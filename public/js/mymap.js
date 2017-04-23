

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      center: {lat: 21.027066, lng: 105.854064},
      zoom: 13,
      mapTypeId: 'roadmap',
      animation:google.maps.Animation.BOUNCE


    });
    var input = document.getElementById('pac-input');
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    
    var marker = new google.maps.Marker({
        position: {lat: 21.027066, lng: 105.854064},
        map: map
    });

    autocomplete.addListener('place_changed', function() {
      infowindow.close();
      marker.setVisible(false);
      var place = autocomplete.getPlace();
      if (!place.geometry) {
        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        window.alert("No details available for input: '" + place.name + "'");
        return;
      }

      // If the place has a geometry, then present it on a map.
      if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
      } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);  // Why 17? Because it looks good.
      }
      marker.setPosition(place.geometry.location);
      marker.setVisible(true);
      $('#lat').val(place.geometry.location.lat());
      $('#long').val(place.geometry.location.lng());

      var address = '';
      if (place.address_components) {
        address = [
          (place.address_components[0] && place.address_components[0].short_name || ''),
          (place.address_components[1] && place.address_components[1].short_name || ''),
          (place.address_components[2] && place.address_components[2].short_name || '')
        ].join(' ');
      }

      infowindowContent.children['place-icon'].src = place.icon;
      infowindowContent.children['place-name'].textContent = place.name;
      infowindowContent.children['place-address'].textContent = address;
      infowindow.open(map, marker);
    });
    google.maps.event.addListener(map, 'click', function(event) {
         $('#lat').val(event.latLng.lat());
         $('#long').val(event.latLng.lng());
    });
}
$(document).ready(function(){
    $('#luong').change(function(){
        tongChiphi();
    });
    $('#thuong').change(function(){
        tongChiphi();
    });

});
function tongChiphi() {
    $('#tongchiphi').val(parseInt($('#luong').val()) + parseInt($('#thuong').val()));
}


