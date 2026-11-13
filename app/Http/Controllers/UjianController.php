<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Sesi;
use App\Models\Soal;
use App\Models\Nilai;
use App\Models\Jawaban;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UjianController extends Controller
{
    // Toleransi keterlambatan (detik) untuk autosave setelah batas waktu
    private const TOLERANSI_DETIK = 60;

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
            $tokenSesi  = strtoupper(trim((string) $sesi->token));

            if ($tokenInput === '' || $tokenSesi === '' || !hash_equals($tokenSesi, $tokenInput)) {
                Log::warning('Token ujian salah', [
                    'siswa_id' => $siswa->id_siswa,
                    'sesi_id'  => $sesi->id_sesi,
                    'ip'       => $request->ip(),
                ]);

                return back()->withErrors(['token' => 'Token ujian salah! Silakan minta token ke pengawas.']);
            }

            // Catat waktu mulai. Ini sekaligus "kunci" bahwa siswa sudah lolos token.
            // Pastikan ada unique (siswa_id, sesi_id) di tabel nilai.
            Nilai::firstOrCreate(
                ['siswa_id' => $siswa->id_siswa, 'sesi_id' => $sesi->id_sesi],
                ['status' => 'mengerjakan', 'started_at' => now(), 'skor' => 0]
            );

            Log::info('Siswa memulai ujian', [
                'siswa_id' => $siswa->id_siswa,
                'sesi_id'  => $sesi->id_sesi,
                'ip'       => $request->ip(),
                'ua'       => substr((string) $request->userAgent(), 0, 200),
            ]);
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
            $pesan = ($nilai && in_array($nilai->status, ['selesai', 'menunggu_koreksi']))
                ? 'Anda sudah menyelesaikan ujian ini.'
                : 'Masukkan token terlebih dahulu untuk memulai ujian.';

            return redirect()->route('siswa.dashboard')->withErrors(['token' => $pesan]);
        }

        // Hitung sisa durasi / batas waktu
        $deadline  = $this->deadline($sesi, $nilai);
        $sisaDetik = (int) max(0, now()->diffInSeconds($deadline, false));

        if ($sisaDetik === 0) {
            // Waktu habis: nilai dari jawaban yang sudah tersimpan (autosave), jangan dibiarkan skor 0
            $this->selesaikan($siswa, $sesi, [], 'Waktu habis');

            return redirect()->route('siswa.dashboard')
                ->withErrors(['token' => 'Waktu ujian Anda sudah habis. Jawaban tersimpan sudah dinilai.']);
        }

        // 2. Terapkan Caching (Simpan ke RAM server selama 1 jam / 3600 detik)
        // Kunci jawaban (is_correct) sengaja TIDAK ikut diambil agar tidak sampai ke browser.
        // Ingat: hapus cache ini (Cache::forget) saat guru mengubah soal di sesi ini.
        $cacheKey = "sesi_{$sesi->id_sesi}_soal";

        $listSoal = Cache::remember($cacheKey, 3600, function () use ($sesi) {
            return Soal::with(['opsi' => function ($query) {
                $query->select('id_opsi', 'soal_id', 'kode_opsi', 'teks_opsi');
            }])->where('sesi_id', $sesi->id_sesi)->orderBy('id_soal', 'asc')->get();
        });

        // Jawaban yang sudah tersimpan di server (pemulihan setelah refresh / ganti perangkat)
        $jawabanSiswa = Jawaban::where('siswa_id', $siswa->id_siswa)
            ->whereIn('soal_id', $listSoal->pluck('id_soal'))
            ->pluck('jawaban', 'soal_id');

        // Jumlah pelanggaran yang sudah tercatat di server (agar hitungan tidak bisa direset dengan menghapus data browser)
        $jumlahPelanggaran = (int) Cache::get("pelanggaran_{$sesi->id_sesi}_{$siswa->id_siswa}", 0);

        return view('siswa.ujian', compact('sesi', 'nilai', 'sisaDetik', 'listSoal', 'jawabanSiswa', 'jumlahPelanggaran'));
    }

    public function autosave(Request $request, $id_sesi)
    {
        $request->validate([
            'jawaban' => 'required|array|max:500',
        ]);

        $siswa = Siswa::findOrFail(session('id_siswa'));
        $sesi  = $this->sesiMilikSiswa($siswa, $id_sesi);

        $nilai = Nilai::where('siswa_id', $siswa->id_siswa)
            ->where('sesi_id', $sesi->id_sesi)
            ->first();

        // Hanya boleh menyimpan saat ujian masih berjalan
        if (!$nilai || $nilai->status !== 'mengerjakan') {
            return response()->json(['status' => 'closed'], 409);
        }

        // Tolak jika sudah lewat batas waktu (+ toleransi)
        if (now()->gt($this->deadline($sesi, $nilai)->copy()->addSeconds(self::TOLERANSI_DETIK))) {
            return response()->json(['status' => 'expired'], 409);
        }

        // Hanya terima id soal yang memang milik sesi ini
        $soalValid = Soal::where('sesi_id', $sesi->id_sesi)
            ->pluck('id_soal')
            ->map(fn ($id) => (string) $id)
            ->all();

        foreach ($request->input('jawaban') as $soalId => $jawaban) {
            if (!in_array((string) $soalId, $soalValid, true) || !is_string($jawaban)) {
                continue;
            }

            Jawaban::updateOrCreate(
                ['siswa_id' => $siswa->id_siswa, 'soal_id' => $soalId],
                ['jawaban' => mb_substr($jawaban, 0, 10000)]
            );
        }

        return response()->json(['status' => 'success']);
    }

    // ---------- Pencatatan pelanggaran (disimpan ke log saja) ----------
    // Dihitung sebagai pelanggaran (menaikkan nomor urut)
    private const JENIS_PELANGGARAN = ['tab_disembunyikan', 'fokus_hilang', 'layar_penuh_keluar'];

    // Hanya keterangan pendukung agar pengawas bisa membaca urutan kejadian
    private const JENIS_INFO = ['halaman_dimuat', 'halaman_ditinggalkan', 'tab_kembali', 'fokus_kembali'];

    public function pelanggaran(Request $request, $id_sesi)
    {
        $jenis         = (string) $request->input('jenis');
        $isPelanggaran = in_array($jenis, self::JENIS_PELANGGARAN, true);

        if (!$isPelanggaran && !in_array($jenis, self::JENIS_INFO, true)) {
            return response()->noContent(422);
        }

        $siswa = Siswa::findOrFail(session('id_siswa'));
        $sesi  = $this->sesiMilikSiswa($siswa, $id_sesi);

        $nilai = Nilai::where('siswa_id', $siswa->id_siswa)
            ->where('sesi_id', $sesi->id_sesi)
            ->first();

        // Abaikan laporan jika ujian tidak sedang berjalan
        if (!$nilai || $nilai->status !== 'mengerjakan') {
            return response()->noContent();
        }

        $lamaDetik = (int) round(max(0, min((int) $request->input('lama_ms', 0), 86400000)) / 1000);

        // Nomor urut pelanggaran per siswa per sesi
        $kunci = "pelanggaran_{$sesi->id_sesi}_{$siswa->id_siswa}";
        Cache::add($kunci, 0, now()->addHours(12));
        $urutan = $isPelanggaran ? Cache::increment($kunci) : (int) Cache::get($kunci, 0);

        // Cegah log membengkak jika ada yang sengaja membanjiri laporan
        if ($urutan > 200) {
            return response()->noContent();
        }

        $konteks = [
            'siswa_id'      => $siswa->id_siswa,
            'nama'          => session('nama'),
            'sesi_id'       => $sesi->id_sesi,
            'jenis'         => $jenis,
            'lama_detik'    => $lamaDetik,
            'pelanggaran_ke' => $urutan,
            'ip'            => $request->ip(),
        ];

        if ($isPelanggaran) {
            Log::warning('UJIAN PELANGGARAN', $konteks);
        } else {
            Log::info('UJIAN AKTIVITAS', $konteks);
        }

        return response()->noContent();
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

    // Batas akhir pengerjaan: yang lebih awal antara (mulai + durasi) dan jam selesai sesi
    private function deadline(Sesi $sesi, Nilai $nilai): Carbon
    {
        [, $selesai] = $this->jendelaSesi($sesi);
        $batasDurasi = Carbon::parse($nilai->started_at)->addMinutes((int) $sesi->durasi);

        return $batasDurasi->lt($selesai) ? $batasDurasi : $selesai;
    }

    public function selesai(Request $request, $id_sesi)
    {
        $request->validate([
            'jawaban' => 'nullable|array',
            'alasan'  => 'nullable|string|max:100',
        ]);

        $siswa = Siswa::findOrFail(session('id_siswa'));
        $sesi  = $this->sesiMilikSiswa($siswa, $id_sesi);

        // Format: [id_soal => pilihan/teks]
        $diproses = $this->selesaikan(
            $siswa,
            $sesi,
            (array) $request->input('jawaban', []),
            $request->input('alasan')
        );

        // Sudah selesai sebelumnya (mis. dua permintaan bertabrakan): cukup kembali ke dashboard
        if (!$diproses) {
            return redirect()->route('siswa.dashboard');
        }

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Ujian berhasil dikirim dan diselesaikan.');
    }

    /**
     * Menyelesaikan & menilai ujian secara atomik.
     * Aman dipanggil berkali-kali / bersamaan: hanya panggilan pertama yang memproses.
     */
    private function selesaikan(Siswa $siswa, Sesi $sesi, array $jawabanInput, ?string $alasan = null): bool
    {
        $diproses = DB::transaction(function () use ($siswa, $sesi, $jawabanInput) {
            // Kunci baris nilai agar tidak ada penilaian ganda
            $nilai = Nilai::where('siswa_id', $siswa->id_siswa)
                ->where('sesi_id', $sesi->id_sesi)
                ->lockForUpdate()
                ->first();

            if (!$nilai || $nilai->status !== 'mengerjakan') {
                return false;
            }

            // Ambil semua soal untuk sesi ini beserta opsi dan kunci jawabannya
            $listSoal = Soal::with('opsi')->where('sesi_id', $sesi->id_sesi)->get();

            // Jawaban yang sudah tersimpan lewat autosave
            $tersimpan = Jawaban::where('siswa_id', $siswa->id_siswa)
                ->whereIn('soal_id', $listSoal->pluck('id_soal'))
                ->pluck('jawaban', 'soal_id');

            $jumlahSoal       = $listSoal->count();
            $poinPerSoal      = $jumlahSoal > 0 ? (100 / $jumlahSoal) : 0;
            $skorPilihanGanda = 0;
            $adaEssay         = false;

            foreach ($listSoal as $soal) {
                $input = $jawabanInput[$soal->id_soal] ?? null;

                // Pakai kiriman terakhir jika ada isinya; jika kosong pakai hasil autosave
                $jawabanSiswa = (is_string($input) && trim($input) !== '')
                    ? mb_substr($input, 0, 10000)
                    : ($tersimpan[$soal->id_soal] ?? null);

                if ($soal->tipe === 'Pilihan Ganda') {
                    // Cari opsi benar (is_correct == 1), bandingkan dengan pilihan siswa
                    $opsiBenar = $soal->opsi->firstWhere('is_correct', 1);
                    if ($opsiBenar && $jawabanSiswa === $opsiBenar->kode_opsi) {
                        $skorPilihanGanda += $poinPerSoal;
                    }
                } else {
                    $adaEssay = true;
                }

                Jawaban::updateOrCreate(
                    ['siswa_id' => $siswa->id_siswa, 'soal_id' => $soal->id_soal],
                    ['jawaban' => $jawabanSiswa]
                );
            }

            $nilai->update([
                'status'      => $adaEssay ? 'menunggu_koreksi' : 'selesai',
                'skor'        => round($skorPilihanGanda, 2),
                'finished_at' => now(),
            ]);

            return true;
        });

        // Jejak audit di storage/logs (tanpa perlu kolom baru di database)
        if ($diproses) {
            Log::info('Ujian diselesaikan', [
                'siswa_id' => $siswa->id_siswa,
                'sesi_id'  => $sesi->id_sesi,
                'alasan'   => $alasan ?: 'Dikirim manual',
                'ip'       => request()->ip(),
            ]);
        }

        return $diproses;
    }
}