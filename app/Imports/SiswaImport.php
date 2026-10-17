<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class SiswaImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $namaKelas = trim($row['kelas'] ?? '');

        // Cari kelas berdasarkan nama kelas di database
        $kelas = Kelas::where('nama_kelas', 'LIKE', '%' . $namaKelas . '%')->first();

        // Jika kelas tidak ditemukan, abaikan baris ini
        if (!$kelas) {
            return null;
        }

        return new Siswa([
            'kelas_id' => $kelas->id_kelas,
            'nisn'     => $row['nisn'],
            'nama'     => $row['nama'],
            'password' => Hash::make($row['password']),
        ]);
    }
}