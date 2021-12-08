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
            <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" value="" name="id_mhs" />
                <div class="card-body">
                    <div class="form-group row ">
                        <label for="nim" class="col-sm-4 col-form-label">NIM</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="nim" id="nim" placeholder="contoh : 20200801001">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nama" class="col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="contoh : John Doe">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="mail" class="col-sm-4 col-form-label">E-Mail</label>
                        <div class="col-sm-8 kosong">
                            <input type="email" class="form-control" name="mail" id="mail" placeholder="contoh : johndoe@example.com">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="telepon" class="col-sm-4 col-form-label">No. Hp</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="telepon" id="telepon" placeholder="contoh : 08123456789">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="prodi" class="col-sm-4 col-form-label">Program Studi</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="prodi" id="prodi">
                                <option value="" selected disabled>Pilih Program Studi</option>
                                <?php
                                foreach ($prodi as $p) { ?>
                                    <option value="<?= $p->id_prodi; ?>"><?= $p->nama_prodi; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="angkatan" class="col-sm-4 col-form-label">Angkatan</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="angkatan" id="angkatan">
                                <option value="" selected disabled>Pilih Angkatan</option>
                                <?php
                                foreach ($angkatan as $a) { ?>
                                    <option value="<?= $a->id_angkatan; ?>"><?= $a->tahun_angkatan; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="lokasi" class="col-sm-4 col-form-label">Lokasi</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="lokasi" id="lokasi">
                                <option value="" selected disabled>Pilih Lokasi Gedung</option>
                                <option value="LP">Lubuk Pakam</option>
                                <option value="M">Medan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="password" class="col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-8 kosong">
                            <input type="password" class="form-control" name="password" id="password">
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
                    <div class="form-group row ">
                        <label for="imagefile" class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8">
                            <img id="v_image" width="100px" height="100px" class="mb-2">
                            <input type="file" class="form-control btn-file" onchange="loadFile(event)" name="imagefile" id="imagefile" placeholder="Image" value="UPLOAD">
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="imagefile" class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8">
                            <img id="v_image" width="100px" height="100px" class="mb-2">
                            <div class="custom-file">
                                <input type="file" class="form-control btn-file" onchange="loadFile(event)" name="imagefile" id="imagefile" placeholder="Image" value="Upload Foto">
                                <label class="custom-file-label" id="label-foto" for="imagefile">Pilih File</label>
                            </div>
                        </div>
                    </div> -->
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="batal()" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->