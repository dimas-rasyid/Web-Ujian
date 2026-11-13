<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'nilai';
    protected $primaryKey = 'id_nilai';

    protected $fillable = ['control_id', 'siswa_id', 'skor', 'skor_up', 'status'];

    public function control()
    {
        return $this->belongsTo(Control::class, 'control_id', 'id_control');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id_siswa');
    }
}