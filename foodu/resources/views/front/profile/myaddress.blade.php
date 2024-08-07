<div class="account_details col-xs-12 no_pad">
    <button onClick="insert()" class="add_address go_to_step btn-danger pull-right btn">ADD ADDRESS</button>
  <div class="smallHeading">{!! Lang::get('core.manage_address') !!}</div>
  <div class="user_address flex_wrap row">
    @if(count($address) > 0)
      @foreach($address as $i=>$addr)
        <?php if($addr->address_type == '1'){
          $add_type= trans('core.home');
          $icon = '<i class="fa fa-home"></i>';
        }else if($addr->address_type == '2'){
          $add_type= trans('core.work');
          $icon = '<i class="fa fa-briefcase"></i>';
        }
        else{
          $add_type= "Others";
          $icon = '<i class="fa fa-map-pin"></i>';
        }  ?>
        <div class="col-md-6 col-sm-6 col-xs-12 fn_<?php echo $addr->id; ?>">
          <div class="desktop">
            <div class="left">
              <span class="annotation"><?php echo $icon; ?></span>
            </div>
            <div>
              <h6 class="text-ellipsis">{{$add_type}}</h6>
              <div class="addr-line addressBlock">{{$addr->building}}, {{$addr->address}}</div>
              <div class="actions">
                <a href="javascript:edit(<?php echo $addr->id; ?>);" class="bootstrap-link edit_address" >{!! Lang::get('core.btn_edit') !!}</a>
                <a  class="bootstrap-link  del_address" href="javascript:remove(<?php echo $addr->id; ?>);" >{!! Lang::get('core.btn_delete') !!}</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    @else 
      <div class="no-address col-xs-12 col-sm-12 ">
      <img class="add_ress" src="../{{CNF_THEME}}/themes/maintheme/images/door.png" style="height: 300px;object-fit: cover;width: 200px;">
      <h3>Can't find a door to knock</h3>
       <h4> {!! trans('core.pro_you_dont_have_adrs') !!}</h4>
      </div>
    @endif
    <div class="clearfix"></div>
  </div>
</div>
<script type="text/javascript">
  function remove(id){

    if(confirm("{!! Lang::get('core.sure_delete') !!}")){
     var url = "{{ URL::to('/')}}/address";
     $.ajax({
      url: url,
      type: "get",
      data: {id:id,key:"delete"},
      success: function(data){
       var alert = '<div class="clearfix"></div><div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>{!! Lang::get("core.success") !!}!</strong>  {!! Lang::get("core.delete_address") !!}.</div>';
       $(".alert_fn").append(alert);
       $(".alert-dismissable").fadeTo(2000, 500).slideUp(500, function(){
        $(".alert-dismissable").alert('{!! Lang::get("core.close") !!}');
      });   
       $(".fn_"+id).remove();
     }

   });
   }

 }
</script>
<script src="https://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key=AIzaSyC2_JaEArN6eNLIY4WZKMnW5KhB9kT1O8o"></script>
<!-- Modal -->

<script type="text/javascript">

  $(document).ready(function()
  {
    /*$(".edit_address").click(function(){
      
    });*/
  })
function getLocation_pos(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(geoSuccess_place, showError_place);
    } else { 
        alert("Geolocation is not supported by this browser.");
    }
}
function geoSuccess_place(position) {
    var geocoder = new google.maps.Geocoder();
    var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    var lat = position.coords.latitude;
    var lng = position.coords.longitude;
    if (geocoder) {
        geocoder.geocode({ 'latLng': latLng}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var components = results[0].address_components;
                $('#a_addr').val(results[0].formatted_address);
                $('#a_lat').val(lat);
                $('#a_lang').val(lng);
                initialize();
                address_check();
            }
            else {
                $('#a_lat').val('');
                $('#a_lang').val('');
                $("#a_addr").val(''); 

            }
        });
    } 
}
function address_check(){
        var addr = $('#a_addr').val();
        var from = $('#addr').val();
        var lat = $('#a_lat').val();
        var res_id = $("#res_id").val();
        var lang = $('#a_lang').val();
        $("#location").val(addr);
        $(".alert_fn").html('');
    }
function showError_place(error){
    var innerHTML = '';
    switch(error.code) {
        case error.PERMISSION_DENIED:
        innerHTML = "You have blocked browser from tracking your location. To use this, change your location settings in browser."
        break;
        case error.POSITION_UNAVAILABLE:
        innerHTML = "Location information is unavailable."
        break;
        case error.TIMEOUT:
        innerHTML = "The request to get user location timed out."
        break;
        case error.UNKNOWN_ERROR:
        innerHTML = "An unknown error occurred."
        break;
    }
    $('#location').val(innerHTML);
}
  function insert(){
  getLocation_pos();
  $('#id').val('');
  $("#building").val('');
  $("#landmark").val('');
    setTimeout(function(){ resizingMap() }, 1000);
      $("#map_modal").addClass("left-active");
      $('.overlay').show();
      initialize();
  }
  function edit(id){
   var url = "{{ URL::to('/')}}/address";
   $.ajax({
    url: url,
    type: "get",
    dataType: "json",
    data: {id:id,key:"edit"},
    success: function(data){
      $('#id').val(data.id);
     $('#a_lat').val(data.lat);
     $('#a_lang').val(data.lang);
     $('#location').val(data.address);
     $('#a_addr').val(data.address);
     $('#building').val(data.building);
     $('#landmark').val(data.landmark);
     $('input:radio[name="address_type"]').prop("checked", false);
     $('#address_type_'+data.address_type).prop("checked", true);
     //$('input:radio[name="address_type"]').filter('#address_type_'+data.address_type).attr('checked', true);
      setTimeout(function(){ resizingMap() }, 1000);
      $("#map_modal").addClass("left-active");
      $('.overlay').show();
      console.log(data);
      initialize();

     $(".address_values input").each(function()
     {
      var v = $(this).val();
      if(v != '')
      {
        $(this).next().addClass('still');
      }
      else
      {
        $(this).next().removeClass('still');
      }
    })
     $(".address_values input").keyup(function()
     {
      var v = $(this).val();
      if(v != '')
      {
        $(this).next().addClass('still');
      }
      else
      {
        $(this).next().removeClass('still');
      }
    })
   }

 });


 }

 

 var map;
 var marker;
 var myLatlng = new google.maps.LatLng($('#a_lat').val(),$('#a_lang').val());
 var geocoder = new google.maps.Geocoder();
 var infowindow = new google.maps.InfoWindow();
 function initialize(){
   var mapOptions = {
    zoom: 15,
    scaleControl: false,
    mapTypeControl: false,
    scrollwheel: false,
   navigationControl: false,
   disableDefaultUI: true,
   zoomControl: false,
    center: new google.maps.LatLng($('#a_lat').val(),$('#a_lang').val()),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(document.getElementById("myaddrMap"), mapOptions);
  marker = new google.maps.Marker({
    map: map,
    position: new google.maps.LatLng($('#a_lat').val(),$('#a_lang').val()),
    draggable: true 
  });     

  geocoder.geocode({'latLng': myLatlng }, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      if (results[0]) {
        $('#a_addr').val(results[0].formatted_address);
        $('#location').val(results[0].formatted_address);
        $('#a_lat').val(marker.getPosition().lat());
        $('#a_lang').val(marker.getPosition().lng());
        infowindow.setContent(results[0].formatted_address);
        infowindow.open(map, marker);
      }
    }
  });


  google.maps.event.addListener(marker, 'dragend', function() {

    geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
 
      if (status == google.maps.GeocoderStatus.OK) {
        if (results[0]) {
          $('#a_addr').val(results[0].formatted_address);
          $('#location').val(results[0].formatted_address);
          $('#a_lat').val(marker.getPosition().lat());
          $('#a_lang').val(marker.getPosition().lng());
          infowindow.setContent(results[0].formatted_address);
          infowindow.open(map, marker);

        }
      }
    });
  });
  google.maps.event.addListener(map, 'click', function (event) {

            // console.log(event);
            placeMarker(event.latLng);
            geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                  $('#a_addr').val(results[0].formatted_address);
                  $('#location').val(results[0].formatted_address);
                  $('#a_lat').val(marker.getPosition().lat());
                  $('#a_lang').val(marker.getPosition().lng());
                  infowindow.setContent(results[0].formatted_address);
                  infowindow.open(map, marker);

                }
              }
            });
          });

}
google.maps.event.addDomListener(window, "resize", resizingMap());

/*$('#map_modal').on('show.bs.modal', function() {
 resizeMap();
})*/

function resizeMap() {
 if(typeof map =="undefined") return;
 setTimeout( function(){resizingMap();} , 400);
}

function resizingMap() {
 if(typeof map =="undefined") return;
 var center = new google.maps.LatLng($('#a_lat').val(),$('#a_lang').val());
 google.maps.event.trigger(map, "resize");
 map.setCenter(center); 
}

function placeMarker(location) {
  if (marker == undefined){
    marker = new google.maps.Marker({
      position: location,
      map: map, 
      animation: google.maps.Animation.DROP,
    });
  } else {
    marker.setPosition(location);
  }
  map.setCenter(location);
}


function saveMapToDataUrl(addr,lat,lang) {

 <?php
    $keys = \AbserveHelpers::site_setting('googlemap_key');
  ?>  
  var dataUrl = " https://maps.googleapis.com/maps/api/staticmap?center="+lat+","+lang+"&zoom=13&size=400x400&markers=color:blue%7Clabel:S%7C11211%7C11206%7C11222&key=<?= $keys->googlemap_key ?>";
  $(".static-map").html('<img src="' + dataUrl + '"/>');
}



</script>