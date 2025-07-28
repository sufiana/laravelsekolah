<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pegawai;
use App\Models\RefJabatanTtd;


class PejabatTtd extends Model
{
    protected $table = 'pejabat_ttd';
    protected $fillable = [
        'id_pegawai',
        'id_jabatan_ttd',
        'tgl_awal',
        'tgl_akhir',
        'deskripsi',
        'aktif',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'

    ];

    public function pegawailist(){
        return $this->belongsTo(Pegawai::class,'id_pegawai','id');
    }

    public function jabatanttdlist(){
        return $this->belongsTo(RefJabatanTtd::class,'id_jabatan_ttd','id');
    }


}
