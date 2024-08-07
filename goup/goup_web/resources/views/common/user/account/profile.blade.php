@extends('common.user.layout.base')
{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
@section('styles')
@parent
<link rel="stylesheet"  type='text/css' href="{{ asset('assets/plugins/cropper/css/cropper.css')}}" />
<style type="text/css">
  .pac-container{
    z-index: 999999999!important;
  }
  .btn-icons {
           border-color: rgba(151, 151, 151, 0.25) !important;
    border: 1px dashed #eaebeb;
    border-radius: 4px !important;
    min-height: 43px;
  }
 
</style>
@stop
@php

   $paymentConfig = json_decode( json_encode( Helper::getSettings()->payment ) , true);
   $cardObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'card'; }));
   //print_r($cardObject);exit;
   $card = 0;

   $stripe_publishable_key = "";

   if(count($cardObject) > 0) { 
      $card = $cardObject[0]['status'];

      $stripePublishableObject = array_values(array_filter( $cardObject[0]['credentials'], function ($e) { return $e['name'] == 'stripe_publishable_key'; }));


      if(count($stripePublishableObject) > 0) {
            $stripe_publishable_key = $stripePublishableObject[0]['value'];
      }
   }

@endphp
@section('content')
@include('common.user.includes.image-modal')
<section class="z-1 content-box" id="profile-form">
   <div class="profile-section">
      <div class="dis-center col-md-12 p-0 dis-center">
         <ul class="nav nav-tabs " role="tablist">
            <li class="nav-item">
               <a class="nav-link active general" data-toggle="tab" href="#general_info" role="tab" data-toggle="tab">@lang('user.profile.general_information')</a>
            </li>
            <li class="nav-item">
               <a class="nav-link password" data-toggle="tab" href="#password" role="tab" data-toggle="tab">@lang('user.profile.change_password')</a>
            </li>
            @if($card==1)
            <li class="nav-item">
               <a class="nav-link payment-method payment_method" data-toggle="tab" href="#payment_method" role="tab" data-toggle="tab">@lang('user.payment_method')</a>
            </li>
            @endif
            <li class="nav-item">
               <a class="nav-link payment-method alladdress" data-toggle="tab" href="#user_address" role="tab" data-toggle="tab">@lang('user.address')</a>
            </li>
         </ul>
      </div>
      <div class="clearfix tab-content">
         <div id="toaster" class="toaster">
         </div>
         <div role="tabpanel" class="tab-pane active col-sm-12 col-md-12 col-lg-12 p-0" id="general_info">
            <div class="col-md-12">
               <div class="profile-content">
                  <div class="row m-0">
                     <form class="w-100 validateForm" style= "color:red;">
                        <div class="col-md-12 col-sm-12 pro-form dis-ver-center p-0">
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.profile_picture')</strong></h5>
                              <div class="photo-section">
                                 <img class = "user-img" height ="200px;" width ="200px;" />
                                 <div class="fileUpload up-btn profile-up-btn">
                                    <input type="file" id="profile_img_upload_btn" name="picture" class="upload" accept="image/x-png, image/jpeg">
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-6 col-lg-4 col-sm-12 p-1 m-3">
                              <div class=" top small-box green">
                                 <div class="left">
                                    <h2>@lang('user.profile.wallet_balance')</h2>
                                    <h4><i class="material-icons">account_balance_wallet</i></h4>
                                    <h1 class="account_balance_wallet"></h1>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12 col-sm-12 pro-form dis-ver-center p-0">
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.first_name')</strong></h5>
                              <input class="form-control" type="text" id ="first_name" name="first_name" placeholder="@lang('user.profile.first_name')">
                           </div>
                           <div class="col-md-6 col-sm-12">
                              <h5 class=" no-padding"><strong>@lang('user.profile.last_name')</strong></h5>
                              <input class="form-control" type="text" id ="last_name" name="last_name" placeholder="@lang('user.profile.last_name')">
                           </div>
                        </div>
                        <div class="col-md-12 pro-form dis-ver-center p-0">
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.email')</strong></h5>
                              <input class="form-control" type="email" id ="profile_email" name="email" placeholder="@lang('user.profile.email')">
                           </div>
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.mobile')</strong></h5>
                              <div class="input-group">
                                 <input class="form-control numbers" type="text" id ="mobile" name="mobile" placeholder="@lang('user.profile.mobile')" readonly>
                                 <input type="hidden" class="mobile_number" value="">
                                 <input type="hidden" class="country_code" value=""> 
                                 <div class="input-group-prepend mt-2 profie-edit-btn btn-icons">
                                    <i class="fa fa-edit  user_edit input-group-text pt-3" ></i>
                                    <i class="fa fa-check-square-o user_update input-group-text pt-3" ></i>
                                    
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-12 pro-form dis-ver-center p-0 otp d-none">
                           <div class="col-md-6 col-sm-12">
                              
                           </div>
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.otp')</strong></h5>
                              <input class="form-control numbers" type="text" id ="otp" placeholder="@lang('user.profile.otp')">
                              <span>
                              <i class="fa fa-check verify_otp" style=" position: absolute; right: 5%; top: 61%;color: #495057;font-size: 18px;cursor: pointer;"></i>
                              </span>
                           </div>
                        </div>
                        <div class="col-md-12 pro-form dis-ver-center p-0">
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.country')</strong></h5>
                              <select id="country" name="country_id"  class=" mb-4 form-control">
                                 <option value="">@lang('user.profile.select_country')</option>
                              </select>
                           </div>
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.city')</strong></h5>
                              <select id="city" name="city_id" @if(Helper::getDemomode() == 1) disabled="disabled" @endif  class=" mb-4 form-control">
                                 <option value="">@lang('user.profile.select_city')</option>
                              </select>
                           </div>
                        </div>
                        <div class="col-md-12 pro-form dis-ver-center p-0">
                           <div class="col-md-6 col-sm-12">
                              <h5 class=""><strong>@lang('user.profile.language')</strong></h5>
                              <select class="form-control" name="language" id="language" @if(Helper::getDemomode() == 1) disabled="true" @endif>
                                 @foreach(Helper::getSettings()->site->language as $language)
                                 <option value="{{$language->key}}">{{$language->name}}</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>
                        <button type="submit"  class="btn btn-secondary edit-profile mt-5 save" >@lang('user.save')</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0" id="password">
            <div class="col-md-12">
               <div class="profile-content">
                  @if(Helper::getDemomode() == 1)
                  <div class="alert alert-danger">
                     
                        <p>** Demo Mode : {{ __('admin.demomode') }}</p>
                        <span class="pull-left">(*personal information hidden in demo)</span>
                        
                  </div>
                  @endif
                  <div class="row m-0">
                     <form class="w-100 validatepasswordForm" style= "color:red;">
                        <div class="col-md-12 pro-form p-0">
                           <div class="col-md-6">
                              <h5 class=""><strong>@lang('user.profile.old_password')</strong></h5>
                              <input class="form-control" type="password" name="old_password" placeholder="Old Password">
                           </div>
                        </div>
                        <div class="col-md-12 pro-form p-0">
                           <div class="col-md-6">
                              <h5 class=""><strong>@lang('user.profile.new_password')</strong></h5>
                              <input class="form-control"  id="password1" type="password" name="password" placeholder="Password">
                           </div>
                        </div>
                        <div class="col-md-12 pro-form p-0">
                           <div class="col-md-6">
                              <h5 class=""><strong>@lang('user.profile.confirm_password')</strong></h5>
                              <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                           </div>
                        </div>
                        <button type="submit" class="btn btn-secondary change-pswrd mt-5" >@lang('user.save')</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
         @if($card==1)
         <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0  min-46vh" id="payment_method">
            <div class="row dis-column payment">
               <div class="col-lg-12 col-md-12 col-sm-12 p-0 ">
                  <h5 class="mb-2 mt-2 ml-4"><strong>@lang('user.add_card')</strong></h5>
               </div>
               <div class=" col-lg-12 col-md-12 col-sm-12 p-0 dis-ver-center flex-wrap">
                  <!-- For add credit card added!-->
                  <!-- Card details!-->
                  <div id="card_container" class=" dis-column  ml-3 mr-3" data-toggle="modal" data-target="#add_card">
                     <div class="add-card">
                        <div class="add-img">
                           <img src="{{asset('assets/layout/images/common/svg/add.svg')}}">
                        </div>
                     </div>
                  </div>
                  <!-- Add Card Modal -->
                  <div class="modal fade bs-modal-lg crud-modal" id="add_card">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content ">
                           <!-- Add Card Header -->
                           <div class="modal-header">
                              <h4 class="modal-title">@lang('user.add_card')</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <!-- Add Card body -->
                           <div class="modal-body">
                              <form id="payment-form"  class="w-100 validatepaymentForm" style= "color:red;">
                                 <div class="row card-section p-0 b-0">
                                    <div class ="payment-errors"></div>
                                    <div class="row card-form">
                                       <div class="col-sm-12">
                                          <h5 class=""><strong>@lang('user.card.fullname')</strong></h5>
                                          <input data-stripe="name" autocomplete="off" required class="form-control" type="text" placeholder="@lang('user.card.fullname')">
                                       </div>
                                       <div class="col-sm-12">
                                          <h5 class=""><strong>@lang('user.card.card_no')</strong></h5>
                                          <input class="form-control numbers" type="text"  data-stripe="number" required autocomplete="off" maxlength="16" placeholder="@lang('user.card.card_no')" >
                                       </div>
                                          <div class="col-4">
                                             <h5 class=""><strong>@lang('user.card.month')</strong></h5>
                                             <input class="form-control numbers" type="text" maxlength="2" required autocomplete="off" data-stripe="exp-month" class="form-control" placeholder="MM">
                                          </div>
                                          <div class="col-4">
                                             <h5 class=""><strong>@lang('user.card.year')</strong></h5>
                                             <input class="form-control numbers" type="text"  maxlength="2" required autocomplete="off" data-stripe="exp-year" class="form-control"  placeholder="YY">
                                          </div>
                                          <div class="col-4">
                                             <h5 class=""><strong>@lang('user.card.cvv')</strong></h5>
                                             <input class="form-control numbers" type="text" data-stripe="cvc"  required autocomplete="off" maxlength="4"  placeholder="@lang('user.card.cvv')">
                                          </div>
                                    </div>
                                 </div>
                                 @if(Helper::getDemomode() == 0)
                                 <div class="modal-footer">
                                    <button type="submit"  class="btn btn-secondary  btn-block change-pswrd payment-method" >@lang('user.save')</button>
                                 </div>
                                 @endif
                              </form>
                           </div>
                           <!-- Add Card body -->
                        </div>
                     </div>
                  </div>
                  <!-- Add Card Modal -->
               </div>
            </div>
         </div>
         @endif
         <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0  min-46vh" id="user_address">
            <div class="row dis-column">
               <div class="col-lg-12 col-md-12 col-sm-12 p-0 ">
                  <h5 class="m-4"><strong>@lang('user.address')</strong></h5>
                  <!-- <div class="money-img">
                     <img src="{{asset('assets/layout/images/common/svg/money.svg')}}">
                     </div> -->
               </div>
               <div class=" col-lg-12 col-md-12 col-sm-12 p-0 dis-ver-center flex-wrap address_container">
                  <!-- For add credit card added!-->
                  <!-- address  details!-->
               </div>
                  <!-- Add Address Modal -->
                  <div class="modal fade bs-modal-lg crud-modal" id="add_address" >
                     <div class="modal-dialog min-50vw">
                        <div class="modal-content password-change">
                           <!-- Add Card Header -->
                           <div class="modal-header">
                              <h4 class="modal-title">@lang('user.address')</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                           </div>
                           <!-- Add Card body -->
                           <div class="modal-body">
                              <form id="address-form"  class="w-100 validateaddressForm" style= "color:red;">
                                 <input type="hidden" name="id" id="address_id" value="0" />
                                 <!-- <div class="col-lg-12 col-md-12 col-sm-12 card-section p-0 b-0" style= "flex-direction: row;align-items: start;"> -->
                                    <div class="row">
                                       <div class ="address-errors"></div>
                                       <div class="col-sm-12 col-xl-6">
                                          <span class="fa fa-location-arrow" style=" position: absolute; left: 20px; top: 25px;color: #495057;font-size: 18px;"></span>
                                          <input class="form-control search-loc-form" type="text" id="pac-input" name="map_address" placeholder="Search for area, street name.." required>
                                          <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude') }}" readonly >
                                          <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude') }}" readonly >
                                          <div id="my_map"   style="height:500px;width:100%;" ></div>
                                          <span class="my_map_form_current"><i class="material-icons my_map_form_current" style=" position: absolute; right: 15px; top: 25px;color: #495057;font-size: 18px;cursor: pointer;">my_location</i> </span>
                                       </div>
                                       <div class="col-sm-12 col-xl-6  card-form">
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
                                 <!-- </div> -->
                           </div>
                           <div class="modal-footer">
                           <button type="submit"  class="btn btn-secondary  btn-block change-pswrd payment-method " >@lang('user.save')</button>
                           </div>
                           </form>
                        </div>
                        <!-- Add Card body -->
                     </div>
                  </div>
               <!-- Add Address Modal -->
            </div>
         </div>
      </div>
   </div>
   </div>
</section>


<!-- Status Modal -->

<div class="modal fade bs-modal-lg confirm-modal" tabindex="-1" role="basic" aria-hidden="true" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">@lang('user.confirm_changes')</h4>
         </div>
         <div class="modal-body p-2">
            <center>@lang('user.are_u_sure')</center>
            </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('user.close')</button>
            <button type="button" class="btn btn-danger delete-modal-btn">@lang('user.delete')</button>
         </div>
      </div>
      <!-- /.modal-content -->
   </div>
   <!-- /.modal-dialog -->
</div>

<!-- End Modal -->

@stop
@section('scripts')
@parent
<script type="text/javascript" src="{{ asset('assets/plugins/iscroll/js/scrolloverflow.min.js')}}"></script>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script src = "{{ asset('assets/plugins/cropper/js/cropper.js')}}" > </script> 
<script src = "{{ asset('assets/layout/js/crop.js')}}" > </script> 
<script>
$('.'+'{{$type}}').trigger('click');   
$('#country').attr('readonly',true);

$('#country').css('pointer-events','none');
$('.user_edit').click(function(){
   $("#mobile").attr('readonly',false);
   $(".save").attr('disabled',true);
});

var blobImage = '';
var blobName = '';

$('#profile_img_upload_btn').on('change', function(e) {
      var files = e.target.files;
      if (files && files.length > 0) {
         blobName = files[0].name;
         cropImage($(this), files[0], $('.user-img'), function(data) {
            blobImage = data;
         });
      }
   });

$('.user_update').click(function(){

   var countryCode = $('.country_code').val();
   var phoneNumber = $('#mobile').val();
   var mob=$('.mobile_number').val();
   if(phoneNumber != "") {
         var data = new FormData();
         data.append('country_code',countryCode);
         data.append('mobile', phoneNumber);
         data.append('salt_key', '{{Helper::getSaltKey()}}');

            $.ajax({
               type:'POST',
               url: getBaseUrl() + "/user/send-otp",
               data: data,
               processData: false,
               contentType: false,
               headers: {
                     Authorization: "Bearer " + getToken("user")
               },
               beforeSend: function(request) {
                     showLoader();
                     
               },
               success:function(data){
                  hideLoader();
                  $('.otp').removeClass('d-none');
                  alertMessage("Success", data.message, "success"); 
               }, error: (jqXHR, textStatus, errorThrown) => {
                  alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                  hideLoader();
                  
               }
            });
   }    
});

$('.verify_otp').on('click', function() {
         
         var countryCode = $('.country_code').val();
         var phoneNumber = $('#mobile').val();
         var otp = $('#otp').val();
         showLoader();

         if(phoneNumber != "") {
            $.post(getBaseUrl() + "/user/verify-otp",{ 
               country_code : countryCode, 
               mobile : phoneNumber,
               otp : otp,
               salt_key: '{{Helper::getSaltKey()}}'
            })
            .done(function(response){ 
               hideLoader();
               $('.otp').addClass('d-none');
               $('.save').prop('disabled',false);
            })
            .fail(function(xhr, status, error) {
               hideLoader();
               var mob=$('.mobile_number').val();
               $('#mobile').val(mob);
               $('#mobile').prop('readonly',true);
               $('.save').prop('disabled',false);
               alertMessage('Error', xhr.responseJSON.message, "danger");
               
            });
         }
 });



   function openNav() {
      document.getElementById("mySidenav").style.width = "50%";
   }

   function closeNav() {
         document.getElementById("mySidenav").style.width = "0";
   }
   //My profile
   $(document).ready(function()
  {
     basicFunctions();

   var id = "";
   
   //For Stripe Details

   
    @if($card==1)
   Stripe.setPublishableKey("{{ @$stripe_publishable_key }}");
   var stripeResponseHandler = function (status, response) {
      var $form = $('#payment-form');         
      if (response.error) {
         // Show the errors on the form
         $form.find('.payment-errors').text(response.error.message);
         $form.find('.payment-errors').text(response.message);
         $form.find('button').prop('disabled', false);
      } else {
         $form.find('.payment-errors').text(response.message); 
         // token contains id, last4, and card type

         var data = new FormData();

         data.append('stripe_token', response.id);

         $.ajax({
            type:'POST',
            url: getBaseUrl() + "/user/card",
            data: data,
            processData: false,
            contentType: false,
            headers: {
                  Authorization: "Bearer " + getToken("user")
            },
            beforeSend: function(request) {
                  showLoader();
            },
            success:function(data){
               alertMessage("Success", data.message, "success");
               $('#add_card').modal('hide');
               hideLoader();
               setTimeout(function(){
                    window.location.replace('/profile/payment_method');
                  }, 1000);
            }, error: (jqXHR, textStatus, errorThrown) => {
               hideLoader();
               $form.find('.payment-errors').text(jqXHR.responseJSON.message);
            }
         });
      }
   };

    //For get stripe card  details
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
               html += `<div class="col-lg-4 col-md-4 col-sm-4 card-section">
                     <h5 class="p-0"><strong>{{__('user.credit_card')}}</strong></h5>
                     <div class="card-img">
                        <img src="{{asset('assets/layout/images/common/svg/card.svg')}}">
                        <div class="card-number">
                           <span>XXXX</span> <span>XXXX</span><span>XXXX</span><span class ="last_four">`+item.last_four+`</span><br>
                           <small>`+item.month+`/`+item.year+`</small><br>
                           <span class = "holder_name">`+item.holder_name+`</span>
                        </div>
                     </div>
                     <div class="col-sm-12 p-0 card-form dis-center">
                        <button  class="btn btn-secondary change-pswrd mt-1 delete" data-toggle="modal" data-target="#edit_card" data-id ="`+item.id+`">{{__('user.delete')}}</button>
                     </div>
                  </div>`;
            });
            $('#card_container').before(html);
         }
      });
   @endif

   function isNumberKey(evt)
   {
      var charCode = (evt.which) ? evt.which : event.keyCode;
      if (charCode != 46 && charCode > 31 
      && (charCode < 48 || charCode > 57))
            return false;

      return true;
   }

   $.ajax({
      url: getBaseUrl() + "/user/countries",
      type: "post",
      async: false,
      data: {
         salt_key: '{{Helper::getSaltKey()}}'
      },
      success: (response, textStatus, jqXHR) => {
         var data = parseData(response);
         var countries = data.responseData;
         for(var i in countries) {
            $('select[name=country_id]').append(`<option value="`+countries[i].id+`">`+countries[i].country_name+`</option>`);
         }

         $('select[name=country_id]').on('change', function() {
            $('select[name=city_id]').html("");
            $('select[name=city_id]').append(`<option value="">{{__('user.profile.select_city')}}</option>`);
            var country_id = $(this).val();
            
            var cities = countries.filter((item) => item.id == country_id)[0].city;

            
            for(var j in cities) {
               $('select[name=city_id]').append(`<option value="`+cities[j].id+`">`+cities[j].city_name+`</option>`);
            }

         });
      },
      error: (jqXHR, textStatus, errorThrown) => {}
   });

   
    //List the user card  details
   $.ajax({
      type:"GET",
      url: getBaseUrl() + "/user/walletlist",
      headers: {
            Authorization: "Bearer " + getToken("user")
      },
      success:function(response){
         var data = parseData(response);
         var result = data.responseData;
         $('.currency').text(result.country.country_currency);
         $('.wallet_balance').text((result.wallet_balance).toFixed(2));
      }
   });
    //For delete stripe record  details
    
     $('body').on('click', '.delete', function() {
        var id = $(this).data('id');
        //var value = $(this).data('value');

         $(".confirm-modal").modal("show");
         $(".delete-modal-btn")
            .off()
            .on("click", function() {
               var url = getBaseUrl() + "/user/card/"+id;
               $.ajax({
                  type:"Delete",
                  url: url,
                  headers: {
                      Authorization: "Bearer " + getToken("user")
                  },
                  'beforeSend': function (request) {
                      showInlineLoader();
                  },
                  success:function(data){
                      //$(".status-modal").modal("hide");
                      
                     var result = data.responseData;
                     window.location.replace('/profile/payment_method');
                     hideLoader();
                  }
            });
         });
        
    });

    //For delete address  details
   $(document).on('click', '.addressdelete', function(){
      var id = $(this).data('id');
      var result = confirm("{{__('user.are_u_sure')}}");
      $.ajax({
         type:"Delete",
         url: getBaseUrl() + "/user/address/"+id,
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         success:function(data){
            var result = data.responseData;
            loaduseraddress();
         }
      });
   });
   $(document).on('click', '.addressedit', function(){
      var id = $(this).data('id');
      $.ajax({
         type:"GET",
         url: getBaseUrl() + "/user/store/address/"+id,
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         success:function(data){
            var result = data.responseData;
            $('#latitude').val(result.latitude);
            $('#longitude').val(result.longitude);
            $('#pac-input').val(result.map_address);
            $('#flat_no').val(result.flat_no);
            $('#street').val(result.street);
            $("#address_type option[value='"+result.address_type +"']").prop('selected', true);
            $('#address_id').val(result.id);
            $('#add_address').modal('show');

            initMap(result.latitude, result.longitude);
         }
      });
   });
   $(document).on('click', '.add-address', function(){
      $('.validateaddressForm')[0].reset();
      $('#add_address').modal('show');
   });

	 //List the profile details
	 $.ajax({
        type:"GET",
        url: getBaseUrl() + "/user/profile",
        headers: {
            Authorization: "Bearer " + getToken("user")
        },
        success:function(response){
         var data = parseData(response);
         var result = data.responseData;
         if(result.language!=''){ 
            $('#language').val(result.language).prop('readonly',true);
         }
         $('#first_name').val(result.first_name);
         $('#last_name').val(result.last_name);
         $('#profile_email').val(result.email);
         $('#mobile').val(result.mobile);
         $('.mobile_number').val(result.mobile);
         $('.country_code').val(result.country_code);
         //$('#language').val(result.language);
         $('.account_balance_wallet').text(result.currency_symbol+' '+result.wallet_balance);
         $('.user-img').attr('src',result.picture);
         $('select[name=country_id]').val(result.country_id).trigger('change');
         $('select[name=city_id]').val(result.city_id).trigger('change');
        }
    });

    //For user address list
    loaduseraddress();
   function loaduseraddress(){
      $.ajax({
         type:"GET",
         url: getBaseUrl() + "/user/store/useraddress",
         headers: {
               Authorization: "Bearer " + getToken("user")
         },
         success:function(response){
            var html = ``;
            var data = parseData(response);
            var result = data.responseData;
            $.each(result,function(key,item){
               html += `<div class="col-lg-4 col-md-12 col-sm-12 card-section" >
                        <div class=" top small-box green w-100">
                           <div class="left">
                              <h2>`+item.address_type+`</h2>`;
                              if(item.address_type=='Home'){
                                  html +=`<h4><i class="material-icons">home</i></h4>`;
                              }
                              if(item.address_type=='Work'){
                                 html +=`<h4><i class="material-icons">work</i></h4>`;
                              }
                              if(item.address_type=='Other'){
                                 html +=`<h4><i class="material-icons">location_on</i></h4>`;
                              }
                              html += `<p class="txt-white">`+item.map_address+`</p>
                           </div>
                        </div>
                        <div class="dis-row">
                        <a  class="btn btn-secondary edit-profile mt-2 addressedit" data-id="`+item.id+`" >{{__('user.edit')}} <i class="fa fa-pencil" aria-hidden="true"></i></a>
                         <a  class="btn btn-secondary edit-profile ml-2 mt-2 addressdelete" data-id="`+item.id+`"  >{{__('user.delete')}} <i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
                     </div>`;
            });
            html += `<div class="dis-column add-address ml-3 mr-3"  data-toggle="modal" data-target="#add_address" >
                        <div class="add-card">
                           <div class="add-img">
                              <img src="{{asset('assets/layout/images/common/svg/add.svg')}}">
                           </div>
                        </div>
                     </div> `;
            $('.address_container').html(html);
         }
      });
   }
    //For profile details
     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            first_name: { required: true },
            last_name: { required: true },
            email: { required: true },
            mobile: { required: true },
            language: { required: true },
            city_id: { required: true },
		},

		messages: {
         first_name: { required: "{{__('auth.firstname_required')}}" },
         last_name: { required: "{{__('auth.lastname_required')}}" },
         mobile: { required: "{{__('auth.mobile_required')}}" },
         email: { required: "{{__('auth.email_required')}}" },
         city_id: { required: "{{__('auth.city_required')}}" },

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
			var formGroup = $(".validateForm").serialize().split("&");
         var data = new FormData();

         if(blobImage != "") data.append('picture', blobImage, blobName);
         
			for(var i in formGroup) {
				var params = formGroup[i].split("=");
            data.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
         }
         
         $.ajax({
                  url: getBaseUrl() + "/user/profile",
                  type: "post",
                  data: data,
                  processData: false,
                  contentType: false,
                  headers: {
                        Authorization: "Bearer " + getToken('user')
                  },
                  beforeSend: function (request) {
                        showInlineLoader();
                  },
                  success: function(response, textStatus, jqXHR) {
                        var data = parseData(response);

                        setUserDetails(data.responseData);
                        document.cookie="user_language="+data.responseData.language;
                        alertMessage("Success", data.message, "success");
                        hideInlineLoader();
                     
                        location.reload();
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
    });

    //Change Password
    $('.validatepasswordForm').validate({
         errorElement: 'span', //default input error message container
         errorClass: 'help-block', // default input error message class
         focusInvalid: false, // do not focus the last invalid input
         rules: {
               old_password: { required: true },
               password: { required:true },
               password_confirmation:{ required:true, equalTo: "#password1" }
         },
         messages: {
               old_password: { required: "{{__('user.old_password_required')}}" },
            password: { required: "{{__('user.password_required')}}" },
            password_confirmation: { required: "{{__('user.password_confirmation_required')}}",equalTo:"{{__('user.password_confirmation_equalto')}}" },
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
			var formGroup = $(".validatepasswordForm").serialize().split("&");
         var data1 = new FormData();
         
			for(var i in formGroup) {
				var params = formGroup[i].split("=");
            data1.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
         }
         
         $.ajax({
                  url: getBaseUrl() + "/user/password",
                  type: "post",
                  data: data1,
                  processData: false,
                  contentType: false,
                  headers: {
                        Authorization: "Bearer " + getToken('user')
                  },
                  beforeSend: function (request) {
                        showInlineLoader();
                  },
                  success: function(response, textStatus, jqXHR) {
                        var data = parseData(response);

                        alertMessage("Success", data.message, "success");
                        hideInlineLoader();
                     
                        setTimeout(function(){
                           window.location.replace("password");
                        }, 1000);
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
    });
    //Payment Details

    $('#payment-form').submit(function (e) {
            e.preventDefault();
           
            if ($('#stripeToken').length == 0)
            {
                var $form = $(this);
                $form.find('button').prop('disabled', true);               
                Stripe.card.createToken($form, stripeResponseHandler);
                hideLoader();
                return false;
            }
            
        });


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
            map_address: { required: "{{__('user.map_address_required')}}" },
            latitude: { required: "{{__('user.latitude_required')}}" },
            longitude: { required: "{{__('user.latitude_required')}}" },
            address_type:{ required:"{{__('user.address_type_required')}}" },
            flat_no:{ required:"{{__('user.flat_no_required')}}"},
            street:{ required:"{{__('user.street_required')}}"}
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
         
         $.ajax({
                  url: getBaseUrl() + "/user/address/add",
                  type: "post",
                  data: data1,
                  processData: false,
                  contentType: false,
                  headers: {
                        Authorization: "Bearer " + getToken('user')
                  },
                  beforeSend: function (request) {
                        showInlineLoader();
                  },
                  success: function(response, textStatus, jqXHR) {
                        var data = parseData(response);

                        alertMessage("Success", data.message, "success");
                        hideInlineLoader();
                      $('#add_address').modal('hide');
                        // setTimeout(function(){
                        //    window.location.replace("all_address");
                        // }, 1000);
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
         loaduseraddress();
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

    function initMap(current_latitude = '13.066239', current_longitude = '80.274816') { 

        var userLocation = new google.maps.LatLng(
                current_latitude,
                current_longitude
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
            console.log(lat,lng, addr);
            latitude.value = lat;
            longitude.value = lng;
            var address = addr;
            var landmark = address.split(',')[0];
            var city = address.replace(address.split(',')[0]+',',' ');
           /* window.localStorage.setItem('landmark', landmark);
            window.localStorage.setItem('city', city);
            window.localStorage.setItem('latitude', lat);
            window.localStorage.setItem('longitude', lng);*/
            $('.landmark').html(landmark);
            $('.city').html(city); 
            $('.search-loc-form').val(address);
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
           
       }
       
       initMap(current_latitude, current_longitude);

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
