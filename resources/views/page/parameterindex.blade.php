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
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Data @yield('title')</h1>
            </div>
        </div>

        <!-- Row untuk grid card -->
        <div class="row g-3">
            @foreach($model as $i)
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4 card-col">
                    <div class="main-box clearfix profile-box-contact">
                        <div class="main-box-body clearfix">
                            <div class="profile-box-header gray-bg clearfix">
                                <div class="row">
                                    <!-- Kiri: Gambar (col-md-4) -->
                                    <div class="col-md-4 col-sm-4 col-4 img-wrap text-center py-3">
                                        <img src="{{ asset('images/icon/' . $i->gambar) }}" alt="{{ $i->nama }}" class="img-fluid">
                                    </div>

                                    <!-- Kanan: Judul + UL (sisa kolom = 8) -->
                                    <div class="col-md-8 col-sm-8 col-8 d-flex flex-column py-3">
                                        <h2 class="mb-2 text-white"><b>{{ $i->nama }}</b></h2>

                                        <ul class="contact-details parameter-list">
                                            @php
                                                $ulang = DB::table('parameter_kebersihan')
                                                    ->where('id_ruang', $i->id_ruang)
                                                    ->orderBy('id')
                                                    ->get();
                                            @endphp
                                            @foreach($ulang as $x)
                                                <li class="text-white">
                                                    <i class="fa fa-check"></i> {{ $x->parameter }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div> <!-- /.row -->
                            </div> <!-- /.profile-box-header -->
                        </div> <!-- /.main-box-body -->
                    </div> <!-- /.profile-box-contact -->
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection