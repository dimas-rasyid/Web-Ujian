<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $idSesi;
    protected $kelasId;
    protected $nomor = 0;

    public function __construct($idSesi, $kelasId = null)
    {
        $this->idSesi = $idSesi;
        $this->kelasId = $kelasId;
    }

    public function collection()
    {
        $query = Nilai::with(['siswa.kelas', 'sesi'])
            ->where('sesi_id', $this->idSesi);

        if ($this->kelasId) {
            $kelasId = $this->kelasId;

            $query->whereHas('siswa', function ($q) use ($kelasId) {
                $q->where('kelas_id', $kelasId);
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NISN',
            'Kelas',
            'Nama Ujian',
            'Kategori',
            'Tanggal Ujian',
            'Skor Akhir',
        ];
    }

    public function map($nilai): array
    {
        return [
            ++$this->nomor,
            $nilai->siswa->nama ?? '-',
            $nilai->siswa->nisn ?? '-',
            $nilai->siswa->kelas->nama_kelas ?? '-',
            $nilai->sesi->judul ?? '-',
            $nilai->sesi->kategori ?? '-',
            $nilai->sesi->tgl_sesi ?? '-',
            $nilai->skor ?? 0,
        ];
    }
}
