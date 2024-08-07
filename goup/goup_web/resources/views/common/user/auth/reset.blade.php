@extends('common.user.layout.auth')
@section('styles')
@parent
@stop
@section('content')
<section id="">
<div class="login-bg ">
   <div class="login-content">

   <div class="logo-section dis-center">
               <a href="{{URL::to('user')}}">
                  <img src="{{ Helper::getSiteLogo() }}" class="" width="100" alt="logo">
               </a>
            </div>
      <div id="password-change" class="col-sm-12 col-md-12 col-lg-12 dis-column">
        
         <div class="h-100 col-sm-12 col-md-12 col-lg-12 dis-column">
            <main class="">
               <h5 class="text-center mb-3">@lang('auth.reset_your_password')</h5>
               <form class=" validateForm" >
                  <div class="col-md-12 p-0 ">
                     <div id="toaster" class="toaster"></div>
                     @if(isset($urlparam['at']))
                        @if($urlparam['at']=='mobile')
                        <input id="mobile" required name="country_code" maxlength="15" placeholder="@lang('auth.phone_number')"  type="hidden" value="{{isset($urlparam['country_code']) ? $urlparam['country_code'] :''}}" >
                        <input id="mobile" required name="username" maxlength="15" placeholder="@lang('auth.phone_number')"  type="hidden" value="{{isset($urlparam['mobile']) ? $urlparam['mobile'] :''}}" >
                        @else
                        <input id="email" name="username" class="form-control mb-4" placeholder="@lang('auth.email_address')" type="hidden" aria-required="true" required  value="{{isset($urlparam['email']) ? $urlparam['email'] :''}}" >
                        @endif
                     @endif
                     <input id="enterOtp" name="otp" class="form-control mb-4" placeholder="@lang('auth.enter_otp_received')" type="text" aria-required="true" required>
                     <input id="newPass" name="password" class="form-control mb-4" placeholder="@lang('auth.new_password')" type="password" aria-required="true" required autocomplete="fa">
                     <input id="confirmPass" name="password_confirmation" class="form-control mb-4" placeholder="@lang('auth.confirm_password')" type="password" aria-required="true" required>
                     <input id="accountType" name="account_type" type="hidden" value="{{isset($urlparam['at'])?$urlparam['at']:''}}">
                     <button type="submit" class="btn btn-block btn-secondary btn-md mb-2 signup">@lang('auth.continue')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>
                  </div>
               </form>
               <div class="mt-2">
                  <a href="{{url('/login')}}" id="sign" class="txt-secondary sign-up-link"><i class="fa fa-arrow-circle-left mr-2" aria-hidden="true"></i>@lang('auth.back_to_login')</a>
               </div>
            </main>
         </div>
      </div>
</div>
   </div>
</section>
@stop
@section('scripts')
@parent

<script>
$(document).ready(function() {

	var base_url_data = JSON.parse(decodeHTMLEntities('{{$base}}'));

	for(var i in Object.keys(base_url_data)) {
		var key = String(Object.keys(base_url_data)[i]);
		var value = String(Object.values(base_url_data)[i]);
		localStorage.setItem(key, value);
   }

   setBaseUrl('{{$base_url}}');

   $('.validateForm').validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-block', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      rules: {
            email: { required: true, email: true },
      },

      messages: {
            email: { required: "Email is required." },
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
            for(var i in formGroup) {
               var params = formGroup[i].split("=");
               data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append( 'salt_key', '{{Helper::getSaltKey()}}');
            data.append( 'country_code', $('.phone').intlTelInput('getSelectedCountryData').dialCode );
             
            $.ajax({
               url: getBaseUrl() + "/user/reset/otp",
               type: "post",
               data: data,
               processData: false,
               contentType: false,
               beforeSend: function() {
                  showLoader();
               },
               success: function(response, textStatus, jqXHR) {
                  // setToken("user", response.responseData.access_token);
                  // setUserDetails(response.responseData.user);
                  window.location.replace("{{ url('/login') }}");
                  hideLoader();
               },
               error: function(jqXHR, textStatus, errorThrown) {
                  console.log(jqXHR);
                  alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                  hideLoader();
               }
            });

      }
   });

   var number;

   $(".phone").intlTelInput({
      initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",
    });
});
</script>

@stop
