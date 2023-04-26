$(function () {
    /* Calling the route `selectRoute` and getting the data from the database. */
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

    $(document).on('submit', '#rtlh_form', function (e) {
        e.preventDefault();
        var formdata = new FormData($("#rtlh_form")[0]);
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
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Data berhasil disimpan!',
                        showConfirmButton: false,
                        timer: 5000,
                    })
                    window.location.href = devIndex;
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

      $(document).on('submit', '#rtlh_form-edit', function (e) {
        e.preventDefault();
        var formdata = new FormData($("#rtlh_form-edit")[0]);
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

});
