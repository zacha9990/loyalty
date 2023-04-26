$(document).on('submit', '#bsps-save', function (e) {
    e.preventDefault();
    var formdata = new FormData($("#bsps-save")[0]);
    $('.loader').show();
    $.ajax({
        url: devStore,
        type: 'POST',
        data: formdata,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('.loader').hide();
            if (data.success == 1) {
              window.location.href = devIndex;
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
