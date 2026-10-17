<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // GURU
    // Form Login Guru
    public function showLoginGuru()
    {
        return view('auth.login-guru');
    }

    // Proses Login Guru
    public function loginGuru(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'password' => 'required'
        ]);

        $guru = Guru::where('nama', $request->nama)->first();

        if ($guru && Hash::check($request->password, $guru->password)) {
            session([
                'id_guru' => $guru->id_guru,
                'nama' => $guru->nama,
                'role' => $guru->role
            ]);
            return redirect()->route('guru.dashboard');
        }

        return back()->withErrors(['msg' => 'Nama atau Password salah!']);
    }

    //Logout Khusu Guru
    public function logoutGuru(Request $request)
    {
        $request->session()->forget(['id_guru', 'nama', 'role']);
        return redirect()->route('login.guru');
    }


    // SISWA
    // Form Login Siswa (Ringan dengan NISN)
    public function showLoginSiswa()
    {
        return view('auth.login-siswa');
    }

    // Proses Login Siswa
    public function loginSiswa(Request $request)
    {
        $request->validate([
            'nisn' => 'required',
            'password' => 'required'
        ]);

        $siswa = Siswa::where('nisn', $request->nisn)->first();

        if ($siswa && Hash::check($request->password, $siswa->password)) {
            session([
                'id_siswa' => $siswa->id_siswa,
                'nama' => $siswa->nama, // Disesuaikan dengan ERD (sebelumnya 'name')
                'kelas_id' => $siswa->kelas_id
            ]);
            return redirect()->route('siswa.dashboard');
        }

        return back()->withErrors(['msg' => 'NISN atau Password salah!']);
    }

    // Logout Universal
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

    
}