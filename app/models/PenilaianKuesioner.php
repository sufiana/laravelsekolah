<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IconGrid;


class PenilaianKuesioner extends Model
{
    //
    protected $table = 'penilaian_kuesioner';
    protected $fillable = [
        'id_ruang',
        'batas_atas',
        'batas_bawah',
        'hasil',
        'score'
    ];

    public function ruanglist(){
        return $this->belongsTo(IconGrid::class,'id_ruang','id');
    }


}
