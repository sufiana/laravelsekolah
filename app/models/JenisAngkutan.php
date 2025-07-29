<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JenisTransportasi;

class JenisAngkutan extends Model
{
    protected $table = 'ref_jenis_angkutan';
    protected $fillable = [
        'nama',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at',
        'jenis_transportasi'
    ];

    public function jenistransportasilist(){
        return $this->belongsTo(JenisTransportasi::class,'jenis_transportasi','id');
    }
}
