@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
<style type="text/css">
  .pac-container{
    z-index: 999999999!important;
  }
</style>
@stop
@php

   $order_setting = json_decode( json_encode( Helper::getSettings()->order ) , true);
   $order_otp = $order_setting['order_otp'];
@endphp
@section('content')

<div class="content-box">
                <div id="toaster" class="toaster"></div>
         <div class="widget clearfix bg-white">
            <!-- /widget heading -->
            <!-- <div class="widget-heading">
               <h3 class="widget-title text-dark">
                  ORDER #109563986
               </h3>
               <p class="m-0">2 items, $168 | 6:00PM</p>
               <div class="clearfix"></div>
               </div> -->
            <div class="widget-body">            
                  <div class="row">
                     <div class="col-sm-12 col-md-12 col-xl-8 margin-b-30 checkout-section">
                        
                        <div class="menu-widget delivery-section col-sm-12 col-md-12 col-xl-12 bg-none p-0">
                           <div id="popular2">
                              <div class="food-item white b-0 p-0">
                                 <div class="row">
                                    <div class="rest-descr ">
                                       <div id="my_map"  style="height:500px;width:100%;"></div>
                                        
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="form-register w-100">
                           <div class="steps clearfix" >
                              <ul role="tablist" >
                                 <li role="tab" aria-disabled="false" class="zero" aria-selected="false">
                                    <a id="form-total-t-6" href="#form-total-h-6" aria-controls="form-total-p-6">
                                       <div class="title">
                                          <span class="step-icon"><img src="{{url('/assets/layout/images/order/svg/breakfast-delivery-service.svg')}}"></span>
                                          <span class="step-text">@lang('store.user.Order_Placed')</span>
                                       </div>
                                    </a>
                                 </li>
                                 <li role="tab" aria-disabled="false" class="first" aria-selected="true">
                                    <a id="form-total-t-0" href="#form-total-h-0" aria-controls="form-total-p-0">
                                       <span class="current-info audible"> </span>
                                       <div class="title">
                                          <span class="step-icon"><img src="{{url('svg/order-received.svg')}}"></span>
                                          <span class="step-text">@lang('store.user.Order_received_by_Shop')</span>
                                       </div>
                                    </a>
                                 </li>
                                 <li role="tab" aria-disabled="false" class="second delivery_container" aria-selected="false">
                                    <a id="form-total-t-1" href="#form-total-h-1" aria-controls="form-total-p-1">
                                       <div class="title">
                                          <span class="step-icon"><img src="{{url('svg/scooter.svg')}}"></span>
                                          <span class="step-text">@lang('store.user.Started_towards_Shop')</span>
                                       </div>
                                    </a>
                                 </li>
                                 <li role="tab" aria-disabled="false" class="third delivery_container" aria-selected="false">
                                    <a id="form-total-t-2" href="#form-total-h-2" aria-controls="form-total-p-2">
                                       <div class="title">
                                          <span class="step-icon"><img src="{{url('svg/scooter.svg')}}"></span>
                                          <span class="step-text">@lang('store.user.Reached_Shop')</span>
                                       </div>
                                    </a>
                                 </li>
                                 <li role="tab" aria-disabled="false" class="four delivery_container" aria-selected="false">
                                    <a id="form-total-t-3" href="#form-total-h-3" aria-controls="form-total-p-3">
                                       <div class="title">
                                          <span class="step-icon"><img src="{{url('/assets/layout/images/order/svg/meal.svg')}}"></span>
                                          <span class="step-text">@lang('store.user.Order_Picked_Up')</span>
                                       </div>
                                    </a>
                                 </li>
                                 <li role="tab" aria-disabled="false" class="four takeaway_container" aria-selected="false">
                                    <a id="form-total-t-3" href="#form-total-h-3" aria-controls="form-total-p-3">
                                       <div class="title">
                                          <span class="step-icon"><img src="{{url('/assets/layout/images/order/svg/meal.svg')}}"></span>
                                          <span class="step-text">@lang('store.user.Food_Prepared')</span>
                                       </div>
                                    </a>
                                 </li>
                                 <li role="tab" aria-disabled="false" class="five" aria-selected="false">
                                    <a id="form-total-t-4" href="#form-total-h-4" aria-controls="form-total-p-4">
                                       <div class="title">
                                          <span class="step-icon"><img src="{{url('/assets/layout/images/order/svg/breakfast-delivery-service.svg')}}"></span>
                                          <span class="step-text">@lang('store.user.Order_Delivered')</span>
                                       </div>
                                    </a>
                                 </li>
                              </ul>
                           </div>
                           <div class="cancelButton" id="cancelButton">
                              <a data-toggle="modal" data-target="#cancelModal" class="btn btn-primary">@lang('store.user.Cancel_Order') </a>
                           </div>                           
                        </div>
                        <div class="menu-widget m-b-30 d-none">
                           <div class="widget-heading c-pointer"  data-toggle="collapse" data-target="#popular3" aria-expanded="true">
                              <h3 class="widget-title text-dark">
                                 @lang('store.user.Order_Picked_Up')
                              </h3>
                              <div class="clearfix"></div>
                           </div>
                           <div class="collapse in white" id="popular3">
                              <div class="food-item white b-0">
                                 <div class="row">
                                    <div class="rest-descr ">
                                       <p> {{ __('Your order has been accepted by the restaurant') }}</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>                
                     <div class="col-sm-12 col-md-12 col-xl-4 bor-dashed pt-2 pb-2 cart-details ">     
                     <form method="post">
                        <input type="hidden" id="orderUsername"  />
                        <input type="hidden" id="orderProvidername"  />
                        <h4 class="modal-title">@lang('store.user.Order_Details') </h4>
                        <h6 class="mb-3 pt-3"><span>@lang('store.user.booking_id')</span> : <span class="txt-green" id="bookingId"></span></h6>
                        <div class="widget-body green">
                              <div class="price-wrap text-center">
                              @if($order_otp==1)
                                 <h5 class="value txt-white">@lang('store.user.OTP') : <span class="cart_otp"></span></h5>
                              
                              @endif
                              </div>
                        </div>
                        <div class="cart-totals margin-b-20 height20vh" id="rcart_list">
                           
                        </div>
                        <div class="cart-totals-fields">
                           <input type="hidden" name="userid" id="orderUserid" />
                           <input type="hidden" name="providerid" id="orderProviderid" />
                           <input type="hidden" name="orderid" id="orderid" />
                           <input type="hidden" name="Servicetype" id="ServiceType" />
                           <table class="table">
                              <tbody>
                                <tr>
                                    <td>@lang('store.user.cart_subtotal')</td>
                                    <td class="tot_gross"></td>
                                 </tr>
                                 <tr class="d-none">
                                    <td>@lang('store.user.cart_subtotal')</td>
                                    <td class="shop_offer"></td>
                                 </tr>
                                 <tr>
                                    <td> @lang('store.user.shop_gst')</td>
                                    <td class="shop_gst"></td>
                                 </tr>
                                  <tr>
                                    <td> @lang('store.user.shop_pkg')</td>
                                    <td class="shop_pkg"></td>
                                 </tr>
                                 <tr class="d-none">
                                    <td> @lang('store.user.promocode_price')</td>
                                    <td class="promocode_price"></td>
                                 </tr>
                                 <tr>
                                    <td class="others d-none" >@lang('store.user.Shipping & Handling')</td>
                                    <td class="food d-none">@lang('store.user.delivery_charge')</td>
                                    <td class="delivery_charge">$2.00</td>
                                 </tr>
                                 <tr class="promocode  loadpromocode d-none" >
                                    <td class="dis-ver-center">
                                       <img src="{{url('svg/coupon.svg')}}">
                                       <h5 class="c-pointer" >@lang('store.user.apply_promocode')</h5>
                                    </td>
                                    <td class="promo_balance"></td>
                                 </tr>
                                  <tr class="d-none">
                                    <td>@lang('store.user.Wallet')</td>
                                    <td class="wallet">$0.00</td>
                                 </tr>
                                 <!-- <tr>
                                    <td class="text-color"><strong>Total</strong></td>
                                    <td class="text-color"><strong class="total-price">$31.00</strong></td>
                                    </tr> -->
                              </tbody>
                           </table>
                           <div class="widget-body green">
                              <div class="price-wrap text-center">
                                 <i class="material-icons address-category">attach_money</i>
                                 <p class="txt-white">@lang('store.user.GRAND_TOTAL')</p>
                                 <h3 class="value txt-white"><strong class="Total">$ 00.00</strong></h3>
                              </div>
                           </div>
                           <div class="form-register w-100  provider-details d-none">
                              <div class="dis-center ">
                                 <div class="col-lg-12 col-sm-12 dis-row pickup-details green">
                                    <div class="dis-column col-lg-6 col-md-6 col-sm-12 p-0">
                                       <span class="user-img" ></span>
                                       <h5 class="txt-white providerName">@lang('store.user.Frank_Provider')</h5>
                                       <p><a href="" class="providerMobile"></a></p>
                                       <div class="rating-outer">
                                          <span class="txt-white providerRating" style="cursor: default;">
                                             <span class="providerRating"></span>
                                             <div class="rating-symbol" style="display: inline-block; position: relative;">
                                                <div class="fa fa-star-o" style="visibility: hidden;"></div>
                                                <div class="rating-symbol-foreground" style="display: inline-block; position: absolute; overflow: hidden; left: 0px; right: 0px;top: 0; width: auto;"><span class="fa fa-star" aria-hidden="true"></span></div>
                                             </div>
                                          </span>
                                          <input type="hidden" class="rating" value="1" disabled="disabled">
                                       </div>
                                    </div>
                                    <div class="dis-column col-lg-6 col-md-6 col-sm-12 p-0">
                                       <span data-toggle="modal" data-target="#contactModal" class="pull-right c-pointer txt-white dis-row"> <i class="material-icons mr-1 txt-white">phone</i> @lang('store.user.Emergency_Contact')</span>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </form>
                     <div id="message_container" class="delivery_boy">
                        <h5 class="text-left mt-3">@lang('store.user.Chat')</h5>
                        <div id="message_box" class="height20vh chat-section mt-1 bg-white"></div>
                        <div class="message-typing"><input class="form-control"  name="message" placeholder="Enter Your Message...">
                           <a class="btn btn-green" onClick=handleSendMessage(this);> <i class="fa fa-paper-plane" aria-hidden="true"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php // RATING MODAL START ?>
            <div class="modal" id="rating">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <form class="validateForm getrate" name="ratingForm">
                        <input type="hidden" class="shopid"name="shopid" value="" />
                        <div class="modal-header">
                        <h4 class="modal-title">@lang('store.user.Rating')</h4>
                        <button type="button" class="close" data-dismiss="modal">x</button>
                        </div>
                        <div class="modal-body">
                           <div class="dis-column col-lg-12 col-md-12 col-sm-12 p-0 ">
                              <div class="trip-user dis-column w-100 delivery_boy">
                                 <div class="user-img" style=""></div>
                                 <h5><span class="providerName"></span></h5>
                                 <div class="rating-outer">
                                    <div id="user_rating"></div>   
                                 </div>
                              </div>
                              <div class="trip-user w-100 dis-column mt10 delivery_boy">
                                 <h5>@lang('store.user.Rate_Delivery_Person')</h5>
                                 <div class="rating-outer">
                                       <fieldset class="rating" >
                                       <input id="star5" name="rating" value="5" checked  type="radio"><label class="full" for="star5" ></label>
                                       <input id="star4" name="rating" value="4" type="radio"><label class="full" for="star4" ></label>
                                       <input id="star3" name="rating" value="3" type="radio"><label class="full" for="star3" ></label>
                                       <input id="star2" name="rating" value="2" type="radio"><label class="full" for="star2" ></label>
                                       <input id="star1" name="rating" value="1"type="radio"><label class="full" for="star1" ></label>
                                       </fieldset>
                                 </div>
                                 
                              </div>
                              <div class="trip-user w-100 dis-column mt10 shoprating">
                                 <h5>@lang('store.user.Rate_this_restaurant')</h5>
                                 <div class="rating-outer">
                                       <fieldset class="rating" >
                                       <input id="star10" name="shoprating" value="5" checked  type="radio"><label class="full" for="star10" ></label>
                                       <input id="star9" name="shoprating" value="4" type="radio"><label class="full" for="star9" ></label>
                                       <input id="star8" name="shoprating" value="3" type="radio"><label class="full" for="star8" ></label>
                                       <input id="star7" name="shoprating" value="2" type="radio"><label class="full" for="star7" ></label>
                                       <input id="star6" name="shoprating" value="1" type="radio"><label class="full" for="star6" ></label>
                                       </fieldset>
                                 </div>
                              </div>
                              <div class="comments-section field-box mt-3">
                                 <textarea class="form-control" rows="4" cols="50" maxLength="255"  id="comment" name="comment" placeholder="Leave Your Comments..."></textarea>
                                 <small>(Maximum characters: 255)</small>
                                  <span class="commentLength" style="color:red"></span>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                        <button type="submit"  class="btn btn-primary btn-block">{{ __('Submit') }} <i class="fa fa-check" aria-hidden="true"></i></button>
                     <!-- <a class="btn btn-primary btn-block" id="ratingreview">Submit <i class="fa fa-check-square" aria-hidden="true"></i></a> -->
                        </div>
                     </form>
                  </div>
               </div>
            </div>
      <?php // RATING MODAL ?>

      <div id="addonCartModal">
         <!--  -->
      </div>
       <div class="modal" id="myModal">
             <div class="modal-dialog">
                <div class="modal-content  all_addons">
                   <!-- Addon Header -->
                   <div class="modal-header dis-end b-b">
                      <h4 class="modal-title  prod_title">Veg Extravaganza</h4>
                      <span class="prod_price">$19.99</span>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <div class="modal-body">
                      <div class="col-sm-12 p-0">
                         <div class="widget bg-white col-sm-12 p-0">
                            <h4>Add-On  <small>(optional)</small></h4>
                            <div class="dis-end  prod_addon_list">
                               
                            </div>
                         </div>
                         
                      </div>
                   </div>
                   <!-- Addon footer -->
                   <!-- <div class="modal-footer b-0  spidfoot">
                      <a id="add_cart"  class="btn btn-primary btn-block addons" ><span class=""></span>Add  <i class="fa fa-plus" aria-hidden="true"></i></a>
                   </div> -->
                </div>
             </div>
          </div>


<!-- cancel Modal -->
<div class="modal" id="cancelModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Schedule Order Header -->
         <div class="modal-header">
            <h4 class="modal-title">@lang('store.user.Reason_For_Cancellation')</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Schedule Order body -->
         <div class="modal-body">
            <select name="cancel_reason" id="cancelReasons" onchange="" class="form-control">
               <option value=""> @lang('store.user.Select_Reason') </option>                     
            </select>

            <div class="comments-section field-box" id ="cancel_comments">
               <h5 class=" no-padding"><strong>{{ __('Tell us why you are cancelling the order') }}</strong></h5>
               <textarea class="form-control" rows="4" cols="50" id="cancel_reason_opt" name="cancel_reason_opt"></textarea>
            </div>
         </div>
         <!-- Schedule Order footer -->
         <div class="modal-footer">
           <a class="btn btn-primary" onClick=handleCancel(this);> {{ __('Submit') }}  <i class="fa fa-clock-o" aria-hidden="true"></i></a>
         </div>
      </div>
   </div>
</div>
<!-- cancel Modal -->
     
<div class="modal" id="contactModal">
   <div class="modal-dialog">
      <div class="modal-content">
         <!-- Emergency Contact Header -->
         <div class="modal-header">
            <h4 class="modal-title">{{ __('Contact') }}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <!-- Emergency Contact body -->
         <div class="modal-body">
            
            <p class="mt-3">{{Helper::getSettings()->site->sos_number}}</p>
         </div>
         <!-- Emergency Contact footer -->
         <div class="modal-footer">
               
         </div>
      </div>
   </div>
</div>
@stop
@section('scripts')
@parent
<script>
window.salt_key = '{{ Helper::getSaltKey() }}';
</script>
<script type="text/javascript">

   $('#cancel_comments').hide();
   var promoavailable = [];
   var currency = getUserDetails().currency_symbol;
   var init = 0;
   var addons = '';
   $("input[name=message]").on('keyup', function (e) {
       if (e.keyCode == 13) {
           handleSendMessage();
       }
   });

   function handleSendMessage(){
      var message = $('input[name=message]');
      var chatSocket = io.connect(window.socket_url);
      var request_id = $("#orderid").val();
      var user_id = $("#orderUserid").val();
      var user_name = $("#orderUsername").val();
      var provider_name = $("#orderProvidername").val();
      var provider_id = $("#orderProviderid").val();
      var admin_service = 'ORDER';
      var user = user_name;
      var provider = provider_name;
      
      if(message.val() != "") {
         chatSocket.emit('send_message', {room: `room_${window.room}_R${request_id}_U${user_id}_P${provider_id}_${admin_service}`, url: getBaseUrl() + "/chat", salt_key: window.salt_key, id: request_id, admin_service: admin_service, user: user, provider: provider, type: 'user',message:  message.val() });
      }

      message.val('');
   }

   loadorder();
   
   var id = {{$id}};
   var that = this;
   var socket = io.connect(window.socket_url);
   var chatSocket = io.connect(window.socket_url);
   socket.emit('joinPrivateRoom', `room_${window.room}_R${id}_ORDER`);
   socket.on('socketStatus', function (data) {
      console.log(data);
   });

   var message_box  = $('body').find('#message_box');
   var height = message_box[0].scrollHeight;
   message_box.scrollTop(height);

   //chatSocket.emit('joinPrivateChatRoom', `room_${window.room}_R${id}_U${user_id}_P${provider_id}_ORDER`);
   chatSocket.on('new_message', function (data) {
      if(data.type == "user") {
            $('#message_box').append(`<div class="user-msg"><span class="msg">${data.message}</span></div>`);
            //$('#message_box').append(`<span style='width:100%; float: left;'>${data.user}: ${data.message}</span>`);
      } else if(data.type == "provider") {
            $('#message_box').append(`<div class="provider-msg"><span class="msg">${data.message}</span></div>`);
            //$('#message_box').append(`<span style='width:100%; float: left;'>${data.provider}: ${data.message}</span>`);
      } 

      var message_box  = $('body').find('#message_box');
      var height = message_box[0].scrollHeight;
      message_box.scrollTop(height);
   });

   socket.on('orderRequest', function (data) {
      that.loadorder();
   });
   
   $.ajax({
      url: getBaseUrl() + "/user/reasons?type=ORDER",
      type: "get",
      data: { },
      headers: {
            Authorization: "Bearer " + getToken("user")
      },
      beforeSend: function() {
            showLoader();
      },
      success: (response, textStatus, jqXHR) => {
            var data = parseData(response);
            var reasons = [];
            if (Object.keys(data.responseData).length > 0) {
               var result = data.responseData;
               $.each(result, function(i,val){
                  $('#cancelReasons')
                  .append($("<option></option>")
                              .attr("value",val.id)
                              .text(val.reason)); 
                  $('#cancelReasons').append($("<option/>", {
                        value: 'ot',
                        text: 'others'
                     }));
               });
            }
            hideLoader();
      },
      error: (jqXHR, textStatus, errorThrown) => {}
   });
   //Get the comments text box
   $('#cancelReasons').change(function(){
      var result = $("#cancelReasons").val();
      showInlineLoader();
      if(result == 'ot')
      {
         $('#cancel_comments').show();
      }else{
         $('#cancel_comments').hide();
      }
      hideInlineLoader();
   });
   function handleCancel(){
      var id = {{$id}};
      var data = new FormData();
      var reason = $("#cancelReasons").val();
      var reason_other = $("#cancel_reason_opt").val();
      data.append( 'id',id);
      data.append( 'cancel_reason', reason );
      data.append( 'cancel_reason_opt', reason_other );
      $.ajax({
         url: getBaseUrl() + "/user/order/cancel/request",
         type: "post",
         processData: false,
         contentType: false,
         secure: false,
         data:data,
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function() {
               showLoader();
         },
         success: (response, textStatus, jqXHR) => {
               hideLoader();
               alertMessage(textStatus, jqXHR.responseJSON.message, "success");
               // $("#booking-status").hide();
               // var data = parseData(response);
               // if (Object.keys(data.responseData).length > 0) {
               //    this.setState({
               //       requests: data.responseData[0]
               //    });
               //    initMap();
               // }
               location.reload();
         },
         error: (jqXHR, textStatus, errorThrown) => {
               // $("#booking-status").show();
               hideLoader();
               alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
         }
      });
   }
// window.setInterval(loadorder, 4000);
// setTimeout(function(){ loadorder(); }, 4000);
function  loadorder(){ 
    

   $.ajax({
         url: getBaseUrl() + "/user/store/order/{{$id}}",
         type:"GET",
         processData: false,
         contentType: false,
         secure: false,
         headers: {
             Authorization: "Bearer " + getToken("user")
         },
         success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
               var order_list = data.responseData;
               var providername = '';
               var providermobile = '';
               var userrate =0;  
               if(order_list.status == 'ORDERED' || order_list.status == 'STORECANCELLED' ){ 
                  $(".cancelButton").show();
               }else{
                  $(".cancelButton").hide();
               }               
               if(order_list.status=='CANCELLED'){
                  location.href="{{url('/home')}}";
               } 
               if(order_list.provider != null){
                  $('.provider-details').removeClass('d-none');
                  providername = order_list.provider.first_name + ' ' + order_list.provider.last_name;
                  providermobile = order_list.provider.country_code + ' ' + order_list.provider.mobile;
                  $(".providerName").html(providername);
                  $('.user-img').css('background-image', 'url('+order_list.provider.picture+')'); 
                  $(".providerMobile").html(providermobile);
                  $(".providerMobile").attr('href','tel:'+providermobile);
                   
                  userrate = Math.round(order_list.provider.rating);
                  $('.providerRating').html(userrate)  
               }
               userfullname = order_list.user.first_name + ' ' + order_list.user.last_name;
               $("#bookingId").html(order_list.store_order_invoice_id);
               // CHAT INIT
               //var chatSocket = io.connect(window.socket_url);
               var id = order_list.id;
               var user_id = order_list.user_id;
               var provider_id = order_list.provider_id;
               var admin_service = order_list.admin_service;
               $("#orderUserid").val(user_id);
               $("#orderProviderid").val(provider_id);
               $("#orderid").val(id);
               $("#ServiceType").val(admin_service);
               $("#orderUsername").val(userfullname);
               $("#orderProvidername").val(providername);
               if(order_list.order_type == 'TAKEAWAY'){
                  $(".delivery_container").hide();
                  $(".takeaway_container").show();

                  if(order_list.store.storetype.category == "OTHERS")
                  {
                     $(".steps .first .step-icon img").attr('src', url+'/svg/ordered.png');
                     $(".steps .four .step-icon img").attr('src', url+'/svg/ready.png');
                     $(".steps .four .step-text").text("Order Ready");
                  }
                  
               }else{
                  $(".delivery_container").show();
                  $(".takeaway_container").hide();
               }
               if(order_list.order_ready_status == 1){
                  $(".steps .four.takeaway_container").addClass("current");
               }
               var chat_data = order_list.chat;
               if(chat_data != null) {
                     for(var chat of chat_data.data) {
                        if(chat.type == "user") {
                           $('#message_box').append(`<div class="user-msg"><span class="msg">${chat.message}</span></div>`);
                        } else if(chat.type == "provider") {
                           $('#message_box').append(`<div class="provider-msg"><span class="msg">${chat.message}</span></div>`);
                        }
                     }
               }
               /* var message_box  = $('body').find('#message_box');
               var height = message_box[0].scrollHeight;
               message_box.scrollTop(height); */

               chatSocket.emit('joinPrivateChatRoom', `room_${window.room}_R${id}_U${user_id}_P${provider_id}_ORDER`);
               /* chatSocket.on('new_message', function (data) {
                  if(data.type == "user") {
                        $('#message_box').append(`<div class="user-msg"><span class="msg">${data.message}</span></div>`);
                        //$('#message_box').append(`<span style='width:100%; float: left;'>${data.user}: ${data.message}</span>`);
                  } else if(data.type == "provider") {
                        $('#message_box').append(`<div class="provider-msg"><span class="msg">${data.message}</span></div>`);
                        //$('#message_box').append(`<span style='width:100%; float: left;'>${data.provider}: ${data.message}</span>`);
                  } 

                  var message_box  = $('body').find('#message_box');
                  var height = message_box[0].scrollHeight;
                  message_box.scrollTop(height);
               }); */
               // CHAT END
               //$('.cart_tot').html((cart_list.carts).length);
               var cartlist ='';
               addons = '';
               $('.cart_otp').html(order_list.order_otp);            
               var str ='';
               for(var i=0;i<userrate;i++){
                 var str = str + "<div class='rating-symbol' style='display:inline-block;position:relative;'><div class='fa fa-star-o' style='visibility:hidden'></div><div class='rating-symbol-foreground' style='display:inline-block;position:absolute;overflow:hidden;left:0px;right:0px;top:0px;width:auto'><span class='fa fa-star' aria-hidden='true'></span></div></div>";
               }
               $("#user_rating").html(str);  
               $(".providerRating").html(str);     
               ongoingInitialize(order_list);
               var order = order_list.invoice.cart_details;
               var order = JSON.parse(order);
               console.log(order_list.store.storetype.category);

               if(order_list.store.storetype.category == "OTHERS")
               {
                  $(".steps .first .step-icon img").attr('src', url+'/svg/ordered.png');
                  $(".steps .four .step-icon img").attr('src', url+'/svg/ready.png');
                  
               }


              if(order_list.status == 'STORECANCELLED') {
                  alertMessage('Dispute Created', 'Shop not accepted your order', "danger");
              } else if(order_list.status == 'PROVIDEREJECTED') {
                  alertMessage('Dispute Created', 'Delivery person not available in the location', "danger");
              }

               // if(order_list.store.storetype.category == "OTHERS")
               // {
               //       $(".steps .zero .step-text").text("current");
               //       $(".steps .first .step-text").text("current");
               //       $(".steps .second .step-text").text("current");
               //       $(".steps .third .step-text").text("current");
               //       $(".steps .four .step-text").text("current");
               //       $(".steps .five .step-text").text("current");
               // }
         
               if(order_list.status=='ORDERED' || order_list.status=='PROCESSING' || order_list.status=='STORECANCELLED' || order_list.status=='PROVIDEREJECTED' || order_list.status=='RECEIVED'){
                  $(".steps .zero").addClass("current");

                  $('#message_container').hide();
               }
               if(order_list.status=='ACCEPTED'  || order_list.status=='PROVIDEREJECTED' || order_list.status=='RECEIVED' || order_list.status=='PROCESSING'){
                  $(".steps .zero").addClass("current");
                  $(".steps .first").addClass("current");
                  $('#message_container').hide();
               }
               if(order_list.status=='STARTED' || order_list.status=='PICKEDUP' || order_list.status=='REACHED' ){
                  $(".steps .zero").addClass("current");
                  $(".steps .first").addClass("current");
                  $(".steps .second").addClass("current");
                  $('#message_container').show();
               }
               if(order_list.status=='REACHED' ||order_list.status=='PICKEDUP' ||  order_list.status=='ARRIVED'  || order_list.status=='DELIVERED' || order_list.status=='COMPLETED'  ){
                  $(".steps .zero").addClass("current");
                  $(".steps .first").addClass("current");
                  $(".steps .second").addClass("current");
                  $(".steps .third").addClass("current");
               }
               if(order_list.status=='PICKEDUP'  ){
                  $(".steps .zero").addClass("current");
                  $(".steps .first").addClass("current");
                  $(".steps .second").addClass("current");
                  $(".steps .third").addClass("current");
                  $(".steps .four").addClass("current");
               }
               if(order_list.status=='COMPLETED'  ){
                  $(".steps .zero").addClass("current");
                  $(".steps .first").addClass("current");
                  $(".steps .second").addClass("current");
                  $(".steps .third").addClass("current");
                  $(".steps .four").addClass("current");
                  $(".steps .five").addClass("current");
                  if(order_list.user_rated == 0){
                     if(order_list.order_type == 'TAKEAWAY'){
                        
                        $('.delivery_boy').hide();
                        
                     }
                     if(order_list.store.storetype.category == "OTHERS")
                     {
                        $("#rating .shoprating h5").text("Rate this Shop");
                     }
                     $(".shopid").val(order_list.store_id);
                     $("#rating").modal("show");
                  }else{
                     $("#rating").modal("hide");
                     window.location.replace("/home");
                  }
               }
               $.each(order, function(i,val){ 
                  //console.log(val.product);
                cartlist +='<ul class="list-inline w-100 order-row dis-row">\
                    <li class="list-inline-item">\
                       <h5 class="price ">'+val.product.item_name+'</h5>\
                       <h6>'+ val.item_quantity + ' ' + val.unit +'</h6>\
                       <p class="txt-color1 m-0">'+currency+ val.product.item_price+'X'+val.quantity+'</p>';
                    if((val.cartaddon).length>0){
                     cartlist +='<a class="text-color c-pointer item-with-addon" data-cartid="'+val.id+'"  data-id="'+val.store_item_id+'"  data-spid="111"  data-toggle="modal" data-target="#addonModal_'+val.id+'">Customize <i class="fa fa-cogs" aria-hidden="true"></i></a>';
                     var cartItem = addonItems(val)
                     $('#addonCartModal').append(cartItem)
                   //   addons += '<div class="modal-header dis-end b-b d-none item_addon_'+val.product.id+' ">\
                   //    <h4 class="modal-title  prod_title">'+val.product.item_name+'</h4>\
                   //    <span class="prod_price">'+currency+val.product.item_price+'</span>\
                   //    <button type="button" class="close" data-dismiss="modal">&times;</button>\
                   // </div>\
                   // <div class="modal-body d-none item_addon_'+val.product.id+' ">\
                   //    <div class="col-sm-12 p-0">\
                   //       <div class="widget bg-white col-sm-12 p-0">\
                   //          <h4>Add-On  <small>(optional)</small></h4>\
                   //          <div class="dis-end  prod_addon_list">';
                   //   $.each(val.cartaddon,function(key,item){
                   //        var chk = "checked";
                   //      addons += '<span class="check-box mt-2 "><input type="checkbox" name="addon[]" id="addon-'+item.id+'" value="'+item.id+'"  '+chk+' ><label for="addon-'+item.id+'" class="mr-2">'+item.addon_name+'</label>'+currency+item.addon_price+'</span>';
                            
                   //      var item_id = item.store_cart_item_id;
                   //      //addons+=addon_obj);
                   //    });
                     addons += '</div>\
                         </div>\
                      </div>\
                   </div>';
                  }
                    cartlist +='<li class="list-inline-item mr-3">\
                       <h5 class="price ">'+currency+ val.total_item_price+'</h5>\
                    </li>\
                 </ul>';
               }); 
               
               $('#rcart_list').html(cartlist);               
               $('.tot_gross').html(currency+ order_list.invoice.gross);
               $('.shop_offer').html(currency+ order_list.invoice.shop_discount);
               $('.shop_gst').html(currency+ order_list.invoice.tax_amount);
               $('.shop_pkg').html(currency+ order_list.invoice.store_package_amount);
               $('.promocode_price').html(currency+ order_list.invoice.promocode_amount);
               $('.Total').html(currency+ order_list.invoice.payable);
               $('.delivery_charge').html(currency+ order_list.invoice.delivery_amount);
                if(order_list.store.storetype.category=='FOOD'){
                    $('.food').removeClass('d-none');
                    $('.others').addClass('d-none');
                }else{
                    $('.food').addClass('d-none');
                    $('.others').removeClass('d-none');
                }
               if(order_list.invoice.discount>0){
                  $('.shop_offer').parent('tr').removeClass('d-none');
                  $('.shop_offer').html(currency+ order_list.invoice.discount);
               }
               if(order_list.invoice.wallet_amount>0){
                  $('.wallet').parent('tr').removeClass('d-none');
                  $('.wallet').html(currency +order_list.invoice.wallet_amount);
               }
               if(order_list.invoice.promocode_amount>0){
                  $('.promo_balance').parent('tr').removeClass('d-none');
                  $('.promo_balance').html(currency +order_list.invoice.promocode_amount);
               }
               if(order_list.invoice.delivery_amount>0){
                  $('.freeship').addClass('d-none')
               }

            }

         }
        });
}

function addonItems(value) {

   var items = '';
   $.each(value.cartaddon,function(key,item){
      var chk = "checked";
      items += '<span class="check-box mt-2 ">'+
                  '<input type="checkbox" name="addon[]" id="addon-'+item.id+'" value="'+item.id+'"  '+chk+' >'+
                  '<label for="addon-'+item.id+'" class="mr-2">'+item.addon_name+'</label>'+currency+item.addon_price+
               '</span>';
          
      var item_id = item.store_cart_item_id;
   });

   var modal = '<div class="modal-header dis-end b-b">'+
                   '<h4 class="modal-title  prod_title">'+value.product.item_name+'</h4>'+
                   '<span class="prod_price">'+currency+value.product.item_price+'</span>'+
                   '<button type="button" class="close" data-dismiss="modal">&times;</button>'+
                '</div>'+
                '<div class="modal-body">'+
                   '<div class="col-sm-12 p-0">'+
                      '<div class="widget bg-white col-sm-12 p-0">'+
                         '<h4>Add-On  <small>(optional)</small></h4>'+
                         '<div class="dis-end  prod_addon_list">'+
                           items +
                     '</div>'+
                      '</div>'+
                   '</div>'+
                '</div>';
   var template = '<div class="modal" id="addonModal_'+value.id+'">'+
                     '<div class="modal-dialog">'+
                        '<div class="modal-content all_addons">'+
                           modal +
                        '</div>'+
                     '</div>'+
                  '</div>';

   return template;
}
$('.validateForm').validate({
   
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
         comment: { maxlength: 255 },
		},

		messages: {
			// dispute_name: { required: "Dispute Name is required." },

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},
		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		submitHandler: function(form,e) { 
            e.preventDefault();
            var formGroup = $(".validateForm").serialize().split("&");
            providerate = $("[name='rating']").val();
            shoprate = $("[name='shoprating']").val();
            shopid = $("[name='shopid']").val();
            var data = new FormData();
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append('request_id',{{$id}} );
            // data.append('store_id',store_id);
            var url = getBaseUrl() + "/user/store/order/rating";
            saveRow( url, null, data, "user","store/order");
            //$('#rating').modal('hide');
            //window.location.replace("/home");
		}
});
// $('body').on('click','.item-with-addon',function(e){
//      var item_id = $(this).data('id');
//     $('.all_addons').html(addons);
//     $('.item_addon_'+item_id).removeClass('d-none');
//      $('#myModal').modal('show');
// });
</script>

<script>
   if(typeof localStorage.landmark !== 'undefined') {
      $('.landmark').html(window.localStorage.getItem('landmark'));
   }
   if(typeof localStorage.city !== 'undefined') {
      $('.city').html(window.localStorage.getItem('city'));
   }
   if(typeof localStorage.latitude !== 'undefined') {
      $('#latitude').val(window.localStorage.getItem('latitude'));
   }
   if(typeof localStorage.longitude !== 'undefined') {
      $('#longitude').val(window.localStorage.getItem('longitude'));
   }
   
   
    var map;
    var input = document.getElementById('pac-input');
    var latitude = document.getElementById('latitude');
    var longitude = document.getElementById('longitude');
    function initMap() {

        var fenway = { lat: 42.345573, lng: -71.098326 };
        var map = new google.maps.Map(document.getElementById('my_map'), {
            center: fenway,
            zoom: 14
        });
        var panorama = new google.maps.StreetViewPanorama(
            document.getElementById('map'), {
                position: fenway,
                pov: {
                    heading: 34,
                    pitch: 10
                }
            });
        map.setStreetView(panorama);

      }
     function ongoingInitialize(trip) {
        map = new google.maps.Map(document.getElementById('my_map'), {
            center: {lat: 0, lng: 0},
            zoom: 2,
        });

        var bounds = new google.maps.LatLngBounds();

        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            icon: '/assets/img/foody/marker-start.png'
        });

        var markerSecond = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            icon: '/assets/img/foody/marker-end.png'
        });
        source = new google.maps.LatLng(trip.store.latitude, trip.store.longitude);
        if(trip.deliveryaddress) {
         destination = new google.maps.LatLng(trip.deliveryaddress.latitude, trip.deliveryaddress.longitude);
         } else {
            destination = new google.maps.LatLng(trip.store.latitude, trip.store.longitude);
         }
        

        marker.setPosition(source);
        markerSecond.setPosition(destination);

        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer({suppressMarkers: true, preserveViewport: true});
        directionsDisplay.setMap(map);

        directionsService.route({
            origin: source,
            destination: destination,
            travelMode: google.maps.TravelMode.DRIVING
        }, function(result, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(result);

                 var infowindow = new google.maps.InfoWindow({
                  content: (trip.store.flat_no ? trip.store.flat_no+', ' : '') +  (trip.store.street ? trip.store.street+', ' : '') +  trip.store.store_location
               });

                marker.setPosition(result.routes[0].legs[0].start_location);
                markerSecond.setPosition(result.routes[0].legs[0].end_location);

                infowindow.open(map, marker);
            }
        });

        if(trip.transporter) {
            var markerProvider = new google.maps.Marker({
                map: map,
                icon: "/assets/img/marker-car.png",
                anchorPoint: new google.maps.Point(0, -29)
            });

            provider = new google.maps.LatLng(trip.transporter.latitude, trip.transporter.longitude);
            markerProvider.setVisible(true);
            markerProvider.setPosition(provider);
            console.log('Provider Bounds', markerProvider.getPosition());
            bounds.extend(markerProvider.getPosition());
        }
        
        bounds.extend(marker.getPosition());
        bounds.extend(markerSecond.getPosition());
        map.fitBounds(bounds);
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>
@stop