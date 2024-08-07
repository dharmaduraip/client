@extends('common.user.layout.auth')
@section('styles')
@parent
@stop
@section('content')
<section id="login-form" class="">
   <div class="login-bg ">
   <div class="login-content">

   <div class="logo-section dis-center">
               <a href="{{URL::to('user')}}">
                  <img src="{{ Helper::getSiteLogo() }}" class="" width="100" alt="logo">
               </a>
            </div>
           


      <div class="col-sm-12 col-md-12 col-lg-12 dis-row">
         <ul class="nav nav-tabs b-0 dis-row">
         @php
           $email_active="";
           $sms_active="";
           $admin_active="";
          if(Helper::getSettings()->site->send_email==1){
            $email_active="active";   
          }else if(Helper::getSettings()->site->send_sms == 1){
            $sms_active="active"; 
          }else{
            $admin_active="active";
          }
         @endphp 
            
            @if(Helper::getSettings()->site->send_email == 1)
            <li class="nav-item">
               <a class="nav-link {{$email_active}}" data-toggle="tab" href="#emailtab">@lang('auth.email_address')</a>
            </li>
            @endif
             @if(Helper::getSettings()->site->send_sms == 1)
            <li class="nav-item">
               <a class="nav-link {{$sms_active}}" data-toggle="tab" href="#mobiletab">@lang('auth.mobile_number')</a>
            </li>
            @endif
            @if(Helper::getSettings()->site->send_sms == 0 && Helper::getSettings()->site->send_email==0)
            <li class="nav-item" style="width:80%">
               <a class="nav-link" data-toggle="tab" href="#admintab">@lang('auth.contact_admin') @if(isset(Helper::getSettings()->site->contact_number)){{ Helper::getSettings()->site->contact_number[0]->number}}@endif</a>
            </li>
            @endif
         </ul>
      </div>      
      <div class="tab-content">
         <div id="emailtab" class="tab-pane {{$email_active}} col-sm-12 col-md-12 col-lg-12">
              <form class="validateForm dis-center" >
                  <div class="col-md-12 p-0 ">
                     <div id="toaster" class="toaster"></div>
                     <input id="email" name="email" class="form-control mb-4" placeholder="E-mail Address" type="email" aria-required="true" required>
                     <span class="errMail"></span>
                     <input id="accountType" name="account_type" type="hidden" value="email">
                     <button type="submit" class="btn btn-block btn-secondary btn-md mb-2 signup">@lang('auth.continue')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>
                     <a href="{{url('/login')}}" id="sign" class="txt-secondary sign-up-link"><i class="fa fa-arrow-circle-left mr-2" aria-hidden="true"></i>@lang('auth.back_to_login')</a>
                </div>
               </form> 
        
         </div>
         <div id="mobiletab" class="tab-pane {{$sms_active}}  col-sm-12 col-md-12 col-lg-12">
             <span class="errMobile"></span>                  
               <form class="validatePhForm dis-center" >
                  <div class="col-md-12 p-0 ">
                  <div id="toaster" class="toaster"></div>
                  <input id="mobile" maxlength="15" required name="mobile" class="intl-tel phone form-control mb-4" placeholder="@lang('auth.mobile_number')"  type="text">
                  <input id="accountType" name="account_type" type="hidden" value="mobile">
                  <button type="submit" class="btn btn-block btn-secondary btn-md mb-2 signup">@lang('auth.continue')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>
                     <a href="{{url('/login')}}" id="sign" class="txt-secondary sign-up-link"><i class="fa fa-arrow-circle-left mr-2" aria-hidden="true"></i>@lang('auth.back_to_login')</a>
                  </div>
               </form>
            </div>
              
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
            email: { required: "{{__('auth.email_required')}}" },
      },
      highlight: function(element)
      {
         $(element).closest('.errMail').addClass('has-error');
      },

      success: function(label) {
         label.closest('.errMail').removeClass('has-error');
         label.remove();
      },
      submitHandler: function(form) {
            var formGroup = $(".validateForm").serialize().split("&");
            para = '?salt=&at=email&un=';
            var data = new FormData();
            for(var i in formGroup) {
               var params = formGroup[i].split("=");
               data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append( 'salt_key', '{{Helper::getSaltKey()}}'); 
            $.ajax({
               url: getBaseUrl() + "/user/forgot/otp",
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
                  window.location.replace("{{ url('/reset-password') }}"+para);
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
   $('.validatePhForm').validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-block', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      rules: {
         mobile: { required: true },
      },
      messages: {
         mobile: { required: "{{__('auth.mobile_required')}}" },
      },
      highlight: function(element)
      {
         $(element).closest('.errMobile').addClass('has-error');
      },

      success: function(label) {
         label.closest('.errMobile').removeClass('has-error');
         label.remove();
      },
      submitHandler: function(form) {
            var formGroup = $(".validatePhForm").serialize().split("&");
            para = '?salt=&at=mobile&un=';
            var data = new FormData();
            for(var i in formGroup) {
               var params = formGroup[i].split("=");
               data.append( params[0], decodeURIComponent(params[1]) );
            }
            data.append( 'salt_key', '{{Helper::getSaltKey()}}'); 
            data.append( 'country_code', $('.phone').intlTelInput('getSelectedCountryData').dialCode );
            $.ajax({
               url: getBaseUrl() + "/user/forgot/otp",
               type: "post",
               data: data,
               processData: false,
               contentType: false,
               success: function(response, textStatus, jqXHR) {
                  // setToken("user", response.responseData.access_token);
                  // setUserDetails(response.responseData.user);
                  window.location.replace("{{ url('/reset-password') }}"+para);
               },
               error: function(jqXHR, textStatus, errorThrown) {
                  console.log(jqXHR);
                  alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
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
