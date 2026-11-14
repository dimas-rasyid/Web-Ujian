<?php

namespace App\Imports;

use App\Models\Control;
use App\Models\Soal;
use App\Models\OpsiSoal;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class SoalImport implements ToCollection, WithHeadingRow
{
    protected $idControl;

    public function __construct($idControl)
    {
        $this->idControl = $idControl;
    }

    public function collection(Collection $rows)
    {
        $control = Control::find($this->idControl);
        if (!$control) {
            return;
        }

        foreach ($rows as $row) {
            $pertanyaan = $row['soal'] ?? null;
            if (!$pertanyaan) continue; // Lewati jika baris soal kosong

            // Jika Anda ingin membaca kolom kelas/tingkat dari excel:
            $kelasExcel = $row['kelas'] ?? null; 

            $opsiA = $row['a'] ?? null;
            $opsiB = $row['b'] ?? null;
            $opsiC = $row['c'] ?? null;
            $opsiD = $row['d'] ?? null;
            $opsiE = $row['e'] ?? null;
            $kunci = strtoupper(trim($row['kunci'] ?? ''));

            // Tentukan Tipe Soal
            $adaOpsi = !empty($opsiA) || !empty($opsiB) || !empty($opsiC) || !empty($opsiD) || !empty($opsiE);
            $tipeSoal = ($adaOpsi && !empty($kunci)) ? 'Pilihan Ganda' : 'Essay';

            // Simpan Soal menggunakan id_control
            $soal = Soal::create([
                'control_id' => $control->id_control,
                'tipe'       => $tipeSoal,
                'pertanyaan' => $pertanyaan,
            ]);

            // Jika Pilihan Ganda, simpan opsi pilihan ke tabel opsi_soal
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
                            'text_opsi'  => $teks, 
                            'is_correct' => ($kode === $kunci) ? 1 : 0,
                        ]);
                    }
                }
            }
        }
    }
}