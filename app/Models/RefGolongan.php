<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RefPangkat;


class RefGolongan extends Model
{
    protected $table = 'ref_golongan';
    protected $fillable = [
        'kode',
        'nama',
        'id_pangkat',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];

    public function pangkatlist(){
        return $this->belongsTo(RefPangkat::class,'id_pangkat','id');
    }
}
