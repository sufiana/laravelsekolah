<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\models\ValidasiSekolahBersih;


class ValidasiSekolahBersihChild extends Model
{
    protected $table = 'validasi_sekolahbersih_child';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_validasi',
        'id_ruang',
        'id_evaluasi',
        'id_kuesioner',
        'score',
        'rata',
        'nilai_kebersihan',
        'persen_kebersihan',
        'keterangan_kebersihan',
        'nilai_kepatuhan',
        'keterangan_kepatuhan',
        'dokumentasi',
        'user_create',
        'time_create',
        'user_update',
        'time_update',
        'score_pengawas',
        'rata_pengawas',
        'nilai_kebersihan_pengawas',
        'keterangan_kebersihan_pengawas',
        'catatan',
        'user_verifikasi',
        'user_verifikasi_guru_piket',
        'tanggal_verifikasi_sekolah',
    ];

    // contoh relasi: child belongsTo validasi_sekolahbersih
    public function validasi()
    {
        return $this->belongsTo(ValidasiSekolahBersih::class, 'id_validasi');
    }
}
