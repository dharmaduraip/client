<!DOCTYPE html>
<html>
   <head>
      <title>
      {{ Helper::getSettings()->site->site_title }}
      </title>
      <meta charset='utf-8'>
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <meta content='website' property='og:type'>
      <link rel="shortcut icon" type="image/png" href="{{ Helper::getFavIcon() }}"/>
      @section('styles')
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css')}}">
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/landing.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/stylesheet.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/owl-carousel/css/owl.carousel.min.css')}}"/>  
      <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/slick/css/slick.min.css')}}"> -->
      <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/slick/css/slick-theme.min.css')}}"> -->
      <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/icons/css/ionicons.min.css')}}"/> -->
      <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/icons/css/linearicons.css')}}"/> -->
      
      <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-mobile.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-tab.css')}}"/>
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/media-lap.css')}}"/> -->
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/swiper/swiper.min.css')}}"/>
      <!-- <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/animate.css')}}"/> -->
      @show
      <link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/stylesheet.css')}}"/>

   </head>
   <body class='index'>
      @include('common.web.includes.header')
      @yield('content')
      @include('common.web.includes.footer')
      @section('scripts')
      <script type="text/javascript" src="{{ asset('assets/plugins/jquery-3.3.1.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/popper.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
      <!-- <script type="text/javascript" src="{{ asset('assets/plugins/slick/js/slick.min.js')}}"></script> -->
      <script type="text/javascript" src="{{ asset('assets/plugins/owl-carousel/js/owl.carousel.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/swiper.jquery.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/plugins/screen.js')}}"></script>
      <script type="text/javascript" src="{{ asset('assets/layout/js/script.js')}}"></script>

      <script>
       
         function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
         }

         function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
         }

         function openToggle() {
            document.getElementById("toggle-bg").style.width = "100%";
            document.getElementById("sideToggle").style.right = "-10px";
         }

         function closeToggle() {
            document.getElementById("toggle-bg").style.width = "0";
            document.getElementById("sideToggle").style.right = "-640px";
         }

         
      </script>
      @if(Helper::getChatmode() == 1)
      <!-- Start of LiveChat (www.livechatinc.com) code -->
      <script type="text/javascript">
         window.__lc = window.__lc || {};
         window.__lc.license = 8256261;
         (function() {
         var lc = document.createElement('script'); lc.type = 'text/javascript'; lc.async = true;
         lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
         var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(lc, s);
         })();
      </script>
      
      <!-- End of LiveChat code -->
      @endif
      @show
   </body>
</html>
