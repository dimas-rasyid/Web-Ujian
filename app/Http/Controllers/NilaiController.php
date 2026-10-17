<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesi;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Soal;

class NilaiController extends Controller
{
    // Menampilkan daftar nilai siswa per sesi
    public function daftarNilaiSesi(Request $request, $id_sesi)
    {
        $sesi = Sesi::with('kelas')->findOrFail($id_sesi);
        $listKelas = $sesi->kelas; 

        $kelasIdDipilih = $request->input('kelas_id', $listKelas->first()->id_kelas ?? null);

        $query = Nilai::with(['siswa.kelas'])
            ->where('sesi_id', $id_sesi);

        if ($kelasIdDipilih) {
            $query->whereHas('siswa', function($q) use ($kelasIdDipilih) {
                $q->where('kelas_id', $kelasIdDipilih);
            });
        }

        $listNilai = $query->get();

        return view('sesi.nilai', compact('sesi', 'listKelas', 'kelasIdDipilih', 'listNilai'));
    }

    // Halaman koreksi essay siswa
    public function koreksi($id_sesi, $id_siswa)
    {
        $sesi = Sesi::findOrFail($id_sesi);
        $siswa = Siswa::with('kelas')->findOrFail($id_siswa);
        
        $nilai = Nilai::where('sesi_id', $id_sesi)
            ->where('siswa_id', $id_siswa)
            ->firstOrFail();

        // Ambil soal beserta opsi dan jawaban siswa
        $listSoal = Soal::with(['opsi', 'jawaban' => function($q) use ($id_siswa) {
            $q->where('siswa_id', $id_siswa);
        }])->where('sesi_id', $id_sesi)->get();

        return view('sesi.koreksi', compact('sesi', 'siswa', 'nilai', 'listSoal'));
    }

    // Menyimpan hasil koreksi manual guru
    public function simpanKoreksi(Request $request, $id_sesi, $id_siswa)
    {
        $sesi = Sesi::findOrFail($id_sesi);
        $nilai = Nilai::where('sesi_id', $id_sesi)
            ->where('siswa_id', $id_siswa)
            ->firstOrFail();

        // 1. Ambil semua soal pada sesi ini untuk menghitung bobot nilai per soal
        $listSoal = Soal::where('sesi_id', $id_sesi)->get();
        $jumlahSoal = $listSoal->count();
        $poinPerSoal = $jumlahSoal > 0 ? (100 / $jumlahSoal) : 0;

        // 2. Hitung ulang skor pilihan ganda yang sudah disimpan sebelumnya, 
        // atau jika Anda ingin merekap dari awal: 
        // (Di sini kita asumsikan $nilai->skor awal adalah murni dari Pilihan Ganda, 
        // atau kita bisa hitung ulang total keseluruhan agar aman).
        
        // Mari hitung ulang total skor Pilihan Ganda dari tabel Jawaban siswa:
        $skorPilihanGanda = 0;
        foreach ($listSoal as $soal) {
            if ($soal->tipe === 'Pilihan Ganda') {
                $jawabanSiswa = \App\Models\Jawaban::where('siswa_id', $id_siswa)
                    ->where('soal_id', $soal->id_soal)
                    ->first();
                    
                $opsiBenar = \App\Models\OpsiSoal::where('soal_id', $soal->id_soal)
                    ->where('is_correct', 1)
                    ->first();

                if ($jawabanSiswa && $opsiBenar && $jawabanSiswa->jawaban === $opsiBenar->kode_opsi) {
                    $skorPilihanGanda += $poinPerSoal;
                }
            }
        }

        // 3. Hitung tambahan skor dari Essay berdasarkan input radio guru (0, 0.5, atau 1)
        $skorEssayTotal = 0;
        $penilaianEssay = $request->input('nilai_essay', []); // Format: [id_soal => nilai_multiplier]

        foreach ($penilaianEssay as $soalId => $multiplier) {
            // Multiplier bisa berupa 0, 0.5, atau 1
            $skorEssayTotal += ($poinPerSoal * floatval($multiplier));
        }

        // 4. Gabungkan skor akhir
        $skorAkhir = $skorPilihanGanda + $skorEssayTotal;

        // 5. Simpan ke database
        $nilai->update([
            'skor' => round(min(100, $skorAkhir), 2),
            'status' => 'selesai'
        ]);

        return redirect()->route('guru.sesi.nilai', $id_sesi)
            ->with('success', 'Koreksi dan penilaian berhasil disimpan.');
    }
}