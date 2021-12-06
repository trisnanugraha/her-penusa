<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">User Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                <!-- <?php echo form_open_multipart('', array('class' => 'form-horizontal', 'id' => 'form')) ?> -->
                <input type="hidden" value="" name="id_user" />
                <div class="card-body">
                    <div class="form-group row ">
                        <label for="id_prodi" class="col-sm-4 col-form-label">Program Studi</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="id_prodi" id="id_prodi">
                                <option value="" selected disabled>Pilih Program Studi</option>
                                <?php
                                foreach ($programStudi as $prodi) { ?>
                                    <option value="<?= $prodi->id_prodi; ?>"><?= $prodi->nama_prodi; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="username" class="col-sm-4 col-form-label">Username</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="username" id="username" placeholder="contoh : johndoe">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="full_name" class="col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="full_name" id="full_name" placeholder="contoh : John Doe">
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label for="password" class="col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-8 kosong">
                            <input type="password" class="form-control " name="password" id="password">
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label for="is_active" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="is_active" id="is_active">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Y">Aktif</option>
                                <option value="N">Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="level" class="col-sm-4 col-form-label">Hak Akses</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="level" id="level">
                                <option value="" selected disabled>Pilih Hak Akses</option>
                                <?php
                                foreach ($user_level as $level) { ?>
                                    <option value="<?= $level->id_level; ?>"><?= $level->nama_level; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="imagefile" class="col-sm-4 col-form-label">Foto</label>
                        <div class="col-sm-8">
                            <img id="v_image" width="100px" height="100px">
                            <input type="file" class="form-control btn-file" onchange="loadFile(event)" name="imagefile" id="imagefile" placeholder="Image" value="UPLOAD">
                        </div>
                    </div>
                </div>
                <!-- <?php echo form_close(); ?> -->
            </form>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="batal()" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->