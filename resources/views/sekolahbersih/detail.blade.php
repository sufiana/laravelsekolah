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
                <h1>Lihat Data @yield('title') #{{$model->id}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Data @yield('title') #{{$model->nama}}</h2>
                        <a href="{{ route('biaya.create') }}" class="btn btn-primary float-right">
                            <i class="fa fa-list"></i> Tambah Data @yield('title')
                        </a>

                        <a href="{{ route('biaya.index') }}" class="btn btn-success float-right" style="margin-right:10px">
                            <i class="fa fa-list"></i> Data @yield('title')
                        </a>
                    </header>

                    <div class="main-box-body clearfix">
                        <div role="alert" id="success_message">
                            <!--                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">-->
                            <!--                                <span aria-hidden="true">×</span>-->
                            <!--                            </button>-->
                            <!--                            <i class="fa fa-check-circle fa-fw fa-lg"></i>-->
                            <!--                            <strong>Well done!</strong> You successfully read this important alert message.-->
                        </div>
                        <div class="table-responsive">
                            <table class="table user-list table-striped table-hover">
                                <tr>
                                    <td width="20%">Jabatan</td>
                                    <td width="1%">:</td>
                                    <td><b>{{!$model->Jabatanlist || !$model->jabatan ?  ' - ' : $model->Jabatanlist["kode"].' - '. $model->Jabatanlist["nama"]}}</b></td>
                                </tr>
                                <tr>
                                    <td width="20%">Jenis Biaya</td>
                                    <td width="1%">:</td>
                                    <td><b>{{!$model->Jenisbiayalist || !$model->jenis_biaya ?  ' - ' : $model->Jenisbiayalist["nama"]}}</b></td>
                                </tr>
                                <tr>
                                    <td width="20%">Status Wilayah Biaya Biaya</td>
                                    <td width="1%">:</td>
                                    <td><b>{{!$model->WilayahBiayalist || !$model->status_wilayah_biaya ?  ' - ' : $model->WilayahBiayalist["nama"]}}</b></td>
                                </tr>
                                <tr>
                                    <td width="20%">Nominal</td>
                                    <td width="1%">:</td>
                                    <td><b>Rp. {{number_format($model->nominal, 0, ",", ".")}}</b></td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td>:</td>
                                    <td><b>{{$model->deskripsi}}</b></td>
                                </tr>
                            </table>
                        </div>

                        <div id="accordions" class="card-accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseO" aria-expanded="false" aria-controls="collapseO">
                                            <i class="fa fa-cloud"></i> Lihat Rincian ( {{sizeof($rincian)}} Pegawai )
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseO" class="collapse" aria-labelledby="headingOne" data-parent="#accordions" style="">
                                    <div class="card-body">
                                        @if(sizeof($rincian) >=1)
                                        <table width="90%" class="table table-bordered">
                                            <tr>
                                                <td width="2%">No</td>
                                                <td width="10%">Jenis Biaya</td>
                                                <td width="20%">Jabatan</td>
                                                <td width="10%">NIP</td>
                                                <td width="20%">Nama</td>
                                                <td width="12%">Status Wilayah Biaya</td>
                                                <td width="10%">Deskripsi</td>
                                                <td width="3%">Nominal</td>
                                            </tr>
                                            @php $no=0;@endphp
                                            @foreach($rincian as $i)
                                            @php $no++; @endphp
                                            <tr>
                                                <td width="2%">{{$no}}</td>
                                                <td width="10%">{{!$model->Jenisbiayalist || !$model->jenis_biaya ?  ' - ' : $model->Jenisbiayalist["nama"]}}</td>
                                                <td width="10%">{{!$model->Jabatanlist || !$model->jabatan ?  ' - ' : $model->Jabatanlist["kode"].' - '. $model->Jabatanlist["nama"]}}</td>
                                                <td width="10%">{{$i->nip}}</td>
                                                <td width="20%">{{$i->nama_pegawai}}</td>
                                                <td width="10%">{{!$model->WilayahBiayalist || !$model->status_wilayah_biaya ?  ' - ' : $model->WilayahBiayalist["nama"]}}</td>
                                                <td width="10%">{{$model->deskripsi}}</td>
                                                <td width="10%" align="right">Rp. {{number_format($model->nominal, 0, ",", ".")}}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                        @else
                                            Tidak Terdapat Pegawai dengan Jabatan {{!$model->Jabatanlist || !$model->jabatan ?  ' - ' : $model->Jabatanlist["nama"]}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>



                            <div id="accordion" class="card-accordion">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <i class="fa fa-cloud"></i> Lihat LOG
                                            </button>
                                        </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-2">User Created</div>
                                                <div class="col-md-8">{{$model->user_created}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">Time Created</div>
                                                <div class="col-md-8">{{$model->created_at}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">User Update</div>
                                                <div class="col-md-8">{{$model->user_update}}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-2">Time Update</div>
                                                <div class="col-md-8">{{$model->updated_at}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
