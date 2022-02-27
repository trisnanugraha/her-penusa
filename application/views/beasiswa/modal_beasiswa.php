<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
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
                    <input type="hidden" value="" name="id_beasiswa" />
                    <div class="form-group row ">
                        <label for="nama_beasiswa" class="col-sm-2 col-form-label">Nama Beasiswa</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="nama_beasiswa" id="nama_beasiswa" placeholder="contoh : Beasiswa Unggulan">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="sumber" class="col-sm-2 col-form-label">Sumber</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="sumber" id="sumber" placeholder="contoh : Kemendikbud">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="periode" id="periode" placeholder="contoh : 2020">
                        </div>
                    </div>
                    <input type="hidden" value="" name="file_beasiswa" />
                    <div class="form-group row">
                        <label for="berkas_beasiswa" class="col-sm-2 col-form-label">Berkas</label>
                        <div class="col-sm-10 kosong">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" onchange="load_file(event)" name="berkas_beasiswa" id="berkas_beasiswa">
                                    <label class="custom-file-label" id="label-beasiswa" for="berkas_beasiswa">Pilih File</label>
                                </div>
                                <div class="input-group-append">
                                    <a class="btn btn-block bg-gradient-info" id="view_file" href="" target="_blank">Preview</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" id="btnCancel" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->