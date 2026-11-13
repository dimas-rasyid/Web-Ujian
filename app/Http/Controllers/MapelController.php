<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\MapelGuru;
use App\Imports\MapelImport;
use Maatwebsite\Excel\Facades\Excel;

class MapelController extends Controller
{
    // Menampilkan halaman manajemen pengampu mapel beserta pilihan dan daftarnya
    public function index()
    {
        $listMapel     = Mapel::orderBy('mapel', 'asc')->get();
        $listGuru      = Guru::orderBy('nama', 'asc')->get();
        $listMapelGuru = MapelGuru::with(['mapel', 'guru'])->orderBy('created_at', 'desc')->get();

        return view('guru.managemapel', compact('listMapel', 'listGuru', 'listMapelGuru'));
    }

    // Menyimpan penugasan guru pengampu mapel baru (bisa banyak guru untuk satu mapel)
    public function store(Request $request)
    {
        $request->validate([
            'mapel'   => 'required|string|max:255',
            'id_guru' => 'required|exists:guru,id_guru',
            'tingkat' => 'required|in:X,XI,XII'
        ]);

        // 1. Cek atau buat master mapel secara otomatis jika diketik baru
        $mapelRecord = Mapel::firstOrCreate([
            'mapel' => trim($request->mapel)
        ]);

        // 2. Buat data penugasan ke tabel mapel_guru menggunakan id_mapel yang didapat/dibuat
        MapelGuru::create([
            'id_mapel' => $mapelRecord->id_mapel,
            'id_guru'  => $request->id_guru,
            'tingkat'  => $request->tingkat,
        ]);

        return back()->with('success', 'Mata pelajaran dan penugasan guru berhasil disimpan!');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new MapelImport, $request->file('file_excel'));
            return back()->with('success', 'Data mata pelajaran dan penugasan guru berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }

    // Menghapus penugasan guru pengampu mapel
    public function destroy($id)
    {
        $mapelGuru = MapelGuru::findOrFail($id);
        $mapelGuru->delete();

        return back()->with('success', 'Penugasan guru berhasil dihapus!');
    }
}