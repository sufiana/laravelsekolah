<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SppdFileDokumentasi extends Model
{
    protected $table = 'sppd_filedokumentasi';
    protected $fillable = [
        'id_sppd',
        'file',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];
}
