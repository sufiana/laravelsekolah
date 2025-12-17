<div class="modal fade" id="cekjadwalspt" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="Modal Upload" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #8bc34a">
                <h4 class="modal-title" style="color: white">Jadwal SPT Ganda <label id="labelnama"></label></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <form method="POST" id="nospt-form" action="">
                    {!! csrf_field() !!}
                    <input type="hidden" id="idganda" value="" name="idganda"/>
                    <input type="hidden" id="pegawai" value="" name="pegawai"/>
                    <input type="hidden" id="tgl_berangkat" value="" name="tgl_berangkat"/>
                    <input type="hidden" id="tgl_kembali" value="" name="tgl_kembali"/>

                    <div id="kosong" style="font-weight: bold; text-align: center"></div>
                    <div id="responnya" style="font-weight: bold; text-align: center"></div>
                    <table id="myTable" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>NO. SPT / Kode SPT</th>
                            <th>Pegawai</th>
                            <th>Tanggal Berangkat</th>
                        </tr>
                        </thead>
                        <tbody id="isitable" style="font-size: 12px">

                        </tbody>
                    </table>

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
