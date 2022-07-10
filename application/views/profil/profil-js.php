<script type="text/javascript">
    $(document).ready(function() {
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
    });

    var loadFile = function(event) {
        var image = document.getElementById('v_image');
        image.src = URL.createObjectURL(event.target.files[0]);
    };

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function simpan() {
        $('#btn_simpan').text('Menyimpan...'); //change button text
        $('#btn_simpan').attr('disabled', true); //set button disable 
        var url = "<?php echo site_url('profil/update') ?>";
        var formdata = new FormData($('#form_profil')[0]);
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
                    Toast.fire({
                        icon: 'success',
                        title: 'Profil Anda Berhasil Diubah!'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                    }
                }
                $('#btn_simpan').text('Simpan'); //change button text
                $('#btn_simpan').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btn_simpan').text('Simpan'); //change button text
                $('#btn_simpan').attr('disabled', false); //set button enable 

            }
        });
    }

    function simpan_pass() {
        $('#btn_simpan_pass').text('Menyimpan...'); //change button text
        $('#btn_simpan_pass').attr('disabled', true); //set button disable 
        var url = "<?php echo site_url('profil/update_pass') ?>";
        var formdata = new FormData($('#form_password')[0]);
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
                    Toast.fire({
                        icon: 'success',
                        title: 'Password Anda Berhasil Diubah!'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                    }
                }
                $('#btn_simpan_pass').text('Simpan'); //change button text
                $('#btn_simpan_pass').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btn_simpan_pass').text('Simpan'); //change button text
                $('#btn_simpan_pass').attr('disabled', false); //set button enable 
            }
        });
    }
</script>