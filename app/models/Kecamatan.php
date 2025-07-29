<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kabupatenkota;
use App\Models\Provinsi;


class Kecamatan extends Model
{
    protected $table = 'kecamatan';

    protected $fillable = [
        'id',
        'id_kabupatenkota',
        'nama',
        'prov'
    ];

    public function kabupatenkotalist(){
        return $this->belongsTo(Kabupatenkota::class,'id_kabupatenkota','id');
    }

    public function provlist(){
        return $this->belongsTo(Provinsi::class,'prov','id');
    }
}
