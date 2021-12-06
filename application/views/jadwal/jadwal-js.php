<script type="text/javascript">
  var save_method; //for save method string
  var table;

  $(document).ready(function() {

    table = $("#tabeljadwal").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
        "sEmptyTable": "Data Jadwal Registrasi Masih Kosong"
      },
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [
        [4, "asc"]
      ], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('jadwal/ajax_list') ?>",
        "type": "POST"
      },
      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [0, 1, 2, 3, 4, 5],
        "className": 'text-center'
      }, {
        "targets": [-1], //last column
        "render": function(data, type, row) {
          if (row[4] == "Non-Aktif") {
            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit_jadwal(" + row[5] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\" onclick=\"delete_jadwal(" + row[5] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>"
          } else {
            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit_jadwal(" + row[5] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div>";
          }

        },
        "orderable": false, //set not orderable
      }, {
        "searchable": false,
        "orderable": false,
        "targets": 0
      }, {
        "targets": [-2], //last column
        "render": function(data, type, row) {
          if (row[4] == "Non-Aktif") {
            return "<div class=\"badge bg-danger text-white text-wrap\">Non-Aktif</div>"
          } else {
            return "<div class=\"badge bg-success text-white text-wrap\">Aktif</div>";
          }
        }
      }],
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

  //delete
  function delete_jadwal(id) {
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
          url: "<?php echo site_url('jadwal/delete'); ?>",
          type: "POST",
          data: "id_jadwal=" + id,
          cache: false,
          dataType: 'json',
          success: function(respone) {
            if (respone.status == true) {
              reload_table();
              Swal.fire({
                icon: 'success',
                title: 'Jadwal Registrasi Berhasil Dihapus!'
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

  function add_jadwal() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Jadwal Registrasi'); // Set Title to Bootstrap modal title
  }

  function edit_jadwal(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('jadwal/get_jadwal') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id_jadwal"]').val(data.id_jadwal);
        $('[name="thn_akademik"]').val(data.tahun_akademik);
        $('[name="tgl_mulai"]').val(data.tanggal_mulai);
        $('[name="tgl_akhir"]').val(data.tanggal_akhir);
        $('[name="status"]').val(data.status);
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ubah Jadwal Registrasi'); // Set title to Bootstrap modal title

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

    if (save_method == 'add') {
      url = "<?php echo site_url('jadwal/insert') ?>";
    } else {
      url = "<?php echo site_url('jadwal/update') ?>";
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
          if (save_method == 'add') {
            Toast.fire({
              icon: 'success',
              title: 'Jadwal Registrasi Berhasil Disimpan!'
            });
          } else if (save_method == 'update') {
            Toast.fire({
              icon: 'success',
              title: 'Jadwal Registrasi Berhasil Diubah!'
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
        $('#btnSave').attr('disabled', false); //set button enable 


      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error adding / update data');
        $('#btnSave').text('Simpan'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 

      }
    });
  }
</script>