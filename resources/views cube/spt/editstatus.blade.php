<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Modal Update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #03a9f4">
                <h4 class="modal-title" style="color: white">Verifikasi @yield('title') #<label id="labelid"></label></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">

                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Error!</strong>Verifikasi Data @yield('title') Gagal
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Berhasil!</strong>Verifikasi Data @yield('title') Berhasil
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <i>Bagian Bertanda <span class="wajib"></span> wajib diisi</i>
                <ul id="save_msgList"></ul>
                <form action=""  method="POST" id="edit_form" class="form-horizontal">
                    @csrf
                    <input type="hidden" id="idedit" name="idedit" />

                    <div class="row">
                        <div class="form-group col-6">
                            <label>Verifikasi Di terima<span class="wajib"></label>
                        </div>
                        <div class="float-left">
                            <div class="onoffswitch onoffswitch-success">
                                <input type="checkbox" name="status" class="onoffswitch-checkbox" id="status" value="1"  onchange="aktiffunc()">
                                <label class="onoffswitch-label" for="status">
                                    <div class="onoffswitch-inner"></div>
                                    <div class="onoffswitch-switch"></div>
                                </label>
                            </div>
                        </div>
                        <input type='hidden' value='0' name="statusdefault" id="statusdefault">
                    </div>

                    <div class="row alasan" id="alasan" style="display: none">
                        <label>Alasan Penolakan <span class="wajib"></label>
                        <textarea class="form-control" id="alasan_penolakan" rows="3" name="alasan_penolakan"></textarea>
                    </div>

                    <br/>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary tambah" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
