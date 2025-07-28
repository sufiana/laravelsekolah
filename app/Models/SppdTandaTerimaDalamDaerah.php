<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sppd;
use App\Models\Pegawai;
use App\Models\RefJenisBiaya;
class SppdTandaTerimaDalamDaerah extends Model
{
    protected $table = 'sppd_tandaterima_dalamdaerah';
    protected $fillable = [
        'id_sppd',
        'pegawai',
        'jenis_biaya',
        'jlh_hari_sppd',
        'jlh_hari_absensi',
        'nominal',
        'total',
        'user_created',
        'created_at',
        'user_update',
        'updated_at',
        'status_wilayah',
        'uraian',
        'upload_file',
        'jenis_pembayaran'

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
