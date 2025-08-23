@extends('layouts/master')
@section('title','Verifikator Sekolah')

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
                        <a href="{{ route('verifikator.create') }}" class="btn btn-turqoise float-right">
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
                                    <th width="20"><a href="#" style="color: white">ID.</a></th>
                                    <th><a href="#" style="color: white">Sekolah</a></th>
                                    <th><a href="#" style="color: white">User Verifikator</a></th>
                                    <th><a href="#" style="color: white">Jabatan</a></th>
                                    <th><a href="#" style="color: white">Deskripsi</a></th>
                                    <th><a href="#" style="color: white">Tanda Tangan</a></th>
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


<!-- Modal untuk preview tanda tangan -->
<div class="modal fade" id="ttdModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Preview Tanda Tangan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span>&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="ttdPreview" src="" style="max-width:100%; border:1px solid #ddd;"/>
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
                url: '{{route("verifikator.getData")}}'
            },
            columns: [
                {data: 'id', name: 'id', searchable: true, orderable: true},
                {data: 'id_sekolah', name: 'id_sekolah', searchable: true, orderable: true},
                {data: 'verifikator', name: 'verifikator', searchable: true, orderable: true},
                {data: 'jabatan_verifikator', name: 'jabatan_verifikator', searchable: true, orderable: true},
                {data: 'deskripsi', name: 'deskripsi', searchable: true, orderable: true},
                {data: 'tandatangan_url', name: 'tandatangan_url', searchable: true, orderable: true},
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
       
       


    });


    $(document).ready(function(){
        $("#success_message").delay(9000).slideUp(300);
    });
    
    
    //popup html
    $(document).on("click", "[data-target='#ttdModal']", function () {
        var img = $(this).data("img");
        $("#ttdPreview").attr("src", img);
    });

</script>
<!---->
@endsection
