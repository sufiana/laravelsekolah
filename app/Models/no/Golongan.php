<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    protected $table = 'ref_golongan';
    protected $fillable = [
        'kode',
        'nama',
        'level',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];
}
