<template>
  <div id="container-fluid">
       <div id="floating-panel">
     <!--  <input id="latlng" type="text" value="40.714224,-73.961452"> -->
     <select id="latlng">
        <option value="40.714224,-73.961452"> 1F SOTTO BRANCH</option>
        <option value="10.3139,123.9012"> AYALA BRANCH </option>
     </select>
      <input id="submit" type="button" value="FIND NOW">
    </div>
    <div id="map"></div>
  </div>
</template>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCB5UntvXRlD5c0WGM1qCffiEVP1cE0w6M&callback=initMap">
    </script>
<script type="text/javascript">
   function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: {lat:10.3157, lng: 123.8854}
        });
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;

        document.getElementById('submit').addEventListener('click', function() {
          geocodeLatLng(geocoder, map, infowindow);
        });
      }

      function geocodeLatLng(geocoder, map, infowindow) {
        var input = document.getElementById('latlng').value;
        var latlngStr = input.split(',', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[0]) {
              map.setZoom(20);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map
              });
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
      }
</script>
