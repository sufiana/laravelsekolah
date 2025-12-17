@extends('layouts/master')
@section('title', 'Validasi')

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
    <div class="alert alert-danger" role="alert">
      @foreach ($hasil as $y)
        @php
          $urlcreate = route("sekolahbersih.create", $y->id_ruang);
          $urlcreate = route("sekolahbersih.create", $y->id_ruang) . "?back=" . urlencode(url()->current());

          $urlverify = $y->id
            ? route("sekolahbersih.verifikasi", $y->id) . "?back=" . urlencode(url()->current())
            : '#';                   
        @endphp
        @if($y->status == 'Sudah isi' and $y->verifikasi == 'Belum Verifikasi')
          {{ $y->nama }} : {{ $y->verifikasi }} <a href='{{$urlverify  }}'>Silahkan Verifikasi</a><br />
        @else
          {{ $y->nama }} : {{ $y->status }} <a href='{{ $urlcreate }}'>Silahkan isi penilaian instrumen</a><br />
        @endif

      @endforeach
    </div>
  </div>
  </div>

@endsection