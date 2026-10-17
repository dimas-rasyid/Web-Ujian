<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $guarded = [];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'id_kelas');
    }

    // Relasi Many-to-Many ke Sesi melalui tabel pivot sesi_kelas
    public function sesi()
    {
        return $this->belongsToMany(Sesi::class, 'sesi_kelas', 'kelas_id', 'sesi_id', 'id_kelas', 'id_sesi');
    }
}