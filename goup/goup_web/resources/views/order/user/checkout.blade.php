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
@section('content')
@php

   $paymentConfig = json_decode( json_encode( Helper::getSettings()->payment ) , true);
   $cardObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'card'; }));
   //print_r($cardObject);exit;
   $card = 0;

   $stripe_publishable_key = "";

   if(count($cardObject) > 0) { 
      $card = $cardObject[0]['status'];
   }

@endphp
<div id="toaster" class="toaster"></div>
<!-- Schedule Order Modal -->
      <div class="modal" id="scheduleModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Schedule Order Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('user.Schedule_Order')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Schedule Order body -->
               <div class="modal-body">
                  <input class="form-control date-picker" type="date" name="date" id="delivery_date" onkeypress="return false">
                  <input class="form-control mt-3 time-picker" type="text" name="time" id="delivery_time" onkeypress="return false">
               </div>
               <!-- Schedule Order footer -->
               <div class="modal-footer">
                  <a  class="btn btn-primary btn-block placeOrder" >@lang('user.Schedule_later') <i class="fa fa-clock-o" aria-hidden="true"></i></a>
               </div>
            </div>
         </div>
      </div>
      <!-- Schedule RiOrderde Modal -->
     
      <!-- Address Modal -->
      <!-- Address Modal -->
        
         <!-- Address Modal -->
      <div class="modal crud-modal" id="addressModal">
         <div class="modal-dialog min-50vw">
            <div class="modal-content password-change">
               <!-- Add Card Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('user.Add_Address')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button> 
               </div>
               <!-- Add Card body -->
               <div class="modal-body">
               <form id="address-form"  class="w-100 validateaddressForm" style= "color:red;">
                  <input type="hidden" name="id" id="address_id" value="0" />
                     <div class="col-lg-12 col-md-12 col-sm-12 card-section p-0 b-0" style= "flex-direction: row;align-items: start;">
                        <div class ="address-errors"></div>
                        <div class="col-sm-12 col-xl-12">
                           <span class="fa fa-location-arrow" style=" position: absolute; left: 20px; top: 11px;color: #495057;font-size: 18px;"></span>
                           <input class="form-control search-loc-form" type="text" id="pac-input" name="map_address" placeholder="Search for area, street name.." required>
                           <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly >
                           <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly >
                           <div id="my_map"   style="height:500px;width:100%; margin-top: 4px" ></div>
                           <span class="my_map_form_current"><i class="material-icons my_map_form_current" style=" position: absolute; right: 30px; top: 12px;color: #495057;font-size: 18px;cursor: pointer;">my_location</i> </span>
                        </div>
                        <div class="col-sm-12 col-xl-12 p-0 card-form">
                           <div class="col-sm-12 p-0">
                              <h5 class=""><strong>@lang('user.flat_no')</strong></h5>
                              <input name="flat_no" id="flat_no" required class="form-control" type="text" placeholder="@lang('user.flat_no')">
                           </div>
                           <div class="col-sm-12 p-0">
                              <h5 class=""><strong>@lang('user.street')</strong></h5>
                              <input name="street" id="street" required class="form-control" type="text" placeholder="@lang('user.street')">
                           </div>
                           <div class="col-sm-12 p-0">
                              <h5 class=""><strong>@lang('user.type')</strong></h5>
                              <select  name="address_type" id="address_type" class="form-control">
                                 <option value="Home">@lang('user.Home')</option>
                                 <option value="Work">@lang('user.Work')</option>
                                 <option value="Other">@lang('user.Other')</option>
                              </select>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                  <button type="submit"  class="btn btn-secondary  btn-block change-pswrd payment-method " >@lang('user.save')</button>
                  </div>
                  </form>
               </div>
               <!-- Add Card body -->
            </div>
         </div>
      </div>
      <!-- Addon Modal -->
      <div class="modal" id="myModal">
             <div class="modal-dialog">
                <div class="modal-content">
                   <!-- Addon Header -->
                   <div class="modal-header dis-end b-b">
                      <h4 class="modal-title  prod_title">Veg Extravaganza</h4>
                      <span class="prod_price">$19.99</span>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <!-- Addon body -->
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
                   <div class="modal-footer b-0  spidfoot">
                      <a id="add_cart"  class="btn btn-primary btn-block addons" ><span class=""></span>{{ __('Add') }}  <i class="fa fa-plus" aria-hidden="true"></i></a>
                   </div>
                </div>
             </div>
          </div>
      <!-- Addon Modal -->
      <!-- Address Modal -->
      <div class="content-box">
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
               <form method="post" action="#">
                  <div class="row">
                     <div class="col-sm-12 col-md-12 col-xl-8 margin-b-30 checkout-section">
                        <div class="menu-widget m-b-30 select-address" >
                           <div class=" white" id="popular1">
                           <div class="widget-heading" >
                              
                              <h3 class="widget-title text-dark dis-center">
                              <i class="material-icons text-dark ">location_on</i>@lang('store.user.Select_Address')
                              </h3>
                              <div class="clearfix"></div>
                           </div>
                              <div class="food-item white b-0">
                                 <div class="row m-0">
                                    <div class="rest-descr ">
                                       <div class="address-block b-0">
                                          <!-- <h5 >SAVED ADDRESSES</h5> -->
                                          <div class="flex-container  address_list">
                                             <div class="address-set col-sm-12 col-lg-5 col-xl-4 dis-ver-center green min-23vh" style="min-width: 100%;">
                                                <i class="material-icons address-category">location_on</i>
                                                <a class="btn btn-primary bg-white primary-color btn-block" data-toggle="modal" data-target="#addressModal">@lang('user.Add_New_Address') <i class="fa fa-plus" aria-hidden="true"></i></a>
                                             </div>
                                             <!-- <a class="btn btn-primary">View More</a> -->
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-sm-12 col-md-12 col-xl-4 bor-dashed pt-2 pb-2 cart-summary">
                        <h4 class="modal-title">@lang('store.user.Cart_Summary') </h4>
                        
                        <div class="cart-totals margin-b-20  checkout-data" id="rcart_list">
                           Loading.........................
                        </div>
                        <div class="cart-totals-fields">
                           <form  id="checkout_form">
                           <input type="hidden" name="promocode_id" id="promocode_id" />
                           <input type="hidden" name="promo_val" id="promo_val" />
                           <input type="hidden" name="user_address_id" id="delivery_address_id" value=""/>
                           <table class="table">
                              <tbody>
                                 <tr>
                                    <td>@lang('store.user.Items_Price')</td>
                                    <td><span class="tot_gross right"></span></td>
                                 </tr>
                                 <tr class="shop_offer_tr d-none">
                                    <td>@lang('store.user.Shop_Offer')</td>
                                    <td><span class="shop_offer right"></span></td>
                                 </tr>
                                 <tr>
                                    <td>@lang('store.user.Shop_GST')</td>
                                    <td><span class="shop_gst right"></span></td>
                                 </tr>
                                  <tr>
                                    <td>@lang('store.user.Shop_Package_Charge')</td>
                                    <td><span class="shop_pkg right"></span></td>
                                 </tr>
                                 <tr class="delivery_charges">
                                    <td class="others d-none" >@lang('store.user.Shipping_Handling')</td>
                                    <td class="food d-none">@lang('store.user.delivery_charge')</td>
                                    <td class="delivery_charge right">$0.00</td>
                                 </tr>
                                 <tr>
                                    <td class="dis-ver-center promocode  loadpromocode" >
                                       <img src="{{url('svg/coupon.svg')}}">
                                       <h5 class="c-pointer"><p id="promoTitle">@lang('store.user.apply_promocode')</p>
                                    </td>
                                    <td><a id="promoTitleRemove" style="cursor:pointer"><small>@lang('store.user.Remove')</small></a></h5></td>
                                 </tr>
                                 <tr class="d-none txt-green">
                                    <td>@lang('store.user.Promocode')</td>
                                    <td><span class="promocode_price right"></span></td>
                                 </tr>
                                 <tr class="my_wallet">
                                    <td>@lang('store.user.Use_Wallet') (<span class="uswalt"></span>) </td>
                                    <td class="right">
                                       <input type="checkbox" class="tuswalt" name="wallet" value="1" id="wallet"   />
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="pl-0 b-0">
                                       <select class="form-control w-140" name="payment_mode" id="payment_mode" >
                                          @if(Helper::checkPayment('cash'))
                                             <option value="CASH" selected>@lang('user.CASH')</option>
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
                                    </td>
                                 </tr>
                                 <tr class="mycard d-none">
                                    <td class="pl-0 b-0">
                                       <select class="form-control w-140" name="card_id" id="card_id" >
                                             <option value="" selected>@lang('user.No_Card_Available!')</option>
                                       </select>
                                       <span class="card_id_error" style="color:red"></span>
                                    </td>
                                 </tr>
                                 <tr>
                                    <td class="pl-0 b-0">
                                       <select class="form-control w-140" name="order_type" id="order_type" >
                                          <option value="DELIVERY" selected>@lang('store.user.DELIVERY')</option>
                                          <option value="TAKEAWAY" >@lang('store.user.TAKEAWAY')</option>
                                       </select>
                                    </td>
                                 </tr>

                                 <tr style="background: #FFF6F4; color: #BC6750; border: 1px solid #BC6750;">
                                    <td colspan="2"><label for="leave_at_door"><input id="leave_at_door" type="checkbox" name="leave_at_door" value="1" /> <b>{{ __('Leave order at door or gate') }}</b> <br>{{ __('Opt for no-contact delivery & our delivery executive will leave it at your door/gate (not applicable on COD orders)') }}</label></td>
                                 </tr>
                              </tbody>
                           </table>
<!--                            </form>
 -->                           <div class="widget-body green" >
                              <div class="price-wrap text-center">
                                 <i class="material-icons address-category">attach_money</i>
                                 <p class="txt-white">@lang('store.user.grand_total')</p>
                                 <h3 class="value txt-white"><strong class="Total">00</strong></h3>
                                 <!-- <p class="txt-white">Free Shipping</p> -->
                                 <?php 
                                 /*
                                 * <!-- <a  class="btn btn-primary bg-white primary-color scheduleorder">Schedule Order <i class="fa fa-clock-o" aria-hidden="true"></i></a> -->
                                 */
                                 ?>
                                 <div id="revoult_hide">
                                 <div class="checkout">
                                 <a id="placeOrder"  class="btn btn-primary bg-white primary-color placeOrder ">@lang('store.user.Place_Order') <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                                 <p id="msg"></p>
                                 </div></div>
                                
                              </div>
                           </div>
                          
                        </div>
                     </div>
                    
                  </div>
               </form>
                <div class="revoult_show" style="display:none; text-align:center">
                                <button id="pay-button" class="btn btn-secondary" >@lang('store.user.Click_Revolut_Pay')</button>
                            </div>
            </div>
         </div>
      </div>
      <!-- Coupon Modal -->
      <div class="modal" id="couponModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Coupon Header -->
               <div class="modal-header">
                  <h4 class="modal-title">@lang('store.user.Coupon_Code')</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Coupon body -->
               <div class="modal-body">
                  <div class="dis-row col-lg-12 col-md-12 col-sm-12 p-0 ">
                     <div class="col-sm-8">
                        <input type="hidden" id="applypromoid" />
                        <input class="form-control" type="text" id="applypromo" name="enter_promocode" placeholder="Enter Coupon Code">
                     </div>
                     <div class="col-sm-4">
                        <a  class="btn btn-primary applypromo" >@lang('store.user.Apply')</a>
                     </div>
                  </div>
                  <ul class="height50vh  list_promocode">
                     <li>@lang('store.user.No_Promocode_Available!')</li>
                  </ul>
               </div>
            </div>
         </div>
      </div>
      <!-- Coupon Modal -->
      <!--Footer Content Start-->
@stop
@section('scripts')
@parent
<script type="text/javascript">
var wallet_balance = getUserDetails().wallet_balance; 
if(wallet_balance<=0){
   $('.my_wallet').hide();
}
var promoavailable = [];
var currency = '';
var init = 0;
var addons = [];

$('select[name=payment_mode], select[name=order_type]').on('change', function() {
  leave_at_door();
});

leave_at_door();
loaduseraddress();

function leave_at_door() {
  if($('select[name=payment_mode]').val() !== 'CASH' && $('select[name=order_type]').val() == 'DELIVERY') {
    $('input[name=leave_at_door]').closest('tr').show();
    $('.mycard').show();
  } else {
    $('input[name=leave_at_door]').prop('checked', false);
    $('input[name=leave_at_door]').closest('tr').hide();
    $('.mycard').hide();
  }
}

function loaduseraddress(){
   $.ajax({
   url: getBaseUrl() + "/user/store/useraddress",
   type:"GET",
   processData: false,
   contentType: false,
   secure: false,
   headers: {
       Authorization: "Bearer " + getToken("user")
   },
   success: (data, textStatus, jqXHR) => {
      if((data.responseData).length != 0) { 
         var address_list = data.responseData;
          var address_saved ='<h5 >SAVED ADDRESSES</h5>';
          var del_address = '';
         $.each(address_list, function(i,val){
          address_saved +='<div class="address-set green  setaddr" data-lat="'+val.latitude+'" data-lng="'+val.longitude+'" data-loc="'+val.map_address+'">';
                  if(val.address_type=='Home'){
                     address_saved +='<i class="material-icons address-category">home</i>';
                  }else if(val.address_type=='Work'){
                     address_saved +='<i class="material-icons address-category">work</i>';
                  }else if(val.address_type=='Other'){
                     address_saved +='<i class="material-icons address-category">location_on</i>';
                  }
                     address_saved +='<div class="">\
                        <h5 class="">'+val.address_type+'</h5>\
                        <p >'+val.map_address+'</p>\
                     </div>\
                  </div>';

                  del_address+='<div class="address-set col-sm-12 col-lg-5 col-xl-4 green">\
                           <i class="material-icons address-category">'+val.address_type+'</i>\
                           <div class="">\
                              <h5 class="">'+val.address_type+'</h5>\
                              <p >'+val.map_address+'</p>\
                              <a class="btn btn-primary bg-white primary-color btn-block  add_delivery_address" data-id="'+val.id+'"  >Delivery Here <i class="fa " aria-hidden="true"></i></a>\
                           </div>\
                        </div>';
         });

         del_address+='<div class="address-set col-sm-12 col-lg-5 col-xl-4 dis-ver-center green min-23vh">\
                  <i class="material-icons address-category">location_on</i>\
                  <a class="btn btn-primary bg-white primary-color btn-block" data-toggle="modal" data-target="#addressModal">Add New Address <i class="fa fa-plus" aria-hidden="true"></i></a>\
               </div>';
         $('#address_saved').html(address_saved);
         $('.address_list').html(del_address);
      }

   }
   });
}
function loadpromocode(){
   $("#applypromo").val('');
   $.ajax({
   url: getBaseUrl() + "/user/store/promocodelist",
   type:"GET",
   processData: false,
   contentType: false,
   secure: false,
   headers: {
       Authorization: "Bearer " + getToken("user")
   },
   success: (data, textStatus, jqXHR) => {
      if((data.responseData).length != 0) { 
         var list_promocode = data.responseData;
         var list_promocodes = '';
         $.each(list_promocode, function(i,val){
          list_promocodes +='<li class="coupon-box" id="coupon'+val.id+'">\
                           <img rc='+val.picture+' style="height: 60px;margin: 38px;opacity: 1.1;">\
                           <span class="txt-primary coupon-text" id="'+val.id+'">'+val.promo_code+'</span>\
                           <p class="mt-2">'+val.promo_description+'</p>\
                           <small>Valid Till: '+val.expiration+'</small>\
                        </li>';
              
         });
         $('.list_promocode').html(list_promocodes);
      }

   }
   });
}
$('body').on('click','.coupon-box',function(e){
   var id = $(this).attr('id');
   var couponval = $('#'+id).children('.coupon-text').text();
   var couponvalid = $('#' + id).children('.coupon-text').attr('id');
   $("#applypromoid").val(couponvalid);
   $("#applypromo").val(couponval);
});
$('body').on('click','#promoTitleRemove',function(e){
   $('#promocode_id').val('');
   $("#promoTitle").text('Apply Promocode');
   $("#promoTitleRemove").addClass('d-none');
   // $(".promocode_price").closest('tr').addClass('d-none');
   loadcart();
});
$('body').on('change',"#order_type",function(e){
  
   loadcart();
});
$(document).ready(function()
{
   $("#promoTitleRemove").addClass('d-none');
   $(".promocode_price").closest('tr').addClass('d-none');
   $('#promocode_id').val('');
});
$('body').on('change','#order_type',function(e){
   loadcart();
});
loadcart();
function  loadcart(){      
      var search = '?';
        //var filter = '';
        //var qfilter = '';;
        //var filter =[];
         if($('#promocode_id').val()){
            search += '&promocode_id='+$('#promocode_id').val();
         }
         if($('#wallet').is(':checked')) {
            search += '&wallet=1'
         }else{
           search += '&wallet=0'
         }
         if($('#order_type').val()){
            search += '&order_type='+$('#order_type').val();
        }
        if($('#delivery_address_id').val()){
           search += '&user_address_id='+$('#delivery_address_id').val();
        }
        /*$.each($("input[name='filter']:checked"), function(){            
                search += '&filter='+$(this).val();
        });
         if(typeof localStorage.latitude !== 'undefined') {
            search +='&latitude='+window.localStorage.getItem('latitude');
         }
         if(typeof localStorage.longitude !== 'undefined') {
            search +='&longitude='+window.localStorage.getItem('longitude');
         }*/

   $.ajax({
         url: getBaseUrl() + "/user/store/cartlist"+search,
         type:"GET",
         processData: false,
         contentType: false,
         secure: false,
         headers: {
             Authorization: "Bearer " + getToken("user")
         },
         beforeSend: function() {
            showLoader();
         },
         success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
               var cart_list = data.responseData;
               //currency = cart_list.carts[0].store.currency_symbol;
               $('.cart_tot').html((cart_list.carts).length);
               var cartlist ='';
               $('.chk_url').attr('href',"{{url('/store/checkout/')}}/"+cart_list.store_id);
              if(cart_list.store_type=='FOOD'){
                $('.food').removeClass('d-none');
                $('.others').addClass('d-none');
              }else{
                  $('.food').addClass('d-none');
                  $('.others').removeClass('d-none');
              }
              var available = 1;
               $.each(cart_list.carts, function(i,val){

                currency = val.store.currency_symbol;
                cartlist +='<ul '; 
                if(val.product.status == 0){
                  cartlist +='style="background:#ccc" ';
                  } 
                  cartlist +='class="list-inline col-md-12 order-row row p-0">\
                    <li class="list-inline-item col-md-12 p-0">\
                      <h5 class="price"><span style="padding-left: 10px;" >'+val.product.item_name+'</span> <span style="padding-left: 10px; float: right; font-weight: 100" >'+val.item_quantity + ' ' + val.unit+'</span>';
                      if(val.product.status == 0){
                       cartlist +='<a class="float: right; text-align: right !important; clear: both; margin-left: 10px;" id="cart-el-remove" data-cart_id="'+val.id+'" href="javascript:void(0)"><i style="font-size: 32px !important; " class="fa fa-times-circle font-16 primary-color c-pointer"></i></a> ';
                      }
                       cartlist +='</h5><p style=" padding-left: 10px; "  class="txt-color1 m-0">'+(val.product.status == 1 ? currency+val.product.item_price : 'Item not available' )+'</p>';
                    if((val.cartaddon).length>0){
                     cartlist +='<a class="text-color c-pointer item-with-addon" data-cartid="'+val.id+'" data-id="'+val.store_item_id+'" data-spid="111" >Customize <i class="fa fa-cogs" aria-hidden="true"></i></a>';
                  }
                   if(val.product.status == 0){
                        available = 0;

                      }
                    cartlist +='</li>';
                  if(val.product.status == 1){
                     cartlist +='<li class="list-inline-item quantity col-md-7 p-0 d-flex justify-content-center">\
                       <span class="add  eminus"  data-id="'+val.store_item_id+'"  data-cat_id="'+val.id+'"  value="-" id="moins" >-</span>\
                       <input class="form-control text-center  qty_prod_'+val.store_item_id+'" min="1" readonly type="input" size="25" value="'+val.quantity+'" id="count_'+val.store_item_id+'">\
                       <span class="minus  eplus" data-id="'+val.store_item_id+'" data-cat_id="'+val.id+'"  value="+"  id="plus" >+</span>\
                    </li>\
                    <li class="list-inline-item col-md-4 p-0 d-flex justify-content-end">\
                       <h5 class="price ">'+currency+val.total_item_price+'</h5>\
                    </li>';
                    }
                 cartlist +='</ul>';
               }); 
               var show_gross = currency+cart_list.total_item_price.toFixed(2);
               var show_offer = currency+cart_list.shop_discount.toFixed(2);
               var show_gst = currency+cart_list.shop_gst_amount.toFixed(2);
               if(cart_list.delivery_charges != null)
               {
                var show_delivery = currency+cart_list.delivery_charges.toFixed(2);
                $('.delivery_charges').show();
                $('.delivery_charge').html(show_delivery);
               }
               else{
                $('.delivery_charges').hide();
               }
               var show_total = currency+cart_list.payable.toFixed(2);
               var show_promoid = cart_list.promocode_id;
               var show_promo = currency+cart_list.promocode_amount.toFixed(2);
               $('#rcart_list').html(cartlist);
               
                if(available == 0)
                {
                  $('.checkout').hide();
                }
                else
                {
                  $('.checkout').show();
                }
               $('.tot_gross').html(show_gross);
               $('.shop_offer').html(show_offer);
               $('.shop_gst').html(show_gst);
               $('.shop_pkg').html(currency+cart_list.shop_package_charge.toFixed(2));
               if(cart_list.user_wallet_balance<=0){ 
                  $('.tuswalt').prop('disabled',true);
               }
               $('.uswalt').html(currency+cart_list.user_wallet_balance);
               $('.promocode_price').html(show_promo);
               if(show_promoid != 0){
                  $(".promocode_price").closest('tr').removeClass('d-none');
               }
               $('.Total').html(show_total);
               
               if(cart_list.shop_discount>0){ 
                  $('.shop_offer_tr').removeClass('d-none');
                  $('.shop_offer').html(currency+cart_list.shop_discount.toFixed(2));
               }
               if(cart_list.delivery_charges>0){
                  $('.freeship').addClass('d-none')
               }

            }
            hideLoader();
         }
        });
}
function showAddons(cart_id,spid){
        $.ajax({
        url: getBaseUrl() + "/user/store/cart-addons/"+cart_id,
        type:"GET",
        processData: false,
        contentType: false,
        secure: false,
        headers: {
              Authorization: "Bearer " + getToken("user")
        },
        success: (data, textStatus, jqXHR) => {
            if((data.responseData).length != 0) { 
                $('.prod_addon_list').html('');
                var item_data = data.responseData;
                $('.prod_title').html(item_data.item_name);
                $('.prod_price').html(currency+item_data.item_price);
                var itemcartaddon = item_data.itemcartaddon;
                $.each(item_data.itemsaddon,function(key,item){
                  if(item.id == itemcartaddon[item.id]){ 
                    var chk = "checked";
                    var addon_obj = '<span class="check-box mt-2"><input type="checkbox" name="addon[]" id="addon-'+item.id+'" disabled value="'+item.id+'"  '+chk+' ><label for="addon-'+item.id+'" class="mr-2">'+item.addon_name+'</label>'+currency+item.price+'</span>';
                  }else{
                    var chk = '';
                  }
                  
                  $('.prod_addon_list').append(addon_obj);
                });
                 
                 if(spid==111){
                  $('.spidfoot').hide();
                 }else{
                  $('.spidfoot').show();
                 }
               $('#myModal').modal('show');
            }else{
                 
            }
        }
      });
}
$('body').on('click','.scheduleorder',function(e){
      if($('#delivery_address_id').val()){
         $('#scheduleModal').modal('show');
      }else{
         $('#msg').html('The user address  is required.');
      }
});
$('body').on('click','.item-with-addon',function(e){
      addons = [];
      var item_id = $(this).data('id');
      var cart_id = $(this).attr('data-cartid');
      var spid = $(this).data('spid');
       $('.addons').data('id',item_id);
      if(spid>0){
        showAddons(cart_id, spid);
      }else{
        $('#warnModal').modal('show');
        $('.item-fresh-cart').data('id',item_id);
        $('.item-nofresh').data('id',item_id);
      }
});
$('body').on('click','.loadpromocode',function(){
   loadpromocode();
   $('#couponModal').modal('show');
});
$('body').on('click','.applypromo',function(){
   if($('#applypromo').val()){
      var promoval = $('#applypromo').val();
      var promoval_id = $('#applypromoid').val();
      $('#promocode_id').val(promoval_id);
      $("#promoTitle").text('Promocode Applied ' + promoval);
      $("#promoTitleRemove").removeClass('d-none');
      loadcart();
      $('#couponModal').modal('hide');
   }else{

   }
});
$('body').on('click','.eplus',function(e){
   var prod_id = $(this).data('id');
   var cart_id = $(this).data('cat_id');
   var elm = $(this).prev(".qty_prod_"+prod_id);
   var qty = elm.val(); 
   // $(".qty_prod_"+prod_id).val(parseInt(qty)+1);
   qty = parseInt(qty) + 1;
   addcart(prod_id, cart_id, qty, 'repeat');
   loadcart();
});
$('body').on('click','.eminus',function(e){
   var prod_id = $(this).data('id');
   var cart_id = $(this).data('cat_id');
   var elm = $(this).next(".qty_prod_"+prod_id);
   var qty = elm.val();
   if(qty>1){
      // $(".qty_prod_"+prod_id).val(parseInt(qty)-1);
      qty = parseInt(qty) - 1;
      addcart(prod_id, cart_id, qty, 'repeat');
      loadcart();
   }
});
$('body').on('click','.add_delivery_address',function(e){
   var address_id = $(this).data('id');
   $('.add_delivery_address i').removeClass('fa-check-circle');
   $(this).find('i').addClass('fa-check-circle');
   $('#delivery_address_id').val(address_id);
   loadcart();
});

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

      var payment =$('#payment_mode').val();
      usercard(payment);
     function usercard(payment){
        if(payment == "CARD") {
               $('.mycard').removeClass('d-none');
            } else {
               var mycard ='<option value="">No Card Available</option>';
               $('#card_id').html(mycard);
               $('.mycard').addClass('d-none');
            }
     }

$('body').on('change','#payment_mode',function(e){ 
    var card_val = $(this).val(); 
    if(card_val=='CARD'){
      usercard(card_val);
    }
})

$('body').on('click','#cart-el-remove',function(e){
  var cart_id = $(this).data('cart_id'); 
  removecart(cart_id);
  
});

function removecart(cart_id){
    var data = new FormData();
    data.append( 'cart_id', cart_id );
    $.ajax({
     url: getBaseUrl() + "/user/store/removecart",
     type:"POST",
     processData: false,
     contentType: false,
     secure: false,
     data:data,
     headers: {
         Authorization: "Bearer " + getToken("user")
     },
     success: (data, textStatus, jqXHR) => {
     loadcart();
       }
    })
}

function addcart(prod_id, cart_id, qty, type){
      var cartQty = parseInt($('.cart_tot').html());
      var orderConfig = '{{Helper::getSettings()->order->max_items_in_order}}';
      var newQty = qty + cartQty;            
      if(newQty > orderConfig){
         hideLoader();
      }
      addons = [];
      var data = new FormData();
      data.append( 'item_id', prod_id );
      data.append( 'cart_id', cart_id );
      data.append( 'qty', qty );
      data.append( 'addons', addons );
      data.append('customize', 0);
      (type == 'repeat') ? data.append('repeat', 1) : data.append('repeat', 0);
      $.ajax({
         url: getBaseUrl() + "/user/store/addcart",
         type:"POST",
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
         success: (data, textStatus, jqXHR) => {
               loadcart();
               hideLoader();
         },
         error: (jqXHR, textStatus, errorThrown) => {
               hideLoader();
         }
      })
}
$('body').on('click','.placeOrder',function(){
      var data = new FormData();
      var prod_id = $('#promocode_id').val();
       var order_type = $('#order_type').val();
      var card_id = $('#card_id').val();
      if($('#wallet').is(':checked')) {
         var wallet = 1;
      }else{
         var wallet = '';
      }

      if($('#delivery_date').val()) {

         var delivery_date = $('#delivery_date').val()+$('#delivery_time').val();

      }else{
         var delivery_date = '';
      }
var user_address_id = $('#delivery_address_id').val();
       if(order_type=="DELIVERY"){ 

        if(user_address_id ==''){
          
          var msg ="Please Select Delivery Address";
          $('#msg').html(msg);

          return false;
        }
      }
      
      var payment_mode = $('#payment_mode').val();
      if(payment_mode=="CARD"){ 
        if(card_id==''){
          var msg ="Card is Required!. Add/Choose Card.";
          $('.card_id_error').html(msg);

          return false;
        }else{
          $('.card_id_error').html('');
        }
      }else{
        $('.card_id_error').html('');
      }
      
      data.append( 'promocode_id', prod_id );
      data.append( 'wallet', wallet );
      data.append( 'payment_mode', payment_mode );
      data.append( 'user_address_id', user_address_id );
      data.append( 'delivery_date', delivery_date );
      data.append( 'order_type', order_type );
      data.append( 'card_id', card_id );
      data.append( 'leave_at_door', $('input[name=leave_at_door]:checked').val() ? 1 : 0 );
      $.ajax({
       url: getBaseUrl() + "/user/store/checkout",
       type:"POST",
       processData: false,
       contentType: false,
       cache: false,
       data:data,
       headers: {
           Authorization: "Bearer " + getToken("user")
       },
      beforeSend: function() {
         showLoader();
      },
      success: (data, textStatus, jqXHR) => { 
         var data = parseData(data);
            var order = data.responseData;
         if((data.responseData).length != 0) { 
            if(data.responseData.invoice && data.responseData.invoice.payment_mode == 'CASH') {
               location.href="{{url('store/order')}}/"+order.id;
            } else if(data.responseData.payment_mode == 'paypal' && data.responseData.url) {
               location.assign(data.responseData.url);
            }else if(data.responseData.payment_mode == 'NOWPAYMENT' && data.responseData.url) {
               location.assign(data.responseData.url);
            }else if(data.responseData.payment_mode == 'REVOLUT' && data.responseData.data.public_id) {
               hideLoader();
               $('#revoult_hide').hide();
               $('.revoult_show').show();
               RevolutCheckout(data.responseData.data.public_id,'sandbox').then(function (RC) {
                  var payButton = document.getElementById("pay-button");
                  // On click open payment pop-up
                  payButton.addEventListener("click", function () {
                     RC.payWithPopup({
                     // (mandatory!) name of the cardholder
                     // name: "First Last",
                     
                     // Callback called when payment finished successfully
                     onSuccess() {
                           revoult_success(data.responseData.data.id,data.responseData.data.merchant_order_ext_ref);
                        // window.alert("Thank you!");

                     },
                     // Callback in case some error happened
                     onError(message) {
                        window.alert("Oh no :(");
                     },
                     // (optional) Callback in case user cancelled a transaction
                     onCancel() {
                        window.alert("Payment cancelled!");
                     },
                     });
                  });
               });

            }
            else if((data.responseData).length != 0){
               var order = data.responseData;
               location.href="{{url('/store/order')}}/"+order.id;
            }
         } else {
            hideLoader();
            alertMessage('Error', data.responseData.message, "danger");
         }
         // if((data.responseData).length != 0) { 
         //       var order = data.responseData;
         //       location.href="{{url('/store/order')}}/"+order.id;
         // }
         // hideLoader();
      },
      error: (jqXHR, textStatus, errorThrown) => {
        hideLoader();
        if(jqXHR.responseJSON) alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
     }
      })
});
function revoult_success(id,merchant_order_ext_ref){
       
         $.ajax({
                type:'GET',
                // url: getBaseUrl() + "/user/wallet/revoult_success/"+id+"/"+merchant_order_ext_ref,
                url: getBaseUrl() + "/user/wallet/revoult_success?id="+id+"&merchant_order_ext_ref="+merchant_order_ext_ref,

               // data: id,
                processData: false,
                contentType: false,
                headers: {
                   Authorization: "Bearer " + getToken("user")
                },
                success:function(data){
                    var data = parseData(data);
                    alertMessage("Success", data.message, "Order Created !!");
                    location.href="{{url('store/order')}}/"+data.responseData.id;

                   // location.reload();
                }, 
                error: function(jqXHR, textStatus, errorThrown) {
                        
                        if (jqXHR.status == 401 && getToken(guard) != null) {
                           refreshToken(guard);
                        } else if (jqXHR.status == 401) {
                           window.location.replace("/login");
                        }
                        if (jqXHR.responseJSON) {
                           
                           alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                        }
                        hideInlineLoader();
                  } 
            });
    }
$(document).ready(function()
{
   $(".promocode_price").closest('tr').addClass('d-none');
   $('#promocode_id').val('');
   $("#flat_no").val('');
         $("#street").val('');
         $("#address_type").val('');
         $("#pac-input").val('');
     basicFunctions();
 //address addd
    $('.validateaddressForm').validate({
         errorElement: 'span', //default input error message container
         errorClass: 'help-block', // default input error message class
         focusInvalid: false, // do not focus the last invalid input
         rules: {
               map_address: { required: true },
               latitude: { required:true },
               longitude: { required:true },
               address_type:{ required:true },
               flat_no:{ required:true},
               street:{ required:true}

         },
         messages: {
            map_address: { required: "choose one address" },
            latitude: { required: "address is required." },
            longitude: { required: "address is required." },
            address_type:{ required:"address type is required" },
            flat_no:{ required:"Flat Number is required"},
            street:{ required:"Street is required"}
         },
         highlight: function(element)
         {
            $(element).closest('.form-group').addClass('has-error');
         },
         success: function(label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
         },
         submitHandler: function(form) {
         var formGroup = $(".validateaddressForm").serialize().split("&");
         var data1 = new FormData();
         
         for(var i in formGroup) {
            var params = formGroup[i].split("=");
            data1.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
         }
         var url = getBaseUrl() + "/user/address/add";
         showLoader();
         saveRow( url, null, data1, "user");
         $("#flat_no").val('');
         $("#street").val('');
         $("#address_type").val('');
         $("#pac-input").val('');
         loaduseraddress();
         hideLoader();
      }
    });
});
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

        var userLocation = new google.maps.LatLng(
                13.066239,
                80.274816
            );
        
        map = new google.maps.Map(document.getElementById('my_map'), {
            center: userLocation,
            zoom: 15
        });

        var service = new google.maps.places.PlacesService(map);
        var autocomplete = new google.maps.places.Autocomplete(input);
        var infowindow = new google.maps.InfoWindow();

        autocomplete.bindTo('bounds', map);

        /*var infowindow = new google.maps.InfoWindow({
            content: "Shop Location",
        });*/

        var marker = new google.maps.Marker({
            map: map,
            draggable: true,
            anchorPoint: new google.maps.Point(0, -29)
        });

        marker.setVisible(true);
        marker.setPosition(userLocation);
        //infowindow.open(map, marker);

        if (navigator.geolocation) { 
            navigator.geolocation.getCurrentPosition(function(location) { 
                var userLocation = new google.maps.LatLng(
                    location.coords.latitude,
                    location.coords.longitude
                );
            });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }

        google.maps.event.addListener(map, 'click', updateMarker);
        google.maps.event.addListener(marker, 'dragend', updateMarker);

       

        function updateMarker(event) {
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': event.latLng}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        input.value = results[0].formatted_address;
                        updateForm(event.latLng.lat(), event.latLng.lng(), results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });

            marker.setPosition(event.latLng);
            map.setCenter(event.latLng);
        }

        autocomplete.addListener('place_changed', function(event) {
            marker.setVisible(false);
            var place = autocomplete.getPlace();

            if (place.hasOwnProperty('place_id')) {
                if (!place.geometry) {
                    window.alert("Autocomplete's returned place contains no geometry");
                    return;
                }
                updateLocation(place.geometry.location);
            } else {
                service.textSearch({
                    query: place.name
                }, function(results, status) {
                    if (status == google.maps.places.PlacesServiceStatus.OK) {
                        updateLocation(results[0].geometry.location, results[0].formatted_address);
                        input.value = results[0].formatted_address;

                    }
                });
            }
        });

        function updateLocation(location) {
            map.setCenter(location);
            marker.setPosition(location);
            marker.setVisible(true);
            //infowindow.open(map, marker);
            updateForm(location.lat(), location.lng(), input.value);
        }
    }

      function getcustomaddress(latLngvar){
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'latLng': latLngvar}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    //console.log(results[0]);
                    if (results[0]) {
                        
                        //input_cur.value = results[0].formatted_address;
                         
                        updateForm(latLngvar.lat, latLngvar.lng, results[0].formatted_address);
                    } else {
                        alert('No Address Found');
                    }
                } else {
                    alert('Geocoder failed due to: ' + status);
                }
            });
      }

        function updateForm(lat, lng, addr) { 
            //console.log(lat,lng, addr);
            latitude.value = lat;
            longitude.value = lng;
            var address = addr;
            var landmark = address.split(',')[0];
            var city = address.replace(address.split(',')[0]+',',' ');
            $('#pac-input').val(addr);
           /* window.localStorage.setItem('landmark', landmark);
            window.localStorage.setItem('city', city);
            window.localStorage.setItem('latitude', lat);
            window.localStorage.setItem('longitude', lng);*/
            $('.landmark').html(landmark);
            $('.city').html(city);
            //shoplist();
        }
    $('.my_map_form_current').on('click',function(){
        //$('#my_map_form_current').submit();
        var current_latitude = 13.0574400;
       var current_longitude = 80.2482605;

       if( navigator.geolocation ) {
          navigator.geolocation.getCurrentPosition( success, fail );
       } else {
           console.log('Sorry, your browser does not support geolocation services');
           initMap();
       }
       function success(position)
       {
           document.getElementById('longitude').value = position.coords.longitude;
           document.getElementById('latitude').value = position.coords.latitude

           if(position.coords.longitude != "" && position.coords.latitude != ""){
               longitude = position.coords.longitude;
               latitude = position.coords.latitude;
                var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
                getcustomaddress(latlng);

           }
       }
       function fail()
       {
           // Could not obtain location
           console.log('unable to get your location');
       }

    });

</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{Helper::getSettings()->site->browser_key}}&libraries=places&callback=initMap" async defer></script>
@stop