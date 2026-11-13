<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Sesi;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // DASHBOARD SISWA
    public function dashboard()
    {
        $siswa = Siswa::with('kelas')->find(session('id_siswa'));

        // Session masih ada tapi data siswa sudah dihapus
        if (!$siswa) {
            session()->flush();
            return redirect()->route('login.siswa')
                ->withErrors(['msg' => 'Sesi login tidak valid, silakan login ulang.']);
        }

        // 1. Ambil $listSesi terlebih dahulu
        $listSesi = Sesi::whereHas('control', function ($query) use ($siswa) {
                $query->where('kelas_id', $siswa->kelas_id);
            })
            ->whereDate('waktu_mulai', '>=', today())
            ->orderBy('waktu_mulai')
            ->get();

        // 2. Baru ambil $statusNilai setelah $listSesi tersedia
        $statusNilai = Nilai::where('siswa_id', $siswa->id_siswa)
            ->whereHas('control', function($q) use ($listSesi) {
                $q->whereIn('sesi_id', $listSesi->pluck('id_sesi'));
            })
            ->with('control')
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->control->sesi_id => $item->status];
            });

        return view('siswa.dashboard', compact('siswa', 'listSesi', 'statusNilai'));
    }
}