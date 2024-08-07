@extends('common.provider.layout.auth')
@section('styles')
@parent
@stop
@section('content')
@include('common.alert')
      <section id="login-form"  >
         <div class="login-bg ">
            <div class="login-content">
         <div class="logo-section dis-center">
         <a href="{{URL::to('')}}">
            <img src="{{ Helper::getSiteLogo() }}" class="" width="100" alt="logo">
         </a>
            </div>
                  <div class="row d-flex align-items-center">
                    
                     <div id="login" class="h-100 col-sm-12 col-md-12 col-lg-12 col-xl-12 dis-column  ">
                        <h5 class="mb-3">@lang('auth.welcome_login')</h5>
                           
                        <form class="col-sm-12 col-md-12 col-lg-12 validateForm">
                        <div id="toaster" class="toaster"></div>

                           <div class="col-sm-12 col-md-12 col-lg-12 p-0 dis-column">

                           <h6 class="txt-primary text-center"><strong>@lang('auth.login-with')</strong></h6>
                           <div class="choose-mode mb-3 col-sm-12 col-md-12 col-lg-12">
                              <span class="radio-box"><input type="radio" checked="checked" name="filter" value="phone" id="filt1-4"><label for="filt1-4">@lang('auth.phone_number')</label></span>
                              <span class="radio-box"><input type="radio" name="filter" value="email" id="filt1-5"><label for="filt1-5">@lang('auth.email')</label></span>
                           </div>

                           <div class="col-sm-12 p-0">
                              <input id="email" name="email" class="form-control required email mb-4" style="display:none" placeholder="@lang('auth.email_address')" type="email" aria-required="true">
                           </div>
                           <div class="col-sm-12 p-0">
                              <input id="mobile" name="mobile" maxlength="15" class="intl-tel phone  phones form-control mb-4" placeholder="@lang('auth.phone_number')"  type="text" >
                           </div>
                           <div class="col-sm-12 p-0">
                              <input id="password" name="password" class="form-control mb-4" value="" placeholder="@lang('auth.password')" type="password">
                           </div>  
                              

                              <!-- <div class="col-sm-12 p-0">
                              <input type="text" id="phone" class="intl-tel phone form-control mb-4" placeholder="Phone Number" >
                              </div> -->
                              <button type="submit" class="btn btn-primary mb-4 login">@lang('auth.login')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></button>
                           </div>
                       
                        
                        </form>
                        
                        <span>@lang('auth.do_not_account') <strong><a href="{{url('/provider/signup')}}" class="signup-link">@lang('auth.signup')</a></strong></span>
                        <span>@lang('auth.forgot_password')<strong><a href="{{url('/provider/forgot-password')}}" class="signup-link">@lang('auth.reset_here')</a></strong></span>
                        @if(Helper::getSettings()->site->social_login == 1)
                        <div class="or-section mt-4 mb-4">
                           <hr>
                           <span>@lang('auth.or')</span>
                           <hr>
                        </div>
                        <div class="social-login">
                           <span class="fb-bg" onclick="fbLogin()"><i class="fa fa-facebook-square "></i></span>
                           <span id="glogin" class="google_login google-bg "><i class="fa fa-google-plus-square "></i></span>
                     </div>
                        <!-- <a onclick="fbLogin()" class="btn btn-primary btn-block mb-2 d-flex align-items-center justify-content-center">Facebook <i class="fa fa-facebook-square ml-3"></i></a>
                        <a id="glogin" class="btn btn-primary btn-block d-flex align-items-center justify-content-center">Google <i class="fa fa-google-plus-square ml-3"></i></a> -->
                        @endif
                        <div class="copyrights">
                        <p>{!! Helper::getSettings()->site->site_copyright !!}</p>
                     </div>
                     </div>
                     <div id="social-login" class="h-100 col-sm-12 col-md-12 col-lg-12 dis-column pt-5 pb-5 login-section d-none ">
                        <h5 class="mb-3">@lang('auth.welcome_login')</h5>
                           
                        <form class="col-sm-12 col-md-12 col-lg-12">
                           <div id="toaster" class="toaster"></div>
                           <div class="col-sm-12 col-md-12 col-lg-12 p-0">
                           <div class="col-sm-12 p-0">
                           <input id="mobile" name="mobile" maxlength="15" autocomplete="off" class="intl-tel phone form-control mb-4 d-none" placeholder="Phone Number"  value="" type="text" >
                           </div>
                           <div class="col-sm-12 p-0">
                           <input id="email" name="email" autocomplete="off" class="form-control mb-4 d-none" placeholder="E-mail Address"  value="" type="email" aria-required="true">
                           </div>
                           <div class="col-sm-12 p-0">
                           <select name="gender" id="gender" class="w-100 mb-3 d-none" autocomplete="off">
                              <option value="">@lang('auth.select_gender')</option>
                              <option value="MALE">@lang('auth.MALE')</option>
                              <option value="FEMALE">@lang('auth.FEMALE')</option>
                              <option value="GENERAL">@lang('auth.GENERAL')</option>
                           </select>
                           </div>  
                           <div class="col-sm-12 p-0">
                           <select id="country" name="country_id" autocomplete="off" class=" mb-4 form-control d-none">
                              <option value="">@lang('auth.select_country')</option>
                           </select>
                           </div> 
                           <div class="col-sm-12 p-0">
                           <select id="city" name="city_id" autocomplete="off" class=" mb-4 form-control d-none">
                              <option value="">@lang('auth.select_city')</option>
                           </select>
                           </div> 
                              

                              <!-- <div class="col-sm-12 p-0">
                              <input type="text" id="phone" class="intl-tel phone form-control mb-4" placeholder="Phone Number" >
                              </div> -->
                           </div>
                        <a class="btn btn-block btn-green btn-md mb-4 social_login">@lang('auth.submit')<i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
                        
                        </form>
                        
                        
                     </div>
                  </div>
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
      if(email != "" && typeof email != 'undefined') {
         formData.append('email', email);
      }
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

               $('#login').addClass('d-none');
               $('#social-login').removeClass('d-none');

               var validators = data.responseData.validators;

               for(var i in validators) {
                  $('#social-login.login-section').find('[name='+validators[i]+']').removeClass('d-none');
               }

               $('.social_login').on('click', function() {
                  

                  $('#social-login.login-section input, #social-login.login-section select').each(function() {
                     if($(this).val() == "" && $(this).is(':visible') ) {
                        $('.social_error').remove();
                        $('#social-login.login-section').prepend(`<span class="social_error" style="padding: 5px; color: red;">The `+ (($(this).attr('name')).replace(/_/g, ' ')).replace(/id/g, '') +` is required</span>`);
                        return false;
                     } else if($(this).val() != "") {
                        formData.append($(this).attr('name'), $(this).val());
                     }
                  });

                  formData.append( 'country_code', $('#social-login.login-section').find('.phone').intlTelInput('getSelectedCountryData').dialCode );

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
                           document.cookie="provider_language="+newData.responseData.user.language+"; path=/";
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
               document.cookie="provider_language="+data.responseData.user.language+"; path=/";
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

   function getFbUserData(){
      FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
      function (response) {
         saveData(response.id, 'FACEBOOK', response.first_name, response.last_name, response.email, response.picture.data.url);
      });
   }
@endif

$(document).ready(function() {

   var base_url_data = JSON.parse(decodeHTMLEntities('{{$base}}')); 

   for(var i in Object.keys(base_url_data)) {
      var key = String(Object.keys(base_url_data)[i]);
      var value = String(Object.values(base_url_data)[i]);
      localStorage.setItem(key, value);
   }

   setBaseUrl('{{$base_url}}');

   $(".phone").intlTelInput({
      //initialCountry: "<?php echo isset(Helper::getSettings()->site->country_code)?Helper::getSettings()->site->country_code :'in'; ?>",
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

   var formGroup = $(".validateForm").serialize().split("&");

   var data = new FormData();

   for(var i in formGroup) {
      var params = formGroup[i].split("=");
      data.append( params[0], decodeURIComponent(params[1]) );
   }

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
               data.append( 'country_code', $('.phones').intlTelInput('getSelectedCountryData').dialCode );
            }
            

            data.append( 'salt_key', '{{Helper::getSaltKey()}}');

            $.ajax({
               url: getBaseUrl() + "/provider/login",
               type: "post",
               data: data,
               processData: false,
               contentType: false,
               beforeSend: function() {
                  showLoader();
               },
               success: function(response, textStatus, jqXHR) {
		            var response = parseData(response);
                  setToken("provider", response.responseData.access_token);
                  setProviderDetails(response.responseData.user);
                  document.cookie="provider_language="+response.responseData.user.language+"; path=/";
                  window.location.replace("{{ url('/provider/home') }}");
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
