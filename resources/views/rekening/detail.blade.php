@extends('layouts/master')
@section('title','Rekening')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('rekening.index') }}"><i class="fa fa-list"></i> Data Rekening</a></span></li>
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
                        <a href="{{ route('rekening.index') }}" class="btn btn-success float-right">
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
                                    <td width="20%">Kode</td>
                                    <td width="1%">:</td>
                                    <td><b>{{$model->kode}}</b></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td><b>{{$model->nama}}</b></td>
                                </tr>
                                <tr>
                                    <td>Tahun</td>
                                    <td>:</td>
                                    <td><b>{{$model->tahun}}</b></td>
                                </tr>
                                <tr>
                                    <td>Deskripsi</td>
                                    <td>:</td>
                                    <td>{{$model->deskripsi}}</td>
                                </tr>
                            </table>


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
</div>


@endsection
