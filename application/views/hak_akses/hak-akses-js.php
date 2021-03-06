<script type="text/javascript">
  var save_method; //for save method string
  var table;

  $(document).ready(function() {

    table = $("#tabellevel").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
        "sEmptyTable": "Data menu Belum Ada"
      },
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('hak_akses/ajax_list') ?>",
        "type": "POST"
      },
      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [0, 1, 2, 3],
        "className": 'text-center'
      }, {
        "targets": [-1], //last column
        "render": function(data, type, row) {
          if (row[2] == 1 || row[3] > 0) {
            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit_level(" + row[2] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div>";
          } else {
            return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit_level(" + row[2] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\" onclick=\"dellevel(" + row[2] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>";
          }
        },
        "orderable": false, //set not orderable
      }, {
        "targets": [2],
        "render": function(data, type, row) {
          return "<a class=\"btn btn-xs btn-info\" href=\"javascript:void(0)\" title=\"Hak Akses Menu\" onclick=\"aksesmenu(" + row[2] + ")\">Hak Akses Menu</a>";
        }

      }, ],
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

  function aksesmenu(id) {
    $('.modal-title').text('Hak Akses Menu');
    $("#modal-default").modal({
      backdrop: 'static',
      keyboard: false
    });
    $(".modal-dialog").addClass('modal-xl');
    $.ajax({
      url: '<?php echo base_url('hak_akses/view_akses_menu'); ?>',
      type: 'post',
      data: 'id=' + id,
      success: function(respon) {
        $("#md_def").html(respon);
      }
    })
  }

  function aksessubmenu(id) {
    $('.modal-title').text('Hak Akses Submenu');
    $("#modal-default").modal({
      backdrop: 'static',
      keyboard: false
    });
    $(".modal-dialog").addClass('modal-xl');
    $.ajax({
      url: '<?php echo base_url('hak_akses/view_akses_submenu'); ?>',
      type: 'post',
      data: 'id=' + id,
      success: function(respon) {
        $("#md_def").html(respon);
      }
    })
  }
  //view
  function vlevel(id) {
    $('.modal-title').text('View Level');
    $("#modal-default").modal('show');
    $.ajax({
      url: '<?php echo base_url('hak_akses/view'); ?>',
      type: 'post',
      data: 'table=tbl_userlevel&id=' + id,
      success: function(respon) {
        $("#md_def").html(respon);
      }
    })
  }

  //delete
  function dellevel(id) {
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
          url: "<?php echo site_url('hak_akses/delete'); ?>",
          type: "POST",
          data: "id=" + id,
          cache: false,
          dataType: 'json',
          success: function(respone) {
            if (respone.status == true) {
              reload_table();
              Swal.fire({
                icon: 'success',
                title: 'Data Berhasil Dihapus!'
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



  function add_level() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Hak Akses'); // Set Title to Bootstrap modal title
  }

  function edit_level(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('hak_akses/edit') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {

        $('[name="id_level"]').val(data.id_level);
        $('[name="nama_level"]').val(data.nama_level);
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ubah Hak Akses'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;

    if (save_method == 'add') {
      url = "<?php echo site_url('hak_akses/insert') ?>";
    } else {
      url = "<?php echo site_url('hak_akses/update') ?>";
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
              title: 'Data Hak Akses Berhasil Disimpan!'
            });
          } else if (save_method == 'update') {
            Toast.fire({
              icon: 'success',
              title: 'Data Hak Akses Berhasil Diubah!'
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