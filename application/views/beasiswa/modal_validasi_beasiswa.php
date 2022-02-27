<!-- Bootstrap modal -->
<div class="modal fade" id="modal_validasi" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form_validate" class="form-horizontal">
                    <input type="hidden" value="" name="id_beasiswa" />
                    <div class="form-group row ">
                        <label for="nama_beasiswa" class="col-sm-2 col-form-label">Nama Beasiswa</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="nama_beasiswa" id="nama_beasiswa"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="sumber" class="col-sm-2 col-form-label">Sumber</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="sumber" id="sumber"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="periode" id="periode"></p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="berkas" class="col-sm-2 col-form-label">Berkas</label>
                        <div class="col-sm-2">
                            <a class="btn btn-block bg-gradient-info" id="berkas" href="" target="_blank">Preview</a>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status" id="status">
                                <option value="P">Diproses</option>
                                <option value="Y">Disetujui</option>
                                <option value="N">Ditolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="komentar" class="col-sm-2 col-form-label">Komentar</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="komentar" id="komentar" rows="5" style="resize: none;"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="validate()" class="btn btn-primary">Simpan</button>
                <button type="button" id="btnCancel" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->