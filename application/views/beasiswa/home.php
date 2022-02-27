<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <?php
                    if ($role == 'Mahasiswa') {
                        echo '<div class="card-header bg-light">
                        <div class="text-left">
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_beasiswa()" title="Add Data"><i class="fas fa-plus"></i> Tambah Data Beasiswa</button>
                            </div>
                            </div>';
                    }
                    ?>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelbeasiswa" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info text-center">
                                    <th>No.</th>
                                    <?php
                                    if ($role == 'Admin') {
                                        echo '<th>Nama Mahasiswa</th>';
                                    }
                                    ?>
                                    <th>Nama Beasiswa</th>
                                    <th>Sumber</th>
                                    <th>Periode</th>
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
<?php echo $modal_validasi; ?>

<div id="tempat-modal"></div>