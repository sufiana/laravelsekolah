<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use app\models\Provinsi;

class Kabupatenkota extends Model
{
    protected $table = 'kabupatenkota';
    protected $fillable = [
        'id',
        'id_provinsi',
        'nama'
    ];

    public function provinsilist(){
        return $this->belongsTo(Provinsi::class,'id_provinsi','id');
    }
}
