var map;
function initMap(){
  var paris = {
      lat: 48.85661400000001,
      lng: 2.3522219000000177
  }
  map = new google.maps.Map(document.getElementById('mapResults'), {
    zoom: 7,
    center: paris
  });

  var infowindow = new google.maps.InfoWindow();
  var marker, i;
  var markers = [];
  var img = "{{asset('assets/img.green-bird.png') }}"; // icon to use for markers

  $.getJSON("../resultsJson", function(data) {
      var loc = JSON.stringify(data);
      console.log(loc);
      var locations = JSON.parse(loc);

      for (i = 0; i < locations.length; i++) {
          marker = new google.maps.Marker({
              position: new google.maps.LatLng(locations[i]['lat'], locations[i]['lng']),
              map: map,
              //TODO: add icon (problem with path)

          });
          markers.push(marker);
          google.maps.event.addListener(marker, 'click', (function(marker, i) {
          return function() {
              infowindow.setContent(locations[i]['title']);
              infowindow.open(map, marker);
              }
          })(marker, i));

          ;
          markers.push(marker);

      }
  });
}


