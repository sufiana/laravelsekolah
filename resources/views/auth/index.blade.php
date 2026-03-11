@extends('layouts/master')
@section('title', 'List Registrasi User')

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
                </div>

                <div class="card-body">
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6 d-flex align-items-center">
                            <label for="customLength" class="me-2 mb-0">Tampilkan:</label>
                            <select id="customLength" class="form-select form-select-sm w-auto">
                                <option value="10">10</option>
                                <option value="25" selected>25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span class="ms-2">data</span>
                        </div>
                        <div class="col-md-6 text-end">
                            <input type="text" id="customSearch" class="form-control form-control-sm w-50 d-inline-block"
                                placeholder="Cari...">
                        </div>
                    </div>

                    {{-- filter --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="row" id="popoverPwd-container">
                                <div class="form-group col-md-12">
                                    <label for="popoverName">Jabatan </label>
                                    <div class="form-group">
                                        <select id="role" class="form-select">
                                            <option value="">-- Semua Jabatan --</option>
                                            @foreach ($role as $r)
                                                <option value="{{ $r->id }}">{{ $r->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row" id="popoverPwd-container">
                                <div class="form-group col-md-12">
                                    <label for="popoverName">Sekolah </label>
                                    <div class="form-group">
                                        <select id="sekolah" class="form-select">
                                            <option value="">-- Semua Sekolah --</option>
                                            @foreach ($sekolah as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="row" id="popoverPwd-container">
                                <div class="form-group col-md-12">
                                    <label for="popoverName">Kabupaten/Kota </label>
                                    <div class="form-group">
                                        <select id="kabupaten" class="form-select">
                                            <option value="">-- Semua Kabupaten/Kota --</option>
                                            @foreach ($kabupaten as $k)
                                                <option value="{{ $k->kode_kabupaten }}">{{ $k->nama_kabupaten }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row" id="popoverPwd-container">
                                <div class="form-group col-md-12">
                                    <label for="popoverName">CABDIS </label>
                                    <div class="form-group">
                                        <select id="cabdis" class="form-select">
                                            <option value="">-- CABDIS--</option>
                                            @foreach ($cabdis as $c)
                                                <option value="{{ $c->id }}">{{ $c->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive-lg">
                        <table id="tabelku" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20">No.</th>
                                    <th>Nama User</th>
                                    <th>Email</th>
                                    <th>Jabatan</th>
                                    <th>Sekolah</th>
                                    <th>Cabdis</th>
                                    <th>Kab/Kota</th>
                                    <th width="20">Status</th>
                                    <th width="40">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('manajemenbiaya.delete-modal')

@endsection

@section('css')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.7.1/css/autoFill.dataTables.min.css">

    {{--
    <link rel="stylesheet"
        href="{{ asset('assets/themes') }}/components/datatables.net-bs4/css/dataTables.bootstrap4.min.css"> --}}
    <style>
        .table thead tr th {
            background-color: #0D6EFD !important;
            color: #FFF !important;
            text-align: center;
            /* optional */
            vertical-align: middle;
            /* optional */
            border: 1px solid #dee2e6
        }

        .table td,
        .table th {
            border: 1px solid #dee2e6;
            padding: .5rem;
            vertical-align: top;
            font-size: 12px;
        }

        div.dataTables_length,
        div.dataTables_filter {
            display: none;
        }
    </style>


@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

    {{--
    <script src="{{ asset('assets/themes') }}/components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/themes') }}/components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/themes') }}/components-custom/modal-animations/modalEffects.js"></script> --}}

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
                ajax: {
                    url: '{{route("register.getData")}}',
                    data: function (d) {
                        d.id_sekolah = $('#sekolah').val();
                        // STATUS KEBERSIHAN
                        d.role = $('#role').val();
                        // HASIL REKOMENDASI
                        d.binaan_kabkota = $('#kabupaten').val();
                        d.cabdis = $('#cabdis').val();
                    }
                },
                columns: [
                    {
                        data: null, sortable: false, render: function (data, type, row, meta) {
                            var i = meta.row + meta.settings._iDisplayStart + 1;
                            return "<a href='show/" + row.id + "' style='text-decoration: none;'>" + i + "</a>"
                        }
                    },
                    { data: 'username', name: 'username', searchable: true, orderable: true },
                    { data: 'email', name: 'email', searchable: true, orderable: true },
                    { data: 'role', name: 'role', searchable: true, orderable: true },
                    { data: 'id_sekolah', name: 'id_sekolah', searchable: true, orderable: true },
                    { data: 'cabdis', name: 'cabdis', searchable: true, orderable: true },
                    { data: 'binaan_kabkota', name: 'binaan_kabkota', searchable: true, orderable: true },
                    { data: 'action', name: 'action' },
                ]
            });
            $('#sekolah, #role, #kabupaten, #cabdis').on('change', function () {
                oTable.ajax.reload();
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
                var url = '{{ route("sekolahbersih.delete", ":id") }}';
                $.ajax({
                    url: url.replace(':id', Id),
                    data: { _token: '{{csrf_token()}}' },
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


        $(document).ready(function () {
            $("#success_message").delay(9000).slideUp(300);
        });

    </script>
    <!---->
@endsection