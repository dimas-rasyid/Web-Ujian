<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaManageController extends Controller
{
    // Menampilkan daftar siswa, pencarian, & pagination
    // Menampilkan daftar siswa, pencarian, & pagination
    public function index(Request $request)
    {
        $search = $request->input('search');
        $kelasFilter = $request->input('kelas_filter');

        $listSiswa = Siswa::with('kelas.jurusan')
            ->when($search, function ($query, $search) {
                // Sesuaikan 'nama' menjadi 'name'
                return $query->where('name', 'like', "%{$search}%")
                           ->orWhere('nisn', 'like', "%{$search}%")
                           ->orWhereHas('kelas', function ($q) use ($search) {
                               // Sesuaikan 'nama_kelas' menjadi 'kelas'
                               $q->where('kelas', 'like', "%{$search}%");
                           });
            })
            ->when($kelasFilter, function ($query, $kelasFilter) {
                return $query->where('kelas_id', $kelasFilter);
            })
            ->simplePaginate(30)
            ->withQueryString();

        $listKelas = Kelas::with('jurusan')->get();

        return view('guru.managesiswa', compact('listSiswa', 'listKelas', 'search', 'kelasFilter'));
    }

    // Menyimpan Siswa Baru Secara Manual
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas_input' => 'required|exists:kelas,kelas',
            'nisn'             => 'required|string|unique:siswa,nisn',
            'name'             => 'required|string|max:255',
            'password'         => 'required|min:6'
        ]);

        $kelas = Kelas::where('kelas', $request->nama_kelas_input)->first();

        Siswa::create([
            'kelas_id' => $kelas->id_kelas,
            'nisn'     => $request->nisn,
            'name'     => $request->name, // Sesuaikan dengan input dan kolom database
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Data siswa berhasil ditambahkan!');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file_excel'));
            return back()->with('success', 'Data siswa berhasil diimpor secara massal!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }

    // Menghapus Siswa
    public function destroy($id)
    {
        Siswa::where('id_siswa', $id)->delete();
        return back()->with('success', 'Data siswa berhasil dihapus!');
    }
}