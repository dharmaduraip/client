@extends('layouts.default.index')
@section('content')
    <header class="head_hgt">
        <div class="container-fluid">
            <div class="row m-0">
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12 position-relative header-space">
                    <nav class="navbar navbar-expand-lg navbar-inverse navcolor" id="fixed-top-bg">
                        <div class="container-fluid">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="navbar-header d-lg-block d-flex align-items-center  justify-content-between">
                                    <a class="navbar-brand" href="{!! URL::to('/') !!}">
                                        <img src="{{ asset('uploads/logo.png')}}" alt="logo" class="img-responsive logo">
                                    </a>
                                    <button type="button" class="navbar-toggler navbar-toggle nav-toggle" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="myNavbar" aria-label="Toggle navigation">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse justify-content-lg-end" id="myNavbar">
                                    <ul class="nav navbar-nav navmenu align-items-lg-center me-lg-4 me-0">
                                        @if(\Auth::check())
                                        <li class="dropdown">
                                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><span>{!! Lang::get('core.welcome') !!} <span class="text-caps">@if(Auth::user()->username != ''){{Auth::user()->username}}@else{{Auth::user()->first_name}}@endif</span></span><span class="caret"></span></a>
                                            <ul class="dropdown-menu">
                                                <li><a href="{{ URL::to('profile') }}">{!! Lang::get('core.account') !!}</a></li>
                                                @if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)
                                                <li><a href="{{ URL::to('dashboard?'.time()) }}">Dashboard</a></li>
                                                @endif
                                                @if(\Auth::user()->p_active == '1' && \Auth::user()->group_id == '4' || \Auth::user()->group_id == '5' || \Auth::user()->group_id == '3' )
                                                <li><a href="{{ URL::to('user/profile?'.time()) }}">Dashboard</a></li>
                                                @endif
                                                <li><a  href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                    <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>Logout
                                                </a></li>
                                            </ul>
                                        </li>
                                        @else
                                        <li class="loginhomeslide"> Login</li>
                                        <li><span class="back signup-show"> Sign up </span></li>
                                        <!-- <li class="cart1">
                                            <a href="{{ URL::to('checkout') }}">
                                                <span class="ccart_count">
                                                    <i class="fa fa-shopping-bag"></i>
                                                    <span class="cart_head_count">{!! \AbserveHelpers::getCartItemCount() !!}</span>
                                                </span>
                                            </a>
                                            <div class="cartpopup header_menu_cart">
                                            </div>
                                        </li> -->
                                        @endif
                                    </ul>
                                    @if(\Auth::check())
                                    @if(\Auth::user()->p_active == '0' || \Auth::user()->p_active == '')
                                    <a href="partner-with-us">Become a partner</a>
                                    @endif
                                    @endif
                                </div>
                            </div>
                       {{--  @if(\Auth::check())
                        @if(\Auth::user()->p_active == '0' || \Auth::user()->p_active == '')
                         <a href="partner-with-us">Become a partner</a>
                         @endif
                         @endif --}}
                        </div>
                    </nav>
                    <div class="header-text">
                            <!-- <div id="word">Alpha</div> -->
                            <h1 class="hungry" id="word">Good Food</h1>
                            <h2 class="orderfood" style="width: 80%;">Handcrafted dishes made by passionate chefs. Delivered to your doorstep </h2>
                        <form class="demosearchform belo mb-5" method="get" action="{{ $maxrest_city_url }}" style="position: relative;">
                                <div class="input1">
                                    <div class="form-group has-success has-feedback">
                                        <input class="form-control keyword form-control1  pdd" name="keyword" value="" id="fn_keyword" placeholder="{!! Lang::get('core.type_delivery') !!}" type="text" onkeypress="return AvoidSpace(event)">
                                        <button type="submit" class="btn findfood findfood_submit" disabled >
                                            <!-- <i class="fa fa-search"></i> -->
                                            <span>Find Food</span>
                                            <div class="small_loader" style="display: none;"></div>
                                        </button>
                                        <span class="locatemespan">
                                            <span class="ico-location-crosshair locateme"></span><span class="locatemetext locate_me">Locate Me</span>
                                        </span>
                                        <div class="outof_location hide" id="outof_location" style="display: none;">Sorry we don't serve at your location currently. </div>
                                    </div>
                                    <input type="hidden" name="lat" id="lat" value="">
                                    <input type="hidden" name="lang" id="lang" value="">
                                </div> 
                     </form>
                    </div>
                </div>
                <!-- <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 over-flow .header-colum2-nopad">
                    <div class="" style="position: relative;">
                        <div class="row">
                            <div class="owl-carousel owl-carousel-banner carousel-inner">
                                <div class="item row">
                                    <div class="col-md-12 headercolum2">
                                        <img loading="lazy" class="lazyload" data-src="https://grozo.s3.ap-south-1.amazonaws.com/Static+images/New_Banner_1.jpg" alt="New_Banner_1">
                                    </div>
                                </div>

                                <div class="item row">
                                    <div class="col-md-12 headercolum3">
                                        <img loading="lazy" class="lazyload" data-src="https://grozo.s3.ap-south-1.amazonaws.com/Static+images/New_Banner_2.jpg" alt="New_Banner_2">
                                    </div>
                                </div> 
                                <div class="item row">
                                    <div class="col-md-12 headercolum4">
                                        <img loading="lazy" class="lazyload" data-src="https://grozo.s3.ap-south-1.amazonaws.com/Static+images/New_Banner_3.jpg" alt="New_Banner_3">
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div> -->
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 header-colum2-nopad col-l-5 ">
                    <div class="headercolum2">
                    </div>
                </div>
</div>
        </div>
    </header>
   
    @if(count($banner) > 0)
    <section class="mg-t-50">
        <div class="container">
            <div class="owl-carousel owl-carousel-ad-banner ">
                @foreach($banner as $item)
                <div class="item">
                    <div class="ad_img">
                        <img src="{!! $item->src !!}">
                    </div>
                </div> 
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section>
        <div class="content1">
            <div class="container nopad">
            <div class="row m-0">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                    <div class="col1">
                    <img src="sximo5/images/themes/images/one.webp" class="topimagesize">
                    <h3>Delicious Food</h3>
                    <p>Choose from an array of delicious food, with no restrictions on order value</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                    <div class="col1">
                    <img src="sximo5/images/themes/images/second.webp" class="topimagesize"> 
                    <h3>Expertly Cooked</h3>
                    <p>Let the pros take over to prepare for you a meticulously crafted meal</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
                    <div class="col1">
                    <img src="sximo5/images/themes/images/third.webp" class="topimagesize">
                    <h3>Delivered safely</h3>
                    <p>Your food will be delivered following strict safety and hygiene standards</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

<section>
  <div class="content2">
    <div class="container">
        <div class="row m-0">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="columone" >
                <h3>Chefs in your pocket</h3>
                <p>Explore restaurants that deliver near you, or try something new from our selection of trained professional chefs.</p>
                <div class="botm-image">
                    <span class="sone">
                    <a href="#">
                        <img src="sximo5/images/themes/images/googleply.webp" ></a></span>
                    <span class="stwo">
                    <a href="#"><img src="sximo5/images/themes/images/iphone.webp" ></a></span>
                </div>       
                </div>
            </div>
            <div class="col-lg-7 col-lg-offset-1 col-md-7 col-md-offset-1 col-sm-8 col-xs-12 no_pad">
                <div class="row m-0">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-6 no_pad">
                    <div class="rightbanner1">
                        <img src="sximo5/images/themes/images/firstone.png"  width="" height="">
                    </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-6 no_pad">   
                    <div class="rightbanner2">
                        <img src="sximo5/images/themes/images/secondone.png">
                    </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</section>

<section>
 <div class="content3">
    <div class="container">
      <div class="city">
        <ul>
          @if(!empty($rest_cities))           
            @foreach($rest_cities as $rest_city)
             <li><a href="{!! URL::to('search?city='.$rest_city->city.'&lat='.$rest_city->latitude.'&lang='.$rest_city->longitude) !!}" class="orange-content">{!! $rest_city->city !!}</a><span class="dot"></span></li>
            @endforeach
          @endif     
      </div>
    </div>
  </div>
</section>


    {{-- @if(count($previous_order)> 0)
    <section class="previous-order">
        <div class="container">
            <div class="flex-block">
                <h1>Previously ordered Shops</h1>
                <a href="{!! \URL::to('orders') !!}"><h4>View more</h4></a>
            </div>
            <div class="row">
                @foreach($previous_order as $k => $v)
                <?php $logo = explode(',',$v->logo); ?>
                <a href="{!! url('details/'.$v->res_id) !!}">
                    <div class="col-lg-3 col-md-4">
                        <div class="previous-order-det">
                            <div class="prev-order-list">
                                <div class="prev-order-img">
                                    <img src="{!! url('uploads/restaurants/'.$logo[0]) !!}" alt="">
                                </div>
                                <div class="shop-details">
                                    <div class="shop-name">
                                        <a href="{!! url('details/'.$v->res_id) !!}">
                                            <h3>  {{ $v->shop_name }}</h3>
                                        </a>
                                        <div class="rate">
                                            <span class="fa fa-star"></span>{{$v->rating}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif --}}
    @if(count($recent_search)> 0)
    <section class="recent-search">
        <div class="container">
            <div class="flex-block">
                <h1>Recent Search</h1>
            </div>
            <div class="owl-carousel owl-carousel-recentsearch recentsearch">
                @foreach($previous_order as $k => $v)
                <?php $logo = explode(',',$v->logo); ?>
                <div class="item">
                    <a href="{!! url('details/'.$v->res_id) !!}"> 
                        <div class="previous-order-det">
                            <div class="prev-order-list">
                                <div class="prev-order-img">
                                    <img src="{!! url('uploads/restaurants/'.$logo[0]) !!}" alt="">
                                </div>
                                <div class="shop-details">
                                    <div class="shop-name">
                                        <a href="{!! url('details/'.$v->res_id) !!}"><h3>{{$v->shop_name}}</h3></a>
                                        <div class="rate">
                                            <span class="fa fa-star"></span>{{$v->rating}}
                                        </div>
                                    </div>

                                    <div class="qtyandrate">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endsection
@push('scripts')
<script type="text/javascript">
    $('.owl-carousel.owl-carousel-banner').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        autoplay:true,
        mouseDrag:true,
        autoplaySpeed:2000,
        lazyLoad: 'progressive',
        autoplayTimeout:8000,
        interval:100,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:1,
                nav:true
            },
            767:{
                items:1,
                nav:true
            },
            1000:{
                items:1,
                nav:true

            }
        }
    });

    $('.owl-carousel.owl-carousel-ad-banner').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        autoplay:true,
        mouseDrag:false,
        autoplaySpeed:100,
        responsive:{
            0:{
                items:1,
                nav:false
            },
            600:{
                items:1,
                nav:false
            },
            767:{
                items:1,
                nav:false
            },
            1000:{
                items:1,
                nav:false,
                dots:true

            }
        }
    });

    $('.owl-carousel.owl-carousel-assurance').owlCarousel({
        loop:true,
        margin:10,
        responsiveClass:true,
        autoplay:true,
        autoplaySpeed:1500,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            500:{
                items:2,
                nav:true
            },
            767:{
                items:2,
                nav:true
            },
            1000:{
                items:4,
                nav:true

            }
        }
    });

    var carousel = $('.owl-carousel.owl-carousel-subbanner').owlCarousel({
        items: 1,
        margin: 10,
        nav: false,
        dots: false,
        loop: false,
        autoplay:true,
        autoplaySpeed:1500,
        lazyLoad: 'progressive',
        responsive: {
            0: { 
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                dots: false,
                loop:true
            },
            600: { 
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                dots: false,
                loop:true
            },
            1000: { 
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',
                dots: false,
                loop:true
            },
        },

    });

    $(".owl-carousel.owl-carousel-recentsearch").owlCarousel({
        margin:10,
        responsiveClass:true,
        autoPlay:true,
        nav:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3,
                nav:true
            },
            1000:{
                items:4,
                nav:true,
            }
        }
    });

    function featuredNearbyOwl() {
        $(".foodimages").owlCarousel({
            margin:10,
            responsiveClass:true,
            autoplay:true,
            center:true,
            lazyLoad:'progressive',
            autoplaySpeed:1500,
            nav:false,
            responsive:{
                0:{
                    items:1,
                    nav:false,
                    loop: true,
                },
                600:{
                    items:3,
                    nav:false,
                    loop: true,
                },
                1000:{
                    items:5,
                    nav:false,
                    loop: true,
                }
            }
        });
    }

    $(".dropdown-toggle").click(function(){
        if($('.dropdown-menu').hasClass('active')){
            $('.dropdown-menu').removeClass('active');
        }
        else{
            $('.dropdown-menu').addClass('active');
        }
    });

    $(function () {
        count = 0;
        wordsArray = ["Good Food", 
        "Good Portions", "Great Price."];
        setInterval(function () {
            count++;
            $("#word").fadeOut(900, function () {
                $(this).text(wordsArray[count  % wordsArray.length]).fadeIn(400);
            });
        }, 2000);
    });

    (function() {

        var quotes = $(".quotes");
        var quoteIndex = -1;

        function showNextQuote() {
            ++quoteIndex;
            quotes.eq(quoteIndex % quotes.length)
            .fadeIn(1000)
            .delay(2000)
            .fadeOut(1000, showNextQuote);
        }

        showNextQuote();
    })();

    $(window).load(function() {
        if(navigator.geolocation) {
            /*navigator.geolocation.getCurrentPosition(geoSuccess, geoError);*/
        } else {
            alert("Geolocation is not supported by this browser.");
        }
        function geoSuccess(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;
            var rurl ='<?php echo URL::to('');?>/home/nearrest';
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
        function geoError(error) {/* alert("Geocoder failed.");*/}
    });

    function functionFeatured(latitude,longitude) {
        var rurl ='<?php echo URL::to('');?>/home/nearrest_place';
        $.ajax({
            url: rurl, 
            dataType: 'json',
            type: 'post',
            data:  {'lat':latitude,'lng':longitude},
            success: function(data) {
                $('.small_loader').hide();
                if (data.result != '0') {
                    $("#outof_location").hide();
                    $(".findfood_submit").removeAttr('disabled');
                    $("#nearby").html(data.html);
                    featuredNearbyOwl();
                } else {
                    $('#lat').val('');
                    $('#lang').val('');
                    $("#fn_keyword").val('');
                    $(".findfood_submit").attr('disabled','disabled');
                    $("#outof_location").show();
                }  
            }
        });
    }

    var IsplaceChange = true;
    $(document).ready(function () {
          loop();
        /*$('#myCarousel').carousel({
            interval:   4000
        });*/

        var clickEvent = false;
        $('#myCarousel').on('click', '.nav a', function() {
            clickEvent = true;
            $('.nav li').removeClass('active');
            $(this).parent().addClass('active');        
        }).on('slid.bs.carousel', function(e) {
            if(!clickEvent) {
                var count = $('.nav').children().length -1;
                var current = $('.nav li.active');
                current.removeClass('active').next().addClass('active');
                var id = parseInt(current.data('slide-to'));
                if(count == id) {
                    $('.nav li').first().addClass('active');    
                }
            }
            clickEvent = false;
        });

        featuredNearbyOwl();
        $(".findfood_submit").attr('disabled','disabled');
        var input = document.getElementById('fn_keyword');
        var options = {
            types: [],
        };
        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('fn_keyword'));
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place       = autocomplete.getPlace();
            var latitude    = place.geometry.location.lat();
            var longitude   = place.geometry.location.lng();
            $('#lat').val(latitude);
            $('#lang').val(longitude);
            var components = place.address_components;
            for (var i = 0, component; component = components[i]; i++) {
                if (component.types[0] == 'locality') {
                    $("#city").val(component['long_name']);
                }
            }
            // functionFeatured(latitude,longitude);
            IsplaceChange = true;
            if(latitude != '' &&  latitude != undefined && longitude != '' &&  longitude != undefined && $('#fn_keyword').val() != '' &&  $('#fn_keyword').val() != undefined){
                $('.small_loader').show();
                functionFeatured(latitude,longitude);
                categoryitemlocation(latitude,longitude);
                shopcategorylocation(latitude,longitude);
            }
        });
        $("#fn_keyword").keydown(function () {
            IsplaceChange = false;
            $(".findfood_submit").attr('disabled','disabled');
        });
        $("#fn_keyword").focusout(function () {      
            if (IsplaceChange) {
                if($('#lat').val() != '' &&  $('#lat').val() != undefined && $('#lang').val() != '' &&  $('#lang').val() != undefined && $('#fn_keyword').val() != '' &&  $('#fn_keyword').val() != undefined){
                    $(".findfood_submit").removeAttr('disabled');
                }
            } else {
                $('#lat').val('');
                $('#lang').val('');
                $("#fn_keyword").val('');
                $(".findfood_submit").attr('disabled','disabled');
            }
        });
        $('.locate_me').click(function(){
            getLocation_pos();
        }); 
        getLocation_pos();
    });

    function AvoidSpace(event) {
        var locate = $("#fn_keyword").val();
        var k = event ? event.which : window.event.keyCode;
        if (k == 32 && locate == '') {
            return false;
        }
    }

    function geoSuccess_place(position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        getCityFromLatLang(lat,lng);
        var rurl =base_url+'home/nearrest_place';
        $.ajax({
            url: rurl, 
            dataType: 'json',
            type: 'post',
            data:  {'lat':lat,'lng':lng},
            success: function(data) {
                if(data.result != '0'){
                    $("#outof_location").hide();
                    var geocoder = new google.maps.Geocoder();
                    var latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    if (geocoder) {
                        geocoder.geocode({ 'latLng': latLng}, function (results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                $('#fn_keyword').val(results[0].formatted_address);
                                $('#lat').val(lat);
                                $('#lang').val(lng);
                                $(".findfood_submit").removeAttr('disabled');
                            }
                            else {
                                $('#fn_keyword').val('Geocoding failed: '+status); 
                            }
                        });
                    }
                    $(".findfood_submit").removeAttr('disabled');
                    $("#nearby").html(data.html);
                    featuredNearbyOwl();
                }else{
                    $("#outof_location").show();

                }  

            }
        });
    }

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
                    shopcategorylocation(lat,lng);
                    categoryitemlocation(lat,lng);

                });
                } else {
                     "No results found";
                }
            } else {
               "Geocoder failed due to: " + status;
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
            innerHTML = "You have blocked {!! CNF_APPNAME !!} from tracking your location. To use this, change your location settings in browser."
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
    $(window).scroll(function(){
        if ($(this).scrollTop() > 50) {
            $('#fixed-top-bg').addClass('bgheader');
        } else {
            $('#fixed-top-bg').removeClass('bgheader');
        }
    });
    // var a_arr = document.getElementsByClassName("j_bg");
    // var a = [a_arr];
    // var len =  a_arr.length;
    // var b = a_arr[a_arr.length-1];
    // // var c = b.style.backgroundImage;
    // var fistChild = a_arr[0].style.backgroundImage;
    // var cssProp = document.createAttribute("style");
    // cssProp.value = "background :" + fistChild;
    // b.setAttributeNode(cssProp);
    var scroll = window.requestAnimationFrame || function(callback){ window.setTimeout(callback, 1000/60)};
    var elementsToShow = document.querySelectorAll('.show-on-scroll'); 

    function loop() {
        console.log();
        Array.prototype.forEach.call(elementsToShow, function(element){
            if (isElementInViewport(element)) {
                element.classList.add('is-visible');
            }/* else {
                element.classList.remove('is-visible');
            }*/
        });
        scroll(loop);
    }

    function isElementInViewport(el) {
        if (typeof jQuery === "function" && el instanceof jQuery) {
            el = el[0];
        }
        var rect = el.getBoundingClientRect();
        return (
            (rect.top <= 0
                && rect.bottom >= 0)
            ||
            (rect.bottom >= (window.innerHeight || document.documentElement.clientHeight) 
                &&
                rect.top <= (window.innerHeight || document.documentElement.clientHeight))
            ||
            (rect.top >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight))
            );
    }

    var owl = $('.screenshot_slider').owlCarousel({
        loop: true,
        responsiveClass: true,
        nav: true,
        margin: 0,
        autoplay:true,
        autoplayTimeout: 4000,
        smartSpeed: 400,
        center: true,
        navText: ['&#8592;', '&#8594;'],
        responsive: {
            0: {
                items: 2,
            },
            600: {
                items: 2, 

            },
            1200: {
                items: 5
            }
        }
    });

    jQuery(document.documentElement).keydown(function (event) {
        if (event.keyCode == 37) {
            owl.trigger('prev.owl.carousel', [400]);
        } else if (event.keyCode == 39) {
            owl.trigger('next.owl.carousel', [400]);
        }
    });

    function shopcategorylocation(lat,lang){
        $('.shopcategory').each(function(){
            var cuisine_id = $(this).attr('data-cid');
            var url = base_url+"search?cuisines="+cuisine_id;
            var city       =  $('#city').val();
            if(lat !== '' && lang !== '' && city !== ''){
                url = base_url+"search?city="+city+"&lat="+lat+"&lang="+lang+"&cuisines="+cuisine_id;
            }
            $(this).attr('href',url); 
        });
    }

    function categoryitemlocation(lat,lang){
        $('.categoryitem').each(function(){
            var cuisine_id = $(this).attr('data-cid');
            var url = base_url+"search?categories="+cuisine_id;
            var city       =  $('#city').val();
            if(lat !== '' && lang !== '' && city !== ''){
                url = base_url+"search?city="+city+"&lat="+lat+"&lang="+lang+"&categories="+cuisine_id;
            }
            $(this).attr('href',url); 
        });
    }
</script>
@endpush
