<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefPangkat extends Model
{
    protected $table = 'ref_pangkat';
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'

    ];
}
