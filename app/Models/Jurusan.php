<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusan';
    protected $primaryKey = 'id_jurusan';

    protected $fillable = ['nama_jurusan'];

    public function guru()
    {
        return $this->hasMany(Guru::class, 'jurusan_id', 'id_jurusan');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id', 'id_jurusan');
    }
}