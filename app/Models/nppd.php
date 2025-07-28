<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class nppd extends Model
{
    protected $table = 'nppd';
    protected $fillable = [
        'no_urut',
        'no_nppd',
        'pegawai',
        'tgl_nppd',
        'provinsi_tujuan',
        'kabkota_tujuan',
        'kecamatan_tujuan',
        'kelurahan_tujuan',
        'maksud',
        'jenis_angkutan',
        'jenis_kendaraan',
        'tanggal_berangkat',
        'tanggal_kembali',
        'lama',
        'pejabat_pemberi_perintah',
        'status',
        'alasan_penolakan',
        'instansi',
        'user_created',
        'created_at',
        'user_update',
        'updated_at',
        'kegiatan',
    ];

    public function setCatAttribute($value)
    {
        $this->attributes['pegawai'] = json_encode($value);
    }

    public function getCatAttribute($value)
    {
        return $this->attributes['pegawai'] = json_decode($value);
    }
}
