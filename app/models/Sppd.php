<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Spt;
use App\Models\JenisTransportasi;
use App\Models\JenisAngkutan;
use App\Models\Provinsi;
use App\Models\Kabupatenkota;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Beban;

class Sppd extends Model
{
    protected $table = 'sppd';
    protected $fillable = [
        'id_spt',
        'maksud',
        'jenis_perjalanan',
        'jenis_angkutan',
        'luar_kota',
        'provinsi',
        'kabupatenkota',
        'kecamatan',
        'kelurahan',
        'tujuan_lokasi',
        'mata_anggaran',
        'status_sppd',
        'hasil_sppd',
        'user_created',
        'created_at',
        'user_update',
        'updated_at',
        'hasil_laporan',
        'tanggal_laporan',
        'file_laporan',
        'verifikasi_laporan',
        'user_laporan',
        'alasan_laporan',
        'verifikasi_sppd',
        'alasan_sppd',
        'user_sppd',
        'verifikasi_tandaterima',
        'user_tandaterima',
        'alasan_tandaterima',
        'tanggal_tandaterima',
        'dibayarkan_oleh',
        'diketahui_oleh',
        'pejabat_sppd',
        'tgl_sppd',
        'total_akhir',
        'tanggal_kwitansi'
    ];

    public function sptlist(){
        return $this->belongsTo(Spt::class,'id_spt','id');
    }

    public function transportasilist(){
        return $this->belongsTo(JenisTransportasi::class,'jenis_perjalanan','id');
    }

    public function angkutanlist(){
        return $this->belongsTo(JenisAngkutan::class,'jenis_angkutan','id');
    }

    public function provinsilist(){
        return $this->belongsTo(Provinsi::class,'provinsi','id');
    }

    public function kabupatenlist(){
        return $this->belongsTo(Kabupatenkota::class,'kabupatenkota','id');
    }

    public function kecamatanlist(){
        return $this->belongsTo(Kecamatan::class,'kecamatan','id');
    }

    public function kelurahanlist(){
        return $this->belongsTo(Kelurahan::class,'kelurahan','id');
    }

    public function bebanlist(){
        return $this->belongsTo(Beban::class,'mata_anggaran','id');
    }




}
