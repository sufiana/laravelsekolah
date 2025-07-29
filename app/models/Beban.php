<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RefBebanJenis;


class Beban extends Model
{
    protected $table = 'beban';
    protected $fillable = [
        'kode',
        'nama',
        'tahun',
        'deskripsi',
        'nilai_pagu',
        'masa_berlaku_awal',
        'masa_berlaku_akhir',
        'jenis',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];
    public function Jenislist(){
        return $this->belongsTo(RefBebanJenis::class,'jenis','id');
    }

}
