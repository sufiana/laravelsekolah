<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Modal Upload" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e84e40">
                <h4 class="modal-title" style="color: white">Hapus @yield('title') #<label id="labelid"></label></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <ul id="save_msgList"></ul>
                <form method="POST" id="delete-form" action="javascript:void(0)">
                    {{ csrf_field() }}
                    @method('DELETE')

                    <input name='id' id="deleteid" hidden>
                    <h4>Apakah Anda Yakin Akan Menghapus data @yield('title') <strong><label id="labelnama"></label></strong> ?</h4>

<!--                    <div class="form-group">-->
<!--                        <label for="exampleInputEmail1">Email address</label>-->
<!--                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label for="exampleInputPassword1">Password</label>-->
<!--                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">-->
<!--                    </div>-->
<!--                    <div class="form-group">-->
<!--                        <label for="exampleTextarea">Textarea</label>-->
<!--                        <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>-->
<!--                    </div>-->
<!--                    <div class="form-inline form-inline-box">-->
<!--                        <div class="form-group">-->
<!--                            <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Enter email">-->
<!--                        </div>-->
<!--                        <div class="form-group">-->
<!--                            <select class="form-control">-->
<!--                                <option>Active</option>-->
<!--                                <option>Inactive</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                        <button type="submit" class="btn btn-link"><i class="fa fa-eye"></i> Preview</button>-->
<!--                    </div>-->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger" id="btn-delete">Hapus</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
