<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Kecamatan;
use App\models\Kabupatenkota;
use App\models\Provinsi;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    protected $fillable = [
        'id',
        'id_kecamatan',
        'nama',
        'kab',
        'prov'
    ];

    public function kecamatanlist(){
        return $this->belongsTo(Kecamatan::class,'id_kecamatan','id');
    }

    public function kablist(){
        return $this->belongsTo(Kabupatenkota::class,'kab','id');
    }

    public function provlist(){
        return $this->belongsTo(Provinsi::class,'prov;
        ','id');
    }
}
