@extends('layouts/master')
@section('title','Parameter Kebersihan')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('sekolahbersih.indexsekolah') }}"><i class="fa fa-list"></i> Data @yield('title')</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Edit @yield('title') {{$ruang->nama}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <div class="main-box-body clearfix">
                        @if ($message = Session::get('berhasil'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil </strong>Data @yield('title') Berhasil Di Edit
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>{{ $message }}</strong>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <form role="form" method="POST" action="{{ route('sekolahbersih.update') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{$model->id}}">
                            <div class="row" style="margin-top: 20px">
                                <div class="col-lg-8 col-sm-6 col-12">
                                    <div class="form-group">
                                        <h2 for="periode">Periode Kuesioner</h2>
                                        <input type="text" name="periode" class="form-control" id="daterange" />
                                    </div>

                                    <div id="parameterContainer">
                                        @php $no = 1; @endphp
                                        @foreach ($parameter as $p)
                                        
                                        
                                        <div class="row">
                                            <div class="col-lg-12"><h2>{{ $no++. '. ' . $p->parameter }}</h2></div>
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <div class="btn-group btn-group-toggle d-flex flex-wrap" data-toggle="buttons">
                                                            <label class="btn btn-warning btn-secondary">
                                                                <input type="radio" 
                                                                       name="jawaban[{{ $p->id }}]" 
                                                                       value="3" 
                                                                       autocomplete="off"
                                                                       onchange="handleJawabanChange({{ $p->id }}, this.value)"> Bersih
                                                            </label>
                                                            <label class="btn btn-warning btn-secondary">
                                                                <input type="radio" 
                                                                       name="jawaban[{{ $p->id }}]" 
                                                                       value="2" 
                                                                       autocomplete="off"
                                                                       onchange="handleJawabanChange({{ $p->id }}, this.value)"> Cukup Bersih
                                                            </label>
                                                            <label class="btn btn-warning btn-secondary">
                                                                <input type="radio" 
                                                                       name="jawaban[{{ $p->id }}]" 
                                                                       value="1" 
                                                                       autocomplete="off"
                                                                       onchange="handleJawabanChange({{ $p->id }}, this.value)"> Tidak Bersih
                                                            </label>
                                                                <!-- Hidden score -->
                                                            <input type="hidden" name="score[{{ $p->id }}]" id="score_{{ $p->id }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <input type="text" class="form-control" name="alasan[{{ $p->id }}]" id="alasan_{{ $p->id }}"  placeholder="Tuliskan alasan...">
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>


                                </div>
                                
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <!--<img alt="" src="{{ asset('images') }}/kuesioner3.png" width="100%" height="80%" />-->
                                    <div class="main-box clearfix project-box green-box">
                                    <div class="main-box-body clearfix">
                                    <div class="project-box-header green-bg">
                                    <div class="name">
                                    <a href="#">
                                    Captain America
                                    </a>
                                    </div>
                                    </div>
                                    <div class="project-box-content">
                                    <span class="chart" data-percent="86" data-bar-color="#2ecc71">
                                    <span class="percent">86</span>%<br>
                                    <span class="lbl">completed</span>
                                    <canvas height="162" width="162" style="height: 130px; width: 130px;"></canvas></span>
                                    </div>
                                    <div class="project-box-footer clearfix">
                                    <a href="#">
                                    <span class="value">93</span>
                                    <span class="label">Tasks</span>
                                    </a>
                                    <a href="#">
                                    <span class="value">3</span>
                                    <span class="label">Alerts</span>
                                    </a>
                                    <a href="#">
                                    <span class="value">483</span>
                                    <span class="label">Messages</span>
                                    </a>
                                    </div>
                                    <div class="project-box-ultrafooter clearfix">
                                    <img class="project-img-owner" alt="" src="img/samples/lima-300.jpg" data-toggle="tooltip" title="" data-original-title="Adriana Lima">
                                    <img class="project-img-owner" alt="" src="img/samples/robert-300.jpg" data-toggle="tooltip" title="" data-original-title="Robert Downey Jr.">
                                    <img class="project-img-owner" alt="" src="img/samples/angelina-300.jpg" data-toggle="tooltip" title="" data-original-title="Angelina Jolie">
                                    <a href="#" class="link float-right">
                                    <i class="fa fa-arrow-circle-right fa-lg"></i>
                                    </a>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                                

                            <div class="form-group text-center">
                                <button class="btn btn-primary tambah" type="submit">Simpan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> 
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script>
function handleJawabanChange(paramId, value) {
    let alasanField = document.getElementById("alasan_" + paramId);
    let scoreField  = document.getElementById("score_" + paramId);

    // set hidden score
    scoreField.value = value;

    // kalau cukup bersih (2) atau tidak bersih (1) → wajib alasan
    if (value == "2" || value == "1") {
        alasanField.style.display = "block";
        alasanField.setAttribute("required", "required");
    } else {
        alasanField.style.display = "none";
        alasanField.removeAttribute("required");
        alasanField.value = ""; // reset
    }
}
</script>
@endsection
