@extends('layouts/master')
@section('title','Verifikator Sekolah')

@section('content')
<div class="app-content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
        <h3 class="mb-0">Data @yield('title')</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><span>@yield('title')</span></li>
        </ol>
      </div>
    </div>
  </div>
</div>

<div class="app-content">
  <div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Data @yield('title')</h3>
            <div class="card-tools">
                <a href="{{ route('verifikator.create') }}" class="btn btn-primary btn-sm float-right">
                    <i class="fa fa-plus-circle fa-lg"></i> Tambah
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="col-md-12 mb-3 d-flex justify-content-centerr">
                <table style="border: none; width: 99%; text-align: center; vertical-align: middle;">
                    <tr>
                        <td width="4%">Show</td>
                        <td width="6%">
                            <select id="customLength" class="form-select form-select-sm w-auto">
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </td>
                        <td width="3%">data</td>
                        <td align="right" width="87%">                    
                            <input type="search" id="customSearch" class="form-control form-control-sm w-50 d-inline-block" placeholder="Cari...">
                        </td>   
                    </tr>
                </table>
            </div>
            <div class="table-responsive-lg">
                <table class="table table-bordered table-striped w-100" id="tabelku">
                    <thead>
                        <tr style="color: white">
                            <th width="2%">ID.</a></th>
                            <th width="28%">Sekolah</a></th>
                            <th width="20%">User Verifikator</a></th>
                            <th width="20%">Jabatan</a></th>
                            <th width="20%">Instrumen</a></th>
                            <th width="3%">Tanda Tangan</a></th>
                            <th width="7%">Action</a></th>
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

<!-- Modal untuk preview tanda tangan -->
<div class="modal fade" id="ttdModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Preview Tanda Tangan</h4>
            </div>
            <div class="modal-body">
                <img id="ttdPreview" src="" style="max-width:100%; border:1px solid #ddd;"/>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>            
            </div>
        </div>
    </div>    
</div>

@include('verifikator.delete-modal')

@endsection

@section('css')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.7.1/css/autoFill.dataTables.min.css">

{{-- <link rel="stylesheet" href="{{ asset('assets/themes') }}/components/datatables.net-bs4/css/dataTables.bootstrap4.min.css"> --}}
<style>
.table thead tr th {
    background-color: #0D6EFD !important;
    color: #FFF !important;
    text-align: center;   /* optional */
    vertical-align: middle; /* optional */
    border: 1px solid #dee2e6
}
.table td, .table th {
    border: 1px solid #dee2e6;
    padding: .5rem;
    vertical-align: top;
    font-size: 12px;
}
div.dataTables_length,
div.dataTables_filter {
  display: none;
}

.table {
  width: 100%;
}
.table td, .table th {
    vertical-align: middle;
}
</style>

@endsection

@section('js')
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="{{ asset('assets/themes') }}/components-custom/modal-animations/modalEffects.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(function () {
         $('#customLength').on('change', function () {
            oTable.page.len($(this).val()).draw();
        });

        // Custom search field
        $('#customSearch').on('keyup', function () {
            oTable.search(this.value).draw();
        });

        var oTable = $('#tabelku').DataTable({
            //order: [[0, "desc"]],
            processing: false,
            serverSide: true,
            //ordering: true,
            ajax: {
                url: '{{route("verifikator.getData")}}'
            },
            columns: [
                {data: 'id', name: 'id', searchable: true, orderable: true},
                {data: 'id_sekolah', name: 'id_sekolah', searchable: true, orderable: true},
                {data: 'verifikator', name: 'verifikator', searchable: true, orderable: true},
                {data: 'jabatan_verifikator', name: 'jabatan_verifikator', searchable: true, orderable: true},
                {data: 'instrumen', name: 'instrumen', searchable: true, orderable: true},
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

        $('#delete-form').on('submit', function(e) {
            e.preventDefault();
            var id = $('#deleteid').val();
            $.ajax({
                url: '{{ route("verifikator.delete", ":id") }}'.replace(':id', id),
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#delModal').modal('hide');
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    oTable.ajax.reload();
                    alert('Data berhasil dihapus');
                },
                error: function(xhr) {
                    alert('Gagal menghapus data');
                }
            });
        });
    });


    $(document).ready(function(){
        $("#success_message").delay(9000).slideUp(300);
    });    
    
    //popup html
    $(document).on('click', '[data-bs-toggle="modal"][data-bs-target="#ttdModal"]', function () {
        const imgUrl = $(this).data('img');
        $('#ttdPreview').attr('src', imgUrl);
    });

</script>
<!---->
@endsection
