<!DOCTYPE html>
<html>
<body>
<h1>Your location to shop</h1>
<div id="googleMap" style="width:100%;height:1000px;"></div>


<script>
var source, destination;
function myMap() {
    var fromlat = <?php echo $fromlat; ?>;
    var fromlon = <?php echo $fromlon; ?>;
    var tolat = <?php echo $tolat; ?>;
    var tolon = <?php echo $tolon; ?>;
    var distance; 
    console.log(markerSecond)
    var mapProp= {
        center:new google.maps.LatLng(fromlat,fromlon),
        zoom:15,
    };
    source = new google.maps.LatLng(fromlat, fromlon);
    destination = new google.maps.LatLng(tolat, tolon);
    var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
    var marker = new google.maps.Marker({
        icon:'https://addisplus.net/assets/marker.png',
        map
    });
    var markerSecond = new google.maps.Marker({
        icon:'https://addisplus.net/assets/marker.png',
        map
    });
    var directionsService = new google.maps.DirectionsService;
    var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true});

    directionsDisplay.setMap(null);
        directionsDisplay.setMap(map);

        directionsService.route({
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING,
            // unitSystem: google.maps.UnitSystem.IMPERIAL,
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);
                console.log(result.routes[0]);
                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);

                // distance.value = result.routes[0].legs[0].distance.value / 1000;
            }
        });
}





</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyALylujNDJlbGgfb3dSd7G4lNJlI2FqwPA&callback=myMap"></script>

</body>
</html>