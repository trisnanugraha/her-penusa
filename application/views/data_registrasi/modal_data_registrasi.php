<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form" class="form-horizontal">
                <input type="hidden" value="" name="id_data_registrasi" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group row ">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nama" id="nama" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="nim" id="nim" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tgl_akhir" class="col-sm-3 col-form-label">No. HP Aktif</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="no_hp" id="no_hp" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-group row">
                                    <label for="email" class="col-sm-3 col-form-label">Email Aktif</label>
                                    <div class="col-sm-9">
                                        <input type="email" class="form-control" name="email" id="email" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="prodi" class="col-sm-3 col-form-label">Program Studi</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="prodi" id="prodi" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="lokasi" class="col-sm-3 col-form-label">Lokasi Gedung</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="lokasi" id="lokasi" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="semester" class="col-sm-3 col-form-label">Semester<span style="color: red;">*</span></label>
                                <div class="col-sm-8 kosong">
                                    <input type="number" class="form-control" name="semester" id="semester">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="ip" class="col-sm-3 col-form-label">IP Terakhir (Opsional)</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="ip" id="ip">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="tipe_pembayaran" class="col-form-label">Tipe Pembayaran<span style="color: red;">*</span></label>
                                <div class="kosong">
                                    <select class="form-control" name="tipe_pembayaran" id="tipe_pembayaran">
                                        <option value="" selected disabled>Pilih Tipe Pembayaran</option>
                                        <option value="A1">A (Non-Beasiswa)</option>
                                        <option value="A2">A (Beasiswa 25%)</option>
                                        <option value="A3">A (Beasiswa 40%)</option>
                                        <option value="A4">A (Beasiswa 50%)</option>
                                        <option value="A5">A (Beasiswa 75%)</option>
                                        <option value="A6">A (Beasiswa 100%)</option>
                                        <option value="B1">B (Non-Beasiswa)</option>
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" value="" name="file_krs" />
                            <div class="form-group">
                                <label for="berkas_krs" class="col-form-label">KRS Semester Berjalan<span style="color: red;">*</span></label>
                                <div class="">
                                    <div class="input-group" name="krs">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" onchange="load_file_krs(event)" name="berkas_krs" id="berkas_krs">
                                            <label class="custom-file-label" id="label-krs" for="berkas_krs">Pilih File</label>
                                        </div>
                                        <div class="input-group-append">
                                            <a class="btn btn-block bg-gradient-info" id="view_file_krs" href="" target="_blank">Preview</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="" name="file_khs" />
                            <div class="form-group">
                                <label for="berkas_khs" class="col-form-label">KHS Terakhir<span style="color: red;">*</span></label>
                                <div class="">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" onchange="load_file_khs(event)" name="berkas_khs" id="berkas_khs">
                                            <label class="custom-file-label" id="label-khs" for="berkas_khs">Pilih File</label>
                                        </div>
                                        <div class="input-group-append khs">
                                            <a class="btn btn-block bg-gradient-info" id="view_file_khs" href="" target="_blank">Preview</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="" name="file_pembayaran" />
                            <div class="form-group">
                                <label for="berkas_pembayaran" class="col-form-label">Slip Kwitansi Cicilan UK/Surat Pernyataan Penerimaan Beasiswa Pengganti Slip Kwitansi/Pembayaran Bagi Mahasiswa Beasiswa 100%<span style="color: red;">*</span></label>
                                <div class="">
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" onchange="load_file_pembayaran(event)" name="berkas_pembayaran" id="berkas_pembayaran">
                                            <label class="custom-file-label" id="label-pembayaran" for="berkas_pembayaran">Pilih File</label>
                                        </div>
                                        <div class="input-group-append pembayaran">
                                            <a class="btn btn-block bg-gradient-info" id="view_file_pembayaran" href="" target="_blank">Preview</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
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