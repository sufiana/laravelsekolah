@extends('layouts/master')
@section('title','Sekolah')

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
                    <div class="main-box-body clearfix">
                        <div role="alert" id="success_message"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tabelku">
                                <thead>
                                <tr class="green-bg" style="color: white">
                                    <th width="20"><a href="#" style="color: white">ID.</a></th>
                                    <th><a href="#" style="color: white">Nama</a></th>
                                    <th><a href="#" style="color: white">NPSN</a></th>
                                    <th><a href="#" style="color: white">Bentuk Pendidikan</a></th>
                                    <th><a href="#" style="color: white">Alamat</a></th>
                                    <th><a href="#" style="color: white">Kabupaten/Kota</a></th>
                                    <th><a href="#" style="color: white">Koordinat</a></th>
                                    <th><a href="#" style="color: white">Telepon</a></th>
                                    <th><a href="#" style="color: white">Email</a></th>
                                    <th><a href="#" style="color: white">Website</a></th>
                                    <th><a href="#" style="color: white">Kepala Sekolah</a></th>
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



@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/themes') }}/components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
<script src="{{ asset('assets/themes') }}/components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('assets/themes') }}/components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(function () {
        var oTable = $('#tabelku').DataTable({
            //order: [[0, "desc"]],
            processing: false,
            serverSide: true,
            ajax: {
                url: '{{route("GetDataSekolah")}}'
            },
            columns: [
                {data: 'id', name: 'id', searchable: true, orderable: true},
                {data: 'nama', name: 'nama', searchable: true, orderable: true},
                {data: 'npsn', name: 'npsn', searchable: true, orderable: true},
                {data: 'bentuk_pendidikan_id', name: 'bentuk_pendidikan_id', searchable: true, orderable: true},
                {data: 'alamat_jalan', name: 'alamat_jalan', searchable: true, orderable: true},
                {data: 'kabupaten_kota', name: 'kabupaten_kota', searchable: true, orderable: true},
                {data: 'lintang', name: 'lintang', searchable: true, orderable: true},
                {data: 'nomor_telepon', name: 'nomor_telepon', searchable: true, orderable: true},
                {data: 'email', name: 'email', searchable: true, orderable: true},
                {data: 'website', name: 'website', searchable: true, orderable: true},
                {data: 'kepalasekolah', name: 'kepalasekolah', searchable: true, orderable: true},
                {data: 'action', name: 'action'},
            ]
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });


</script>
<!---->
@endsection
