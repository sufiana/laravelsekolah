<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';
    protected $fillable = [
        'id_sppd',
        'id_spt',
        'pegawai',
        'tanggal',
        'ket',
        'alasan',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'

    ];
}
