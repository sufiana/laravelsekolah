<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $table = 'program';
    protected $fillable = [
        'kode',
        'nama',
        'tahun',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'

    ];
}
