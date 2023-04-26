
$(function () {

    $.ajax({
        type: "get",
        url: selectRoute,
        data: {id:districtId},
        dataType: "json",
        success: function (response) {
            var len = response.length;

            $("#district_id").empty();
            for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['district_name'];

                if(page == 'edit' && districtId == id){
                    $("#district_id").append("<option value='"+id+"' selected>"+name+"</option>");
                }else{
                    $("#district_id").append("<option value='"+id+"'>"+name+"</option>");
                }
            }

            villageAjax(response[0]['id']);
        }
    });


/* A function that is called when the district is changed. */
var districtChange = () => {
    $("#district_id").on('change', function (event){
        $("#village_id").empty();
        var district_id = $(this).val();
        villageAjax(district_id);
    })
}

/* A function that is called when the district is changed. */
var villageAjax = (id) => {
    $.ajax({
        type: "get",
        url: '/villages/select/'+id,
        dataType: "json",
        success: function (response) {
            var len = response.length;

            $("#village_id").empty();
            for( var i = 0; i<len; i++){
                var id = response[i]['id'];
                var name = response[i]['village_name'];

                if(page == 'edit' && villageId == id){
                    $("#village_id").append("<option value='"+id+"' selected>"+name+"</option>");
                }else{
                    $("#village_id").append("<option value='"+id+"'>"+name+"</option>");
                }

            }
        }
    });
}

districtChange();

    $(document).on('submit', '#housing-form-create', function (e) {
        e.preventDefault();
        var formdata = new FormData($("#housing-form-create")[0]);
        $('.loader').show();
        $.ajax({
            url: housingStore,
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
                    window.location.href = housingIndex+"?jenis="+data.jenis;
                } else {
                    toastr.error('Success messages');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.loader').hide();
                alert(errorThrown);
            }
        });
      });

      $(document).on('submit', '#housing-form-edit', function (e) {
        e.preventDefault();
        var formdata = new FormData($("#housing-form-edit")[0]);
        formdata.append('deletedImg', deletedImg);
        $('.loader').show();
        $.ajax({
            url: housingUpdate,
            type: 'POST',
            data: formdata,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                $('.loader').hide();
                if (data.success == 1) {
                  window.location.href = housingIndex+"?jenis="+data.jenis;
                    toastr.success('Success');
                } else {
                    toastr.error('Success messages');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.loader').hide();
                alert(errorThrown);
            }
        });
      });
});
