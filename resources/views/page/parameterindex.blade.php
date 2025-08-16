@extends('layouts/master')
@section('title','Penilaian Area Strategis')
<style>
    .my-image {
    width: 150px;      /* sesuaikan ukuran kotak */
    height: 150px;     /* supaya kotak, buat width & height sama */
    border-radius: 0;  /* hilangkan border-radius yang bikin bulat */
    object-fit: cover; /* biar gambarnya pas memenuhi kotak */
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
        <div class="row">
            @foreach($model as $i)
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="main-box clearfix profile-box-contact">
                        <div class="main-box-body clearfix">
                            <div class="profile-box-header gray-bg clearfix" style="background-color: #3e5879 !important;">
                                <img src="{{ asset('images/icon/' . $i->gambar) }}">
                                <h2><b>{{$i->nama}}</b></h2>
                                <div class="job-position">
                                </div>
                                <ul class="contact-details">
                                    @php 
                                        $ulang = DB::table('parameter_kebersihan')
                                            ->select('*')
                                            ->where('id_ruang',$i->id_ruang)
                                            ->orderBy('id')
                                            ->get();
                                    @endphp
                                    @foreach($ulang as $x)
                                    <li>
                                        <i class="fa fa-check"></i> {{$x->parameter}}
                                    </li>
                                    @endforeach
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Jika jumlah card ganjil, tambahkan kolom kosong agar rapi -->
            @if($model->count() % 2 == 1)
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4"></div>
            @endif
        </div>
    </div>
</div>
@endsection