@extends('common.provider.layout.auth')
@section('styles')
@parent
@stop
@section('content')
@include('common.alert')
<section id="provider-signup" class="ph-100">
<div class="login-bg ">
            <div class="login-content">
         <div class="logo-section dis-center">
         <a href="{{URL::to('provider')}}">
            <img src="{{ Helper::getSiteLogo() }}" class="" width="100" alt="logo">
         </a>
            </div> 

         
         <div id="sign-up" class="sign-in-section dis-center">
            <div class="h-100 col-sm-12 col-md-12 col-lg-12 dis-column ">
               <h6 class="mb-3"><strong>@lang('auth.welcome_create_account')</strong></h6>
               
               <form class="validateForm">

               <div id="toaster" class="toaster"></div>

               <input id="mobile" name="mobile" maxlength="15" class="intl-tel phone form-control mb-3" placeholder="@lang('auth.phone_number')" type="text" >
               @if(Helper::getSettings()->site->send_sms == 1)
               <input id="otp" name="otp" maxlength="4" style="display: none" class=" form-control mb-3" placeholder="@lang('auth.otp')" type="text" >
               @endif

               <div class="account_kit" @if(Helper::getSettings()->site->send_sms == 1) style="display:none" @endif>
                 <input id="email" name="email" class="form-control mb-3" placeholder="@lang('auth.email_address')" type="email" aria-required="true" >
                 <div class="col-sm-12 col-md-12 col-lg-12 p-0 d-flex">
                    <div class="col-sm-6 p-0 mr-1">
                       <input id="first_name" name="first_name" class="form-control mb-3" value="" placeholder="@lang('auth.first_name')" type="text" >
                    </div>
                    <div class="col-sm-6 p-0">
                       <input id="last_name" name="last_name" class="form-control mb-3" value="" placeholder="@lang('auth.last_name')" type="text" >
                    </div>
                 </div>
                 <select name="gender" id="gender" class="w-100 mb-3">
                    <option value="">@lang('auth.select_gender')</option>
                    <option value="MALE">@lang('auth.MALE')</option>
                    <option value="FEMALE">@lang('auth.FEMALE')</option>
                    <option value="GENERAL">@lang('auth.GENERAL')</option>
                 </select>
                 <input id="password" name="password" class="form-control mb-3" value="" placeholder="@lang('auth.password')" type="password" >
                 <input id="password_confirmation" name="password_confirmation" class="form-control mb-3" value="" placeholder="@lang('auth.confirm_password')" type="password" >
                 <select id="country" name="country_id"  class=" mb-3 form-control">
                    <option value="">@lang('auth.select_country')</option>
                 </select>
                 <select id="city" name="city_id" class=" mb-3 form-control">
                    <option value="">@lang('auth.select_city')</option>
                 </select>
                 <input id="picture" name="picture" class="form-control mb-3" placeholder="Picture" type="file" >
                 <input id="referral_code" name="referral_code" class="form-control mb-3" placeholder="@lang('auth.referral_code')" type="text" >
               </div>
               @if(Helper::getSettings()->site->send_sms == 1)
               <a class="btn btn-block btn-primary btn-md mb-2 verify_btn">@lang('auth.verify')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
               <a class="btn btn-block btn-primary btn-md mb-2 check_otp"  style="display: none !important" >@lang('auth.submit')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
               @endif
               <button type="submit" class="btn btn-block btn-green btn-md mb-2 account_kit"  @if(Helper::getSettings()->site->send_sms == 1) style="display:none !important" @endif >@lang('auth.next')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>
               </form>
               <span>@lang('auth.already_account') <strong><a href="{{ url('/provider/login') }}" class="signup-link">@lang('auth.login')</a></strong></span>
               <div class="or-section mt-4 mb-3">
                  <hr>
                  <span>@lang('auth.or')</span>
                  <hr>
               </div>
               @if(Helper::getSettings()->site->social_login == 1)
               <div class="social-login">
                           <span class="fb-bg" onclick="fbLogin()"><i class="fa fa-facebook-square "></i></span>
                           <span id="glogin" class="google_login google-bg "><i class="fa fa-google-plus-square "></i></span>
                     </div>

               
               @endif
               <div class="copyrights">
                        <p>{!! Helper::getSettings()->site->site_copyright !!}</p>
                     </div>
            </div>
         </div>
      </div>

      <div id="social-login" class="col-sm-12 col-md-12 col-lg-12 d-none">
         <div class="sign-in-section dis-center">
            <div class="h-100 col-sm-12 col-md-5 col-lg-5 dis-column content-card">
               <h6 class="mb-3"><strong>@lang('auth.welcome_create_account')</strong></h6>

               <form class="col-lg-12">

               <div id="toaster" class="toaster"></div>

               <input id="mobile" name="mobile" maxlength="15" class="intl-tel phone form-control mb-3 d-none" placeholder="@lang('auth.phone_number')" type="text" >
               <input id="email" name="email" class="form-control mb-3 d-none" placeholder="@lang('auth.email_address')" type="email" aria-required="true" >
               <select name="gender" id="gender" class="w-100 mb-3">
                  <option value="">@lang('auth.select_gender')</option>
                  <option value="MALE">@lang('auth.MALE')</option>
                  <option value="FEMALE">@lang('auth.FEMALE')</option>
                  <option value="GENERAL">@lang('auth.GENERAL')</option>
               </select>
               <select id="country" name="country_id"  class=" mb-3 form-control">
                  <option value="">@lang('auth.select_country')</option>
               </select>
               <select id="city" name="city_id" class=" mb-3 form-control">
                  <option value="">@lang('auth.select_city')</option>
               </select>
               <a class="btn btn-block btn-green btn-md mb-2 social_login">@lang('auth.next')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
               </form>
               <span>@lang('auth.already_account') <strong><a href="{{ url('/provider/login') }}" class="signup-link">@lang('auth.signin')</a></strong></span>
            </div>
         </div>
      </div>
   </div>
</section>
@stop
@section('scripts')
@parent
<script src="https://apis.google.com/js/api:client.js"></script>
<script src="https://sdk.accountkit.com/en_US/sdk.js"></script>
<script>

startApp();
var googleUser = {};
  function startApp() {
    gapi.load('auth2', function(){
      // Retrieve the singleton for the GoogleAuth library and set up the client.
      auth2 = gapi.auth2.init({
        client_id: '{{ Helper::getSettings()->site->google_client_id }}',
        cookiepolicy: 'single_host_origin',
        // Request scopes in addition to 'profile' and 'email'
        //scope: 'additional_scope'
      });
      attachSignin(document.getElementById('glogin'));
    });
  };

  function attachSignin(element) {
   auth2.attachClickHandler(element, {}, function () {

      gapi.client.load('oauth2', 'v2', function () {
         var request = gapi.client.oauth2.userinfo.get({
               'userId': 'me'
         });
         request.execute(function (response) {
               // Display the user details
               saveData(response.id, 'GOOGLE', response.given_name, response.family_name, response.email, response.picture);
         });
      });
      }, function(error) {
          console.log(JSON.stringify(error, undefined, 2));
      }

   );
  }


  // initialize Account Kit with CSRF protection
  AccountKit_OnInteractive = function(){
    AccountKit.init(
      {
        appId: {{ Helper::getSettings()->site->facebook_app_id }}, 
        state:"state", 
        version: "{{ Helper::getSettings()->site->facebook_app_version }}",
        fbAppEventsEnabled:true
      }
    );
  };



  window.fbAsyncInit = function() {
    FB.init({
      appId      : '{{ Helper::getSettings()->site->facebook_app_id }}',
      cookie     : true,
      xfbml      : true,
      version    : 'v3.2'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   /* FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
   }); */

   function saveData(social_unique_id, login_by, first_name, last_name, email,picture) {

      $.ajax({
         url: getBaseUrl() + "/user/countries",
         type: "post",
         data: {
            salt_key: '{{Helper::getSaltKey()}}'
         },
         success: (data, textStatus, jqXHR) => {
            var countries = data.responseData;
            for(var i in countries) {
               $('select[name=country_id]').append(`<option value="`+countries[i].id+`">`+countries[i].country_name+`</option>`);
            }

            $('select[name=country_id]').on('change', function() {
               $('select[name=city_id]').html("");
               $('select[name=city_id]').append(`<option value="">Select City</option>`);
               var country_id = $(this).val();

               var cities = countries.filter((item) => item.id == country_id)[0].city;

               for(var j in cities) {
                  $('select[name=city_id]').append(`<option value="`+cities[j].id+`">`+cities[j].city_name+`</option>`);
               }

            });
         },
         error: (jqXHR, textStatus, errorThrown) => {}
      });


      var formData = new FormData();
      formData.append('social_unique_id', social_unique_id);
      formData.append('login_by', login_by);
      formData.append('first_name', first_name);
      formData.append('last_name', last_name);
      formData.append('email', email);
      formData.append('picture', picture);
      formData.append('salt_key', '{{Helper::getSaltKey()}}');

      $.ajax({
         url: getBaseUrl() + "/provider/social/login",
         type: "post",
         processData: false,
         contentType: false,
         data: formData,
         success: (response, textStatus, jqXHR) => {
            var data = parseData(response);

            if(data.responseData.status == 0) {

               $('#sign-up').addClass('d-none');
               $('#social-login').removeClass('d-none');

               var validators = data.responseData.validators;

               for(var i in validators) {
                  $('#social-login').find('[name='+validators[i]+']').removeClass('d-none');
               }

               $('.social_login').on('click', function() {
                  

                  $('#social-login input, #social-login select').each(function() {
                     if($(this).val() == "" && $(this).is(':visible') ) {
                        $('.social_error').remove();
                        $('#social-login form').prepend(`<span class="social_error" style="padding: 5px; color: red; text-align:center; float:left; width: 100%;">The `+ (($(this).attr('name')).replace(/_/g, ' ')).replace(/id/g, '') +` is required</span>`);
                     
                        return false;
                     } else if($(this).val() != "") {
                        formData.append($(this).attr('name'), $(this).val());
                     }
                  });

                  

                  formData.append( 'country_code', $('#social-login').find('.phone').intlTelInput('getSelectedCountryData').dialCode );

                  $.ajax({
                     url: getBaseUrl() + "/provider/social/login",
                     type: "post",
                     processData: false,
                     contentType: false,
                     data: formData,
                     beforeSend: function() {
                        showLoader();
                     },
                     success: (newResponse, textStatus, jqXHR) => {
                        var newData = parseData(newResponse);
                        if(newData.responseData.status != 0) {
                           setToken("provider", newData.responseData.access_token);
                           setProviderDetails(newData.responseData.user);
                           window.location.replace("{{ url('/provider') }}");
                        }
                        hideLoader();
                     },
                     error: (jqXHR, textStatus, errorThrown) => {
                        hideLoader();
                        alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                     }
                  });

               });

            } else {
               setToken("provider", data.responseData.access_token);
               setProviderDetails(data.responseData.user);
               window.location.replace("{{ url('/provider') }}");
            }
         },
         error: (jqXHR, textStatus, errorThrown) => {
            alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
         }
      });
   }

   function fbLogin() {
    FB.login(function (response) {
        if (response.authResponse) {
            // Get and display the user profile data
            getFbUserData();
        } else {
            console.log('User cancelled login or did not fully authorize.');
        }
      }, {scope: 'email'});
   }

   function getFbUserData() {
      FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
      function (response) {
         saveData(response.id, 'FACEBOOK', response.first_name, response.last_name, response.email, response.picture.data.url);
      });
   }

   $('.verify_btn').on('click', function() {
      
      var countryCode = $('#sign-up .phone').intlTelInput('getSelectedCountryData').dialCode;
      var phoneNumber = $('#sign-up input[name=mobile]').val();

      if(phoneNumber != "") {
         $.post( getBaseUrl() + "/provider/send-otp",{ 
            country_code : countryCode, 
            mobile : phoneNumber,
            salt_key: '{{Helper::getSaltKey()}}'
         })
         .done(function(data){ 
            $('.verify_btn').attr("style", "display: none !important");
            $('.intl-tel-input').hide();
            $('#sign-up input[name=otp]').show();
            $('.check_otp').show();
         })
         .fail(function(xhr, status, error) {
            $('.verify_btn').attr("style", "display: block !important");
            $('.intl-tel-input').show();
            $('#sign-up input[name=otp]').hide();
            $('.check_otp').hide();
            alertMessage('Error',  xhr.responseJSON.message, "danger");
         });
      }
   });

   $('.check_otp').on('click', function() {
      
      var countryCode = $('#sign-up .phone').intlTelInput('getSelectedCountryData').dialCode;
      var phoneNumber = $('#sign-up input[name=mobile]').val();
      var otp = $('#sign-up input[name=otp]').val();

      if(phoneNumber != "") {
         $.post(getBaseUrl() + "/provider/verify-otp",{ 
            country_code : countryCode, 
            mobile : phoneNumber,
            otp : otp,
            salt_key: '{{Helper::getSaltKey()}}'
         })
         .done(function(response){ 
            $('.intl-tel-input').show();
            $('#sign-up input[name=mobile]').attr('readonly',true);
            $('.account_kit').fadeIn(400);
            $('#sign-up input[name=otp]').hide();
            $('.verify_btn, .check_otp').remove();
         })
         .fail(function(xhr, status, error) {
            alertMessage('Error',  xhr.responseJSON.message, "danger");
            /* $('.verify_btn').attr("style", "display: block !important");
            $('.intl-tel-input').show();
            $('#sign-up input[name=otp]').hide();
            $('.check_otp').hide(); */
         });
      }
   });



         $(document).ready(function() {

            $(".phone").intlTelInput({
              // initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",
            });

            $.ajax({
               url: getBaseUrl() + "/provider/countries",
               type: "post",
               data: {
                  salt_key: '{{Helper::getSaltKey()}}'
               },
               success: (data, textStatus, jqXHR) => {
                  var countries = data.responseData;
                  for(var i in countries) {
                     $('select[name=country_id]').append(`<option value="`+countries[i].id+`">`+countries[i].country_name+`</option>`);
                  }

                  $('select[name=country_id]').on('change', function() {
                     $('select[name=city_id]').html("");
                     $('select[name=city_id]').append(`<option value="">Select City</option>`);
                     var country_id = $(this).val();

                     var cities = countries.filter((item) => item.id == country_id)[0].city;

                     for(var j in cities) {
                        $('select[name=city_id]').append(`<option value="`+cities[j].id+`">`+cities[j].city_name+`</option>`);
                     }

                  });
               },
               error: (jqXHR, textStatus, errorThrown) => {}
            });

            var number;

            $('.validateForm').validate({
               errorElement: 'span', //default input error message container
               errorClass: 'help-block', // default input error message class
               focusInvalid: false, // do not focus the last invalid input
               rules: {
                     first_name: { required: true },
                     last_name: { required: true },
                     mobile: { required: true },
                     email: { required: true, email: true },
                     gender: { required: true },
                     password: { required: true },
                     password_confirmation: {
                        equalTo: "#password"
                     },
                     country_id: { required: true },
                     city_id: { required: true },
               },

               messages: {
                     first_name: { required: "First name is required." },
                     last_name: { required: "last name is required." },
                     mobile: { required: "Mobile number is required." },
                     email: { required: "Email is required." },
                     password: { required: "Password is required." },
                     country_id: { required: "Country is required." },
                     city_id: { required: "City is required." },
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
                     data.append( params[0], decodeURIComponent( params[1]) );
                  }
                  data.append( 'salt_key', '{{Helper::getSaltKey()}}');
                  data.append( 'country_code', $('.phone').intlTelInput('getSelectedCountryData').dialCode );
                  if(($('input[name=picture][type=file]')[0].files).length > 0) {
                     data.append('picture', $('input[name=picture][type=file]')[0].files[0]); 
                  }
                  $.ajax({
                     url: getBaseUrl() + "/provider/signup",
                     type: "post",
                     data: data,
                     processData: false,
                     contentType: false,
                     beforeSend: function() {
                        showLoader();
                     },
                     success: function(response, textStatus, jqXHR) {
                        setToken("provider", response.responseData.access_token);
                        setProviderDetails(response.responseData.user);
                        window.location.replace("{{ url('/provider/home') }}");
                        alertMessage("Success", response.message, "success"); 
                        hideLoader();
                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                        alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                        hideLoader();
                     }
                  });

               }
            });

         });

   </script>
@stop
