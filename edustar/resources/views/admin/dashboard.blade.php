@extends('admin.layouts.master')
@section('title',__('Admin Dashboard'))
@section('breadcum')
<div class="breadcrumbbar">
    <div class="row align-items-center">
        <div class="col-md-8 col-lg-8">
            <h4 class="page-title">{{ __('Home') }}</h4>
            <div class="breadcrumb-list">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>

                </ol>
            </div>
        </div>

    </div>
</div>
@endsection
@section('maincontent')
<div class="contentbar content_header_new">
    @can('dashboard.manage')
        <!-- Start row -->
        <div class="row">

            <!-- Start col -->
            <div class="col-lg-12">

                <div class="alert alert-success alert-dismissible fade show">
            
            
                    <span id="update_text">
                    
                    </span>
    
                    <form action="{{ url("/merge-quick-update") }}" method="POST" class="float-right d-none updaterform">
                        @csrf
                        <input required type="hidden" value="" name="filename">
                        <input required type="hidden" value="" name="version">
                        <button class="btn btn-sm btn-primary-rgba">
                        <i class="feather icon-check-circle"></i> {{__("Update Now")}}
                        </button>
                    </form>
        
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
    
                </div>
            </div>

            <div class="col-lg-12">

                <!-- Start row -->
                <div class="row">

                    <!-- Start col -->
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 my-2">
                        <div class="card bg-aqua">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $userss }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Users') }}</p>
                                    </div> 
                                <div class="col-6 text-right">
                                    <a href="{{ route('user.index') }}"><i
                                        class="text-aqua feather icon-users icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 my-2">
                        <div class="card m-b-30 shadow-sm bg-green">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $courses }}</h4>
                                        <p class="font-14 mb-0 text-white ">{{ __('Courses') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('course.index') }}"><i
                                            class="text-green  feather icon-book-open icondashboard"></i></a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 my-2">
                        <div class="card m-b-30 shadow-sm bg-yellow">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $categories }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Categories') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('category.index') }}"><i
                                            class="text-yellow feather icon-aperture icondashboard"></i></a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 my-1">
                        <div class="card m-b-30 shadow-sm bg-red">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $coupon }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Coupons') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('coupon.index') }}"><i
                                            class="text-red feather icon-percent icondashboard"></i></a>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($zoom_enable) && $zoom_enable == 1)
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-purple">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-7">
                                        <h4>{{ $zoom }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Zoom Meetings') }}</p>
                                    </div>
                                    @if(Route::has('zoom.setting'))
                                    <div class="col-5 text-right">
                                        <a href="{{ route('zoom.setting') }}"><i
                                            class="text-purple feather icon-radio icondashboard"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(isset($gsetting) && $gsetting->bbl_enable == 1)
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-orange">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $bbl }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('BBL Meetings') }}</p>
                                    </div>
                                    @if(Route::has('bbl.setting'))
                                    <div class="col-6 text-right">
                                        <a href="{{ route('bbl.setting') }}"><i
                                            class="text-orange feather icon-camera icondashboard"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif


                    @if(isset($gsetting) && $gsetting->jitsimeet_enable == 1)
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-orange">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $jitsi }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Jitsi Meetings') }}</p>
                                    </div>
                                    @if(Route::has('jitsi.dashboard'))
                                    <div class="col-6 text-right">
                                        <a href="{{ route('jitsi.dashboard') }}"><i
                                            class="text-orange feather icon-video icondashboard"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if(isset($gsetting) && $gsetting->googlemeet_enable == 1)
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $googlemeet }}</h4>
                                        <p class="font-14 mb-0">{{ __('Google Meetings') }}</p>
                                    </div>

                                    @if(Route::has('googlemeet.index'))
                                    <div class="col-6 text-right">
                                        <a href="{{ route('googlemeet.index') }}"><i
                                            class="text-warning feather icon-radio icondashboard"></i></a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-gray">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $faq }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Faq\'s') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('faq.index') }}"><i
                                            class="text-gray fa fa-question icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-skyblue">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $pages }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Pages') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('page.index') }}"><i
                                            class="text-skyblue feather icon-bookmark icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-aqua">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $blogs }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Blogs') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('blog.index') }}"><i
                                            class="text-aqua feather icon-message-square icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-green">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $testimonial }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Testimonials') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('testimonial.index') }}"><i
                                            class="text-green feather icon-shield icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-yellow">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $instructor }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Instructors') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ url('allinstructor') }}"><i
                                            class="text-yellow feather icon-user icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-red">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $orders }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Orders') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('order.index') }}"><i
                                            class="text-red feather icon-shopping-bag icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-purple">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $refund }}</h4>
                                        <p class="font-14 mb-0 text-white">{{ __('Refund Policy') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ url('refundpolicy') }}"><i
                                            class="text-purple  feather icon-shopping-cart icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 mt-md-3">
                        <div class="card m-b-30 shadow-sm bg-orange">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h4>{{ $follower }}</h4>
                                        <p class="font-14 mb-0 text-white" >{{ __('Followers') }}</p>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('follower.view') }}"><i
                                            class="text-orange  feather icon-user-check icondashboard"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if (!empty($topuser))
                    <div class="col-lg-12 col-xl-3 mt-md-3">
                        <div class="card m-b-30 shadow-sm">
                            <div class="card-header bg-border-red">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <h5 class="card-title mb-0">{{ __('Recent Users') }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="user-slider">
                                @foreach($topuser as $topusers)
                                <div class="user-slider">
                                    <div class="user-slider-item">
                                        <div class="card-body text-center">
                                            <span class="action-icon badge badge-primary-inverse">
                                                @if($topusers['user_img'] != null && $topusers['user_img'] !='' && @file_get_contents('images/user_img/'.$topusers['user_img']))

                                                    <img src="{{ url('images/user_img/'.$topusers['user_img'])}}" class="dashboard-imgs" alt="">

                                                @else

                                                <img src="{{ Avatar::create($topusers->fname)->toBase64() }}" class="dashboard-imgs" alt="">
                                                @endif

                                                
                                            </span>
                                            <h5>{{ $topusers->fname }}</h5>
                                            <p>{{ $topusers->email }}</p>
                                            <p><span class="badge badge-primary-inverse">{{ __('Verified') }}:{{ $topusers['verified'] }}</span>
                                            </p>
                                        
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="row">
                                                <div class="col-12 border-right">
                                                    <h4>{{ date('jS F Y', strtotime($topusers->created_at)) }}</h4>
                                                    <p class="my-2">{{ __('Created At') }}</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endif
                    @if (!empty($topinstructor))
                    <div class="col-lg-12 col-xl-3 mt-md-3">
                        <div class="card m-b-30">
                            <div class="card-header bg-border-darkpurple">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <h5 class="card-title mb-0">{{ __('Recent Instructors') }}</h5>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="user-slider">
                                @foreach($topinstructor as $topinstructors)
                                <div class="user-slider">
                                    <div class="user-slider-item">
                                        <div class="card-body text-center">
                                            <span class="action-icon badge badge-primary-inverse"><img src="{{ Avatar::create($topinstructors->fname)->toBase64() }}"
                                                    class="dashboard-imgs" alt=""></span>
                                            <h5>{{ $topinstructors->fname }}</h5>
                                            <p>{{ $topinstructors->email }}</p>
                                            <p><span
                                                    class="badge badge-primary-inverse">{{ __('Verified') }}:{{ $topinstructors->verified }}</span>
                                            </p>
                                        
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="row">
                                                <div class="col-12 border-right">
                                                    <h4>{{ date('jS F Y', strtotime($topinstructors->created_at)) }}</h4>
                                                    <p class="my-2">{{ __('Created At') }}</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endif
                    @if (!empty($topcourses))
                    <div class="col-lg-12 col-xl-3 mt-md-3">
                        <div class="card m-b-30">
                            <div class="card-header bg-border-power">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <h5 class="card-title mb-0">{{ __('Recent Courses') }}</h5>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="user-slider">
                                @foreach($topcourses as $topcourses)

                                <div class="user-slider">
                                    <div class="user-slider-item">
                                        <div class="card-body text-center">
                                            <span class="action-icon badge badge-primary-inverse">
                                                @if($topcourses['preview_image'] !== NULL && $topcourses['preview_image'] !== '')
                                                <img src="{{ asset('images/course/'.$topcourses['preview_image']) }}" class="dashboard-imgs" alt="">
                                                
                                                @else
                                                <img src="{{ Avatar::create($topcourses->title)->toBase64() }}" class="dashboard-imgs" alt="">
                                                @endif

                                            </span>
                                            <h5>{{ str_limit($topcourses->title, $limit = 15, $end = '...') }}</h5>
                                            <p>{{ optional($topcourses->category)->title }}</p>
                                            <p>
                                                @if($topcourses->discount_price == NULL)
                                                <span class="badge badge-primary-inverse">{{ __('Price') }}:{{ $topcourses->price }}</span>
                                                @else
                                                <span class="badge badge-primary-inverse">{{ __('Price') }}:{{ $topcourses->discount_price }}</span>
                                                @endif
                                            </p>
                                        
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="row">
                                                <div class="col-12 border-right">
                                                    <h4>{{ optional($topcourses->user)->fname }}</h4>
                                                    <p class="my-2">{{ __('Instructor') }}</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endif
                    @if (!empty($toporder))
                    <div class="col-lg-12 col-xl-3 mt-md-3">
                        <div class="card m-b-30">
                            <div class="card-header bg-border-green">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <h5 class="card-title mb-0">{{ __('Recent Orders') }}</h5>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="user-slider">
                                @foreach($toporder as $toporders)

                                @if(!is_null($toporders->user))

                                <div class="user-slider">
                                    <div class="user-slider-item">
                                        <div class="card-body text-center">
                                            <span class="action-icon badge badge-primary-inverse"><img
                                                    src="{{ Avatar::create($toporders->user->fname)->toBase64() }}"
                                                    class="dashboard-imgs" alt=""></span>
                                            <h5>{{ $toporders->user->fname }}</h5>
                                            <p>{{ $toporders->payment_method }}</p>
                                            <p><span class="badge badge-primary-inverse">{{ __('Price') }}:{{ $toporders->total_amount}}</span>
                                            </p>
                                            
                                        </div>
                                        <div class="card-footer text-center">
                                            <div class="row">
                                                <div class="col-12 border-right">
                                                    <h4>{{ date('jS F Y', strtotime($toporders->created_at)) }}</h4>
                                                    <p class="my-2">{{ __('Created At') }}</p>
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
                    @endif
                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="card m-b-30 mt-md-2">
                            <div class="card-header bg-border-power">
                                <h5 class="card-title">{{ __('Monthly Registred Users in ') }}{{ date('Y') }}</h5>
                            </div>
                            <div class="card-body">
                                <canvas height='180' id="chartjs-bar-chart" class="chartjs-chart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-md-3 chart_height">
                        <div class="card">
                            <div class="card-header  bg-border-darkpurple">
                                <h5 class="card-title">{{ __('Total Orders in ') }}{{ date('Y') }}</h5>
                            </div>
                            <div class="card-body">
                                <div id="apex-chart">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-md-3 chart_height">
                        <div class="card">
                            <div class="card-header bg-border-red">
                                <h5 class="card-title">{{ __('User Distribution') }}</h5>
                            </div>
                            <div class="card-body">
                                <div id="apex-circle-chart-custom-angel-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mt-5">
                        <div class="card m-b-30">
                            <div class="card-header bg-border-darkpurple">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <h5 class="card-title mb-0">{{ __('Recent Courses') }}</h5>
                                    </div>
                                    <div class="col-3">
                                        <div class="dropdown">
                                            <button class="btn btn-link p-0 font-18 float-right" type="button"
                                                id="upcomingTask" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="upcomingTask">
                                                <a href="{{url('course')}}"
                                                    class="dropdown-item font-13">{{ __('View All') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @php
                                    $courses = App\Course::limit(5)->orderBy('id', 'DESC')->get()
                                    @endphp
                                    @if(!$courses->isEmpty())
                                    <table class="table table-borderless">
                                        <thead></thead>
                                        <tbody>
                                            @foreach($courses as $course)
                                            <tr>
                                                <td>
                                                    @if($course['preview_image'] !== NULL && $course['preview_image'] !==
                                                    '')
                                                    <img src="images/course/<?php echo $course['preview_image'];  ?>"
                                                        alt="Course Image" class="img-responsive img-cousre">
                                                    @else
                                                    <img src="{{ Avatar::create($course->title)->toBase64() }}"
                                                        alt="Course Image" class="img-responsive img-cousre">
                                                    @endif
                                                </td>
                                                <td>
                                                    <p><span
                                                            class="text-dark">{{ str_limit($course['title'], $limit = 25, $end = '...') }}</span><br>
                                                        <span class="product-description">
                                                            {{ str_limit($course->short_detail, $limit = 40, $end = '...') }}
                                                        </span>
                                                    </p>
                                                </td>
                                                <td><span class="badge badge-warning">
                                                    @if( $course->type == 1)
                                                    @if($course->discount_price == !NULL)
                                                    @if($gsetting['currency_swipe'] == 1)
                                                    <i
                                                        class="{{ $currency['icon'] }}"></i>{{ $course['discount_price'] }}
                                                    @else
                                                    {{ $course['discount_price'] }}<i
                                                        class="{{ $currency['icon'] }}"></i>
                                                    @endif
                                                    @else
                                                    @if($gsetting['currency_swipe'] == 1)
                                                    <i class="{{ $currency['icon'] }}"></i>{{ $course['price'] }}
                                                    @else
                                                    {{ $course['price'] }}<i class="{{ $currency['icon'] }}"></i>
                                                    @endif
                                                    @endif
                                                    @else
                                                    {{ __('Free') }}
                                                    @endif
                                                </span>
                                            </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4 mt-5">
                        @php
                        $instructors = App\Instructor::limit(3)->orderBy('id', 'DESC')->get();
                        @endphp
                        @if( !$instructors->isEmpty() )
                        <div class="card m-b-30">
                            <div class="card-header bg-border-green">
                                <div class="row align-items-center">
                                    <div class="col-9">
                                        <h5 class="card-title mb-0">{{ __('Instructor Request') }}</h5>
                                    </div>
                                    <div class="col-3">
                                        <div class="dropdown">
                                            <button class="btn btn-link p-0 font-18 float-right" type="button"
                                                id="upcomingTask" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false"><i class="feather icon-more-horizontal-"></i></button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="upcomingTask">
                                                <a href="{{route('all.instructor')}}"
                                                    class="dropdown-item font-13">{{ __('All Instructor') }}</a>
                                                <a href="{{url('requestinstructor')}}"
                                                    class="dropdown-item font-13">{{ __('View All Instructor') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($instructors as $instructor)
                                    @if($instructor->status == 0)
                                    <div class="col-md-2 col-2">
                                        <img src="{{ asset('images/instructor/'.$instructor['image'])}}" alt="user "
                                            class="online img-cousre">
                                    </div>
                                    <div class="col-md-10 col-10">
                                        <p><span
                                                class="text-dark">{{ $instructor['fname'] }}&nbsp;{{ $instructor['lname'] }}</span><br>
                                            <span> {{ str_limit($instructor['detail'], $limit = 130, $end = '...') }}</span>
                                        </p>
                                        <div class="text-right">
                                            <h6>{{ __('Resume') }}:
                                                <a href="{{ asset('files/instructor/'.$instructor['file']) }}"
                                                    download="{{$instructor['file']}}">{{ __('Download') }}
                                                    <i class="ion ion-md-download"></i></a></h6>
                                        </div>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">

            <!-- Start col -->
            <div class="col-lg-12">
            <h3> {{ auth()->user()->getRoleNames()[0] }} {{ __('Dashboard') }} </h3>
            </div>
            <div class="col-md-12">
            <div class="card bg-primary-rgba m-b-30">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h5 class="card-title text-primary mb-1">Welcome, {{ Auth::user()->fname}}
                            </h5>
                            <p class="mb-0 text-primary font-14">"May the sun shine brightest, Today"</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    @endcan
</div>
@endsection
@section('scripts')
<script>
    var user = @json($usergraph);
    var course = @json($coursegraph);
    var category = @json($categorygraph);
    var order = @json($ordergraph);
    var refund = @json($refundgraph);
    var coupon = @json($coupongraph);
    var zoom = @json($zoomgraph);
    var bbl = @json($bblgraph);
    var jitsi = @json($jitsigraph);
    var googlemeet = @json($googlemeetgraph);
    var faq = @json($faqgraph);
    var page = @json($pagegraph);
    var blog = @json($bloggraph);
    var testimonial = @json($testimonialgraph);
    var instructor = @json($instructorgraph);
    var instructor = @json($instructorgraph);
    var follower = @json($followergraph);
    var datas = @json($datas);
    var adminchart = @json($admincharts);

    "use strict";
    $(document).ready(function () {
        var barChartID = document.getElementById("chartjs-bar-chart").getContext('2d');
        var barChart = new Chart(barChartID, {




            type: 'bar',



            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ],
                datasets: [{
                    label: 'Monthly Registred Users',
                    backgroundColor: ["#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4",
                        "#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4",
                        "#506fe4", "#506fe4"
                    ],
                    borderColor: ["#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4",
                        "#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4", "#506fe4",
                        "#506fe4", "#506fe4"
                    ],
                    borderWidth: 1,
                    data: datas,

                }]
            },
            options: {


                responsive: true,
                legend: {
                    position: 'top',
                    height: 100
                },
                title: {
                    display: false,
                    text: 'Chart.js Bar Chart'
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Month'
                        },
                        gridLines: {
                            color: 'rgba(0,0,0,0.05)',
                            lineWidth: 1,
                            borderDash: [0]
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Value'
                        },

                        gridLines: {
                            color: 'rgba(0,0,0,0.05)',
                            lineWidth: 1,
                            borderDash: [0]
                        }
                    }]
                }
            }
        });
    });
    var datas1 = @json($datas1);
    "use strict";
    $(document).ready(function () {
        var options = {
            chart: {
                height: 285,
                type: 'area',
                toolbar: {
                    show: false
                },
                zoom: {
                    type: 'x',
                    enabled: false,
                    autoScaleYaxis: true
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
            },
            colors: ['#506fe4'],
            series: [{
                name: 'Orders',
                data: datas1
            }],
            legend: {
                show: false,
            },
            xaxis: {

                title: {
                    text: 'Months',
                },
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                    'Dec'
                ],
                axisBorder: {
                    show: true,
                    color: 'rgba(0,0,0,0.05)'
                },
                axisTicks: {
                    show: true,
                    color: 'rgba(0,0,0,0.05)'
                }
            },
            yaxis: {
                title: {
                    text: 'Orders',
                },
                min: 0
            },
            grid: {
                row: {
                    colors: ['transparent', 'transparent'],
                    opacity: .5
                },
                borderColor: 'rgba(0,0,0,0.05)'
            },


        }
        var chart = new ApexCharts(
            document.querySelector("#apex-chart"),
            options
        );
        chart.render();
    });
</script>
@endsection