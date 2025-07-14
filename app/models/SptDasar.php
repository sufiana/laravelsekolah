<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SptDasar extends Model
{
    protected $table = 'spt_dasar';
    protected $fillable = [
        'id_spt',
        'nomor_spt',
        'jumlah',
        'nomor_urut',
        'dasar',
        'user_created',
        'created_at',
        'user_update',
        'kode_spt',
        'updated_at'
    ];
}
