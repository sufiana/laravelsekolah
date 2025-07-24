<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\IconGrid;
use App\Models\Sekolah;

class EvaluasiKuesioner extends Model
{
    //
    protected $table = 'evaluasi_kuesioner';
    const CREATED_AT = 'time_created';
    const UPDATED_AT = 'time_update';
    protected $fillable = [
        'id_kuesioner',
        'sekolah',
        'periode_awal_kuesioner',
        'periode_akhir_kuesioner',
        'status_verifikasi_sekolah',
        'status_evaluasi_pengawas',
        'status_evaluasi_cabdis',
        'id_ruang',
        'score',
        'hasil_score',
        'time_created',
        'user_created',
        'time_update',
        'user_updated',
        'user_verifikasi',
        'jabatan_verifikasi',
        'tanggal_verifikasi',
        'jabatan_approval_pengawas',
        'user_approval_pengawas',
        'tanggal_approval_pengawas',
        'jabatan_approval_cabdis',
        'user_approval_cabdis',
        'tanggal_approval_cabdis'
    ];

    public function ruanglist(){
        return $this->belongsTo(IconGrid::class,'id_ruang','id');
    }

    public function sekolahlist(){
        return $this->belongsTo(Sekolah::class,'id_sekolah','id');
    }

}
