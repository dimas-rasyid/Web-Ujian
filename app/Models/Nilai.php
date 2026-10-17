<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'id_nilai';
    protected $guarded = [];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id_sesi');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
}