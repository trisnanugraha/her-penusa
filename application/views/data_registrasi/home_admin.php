    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <?php
            if ($role == 'Mahasiswa' & $isUpload->pass_foto == NULL) { ?>
              <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>
                Anda Belum Upload Pass Foto 3x4 Pada Profil Anda. Silakan Update Terlebih Dahulu Sebelum Melakukan Registrasi. <a href="<?php echo site_url('profil'); ?>">Klik Disini Untuk Melakukan Update</a>
              </div>
            <?php }
            ?>

            <div class="card">
              <?php if ($isInput != 1 && $jadwal->status == 'Y' && $role != 'Admin' && $isUpload->pass_foto != NULL) {
              ?>
                <div class="card-header bg-light">
                  <div class="text-left">
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_data()" title="Add Data"><i class="fas fa-plus"></i> Tambah Data Baru</button>
                  </div>
                </div>
              <?php }; ?>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabelregistrasi" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info text-center">
                      <th>No.</th>
                      <th>TA</th>
                      <th>NIM</th>
                      <th>Nama Lengkap</th>
                      <th>Prodi</th>
                      <th>Lokasi</th>
                      <!-- <th>No. HP</th>
                      <th>Email</th> -->
                      <th>Status</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>


    <?php echo $modal_detail; ?>
    <?php echo $modal_tolak; ?>