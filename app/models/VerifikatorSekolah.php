<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Sekolah;
use App\models\RefJabatanVerifikator;


class VerifikatorSekolah extends Model
{
    protected $table = 'verifikator_sekolah';
    protected $fillable = [
        'id_sekolah',
        'verifikator',
        'jabatan_verifikator',
        'tandatangan',
        'deskripsi',
        'created_at',
        'user_create',
        'user_update',
        'updated_at',
        'instrumen'
    ];

    public function sekolahlist()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id');
    }

    public function jabatanlist()
    {
        return $this->belongsTo(RefJabatanVerifikator::class, 'jabatan_verifikator', 'id');
    }


}
