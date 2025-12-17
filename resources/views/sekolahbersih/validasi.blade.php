@extends('layouts/master')
@section('title', 'Validasi Pengawas Sekolah')

@section('css')
<style>
.card-footer {
  padding: .75rem 1.25rem;
  background-color: #3e5879 !important; 
  color: #fff;
  text-align: center;
}

.widget-user-header {
    background-color: #3e5879 !important;
    color: #fff;
    padding: 0 20px;
}

  .widget-user-image {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 20px 0; 
  }

  .chart-wrapper {
  position: relative;
  width: 150px;
  height: 150px;
  margin: 0 auto;
}

.chart-wrapper canvas {
  position: relative;
  z-index: 1;
}

.chart-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-weight: bold;
  font-size: 20px;
  color: #3e5879;
  z-index: 2;
  pointer-events: none;
}


@media (max-width: 767.98px) {
  .widget-user-header .row {
    flex-direction: column;
    align-items: center;
  }

  .widget-user-image {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin: 20px 0; 
  }

  .direct-chat-img {
    float: none;
    margin: 0 auto;
  }

  .widget-user-username {
    padding-top: 10px !important;
    align-items: center;    
  }

}
.textfield-xs {
  font-size: 0.75rem;       /* Ukuran teks kecil */
  padding: 0.25rem 0.5rem;  /* Padding minimal */
  height: calc(1.5em + 0.5rem + 2px); /* Tinggi input */
  line-height: 1.5;
  border-radius: 0.2rem;
}
.input-group-xs > .form-control,
.input-group-xs > .input-group-text {
  font-size: 0.75rem;
  padding: 0.25rem 0.5rem;
  height: calc(1.5em + 0.5rem + 2px);
  line-height: 1.5;
  border-radius: 0.2rem;
}

</style>
@endsection


@section('content')


<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Data @yield('title')</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><span>@yield('title')</span></li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
    <div class="container-fluid">  
        <div class="row">
            <div class="col-md-12">
                <div class="card card-widget widget-user-2">
                    <div class="widget-user-header">
                        <div class="row align-items-center">
                            <h6 class="widget-user-username" style="padding-top: 10px; font-weight: bold;">{{$sekolah->nama}} {{ $kabupaten->nama_kabupaten }}</h6>
                            <ul class="contact-details list-unstyled" style="font-size: 12px; line-height: 22px;">        
                                <li>
                                    <i class="fa fa-envelope-open-o"></i>  NPSN : {{$sekolah->npsn}}
                                <li>
                                <li>
                                    <i class="fa fa-envelope-open-o"></i> Kecamatan/Kabupatenkota : {{!$kabupaten || !$sekolah->kabupaten_kota ? ' - ' : $kabupaten->nama_kabupaten}} 
                                </li>                                      
                                    <i class="fa fa-calendar"></i> Periode {{date('d-M-Y',strtotime($model->periode_awal_kuesioner)).' s/d '.date('d-M-Y',strtotime($model->periode_akhir_kuesioner))}}
                                </li>
                                <li>
                                    <i class="fa fa-calculator"></i> Alamat Sekolah : {{$sekolah->alamat_jalan}} 
                                </li>                                
                                <li>
                                    <i class="fa fa-user"></i> Nama Kepala Sekolah : {{!$sekolah->kepalasekolah ? '-' : $sekolah->kepalasekolah}}
                                </li>                              
                            </ul>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('sekolahbersih.storeValidasi') }}" id="form-penilaian">
                    @csrf
                        <input type="hidden" id="periode_awal_kuesioner" name="periode_awal_kuesioner" value="{{$model->periode_awal_kuesioner}}">
                        <input type="hidden" id="periode_akhir_kuesioner" name="periode_akhir_kuesioner" value="{{$model->periode_akhir_kuesioner}}">
                        <input type="hidden" id="sekolah" name="sekolah" value="{{$model->sekolah}}">

                        <div class="main-box-body clearfix">
                            <div class="row">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="align-middle">
                                                <td width="2%">No</td>
                                                <td width="30%">Instrumen</td>
                                                <td width="5%">Score</td>
                                                <td width="8%">Rata-rata</td>
                                                {{-- <td width="8%">Kepatuhan</td> --}}
                                                <td width="5%">Kebersihan</td>
                                                <td width="5%">keterangan</td>

                                                <td width="5%">Dokumentasi</td>
                                                {{-- <td width="8%">Keterangan <br/> Kebersihan </td>
                                                <td width="14%">Catatan/Temuan</td> --}}
                                                {{-- <td width="15%">Catatan Pemeriksaan</td> --}}
                                            </tr>
                                            @php
                                                $globalIndex=0;
                                                $displayNo=1;
                                                $totalscore=0;
                                                $totalrata=0;
                                                $totalinstrumen=0;
                                                
                                            @endphp

                                            @foreach ($hasilKuesioner as $hkr )
                                                @php
                                                    $nilaikebersihanmaximal=$hkr->jumlah_parameter*4;
                                                    $nilaikebersihan=($hkr->score/$nilaikebersihanmaximal)*100;
                                                    if($nilaikebersihan >=85) {
                                                        $statuskebersihanhkr='<span class="badge text-bg-success">Sangat Bersih</span>';
                                                    }
                                                    else if($nilaikebersihan >=70 && $nilaikebersihan <85) {
                                                        $statuskebersihanhkr='<span class="badge text-bg-success">Bersih</span>';
                                                    }
                                                    else if($nilaikebersihan >=50 && $nilaikebersihan <70) {
                                                        $statuskebersihanhkr='<span class="badge text-bg-warning">Cukup Bersih</span>';
                                                    }
                                                    else if($nilaikebersihan ==0) {
                                                        $statuskebersihanhkr='<span class="badge text-bg-danger">Belum isi</span>';
                                                    }
                                                    else {
                                                        $statuskebersihanhkr='<span class="badge text-bg-danger">Kurang Bersih</span>';
                                                    }

                                                    $ambilchildkuesioner = App\Models\EvaluasiKuesioner::where('periode_awal_kuesioner', $model->periode_awal_kuesioner)
                                                        ->where('periode_akhir_kuesioner', $model->periode_akhir_kuesioner)
                                                        ->where('sekolah', $model->sekolah)
                                                        ->where('id_ruang', $hkr->id_ruang)
                                                        ->first();

                                                    $rataold=$hkr->score / $hkr->jumlah_parameter;
                                                    $rata=round($rataold,3);

                                                    $totalscore += $hkr->score;
                                                    //$totalrata += $rataold;
                                                    $totalinstrumen += $hkr->jumlah_parameter;
                                                    $scorekepatuhan=0;
                                                    $keterangan_kepatuhan='';
                                                    if($rata >=3) {
                                                        $scorekepatuhan=3;
                                                        $keterangan_kepatuhan='Sangat Patuh';
                                                    }
                                                    else if($rata >1 || $rata <=2) {
                                                        $scorekepatuhan=2;
                                                        $keterangan_kepatuhan='Belum isi';
                                                    }                                                    
                                                    else if($rata == 0) {
                                                        $scorekepatuhan=0;
                                                        $keterangan_kepatuhan='Belum isi';
                                                    }
                                                    //============AMBIL KETERANGAN KEBERSIHAN=================
                                                    if ($rata > 3 && $rata <= 4) {
                                                        $nilaikebersihanchild = 4;
                                                        $keterangankebersihanchild = "Sangat Bersih"; 
                                                    } elseif ($rata > 2 && $rata <= 3) {
                                                        $nilaikebersihanchild = 3;
                                                        $keterangankebersihanchild = "Bersih";
                                                    } elseif ($rata > 1 && $rata <= 2) {
                                                        $nilaikebersihanchild = 2;
                                                        $keterangankebersihanchild = "Cukup Bersih";
                                                    } else { // nilai <= 1
                                                        $nilaikebersihanchild = 1;
                                                        $keterangankebersihanchild = "Kurang Bersih";
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>
                                                        {{ $displayNo++ }}                                                                                                            
                                                        <input type="hidden" id="id_evaluasi[{{$globalIndex}}]" name="id_evaluasi[{{$globalIndex}}]" value="{{$ambilchildkuesioner->id ?? '' }}">
                                                        <input type="hidden" id="id_kuesioner[{{$globalIndex}}]" name="id_kuesioner[{{$globalIndex}}]" value="{{$ambilchildkuesioner->id_kuesioner ?? '' }}">
                                                    </td>
                                                    <td>
                                                        {{ $hkr->nama.' ('.$hkr->jumlah_parameter.')' }} 
                                                        <input type="hidden" id="id_ruang[{{$globalIndex}}]" name="id_ruang[{{$globalIndex}}]" value="{{$hkr->id_ruang}}">
                                                    </td>
                                                    <td>
                                                        {{ $hkr->score }}
                                                        <input type="hidden" id="score[{{$globalIndex}}]" name="score[{{$globalIndex}}]" value="{{ $hkr->score}}">
                                                    </td>
                                                    <td>                                                        
                                                        {{ $rata }}
                                                        <input type="hidden" id="rata[{{$globalIndex}}]" name="rata[{{$globalIndex}}]" value="{{ $rata}}">
                                                        <input type="hidden" id="nilai_kebersihan_child[{{$globalIndex}}]" name="nilai_kebersihan_child[{{$globalIndex}}]" value="{{ $nilaikebersihanchild}}">
                                                        <input type="hidden" id="ket_kebersihan_child[{{$globalIndex}}]" name="ket_kebersihan_child[{{$globalIndex}}]" value="{{ $keterangankebersihanchild}}">
                                                        <input type="hidden" id="user_verifikasi_child[{{ $globalIndex }}]" name="user_verifikasi_child[{{ $globalIndex }}]" value="{{ $ambilchildkuesioner->user_verifikasi ?? '' }}" >
                                                        <input type="text" id="user_verifikasi_guru_piket_child[{{ $globalIndex }}]" name="user_verifikasi_guru_piket_child[{{ $globalIndex }}]" value="{{ $ambilchildkuesioner->user_verifikasi_guru_piket ?? '' }}" >
                                                        <input type="hidden" id="tanggal_verifikasi_sekolah_child[{{ $globalIndex }}]" name="tanggal_verifikasi_sekolah_child[{{ $globalIndex }}]" value="{{ date('Y-m-d', strtotime($ambilchildkuesioner->tanggal_verifikasi ?? '')) }}" >

                                                    </td>
                                                    <td>
                                                        {{ number_format($nilaikebersihan, 2) }} %
                                                    </td>                                                    
                                                    <td>
                                                        {!! $statuskebersihanhkr !!}
                                                    </td>

                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dokumentasi[{{ $globalIndex }}]" id="toggle-{{ $globalIndex }}" value=1 checked>
                                                            <label class="form-check-label">Ada</label>
                                                        </div>
                                                        {{-- <input type="checkbox" name="dokumentasi[{{ $nohkr }}]" id="toggle-{{ $nohkr }}"  checked data-toggle="toggle" data-on="Ada" data-off="Tidak Ada" data-onstyle="success" data-offstyle="danger"data-size="sm">                                                 --}}
                                                    </td>
                                                </tr>
                                                @php $globalIndex++; @endphp                                            
                                            @endforeach
                                            <tr>
                                                @php 
                                                    $totalrata=round($totalscore / $totalinstrumen,2);
                                                    $persentasekebersihan=round(($totalrata/4)*100,2);
                                                    $nilaikebersihan=0;
                                                    $keterangankebersihan='';

                                                    if ($totalrata > 3 && $totalrata <= 4) {
                                                        $nilaikebersihan = 4;
                                                        $keterangankebersihan = "Sangat Bersih"; 
                                                    } elseif ($totalrata > 2 && $totalrata <= 3) {
                                                        $nilaikebersihan = 3;
                                                        $keterangankebersihan = "Bersih";
                                                    } elseif ($totalrata > 1 && $totalrata <= 2) {
                                                        $nilaikebersihan = 2;
                                                        $keterangankebersihan = "Cukup Bersih";
                                                    } else { // nilai <= 1
                                                        $nilaikebersihan = 1;
                                                        $keterangankebersihan = "Kurang Bersih";
                                                    }
                                                @endphp                                                
                                                <td colspan="2">Jumlah</td>
                                                <td colspan="1">{{$totalscore}}
                                                    <input type="hidden" name="total_score" id="total_score" value="{{$totalscore}}">
                                                </td>
                                                <td colspan ='1'>
                                                    {{$totalrata }}
                                                    <input type="hidden" name="total_rata" id="total_rata" value="{{$totalrata}}">

                                                </td>
                                                <td colspan ='1'>
                                                    {{$nilaikebersihan}} 
                                                    <input type="hidden" name="nilai_kebersihan" id="nilai_kebersihan" value="{{$nilaikebersihan}}">
                                                </td>
                                                <td colspan ='2'>
                                                    {{$keterangankebersihan}} 
                                                    <input type="hidden" name="keterangan_kebersihan" id="keterangan_kebersihan" value="{{$keterangankebersihan}}">
                                                    <input type="hidden" name="persen_kebersihan" id="persen_kebersihan" value="{{$persentasekebersihan}}">
                                                </td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="main-box-body clearfix" style="padding: 20px">
                            <input type="hidden" name="id" value="{{ $model->id }}">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="row" id="popoverPwd-container">
                                        <div class="form-group col-md-12">
                                            <label for="popoverName">Tanggal Validasi </label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="tanggal_supervisi_verifikasi" name="tanggal_supervisi_verifikasi" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="popoverName">Disusun Oleh</label>
                                            <div class="form-group">
                                                @if($verifikator && count($verifikator) > 0)
                                                    <select name="user_validator" id="user_validator" class="form-select">
                                                        <option value="">-- Pilih Verifikator --</option>
                                                        @foreach($verifikator as $user)
                                                            <option value="{{ $user->id }}" {{ old('user_validator') == $user->id ? 'selected' : '' }}>
                                                                {{ $user->verifikator.' - jabatan '.$user->jabatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <div class="alert alert-warning">
                                                        Data verifikator sekolah tidak ditemukan. 
                                                        Silakan <a href="{{ route('verifikator.create') }}">tambahkan verifikator</a> terlebih dahulu.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="row mb-3">
                                        <div class="form-group col-md-12">
                                            <label for="popoverName">Mengetahui</label>
                                            <div class="form-group">
                                                @if($verifikator && count($verifikator) > 0)
                                                    <select name="user_validator_kepsek" id="user_validator_kepsek" class="form-select">
                                                        <option value="">-- Pilih Verifikator --</option>
                                                        @foreach($verifikator as $kepsek)
                                                            <option value="{{ $kepsek->id }}" {{ old('user_validator_kepsek') == $kepsek->id ? 'selected' : '' }}>
                                                                {{ $kepsek->verifikator.' - jabatan '.$kepsek->jabatan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <div class="alert alert-warning">
                                                        Data verifikator sekolah tidak ditemukan. 
                                                        Silakan <a href="{{ route('verifikator.create') }}">tambahkan verifikator</a> terlebih dahulu.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="catatan_sekolah">Catatan Sekolah</label>
                                        <div class="form-group">
                                            <textarea class="form-control" id="catatan_sekolah" name="catatan_sekolah" rows="3">{{ old('catatan_sekolah', $model->catatan_sekolah ?? '') }}</textarea>  
                                        </div>
                                    </div>
                                </div>

                            </div>
                                
                            <div class="form-group text-center mt-4">
                                <button class="btn btn-primary tambah" type="submit">Verifikasi</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function() {
    $('#tanggal_supervisi_verifikasi').datepicker({
        format: 'dd-M-yyyy',
        autoclose: true,
        todayHighlight: true
        }).datepicker('setDate', new Date()); // ← ini untuk default hari ini
    });


    
</script>

<script>
$(document).ready(function () {

    $('#form-penilaian').on('submit', function (e) {
        e.preventDefault(); 

        Swal.fire({
            title: 'Yakin Simpan Validasi?',
            text: "Pastikan data sudah benar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan!',
            cancelButtonText: 'Batal',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading alert
                Swal.fire({
                    title: 'Menyimpan...',
                    text: 'Mohon tunggu',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        // Show success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data validasi berhasil disimpan/diupdate.',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Redirect after showing alert
                            window.location.href = "{{ route('sekolahbersih.indexValidasi') }}";
                        });
                    },
                    error: function (xhr) {
                        let errorMessage = 'Gagal menyimpan validasi';
                        
                        // Check if response has validation errors
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            errorMessage = Object.values(errors).flat().join('\n');
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        // Show error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage,
                            confirmButtonText: 'Coba Lagi'
                        });
                    }
                });
            }
        });
    });

});
</script>

@endsection
