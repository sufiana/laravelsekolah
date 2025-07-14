<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class JenisTransportasi extends Model
{
    protected $table = 'ref_jenis_transportasi';
    protected $fillable = [
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];
}
