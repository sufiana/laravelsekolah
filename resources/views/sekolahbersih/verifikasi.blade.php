@extends('layouts/master')
@section('title', 'Verifikasi Penilaian Sekolah Bersih')

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

  {{-- Hitung persentase --}}
  @php
    $score = $model->score;
    $max = $maxinstrumen;
    $percentage = round(($score / $max) * 100);
  @endphp

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-9 col-12 mb-3">
          <div class="card card-widget widget-user-2">
            <div class="widget-user-header">
              <div class="row align-items-center">
                <h6 class="widget-user-username" style="padding-top: 10px; font-weight: bold;">{{$sekolah->nama}}
                  {{ $kabupaten->nama_kabupaten }}
                </h6>
                <ul class="contact-details list-unstyled" style="font-size: 12px;">
                  <li>
                    <i class="fa fa-envelope-open-o"></i> Instrumen Penilaian
                    {{!$model->ruanglist || !$model->id_ruang ? ' - ' : $model->ruanglist["nama"]}}
                  </li>
                  <li>
                    <i class="fa fa-calendar"></i> Periode
                    {{date('d-M-Y', strtotime($model->periode_awal_kuesioner)) . ' s/d ' . date('d-M-Y', strtotime($model->periode_akhir_kuesioner))}}
                  </li>
                  <li>
                    <i class="fa fa-calculator"></i> Score {{$model->score}}
                  </li>
                  <li>
                    <i class="fa fa-percent"></i> Presentase {{$percentage}}%
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
                        <td width="15%">Instrumen</td>
                        <td width="10%">Jawaban</td>
                        <td width="10%">Alasan</td>
                      </tr>
                    </thead>
                    @php $no = 0; @endphp
                    @foreach($hasilKuesioner as $i)
                      @php $no++; @endphp
                      <tr>
                        <td style="text-align: center">{{$no}}</td>
                        <td>{{$i->parameter}}</td>
                        <td>
                          @if($i->jawaban == 3)
                            <span class="badge text-bg-success">Bersih</span>
                          @elseif($i->jawaban == 4)
                            <span class="badge text-bg-success">Sangat Bersih</span>
                          @elseif($i->jawaban == 2)
                            <span class="badge text-bg-warning">Cukup Bersih</span>
                          @else
                            <span class="badge text-bg-danger">Tidak Bersih</span>
                          @endif
                        </td>
                        <td>{{$i->deskripsi_jawaban}}</td>
                      </tr>
                    @endforeach
                  </table>
                </div>
              </div>
            </div>

            <div class="main-box-body clearfix" style="padding: 20px">
              <form method="POST" action="{{ route('sekolahbersih.saveVerifikasi') }}" id="form-penilaian">
                @csrf
                <input type="hidden" name="id" value="{{ $model->id }}">
                <input type="hidden" name="back" value="{{ request('back') }}">


                <div class="form-group row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">User Verifikator <span
                      class="wajib"></span></label>
                  <div class="col-sm-10">
                    {{-- <input type="text" class="form-control" id="user_verifikasi" name="user_verifikasi" required>
                    --}}
                    @if($verifikator && count($verifikator) > 0)
                      <select name="user_verifikasi" id="user_verifikasi" class="form-control form-select">
                        @foreach($verifikator as $i)
                          <option value="{{ $i->id }}" {{ old('user_verifikasi') == $i->id ? 'selected' : '' }}>
                            {{ $i->verifikator . ' - jabatan ' . $i->jabatan }}
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

                <div class="form-group row mb-3">
                  <label for="inputEmail3" class="col-sm-2 col-form-label">Guru Piket <span class="wajib"></span></label>
                  <div class="col-sm-10">
                    @if($verifikator && count($verifikator) > 0)
                      <select name="user_verifikasi_guru_piket" id="user_verifikasi_guru_piket"
                        class="form-control form-select">
                        @foreach($verifikator as $i)
                          <option value="{{ $i->id }}" {{ old('user_verifikasi_guru_piket') == $i->id ? 'selected' : '' }}>
                            {{ $i->verifikator . ' - jabatan ' . $i->jabatan }}
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

                <div class="form-group text-center">
                  <button class="btn btn-primary tambah" type="submit">Verifikasi</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card card-primary mb-3">
            <div class="card-header">
              <h3 class="card-title">Grafik</h3>
            </div>
            <div class="card-body">
              <div class="card-body">
                <div class="chart-wrapper">
                  <canvas id="progressChart" width="150" height="150"></canvas>
                  <div class="chart-text"><span style="font-size: 10px;">% Penilaian</span> <br />{{ $percentage }}%</div>
                </div>
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
      </div>
    </div>
  </div>
@endsection
@section('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('progressChart').getContext('2d');
      const percentage = {{ $percentage }};

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
    });
  </script>
@endsection