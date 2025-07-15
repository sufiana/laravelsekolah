<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IconGrid;
use App\Models\Parameter;
use App\Models\Sekolah;

class HasilKuesioner extends Model
{
    //
    protected $table = 'hasil_kuesioner';
    protected $fillable = [
        'id_sekolah',
        'id_user',
        'id_parameter',
        'id_ruang',
        'jawaban',
        'deskripsi_jawaban',
        'tahun_ajaran',
        'periode',
        'time_created',
        'user_created',
        'time_update',
        'user_updated',
        'status_verifikasi',
        'user_verifikasi',
        'jabatan_verifikasi',
        'tanggal_verifikasi',
        'status_approval_disdik',
        'jabatan_approval_disdik',
        'user_approval_disdik',
        'tanggal_approval_disdik',
        'periode_awal_kuesioner',
        'periode_akhir_kuesioner'
    ];

    public function ruanglist(){
        return $this->belongsTo(IconGrid::class,'id_ruang','id');
    }

    public function parameterlist(){
        return $this->belongsTo(Parameter::class,'id_parameter','id');
    }

    public function sekolahlist(){
        return $this->belongsTo(Sekolah::class,'id_sekolah','id');
    }

}
