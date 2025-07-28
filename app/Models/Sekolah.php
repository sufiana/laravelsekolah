<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    //
    protected $table = 'sekolah';
    protected $fillable = [
        'nama',
        'npsn',
        'bentuk_pendidikan_id',
        'status_sekolah',
        'alamat_jalan',
        'rt',
        'rw',
        'dusun',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten_kota',
        'provinsi',
        'kode_wilayah',
        'kode_pos',
        'lintang',
        'bujur',
        'nomor_telepon',
        'email',
        'website',
        'sk_penetapan',
        'tanggal_sk_penetapan',
        'jumlah_siswa_l',
        'jumlah_siswa_p',
        'tahun_ajaran_id',
        'semester_id',
        'create_date',
        'last_update',
    ];

}
