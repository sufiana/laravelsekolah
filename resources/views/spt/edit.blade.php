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
                <h1>Ubah SPT</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Ubah @yield('title') (Surat Perintah Tugas)</h2>
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


                        <form role="form" method="POST" action="{{ route('spt.update') }}">
                            @csrf
                            <input type="hidden" value="{{$model->id}}" id="id" name="id">

                            <?php
                                $formatnosurattabel=\App\models\FormatSurat::find(1);
                                if($model->no_spt <> NULL) {
                                    $nosurat = $model->no_spt;
                                    $nourut  = $model->no_urut;
                                }
                                else {
                                    $nosurat = $formatnosurattabel->digit_pertama . '/  /' . $formatnosurattabel->digit_berikutnya . '/' . date("Y");
                                    $nourut  = null;
                                }
                            ?>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Kode. SPT <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                        </div>
                                        <input type="number" class="form-control" id="kodespt" name="kodespt" value="{{$kode}}" required readonly >
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>No. SPT</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-primary" type="button" id="notset" onclick="kosongkan()">Not Set</button>
                                        </div>
                                        <input type="text" class="form-control" id="nospt" name="nospt" value="{{old('no_spt',$nosurat)}}" onfocusout="getnourut()" required>
                                        <input type="hidden" class="form-control" id="no_urut" name="no_urut" value="{{old('no_urut',$nourut)}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Tanggal SPT<span class="wajib"></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" id="tgl_spt" name="tgl_spt" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date" value="{{old('tgl_spt',date('d-M-Y', strtotime($model->tgl_spt)))}}" required>
                                    </div>
                                </div>

                                <div class="form-group col-6" id="anggaran">
                                    <label>Mata Anggaran<span class="wajib"></span></label>
                                    <select name="mata_anggaran" id="mata_anggaran" class="form-control select2" required style="z-index: -1">
                                        <option value="">== Pilih Anggaran ==</option>
                                        @foreach ($mataanggaran as $ma)
                                        <option value="{{ $ma->id }}" {{(old('mata_anggaran',$model->mata_anggaran) == $ma->id?'selected':'')}}>{{$ma->kode.' '.$ma->nama}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Program <span class="wajib"></span></label>
                                    <select name="program" id="program" class="form-control select2" required>
                                        <option value="">== Pilih Program ==</option>
                                        @foreach ($program as $prog)
                                        <option value="{{ $prog->id }}" {{(old('program',$model->program) == $prog->id?'selected':'')}}>{{ $prog->kode.' '.$prog->nama }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="kop" name="kop" value="{{$kop->nama_dinas_surat}}">
                                    <input type="hidden" id="kegiatanlama" name="kegiatanlama" value="{{$model->kegiatan}}">
                                    <input type="hidden" id="namaprogram" name="namaprogram">
                                    <input type="hidden" id="tahunprogram" name="tahunprogram">
                                </div>
                                <div class="form-group col-6">
                                    <label>Kegiatan <span class="wajib"></span></label>
                                    <select name="kegiatan" id="kegiatan" class="form-control select2" required>
                                        <option value="{{$model->subkegiatan}}">{{$ambilkegiatan->kode.' - '.$ambilkegiatan->nama}}</option>
                                    </select>
                                    <input type="hidden" id="namakegiatan" name="namakegiatan">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Sub Kegiatan <span class="wajib"></span></label>
                                    <select name="subkegiatan" id="subkegiatan" class="form-control select2" required>
                                        <option value="{{$model->subkegiatan}}">{{$ambilsubkegiatan->kode.' - '.$ambilsubkegiatan->nama}}</option>
                                    </select>
                                    <input type="hidden" id="namasubkegiatan" name="namasubkegiatan">
                                </div>

                                <div class="form-group col-6">
                                    <label>Jumlah Poin Dasar <span class="wajib"></span></label>
                                    <div class="input-group">
                                        @if($sptdasar)
                                            <input min="0" type="number" name="inputCount" id="inputCount" class="form-control" placeholder="Masukkan Jumlah Poin Dasar" value="{{$sptdasar->jumlah}}">
                                        @else
                                            <input min="0" type="number" name="inputCount" id="inputCount" class="form-control" placeholder="Masukkan Jumlah Poin Dasar">
                                        @endif
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" value="Make" id="ok" onclick="buatchilddasar()">Buat Poin</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="inputs" class="form-group row">

                            </div>


                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Pilih Pegawai Yang Diperintahkan <span class="wajib"></span></label>
                                    <select name="pegawai_ke1" id="pegawai_ke1" tabindex="-1" class="form-control select2 pegawai" aria-hidden="true" rows="5" required>
                                        <option value="">== Pilih Pegawai ==</option>
                                        @foreach ($pegawai as $k)
                                        <option value="{{$k->id}}" {{(old('pegawai',$model->pegawai_ke1) == $k->id?'selected':'')}}>{{$k->nip.' - '.$k->nama_pegawai}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Pilih Anggota Pegawai Lainnya <span class="wajib"></span></label>
                                    <select name="pegawai[]" id="pegawai" multiple="" tabindex="-1" class="form-control select2 pegawai" aria-hidden="true" rows="5" required>
                                        <option value="">== Pilih Pegawai ==</option>
                                        @foreach ($pegawai as $k)
                                        <option value="{{$k->id}}" {{(old('pegawai',$model->pegawai) == $k->id?'selected':'')}}>{{$k->nip.' - '.$k->nama_pegawai}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Untuk <span class="wajib"></span></label>
                                    <textarea class="form-control" id="untuk" name="untuk" rows="3" required>{!! $model->untuk !!}</textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-3">
                                    <label>Tanggal Keberangkatan <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" id="tanggal_berangkat" name="tanggal_berangkat" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date" value="{{old('tanggal_berangkat',date('d-M-Y', strtotime($model->tanggal_berangkat)))}}" required style="z-index: 1 !important;">
                                    </div>
                                </div>

                                <div class="form-group col-3">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">s.d <span class="wajib"></span></div>
                                        </div>
                                        <input type="text" id="tanggal_kembali" name="tanggal_kembali" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date" onchange="days()" value="{{old('tanggal_kembali',date('d-M-Y', strtotime($model->tanggal_kembali)))}}" required style="z-index: 1 !important;">

                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Lama <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="lama" name="lama" onclick="days()" value="{{old('lama',$model->lama)}}" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">Hari</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-center">
                                <button class="btn btn-info tambah" type="submit" id="savespt" style="display: none; margin-right: 10px">Simpan</button>
                                <button class="btn btn-info tambah" type="submit" id="print" name="print" style="display: none; margin-right: 10px" value="1"><i class="fa fa-print"></i>  Print</button>
                                <button class="btn btn-primary tambah" type="submit" id="cekbutton">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalcekjadwal"  role="dialog" aria-hidden="true" aria-labelledby="Modal Cek Jadwal SPT">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 110% !important;">
            <div class="modal-header" style="background-color: #03a9f4">
                <h4 class="modal-title" style="color: white">Cek Jadwal SPT</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <form role="form" method="POST" action="" >
                    @csrf
                    <div id="kosong" style="font-weight: bold; text-align: center"></div>
                    <div id="responnya" style="font-weight: bold; text-align: center"></div>
                    <div id="baris" style="font-weight: bold; text-align: center"></div>

                    <table id="myTable" class="table" style="overflow-y: scroll; height: 300px; display: block">
                        <thead>
                        <tr>
                            <th>NO. SPT / Kode SPT</th>
                            <th>Pegawai</th>
                            <th>Tanggal Berangkat</th>
                        </tr>
                        </thead>
                        <tbody id="isitable" style="font-size: 12px">

                        </tbody>
                    </table>

                    <div class="form-group text-center">
                        <button class="btn btn-primary tambah" type="button" id="simpanspt">Lanjutkan & Simpan SPT</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('css')
<!--<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/select2/dist/css/select2.min.css">-->
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/cselect2/select2.min.css">
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components-custom/summernote/summernote-bs4.min.css">
@endsection


@section('js')
<script src="{{ asset('assets/themes') }}/components/cselect2/select2.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/ckeditor/ckeditor.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/summernote/summernote-bs4.min.js"></script>

<script>
    $(function($) {
        $('#pegawai').select2({
            placeholder: 'Pilih Anggota Pegawai',
            allowClear: true
        });

        $('#pegawai_ke1').select2({
            placeholder: 'Pilih Pimpinan Pegawai untuk SPT ini',
            allowClear: true
        });
        const pegawaiarray = <?php echo '['.$model->pegawai.']';?>;
        pegawaiarray.splice(0, 1);
        $('#pegawai').val(pegawaiarray).trigger("change");

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

        $('#mata_anggaran').select2({
            placeholder: 'Pilih Mata Anggaran ',
            allowClear: true
        });

        $('#untuk').summernote({
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
            ]

        });


    });

    $(document).ready(function() {
        // this function to search and show matched input
        function matchCustom(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }

            if (typeof data.text === 'undefined') {
                return null;
            }

            if (data.text.toUpperCase().indexOf(params.term.toUpperCase()) > -1) {
                var modifiedData = $.extend({}, data, true);
                modifiedData.text += '';
                return modifiedData;
            }

            return null;
        }

        $(".pegawai").select2({
            matcher: matchCustom
        });

        $('#pegawai').change(function() {
            var tableHeader = $(this).val();
            var tableBody = $("#pegawai_ke1")[0];
            $.each(tableBody.options, function(i, item) {
                if (tableHeader.includes(item.value)) {
                    $(item).prop("disabled", true);
                } else {
                    $(item).prop("disabled", false);
                }
            });
        });

        $('#pegawai_ke1').change(function() {
            var tableBody = $(this).val();
            var tableHeader = $("#pegawai")[0];
            $.each(tableHeader.options, function(i, item) {
                if (tableBody.includes(item.value)) {
                    $(item).prop("disabled", true);
                } else {
                    $(item).prop("disabled", false);
                }
            });
        });
    });


    function getnourut()
    {
        var nospt= $('#nospt').val();
        var hasil=nospt.replace(/\s/g, '');
        $('#nospt').val(hasil);

        var pos = hasil.indexOf("/") + 1;
        nospt = hasil.slice(pos, hasil.lastIndexOf("/SPT"));
        nourut=parseInt(nospt);
        $('#no_urut').val(nourut);
        //alert(nourut);
    }





    jQuery(document).ready(function ()
    {
        //program
        jQuery('select[name="program"]').on('change',function(){
            var countryID = jQuery(this).val();
            var url = '{{ route("spt.getKegiatan", ":id") }}';
            if(countryID)
            {
                jQuery.ajax({
                    //url : 'getKegiatan/' +countryID,
                    url : url.replace(':id', countryID),
                    type : "GET",
                    dataType : "json",
                    success:function(data)
                    {
                        console.log(data);
                        //jQuery('select[name="kegiatan"]').empty();
                        $("#tahunprogram").val(data.tahun);
                        jQuery.each(data.kabkota, function(key,value){
                            $('select[name="kegiatan"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }
            else
            {
                $('select[name="kegiatan"]').width('300px');
                // $('#kegiatan').val(2).trigger('change');
            }
        });
        var previousValue=$("#kegiatanlama").val();

         //kegiatan
        jQuery('select[name="kegiatan"]').on('change',function(){
            var countryID = jQuery(this).val();
            var url = '{{ route("spt.getsubkegiatan", ":id") }}';
            if(countryID)
            {
                jQuery.ajax({
                    url : url.replace(':id', countryID),
                    type : "GET",
                    dataType : "json",
                    success:function(data)
                    {
                        console.log(data);
                        //jQuery('select[name="subkegiatan"]').empty();
                        jQuery.each(data, function(key,value){
                            $('select[name="subkegiatan"]').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            }
            else
            {
                $('#kegiatan').val(previousValue);
            }
        });

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

    }
    // CKEDITOR.replace('dasar');
    // CKEDITOR.replace('untuk');
    // CKEDITOR.get("myTextarea").getContent();
    // alert(CKEDITOR.instances.dasar.getData());
    // alert(CKEDITOR.instances.untuk.getData());

    function buatchilddasar() {
        var parent = document.getElementById('inputs'),
            count = document.getElementById('inputCount').value || 1;
        parent.innerHTML = '';
        var tahun       = $("#tahunprogram").val();
        var kop         = $("#kop").val();
        var kegiatan    = $("#kegiatan :selected").text();
        var subkegiatan = $("#subkegiatan :selected").text();
        var rekening    = $("#mata_anggaran :selected").text();

        for (let i = 1; i <= count; i++) {
            if(i < count)
            {
                parent.innerHTML += `<label for="${i}" class="col-sm-1 col-form-label" style="text-align: right">${i}</label>
                                     <input type="hidden" value="${i}" name="nomor[${i}]" id="nomor[${i}]" class="col-sm-1 form-control" readonly/>
                                     <div class="form-group col-11">
                                        <textarea placeholder="Ketikkan Dasar Nomor ${i}" name="dasar[${i}]" id="dasar[${i}]" class="form-control" rows='5'/></textarea>
                                     </div>`;
            }
            else
            {
                parent.innerHTML += `<label for="${i}" class="col-sm-1 col-form-label" style="text-align: right">${i}</label>
                                     <input type="hidden" value="${i}" name="nomor[${i}]" id="nomor[${i}]" class="col-sm-1 form-control" readonly/>
                                     <div class="form-group col-11">
                                        <textarea placeholder="Ketikkan Dasar Nomor ${i}" name="dasar[${i}]" id="dasar[${i}]" class="form-control" rows='5'/>Dokumen Pelaksanaan Anggaran `
                    +kop+' Tahun Anggaran '+tahun+
                    ' pada Kegiatan '+kegiatan+', '+
                    ' Sub Kegiatan '+subkegiatan+', '+
                    ' Rekening '+rekening+'.'+
                    `</textarea>
                                     </div>`;
            }

        }
    }

    $(document).ready(function () {
        // check window is loaded meaning all external assets like images, css, js, etc
        $(window).on("load", function () {
            var parent = document.getElementById('inputs'),
                count = document.getElementById('inputCount').value || 1;
            parent.innerHTML = '';
            var tahun       = $("#tahunprogram").val();
            var kop         = $("#kop").val();
            var kegiatan    = $("#kegiatan :selected").text();
            var subkegiatan = $("#subkegiatan :selected").text();
            var rekening    = $("#mata_anggaran :selected").text();
            var banyak      = $("#inputCount").val();
            var id          = $("#id").val();
            var url = '{{ route("spt.dasarSptGet", ":id") }}';

            $.ajax({
                type: 'GET',
                url : url.replace(':id', id),
                dataType: "json",
                success: function (data) {
                    for (let i = 0; i<= data.sql.length; i++) {
                        parent.innerHTML += `<label for="${data.sql[i].nomor_urut}" class="col-sm-1 col-form-label" style="text-align: right">${data.sql[i].nomor_urut}</label>
                                     <input type="hidden" value="${data.sql[i].nomor_urut}" name="nomor[${data.sql[i].nomor_urut}]" id="nomor[${data.sql[i].nomor_urut}]" class="col-sm-1 form-control" readonly/>
                                     <div class="form-group col-11">
                                        <textarea name="dasar[${data.sql[i].nomor_urut}]" id="dasar[${data.sql[i].nomor_urut}]" class="form-control" rows='5'/>${data.sql[i].dasar}</textarea>
                                     </div>`;
                    }


                },

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }


            });


        });
    });


    $("#cekbutton").click(function(e) {
        e.preventDefault();
        var pegawai=$('#pegawai_ke1').val();
        var pegawailain=$('#pegawai').val();
        var pegawaiarray=pegawai+','+pegawailain;
        var tgl1 = new Date($('#tanggal_berangkat').val());
        var tgl1dmy = $('#tanggal_berangkat').val();
        var tgl2 = new Date($('#tanggal_kembali').val());
        var tgl2dmy = $('#tanggal_kembali').val();
        var tgla = tgl1.getFullYear()+"-"+((tgl1.getMonth() + 1) < 10 ? '0' : '') + (tgl1.getMonth() + 1)+"-"+((tgl1.getDate() < 10 ? '0' : '') + tgl1.getDate())
        var tglb = tgl2.getFullYear()+"-"+((tgl2.getMonth() + 1) < 10 ? '0' : '') + (tgl2.getMonth() + 1)+"-"+((tgl2.getDate() < 10 ? '0' : '') + tgl2.getDate())
        var url = '{{ route("spt.cekjadwalsptupdate") }}';
        var id=$('#id').val();

        if(pegawai && pegawailain && tgla && tglb) {
            //alert('ggg');
            $('#isitable').empty();
            $('#responnya').empty();
            $('#kosong').empty();
            $.ajax({
                type: 'GET',
                url: url,
                data: {'pegawaiarray': pegawaiarray, 'tgla': tgla, 'tglb': tglb, 'id':id},
                dataType: "json",
                contentType: 'application/json; charset=ytf-8',
                success: function (data) {
                    $('#modalcekjadwal').modal('show');
                    if (data.sql.length >= 1) {
                        for (var i = 0; i < data.sql.length; i++) {
                            let ptext = data.sql[i].pegawai;
                            let rtext = ptext.replace(';-;', '\n');
                            var kode='';
                            if(data.sql[i].no_spt == null)
                                kode=data.sql[i].kode_spt;
                            else
                                kode=data.sql[i].no_spt;

                            $('#responnya').html(data.response);
                            var row = $('<tr><td style="font-size: 10px !important;">' + kode + '</td><td>' + rtext + '</td><td>' + data.sql[i].tanggal + '</td></tr>');
                            $('#myTable').append(row);



                        }
                    } else {
                        //$('#myTable').empty();
                        //$('#isitable').empty();
                        if (tgl1dmy == tgl2dmy) {
                            var pesan = tgl1dmy;
                        } else {
                            var pesan = tgl1dmy + ' s/d ' + tgl2dmy;
                        }
                        $('#kosong').html('Tidak Ada Jadwal SPT ' + pesan + ' untuk Anggota tersebut.. Silahkan Lanjutkan untuk menyimpan SPT ini');
                    }
                },

                error: function (jqXHR, textStatus, errorThrown) {
                    alert('Error: ' + textStatus + ' - ' + errorThrown);
                }


            });
        }
    });

    document.getElementById('simpanspt').onclick = function() {
        $('#modalcekjadwal').modal('hide');
        $("#cekbutton").html('Cek Jadwal SPT');
        $("#savespt").css('display', 'block');
        $("#print").css('display', 'block');

    }

    function kosongkan()
    {
        document.getElementById('nospt').value=null;
        alert('No. SPT belum diterbitkan');
    }

</script>
@endsection
