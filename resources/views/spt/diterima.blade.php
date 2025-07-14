@extends('layouts/master')
@section('title','SPT Terverifikasi')

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
                                    <th><a href="#" style="color: white">No. SPT</a></th>
<!--                                    <th><a href="#" style="color: white">Program</a></th>-->
<!--                                    <th><a href="#" style="color: white">Kegiatan</a></th>-->
                                    <th><a href="#" style="color: white">Sub Kegiatan</a></th>
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


@include('spt.reset')

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
                url: '{{route("spt.getsptditerima")}}'
            },
            columns: [
                {
                    data: null, sortable: false, render: function (data, type, row, meta) {
                        var i = meta.row + meta.settings._iDisplayStart + 1;
                        return "<a href='show/" + row.id + "'>" + i + "</a>"
                    }
                },
                {data: 'no_spt', name: 'no_spt', searchable: true, orderable: true},
                // {data: 'program', name: 'program', searchable: true, orderable: true},
                // {data: 'kegiatan', name: 'kegiatan', searchable: true, orderable: true},
                {data: 'subkegiatan', name: 'subkegiatan', searchable: true, orderable: true},
                {data: 'pegawai', name: 'pegawai', searchable: true, orderable: true},
                {data: 'tanggal_berangkat', name: 'tanggal_berangkat', searchable: true, orderable: true},
                {data: 'lama', name: 'lama', searchable: true, orderable: true},
                {data: 'action', name: 'action'},
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#resetbtn', function (e) {
            e.preventDefault();
            var idnya = $(this).data('id');
            $('#resetModal').modal('show');
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
                        $('#idreset').val(idnya);
                    }
                }
            });
        })

        //Reset form submit
        $('#reset_form').submit(function(e){
            e.preventDefault();
            var id = $('#idreset').val();
            var data = {
                _token: '{{csrf_token()}}'
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#resetModal").on("hidden.bs.modal", function(){
                $('.alert-danger').html('');
                $('.alert-danger').hide();
                $('.alert-success').hide();
            });
            $.ajax({
                type: 'PUT',
                url: 'reset/'+id,
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
                                $('#resetModal').modal('hide');
                            }, 1000
                        );
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
