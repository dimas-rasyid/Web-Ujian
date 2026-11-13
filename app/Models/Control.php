<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Control extends Model
{
    protected $table = 'control';
    protected $primaryKey = 'id_control';

    protected $fillable = ['sesi_id', 'mapel_id', 'kelas_id'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id_sesi');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id_mapel');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id_kelas');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'control_id', 'id_control');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'control_id', 'id_control');
    }
}