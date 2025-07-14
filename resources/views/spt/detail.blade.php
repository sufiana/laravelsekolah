@extends('layouts/master')
@section('title','SPT')

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
                    <li><span><a href="{{ route('spt.index') }}"><i class="fa fa-list"></i> Data @yield('title')</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Lihat Data @yield('title') #{{$model->id}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Data @yield('title') #{{$model->no_spt}}</h2>
                        <a href="{{ route('spt.cetak',$model->id) }}" class="btn btn-success float-right" style="background-color: #1abc9c; color: white; margin-left: 10px">
                            <i class="fa fa-list"></i> Cetak @yield('title')
                        </a>
                        <a href="{{ route('spt.create') }}" class="btn btn-success float-right" style="margin-left: 10px">
                            <i class="fa fa-list"></i> Tambah @yield('title')
                        </a>
                        <a href="{{ route('spt.index') }}" class="btn btn-info float-right">
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
                                    <td width="20%">No. SPT</td>
                                    <td width="1%">:</td>
                                    <td style="font-size: 14px"><b>{{$model->no_spt}}</b></td>
                                </tr>
                                <tr>
                                    <td>No. Urut</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{{$model->no_urut}}</td>
                                </tr>
                                <tr>
                                    <td>Dasar</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">
                                        @php
                                        echo str_replace(
                                            array('<p>','</p>',';'),
                                            array('','',''),
                                            $model->dasar
                                        );
                                        @endphp
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pegawai</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">


                                        <table width="90%" class="table table-bordered">
                                            <tr>
                                                <td width="5%">No</td>
                                                <td width="33%">NIP</td>
                                                <td width="28%">Nama</td>
                                                <td width="34%">Jabatan</td>
                                            </tr>
                                            @php
                                            $categoryIdString = $model->pegawai;
                                            $categoryIds = explode(',', $categoryIdString);
                                            if($categoryIdString <> NULL)
                                            {
                                            $articles = App\Models\Pegawai::select("*")
                                            ->whereIn('id', $categoryIds)
                                            ->orderByRaw('FIELD(id, '.implode(", " , $categoryIds).')')
                                            ->get();
                                            }
                                            else
                                            {
                                            $articles = App\Models\Pegawai::select("*")
                                            ->where('id','=','0')
                                            ->get();
                                            }
                                            $cetak=array();
                                            $no=1;

                                            foreach($articles as $pegawai)
                                            {
                                            @endphp
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$pegawai->nip}}</td>
                                                <td>{{$pegawai->nama_pegawai}}</td>
                                                <td>
                                                    @php
                                                        $jabatanpeg=App\Models\RefJabatan::find($pegawai->id_jabatan);
                                                        if($jabatanpeg <> NULL)
                                                        echo $jabatanpeg->nama;
                                                        else
                                                        echo '-';
                                                    @endphp
                                                </td>
                                            </tr>
                                            @php
                                            }
                                            @endphp
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%">Rincian Sub Kegiatan</td>
                                    <td width="1%">:</td>
                                    <td style="font-size: 14px">
                                        <ul>
                                            <li>
                                                {{$model->program ? $model->programlist["kode"].' - '.$model->programlist["nama"].' ('.$model->programlist["tahun"].')' : ' - '}}
                                                <ul>
                                                    <li>
                                                        {{$model->kegiatan ? $model->kegiatanlist["kode"].' - '.$model->kegiatanlist["nama"] : ' - '}}
                                                        <ul>
                                                            <li>{{$model->subkegiatan ? $model->subkegiatanlist["kode"].' - '.$model->subkegiatanlist["nama"] : ' - '}}</li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Untuk</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">{!!$model->untuk!!}</td>
                                </tr>

                                <tr>
                                    <td>Tanggal Keberangkatan</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">
                                        @php
                                        $a=date('d-M-Y', strtotime($model->tanggal_berangkat));
                                        $b=date('d-M-Y', strtotime($model->tanggal_kembali));
                                        echo $a.' s/d '.$b;
                                        @endphp
                                    </td>
                                </tr>

                                <tr>
                                    <td>Lama (Hari)</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">
                                        {{$model->lama}} Hari
                                    </td>
                                </tr>

                                <tr>
                                    <td>Tanggal SPT</td>
                                    <td>:</td>
                                    <td style="font-size: 14px">
                                        {{date('d-M-Y', strtotime($model->tgl_spt))}}
                                    </td>
                                </tr>

                                <tr>
                                    <td>Pejabat Pemberi Perintah</td>
                                    <td>:</td>
                                    <td style="font-size: 14px"><b>
                                       @php
                                            echo $pejabatttd;
                                       @endphp
                                        </b>

                                    </td>
                                </tr>

                                <tr>
                                    <td>Status Verifikasi SPT</td>
                                    <td>:</td>
                                    <td style="font-size: 14px"><b>
                                            @php
                                                if ($model->status == "0"){
                                                    $badge = '<span class="badge badge-success">SPT</span>';
                                                }
                                                else if ($model->status == "2"){
                                                    $badge = '<span class="badge badge-danger">Verifikasi Di tolak</span>';
                                                }
                                                else {
                                                    $badge = '<span class="badge badge-warning">Belum Terverifikasi</i></span>';
                                                }

                                                echo $badge;
                                            @endphp
                                        </b>

                                    </td>
                                </tr>

                                @if($model->status == "2")
                                    <tr>
                                        <td>Alasan Verifikasi</td>
                                        <td>:</td>
                                        <td style="font-size: 14px"><b>{{$model->alasan_penolakan}}</b></td>
                                    </tr>
                                @endif
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
