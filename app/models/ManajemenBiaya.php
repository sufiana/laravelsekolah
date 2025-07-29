<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RefGolongan;
use App\models\RefJenisBiaya;
use App\models\RefStatusWilayahBiaya;

class ManajemenBiaya extends Model
{
    protected $table = 'manajemen_biaya';
    protected $fillable = [
        'jabatan',
        'jenis_biaya',
        'status_wilayah_biaya',
        'nominal',
        'deskripsi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];

    public function Jabatanlist(){
        return $this->belongsTo(RefGolongan::class,'jabatan','id');
    }

    public function Jenisbiayalist(){
        return $this->belongsTo(RefJenisBiaya::class,'jenis_biaya','id');
    }

    public function WilayahBiayalist(){
        return $this->belongsTo(RefStatusWilayahBiaya::class,'status_wilayah_biaya','id');
    }


}
