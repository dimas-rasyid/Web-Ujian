<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    // Tambahkan 'guru_id' di sini agar bisa disimpan ke database
    protected $fillable = ['jurusan_id', 'kelas', 'tingkat', 'guru_id'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', 'id_kelas');
    }

    public function control()
    {
        return $this->hasMany(Control::class, 'kelas_id', 'id_kelas');
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id_guru');
    }
}