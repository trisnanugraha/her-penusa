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
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="biodata">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td><b>Nama Lengkap</b></td>
                      <td><?php echo $mahasiswa->nama_lengkap; ?></td>
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
                      <td><b>Lokasi</b></td>
                      <td><?php echo $mahasiswa->lokasi; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="ubah_data">
                <form class="form-horizontal" action="#" id="form_profil">
                  <input type="hidden" value="<?php echo $mahasiswa->id_mahasiswa; ?>" name="id" />
                  <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                    <div class="col-sm-10 kosong">
                      <input type="email" class="form-control" id="nama" name="nama" placeholder="Contoh : John Doe" value="<?php echo $mahasiswa->nama_lengkap; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10 kosong">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Contoh : johndoe@email.com" value="<?php echo $mahasiswa->email; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="no_hp" class="col-sm-2 col-form-label">No. HP</label>
                    <div class="col-sm-10 kosong">
                      <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Contoh : 08123456789" value="<?php echo $mahasiswa->no_hp; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="imagefile" class="col-sm-2 col-form-label">Pass Foto</label>
                    <div class="col-sm-10">
                      <img id="v_image" height="150px" style="margin-bottom: 10px;" src="<?php site_url(); ?>/assets/foto/user/<?php echo $mahasiswa->pass_foto; ?>">
                      <input type="file" class="form-control btn-file" onchange="loadFile(event)" name="imagefile" id="imagefile" placeholder="Image" value="UPLOAD">
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="offset-sm-2 col-sm-10">
                    <button type="button" onclick="simpan()" id="btn_simpan" class="btn btn-success">Simpan</button>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>