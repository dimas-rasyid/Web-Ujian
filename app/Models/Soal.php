<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';
    protected $primaryKey = 'id_soal';
    protected $guarded = [];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id_sesi');
    }

    public function opsi()
    {
        return $this->hasMany(OpsiSoal::class, 'soal_id', 'id_soal');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'soal_id', 'id_soal');
    }
}