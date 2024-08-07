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
            <h4 class="modal-title">@lang('transport.user.schedule_ride')</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Schedule Ride body -->
         <div class="modal-body">
            <input class="form-control " type="text" placeholder="MM/DD/YYYY"  name="date" onkeypress="return false">
            <input class="form-control time-picker" type="text" name="time" placeholder="HH:MM" value="" onkeypress="return false">
         </div>
         <!-- Schedule Ride footer -->
         <div class="modal-footer">
            <a id="schedule-later" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#myModal">@lang('transport.user.schedule_later')</a>
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
                  <a class="nav-link active" data-toggle="tab" href="#daily-ride" role="tab" data-toggle="tab">@lang('transport.user.daily_rides')</a>
               </li>
               <!-- <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#outstation" role="tab" data-toggle="tab">Outstation</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link " data-toggle="tab" href="#rental" role="tab" data-toggle="tab">Rentals</a>
               </li> -->
            </ul>
         </div>
         <div class="clearfix tab-content">
         <div id="toaster" class="toaster"></div>
            <div role="tabpanel" class="tab-pane active col-sm-12 col-md-12 col-lg-12 p-0" id="daily-ride">
            <div class="ride-section">
               <form class="trip-frm2 w-100">
                  <div class="col-md-12 col-sm-12 col-lg-12 p-0 dis-reverse">


                     <div class="col-sm-12 col-md-12 col-lg-7 map-section">
                        <div  id="map"  style="width:100%; height: 500px;  box-shadow: 2px 2px 10px #ccc;">
                        </div>
                     </div>

                     <div id="ride-book" class="col-sm-12 col-md-12 col-lg-5 p-0 form-section d-none">
                        
                        <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                           <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0 ride_types d-none">
                           </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                           <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                              
                           </div>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                           <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                              <input id="origin-input"
                                 name="s_address" class="form-control" type="text" placeholder=" Pickup" autocomplete="off">

                              <span class="error" style="color: red"></span>
                           </div>
                        </div>
                        @if(Helper::isDestination())
                        <div class="col-md-12 col-sm-12 col-lg-12 p-0">
                           <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                              <input id="destination-input"
                                 name="d_address" class="form-control" type="text" placeholder=" Destination" autocomplete="off">
                                 <span class="error" style="color: red"></span>
                           </div>
                        </div>
                        @endif

                        <input type="hidden" name="s_latitude" id="origin_latitude" />
                        <input type="hidden" name="s_longitude" id="origin_longitude" />
                        @if(Helper::isDestination())
                        <input type="hidden" name="d_latitude" id="destination_latitude" />
                        <input type="hidden" name="d_longitude" id="destination_longitude" />
                        @endif
                        <input type="hidden" name="current_longitude" id="long" />
                        <input type="hidden" name="current_latitude" id="lat" />
                        <div class="field-box">
                        <div id="service_list" class="owl-carousel service-slider">
                        </div>
                        <span class="error" style="color: red"></span>
                        </div>
                        <div class="col-md-12 col-sm-12 col-lg-12 p-0 card-feild">
                           <div class="field-box">
                              <select class="custom-select m-0" name="payment" id="select_payment">
                                 @if(Helper::checkPayment('cash'))
                                 <option value="CASH" selected="">CASH</option>
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
                           </div>
                           <br />
                           <div class="field-box card" style="display:none">
                              <select class="custom-select m-0" name="card_id">
                              </select>

                              <span class="error" style="color: red"></span>
                           </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-lg-12 p-0 mt-5 btn-section">
                           <a id="ride-now" class="btn btn-primary ">@lang('transport.user.ride_now') <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                        </div>

                     </div>
                     
                     <div  id="confirm-ride" class="col-sm-12 col-md-12 col-lg-5 p-0 form-section d-none">
                        @if(Helper::isDestination())
                        <h4>@lang('transport.user.trip_estimation')</h4>
                        @endif

                        <div class="col-md-12 col-lg-12 col-sm-12 ">
                           <form id="ride_creation">
                           <div id="estimation"></div>
                              <ul class="estimation invoice"></ul>
                                 <br>

                                 
                                 <div class="row">
                                    <div id="my_wallet" class="col-md-6 col-sm-12 col-xl-4 dis-end mt-2 d-sm-none d-md-none d-xl-block online">
                                          <h5 class="p-0 go-online">@lang('transport.user.use_wallet')(<span class="currency"></span>)</h5>
                                         
                                          <label class="toggleSwitch nolabel" onclick="">
                                             <input name="use_wallet" value="1"
                                             id="use_wallet" type="checkbox"  autocomplete="off">
                                             <span>
                                                <span class="show1">@lang('transport.user.no')</span>
                                                <span class="show2">@lang('transport.user.yes')</span>
                                             </span>
                                             <a></a>
                                          </label>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xl-4 dis-end mt-2 d-sm-none d-md-none d-xl-block online wheel_chair">
                                       <h5 class="p-0 go-online">@lang('transport.user.wheel_chair')</h5>
                                      
                                       <label class="toggleSwitch nolabel" onclick="">
                                          <input name="wheel_chair" value="1"
                                             id="filt1-1" type="checkbox"  autocomplete="off">
                                          <span>
                                             <span class="show1">@lang('transport.user.no')</span>
                                             <span class="show2">@lang('transport.user.yes')</span>
                                          </span>
                                          <a></a>
                                       </label>
                                    </div>
                                       
                                    <div class="col-md-6 col-sm-12 col-xl-4 dis-end mt-2 d-sm-none d-md-none d-xl-block online child_seat">
                                          <h5 class="p-0 go-online">@lang('transport.user.child_seat')</h5>
                                         
                                          <label class="toggleSwitch nolabel" onclick="">
                                             <input name="child_seat" value="1"
                                                id="filt1-3" type="checkbox"  autocomplete="off">
                                             <span>
                                                <span class="show1">@lang('transport.user.no')</span>
                                                <span class="show2">@lang('transport.user.yes')</span>
                                             </span>
                                             <a></a>
                                          </label>
                                       </div>
                                 </div>
                                 <div class="row">
                                    <div  class="col-md-6 col-sm-12 col-xl-6 dis-end mt-2 d-sm-none d-md-none d-xl-block online">
                                          <h5 class="p-0 go-online">@lang('transport.user.book_for_someone')</h5>
                                         
                                          <label class="toggleSwitch nolabel" onclick="">
                                             <input name="someone" value="1"id="someone" type="checkbox"  autocomplete="off">
                                             <span>
                                                <span class="show1">@lang('transport.user.no')</span>
                                                <span class="show2">@lang('transport.user.yes')</span>
                                             </span>
                                             <a></a>
                                          </label>
                                    </div>
                                    <div class="someone_form col-md-6 col-sm-12 col-xl-6 dis-end mt-2 d-sm-none d-md-none d-xl-block online">
                                    <h5>@lang('transport.user.someone_details')</h5>
                                    <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                                          <input id="someone_name"
                                             name="someone_name" class="form-control" type="text" placeholder="@lang('transport.user.someone_name')" autocomplete="off">
                                       </div>
                                       <span class="error error_someone_name" style="color: red"></span>
                                    @if(Helper::getCheckEmail()==1 || Helper::getrideotp()==0) 
                                       <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                                          <input id="someone_email"
                                             name="someone_email" class="form-control" type="email" placeholder="@lang('transport.user.someone_email')" autocomplete="off">
                                       </div>
                                       <span class="error error_someone_email" style="color: red"></span>
                                    @endif
                                    @if(Helper::getCheckSms()==1 || Helper::getrideotp()==0)   
                                       <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                                          <input id="someone_mobile"
                                             name="someone_mobile" class="form-control" type="text" placeholder="@lang('transport.user.someone_mobile')" autocomplete="off">
                                       </div>
                                       <span class="error error_someone_mobile" style="color: red"></span>
                                    @endif
                                    @if(Helper::getCheckSms()==0 && Helper::getCheckSms()==0 && Helper::getrideotp()==1)   
                                       <div class="field-box col-md-12 col-sm-12 col-lg-12 p-0">
                                          <label>@lang('transport.user.booksomeone_msg')</label>
                                       </div>
                                       <span class="error error_someone_mobile" style="color: red"></span>
                                    @endif

                                    </div>
                                       
                                   
                                 </div>
                                
                                 <br>
                              <br>
                              <a id="schedule-ride" data-toggle="modal" data-target="#myModal"  class="btn btn-primary  ">@lang('transport.user.schedule-ride')<i class="fa fa-clock-o" aria-hidden="true"></i></a>
                              <a id="book-now" class="btn btn-secondary">@lang('transport.user.ride_now') <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                           </form>
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
            <h4 class="modal-title">@lang('transport.user.coupon_code')</h4>
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
                  <a class="btn btn-primary btn-block apply_coupon">@lang('transport.user.apply')</a>
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
<script type="text/javascript">
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
<script type="text/javascript" src="{{ asset('assets/layout/js/map.js') }}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>

<script type="text/javascript" src="{{ asset('assets/plugins/owl-carousel/js/owl.carousel.min.js')}}"></script>

<script crossorigin src="https://unpkg.com/babel-standalone@6.26.0/babel.min.js"></script>
<!-- <script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.production.min.js"></script> -->

<script crossorigin src="https://unpkg.com/react@16.8.0/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@16.8.0/umd/react-dom.development.js"></script>

<script type="text/babel" src="{{ asset('assets/layout/js/transport/waiting.js') }}"></script>


<script>
window.salt_key = '{{ Helper::getSaltKey() }}';
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
})
   $(document).ready(function(){

      var userSettings = getUserDetails();

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

     }

     if(userSettings.id != 0) {
        

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
     } else {
      $('select[name=payment] option[value!="CASH"]').hide();
      $('.card').hide();
     }


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
         var destination_address = $('input[name=d_address]');

         var service_type = $('input[name=service_type]:checked').val();
         var use_wallet = $('input[name=use_wallet]:checked').val();
         var source_latitude = $('input[name=s_latitude]').val();
         var source_longitude = $('input[name=s_longitude]').val();

         @if(Helper::isDestination() == "1")
         var destination_address = $('input[name=d_address]');
         var destination_latitude = $('input[name=d_latitude]').val();
         var destination_longitude = $('input[name=d_longitude]').val();
         @endif

         var payment = $('select[name=payment]').val();
         var ride_type = $('input[name=ride_type]:checked').val();
         var ride_type = $('input[name=ride_type]:checked').val();
         //console.log(transport);
         // $(".error").remove();
         

         /* if(typeof ride_type == 'undefined') {
            $('input[name=ride_type]').closest('.field-box').after(`<span class="error" style="color: red">Ride type is required</span>`);
         } else */if(source_address.val() == "") {
            source_address.closest('.field-box').find('.error').text(`Source address is required`);
         } 
         @if(Helper::isDestination())
         else if(destination_address.val() == "") {
            destination_address.closest('.field-box').find('.error').text(`Destination address is required`);
         } 
         @endif
         else if(typeof service_type == 'undefined') {
            $('input[name=service_type]').closest('.field-box').find('.error').text(`Service type is required`);
         } else if(payment == 'CARD' && $('select[name=card_id]').val() == "") {
            $('select[name=card_id]').closest('.field-box').find('.error').text(`Card is required`);
         } else {
         @if(Helper::isDestination())
            showLoader();
            $.ajax({
            url: getBaseUrl() + "/user/transport/estimate",
            type: "post",
            data: {
               city_id: getUserDetails().city_id,
               s_latitude: source_latitude,
               s_longitude: source_longitude,
               service_type: service_type,
               d_latitude: destination_latitude,
               d_longitude: destination_longitude,
               payment_mode:payment,
               use_wallet:use_wallet
            },
            headers: {
                  Authorization: "Bearer " + getToken("user")
            },
            success: (data, textStatus, jqXHR) => {

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
                                          <span class="pricing">`+result.fare.distance+` `+result.unit+`</span>
                                       </li>`;
                  }

                  if(result.fare.time != "") {
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
                  }


                  if(result.fare.estimated_fare != "") {
                     estimationHtml += `<li>
                                          <span class="fare">Estimated Fare</span>
                                          <span class="pricing "><span> `+result.currency+`</span><span class="estimate_amount">`+result.fare.estimated_fare+`</span></span>
                                       </li>`;
                  }

                  estimationHtml += `<li class="promocode dis-ver-center">
                                    <img src="{{ asset('assets/layout/images/transport/svg/coupon.svg') }}">
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
         @else
            $("#ride-book").addClass("d-none");
            $("#confirm-ride").removeClass("d-none");
         @endif


         }
      });

      $("#book-now, #schedule-later").click(function() {
         var userSettings = getUserDetails();
         
         if(userSettings.id == 0) {
            alertMessage("Error","Please Login", "danger");     
            setTimeout(function(){              
               window.location.replace("{{ url('/login') }}");
            }, 5000); 
            return false;       
         }

         var that = $(this);

         var data = {};
         data["service_type"] = $('input[name=service_type]:checked').val();
         data["s_latitude"] = $('input[name=s_latitude]').val();
         data["s_longitude"] = $('input[name=s_longitude]').val();
         data["s_address"] = $('input[name=s_address]').val();
         data["d_latitude"] = $('input[name=d_latitude]').val();
         data["d_longitude"] = $('input[name=d_longitude]').val();
         data["d_address"] = $('input[name=d_address]').val();
         data["promocode_id"] = $('#promocode').val();
         data["payment_mode"] = $('select[name=payment]').val();
         data["card_id"] = $('select[name=card_id]:selected').val();
         data["ride_type_id"] = '{{$id}}';
         data["wheel_chair"] = $('input[name=wheel_chair]:checked').val();
         data["child_seat"] = $('input[name=child_seat]:checked').val();
         data["use_wallet"] = $('input[name=use_wallet]:checked').val();
         

         if(that.attr('id') == "schedule-later") {
            
            if(!$('input[name=date]').val() || !$('input[name=time]').val()){
               alertMessage("Error","Please Choose both date and time", "danger");
               return false;
            }
            data["schedule_date"] = $('input[name=date]').val();
            data["schedule_time"] = $('input[name=time]').val();
         }

         if($('#someone').is(':checked')){ 
            if($('#someone_email').val() == "" && $('#someone_mobile').val() == "") { 
               alertMessage("Error", "Email or Mobile is Required", "danger");
               return false;
            }
            data["someone"] = $('input[name=someone]:checked').val(); 
            data["someone_email"] = $('#someone_email').val(); 
            data["someone_mobile"] = $('#someone_mobile').val(); 
         }

         sendRequest(data, that.attr('id'));

      });

      function sendRequest(data, type) {
         showLoader();
         $.ajax({
            url: getBaseUrl() + "/user/transport/send/request",
            type: "post",
            data: data,
            headers: {
                  Authorization: "Bearer " + getToken("user")
            },
            success: (response, textStatus, jqXHR) => {
               var data = parseData(response);
               hideLoader();
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
      }

   
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
         getRideTypes(); 
         
         }, 1000);

   })

   setTimeout(function(){ getRideTypes(); }, 1000);

   function getRideTypes() {
      
      $.ajax({
         url: getBaseUrl() + "/user/transport/services?type={{$id}}&latitude="+current_latitude+"&longitude="+current_longitude+"&city_id="+
               getUserDetails().city_id,
         type: "get",
         processData: false,
         contentType: false,
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function() {
            showLoader();
         },
         success: (response, textStatus, jqXHR) => {
            hideLoader();
            var data = parseData(response);
            if(Object.keys(data.responseData).length != 0) {
               var result = data.responseData;
               var services = result.services;
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

                  $('#ride-book').removeClass('d-none');

                  if(services.length > 0) {

                     for(var i in services) {
                        
                           serviceList += `<div class="item" style="width: 130px; float:left;">
                                    <div class="dis-column service-type">
                                       <input type="radio" name="service_type" data-id="`+services[i].capacity+`" value="`+services[i].id+`" id="service-`+services[i].id+`" tabindex="0">
                                       <label for="service-`+services[i].id+`" class="dis-column">
                                          <div class="left-icon p-0">
                                             <img src="`+services[i].vehicle_image+`" alt="`+services[i].vehicle_name+`">
                                             <h6 class="m-0">`+services[i].vehicle_name+`<br> (`+services[i].estimated_time+`)</h6>
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

                     $('#ride-book').html(`<div style="float:left; text-align: center; width: 100%">No service available!</div>`);
                  }
                  


            }

         },
         error: (jqXHR, textStatus, errorThrown) => {
            hideLoader();
            $('.ride-section').html(  `<h4 style="text-align:center">`+jqXHR.responseJSON.message+`<h4>`);
         }
      });

   }
});
 
</script>
@stop
