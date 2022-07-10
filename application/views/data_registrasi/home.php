    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-light">
                <div class="text-left">
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_data()" title="Add Data"><i class="fas fa-plus"></i> Tambah Data Baru</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabelregistrasi" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info text-center">
                      <th>No.</th>
                      <th>Semester</th>
                      <th>IP Terakhir</th>
                      <th>Tipe Pembayaran</th>
                      <th>Tanggal Registrasi</th>
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

    <?php echo $modal; ?>