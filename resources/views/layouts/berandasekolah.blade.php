@extends('layouts/master')
@section('title', 'Dashboard')
@section('css')
    <style>
        .row.grid-equal-height {
            display: grid;
            grid-auto-rows: 1fr;
        }

        .row.grid-equal-height>[class*='col-'] {
            display: flex;
        }

        .main-box {
            background: #FFFFFF;
            box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.1);
            margin-bottom: 16px;
            /* overflow: hidden; */
            border-radius: 3px;
        }

        .profile-box-contact .main-box-body {
            padding: 0;
        }

        .profile-box-contact .profile-box-header {
            padding: 15px 15px;
            color: #fff;
            border-radius: 3px 3px 0 0;
        }

        /* .profile-box-contact .profile-box-footer {
        padding-top: 10px;
        padding-bottom: 15px;
    } */

        .profile-box-contact .profile-box-footer a {
            display: block;
            width: 33%;
            width: 33.33%;
            float: left;
            text-align: center;
            padding: 15px 10px;
            color: #212121;
            text-decoration: none;
        }

        .profile-box-contact .profile-box-footer .value {
            display: block;
            font-size: 1.8em;
            font-weight: 300;
        }

        .direct-chat-img {
            border-radius: 50%;
            float: left;
            height: 130px;
            width: 130px;
        }

        .col-md-1-5 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        @media (min-width: 768px) {
            .col-md-1-5 {
                flex: 0 0 auto;
                width: 12.5%;
                max-width: 12.5%;
            }
        }

        @media (min-width: 768px) {
            .col-md-5th {
                width: 20%;
                flex: 0 0 20%;
                max-width: 20%;
            }
        }

        @media (max-width: 767.98px) {
            .col-md-5th {
                width: 50%;
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
    </style>
@endsection
@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{count($icon)}} / 12</h3>
                            <p>Jlh Instrumen</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>{{$showInstrumenAlert}}<sup class="fs-5">%</sup></h3>
                            <p>On Review </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>33</h3>
                            <p>Penilaian</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Persentase SB</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="main-box clearfix profile-box-contact">
                <div class="main-box-body clearfix">
                    <div class="profile-box-header gray-bg clearfix" style="background-color: #3e5879 !important;">
                        <div class="row g-0 align-items-center">
                            <div class="col-md-1-5">
                                @if(!is_null($user->img) && file_exists(public_path('images/user/' . $user->img)))
                                    <img src="{{ asset('images/user/' . $user->img) }}" alt="Foto Profil"
                                        class="direct-chat-img">
                                @else
                                    <img src="{{ asset('images/user/user.png') }}" alt="Default Foto" class="direct-chat-img">
                                @endif
                            </div>
                            <div class="col-md-10"> <!-- kasih padding kecil manual -->
                                <h5 class="widget-user-username">{{$user->username}}</h5>
                                <h6 class="widget-user-desc"> {{$sekolah->nama}} {{$kab->nama_kabupaten}}</h6>

                                <ul class="contact-details list-unstyled" style="font-size: smaller;">
                                    <li>
                                        <i class="fa fa-envelope"></i> {{$user->email}}
                                    </li>
                                    <li>
                                        <i class="fa fa-map-marker"></i>
                                        {{$sekolah->alamat_jalan ? $sekolah->alamat_jalan : '-'}}
                                    </li>
                                    <li>
                                        <i class="fa fa-user"></i> Kepala Sekolah :
                                        {{$sekolah->kepalasekolah ? $sekolah->kepalasekolah : '-'}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                $totalIcon = count($icon);
            @endphp

            <div class="row" style="padding-top: 40px">
                @foreach($icon as $i)
                    @php
                        if ($totalIcon < 6) {
                            $colClass = 'col-lg-2 col-6'; // for 1–5 icons
                        } elseif (in_array($totalIcon, [7, 8])) {
                            $colClass = 'col-md-3 col-6'; // 4 per row
                        } elseif (in_array($totalIcon, [9, 10])) {
                            $colClass = 'col-md-5th'; // custom class for 5 per row
                        } elseif (in_array($totalIcon, [6, 11, 12])) {
                            $colClass = 'col-lg-2 col-md-6 col-sm-6 col-12'; // tighter layout
                        } else {
                            $colClass = 'col-md-3 col-6'; // fallback
                        }
                    @endphp

                    <div class="{{ $colClass }}">
                        <div class="main-box clearfix profile-box-contact"
                            style="box-shadow: none; background-color: transparent; border: none;">
                            <div class="main-box-body clearfix" style="border: none;">
                                <div class="d-flex flex-column align-items-center justify-content-center text-center"
                                    style="padding-bottom: 30px">
                                    <a href="{{ route('sekolahbersih.create', $i->id) }}" style="text-decoration: none;">
                                        <img src="{{ asset('images/icon/' . $i->gambar) }}" alt=""
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                        <h2 class="mb-0" style="font-size: 1.2rem; color: #3e5879; padding-top: 15px;">
                                            {{ $i->singkatan }}</h2>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


            <div class="modal fade" id="instrumenModal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="text-center">
                                <b>Selamat Datang di Aplikasi Sekolah Bersih!</b>
                                <p>Hai <b>{{$sekolah->nama}}</b>, senang menyambut Anda di platform ini.</p>
                                <p>Sebelum mulai menggunakan fitur-fitur yang tersedia, mohon untuk terlebih dahulu
                                    melengkapi data sekolah, khususnya:</p>
                            </div>
                            <ul>
                                <li>Nama Kepala Sekolah</li>
                                <li>Instrumen</li>
                            </ul>
                            <p>Harap periksa dan edit data sekolah untuk melanjutkan.</p>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('EditSekolah', $sekolah->id) }}" class="btn btn-primary">Edit Data Sekolah</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('js')
    @if ($showInstrumenAlert == 1)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = new bootstrap.Modal(document.getElementById('instrumenModal'));
                modal.show();
            });
        </script>
    @endif
@endsection