<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Data Jurusan
        $jurusanRPL = Jurusan::create(['nama_jurusan' => 'RPL']);
        
        $jurusanRPL = Jurusan::create(['nama_jurusan' => 'TJAT']);

        $jurusanRPL = Jurusan::create(['nama_jurusan' => 'MP']);
        
        $jurusanRPL = Jurusan::create(['nama_jurusan' => 'AKR']);

        

        // 3. Buat Akun Guru (Admin & Pengajar)
        Guru::create([
            'jurusan_id' => $jurusanRPL->id_jurusan,
            'nama' => 'Pak Budi',
            'role' => 'admin', // Status Admin
            'password' => Hash::make('123456') // Password untuk login
        ]);

    }
}