<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_tolak" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form_tolak" class="form-horizontal">
                <input type="hidden" value="" name="id_registrasi" />
                <div class="modal-body form">
                    <div class="form-group row">
                        <label for="perihal" class="col-sm-2 col-form-label">Alasan</label>
                        <div class="col-sm-10 kosong">
                            <textarea class="form-control" name="komentar" id="komentar" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->