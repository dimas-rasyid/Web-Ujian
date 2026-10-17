<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesi;
use App\Models\Soal;
use App\Models\OpsiSoal;
use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;

class SoalController extends Controller
{
    // Menampilkan halaman tambah soal untuk sesi tertentu
    public function create(Request $request,$id_sesi)
    {
        $sesi = Sesi::findOrFail($id_sesi);
        
        // Ambil daftar soal yang sudah diinput pada sesi ini beserta opsi jawabannya
        $listSoal = Soal::with('opsi')->where('sesi_id',$id_sesi)->orderBy('id_soal', 'asc')->get();

        return view('sesi.tambah-soal', compact('sesi', 'listSoal'));
    }

    // Menyimpan Soal (Pilihan Ganda atau Essay) ke Database
    public function store(Request $request, $id_sesi) { // 1. Validasi input yang fleksibel untuk Pilihan Ganda dan Essay
        $request->validate([
            'tipe'          => 'required|in:Pilihan Ganda,Essay',
            'pertanyaan'    => 'required|string',
            'kunci_jawaban' => 'nullable|string|in:A,B,C,D,E', 
            'opsi'          => 'nullable|array',
            'opsi.*'        => 'nullable|string',
        ]);

        // 2. Simpan data soal ke tabel `soal`
        $soal = Soal::create([
            'sesi_id'    => $id_sesi,
            'tipe'       => $request->tipe,
            'pertanyaan' => $request->pertanyaan,
        ]);

        // 3. Jika tipe soal adalah Pilihan Ganda, simpan pilihan opsi ke tabel `opsi_soal`
        if ($request->tipe === 'Pilihan Ganda' &&$request->has('opsi')) {
            foreach ($request->opsi as $kodeOpsi =>$teksOpsi) {
                // Pastikan teks opsi tidak kosong sebelum disimpan ke database
                if (!empty(trim($teksOpsi))) {$isCorrect = ($kodeOpsi ===$request->kunci_jawaban) ? 1 : 0;

                    OpsiSoal::create([
                        'soal_id'   => $soal->id_soal,
                        'kode_opsi' => $kodeOpsi,
                        'teks_opsi' => $teksOpsi,
                        'is_correct'=> $isCorrect,
                    ]);
                }
            }
        }

        return redirect()->route('guru.soal.create', $id_sesi)->with('success', 'Soal berhasil ditambahkan!');
    }

    // Import Soal
    public function import(Request $request,$id_sesi)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new SoalImport($id_sesi),$request->file('file_excel'));
            return back()->with('success', 'Soal berhasil diimport!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengimport file. Pastikan format kolom pada file Excel sudah sesuai.']);
        }
    }

    // Menghapus soal satuan beserta opsi terkaitnya
    public function destroy($id_soal)
    {
        $soal = Soal::findOrFail($id_soal);
        $sesiId =$soal->sesi_id;
        
        // Hapus opsi soal terlebih dahulu
        $soal->opsi()->delete();$soal->delete();

        return redirect()->route('guru.soal.create', $sesiId)->with('success', 'Soal berhasil dihapus!');
    }

    // Menghapus semua soal dalam sesi tertentu sekaligus
    public function destroyAll($id_sesi)
    {
        $soals = Soal::where('sesi_id',$id_sesi)->get();

        foreach ($soals as$soal) {
            $soal->opsi()->delete();$soal->delete();
        }

        return redirect()->route('guru.soal.create', $id_sesi)->with('success', 'Semua soal pada sesi ini berhasil dihapus!');
    }
}