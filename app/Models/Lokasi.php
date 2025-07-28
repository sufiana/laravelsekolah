<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $fillable = [
        'id',
        'sub_id',
        'nama',
        'kab'
    ];
}
