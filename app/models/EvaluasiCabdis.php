<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\Sekolah;


class EvaluasiCabdis extends Model
{
    protected $table = 'evaluasi_cabdis';
    const CREATED_AT = 'time_created';
    const UPDATED_AT = 'time_update';
    protected $fillable = [
        'sekolah',
        'periode_awal_kuesioner',
        'periode_akhir_kuesioner',
        'tgl_supervisi',
        'id_evaluasi',
        'total_score',
        'total_ratarata',
        'total_akhir',
        'nilai_kepatuhan',
        'status_kepatuhan',
        'nilai_kebersihan',
        'status_kebersihan',
        'time_created',
        'user_created',
        'time_update',
        'user_updated',
        'hasil_rekomendasi'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah', 'id');
    }

}
