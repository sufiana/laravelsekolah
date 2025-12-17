@extends('layouts/master')
@section('title','SPT')

@section('content')
<head>
    <style>
        select,
        .select2-container {
            width: 100% !important;
        }
    </style>
</head>

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


                        <form role="form" method="POST" action="{{ route('spt.simpan') }}" name="sptform" id="sptform">
                            @csrf
                            <?php
                                $formatnosurattabel=\App\models\FormatSurat::find(1);
                                $nosurat=$formatnosurattabel->digit_pertama.'/  /'.$formatnosurattabel->digit_berikutnya.'/'.date("Y");

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
                                    <label>No. SPT </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-primary" type="button" id="notset" onclick="kosongkan()">Not Set</button>
                                        </div>
                                        <input type="text" class="form-control" id="nospt" name="nospt" value="{{$nosurat}}" onfocusout="getnourut()">
                                        <input type="hidden" class="form-control" id="no_urut" name="no_urut">
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Tanggal SPT<span class="wajib"></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" id="tgl_spt" name="tgl_spt" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date" required style="z-index: 1 !important;">
                                    </div>
                                </div>

                                <div class="form-group col-6" id="anggaran">
                                    <label>Mata Anggaran<span class="wajib"></span></label>
                                    <select name="mata_anggaran" id="mata_anggaran" class="form-control select2" required style="z-index: -1">
                                        <option value="">== Pilih Anggaran ==</option>
                                        @foreach ($mataanggaran as $ma)
                                        <option value="{{ $ma->id }}" {{(old('mata_anggaran') == $ma->id?'selected':'')}}>{{$ma->kode.' '.$ma->nama}}</option>
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
                                        <option value="{{ $prog->id }}" {{(old('program') == $prog->id?'selected':'')}}>{{ $prog->kode.' '.$prog->nama }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="kop" name="kop" value="{{$kop->nama_dinas_surat}}">
                                    <input type="hidden" id="namaprogram" name="namaprogram">
                                    <input type="hidden" id="tahunprogram" name="tahunprogram">
                                </div>
                                <div class="form-group col-6">
                                    <label>Kegiatan <span class="wajib"></span></label>
                                    <select name="kegiatan" id="kegiatan" class="form-control select2" required>
                                        <option value="">== Pilih Kegiatan ==</option>
                                    </select>
                                    <input type="hidden" id="namakegiatan" name="namakegiatan">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-6">
                                    <label>Sub Kegiatan <span class="wajib"></span></label>
                                    <select name="subkegiatan" id="subkegiatan" class="form-control select2" required>
                                        <option value="">== Pilih Sub Kegiatan ==</option>
                                    </select>
                                    <input type="hidden" id="namasubkegiatan" name="namasubkegiatan">
                                </div>

                                <div class="form-group col-6">
                                    <label>Jumlah Poin Dasar <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <input min="0" type="number" name="inputCount" id="inputCount" class="form-control" placeholder="Masukkan Jumlah Poin Dasar">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" value="Make" id="ok" onclick="buatchilddasar()">Buat Poin</button>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div id="inputs" class="form-group row">
                            <!-- container for dynamic inputs -->
                            </div>

                            {{--<div class="row">
                                <div class="form-group col-12">
                                    <label>Dasar <span class="wajib"></span></label>
                                    <textarea class="form-control" id="dasar" name="dasar" rows="3" required>
                                           <ol>
                                                <li>&nbsp;</li>
                                                <li>&nbsp;</li>
                                                <li>Dokumen Pelaksanaan Anggaran $dinassurat Tahun Anggaran $tahun pada Kegiatan $kegiatan, Sub Kegiatan $subkegiatan </li>
                                           </ol>
                                    </textarea>
                                </div>
                            </div>--}}

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Pilih Pegawai Yang Diperintahkan <span class="wajib"></span></label>
                                    <select name="pegawai_ke1" id="pegawai_ke1" tabindex="-1" class="form-control select2 pegawai" aria-hidden="true" rows="5" required onchange="getPegawai1()">
                                        <option value="">== Pilih Pegawai ==</option>
                                        @foreach ($pegawai as $k)
                                        <option value="{{$k->id}}" {{(old('pegawai') == $k->id?'selected':'')}}>{{$k->nip.' - '.$k->nama_pegawai}}</option>
                                        @endforeach
                                        <input id="detail_pegawai_1" name="detail_pegawai_1" type="hidden">
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Pilih Anggota Pegawai Lainnya <span class="wajib"></span></label>
                                    <select name="pegawai[]" id="pegawai" multiple="" tabindex="-1" class="form-control select2 pegawai" aria-hidden="true" rows="5" required onchange="getPegawailain()">
                                        <option value="">== Pilih Pegawai ==</option>
                                        @foreach ($pegawai as $k)
                                        <option value="{{$k->id}}" {{(old('pegawai') == $k->id?'selected':'')}}>{{$k->nip.' - '.$k->nama_pegawai}}</option>
                                        @endforeach
<!--                                        <input id="detail_pegawai_lain" name="detail_pegawai_lain" type="text" class="form-control">-->
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Untuk <span class="wajib"></span></label>
                                    <textarea class="form-control" id="untuk" name="untuk" rows="3" required></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-3">
                                    <label>Tanggal Keberangkatan <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" id="tanggal_berangkat" name="tanggal_berangkat" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date" required style="z-index: 1 !important;">
                                    </div>
                                </div>

                                <div class="form-group col-3">
                                    <label>&nbsp;</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">s.d <span class="wajib"></span></div>
                                        </div>
                                        <input type="text" id="tanggal_kembali" name="tanggal_kembali" class="form-control datepicker" data-date-format="DD/MMM/YYYY" type="date" onchange="days()" required style="z-index: 1 !important;">
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label>Lama <span class="wajib"></span></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="lama" name="lama" onclick="days()" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">Hari</div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-center">
                                <button class="btn btn-info tambah" type="submit" id="savespt" style="display: none; margin-right: 10px">Simpan</button>
                                <button class="btn btn-info tambah" type="submit" id="print" name="print" style="display: none; margin-right: 10px" value="1"><i class="fa fa-print"></i> Print</button>
                                <button class="btn btn-primary tambah" type="submit" id="cekbutton">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
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
                    <table id="myTable" class="table table-striped table-hover">
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
@endsection

@section('js')
<!--<script src="{{ asset('assets/themes') }}/components/select2/dist/js/select2.min.js"></script>-->
<script src="{{ asset('assets/themes') }}/components/cselect2/select2.min.js"></script>

<script src="{{ asset('assets/themes') }}/components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/ckeditor/ckeditor.js"></script>

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
            if(countryID)
            {
                jQuery.ajax({
                    url : 'getKegiatan/' +countryID,
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
            }
        });

        //kegiatan
        jQuery('select[name="kegiatan"]').on('change',function(){
            var countryID = jQuery(this).val();
            if(countryID)
            {
                jQuery.ajax({
                    url : 'getsubkegiatan/' +countryID,
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
                $('select[name="subkegiatan"]').width('300px');
            }
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

            if(pegawai && pegawailain && tgla && tglb) {
            $('#isitable').empty();
            $('#responnya').empty();
            $('#kosong').empty();
            $.ajax({
                type: 'GET',
                url: 'cekjadwalspt',
                data: {'pegawaiarray': pegawaiarray, 'tgla': tgla, 'tglb': tglb},
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
                            var row = $('<tr><td style="font-size: 10px !important;">' + data.sql[i].no_spt + '</td><td>' + rtext + '</td><td>' + data.sql[i].tanggal + '</td></tr>');
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


    function days() {
        var a = $("#tanggal_berangkat").datepicker('getDate').getTime(),
            b = $("#tanggal_kembali").datepicker('getDate').getTime(),
            c = 24*60*60*1000,
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
    //CKEDITOR.replace('dasar');
    // CKEDITOR.replace('untuk');
    //CKEDITOR.get("myTextarea").getContent();

    function getPegawai1()
    {
        var select = document.getElementById('pegawai_ke1');
        var text = select.options[select.selectedIndex].text;
        $("#detail_pegawai_1").val(text);
    }

    function getPegawailain()
    {
        let val,
            dom = '#pegawai';
        val = $(dom+' option:selected').text();
        console.log(val+'; ');
        $("#detail_pegawai_lain").val(val);

        $(document).on('change', () => {
            val = $(dom).select2('data').text;
            console.log(val+'; ');
            $("#detail_pegawai_lain").val(val);
        });
    }


    function buatchilddasar() {
        var parent = document.getElementById('inputs'),
            count = document.getElementById('inputCount').value || 1;
        parent.innerHTML = '';
        var tahun       = $("#tahunprogram").val();
        var kop         = $("#kop").val();
        var kegiatan    = $("#kegiatan :selected").text();
        var subkegiatan = $("#subkegiatan :selected").text()
        var rekening    = $("#mata_anggaran :selected").text()

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
                                        <textarea placeholder="Ketikkan Dasar Nomor ${i}" name="dasar[${i}]" id="dasar[${i}]" class="form-control" rows='5'/>Dokumen pelaksanaan anggaran `
                                            +kop+' tahun nggaran '+tahun+
                                            ' pada kegiatan '+kegiatan.toLowerCase()+', '+
                                            ' sub kegiatan '+subkegiatan.toLowerCase()+', '+
                                            ' rekening '+rekening.toLowerCase()+'.'+
                                            `</textarea>
                                     </div>`;
            }

        }
    }

    function ubahymd() {
        var a = new Date($('#tanggal_berangkat').val());
        var bulana= (a.getDate() < 10 ? '0' : '') + a.getDate();
        var b = a.getFullYear()+"-"+((a.getMonth() + 1) < 10 ? '0' : '') + (a.getMonth() + 1)+"-"+((a.getDate() < 10 ? '0' : '') + a.getDate());
        alert(b);
    }
    function kosongkan()
    {
        document.getElementById('nospt').value=null;
        alert('No. SPT belum diterbitkan');
    }


</script>
@endsection
