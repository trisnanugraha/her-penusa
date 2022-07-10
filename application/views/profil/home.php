<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" style="height: 200px; width: auto;" src="<?php site_url(); ?>/assets/foto/user/<?php echo $mahasiswa->pass_foto; ?>" alt="User profile picture">
            </div>
            <br>
            <h3 class="profile-username text-center"><?php echo $mahasiswa->nama_lengkap; ?></h3>
            <p class="text-muted text-center"><?php echo $mahasiswa->nim; ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#biodata" data-toggle="tab">Biodata</a></li>
              <li class="nav-item"><a class="nav-link" href="#ubah_data" data-toggle="tab">Ubah Data</a></li>
              <li class="nav-item"><a class="nav-link" href="#ubah_password" data-toggle="tab">Ubah Password</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="biodata">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td><b>Status Mahasiswa</b></td>
                      <td><?php if ($mahasiswa->status == 'Y') { ?>
                          <div class="badge bg-success text-white text-wrap">Aktif</div>
                        <?php } else { ?>
                          <div class="badge bg-warning text-white text-wrap">Tidak Aktif</div>
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Tahun Angkatan</b></td>
                      <td>
                        <?php echo $mahasiswa->tahun_angkatan; ?>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Nama Lengkap</b></td>
                      <td>
                        <?php echo $mahasiswa->nama_lengkap; ?>
                      </td>
                    </tr>
                    <tr>
                      <td><b>NIM</b></td>
                      <td><?php echo $mahasiswa->nim; ?></td>
                    </tr>
                    <tr>
                      <td><b>Program Studi</b></td>
                      <td><?php echo $mahasiswa->prodi; ?></td>
                    </tr>
                    <tr>
                      <td><b>Email</b></td>
                      <td><?php echo $mahasiswa->email; ?></td>
                    </tr>
                    <tr>
                      <td><b>No. HP</b></td>
                      <td><?php echo $mahasiswa->no_hp; ?></td>
                    </tr>
                    <tr>
                      <td><b>No. HP Orang Tua</b></td>
                      <td><?php echo $mahasiswa->no_hp_ortu; ?></td>
                    </tr>
                    <tr>
                      <td><b>Lokasi</b></td>
                      <td><?php echo $mahasiswa->lokasi; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="ubah_data">
                <form class="form-horizontal" action="#" id="form_profil">
                  <input type="hidden" value="<?php echo $mahasiswa->id_mahasiswa; ?>" name="id" />
                  <div class="form-group">
                    <label for="nama" class="col-form-label">Nama Lengkap</label>
                    <div class="kosong">
                      <input type="email" class="form-control" id="nama" name="nama" placeholder="Contoh : John Doe" value="<?php echo $mahasiswa->nama_lengkap; ?>" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-form-label">Email<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Contoh : johndoe@email.com" value="<?php echo $mahasiswa->email; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_hp" class="col-form-label">No. HP<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Contoh : 08123456789" value="<?php echo $mahasiswa->no_hp; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_hp_ortu" class="col-form-label">No. HP Orang Tua<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="text" class="form-control" id="no_hp_ortu" name="no_hp_ortu" placeholder="Contoh : 08123456789" value="<?php echo $mahasiswa->no_hp_ortu; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="imagefile" class="col-form-label">Pass Foto<span style="color: red;">*</span></label>
                    <div class="">
                      <img id="v_image" height="150px" style="margin-bottom: 10px;" src="<?php site_url(); ?>/assets/foto/user/<?php echo $mahasiswa->pass_foto; ?>">
                      <input type="file" class="form-control btn-file" onchange="loadFile(event)" name="imagefile" id="imagefile" placeholder="Image" value="UPLOAD">
                    </div>
                  </div>
                </form>
                <div>
                  <button type="button" onclick="simpan()" id="btn_simpan" class="btn btn-success">Simpan</button>
                </div>
              </div>
              <div class="tab-pane" id="ubah_password">
                <form class="form-horizontal" action="#" id="form_password">
                  <input type="hidden" value="<?php echo $mahasiswa->id_mahasiswa; ?>" name="id" />
                  <div class="form-group">
                    <label for="password_lama" class="col-form-label">Masukkan Password Lama<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="password" class="form-control" id="password_lama" name="password_lama">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password_baru" class="col-form-label">Masukkan Password Baru<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="password" class="form-control" id="password_baru" name="password_baru">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="verify_pass" class="col-form-label">Verifikasi Password Baru<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="password" class="form-control" id="verify_pass" name="verify_pass">
                    </div>
                  </div>
                </form>
                <div>
                  <button type="button" onclick="simpan_pass()" id="btn_simpan_pass" class="btn btn-success">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>