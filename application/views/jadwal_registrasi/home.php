    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-light">
                <div class="text-left">
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_jadwal()" title="Add Data"><i class="fas fa-plus"></i> Tambah Jadwal</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="tabeljadwal" class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr class="bg-info text-center">
                      <th>No.</th>
                      <th>Tahun Akademik</th>
                      <th>Tanggal Mulai</th>
                      <th>Tanggal Akhir</th>
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

    <?php echo $modal; ?>