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

        $listSesi = Sesi::whereHas('kelas', function ($query) use ($siswa) {
                $query->where('sesi_kelas.kelas_id', $siswa->kelas_id);
            })
            ->whereDate('tgl_sesi', '>=', today())   // sembunyikan sesi hari-hari lalu
            ->orderBy('tgl_sesi')
            ->orderBy('waktu_mulai')
            ->get();

        // [id_sesi => status] milik siswa ini, untuk menentukan tombol di tampilan
        $statusNilai = Nilai::where('siswa_id', $siswa->id_siswa)->pluck('status', 'sesi_id');

        return view('siswa.dashboard', compact('siswa', 'listSesi', 'statusNilai'));
    }
}