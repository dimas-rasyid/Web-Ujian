<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class GuruImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $namaJurusan = trim($row['jurusan'] ?? '');

        // Jika kolom jurusan kosong, tetapkan sebagai "UMUM"
        if (empty($namaJurusan)) {
            $jurusanUmum = Jurusan::firstOrCreate(['nama_jurusan' => 'UMUM']);
            $jurusanId = $jurusanUmum->id_jurusan;
        } else {
            // Jika diisi, cari berdasarkan nama
            $jurusan = Jurusan::where('nama_jurusan', 'LIKE', '%' . $namaJurusan . '%')->first();

            // Jika jurusan yang ditulis tidak ditemukan di database, skip baris ini
            if (!$jurusan) {
                return null;
            }

            $jurusanId = $jurusan->id_jurusan;
        }

        return new Guru([
            'jurusan_id' => $jurusanId,
            'nama'       => $row['nama'],
            'role'       => strtolower($row['role']) === 'admin' ? 'admin' : 'pengajar',
            'password'   => Hash::make($row['password']),
        ]);
    }
}