<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form" class="form-horizontal">
                <input type="hidden" value="" name="id_angkatan" />
                <div class="card-body">
                    <div class="form-group row ">
                        <label for="thn_angkatan" class="col-sm-4 col-form-label">Tahun Angkatan</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="thn_angkatan" id="thn_angkatan" placeholder="Misal 2017">
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