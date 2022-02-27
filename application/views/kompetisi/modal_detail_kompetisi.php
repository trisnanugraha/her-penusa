<!-- Bootstrap modal -->
<div class="modal fade" id="modal_detail" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id_kompetisi" />
                    <div class="form-group row ">
                        <label for="nama_kompetisi" class="col-sm-2 col-form-label">Kompetisi</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="nama_kompetisi" id="nama_kompetisi"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tingkat_prestasi" class="col-sm-2 col-form-label">Tingkat Prestasi</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="tingkat_prestasi" id="tingkat_prestasi"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_mulai" class="col-sm-2 col-form-label">Tanggal Mulai</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="tanggal_mulai" id="tanggal_mulai"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_akhir" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="tanggal_akhir" id="tanggal_akhir"></p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="berkas" class="col-sm-2 col-form-label">Berkas</label>
                        <div class="col-sm-2">
                            <a class="btn btn-block btn-info" id="berkas" href="" target="_blank">Preview</a>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="status" id="status"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="komentar" class="col-sm-2 col-form-label">Komentar</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="komentar" id="komentar" rows="5" style="resize: none;" readonly></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <button class="btn btn-primary" onclick="tutup()" data-dismiss="modal"> Tutup</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->