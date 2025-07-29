<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sppd;
use App\Models\Pegawai;
use App\Models\RefJenisBiaya;
class SppdTandaTerimaLuarDaerah extends Model
{
    protected $table = 'sppd_tandaterima_luardaerah';
    protected $fillable = [
        'id_sppd',
        'jenis_biaya',
        'uraian',
        'pegawai',
        'jlh_hari',
        'nominal',
        'total',
        'upload_file',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];

    public function jenisbiayalist(){
        return $this->belongsTo(RefJenisBiaya::class,'jenis_biaya','id');
    }

    public function PegawaiList(){
        return $this->belongsTo(Pegawai::class,'pegawai','id');
    }

    public function SppdList(){
        return $this->belongsTo(Sppd::class,'id_sppd','id');
    }
}
