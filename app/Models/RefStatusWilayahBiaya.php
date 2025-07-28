<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefStatusWilayahBiaya extends Model
{
    protected $table = 'ref_status_wilayah_biaya';
    protected $fillable = [
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];
}
