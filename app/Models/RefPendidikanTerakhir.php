<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefPendidikanTerakhir extends Model
{
    protected $table = 'ref_pendidikan_terakhir';
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi'
    ];
}
