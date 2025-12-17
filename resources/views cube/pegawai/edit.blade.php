@extends('layouts/master')
@section('title','Pegawai')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('pegawai.index') }}"><i class="fa fa-list"></i> Data SPT</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Tambah Pegawai</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Tambah @yield('title')</h2>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-success float-right">
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

                        <form role="form" method="POST" action="{{ route('pegawai.update') }}"  enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{$model->id}}" id="id" name="id">

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>NIP<span class="wajib"></span></label>
                                    <input type="text" name="nip" id="nip" class="form-control" placeholder="NIP @yield('title')" value="{{old('nip',$model->nip)}}" required>

                                </div>
                                <div class="form-group col-6">
                                    <label>No. Kartu Pegawai</label>
                                    <input type="text" name="no_kartu_pegawai" id="no_kartu_pegawai" placeholder="No. Kartu @yield('title')" class="form-control" value="{{old('no_kartu_pegawai',$model->no_kartu_pegawai)}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Nama Pegawai <span class="wajib"></span></label>
                                    <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" placeholder="Nama @yield('title')" required value="{{old('nama_pegawai',$model->nama_pegawai)}}">

                                </div>
                                <div class="form-group col-6">
                                    <label>Jenis Kelamin <span class="wajib"></span></label>
                                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                        <option value="">== Pilih Jenis Kelamin ==</option>
                                        <option value="Laki-laki" {{$model->jenis_kelamin=="Laki-laki" ?'selected':'' }}>Laki-laki</option>
                                        <option value="Perempuan" {{$model->jenis_kelamin=="Perempuan" ?'selected':'' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Tempat Lahir <span class="wajib"></span></label>
                                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required value="{{old('tempat_lahir',$model->tempat_lahir)}}">
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal Lahir <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" id="tanggal_lahir" name="tanggal_lahir" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date" required value="{{old('tanggal_lahir',date('d-M-Y', strtotime($model->tanggal_lahir)))}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Alamat <span class="wajib"></span></label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="4" required>{{old('alamat',$model->alamat)}}</textarea>
                                </div>
                                <div class="form-group col-6">
                                    <label>No Telp Whatsapp <span class="wajib"></span></label>
                                    <input type="text" name="no_telp_wa" id="no_telp_wa" class="form-control" placeholder="No Telp Whatsapp" required value="{{old('no_telp_wa',$model->no_telp_wa)}}">

                                    <label>No NPWP</label>
                                    <input type="text" name="no_npwp" id="no_npwp" class="form-control" placeholder="NPWP" value="{{old('no_npwp',$model->no_npwp)}}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Agama</label>
                                    <select name="agama" id="agama" class="form-control select2">
                                        <option value="">== Pilih Agama ==</option>
                                        @foreach ($agama as $ag)
                                        <option value="{{ $ag->id }}" {{(old('agama',$model->agama) == $ag->id?'selected':'')}}>{{$ag->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Pendidikan Terakhir</label>
                                    <select name="pendidikan_terakhir" id="pendidikan_terakhir" class="form-control select2">
                                        <option value="">== Pilih Pendidikan Terakhir==</option>
                                        @foreach ($pendidikan as $pend)
                                        <option value="{{ $pend->id }}" {{(old('pendidikan_terakhir',$model->pendidikan_terakhir) == $pend->id?'selected':'')}}>{{$pend->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Pangkat <span class="wajib"></span></label>
                                    <select name="pangkat" id="pangkat" class="form-control select2" required>
                                        <option value="">== Pilih Pangkat ==</option>
                                        @foreach ($pangkat as $png)
                                        <option value="{{ $png->id }}" {{(old('pangkat',$model->pangkat) == $png->id?'selected':'')}}>{{$png->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Golongan  <span class="wajib"></span></label>
                                    <select name="golongan" id="golongan" class="form-control select2" required>
                                        <option value="">== Pilih Golongan ==</option>
                                        @foreach ($golongan as $gol)
                                        <option value="{{ $gol->id }}" {{(old('golongan',$model->golongan) == $gol->id?'selected':'')}}>{{$gol->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Eselon <span class="wajib"></span></label>
                                    <select name="id_eselon" id="id_eselon" class="form-control select2" required>
                                        <option value="">== Pilih Eselon ==</option>
                                        @foreach ($eselon as $es)
                                        <option value="{{ $es->id }}" {{(old('id_eselon',$model->id_eselon) == $es->id?'selected':'')}}>{{$es->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Jabatan  <span class="wajib"></span></label>
                                    <select name="id_jabatan" id="id_jabatan" class="form-control select2" required>
                                        <option value="">== Pilih Jabatan ==</option>
                                        @foreach ($jabatan as $jab)
                                        <option value="{{ $jab->id }}" {{(old('id_jabatan',$model->id_jabatan) == $jab->id?'selected':'')}}>{{$jab->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Status Pegawai <span class="wajib"></span></label>
                                    <select name="status_pegawai" id="status_pegawai" class="form-control select2" required>
                                        <option value="">== Pilih Status Pegawai ==</option>
                                        @foreach ($statuspegawai as $sp)
                                        <option value="{{ $sp->id }}" {{(old('status_pegawai',$model->status_pegawai) == $sp->id?'selected':'')}}>{{$sp->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-4">
                                    <label>Foto Pegawai</label>
                                    <input type="file" id="foto" name="foto" accept="image/*" class="form-control">
                                </div>
                                <div class="form-group col-2">
                                    @if($model->foto <> NULL)
                                        <img id="preview_foto" style="max-height: 90px; width: 46%;" class="attachment-img" src="{{ asset('fotopegawai/upload/'.$model->foto) }}">
                                    @else
                                        Tidak Ada Foto
                                    @endif
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
<!--<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/select2/dist/css/select2.min.css">-->
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/cselect2/select2.min.css">
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css">
@endsection

@section('js')
<!--<script src="{{ asset('assets/themes') }}/components/select2/dist/js/select2.min.js"></script>-->
<script src="{{ asset('assets/themes') }}/components/cselect2/select2.min.js"></script>

<script src="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/ckeditor/ckeditor.js"></script>

<script>
    $(function($) {
        $('#tanggal_lahir').datepicker({
            format: 'dd-M-yyyy',
            autoclose: true
        });
    });

</script>
@endsection
