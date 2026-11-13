<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapelGuru extends Model
{
    protected $table = 'mapel_guru';
    protected $primaryKey = 'id_mapgur';

    protected $fillable = ['id_guru', 'id_mapel', 'tingkat'];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id_mapel');
    }
}