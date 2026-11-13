<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    protected $table = 'soal';
    protected $primaryKey = 'id_soal';

    protected $fillable = ['control_id', 'tipe', 'pertanyaan'];

    public function control()
    {
        return $this->belongsTo(Control::class, 'control_id', 'id_control');
    }

    public function opsiSoal()
    {
        return $this->hasMany(OpsiSoal::class, 'soal_id', 'id_soal');
    }

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class, 'soal_id', 'id_soal');
    }

    public function opsi()
    {
        return $this->hasMany(OpsiSoal::class, 'soal_id', 'id_soal');
    }
}