<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $guarded = [];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'siswa_id', 'id_siswa');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'siswa_id', 'id_siswa');
    }
}