<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SppdTandaTerimaLuarWilayah extends Model
{
    protected $table = 'sppd_tandaterima_luarwilayah';
    protected $fillable = [
        'id_sppd',
        'pegawai',
        'jenis_biaya',
        'uraian',
        'jlh_hari_sppd',
        'jlh_hari_absensi',
        'nominal',
        'total',
        'upload_file',
        'user_created',
        'created_at',
        'user_update',
        'updated_at',
        'status_wilayah',
        'jenis_pembayaran',
        'status',
        'generate'
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
