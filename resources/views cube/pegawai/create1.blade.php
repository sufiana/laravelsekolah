@extends('layouts/master')
@section('title','SPT')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><span><a href="{{ route('spt.index') }}"><i class="fa fa-list"></i> Data SPT</a></span></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Tambah SPT</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Tambah @yield('title') (Surat Perintah Tugas)</h2>
                        <a href="{{ route('spt.index') }}" class="btn btn-success float-right">
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

                        @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error! </strong>Data @yield('title') Gagal Di Tambah
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif


                        <form role="form" method="POST" action="{{ route('spt.simpan') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Pilih Pegawai <span class="wajib"></span></label>
                                        <select name="pegawai[]" id="pegawai" multiple="" tabindex="-1" class="form-control select2" aria-hidden="true" rows="5">
                                            <option value="">== Pilih Pegawai ==</option>
                                            @foreach ($pegawai as $k)
                                            <option value="{{$k->id_pegawai}}" {{(old('pegawai') == $k->id_pegawai?'selected':'')}}>{{$k->nip.' - '.$k->nama_pegawai}}</option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Luar Kabupaten Deli Serdang <span class="wajib"></label>
                                </div>

                                <div class="float-left">
                                    <div class="onoffswitch onoffswitch-success">
                                        <input type="checkbox" name="myonoffswitch4" class="onoffswitch-checkbox" id="myonoffswitch4" value="1"  onchange="aktiffunc()">
                                        <label class="onoffswitch-label" for="myonoffswitch4">
                                            <div class="onoffswitch-inner"></div>
                                            <div class="onoffswitch-switch"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>


                            <div id="lokasi" style="display: none">
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label>Provinsi Tujuan</label>
                                        <select name="provinsi" id="provinsi" class="form-control select2">
                                            <option value="">== Pilih Provinsi ==</option>
                                            @foreach ($provinsi as $p)
                                            <option value="{{ $p->id }}" {{(old('provinsi') == $p->id?'selected':'')}}>{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label>Kabupaten / Kota</label>
                                        <select name="kabupaten" id="kabupaten" class="form-control select2">
                                            <option value="">== Pilih Kabupaten / Kota ==</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Kecamatan</label>
                                    <select name="kecamatan" id="kecamatan" class="form-control select2">
                                        <option value="">== Pilih Kecamatan ==</option>
                                        @foreach ($kecamatands as $kcds)
                                        <option value="{{ $kcds->id }}" {{(old('kecamatan') == $kcds->id?'selected':'')}}>{{ $kcds->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <label>Kelurahan</label>
                                    <select name="kelurahan" id="kelurahan" class="form-control select2">
                                        <option value="">== Pilih Kelurahan ==</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Instansi <span class="wajib"></label>
                                    <textarea class="form-control" id="instansi" name="instansi" rows="5"></textarea>
                                </div>

                                <div class="form-group col-6">
                                    <label>Kegiatan <span class="wajib"></label>
                                    <select name="kegiatan" id="kegiatan" class="form-control select2">
                                        <option value="">== Pilih kegiatan ==</option>
                                        @foreach ($kegiatan as $keg)
                                        <option value="{{ $keg->id }}" {{(old('kegiatan') == $keg->id?'selected':'')}}>{{ $keg->kode.' - '.$keg->nama }}</option>
                                        @endforeach
                                    </select>

                                    <label>Jenis Kendaraan <span class="wajib"></label>
                                    <select name="jenis_kendaraan" id="jenis_kendaraan" class="form-control select2">
                                        <option value="">== Pilih Jenis Angkutan ==</option>
                                        @foreach ($angkutan as $ang)
                                        <option value="{{ $ang->id }}" {{(old('jenis_angkutan') == $ang->id?'selected':'')}}>{{ $ang->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>



                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Dasar <span class="wajib"></label>
                                    <textarea class="form-control" id="dasar" name="dasar" rows="3"></textarea>
                                </div>
                                <div class="form-group col-6">
                                    <label>Maksud <span class="wajib"></label>
                                    <textarea class="form-control" id="maksud" name="maksud" rows="3"></textarea>
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-3">
                                    <label>Tanggal Keberangkatan <span class="wajib"></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" id="tanggal_berangkat" name="tanggal_berangkat" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date">
                                    </div>
                                </div>

                                <div class="form-group col-3">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">s.d</div>
                                        </div>
                                        <input type="text" id="tanggal_kembali" name="tanggal_kembali" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date" onchange="days()">

                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Lama <span class="wajib"></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="lama" name="lama" onclick="days()">
                                        <div class="input-group-append">
                                            <div class="input-group-text">Hari</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Tanggal SPT <span class="wajib"></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" id="tgl_spt" name="tgl_spt" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date">
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Pejabat Pemberi Perintah <span class="wajib"></label>
                                    <select name="pejabat_pemberi_perintah" id="pejabat_pemberi_perintah" tabindex="-1" class="form-control select2" aria-hidden="true">
                                        <option value="">== Pilih Pejabat Pemberi Perintah ==</option>
                                        @foreach ($pegawai as $k)
                                        <option value="{{$k->id_pegawai}}" {{(old('pegawai') == $k->id_pegawai?'selected':'')}}>{{$k->nip.' - '.$k->nama_pegawai}}</option>
                                        @endforeach
                                    </select>
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
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css">
@endsection

@section('js')
<script src="{{ asset('assets/themes') }}/components/select2/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<script>
    $(function($) {
        $('#pegawai').select2({
            placeholder: 'Pilih Anggota Pegawai',
            allowClear: true
        });

        $('#pejabat_pemberi_perintah').select2({
            placeholder: 'Pilih Nama Pemberi Perintah ',
            allowClear: true
        });

        $('#tanggal_berangkat').datepicker({
            format: 'dd-M-yyyy',
            autoclose: true
        });

        $('#tanggal_kembali').datepicker({
            format: 'dd-M-yyyy',
            autoclose: true
        });

        $('#tgl_spt').datepicker({
            format: 'dd-M-yyyy',
            autoclose: true
        });

    });


    function aktiffunc() {
        var checkBoxValue = $('#myonoffswitch4').is(':checked')?1:0;
        $('#myonoffswitch4').val(checkBoxValue);

        var x=document.getElementById("myonoffswitch4").value;
        var a = document.getElementById("provinsi");
        var b = document.getElementById("kabupaten");
        // var c = document.getElementById("kecamatan");
        // var d = document.getElementById("kelurahan");
        //alert(x);
        if(x=="0")
        {
            $("#lokasi").show();
            a.required = true;
            b.required = true;
            // c.required = true;
            // d.required = true;
        }
        else
        {
            $("#lokasi").hide();
            a.required = false;
            b.required = false;
            // c.required = false;
            // d.required = false;

            a.val(12);
            b.val(1212);
            // c.val(1212);
            // d.val(1212);
        }
    }



    jQuery(document).ready(function ()
    {
        jQuery('select[name="provinsi"]').on('change',function(){
            var countryID = jQuery(this).val();
            if(countryID)
            {
                jQuery.ajax({
                    url : 'getKabupatenkota/' +countryID,
                    type : "GET",
                    dataType : "json",
                    success:function(data)
                    {
                        console.log(data);
                        jQuery('select[name="kabupaten"]').empty();
                        jQuery.each(data, function(key,value){
                            $('select[name="kabupaten"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }
            else
            {
                $('select[name="kabupaten"]').width('300px');
            }
        });

        <!-- pilih kecamatan -->

        jQuery('select[name="kabupaten"]').on('change',function(){
            var id_kab = jQuery(this).val();
            if(id_kab)
            {
                jQuery.ajax({
                    url : 'getKecamatan/' +id_kab,
                    type : "GET",
                    dataType : "json",
                    success:function(data)
                    {
                        console.log(data);
                        jQuery('select[name="kecamatan"]').empty();
                        jQuery.each(data, function(key,value){
                            $('select[name="kecamatan"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }
            else
            {
                $('select[name="kecamatan"]').width('400px');
            }
        });

        <!-- pilih kelurahan -->

        jQuery('select[name="kecamatan"]').on('change',function(){
            var id_kec = jQuery(this).val();
            if(id_kec)
            {
                jQuery.ajax({
                    url : 'getKelurahan/' +id_kec,
                    type : "GET",
                    dataType : "json",
                    success:function(data)
                    {
                        console.log(data);
                        jQuery('select[name="kelurahan"]').empty();
                        jQuery.each(data, function(key,value){
                            $('select[name="kelurahan"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }
            else
            {
                $('select[name="kelurahan"]').empty();
            }
        });

        <!-- Pilih Kantor Berdasarkan Provinsi -->
        // jQuery('select[name="id_provinsi"]').on('change',function(){
        //     var id_prov = jQuery(this).val();
        //     if(id_prov)
        //     {
        //         jQuery.ajax({
        //             url : 'getKantor/' +id_prov,
        //             type : "GET",
        //             dataType : "json",
        //             success:function(data)
        //             {
        //                 console.log(data);
        //                 jQuery('select[name="uid_kantor"]').empty();
        //                 jQuery.each(data, function(key,value){
        //                     $('select[name="uid_kantor"]').append('<option value="'+ key +'">'+ value +'</option>');
        //                 });
        //             }
        //         });
        //     }
        //     else
        //     {
        //         $('select[name="uid_kantor"]').empty();
        //     }
        // });

    });

    function days() {
        var a = $("#tanggal_berangkat").datepicker('getDate').getTime(),
            b = $("#tanggal_kembali").datepicker('getDate').getTime(),
            c = 24*60*60*1000,


            //diffDays = Math.round(Math.abs((a - b)/(c)));
            //rumus jumlah hari pertama + 1
            diffDays = Math.round(Math.abs((a - b)/(c)))+1;
            if(b < a)
            {
                alert('maaf Tanggal Kembali Harus > Tanggal Keberangkatan');
                $("#lama").val(0);
            }
            else
            {
                $("#lama").val(diffDays);
            }

        //console.log(diffDays); //show difference
    }
    CKEDITOR.replace('dasar');
    CKEDITOR.replace('maksud');
</script>
@endsection
