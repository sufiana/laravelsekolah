<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Provinsi;

class Kabupatenkota extends Model
{
    protected $table = 'kabupaten';
    protected $fillable = [
        'kode_kabupaten',
        'nama_kabupaten',
        'jenis',
        'id_provinsi'
    ];

    public function provinsilist()
    {
        return $this->belongsTo(Provinsi::class, 'id_provinsi', 'id');
    }
}
