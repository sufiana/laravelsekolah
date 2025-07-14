<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RefGolongan;


class RefJabatan extends Model
{
    protected $table = 'ref_jabatan';
    protected $fillable = [
        'kode',
        'id_golongan',
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'

    ];

    public function golonganlist(){
        return $this->belongsTo(RefGolongan::class,'id_golongan','id');
    }
}
