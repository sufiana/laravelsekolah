@extends('layouts/master')
@section('title','Manajemen Biaya')

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
                        <a href="{{ route('biaya.create') }}" class="btn btn-turqoise float-right">
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
                                    <th><a href="#" style="color: white">Jabatan</a></th>
                                    <th><a href="#" style="color: white">Jenis Biaya</a></th>
                                    <th><a href="#" style="color: white">Status Wilayah Biaya</a></th>
                                    <th><a href="#" style="color: white">Nominal</a></th>
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


@include('manajemenbiaya.delete-modal')

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
                url: '{{route("biaya.getData")}}'
            },
            columns: [
                {
                    data: null, sortable: false, render: function (data, type, row, meta) {
                        var i = meta.row + meta.settings._iDisplayStart + 1;
                        return "<a href='show/" + row.id + "'>" + i + "</a>"
                    }
                },
                {data: 'jabatan', name: 'jabatan', searchable: true, orderable: true},
                {data: 'jenis_biaya', name: 'jenis_biaya', searchable: true, orderable: true},
                {data: 'status_wilayah_biaya', name: 'status_wilayah_biaya', searchable: true, orderable: true},
                {data: 'nominal', name: 'nominal', searchable: true, orderable: true},
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
            var url = '{{ route("biaya.delete", ":id") }}';
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


    });


    $(document).ready(function(){
        $("#success_message").delay(9000).slideUp(300);
    });

</script>
<!---->
@endsection
