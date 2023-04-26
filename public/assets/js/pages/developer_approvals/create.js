$(document).on('submit', '#da-form', function (e) {
    e.preventDefault();
    var formdata = new FormData($("#da-form")[0]);
    $('.loader').show();
    $.ajax({
        url: daStore,
        type: 'POST',
        data: formdata,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('.loader').hide();
            if (data.success == 1) {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Data berhasil disimpan!',
                    showConfirmButton: false,
                    timer: 5000,
                })
                window.location.href = daIndex;
            } else {
                toastr.error('Success messages').clear();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.loader').hide();
            alert(errorThrown);
        }
    });
  });
