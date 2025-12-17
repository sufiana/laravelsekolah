@extends('layouts/master')
@section('title', 'Detail validasi Penilaian Sekolah Bersih')

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
    </style>
@endsection

@php
    $score = $model->nilai_kebersihan;
    $max = 4;
    $percentage = round(($score / $max) * 100);

    $scorekepatuhan = $model->nilai_kepatuhan;
    $percentagekepatuhan = round(($scorekepatuhan / $max) * 100);
@endphp

@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">@yield('title')</h3>
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
            <!-- Make sure the .row wraps both columns so the right column stays to the right -->
            <div class="row">
                <div class="col-md-9 col-12 mb-3">
                    <div class="card card-widget widget-user-2">
                        <div class="widget-user-header">
                            <div class="row align-items-center">
                                <h6 class="widget-user-username" style="padding-top: 10px; font-weight: bold;">
                                    {{$sekolah->nama}}
                                    {{ $kabupaten->nama_kabupaten }}
                                </h6>
                                <ul class="contact-details list-unstyled" style="font-size: 12px;">
                                    <li>
                                        <i class="fa fa-envelope-open-o"></i> NPSN : {{$sekolah->npsn}}
                                    </li>
                                    <li>
                                        <i class="fa fa-calendar"></i> Periode :
                                        {{date('d-M-Y', strtotime($model->periode_awal)) . ' s/d ' . date('d-M-Y', strtotime($model->periode_akhir))}}
                                    </li>
                                    <li>
                                        <i class="fa fa-calculator"></i> Score Kebersihan : {{$model->nilai_kebersihan}}
                                    </li>
                                    <li>
                                        <i class="fa fa-check-square"></i> Keterangan Kebersihan :
                                        {{$model->keterangan_kebersihan}}
                                    </li>
                                    <li>
                                        <i class="fa fa-calculator"></i> Score Kepatuhan : {{$model->nilai_kebersihan}}
                                    </li>
                                    <li>
                                        <i class="fa fa-check-square"></i> Keterangan Kepatuhan :
                                        {{$model->keterangan_kepatuhan}}
                                    </li>
                                    <li>
                                        <i class="fa fa-user"></i> Kepala Sekolah : {{$sekolah->kepalasekolah}}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="main-box-body clearfix">
                            <div class="row">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <td style="text-align: center; width: 2%;">No</td>
                                                <td width="30%">Instrumen</td>
                                                <td width="10%">Ket. Kebersihan</td>
                                                <td width="10%">Ket. Kepatuhan</td>
                                                <td width="5%">Dokumentasi</td>
                                            </tr>
                                        </thead>
                                        @php $no = 0; @endphp
                                        @foreach($child as $i)
                                            @php $no++; @endphp
                                            <tr>
                                                <td style="text-align: center">{{$no}}</td>
                                                <td>{{$i->nama}}</td>
                                                <td>
                                                    @if($i->keterangan_kebersihan == 'Sangat Bersih')
                                                        <span class="badge text-bg-success">Sangat Bersih</span>
                                                    @elseif($i->keterangan_kebersihan == 'Bersih')
                                                        <span class="badge text-bg-success">Bersih</span>
                                                    @elseif($i->keterangan_kebersihan == 'Cukup Bersih')
                                                        <span class="badge text-bg-warning">Cukup Bersih</span>
                                                    @else
                                                        <span class="badge text-bg-danger">Kurang Bersih</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($i->keterangan_kepatuhan == 'Patuh')
                                                        <span class="badge text-bg-success">Patuh</span>
                                                    @elseif($i->keterangan_kepatuhan == 'Cukup Patuh')
                                                        <span class="badge text-bg-warning">Cukup Patuh</span>
                                                    @elseif($i->keterangan_kepatuhan == null)
                                                        <span class="badge text-bg-warning">Belum di Verifikasi oleh Pengawas</span>
                                                    @else
                                                        <span class="badge text-bg-danger">Tidak Patuh</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($i->dokumentasi == 1)
                                                        <span
                                                            style="font-family: DejaVu Sans; font-size: 20px"">&#9745;</span> {{-- ☑ --}}
                                                    @else
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <span style="
                                                                font-family: DejaVu Sans; font-size: 20px">&#9744;</span> {{-- ☐ --}}
                                                            @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            Verifikasi Sekolah
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-3">Disusun Oleh</div>
                                                <div class="col-md-8">: {{ $disusunoleh }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Mengetahui</div>
                                                <div class="col-md-8">: {{ $mengetahui }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Tanggal Supervisi</div>
                                                <div class="col-md-8">:
                                                    @if($model->tanggal_supervisi_verifikasi != null)
                                                        {{ucfirst(\Carbon\Carbon::parse($model->tanggal_supervisi_verifikasi)->locale('id')->isoFormat('dddd, D MMMM Y'))}}
                                                    @else
                                                        -
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Verifikasi Pengawas
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-md-3">Verifikator Pengawas</div>
                                                <div class="col-md-8">: {{ $verifikatorpengawas }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">Tanggal Supervisi</div>
                                                <div class="col-md-8">:
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                            Verifikasi Cabdis
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

                <!-- Right column must be sibling of the left column inside the same .row -->
                <div class="col-md-3 col-12">
                    <div class="card card-primary mb-3">
                        <div class="card-header">
                            <h3 class="card-title">Grafik Kebersihan</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-wrapper">
                                <canvas id="progressChart" width="150" height="150"></canvas>
                                <div class="chart-text"><span style="font-size: 10px;">% Penilaian</span>
                                    <br />{{ $percentage }}%
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-primary mb-3">
                        <div class="card-header" style="background-color: #3e5879;">
                            <h3 class="card-title">Grafik Kepatuhan</h3>
                        </div>
                        <div class="card-body">
                            <div class="chart-wrapper">
                                @if($model->nilai_kepatuhan != null)
                                    <canvas id="progressChart1" width="150" height="150"></canvas>
                                    <div class="chart-text"><span style="font-size: 10px;">% Penilaian</span>
                                        <br />{{ $percentagekepatuhan }}%
                                    </div>
                                @else
                                    <span style="font-size: 14px; color: #ff0000;">
                                        Data Kepatuhan Belum Tersedia
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">LOG</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body" style="display: block;">
                            Time Created : {{date('d-M-Y H:i:s', strtotime($model->time_created))}}<br />
                            User Created : {{$model->user_created}}
                        </div>
                    </div>
                </div>
            </div> <!-- /.row -->
        </div> <!-- /.container-fluid -->
    </div> <!-- /.app-content -->
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('progressChart').getContext('2d');
            const ctx1 = document.getElementById('progressChart1').getContext('2d');

            const percentage = {{ $percentage }};
            const percentagekepatuhan = {{ $percentagekepatuhan }};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [percentage, 100 - percentage],
                        backgroundColor: ['#00aaff', '#eeeeee'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '80%',
                    responsive: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });

            new Chart(ctx1, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [percentagekepatuhan, 100 - percentagekepatuhan],
                        backgroundColor: ['#3e5879', '#eeeeee'],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: '80%',
                    responsive: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        });
    </script>
@endsection