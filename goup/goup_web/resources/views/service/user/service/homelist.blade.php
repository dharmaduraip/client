<?php  exit; ?>

@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
   <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/services.css')}}"/>
@stop
@section('content')
<!-- Schedule service Modal -->
<div id="mySidenav" class="sidenav">
      </div>
      <!-- Schedule Service Modal -->
      <div class="modal" id="myModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Schedule Service Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('user.Schedule_Service')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Schedule Service body -->
               <div class="modal-body">
                  <input class="form-control date-picker" type="date" name="date" onkeypress="return false">
                  <input class="form-control time-picker" type="text" name="time" onkeypress="return false">
               </div>
               <!-- Schedule Service footer -->
               <div class="modal-footer">
                  <a  id="schedule-later" class="btn btn-primary btn-block " data-toggle="modal" data-target="#myModal">@lang('user.Schedule_later')</a>
               </div>
            </div>
         </div>
      </div>
      <div class="modal" id="descriptionModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Emergency Contact Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('user.Reason_For_Cancellation')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Emergency Contact body -->
               <div class="modal-body">
                  <div class="c-pointer dis-column">
                     <h5 class="text-left mb-2">@lang('user.Upload_Image')</h5>
                     <div class="add-document">
                        <img src="../img/svg/add.svg" alt="add_document">
                     </div>
                     <div class="fileUpload up-btn profile-up-btn">                   
                        <input type="file" id="profile_img_upload_btn" name="picture" class="upload" accept="image/x-png, image/jpeg">
                     </div>
                  </div>
                  <textarea class="form-control" rows="4" cols="50" placeholder="Leave Your Comments..."></textarea>
               </div>
               <!-- Emergency Contact footer -->
               <div class="modal-footer">
                  <a  class="btn btn-primary btn-block" data-toggle="modal" data-target="#descriptionModal">{{ __('Submit') }} <i class="fa fa-check" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
      </div>
      <!-- Emergency Contact Modal -->
       <!-- Reviews  Modal -->
      <div class="modal" id="reviewModal">
            <div class="modal-dialog">
               <div class="modal-content">
                  <!-- Reviews Header -->
                  <div class="modal-header">
                     <h4 class="modal-title">@lang('user.Reviews')</h4>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Reviews body -->
                  <div class="modal-body">
                        <div class="col-md-12 col-lg-12 col-sm-12 p-0">
                              <ul class="provider-list invoice height50vh ratingpanel">
                                 
                              </ul>
                           </div>
                    
                  </div>
               </div>
            </div>
      </div>

     <!--Description details !-->
     <div class="modal" id="requestdescriptionModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Emergency Contact Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('user.Description_Details')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Emergency Contact body -->
               <div class="modal-body">
                  <textarea class="form-control" name="description" id="description">
                  </textarea>
               </div>
               <!-- Emergency Contact footer -->
               <div class="modal-footer">
                  <a id ="before_comment_details"  class="btn btn-primary btn-block" data-toggle="modal" data-target="#contactModal">{{ __('Submit') }} <i class="fa fa-check" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
      </div>
      <!--Logic starts here!-->
      <section class="content-box">
         <div id="toaster" class="toaster">
            @include('common.admin.components.toast')
         </div>
         <div class="col-sm-12 col-md-12 col-lg-12 p-0">
            <div class="ride-section">
               <form class="trip-frm2 w-100">
                  <div class="col-md-12 col-sm-12 col-lg-12 p-0 dis-reverse align-items-start">
                  <div id="map" class="col-sm-12 col-md-12 col-lg-6 map-section" style="width:100%; height: 500px; box-shadow: 2px 2px 10px #ccc;">
                        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2970.652981076582!2d-87.63116368463953!3d41.87881207334865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e2cbcb88d3b45%3A0x37ef3145a8a1c23d!2sUnited+States+Attorney&#39;s+Office!5e0!3m2!1sen!2sin!4v1549101057336" width="0" height="0" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                     </div>
                     <div  class="col-sm-12 col-md-12 col-lg-6 form-section">
                        <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                           <h5 class="text-left mb-3">@lang('user.Book_Service')</h5>
                           <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                              <!-- <span class="fa fa-location-arrow" style=" position: absolute; left: 2%; top: 35%;color: #ffa200;font-size: 18px;"></span> -->
                              <input id="origin-input" name="s_address" class="form-control" type="text" placeholder=" Enter Service Location" autocomplete="off">
                              
                              <!-- <i class="fa fa-heart-o" style=" color: #000;"></i> -->
                           </div>
                        </div>

                        <input type="hidden" name="s_latitude" id="origin_latitude">
                        <input type="hidden" name="s_longitude" id="origin_longitude">
                        <input type="hidden" name="current_longitude" id="long">
                        <input type="hidden" name="current_latitude" id="lat">
                        <input type="hidden" name="provider" id="provider" value="">
                        <input type="hidden" name="request_type" id="request_type" value="">
                        <div id="payment_detail">
                           <h5>@lang('user.Payment_Methods')</h5>
                           <select class="custom-select" name="payment" id="select_payment">
                              <option value="CASH" selected="">CASH</option>
                              <option value="CARD">Card</option>
                           </select>
                        </div><br>
                        <div id="promocode_detail">
                           <h5>@lang('user.promocode')</h5>
                           <select class="custom-select" name="promocode_id" id="promocode">
                              <option value="" data-percent="0" data-max="0">@lang('user.promocode_select')</option>
                           </select>
                        </div>
                        <div id ="provider_list" class="col-md-12 col-lg-12 col-sm-12 p-0">
                        </div>
                     </div>
                  </div>
               </form>
            </div>

            <div id="root"></div>
            
         </div>
      </section>
          

@stop
@section('scripts')
@parent
<script>
   window.salt_key = '{{ Helper::getSaltKey() }}';
</script>
<script type="text/javascript">
    var current_latitude = 13.0574400;
    var current_longitude = 80.2482605;

    if( navigator.geolocation ) {
       navigator.geolocation.getCurrentPosition( success, fail );
    } else {
        console.log('Sorry, your browser does not support geolocation services');
        initAutocomplete();
    }

    function success(position)
    {
        document.getElementById('long').value = position.coords.longitude;
        document.getElementById('lat').value = position.coords.latitude

        if(position.coords.longitude != "" && position.coords.latitude != ""){
            current_longitude = position.coords.longitude;
            current_latitude = position.coords.latitude;
        }
        initAutocomplete();
    }

    function fail()
    {
        // Could not obtain location
        console.log('unable to get your location');
    }
//For google map
function initAutocomplete(){

var originLatitude = document.getElementById('origin_latitude');
var originLongitude = document.getElementById('origin_longitude');

var lat = current_latitude,
lng = current_longitude,
latlng = new google.maps.LatLng(lat, lng),
image = 'http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png'; 

var mapOptions = {           
    center: new google.maps.LatLng(lat, lng),           
    zoom: 15,           
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    styles : [{"elementType":"geometry","stylers":[{"color":"#f5f5f5"}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"elementType":"labels.text.stroke","stylers":[{"color":"#f5f5f5"}]},{"featureType":"administrative.land_parcel","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#e4e8e9"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"poi.park","elementType":"geometry.fill","stylers":[{"color":"#7de843"}]},{"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#ffffff"}]},{"featureType":"road.arterial","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},{"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},{"featureType":"transit.line","elementType":"geometry","stylers":[{"color":"#e5e5e5"}]},{"featureType":"transit.station","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#c9c9c9"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#9bd0e8"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]}]

},
map = new google.maps.Map(document.getElementById('map'), mapOptions),
marker = new google.maps.Marker({
    position: latlng,
    map: map,
    icon: image
 });

var input = document.getElementById('origin-input');         
var autocomplete = new google.maps.places.Autocomplete(input); 

autocomplete.bindTo('bounds', map); 
var infowindow = new google.maps.InfoWindow(); 


google.maps.event.addListener(autocomplete, 'place_changed', function() {
infowindow.close();
    var place = autocomplete.getPlace();
    if (place.geometry.viewport) {
        map.fitBounds(place.geometry.viewport);
    } else {
        map.setCenter(place.geometry.location);
        map.setZoom(17);  
    }
    
    moveMarker(place.name, place.geometry.location);
});  


 $("input").focusin(function () {
    $(document).keypress(function (e) {
        if (e.which == 13) {
            infowindow.close();
            var firstResult = $(".pac-container .pac-item:first").text();
            
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({"address":firstResult }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var lat = results[0].geometry.location.lat(),
                        lng = results[0].geometry.location.lng(),
                        placeName = results[0].address_components[0].long_name,
                        latlng = new google.maps.LatLng(lat, lng);
                    moveMarker(placeName, latlng);
                    // $("#s_address").val(firstResult);
                }
            });
        }
    });
});
 
 function moveMarker(placeName, latlng){
    originLatitude.value = latlng.lat();
    originLongitude.value = latlng.lng();
    marker.setIcon(image);
    marker.setPosition(latlng);
    infowindow.setContent(placeName);
    infowindow.open(map, marker);
 }

}
// <!--end map!-->
</script>
<!-- <script type="text/javascript" src="{{ asset('assets/layout/js/map.js') }}"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initAutocomplete" async defer></script>

<script crossorigin src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
<!-- <script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.production.min.js"></script> -->

<script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.development.js"></script>


<script type="text/babel" src="{{ asset('assets/layout/js/service/waiting.js') }}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/plugins/data-tables/js/dataTables.bootstrap.min.js')}}"></script>
<script>
var provider_id = null;
      //search for provider location details and list the detail
         //List the provider details
         $('#payment_detail').hide();
         $('#promocode_detail').hide();
         //Promocode display in dropdown
         $.ajax({
            url: getBaseUrl() + "/user/promocode",
            type:"GET",
            processData: false,
            contentType: false,
            headers: {
                  Authorization: "Bearer " + getToken("user")
            },
            success: (data, textStatus, jqXHR) => {
               if(Object.keys(data.responseData).length != 0) {
                  var promocodes = data.responseData;
                  $.each(promocodes, function(i,val){

                        $('#promocode')
                        .append($("<option></option>")
                                    .attr("value",val.id)
                                    .attr("data-percent",val.percentage)
                                    .attr("data-max",val.max_amount)
                                    .text(val.promo_code)); 
                  });
               }
            }
         });
          //Change the location display the detail
         $("input[name=s_address]").on('change', function() { alert(1111);
            $('#payment_detail').show();
            $('#promocode_detail').show();
            setTimeout(function(){ 
             var lat=$('input[name=s_latitude]').val();
             var long=$('input[name=s_longitude]').val(); 
              $.ajax({
                 url: getBaseUrl() + "/user/list?lat="+lat+"&long="+long+"&id="+{{$id}},
                 type: "GET",
                 headers: {
                     Authorization: "Bearer " + getToken("user")
                 },
               success:function(data){
               var html = ``;
               var currency = data.responseData.currency;
               var result = data.responseData.provider_service;
               if(result.length!=0){ alert(1111);
                     html += `<ul id ="provider_list" class="provider-list invoice height50vh">`;
                        $.each(result,function(key,item){
                           starvalue=``;
                           for (i = 0; i < item.rating; i++) { 
                                 starvalue = starvalue + `
                                 <div class="rating-symbol" style="display: inline-block; position: relative;">
                                    <div class="fa fa-star-o" style="visibility: visible;"></div>
                                    <div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px;top: 0; width: auto;"><span class="fa fa-star" aria-hidden="true"></span></div>
                                 </div>
                                 `;
                           }
                           html += `<li class="row">
                                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                             <img src="`+item.picture+`" class="user-img">
                                             <div class="user-right">
                                                <h5 class="d-inline">`+item.first_name+`</h5> 
                                                <a class="float-right c-pointer txt-primary review reviewModal" data-toggle="modal" 
                                                data-id =`+item.id+`> View reviews <i class="fa fa-eye"></i></a>
                                                <div class="rating-outer">
                                                   <span style="cursor: default;">
                                                      `+ starvalue+`
                                                   </span>
                                                   <input type="hidden" class="rating" value="1" disabled="disabled">
                                                
                                                </div>
                                             </div>
                                          </div>
                                          <div class="dis-flex-start">`;
                                          html +=`<div class=" top small-box green mb-2 position-relative col-xl-6 col-md-6 sol-sm-12">
                                             <div class="ml-2">
                                                <h2>Base fare</h2>
                                                <h2>`+currency + ` `+ item.base_fare +` </h2>
                                             </div>
                                          </div>`;

                                            if(item.fare_type=='HOURLY'){                             
                                                html +=`<div class=" top small-box green mb-2 position-relative col-xl-6 col-md-6 sol-sm-12 ml-2">
                                                  <div class="ml-2">
                                                     <h2>Hourly Fare</h2>
                                                     <h2>`+currency + ` ` + item.per_mins +`</h2>
                                                  </div>
                                               </div>`;
                                           }

                                           if(item.fare_type=='DISTANCETIME'){                             
                                                html +=`<div class=" top small-box green mb-2 position-relative col-xl-6 col-md-6 sol-sm-12 ml-2">
                                                  <div class="ml-2">
                                                     <h2>Hourly Fare</h2>
                                                     <h2>`+currency + ` ` + item.per_mins +`</h2>
                                                  </div>
                                               </div>`;

                                               html +=`<div class="top small-box green mb-2 position-relative col-xl-6 col-md-6 sol-sm-12">
                                                  <div class="ml-2">
                                                     <h2>Distance Fare</h2>
                                                     <h2>`+currency + ` ` + item.per_miles +`</h2>
                                                  </div>
                                               </div>`;
                                           }

                                    html +=`</div>
                                          <div class="actions col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                             <a id="schedule_service"  data-id =`+item.id+`  class="btn btn-green">Schedule Later <i class="fa fa-clock-o" aria-hidden="true"></i></a>
                                             <a id="request_service" class="btn  btn-green ml-3"  data-target="#description" data-id =`+item.id+`>Request a Service <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                          </div>
                                       </div>
                                    </li>`;
                        });
                        html += `</ul>`;
                     }else{
                           html += `<ul id ="provider_list" class="provider-list invoice height50vh">
                                 <li class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                          <h5 class="d-inline"> Providers Not Found For the Location</h5> 
                                       </div>
                                    </div>
                                 </li>
                              </ul>`;
                     }
                     $('#provider_list').before(html);
                  } 
               });
            }, 700);  
         });
         //For promocode details
         $('#promocode').on('change', function() {
            var pedatacentage='';
            var estimate = $("#est_amt").text();
            var percentage = $('option:selected', this).attr('data-percent');
            var max_amount = $('option:selected', this).attr('data-max');
            var percent_total = estimate * pedatacentage/100;
               if(percent_total > max_amount) {
                  promo = parseFloat(max_amount);
               }else{
                  promo = parseFloat(percent_total);
               }
               $("#promo_amount").html(promo.toFixed(2));
               $("#total_amount").html((estimate-promo).toFixed(2));
         });
         //get the value in front page..
            $(document).on('click',"#request_service, #schedule-later", function(e){
            
               $('#provider').val($(this).data('id'));
               $('#request_type').val($(this).attr('id'));
               var id = "{{$id}}";
               var userSettings = getUserDetails();
               $.ajax({
                  type:"GET",
                  url: getBaseUrl() + "/user/servicelist/"+id+"?city_id="+userSettings.card_id,
                  headers: {
                        Authorization: "Bearer " + getToken("user")
                  },
                  success:function(data){
                     var result = data.responseData;
                     var check_desc =$('#allow_description').val();
                     if(check_desc!='undefined' || check_desc.length<0){
                       $("#requestdescriptionModal").modal('show');
                    }else{
                        if(result.allow_desc==1){
                          $("#requestdescriptionModal").modal('show');
                        }
                        else{
                          sendRequest();
                        }
                     }
                  }
               });
               
               $(document).on('click', '#before_comment_details', function(){
                  var id = "{{$id}}";
                  $("#requestdescriptionModal").modal('hide');
                  sendRequest();
               });
         });
         //Modal show the value
         $(document).on('click', '.reviewModal', function(){
            provider_id = $(this).data('id');
            // $.ajax({
            //       type:"GET",
            //       url: getBaseUrl() + "/user/reviewlist/"+provider_id,
            //       headers: {
            //             Authorization: "Bearer " + getToken("user")
            //       },
            //       success:function(data){
            //          var result = data.responseData;
            //          var check_desc =$('#allow_description').val();
            //          if(check_desc!='undefined' || check_desc.length<0){
            //            $("#requestdescriptionModal").modal('show');
            //         }else{
            //             if(result.allow_desc==1){
            //               $("#requestdescriptionModal").modal('show');
            //             }
            //             else{
            //               sendRequest();
            //             }
            //          }
            //       }
            //    });
            // $("#reviewModal").modal('show'); 
         });
         $(document).on('click', '#schedule_service', function(){
            provider_id = $(this).data('id');
            $("#myModal").modal('show'); 
         });
         $("#book-now, #schedule-later").click(function() {
            var that = $(this);
            var data = {};
               var provider_id = $('#provider').val();
               var request_type = $('#request_type').val();
               var serviceid = "{{$id}}";
               data["service_id"] = "{{$id}}";
               data["s_latitude"] = $('#origin_latitude').val();
               data["s_longitude"] = $('#origin_longitude').val(); 
               data["s_address"] = $('input[name=s_address]').val();
               data["promocode_id"] = $('#promocode').val();
               data["payment_mode"] = $('select[name=payment]').val();
               data["allow_description"] = $('#allow_description').val();
               data["allow_image"] = $('#allow_image').val();

               if(request_type == "schedule-later") {
                  data["schedule_date"] = $('input[name=date]').val();
                  data["schedule_time"] = $('input[name=time]').val();
               }

            sendRequest(data, that.attr('id'));

            });
         //Save the record details
         function sendRequest(data, type) {
            showLoader();
            var data = {};
            var provider_id = $('#provider').val();
            var request_type = $('#request_type').val();
            var serviceid = "{{$id}}";
            data["service_id"] = "{{$id}}";
            data["s_latitude"] = $('#origin_latitude').val();
            data["s_longitude"] = $('#origin_longitude').val(); 
            data["s_address"] = $('input[name=s_address]').val();
            data["promocode_id"] = $('#promocode').val();
            data["payment_mode"] = $('select[name=payment]').val();
            data["allow_description"] = $('#allow_description').val();
            data["allow_image"] = $('#allow_image').val();

            if(request_type == "schedule-later") {
               data["schedule_date"] = $('input[name=date]').val();
               data["schedule_time"] = $('input[name=time]').val();
            }

            $.ajax({
               url: getBaseUrl() + "/user/service/send/request?id="+provider_id,
               type: "post",
               data: data,
               headers: {
                     Authorization: "Bearer " + getToken("user")
               },
               beforeSend: function() {
                 // showLoader();
               },
               success: (data, textStatus, jqXHR) => {
                  hideLoader();
                  
                  //window.location.replace("/user/service/"+serviceid);
                  if(request_type == "schedule-later") {
                        $("#service-status").removeClass("d-none");
                        $(".ride-section").addClass("d-none");
                        initMap();
                        alertMessage("Success", "New Schedule created", "success")
                  } else {
                     $("#service-status").removeClass("d-none");
                     $(".ride-section").addClass("d-none");
                  }
                  $("#request_service").closest('form')[0].reset();
                  location.reload();
               },
               error: (jqXHR, textStatus, errorThrown) => {
                  // alertMessage("Error", jqXHR.responseJSON.message, "danger")
                  hideLoader();
               }
            });
         }
         //reviews details for particular provider
         $(document).on('click', '.review', function(){
            var id = $(this).data('id');
            $.ajax({
               type:"GET",
               url: getBaseUrl() + "/user/review/"+id,
               headers: {
                     Authorization: "Bearer " + getToken("user")
               },
               success:function(data){
                
                  var result = data.responseData.review;
                  output ='';
                  output += ``;
                  if(result.length!=0){
                    $.each(result,function(key,item){
                       starvalue=``; 
                       for (i = 0; i < item.user_rating; i++) { 
                          starvalue = starvalue + `<div class="rating-symbol" style="display: inline-block; position: relative;">
                             <div class="fa fa-star-o" style="visibility: visible;"></div>
                             <div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px;top: 0; width: auto;"><span class="fa fa-star" aria-hidden="true"></span></div>
                          </div>
                          `;
                       }
                       ratedUserfname = item.user.first_name;
                       ratedUserlname = item.user.last_name;
                       ratedUsername = ratedUserfname + ratedUserlname;
                    output += `<li class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                            <img src="`+ item.user.picture+ `" class="user-img">
                                            <div class="user-right">
                                               <h5 class="d-inline">`+ ratedUsername + `</h5> 
                                               <div class="rating-outer">
                                                  <span style="cursor: default;">
                                                  `+ starvalue + `
                                                  </span>
                                                  <input class="rating" value="1" disabled="disabled" type="hidden">
                                                 
                                               </div>
                                            </div>
                                         </div>
                                         <div class="dis-row">
                                               <span>` +item.user_comment +`</span>
                                         </div>
                                         
                                      </div>
                                   </li> `;
                       
                       // $('.user-img').attr('src',result.user.picture);
                       // $('.first_name').text(result.user.first_name); 
                       $('.star').html(starvalue); 

                    });
                  }else{
                     output += `<li class="row">No Reviews Yet</li>`;
                  }
                  $(".ratingpanel").html(output);

                  $("#reviewModal").modal('show');
               }
            });
         });
         function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
          }
          
          function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
          }
         
           // Input Checked
          $(document).ready(function(){
            $('input:checkbox').click(function() {
               $('input:checkbox').not(this).prop('checked', false);
            });
          });
            $(document).on('click', '#cancel_req_1', function(e){
               e.preventDefault();
               var id = $(this).data('id');
               var result = confirm("Are You sure Want to delete?");
               $.ajax({
                  url: getBaseUrl() + "/user/cancelrequest/"+id,
                  type: "Post",
                  headers: {
                     Authorization: "Bearer " + getToken("user")
                  },
                  processData: false,
                  contentType: false,
                  success: function(response, textStatus, jqXHR) {
                     location.reload();
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                     alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                  }
               });
            });
            //get provider status details
            $(document).on('click', '.status', function(){
               
            });
            $("#book-now").click(function() {
               $("#service-status").removeClass("d-none");
               $("#booking-ride").addClass("d-none");
            });
            $("#cancel_req").click(function() {
               $(".ride-section").removeClass("d-none");
               $("#service-status").addClass("d-none");
            });
         
            $(".status").click(function() {
               $("#accepted-status").removeClass("d-none");
               $("#service-status").addClass("d-none");
            });
            $("#cancel_req_2").click(function() {
               $(".ride-section").removeClass("d-none");
               $("#accepted-status").addClass("d-none");
            });
            $(".trip-user").click(function() {
               $("#invoice-section").removeClass("d-none");
               $("#accepted-status").addClass("d-none");
            });
      </script>
@stop
