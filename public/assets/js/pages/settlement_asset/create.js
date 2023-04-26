/**
 * It creates a map, adds a marker, and adds a listener to the map that updates the marker's position
 * when the map is clicked
 * @returns the value of the variable map.
 */
function initMap() {
    // Create a map object and specify the DOM element for display.
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: latitude, lng:  longitude},
      zoom: 13,
      fullscreenControl: false,
      mapTypeControl: true,
      mapTypeId: 'hybrid',
    });

    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    map.addListener('bounds_changed', function() {
      searchBox.setBounds(map.getBounds());
    });

    /**
     * It adds two listeners to the marker object. One for when the marker is dragged and one for when
     * the marker is dropped
     * @param markerobject - the marker object that you want to get the coordinates from
     */
    function markerCoords(markerobject){
      google.maps.event.addListener(markerobject, 'dragend', function(evt){
          console.log("lat: "+evt.latLng.lat().toFixed(3)+" lon: "+evt.latLng.lng().toFixed(3));
      });

      google.maps.event.addListener(markerobject, 'drag', function(evt){
          console.log("marker is being dragged");
          console.log("lat: "+evt.latLng.lat().toFixed(3)+" lon: "+evt.latLng.lng().toFixed(3));

          $('#latitude').val(evt.latLng.lat().toFixed(8));
          $('#longitude').val(evt.latLng.lng().toFixed(8));
          flashy();
      });
    }

   /* It's a function that will create a marker on the map. */
    var marker = new google.maps.Marker({
      position: {lat: latitude, lng:  longitude},
      map: map,
      title: 'Pilih Lokasi!',
      draggable:true,
    });

    markerCoords(marker);

    /* It's a function that will add class active to the element with id latitude and longitude. */
    google.maps.event.addListener(map, 'click', function(evt) {
       console.log("lat: "+evt.latLng.lat().toFixed(3)+" lon: "+evt.latLng.lng().toFixed(3));
        var latlng = new google.maps.LatLng(evt.latLng.lat().toFixed(8), evt.latLng.lng().toFixed(8));
        marker.setPosition(latlng);
        $('#latitude').val(evt.latLng.lat().toFixed(8));
        $('#longitude').val(evt.latLng.lng().toFixed(8));

            flashy();
        });

      searchBox.addListener('places_changed', function() {
       var places = searchBox.getPlaces();

       if (places.length == 0) {
         return;
       }

       /* It's a function that will set the position of the marker and the value of the latitude and
       longitude. */
       places.forEach(function(place) {
        marker.setPosition(place.geometry.location);
        $('#latitude').val(place.geometry.location.lat().toFixed(8));
        $('#longitude').val(place.geometry.location.lng().toFixed(8));
        map.setCenter(marker.getPosition());
        flashy();
       });

     });

     $("#pac-input").click(function(event) {
       $(this).val('');
     });

  }


  /* It's a function that will add class active to the element with id latitude and longitude. */
  var flashy = () => {
    setTimeout(function() {
        $('#latitude').addClass('active');
    }, 100);

    $('#latitude').removeClass('active').addClass('final').trigger('focus').select();

    setTimeout(function() {
        $('#longitude').addClass('active');
    }, 100);

    $('#longitude').removeClass('active').addClass('final').trigger('focus').select();
  }


  $(document).on('change', '#asset_image', function() {
    var flag = $(this).attr('data-flag');
    imagesPreview(this, '#asset_gallery');
  });

  $(document).on('change', '#berita_acara', function() {
    var flag = $(this).attr('data-flag');
    filesList(this, '#berita_acara_gallery');
  });

  var filesList = (input, placeToInsertFilesList) => {
    if (input.files) {
        var filesAmount = input.files.length;
        var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.jfif|\.webp|\.pdf)$/i;
        for (i = 0; i < filesAmount; i++) {


          if(!allowedExtensions.exec(input.value)){
            iziToast.error({
              title: 'Error!',
              message: 'Please upload file having extensions .jpeg/.jpg/.png/.pdf only.',
              position: 'topRight'
            });
            input.value = '';
            return false;
          }else{

            var reader = new FileReader();
            var fileName = input.files[i].name;
            $(placeToInsertFilesList).append('<div class="borderwrap" data-href="'+event.target.result+'"><div class="filenameupload"><p>'+fileName+'</p><i class="mdi mdi-trash-can-outline remove_file"></i></div> </div>');

            reader.readAsDataURL(input.files[i]);
          }
        }
      }
  }


  /* It's a function that will preview the image before uploading it. */
  var imagesPreview = function(input, placeToInsertImagePreview) {

    if (input.files) {
      var filesAmount = input.files.length;
      var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.jfif|\.webp)$/i;
      for (i = 0; i < filesAmount; i++) {

        if(!allowedExtensions.exec(input.value)){
          iziToast.error({
            title: 'Error!',
            message: 'Please upload file having extensions .jpeg/.jpg/.png only.',
            position: 'topRight'
          });
          input.value = '';
          return false;
        }else{

          var reader = new FileReader();

          reader.onload = function(event) {
            $(placeToInsertImagePreview).append('<div class="borderwrap" data-href="'+event.target.result+'"><div class="filenameupload"><img src="'+event.target.result+'" width="130" height="130"> <div class="middle"><i class="mdi mdi-trash-can-outline remove_img"></i></div> </div></div>');
          }

          reader.readAsDataURL(input.files[i]);
        }
      }
    }
  };

  /* It's a function that will remove the image from the preview. */
  $(document).on('click','.remove_img', function(){

    var img_len = $('.borderwrap').length-1;
    var p_img = $(this).closest("div").parent().parent().attr('data-href');
    $(this).closest("div").parent().parent().remove();

    var upload_img = $('#hidden_asset_image').val();
    var temp = upload_img.replace(p_img+",",'');

    if(upload_img == temp){
      var temp = upload_img.replace(p_img,'');
    }

    if ($(this).hasClass('old-image')){
        let deletedId = $(this).data('img-id');
        deletedImg.push(deletedId);
    }

    $('#hidden_asset_image').val(temp);
    $('#hidden_asset_image').attr('value',temp);

  });

  $(document).on('click','.remove_file', function(){

    var img_len = $('.borderwrap').length-1;
    var p_img = $(this).closest("div").parent().parent().attr('data-href');

    if ($(this).hasClass('old-file')){
        let deletedId = $(this).data('file-id');
        deletedFile.push(deletedId);
    }

    $(this).closest("div").parent().remove();
  });

  $(document).on('submit', '#sa_form', function (e) {
    e.preventDefault();
    var formdata = new FormData($("#sa_form")[0]);
    formdata.append('deletedImg', deletedImg);
    formdata.append('deletedFile', deletedFile);
    $('.loader').show();
    $.ajax({
        url: saStore,
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
              window.location.href = saIndex;
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


