@extends('common.web.layout.base')
{{-- {{ App::setLocale(Request::route('lang') !== null ? Request::route('lang') : 'en') }} --}}
@section('styles')
@parent
<link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/landing.css')}}"/>
<link href="https://fonts.googleapis.com/css?family=Raleway:100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
@stop
@section('content')
<section class="dash-banner dash-section dis-column" >
   <div class="overlay-sec"></div>
   <div class="dis-column col-lg-12 col-md-12 col-sm-12">
      <div class="dis-column col-lg-12 col-md-12 col-sm-12">
         <h1 class="banner-heading z2">{{ __('Welcome to') }} {{ __(Helper::getSettings()->site->site_title) }}</h1>
         <p class="z2 mt-3">{{ __('One solution for all') }}</p>
         <div class="search-section z2 w-100 dis-reverse">
            <div class="col-lg-6 col-md-8 col-sm-12 dis-column">
               <input id="search" name="search" class="form-control mb-0" placeholder="{{ __('Search for a service') }}" type="text" aria-required="true" required>
               <!-- <p>E.g. Salon at Home, Plumber, Wedding Photographer</p> -->
            </div>
            <div class="dropdown col-lg-2 col-md-4 col-sm-2 dis-flex-end">
               <a class="btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
               {{ __('Chennai') }}
               </a>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">{{ __('Banglore') }}</a>
                  <a class="dropdown-item" href="#">{{ __('Mumbai') }}</a>
                  <a class="dropdown-item" href="#">{{ __('Goa') }}</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
s
<section class="services-list">
   <div class="container space section-divider">
      <div class="dis-column mb-4">
         <hr>
         <h5 class="service-heading txt-primary">{{ __('Services') }}</h5>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div id="rides" class="col-md-12 col-lg-12 col-sm-12 p-0 dis-center flex-wrap">
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-1">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/sedan-car-model.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Taxi Ride') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-2">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/bike.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Moto Rental') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-3">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/package.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Movers') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-4">
                     <img alt="" class="img-responsive" style="width:60px;" src="{{asset('assets/layout/images/common/svg/electricity.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Electrician') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-5">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/chef.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Food') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-6">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/groceries-bag.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Grocery') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-7">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/flower-bouquet.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Flower') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-8">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/doctor-stethoscope.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Doctor') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-9">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/tap.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Plumber') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-10">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/hair-dryer.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Beauty Services') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-11">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/pawprints.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Dog Walking') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-12">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/laundry.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Laundry') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-13">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/vacuum.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('House Cleaning') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-14">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/toolbox.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Carpenter') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-15">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/lawn-mower.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Lawn Mowing') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-16">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/man-on-his-knees-to-cuddle-his-dog.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Cuddling') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-17">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/open-book.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Tutor') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0 ">
                  <div class="service-item item-shadow bg-18">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/essential-oil-drop-for-spa-massage-falling-on-an-open-hand.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Massage') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-19">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/vynil.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('DJ') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
               <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                  <div class="service-item item-shadow bg-20">
                     <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/svg/baby-stroller.svg')}}">
                     <div class="blog-hover"></div>
                  </div>
                  <div class="service-section">
                     <div class="service-content">
                        <h3 class="service-title">{{ __('Baby Sitting') }}</h3>
                        <a href="#" target="_blank" class="link-arrow">{{ __('Book Now') }}<i class="icon ion-ios-arrow-right"></i></a>
                     </div>
                  </div>
               </div>
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

    $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
      $.getJSON('http://www.geoplugin.net/json.gp?ip='+data.geobytesremoteip, function(response) {
         if(response.geoplugin_countryCode == 'AE') {
            if(!( window.location.href ).includes('/ar')) {
                location.replace('/services/ar');
            }
         }
      });
   });

      
</script>

@stop
