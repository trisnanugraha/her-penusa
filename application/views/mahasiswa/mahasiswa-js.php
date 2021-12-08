<script type="text/javascript">
  var save_method; //for save method string
  var table;

  $(document).ready(function() {

    table = $("#tabelmhs").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
        "sEmptyTable": "Data Mahasiswa Masih Kosong"
      },
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('mahasiswa/ajax_list') ?>",
        "type": "POST"
      },
      //Set column definition initialisation properties.
      "columnDefs": [{
          "targets": [0, 1, 2, 3, 4, 5],
          "className": 'text-center'
        }, {
          "targets": [-1], //last column
          "render": function(data, type, row) {
            if (row[4] == "N") {
              return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit_mhs(" + row[5] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\"  onclick=\"del_mhs(" + row[5] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>"
            } else {
              return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit_mhs(" + row[5] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-warning\" href=\"javascript:void(0)\" title=\"Reset Password\" onclick=\"reset_pass(" + row[5] + ")\"><i></i> Reset Password</a></div>";
            }
          },
          "orderable": false, //set not orderable
        }, {
          "targets": [-2], //last column
          "render": function(data, type, row) {
            if (row[4] == "N") {
              return "<div class=\"badge bg-danger text-white text-wrap\">Non-Aktif</div>"
            } else {
              return "<div class=\"badge bg-success text-white text-wrap\">Aktif</div>";
            }
          }
        }, {
          "searchable": false,
          "orderable": false,
          "targets": 0
        }
        // {
        //   "targets": [0],
        //   "render": function(data , type , row){
        //     if (row[0]!=null) {
        //       return "<img class=\"myImgx\"  src='<?php echo base_url("assets/foto/user/"); ?>"+row[0]+"' width=\"100px\" height=\"100px\">";
        //     }else{
        //       return "<img class=\"myImgx\"  src='<?php echo base_url("assets/foto/default-150x150.png"); ?>' width=\"100px\" height=\"100px\">";
        //     }
        //   }
        // },
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

    // $('#imagefile').change(function(e) {
    //   var foto = e.target.files[0].name;
    //   $('#label-foto').html(foto);
    // });
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

  // Button Tabel

  function reset_pass(id) {

    Swal.fire({
      title: 'Anda Yakin Ingin Mengatur Ulang Password ?',
      text: "Default Password : password123",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Atur Ulang Password!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "<?php echo site_url('mahasiswa/reset_pass'); ?>",
          type: "POST",
          data: "id=" + id,
          cache: false,
          dataType: 'json',
          success: function(respone) {
            if (respone.status == true) {
              reload_table();
              Swal.fire({
                icon: 'success',
                title: 'Password Berhasil Diatur Ulang!',
              });
            } else {
              Toast.fire({
                icon: 'error',
                title: 'Reset password Error!!.'
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

  //delete
  function del_mhs(id) {
    Swal.fire({
      title: 'Konfirmasi Hapus Akun',
      text: "Apakah Anda Yakin Ingin Menghapus Akun Ini ?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, Hapus Akun Ini!',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: "<?php echo site_url('mahasiswa/delete'); ?>",
          type: "POST",
          data: "id_mahasiswa=" + id,
          cache: false,
          dataType: 'json',
          success: function(respone) {
            if (respone.status == true) {
              reload_table();
              Swal.fire({
                icon: 'success',
                title: 'Akun Berhasil Dihapus!'
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

  function add_mhs() {
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('[name="nim"]').attr('readonly', false);
    $("#v_image").attr("src", '');
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Tambah Mahasiswa'); // Set Title to Bootstrap modal title
  }

  function edit_mhs(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('mahasiswa/get_mhs') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('[name="id_mhs"]').val(data.id_mahasiswa);
        $('[name="nim"]').attr('readonly', true);
        $('[name="nim"]').val(data.nim);
        $('[name="nama"]').val(data.nama_lengkap);
        $('[name="mail"]').val(data.email);
        $('[name="telepon"]').val(data.no_hp);
        $('[name="prodi"]').val(data.id_prodi);
        $('[name="angkatan"]').val(data.id_angkatan);
        $('[name="lokasi"]').val(data.lokasi);
        $('[name="status"]').val(data.status);

        if (data.pass_foto == null) {
          var image = "<?php echo base_url('upload/foto/mahasiswa/default.png') ?>";
          $("#v_image").attr("src", image);
        } else {
          var image = "<?php echo base_url('upload/foto/mahasiswa/') ?>";
          $("#v_image").attr("src", image + data.pass_foto);
        }

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ubah Data Mahasiswa'); // Set title to Bootstrap modal title

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
      url = "<?php echo site_url('mahasiswa/insert') ?>";
    } else {
      url = "<?php echo site_url('mahasiswa/update') ?>";
    }
    var formdata = new FormData($('#form')[0]);
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
              title: 'Data Mahasiswa Berhasil Disimpan!'
            });
          } else if (save_method == 'update') {
            Toast.fire({
              icon: 'success',
              title: 'Data Mahasiswa Berhasil Diubah!'
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
        alert(textStatus);
        // alert('Error adding / update data');
        Toast.fire({
          icon: 'error',
          title: 'Error!!.'
        });
        $('#btnSave').text('Simpan'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 

      }
    });
  }

  var loadFile = function(event) {
    var image = document.getElementById('v_image');
    image.src = URL.createObjectURL(event.target.files[0]);
  };

  function batal() {
    $('#form')[0].reset();
    reload_table();
    var image = document.getElementById('v_image');
    image.src = "";
  }
</script>