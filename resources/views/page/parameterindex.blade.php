@extends('layouts/master')
@section('title','Penilaian Area Strategis')
<style>
    .my-image {
    width: 150px;      /* sesuaikan ukuran kotak */
    height: 150px;     /* supaya kotak, buat width & height sama */
    border-radius: 0;  /* hilangkan border-radius yang bikin bulat */
    object-fit: cover; /* biar gambarnya pas memenuhi kotak */
}

    /* Warna header card */
    .profile-box-header {
        background-color: #3e5879 !important;
    }

    /* Gambar responsif */
    .img-wrap img {
        max-width: 100%;
        height: auto;
        display: block;
    }

    /* UL seragam: set tinggi tetap + scroll */
    .parameter-list {
        /* Ubah angka ini sesuai kebutuhan */
                         /* <-- Opsi A: seragam & scroll */
        overflow-y: auto;
        margin: 0;
        padding-left: 1rem;
    }

    /* Biar card sama tinggi di kolom (pakai flex) */
    .card-col {
        display: flex;
    }
    .profile-box-contact {
        width: 100%;
        display: flex;
        flex-direction: column;
    }
    .main-box-body {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
</style>

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

        @if($showInstrumenAlert)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Maaf!</strong> Sekolah ini belum memberikan informasi instrumen apa saja yang dimiliki.<br>
                Silahkan klik 
                    <a href="{{ route('EditSekolah', $sekolah->id) }}" class="alert-link">link ini</a>                untuk mengubah data/informasi instrumen yang dimiliki sekolah.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row g-3">         
            @foreach($model as $i)
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4 card-col">
                    <div class="card bg-light d-flex flex-fill">                
                        <div class="card-body pt-10">
                            <div class="row">
                                <div class="col-3 text-center">
                                    <img src="{{ asset('images/icon/' . $i->gambar) }}" alt="{{ $i->nama }}" class="img-circle img-fluid">
                                </div>
                                <div class="col-9">
                                    <h2 class="lead"><b>{{ $i->nama }}</b></h2>
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        @php
                                            $ulang = DB::table('parameter_kebersihan')
                                                ->where('id_ruang', $i->id_ruang)
                                                ->orderBy('id')
                                                ->get();
                                        @endphp
                                        @foreach($ulang as $x)
                                            <li class="small">
                                                <span class="fa-li"><i class="fa fa-check"></i></span> {{ $x->parameter }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                @php
                                    $verifikators = $verifikatorPerInstrumen[$i->id_ruang] ?? [];
                                @endphp

                                @if(count($verifikators))
                                    <b>Verifikator:</b>
                                        @foreach($verifikators as $v)
                                                {{ $v['nama'] }}
                                                {{-- @if($v['jabatan']) - Jabatan: {{ $v['jabatan'] }} @endif --}}
                                                {{-- @if($v['ttd'])<br><img src="{{ asset($v['ttd']) }}" alt="TTD {{ $v['nama'] }}" style="height:40px;">@endif --}}
                                        @endforeach
                                @else
                                    <span class="badge bg-secondary">Belum Ada Verifikator </span> <a href="{{ route('verifikator.create') }}">Klik disini untuk menambah user verifikator</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>



    
@endsection