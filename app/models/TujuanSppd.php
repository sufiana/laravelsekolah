<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TujuanSppd extends Model
{
    protected $table = 'tujuan_sppd';
    protected $fillable = [
        'id_spt',
        'id_sppd',
        'luar_kota',
        'provinsi',
        'kabupatenkota',
        'kecamatan',
        'kelurahan'
    ];
}
