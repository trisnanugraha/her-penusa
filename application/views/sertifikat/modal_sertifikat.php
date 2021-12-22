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
                        <label for="nama_sertifikat" class="col-sm-2 col-form-label">Nama Sertifikat</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="nama_sertifikat" id="nama_sertifikat" placeholder="contoh : Junior Netwok Administrator">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nomor_sertifikat" class="col-sm-2 col-form-label">Nomor</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="nomor_sertifikat" id="nomor_sertifikat" placeholder="contoh : 001.0001.000001">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_sertifikat" class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10 kosong">
                            <input type="date" class="form-control" name="tanggal_sertifikat">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nama_lsp" class="col-sm-2 col-form-label">Nama LSP</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="nama_lsp" id="nama_lsp" placeholder="contoh : LSP BPPTIK">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="masa_berlaku" class="col-sm-2 col-form-label">Masa Berlaku</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="masa_berlaku" id="masa_berlaku" placeholder="contoh : 3 Tahun">
                        </div>
                    </div>
                    <input type="hidden" value="" name="file_sertifikat" />
                    <div class="form-group row">
                        <label for="berkas_sertifikat" class="col-sm-2 col-form-label">Berkas</label>
                        <div class="col-sm-10 kosong">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" onchange="load_file(event)" name="berkas_sertifikat" id="berkas_sertifikat">
                                    <label class="custom-file-label" id="label-sertifikat" for="berkas_sertifikat">Pilih File</label>
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