<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\RefAgama;
use App\Models\RefStatusPegawai;
use App\Models\RefPangkat;
use App\Models\RefGolongan;
use App\Models\RefStatusJabatan;
use App\Models\RefJabatan;
use App\Models\UnitKerja;
use App\Models\RefEselon;
use App\Models\RefPendidikanTerakhir;

class Pegawai extends Model
{
    protected $table = 'master_pegawai';
    protected $fillable = [
        'nip',
        'no_kartu_pegawai',
        'nama_pegawai',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_pegawai',
        'alamat',
        'no_telp_wa',
        'no_npwp',
        'pangkat',
        'golongan',
        'nomor_sk_pangkat',
        'tanggal_sk_pangkat',
        'tanggal_mulai_pangkat',
        'tanggal_selesai_pangkat',
        'id_status_jabatan',
        'id_jabatan',
        'id_unit_kerja',
        'id_satuan_kerja',
        'lokasi_kerja',
        'nomor_sk_jabatan',
        'id_eselon',
        'foto',
        'pendidikan_terakhir',
        'user_created',
        'created_at',
        'user_update',
        'updated_at'
    ];

    public function agamalist(){
        return $this->belongsTo(RefAgama::class,'agama','id');
    }

    public function statuspegawailist(){
        return $this->belongsTo(RefStatusPegawai::class,'status_pegawai','id');
    }

    public function pangkatlist(){
        return $this->belongsTo(RefPangkat::class,'pangkat','id');
    }

    public function golonganlist(){
        return $this->belongsTo(RefGolongan::class,'golongan','id');
    }

    public function statusjabatanlist(){
        return $this->belongsTo(RefStatusJabatan::class,'id_status_jabatan','id');
    }

    public function jabatanlist(){
        return $this->belongsTo(RefJabatan::class,'id_jabatan','id');
    }

    public function unitkerjalist(){
        return $this->belongsTo(UnitKerja::class,'id_unit_kerja','id');
    }

    public function eselonlist(){
        return $this->belongsTo(RefEselon::class,'id_eselon','id');
    }

    public function pendidikanlist(){
        return $this->belongsTo(RefPendidikanTerakhir::class,'pendidikan_terakhir','id');
    }




}
