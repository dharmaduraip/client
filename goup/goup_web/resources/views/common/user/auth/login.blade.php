@extends('common.user.layout.auth')
@section('styles')

@parent
@stop
@section('content')
@include('common.alert')
<section id="login-form" class="">
   <div class="login-bg ">
   <div class="login-content">
      <div class="logo-section dis-center">
         <a href="{{URL::to('')}}">
            <img src="{{ Helper::getSiteLogo() }}" class="" width="100" alt="logo">
         </a>
      </div>

      <div class="col-sm-12 col-md-12 col-lg-12 dis-row">
         <ul class="nav nav-tabs b-0 dis-row">
            <li class="nav-item">
               <a class="nav-link @if($type == "login") active @else  @endif" data-toggle="tab" href="#login">@lang('auth.login')</a>
            </li>
            <li class="nav-item">
               <a class="nav-link @if($type == "signup") active @else  @endif" data-toggle="tab" href="#sign-up">@lang('auth.signup')</a>
            </li>
         </ul>
      </div>
      <div class="tab-content">
         <div id="login" class="tab-pane @if($type == "login") active @else  @endif col-sm-12 col-md-12 col-lg-12">
            <div class="dis-center">
               <!-- <div class="h-100 col-sm-12 col-md-12 col-lg-7 dis-column d-lg-none d-md-block d-sm-block">
                  <img src="{{ asset('assets/layout/images/common/login.png') }}" class="w-50">
               </div> -->
               <!-- <div class="offset-md-7 d-lg-block d-md-none d-sm-none"></div> -->
               <form class="h-100 col-sm-12 col-md-12 col-lg-12 col-xl-12 dis-column validateForm">
                     <div id="toaster" class="toaster"></div>
                     <h6 class="txt-primary text-center"><strong>@lang('auth.login-with')</strong></h6>
                     <div class="choose-mode mb-3 col-sm-12 col-md-12 col-lg-12">
                              <span class="radio-box"><input type="radio" checked="checked" name="filter" value="phone" id="filt1-4"><label for="filt1-4">@lang('auth.phone_number')</label></span>
                              <span class="radio-box"><input type="radio" name="filter" value="email" id="filt1-5"><label for="filt1-5">@lang('auth.email')</label></span>
                        </div>
                     <input id="email" name="email" class="form-control required email mb-4" style="display:none" placeholder="@lang('auth.email')" type="email" aria-required="true">
                     <input id="mobile" name="mobile" maxlength="15" class="intl-tel phone form-control mb-4" placeholder="@lang('auth.phone_number')"  type="text" >
                     <input id="password" name="password" class="form-control mb-4" value="" placeholder="@lang('auth.password')" type="password">
                     <button type="submit" class="btn btn-primary btn-md mb-4">@lang('auth.login')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>
                     <a href="{{url('/forgot-password')}}" class="forgot-link">@lang('auth.forgot_password')</a>

                     @if( Helper::getSettings()->site->social_login == 1)
                     <div class="or-section mt-2 mb-3">
                        <hr>
                        <span>OR</span>
                        <hr>
                     </div>
                     <div class="social-login">
                           <span class="fb-bg" onclick="fbLogin()"><i class="fa fa-facebook-square "></i></span>
                           <span id="glogin" class="google_login google-bg "><i class="fa fa-google-plus-square "></i></span>
                     </div>
                     @endif
                     <div class="copyrights">
                        <p>{!! Helper::getSettings()->site->site_copyright !!}</p>
                     </div>
                     
               </form>
            </div>
         </div>
         <div id="sign-up" class="tab-pane @if($type == "signup") active @else  @endif col-sm-12 col-md-12 col-lg-12">


         

            <div class="dis-center">
               <!-- <div class="h-100 col-sm-12 col-md-12 col-lg-7 dis-column d-lg-none d-md-block d-sm-block">
                  <img src="{{ asset('assets/layout/images/common/sign-up.png') }}" class="w-50">
               </div>
               <div class="offset-md-7 d-lg-block d-md-none d-sm-none"></div> -->
               <form class=" h-100 col-sm-12 col-md-12 col-lg-12 col-xl-12 dis-column validateSignForm">
                     

                     <div id="toaster" class="toaster"></div>

                     <input name="mobile" maxlength="15" class="intl-tel signup_phone form-control mb-4" placeholder="Phone Number"  type="text" >
                     @if(Helper::getSettings()->site->send_sms == 1)
                     <input id="otp" name="otp" maxlength="4" style="display: none" class=" form-control mb-4" placeholder="@lang('auth.otp')" type="text" >
                     
                       <a class="btn btn-block btn-secondary btn-md mt-2 verify_btn" id="resend_otp"  style="display: none!important">Resend Otp</a>
                     @endif
                     <div class="account_kit" @if(Helper::getSettings()->site->send_sms == 1) style="display:none" @endif >
                     <input id="email" name="email" class="form-control mb-4" placeholder="@lang('auth.email')" type="email" aria-required="true" required>
                     <div class="col-sm-12 col-md-12 col-lg-12 p-0 d-flex">
                        <div class="col-sm-12  col-md-6 p-0 mr-1">
                           <input id="first_name" name="first_name" class="form-control mb-4" value="" placeholder="@lang('auth.first_name')" type="text" required>
                        </div>
                        <div class="col-sm-12 col-md-6 p-0">
                           <input id="last_name" name="last_name" class="form-control mb-4" value="" placeholder="@lang('auth.last_name')" type="text" required>
                        </div>
                     </div>
                    <!--  w-100 -->
                     <select name="gender" class="form-control mb-4">
                        <option value="">@lang('auth.select_gender')</option>
                        <option value="MALE">@lang('auth.MALE')</option>
                        <option value="FEMALE">@lang('auth.FEMALE')</option>
                        <option value="GENERAL">@lang('auth.GENERAL')</option>
                     </select>
                     <input id="signin_password" name="password" class="form-control mb-4" value="" placeholder="@lang('auth.password')" type="password" required>
                     <input id="password_confirmation" name="password_confirmation" class="form-control mb-4" value="" placeholder="@lang('auth.confirm_password')" type="password" required>
                     <select name="country_id"  class=" mb-4 form-control">
                        <option value="">@lang('auth.select_country')</option>
                     </select>
                     <select name="city_id"  class=" mb-4 form-control">
                           <option value="">@lang('auth.select_city')</option>
                        </select>
                     <input id="picture" name="picture" class="form-control mt-4" placeholder="Picture" type="file" >
                     <input id="referral_code" name="referral_code" class="form-control mt-4" placeholder="Referral Code" type="text" >
                     </div>
                     @if(Helper::getSettings()->site->send_sms == 1)
                     <a class="btn btn-block btn-secondary btn-md mt-2 verify_btn">@lang('auth.verify')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
                     <a class="btn btn-block btn-primary btn-md mb-2 check_otp"  style="display: none !important" >@lang('auth.submit')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
                     @endif
                     <button type="submit" class="btn btn-block btn-secondary btn-md mt-2 signup account_kit" @if(Helper::getSettings()->site->send_sms == 1) style="display:none !important" @endif >@lang('auth.signup')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>

                     <div class="or-section mt-2 mb-3">
                        <hr>
                        <span>@lang('auth.or')</span>
                        <hr>
                     </div>

                     @if(Helper::getSettings()->site->social_login == 1)
                     <div class="social-login">
                           <span class="fb-bg" onclick="fbLogin()"><i class="fa fa-facebook-square "></i></span>
                           <span id="glogin1" class="google_login google-bg "><i class="fa fa-google-plus-square "></i></span>
                     </div>

                    
                     @endif

                     <div class="copyrights">
                        <p>{!! Helper::getSettings()->site->site_copyright !!}</p>
                     </div>
               </form>
            </div>
         </div>
         <div id="social-login" class="tab-pane fade col-sm-12 col-md-12 col-lg-12">
            <div class="dis-reverse">
             <!--   <div class="h-100 col-sm-12 col-md-12 col-lg-7 dis-column d-lg-none d-md-block d-sm-block">
                  <img src="{{ asset('assets/layout/images/common/sign-up.png') }}" class="w-50">
               </div>
               <div class="offset-md-7 d-lg-block d-md-none d-sm-none"></div> -->
               <form class="signin-section h-100 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                     <input name="mobile" maxlength="15" autocomplete="off" class="intl-tel social_phone form-control mb-4 d-none" placeholder="Phone Number"  value="" type="text" >
                     <input name="email" autocomplete="off" class="form-control mb-4 d-none" placeholder="E-mail Address"  value="" type="email" aria-required="true">
                     <select name="gender" class="w-100 mb-3 d-none" autocomplete="off">
                        <option value="">@lang('auth.select_gender')</option>
                        <option value="MALE">@lang('auth.MALE')</option>
                        <option value="FEMALE">@lang('auth.FEMALE')</option>
                        <option value="GENERAL">@lang('auth.GENERAL')</option>
                     </select>
                     <select name="country_id" autocomplete="off" class=" mb-4 form-control d-none">
                        <option value="">@lang('auth.select_country')</option>
                     </select>
                     <select name="city_id" autocomplete="off" class=" mb-4 form-control d-none">
                        <option value="">@lang('auth.select_city')</option>
                     </select>
                     <a class="btn btn-block btn-secondary btn-md mb-2 social_login">@lang('auth.signup')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
               </form>
            </div>
         </div>
      </div>
</div>
      <div class="wave">
            <div class="wave-green"></div>
            <div class="wave-blue"></div>
         </div>

   </div>
</section>
@stop
@section('scripts')
@parent
<script src="https://apis.google.com/js/api:client.js"></script>


<script>

@if(Helper::getSettings()->site->social_login == 1)

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
      attachSignin(document.getElementById('glogin1'));
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
@endif
   function saveData(social_unique_id, login_by, first_name, last_name, email,picture) {

      var formData = new FormData();
      formData.append('social_unique_id', social_unique_id);
      formData.append('login_by', login_by);
      formData.append('first_name', first_name);
      formData.append('last_name', last_name);
      if(email != "" && typeof email != 'undefined') {
         formData.append('email', email);
      }
      formData.append('email', email);
      formData.append('picture', picture);
      formData.append('salt_key', '{{Helper::getSaltKey()}}');

      $.ajax({
         url: getBaseUrl() + "/user/social/login",
         type: "post",
         processData: false,
         contentType: false,
         data: formData,
         success: (response, textStatus, jqXHR) => {
            var data = parseData(response);

            if(data.responseData.status == 0) {

               $('.nav-link').removeClass('active');
               $('#login, #sign-up').removeClass('active show');
               $('#social-login').addClass('active show');

               var validators = data.responseData.validators;

               for(var i in validators) {
                  $('#social-login .signin-section').find('[name='+validators[i]+']').removeClass('d-none');
               }

               $('.social_login').on('click', function() {
                  $('#social-login .signin-section input, #social-login .signin-section select').each(function() {
                     if($(this).val() == "" && $(this).is(':visible') ) {
                        $('.social_error').remove();
                        $('#social-login .signin-section').prepend(`<span class="social_error" style="padding: 5px; color: red;">The `+ (($(this).attr('name')).replace(/_/g, ' ')).replace(/id/g, '') +` is required</span>`);
                        return false;
                     } else if($(this).val() != "") {
                        formData.append($(this).attr('name'), $(this).val());
                     }
                  });

                  formData.append( 'country_code', $('#social-login .signin-section').find('.social_phone').intlTelInput('getSelectedCountryData').dialCode );

                  $.ajax({
                     url: getBaseUrl() + "/user/social/login",
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
                           setToken("user", newData.responseData.access_token);
                           setUserDetails(newData.responseData.user);
                           document.cookie="user_language="+newData.responseData.user.language+"; path=/";
                           window.location.replace("{{ url('/home') }}");
                        }
                        hideLoader();
                     },
                     error: (jqXHR, textStatus, errorThrown) => {
                        hideLoader();
                     }
                  });

               });

            } else {
               setToken("user", data.responseData.access_token);
               setUserDetails(data.responseData.user);
               document.cookie="user_language="+data.responseData.user.language+"; path=/";
               window.location.replace("{{ url('/home') }}");
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

   function getFbUserData(){
      FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
      function (response) {
         saveData(response.id, 'FACEBOOK', response.first_name, response.last_name, response.email, response.picture.data.url);
      });
   }

      // phone form submission handler
      $('.verify_btn').on('click', function() {
      
         var countryCode = $('#sign-up .signup_phone').intlTelInput('getSelectedCountryData').dialCode;
         var phoneNumber = $('#sign-up input[name=mobile]').val();

         if(phoneNumber != "") {
            $.post( getBaseUrl() + "/user/send-otp",{ 
               country_code : countryCode, 
               mobile : phoneNumber,
               salt_key: '{{Helper::getSaltKey()}}'
            })
            .done(function(response){ 
               $('.verify_btn').attr("style", "display: none !important");
               $('.intl-tel-input').hide();
               $('#sign-up input[name=otp]').show();
               $('#resend_otp').show();

               $('.check_otp').show();
            })
            .fail(function(xhr, status, error) {
               $('.verify_btn').attr("style", "display: block !important");
               $('.intl-tel-input').show();
               $('#sign-up input[name=otp]').hide();
               $('.check_otp').hide();
               $('#resend_otp').hide();
               alertMessage('Error', xhr.responseJSON.message, "danger");
            });
         }
      });

      $('.check_otp').on('click', function() {
         
         var countryCode = $('#sign-up .signup_phone').intlTelInput('getSelectedCountryData').dialCode;
         var phoneNumber = $('#sign-up input[name=mobile]').val();
         var otp = $('#sign-up input[name=otp]').val();

         if(phoneNumber != "") {
            $.post(getBaseUrl() + "/user/verify-otp",{ 
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
               alertMessage('Error', xhr.responseJSON.message, "danger");
               /* $('.verify_btn').attr("style", "display: block !important");
               $('.intl-tel-input').show();
               $('#sign-up input[name=otp]').hide();
               $('.check_otp').hide(); */
            });
         }
      });



$(document).ready(function() {

	var base_url_data = JSON.parse(decodeHTMLEntities('{{$base}}'));

	for(var i in Object.keys(base_url_data)) {
		var key = String(Object.keys(base_url_data)[i]);
		var value = String(Object.values(base_url_data)[i]);
		localStorage.setItem(key, value);
   }

   setBaseUrl('{{$base_url}}');

   $.ajax({
      url: getBaseUrl() + "/user/countries",
      type: "post",
      data: {
         salt_key: '{{Helper::getSaltKey()}}'
      },
      success: (data, textStatus, jqXHR) => {
         data = JSON.parse(data);
         var countries = data.responseData;
         for(var i in countries) {
            $('select[name=country_id]').append(`<option value="`+countries[i].id+`">`+countries[i].country_name+`</option>`);
         }

         $('select[name=country_id]').on('change', function() {
            $('select[name=city_id]').html("");
            $('select[name=city_id]').append(`<option value="">{{__('auth.select_city')}}</option>`);
            var country_id = $(this).val();

            var cities = countries.filter((item) => item.id == country_id)[0].city;

            for(var j in cities) {
               $('select[name=city_id]').append(`<option value="`+cities[j].id+`">`+cities[j].city_name+`</option>`);
            }

         });
      },
      error: (jqXHR, textStatus, errorThrown) => {}
   });

   $('.validateForm').validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-block', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      rules: {
            mobile: { required: true },
            email: { required: true, email: true },
            password: { required: true },
      },

      messages: {
            mobile: { required: "{{__('auth.mobile_required')}}" },
            email: { required: "{{__('auth.email_required')}}" },
            password: { required: "{{__('auth.password_required')}}" },
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

            var formGroup = $(".validateForm").find("input[type='hidden'], select, :input:not(:hidden)").serialize().split("&");

            var data = new FormData();

            for(var i in formGroup) {
               var params = formGroup[i].split("=");
               data.append( params[0], decodeURIComponent(params[1]) );
            }

            if($('.phone').is(':visible')) {
               data.append( 'country_code', $('#login .phone').intlTelInput('getSelectedCountryData').dialCode );
            }

            data.append( 'salt_key', '{{Helper::getSaltKey()}}'); 

            $.ajax({
               url: getBaseUrl() + "/user/login",
               type: "post",
               data: data,
               processData: false,
               contentType: false,
               beforeSend: function() {
                  showLoader();
               },
               success: function(response, textStatus, jqXHR) {
                  var data = parseData(response);
                  setToken("user", data.responseData.access_token);
                  setUserDetails(data.responseData.user);
                  document.cookie="user_language="+data.responseData.user.language+"; path=/";
                  window.location.replace("{{ url('/home') }}");
                  hideLoader();
               },
               error: function(jqXHR, textStatus, errorThrown) {
                  alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                  hideLoader();
               }
            });

      }
   });

   var number;

   $(".phone").intlTelInput({
      /*initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",*/
    });

   $(".signup_phone").intlTelInput({
     /* initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",*/
    });

   $(".social_phone").intlTelInput({
      /*initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",*/
    });

   $('input[name=filter]').on('change', function() {
      var value = $(this).val();
      $("#login #email, #login .intl-tel-input").hide();
      if(value == "email") {
         $("#login #email").show();
      } else {
         $("#login .intl-tel-input").show();
      }
   });

   $('.validateSignForm').validate({
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
               equalTo: "#signin_password"
            },
            country_id: { required: true },
            city_id: { required: true },
      },

      messages: {
            first_name: { required: "{{__('auth.firstname_required')}}" },
            last_name: { required: "{{__('auth.lastname_required')}}" },
            mobile: { required: "{{__('auth.mobile_required')}}" },
            email: { required: "{{__('auth.email_required')}}" },
            password: { required: "{{__('auth.password_required')}}" },
            country_id: { required: "{{__('auth.country_required')}}" },
            city_id: { required: "{{__('auth.city_required')}}" },
      },

      highlight: function(element)
      {
         $(element).closest('.form-group').addClass('has-error');
         $(element).removeClass('mb-4').addClass('mb-0').addClass('mt-4');;
      },

      success: function(label) {
         label.closest('.form-group').removeClass('has-error');
         label.remove();
      },

      submitHandler: function(form) {

         var SignupFormGroup = $(".validateSignForm").serialize().split("&");

         var SignupData = new FormData();

         for(var i in SignupFormGroup) {
            var SignupParams = SignupFormGroup[i].split("=");
            SignupData.append( SignupParams[0], decodeURIComponent( SignupParams[1]) );
         }
         SignupData.append( 'salt_key', '{{Helper::getSaltKey()}}');
         SignupData.append( 'country_code', $('.signup_phone').intlTelInput('getSelectedCountryData').dialCode );

         if(($('input[name=picture][type=file]')[0].files).length > 0) {
            SignupData.append('picture', $('input[name=picture][type=file]')[0].files[0]); 
         }
         $.ajax({
            url: getBaseUrl() + "/user/signup",
            type: "post",
            data: SignupData,
            processData: false,
            contentType: false,
            beforeSend: function() {
               showLoader();
            },
            success: function(response, textStatus, jqXHR) {
               var data = parseData(response);
               setToken("user", data.responseData.access_token);
               setUserDetails(data.responseData.user);
               document.cookie="user_language="+data.responseData.user.language+"; path=/";
               window.location.replace("{{ url('/home') }}");
               hideLoader();
            },
            error: function(jqXHR, textStatus, errorThrown) {
               hideLoader();
               alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
            }
         });

      }
   });

});
</script>

@stop
