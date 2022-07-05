<section class="content">
    <div class="container-fluid">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Pengumuman</h3>
            </div>
            <div class="card-body">
                <?php
                foreach ($informasi as $i) {
                    echo $i->deskripsi;
                }
                ?>
            </div>
        </div>
    </div>
    <!-- /.row -->
</section>