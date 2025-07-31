@extends('layouts/master')
@section('title','Verifikasi Pengawas Sekolah')

@section('content')
<style>
.table td, .table th {
    padding: .5rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
    font-size: 10px;
}
.table tbody > tr > td:first-child {
    font-size: 12px;
    font-weight: 300;
}

.onoffswitch-sm {
  width: 60px;
  height: 24px;
}

.onoffswitch-sm .onoffswitch-label {
  display: block;
  overflow: hidden;
  cursor: pointer;
  height: 24px;
  padding: 0;
  line-height: 24px;
  border: 2px solid #E74C3C;
  border-radius: 24px;
  background-color: #E74C3C;
  font-size: 6px; /* Tambahkan ini untuk kecilkan font */
}

.onoffswitch-sm .onoffswitch-inner {
  display: block;
  width: 200%;
  margin-left: -100%;
  transition: margin 0.3s ease-in 0s;
}

.onoffswitch-sm .onoffswitch-switch {
  width: 10px;
  height: 10px;
  background: white;
  position: absolute;
  top: 1px; /* Sesuaikan agar vertikalnya pas */
  right: 26px;
  border: 1px solid #E74C3C;
  border-radius: 50%; /* Pastikan ini untuk bentuk bulat */
  transition: all 0.3s ease-in 0s;
  margin: 5px 18px 30px 40px;
}


.onoffswitch-sm .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
  margin-left: 0;
}

.onoffswitch-sm .onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-switch {
  right: -10px;
}

.onoffswitch-inner:before {
    padding-left: 5px;
}


</style>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('sekolahbersih.index') }}"><i class="fa fa-list"></i> Data @yield('title')</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Lihat Data @yield('title') #{{$model->id}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="main-box clearfix profile-box-contact">
                    <div class="main-box-body clearfix">
                        <div class="profile-box-header gray-bg clearfix" style="background-color: #3e5879 !important;">
                            <img src="img/samples/angelina-300.jpg" alt="" class="profile-img img-fluid">
                            <h2>{{$sekolah->nama}}</h2>
                            <div class="job-position">
                                Parameter Penilaian {{!$model->ruanglist || !$model->id_ruang ?  ' - ' : $model->ruanglist["nama"]}}
                            </div>
                            <ul class="contact-details">
                                <li>
                                    <i class="fa fa-calendar"></i> Periode {{date('d-M-Y',strtotime($model->periode_awal_kuesioner)).' s/d '.date('d-M-Y',strtotime($model->periode_awal_kuesioner))}}
                                </li>
                                <li>
                                    <i class="fa fa-percent"></i> Score {{$model->score}}
                                </li>
                                <li>
                                    <i class="fa fa-envelope-open-o"></i> Hasil Evaluasi {{$model->hasil_score}}
                                </li>
                            </ul>
                        </div>
                        <div class="main-box-body clearfix">
                            <div class="table-responsive">
                                <table width="98%" class="table">
                                    <thead>
                                    <tr>
                                        <td width="2%" style="text-align: center">No</td>
                                        <td width="30%">Parameter</td>
                                        <td width="5%">Score</td>
                                        <td width="8%">Rata-rata</td>
                                        <td width="8%">Keterangan</td>
                                        <td width="22%">Catatan/Temuan</td>
                                        <td width="5%">Dokumentasi</td>
                                        <td width="15%">Catatan Pemeriksaan</td>
                                    </tr>
                                    </thead>

                                    @php $no=0; @endphp
                                    @foreach($hasilKuesioner as $i)
                                    @php 
                                        $no++; 
                                        $ratarata = $i->score / $i->jumlah_parameter;
                                        $switchId = 'switch_' . $no;
                                    
                                        if ($ratarata >= 2.75) {
                                            $kesimpulan = '<span class="badge badge-primary">Sangat Bersih</span>';
                                            $nilai = 4;
                                        } elseif ($ratarata >= 2.00 && $ratarata < 2.75) {
                                            $kesimpulan = '<span class="badge badge-success">Bersih</span>';
                                            $nilai = 3;
                                        } elseif ($ratarata >= 1.00 && $ratarata < 2.00) {
                                            $kesimpulan = '<span class="badge badge-info">Cukup Bersih</span>';
                                            $nilai = 2;
                                        } elseif ($ratarata == 0) {
                                            $kesimpulan = '<span class="badge badge-danger">Belum isi</span>';
                                            $nilai = 0;
                                        } else {
                                            $kesimpulan = '<span class="badge badge-warning">Kurang Bersih</span>';
                                            $nilai = 1;
                                        }
                                    @endphp

                                    <tr>
                                        <td style="text-align: center">{{$no}}</td>
                                        <td>{{$i->nama.' ('.$i->jumlah_parameter.')'}}</td>
                                        <td>{{$i->score}}</td>
                                        <td>{{$ratarata}}</td>
                                        <td>
                                            {!!$kesimpulan!!} 
                                            <input type="hidden" class="form-control" id="nilai[{{$no}}]" name="nilai[{{$no}}]" value="{{$nilai}}">
                                        </td>
                                        <td>
                                            <textarea class="form-control form-control-sm" id="catatan[{{$no}}]" name="catatan[{{$no}}]" rows="1"></textarea>
                                        </td>
                                        <td>
                                            <div class="float-left">
                                           <!--<div class="onoffswitch onoffswitch-danger onoffswitch-sm">-->
                                           <!--   <input type="checkbox" name="kategori[{{$no}}]" class="onoffswitch-checkbox" id="switch_{{$no}}" checked>-->
                                           <!--   <label class="onoffswitch-label" for="switch_{{$no}}">-->
                                           <!--     <div class="onoffswitch-inner"></div>-->
                                           <!--     <div class="onoffswitch-switch"></div>-->
                                           <!--   </label>-->
                                           <!-- </div>-->

                                        <div class="form-check form-check-inline checkbox-nice">
                                            
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                id="dokumentasi_{{ $no }}" 
                                                onchange="updateCheckboxValue({{ $no }})"
                                            >
                                            <label class="form-check-label" for="dokumentasi_{{ $no }}">Ada</label>
                                        </div>
                                        <br/>
                                            <input type="hidden" id="dokumentasi_hidden_{{ $no }}" name="dokumentasi[{{ $no }}]" value="0">


                                            
                                        </td>
                                        <td width="10%">
                                            <textarea class="form-control form-control-sm" id="catatanpemeriksaan[{{$no}}]" name="catatanpemeriksaan[{{$no}}]" rows="1"></textarea>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>

                            <div class="main-box-body clearfix" style="padding: 20px">
                                <form method="POST" action="{{ route('sekolahbersih.storeverifikasi') }}" id="form-penilaian">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $model->id }}">
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">User Verifikator <span class="wajib"></span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="user_verifikasi" name="user_verifikasi" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-2 col-form-label">Jabatan Verifikator <span class="wajib"></span></label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="jabatan_verifikasi" name="jabatan_verifikasi" required>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button class="btn btn-primary tambah" type="submit">Verifikasi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('js')
<script>
function updateCheckboxValue(no) {
    const checkbox = document.getElementById('dokumentasi_' + no);
    const hiddenInput = document.getElementById('dokumentasi_hidden_' + no);
    
    if (checkbox.checked) {
        hiddenInput.value = 1;
    } else {
        hiddenInput.value = 0;
    }
}
</script>

@endsection
@endsection
