@extends('layouts/master')
@section('title','Pegawai')

@section('content')
<style>
    .huruf{font-size: 14px}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('pegawai.index') }}"><i class="fa fa-list"></i> Data @yield('title')</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Lihat Data @yield('title') #{{$model->id}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Data @yield('title') #{{$model->nama_pegawai}}</h2>
                        <a href="{{ route('pegawai.index') }}" class="btn btn-success float-right">
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
                            <table class="table user-list table-striped table-hover huruf">
                                <tr>
                                    <td width="20%">NIP</td>
                                    <td width="1%">:</td>
                                    <td style="font-size: 14px"><b>{{$model->nip}}</b></td>
                                </tr>
                                <tr>
                                    <td>No. Kartu Pegawai</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$model->no_kartu_pegawai}}</td>
                                </tr>
                                <tr>
                                    <td>Nama Pegawai</td>
                                    <td>:</td>
                                    <td style="font-size: 14px"><b>{{$model->nama_pegawai}}</b></td>
                                </tr>
                                <tr>
                                    <td>Unit Kerja</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$unitkerja->nama_cetak}}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$model->jenis_kelamin}}</td>
                                </tr>
                                <tr>
                                    <td>Tempat Lahir</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$model->tempat_lahir}}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Lahir</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{date('d-M-Y', strtotime($model->tanggal_lahir))}}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$model->alamat}}</td>
                                </tr>
                                <tr>
                                    <td>No. Telp/Whatsapp</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$model->no_telp_wa}}</td>
                                </tr>
                                <tr>
                                    <td>NPWP</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$model->no_npwp}}</td>
                                </tr>
                                <tr>
                                    <td>Agama</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$agama}}</td>
                                </tr>
                                <tr>
                                    <td>Pendidikan Terakhir</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$pendidikan}}</td>
                                </tr>
                                <tr>
                                    <td>Pangkat</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$pangkat}}</td>
                                </tr>
                                <tr>
                                    <td>Golongan</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$golongan}}</td>
                                </tr>
                                <tr>
                                    <td>Eselon</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$eselon}}</td>
                                </tr>
                                <tr>
                                    <td>Jabatan</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$jabatan}}</td>
                                </tr>
                                <tr>
                                    <td>Status Pegawai</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$statuspegawai}}</td>
                                </tr>
                                <tr>
                                    <td>Foto Pegawai</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">
                                        <a href="javascript:;" data-href="{{ asset('fotopegawai/upload/'.$model->foto) }}" title="Lihat Dokumen" class="lihatBerkas">
                                            <img alt="" src="{{ asset('fotopegawai/upload/'.$model->foto) }}" class="profile-img img-fluid mx-auto" width="20%">
                                        </a>
                                    </td>
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


<div class="modal fade " id="berkasModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src="" alt=""/>
        </div>
    </div>
</div>

@endsection

@section('js')

<script>
    $(".lihatBerkas").click(function(){
        var href = $(this).data("href");
        $("#berkasModal img").attr("src",href );
        $("#berkasModal").modal("show");
    })


</script>
@endsection
