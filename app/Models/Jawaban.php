<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Tambahkan/perbaiki baris ini

class Jawaban extends Model
{
    protected $table = 'jawaban';
    protected $primaryKey = 'id_jawaban';
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id_soal');
    }
}