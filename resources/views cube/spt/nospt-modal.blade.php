<div class="modal fade" id="setnosptModal" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Modal Upload" data-backdrop="false">
    <div class="modal-dialog" style="width: 330px">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #8bc34a">
                <h4 class="modal-title" style="color: white">Isi No. SPT #<label id="labelnama"></label></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="nospt-form" action="{{ route('spt.updatenospt') }}">
                    <?php
                    $formatnosurattabel=\App\models\FormatSurat::find(1);
                    $nosurat=$formatnosurattabel->digit_pertama.'/  /'.$formatnosurattabel->digit_berikutnya.'/'.date("Y");
                    ?>
                    {!! csrf_field() !!}
                    <input type="hidden" id="idspt" value="" name="idspt"/>
                    <input type="hidden" id="laman" value="" name="laman"/>
                    <div class="form-group">
                        <div class="row">
                            <label>No. SPT <span class="wajib"></span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fa fa-envelope"></i></div>
                                </div>
                                <input type="text" class="form-control" id="nospt" name="nospt" value="{{$nosurat}}" onfocusout="getnourut()" required>
                                <input type="hidden" class="form-control" id="no_urut" name="no_urut">

                            </div>
                        </div>
                        <br/>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan No. SPT</button> &nbsp;&nbsp;
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function getnourut()
    {
        var nospt= $('#nospt').val();
        var hasil=nospt.replace(/\s/g, '');
        $('#nospt').val(hasil);

        var pos = hasil.indexOf("/") + 1;
        nospt = hasil.slice(pos, hasil.lastIndexOf("/SPT"));
        nourut=parseInt(nospt);
        $('#no_urut').val(nourut);
    }
</script>
