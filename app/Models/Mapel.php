<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    protected $table = 'mapel';
    protected $primaryKey = 'id_mapel';

    protected $fillable = ['mapel', 'password'];

    public function mapelGuru()
    {
        return $this->hasMany(MapelGuru::class, 'id_mapel', 'id_mapel');
    }

    public function control()
    {
        return $this->hasMany(Control::class, 'mapel_id', 'id_mapel');
    }
}