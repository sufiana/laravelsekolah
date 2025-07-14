<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefEselon extends Model
{
    protected $table = 'ref_eselon';
    protected $fillable = [
        'nama',
        'kode',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];
}
