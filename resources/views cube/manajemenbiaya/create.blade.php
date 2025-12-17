@extends('layouts/master')
@section('title','Manajemen Biaya')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('biaya.index') }}"><i class="fa fa-list"></i> Data @yield('title')</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Tambah @yield('title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Tambah @yield('title')</h2>
                        <a href="{{ route('biaya.index') }}" class="btn btn-success float-right">
                            <i class="fa fa-list"></i> Data @yield('title')
                        </a>
                    </header>

                    <div class="main-box-body clearfix">
                        <i>Bagian Bertanda <span class="wajib"></span> wajib diisi</i><br/><br/>

                        @if ($message = Session::get('berhasil'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Berhasil </strong>Data @yield('title') Berhasil Di Tambah
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

                        <form role="form" method="POST" action="{{ route('biaya.simpan') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Jabatan <span class="wajib"></span></label>
                                    <select name="jabatan" id="jabatan" class="form-control select2" required>
                                        <option value="">== Pilih Jabatan ==</option>
                                        <option value="0">Semua Jabatan</option>
                                        @foreach ($golongan as $png)
                                        <option value="{{ $png->id }}" {{(old('pangkat') == $png->id?'selected':'')}}>{{$png->kode.' - '.$png->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Jenis Biaya <span class="wajib"></span></label>
                                    <select name="jenis_biaya" id="jenis_biaya" class="form-control select2" required>
                                        <option value="">== Pilih Jenis Biaya ==</option>
                                        @foreach ($jenisbiaya as $j)
                                        <option value="{{ $j->id }}" {{(old('jenis_biaya') == $j->id?'selected':'')}}>{{$j->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Deskripsi </label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"></textarea>
                                </div>
                                <div class="form-group col-6">
                                    <label>Status Wilayah Biaya <span class="wajib"></span></label>
                                    <select name="status_wilayah_biaya" id="status_wilayah_biaya" class="form-control select2" required>
                                        <option value="">== Pilih Status Wilayah Biaya==</option>
                                        @foreach ($statusbiaya as $s)
                                        <option value="{{ $s->id }}" {{(old('status_wilayah_biaya') == $s->id?'selected':'')}}>{{$s->nama}}</option>
                                        @endforeach
                                    </select>

                                    <label>Nominal <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Rp.</div>
                                        </div>
                                        <input type="text" class="form-control" id="nominal" name="nominal" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button class="btn btn-primary tambah" type="submit">Tambah</button>
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
<!--<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/select2/dist/css/select2.min.css">-->
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/cselect2/select2.min.css">
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css">
@endsection

@section('js')
<!--<script src="{{ asset('assets/themes') }}/components/select2/dist/js/select2.min.js"></script>-->
<script src="{{ asset('assets/themes') }}/components/cselect2/select2.min.js"></script>

<script src="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/ckeditor/ckeditor.js"></script>
<script src="{{ asset('assets/themes') }}/js/mask/jquery.mask.js"></script>
<script src="{{ asset('assets/themes') }}/js/mask/jquery.maskMoney.js"></script>

<script>
    $('#nominal').mask("#.##0", {reverse: true});
</script>
@endsection
