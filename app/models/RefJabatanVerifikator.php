<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefJabatanVerifikator extends Model
{
    protected $table = 'ref_jabatan_verifikator';
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'deskripsi',
    ];
}
