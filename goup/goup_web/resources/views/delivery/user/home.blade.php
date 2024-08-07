@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
<link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/owl-carousel/css/owl.carousel.min.css')}}"/>
@stop
@section('content')
<!-- Schedule Ride Modal -->
<div class="modal" id="myModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Schedule Ride Header -->
         <div class="modal-header">
            <h4 class="modal-title">@lang('delivery.user.schedule_ride')</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Schedule Ride body -->
         <div class="modal-body">
            <input class="form-control " type="text" placeholder="MM/DD/YYYY"  name="date" onkeypress="return false">
            <input class="form-control time-picker" type="text" name="time" placeholder="HH:MM" value="" onkeypress="return false">
         </div>
         <!-- Schedule Ride footer -->
         <div class="modal-footer">
            <a id="schedule-later" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#myModal">@lang('delivery.user.schedule_later')</a>
         </div>
      </div>
   </div>
</div>
<!-- Schedule Ride Modal -->
<section class="taxi-banner z-1 content-box" id="booking-form">
   <div class="">
      <div class="booking-section">
         <div class="dis-center col-md-12 col-sm-12 p-0 dis-center w-100">
            <ul class="nav nav-tabs " role="tablist">
               <li class="nav-item">
                  <a class="nav-link active" data-toggle="tab" href="#daily-ride" role="tab" data-toggle="tab">Delivery Services</a>
               </li>
            </ul>
         </div>
         <div class="clearfix tab-content">
            <div id="toaster" class="toaster"></div>
            <div role="tabpanel" class="tab-pane active col-sm-12 col-md-12 col-lg-12 p-0" id="daily-ride">
               <div class="ride-section">
                  <form class="trip-frm2 w-100">
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12 p-0 dis-reverse">
                           <div class="row w-100">
                              <div class="col-md-6 pl-0">
                                 <div id="ride-book" class="col-sm-12 col-md-12 p-0 form-section">
                                    <div class="deliveryContentBox multipleDelivery">
                                       <div class="col-md-11 col-sm-11 col-lg-11 p-0">
                           
                                          <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                                             <input id="origin-input" name="s_address" class="form-control" type="text" placeholder=" Pickup" autocomplete="off">
                                             <input type="hidden" name="s_latitude" id="origin_latitude" />
                                             <input type="hidden" name="s_longitude" id="origin_longitude" />
                                          </div>
                                          <div class="destination_container"></div>
                                          <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                                             <br><a class="add_delivery"><span class="fa fa-plus fa-2x add_icon" ></span> Add Delivery</a>
                                          </div>

                                          
                                          <input type="hidden" name="current_longitude" id="long" />
                                          <input type="hidden" name="current_latitude" id="lat" />

                                       <br>

                                          <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                                             <div class="selectField">
                                                <select class="custom-select m-0" name="delivery_type_id" id="delivery_type_id">
                                                </select>
                                             </div>
                                          </div>
                                          <div id="service_list" class="owl-carousel service-slider"></div>


                                       </div>
                                       <br>
                                       <div class="col-md-11 col-sm-11 col-lg-11 p-0 mt-0 card-feild">
                                          
                                          <div class="field-box">
                                             <div class="selectField">
                                                <select class="custom-select m-0" name="payment" id="select_payment">
                                                   <option value="" selected="">Select Payment</option>
                                                   @if(Helper::checkPayment('cash'))
                                                   <option value="CASH">CASH</option>
                                                   @endif
                                                   @if(Helper::checkPayment('card'))
                                                   <option value="CARD">CARD</option>
                                                   @endif
                                                   @if(Helper::checkPayment('PayPal'))
                                                   <option value="PAYPAL">PAYPAL</option>
                                                   @endif
                                                   @if(Helper::checkPayment('NOWPAYMENT'))
                                                   <option value="NOWPAYMENT">NOWPAYMENT</option>
                                                   @endif
                                                   @if(Helper::checkPayment('REVOLUT'))
                                                   <option value="REVOLUT">REVOLUT</option>
                                                   @endif
                                                </select>
                                             </div>
                                          </div>
                                          <br>
                                          <div class="field-box">
                                             <div class="selectField">
                                                <select class="custom-select m-0" name="payment_by" id="select_payment">
                                                   <!-- <option value="SENDER">Sender</option>
                                                   <option value="RECEIVER">Receiver</option> -->
                                                </select>
                                             </div>
                                          </div>
                                          
                                          <div class="field-box card" style="display:none">
                                             <div class="selectField">
                                                <select class="form-control" name="card_id">
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                     <div id="directions-panel"></div>

                                    <!-- courierContentBox -->
                                    <div class="col-md-12 col-sm-12 col-lg-12 p-0 mt-5 btn-section">
                                       <a id="ride-now" class="btn btn-primary ">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                    </div>
                                 </div>
                                 <div  id="confirm-ride" class="col-sm-12 col-md-12 p-0 form-section d-none">
                                    @if(Helper::isDestination())
                                    <h4>@lang('delivery.user.trip_estimation')</h4>
                                    @endif
                                    <div class="col-md-12 col-lg-12 col-sm-12 ">
                  <form id="ride_creation">
                  <div id="estimation"></div>
                  <ul class="estimation invoice"></ul>
                  <br>
                  <div class="row">
                  <div id="my_wallet" class="col-md-6 col-sm-12 col-xl-4 dis-end mt-2 d-sm-none d-md-none d-xl-block online">
                  <h5 class="p-0 go-online">@lang('delivery.user.use_wallet')(<span class="currency"></span>)</h5>
                  <label class="toggleSwitch nolabel" onclick="">
                  <input name="use_wallet" value="1"
                     id="use_wallet" type="checkbox"  autocomplete="off">
                  <span>
                  <span class="show1">@lang('delivery.user.no')</span>
                  <span class="show2">@lang('delivery.user.yes')</span>
                  </span>
                  <a></a>
                  </label>
                  </div>
                  

                  </div>


                  <!-- <div class="row">
                  <div  class="col-md-6 col-sm-12 col-xl-6 dis-end mt-2 d-sm-none d-md-none d-xl-block online">
                  <h5 class="p-0 go-online">@lang('delivery.user.book_for_someone')</h5>
                  <label class="toggleSwitch nolabel" onclick="">
                  <input name="someone" value="1"id="someone" type="checkbox"  autocomplete="off">
                  <span>
                  <span class="show1">@lang('delivery.user.no')</span>
                  <span class="show2">@lang('delivery.user.yes')</span>
                  </span>
                  <a></a>
                  </label>
                  </div>
                
                  </div> -->
                  <br>
                  <br>
                  <a id="schedule-ride" data-toggle="modal" data-target="#myModal"  class="btn btn-primary  ">@lang('delivery.user.schedule-ride')<i class="fa fa-clock-o" aria-hidden="true"></i></a>
                  <a id="book-now" class="btn btn-secondary">@lang('delivery.user.ride_now') <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                  </form>
                  </div>
                  </div>
                  </div>
                  <div class="col-md-6 pr-0">
                  <div id="map" class="col-sm-12 col-md-12 map-section" style="width:100%; height: 500px; box-shadow: 2px 2px 10px #ccc;"></div>
                  </div>
                  </div>
                  </div>
                  </div>
                  </form>
               </div>
               <div id="root"></div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- Coupon Modal -->
<div class="modal" id="couponModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Coupon Header -->
         <div class="modal-header">
            <h4 class="modal-title">@lang('delivery.user.coupon_code')</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Coupon body -->
         <div class="modal-body">
            <div class="dis-row col-lg-12 col-md-12 col-sm-12 p-0 ">
               <div class="col-sm-8">
                  <input class="form-control" type="text" name="coupon_value" placeholder="Enter Coupon Code" />
                  <input  type="hidden" name="promocode" id="promocode"  />
                  <input type="hidden" name="max_amount" />
                  <input type="hidden" name="discount_percent" />
               </div>
               <div class="col-sm-4">
                  <a class="btn btn-primary btn-block apply_coupon">@lang('delivery.user.apply')</a>
               </div>
            </div>
            <ul class="height50vh coupon_list"></ul>
         </div>
      </div>
   </div>
</div>

@stop
@section('scripts')
@parent
<script>

    var current_latitude = 13.0574400;
    var current_longitude = 80.2482605;

    if( navigator.geolocation ) {
       navigator.geolocation.getCurrentPosition( success, fail );
    } else {
        console.log('Sorry, your browser does not support geolocation services');
    }

    function success(position)
    {
        document.getElementById('long').value = position.coords.longitude;
        document.getElementById('lat').value = position.coords.latitude

        if(position.coords.longitude != "" && position.coords.latitude != ""){
            current_longitude = position.coords.longitude;
            current_latitude = position.coords.latitude;
        }



      initMap();

    }

    function fail()
    {
        // Could not obtain location
        console.log('unable to get your location');
         initMap();
    }

</script>

<script type="text/javascript" src="{{ asset('assets/layout/js/delivery-map.js') }}"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>
<script type="text/javascript" src="{{ asset('assets/plugins/owl-carousel/js/owl.carousel.min.js')}}"></script>
<script crossorigin src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
<!-- <script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.production.min.js"></script>
   <script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.production.min.js"></script> -->
<script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.development.js"></script>
<script type="text/babel" src="{{ asset('assets/layout/js/delivery/waiting.js') }}"></script>
<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
   window.salt_key = '{{ Helper::getSaltKey() }}';

    @php

   $paymentConfig = json_decode( json_encode( Helper::getSettings()->payment ) , true);
   $cardObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'paystack'; }));
   //print_r($cardObject);exit;
   $paystack = 0;

   $public_key = "";

   if(count($cardObject) > 0) { 
      $paystack = $cardObject[0]['status'];

      $PublishableObject = array_values(array_filter( $cardObject[0]['credentials'], function ($e) { return $e['name'] == 'public_key'; }));


      if(count($PublishableObject) > 0) {
            $public_key = $PublishableObject[0]['value'];
      }
   }
  

@endphp
 var userSetting = getUserDetails();

 window.public_key = '{{$public_key}}';

 window.email = userSetting.email;

 window.mobile = userSetting.mobile;

   var currency = getUserDetails().currency_symbol;
   var wallet_balance = getUserDetails().wallet_balance; 
   $('.someone_form').addClass('d-none');
   $('.currency').html(currency);
   if(wallet_balance<=0){
      $('#my_wallet').hide();
   }
   $('#someone').on('change',function(){
      if($(this).is(':checked')){
         $('.someone_form').removeClass('d-none');
         $('#someone_email').prop("required", true);
         $('#someone_mobile').prop("required", true);
      }else{
         $('.someone_form').addClass('d-none');
         $('#someone_email').prop("required", false);
         $('#someone_mobile').prop("required", false);
      }
   });

   var destination_content = `<div class="field-box col-md-12 col-sm-12 col-lg-12 p-0" style="background: #fff; box-shadow: 0px 5px 10px #ccc; border: 1px solid #1FBCC4; padding: 5px !important; border-radius: 15px; margin: 10px 0;">
                                             <div class="view_container">
                                                <a class="view_content" ><span class="fa fa-eye fa-2x view_icon" ></span></a>
                                                <a class="delete_content"><span class="fa fa-minus fa-2x remove_icon" ></span></a>
                                             </div>
                                             <input id="destination-input" name="d_address[]" class="form-control" type="text" placeholder="Destination" autocomplete="off" required>
                                             <input type="hidden" name="d_latitude[]" />
                                             <input type="hidden" name="d_longitude[]" />
                                             <input type="hidden" name="distance[]" />
                                             <div class="productListContent" style="display: none;">
                                                   <div class="form-group">
                                                      <input required="required" type="text" name="receiver_name" class="form-control" placeholder="Receiver Name" id="receivarName" autocomplete="off" style="float:left; width: 49%;">
                                                      <input type="text" class="form-control numbers" name="receiver_mobile" placeholder="Mobile Number" id="receivarMobile" autocomplete="off" style="float:left; width: 49%; margin-left:2%;">
                                                   </div>
                                                   <div class="form-group">
                                                      <select class="form-control" name="package_type_id" id="package_type_id">`;

                                                      $.ajax({
                                                         type:"GET",
                                                         url: getBaseUrl() + "/user/delivery/package/types",
                                                         headers: {
                                                               Authorization: "Bearer " + getToken("user")
                                                         },
                                                         async: false,
                                                         success:function(data){
                                                            var html = ``;
                                                            var result = data.responseData;
                                                            //console.log(result);
                                                            $.each(result,function(key,item){
                                                                destination_content += `<option value="` + item.id + `"> `+item.package_name+`</option>`;
                                                            });

                                                         }
                                                      });

                                                   destination_content += `</select>
                                                   </div>
                                                   <div class="form-group">
                                                      <input type="number" class="form-control" name="receiver_instruction" placeholder="Declare Value" id="receivarInstruction" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <input type="file" class="form-control" name="delivery_image[]" />
                                                      <textarea style="width:0; height:0; padding: 0; margin: 0; border: 0px dashed #eaebeb; min-height: 0;" class="form-control" name="image[]"> </textarea>
                                                   </div>
                                                   <div class="form-group">
                                                      <div class="row">
                                                         <div class="col-md-4">
                                                            <input type="text" class="form-control numbers" name="length" placeholder="length (cm)" id="length" autocomplete="off" />
                                                         </div>
                                                         <div class="col-md-4">
                                                             <input type="text" class="form-control numbers" name="breadth" placeholder="breadth (cm)" id="breadth" autocomplete="off" />
                                                         </div>
                                                         <div class="col-md-4">
                                                             <input type="text" class="form-control numbers" name="height" placeholder="height (cm)" id="height" autocomplete="off" />
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                     
                                                   </div>
                                                   <div class="form-group">
                                                      
                                                   </div>
                                                   <div class="form-group">
                                                      <input type="text" class="form-control numbers" name="weight" placeholder="weight (kg)" id="weight" autocomplete="off">
                                                   </div>
                                                   <div class="form-group">
                                                      <label for="is_fragile"><input id="is_fragile" name="is_fragile" type="checkbox" autocomplete="off"> Fragile</label>
                                                   </div>
                                                </div>
                                          </div>`;

   $(document).ready(function(){
      var autocomplete_arr = [];
      $('.add_delivery').on('click', function() {
         $('.productListContent').hide();
         var content = $(destination_content);
         content.find('.productListContent').show();
         $('.destination_container').append(content);
         var destinationAutocompleteElem = $('.destination_container .field-box').last().find('input[name="d_address[]"]')[0];
         var inputs = $('.destination_container .field-box').find('input[name="d_address[]"]');
         setupAutocomplete(destinationAutocompleteElem, inputs);
         //console.log(  destinationAutocompleteElem  );
         //console.log(  $('.destination_container .field-box').last().find('input[name="d_address[]"]')  );
         //this.setupPlaceChangedListener(destinationAutocomplete, 'DEST');
      });

      $('body').on('click', '.delete_content' ,function() {
         $(this).closest('.field-box').remove();
      });

      $('body').on('click', '.view_content' ,function() {
         $(this).closest('.field-box').find('.productListContent').toggle();
      });


         $.ajax({
            type:"GET",
            url: getBaseUrl() + "/user/delivery/types/{{$id}}",
            headers: {
                  Authorization: "Bearer " + getToken("user")
            },
            success:function(data){
               var html = ``;
               var result = data.responseData;
               //console.log(result);
               $.each(result,function(key,item){
                  $("select[name=delivery_type_id]").append('<option value="' + item.id + '"> '+item.delivery_name+'</option>');
               });

               setTimeout(function(){ getDeliveryTypes($("select[name=delivery_type_id]").val()); }, 1000);
            }
         });

      });

   $(document).ready(function(){
      $("select[name=delivery_mode]").on('change', function(){
         var delivery_mode = $(this).val();

         if(delivery_mode == "SINGLE"){

            $('.add').css("display", "none");
         }else{
            $('.add').css("display", "block");
         }
      });


      $("select[name=delivery_type_id]").on('change', function(){
         var delivery_type_id = $(this).val();

         getDeliveryTypes(delivery_type_id);

      });

   });

    $('body').off('click', '.addProductInf').on('click', '.addProductInf', function(){

               var clone = $('.BoxInf').clone();


               clone.find('select[name=package_type_id], input[name=receiver_name], input[name=receiver_mobile], input[name=receiver_instruction], input[name=weight]').val("");
               clone.find('input[name=is_fragile]').val(0);

               $('.BoxInf').after(clone);
     });

      $(document).ready(function(){
   
         $('input[name=date]').datepicker({
               rtl: false,
               orientation: "left",
               todayHighlight: true,
               autoclose: true,
               startDate:new Date()
           });
   
         var carousel = $('.service-slider');
   
         $('#home').addClass('menu-active');
   
         $('body').on('change', 'select[name=payment]', function() {
            var payment = $(this).val();
            if(payment != "CASH"){
               $("select[name=payment_by]").empty().append('<option value=""></option>');
               $("select[name=payment_by]").append('<option value="SENDER" selected="">SENDER</option>');

            }else{
               $("select[name=payment_by]").empty().append('<option value=""></option>');
               $("select[name=payment_by]").append('<option value="SENDER" selected="">SENDER</option><option value="RECEIVER">RECEIVER</option>');
            }
            usercard(payment);
         });
   
         var payment =$('#select_payment').val();
         usercard(payment);
        function usercard(payment){
           
         if(payment == "CARD") {
               $('.card').show();
            } else {
               $('.card').hide();
            }
   
         if(payment == "CASH") {
            $('.cashPayment').show();
         } else {
            $('.cashPayment').hide();
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
   
   
         $('body').on('click', '.coupon-box', function() {
            $('input[name=coupon_value]').val($(this).find('.coupon-text').text());
            $('input[name=max_amount]').val($(this).find('.coupon-text').data('maxamount'));
            $('input[name=discount_percent]').val($(this).find('.coupon-text').data('percent'));
            
            $('input[name=coupon_value]').prop('readonly', true);
            $('input[name=coupon_value]').data('promocode_id',$(this).find('.coupon-text').data('promocode_id'));
         });
   
         $('body').on('click', '.promocode', function() {
            $('input[name=coupon_value]').val('');
            $('input[name=max_amount]').val('0');
            $('input[name=discount_percent]').val('0');
            $('input[name=coupon_value]').prop('readonly', false);
            $('#couponModal').modal('show'); 
         });
         
   
         $('.apply_coupon').on('click', function() {
            var coupon_value = $('input[name=coupon_value]').val(); 
            $('input[name=promocode]').val($('input[name=coupon_value]').data('promocode_id'));
            $('.promocode_container').remove();
            if(coupon_value != "") {
               $('.promocode').after(`<li class="promocode_container">
                  <span class="fare">Promocode Discount &nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" class="removePromo" title="Remove Promocode">X</a></span>
                  <span class="txt-green pricing "><span class="coupon_value">0.00</span><span>`+currency+`</span></span>
               </li>`);
            }
            $('input[name=coupon_value]').prop('readonly', true);
   
   
            var estimate = $('.estimate_amount').text();
            var percentage = $('input[name=discount_percent]').val();
            var max_amount = $('input[name=max_amount]').val();
   
            var percent_total = estimate * percentage/100;
   
            if(percent_total > max_amount) {
             promo = parseFloat(max_amount);
            }else{
             promo = parseFloat(percent_total);
            }
            $(".coupon_value").html(promo.toFixed(2));
            $(".total_amount").html((estimate-promo).toFixed(2));
   
            $('#couponModal').modal('hide'); 
         });
         $(document).on('click','.removePromo', function() {
   
            var promocode_amount = $(".coupon_value").text();
            $(".coupon_value").html('0.00');
            var total_amount = $(".total_amount").text();
            var new_total = parseFloat(total_amount)+parseFloat(promocode_amount);
            $(".total_amount").html(new_total.toFixed(2));
            $('input[name=promocode]').val('');
             $('.promocode_container').remove();
   
         });
   
         $("#ride-now").click(function() {
            var source_address = $('input[name=s_address]');
            /*var destination_address = $('.destination_container .field-box').find('input[name="d_address[]"]');
            var receivers_name = $('.destination_container .field-box').find('input[name="receiver_name"]');
            var receivers_mobile = $('.destination_container .field-box').find('input[name="receiver_mobile"]');*/
            var service_type = $('input[name=service_type]:checked').val();
            var delivery_mode = $('select[name=delivery_mode]').val();
            var delivery_type_id = $('select[name=delivery_type_id]').val();
            var use_wallet = $('input[name=use_wallet]:checked').val();
            var source_latitude = $('input[name=s_latitude]').val();
            var source_longitude = $('input[name=s_longitude]').val();
   
          /*  @if(Helper::isDestination() == "1")
            var destination_address = $("input[name=d_address]").val();
            var destination_latitude = $("input[name=d_latitude]").val();
            var destination_longitude = $("input[name=d_longitude]").val();
            @endif*/
   
            var payment = $('select[name=payment]').val();
            var payment_by = $('select[name=payment_by]').val();
            var ride_type = $('input[name=ride_type]:checked').val();
            var ride_type = $('input[name=ride_type]:checked').val();

            var destination_address = $("input[name^='d_address']").map(function() { return $(this).val(); }).get();
            var receiver_name = $("input[name=receiver_name]").map(function() { return $(this).val(); }).get();
            var receiver_mobile = $("input[name=receiver_mobile]").map(function() { return $(this).val(); }).get();
            var d_latitude = $("input[name^='d_latitude']").map(function() { return $(this).val(); }).get();
            var d_longitude = $("input[name^='d_longitude']").map(function() { return $(this).val(); }).get();
            var package_type_id = $("input[name=package_type_id]").map(function() { return $(this).val(); }).get();
            var receiver_instruction = $("input[name=receiver_instruction]").map(function() { return $(this).val(); }).get();
            var weight = $("input[name=weight]").map(function() { return $(this).val(); }).get();
            var height = $("input[name=height]").map(function() { return $(this).val(); }).get();
            var breadth = $("input[name=breadth]").map(function() { return $(this).val(); }).get();
            var length = $("input[name=length]").map(function() { return $(this).val(); }).get();

            
            var is_fragile = $("input[name=is_fragile]").map(function() { return $(this).is(':checked') ? 1 : 0 ; }).get();

            $(".error").remove();
            
            
            if(delivery_type_id == ""){
                $('select[name=delivery_type_id]').after(`<span class="error" style="color: red">Delivery type is required</span>`);
            }

            if(receiver_instruction > 5000){
                $('select[name=receiver_instruction]').after(`<span class="error" style="color: red">Instruction is not exceed more than 5000</span>`);
            }

            if(source_address.val() == "") {
               source_address.closest('.field-box').after(`<span class="error" style="color: red">Source address is required</span>`);
            } 
            else if(destination_address == "") {
               $('.destination_container .field-box').find('input[name="d_address[]"]').after(`<span class="error" style="color: red">Destination address is required</span>`);
            }else if(receiver_name == ""){
               $('.destination_container .field-box').find('input[name="receiver_name"]').after(`<span class="error" style="color: red">Receiver Name is required</span>`);
            }else if(receiver_mobile == ""){
               $('.destination_container .field-box').find('input[name="receiver_mobile"]').after(`<span class="error" style="color: red">Receiver Mobile is required</span>`);
            }else if(weight == ""){
               $('.destination_container .field-box').find('input[name="weight"]').after(`<span class="error" style="color: red">Weight is required</span>`);
            }
            else if(typeof service_type == 'undefined') {
               $('#service_list').after(`<span class="error" style="color: red">Service type is required</span>`);
            } else if(payment == 'CARD' && $('select[name=card_id]').val() == "") {
               $('select[name=card_id]').after(`<span class="error" style="color: red">Card is required</span>`);
            } else {
               showLoader();

               $.ajax({
               url: getBaseUrl() + "/user/delivery/estimate",
               type: "post",
               data: {
                  city_id: getUserDetails().city_id,
                  s_latitude: source_latitude,
                  s_longitude: source_longitude,
                  service_type: service_type,
                  d_latitude: d_latitude,
                  delivery_mode: delivery_mode,
                  d_longitude: d_longitude,
                  delivery_type_id:delivery_type_id,
                  payment_mode:payment,
                  use_wallet:use_wallet,
                  payment_by:payment_by,
                  receiver_name:receiver_name,
                  receiver_mobile:receiver_mobile,
                  package_type_id:package_type_id,
                  receiver_instruction:receiver_instruction,
                  weight:weight,
                  length:length,
                  breadth:breadth,
                  height:height,

                  is_fragile:is_fragile

               },
               headers: {
                     Authorization: "Bearer " + getToken("user")
               },
               success: (data, textStatus, jqXHR) => {
                  if(payment != "CASH" || payment_by != 'SENDER'){
                     $("#my_wallet").removeClass("d-xl-block");
                     $('#my_wallet').hide();
                  }
               console.log(data);
                  var estimationHtml = ``;
   
                  if((Object.keys(data.responseData)).length > 0) {
   
                     var result = data.responseData;
                     currency = result.currency;
                     console.log(result.service.vehicle_name);
   
                     estimationHtml += `<ul class="invoice">`;
   
                     if(result.service.vehicle_name != "") {
                        estimationHtml += `<li>
                                             <span class="fare">Vehicle Type</span>
                                             <span class="pricing">`+result.service.vehicle_name+`</span>
                                          </li>`;
                     }
   
                     if(result.fare.distance != "") {
                        estimationHtml += `<li>
                                             <span class="fare">Estimated Distance</span>
                                             <span class="pricing">`+result.fare.distance+` `+result.fare.unit+`</span>
                                          </li>`;
                     }
   
                    /* if(result.fare.time != "") {
                        estimationHtml += `<li>
                                             <span class="fare">ETA</span>
                                             <span class="pricing">`+result.fare.time+`</span>
                                          </li>`;
                     }
   
                     if(result.fare.peak != "" && result.fare.peak >0) {
                        estimationHtml += `<li>
                                             <span class="fare">Peak Charge</span>
                                             <span class="pricing">`+result.fare.peak+`</span>
                                          </li>`;
                     }*/
   
   
                     if(result.fare.estimated_fare != "") {
                        estimationHtml += `<li>
                                             <span class="fare">Estimated Fare</span>
                                             <span class="pricing "><span> `+result.currency+`</span><span class="estimate_amount">`+result.fare.estimated_fare+`</span></span>
                                          </li>`;
                     }
   
                    /* if(receiver_name != "") {
                        estimationHtml += `<li>
                                             <span class="fare">Receiver Name</span>
                                             <span class="pricing "><span class="receiver_name">`+receiver_name+`</span></span>
                                          </li>`;
                     }
   
                     if(receiver_mobile != "") {
                        estimationHtml += `<li>
                                             <span class="fare">Receiver Mobile</span>
                                             <span class="pricing "><span class="receiver_mobile">`+receiver_mobile+`</span></span>
                                          </li>`;
                     }*/
   
                     /*if(destination_address != "") {
                        estimationHtml += `<li>
                                             <span class="fare">Destination Address</span>
                                             <span class="pricing "><span class="destination_address">`+destination_address+`</span></span>
                                          </li>`;
                     }*/
   
                     if(result.fare.weight != "") {
                        estimationHtml += `<li>
                                             <span class="fare">Weight(KGs)</span>
                                             <span class="pricing "><span class="weight">`+result.fare.weight+`</span></span>
                                          </li>`;
                     }
   
                     /*if(receiver_instruction != "") {
                        estimationHtml += `<li>
                                             <span class="fare">Receiver Instruction</span>
                                             <span class="pricing "><span class="receiver_instruction">`+receiver_instruction+`</span></span>
                                          </li>`;
                     }*/
   
                     estimationHtml += `<li class="promocode dis-ver-center">
                                       <img src="{{ asset('assets/layout/images/delivery/svg/coupon.svg') }}">
                                       <h5 class="c-pointer">Apply Promocode</h5>
                                    </li>`;
   
                     if(result.fare.estimated_fare != "") {
                        estimationHtml += `<li>
                                       <hr>
                                       <span class="fare">Total</span>
                                       <span class="txt-yellow pull-right"><span> `+result.currency+`</span><span class="total_amount">`+result.fare.estimated_fare+`</span></span>
                                       <hr>
                                    </li>`;
                     }
   
   
                     estimationHtml += `</ul>`;
   
                     var promocodes = result.promocodes;
                     var coupons_html = ``;
   
                     if(promocodes.length > 0) {
                        for(var i in promocodes) {
                           coupons_html += `<li class="coupon-box">
                              <img src=`+promocodes[i].picture+` style="height: 60px;margin: 38px;opacity: 1.1;">
                              <span data-promocode_id="`+promocodes[i].id+`"  data-percent="`+promocodes[i].percentage+`" data-maxamount="`+promocodes[i].max_amount+`" class="txt-yellow coupon-text">`+promocodes[i].promo_code+`</span>
                              <p class="mt-2">`+promocodes[i].promo_description+`</p>
                              <small>Valid Till: `+promocodes[i].expiration+`</small>
                           </li>`;
                        }
                     }
   
                     
   
                     $('.coupon_list').html(coupons_html);
   
                     hideLoader();
                    
                  }
   
                  $('#estimation').html(estimationHtml);
   
                  $("#ride-book").addClass("d-none");
                  $("#confirm-ride").removeClass("d-none");
   
               },
               error: (jqXHR, textStatus, errorThrown) => {
                  alertMessage("Error", jqXHR.responseJSON.message, "danger")
                  hideLoader();
               }
            });
          
   
   
            }
         });

         var delivery_image = [];

         $('body').on('change', 'input[name="delivery_image[]"]', function(e) {
            var that = $(this);
            var files = e.target.files;
            if (files && files.length > 0) {

               var file = files[0];
               var reader = new FileReader();
               var baseString;
               reader.onloadend = function () {
                  baseString = reader.result;
                  that.closest('.form-group').find('textarea[name="image[]"]').val(baseString);
                  console.log(baseString); 
               };
               reader.readAsDataURL(file);
               //data.append('picture[]', files[0]);
            }
         });
   
         $("#book-now, #schedule-later").click(function() {
            var userSettings = getUserDetails();

            if(userSettings.id == 0) {
               window.location.replace("{{ url('/user/login') }}");
            }
            var that = $(this);
   
            var data =  new FormData();
            
            var delivery_mode = $('select[name=delivery_mode]').val();
            var service_type = $('input[name=service_type]:checked').val();
            var s_latitude = $('input[name=s_latitude]').val();
            var s_longitude = $('input[name=s_longitude]').val();
            var s_address = $('input[name=s_address').val();
            var promocode_id = $('#promocode').val();
            var payment_mode = $('select[name=payment]').val();
            var payment_by = $('select[name=payment_by]').val();
            var card_id = $('select[name=card_id]:selected').val();
            var delivery_type_id = $('select[name=delivery_type_id]').val();
            var time = $('input[name=time]').val();
            var use_wallet = $('input[name=use_wallet]:checked').val();

            var destination_address = $("input[name^='d_address']").map(function() { return $(this).val(); }).get();
            var receiver_name = $("input[name=receiver_name]").map(function() { return $(this).val(); }).get();
            var receiver_mobile = $("input[name=receiver_mobile]").map(function() { return $(this).val(); }).get();
            var d_latitude = $("input[name^='d_latitude']").map(function() { return $(this).val(); }).get();
            var d_longitude = $("input[name^='d_longitude']").map(function() { return $(this).val(); }).get();
            var distance = $("input[name='distance']").map(function() { return $(this).val(); }).get();
            var package_type_id = $("input[name=package_type_id]").map(function() { return $(this).val(); }).get();
            var receiver_instruction = $("input[name=receiver_instruction]").map(function() { return $(this).val(); }).get();
            var weight = $("input[name=weight]").map(function() { return $(this).val(); }).get();
            var length = $("input[name=length]").map(function() { return $(this).val(); }).get();
            var breadth = $("input[name=breadth]").map(function() { return $(this).val(); }).get();
            var height = $("input[name=height]").map(function() { return $(this).val(); }).get();
            var is_fragile = $("input[name=is_fragile]").map(function() { return $(this).is(':checked') ? 1 : 0 ; }).get();
            var picture = $("input[name=image]").map(function() { return $(this).val(); }).get();

            if(receiver_instruction > 5000){
                $('select[name=receiver_instruction]').after(`<span class="error" style="color: red">Instruction is not exceed more than 5000</span>`);
            }
            var data = {};
            var delivery_picture = [];

            $('textarea[name="image[]"]').each(function() {

               // var block = ($(this).val()).split(";");
               // var contentType = block[0].split(":")[1];
               // var realData = "";
               // if( (block[1] != "") ||  (block[1] != undefined)){
               //    var realData = block[1].split(",")[1];
               //  }

               // var blob = b64toBlob(realData, contentType);

               // data.append('picture[]', blob);

              // data.append('picture[]', $(this).val());
             // data['picture[]'] = $(this).val();
             code = $(this).val();
             delivery_picture.push(code);
            });

            data['picture'] = delivery_picture;
               data['s_latitude'] = s_latitude;
               data['s_longitude'] = s_longitude;
               data['s_address'] = s_address;
               data['promocode_id'] = promocode_id;
               data['service_type'] = service_type;
               data['d_latitude'] = d_latitude;
               data['delivery_mode'] = delivery_mode;
               data['payment_mode'] = payment_mode;
               data['payment_by'] = payment_by;
               data['card_id'] = card_id;
               data['time'] = time;
               data['d_longitude'] = d_longitude;
               data['d_address'] = destination_address;
               data['distance'] = distance;
               data['delivery_type_id'] = delivery_type_id;
               data['receiver_name'] = receiver_name;
               data['receiver_mobile'] = receiver_mobile;
               data['package_type_id'] = package_type_id;
               data['receiver_instruction'] = receiver_instruction;
               data['weight'] = weight;
               data['height'] = height;
               data['length'] = length;
               data['breadth'] = breadth;
               data['device_type'] = 'web';
               data['use_wallet'] = use_wallet;
               data['is_fragile'] = is_fragile;
            console.log(data);

            if(that.attr('id') == "schedule-later") {
               
               if(!$('input[name=date]').val() || !$('input[name=time]').val()){
                  alertMessage("Error","Please Choose both date and time", "danger");
                  return false;
               }
               // data.append('schedule_date', $('input[name=date]').val());
               // data.append('schedule_time', $('input[name=time]').val());
               data['schedule_date'] = $('input[name=date]').val();
               data['schedule_time'] = $('input[name=time]').val();

               
                  console.log(data);


            } 
            showLoader();
               $.ajax({
                  url: getBaseUrl() + "/user/delivery/send/request",
                  type: "post",
                 
                  data:data,
                  headers: {
                        Authorization: "Bearer " + getToken("user")
                  },
                  success: (response, textStatus, jqXHR) => {
                     var data = parseData(response);
                     hideLoader();
                     var type = $(this).attr('id');
                     if(type == "schedule-later") {
                        $("#ride-book").removeClass("d-none");
                        $("#confirm-ride").addClass("d-none");
                        initMap();
                        alertMessage("Success", "New Schedule created", "success")
                     } else {
                        $(".ride-section").addClass("d-none");
                        $("#ride-book").removeClass("d-none");
                        $("#confirm-ride").addClass("d-none");
                        
                     }
                     $("#ride-book").closest('form')[0].reset();
                     location.assign(window.location.href.split('?')[0] + "?id="+data.responseData.request);

                     
                  },
                  error: (jqXHR, textStatus, errorThrown) => {
                     alertMessage("Error", jqXHR.responseJSON.message, "danger");
                     hideLoader();
                  }
               });                     
            
               
            //sendRequest(data, 'send');              
   
         });
   
        
   
      
      // Header-Section
      function openNav() {
         document.getElementById("mySidenav").style.width = "50%";
      }
   
      function closeNav() {
         document.getElementById("mySidenav").style.width = "0";
      }
   
      $('#origin-input').change(function(){
        
        
         setTimeout(function(){ 
            current_latitude=$('#origin_latitude').val();
            current_longitude=$('#origin_longitude').val();
            getDeliveryTypes($("select[name=delivery_type_id]").val()); 
            
            }, 1000);
   
      })

   
      
   });
   
   $(document).ready(function() {
   

     $('#updateDetailBtn').on('click', function() {

      var BoxContent = $(this).closest('.modal-body').find('.productListContent').clone();

      var value = $(this).closest('.modal-body').find('.productListContent').find('select[name="package_type_id"]').val();

      $('.modal-header .close').click();
      $('.BoxInf .BoxContent').slideDown();
      
      $('.recPackageField span').html($("input[name='optradio']:checked").val());

      //$('.recPackageField span').html($("select[name='package_type_id']").val());
     
       $('.BoxInf').append(`<div style="padding:10px;" class="BoxContent active"><div class="detailListTitle">
                     <h6>Receiver Details</h6>
                     <div class="detailListBtns"><span class="dlSave"><i class="fa fa-check-square-o"></i></span><span class="dlDelete"><i class="fa fa-trash"></i></span></div>
                  </div></div>`);

       $('.BoxInf .BoxContent:last').append(BoxContent);
       $('.BoxInf .BoxContent:last').append(BoxContent).find('select[name="package_type_id"]').val(value);

       $(this).closest('.modal-body').find('form').trigger('reset');

     });
   
     $('body').on("click", ".BoxContent .detailListTitle h6, .dlView" , function() {
         
         if ($(this).closest('.BoxContent').hasClass("active")) {
            $(this).closest('.BoxContent').removeClass('active');
            $(this).closest('.BoxContent').find('.detailListContent').slideUp();
         } else {
            $('.BoxContent').removeClass('active');
            $('.BoxContent').find('.detailListContent').slideUp();
            $(this).closest('.BoxContent').addClass('active');
            $(this).closest('.BoxContent').find('.detailListContent').slideDown();
         }
         
     });
   
     $('body').on("click", ".BoxContent .detailListBtns .dlDelete" , function(e) {
         if (confirm('Are you sure Delete?')) {
           $(this).closest('.BoxContent').remove();
         }
         
     });
   
   });

   function getDeliveryTypes(type) {
         $.ajax({
            url: getBaseUrl() + "/user/delivery/services?type="+type+"&latitude="+current_latitude+"&longitude="+current_longitude+"&city_id="+
               getUserDetails().city_id,
            type: "get",
            processData: false,
            contentType: false,
            headers: {
                  Authorization: "Bearer " + getToken("user")
            },
            success: (response, textStatus, jqXHR) => {
               var data = parseData(response);
               if(Object.keys(data.responseData).length != 0) {
                  var result = data.responseData;
                  var services = result.services;
                  console.log(services);
                  var promocodes = result.promocodes;
   
                  $.each(promocodes, function(i,val){
   
                        $('#promocode')
                        .append($("<option></option>")
                                    .attr("value",val.id)
                                    .attr("data-percent",val.percentage)
                                    .attr("data-max",val.max_amount)
                                    .text(val.promo_code)); 
                  });
   
                     var serviceList = ``;
   
                     //$('#ride-book').removeClass('d-none');
   
                     if(services.length > 0) {

   
                        for(var i in services) {
                           
                              serviceList += `<div class="item" style="width: 130px; float:left;">
                                       <div class="dis-column service-type">
                                          <input type="radio" name="service_type" data-id="`+services[i].capacity+`" value="`+services[i].id+`" id="service-`+services[i].id+`" tabindex="0">
                                          <label for="service-`+services[i].id+`" class="dis-column">
                                             <div class="left-icon p-0">
                                                <img src="`+services[i].vehicle_image+`" alt="`+services[i].vehicle_name+`">
                                                <h6 class="m-0">`+services[i].vehicle_name+`<br><span style="text-align: center; width:100%; float: left; color: #7a7a7a;">`+services[i].estimated_time+`</span></h6>
                                             </div>
                                          </label>
                                       </div>
                                    </div>`;
   
                        }
   
                        $('#service_list').html(serviceList);
   
                        carousel = $('.service-slider').owlCarousel({
                           items: 3,
                           loop:false,
                           margin:10,
                           navSpeed:500,
                           nav:true,
                           navText: ['<span class="fa fa-chevron-left fa-2x"></span>','<span class="fa fa-chevron-right fa-2x"></span>']
                        });
                        carousel.on('click', '.owl-item', function(event) {
                           $radio = $(this).find("input[name='service_type']").data('id');
                           if($radio>3){
                              $('.wheel_chair,.child_seat').addClass('d-none');
                           }else{
                              $('.wheel_chair,.child_seat').removeClass('d-none');
                           }
                               
                        });
                     } else {
   
                        if(typeof carousel != 'undefined') { 
                           carousel.trigger('destroy.owl.carousel'); 
                           carousel.find('.owl-stage-outer').children().unwrap();
                           carousel.removeClass("owl-center owl-loaded owl-text-select-on");
                        }
   
                        $('#service_list').html("");
   
                        //$('#ride-book').html(`<div style="float:left; text-align: center; width: 100%">No service available!</div>`);
                     }
                     
   
   
               }
   
            },
            error: (jqXHR, textStatus, errorThrown) => {}
         });
   
      }
   

</script>
@stop