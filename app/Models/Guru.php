<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id_guru';

    protected $fillable = ['jurusan_id', 'nama', 'role', 'password'];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id_jurusan');
    }

    public function mapelGuru()
    {
        return $this->hasMany(MapelGuru::class, 'id_guru', 'id_guru');
    }

    public function sesi()
    {
        return $this->hasMany(Sesi::class, 'guru_id', 'id_guru');
    }

    public function kelasBinaan()
    {
        return $this->hasOne(Kelas::class, 'guru_id', 'id_guru');
    }
}