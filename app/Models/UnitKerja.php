<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{

    protected $table = 'unit_kerja';
    protected $fillable = [
        'kode_unit_kerja',
        'nama',
        'nama_cetak',
        'singkatan',
        'provinsi',
        'kabupatenkota',
        'alamat',
        'kodepos',
        'no_telp',
        'email',
        'website',
        'kopsurat_baris1',
        'kopsurat_baris2',
        'kopsurat_baris3',
        'kopsurat_baris4',
        'kopsurat_baris5',
        'kopsurat_baris6',
        'tempat_ttd',
        'logo',
        'aktif',
        'nama_dinas_surat',
        'nama_dinas_tandaterima',
        'kode_lokasi'
    ];
}
