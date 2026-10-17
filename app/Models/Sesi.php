<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    protected $table = 'sesi';
    protected $primaryKey = 'id_sesi';
    protected $guarded = [];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id_guru');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'sesi_id', 'id_sesi');
    }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'sesi_kelas', 'sesi_id', 'kelas_id', 'id_sesi', 'id_kelas');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'sesi_id', 'id_sesi');
    }
}