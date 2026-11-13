<?php

namespace App\Imports;

use App\Models\Mapel;
use App\Models\Guru;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows; // <-- Pakai 'SkipsEmptyRows' (dengan s)

class MapelImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    public function model(array $row)
    {
        $namaMapel = trim($row['mapel'] ?? '');
        $namaGuru  = trim($row['guru'] ?? '');
        $rawTingkat = trim($row['tingkat'] ?? '');

        if (empty($namaMapel) || empty($namaGuru)) {
            return null;
        }

        // 1. Cek atau Buat Mapel
        $mapel = Mapel::firstOrCreate(
            ['mapel' => $namaMapel],
            ['password' => Hash::make('123456')]
        );

        // 2. Cek Guru berdasarkan nama
        $guru = Guru::where('nama', 'LIKE', '%' . $namaGuru . '%')->first();

        if (!$guru) {
            return null;
        }

        // 3. Parse Tingkat
        $tingkat = $this->parseTingkat($rawTingkat);

        // 4. Masukkan ke tabel relasi mapel_guru
        DB::table('mapel_guru')->updateOrInsert(
            [
                'id_mapel' => $mapel->id_mapel,
                'id_guru'  => $guru->id_guru,
                'tingkat'  => $tingkat,
            ]
        );

        return null;
    }

    private function parseTingkat($text)
    {
        $text = strtoupper(trim($text));

        if (str_contains($text, 'XII') || str_contains($text, '12') || str_contains($text, 'DUABELAS')) {
            return 'XII';
        }
        if (str_contains($text, 'XI') || str_contains($text, '11') || str_contains($text, 'SEBELAS')) {
            return 'XI';
        }
        if (str_contains($text, 'X') || str_contains($text, '10') || str_contains($text, 'SEPULUH')) {
            return 'X';
        }

        return 'X';
    }
}