<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    protected $table = 'rekening';
    protected $fillable = [
        'kode',
        'tahun',
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];
}
