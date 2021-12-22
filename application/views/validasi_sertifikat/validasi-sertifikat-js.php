<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        table = $("#tabelsertifikat").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Sertifikat Masih Kosong"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('validasi_sertifikat/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                    "targets": [0, 1, 2, 3, 4, 5, 6, 7],
                    "className": 'text-center'
                }, {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                },
                {
                    "targets": [-2], //status lppm
                    "render": function(data, type, row) {
                        if (row[6] == "Y") {
                            return "<div class=\"badge bg-success text-white text-wrap\">Disetujui</div>"
                        } else if (row[6] == "N") {
                            return "<div class=\"badge bg-danger text-white text-wrap\">Ditolak</div>"
                        } else if (row[6] == "P") {
                            return "<div class=\"badge bg-info text-white text-wrap\">Diproses</div>"
                        }
                    }
                }, {
                    "targets": [-1], //last column
                    "render": function(data, type, row) {
                        return "<a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Validasi\" onclick=\"validasi_sertifikat(" + row[7] + ")\"><i class=\"fas fa-eye\"></i> Validasi</a>";
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

    function validasi_sertifikat(id) {
        save_method = 'validasi';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('validasi_sertifikat/get_sertifikat') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id_sertifikat"]').val(data.id_sertifikat);
                $('[name="nim"]').text(data.nim);
                $('[name="nama_lengkap"]').text(data.nama_lengkap);
                $('[name="nama_sertifikat"]').text(data.nama_sertifikat);
                $('[name="nomor_sertifikat"]').text(data.nomor_sertifikat);
                $('[name="tanggal_sertifikat"]').text(data.tanggal_sertifikat);
                $('[name="nama_lsp"]').text(data.nama_lsp);
                $('[name="masa_berlaku"]').text(data.masa_berlaku);
                $('[name="status"]').val(data.status);
                $('[name="komentar"]').val(data.komentar);
                if (data.berkas == '' || data.berkas == null) {
                    $('#berkas').attr("href", '');
                } else {
                    var lokasi_file = "<?php echo base_url('upload/skpi/sertifikat/') ?>"
                    $('#berkas').attr("href", lokasi_file + data.berkas);
                }
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Validasi Data Sertifikat'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function save() {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'validasi') {
            url = "<?php echo site_url('validasi_sertifikat/update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                    if (save_method == 'validasi') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Sertifikat Berhasil Divalidasi!'
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
</script>