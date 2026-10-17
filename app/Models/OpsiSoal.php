<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpsiSoal extends Model
{
    protected $table = 'opsi_soal';
    protected $primaryKey = 'id_opsi';
    protected $guarded = [];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id_soal');
    }
}