<div class="modal fade" id="delModal" tabindex="-1" aria-labelledby="delModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e84e40">
                <h4 class="modal-title" style="color: white" id="delModalLabel">Hapus @yield('title') #<label id="labelid"></label></h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="save_msgList"></ul>
                <form method="POST" id="delete-form">
                    @csrf
                    @method('DELETE')

                    <input name='id' id="deleteid" hidden>
                    <h4>Apakah Anda Yakin Akan Menghapus data @yield('title') <strong><label id="labelnama"></label></strong> ?</h4>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" id="btn-delete">Hapus</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
