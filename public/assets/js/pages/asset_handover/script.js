$(document).on('submit', '#ah-form-create', function (e) {
    console.log(1);
    e.preventDefault();
    var formdata = new FormData($("#ah-form-create")[0]);
    $('.loader').show();
    $.ajax({
        url: ahStore,
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
              window.location.href = ahIndex;

            } else {
                toastr.error('Error messages').clear();
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.loader').hide();
            alert(errorThrown);
        }
    });
  });


  $(document).on('submit', '#ah-form-edit', function (e) {
    e.preventDefault();
    var formdata = new FormData($("#ah-form-edit")[0]);
    formdata.append('deletedFile', deletedFile)
    $('.loader').show();
    $.ajax({
        url: ahStore,
        type: 'POST',
        data: formdata,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('.loader').hide();
            if (data.success == 1) {
              window.location.href = ahIndex;
                toastr.success('Success').clear();
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

  $(function () {
    $(document).on('change', '#documents', function() {
        var flag = $(this).attr('data-flag');
        filesList(this, '#documents_gallery');
      });
  });
