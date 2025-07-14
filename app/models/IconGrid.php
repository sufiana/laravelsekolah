<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class IconGrid extends Model
{
    //
    protected $table = 'ruang_sekolah';
    protected $fillable = [
        'nama',
        'deskripsi',
        'gambar',
        'singkatan',
        'url',
        'aktif'
    ];
}
