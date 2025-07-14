@extends('layouts/master')
@section('title','Rekening')

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
                        <h2 class="float-left">Data @yield('title')</h2>
                        <a href="#" data-href="#" data-toggle="modal" data-target="#createModal" class="btn btn-primary float-right">
                            <i class="fa fa-plus-circle fa-lg"></i> Tambah
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
                            <table class="table table-bordered table-striped table-hover" id="tabelku">
                                <thead>
                                <tr class="green-bg" style="color: white">
                                    <th width="20"><a href="#" style="color: white">No.</a></th>
                                    <th><a href="#" style="color: white">Kode @yield('title')</a></th>
                                    <th><a href="#" style="color: white">Tahun @yield('title')</a></th>
                                    <th><a href="#" style="color: white">Nama @yield('title')</a></th>
                                    <th><a href="#" style="color: white">Deskripsi</a></th>
                                    <th width="20"><a href="#" style="color: white">Action</a></th>
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



<!--                    <div class="main-box clearfix project-box green-box">-->
<!--                        <div class="main-box-body clearfix">-->
<!--                            <div class="project-box-header green-bg">-->
<!--                                <div class="name">-->
<!--                                    <a href="#">-->
<!--                                        Captain America-->
<!--                                    </a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div class="project-box-content">-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->

@include('rekening.delete-modal')
@include('rekening.edit')
@include('rekening.create')

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
                url: '{{route("rekening.getData")}}'
            },
            columns: [
                {
                    data: null, sortable: false, render: function (data, type, row, meta) {
                        var i = meta.row + meta.settings._iDisplayStart + 1;
                        return "<a href='show/" + row.id + "'>" + i + "</a>"
                    }
                },
                {data: 'kode', name: 'kode', searchable: true, orderable: true},
                {data: 'tahun', name: 'tahun', searchable: true, orderable: true},
                {data: 'nama', name: 'nama', searchable: true, orderable: true},
                {data: 'deskripsi', name: 'deskripsi', searchable: true, orderable: true},
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
            var url = '{{ route("rekening.delete", ":id") }}';
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
                }
            });
        });

        $('#add_form').submit(function(e){
            e.preventDefault();
            var data = {
                'nama'              : $('#nama').val(),
                'kode'              : $('#kode').val(),
                'tahun'             : $('#tahun').val(),
                'deskripsi'         : $('#deskripsi').val(),
                _token: '{{csrf_token()}}'
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#createModal").on("hidden.bs.modal", function(){
                $(".modal-body1").html("");
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').hide();
            });
            $.ajax({
                type: 'POST',
                url: 'store',
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
                                $('#createModal').modal('hide');
                        }, 1000
                        );
                    }

                }
            });
        });


        $('#createModal').on('hidden.bs.modal', function () {
            $(this).find('form').trigger('reset');
        })
        //edit

        $(document).on('click', '#editbtn', function (e) {
            e.preventDefault();
            var idnya = $(this).data('id');
            $('#editModal').modal('show');
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            $('.alert-success').hide();
            $.ajax({
                type: "GET",
                url: "edit/" + idnya,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('');
                        $('#success_message').text(response.message);
                        $('#editModal').modal('hide');
                    } else {
                        // console.log(response.student.name);
                        $('#namaedit').val(response.model.nama);
                        $('#kodeedit').val(response.model.kode);
                        $('#tahunedit').val(response.model.tahun);
                        $('#deskripsiedit').val(response.model.deskripsi);
                        $('#labelid').html(idnya.toString());
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
                'kodeedit'        : $('#kodeedit').val(),
                'namaedit'        : $('#namaedit').val(),
                'tahunedit'       : $('#tahunedit').val(),
                'leveledit'       : $('#leveledit').val(),
                'deskripsiedit'   : $('#deskripsiedit').val(),
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
                url: 'update/'+id,
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
                        // $('#save_msgList').html("");
                        // $('#success_message').addClass('alert alert-success alert-dismissible fade show');
                        // $('#success_message').text('Data berhasil di Simpan');
                        // $("#editModal").modal("hide");
                        // oTable.ajax.reload();
                    }
                }
            });
        });
    });


    $(document).ready(function(){
        $("#success_message").delay(9000).slideUp(300);
    });

</script>
<!---->
@endsection
