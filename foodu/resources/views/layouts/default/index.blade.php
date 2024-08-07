<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> {!! CNF_APPNAME !!} </title>
    <meta name="keywords" content="{!! CNF_METAKEY !!}">
    <meta name="description" content="{!! CNF_METADESC !!}"/>
    <meta name="google-signin-client_id" content="{!! CNF_GOOGLE_Client_ID !!}">
    <meta name="facebook-appkey" content="{!! F_APP_KEY !!}">

    <link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">
    <!-- CSS Files -->
    {{-- <link href="{{ asset('sximo5/fonts/awesome/css/font-awesome.min.css')}}" rel="stylesheet"> --}}
    <link href="{{ asset('frontend/default/css/style.css')}}" rel="stylesheet">
    {{-- <link href="https://grozo.s3.ap-south-1.amazonaws.com/grozo+css/default/style.min.css" rel="stylesheet"> --}}

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    {{-- <link href="{{ asset('sximo5/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.carousel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/assets/owl.theme.default.css">
    <link rel="stylesheet" href="{{ asset('sximo5/css/front/style.css') }}">
    {{-- <link rel="stylesheet" href="https://grozo.s3.ap-south-1.amazonaws.com/grozo+css/front/style.css"> --}}
    <link rel="stylesheet" href="{{ asset('sximo5/css/front/static-style.min.css') }}">
    {{-- <link rel="stylesheet" href="https://grozo.s3.ap-south-1.amazonaws.com/grozo+css/front/static-style.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.2.0/css/all.min.css"/>
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css"> --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('sximo5/css/front/front.min.css') }}"> 
    <!-- <link rel="stylesheet" type="text/css" href="https://grozo.s3.ap-south-1.amazonaws.com/grozo+css/front/front.min.css"> -->
    
    @yield('css')
 
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/owl.carousel.min.js"></script>--}}
    <script type="text/javascript" src="{{ asset('sximo5/js/front/abserve.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('sximo5/js/front/loginsignup.js') }}" defer></script>
   
    <!-- CSS Just for demo purpose, don't include it in your project --> 
    {{-- <script type="text/javascript" src="{{ asset('sximo5/sximo.min.js') }}"></script> --}}
    <script type="text/javascript">
        var base_url    = "<?php echo URL::to('/').'/'; ?>";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
    @if(\Request::segment(1) != '' && \Request::segment(1) == 'details')
    <script type="text/javascript">
        var loader      = `@include("front.list.detailpage.loader")`;
        var cartloader  = `@include("front.list.detailpage.rightside_loader")`;
    </script>
    {{-- <script type="text/javascript" src="{{ asset('sximo5/js/front/detail.js') }}"></script> --}}
    @endif
    {{-- <script type="text/javascript" src="{{ asset('frontend/default/js/default.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="https://grozo.s3.ap-south-1.amazonaws.com/grozo+js/default/default.min.js"></script> --}}
    <script type="text/javascript" src="{{ asset('sximo5/js/plugins/parsley.js') }}"></script>
    {{-- <script type="text/javascript" src="https://grozo.s3.ap-south-1.amazonaws.com/grozo+js/plugins/parsley.js"></script>  --}}
    {{-- <script type="text/javascript" src="https://grozo.s3.ap-south-1.amazonaws.com/grozo+js/plugins/parsley.mini.js"></script>  --}}
    <script type="text/javascript" src="{{ asset('sximo5/js/jquery.mixitup.min.js') }}"></script>
    {{-- <script type="text/javascript" src="https://grozo.s3.ap-south-1.amazonaws.com/grozo+js/jquery.mixitup.min.js"></script> --}}
    <script src="{{ asset('sximo5/js/plugins/jquery.validate.min.js') }}"></script>
    {{-- <script src="https://grozo.s3.ap-south-1.amazonaws.com/grozo+js/plugins/jquery.validate.min.js"></script> --}}
    {{-- <script src="{!! asset('sximo5/js/front/jquery.validate.min.js') !!}"></script> --}}
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
    </script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js">
    </script>
    <![endif]-->
    <!-- social media login -->
    <script type="text/javascript">
        /*--------lazy image load sripts-----------*/
        $ (document).ready(function() {
            if ('loading' in HTMLImageElement.prototype) {
                const images    = document.querySelectorAll('img[loading="lazy"]');
                images.forEach(img => {
                    img.src     = img.dataset.src;
                });
            } else {
                const script    = document.createElement('script');
                script.src      ='https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
                document.body.appendChild(script);
            }
        });
        /*--------lazy image load sripts end-----------*/ 
    </script>
    @if(\Auth::check() == false)

    <!-- Google -->
    <script type="text/javascript">
        /*--------lazy image load sripts-----------*/
            $(document).ready(function(){
                if ('loading' in HTMLImageElement.prototype) {
                    const images = document.querySelectorAll('img[loading="lazy"]');
                    images.forEach(img => {
                    img.src = img.dataset.src;
                    });
                }
                else {
                    const script = document.createElement('script');
                    script.src ='https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.2/lazysizes.min.js';
                    document.body.appendChild(script);
                }
            });
        /*--------lazy image load sripts end-----------*/
        var userData = {};
        function check_exists()
        {
            console.log(userData);            
            $.ajax({
                type : 'POST',
                dataType : 'json',
                url:base_url+"user/checksocial",         
                data : {'social_id':userData['id'],'from':userData['from']},
                success: function (data) {
                    if(data.result == 0 && data.msg == 'NO-ACCOUNT'){
                        // EMAIL NOT EXISTS           
                        $('.clickshow').trigger('click');
                        $('#google_success').fadeIn('slow');
                        $('.google_thanks').html("Few More Steps! Please enter your mobile number");
                    } else if(data.msg == 'noaccess') {
                        // EMAIL EXISTS LOGIN 
                        $('.clicksignin').trigger('click');
                        $(".loginerror").html('<font color="red">Please verify your Account!</font>');
                        setTimeout(function(){$(".loginerror").html('');},3000);
                    }else if(data.msg == 'success')
                    {
                        $("#login_check").show();
                        if(data.redirect != ''){
                            window.location.href = base_url+data.redirect;
                        }else{
                            location.reload();
                        }  
                    }else {
                        $(".loginerror").html('<font color="red">'+data.msg+'</font>');
                        setTimeout(function(){$(".loginerror").html('');},3000);
                    }

                } 
            }); 
        }

        function onSuccess(googleUser)
        {
            var profile = googleUser.getBasicProfile();
            userData['name'] = profile.getName();         
            userData['imageURL'] = profile.getImageUrl();
            userData['email'] = profile.getEmail();            
            userData['id'] = profile.getId();            
            userData['from'] = 'gmail';
            check_exists();
            googleUser.disconnect();
            // socialMediaLog(userData);            
            var auth2 = gapi.auth2.getAuthInstance();      
            auth2.signOut().then(function () {
            });
        }

        function onFailure(error) {
        }

        function renderButton() {
            gapi.signin2.render('my-signin2', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess': onSuccess,
                'onfailure': onFailure
            });
            gapi.signin2.render('my-signin3', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess': onSuccess,
                'onfailure': onFailure
            });
        }
    </script>
    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    <!-- Face book -->
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({   
                appId      : '{!! F_APP_KEY !!}',
                cookie     : true,
                xfbml      : true,
                version    : 'v2.8'
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


        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        }

        function statusChangeCallback(response) {
            if (response.status === 'connected') {
                FB.api('/me?fields=email,name', function (response) {
                    userData['id'] = response.id;
                    userData['name'] = response.name;
                    userData['email'] = response.email;
                    userData['from'] = 'fb';
                    check_exists();
                    //   socialMediaLog(userData);
                });
            } else {

            }
        }

        function socialMediaLog(userData){
            $.ajax({
                type : 'post',
                url  : base_url+'user/socialmedia',
                dataType : 'json',
                data : { userData : userData },
                success : function(res){
                    location.reload();
                }
            });
        }
    </script>
@endif
</head>
<body class="abserve FoodStar">
    <div class="loader_event" style="display: none;"> </div>
    <div  class="overlay" ></div>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <div id="overlayer">
        <div class="preloader" style=" position: fixed;width: 100%;height: 100%;top: 0;left: 0;z-index: 100000;backface-visibility: hidden;background: #ffffff;">
            <div class="lottie-parent" style="top: -10%;">
                <lottie-player src="{{ \URL::to('sximo5/js/front/mygrozo5.json') }}"  background="transparent"  speed="1"  style="margin: auto;width: 100%;text-align: center;"  loop autoplay></lottie-player>
            </div>
        </div>
    </div>
    @include('layouts.default.header')
    @if(\Request::segment(1) != '' && \Request::segment(2) != 'checkout')
    <?php
        if(\Auth::check()){
            $aSavedAddress = \App\Models\Useraddress::select('id','address_type','building','landmark','address','lat','lang','city','state')->where('user_id',\Auth::user()->id)->where('del_status','0')->get()->map(function($result){
                return $result->append('address_type_text');
            });
        } else {
            $aSavedAddress = [];
        }
    ?>
    <div id="leftSidenav" class="left-menu">
        <div class="closebtn">
            <!--  <i class="fas fa-times closeicon"></i> -->
            <i class="closefilter closeicon2"></i>
        </div>
        <div class="leftinputbox">
            <input type="text"  name="fn_keyword" id="fn_keyword"  placeholder="Search for area, street name.." class="inputsearch">
            <input type="hidden" name="lat" id="lat" value="">
            <input type="hidden" name="lang" id="lang" value="">
            <input type="hidden" name="city" id="city" value="">
        </div>
        <div class="leftinputbox1">
            <div class="loctext">
                <p>
                    <a href="javascript:void(0);" class="locate_me">
                        <span class="locicon">
                            <i class="fas fa-crosshairs iconsze"></i>
                        </span>
                        <span class="locp">Get current location</span>
                    </a>
                </p>
                <p class="pace">Using GPS</p>
            </div>
        </div> 
        <div class="leftinputbox1 no_res_msg" style="display: none;"><font color="red">Sorry! We don't serve at your location currently.</font></div>



        <div class="leftinputbox saved_adrs" style="cursor: pointer;">
            <div class="save_addr">SAVED ADDRESSES</div>
            @if(count($aSavedAddress) > 0)
            @foreach($aSavedAddress as $adrs)

            <div class="add_parent">
                <p><i class="{!! $adrs->address_type_icon !!}" aria-hidden="true"></i>{!! $adrs->address_type_text !!}</p>
                <span class="adrs_adrs">{!! $adrs->address !!}</span>
                <input type="hidden" name="adrs_lat" class="adrs_lat" value="{!! $adrs->lat !!}">
                <input type="hidden" name="adrs_lang" class="adrs_lang" value="{!! $adrs->lang !!}">
                <input type="hidden" name="adrs_adrs" class="adrs_adrs" value="{!! $adrs->address !!}">
                <input type="hidden" name="adrs_city" class="adrs_city" value="{!! $adrs->city !!}">
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click','.saved_adrs',function(){ 
            var adrs_lat = $(this).find('.adrs_lat').val();
            var adrs_lang = $(this).find('.adrs_lang').val();
            var adrs_adrs = $(this).find('.adrs_adrs').text(); 
            var adrs_city = $(this).find('.adrs_city').text();   
            if(adrs_city == '')
            {
                adrs_city = getCityFromLatLang(adrs_lat,adrs_lang);
                setTimeout(function(){
                    var city = $('#city').val();
                    checkaddress(adrs_lat,adrs_lang,adrs_adrs,city);
                },2000);
            }
            checkaddress(adrs_lat,adrs_lang,adrs_adrs,adrs_city);
        });
        function getCityFromLatLang(lat, lng) {
            geocoder = new google.maps.Geocoder();

            var latlng = new google.maps.LatLng(lat, lng);
            geocoder.geocode({latLng: latlng}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                  if (results[1]) {
                    var arrAddress = results;
                    $.each(arrAddress, function(i, address_component) {
                      if (address_component.types[0] == "locality") {
                        itemLocality = address_component.address_components[0].long_name;
                        $('#city').val(itemLocality);
                    }

                });
                } else {
                     "No results found";
                }
            } else {
               "Geocoder failed due to: " + status;
          }
        });
        }
    </script>
    @endif
    <div class="sessionerror">
        @if(\Request::segment(1) == 'user' && (\Request::segment(2) ==  'login' || \Request::segment(2) ==  'register'  || \Request::segment(2) ==  'reset' ))
        @else
        @if(Session::has('message'))
        <div class="container no_pad">
            {!! Session::get('message') !!}
        </div>
        @endif
    </div>
    <div class="container no_pad">
        <ul class="parsley-error-list">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @isset($pages)
    @include($pages)
    @endif
    <!-- #header -->
    @yield('content')
    {{-- <footer id="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong>{{ config('sximo.cnf_comname') }}</strong>. All right reserved
            </div>
            <div class="credits">
            </div>
        </div>
    </footer> --}}
    @if(Request::segment(2) != 'search' && !isset($_GET['appview']))
    <footer>
        <div class="foot">
            <div class="container nopad">
                <div class="row">
                    {!! \AbserveHelpers::blocks(1) !!}
                    {!! \AbserveHelpers::blocks(2) !!}
                    {!! \AbserveHelpers::blocks(3) !!}
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 foot-colum1">
                        <h4>Social Links</h4>
                        <div class="social-icon d-flex flex-wrap">
                            <a href="#" target="_blank" rel="noreferrer noopener">
                                <i class="fab fa-facebook-f fb"></i>
                            </a>

                            <a href="#" target="_blank" rel="noreferrer noopener">
                                <i class="fab fa-linkedin li"></i>
                            </a>
                            <a href="#" target="_blank" rel="noreferrer noopener">
                                <i class="fab fa-instagram ig"></i>
                            </a>
                            <a href="#" target="_blank" rel="noreferrer noopener">
                                <i class="fab fa-youtube yt"></i>
                            </a>
                        </div>
                        <div class="foot-colum1 socialiconspace ">
                            <a target="_blank" href="#" class="zoom"><img src="{{ asset('sximo5/images/themes/images/gplay.webp')}}"
                                class="bottom-image">
                            </a>
                            <a target="_blank" href="#" class="zoom"><img src="{{ asset('sximo5/images/themes/images/palystore.png')}}" class="bottom-image">
                            </a>
                        </div>
                    </div>
                    <div class="foot-bottom ">
                        <div class="container nopad">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="footcenter">
                                        <img class="footerlogo" src="{{ asset('uploads/logo.png')}}" width="230" alt="{!! CNF_APPNAME !!}">
                                        <span class="copy_right">© <?php echo date("Y");?> Tastyeats Enterprises LLP </span>
                                        {{-- <span class="bottom-pad">
                                            <a target="_blank"  class="zoom" href="javascript:void(0);"><i class="fab fa-facebook transform"></i></a>
                                            <a target="_blank" class="zoom" href="javascript:void(0);"><i class="fab fa-twitter transform"></i></a>

                                            <a target="_blank" class="zoom" href="javascript:void(0);"><i class="fab fa-instagram transform"></i></a>
                                        </span> --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </footer>
   <script type="text/javascript">
            $("#pop").click(function () {
            $('#megaoffers').modal('show'); 
        });
    </script>
    <div id="megaoffers" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
                    <!-- <iframe src="{!! URL('/').'/megaoffer?appview=1' !!}" style="width:91%;"></iframe> -->
                </div>
            </div>
        </div>
    </div>

    <?php
        $emergencyData = (object) [];
        $emergencyData = \App\Models\Location::where('id',1)->where('emergency_mode','on')->first();
    ?>
    @if(!empty($emergencyData))
    <div id="modal-pongal" class="modal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <input type="hidden" id="emergencyData" name="emergencyData" value="{{ $emergencyData->emergency_mode }}">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title"> Notice</h4>
                </div>
                <div class="modal-body">
                    <p>{{ $emergencyData->reason }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    <?php
        $offer      = (object) [];
        $offer      = \App\Models\Front\Offers::whereRaw('? between usage_from and usage_to', [date('Y-m-d')])->orWhereRaw('? between offer_from and offer_to', [date('Y-m-d')])->where('status','active')->first();
        $date       = date('Y-m-d');
        $date       = date('Y-m-d', strtotime($date));
        $begindate  = date('Y-m-d', strtotime("03/31/2022"));
        $enddate    = date('Y-m-d', strtotime("04/20/2022"));
    ?>
    @if(\Request::segment(1) == '' && ($date >= $begindate) && ($date <= $enddate))
   <!--  <div class="offer-banner" id="offer-ban">
        <div class="d-inline-block">
            <div class="offer-banner-close text-end" onclick="acceptCookieConsent();">
                <i class="fas fa-times"></i>
            </div>
                <div class="offer-img">
                    <img src="{{ asset('public/'.CNF_THEME.'/images/newyrweb.jpg')}}" alt="{{CNF_APPNAME }}" data-retina="true" class="">
                </div>
            </a>
        </div>
    </div> -->
    @endif
    @endif
    @include('layouts.default.modal')
    @include('front/modal')

    <!-- #footer -->
    <style type="text/css">
        #particles-js canvas {
            position: absolute;
            z-index: 1;
        }
        .popup_div {
            position: fixed;  top: 50%; left: 50%; z-index: 9999; background-color: #000; padding: 10px; color: #fff; border-radius: 3px; display: none;box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .loader_event {
            background: rgba(0, 0, 0, 0.5) url("{{\URL::to(CNF_THEME.'/images/loader.gif')}}") no-repeat scroll center center / 50px auto; height: 100%; left: 0; position: fixed; top: 0; width: 100%; z-index: 9999;
        };
    </style>
    
   
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.3/owl.carousel.min.js"></script>
    <script type="text/javascript" src="{{ asset('sximo5/js/front/abserve.js') }}" defer></script>
   
   
    <script type="text/javascript">
        var base_url    = "<?php echo URL::to('/').'/'; ?>";
    </script>

    @if(\Request::segment(1) != '' && \Request::segment(1) == 'details')
    <script type="text/javascript">
        var loader      = `@include("front.list.detailpage.loader")`;
        var cartloader  = `@include("front.list.detailpage.rightside_loader")`;
    </script>
    <script type="text/javascript" src="{{ asset('sximo5/js/front/detail.js') }}"></script>
    @endif
    <script type="text/javascript" src="{{ asset('frontend/default/js/default.min.js') }}" defer></script>
   
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js">
    </script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js">
    </script>
    <![endif]-->
    <!-- social media login -->
    @if(\Auth::check() == false)
    <!-- Google -->
    <script type="text/javascript">    
        var userData = {};
        function check_exists()
        {
            console.log(userData);            
            $.ajax({
                type : 'POST',
                dataType : 'json',
                url:base_url+"user/checksocial",         
                data : {'social_id':userData['id'],'from':userData['from']},
                success: function (data) {
                    if(data.result == 0 && data.msg == 'NO-ACCOUNT'){
                        // EMAIL NOT EXISTS           
                        $('.clickshow').trigger('click');
                        $('#google_success').fadeIn('slow');
                        $('.google_thanks').html("Few More Steps! Please enter your mobile number");
                    } else if(data.msg == 'noaccess') {
                        // EMAIL EXISTS LOGIN 
                        $('.clicksignin').trigger('click');
                        $(".loginerror").html('<font color="red">Please verify your Account!</font>');
                        setTimeout(function(){$(".loginerror").html('');},3000);
                    }else if(data.msg == 'success')
                    {
                        $("#login_check").show();
                        if(data.redirect != ''){
                            window.location.href = base_url+data.redirect;
                        }else{
                            location.reload();
                        }  
                    }else {
                        $(".loginerror").html('<font color="red">'+data.msg+'</font>');
                        setTimeout(function(){$(".loginerror").html('');},3000);
                    }

                } 
            }); 
        }

        function onSuccess(googleUser)
        {
            var profile = googleUser.getBasicProfile();
            userData['name'] = profile.getName();         
            userData['imageURL'] = profile.getImageUrl();
            userData['email'] = profile.getEmail();            
            userData['id'] = profile.getId();            
            userData['from'] = 'gmail';
            check_exists();
            googleUser.disconnect();
            // socialMediaLog(userData);            
            var auth2 = gapi.auth2.getAuthInstance();      
            auth2.signOut().then(function () {
            });
        }

        function onFailure(error) {
        }

        function renderButton() {
            gapi.signin2.render('my-signin2', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess': onSuccess,
                'onfailure': onFailure
            });
            gapi.signin2.render('my-signin3', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess': onSuccess,
                'onfailure': onFailure
            });
        }
    </script>
    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
    <!-- Face book -->
    <script type="text/javascript">
        window.fbAsyncInit = function() {
            FB.init({   
                appId      : '{!! F_APP_KEY !!}',
                cookie     : true,
                xfbml      : true,
                version    : 'v2.8'
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


        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                statusChangeCallback(response);
            });
        }

        function statusChangeCallback(response) {
            if (response.status === 'connected') {
                FB.api('/me?fields=email,name', function (response) {
                    userData['id'] = response.id;
                    userData['name'] = response.name;
                    userData['email'] = response.email;
                    userData['from'] = 'fb';
                    check_exists();
                    //   socialMediaLog(userData);
                });
            } else {

            }
        }

        function socialMediaLog(userData){
            $.ajax({
                type : 'post',
                url  : base_url+'user/socialmedia',
                dataType : 'json',
                data : { userData : userData },
                success : function(res){
                    location.reload();
                }
            });
        }
    </script>
    @endif

    <script type="text/javascript">
        $(window).load(function() {
            $(".preloader").delay(2000).fadeOut("slow");
            $("#overlayer").delay(2000).fadeOut("slow");
        })
        $(' li.dropdown-search').hover(function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
        }, function() {
            $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
        });

        $('.username').blur(function(){
            var uname = $(this).val();
            if (uname.length<4) {
                $('.create_user').prop('disabled','true');
                $('#uname').addClass('l_err_uname').html('Min 4 characters needed ').css('color','red');
            } else {
                $.ajax({
                    type : 'POST',
                    url:base_url+"user/checkuname",
                    data : {'uname':uname},
                    success: function (data) {
                        if(data == 1){
                            $('.create_user').prop('disabled','true');
                            $('#uname').addClass('reg_err').html('Username already exists').css('color','red');
                        }else{
                            $('.create_user').prop('disabled','');
                            $('#uname').removeClass('reg_err').html('Username ').css('color','#999');
                        }
                    } 
                });
            }
        });

        $('.firstname').blur(function(){
            var fname = $(this).val();
            if(fname.length<3){
                $('.create_user').prop('disabled','true');
                $('#fname').addClass('reg_err').html('Min 3 characters needed ').css('color','red');
            }else{
                $('.create_user').prop('disabled','');
                $('#fname').removeClass('reg_err').html('First Name').css('color','#999');
            }
        });

        $('.lastname').blur(function(){  
            var lname = $(this).val();
            if(lname.length<3){
                $('.create_user').prop('disabled','true');
                $('#lname').addClass('reg_err').html('Min 3 characters needed ').css('color','red');
            }else{
                $('.create_user').prop('disabled','');
                $('#lname').removeClass('reg_err').html('Last Name ').css('color','#999');
            }
        });

        $(document).on('click','#send_otp',function(){
            var mobile = $("#mobile_numberV").val();
            var user_id= $(this).attr('data-id');
            $(".loader_event").show();
            if(mobile!=''){
                $.ajax({
                    type : 'POST',
                    url:base_url+"mobile/user/sendotp",
                    data : {'user_id':user_id,'mobile':mobile},
                    success: function (data) {

                        var res= JSON.parse(data);
                        if(res.id == '1' || res.id == 1){
                            $(".loader_event").hide();
                            $("#mobile_numberV").hide();
                            $(".send_otp").hide();
                            $("#otpV").show();
                            $("#verify_OTP").show();
                            $(".resend_otp").show();
                        }else{
                            $(".loader_event").hide();
                            alert('Something wrong');
                        }
                    } 
                });
            }else{
                alert('Enter your mobile number');
            }
        });

        $(document).on('click','#verify_OTP',function(){
            var mobile = $("#mobile_numberV").val();
            var otp_code= $("#otpV").val();
            $(".loader_event").show();
            if(mobile!=''){
                $.ajax({
                    type : 'POST',
                    url:base_url+"mobile/user/otpverification",
                    data : {'otp_code':otp_code,'mobile':mobile},
                    success: function (data) {
                        var res= JSON.parse(data);
                        if(res.id == '1' || res.id == 1){
                            $(".loader_event").hide();
                            $("#myModalphoneverified").modal('hide');
                        }else{
                            $(".loader_event").hide();
                            alert(res.message);
                        }
                    } 
                });
            }else{
                alert('Enter your mobile number');
            }
        });
        $('.emailaddr').blur(function(){
            var email = $.trim($(this).val()); 
            var pattern = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!pattern.test(email)){
                $('.create_user').prop('disabled','true');
                $('#email').addClass('reg_err').html('Invalid Email').css('color','red');
            }else{
                $.ajax({
                    type : 'POST',
                    url:base_url+"user/checkemail",
                    data : {'email':email},
                    success: function (data) {
                        if(data == 1){
                            $('.create_user').prop('disabled','true');
                            $('#email').addClass('reg_err').html('Email address already exists').css('color','red');
                        }else{
                            $('.create_user').prop('disabled','');
                            $('#email').removeClass('reg_err').html('Email ').css('color','#999');
                        }
                    } 
                });  
            }
        });

        $('.phone').keyup(function(){
            var phone = $(this).val();
            var segment = $("#segment").val();
            if(phone.length<5){
                $('.reg_otp_check').prop('disabled','true');
                $('#phone').addClass('reg_err').html('Invalid Phone Number').css('color','red');
            }else{
                $.ajax({
                    type : 'POST',
                    url:base_url+"user/checkphone",
                    data : {'phone':phone},
                    success: function (data) {
                        if(data == 1 && segment != 'partner-with-us' && segment != 'delivery-with-us'){ 
                            $('.reg_otp_check').prop('disabled','true');
                            $('#phone').addClass('reg_err').html('Phone number already exists').css('color','red');
                        }else if(data == 1 && (segment == 'partner-with-us' || segment == 'delivery-with-us'  )){
                           $('.reg_otp_check').addClass('login_otp_check').removeClass('reg_otp_check');
                           $('.mobile-cl').val(phone);
                           $('.login_otp_check').prop('disabled','false');
                           if(segment == 'partner-with-us'){
                               $('#newpartner').val('1');
                           }
                           if(segment == 'delivery-with-us'){
                            $('#newdeliveryboy').val('1');
                        }
                       }else{
                        $('.reg_otp_check').prop('disabled','');
                        $('#phone').removeClass('reg_err').html('Phone Number ').css('color','#999');
                    }
                } 
            });    
            }
        });
        $('.mobile-cl').keyup(function(){
            var phone = $(this).val();
            checkPhone(phone);
        }); 
        $('.mobile-cl').change(function(){
            var phone = $(this).val();
            checkPhone(phone);
        });

        function checkPhone(phone){
            if(phone.length<10){
                $('.login_otp_check').prop('disabled','true');
                if(phone.length>6){
                    $('#mm').addClass('reg_err').html('Invalid Phone Number').css('color','red');
                }     
                else{
                    $('#mm').removeClass('reg_err').html('Phone Number').css('color','#999');    
                }
            } else{   
                $.ajax({
                    type : 'POST',
                    url:base_url+"user/checkphone",
                    data : {'phone':phone},
                    success: function (data) {
                        if(data == 1){
                            $('.login_otp_check').prop('disabled','');
                            $('#mm').removeClass('reg_err').html('Phone Number').css('color','#999');
                            $(document).on("keypress", "input", function(e){
                                if(e.which == 13){
                                    $(".login_otp_check").trigger('click');
                                }
                            });
                        }else{
                            $('.login_otp_check').prop('disabled','true');
                            $('#mm').addClass('reg_err').html('Phone number does not exist').css('color','red');
                        }
                    } 
                });    
            }
        }

        $('#group_id').on('change',function(){
            $('#group_id').removeClass('reg_err').css('color','#999');  
        });

        $('.phone_code').on('change',function(){
            $('.phone_code').removeClass('reg_err').css('color','#999');  
        });


        $(document).on('click','.create_user',function(e){
            var phone = $('.phone').val();
            var group_id = $('.group_id').val();
            var phone_code = $('.phone_code').val();
            var recaptcha_valid = 'true';
            var uname = $('.username').val();
            var address = $('.address').val();
            if($("#RecaptchaField1").length > 0){
                var signupcaptcha = $("#qt_hiddenRecaptcha").val();
                var response = grecaptcha.getResponse();
                if(signupcaptcha == '' || signupcaptcha == undefined){
                    recaptcha_valid = 'false';
                    $('.hidden_signup_Recaptcha_error').addClass('log_err').html('This field is required').css('color','red'); 
                } else {
                    recaptcha_valid = 'true';
                    $('.hidden_signup_Recaptcha_error').removeClass('log_err').html('');
                }
            } 
            if(group_id == ''){
                $('#group_id').addClass('reg_err').css('color','red'); 
            }
            if(phone_code == ''){
                $('.phone_code').addClass('reg_err').css('color','red'); 
            }
            if(uname == ''){
                $('#uname').addClass('reg_err').css('color','red'); 
            }
            if(phone == ''){
                $('#phone').addClass('reg_err').css('color','red'); 
            }else{
            }
            var cnt=0;
            $('.reg_err').each(function(){
                if($(this).text()!=''){
                    cnt++;
                }
            });
            if(cnt!='0'){
                $('.create_user').prop('disabled','true');
                e.preventDefault();
            } else {
                if(recaptcha_valid == 'true'){
                    $(".signup_popup_pfix").show();
                    $.ajax({
                        type : 'POST',
                        dataType : 'json',
                        url:base_url+"user/usercreate",
                        data : {'userData':userData,'uname':uname,'phone_number':phone,'phone_code':phone_code,'group_id':group_id,'address':address},
                        success: function (data) {
                            if(data.result == 'success')
                            {
                                $(".signup_popup_pfix").hide();
                                $('#user_id').val(data.user_id);
                                $('#reg_success').fadeIn('slow');
                                $('.reg_s').html(data.message);
                                $('.rightsignup').removeClass('rightsignup-active');
                                $('.overlay').prop('display','block');
                                $('.rightsignin').addClass('rightsign-active');
                                setTimeout(function(){
                                    $('#reg_success').fadeOut('slow');
                                },3000);
                                setTimeout(function(){
                                    $('.reg_s').html('');
                                },4000);
                                $('.username').val('');
                                $('.phone').val('');
                                $('.group_id').val('');
                                $('.phone_code').val('');
                                var otp = $('#mobile_otp').val();
                                var newpartner = $('#newpartner').val();
                                var newdeliveryboy = $('#newdeliveryboy').val();
                                $.ajax({
                                    url : base_url+"user/checkuser",
                                    type:"post",
                                    data : {mobile : phone,otp:otp,newpartner : newpartner,newdeliveryboy : newdeliveryboy},
                                    dataType : 'json',
                                    success: function(res){
                                        $(".signin_popup_pfix").hide();
                                        if(res.msg == 'success'){
                                            $("#login_check").show();
                                            $(".mobile_login12").hide();              
                                            if(res.redirect != ''){                
                                                window.location.href = base_url+res.redirect;
                                            }else{
                                                location.reload();
                                            }
                                        }
                                    }
                                })
                            }
                        } 
                    });
                }  
            }
        });

        var timoutException;
        $(document).on('click','.back_to_login_phone',function(){
            clearTimeout(timoutException);  
            $(".signup_popup_pfix").hide();
            $(".otp_login").fadeOut();
            $(".mobile_login").fadeIn();
            $('.login_frm').addClass('login_otp_check');
            $('.login_frm').removeClass('login_frm');
            $(".back_to_login_phone").hide();
        });
        let timerOn = true; 

        function timer(remaining) {
            clearTimeout(timoutException); 
            var m = Math.floor(remaining / 60);
            var s = remaining % 60;

            m = m < 10 ? '0' + m : m;
            s = s < 10 ? '0' + s : s;
            document.getElementById('timer_Otp').innerHTML = m + ':' + s;
            remaining -= 1;

            if(remaining >= 0 && timerOn) {
                timoutException = setTimeout(function() {
                    timer(remaining);
                }, 1000);
                return;
            }

            if(!timerOn) {
                // Do validate stuff here
                return;
            }
            // resend_login_otp
            $('#timer_Otp').addClass('resend_login_otp').html('Resend otp'); 
            $(".back_to_login_phone").fadeIn();
        }   

        function send_login_otp()   
        {
            var phone = $('.mobile-cl').val();
            var segment = $("#segment").val();
            if (phone != '')
            {
                $('.login_otp_check').prop('disabled',true);   
                $.ajax({
                    type : 'POST',
                    url:base_url+"user/checkphone",
                    data : {'phone':phone},
                    success: function (data){                
                        if(data == 1){        
                            $(".signup_popup_pfix").show();            
                            $('.login_otp_check').prop('disabled','');                 
                            $('#mm').removeClass('reg_err').html('Phone number').css('color','#999');           
                            $.ajax({
                                type : 'POST',
                                url:base_url+"user/sendotpreg",      
                                data : {'phone':phone,'website':1},
                                success: function (data) 
                                { 
                                    $(".signup_popup_pfix").hide();
                                    $(".mobile_login").fadeOut();
                                    $(".otp_login").fadeIn();
                                    $('.login_otp_check').addClass('login_frm');
                                    $('.login_otp_check').removeClass('login_otp_check');   
                                    $('#reg_success').fadeIn('slow');
                                    $('.reg_s').html("OTP sent to "+phone);
                                    $('.rightsignup').removeClass('rightsignup-active'); 
                                    setTimeout(function(){
                                        $('#reg_success').fadeOut('slow');                                                         
                                    },4000);
                                    setTimeout(function(){
                                        $('.reg_s').html('');
                                    },4000);
                                    if(segment == 'partner-with-us' || segment == 'delivery-with-us'){
                                        $('.loginhomeslide').trigger('click');
                                    }
                                },
                                error : function(err)   {
                                    $(".signup_popup_pfix").hide();
                                    $('#phone').addClass('reg_err').html('Invalid Phone Number').css('color','red');
                                }
                            });
                        }else{
                            // $('.login_otp_check').prop('disabled','true');
                            $('#mm').addClass('reg_err').html('Phone number does not exist').css('color','red');
                        }
                    } 
                });
            }else
            {
                $('#phone').addClass('reg_err').html('Phone number').css('color','red');   
            }
        }

        $(document).on('click','.login_otp_check,.resend_login_otp',function(){         
            $('#timer_Otp').removeClass('resend_login_otp');
            timer(60);
            send_login_otp();
        });

        $(document).on('click','.reg_otp_check',function(){
            var phone = $('.phone').val();
            var segment = $("#segment").val();
            if (phone != '' && phone.length == '10')
            {
                $.ajax({                             
                    type : 'POST',
                    url:base_url+"user/checkphone",
                    data : {'phone':phone},
                    success: function (data) {
                        if(data == 1){
                            $('.reg_otp_check').prop('disabled','true');
                            $('#phone').addClass('reg_err').html('Phone number already exists').css('color','red');
                            $('#phone1').addClass('reg_err').html('Phone number already exists').css('color','red');
                        }else{
                            $('.reg_otp_check').prop('disabled','');
                            if(segment == 'partner-with-us'){
                            $('#newpartner').val('1');
                             }
                            if(segment == 'delivery-with-us'){
                            $('#newdeliveryboy').val('1');
                            }
                            $('#phone').removeClass('reg_err').html('Phone Number ').css('color','#999');
                            $('#phone1').removeClass('reg_err').html('Phone Number ').css('color','#999');
                            $(".signup_popup_pfix").show();
                            $.ajax({
                                type : 'POST',
                                url:base_url+"user/sendotpreg",
                                data : {'phone':phone},
                                success: function (data) {
                                    $(".signup_popup_pfix").hide();
                                    $(".reg_1").fadeOut();
                                    $(".reg_2").fadeIn();
                                    $('.reg_otp_check').addClass('check_otp_valid');
                                    $('.reg_otp_check').removeClass('reg_otp_check');
                                },
                                error : function(err){
                                    $(".signup_popup_pfix").hide();
                                    $('#phone').addClass('reg_err').html('Invalid Phone Number').css('color','red');
                                } 
                            });
                        }
                    } 
                });
            }else
            {
                $('#phone').addClass('reg_err').html('Phone Number').css('color','red');
            }
        });

        $(document).on('click','.check_otp_valid',function(){
            var otp = $('#mobile_otp').val();
            if(otp != ''){
                if(otp.length > 4) {
                    var phone = $('.phone').val();
                    $.ajax({
                        type : 'POST',
                        url:base_url+"user/checkphoneuserotp",
                        data : {'phone':phone,'otp':otp},
                        success: function (data) {
                            if(data.result == 1) {
                                if (typeof partner_value === "undefined") {
                                    $('.check_otp_valid').addClass('create_user');
                                }else{
                                    $('.check_otp_valid').addClass('create_user1');
                                }
                                $('.check_otp_valid').removeClass('check_otp_valid');
                                $(".reg_2").fadeOut();
                                $(".reg_3").fadeIn();
                                if(userData['name'] != '')
                                {

                                    $('.username').val(userData['name']);
                                    $('.create_user').trigger('click');
                                }
                            } else {
                                $('#mobile_otp').val('');
                                $(".otp_fail").html('<font color="red">INVALID OTP!</font>');
                                setTimeout(function(){$(".otp_fail").html('');},3000);
                            }
                        } 
                    });
                } else {
                    $('#mobile_otp_err').addClass('reg_err').html('Enter Valid OTP').css('color','red');
                }
            } else {
                $('#mobile_otp_err').addClass('reg_err').html('Enter OTP').css('color','red');
            }
        });

        $(document).on('click','#otp_check',function() {
            var otp = $('#otp_verification_otp').val();
            if(otp != '') {
                var phone = $('#otp_verification_num').val();
                $.ajax({
                    type : 'POST',
                    url:base_url+"user/checkphoneotp",
                    data : {'phone':phone,'otp':otp},
                    success: function (data) {
                        if (data == 1) {
                            $('.rightotpverification').removeClass('rightsign-active');
                            $('.overlay').prop('display','block');
                            $('.rightsignin').addClass('rightsign-active');            
                        } else {
                            $('#otp_fail').show();
                        }
                    } 
                });
            } else {
                $('#otp_verification_otp_msg').addClass('reg_err').css('color','red'); 
            }
        });

        $(document).on('keyup','#otp_verification_otp',function(){
            $('#otp_verification_otp_msg').css('color','#93959f');
            $('#otp_fail').hide();
        });

        //SIGNIN
        $('.log_email').blur(function(){
            var email = $.trim($(this).val());
            var pattern =  /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if(!pattern.test(email)){
                $('#log_email').addClass('log_err').html('Invalid Email').css('color','red');
            }else{
                $.ajax({
                    type : 'POST',
                    url:base_url+"user/checkemail",
                    data : {'email':email},
                    success: function (data) {
                        if(data == 1){
                            $('#log_email').removeClass('log_err').html('Email Address').css('color','#999');
                        }else{
                            $('#log_email').addClass('log_err').html('Email Address Not exists . Please Register').css('color','red');  
                        }
                    } 
                });  
            }
        })

       /* function getCityFromLatLang(lat,lng)
        {
            geocoder = new google.maps.Geocoder();
            latlng = new google.maps.LatLng(lat,lng);
            geocoder.geocode({
                'latLng': latlng
            }, function(results, status) {
                if (status === 'OK') {
                    if (results[1]) {
                        for (var i = 0; i < results[0].address_components.length; i++) {
                            for (var b = 0; b < results[0].address_components[i].types.length; b++) {
                                switch (results[0].address_components[i].types[b]) {
                                    case 'locality':
                                    city = results[0].address_components[i].long_name;
                                    $('#city').val(city);
                                    return city;
                                    break;
                                    case 'administrative_area_level_1':
                                    state = results[0].address_components[i].long_name;
                                    break;
                                    case 'country':
                                    country = results[0].address_components[i].long_name;
                                    break;
                                }
                            }
                        }
                    } 
                } 
            });
        }*/
        $('.log_password').blur(function(){
            var password = $(this).val();
            if(password == ''){
                $('#log_password').addClass('log_err').html('Please Enter Password').css('color','red');
            }else{
                $('#log_password').removeClass('log_err').html('Password').css('color','#999');
            }
        });

        $(document).on('click','.login_frm',function(e){
            var mobile = $.trim($('.mobile-cl').val()); 
            var otp = $('#login_otp').val();
            var recaptcha_valid = 'true';
            if(otp != ''){
                if(otp.length > 4)
                {
                    if($("#RecaptchaField2").length > 0){
                        var response = grecaptcha.getResponse();
                        var signinrecaptha = $("#ct_hiddenRecaptcha").val();

                        if(signinrecaptha == '' || signinrecaptha == undefined){
                            recaptcha_valid = 'false';
                            $('.hiddenRecaptcha_error').addClass('log_err').html('This field is required').css('color','red'); 
                        } else {
                            recaptcha_valid = 'true';
                            $('.hiddenRecaptcha_error').removeClass('log_err').html('');
                        }
                    } 
                    if(mobile == ''){
                        $('#log_email').addClass('log_err').css('color','red'); 
                    }
                    var cntl=0;
                    $('.log_err').each(function(){
                        if($(this).text()!=''){
                            cntl++;
                        }
                    })
                    if(cntl!='0'){
                        e.preventDefault();
                    }else{
                        if(recaptcha_valid == 'true'){
                            $(".signin_popup_pfix").show();
                            var newpartner = $('#newpartner').val();
                            var newdeliveryboy = $('#newdeliveryboy').val();
                            $.ajax({
                                url : base_url+"user/checkuser",
                                type:"post",
                                data : {mobile : mobile,otp:otp,newpartner : newpartner,newdeliveryboy : newdeliveryboy},        
                                dataType : 'json',
                                success: function(res){
                                    $(".signin_popup_pfix").hide();
                                    if(res.msg == 'success'){
                                        $("#login_check").show();
                                        if(res.redirect != ''){
                                            window.location.href = base_url+res.redirect;
                                        }else{
                                            location.reload();
                                        }                    
                                    } else {
                                        if(res.msg == 'fail') {
                                            $(".loginerror").html('<font color="red">Your OTP was incorrect</font>');
                                            setTimeout(function(){$(".loginerror").html('');},3000);
                                        } else if(res.msg == 'noaccess') {
                                            $(".loginerror").html('<font color="red">Please verify your Account!</font>');
                                            setTimeout(function(){$(".loginerror").html('');},3000);
                                        }else {
                                            $(".loginerror").html('<font color="red">'+res.msg+'</font>');
                                            setTimeout(function(){$(".loginerror").html('');},3000);
                                        }
                                    } 
                                }
                            })
                        } 
                    }
                }else{
                    $('#login_otp_err').addClass('reg_err').html('Enter Valid OTP').css('color','red');
                }
            }else{
                $('#login_otp_err').addClass('reg_err').html('Enter OTP').css('color','red');
            }
        });

        $(document).on("keypress", "#login_otp", function(e){
            if(e.which == 13){
                if ($(this).val().length == 5)
                    $(".login_frm").trigger('click');
            }
        });

        function checkaddress(latitude,longitude,address,city='')
        {
            var rurl    = base_url+'home/nearrest_place';
            $.ajax({
                url: rurl, 
                dataType: 'json',
                type: 'post',
                data:  {'lat':latitude,'lng':longitude},
                success: function(data) {
                    if(data.result == '1'){
                        var str = window.location.search;
                        str = replaceQueryParam('lat',latitude,str);
                        str = replaceQueryParam('lang',longitude,str);
                        str = replaceQueryParam('keyword',address,str);
                        str = replaceQueryParam('city',city,str);
                        var search_url = base_url+'search'+str;
                        window.location.href = search_url;
                    } else {
                        $('#lat').val('');
                        $('#lang').val('');
                        $("#fn_keyword").val('');
                        $(".no_res_msg").show();
                        setTimeout(function(){$(".no_res_msg").hide();},5000);
                    }
                }
            });
        }

        function replaceQueryParam(param, newval, search) {
            var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
            var query = search.replace(regex, "$1").replace(/&$/, '');

            return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
        }

        $(document).on('click','.order-details',function(){
            var id = $(this).attr('data-id');
            var type = '1';
            $.ajax({
                type : 'POST',
                url : base_url+'user/allorderdetails',
                data : {id:id,type:type},
                success:function(data){
                    $('#orderModal').modal('show');
                    $('.order-content').html(data);
                }
            })
        });
    </script>
    @if(\Request::segment(2) != 'checkout' && \Request::segment(1) != 'manage_addresses')
    @php
        $keys = \AbserveHelpers::site_setting('googlemap_key');
    @endphp
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key={!! $keys->googlemap_key !!}"></script>
    @endif
    @if(\Request::segment(0) == 'checkout')
    <script type="text/javascript">
        var access_token    = '{!! $access_token !!}';
        $(document).ready(function () {
            $('.timer-cancellation-dashboard').click(function(){
                var id = $(this).attr('data-id');
                bootbox.confirm({size: "small",message: "Are you sure you want to cancel the order?",
                    buttons: { confirm: { label: 'Cancel Order', className: 'btn-danger' }, cancel: { label: 'No', } },
                    callback: function(result)
                    { 
                        if(result)
                        { 
                            $(".loader_event").show();
                            var orderId = id;
                            $.ajax({
                                url: base_url+'api/order/orderStatusChange',
                                beforeSend: function(xhr){xhr.setRequestHeader('Authorization', 'Bearer '+access_token);},      
                                type: "POST",
                                data: {'type':'user','user_type':'user','group_id':'4','order_id':orderId,'status':5 },
                                success: function(data){ 
                                    window.location.href=base_url+'account/orders';
                                }
                            });
                        }
                    }
                });
            });
            $(".forget").click(function () {
                $(".forgetsignin").toggle();
            });
            $(".backtologin").on('click',function() {
                $(".forgetsignin").hide();
            });
        });
    </script>
    @endif
   @if(\Request::segment(1) == 'orders')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.timer-cancellation-dashboard').click(function(){
             var id = $(this).attr('data-id');
             var partnerid       = $(this).attr('partner-id');
             var access_token    = '{!! $access_token !!}';
             bootbox.confirm({size: "small",message: "Are you sure you want to cancel the order?",
                buttons: { confirm: { label: 'Cancel Order', className: 'btn-danger' }, cancel: { label: 'No', } },
                callback: function(result)
                { 

                    if(result)
                    { 
                        //$(".loader_event").show();
                        var orderId = id;
                        $.ajax({
                            url: base_url+'api/order/orderStatusChange',
                            beforeSend: function(xhr){xhr.setRequestHeader('Authorization', 'Bearer '+access_token);},    

                            type: "POST",
                            data: {'type':'user','user_type':'user','group_id':'4','partner_id':partnerid,'order_id':orderId,'status':5 },
                            success: function(data){ 
                                window.location.href=base_url+'orders';
                            }
                        });
                    }
                }
            });
         });
            $(".forget").click(function () {
                $(".forgetsignin").toggle();
            });
            $(".backtologin").on('click',function() {
                $(".forgetsignin").hide();
            });     
        });
    </script>  
    @endif
    @if(\Request::segment(1) == 'contact-us')
    <script type="text/javascript">
        $(document).ready(function() {
            var latitude    = 38.555474;
            var longitude   = -95.664999;
            var roomlatlng  = {lat:parseFloat(latitude), lng: parseFloat(longitude)};
            google.maps.event.addDomListener(window, 'load', loadMap);
            function loadMap() {
                // Create the map.
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom            : 5,
                    center          : roomlatlng,
                    scaleControl    : true,
                    scrollwheel     : false,
                    disableDefaultUI: false,
                    mapTypeControl  : false,
                });
                // Add the circle for this city to the map.
                var cityCircle = new google.maps.Circle({
                    strokeColor     : '#008489',
                    strokeOpacity   : 0.8,
                    strokeWeight    : 2,
                    fillColor       : '#008489',
                    fillOpacity     : 0.35,
                    map             : map,
                    center          : roomlatlng,
                    radius          : 500
                });
            }
        });
    </script>
    @endif
    @if(\Request::segment(1) == '')
    <script type="text/javascript">
        $('.you-cart-btn').click(function(){
            $('.your_cart_block').toggleClass('active');
        });

        function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        }
        
        // Delete cookie
        function deleteCookie(cname) {
            const d = new Date();
            d.setTime(d.getTime() + (24*60*60*1000));
            let expires = "expires="+ d.toUTCString();
            document.cookie = cname + "=;" + expires + ";path=/";
        }
        // Read cookie
        function getCookie(cname) {
            let name = cname + "=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(let i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }

        function acceptCookieConsent(){
            $('.offer-banner').addClass('d-none');
            deleteCookie('user_cookie_consent');
            setCookie('user_cookie_consent', 1, 30);
            document.getElementById("offer-ban").style.display = "none";
        }

        let cookie_consent = getCookie("user_cookie_consent");
        if (cookie_consent != "") {
            document.getElementById("offer-ban").style.display = "none";
        } else {
            document.getElementById("offer-ban").style.display = "block";
        }

        $(document).on("click",'.add_cart_item',function(){
            var count = $(this).closest("div").find('.item-count').text();
            $(this).closest("div").find('.item-count').text(parseInt(count) + 1);
            var item = $(this).closest("div.menu-cart-items").attr("id");
            var item_array = item.split("_");
            add_to_cart(item_array[1],parseInt(count) + 1);
        });

        $(document).on("click",'.remove_cart_item',function(){
            var count = $(this).closest("div").find('.item-count').text();
            if(count > 0){
                $(this).closest("div").find('.item-count').text(parseInt(count) - 1);
                var item = $(this).closest("div.menu-cart-items").attr("id");
                var item_array = item.split("_");
                remove_from_cart(item_array[1],parseInt(count) - 1);
            }
        });

        /*$('.offer-banner-close').click(function(){
            $('.offer-banner').addClass('d-none');
        })*/

        /*function add_to_cart(item,qty){
            var res_id = $("#res_id").val();
            $.ajax({
                url: base_url+'checkcart',
                type: "GET",
                data: {'res_id':res_id},
                success: function(data){
                    var res_id = $("#res_id").val();
                    if (data == 0) {
                        $.ajax({
                            url: base_url+'addtotcart',
                            type: "post",
                            data: {'item':item,'res_id':res_id,qty:qty,key:"searchcart"},
                            success: function(data){
                                $('.header_menu_cart > div').html(data);
                            }
                        });
                    } else { 
                        $("#switch_cart").find('#cart_res').val(res_id); 
                        $("#switch_cart").find('#cart_item').val(item); 
                        $("#switch_cart").find('#cart_qty').val(qty); 
                        $("#switch_cart").modal("show"); 
                    } 
                } 
            }); 
        }*/

        function remove_from_cart(item,qty){ 
            var res_id = $("#res_id").val(); 
            $.ajax({ 
                url: base_url+'removefromcart', 
                type: "POST", 
                data: {'item':item,'res_id':res_id,qty:qty,key:"searchcart"}, 
                success: function(data){
                    var content=data.html;
                    $('.header_menu_cart > div').html(content);
                } 
            });
        }
    </script>
    @endif
    @if(\Request::segment(1) != '' && \Request::segment(1) != 'manage_addresses'  && \Request::segment(1) != 'checkout')
    <script type="text/javascript">
        var debounce    = function (func, wait, immediate) {
           var timeout;
           return function() {
               var context = this, args = arguments;
               var later = function() {
                   timeout = null;
                   if (!immediate) func.apply(context, args);
               };
               var callNow = immediate && !timeout;
               clearTimeout(timeout);
               timeout = setTimeout(later, wait);
               if (callNow) func.apply(context, args);
           };
       };
        var map;
        var marker;
        var myLatlng = new google.maps.LatLng($('#lat').val(),$('#lang').val());
        var geocoder = new google.maps.Geocoder();
        var infowindow = new google.maps.InfoWindow();
        $(window).load(function() {
            if(navigator.geolocation) {
                //navigator.geolocation.getCurrentPosition(geoSuccess, geoError);
            } 
            else {
                alert("Geolocation is not supported by this browser.");
            }
            function geoSuccess(position) {
                var lat     = position.coords.latitude;
                var lng     = position.coords.longitude;
                var rurl    = base_url+'home/nearrest';
                $.ajax({
                    url: rurl, 
                    type: 'post',
                    data:  {'lat':lat,'lng':lng},
                    dataType: 'json',
                    success: function(data) {
                        $("#featured-lis").html(data.result);
                        $(".abs_slider").owlCarousel({
                            navigation: true,
                            pagination: true,
                            slideSpeed: 1000,
                            stopOnHover: true,
                            autoPlay: false,
                            items: 4,
                            itemsDesktopSmall: [1024, 3],
                            itemsTablet: [600, 1],
                            itemsMobile: [479, 1]
                        });
                    }
                });
            }
            function geoError(error) {
            }
        });
        var IsplaceChange = true;
        $(document).ready(function () {
            $('.locate_me').click(function(){
                getLocation_pos();
            })
            var input = document.getElementById('fn_keyword');
            var placeVal = $("#fn_keyword").val();
            var options = {
                // componentRestrictions: {country: 'ca'},
                // types: ['(regions)'],
                componentRestrictions: {country: 'MY'},
                types: [],
            };
            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('fn_keyword'));
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place   = autocomplete.getPlace();
                var latitude  = place.geometry.location.lat();
                var longitude = place.geometry.location.lng();
                $('#lat').val(latitude);
                $('#lang').val(longitude);
                IsplaceChange = true;
                getCityFromLatLang(latitude,longitude);
                setTimeout(function afterTwoSeconds() {
                    var city = $('#city').val();
                    checkaddress(latitude,longitude,place.formatted_address,city);
                }, 500)
            });
            $("#fn_keyword").keydown(function () {
                IsplaceChange = false;
            });
            $("#fn_keyword").focusout(function () {
                if (IsplaceChange) {
                    // $("#map_modal").show();
                } else {
                    $('#lat').val('');
                    $('#lang').val('');
                    $("#fn_keyword").val('');
                }
            });
        });
        function geoSuccess_place(position) {
            var lat     = position.coords.latitude;
            var lng     = position.coords.longitude;
            var rurl    = base_url+'home/nearrest_place';
            $.ajax({
                url: rurl, 
                dataType: 'json',
                type: 'post',
                data:  {'lat':lat,'lng':lng},
                success: function(data) {
                    if(data.result == '1'){
                        $("#outof_location").hide();
                        var geocoder = new google.maps.Geocoder();
                        var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        if (geocoder) {
                            geocoder.geocode({ 'latLng': latLng}, function (results, status) {
                                if (status == google.maps.GeocoderStatus.OK) {
                                    $('#fn_keyword').val(results[0].formatted_address);
                                    $('#lat').val(lat);
                                    $('#lang').val(lng);
                                    geocoder = new google.maps.Geocoder();
                                    latlng = new google.maps.LatLng(lat, lng);
                                    geocoder.geocode({
                                        'latLng': latlng
                                    }, function(results, status) {
                                        if (status === 'OK') {
                                            if (results[1]) {
                                                for (var i = 0; i < results[0].address_components.length; i++) {
                                                    for (var b = 0; b < results[0].address_components[i].types.length; b++) {
                                                        switch (results[0].address_components[i].types[b]) {
                                                            case 'locality':
                                                            city = results[0].address_components[i].long_name;
                                                            var search_url = base_url+'search?keyword='+results[0].formatted_address+'&lat='+lat+'&lang='+lng+'&city='+city;
                                                            window.location.href = search_url;
                                                            break;
                                                            case 'administrative_area_level_1':
                                                            state = results[0].address_components[i].long_name;
                                                            break;
                                                            case 'country':
                                                            country = results[0].address_components[i].long_name;
                                                            break;
                                                        }
                                                    }
                                                }
                                            } 
                                        } 
                                    });
                                } else {
                                    $('#fn_keyword').val('Geocoding failed: '+status);
                                    $('#lat').val('');
                                    $('#lang').val('');
                                    $("#fn_keyword").val('');
                                    $(".no_res_msg").show();
                                    setTimeout(function(){$(".no_res_msg").hide();},5000);  
                                }
                            });
                        }  
                    }else{
                        $("#outof_location").show();
                    }  

                }
            });
        }
        function getLocation_pos(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(geoSuccess_place, showError_place);
            } else { 
                alert("Geolocation is not supported by this browser.");
            }
        }

        function showError_place(error){
            var innerHTML = '';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                innerHTML = "You have blocked tracking your location. To use this, change your location settings in browser."
                break;
                case error.POSITION_UNAVAILABLE:
                innerHTML = "Location information is unavailable."
                break;
                case error.TIMEOUT:
                innerHTML = "The request to get user location timed out."
                break;
                case error.UNKNOWN_ERROR:
                innerHTML = "An unknown error occurred."
                break;
            }
            $("#outof_location").show();
            $('#outof_location_lab').html(innerHTML);
        }
        // Map functionality
        function initialize(){
            var mapOptions = {
                zoom: 15,
                center: new google.maps.LatLng($('#lat').val(),$('#lang').val()),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("myaddrMap"), mapOptions);
            marker = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng($('#lat').val(),$('#lang').val()),
                draggable: true 
            });     

            geocoder.geocode({'latLng': myLatlng }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        $('#a_addr').val(results[0].formatted_address);
                        $('#a_lat').val(marker.getPosition().lat());
                        $('#a_lang').val(marker.getPosition().lng());
                        infowindow.setContent(results[0].formatted_address);
                        infowindow.open(map, marker);
                    }
                }
            });

            google.maps.event.addListener(marker, 'dragend', function() {
                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#a_addr').val(results[0].formatted_address);
                            $('#a_lat').val(marker.getPosition().lat());
                            $('#a_lang').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                            address_check();
                        }
                    }
                });
            });
            google.maps.event.addListener(map, 'click', function (event) {
                placeMarker(event.latLng);
                geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#a_addr').val(results[0].formatted_address);
                            $('#a_lat').val(marker.getPosition().lat());
                            $('#a_lang').val(marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, marker);
                            address_check();
                        }
                    }
                });
            });
        }
        google.maps.event.addDomListener(window, "resize", resizingMap());
        $('#map_modal').on('show.bs.modal', function() {
            resizeMap();
        })
        function resizeMap() {
            if(typeof map =="undefined") return;
            setTimeout( function(){resizingMap();} , 400);
        }

        function resizingMap() {
            if(typeof map =="undefined") return;
            var center = new google.maps.LatLng($('#lat').val(),$('#lang').val());
            google.maps.event.trigger(map, "resize");
            map.setCenter(center); 
        }

        function placeMarker(location) {
            if (marker == undefined){
                marker = new google.maps.Marker({
                    position: location,
                    map: map, 
                    animation: google.maps.Animation.DROP,
                });
            } else {
                marker.setPosition(location);
            }
            map.setCenter(location);
        }
    </script>
    @endif
    @if(!empty($emergencyData))
    <script type="text/javascript">
        $(function() {
            if ($('#emergencyData').val() == 'on') {
                $("#modal-pongal").modal('show');
                $('.modal-backdrop').addClass('active');
            }
        });
    </script>
    @endif
    @stack('scripts')
</body>
</html>