@extends('layouts/master')
@section('title','Dashboard')
@section('css')
<style>
  

</style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div id="content-header" class="clearfix">
                    <div class="float-left">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active"><span>Dashboard</span></li>
                        </ol>
                        <h1>Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-sm-6 col-12">
                <div class="main-box infographic-box colored emerald-bg">
                    <i class="fa fa-user"></i>
                    <span class="headline" style="font-size: 10.5px">Komponen Terkirim</span>
                    <span class="value">12</span>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="main-box infographic-box colored red-bg">
                    <i class="fa fa-tag"></i>
                    <span class="headline" style="font-size: 10.5px">Komponen Terverifikasi</span>
                    <span class="value">12</span>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="main-box infographic-box colored green-bg">
                    <i class="fa fa-tags"></i>
                    <span class="headline" style="font-size: 9px">Penilaian</span>
                    <span class="value">45</span>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 col-12">
                <div class="main-box infographic-box colored purple-bg">
                    <i class="fa fa-credit-card"></i>
                    <span class="headline" style="font-size: 10.5px">Persentase Sekolah Bersih</span>
                    <span class="value">42</span>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="main-box clearfix profile-box-contact">
                <div class="main-box-body clearfix">
                    <div class="profile-box-header gray-bg clearfix" style="background-color: #3e5879 !important;">
                        @if(!is_null($user->img) && file_exists(public_path('images/user/' . $user->img)))
                        <img src="{{ asset('images/user/' . $user->img) }}" alt="Foto Profil" class="profile-img img-fluid">
                        @else
                        <img src="{{ asset('images/user/user.png') }}" alt="Default Foto" class="profile-img img-fluid">
                        @endif
                        <h2>{{$user->username}}</h2>
                        <div class="job-position">
                            {{$role->name}}
                        </div>
                        <ul class="contact-details">
                            <li>
                                <i class="fa fa-bank"></i> {{$sekolah->nama}} {{$sekolah->kabupaten_kota}}
                            </li>
                            <li>
                                <i class="fa fa-envelope"></i> {{$user->email}}
                            </li>
                            <li>
                                <i class="fa fa-map-marker"></i> {{$sekolah->alamat_jalan ? $sekolah->alamat_jalan : '-'}}
                            </li>
                            <li>
                                <i class="fa fa-user"></i> Kepala Sekolah : {{$sekolah->kepalasekolah ? $sekolah->kepalasekolah : '-'}}
                            </li>
                        </ul>
                    </div>
                    <div class="profile-box-footer clearfix">
                        <a href="#">
                            <span class="value">Baik</span>
                            <span class="label">Hasil Evaluasi Bulan ini</span>
                        </a>
                        <a href="#">
                            <span class="value">Baik</span>
                            <span class="label">Tingkat Kepatuhan Bulan Ini</span>
                        </a>
                        <a href="#">
                            <span class="value">Penghargaan</span>
                            <span class="label">Penilaian Sekolah Bersih</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-top: 40px">
            @foreach($icon as $i)
            <div class="col-lg-2 col-md-6 col-sm-6 col-12">
                <div class="main-box clearfix profile-box-contact" style="box-shadow: none; background-color: transparent; border: none;">
                    <div class="main-box-body clearfix" style="border: none;">
                        <div class="d-flex flex-column align-items-center justify-content-center text-center" style="padding-bottom: 30px">
                            <img src="{{ asset('images/icon/' . $i->gambar) }}" alt="" style="width: 80px; height: 80px; object-fit: cover;">
                            <a href="{{ route('sekolahbersih.create', $i->id) }}">
                                <h2 class="mb-0" style="font-size: 1.2rem; color: #3e5879;">{{ $i->singkatan }}</h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection

@section('js')
@endsection
