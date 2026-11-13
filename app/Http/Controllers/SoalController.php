<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Control;
use App\Models\Sesi;
use App\Models\Soal;
use App\Models\OpsiSoal;
use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;

class SoalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil data control dengan relasi sesi, mapel, dan kelas (beserta jurusan)
        $query = Control::with(['sesi', 'mapel', 'kelas.jurusan'])
            ->when($search, function($q, $search) {
                $q->whereHas('sesi', function($sub) use ($search) {
                    $sub->where('judul', 'like', "%{$search}%");
                })->orWhereHas('mapel', function($sub) use ($search) {
                    $sub->where('mapel', 'like', "%{$search}%");
                });
            });

        $controls = $query->get();

        // Hapus duplikat berdasarkan kombinasi: judul sesi, id_mapel, dan tingkat kelas
        $listControl = $controls->unique(function ($item) {
            $judul = optional($item->sesi)->judul;
            $mapelId = $item->mapel_id;
            $tingkat = optional($item->kelas)->tingkat; // Mengelompokkan berdasarkan tingkat kelas (X, XI, XII)
            
            return $judul . '-' . $mapelId . '-' . $tingkat;
        });

        return view('guru.managesoal', compact('listControl', 'search'));
    }

    // Menampilkan halaman tambah/kelola soal berdasarkan id_sesi (atau control)
    public function detail($id_sesi)
    {
        $sesi = Sesi::findOrFail($id_sesi);
        
        // Ambil control terkait sesi ini untuk mendapatkan relasi mapel/kelas jika diperlukan
        $control = Control::where('sesi_id', $id_sesi)->first();

        // Ambil daftar soal yang sudah diinput pada sesi ini melalui tabel control
        $listSoal = collect();
        if ($control) {
            $listSoal = Soal::with('opsiSoal')->where('control_id', $control->id_control)->get();
        }

        // Data bank sesi untuk fitur "Ambil dari Bank Soal"
        $listBankSesi = Sesi::where('id_sesi', '!=', $id_sesi)->orderBy('created_at', 'desc')->get();

        return view('guru.tambah-soal', compact('sesi', 'control', 'listSoal', 'listBankSesi'));
    }

    // Menyimpan Soal Baru (Pilihan Ganda atau Essay)
    public function store(Request $request, $id_sesi)
    {
        $request->validate([
            'tipe'       => 'required|in:Pilihan Ganda,Essay',
            'pertanyaan' => 'required|string',
        ]);

        // Cari data control berdasarkan sesi_id
        $control = Control::where('sesi_id', $id_sesi)->firstOrFail();

        // 1. Simpan ke tabel soal
        $soal = Soal::create([
            'control_id' => $control->id_control,
            'tipe'       => $request->tipe,
            'pertanyaan' => $request->pertanyaan,
        ]);

        // 2. Jika Pilihan Ganda, simpan opsi pilihan ke tabel opsi_soal
        if ($request->tipe === 'Pilihan Ganda' && $request->has('opsi')) {
            $kunciJawaban = $request->input('kunci_jawaban'); // Contoh: 'A', 'B', dll.

            foreach ($request->input('opsi') as $huruf => $teksOpsi) {
                if (!empty($teksOpsi)) {
                    OpsiSoal::create([
                        'soal_id'    => $soal->id_soal,
                        'kode_opsi'  => $huruf,
                        'text_opsi'  => $teksOpsi, // Sesuaikan dengan ERD (text_opsi)
                        'is_correct' => ($kunciJawaban === $huruf) ? 1 : 0,
                    ]);
                }
            }
        }

        return redirect()->route('guru.soal.detail', $id_sesi)->with('success', 'Soal berhasil ditambahkan!');
    }

    // Method untuk menangani import file excel soal
    public function import(Request $request, $id_sesi)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:5120',
        ]);

        try {
            Excel::import(new SoalImport($id_sesi), $request->file('file_excel'));

            return redirect()->route('guru.soal.detail', $id_sesi)->with('success', 'Soal berhasil di-import dari Excel!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengimport file: ' . $e->getMessage()]);
        }
    }

    // Menghapus satuan soal
    public function destroy($id_soal)
    {
        $soal = Soal::findOrFail($id_soal);
        $control = Control::where('id_control', $soal->control_id)->first();
        $sesiId = $control ? $control->sesi_id : null;

        $soal->delete();

        return back()->with('success', 'Soal berhasil dihapus!');
    }

    public function destroyAll($id)
    {
        // Sesuaikan logika penghapusan berdasarkan struktur (misalnya berdasarkan control_id atau sesi_id)
        $soals = Soal::where('control_id', $id)->get(); // atau berdasarkan sesi

        foreach ($soals as $soal) {
            $soal->opsiSoal()->delete();
            $soal->delete();
        }

        return back()->with('success', 'Semua soal berhasil dihapus!');
    }
}