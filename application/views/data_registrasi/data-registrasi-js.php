<script type="text/javascript">
  var save_method; //for save method string
  var table;

  $(document).ready(function() {

    table = $("#tabelregistrasi").DataTable({
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
        "url": "<?php echo site_url('data_registrasi/ajax_list') ?>",
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

    $("input [type='file']").change(function() {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
      $(this).removeClass('is-invalid');
    });

    $('#berkas_krs').change(function(e) {
      var krs = e.target.files[0].name;
      $('#label-krs').html(krs);
    });

    $('#berkas_khs').change(function(e) {
      var khs = e.target.files[0].name;
      $('#label-khs').html(khs);
    });

    $('#berkas_pembayaran').change(function(e) {
      var pembayaran = e.target.files[0].name;
      $('#label-pembayaran').html(pembayaran);
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

  var load_file_krs = function(event) {
    var file_krs = document.getElementById('view_file_krs');
    file_krs.href = URL.createObjectURL(event.target.files[0]);
  };

  var load_file_khs = function(event) {
    var file_khs = document.getElementById('view_file_khs');
    file_khs.href = URL.createObjectURL(event.target.files[0]);
  };

  var load_file_pembayaran = function(event) {
    var file_pembayaran = document.getElementById('view_file_pembayaran');
    file_pembayaran.href = URL.createObjectURL(event.target.files[0]);
  };

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
          url: "<?php echo site_url('jadwal_registrasi/delete'); ?>",
          type: "POST",
          data: "id_jadwal_registrasi=" + id,
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

  function add_data() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('data_registrasi/get_mhs') ?>",
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="nama"]').val(data.nama_lengkap);
        $('[name="nim"]').val(data.nim);
        $('[name="no_hp"]').val(data.no_hp);
        $('[name="email"]').val(data.email);
        $('[name="prodi"]').val(data.prodi);
        $('[name="lokasi"]').val(data.lokasi);
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Data Registrasi Baru'); // Set Title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });

  }

  function edit_jadwal(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('jadwal_registrasi/get_jadwal_registrasi') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id_jadwal_registrasi"]').val(data.id_jadwal_registrasi);
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
      url = "<?php echo site_url('data_registrasi/insert') ?>";
    } else {
      url = "<?php echo site_url('jadwal_registrasi/update') ?>";
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
          reload_table();
          if (save_method == 'add') {
            Toast.fire({
              icon: 'success',
              title: 'Data Registrasi Berhasil Disimpan!'
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