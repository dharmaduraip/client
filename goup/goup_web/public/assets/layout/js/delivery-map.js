var map;

function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {
        mapTypeControl: false,
        zoomControl: true,
        center: { lat: current_latitude, lng: current_longitude },
        zoom: 12,
        styles: [
            { elementType: "geometry", stylers: [{ color: "#f5f5f5" }] },
            { elementType: "labels.icon", stylers: [{ visibility: "off" }] },
            {
                elementType: "labels.text.fill",
                stylers: [{ color: "#616161" }]
            },
            {
                elementType: "labels.text.stroke",
                stylers: [{ color: "#f5f5f5" }]
            },
            {
                featureType: "administrative.land_parcel",
                elementType: "labels.text.fill",
                stylers: [{ color: "#bdbdbd" }]
            },
            {
                featureType: "landscape.man_made",
                elementType: "geometry",
                stylers: [{ color: "#e4e8e9" }]
            },
            {
                featureType: "poi",
                elementType: "geometry",
                stylers: [{ color: "#eeeeee" }]
            },
            {
                featureType: "poi",
                elementType: "labels.text.fill",
                stylers: [{ color: "#757575" }]
            },
            {
                featureType: "poi.park",
                elementType: "geometry",
                stylers: [{ color: "#e5e5e5" }]
            },
            {
                featureType: "poi.park",
                elementType: "geometry.fill",
                stylers: [{ color: "#7de843" }]
            },
            {
                featureType: "poi.park",
                elementType: "labels.text.fill",
                stylers: [{ color: "#9e9e9e" }]
            },
            {
                featureType: "road",
                elementType: "geometry",
                stylers: [{ color: "#ffffff" }]
            },
            {
                featureType: "road.arterial",
                elementType: "labels.text.fill",
                stylers: [{ color: "#757575" }]
            },
            {
                featureType: "road.highway",
                elementType: "geometry",
                stylers: [{ color: "#dadada" }]
            },
            {
                featureType: "road.highway",
                elementType: "labels.text.fill",
                stylers: [{ color: "#616161" }]
            },
            {
                featureType: "road.local",
                elementType: "labels.text.fill",
                stylers: [{ color: "#9e9e9e" }]
            },
            {
                featureType: "transit.line",
                elementType: "geometry",
                stylers: [{ color: "#e5e5e5" }]
            },
            {
                featureType: "transit.station",
                elementType: "geometry",
                stylers: [{ color: "#eeeeee" }]
            },
            {
                featureType: "water",
                elementType: "geometry",
                stylers: [{ color: "#c9c9c9" }]
            },
            {
                featureType: "water",
                elementType: "geometry.fill",
                stylers: [{ color: "#9bd0e8" }]
            },
            {
                featureType: "water",
                elementType: "labels.text.fill",
                stylers: [{ color: "#9e9e9e" }]
            }
        ]
    });

    var curr_marker = new google.maps.MarkerImage(
        //'/assets/layout/images/common/marker-end.png',
        new google.maps.Size(54, 42),
        new google.maps.Point(0, 0),
        new google.maps.Point(12, 22)
    );

    var curr_location = new google.maps.LatLng(current_latitude, current_longitude);

    makeMarker(curr_location, curr_marker, 'You are here', map);

    new AutocompleteDirectionsHandler();
}

function setupAutocomplete(autocomplete, inputs) {

    var autocomplete = new google.maps.places.Autocomplete(autocomplete);
    autocomplete.bindTo("bounds", map);
    autocomplete.addListener("place_changed", function(event) {
       
        var me = new AutocompleteDirectionsHandler();

        var place = autocomplete.getPlace();
        var waypts = [];
        if (!place.place_id) {
            // window.alert("Please select an option from the dropdown list.");
            return;
        }

        for(var i = 0; i < inputs.length; i++) {
            if(inputs[i].value != "") {
                waypts.push({
                    location: inputs[i].value,
                    stopover: true
                });
            }
        }

        me.waypts = waypts;
        me.origin = document.getElementById("origin-input").value;
        /*if (mode === 'ORIG') {
            me.origin = place.formatted_address;
            waypts.pop();
        } else {*/
            me.destination = waypts.pop().location;
        //}
        me.route(waypts, inputs);

    });    
}

/**
 * @constructor
 */

function AutocompleteDirectionsHandler() {

    this.originPlaceId = null;
    this.destinationPlaceId = null;
    this.travelMode = "DRIVING";
    var originInput = document.getElementById("origin-input");
    var modeSelector = document.getElementById("mode-selector");
    var originLatitude = document.getElementById("origin_latitude");
    var originLongitude = document.getElementById("origin_longitude");


    var polylineOptionsActual = new google.maps.Polyline({
        strokeColor: "#111",
        strokeOpacity: 0.8,
        strokeWeight: 4
    });

    this.directionsService = new google.maps.DirectionsService();
    this.directionsDisplay = new google.maps.DirectionsRenderer({
        suppressMarkers: true
    });
    this.directionsDisplay.setMap(map);

    var originAutocomplete = new google.maps.places.Autocomplete(originInput);

    var modeSelectorAutocomplete = new google.maps.places.Autocomplete(
        modeSelector
    );

    modeSelectorAutocomplete.addListener("place_changed", function(event) {
        var place = modeSelectorAutocomplete.getPlace();
    });

    originAutocomplete.addListener("place_changed", function(event) {
        var place = originAutocomplete.getPlace();

        if (place.hasOwnProperty("place_id")) {
            if (!place.geometry) {
                // window.alert("Autocomplete's returned place contains no geometry");
                return;
            }
            originLatitude.value = place.geometry.location.lat();
            originLongitude.value = place.geometry.location.lng();
        } else {
            service.textSearch(
                {
                    query: place.name
                },
                function(results, status) {
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        originLatitude.value = results[0].geometry.location.lat();
                        originLongitude.value = results[0].geometry.location.lng();
                    }
                }
            );
        }
    });



    this.setupPlaceChangedListener(originAutocomplete, "ORIG");
}

// Sets a listener on a radio button to change the filter type on Places
// Autocomplete.

AutocompleteDirectionsHandler.prototype.setupPlaceChangedListener = function( autocomplete, mode ) {
    var me = this;
    var waypointsInput = document.getElementsByName('d_address[]');
    autocomplete.bindTo("bounds", map);
    autocomplete.addListener("place_changed", function() {
        var place = autocomplete.getPlace();
        var waypts = [];
        if (!place.place_id) {
            // window.alert("Please select an option from the dropdown list.");
            return;
        }

        for(var i = 0; i < waypointsInput.length; i++) {
            if(waypointsInput[i].value != "") {
                waypts.push({
                    location: waypointsInput[i].value,
                    stopover: true
                });
            }
        }

        me.waypts = waypts;
        if (mode === 'ORIG') {
            me.origin = place.formatted_address;
            waypts.pop();
        } else {
            me.destination = waypts.pop().location;
        }

        me.route(waypts, waypointsInput);
    });
};

AutocompleteDirectionsHandler.prototype.route = function(waypts, waypointsInput) {
    if (!this.origin || !this.destination) {
        return;
    }

    var me = this;

    this.directionsService.route(
        {
            origin: this.origin,
            destination: this.destination,
            waypoints: waypts,
            optimizeWaypoints: true,
            travelMode: this.travelMode
        },
        function(response, status) {
            if (status === "OK") {
                var route = response.routes[0];
                var start = new google.maps.MarkerImage(
                    '/assets/layout/images/common/marker-start.png',
                    new google.maps.Size(54, 42),
                    new google.maps.Point(0, 0),
                    new google.maps.Point(12, 12));

                var end = new google.maps.MarkerImage(
                    '/assets/layout/images/common/marker-end.png',
                    new google.maps.Size(54, 42),
                    new google.maps.Point(0, 0),
                    new google.maps.Point(12, 22));

                makeMarker(route.legs[0].start_location, start, route.legs[0].start_address, map);

                for (var i = 0; i < waypointsInput.length; i++) {
                    var destinationLatitude = waypointsInput[i].parentElement.querySelector('input[name="d_latitude[]"]');
                    var destinationLongitude = waypointsInput[i].parentElement.querySelector('input[name="d_longitude[]"]');
                    //var distance = waypointsInput[i].parentElement.querySelector('input[name="distance[]"]');
                    if(route.legs.length > 0 && route.legs[i]) {
                        destinationLatitude.value = route.legs[i].end_location.lat();
                        destinationLongitude.value = route.legs[i].end_location.lng();
                        //distance.value = route.legs[i].distance.value;
                    }

                    makeMarker(route.legs[i].end_location, end, route.legs[0].end_address, map);
                }

                me.directionsDisplay.setDirections(response);
            } else {
                // window.alert('Directions request failed due to ' + status);
            }
        }
    );
};

function makeMarker(position, icon, title, map) {
    new google.maps.Marker({
        position: position,
        map: map,
        icon: icon,
        title: title
    });
}
