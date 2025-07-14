<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SptAnggota extends Model
{
    protected $table = 'spt_anggota';
    protected $fillable = [
        'id_spt',
        'no_spt',
        'id_pegawai',
        'urutan',
        'jabatan_pegawai',
        'golongan_pegawai',
        'tanggal_berangkat',
        'tanggal_kembali',
        'lama',
        'status',
        'user_created',
        'created_at',
        'user_update',
        'kode_spt',
        'updated_at'
    ];
}
