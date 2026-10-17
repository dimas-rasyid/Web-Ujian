<?php

namespace App\Imports;

use App\Models\Soal;
use App\Models\OpsiSoal;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class SoalImport implements ToCollection, WithHeadingRow
{
    protected $idSesi;

    public function __construct($idSesi)
    {
        $this->idSesi = $idSesi;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Sesuaikan key header excel Anda (misal: soal, a, b, c, d, e, kunci)
            $pertanyaan = $row['soal'] ?? null;
            if (!$pertanyaan) continue; // Lewati jika baris soal kosong

            $opsiA = $row['a'] ?? null;
            $opsiB = $row['b'] ?? null;
            $opsiC = $row['c'] ?? null;
            $opsiD = $row['d'] ?? null;
            $opsiE = $row['e'] ?? null;
            $kunci = strtoupper(trim($row['kunci'] ?? ''));

            // 1. Tentukan Tipe Soal (Jika tidak ada opsi sama sekali dan kunci kosong, maka Essay)
            $adaOpsi = !empty($opsiA) || !empty($opsiB) || !empty($opsiC) || !empty($opsiD) || !empty($opsiE);
            $tipeSoal = ($adaOpsi && !empty($kunci)) ? 'Pilihan Ganda' : 'Essay';

            // Simpan Soal
            $soal = Soal::create([
                'sesi_id'    => $this->idSesi,
                'tipe'       => $tipeSoal,
                'pertanyaan' => $pertanyaan,
            ]);

            // 2. Jika Pilihan Ganda, simpan hanya opsi yang terisi (mendukung 3, 4, atau 5 opsi)
            if ($tipeSoal === 'Pilihan Ganda') {
                $daftarOpsi = [
                    'A' => $opsiA,
                    'B' => $opsiB,
                    'C' => $opsiC,
                    'D' => $opsiD,
                    'E' => $opsiE
                ];

                foreach ($daftarOpsi as $kode => $teks) {
                    if (!empty($teks)) {
                        OpsiSoal::create([
                            'soal_id'    => $soal->id_soal,
                            'kode_opsi'  => $kode,
                            'teks_opsi'  => $teks,
                            'is_correct' => ($kode === $kunci) ? 1 : 0,
                        ]);
                    }
                }
            }
        }
    }
}