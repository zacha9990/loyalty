$(document).on('submit', '#dev_form', function (e) {
    e.preventDefault();
    var formdata = new FormData($("#dev_form")[0]);
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
                toastr.error('Success messages');
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('.loader').hide();
            alert(errorThrown);
        }
    });
});


// MAP

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

