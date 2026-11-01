<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesi;
use App\Models\Soal;
use App\Models\OpsiSoal;
use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class SoalController extends Controller
{
    // Menampilkan halaman tambah soal untuk sesi tertentu
    public function create(Request $request, $id_sesi)
    {
        $sesi = Sesi::findOrFail($id_sesi);
        
        // Ambil daftar soal di sesi ini
        $listSoal = Soal::with('opsi')->where('sesi_id', $id_sesi)->orderBy('id_soal', 'asc')->get();

        // Ambil daftar sesi lain untuk Bank Soal (kecuali sesi saat ini)
        $listBankSesi = Sesi::where('id_sesi', '!=', $id_sesi)->orderBy('tgl_sesi', 'desc')->get();

        return view('sesi.tambah-soal', compact('sesi', 'listSoal', 'listBankSesi'));
    }

    public function store(Request $request, $id_sesi)
    {
        $request->validate([
            'tipe'          => 'required|in:Pilihan Ganda,Essay',
            'pertanyaan'    => 'required|string',
            'kunci_jawaban' => 'nullable|string|in:A,B,C,D,E', 
            'opsi'          => 'nullable|array',
            'opsi.*'        => 'nullable|string',
        ]);

        $soal = Soal::create([
            'sesi_id'    => $id_sesi,
            'tipe'       => $request->tipe,
            'pertanyaan' => $request->pertanyaan,
        ]);

        if ($request->tipe === 'Pilihan Ganda' && $request->has('opsi')) {
            foreach ($request->opsi as $kodeOpsi => $teksOpsi) {
                if (!empty(trim($teksOpsi))) {
                    $isCorrect = ($kodeOpsi === $request->kunci_jawaban) ? 1 : 0;

                    OpsiSoal::create([
                        'soal_id'   => $soal->id_soal,
                        'kode_opsi' => $kodeOpsi,
                        'teks_opsi' => $teksOpsi,
                        'is_correct'=> $isCorrect,
                    ]);
                }
            }
        }

        // HAPUS CACHE SOAL SESI INI
        Cache::forget("sesi_{$id_sesi}_soal");

        return redirect()->route('guru.soal.create', $id_sesi)->with('success', 'Soal berhasil ditambahkan!');
    }

    public function import(Request $request, $id_sesi)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new SoalImport($id_sesi), $request->file('file_excel'));
            
            // HAPUS CACHE SOAL SESI INI
            Cache::forget("sesi_{$id_sesi}_soal");

            return back()->with('success', 'Soal berhasil diimport!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengimport file. Pastikan format kolom pada file Excel sudah sesuai.']);
        }
    }

    // TAMBAH SOAL DARI BANK SOAL
    public function salinDariBank(Request $request, $id_sesi_tujuan, $id_sesi_sumber)
    {
        // Ambil semua soal dari sesi sumber (bank soal)
        $soalSumber = Soal::with('opsi')->where('sesi_id', $id_sesi_sumber)->get();

        if ($soalSumber->isEmpty()) {
            return back()->withErrors(['error' => 'Sesi sumber tidak memiliki soal untuk disalin.']);
        }

        foreach ($soalSumber as $sumber) {
            // 1. Duplikasi soal ke sesi tujuan
            $soalBaru = Soal::create([
                'sesi_id'    => $id_sesi_tujuan,
                'tipe'       => $sumber->tipe,
                'pertanyaan' => $sumber->pertanyaan,
            ]);

            // 2. Jika ada opsi (Pilihan Ganda), duplikasi juga opsi jawabannya
            if ($sumber->tipe === 'Pilihan Ganda') {
                foreach ($sumber->opsi as $opsiSumber) {
                    OpsiSoal::create([
                        'soal_id'    => $soalBaru->id_soal,
                        'kode_opsi'  => $opsiSumber->kode_opsi,
                        'teks_opsi'  => $opsiSumber->teks_opsi,
                        'is_correct' => $opsiSumber->is_correct,
                    ]);
                }
            }
        }

        // Hapus cache soal untuk sesi tujuan
        Cache::forget("sesi_{$id_sesi_tujuan}_soal");

        return redirect()->route('guru.soal.create', $id_sesi_tujuan)
            ->with('success', 'Soal dari bank sesi berhasil disalin ke sesi ini!');
    }

    public function destroy($id_soal)
    {
        $soal = Soal::findOrFail($id_soal);
        $sesiId = $soal->sesi_id;
        
        $soal->opsi()->delete();
        $soal->delete();

        // HAPUS CACHE SOAL SESI INI
        Cache::forget("sesi_{$sesiId}_soal");

        return redirect()->route('guru.soal.create', $sesiId)->with('success', 'Soal berhasil dihapus!');
    }

    public function destroyAll($id_sesi)
    {
        $soals = Soal::where('sesi_id', $id_sesi)->get();

        foreach ($soals as $soal) {
            $soal->opsi()->delete();
            $soal->delete();
        }

        // HAPUS CACHE SOAL SESI INI
        Cache::forget("sesi_{$id_sesi}_soal");

        return redirect()->route('guru.soal.create', $id_sesi)->with('success', 'Semua soal pada sesi ini berhasil dihapus!');
    }
}