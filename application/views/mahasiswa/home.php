<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header bg-light">
            <div class="text-left">
              <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_mhs()" title="Add Data"><i class="fas fa-plus"></i> Tambah Mahasiswa</button>
              <a href="<?php echo base_url('mahasiswa/download') ?>" type="button" class="btn btn-sm btn-outline-info" target="_blank" id="export_mhs" title="Export Data"><i class="fas fa-download"></i> Export Data</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="tabelmhs" class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="bg-info text-center">
                  <th>No</th>
                  <th>NIM</th>
                  <th>Nama Lengkap</th>
                  <th>Program Studi</th>
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