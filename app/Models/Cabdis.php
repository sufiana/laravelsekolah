<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cabdis extends Model
{
    protected $table = 'cabdis';
    protected $fillable = [
        'nama',
        'kabupatenkota',
        'deskripsi'
    ];

}
