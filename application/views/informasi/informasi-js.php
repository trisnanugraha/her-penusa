<script type="text/javascript">
  var save_method; //for save method string
  var table;

  $(document).ready(function() {

    table = $("#tabelinformasi").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
        "sEmptyTable": "Data Informasi Masih Kosong"
      },
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('informasi/ajax_list') ?>",
        "type": "POST"
      },
      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [0, 2],
        "className": 'text-center'
      }, {
        "searchable": false,
        "orderable": false,
        "targets": 0
      }, {
        "targets": [-1], //last column
        "render": function(data, type, row) {
          return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit(" + row[2] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div>";
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

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('informasi/get_informasi') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data) {
        $('[name="id"]').val(data.id_informasi);
        if (data.deskripsi != null) {
          getDeskripsi.setData(data.deskripsi);
        }

        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ubah Banner Informasi'); // Set title to Bootstrap modal title

      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function save() {
    $('#btnSave').text('Menyimpan...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url = "<?php echo site_url('informasi/update') ?>";
    var formData;

    const deskripsi = getDeskripsi.getData();

    formData = {
      id_informasi: $("#id").val(),
      deskripsi: deskripsi
    }

    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      dataType: "JSON",
      success: function(data) {

        if (data.status) //if success close modal and reload ajax table
        {
          getDeskripsi.setData('');
          $('#modal_form').modal('hide');
          reload_table();
          Toast.fire({
            icon: 'success',
            title: 'Banner Informasi Berhasil Diubah!'
          });
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

  function batal() {
    $('#form')[0].reset();
    reload_table();
    var image = document.getElementById('v_image');
    image.src = "";
  }
</script>