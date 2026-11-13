<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Guru;

class JurusanKelasController extends Controller
{
    // Menampilkan halaman utama CRUD Jurusan & Kelas
    public function index()
    {
        $listJurusan = Jurusan::with('kelas')->get();
        // Memuat relasi 'kelas' dan sub-relasi 'waliKelas' (yang merujuk ke model Guru)
        $listJurusan = Jurusan::with(['kelas.waliKelas'])->get();
        
        // Jika Anda juga memerlukan daftar guru untuk pilihan wali kelas nantinya saat form tambah/edit:
        $listGuru = \App\Models\Guru::all(); 

        return view('guru.jurusan-kelas', compact('listJurusan', 'listGuru'));
    }

    // Menyimpan Jurusan Baru
    public function storeJurusan(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusan,nama_jurusan'
        ]);

        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan
        ]);

        return back()->with('success', 'Jurusan berhasil ditambahkan!');
    }

    // Menyimpan Kelas Baru
    public function storeKelas(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'tingkat'    => 'required|in:X,XI,XII',
            'nama_kelas' => 'required|string|max:255',
            // Jika wali kelas wajib dipilih, ganti 'nullable' jadi 'required'. 
            // Jika opsional, hapus atribut 'required' di form HTML. Kita buat 'nullable' di sini:
            'guru_id'    => 'nullable|exists:guru,id_guru', 
        ]);

        Kelas::create([
            'jurusan_id' => $request->jurusan_id,
            'tingkat'    => $request->tingkat,
            'kelas'      => $request->nama_kelas,
            'guru_id'    => $request->guru_id,
        ]);

        return back()->with('success', 'Kelas berhasil ditambahkan!');
    }

    // Hapus Jurusan beserta Kelas di dalamnya
    public function destroyJurusan($id)
    {
        // Hapus semua kelas yang berelasi dengan jurusan ini terlebih dahulu
        \App\Models\Kelas::where('jurusan_id', $id)->delete();

        // Setelah itu hapus jurusannya
        Jurusan::where('id_jurusan', $id)->delete();
        
        return back()->with('success', 'Jurusan beserta kelas di dalamnya berhasil dihapus!');
    }

    // Hapus Kelas
    public function destroyKelas($id)
    {
        Kelas::where('id_kelas', $id)->delete();
        return back()->with('success', 'Kelas berhasil dihapus!');
    }
}