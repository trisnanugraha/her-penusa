<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        table = $("#tabelbeasiswa").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Beasiswa Masih Kosong"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('beasiswa/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0, 1, 2, 3, 4, 5],
                    "className": 'text-center'
                }, {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },
                {
                    "targets": [-2], //status lppm
                    "render": function(data, type, row) {
                        if (row[4] == "Y") {
                            return "<div class=\"badge bg-success text-white text-wrap\">Disetujui</div>"
                        } else if (row[4] == "N") {
                            return "<div class=\"badge bg-danger text-white text-wrap\">Ditolak</div>"
                        } else if (row[4] == "P") {
                            return "<div class=\"badge bg-info text-white text-wrap\">Diproses</div>"
                        }
                    }
                }, {
                    "targets": [-1], //last column
                    "render": function(data, type, row) {
                        if (row[6] == 'Admin') {
                            return "<a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Validasi\" onclick=\"validasi_beasiswa(" + row[5] + ")\"><i class=\"fas fa-eye\"></i> Validasi</a>";
                        } else {
                            if (row[4] == "Y" || row[4] == "P") {
                                return "<a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"detail_beasiswa(" + row[5] + ")\"><i class=\"fas fa-eye\"></i> Detail</a>";
                            } else {
                                return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit_beasiswa(" + row[5] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\" onclick=\"delete_beasiswa(" + row[5] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>";
                            }
                        }
                    },
                    "orderable": false, //set not orderable
                },
            ],
        });
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        $("textarea").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        $("select").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });

        $('#berkas_beasiswa').change(function(e) {
            var laporan = e.target.files[0].name;
            $('#label-beasiswa').html(laporan);
        });
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    //delete
    function delete_beasiswa(id) {

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: "Apakah Anda Yakin Ingin Menghapus Data Ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data Ini!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('beasiswa/delete'); ?>",
                    type: "POST",
                    data: "id_beasiswa=" + id,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Beasiswa Berhasil Dihapus!'
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Delete Error!!.'
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }

    function add_beasiswa() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Beasiswa'); // Set Title to Bootstrap modal title
    }

    function edit_beasiswa(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('beasiswa/get_beasiswa') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id_beasiswa"]').val(data.id_beasiswa);
                $('[name="nama_beasiswa"]').val(data.nama_beasiswa);
                $('[name="sumber"]').val(data.sumber_beasiswa);
                $('[name="periode"]').val(data.periode);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Data Beasiswa'); // Set title to Bootstrap modal title
                if (data.berkas != '') {
                    var lokasi_file = "<?php echo base_url('upload/skpi/beasiswa/') ?>"
                    $('#view_file').attr("href", lokasi_file + data.berkas);
                    $('[name="file_beasiswa"]').val(data.berkas);
                } else {
                    $('#view_file').attr("href", '');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function validasi_beasiswa(id) {
        var lokasi_file;
        $('#form_validate')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('beasiswa/get_beasiswa') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_beasiswa"]').val(data.id_beasiswa);
                $('[name="nama_beasiswa"]').text(data.nama_beasiswa);
                $('[name="sumber"]').text(data.sumber_beasiswa);
                $('[name="periode"]').text(data.periode);
                $('[name="status"]').val(data.status);
                $('[name="komentar"]').val(data.komentar);
                if (data.berkas == '' || data.berkas == null) {
                    lokasi_file = "<?php echo base_url() ?>";
                    $('#berkas').attr("href", lokasi_file);
                } else {
                    lokasi_file = "<?php echo base_url('upload/skpi/beasiswa/') ?>";
                    $('#berkas').attr("href", lokasi_file + data.berkas);
                }
                $('#modal_validasi').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Validasi Data Beasiswa'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function detail_beasiswa(id) {
        $.ajax({
                method: "POST",
                url: "<?php echo base_url('beasiswa/detail'); ?>",
                data: "id_beasiswa=" + id,
            })
            .done(function(data) {
                $('#tempat-modal').html(data);
                $('.modal-title').text('Detail Data Beasiswa');
                $('#modal_detail').modal('show');
            })
    }

    function save() {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = "<?php echo site_url('beasiswa/insert') ?>";
        } else {
            url = "<?php echo site_url('beasiswa/update') ?>";
        }

        var formdata = new FormData($('#form')[0]);

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: formdata,
            dataType: "JSON",
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    $('#modal_validasi').modal('hide');
                    reload_table();
                    if (save_method == 'add') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Beasiswa Berhasil Disimpan!'
                        });
                    } else if (save_method == 'update') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Beasiswa Berhasil Diubah!'
                        });
                    }
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnCancel').text('Batal'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('Simpan'); //change button text
                $('#btnCancel').text('Batal'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function validate() {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 

        var url = "<?php echo site_url('beasiswa/validate') ?>";

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form_validate').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_validasi').modal('hide');
                    reload_table();
                    Toast.fire({
                        icon: 'success',
                        title: 'Data Beasiswa Berhasil Divalidasi!'
                    });
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnCancel').text('Batal'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('Simpan'); //change button text
                $('#btnCancel').text('Batal'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    var load_file = function(event) {
        var file = document.getElementById('view_file');
        file.href = URL.createObjectURL(event.target.files[0]);
    };
</script>