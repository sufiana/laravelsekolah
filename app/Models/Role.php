<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
    protected $table = 'role';
    protected $fillable = [
        'name',
        'deskripsi',
        'butuh_sekolah'
    ];

}
