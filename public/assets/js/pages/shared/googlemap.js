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
  }
