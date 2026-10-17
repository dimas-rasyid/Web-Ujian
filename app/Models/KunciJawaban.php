<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KunciJawaban extends Model
{
    protected $table = 'kunci_jawaban';
    protected $primaryKey = 'id_kunci';
    protected $guarded = [];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id_soal');
    }
}