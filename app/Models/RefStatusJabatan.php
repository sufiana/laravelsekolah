<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefStatusJabatan extends Model
{
    protected $table = 'ref_status_jabatan';
    protected $fillable = [
        'nama',
        'deskripsi'
    ];
}
