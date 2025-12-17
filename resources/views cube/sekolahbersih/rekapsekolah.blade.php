@extends('layouts/master')
@section('title','Penilaian Sekolah Bersih')

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
                    {{-- <header class="main-box-header clearfix">
                        <h2 class="float-left">Data @yield('title')</h2>
                        <a href="{{ route('sekolahbersih.create') }}" class="btn btn-turqoise float-right">
                            <i class="fa fa-plus-circle fa-lg"></i> Tambah
                        </a>
                    </header> --}}

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
                                    <th><a href="#" style="color: white">Sekolah</a></th>
                                    <th><a href="#" style="color: white">Periode</a></th>
                                    <th><a href="#" style="color: white">Deskripsi</a></th>
                                    <th><a href="#" style="color: white">Tgl Supervisi</a></th>
                                    <th><a href="#" style="color: white">Kesimpulan</th>
                                    <th width="40"><a href="#" style="color: white">Action</a></th>
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
                url: '{{route("sekolahbersih.getDataRekapSekolah")}}'
            },
            columns: [
                {
                    data: null, sortable: false, render: function (data, type, row, meta) {
                        var i = meta.row + meta.settings._iDisplayStart + 1;
                        return "<a href='show/" + row.id + "'>" + i + "</a>"
                    }
                },
                {data: 'sekolah', name: 'sekolah', searchable: true, orderable: true},
                {data: 'periode_awal_kuesioner', name: 'periode_awal_kuesioner', searchable: true, orderable: true},
                {data: 'id_ruang', name: 'id_ruang', searchable: true, orderable: true},
                {data: 'tanggal_supervisi', name: 'tanggal_supervisi', searchable: true, orderable: true},
                {data: 'catatan_pengawas', name: 'catatan_pengawas', searchable: true, orderable: true},
                {data: 'action', name: 'action'},
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


    });


    $(document).ready(function(){
        $("#success_message").delay(9000).slideUp(300);
    });

</script>
<!---->
@endsection
