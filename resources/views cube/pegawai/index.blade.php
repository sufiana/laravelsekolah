@extends('layouts/master')
@section('title','Pegawai')

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
                        <a href="{{ route('pegawai.create') }}"  class="btn btn-primary float-right">
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
                                    <th><a href="#" style="color: white">NIP</a></th>
                                    <th><a href="#" style="color: white">Nama Pegawai</a></th>
                                    <th><a href="#" style="color: white">Pangkat & Golongan</a></th>
                                    <th><a href="#" style="color: white">Jabatan</a></th>
                                    <th><a href="#" style="color: white">No. Telp</a></th>
                                    <th><a href="#" style="color: white">Status Pegawai</a></th>
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

@include('pegawai.delete-modal')

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
                url: '{{route("pegawai.getData")}}'
            },
            columns: [
                {
                    data: null, sortable: false, render: function (data, type, row, meta) {
                        var i = meta.row + meta.settings._iDisplayStart + 1;
                        return "<a href='show/" + row.id + "'>" + i + "</a>"
                    }
                },
                {data: 'nip', name: 'nip', searchable: true, orderable: true},
                {data: 'nama_pegawai', name: 'nama_pegawai', searchable: true, orderable: true},
                {data: 'golongan', name: 'golongan', searchable: true, orderable: true},
                {data: 'id_jabatan', name: 'id_jabatan', searchable: true, orderable: true},
                {data: 'no_telp_wa', name: 'no_telp_wa', searchable: true, orderable: true},
                {data: 'status_pegawai', name: 'status_pegawai', searchable: true, orderable: true},
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
            var url = '{{ route("pegawai.delete", ":id") }}';
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
