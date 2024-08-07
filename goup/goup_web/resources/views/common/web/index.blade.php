@extends('common.web.layout.base')
@section('styles')
@parent
<link rel='stylesheet' type='text/css' href="{{ asset('assets/plugins/owl-carousel/css/owl.carousel.min.css')}}"/>
<link rel='stylesheet' type='text/css' href="{{ asset('assets/layout/css/landing.css')}}"/>
@stop
@section('content')
<section class="dash-banner dash-section dis-column" >
   <div class="overlay-sec"></div>
   <div class="dis-column col-lg-12 col-md-12 col-sm-12">
      <div class="dis-column col-lg-12 col-md-12 col-sm-12">
         <h1 class="banner-heading z2">Welcome to Xjek</h1>
         <p class="z2 mt-3">One app for all</p>
         <div class="search-section z2 w-100 dis-reverse">
            <div class="col-lg-6 col-md-8 col-sm-12 dis-column">
               <input id="search" name="search" class="form-control mb-0" placeholder="Search for a service" type="text" aria-required="true" required>
               <!-- <p>E.g. Salon at Home, Plumber, Wedding Photographer</p> -->
            </div>
            <div class="dropdown col-lg-2 col-md-4 col-sm-2 dis-flex-end">
               <a class="btn dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
               Chennai
               </a>
               <div class="dropdown-menu">
                  <a class="dropdown-item" href="#">Banglore</a>
                  <a class="dropdown-item" href="#">Mumbai</a>
                  <a class="dropdown-item" href="#">Goa</a>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="">
   <div class="container space section-divider">
      <div class="dis-column mb-4">
         <hr>
         <h5 class="service-heading txt-primary">Rides</h5>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div id="rides" class="owl-carousel">
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/bg.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Taxi Ride</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/car-rental.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Car Rental</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/moto-rental.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Moto Rental</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/moto-ride.jpg')}} ">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Moto Ride</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/packers.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Packers And Movers</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="dis-column mb-4">
         <hr>
         <h5 class="service-heading txt-primary">Deliveries</h5>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div id="deliveries" class="owl-carousel">
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/food.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Food Delivery</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/flower.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Flower</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/grocary.png')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Grocery Delivery</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/courier.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Courier Delivery</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common//marijuana.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Marijuana Delivery</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/alcohol.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Alcohol Delivery</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="dis-column mb-4">
         <hr>
         <h5 class="service-heading txt-primary">Other Services</h5>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div id="other-services" class="owl-carousel">
               <div class="item">
                  <div class="service-list  col-md-12 col-lg-12 col-sm-12">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/doctor.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Doctor</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now <i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list  col-md-12 col-lg-12 col-sm-12">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/baby-sitting.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Babysitting</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now <i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/beauty-service.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Beauty Service</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/dog-walking.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Dog Walking</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/carpenter.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Carpenter</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/electrician.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Electrician</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/laundry.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Laundry</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/tutor.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Tutor</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/cuddling.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Cuddling</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/dj.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">DJ</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/massage.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Massage</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="item">
                  <div class="service-list col-md-12 col-lg-12 col-sm-12 p-0">
                     <div class="service-item item-shadow">
                        <img alt="" class="img-responsive" src="{{asset('assets/layout/images/common/lawn-mowing.jpg')}}">
                        <div class="blog-hover"></div>
                     </div>
                     <div class="service-section">
                        <div class="service-content">
                           <h3 class="service-title">Lawn Mowing</h3>
                           <a href="#" target="_blank" class="link-arrow">Book Now<i class="icon ion-ios-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- TESTIMONIALS -->
<section class="testimonials">
   <div class="container space section-divider">
      <div class="dis-column mb-4">
         <hr>
         <h5 class="service-heading txt-primary">TESTIMONIALS</h5>
      </div>
      <div class="row">
         <div class="col-sm-12">
            <div id="customers-testimonials" class="owl-carousel">
               <div class="item">
                  <div class="shadow-effect">
                     <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
                     <p>Welcome to Xjek</p>
                  </div>
                  <div class="testimonial-name">EMILIANO AQUILANI</div>
               </div>
               <div class="item">
                  <div class="shadow-effect">
                     <img class="img-circle" src="http://themes.audemedia.com/html/goodgrowth/images/testimonial3.jpg" alt="">
                     <p>All in one app</p>
                  </div>
                  <div class="testimonial-name">ANNA ITURBE</div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<!-- END OF TESTIMONIALS -->
<!-- <section class="download ">
   <div class="container space section-divider">
      <div class="col-md-12 col-lg-12 col-sm-12 dis-row">
         <div class="col-lg-6 col-md-6 col-sm-12 mobile-app dis-center">
            <img src='./img/mobile-mock.png' class="">
         </div>
         <div class=" col-md-6 col-lg-6 col-sm-12 text-left dis-column p-0">
            <div class="title-section dis-column text-center">
               <h3 class="m-0">DOWNLOAD THE APP NOW!</h3>
               <p>Lorem Ipsum passages, and more recently with desktop publishing software like aldus pageMaker</p>
            </div>
            <div class="app-icons dis-row col-md-6 col-lg-6 p-0">
               <a class="pr-3" href=""><img src='./img/svg/app-store.png' width="150"></a>
               <a href=""><img src='./img/svg/google-play.png' width="150"></a>
            </div>
         </div>
      </div>
   </div>
   </section> -->
<!--App Section Start-->
<section class="app-section">
   <div class="container">
      <div class="row">
         <!--App Info Section Start-->
         <div class="col-md-6 col-sm-7">
            <div class="app-info">
               <div class="heading-style">
                  <h3>Download our App</h3>
               </div>
               <p>Welcome to Xjek</p>
               <ul class="feature-list">
                  <li><i class="fa fa-check" aria-hidden="true"></i>Book for Others</li>
                  <li><i class="fa fa-check" aria-hidden="true"></i>No-Surge Price 24/7</li>
                  <li><i class="fa fa-check" aria-hidden="true"></i>Chauffeur-drive</li>
                  <li><i class="fa fa-check" aria-hidden="true"></i>Well maintained Cabs</li>
               </ul>
               <div class="app-links">
                  <a href="#"><img src="{{asset('assets/layout/images/common/svg/app-store.png')}}" width="150" alt=""/></a>
                  <a href="#"><img src="{{asset('assets/layout/images/common/svg/google-play.png')}}"  width="150" alt=""/></a>
               </div>
            </div>
         </div>
         <!--App Info Section End-->
         <!--App Banner Section Start-->
         <div class="col-md-6 col-sm-5 p-0  app-banner-wrap dis-center">
            <img src="{{asset('assets/layout/images/common/mobile-mock.png')}}" alt=""/>
         </div>
         <!--App Banner Section End-->
      </div>
   </div>
</section>
<!--App Section End-->
@stop
@section('scripts')
@parent
<script type="text/javascript" src="{{ asset('assets/plugins/iscroll/js/scrolloverflow.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/owl-carousel/js/owl.carousel.min.js')}}"></script>
<script>
   jQuery(document).ready(function($) {
     		"use strict";

           $('#rides').owlCarousel({

           items: 3,
           margin: 10,
               nav: true,
           autoplay: true,
           dots:true,
           autoplayTimeout: 5000,
               navText: ['<span class="icon ion-ios-arrow-left"></span>','<span class="icon ion-ios-arrow-right"></span>'],
           smartSpeed: 450,
           responsive: {
             0: {
               items: 1
             },
             768: {
               items: 2
             },
             1170: {
               items: 3
             }
           }
       });

           $('#deliveries').owlCarousel({

           items: 3,
           margin: 10,
               nav: true,
           autoplay: true,
           dots:true,
           autoplayTimeout: 5000,
               navText: ['<span class="icon ion-ios-arrow-left"></span>','<span class="icon ion-ios-arrow-right"></span>'],
           smartSpeed: 450,
           responsive: {
             0: {
               items: 1
             },
             375: {
               items: 1
             },
             768: {
               items: 2
             },
             1170: {
               items: 3
             }
           }
       });

           $('#other-services').owlCarousel({

           items: 3,
           margin: 10,
               nav: true,
           autoplay: true,
           dots:true,
           autoplayTimeout: 5000,
               navText: ['<span class="icon ion-ios-arrow-left"></span>','<span class="icon ion-ios-arrow-right"></span>'],
           smartSpeed: 450,
           responsive: {
             0: {
               items: 1
             },
             375: {
               items: 1
             },
             768: {
               items: 2
             },
             1170: {
               items: 3
             }
           }
       });
     		//  TESTIMONIALS CAROUSEL HOOK
       $('#customers-testimonials').owlCarousel({
           loop: true,
           center: true,
           items: 3,
           margin: 0,
         //   autoplay: true,
           dots:true,
         //   autoplayTimeout: 8500,
           smartSpeed: 450,
           responsive: {
             0: {
               items: 2
             },
             375: {
               items: 1
             },
             768: {
               items: 2
             },
             1170: {
               items: 2
             }
           }
       });
     	});
</script>
@stop
