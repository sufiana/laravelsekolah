<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Modal Create">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #1abc9c">
                <h4 class="modal-title" style="color: white">Tambah Data @yield('title')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Error!</strong>Data @yield('title') Gagal Di Tambah
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Berhasil!</strong>Data @yield('title') Berhasil Di Tambah
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <i>Bagian Bertanda <span class="wajib"></span> wajib diisi</i>
                <ul id="save_msgList"></ul>
                <form action=""  method="POST" id="add_form" class="form-horizontal">
                    @csrf
                    <div class="form-group row">
                        <label for="Warna" class="col-sm-4 col-form-label">Kode @yield('title') <span class="wajib"></span> </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode @yield('title')" required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Warna" class="col-sm-4 col-form-label">Nama @yield('title') <span class="wajib"></span> </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama @yield('title')" required="">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Warna" class="col-sm-4 col-form-label">Tahun @yield('title') <span class="wajib"></span> </label>
                        <div class="col-sm-8">
                            <select name="tahun" id="tahun" class="form-control" required>
                                <option value="">== Pilih Tahun ==</option>
                                @php
                                $tahun=date('Y');
                                $tahunawal=$tahun-25;
                                @endphp
                                @foreach(array_combine(range(date("Y"), $tahunawal), range(date("Y"), $tahunawal)) as $year)
                                <option value="{{$year}}" {{(old('tahun') == $year ?'selected':'')}}>{{$year}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="Deskripsi" class="col-sm-4 col-form-label">Deskripsi @yield('title')</label>
                        <div class="col-sm-8">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi @yield('title')" rows="3"></textarea>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary tambah" type="submit">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
