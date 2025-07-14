@extends('layouts/master')
@section('title','Jenis Surat')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            @yield('title')
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('refjenissurat.index') }}">Lihat @yield('title')</a></li>
            <li class="active">@yield('title')</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-success ">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tambah Jenis Surat</h3>
                        <div class="box-tools pull-right">
<!--                            <button type="button" class="btn btn-box btn-info">Tambah</button>-->
                            <a href="#" data-href="#" data-toggle="modal" data-target="#createModal" class="btn btn-box btn-success"> <i class="glyphicon glyphicon-th-list"> Lihat </i></a>

                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('refklasifikasisurat.simpan') }}"  method="POST" id="add_form" class="form-horizontal">
                            @csrf
                            <div class="form-group">
                                <label for="jenissurat" class="col-sm-4 control-label">Nama Klasifikasi Surat <span class="wajib"></span> </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Jenis Surat">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="jenissurat" class="col-sm-4 control-label">kode Klasifikasi Surat <span class="wajib"></span> </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="kode" name="kode" placeholder="Nama Jenis Surat">
                                </div>
                            </div>

<!--                            <div class="form-group">-->
<!--                                <label for="kodejenissurat" class="col-sm-4 control-label">Kode Jenis <span class="wajib"></span> </label>-->
<!--                                <div class="col-sm-8">-->
<!--                                    <input type="text" class="form-control" id="kodejenis" placeholder="Kode Jenis Surat">-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="form-group">-->
<!--                                <label for="sistem_penomoran" class="col-sm-4 control-label">Sitem Penomoran <span class="wajib"></span> </label>-->
<!--                                <div class="col-sm-8">-->
<!--                                    <select class="form-control" id="status_penomoran">-->
<!--                                        <option>Pilih Sistem Penomoran</option>-->
<!--                                        <option value="1">Penomoran Terpusat</option>-->
<!--                                        <option value="1">Penomoran Perunit</option>-->
<!--                                        <option value="1">Penomoran Sistem</option>-->
<!--                                    </select>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="form-group">-->
<!--                                <label for="pembatasan" class="col-sm-4 control-label">Pembatasan Hak Akses </label>-->
<!--                                <div class="col-sm-8">-->
<!--                                    <div class="checkbox">-->
<!--                                        <label>-->
<!--                                            <input type="checkbox" value="1" id="batas">Batasi akses hanya untuk unit tertentu-->
<!--                                            <!--                                    <p class="help-block">Jika diaktifkan maka jenis hanya akan tampil pada unit yang terpilih saja</p>-->-->
<!--                                        </label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!---->
<!--                            <div class="form-group">-->
<!--                                <label for="aktif" class="col-sm-4 control-label">Status Aktif </label>-->
<!--                                <div class="col-sm-8">-->
<!--                                    <div class="checkbox">-->
<!--                                        <label>-->
<!--                                            <input type="checkbox" value="1" id="aktif">Aktif-->
<!--                                        </label>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->


                            <div class="form-group text-center">
                                <button type="button" class="btn btn-light my-2" data-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary" type="submit" id="simpan">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>


</div>


@endsection
