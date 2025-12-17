@extends('layouts/master')
@section('title','SPT')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active"><span>@yield('title')</span></li>
                </ol>
                <h1>Data @yield('title')</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="main-box clearfix">
                    <header class="main-box-header clearfix">
                        <h2 class="float-left">Data @yield('title') (Surat Perintah Tugas)</h2>
                        <a href="{{ route('spt.create') }}"  class="btn btn-primary float-right">
                            <i class="fa fa-plus-circle fa-lg"></i> Tambah
                        </a>
                    </header>

                    <div class="main-box-body clearfix">
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

                        <div role="alert" id="success_message">
<!--                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">-->
<!--                                <span aria-hidden="true">×</span>-->
<!--                            </button>-->
<!--                            <i class="fa fa-check-circle fa-fw fa-lg"></i>-->
<!--                            <strong>Well done!</strong> You successfully read this important alert message.-->
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tabelku">
                                <thead>
                                <tr class="green-bg" style="color: white">
                                    <th><a href="#" style="color: white; width: 2%">No.</a></th>
                                    <th width="5px"><a href="#" style="color: white">Kode SPT</a></th>
                                    <th width="5px !important"><a href="#" style="color: white">No. SPT</a></th>
<!--                                    <th><a href="#" style="color: white">Program</a></th>-->
<!--                                    <th><a href="#" style="color: white">Kegiatan</a></th>-->
                                    <th width="20% !important"><a href="#" style="color: white;">Sub Kegiatan</a></th>
                                    <th><a href="#" style="color: white">Pegawai</a></th>
                                    <th><a href="#" style="color: white">Tanggal Keberangkatan</a></th>
                                    <th width="5px"><a href="#" style="color: white;  width: 2%">lama (Hari)</a></th>
<!--                                    <th><a href="#" style="color: white; width: 2%">Status</a></th>-->
                                    <th><a href="#" style="color: white">Action</a></th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@include('spt.nospt-modal')
@include('spt.delete-modal')
@include('spt.editstatus')
@include('spt.cekjadwalspt-modal')

@endsection

@section('css')
<!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">-->
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">


@endsection

@section('js')
<!--<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>-->
<script src="{{ asset('assets/themes') }}/components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/modal-animations/modalEffects.js"></script>

<script>
    $(function () {
        var oTable = $('#tabelku').DataTable({
            //order: [[0, "desc"]],
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{route("spt.getData")}}'
            },
            columns: [
                {
                    data: null, sortable: false, render: function (data, type, row, meta) {
                        var i = meta.row + meta.settings._iDisplayStart + 1;
                        return "<a href='show/" + row.id + "'>" + i + "</a>"
                    }
                },
                {data: 'kode_spt', name: 'kode_spt', searchable: true, orderable: true},
                {data: 'no_spt', name: 'no_spt', searchable: true, orderable: true},
                // {data: 'program', name: 'program', searchable: true, orderable: true},
                // {data: 'kegiatan', name: 'kegiatan', searchable: true, orderable: true},
                {data: 'subkegiatan', name: 'subkegiatan', searchable: true, orderable: true},
                {data: 'pegawai', name: 'pegawai', searchable: true, orderable: true},
                {data: 'tanggal_berangkat', name: 'tanggal_berangkat', searchable: true, orderable: true},
                {data: 'lama', name: 'lama', searchable: true, orderable: true},
                // {data: 'status', name: 'status', searchable: true, orderable: true},
                {data: 'action', name: 'action'},
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#delModal').on('show.bs.modal', function (e) {
            let Id = $(e.relatedTarget).data('id');
            var nama = $(e.relatedTarget).data('nama');
            $('#deleteid').val(Id.toString());
            $('#labelid').html(Id.toString());
            $('#labelnama').html(nama.toString());
        });
        $('#delete-form').submit(function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            let Id = formData.get('id');
            var url = '{{ route("spt.delete", ":id") }}';
            $.ajax({
                url  : url.replace(':id', Id),
                data: {_token: '{{csrf_token()}}'},
                type: 'DELETE',
                dataType: 'HTML',
                success: function (resp) {
                    $('#save_msgList').html("");
                    $('#success_message').addClass('alert alert-danger alert-dismissible fade show');
                    $('#success_message').text('Data berhasil di hapus');
                    $("#delModal").modal("hide");
                    oTable.ajax.reload();
                },
                error: function (data) {
                    console.log(data);
                    $('#success_message').text('Maaf Data SPT ini Tidak bisa di hapus dikarenakan SPPD nya sudah Terbit!');
                }
            });
        });

        $('#setnosptModal').on('show.bs.modal', function (e) {
            let Id = $(e.relatedTarget).data('id');
            var nama = $(e.relatedTarget).data('nama');
            var laman = $(e.relatedTarget).data('laman');
            $('#idspt').val(Id.toString());
            $('#labelnama').html(nama.toString());
            $('#laman').val(laman);
        });

        $('#cekjadwalspt').on('show.bs.modal', function (e) {
            let Id = $(e.relatedTarget).data('id');
            let tanggala = $(e.relatedTarget).data('tanggala');
            let tanggalb = $(e.relatedTarget).data('tanggalb');
            let pegawai = $(e.relatedTarget).data('pegawai');
            $('#idganda').val(Id.toString());
            $('#pegawai').val(pegawai.toString());
            $('#tgl_berangkat').val(tanggala.toString());
            $('#tgl_kembali').val(tanggalb.toString());

            var tgl1 = new Date($('#tgl_berangkat').val());
            var tgl1dmy = $('#tgl_berangkat').val();
            var tgl2 = new Date($('#tgl_kembali').val());
            var tgl2dmy = $('#tgl_kembali').val();
            var tgla = tgl1.getFullYear()+"-"+((tgl1.getMonth() + 1) < 10 ? '0' : '') + (tgl1.getMonth() + 1)+"-"+((tgl1.getDate() < 10 ? '0' : '') + tgl1.getDate())
            var tglb = tgl2.getFullYear()+"-"+((tgl2.getMonth() + 1) < 10 ? '0' : '') + (tgl2.getMonth() + 1)+"-"+((tgl2.getDate() < 10 ? '0' : '') + tgl2.getDate())
            var pegawaiarray=$('#pegawai').val();
            var idganda=$('#idganda').val()


            $('#isitable').empty();
            $('#responnya').empty();
            $('#kosong').empty();

            $.ajax({
                type: 'GET',
                url: 'cekjadwalsptmodalgrid',
                data: {'pegawaiarray': pegawaiarray, 'tgla': tgla, 'tglb': tglb, 'idganda':idganda},
                dataType: "json",
                contentType: 'application/json; charset=ytf-8',
                success: function (data) {
                    //alert(pegawaiarray);
                    if (data.sql.length >= 1) {
                        for (var i = 0; i < data.sql.length; i++) {
                            let ptext = data.sql[i].pegawai;
                            let rtext = ptext.replace(';-;', '\n');
                            $('#responnya').html(data.response);
                            var kode='';
                            if(data.sql[i].no_spt == null)
                                kode=data.sql[i].kode_spt;
                            else
                                kode=data.sql[i].no_spt;
                            var row = $('<tr><td style="font-size: 10px !important;">' + kode + '</td><td>' + rtext + '</td><td>' + data.sql[i].tanggal + '</td></tr>');
                            $('#myTable').append(row);
                        }
                    } else {
                        $('#myTable').empty();
                        $('#isitable').empty();
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
        });

        /*
        //untuk verifikasi (*sekarang tidak dipakai lagi)

                $(document).on('click', '#editbtn', function (e) {
                    e.preventDefault();
                    var idnya = $(this).data('id');
                    $('#editModal').modal('show');
                    $('.alert-danger').html('');

                    $('.alert-danger').hide();
                    $('.alert-success').hide();
                    $.ajax({
                        type: "GET",
                        url: "editmodal/" + idnya,
                        success: function (response) {
                            if (response.status == 404) {
                                $('#success_message').addClass('');
                                $('#success_message').text(response.message);
                                $('#editModal').modal('hide');
                            } else {
                                $('#idedit').val(idnya);
                            }
                        }
                    });
                })


                //edit form submit
                $('#edit_form').submit(function(e){
                    e.preventDefault();
                    var id = $('#idedit').val();
                    var data = {
                        'status'          : $('#status').val(),
                        'alasan_penolakan': $('#alasan_penolakan').val(),
                        _token: '{{csrf_token()}}'
                    }
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $("#editModal").on("hidden.bs.modal", function(){
                        $('.alert-danger').html('');
                        $('.alert-danger').hide();
                        $('.alert-success').hide();
                    });
                    $.ajax({
                        type: 'PUT',
                        url: 'updatemodal/'+id,
                        data: data,
                        dataType: 'json',
                        success: function (response) {
                            if(response.errors) {
                                $('.alert-danger').html('');
                                $.each(response.errors, function(key, value) {
                                    $('.alert-danger').show();
                                    $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                                });
                            } else {
                                $('.alert-danger').hide();
                                $('.alert-success').show();
                                oTable.ajax.reload();
                                setTimeout(function() {
                                    $('.alert-success').modal('hide');
                                    $('#editModal').modal('hide');
                                    }, 1000
                                );

                            }
                        }
                    });
                });

            */


    });



    $(document).ready(function(){
        $("#success_message").delay(9000).slideUp(300);
    });

    function aktiffunc() {
        var checkBoxValue = $('#status').is(':checked')?1:2;
        $('#status').val(checkBoxValue);
        var x=document.getElementById("status").value;
        var a = document.getElementById("alasan_penolakan");
        if(x=="2")
        {
            $("#alasan").show();
            a.required = true;
        }
        else if(x=="1")
        {
            $("#alasan").hide();
            a.required = false;
        }
        else
        {
            $("#alasan").hide();
            a.required = false;
        }
    }



</script>
<!---->
@endsection
