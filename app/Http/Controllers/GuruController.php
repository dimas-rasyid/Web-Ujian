<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sesi;

class GuruController extends Controller
{
    // Menampilkan Dashboard Guru & Daftar Sesi Ujian
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Ambil session role dan id_guru yang sedang login
        $role = session('role') ?? 'admin';
        $guruId = session('id_guru') ?? null;

        $query = Sesi::with(['guru', 'kelas', 'soal']);

        // Jika bukan admin, filter berdasarkan guru_id yang login
        if ($role !== 'admin' && $guruId) {
            $query->where('guru_id', $guruId);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('sesi', 'like', "%{$search}%");
            });
        }

        $listSesi = $query->orderBy('id_sesi', 'asc')->paginate(10)->withQueryString();

        // Kirim $listSesi ke view dashboard.blade.php
        return view('guru.dashboard', compact('listSesi', 'search'));
    }

}