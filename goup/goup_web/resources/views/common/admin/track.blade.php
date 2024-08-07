<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('constants.site_title','Tranxit')}} - Trip</title>
    <link rel="shortcut icon" type="image/png" href="{{ config('constants.site_icon') }}"/>

   
    <link href="{{asset('asset/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset/css/slick.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('asset/css/slick-theme.css')}}"/>
    <link href="{{asset('asset/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{asset('asset/css/bootstrap-timepicker.css')}}" rel="stylesheet">
    <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/stylesheet.css')}}"/>
    <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

<div class="dis-center">
    <div class="content-box-2 m-5 col-md-10 p-4">    
       
           <div class="dis-space-btw m-b-20"> 
           <h3 class="txt-primary user_name"></h3>
            <p class="txt-primary ">@lang('user.ride.ride_now')</p> 
          </div>
          <div class="col-md-12 col-sm-12 col-lg-12 p-0 dis-column ">
                              <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                                 
                                 <div >

                            <div id="map" style="width:100%;height:470px;"></div>

                            </div>
                              </div>
                              <div class="col-md-12 col-sm-12 col-lg-12 pl-0">
                                 <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                                 
                                    <!-- <h5 class="text-left">Status</h5> -->
                                    <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                                       
                                          
                                         
                                          <div class="trip-user dis-ver-center col-lg-12 col-md-12 col-sm-12 mb-2">
                                             <div class="dis-column col-lg-6 col-md-6 col-sm-6 ">
                                                <div class="user-img" style="background-image: url(https://schedule.tranxit.co/storage/provider/profile/f1505bf83063da02b2106323e78be9a5.jpeg);">
                                                </div>
                                                <h5 class="provider_name"></h5>
                                                <div class="rating-outer">
                                                   <span style="cursor: default;"><span class="provider_rating">4.6</span>
                                                      <div class="rating-symbol" style="display: inline-block; position: relative;">
                                                         <div class="fa fa-star-o" style="visibility: hidden;"></div>
                                                         <div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px;top: 0; width: auto;">
                                                            <span class="fa fa-star" aria-hidden="true"></span></div>
                                                      </div>
                                                   </span>
                                                   <input type="hidden" class="rating" value="1" disabled="disabled">
                                                </div>
                                             </div>
                                             <div class="dis-column col-lg-6 col-md-6 col-sm-6 p-0">
                                                <div class="car-img"> <img width="100" class="" src="../img/taxi/mustang.png" alt="premium">
                                                </div>
                                                <h5 class="vehicle_no"></h5>
                                                <div class="rating-outer">
                                                   <p style="cursor: default;"  class="vehicle_type"></p>
                                                   <input type="hidden" class="rating" value="1" disabled="disabled">
                                                </div>
                                             </div>
                                          </div>
      
                                       
                                       
                                    </div>
                                 </div>
                             
                           </div>

        </div>
    </div>
    </div>

    <script type="text/javascript" src="{{ asset('assets/plugins/jquery-3.3.1.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/popper.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}" ></script>

    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
     

    <script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}"></script>
    
    <script src="{{ asset('assets/layout/js/script.js')}}"></script>
    <script src="{{ asset('assets/layout/js/api.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script type="text/javascript">

    window.room = '{{base64_decode(Helper::getSaltKey())}}';
    window.socket_url = '{{Helper::getSocketUrl()}}';
     
    var map;
    var directionDisplay;
    var directionsService;
    var position;
    var marker = null;
    var polyline = null;
    var poly2 = null;
    var infowindow = null;
    var timerHandle = null;
    var steps = [];

    var socket = io.connect(window.socket_url);

    var meters, milliseconds, marker_url;

    google.maps.event.addDomListener(window, "load", initialize);

    socket.emit('joinPrivateRoom', `room_${window.room}_R${ {{$id}} }_TRANSPORT`);

    socket.on('socketStatus', function (data) {
      console.log(data);
    });

    function initialize() {
      // Instantiate a directions service.
      directionsService = new google.maps.DirectionsService();

      // Create a map and center it on Manhattan.
      var myOptions = {
        zoom: 20,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      };
      map = new google.maps.Map(
        document.getElementById("map"),
        myOptions
      );

      map.setCenter({
        lat: parseFloat('13.06169050'),
        lng: parseFloat('80.25444540')
      });

      // Create a renderer for directions and bind it to the map.
      var rendererOptions = {
        suppressPolylines: true,
        map: map
      };
      directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

      polyline = new google.maps.Polyline({
        path: []
      });
      poly2 = new google.maps.Polyline({
        path: []
      });

      track();

    }

    function track() {
      $.ajax({
        type: "POST",
        url: getBaseUrl() + "/admin/transport/track/request",
        data: {
          id: '{{$id}}'
        },
        headers: {
          Authorization: "Bearer " + getToken("admin")
        },
        success: function(response) {

          // 0.5 metre travels in 100 millisecond
          meters = 0.1;
          milliseconds = 100;
          marker_url = response.marker;


          $('.user_name').text(response.user.first_name+ "'s Trip");
          $('.provider_name').text(response.provider.first_name+ " "+response.provider.last_name);
          $('.user-img').css('background-image', 'url('+response.provider.picture+')');
          $('.provider_rating').text(response.provider.rating);
          $('.car-img img').attr('alt', response.provider.vehicle.model);
          $('.car-img img').attr('src', response.provider.vehicle.picture);
          $('.vehicle_no').text(response.provider.vehicle.vehicle_no);
          $('.vehicle_type').text(response.provider.vehicle.type);

          //if(typeof localStorage.starting_point == 'undefined' || (localStorage.starting_point != response.source || localStorage.destination_point != response.destination) ) {
            localStorage.setItem('starting_point', response.source);
            localStorage.setItem('destination_point', response.destination);

            calcRoute(localStorage.starting_point, localStorage.destination_point);
          //}

        }

      });
    }

    function calcRoute(origin, destination) {

      //clear Timeouts and clear map
      if (timerHandle) {
        clearTimeout(timerHandle);
      }
      if (marker) {
        marker.setMap(null);
      }
      polyline.setMap(null);
      poly2.setMap(null);
      directionsDisplay.setMap(null);

      //Add base polyline
      polyline = new google.maps.Polyline({
        path: []
      });

      //Add second polyline
      poly2 = new google.maps.Polyline({
        path: [],
        strokeColor: "#009dff",
        strokeWeight: 3
      });

      // Create a renderer for directions and bind it to the map.
      var rendererOptions = {
        map: map,
        suppressPolylines: true,
        suppressMarkers: true
      };
      directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

      var travelMode = google.maps.DirectionsTravelMode.DRIVING;

      var request = {
        origin: origin,
        destination: destination,
        travelMode: travelMode
      };

      // Route the directions and pass the response to a
      // function to create markers for each step.
      directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {


          //directionsDisplay.setDirections(response);

          var bounds = new google.maps.LatLngBounds();
          var route = response.routes[0];
          startLocation = new Object();
          endLocation = new Object();

          // For each route, display summary information.
          var path = response.routes[0].overview_path;
          var legs = response.routes[0].legs;
          
          for (i = 0; i < legs.length; i++) {
            if (i === 0) {
              startLocation.latlng = legs[i].start_location;
              startLocation.address = legs[i].start_address;
            }

            var steps = legs[i].steps;
            for (j = 0; j < steps.length; j++) {
              var nextSegment = steps[j].path;
              for (k = 0; k < nextSegment.length; k++) {
                polyline.getPath().push(nextSegment[k]);
                poly2.getPath().push(nextSegment[k]);
                bounds.extend(nextSegment[k]);
              }
            }
          }

          poly2.setMap(map);
          //map.fitBounds(bounds);
          //map.setZoom(1);
          startAnimation();

        }
      });

    }

    var eol;
    var k = 0;
    var stepnum = 0;
    var speed = "";
    var lastVertex = 1;

    var icon = {
      url: '{{asset("assets/layout/images/mod.svg")}}',
      anchor: new google.maps.Point(39, 60),
      //origin: new google.maps.Point(10,0),
      //scaledSize: new google.maps.Size(50, 50),
      size: new google.maps.Size(150, 150)
    };

    var socket_status = false;

    function startAnimation() {
      eol = polyline.Distance();
      map.setCenter(polyline.getPath().getAt(0));
      marker = new google.maps.Marker({
        position: polyline.getPath().getAt(0),
        map: map,
        icon: icon
      });

      

      socket.on('updateLocation', function (data) {
        console.log(data);
        if(data.lat != "" && data.lng != "") {
          var p = new google.maps.LatLng( data.lat, data.lng);
          socket_status = true;
          map.panTo(p);
          var lastPosn = marker.getPosition();
          marker.setPosition(p);
          var heading = google.maps.geometry.spherical.computeHeading(
            lastPosn,
            p
          );
          icon.rotation = heading;

          $('img[src="{{asset("assets/layout/images/mod.svg")}}"]').css({
            'transform': 'rotate(' + heading + 'deg)',
            'transform-origin': '39px 60px'
          })
        }
        

      });
      if(this.socket_status == false) {
        setTimeout("animate(1)", 500); // Allow time for the initial map display
      }
    }

    function animate(d) {
      if(this.socket_status == false) {
        if (d > eol) {
          map.panTo(endLocation.latlng);
          marker.setPosition(endLocation.latlng);
          return;
        }
        var socket_status = false;
        var p = polyline.GetPointAtDistance(d);

        if (p != false) {
          map.panTo(p);
          var lastPosn = marker.getPosition();
          marker.setPosition(p);
          var heading = google.maps.geometry.spherical.computeHeading(
            lastPosn,
            p
          );
          icon.rotation = heading;
        }

        $('img[src="{{asset("assets/layout/images/mod.svg")}}"]').css({
          'transform': 'rotate(' + heading + 'deg)',
          'transform-origin': '39px 60px'
        });

        timerHandle = setTimeout("animate(" + (d + meters) + ")", milliseconds);
      }
    }


    // === first support methods that don't (yet) exist in v3
    google.maps.LatLng.prototype.distanceFrom = function(newLatLng) {
      var EarthRadiusMeters = 6378137.0; // meters
      var lat1 = this.lat();
      var lon1 = this.lng();
      var lat2 = newLatLng.lat();
      var lon2 = newLatLng.lng();
      var dLat = ((lat2 - lat1) * Math.PI) / 180;
      var dLon = ((lon2 - lon1) * Math.PI) / 180;
      var a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos((lat1 * Math.PI) / 180) *
        Math.cos((lat2 * Math.PI) / 180) *
        Math.sin(dLon / 2) *
        Math.sin(dLon / 2);
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
      var d = EarthRadiusMeters * c;
      return d;
    };

    google.maps.LatLng.prototype.latRadians = function() {
      return (this.lat() * Math.PI) / 180;
    };

    google.maps.LatLng.prototype.lngRadians = function() {
      return (this.lng() * Math.PI) / 180;
    };

    // === A method which returns the length of a path in metres ===
    google.maps.Polygon.prototype.Distance = function() {
      var dist = 0;
      for (var i = 1; i < this.getPath().getLength(); i++) {
        dist += this.getPath()
          .getAt(i)
          .distanceFrom(this.getPath().getAt(i - 1));
      }
      return dist;
    };

    // === A method which returns a GLatLng of a point a given distance along the path ===
    // === Returns null if the path is shorter than the specified distance ===
    google.maps.Polygon.prototype.GetPointAtDistance = function(metres, lat, lng) {

      // some awkward special cases
      if (metres == 0) return this.getPath().getAt(0);
      if (metres < 0) return null;
      if (this.getPath().getLength() < 2) return null;
      var dist = 0;
      var olddist = 0;
      for (var i = 1; i < this.getPath().getLength() && dist < metres; i++) {
        olddist = dist;
        dist += this.getPath().getAt(i).distanceFrom(this.getPath().getAt(i - 1));
      }
      if (dist < metres) {
        return null;
      }

      var p1 = this.getPath().getAt(i - 2);
      var p2 = this.getPath().getAt(i - 1);

      var m = (metres - olddist) / (dist - olddist);


      if (p2.lat() > lat && p2.lng() > lng) {
        return false;
      }

      return new google.maps.LatLng(
        p1.lat() + (p2.lat() - p1.lat()) * m,
        p1.lng() + (p2.lng() - p1.lng()) * m
      ); 
    };


    // === Copy all the above functions to GPolyline ===
    google.maps.Polyline.prototype.Distance = google.maps.Polygon.prototype.Distance;
    google.maps.Polyline.prototype.GetPointAtDistance = google.maps.Polygon.prototype.GetPointAtDistance;


    </script>

    </body>
</html>