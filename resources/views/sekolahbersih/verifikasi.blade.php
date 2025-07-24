@extends('layouts/master')
@section('title','Verifikasi Penilaian Sekolah Bersih')

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
@endsection
