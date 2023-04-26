$(document).on('submit', '#village-add-form', function (e) {
    e.preventDefault();
    var formdata = new FormData($("#village-add-form")[0]);
    $('.loader').show();
    $.ajax({
        url: villageStore,
        type: 'POST',
        data: formdata,
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('.loader').hide();
            if (data.success == 1) {
              window.location.href = villageIndex;
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
