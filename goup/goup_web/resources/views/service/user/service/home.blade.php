@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
   <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/services.css')}}"/>
   <style type="text/css">
   .upload-btn-wrapper {
  position: relative;
  overflow: hidden;
  display: inline-block;
  background-color:#7594ac;
  /*background-image: url("/assets/layout/images/file.png");*/
  background-repeat: no-repeat!important;
  cursor: pointer!important;
  color: #fff;
    padding: 0 10px;
    border-radius: 10px;
    text-align: center;
}

.btn {
  border: 2px solid gray;
  color: gray;
  background-color: white;
  padding: 8px 20px;
  border-radius: 8px;
  font-size: 20px;
  font-weight: bold;
}

.upload-btn-wrapper input[type=file] {
  /*font-size: 100px;*/
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
  cursor: pointer!important;
}
.upload-btn-wrapper img {
      width: 100px;
    height: 100px;
    margin: 0 auto;
    display: block;
    object-fit: contain;
}
input[type=file], /* FF, IE7+, chrome (except button) */
input[type=file]::-webkit-file-upload-button { /* chromes and blink button */
    cursor: pointer; 
}
</style>
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
                  <h4 class="modal-title">@lang('service.user.schedule_service')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Schedule Service body -->
               <div class="modal-body">
                  <input class="form-control" type="text" placeholder="MM/DD/YYYY" name="date" onkeypress="return false">
                  <input class="form-control time-picker" type="text" placeholder="HH:MM" name="time" onkeypress="return false">
                  <input type="hidden" name="request_type" id="request_type" value="">
               </div>
               <!-- Schedule Service footer -->
               <div class="modal-footer">
                  <a  id="schedule-later" data-value="schedule-later" class="btn btn-primary btn-block " >@lang('service.user.schedule_later')</a>
               </div>
            </div>
         </div>
      </div>
      <div class="modal" id="descriptionModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Emergency Contact Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('service.user.reason_for_cancellation')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Emergency Contact body -->
               <div class="modal-body">
                  <div class="c-pointer dis-column">
                     <h5 class="text-left mb-2">@lang('service.user.upload_image')</h5>
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
                  <a   class="btn btn-primary btn-block description" data-toggle="modal" data-target="#descriptionModal">@lang('service.submit')  <i class="fa fa-check" aria-hidden="true"></i></a>
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
                     <h4 class="modal-title">@lang('service.user.reviews') </h4>
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
                  <h4 class="modal-title">@lang('service.user.description_details')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Emergency Contact body -->
               <form role="form"   id="devis"  enctype="multipart/form-data" class="form-horizontal">
               <div class="modal-body">
                    
                    <div class="row">
                        <div class=" col-md-12">
                            <textarea class="form-control" name="description"  placeholder="write your description..." id="allow_description">
                            </textarea>
                        </div>
                        <div class="upload-btn-wrapper col-md-12 pointer" style="cursor: pointer!important;">
                            
                            <input type="file" id="allow_image" name="allow_image" class="pointer"  style="cursor: pointer!important;" />
                            <img id="image" src="" height="50px" width="50px" class="d-none"/>
                            <button  class="btn btn-primary" id="doc_preview" >@lang('service.user.upload_description_image')</button>
                        </div>
                    </div>
                    
                </div>
               <!-- Emergency Contact footer -->
               <div class="modal-footer">
                  <a id ="before_comment_details"  class="btn btn-primary btn-block" data-toggle="modal" data-target="#contactModal">@lang('service.submit') <i class="fa fa-check" aria-hidden="true"></i></a>
               </div>
               </form>
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
                  <div id="map" class="map-section" style="width:100%; height: 500px; box-shadow: 2px 2px 10px #ccc;">
                        <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2970.652981076582!2d-87.63116368463953!3d41.87881207334865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e2cbcb88d3b45%3A0x37ef3145a8a1c23d!2sUnited+States+Attorney&#39;s+Office!5e0!3m2!1sen!2sin!4v1549101057336" width="0" height="0" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                     </div>
                     <div  class="col-sm-12 col-md-12 col-lg-6 form-section srchlist-bfr">
                        <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                          <br/>
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
                        <input type="hidden" name="quantity" id="quantity" value="{{Request::get('qty')?:''}}">
                        <div id="payment_detail">
                           <h5>@lang('user.Payment_Methods')</h5>
                           <select class="custom-select" name="payment" id="select_payment">
                              @if(Helper::checkPayment('cash'))
                                 <option value="CASH" selected="">@lang('user.CASH')</option>
                              @endif
                              @if(Helper::checkPayment('card'))
                                 <option value="CARD">@lang('user.CARD')</option>
                              @endif
                              @if(Helper::checkPayment('PayPal'))
                                 <option value="PAYPAL">@lang('user.PAYPAL')</option>
                              @endif
                              @if(Helper::checkPayment('NOWPAYMENT'))
                                 <option value="NOWPAYMENT">@lang('user.NOWPAYMENT')</option>
                              @endif
                              @if(Helper::checkPayment('REVOLUT'))
                                 <option value="REVOLUT">@lang('user.REVOLUT')</option>
                              @endif
                           </select>
                        </div><br>
                        <div  id="payment_detail"  class="field-box cards" style="display:none">
                              <h5>@lang('user.select_card')</h5>
                              <select class="custom-select m-0" name="card_id">
                              </select>
                           </div>
                        <div id="promocode_detail">
                           <h5>@lang('user.promocode')</h5>
                           <select class="custom-select" name="promocode_id" id="promocode">
                              <option value="" data-percent="0" data-max="0">@lang('user.promocode_select')</option>
                           </select>
                           <div id="walletBox">
                              <h5>@lang('transport.user.use_wallet') <small> (Available : <span id="wallet_avail"></span>)</small></h5>
                              <div class="choose-mode mb-3 col-sm-12 col-md-12 col-xl-12 p-0">
                                 <span class="radio-box pl-3">
                                    <input type="checkbox" name="use_wallet" value="1" id="use_wallet">
                                    <label for="use_wallet">@lang('transport.user.yes')</label>
                                 </span>
                              </div>
                           </div>
                        </div>                        
                        <span id="provlist">
                       <a class="btn btn-primary provlist"  > {{ __('NEXT') }}</a>
                       </span>
                       
                     </div>
                     <div  class="col-sm-12 col-md-12 col-lg-6 form-section srchlist  ">
                        <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                          <br/>
                           <h5 class="text-left mb-3">  <b><a class=" provlist-back pull-left "  > <i class="fa fa-arrow-left" aria-hidden="true"></i> </a>  </b>    &nbsp; &nbsp;       @lang('user.Providers_Available')   </h5>
                           <div class="field-box col-md-12 col-sm-12 col-lg-12 p-2">
                              <!-- <span class="fa fa-location-arrow" style=" position: absolute; left: 2%; top: 35%;color: #ffa200;font-size: 18px;"></span> -->
                              <input id="q" name="q" class="form-control" type="text" placeholder="Search......" >
                             
                              <!-- <i class="fa fa-heart-o" style=" color: #000;"></i> -->
                           </div>
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

<script type="text/javascript">
    window.salt_key = '{{ Helper::getSaltKey() }}';
    
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

$('input[name=date]').datepicker({
            rtl: false,
            orientation: "left",
            todayHighlight: true,
            autoclose: true,
            startDate:new Date()
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

$('.provlist').on('click',function(){

   var userSettings = getUserDetails();

   if(userSettings.id == 0) {
      window.location.replace("{{ url('/login') }}");
   }

   var payment = $('select[name=payment]').val();
   if(payment == 'CARD' && $('select[name=card_id]').val() == "") {
   $('select[name=card_id]').after(`<span class="error" style="color: red">Card is required</span>`);
   return false;
   }
  $('.srchlist-bfr').hide();
  $('.srchlist').show();
});
$('.provlist-back').on('click',function(){
  $('.srchlist-bfr').show();
  $('.srchlist').hide();
});

$('body').on('change', 'select[name=payment]', function() {
         var payment = $(this).val();
         usercard(payment);
      });

      
     function usercard(payment){
        
      if(payment == "CARD") {
            $('.cards').show();
         } else {
            $('.cards').hide();
         }

     }

     $.ajax({
         type:"GET",
         url: getBaseUrl() + "/user/card",
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         success:function(data){
            var html = ``;
            var result = data.responseData;
            $.each(result,function(key,item){
               $("select[name=card_id]").empty().append('<option value="">SELECT CARD</option>');
               $.each(data.responseData, function(key, item) {
                  $("select[name=card_id]").append('<option value="' + item.card_id + '"> **** **** **** '+item.last_four+'</option>');
               });
            });
         }
      });




document.getElementById("allow_image").onchange = function (obj) {
    var reader = new FileReader();
    console.log(obj.target.files[0]);
    reader.onload = function (e) {
      console.log(e.target);
        // get loaded data and render thumbnail.
        if(obj.target.files[0].type=='image/png'|| obj.target.files[0].type=='image/jpeg' || obj.target.files[0].type=='image/jpg'){
          $('#doc_preview').addClass('d-none');
          $('#image').removeClass('d-none');
          document.getElementById("image").src = e.target.result;
        }else{
          $('#image').addClass('d-none');
          $('#doc_preview').removeClass('d-none');
          var preview = '<span><i class="fa fa-file-pdf-o" aria-hidden="true"></i></span>';
          $('#doc_preview').html(preview);
          
        }
    };

    // read the image file as a data URL.
    reader.readAsDataURL(this.files[0]);
};
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
         $('#provlist').hide();
         $('.provlist-back').hide();
         $('.srchlist').hide();
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
         var provider_result  = ``;
         var currency = '';
          //Change the location display the detail
         $("input[name=s_address]").on('change', function() {
            $('#payment_detail').show();
            $('#promocode_detail').show();
            $('#provlist').show();
            $('.provlist-back').show();
            $("#walletBox").show();
            var payment =$('#select_payment').val();
            usercard(payment);

            $.ajax({
               url: getBaseUrl() + "/user/users",
               type: "GET",
               headers: {
                     Authorization: "Bearer " + getToken("user")
               },
               success:function(data){
                  var userSettings = data;
                  var userwallet = userSettings.message.wallet_balance;
                  if(userwallet <= 0){
                     $("#use_wallet").attr("disabled", true);
                     // $("#walletBox").hide();
                  }else{
                     $("#use_wallet").attr("disabled", false);
                  }
                  $("#wallet_avail").html(currency+userwallet);
               }
            });
           
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
                     provider_result = '';
                     currency = data.responseData.currency;
                     var result = data.responseData.provider_service;
                     provider_result = result;
                     showResults();
                     $("#wallet_avail").html(currency+$("#wallet_avail").text());
                  }               
               });
            }, 700);  
         });
         $('#q').keyup(function( event ) {
          //setTimeout(function(){ 
            var lat=$('input[name=s_latitude]').val();
            var long=$('input[name=s_longitude]').val(); 
            var name = $(this).val();
             //showLoader();
            $.ajax({
               url: getBaseUrl() + "/user/list?lat="+lat+"&long="+long+"&id="+{{$id}}+'&name='+name,
               type: "GET",
               headers: {
                  Authorization: "Bearer " + getToken("user")
               },
               success:function(data){
                  var html = ``;
                  provider_result = '';
                  currency = data.responseData.currency;
                  var result = data.responseData.provider_service;
                  provider_result = result;
                  showResults();
                  //hideLoader();
               }
            
            });
           // }, 700);  

        });      

        function showResults(){  
          var html = ``;
          if(provider_result.length!=0){
                html += `<ul id ="provider_list" class="provider-list invoice height50vh">`;
            $.each(provider_result,function(key,item){
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

                              if(item.fare_type=='FIXED'){      
                                    html +=`<div class=" top small-box green mb-2 position-relative col-xl-6 col-md-6 sol-sm-12">
                                 <div class="ml-2">
                                    <h2>Base fare</h2>
                                    <h2>`+currency + ` `+ item.base_fare +` </h2>
                                 </div>
                              </div>`;                       
                                    
                               }
                              

                                if(item.fare_type=='HOURLY'){      
                                    html +=`<div class=" top small-box green mb-2 position-relative col-xl-6 col-md-6 sol-sm-12">
                                 <div class="ml-2">
                                    <h2>Base fare</h2>
                                    <h2>`+currency + ` `+ item.base_fare +` </h2>
                                 </div>
                              </div>`;                       
                                    html +=`<div class=" top small-box green mb-2 position-relative col-xl-6 col-md-6 sol-sm-12 ml-2">
                                      <div class="ml-2">
                                         <h2>Hourly Fare</h2>
                                         <h2>`+currency + ` ` + item.per_mins +`</h2>
                                      </div>
                                   </div>`;
                               }

                               if(item.fare_type=='DISTANCETIME'){  
                                    html +=`<div class=" top small-box green mb-2 position-relative col-xl-4 col-md-4 sol-sm-12">
                                       <div class="ml-2">
                                          <h2>Base fare</h2>
                                          <h2>`+currency + ` `+ item.base_fare +` </h2>
                                       </div>
                                    </div>`;                           
                                    html +=`<div class=" top small-box green mb-2 position-relative col-xl-4 col-md-4 sol-sm-12 ml-2">
                                      <div class="ml-2">
                                         <h2>Hourly Fare</h2>
                                         <h2>`+currency + ` ` + item.per_mins +`</h2>
                                      </div>
                                   </div>`;

                                   html +=`<div class="top small-box green mb-2 position-relative col-xl-4 col-md-4 sol-sm-12 ml-2">
                                      <div class="ml-2">
                                         <h2>Distance Fare</h2>
                                         <h2>`+currency + ` ` + item.per_miles +`</h2>
                                      </div>
                                   </div>`;
                               }

                        html +=`</div>
                              <div class="actions col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                 <a id="schedule_service"  data-id =`+item.id+`  class="btn btn-primary">Schedule Later <i class="fa fa-clock-o" aria-hidden="true"></i></a>
                                 <a id="request_service" class="btn  btn-primary ml-3"  data-target="#description" data-id =`+item.id+`>Request a Service <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
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
          $('#provider_list').html(html);
        
        
      }



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

         $('body').on('click', '#request_service', function() {
            $('#allow_description').val(" ");
            $('#provider').val($(this).data('id'));
            $('#request_type').val('');
            booking();    
          });
         $('#schedule-later').click(function(){ 
           $('#request_type').val($(this).data('value'));
           booking();
         });

         //  $('#requestdescriptionModal').on('hidden.bs.modal', function () {
               
         //       $('#request_type').val('');
         //  })

           function booking(){
            var userSettings = getUserDetails();
              var id = "{{$id}}";
                $.ajax({
                  type:"GET",
                  url: getBaseUrl() + "/user/servicelist/"+id+"?city_id="+userSettings.card_id,
                  beforeSend: function() {
                    showLoader();
                  },
                  headers: {
                        Authorization: "Bearer " + getToken("user")
                  },
                  success:function(data){
                     var result = data.responseData;
                     var check_desc =$('#allow_description').val();
                     /*if(check_desc!='undefined' || check_desc.length<0  || result.allow_desc==0){
                        $('#allow_description').val(" ");
                        $("#myModal").modal('hide'); 
                       $("#requestdescriptionModal").modal('show');
                      
                       hideLoader();
                    }else{*/
                        if(result.allow_desc==1){
                           $('#allow_description').val(" ");
                           $("#myModal").modal('hide');
                          $("#requestdescriptionModal").modal('show');
                          hideLoader();
                         
                        }
                        else{
                          sendRequest();
                        }
                     //}
                  }
               });
           }

           
         $(document).on('click', '#before_comment_details', function(){
            
            var description=$.trim($('#allow_description').val());
            var image = $('#allow_image').val();
            description=$.trim(description);
           
            if(description.length==0 && image.length == 0){
              alertMessage("error","Please Enter Description as text or file upload", "danger");
            }
            else if(description.length > 0){
               $("#requestdescriptionModal").modal('hide');
               sendRequest();         
            }else if(image.length > 0){       
               $("#requestdescriptionModal").modal('hide');
               sendRequest();
            }else{
              alertMessage("error","Please Enter Description", "danger");
            }
            
         });
         
        
         $(document).on('click', '#schedule_service', function(){ 
            $('input[name=date]').val('');
            $('input[name=time]').val('');
            provider_id = $(this).data('id');
            $('#provider').val(provider_id);
            var today = new Date().toISOString().split('T')[0];
            document.getElementsByName("date")[0].setAttribute('min', today);
            $("#myModal").modal('show'); 
         });
        
         //Save the record details
         function sendRequest(data, type) {
            showLoader();
            //var data = {};
            var form = $('#devis')[0];
            var data = new FormData(form);
            var provider_id = $('#provider').val();
            var request_type = $('#request_type').val();
            var serviceid = "{{$id}}";

            data.append( decodeURIComponent('service_id'), decodeURIComponent("{{$id}}") );
            data.append( decodeURIComponent('s_latitude'), decodeURIComponent($('#origin_latitude').val()) );
            data.append( decodeURIComponent('s_longitude'), decodeURIComponent($('#origin_longitude').val()) );
            data.append( decodeURIComponent('s_address'), decodeURIComponent($('input[name=s_address]').val()) );
            data.append( decodeURIComponent('promocode_id'), decodeURIComponent($('#promocode').val()) );
            data.append( decodeURIComponent('payment_mode'), decodeURIComponent($('select[name=payment]').val()) );
            data.append( decodeURIComponent('card_id'), decodeURIComponent($('select[name=card_id]:selected').val()) );
            data.append( decodeURIComponent('allow_description'), decodeURIComponent($('#allow_description').val()) );
            if($('#use_wallet').is(":checked")){
              data.append( decodeURIComponent('use_wallet'), decodeURIComponent($('#use_wallet').val()) );
            }
            data.append( decodeURIComponent('quantity'), decodeURIComponent($('#quantity').val()) );
           /* data["service_id"] = "{{$id}}";
            data["s_latitude"] = $('#origin_latitude').val();
            data["s_longitude"] = $('#origin_longitude').val(); 
            data["s_address"] = $('input[name=s_address]').val();
            data["promocode_id"] = $('#promocode').val();
            data["payment_mode"] = $('select[name=payment]').val();
            data["allow_description"] = $('#allow_description').val();*/
            //data["allow_image"] = file;
           

             if(request_type == "schedule-later") {
                //data["schedule_date"] = $('input[name=date]').val();
                //data["schedule_time"] = $('input[name=time]').val();
                data.append( decodeURIComponent('schedule_date'), decodeURIComponent($('input[name=date]').val()) );
            data.append( decodeURIComponent('schedule_time'), decodeURIComponent($('input[name=time]').val()) );
             }

            $.ajax({
               url: getBaseUrl() + "/user/service/send/request?id="+provider_id,
               type: "post",
               data: data,
               headers: {
                     Authorization: "Bearer " + getToken("user")
               },
               cache: false,
               processData: false,
                contentType: false,
               beforeSend: function() {
                 // showLoader();
               },
               success: (data, textStatus, jqXHR) => {
                
                  hideLoader();
                  
                  //window.location.replace("/user/service/"+serviceid);
                  if(request_type == "schedule-later") {
                        $("#service-status").removeClass("d-none");
                        $(".ride-section").addClass("d-none");
                        // initMap();
                        alertMessage("Success", "New Schedule created", "success");
                        setTimeout(function(){ 
                           location.assign(window.location.href.split('?')[0]); 
                        }, 3000);

                  } else {
                     $("#service-status").removeClass("d-none");
                     $(".ride-section").addClass("d-none");
                  }
                  $("#request_service").closest('form')[0].reset();
                  location.assign(window.location.href.split('?')[0] + "?id="+data.responseData.request);
               },
               error: (jqXHR, textStatus, errorThrown) => {
                  alertMessage("Error", jqXHR.responseJSON.message, "danger")
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
                                                  `+ (starvalue?starvalue:'') + `
                                                  </span>
                                                  <input class="rating" value="1" disabled="disabled" type="hidden">
                                                 
                                               </div>
                                            </div>
                                         </div>
                                         <div class="dis-row">
                                               <span>` +(item.user_comment?item.user_comment:'No reviews yet') +`</span>
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
                     location.assign(window.location.href.split('?')[0]);
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
