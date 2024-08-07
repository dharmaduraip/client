{{ App::setLocale(  isset($_COOKIE['user_language']) ? $_COOKIE['user_language'] : 'en'  ) }}
<!DOCTYPE html>
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
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}">
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/icons/css/ionicons.min.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/icons/css/linearicons.css')}}"/>
      <link rel='stylesheet' href="https://fonts.googleapis.com/icon?family=Material+Icons" />
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-mobile.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-tab.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-lap.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/animate.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" />
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" />
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/clockpicker-wearout/css/jquery-clockpicker.min.css')}}"/>
      @show
     
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/stylesheet.css')}}"/>
      
     
      @if(@Request::segment(1)=='store' && @Request::segment(2) !='order' )
       <link rel='stylesheet' type='text/css' href="{{ asset('assets/foody/foody.css')}}"/>
      @elseif(@Request::segment(1)=='store' && @Request::segment(2)=='order')

      
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/foody/foody.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/provider.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/>
        <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/> -->
      @else
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/provider.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/user.css')}}"/>
      @endif
   </head>
   <body>
      @include('common.user.includes.header')
      @include('common.user.includes.nav')
      @yield('content')
      @include('common.user.includes.footer')
      <script>
         window.room = '{{base64_decode(Helper::getSaltKey())}}';
         window.socket_url = '{{Helper::getSocketUrl()}}';
         window.base_url = '{{ env('BASE_URL') }}';
         window.country_id = '{{ json_encode(Helper::getAccessKey()) }}';
      </script>
      @section('scripts')
      <script>!function(e,o,t){e[t]=function(n,r){var c={sandbox:"https://sandbox-merchant.revolut.com/embed.js",prod:"https://merchant.revolut.com/embed.js",dev:"https://merchant.revolut.codes/embed.js"},d=o.createElement("script");d.id="revolut-checkout",d.src=c[r]||c.prod,d.async=!0,o.head.appendChild(d);var s={then:function(r,c){d.onload=function(){r(e[t](n))},d.onerror=function(){o.head.removeChild(d),c&&c(new Error(t+" is failed to load"))}}};return"function"==typeof Promise?Promise.resolve(s):s}}(window,document,"RevolutCheckout");</script>

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
      @show
      <script>

         if(getToken("user") == null) {
            //window.location.replace("{{ url('/login') }}");
         }

         window.url = '{{url("")}}';
         window.env = "{{(env('APP_ENV'))}}";

         checkAuthentication("user");

         $(document).ready(function() {
            var userSettings = getUserDetails();

            if(userSettings.id == 0) {
               if(typeof userSettings.city_id == "undefined") {
                 window.location.replace("{{ url('/home') }}");
               }
               $('.header-submenu .dropdown-item, .menu-two, .menu-three, .menu-four').remove();

               $('.header-submenu').append(`<a class="dropdown-item" href="{{ url('/login') }}"><i class="material-icons">account_circle</i> Login</a>`);
               
            }

            $(".user_name").text(userSettings.first_name.substr(0,9));
            // $(".user_name").text($(this).text().substr(0, )+'...');



            $(".user_image").attr('src', userSettings.picture ? userSettings.picture : "{{asset('assets/layout/images/admin/avatar.jpg')}}" );
         });

         /* function showLoader() {
            if($('body').find('span.loader').length == 0) {
               $('body').append(`<span class="loader" style="position: fixed; left: 50%; top: 30%; transform: translate(-50%, 0); z-index: 99;"><img style="width: 100px" src="{{ asset('assets/layout/images/common/loader.gif') }}" /></span>`);
            }
         }

         function hideLoader() {
            if($('body').find('span.loader').length > 0) {
               $('body').find('span.loader').remove();
            }
         } */
         @if(count(Helper::getServiceList()) > 1)
         $('#history-detail').click(function() {
            $(".subnav").toggle();  
         }); 
         @endif
          //For notification details
      $('.notification').on('click', function(){
         $.ajax({
            url: getBaseUrl() + "/user/notification",
            type: "GET",
            beforeSend: function() {
            showInlineLoader();
            },
            headers: {
               Authorization: "Bearer " + getToken("user")
            },
            success:function(data){
               var html = ``;
               var result = data.responseData.notification.data;
               if(result.length>0){
                     //$('#notification_count').text(result.length);
                     $.each(result,function(key,item){
                        console.log(item);
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
               }else{
                  var html = `No Notifications`;
               }
               $('#notification_detail').html(html);
               hideInlineLoader();
            } 
         }); 
      });
      //For refering user Concept
      $('.referdetail').on('click', function(){
         $.ajax({
            url: getBaseUrl() + "/user/profile",
            type: "GET",
            headers: {
               Authorization: "Bearer " + getToken("user")
            },
            success:function(data){
               var result = data.responseData.referral;
               $('.referal_code').text(result.referral_code); 
               $('.referal_count').text(result.referral_count); 
               $('.referal_amount').text(result.referral_amount); 
               $('.user_referal_count').text(result.user_referral_count); 
               $('.user_referal_amount').text(data.responseData.currency_symbol +' '+result.user_referral_amount);
               $('.currency').text(data.responseData.currency_symbol);
                
            } 
         }); 
      }); 

      $('#invite').on('click', function(e){
         e.preventDefault();
         var referral_email = $('input[name=referral_email]').val();

         if(referral_email != "" && validateEmail(referral_email)) {
            var referral_code = $('.referal_code').text(); 
            window.location.replace("mailto:"+referral_email+"?subject=Invitation to join {{ Helper::getSettings()->site->site_title }}&body=Hi,%0A%0A I found this website and thought you might like it. Use my referral code("+ referral_code +") on registering in the application.%0A%0AWebsite: {{url('/')}}/login %0AReferral Code:"+referral_code);
         } else {
            alertMessage("Error", "Please enter a valid email", "danger");
         }
         
      });


   </script>
   @if(Helper::getChatmode() == 1)
      <!-- Start of LiveChat (www.livechatinc.com) code -->
      <script type="text/javascript"  src="{{ asset('assets/layout/js/common-chat.js') }}"></script>
      <!-- End of LiveChat code -->
   @endif
   </body>
</html>
