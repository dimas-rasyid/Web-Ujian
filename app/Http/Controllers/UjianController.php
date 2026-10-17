<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Sesi;
use App\Models\Siswa;
use App\Models\Soal;
use App\Models\OpsiSoal;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UjianController extends Controller
{
    //koreksi token ulang
    public function validasiToken(Request $request, $id_sesi)
    {
        // Token boleh kosong: siswa yang sudah pernah masuk cukup menekan "Lanjutkan ujian"
        $request->validate([
            'token' => 'nullable|string|max:10',
        ]);

        $siswa = Siswa::findOrFail(session('id_siswa'));

        // 1. Sesi harus ditujukan untuk kelas siswa ini (selain itu 404)
        $sesi = $this->sesiMilikSiswa($siswa, $id_sesi);

        // 2. Cek jadwal
        [$mulai, $selesai] = $this->jendelaSesi($sesi);

        if (now()->lt($mulai)) {
            return back()->withErrors(['token' => 'Ujian belum dimulai! Harap tunggu sampai jadwal ujian dibuka.']);
        }

        if (now()->gt($selesai)) {
            return back()->withErrors(['token' => 'Waktu ujian telah berakhir!']);
        }

        // 3. Sudah pernah masuk atau sudah selesai?
        $nilai = Nilai::where('siswa_id', $siswa->id_siswa)
            ->where('sesi_id', $sesi->id_sesi)
            ->first();

        if ($nilai && in_array($nilai->status, ['selesai', 'menunggu_koreksi'])) {
            return back()->withErrors(['token' => 'Anda sudah menyelesaikan ujian ini.']);
        }

        // 4. Token hanya diminta saat masuk pertama kali
        if (!$nilai) {
            $tokenInput = strtoupper(trim((string) $request->token));
            $tokenSesi  = strtoupper(trim($sesi->token));

            if ($tokenInput === '' || !hash_equals($tokenSesi, $tokenInput)) {
                return back()->withErrors(['token' => 'Token ujian salah! Silakan minta token ke pengawas.']);
            }

            // Catat waktu mulai. Ini sekaligus "kunci" bahwa siswa sudah lolos token.
            // Pastikan ada unique (siswa_id, sesi_id) di tabel nilai.
            Nilai::firstOrCreate(
                ['siswa_id' => $siswa->id_siswa, 'sesi_id' => $sesi->id_sesi],
                ['status' => 'mengerjakan', 'started_at' => now(), 'skor' => 0]
            );
        }

        return redirect()->route('siswa.sesi.kerjakan', $sesi->id_sesi);
    }

    // HALAMAN UJIAN
    public function kerjakan($id_sesi)
    {
        $siswa = Siswa::findOrFail(session('id_siswa'));
        $sesi  = $this->sesiMilikSiswa($siswa, $id_sesi);

        $nilai = Nilai::where('siswa_id', $siswa->id_siswa)
            ->where('sesi_id', $sesi->id_sesi)
            ->first();

        if (!$nilai || $nilai->status !== 'mengerjakan') {
            return redirect()->route('siswa.dashboard')
                ->withErrors(['token' => 'Masukkan token terlebih dahulu untuk memulai ujian.']);
        }

        // Hitung sisa durasi / batas waktu
        [, $selesai] = $this->jendelaSesi($sesi);
        $batasDurasi = Carbon::parse($nilai->started_at)->addMinutes($sesi->durasi);
        $deadline    = $batasDurasi->lt($selesai) ? $batasDurasi : $selesai;
        $sisaDetik   = (int) max(0, now()->diffInSeconds($deadline, false));

        if ($sisaDetik === 0) {
            $nilai->update(['status' => 'selesai']);
            return redirect()->route('siswa.dashboard')
                ->withErrors(['token' => 'Waktu ujian Anda sudah habis.']);
        }

        // Ambil soal beserta opsi (tanpa is_correct demi keamanan)
        $listSoal = \App\Models\Soal::with(['opsi' => function($query) {
            $query->select('id_opsi', 'soal_id', 'kode_opsi', 'teks_opsi');
        }])->where('sesi_id', $sesi->id_sesi)->get();

        return view('siswa.ujian', compact('sesi', 'nilai', 'sisaDetik', 'listSoal'));
    }

    public function autosave(Request $request, $id_sesi)
    {
        $siswaId = session('id_siswa');
        $jawabanInput = $request->input('jawaban', []);

        foreach ($jawabanInput as $soalId => $jawabanSiswa) {
            \App\Models\Jawaban::updateOrCreate(
                ['siswa_id' => $siswaId, 'soal_id' => $soalId],
                ['jawaban' => $jawabanSiswa]
            );
        }

        return response()->json(['status' => 'success']);
    }

    // ---------- Helper ----------
    private function sesiMilikSiswa(Siswa $siswa, $id_sesi): Sesi
    {
        return Sesi::whereHas('kelas', function ($query) use ($siswa) {
            $query->where('sesi_kelas.kelas_id', $siswa->kelas_id);
        })->findOrFail($id_sesi);
    }

    private function jendelaSesi(Sesi $sesi): array
    {
        $tgl = Carbon::parse($sesi->tgl_sesi)->format('Y-m-d');

        return [
            Carbon::parse($tgl . ' ' . $sesi->waktu_mulai),
            Carbon::parse($tgl . ' ' . $sesi->waktu_selesai),
        ];
    }

    
    public function selesai(Request $request, $id_sesi)
    {
        $siswa = Siswa::findOrFail(session('id_siswa'));
        $sesi  = $this->sesiMilikSiswa($siswa, $id_sesi);

        $nilai = Nilai::where('siswa_id', $siswa->id_siswa)
            ->where('sesi_id', $sesi->id_sesi)
            ->first();

        if (!$nilai || $nilai->status !== 'mengerjakan') {
            return redirect()->route('siswa.dashboard');
        }

        $jawabanInput = $request->input('jawaban', []); // Format: [id_soal => pilihan/teks]
        
        // Ambil semua soal untuk sesi ini beserta opsi dan kunci jawabannya
        $listSoal = \App\Models\Soal::with('opsi')->where('sesi_id', $sesi->id_sesi)->get();
        
        $jumlahSoal = $listSoal->count();
        $poinPerSoal = $jumlahSoal > 0 ? (100 / $jumlahSoal) : 0;
        $skorPilihanGanda = 0;
        $adaEssay = false;

        foreach ($listSoal as $soal) {
            $jawabanSiswa = $jawabanInput[$soal->id_soal] ?? null;

            if ($soal->tipe === 'Pilihan Ganda') {
                // Cari opsi yang dipilih siswa, cek apakah is_correct == 1
                $opsiBenar = $soal->opsi->where('is_correct', 1)->first();
                if ($opsiBenar && $jawabanSiswa === $opsiBenar->kode_opsi) {
                    $skorPilihanGanda += $poinPerSoal;
                }
                
                // Simpan jawaban pilihan ganda ke tabel detail jika ada, atau abaikan jika langsung rekap
            } else {
                $adaEssay = true;
            }

            // Opsional: Simpan jawaban ke tabel jawaban_siswa jika Anda ingin merekamnya per soal
            \App\Models\Jawaban::updateOrCreate(
                ['siswa_id' => $siswa->id_siswa, 'soal_id' => $soal->id_soal],
                ['jawaban' => $jawabanSiswa]
            );
        }

        $statusAkhir = $adaEssay ? 'menunggu_koreksi' : 'selesai';

        $nilai->update([
            'status' => $statusAkhir,
            'skor' => round($skorPilihanGanda, 2),
            'finished_at' => now()
        ]);

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Ujian berhasil dikirim dan diselesaikan.');
    }
}