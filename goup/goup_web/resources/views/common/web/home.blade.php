@extends('common.web.layout.base')
{{-- {{ App::setLocale(Request::route('lang') !== null ? Request::route('lang') : 'en') }} --}}
@section('styles')
@parent
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.4.8/plyr.css">
    <style>
        #hero {
                height:100vh;
                width:100%;
                background:red;
                display:flex;
                align-items:center;
                justify-content: center;
        }
         header#myTopnav select#default_language {
                margin-bottom: 0px !important;
                margin-top: 0px;
                color: #fff;
            }
            header#myTopnav select#default_language option {
                color: #000;
            }

        #hero::after {
              width:100%;
              height:100%;
              content: '';
              position:absolute;
              z-index:10;
              top:0;
              left:0;
              background:rgba(0,0,0,0.5)
        }
        #hero video {
              width:100%;
              height:100%;
              position:absolute;
              top:0;
              left:0;
              z-index:5;
              object-fit:cover;
              font-family:'object-fit: cover';
        }
        #hero .bg-img-1 {
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                left: 0;
                z-index: 5;
                object-fit: cover;
                font-family: 'object-fit: cover';
                background-repeat: no-repeat;
                background-size: cover;
        }

        #hero .texture {
              width:100%;
              height:100%;
              position:absolute;
              top:0;
              left:0;
              z-index:15;
              background:url('../../assets/img/texture.png');
        }

        #hero .caption {

              position:relative;
              z-index:20;
              text-align:center;
              color:#ffffff;
        }

        #hero .caption h1 {

              text-transform: uppercase;
              font-size:2em;
              font-family: 'Oswald', sans-serif;
              margin-bottom:0.5rem;
        }

        #hero .caption h2 {
              font-weight:400;
              font-size:1.5rem;
              margin:0;
              font-family: 'PT Sans', sans-serif;
              color: #fff;
        }
        .caption {
            text-align: center;
            color: #000;
            background: transparent;
            padding-bottom: 10px;
        }
        .caption h1 {
            color: #fff;
        }

        @media screen and (min-width:768px)
        {
              #hero .caption h1 {
                    font-size:2.5rem;
              }

              #hero .caption h2 {
                    font-size:1.75rem;
              }
        }

        @media screen and (min-width:992px)
        {
              #hero .caption h1 {
                    font-size:3rem;
              }

              #hero .caption h2 {
                    font-size:2rem;
              }
        }

        @media screen and (min-width:1200px)
        {
            #hero .caption h1 {
                font-size: 4rem;
                font-family: 'Oswald', sans-serif;
                margin-bottom: 0.5rem;
                color: #fff;
            }

            #hero .caption h2 {
                font-size:2.5rem;
                color: #fff;
            }
        }
        @media only screen and (max-width: 767px)
        {
            #hero
            {
                background: transparent;
            }
            header#myTopnav {
                height: auto;
            }

            .logo-sec {
                position: static;
                width: 100%;
                height: auto;
            }

            header#myTopnav .dis-row {
                flex-flow: column;
            }
            div#sidebarCollapse {
                position: absolute;
                top: -60px;
                right: 0px;
            }

            .logo-sec {
                position: static !important;
                padding: 20px;
            }
            header .header-section .location, .user .dis-flex-end {
                justify-content: center;
            }
            /*#hero .caption
            {
                z-index: 9;
            }*/
            .side-toggle
            {
                z-index: 99999 !important;
                margin-top: 0px !important;
            }
            header#myTopnav select#default_language {
                margin-bottom: 0px !important;
                margin-top: 0px;
                color: #fff;
            }
            header#myTopnav select#default_language option {
                color: #000;
            }
            header#myTopnav {
    padding-bottom: 10px !important;
}
        }
    </style>
@stop
@section('content')

<div id="hero">
    {{-- <video loop="" muted="" autoplay="" preload="auto">
        <source src="{{ asset('assets/banner.m4v') }}" type="video/mp4">
            @lang('landing.your_browser_does_not_support_the_video_tag')
    </video> --}}
    <div class="bg-img-1" style="background-image: url(https://www.adp.com/-/media/adp/resourcehub/rh2/images/insight/hero/insight_hcm_mobile_hero_384_en.jpg?rev=c130acd2338d4585a34a3e091be1413a&h=432&w=768&la=en&hash=89F03528FF6D97601A46022743EDB9AE);"></div>
    <div class="caption">

        <h1>Goup</h1>
        <h2>@lang('landing.making_life_easier_for_you') </h2>

    </div>
</div>

                  
<section id="about" class="services-list">
    <div class="container-fluid">
        <div class="heading dis-column col-12 col-lg-12">
            <hr>
            <h1 class="text-center"><span class="txt-green">@lang('landing.one_app')  </span>@lang('landing.for_all_your_needs')</h1>
            <p class="mt-4 col-sm-12 col-md-12 col-lg-12 p-0 text-center">
               {{ __(Helper::getSettings()->site->site_title) }} @lang('landing.home_content') @lang('landing.home_content1') @lang('landing.home_content2')
            </p>
          
        </div>
        <div class="row bg-dots">
            <div class="col-sm-12">
                <div class="dis-center col-md-12 p-0 dis-center">
                    <ul class="nav nav-tabs " role="tablist">
                         @foreach(Helper::getServiceList() as $service)
                            @if($service =='TRANSPORT')
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#general_info" role="tab"
                                    data-toggle="tab"><img src="{{ asset('assets/layout/images/common/svg/seatbelt.svg') }}">@lang('landing.rides') </a>
                            </li>
                             @elseif($service =='ORDER')
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#password" role="tab"
                                    data-toggle="tab"><img src="{{ asset('assets/layout/images/common/svg/delivery-truck.svg') }}">@lang('landing.deliveries') </a>
                            </li>
                             @elseif($service =='SERVICE')
                            <li class="nav-item">
                                <a class="nav-link " data-toggle="tab" href="#payment_method" role="tab"
                                    data-toggle="tab"><img src="{{ asset('assets/layout/images/common/svg/tools.svg') }}">@lang('landing.services')</a>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
                <div class="clearfix tab-content">
                    @foreach(Helper::getServiceList() as $service)
                        @if($service =='TRANSPORT')
                        <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0"
                            id="general_info">
                            <div class="dis-row flex-wrap">
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0 ">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-1">
                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/sedan-car-model.svg') }}">
                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.taxi_ride') </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-2">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/bike.svg') }}">
                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.moto_rental')</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-3">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/package.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.movers') </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($service =='ORDER')
                        <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0" id="password">
                            <div class="dis-row flex-wrap">
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-5">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/chef.svg') }}">

                                    </div>
                                </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.food')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-6">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/groceries-bag.svg') }}">
                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.grocery')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-7">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/flower-bouquet.svg') }}">

                                    </div>
                                     </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.flower')</h3>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($service =='SERVICE')
                        <div role="tabpanel" class="tab-pane col-sm-12 col-md-12 col-lg-12 p-0" id="payment_method">
                            <div class="dis-row flex-wrap">
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-4">

                                        <img alt="" class="img-responsive" style="width:60px;"
                                            src="{{ asset('assets/layout/images/common/svg/electricity.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.electrician')</h3>

                                        </div>
                                    </div>
                                </div>

                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-8">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/doctor-stethoscope.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.doctor')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-9">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/tap.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.plumber')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-10">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/hair-dryer.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.beauty_services')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-11">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/pawprints.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.dog_walking')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-12">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/laundry.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.laundry')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-13">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/vacuum.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.house_cleaning') </h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-14">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/toolbox.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.carpenter')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                     <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-15">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/lawn-mower.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.lawn_mowing')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-16">

                                        <img alt="" class="img-responsive"
                                            src="{{ asset('assets/layout/images/common/svg/man-on-his-knees-to-cuddle-his-dog.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.cuddling')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-17">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/open-book.svg') }}">

                                    </div>
                                      </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.tutor')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0 ">
                                      <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-18">

                                        <img alt="" class="img-responsive"
                                            src="{{ asset('assets/layout/images/common/svg/essential-oil-drop-for-spa-massage-falling-on-an-open-hand.svg') }}">

                                    </div>
                                     </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.massage')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                     <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-19">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/vynil.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.dj')</h3>

                                        </div>
                                    </div>
                                </div>
                                <div class="service-list col-md-3 col-lg-2 col-sm-12 p-0">
                                    <a  href="javascript:;" onclick="openToggle()">
                                    <div class="service-item item-shadow bg-20">

                                        <img alt="" class="img-responsive" src="{{ asset('assets/layout/images/common/svg/baby-stroller.svg') }}">

                                    </div>
                                    </a>
                                    <div class="service-section">
                                        <div class="service-content ">
                                            <h3 class="service-title">@lang('landing.baby_sitting')</h3>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

</section>

<section id="features">
    <div class="container">
        <div class="row justify-content-md-center">
          <div class="owl-carousel video-section">
    <div class="item">
      <div>
    <video class="js-player"  playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
      <source src="{{(isset(Helper::getSettings()->site->home_page_video_1)?Helper::getSettings()->site->home_page_video_1:'') }}" type="video/mp4" size="720">
        </video>
  </div>
    </div>
    <div class="item">
        <div>
          <video class="js-player"  playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
          <source src="{{(isset(Helper::getSettings()->site->home_page_video_2)?Helper::getSettings()->site->home_page_video_2:'') }}" type="video/mp4" size="720">
            </video>
        </div>
    </div>
        <div class="item">
        <div>
        <video class="js-player"  playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
        <source src="{{(isset(Helper::getSettings()->site->home_page_video_3)?Helper::getSettings()->site->home_page_video_3:'') }}" type="video/mp4" size="720">
          </video>
        </div>
    </div>
     <div class="item">
        <div>
          <video class="js-player"  playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
          <source src="{{(isset(Helper::getSettings()->site->home_page_video_4)?Helper::getSettings()->site->home_page_video_4:'') }}" type="video/mp4" size="720">
            </video>
        </div>
    </div>
     <div class="item">
        <div>
          <video class="js-player"  playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
          <source src="{{(isset(Helper::getSettings()->site->home_page_video_5)?Helper::getSettings()->site->home_page_video_5:'') }}" type="video/mp4" size="720">
            </video>
        </div>
    </div>
     <div class="item">
        <div>
          <video class="js-player"  playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
          <source src="{{(isset(Helper::getSettings()->site->home_page_video_6)?Helper::getSettings()->site->home_page_video_6:'') }}" type="video/mp4" size="720">
            </video>
        </div>
    </div>
     <div class="item">
        <div>
          <video class="js-player"  playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
          <source src="{{(isset(Helper::getSettings()->site->home_page_video_7)?Helper::getSettings()->site->home_page_video_7:'') }}" type="video/mp4" size="720">
            </video>
        </div>
    </div>
     <div class="item">
        <div>
          <video class="js-player"  playsinline poster="https://cdn.plyr.io/static/demo/View_From_A_Blue_Moon_Trailer-HD.jpg">
          <source src="{{(isset(Helper::getSettings()->site->home_page_video_8)?Helper::getSettings()->site->home_page_video_8:'') }}" type="video/mp4" size="720">
            </video>
        </div>
    </div>
  </div>
            
        </div>
        
    </div>
</section> 

 

<section id="demo">
    <div class="overlay"></div>
    <div class="">
        <div class="row dis-center">
            <div class="heading dis-column">
                <hr>
                <h1 class="txt-white">@lang('landing.download')<span class="txt-white">{{ __(Helper::getSettings()->site->site_title) }}</span> @lang('landing.today')</h1>
                <p class="mt-3 col-lg-12 col-md-12 p-0 text-center txt-white">
                     @lang('landing.get_both_the_Android_and_iOS_apps_for_free.After_all,building_a_business_doesn’t_have_to_cost_you_a_bomb')
                </p>
            </div>
            <div class="col-md-12 col-lg-12 col-sm-12 dis-row">

                <div class="col-md-12 col-lg-6 col-sm-12 mt-3 dis-column">
                    <h5 class="txt-white">@lang('landing.user_iOS_App_&_Android_App')</h5>
                    <div class="app-links">

                        <a class="btn btn-lg big-btn mr-2" target="_blank" href="@if(isset(Helper::getSettings()->site->store_link_ios_user)){{ Helper::getSettings()->site->store_link_ios_user}} @else # @endif">
                            <img width="22px" class="pull-left" src="{{ asset('assets/layout/images/common/apple.png') }}">
                            <div class="btn-text"><small> @lang('landing.download_on_the')</small><br><strong> @lang('landing.app_store')</strong></div>
                        </a>
                        <a class="btn btn-lg  big-btn" target="_blank" href="@if(isset(Helper::getSettings()->site->store_link_android_user)){{ Helper::getSettings()->site->store_link_android_user}} @else # @endif">
                            <img width="22px" class="pull-left" src="{{ asset('assets/layout/images/common/google-play.png') }}">
                            <div class="btn-text"><small> @lang('landing.get_it_on')</small><br><strong>  @lang('landing.google_play')</strong></div>
                        </a>
                    </div>
                    <!--  -->
                    <h5 class="txt-white" style="margin-top: 25px;">@lang('landing.shop_iOS_App & Android_App') </h5>
                    <div class="app-links">

                        <a class="btn btn-lg big-btn mr-2" target="_blank" href="@if(isset(Helper::getSettings()->site->store_link_ios_shop)){{ Helper::getSettings()->site->store_link_ios_shop}} @else # @endif">
                            <img width="22px" class="pull-left" src="{{ asset('assets/layout/images/common/apple.png') }}">
                            <div class="btn-text"><small>@lang('landing.download_on_the')</small><br><strong>@lang('landing.app_store')</strong></div>
                        </a>
                        <a class="btn btn-lg  big-btn" target="_blank" href="@if(isset(Helper::getSettings()->site->store_link_android_shop)){{ Helper::getSettings()->site->store_link_android_shop}} @else # @endif">
                            <img width="22px" class="pull-left" src="{{ asset('assets/layout/images/common/google-play.png') }}">
                            <div class="btn-text"><small>@lang('landing.get_it_on')</small><br><strong>@lang('landing.google_play')</strong></div>
                        </a>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 col-sm-12 mt-3 dis-column">

                    <h5 class="txt-white"> @lang('landing.provider/driver_iOS_app & android_App') </h5>
                    <div class="app-links">

                        <a class="btn btn-lg big-btn mr-2" target="_blank" href="@if(isset(Helper::getSettings()->site->store_link_ios_provider)){{ Helper::getSettings()->site->store_link_ios_provider}} @else # @endif">
                            <img width="22px" class="pull-left" src="{{ asset('assets/layout/images/common/apple.png') }}">
                            <div class="btn-text"><small>@lang('landing.download_on_the')</small><br><strong>@lang('landing.app_store')</strong></div>
                        </a>
                        <a class="btn btn-lg  big-btn" target="_blank" href="@if(isset(Helper::getSettings()->site->store_link_android_provider)){{ Helper::getSettings()->site->store_link_android_provider}} @else # @endif">
                            <img width="22px" class="pull-left" src="{{ asset('assets/layout/images/common/google-play.png') }}">
                            <div class="btn-text"><small>@lang('landing.get_it_on')</small><br><strong>@lang('landing.google_play')</strong></div>
                        </a>
                    </div>
                    <!--  -->
                    <h5 class="txt-white" style="margin-top: 25px;">@lang('landing.iPad_iOS_App_&_tablet_android_app') </h5>
                    <div class="app-links">

                        <a class="btn btn-lg big-btn mr-2" target="_blank" href="@if(isset(Helper::getSettings()->site->store_link_ios_shop)){{ Helper::getSettings()->site->store_link_ios_shop}} @else # @endif">
                            <img width="22px" class="pull-left" src="{{ asset('assets/layout/images/common/apple.png') }}">
                            <div class="btn-text"><small>@lang('landing.download_on_the')</small><br><strong>@lang('landing.app_store')</strong></div>
                        </a>
                        <a class="btn btn-lg  big-btn" target="_blank" href="@if(isset(Helper::getSettings()->site->store_link_android_shop)){{ Helper::getSettings()->site->store_link_android_shop}} @else # @endif">
                            <img width="22px" class="pull-left" src="{{ asset('assets/layout/images/common/google-play.png') }}">
                            <div class="btn-text"><small>@lang('landing.get_it_on')</small><br><strong>@lang('landing.google_play')</strong></div>
                        </a>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</section>





@stop

@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/plyr/3.4.8/plyr.js"></script>
<script>


    $(document).ready(function() {
        $('.nav-tabs li:first a').trigger('click');
    });

    $.getJSON('http://gd.geobytes.com/GetCityDetails?callback=?', function(data) {
        $.getJSON('http://www.geoplugin.net/json.gp?ip=' + data.geobytesremoteip, function(response) {
            if (response.geoplugin_countryCode == 'AE') {
                if (!(window.location.href).includes('/ar')) {
                    location.replace('/ar');
                }
            }
        });
    });

    if(getUserDetails() && getUserDetails().id != 0) {
        $('.user_login').remove();
        $('.user_app').show();
    } else {
        $('.user_app').remove();
    }

    if(getProviderDetails() && getProviderDetails().id != 0) {
        $('.provider_login').remove();
        $('.provider_app').show();
    } else {
        $('.provider_app').remove();
    }

    if(getShopDetails() && getShopDetails().id != 0) {
        $('.shop_login').remove();
        $('.shop_app').show();
    } else {
        $('.shop_app').remove();
    }


    // jQuery(document).ready(function ($) {
    //    "use strict";

    // $('#rides').owlCarousel({

    //    items: 3,
    //    margin: 10,
    //    nav: true,
    //    autoplay: true,
    //    dots: true,
    //    autoplayTimeout: 5000,
    //    navText: ['<span class="icon ion-ios-arrow-left"></span>', '<span class="icon ion-ios-arrow-right"></span>'],
    //    smartSpeed: 450,
    //    responsive: {
    //       0: {
    //          items: 1
    //       },
    //       768: {
    //          items: 2
    //       },
    //       1170: {
    //          items: 4
    //       }
    //    }
    // });

    // $('#deliveries').owlCarousel({

    //    items: 3,
    //    margin: 10,
    //    nav: true,
    //    autoplay: true,
    //    dots: true,
    //    autoplayTimeout: 5000,
    //    navText: ['<span class="icon ion-ios-arrow-left"></span>', '<span class="icon ion-ios-arrow-right"></span>'],
    //    smartSpeed: 450,
    //    responsive: {
    //       0: {
    //          items: 1
    //       },
    //       375: {
    //          items: 1
    //       },
    //       768: {
    //          items: 2
    //       },
    //       1170: {
    //          items: 4
    //       }
    //    }
    // });

    // $('#other-services').owlCarousel({
    //    items: 3,
    //    margin: 10,
    //    nav: true,
    //    autoplay: true,
    //    dots: true,
    //    autoplayTimeout: 5000,
    //    navText: ['<span class="icon ion-ios-arrow-left"></span>', '<span class="icon ion-ios-arrow-right"></span>'],
    //    smartSpeed: 450,
    //    responsive: {
    //       0: {
    //          items: 1
    //       },
    //       375: {
    //          items: 1
    //       },
    //       768: {
    //          items: 2
    //       },
    //       1170: {
    //          items: 4
    //       }
    //    }
    // });
</script>


<script type="text/javascript">
    $(document).ready(function(){
       $("#mySidenav a").click(function(){
         $("#mySidenav").css("width", "0");
        });
});
</script>
<script>
var video = document.getElementById("myVideo");
var btn = document.getElementById("myBtn");

function myFunction() {
  if (video.paused) {
    video.play();
    btn.innerHTML = "Pause";
  } else {
    video.pause();
    btn.innerHTML = "Play";
  }
}
</script>
<script type="text/javascript">
$('.owl-carousel').owlCarousel({
    stagePadding: 200,
    loop:true,
    margin:10,
    items:1,
    nav:true,
  responsive:{
        0:{
            items:1,
            stagePadding: 60
        },
        600:{
            items:1,
            stagePadding: 100
        },
        1000:{
            items:1,
            stagePadding: 200
        },
        1200:{
            items:1,
            stagePadding: 250
        },
        1400:{
            items:1,
            stagePadding: 300
        },
        1600:{
            items:1,
            stagePadding: 350
        },
        1800:{
            items:1,
            stagePadding: 400
        }
    }
})

var playerSettings = {
      controls : ['play-large'],
      fullscreen : { enabled: false},
      resetOnEnd : true,
      hideControls  :true,
  clickToPlay:true,
      keyboard : false,
    }

const players = Plyr.setup('.js-player', playerSettings);

 players.forEach(function(instance,index) {
            instance.on('play',function(){
                players.forEach(function(instance1,index1){
                  if(instance != instance1){
                        instance1.pause();
                    }
                });
            });
        });

$('.video-section').on('translated.owl.carousel', function (event) {
  players.forEach(function(instance,index1){
                  instance.pause();
                });
});
</script>
@stop
