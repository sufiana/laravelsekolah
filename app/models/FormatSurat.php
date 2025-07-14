<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class FormatSurat extends Model
{
    protected $table = 'format_surat';
    protected $fillable = [
        'nama_surat',
        'digit_pertama',
        'digit_berikutnya',
        'id_jenis_surat',
        'aktif'

    ];
}
