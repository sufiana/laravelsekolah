<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'ref_jabatan';
    protected $fillable = [
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'

    ];
}
