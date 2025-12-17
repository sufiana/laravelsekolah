<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ValidasiSekolahBersih extends Model
{
    protected $table = 'validasi_sekolahbersih';
    protected $primaryKey = 'id';
    public $timestamps = false; // karena tidak ada created_at / updated_at default

    protected $fillable = [
        'id_sekolah',
        'periode_awal',
        'periode_akhir',
        'total_score',
        'total_rata',
        'nilai_kebersihan',
        'persen_kebersihan',
        'keterangan_kebersihan',
        'nilai_kepatuhan',
        'persen_kepatuhan',
        'keterangan_kepatuhan',
        'tanggal_supervisi_verifikasi',
        'user_supervisi_verifikasi',
        'dokumentasi',
        'kendala',
        'hasil_rekomendasi_pengawas',
        'hasil_rekomendasi',
        'tanggal_supervisi_validasi',
        'user_supervisi_validasi',
        'user_create',
        'time_create',
        'user_update',
        'time_update',
        'disusun_oleh',
        'mengetahui',
        'user_supervisi_pengawas',
        'tanggal_supervisi_pengawas',
        'status',
        'total_score_pengawas',
        'total_rata_pengawas',
        'rekap_nilai_kebersihan',
        'rekap_keterangan_kebersihan',
        'catatan_pengawas',
        'catatan_sekolah',
    ];
}
