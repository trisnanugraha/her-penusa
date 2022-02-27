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
                    <input type="hidden" value="" name="id_kompetisi" />
                    <div class="form-group row ">
                        <label for="nama_kompetisi" class="col-sm-2 col-form-label">Kompetisi</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="nama_kompetisi" id="nama_kompetisi" placeholder="contoh : Pertandingan Karate">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tingkat_prestasi" class="col-sm-2 col-form-label">Tingkat Prestasi</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="tingkat_prestasi" id="tingkat_prestasi" placeholder="contoh : Juara Umum">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_mulai" class="col-sm-2 col-form-label">Tanggal Mulai</label>
                        <div class="col-sm-10 kosong">
                            <input type="date" class="form-control" name="tanggal_mulai">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="tanggal_akhir" class="col-sm-2 col-form-label">Tanggal Akhir</label>
                        <div class="col-sm-10 kosong">
                            <input type="date" class="form-control" name="tanggal_akhir">
                        </div>
                    </div>
                    <input type="hidden" value="" name="file_kompetisi" />
                    <div class="form-group row">
                        <label for="berkas_kompetisi" class="col-sm-2 col-form-label">Berkas</label>
                        <div class="col-sm-10 kosong">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" onchange="load_file(event)" name="berkas_kompetisi" id="berkas_kompetisi">
                                    <label class="custom-file-label" id="label-kompetisi" for="berkas_kompetisi">Pilih File</label>
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