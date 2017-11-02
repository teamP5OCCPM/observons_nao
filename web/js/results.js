
function initMap(){
  var france = {
      lat: 46.227638,
      lng: 2.213749000000007
  }
  var map = new google.maps.Map(document.getElementById('mapResults'), {
    zoom: 6,
    center: france
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

$(document).ready( function() {
    var btnText = $('#style-button').text();
   $('#style-button').click( function() {
       $('.style-results').toggle("slow");
       $('#style-button').text() === "Afficher la map"? $('#style-button').text("Afficher la liste"): $('#style-button').text("Afficher la map");
   });
   console.log(btnText);
});


