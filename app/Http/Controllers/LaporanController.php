<?php

namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\NilaiExport;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Memastikan sesi ujian memang milik guru yang login.
     */
    private function cekAksesSesi($id_sesi)
    {
        $sesi = Sesi::findOrFail($id_sesi);

        // Admin boleh melihat semua sesi.
        if (session('role') === 'admin') {
            return $sesi;
        }

        // Guru hanya boleh melihat sesi miliknya.
        abort_unless(
            session('id_guru') &&
            (int) $sesi->guru_id === (int) session('id_guru'),
            403,
            'Anda tidak memiliki akses ke laporan sesi ini.'
        );

        return $sesi;
    }

  /**
     * Check Nilai Sudah DI koreksi semua atau belum.
     */
    
    private function cekKelengkapanNilai($listNilai)
    {
        if ($listNilai->isEmpty()) {
            return back()->with(
                'error',
                'Export ditolak! Belum ada data nilai.'
            );
        }

        $belumSelesai = $listNilai->contains(function ($nilai) {
         return strtolower(trim($nilai->status ?? '')) !== 'selesai';
        });

        if ($belumSelesai) {
         return back()->with(
             'error',
             'Export Belum Bisa di Lakukan! Masih ada nilai yang belum selesai dikoreksi.'
         );
        }

        return null;
    }


    /**
     * Mengambil nilai berdasarkan sesi dan filter kelas.
     */
    private function ambilNilai($id_sesi, $kelasId = null)
    {
        $query = Nilai::with(['siswa.kelas'])
            ->where('sesi_id', $id_sesi);

        if ($kelasId) {
            $query->whereHas('siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        return $query->get();
    }

    /**
     * Export laporan nilai ke PDF.
     */
    public function exportPdf(Request $request, $id_sesi)
    {
     $sesi = $this->cekAksesSesi($id_sesi);
     $kelasId = $request->input('kelas_id');
        $listNilai = $this->ambilNilai($id_sesi, $kelasId);

        $validasi = $this->cekKelengkapanNilai($listNilai);

        if ($validasi) {
            return $validasi;
        }

        $pdf = Pdf::loadView('sesi.export-pdf', [
         'sesi' => $sesi,
         'listNilai' => $listNilai,
        ])->setPaper('a4', 'landscape');

     return $pdf->download(
            'laporan-nilai-' . $sesi->id_sesi . '.pdf'
        );
    }

    /**
     * Export laporan nilai ke Excel.
     */
    public function exportExcel(Request $request, $id_sesi)
    {
        $this->cekAksesSesi($id_sesi);

        $kelasId = $request->input('kelas_id');
    $listNilai = $this->ambilNilai($id_sesi, $kelasId);

    $validasi = $this->cekKelengkapanNilai($listNilai);

        if ($validasi) {
            return $validasi;
        }

        return Excel::download(
         new NilaiExport($id_sesi, $kelasId),
         'laporan-nilai-' . $id_sesi . '.xlsx'
        );
    }
}
