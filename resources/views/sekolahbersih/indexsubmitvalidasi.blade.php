@extends('layouts/master')
@section('title', 'Submit Validasi Instrumen Sekolah')

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

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="periode" class="form-select">
                                <option value="">-- Pilih Periode --</option>
                                @foreach($periode as $p)
                                    @php
                                        $label = date('d-M-Y', strtotime($p->periode_awal_kuesioner)) . ' s/d ' . date('d-M-Y', strtotime($p->periode_akhir_kuesioner));
                                        $value = $p->periode_awal_kuesioner . ' - ' . $p->periode_akhir_kuesioner;
                                    @endphp
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="status" class="form-select">
                                <option value="">-- Pilih Status --</option>
                                <option value="1">Validasi</option>
                                <option value="0">Belum DiValidasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive-lg">
                        <table id="tabelku" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="2%">No.</th>
                                    {{-- <th width="15%">Sekolah</th> --}}
                                    <th width="25%">Periode</th>
                                    <th width="10%">Tgl Validasi Sekolah</th>
                                    <th width="5%">Nilai Kebersihan</th>
                                    <th width="5%">Keterangan Kebersihan</th>
                                    <th width="9%">Disusun Oleh</th>
                                    <th width="9%">Mengetahui</th>
                                    <th width="24%">Deskripsi</th>
                                    <th width="13%">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                    url: '{{route("sekolahbersih.getDatasubmitValidasi")}}',
                    data: function (d) {
                        d.periode = $('#periode').val();
                        d.status = $('#status').val();
                    }
                },
                columns: [
                    {
                        data: null, sortable: false, render: function (data, type, row, meta) {
                            var i = meta.row + meta.settings._iDisplayStart + 1;
                            return "<a href='show/" + row.id + "' style='text-decoration: none;'>" + i + "</a>"
                        }
                    },
                    { data: 'periode_awal', name: 'periode_awal', searchable: true, orderable: true },
                    { data: 'tanggal_supervisi_verifikasi', name: 'tanggal_supervisi_verifikasi', searchable: true, orderable: true },
                    { data: 'nilai_kebersihan', name: 'nilai_kebersihan', searchable: true, orderable: true },
                    { data: 'keterangan_kebersihan', name: 'keterangan_kebersihan', searchable: true, orderable: true },
                    { data: 'disusun_oleh', name: 'disusun_oleh', searchable: true, orderable: true },
                    { data: 'mengetahui', name: 'mengetahui', searchable: true, orderable: true },
                    { data: 'deskripsi', name: 'deskripsi', searchable: true, orderable: true },
                    { data: 'action', name: 'action' },
                ]
            });

            // Reload saat filter berubah
            $('#periode, #status').on('change', function () {
                oTable.ajax.reload();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });


        $(document).ready(function () {
            $("#success_message").delay(9000).slideUp(300);
        });

    </script>
    <!---->
@endsection