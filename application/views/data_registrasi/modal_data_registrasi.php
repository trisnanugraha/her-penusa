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
                <input type="hidden" value="" name="id_jadwal_registrasi" />
                <div class="card-body">
                    <div class="form-group row ">
                        <label for="thn_akademik" class="col-sm-4 col-form-label">Tahun Akademik</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="thn_akademik" id="thn_akademik" placeholder="Misal 2021-1">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_mulai" class="col-sm-4 col-form-label">Tanggal Mulai</label>
                        <div class="col-sm-8 kosong">
                            <input type="date" class="form-control" name="tgl_mulai">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_akhir" class="col-sm-4 col-form-label">Tanggal Akhir</label>
                        <div class="col-sm-8 kosong">
                            <input type="date" class="form-control" name="tgl_akhir">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="status" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="status" id="status">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Y">Aktif</option>
                                <option value="N">Non-Aktif</option>
                            </select>
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