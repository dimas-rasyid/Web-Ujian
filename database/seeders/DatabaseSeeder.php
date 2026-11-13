<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Input Data Jurusan
        $jurusanList = [
            ['nama_jurusan' => 'RPL'],
            ['nama_jurusan' => 'TJKT'],
            ['nama_jurusan' => 'DKV'],
            ['nama_jurusan' => 'AKR'],
            ['nama_jurusan' => 'MP'],
        ];

        foreach ($jurusanList as $j) {
            Jurusan::create($j);
        }

        // Ambil ID jurusan pertama (misal: RPL) untuk relasi guru default jika diperlukan
        $jurusanRPL = Jurusan::where('nama_jurusan', 'RPL')->first();

        // 2. Input Data Guru (Admin & Pengajar)
        Guru::create([
            'jurusan_id' => $jurusanRPL->id_jurusan,
            'nama'       => 'Administrator Utama',
            'role'       => 'admin',
            'password'   => Hash::make('password123'), // Sesuaikan password
        ]);

        Guru::create([
            'jurusan_id' => $jurusanRPL->id_jurusan,
            'nama'       => 'Guru Pengajar Mapel',
            'role'       => 'pengajar',
            'password'   => Hash::make('password123'), // Sesuaikan password
        ]);
    }
}