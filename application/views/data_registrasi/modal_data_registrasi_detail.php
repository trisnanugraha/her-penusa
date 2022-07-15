<!-- Bootstrap modal -->
<div class="modal fade" id="modal_detail" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">

                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="profile-user-img img-fluid img-circle" id="pass_foto" style="height: 200px; width: auto;" alt="User profile picture">
                                        </div>
                                        <br>
                                        <h3 class="profile-username text-center" name="nama_lengkap"></h3>
                                        <p class="text-muted text-center" name="nim"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills">
                                            <li class="nav-item"><a class="nav-link active" href="#biodata" data-toggle="tab">Biodata</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#berkas" data-toggle="tab">Berkas</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="biodata">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td><b>Status Mahasiswa</b></td>
                                                            <td name="status">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Tahun Angkatan</b></td>
                                                            <td name="tahun_angkatan">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Nama Lengkap</b></td>
                                                            <td name="nama_lengkap">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>NIM</b></td>
                                                            <td name="nim"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Program Studi</b></td>
                                                            <td name="prodi"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Email</b></td>
                                                            <td name="email"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>No. HP</b></td>
                                                            <td name="no_hp"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>No. HP Orang Tua</b></td>
                                                            <td name="no_hp_ortu"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Lokasi</b></td>
                                                            <td name="lokasi"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="berkas">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <td style="width: 30%;"><b>KRS Semester Berjalan</b></td>
                                                            <td name="krs">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>KHS Terakhir</b></td>
                                                            <td name="khs">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Slip Pembayaran</b></td>
                                                            <td name="slip_pembayaran">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->