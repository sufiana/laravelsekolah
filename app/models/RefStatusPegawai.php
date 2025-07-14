<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefStatusPegawai extends Model
{
    protected $table = 'ref_status_pegawai';
    protected $fillable = [
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'

    ];
}
