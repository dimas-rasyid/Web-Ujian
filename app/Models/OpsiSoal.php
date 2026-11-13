<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpsiSoal extends Model
{
    protected $table = 'opsi_soal';
    protected $primaryKey = 'id_opsi';

    protected $fillable = ['soal_id', 'kode_opsi', 'text_opsi', 'is_correct'];

    public function soal()
    {
        return $this->belongsTo(Soal::class, 'soal_id', 'id_soal');
    }
}