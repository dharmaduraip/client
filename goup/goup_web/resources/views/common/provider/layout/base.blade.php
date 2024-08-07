{{ App::setLocale(   isset($_COOKIE['provider_language']) ? $_COOKIE['provider_language'] : 'en'  ) }}
<html>
   <head>
      <title>
      {{ __(Helper::getSettings()->site->site_title) }}
      </title>
      <meta charset='utf-8'>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <meta content='website' property='og:type'>
      <link rel="shortcut icon" type="image/png" href="{{ Helper::getFavIcon() }}"/>
      @section('styles')
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}"/>
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/owl-carousel/css/owl.carousel.min.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons"  rel="stylesheet">
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/clockpicker-wearout/css/jquery-clockpicker.min.css')}}"/>
      @show

      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/stylesheet.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/provider.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/>
      
   </head>
   <body>
   <div id="toaster" class="toaster">
      </div>
      @include('common.provider.includes.nav')
      @include('common.provider.includes.header')
      @yield('content')
      @include('common.provider.includes.footer')
      @section('scripts')
      <script type="text/javascript" src="{{ asset('assets/plugins/jquery-3.3.1.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/popper.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>

      <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
      <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}" ></script>

      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/clockpicker-wearout/js/jquery-clockpicker.min.js') }}"></script>
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
      
      <script src="{{ asset('assets/layout/js/script.js')}}"></script>
      <script src="{{ asset('assets/layout/js/api.js')}}"></script>
       <script>!function(e,o,t){e[t]=function(n,r){var c={sandbox:"https://sandbox-merchant.revolut.com/embed.js",prod:"https://merchant.revolut.com/embed.js",dev:"https://merchant.revolut.codes/embed.js"},d=o.createElement("script");d.id="revolut-checkout",d.src=c[r]||c.prod,d.async=!0,o.head.appendChild(d);var s={then:function(r,c){d.onload=function(){r(e[t](n))},d.onerror=function(){o.head.removeChild(d),c&&c(new Error(t+" is failed to load"))}}};return"function"==typeof Promise?Promise.resolve(s):s}}(window,document,"RevolutCheckout");</script>
      @show
      <script>
         window.salt_key = '{{ Helper::getSaltKey() }}';
         window.room = '{{base64_decode(Helper::getSaltKey())}}';
         window.socket_url = '{{Helper::getSocketUrl()}}';
         window.url = '{{url("")}}';
         window.env = "{{(env('APP_ENV'))}}";
         window.base_url = '{{ env('BASE_URL') }}';
         window.country_id = '{{ json_encode(Helper::getAccessKey()) }}';
         if(getToken("provider") == null) {
            window.location.replace("{{ url('/provider/login') }}");
         }

         checkAuthentication("provider");

         $(document).ready(function() {
            var providerSettings = getProviderDetails();
            $(".provider_name").text(providerSettings.first_name);
            $(".provider_image").attr('src', providerSettings.picture ? providerSettings.picture : "{{asset('assets/layout/images/admin/avatar.jpg')}}" );
         });
         //For refering user Concept
         $('.referdetail').on('click', function(){
            $.ajax({
               url: getBaseUrl() + "/provider/profile",
               type: "GET",
               headers: {
                  Authorization: "Bearer " + getToken("provider")
               },
               success:function(data){
                  var result = data.responseData.referral;
                  var id = data.responseData.id;
                  $('.referal_code').text(result.referral_code); 
                  $('.referal_count').text(result.referral_count); 
                  $('.referal_amount').text(result.referral_amount); 
                  $('.user_referal_count').text(result.user_referral_count); 
                  $('.user_referal_amount').text(result.user_referral_amount);
                  $('.currency').text(data.responseData.country.country_currency);
                  $('.id').text(id);  
               } 
            }); 
         });

         $('#invite').on('click', function(e){
            e.preventDefault();
            var referral_email = $('input[name=referral_email]').val();

            if(referral_email != "" && validateEmail(referral_email)) {
               var referral_code = $('.referal_code').text(); 
               window.location.replace("mailto:"+referral_email+"?subject=Invitation to join {{ Helper::getSettings()->site->site_title }}&body=Hi,%0A%0A I found this website and thought you might like it. Use my referral code("+ referral_code +") on registering in the application.%0A%0AWebsite: {{url('/')}}/provider/login %0AReferral Code:"+referral_code);
            } else {
               alertMessage("Error", "Please enter a valid email", "danger");
            }
            
         });

         //for notification
         $('.notification').on('click', function(){
            $.ajax({
               url: getBaseUrl() + "/provider/notification",
               type: "GET",
               headers: {
                  Authorization: "Bearer " + getToken("provider")
               },
               success:function(data){
                  var html = ``;
                  var result = data.responseData.notification.data;
                  if(result.length>0){
                     //$('#notification_count').text(result.length);
                     $.each(result,function(key,item){
                       html += `<div class="col-md-12 col-lg-12 col-sm-12 p-0">
                              <ul class="provider-list invoice">
                                 <li class="row">
                                   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                          <img src=`+item.image+` height="" width=""  class="user-img img-fluid">
                                       </div>
                                       <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-0" >
                                          <div class="user-right mt-4">
                                             <h5 class="d-inline"> `+item.title+`</h5> 
                                          </div>
                                       
                                          <div class="user-right">
                                                `+item.descriptions+`
                                          </div>
                                          <div class="user-right">
                                                <small>Valid Till: `+item.expiry_time+`</small>
                                          </div>                                                 
                                    </div>
                                 </li>                             
                              </ul>
                           </div>`; 
                     });
                  }
                  $('#notification_detail').html(html);
               } 
            }); 
         }); 
   </script>
   @if(Helper::getChatmode() == 1)
      <!-- Start of LiveChat (www.livechatinc.com) code -->
      <script type="text/javascript"  src="{{ asset('assets/layout/js/common-chat.js') }}"></script>
      <!-- End of LiveChat code -->
      @endif
   </body>
</html>
