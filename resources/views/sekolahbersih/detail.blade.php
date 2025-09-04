@extends('layouts/master')
@section('title','Detail Penilaian Sekolah Bersih')

@section('content')
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
                                <table width="60%" class="table">
                                    <thead>
                                    <tr>
                                        <td width="2%" style="text-align: center">No</td>
                                        <td width="15%">Parameter</td>
                                        <td width="10%">Jawaban</td>
                                        <td width="10%">Alasan</td>
                                    </tr>
                                    </thead>

                                    @php $no=0; @endphp
                                    @foreach($hasilKuesioner as $i)
                                    @php $no++; @endphp
                                    <tr>
                                        <td width="2%" style="text-align: center">{{$no}}</td>
                                        <td width="10%">{{$i->parameter}}</td>
                                        <td width="10%">
                                            @if($i->jawaban ==3)
                                            <span class="badge badge-success">Bersih</span>
                                            @elseif($i->jawaban ==4)
                                            <span class="badge badge-success">Sangat Bersih</span>
                                            @elseif($i->jawaban ==2)
                                            <span class="badge badge-warning">Cukup Bersih</span>
                                            @else
                                            <span class="badge badge-danger">Tidak Bersih</span>
                                            @endif
                                        </td>
                                        <td width="10%">{{$i->deskripsi_jawaban}}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                        <div class="profile-box-footer clearfix" style="background-color: #3e5879">
                            <a href="#" style="color: white">
                                <span class="value">
                                    @if($model->status_verifikasi_sekolah == 1)
                                        <i class="fa fa-check-square"></i>
                                    @else
                                        <i class="fa fa-exclamation-triangle text-warning"></i>
                                    @endif
                                </span>
                                <span class="label"><b>Verifikasi Sekolah</b></span><br/>
                                @if($model->status_verifikasi_sekolah == 1)
                                    <span class="label">{{!$model->user_verifikasi && !$verifikator ?  ' - ' : $verifikator->verifikator}}</span><br/>
                                    <span class="label">Jabatan : {{!$model->jabatan_verifikasi && !$verifikator ?  ' - ' : $verifikator->jabatan}}</span><br/>
                                    <span class="label">Tanggal : {{date('d-M-Y', strtotime($model->tanggal_verifikasi))}}</span><br/>
                                @endif
                            </a>
                            <a href="#" style="color: white">
                                <span class="value">
                                    @if($model->status_verifikasi_pengawas == 1)
                                        <i class="fa fa-check-square"></i>
                                    @else
                                        <i class="fa fa-exclamation-triangle text-warning"></i>
                                    @endif
                                </span>
                                <span class="label">Verifikasi Pengawas</span><br/>
                                @if($model->status_evaluasi_pengawas == 1)
                                <span class="label">Nama : {{$model->user_approval_pengawas}}</span><br/>
                                <span class="label">Jabatan : {{$model->jabatan_approval_pengawas}}</span><br/>
                                <span class="label">Tanggal : {{date('d-M-Y', strtotime($model->tanggal_approval_pengawas))}}</span><br/>
                                @endif
                            </a>
                            <a href="#" style="color: white">
                                <span class="value">
                                    @if($model->status_verifikasi_cabdis == 1)
                                        <i class="fa fa-check-square"></i>
                                    @else
                                        <i class="fa fa-exclamation-triangle text-warning"></i>
                                    @endif
                                </span>
                                <span class="label">Verifikasi Cabdis</span><br/>
                                @if($model->status_evaluasi_cabdis == 1)
                                    <span class="label">Nama : {{$model->user_approval_cabdis}}</span><br/>
                                    <span class="label">Jabatan : {{$model->jabatan_approval_cabdis}}</span><br/>
                                    <span class="label">Tanggal : {{date('d-M-Y', strtotime($model->tanggal_approval_cabdis))}}</span><br/>
                                @endif
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
