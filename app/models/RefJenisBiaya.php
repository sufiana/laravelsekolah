<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class RefJenisBiaya extends Model
{
    protected $table = 'ref_jenis_biaya';
    protected $fillable = [
        'nama',
        'tipe_pembayaran',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];
}
