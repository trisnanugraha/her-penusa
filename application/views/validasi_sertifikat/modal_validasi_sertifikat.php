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
                    <input type="hidden" value="" name="id_sertifikat" />
                    <div class="form-group row ">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="nim" id="nim"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="nama_lengkap" id="nama_lengkap"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nama_sertifikat" class="col-sm-2 col-form-label">Nama Sertifikat</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="nama_sertifikat" id="nama_sertifikat"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nomor_sertifikat" class="col-sm-2 col-form-label">Nomor</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="nomor_sertifikat" id="nomor_sertifikat"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_sertifikat" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="tanggal_sertifikat" id="tanggal_sertifikat"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nama_lsp" class="col-sm-2 col-form-label">Nama LSP</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="nama_lsp" id="nama_lsp"></p>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="masa_berlaku" class="col-sm-2 col-form-label">Masa Berlaku</label>
                        <div class="col-sm-10">
                            <p class="form-control my-0" name="masa_berlaku" id="masa_berlaku"></p>
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
                <div class="text-right">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" onclick="batal()" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->