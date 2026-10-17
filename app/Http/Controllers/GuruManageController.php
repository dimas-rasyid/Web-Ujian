<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\GuruImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\Models\Guru;
use App\Models\Jurusan;

class GuruManageController extends Controller
{
    // Menampilkan daftar guru dan form tambah dengan pencarian & pagination
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query pencarian berdasarkan nama guru atau nama jurusan terkait
        $listGuru = Guru::with('jurusan')
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhereHas('jurusan', function ($q) use ($search) {
                                 $q->where('nama_jurusan', 'like', "%{$search}%");
                             });
            })
            ->paginate(10)
            ->withQueryString(); // Memastikan parameter pencarian tetap ada saat berpindah halaman pagination

        $listJurusan = Jurusan::all();
        
        return view('guru.manageguru', compact('listGuru', 'listJurusan', 'search'));
    }

    // Menyimpan Guru / Admin Baru
    public function store(Request $request)
    {
        $request->validate([
            'jurusan_id' => 'required|exists:jurusan,id_jurusan',
            'nama' => 'required|string|max:255',
            'role' => 'required|in:admin,pengajar',
            'password' => 'required|min:6'
        ]);

        Guru::create([
            'jurusan_id' => $request->jurusan_id,
            'nama' => $request->nama,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Akun guru/admin berhasil ditambahkan!');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new GuruImport, $request->file('file_excel'));
            return back()->with('success', 'Data guru berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }

    // Menghapus Guru / Admin
    public function destroy($id)
    {
        // Mencegah admin menghapus akunnya sendiri yang sedang aktif login
        if (session('id_guru') == $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan untuk login saat ini!');
        }

        Guru::where('id_guru', $id)->delete();
        return back()->with('success', 'Akun guru berhasil dihapus!');
    }
}