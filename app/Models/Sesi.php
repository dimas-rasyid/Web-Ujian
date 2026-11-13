<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sesi extends Model
{
    protected $table = 'sesi';
    protected $primaryKey = 'id_sesi';

    // Tambahkan 'mapel_id' agar bisa disimpan via mass assignment (create)
    protected $fillable = [
        'guru_id', 
        'mapel_id', 
        'judul', 
        'sesi', 
        'token', 
        'waktu_mulai', 
        'waktu_selesai', 
        'durasi'
    ];

    // Relasi ke Guru (PJ Sesi)
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id_guru');
    }

    // Relasi ke Mata Pelajaran
    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'mapel_id', 'id_mapel');
    }

    // Relasi ke Control (Tabel Pivot)
    public function control()
    {
        return $this->hasMany(Control::class, 'sesi_id', 'id_sesi');
    }

    // Relasi Many-to-Many ke Kelas (melalui tabel control)
    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'control', 'sesi_id', 'kelas_id');
    }

    // Relasi ke Soal ujian (melalui tabel control)
    public function soal()
    {
        return $this->hasManyThrough(Soal::class, Control::class, 'sesi_id', 'control_id', 'id_sesi', 'id_control');
    }
}