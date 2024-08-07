@extends('theme.master')
@section('title', 'Online Courses')
@section('content')
@include('admin.message')
@include('sweetalert::alert')
@section('meta_tags')
<meta name="title" content="{{ $gsetting['project_title'] }}">
<meta name="description" content="{{ $gsetting['meta_data_desc'] }} ">
<meta property="og:title" content="{{ $gsetting['project_title'] }} ">
<meta property="og:url" content="{{ url()->full() }}">
<meta property="og:description" content="{{ $gsetting['meta_data_desc'] }}">
<meta property="og:image" content="{{ asset('images/logo/'.$gsetting['logo']) }}">
<meta itemprop="image" content="{{ asset('images/logo/'.$gsetting['logo']) }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ asset('images/logo/'.$gsetting['logo']) }}">
<meta property="twitter:title" content="{{ $gsetting['project_title'] }} ">
<meta property="twitter:description" content="{{ $gsetting['meta_data_desc'] }}">
<meta name="twitter:site" content="{{ url()->full() }}" />
<link rel="canonical" href="{{ url()->full() }}" />
<meta name="robots" content="all">
<meta name="keywords" content="{{ $gsetting->meta_data_keyword }}">

@endsection

<!-- categories-tab start-->
@if($gsetting->category_enable == 1)
<section id="categories-tab" class="categories-tab-main-block">
    <div class="container-xl">
        <div id="categories-tab-slider" class="categories-tab-block owl-carousel">

            @foreach($category as $cat)
            @if($cat->status == 1)
            <div class="item categories-tab-dtl">
                <a href="{{ route('category.page',['id' => $cat->id, 'category' => str_slug(str_replace('-','&',$cat->slug))]) }}" title="{{ $cat->title }}"><i class="fa {{ $cat->icon }}"></i>{{ $cat->title }}</a>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- categories-tab end-->


@if(isset($sliders))
<section id="home-background-slider" class="background-slider-block owl-carousel position-relative">
    <div class="lazy item home-slider-img">
        @foreach($sliders as $slider)
        @if($slider->status == 1)
        <div id="home" class="home-main-block" style="background-image: url('{{ asset('images/slider/'.$slider['image']) }}')">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 {{$slider['left'] == 1 ? 'col-md-offset-6 col-sm-offset-6 col-sm-6 col-md-6 text-right' : ''}}">
                        <div class="home-dtl">
                            <div class="home-heading">{{ $slider['heading'] }}</div>
                            <p class="btm-10">{{ $slider['sub_heading'] }}</p>
                            <p class="btm-20">{{ $slider['detail'] }}
                        </div>

                        @if($slider->search_enable == 1)
                        <div class="home-search">
                            <form method="GET" id="searchform" action="{{ route('search') }}">
                                <div class="search">

                                    <input type="text" name="searchTerm" class="searchTerm" placeholder="{{ __('What do you want to learn?')}}">
                                    <button type="submit" class="searchButton">{{ __('Search')}}
                                    </button>

                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach
    {{-- </div> --}}
</section>
@endif
<!-- home end -->
<!-- learning-work start -->
@if(isset($facts) && count($facts)> 0)
<section id="learning-work" class="learning-work-main-block">
    <div class="container-xl">
        <div class="row">
            @foreach($facts as $fact)
            <div class="col-lg-4 col-md-4">
                <div class="learning-work-block">
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <div class="learning-work-icon">
                                <i class="fa {{ $fact['icon'] }}"></i>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-9">
                            <div class="learning-work-dtl">
                                <div class="work-heading">{{ $fact['heading'] }}</div>
                                <p>{{ $fact['sub_heading'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
{{-- <section>
            <div class="d-flex flex-wrap align-items-center p-xl-5 p-md-4 p-3" id="after-herosection">
                <div class="col-md-4 col-12 my-1 px-0">
                    <h2>Vivamus maximus</h2>
                    <p>Lorem ipsum dolor sadipscing elitr, sed diam nonum</p>
                    <ul>
                        <li>Nullam est</li>
                        <li>Mattis dictum nunc</li>
                    </ul>
                </div>
                <div class="col-md-8 col-12 d-flex flex-wrap justify-content-between my-1 px-0">
                    @foreach($facts as $fact)
                    <div class="col-md-4 col-sm-6 col-12 d-flex work-head-section">
                       <i class="fa {{ $fact['icon'] }}"></i>
<div class="content my-md-1">
    <div class="work-heading text-center my-2">{{ $fact['heading'] }}</div>
    <p class="text-center">{{ $fact['sub_heading'] }}</p>
</div>
</div>
@endforeach
</div>
</div>
</section> --}}
@endif

@if($hsetting->trusted_enable == 1 && ! $trusted->isEmpty() )
<section id="trusted" class="trusted-main-block top-40">
    <div class="container-xl">
        <div class="patners-block">

            <h6 class="patners-heading btm-40">{{ __('Trusted By Companies') }}</h6>
            <div id="patners-slider" class="patners-slider owl-carousel" data-truscom="{{ count($trusted) }}">
                @foreach($trusted as $trust)
                <div class="item">
                    <div class="ad-box">
                        <a href="{{ $trust['url'] }}" target="_blank">
                            <img data-src="{{ asset('images/trusted/'.$trust['image']) }}" class="img-fluid owl-lazy" alt="patners-1">
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</section>
@endif

<!-- learning-work end -->
<!-- fact start -->
@if($hsetting->fact_enable == 1 && count($factsetting)> 0)
<section id="facts" class="fact-main-block">
    <div class="container-xl">
        <div class="col-lg-6 col-md-6 col-7">
            <h4 class="">{{ __('Facts') }}</h4>
        </div>
        <div class="row">
            @foreach($factsetting as $factset)
            <div class="col-lg-3 col-md-6 col-12">
                <div class="facts-block text-center">
                    <div class="facts-block-one">
                        <div class="facts-block-img">
                            @if($factset['image'] !== NULL && $factset['image'] !== '')
                            <img src="{{ url('/images/facts/'.$factset->image) }}" class="img-fluid" alt="" />
                            @else
                            <img src="{{ Avatar::create($factset->title)->toBase64() }}" alt="course" class="img-fluid">
                            @endif
                            <div class="facts-count">{{ $factset->number }}</div>
                        </div>
                        <h5 class="facts-title"><a href="#" title="">{{ $factset->title }}</a></h5>
                        <p>{{ $factset->description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- fact end -->
<!-- Advertisement -->
@if(isset($advs))
@foreach($advs as $adv)
@if($adv->position == 'belowslider')
<br>
<section id="student" class="student-main-block top-40">
    <div class="container-xl">
        <a href="{{ $adv->url1 }}" title="{{ __('Click to visit') }}">

        </a>
    </div>
</section>
@endif
@endforeach
@endif
@if($hsetting->discount_enable == 1 && isset($discountcourse) && count($discountcourse) >0)
<section id="student" class="student-main-block top-40">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-7">
                <h4 class="student-heading">{{ __('Top Discounted Courses') }}</h4>
            </div>
            @if(count($discountcourse) > 4)
            <div class="col-lg-6 col-md-6 col-5">
                <div class="view-button txt-rgt">

                    <a href="{{url('topdiscounted/view')}}" class="btn btn-secondary" title="View More">View More<i data-feather="chevron-right"></i>
                    </a>
                </div>
            </div>
            @endif
        </div>
        <div id="discounted-view-slider" class="student-view-slider-main-block owl-carousel" data-discour="{{ count($discountcourse) }}">
            @foreach($discountcourse as $discount)
            @if($discount->status == 1 && $discount->featured == 1)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$discount->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @if($discount['preview_image'] !== NULL && $discount['preview_image'] !== '')
                            <a href="{{ route('user.course.show',['id' => $discount->id, 'slug' => $discount->slug ]) }}"><img data-src="{{ asset('images/course/'.$discount['preview_image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('user.course.show',['id' => $discount->id, 'slug' => $discount->slug ]) }}"><img data-src="{{ Avatar::create($discount->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        <div class="badges bg-priamry offer-badge"><span>OFF<span><?php echo round((($discount->price - $discount->discount_price) * 100) / $discount->price) . '%'; ?></span></span></div>


                        @if($discount['level_tags'] == 'trending')
                        <div class="advance-badge">
                            <span class="badge bg-warning">{{__('Trending')}}</span>
                        </div>
                        @endif
                        @if($discount['level_tags'] == 'featured')

                        <div class="advance-badge">
                            <span class="badge bg-danger">{{__('Featured')}}</span>
                        </div>
                        @endif
                        @if($discount['level_tags'] == 'new')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('New')}}</span>
                        </div>
                        @endif
                        @if($discount['level_tags'] == 'onsale')

                        <div class="advance-badge">
                            <span class="badge bg-info">{{__('On-sale')}}</span>
                        </div>
                        @endif
                        @if($discount['level_tags'] == 'bestseller')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('Bestseller')}}</span>
                        </div>
                        @endif
                        @if($discount['level_tags'] == 'beginner')

                        <div class="advance-badge">
                            <span class="badge bg-primary">{{__('Beginner')}}</span>
                        </div>
                        @endif
                        @if($discount['level_tags'] == 'intermediate')

                        <div class="advance-badge">
                            <span class="badge bg-secondary">{{__('Intermediate')}}</span>
                        </div>
                        @endif
                        <div class="view-user-img">

                            @if(optional($discount->user)['user_img'] !== NULL && optional($discount->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$discount->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$discount->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{  route('all/profile',$discount->id)  }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('user.course.show',['id' => $discount->id, 'slug' => $discount->slug ]) }}">{{ str_limit($discount->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$discount->user->id) }}"> {{ optional($discount->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="rating">
                                <ul>
                                    <li>
                                        <?php
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $sub_total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $discount->id)->get();
                                        ?>
                                        @if(!empty($reviews[0]))
                                        <?php
                                        $count =  App\ReviewRating::where('course_id', $discount->id)->count();

                                        foreach ($reviews as $review) {
                                            $learn = $review->price * 5;
                                            $price = $review->price * 5;
                                            $value = $review->value * 5;
                                            $sub_total = $sub_total + $learn + $price + $value;
                                        }

                                        $count = ($count * 3) * 5;
                                        $rat = $sub_total / $count;
                                        $ratings_var = ($rat * 100) / 5;
                                        ?>

                                        <div class="pull-left">
                                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>


                                        @else
                                        <div class="pull-left">{{ __('No Rating') }}</div>
                                        @endif
                                    </li>
                                    <!-- overall rating-->
                                    <?php
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $count =  count($reviews);
                                    $onlyrev = array();

                                    $reviewcount = App\ReviewRating::where('course_id', $discount->id)->WhereNotNull('review')->get();

                                    foreach ($reviews as $review) {

                                        $learn = $review->learn * 5;
                                        $price = $review->price * 5;
                                        $value = $review->value * 5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }

                                    $count = ($count * 3) * 5;

                                    if ($count != "" && $count != 0) {
                                        $rat = $sub_total / $count;

                                        $ratings_var = ($rat * 100) / 5;

                                        $overallrating = ($ratings_var / 2) / 10;
                                    }

                                    ?>

                                    @php
                                    $reviewsrating = App\ReviewRating::where('course_id', $discount->id)->first();
                                    @endphp
                                    @if(!empty($reviewsrating))
                                    <!-- <li>
                                            <b>{{ round($overallrating, 1) }}</b>
                                        </li> -->
                                    @endif
                                    <li class="reviews">
                                        (@php
                                        $data = App\ReviewRating::where('course_id', $discount->id)->count();
                                        if($data>0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp Reviews)
                                    </li>

                                </ul>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $discount->id)->count();
                                                if(($data)>0){

                                                echo $data;
                                                }
                                                else{

                                                echo "0";
                                                }
                                                @endphp</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if( $discount->type == 1)
                                        <div class="rate text-right">
                                            <ul>

                                                @if($discount->discount_price == !NULL)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($discount['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r' ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($discount['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>


                                                @else

                                                @if($c->price == !NULL)
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($discount['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>
                                                @endif

                                                @endif
                                            </ul>
                                        </div>
                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>



                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',$discount->id)->first();
                                        $existorder = App\Order::where('user_id',Auth::User()->id)->where('course_id', $discount->id)->where('refunded', '0')->first();
                                        @endphp
                                        @if ($wish == NULL)
                                            @if(!isset($existorder))
                                                <li class="protip-wish-btn">
                                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                        <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                                    </form>
                                                </li>
                                            @endif
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block{{$discount->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $discount['title'] }}</h5>
                            <div class="main-des">
                                <p>Last Updated: {{ date('jS F Y', strtotime($discount->updated_at)) }}</p>
                            </div>

                            <ul class="description-list">
                                <li>
                                    <i data-feather="play-circle"></i>
                                    <div class="class-des">
                                        {{ __('Classes') }}:
                                        @php
                                        $data = App\CourseClass::where('course_id', $discount->id)->count();
                                        if($data > 0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp
                                    </div>
                                </li>
                                &nbsp;
                                <li>
                                    <div>
                                        <div class="time-des">
                                            <span class="">
                                                <i data-feather="clock"></i>
                                                @php

                                                $classtwo = App\CourseClass::where('course_id',
                                                $discount->id)->sum("duration");

                                                @endphp
                                                {{ $classtwo }} {{ __('Minutes')}}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="lang-des">
                                        @if($discount['language_id'] == !NULL)
                                        @if(isset($c->language))
                                        <i data-feather="globe"></i> {{ $discount->language['name'] }}
                                        @endif
                                        @endif
                                    </div>
                                </li>

                            </ul>

                            <div class="product-main-des">
                                <p>{{ $discount->short_detail }}</p>
                            </div>
                            <div>
                                @if($discount->whatlearns->isNotEmpty())
                                @foreach($discount->whatlearns as $wl)
                                @if($wl->status ==1)
                                <div class="product-learn-dtl">
                                    <ul>
                                        <li><i data-feather="check-circle"></i>{{ str_limit($wl['detail'], $limit = 120, $end = '...') }}
                                        </li>
                                    </ul>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-8">
                                        @if($discount->type == 1)
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin" || $discount->user_id == Auth::User()->id)
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $discount->id, 'slug' => $discount->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('course_id',$discount->id)->first();
                                        @endphp
                                        @if(!empty($order) && $order->status == 1)
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $discount->id, 'slug' => $discount->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if(!empty($cart))
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('remove.item.cart',$cart->id) }}">
                                                {{ csrf_field() }}

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $discount->id, 'price' => $discount->price, 'discount_price' => $discount->discount_price ]) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="category_id" value="{{$discount->category['id'] ?? '-'}}" />

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Add To Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @else
                                        @if($gsetting->guest_enable == 1)
                                        <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}


                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                            </div>
                                        </form>

                                        @else

                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $discount->id, 'slug' => $discount->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('course_id',$discount->id)->first();
                                        @endphp
                                        @if($enroll == NULL)
                                        <div class="protip-btn">
                                            <a href="{{url('enroll/show',$c->id)}}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $discount->id, 'slug' => $discount->slug ]) }}" class="btn btn-secondary" title="Cart">{{ __('Go To Course') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="img-wishlist">
                                            <div class="protip-wishlist">
                                                <ul>
                                                    @if(Auth::check())

                                                    @php
                                                    $wish = App\Wishlist::where('user_id',
                                                    Auth::User()->id)->where('course_id', $discount->id)->first();
                                                    @endphp
                                                    @if ($wish == NULL)
                                                        @if(!isset($existorder))
                                                            <li class="protip-wish-btn">
                                                                <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                    <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                                    <button class="wishlisht-btn" title="{{ __('Add to wishlist')}}" type="submit"><i data-feather="heart"></i></button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @else
                                                    <li class="protip-wish-btn-two">
                                                        <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                            <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                            <button class="wishlisht-btn heart-fill" title="{{ __('Remove from Wishlist')}}" type="submit"><i data-feather="heart"></i></button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                    @else
                                                    <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

    </div>
</section>
@endif
<!-- Student start -->

@if(Auth::check())
@if($hsetting->recentcourse_enable == 1 && isset($recent_course_id) && isset($recent_course))
<section id="student" class="student-main-block top-40">
    <div class="container-xl">

        @if($total_count >= '0')
        <h4 class="student-heading">{{ __('Recently Viewed Courses') }}</h4>
        <div id="recent-courses-slider" class="student-view-slider-main-block owl-carousel" data-reviewcor="{{ $recent_coursecnt }}">
            @foreach($recent_course_id as $view)
            @php

            $recent_course = App\Course::where('id', $view)->with('user')->first();

            @endphp
            @if(isset($recent_course))

            @if($recent_course->status == 1)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image">
                    <div class="view-block">
                        <div class="view-img">
                            @if($recent_course['preview_image'] !== NULL && $recent_course['preview_image'] !== '')
                            <a href="{{ route('user.course.show',['id' => $recent_course->id, 'slug' => $recent_course->slug ]) }}"><img data-src="{{ asset('images/course/'.$recent_course['preview_image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('user.course.show',['id' => $recent_course->id, 'slug' => $recent_course->slug ]) }}"><img data-src="{{ Avatar::create($recent_course->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        @if($recent_course['level_tags'] == 'trending')
                        <div class="advance-badge">
                            <span class="badge bg-warning">{{__('Trending')}}</span>
                        </div>
                        @endif
                        @if($recent_course['level_tags'] == 'featured')

                        <div class="advance-badge">
                            <span class="badge bg-danger">{{__('Featured')}}</span>
                        </div>
                        @endif
                        @if($recent_course['level_tags'] == 'new')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('New')}}</span>
                        </div>
                        @endif
                        @if($recent_course['level_tags'] == 'onsale')

                        <div class="advance-badge">
                            <span class="badge bg-info">{{__('On-sale')}}</span>
                        </div>
                        @endif
                        @if($recent_course['level_tags'] == 'bestseller')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('Bestseller')}}</span>
                        </div>
                        @endif
                        @if($recent_course['level_tags'] == 'beginner')

                        <div class="advance-badge">
                            <span class="badge bg-primary">{{__('Beginner')}}</span>
                        </div>
                        @endif
                        @if($recent_course['level_tags'] == 'intermediate')

                        <div class="advance-badge">
                            <span class="badge bg-secondary">{{__('Intermediate')}}</span>
                        </div>
                        @endif

                        <div class="view-user-img">

                            @if($recent_course->user['user_img'] !== NULL && $recent_course->user['user_img'] !== '')
                            <a href="{{ route('all/profile',$recent_course->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$recent_course->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$recent_course->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('user.course.show',['id' => $recent_course->id, 'slug' => $recent_course->slug ]) }}">{{ str_limit($recent_course->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$recent_course->user->id) }}"> {{ optional($recent_course->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="rating">
                                <ul>
                                    <li>
                                        <?php
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $sub_total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $recent_course->id)->get();
                                        ?>
                                        @if(!empty($reviews[0]))
                                        <?php
                                        $count =  App\ReviewRating::where('course_id', $recent_course->id)->count();

                                        foreach ($reviews as $review) {
                                            $learn = $review->price * 5;
                                            $price = $review->price * 5;
                                            $value = $review->value * 5;
                                            $sub_total = $sub_total + $learn + $price + $value;
                                        }

                                        $count = ($count * 3) * 5;
                                        $rat = $sub_total / $count;
                                        $ratings_var = ($rat * 100) / 5;
                                        ?>

                                        <div class="pull-left">
                                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>


                                        @else
                                        <div class="pull-left">{{ __('No Rating') }}</div>
                                        @endif
                                    </li>
                                    <!-- overall rating-->
                                    <?php
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $count =  count($reviews);
                                    $onlyrev = array();

                                    $reviewcount = App\ReviewRating::where('course_id', $recent_course->id)->WhereNotNull('review')->get();

                                    foreach ($reviews as $review) {

                                        $learn = $review->learn * 5;
                                        $price = $review->price * 5;
                                        $value = $review->value * 5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }

                                    $count = ($count * 3) * 5;

                                    if ($count != "" && $count > 0) {
                                        $rat = $sub_total / $count;

                                        $ratings_var = ($rat * 100) / 5;

                                        $overallrating = ($ratings_var / 2) / 10;
                                    }

                                    ?>

                                    @php
                                    $reviewsrating = App\ReviewRating::where('course_id', $recent_course->id)->first();
                                    @endphp
                                    <!-- @if(!empty($reviewsrating))
                                        <li>
                                            <b>{{ round($overallrating, 1) }}</b>
                                        </li>
                                        @endif -->

                                    <li class="reviews">
                                        (@php
                                        $data = App\ReviewRating::where('course_id', $recent_course->id)->count();
                                        if($data>0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp Reviews)
                                    </li>
                                </ul>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $recent_course->id)->count();
                                                if(($data)>0){

                                                echo $data;
                                                }
                                                else{

                                                echo "0";
                                                }
                                                @endphp</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if( $recent_course->type == 1)
                                        <div class="rate text-right">
                                            <ul>

                                                @if($recent_course->discount_price == !NULL)

                                                <li><a><b>
                                                            {{ currency($recent_course->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}
                                                        </b></a>
                                                </li>

                                                <li><a><b><strike>{{ currency($recent_course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</strike></b></a>
                                                </li>


                                                @else
                                                <li><a><b>
                                                            {{ currency($recent_course->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) }}</b></a>
                                                </li>


                                                @endif
                                            </ul>
                                        </div>
                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>
                                        @if(Auth::check())
                                        @php
                                        $wish = App\Wishlist::where('user_id', auth()->user()->id)->where('course_id',$recent_course->id)->first();
                                        $existorder = App\Order::where('user_id',Auth::User()->id)->where('course_id', $recent_course->id)->where('refunded', '0')->first();
                                        @endphp
                                        @if ($wish == NULL)
                                            @if(!isset($existorder))
                                                <li class="protip-wish-btn">
                                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $recent_course->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}" />
                                                        <input type="hidden" name="course_id" value="{{$recent_course->id}}" />

                                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart" class="rgt-10"></i></button>
                                                    </form>
                                                </li>
                                            @endif
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $recent_course->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{auth()->user()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$recent_course->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart" class="rgt-10"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart" class="rgt-10"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @endif
            @endif
            @endforeach
        </div>
        @endif

    </div>
</section>
@endif
@endif
<!-- Students end -->
<!-- Student start -->
@if(Auth::check())
@php
if(Schema::hasColumn('orders', 'refunded'))
{
$enroll = App\Order::where('refunded', '0')->where('user_id', auth()->user()->id)->where('status',
'1')->with('courses')->with(['user','courses.user'] )->get();

$enrollcnt = App\Order::where('refunded', '0')->where('user_id', auth()->user()->id)->where('status',
'1')->whereHas('courses', function($q){
$q->where('status', '=', "1");
})->with(['user','courses.user'] )->get()->count();
}
else{
$enroll = NULL;
}
@endphp
@if($hsetting->purchase_enable == 1 && isset($enroll))
<section id="student" class="student-main-block top-40">
    <div class="container-xl">
        @if(count($enroll) > 0)
        <h4 class="student-heading">{{ __('My Purchased Courses') }}</h4>
        <div id="my-courses-slider" class="student-view-slider-main-block owl-carousel" data-purcor="{{ $enrollcnt }}">
            @foreach($enroll as $enrol)
            @if(isset($enrol->courses) && $enrol->courses['status'] == 1 )
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image">
                    <div class="view-block">
                        <div class="view-img">
                            @if($enrol->courses['preview_image'] !== NULL && $enrol->courses['preview_image'] !== '')
                            <a href="{{ route('course.content',['id' => $enrol->courses->id, 'slug' => $enrol->courses->slug ]) }}"><img data-src="{{ asset('images/course/'.$enrol->courses['preview_image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('course.content',['id' => $enrol->courses->id, 'slug' => $enrol->courses->slug ]) }}"><img data-src="{{ Avatar::create($enrol->courses->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        <div class="view-user-img">

                            @if($enrol->courses->user['user_img'] !== NULL && $enrol->courses->user['user_img'] !== '')
                            <a href="{{ route('all/profile',$enrol->instructor_id) }}" title=""><img src="{{ asset('images/user_img/'.$enrol->courses->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$enrol->instructor_id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('course.content',['id' => $enrol->courses->id, 'slug' => $enrol->courses->slug ]) }}">{{ str_limit($enrol->courses->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                {{-- <h6>By <span><a href="{{ route('all/profile',$enrol->user->id) }}"> {{ optional($enrol->user)['fname'] }}</a></span></h6> --}}
                                <h6><a href="{{ route('course.content',['id' => $enrol->courses->id, 'slug' => $enrol->courses->slug ]) }}">{{__('Go To Course') }}</a></h6>
                            </div>
                            <div class="rating">
                                <ul>
                                    <li>
                                        <?php
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $sub_total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $enrol->courses->id)->get();
                                        ?>
                                        @if(!empty($reviews[0]))
                                        <?php
                                        $count =  App\ReviewRating::where('course_id', $enrol->courses->id)->count();

                                        foreach ($reviews as $review) {
                                            $learn = $review->price * 5;
                                            $price = $review->price * 5;
                                            $value = $review->value * 5;
                                            $sub_total = $sub_total + $learn + $price + $value;
                                        }

                                        $count = ($count * 3) * 5;
                                        $rat = $sub_total / $count;
                                        $ratings_var = ($rat * 100) / 5;
                                        ?>

                                        <div class="pull-left">
                                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>


                                        @else
                                        <div class="pull-left">{{ __('No Rating') }}</div>
                                        @endif
                                    </li>
                                    <!-- overall rating-->
                                    <?php
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $count =  count($reviews);
                                    $onlyrev = array();

                                    $reviewcount = App\ReviewRating::where('course_id', $enrol->courses->id)->WhereNotNull('review')->get();

                                    foreach ($reviews as $review) {

                                        $learn = $review->learn * 5;
                                        $price = $review->price * 5;
                                        $value = $review->value * 5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }

                                    $count = ($count * 3) * 5;

                                    if ($count != "" && $count != 0) {
                                        $rat = $sub_total / $count;

                                        $ratings_var = ($rat * 100) / 5;

                                        $overallrating = ($ratings_var / 2) / 10;
                                    }

                                    ?>

                                    @php
                                    $reviewsrating = App\ReviewRating::where('course_id', $enrol->courses->id)->first();
                                    @endphp

                                    <li class="reviews">
                                        (@php
                                        $data = App\ReviewRating::where('course_id', $enrol->courses->id)->count();
                                        if($data>0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp Reviews)
                                    </li>
                                </ul>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $enrol->courses->id)->count();
                                                if(($data)>0){

                                                echo $data;
                                                }
                                                else{

                                                echo "0";
                                                }
                                                @endphp</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if( $enrol->courses->type == 1)
                                        <div class="rate text-right">
                                            <ul>


                                                @if($enrol->courses->discount_price == !NULL)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format( currency($enrol->courses->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format( currency($enrol->courses->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>




                                                @else

                                                <li><a><b>
                                                            {{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }} {{ price_format( currency($enrol->courses->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }} {{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                @endif
                                            </ul>
                                        </div>
                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            @endif
            @endforeach
        </div>
        @endif

    </div>
</section>
@endif
@endif
<!-- Students end -->

<!-- learning-courses start -->
@if($hsetting->recentcourse_enable == 1 && count($r_course)> 0)
<section id="learning-courses" class="learning-courses-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                <h4 class="student-heading">{{ __('Recent Courses') }}</h4>
            </div>
            <div class="col-lg-6 col-md-6 col-5">
                @if(count($r_course_count) > 5)
                <div class="view-button txt-rgt">
                    <a href="{{url('toprecent/view')}}" class="btn btn-secondary" title="View More">View More<i data-feather="chevron-right"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>
        <div id="" class="student-view-slider-main-block row">
            @foreach($r_course as $c)
            @if($c->status == 1)
            <div class="item student-view-block student-view-block-1 col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block{{$c->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @if($c['preview_image'] !== NULL && $c['preview_image'] !== '')
                            <a href="{{ route('user.course.show',['id' => $c->id, 'slug' => $c->slug ]) }}"><img src="{{ asset('images/course/'.$c['preview_image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('user.course.show',['id' => $c->id, 'slug' => $c->slug ]) }}"><img data-src="{{ Avatar::create($c->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        {{-- <div class="badges bg-priamry offer-badge"><span>OFF<span><?php echo round((($c->price - $c->discount_price) * 100) / $c->price) . '%'; ?></span></span></div> --}}

                        @if($c['level_tags'] == 'trending')
                        <div class="advance-badge">
                            <span class="badge bg-warning">{{__('Trending')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'featured')

                        <div class="advance-badge">
                            <span class="badge bg-danger">{{__('Featured')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'new')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('New')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'onsale')

                        <div class="advance-badge">
                            <span class="badge bg-info">{{__('Onsale')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'bestseller')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('Bestseller')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'beginner')

                        <div class="advance-badge">
                            <span class="badge bg-primary">{{__('Beginner')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'intermediate')

                        <div class="advance-badge">
                            <span class="badge bg-secondary">{{__('Intermediate')}}</span>
                        </div>
                        @endif
                        <div class="view-user-img">

                            @if(optional($c->user)['user_img'] !== NULL && optional($c->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$c->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$c->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$c->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif


                        </div>

                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('user.course.show',['id' => $c->id, 'slug' => $c->slug ]) }}">{{ str_limit($c->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$c->user->id) }}"> {{ optional($c->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="rating">
                                <ul>
                                    <li>
                                        <?php
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $sub_total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $c->id)->get();
                                        ?>
                                        @if(!empty($reviews[0]))
                                        <?php
                                        $count =  App\ReviewRating::where('course_id', $c->id)->count();

                                        foreach ($reviews as $review) {
                                            $learn = $review->price * 5;
                                            $price = $review->price * 5;
                                            $value = $review->value * 5;
                                            $sub_total = $sub_total + $learn + $price + $value;
                                        }

                                        $count = ($count * 3) * 5;
                                        $rat = $sub_total / $count;
                                        $ratings_var = ($rat * 100) / 5;
                                        ?>

                                        <div class="pull-left">
                                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>


                                        @else
                                        <div class="pull-left">{{ __('No Rating') }}</div>
                                        @endif
                                    </li>
                                    <!-- overall rating-->
                                    <?php
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $count =  count($reviews);
                                    $onlyrev = array();

                                    $reviewcount = App\ReviewRating::where('course_id', $c->id)->WhereNotNull('review')->get();

                                    foreach ($reviews as $review) {

                                        $learn = $review->learn * 5;
                                        $price = $review->price * 5;
                                        $value = $review->value * 5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }

                                    $count = ($count * 3) * 5;

                                    if ($count != "" && $count != 0) {
                                        $rat = $sub_total / $count;

                                        $ratings_var = ($rat * 100) / 5;

                                        $overallrating = ($ratings_var / 2) / 10;
                                    }

                                    ?>

                                    @php
                                    $reviewsrating = App\ReviewRating::where('course_id', $c->id)->first();
                                    @endphp
                                    @if(!empty($reviewsrating))
                                    <!-- <li>
                                            <b>{{ round($overallrating, 1) }}</b>
                                        </li> -->
                                    @endif
                                    <li class="reviews">
                                        (@php
                                        $data = App\ReviewRating::where('course_id', $c->id)->count();
                                        if($data>0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp Reviews)
                                    </li>

                                </ul>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $c->id)->count();
                                                if(($data)>0){

                                                echo $data;
                                                }
                                                else{

                                                echo "0";
                                                }
                                                @endphp</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if( $c->type == 1)
                                        <div class="rate text-right">
                                            <ul>

                                                @if($c->discount_price == !NULL)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($c['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>


                                                @else

                                                @if($c->price == !NULL)
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>
                                                @endif

                                                @endif
                                            </ul>
                                        </div>
                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>



                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $c['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($c->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',$c->id)->first();
                                        $existorder = App\Order::where('user_id',Auth::User()->id)->where('course_id', $c->id)->where('refunded', '0')->first();
                                        @endphp
                                        @if ($wish == NULL)
                                            @if(!isset($existorder))
                                                <li class="protip-wish-btn">
                                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                        <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                                    </form>
                                                </li>
                                            @endif
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block{{$c->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $c['title'] }}</h5>
                            <div class="main-des">
                                <p>Last Updated: {{ date('jS F Y', strtotime($c->updated_at)) }}</p>
                            </div>

                            <ul class="description-list">
                                <li>
                                    <i data-feather="play-circle"></i>
                                    <div class="class-des">
                                        {{ __('Classes') }}:
                                        @php
                                        $data = App\CourseClass::where('course_id', $c->id)->count();
                                        if($data > 0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp
                                    </div>
                                </li>
                                &nbsp;
                                <li>
                                    <div>
                                        <div class="time-des">
                                            <span class="">
                                                <i data-feather="clock"></i>
                                                @php

                                                $classtwo = App\CourseClass::where('course_id',
                                                $c->id)->sum("duration");

                                                @endphp
                                                {{ $classtwo }} Minutes
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="lang-des">
                                        @if($c['language_id'] == !NULL)
                                        @if(isset($c->language))
                                        <i data-feather="globe"></i> {{ $c->language['name'] }}
                                        @endif
                                        @endif
                                    </div>
                                </li>

                            </ul>

                            <div class="product-main-des">
                                <p>{{ $c->short_detail }}</p>
                            </div>
                            <div>
                                @if($c->whatlearns->isNotEmpty())
                                @foreach($c->whatlearns as $wl)
                                @if($wl->status ==1)
                                <div class="product-learn-dtl">
                                    <ul>
                                        <li><i data-feather="check-circle"></i>{{ str_limit($wl['detail'], $limit = 120, $end = '...') }}
                                        </li>
                                    </ul>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-8">
                                        @if($c->type == 1)
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin" || $c->user_id == Auth::User()->id)
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $c->id, 'slug' => $c->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('course_id',
                                        $c->id)->first();
                                        @endphp
                                        @if(!empty($order) && $order->status == 1)
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $c->id, 'slug' => $c->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('course_id',
                                        $c->id)->first();
                                        @endphp
                                        @if(!empty($cart))
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('remove.item.cart',$cart->id) }}">
                                                {{ csrf_field() }}

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $c->id, 'price' => $c->price, 'discount_price' => $c->discount_price ]) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="category_id" value="{{$c->category['id'] ?? '-'}}" />

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>{{ __('Add To Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @else
                                        @if($gsetting->guest_enable == 1)
                                        <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}


                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                            </div>
                                        </form>

                                        @else

                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $c->id, 'slug' => $c->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('course_id',
                                        $c->id)->first();
                                        @endphp
                                        @if($enroll == NULL)
                                        <div class="protip-btn">
                                            <a href="{{url('enroll/show',$c->id)}}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $c->id, 'slug' => $c->slug ]) }}" class="btn btn-secondary" title="Cart">{{ __('Go To Course') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="img-wishlist">
                                            <div class="protip-wishlist">
                                                <ul>
                                                    @if(Auth::check())

                                                    @php
                                                    $wish = App\Wishlist::where('user_id',
                                                    Auth::User()->id)->where('course_id', $c->id)->first();
                                                    @endphp
                                                    @if ($wish == NULL)
                                                        @if(!isset($existorder))
                                                            <li class="protip-wish-btn">
                                                                <form id="demo-form2" method="post" action="{{ url('show/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                    <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                                    <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @else
                                                    <li class="protip-wish-btn-two">
                                                        <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                            <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                            <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                    @else
                                                    <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <!-- Old recentcourse -->
        <div class="row d-none">
            <div class="col-lg-12">
                <div class="learning-courses">
                    @if(isset($categories))
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @foreach($categories as $cats)

                        <li class="btn nav-item"><a class="nav-item nav-link" id="home-tab" data-toggle="tab" href="#content-tabs" role="tab" aria-controls="home" onclick="showtab('{{ $cats->id }}')" aria-selected="true">{{ $cats['title'] }}</a></li>

                        @endforeach
                    </ul>
                    @endif
                </div>
                <div class="tab-content" id="myTabContent">
                    @if(!empty($categories))
                    @foreach($categories as $cate)
                    <div class="tab-pane fade show active" id="content-tabs" role="tabpanel" aria-labelledby="home-tab">
                        <div id="tabShow">
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- learning-courses end -->
<!-- Advertisement -->
@if(isset($advs))
@foreach($advs as $adv)
@if($adv->position == 'belowrecent')
<br>
<section id="student" class="student-main-block btm-40">
    <div class="container-xl">
        <a href="{{ $adv->url1 }}" title="{{ __('Click to visit') }}">
            <img class="lazy img-fluid advertisement-img-one" data-src="{{ url('images/advertisement/'.$adv->image1) }}" alt="{{ $adv->image1 }}">
        </a>
    </div>
</section>
@endif

@endforeach

@endif
<!-- Advertisement -->
<!-- Student start -->

@if( ! $cors->isEmpty() && $hsetting->featured_enable)
<section id="student" class="student-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-7">
                <h4 class="student-heading">{{ __('Featured Courses') }}</h4>
            </div>
            @if(count($cors) > 4)
            <div class="col-lg-6 col-md-6 col-5">
                <div class="view-button txt-rgt">
                    <a href="{{ url('featuredcourse/view') }}" class="btn btn-secondary" title="View More">{{__('View More')}}<i data-feather="chevron-right"></i>
                    </a>
                </div>
            </div>
            @endif
        </div>
        <div id="student-view-slider" class="student-view-slider-main-block owl-carousel" data-featcor="{{ count($cors) }}">
            @foreach($cors as $c)
            @if($c->status == 1 && $c->featured == 1)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-fc{{$c->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @if($c['preview_image'] !== NULL && $c['preview_image'] !== '')
                            <a href="{{ route('user.course.show',['id' => $c->id, 'slug' => $c->slug ]) }}"><img data-src="{{ asset('images/course/'.$c['preview_image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('user.course.show',['id' => $c->id, 'slug' => $c->slug ]) }}"><img data-src="{{ Avatar::create($c->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        {{-- <div class="badges bg-priamry offer-badge"><span>OFF<span><?php echo round((($c->price - $c->discount_price) * 100) / $c->price) . '%'; ?></span></span></div> --}}

                        @if($c['level_tags'] == 'trending')
                        <div class="advance-badge">
                            <span class="badge bg-warning">{{__('Trending')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'featured')

                        <div class="advance-badge">
                            <span class="badge bg-danger">{{__('Featured')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'new')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('New')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'onsale')

                        <div class="advance-badge">
                            <span class="badge bg-info">{{__('Onsale')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'bestseller')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('Bestseller')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'beginner')

                        <div class="advance-badge">
                            <span class="badge bg-primary">{{__('Beginner')}}</span>
                        </div>
                        @endif
                        @if($c['level_tags'] == 'intermediate')

                        <div class="advance-badge">
                            <span class="badge bg-secondary">{{__('Intermediate')}}</span>
                        </div>
                        @endif
                        <div class="view-user-img">

                            @if(optional($c->user)['user_img'] !== NULL && optional($c->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$c->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$c->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$c->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif


                        </div>

                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('user.course.show',['id' => $c->id, 'slug' => $c->slug ]) }}">{{ str_limit($c->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$c->user->id) }}"> {{ optional($c->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="rating">
                                <ul>
                                    <li>
                                        <?php
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $sub_total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $c->id)->get();
                                        ?>
                                        @if(!empty($reviews[0]))
                                        <?php
                                        $count =  App\ReviewRating::where('course_id', $c->id)->count();

                                        foreach ($reviews as $review) {
                                            $learn = $review->price * 5;
                                            $price = $review->price * 5;
                                            $value = $review->value * 5;
                                            $sub_total = $sub_total + $learn + $price + $value;
                                        }

                                        $count = ($count * 3) * 5;
                                        $rat = $sub_total / $count;
                                        $ratings_var = ($rat * 100) / 5;
                                        ?>

                                        <div class="pull-left">
                                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>


                                        @else
                                        <div class="pull-left">{{ __('No Rating') }}</div>
                                        @endif
                                    </li>
                                    <!-- overall rating-->
                                    <?php
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $count =  count($reviews);
                                    $onlyrev = array();

                                    $reviewcount = App\ReviewRating::where('course_id', $c->id)->WhereNotNull('review')->get();

                                    foreach ($reviews as $review) {

                                        $learn = $review->learn * 5;
                                        $price = $review->price * 5;
                                        $value = $review->value * 5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }

                                    $count = ($count * 3) * 5;

                                    if ($count != "" && $count != 0) {
                                        $rat = $sub_total / $count;

                                        $ratings_var = ($rat * 100) / 5;

                                        $overallrating = ($ratings_var / 2) / 10;
                                    }

                                    ?>

                                    @php
                                    $reviewsrating = App\ReviewRating::where('course_id', $c->id)->first();
                                    @endphp
                                    @if(!empty($reviewsrating))
                                    <!-- <li>
                                            <b>{{ round($overallrating, 1) }}</b>
                                        </li> -->
                                    @endif
                                    <li class="reviews">
                                        (@php
                                        $data = App\ReviewRating::where('course_id', $c->id)->count();
                                        if($data>0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp Reviews)
                                    </li>

                                </ul>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $c->id)->count();
                                                if(($data)>0){

                                                echo $data;
                                                }
                                                else{

                                                echo "0";
                                                }
                                                @endphp</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if( $c->type == 1)
                                        <div class="rate text-right">
                                            <ul>

                                                @if($c->discount_price == !NULL)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($c['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>


                                                @else

                                                @if($c->price == !NULL)
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($c['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>
                                                @endif

                                                @endif
                                            </ul>
                                        </div>
                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>



                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $c['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($c->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',$c->id)->first();
                                        $existorder = App\Order::where('user_id',Auth::User()->id)->where('course_id', $c->id)->where('refunded', '0')->first();
                                        @endphp
                                        @if ($wish == NULL)
                                            @if(!isset($existorder))
                                                <li class="protip-wish-btn">
                                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                        <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                                    </form>
                                                </li>
                                            @endif
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-fc{{$c->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $c['title'] }}</h5>
                            <div class="main-des">
                                <p>Last Updated: {{ date('jS F Y', strtotime($c->updated_at)) }}</p>
                            </div>

                            <ul class="description-list">
                                <li>
                                    <i data-feather="play-circle"></i>
                                    <div class="class-des">
                                        {{ __('Classes') }}:
                                        @php
                                        $data = App\CourseClass::where('course_id', $c->id)->count();
                                        if($data > 0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp
                                    </div>
                                </li>
                                &nbsp;
                                <li>
                                    <div>
                                        <div class="time-des">
                                            <span class="">
                                                <i data-feather="clock"></i>
                                                @php

                                                $classtwo = App\CourseClass::where('course_id',
                                                $c->id)->sum("duration");

                                                @endphp
                                                {{ $classtwo }} Minutes
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="lang-des">
                                        @if($c['language_id'] == !NULL)
                                        @if(isset($c->language))
                                        <i data-feather="globe"></i> {{ $c->language['name'] }}
                                        @endif
                                        @endif
                                    </div>
                                </li>

                            </ul>

                            <div class="product-main-des">
                                <p>{{ $c->short_detail }}</p>
                            </div>
                            <div>
                                @if($c->whatlearns->isNotEmpty())
                                @foreach($c->whatlearns as $wl)
                                @if($wl->status ==1)
                                <div class="product-learn-dtl">
                                    <ul>
                                        <li><i data-feather="check-circle"></i>{{ str_limit($wl['detail'], $limit = 120, $end = '...') }}
                                        </li>
                                    </ul>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-8">
                                        @if($c->type == 1)
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin" || $c->user_id == Auth::User()->id)
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $c->id, 'slug' => $c->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('course_id',
                                        $c->id)->first();
                                        @endphp
                                        @if(!empty($order) && $order->status == 1)
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $c->id, 'slug' => $c->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('course_id',
                                        $c->id)->first();
                                        @endphp
                                        @if(!empty($cart))
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('remove.item.cart',$cart->id) }}">
                                                {{ csrf_field() }}

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $c->id, 'price' => $c->price, 'discount_price' => $c->discount_price ]) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="category_id" value="{{$c->category['id'] ?? '-'}}" />

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>{{ __('Add To Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @else
                                        @if($gsetting->guest_enable == 1)
                                        <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}


                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                            </div>
                                        </form>

                                        @else

                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $c->id, 'slug' => $c->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('course_id',
                                        $c->id)->first();
                                        @endphp
                                        @if($enroll == NULL)
                                        <div class="protip-btn">
                                            <a href="{{url('enroll/show',$c->id)}}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $c->id, 'slug' => $c->slug ]) }}" class="btn btn-secondary" title="Cart">{{ __('Go To Course') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="img-wishlist">
                                            <div class="protip-wishlist">
                                                <ul>
                                                    @if(Auth::check())

                                                    @php
                                                    $wish = App\Wishlist::where('user_id',
                                                    Auth::User()->id)->where('course_id', $c->id)->first();
                                                    @endphp
                                                    @if ($wish == NULL)
                                                        @if(!isset($existorder))
                                                            <li class="protip-wish-btn">
                                                                <form id="demo-form2" method="post" action="{{ url('show/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                    <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                                    <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @else
                                                    <li class="protip-wish-btn-two">
                                                        <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $c->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                            <input type="hidden" name="course_id" value="{{$c->id}}" />

                                                            <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                    @else
                                                    <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

    </div>
</section>
@endif
<!-- Students end -->

<!-- Subscription Bundle start -->
<section id="subscription" class="student-main-block">
    <div class="container-xl">
        @if (isset($subscriptionBundles) && !$subscriptionBundles->isEmpty())
        <h4 class="student-heading">{{ __('Subscription Bundles') }} </h4>
        <div id="subscription-bundle-view-slider" class="student-view-slider-main-block owl-carousel" data-subucor="{{ count($subscriptionBundles) }}">
            @foreach ($subscriptionBundles as $bundle)
            @if ($bundle->status == 1 && $bundle->is_subscription_enabled == 1)

            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image protip" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-3{{ $bundle->id }}">
                    <div class="view-block">
                        <div class="view-img">
                            @if ($bundle['preview_image'] !== null && $bundle['preview_image'] !== '')
                            <a href="{{ route('bundle.detail', $bundle->id) }}"><img data-src="{{ asset('images/bundle/' . $bundle['preview_image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('bundle.detail', $bundle->id) }}"><img data-src="{{ Avatar::create($bundle->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        <div class="badges bg-priamry offer-badge"><span>OFF<span><?php echo round((($bundle->price - $bundle->discount_price) * 100) / $bundle->price) . '%'; ?></span></span></div>

                        <div class="view-user-img">

                            @if($bundle->user['user_img'] !== NULL && $bundle->user['user_img'] !== '')
                            <a href="{{ route('all/profile',$bundle->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$bundle->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$bundle->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('bundle.detail', $bundle->id) }}">{{ str_limit($bundle->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$bundle->user->id) }}"> {{ optional($bundle->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y', strtotime($bundle['created_at'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if ($bundle->type == 1 && $bundle->price != null)
                                        <div class="rate text-right">
                                            <ul>
                                                @if ($bundle->discount_price == !null)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>


                                                @else



                                                <li><a><b>
                                                            {{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>

                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-3{{ $bundle->id }}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $bundle['title'] }}</h5>
                            <div class="main-des">
                                @if($bundle['short_detail'] != NUll)

                                <p>{{ str_limit($bundle['short_detail'], $limit = 200, $end = '...') }}</p>
                                @else
                                <p>{{ str_limit($bundle['detail'], $limit = 200, $end = '...') }}</p>
                                @endif
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if ($bundle->type == 1)
                                        @if (Auth::check())
                                        @if (Auth::User()->role == 'admin')
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary" title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $order = App\Order::where('user_id',
                                        Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if (!empty($order) && $order->status == 1)
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary" title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $cart = App\Cart::where('user_id',
                                        Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if (!empty($cart))
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('remove.item.cart', $cart->id) }}">
                                                {{ csrf_field() }}

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('bundlecart', $bundle->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{ Auth::User()->id }}" />
                                                <input type="hidden" name="bundle_id" value="{{ $bundle->id }}" />

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Subscribe Now') }}</button>
                                                </div>


                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">

                                            <a href="{{ route('login') }}" class="btn btn-primary"><i class="fa fa-cart-plus" aria-hidden="true"></i>&nbsp;{{ __('Subscribe Now') }}</a>

                                        </div>
                                        @endif
                                        @else
                                        @if (Auth::check())
                                        @if (Auth::User()->role == 'admin')
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary" title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $enroll = App\Order::where('user_id',
                                        Auth::User()->id)->where('course_id', $c->id)->first();
                                        @endphp
                                        @if ($enroll == null)
                                        <div class="protip-btn">
                                            <a href="{{ url('enroll/show', $bundle->id) }}" class="btn btn-primary" title="Enroll Now">{{ __('Subscribe Now') }}</a>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary" title="Cart">{{ __('Purchased') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now">{{ __('Subscribe Now') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif

            @endforeach
        </div>
        @endif
    </div>
</section>
<!-- Subscription Bundle end -->

<!-- Bundle start -->
@if(!$bundles->isEmpty() && $hsetting->bundle_enable && isset($bundles))
<section id="bundle-block" class="student-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-7">
                <h4 class="student-heading">{{ __('Bundle Courses') }} </h4>
            </div>
            @if(count($bundles) > 4)
            <div class="col-lg-6 col-md-6 col-5">
                <div class="view-button txt-rgt">
                    <a href="{{url('bundles/view')}}" class="btn btn-secondary" title="View More">View More<i data-feather="chevron-right"></i>
                    </a>
                </div>
            </div>
            @endif
        </div>
        @if(count($bundles) > 0)

        <div id="bundle-view-slider" class="student-view-slider-main-block owl-carousel" data-buco="{{ count($bundles) }}">
            @foreach($bundles as $bundle)
            @if($bundle->status == 1)

            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-4{{$bundle->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @if($bundle['preview_image'] !== NULL && $bundle['preview_image'] !== '')
                            <a href="{{ route('bundle.detail', $bundle->id) }}"><img data-src="{{ asset('images/bundle/'.$bundle['preview_image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('bundle.detail', $bundle->id) }}"><img data-src="{{ Avatar::create($bundle->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        <div class="view-user-img">

                            @if($bundle->user['user_img'] !== NULL && $bundle->user['user_img'] !== '')
                            <a href="{{ route('all/profile',$bundle->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$bundle->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$bundle->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('bundle.detail', $bundle->id) }}">{{ str_limit($bundle->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$bundle->user->id) }}"> {{ optional($bundle->user)['fname'] }}</a></span></h6>
                            </div>
                            <!-- <p class="btm-10"><a herf="#">{{ __('by') }} @if(isset($bundle->user)) {{ $bundle->user['fname'] }} {{ $bundle->user['lname'] }} @endif</a></p> -->

                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                {{ $bundle->order->count() }}</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if($bundle->type == 1 && $bundle->price != null)
                                        <div class="rate text-right">
                                            <ul>

                                                @if($bundle->discount_price == !NULL)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->discount_price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>


                                                @else
                                                <li><a><b>
                                                            {{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format(  currency($bundle->price, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $bundle['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($bundle->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',$bundle->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $bundle->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$bundle->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $bundle->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$bundle->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div id="prime-next-item-description-block-4{{$bundle->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $bundle['title'] }}</h5>

                            <div class="product-main-des">
                                <p>{{ strip_tags(str_limit($bundle['detail'], $limit = 200, $end = '...')) }}</p>
                            </div>
                            <div>
                                <div class="product-learn-dtl">
                                    <ul>

                                        @foreach ($bundle->course_id as $bundles)

                                        @php
                                        $course = App\Course::where('id', $bundles)->first();
                                        @endphp
                                        @isset($course)
                                        <li><i data-feather="check-circle"></i>
                                            <a href="#">{{ $course['title'] }}</a>
                                        </li>
                                        @endisset

                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if($bundle->type == 1)
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary" title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if(!empty($order) && $order->status == 1)
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary" title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if(!empty($cart))
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('remove.item.cart',$cart->id) }}">
                                                {{ csrf_field() }}

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('bundlecart', $bundle->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="bundle_id" value="{{$bundle->id}}" />

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>{{ __('Add To Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                        </div>
                                        @endif
                                        @else
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary" title="course">{{ __('Purchased') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('bundle_id',
                                        $bundle->id)->first();
                                        @endphp
                                        @if($enroll == NULL)
                                        <div class="protip-btn">
                                            <a href="{{url('enroll/show',$bundle->id)}}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <a href="" class="btn btn-secondary" title="Cart">{{ __('Purchased') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            @endif

            @endforeach
        </div>
        @endif

    </div>
</section>
@endif
<!-- Bundle end -->
@if(! $bestselling->isEmpty() && $hsetting->bestselling_enable && isset($bestselling) && count($bestselling) > 0 )
<section id="student" class="student-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-7">
                <h4 class="student-heading">{{ __('Best selling Courses') }}</h4>
            </div>
            @if(count($bestselling) > 4)
            <div class="col-lg-6 col-md-6 col-5">
                <div class="view-button txt-rgt">
                    <a href="{{ url('bestselling/view') }}" class="btn btn-secondary" title="View More">View More<i data-feather="chevron-right"></i>
                    </a>
                </div>
            </div>
            @endif
        </div>
        <div id="bestseller-view-slider" class="student-view-slider-main-block owl-carousel" data-besse="{{ count($bestselling) }}">
            @foreach($bestselling as $best)

            @if($best->courses->status == 1 )

            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-best{{$best->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @if($best->courses['preview_image'] !== NULL && $best->courses['preview_image'] !== '')
                            <a href="{{ route('user.course.show',['id' => $best->courses->id, 'slug' => $best->courses->slug ]) }}"><img data-src="{{ asset('images/course/'.$best->courses['preview_image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('user.course.show',['id' => $best->courses->id, 'slug' => $best->courses->slug ]) }}"><img data-src="{{ Avatar::create($best->title)->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif
                        </div>
                        @if($best->courses['level_tags'] == 'trending')
                        <div class="advance-badge">
                            <span class="badge bg-warning">{{__('Trending')}}</span>
                        </div>
                        @endif
                        @if($best->courses['level_tags'] == 'featured')

                        <div class="advance-badge">
                            <span class="badge bg-danger">{{__('Featured')}}</span>
                        </div>
                        @endif
                        @if($best->courses['level_tags'] == 'new')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('New')}}</span>
                        </div>
                        @endif
                        @if($best->courses['level_tags'] == 'onsale')

                        <div class="advance-badge">
                            <span class="badge bg-info">{{__('Onsale')}}</span>
                        </div>
                        @endif
                        @if($best->courses['level_tags'] == 'bestseller')

                        <div class="advance-badge">
                            <span class="badge bg-success">{{__('Bestseller')}}</span>
                        </div>
                        @endif
                        @if($best->courses['level_tags'] == 'beginner')

                        <div class="advance-badge">
                            <span class="badge bg-primary">{{__('Beginner')}}</span>
                        </div>
                        @endif
                        @if($best->courses['level_tags'] == 'intermediate')

                        <div class="advance-badge">
                            <span class="badge bg-secondary">{{__('Intermediate')}}</span>
                        </div>
                        @endif
                        <div class="view-user-img">
                            @if($best->courses->user['user_img'] !== NULL && $best->courses->user['user_img'] !== '')
                            <a href="{{ route('all/profile',$best->courses->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$best->courses->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$best->courses->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif

                        </div>

                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('user.course.show',['id' => $best->courses->id, 'slug' => $best->courses->slug ]) }}">{{ str_limit($best->courses->title, $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$best->courses->user->id) }}"> {{ optional($best->courses->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="rating">
                                <ul>
                                    <li>
                                        <?php
                                        $learn = 0;
                                        $price = 0;
                                        $value = 0;
                                        $sub_total = 0;
                                        $sub_total = 0;
                                        $reviews = App\ReviewRating::where('course_id', $best->courses->id)->get();
                                        ?>
                                        @if(!empty($reviews[0]))
                                        <?php
                                        $count =  App\ReviewRating::where('course_id', $best->courses->id)->count();

                                        foreach ($reviews as $review) {
                                            $learn = $review->price * 5;
                                            $price = $review->price * 5;
                                            $value = $review->value * 5;
                                            $sub_total = $sub_total + $learn + $price + $value;
                                        }

                                        $count = ($count * 3) * 5;
                                        $rat = $sub_total / $count;
                                        $ratings_var = ($rat * 100) / 5;
                                        ?>

                                        <div class="pull-left">
                                            <div class="star-ratings-sprite"><span style="width:<?php echo $ratings_var; ?>%" class="star-ratings-sprite-rating"></span>
                                            </div>
                                        </div>


                                        @else
                                        <div class="pull-left">{{ __('No Rating') }}</div>
                                        @endif
                                    </li>
                                    <!-- overall rating-->
                                    <?php
                                    $learn = 0;
                                    $price = 0;
                                    $value = 0;
                                    $sub_total = 0;
                                    $count =  count($reviews);
                                    $onlyrev = array();

                                    $reviewcount = App\ReviewRating::where('course_id', $best->courses->id)->WhereNotNull('review')->get();

                                    foreach ($reviews as $review) {

                                        $learn = $review->learn * 5;
                                        $price = $review->price * 5;
                                        $value = $review->value * 5;
                                        $sub_total = $sub_total + $learn + $price + $value;
                                    }

                                    $count = ($count * 3) * 5;

                                    if ($count != "" && $count != 0) {
                                        $rat = $sub_total / $count;

                                        $ratings_var = ($rat * 100) / 5;

                                        $overallrating = ($ratings_var / 2) / 10;
                                    }

                                    ?>

                                    @php
                                    $reviewsrating = App\ReviewRating::where('course_id', $best->courses->id)->first();
                                    @endphp
                                    @if(!empty($reviewsrating))
                                    <!-- <li>
                                                <b>{{ round($overallrating, 1) }}</b>
                                            </li> -->
                                    @endif
                                    <li class="reviews">
                                        (@php
                                        $data = App\ReviewRating::where('course_id', $best->courses->id)->count();
                                        if($data>0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp Reviews)
                                    </li>

                                </ul>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="count-user">
                                            <i data-feather="user"></i><span>
                                                @php
                                                $data = App\Order::where('course_id', $best->courses->id)->count();
                                                if(($data)>0){

                                                echo $data;
                                                }
                                                else{

                                                echo "0";
                                                }
                                                @endphp</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        @if( $best->courses->type == 1)
                                        <div class="rate text-right">
                                            <ul>

                                                @if($best->courses->discount_price == !NULL)

                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($best->courses['discount_price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false)) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>

                                                <li><a><b><strike>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($best->courses['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</strike></b></a>
                                                </li>


                                                @else

                                                @if($c->price == !NULL)
                                                <li><a><b>{{ activeCurrency()->getData()->position == 'l'  ? activeCurrency()->getData()->symbol :'' }}{{ price_format( currency($best->courses['price'], $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = false) ) }}{{ activeCurrency()->getData()->position == 'r'  ? activeCurrency()->getData()->symbol :'' }}</b></a>
                                                </li>
                                                @endif

                                                @endif
                                            </ul>
                                        </div>
                                        @else
                                        <div class="rate text-right">
                                            <ul>
                                                <li><a><b>{{ __('Free') }}</b></a></li>
                                            </ul>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>



                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $best['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($best->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',$best->courses->id)->first();
                                        $existorder = App\Order::where('user_id',Auth::User()->id)->where('course_id', $best->courses->id)->where('refunded', '0')->first();
                                        @endphp
                                        @if ($wish == NULL)
                                            @if(!isset($existorder))
                                                <li class="protip-wish-btn">
                                                    <form id="demo-form2" method="post" action="{{ url('show/wishlist', $best->courses->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                        {{ csrf_field() }}

                                                        <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                        <input type="hidden" name="course_id" value="{{$best->courses->id}}" />

                                                        <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                                    </form>
                                                </li>
                                            @endif
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $best->courses->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$best->courses->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-best{{$best->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $best->courses['title'] }}</h5>
                            <div class="main-des">
                                <p>Last Updated: {{ date('jS F Y', strtotime($best->courses->updated_at)) }}</p>
                            </div>

                            <ul class="description-list">
                                <li>
                                    <i data-feather="play-circle"></i>
                                    <div class="class-des">
                                        {{ __('Classes') }}:
                                        @php
                                        $data = App\CourseClass::where('course_id', $best->courses->id)->count();
                                        if($data > 0){

                                        echo $data;
                                        }
                                        else{

                                        echo "0";
                                        }
                                        @endphp
                                    </div>
                                </li>
                                &nbsp;
                                <li>
                                    <div>
                                        <div class="time-des">
                                            <span class="">
                                                <i data-feather="clock"></i>
                                                @php

                                                $classtwo = App\CourseClass::where('course_id',
                                                $best->courses->id)->sum("duration");

                                                @endphp
                                                {{ $classtwo }} {{ __('Minutes')}}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="lang-des">
                                        @if($best->courses['language_id'] == !NULL)
                                        @if(isset($best->courses->language))
                                        <i data-feather="globe"></i> {{ $best->courses->language['name'] }}
                                        @endif
                                        @endif
                                    </div>
                                </li>
                            </ul>

                            <div class="product-main-des">
                                <p>{{ $best->courses->short_detail }}</p>
                            </div>
                            <div>
                                @if($best->courses->whatlearns->isNotEmpty())
                                @foreach($best->courses->whatlearns as $wl)
                                @if($wl->status ==1)
                                <div class="product-learn-dtl">
                                    <ul>
                                        <li><i data-feather="check-circle"></i>{{ str_limit($wl['detail'], $limit = 120, $end = '...') }}
                                        </li>
                                    </ul>
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-8">
                                        @if($best->courses->type == 1)
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin" || $best->courses->user_id == Auth::User()->id)
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $best->courses->id, 'slug' => $best->courses->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $order = App\Order::where('user_id', Auth::User()->id)->where('course_id',
                                        $best->courses->id)->first();
                                        @endphp
                                        @if(!empty($order) && $order->status == 1)
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $best->courses->id, 'slug' => $best->courses->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $cart = App\Cart::where('user_id', Auth::User()->id)->where('course_id',
                                        $best->courses->id)->first();
                                        @endphp
                                        @if(!empty($cart))
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('remove.item.cart',$cart->id) }}">
                                                {{ csrf_field() }}

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Remove From Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <form id="demo-form2" method="post" action="{{ route('addtocart',['course_id' => $best->courses->id, 'price' => $best->courses->price, 'discount_price' => $best->courses->discount_price ]) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="category_id" value="{{$best->category['id'] ?? '-'}}" />

                                                <div class="box-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('Add To Cart') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endif
                                        @endif
                                        @endif
                                        @else
                                        @if($gsetting->guest_enable == 1)
                                        <form id="demo-form2" method="post" action="{{ route('guest.addtocart', $best->courses->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                            {{ csrf_field() }}
                                            <div class="box-footer">
                                                <button type="submit" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</button>
                                            </div>
                                        </form>
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary"><i data-feather="shopping-cart"></i>&nbsp;{{ __('Add To Cart') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        @if(Auth::check())
                                        @if(Auth::User()->role == "admin")
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $best->courses->id, 'slug' => $best->courses->slug ]) }}" class="btn btn-secondary" title="course">{{ __('Go To Course') }}</a>
                                        </div>
                                        @else
                                        @php
                                        $enroll = App\Order::where('user_id', Auth::User()->id)->where('course_id',
                                        $best->courses->id)->first();
                                        @endphp
                                        @if($enroll == NULL)
                                        <div class="protip-btn">
                                            <a href="{{url('enroll/show',$best->courses->id)}}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('course.content',['id' => $best->courses->id, 'slug' => $best->courses->slug ]) }}" class="btn btn-secondary" title="Cart">{{ __('Go To Course') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                        @else
                                        <div class="protip-btn">
                                            <a href="{{ route('login') }}" class="btn btn-primary" title="Enroll Now"><i data-feather="shopping-cart"></i>{{ __('Enroll Now') }}</a>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="img-wishlist">
                                            <div class="protip-wishlist">
                                                <ul>
                                                    @if(Auth::check())

                                                    @php
                                                    $wish = App\Wishlist::where('user_id',
                                                    Auth::User()->id)->where('course_id', $best->courses->id)->first();
                                                    @endphp
                                                    @if ($wish == NULL)
                                                        @if(!isset($existorder))
                                                            <li class="protip-wish-btn">
                                                                <form id="demo-form2" method="post" action="{{ url('show/wishlist', $best->courses->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                                    {{ csrf_field() }}

                                                                    <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                                    <input type="hidden" name="course_id" value="{{$best->courses->id}}" />

                                                                    <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    @else
                                                    <li class="protip-wish-btn-two">
                                                        <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $best->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                            {{ csrf_field() }}

                                                            <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                            <input type="hidden" name="course_id" value="{{$best->courses->id}}" />

                                                            <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                                        </form>
                                                    </li>
                                                    @endif
                                                    @else
                                                    <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach

        </div>
    </div>
</section>
@endif
<!-- Advertisement -->
@if(isset($advs))
@foreach($advs as $adv)
@if($adv->position == 'belowbundle')
<br>
<section id="student" class="student-main-block btm-40">
    <div class="container-xl">
        <a href="{{ $adv->url1 }}" title="{{ __('Click to visit') }}">
            <img class="lazy img-fluid advertisement-img-one" data-src="{{ url('images/advertisement/'.$adv->image1) }}" alt="{{ $adv->image1 }}">
        </a>
    </div>
</section>
@endif

@endforeach

@endif
<!-- Zoom start -->
@if($hsetting->livemeetings_enable == 1)
@if($gsetting->zoom_enable == '1' || $gsetting->bbl_enable == '1' || $gsetting->googlemeet_enable == '1' ||
$gsetting->jitsimeet_enable == '1')
<section id="student" class="student-main-block">
    <div class="container-xl">
        @php
        $mytime = Carbon\Carbon::now();
        $cntzoom = count($meetings) + count($bigblue) + count($allgooglemeet) + count($jitsimeeting);
        @endphp
        @if( count($meetings) > 0 || count($bigblue) > 0 || count($allgooglemeet) > 0 || count($jitsimeeting) > 0 )
        <h4 class="student-heading">{{ __('Live Meetings') }}</h4>

        <div id="zoom-view-slider" class="student-view-slider-main-block owl-carousel" data-lmc="{{ $cntzoom }}">

            @if( ! $meetings->isEmpty() )
            @foreach($meetings as $meeting)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-6{{$meeting->id}}">
                    <div class="view-block">
                        <div class="view-img">

                            @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                            <a href="{{ route('zoom.detail', $meeting->id) }}"><img data-src="{{ asset('images/zoom/'.$meeting['image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('zoom.detail', $meeting->id) }}"><img data-src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif


                        </div>
                        <div class="view-user-img">

                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif


                        </div>
                        @if(asset('images/meeting_icons/zoom.png') == !NULL)
                        <div class="meeting-icon"><img src="{{ asset('images/meeting_icons/zoom.png')}}" class="img-circle" alt=""></div>
                        @endif


                        <div class="view-dtl">
                            <div class="view-heading"><a href="#">
                                    {{ str_limit($meeting->meeting_title, $limit = 30, $end = '...') }}</a></div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$meeting->user->id) }}"> {{ optional($meeting->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-6{{$meeting->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading"><a href="{{ route('zoom.detail', $meeting->id) }}">{{ $meeting['meeting_title'] }}</a>
                            </h5>
                            <div class="protip-img">
                                <h6 class="user-name">{{ __('by') }}
                                    @if(isset($meeting->user)) {{ $meeting->user['fname'] }} @endif</h6>
                                <p class="meeting-owner btm-10"><a herf="#">Meeting Owner:
                                        {{ $meeting->owner_id }}</a></p>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">Start At: </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="des-btn-block">
                                <a href="{{ $meeting->zoom_url }}" class="iframe btn btn-light">{{ __('Join Meeting') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

            @if( ! $bigblue->isEmpty() )
            @foreach($bigblue as $bbl)


            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-7{{$bbl->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            <a href="{{ route('bbl.detail', $bbl->id) }}"><img data-src="{{ Avatar::create($bbl['meetingname'])->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                        </div>
                        <div class="view-user-img">

                            @if(optional($bbl->user)['user_img'] !== NULL && optional($bbl->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$bbl->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$bbl->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$bbl->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif


                        </div>
                        @if(asset('images/meeting_icons/bigblue.png') == !NULL)
                        <div class="meeting-icon"><img src="{{ asset('images/meeting_icons/bigblue.png')}}" class="img-circle" alt=""></div>
                        @endif

                        <div class="view-dtl">
                            <div class="view-heading"><a href="{{ route('bbl.detail', $bbl->id) }}">{{ str_limit($bbl['meetingname'], $limit = 30, $end = '...') }}</a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$bbl->user->id) }}"> {{ optional($bbl->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($bbl['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($bbl['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div id="prime-next-item-description-block-7{{$bbl->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $bbl['meetingname'] }}</h5>
                            <div class="protip-img">
                                <a href="{{ route('bbl.detail', $bbl->id) }}"><img src="{{ Avatar::create($bbl['meetingname'])->toBase64() }}" alt="course" class="img-fluid"></a>
                            </div>

                            <div class="main-des">
                                <p>{!! $bbl['detail'] !!}</p>
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
            @endif

            @if( isset($allgooglemeet) )
            @foreach($allgooglemeet as $meeting)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-6{{ $meeting['meeting_id'] }}">
                    <div class="view-block">
                        <div class="view-img">

                            @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                            <a href="{{ route('googlemeetdetailpage.detail', $meeting['id']) }}"><img data-src="{{ asset('images/googlemeet/profile_image/'.$meeting['image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('googlemeetdetailpage.detail', $meeting['id']) }}"><img data-src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif


                        </div>
                        <div class="view-user-img">

                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif


                        </div>
                        @if(asset('images/meeting_icons/google.png') == !NULL)
                        <div class="meeting-icon"><img src="{{ asset('images/meeting_icons/google.png')}}" class="img-circle" alt=""></div>
                        @endif

                        <div class="view-dtl">
                            <div class="view-heading"><a href="#">
                                    {{ str_limit($meeting->meeting_title, $limit = 30, $end = '...') }}</a></div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$meeting->user->id) }}"> {{ optional($meeting->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-6{{$meeting['meeting_id']}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading"><a href="{{ route('zoom.detail', $meeting->id) }}">{{ $meeting['meeting_title'] }}</a>
                            </h5>
                            <div class="protip-img">
                                <h6 class="user-name">{{ __('by') }}
                                    @if(isset($meeting->user)) {{ $meeting->user['fname'] }} @endif</h6>
                                <p class="meeting-owner btm-10"><a herf="#">{{ __('Meeting Owner:') }}
                                        {{ $meeting->owner_id }}</a></p>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">{{ __('Start At:') }} </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">{{ __('End At: ') }}</div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['end_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['end_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="des-btn-block">
                                <a href="{{ $meeting->meet_url }}" target="_blank" class="btn btn-light">Join
                                    {{ __('Meeting') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif

            @if( ! $jitsimeeting->isEmpty() )
            @foreach($jitsimeeting as $meeting)
            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-6{{ $meeting['meeting_id'] }}">
                    <div class="view-block">
                        <div class="view-img">

                            @if($meeting['image'] !== NULL && $meeting['image'] !== '')
                            <a href="{{ route('jitsipage.detail', $meeting['id']) }}"><img data-src="{{ asset('images/jitsimeet/'.$meeting['image']) }}" alt="course" class="img-fluid owl-lazy"></a>
                            @else
                            <a href="{{ route('jitsipage.detail', $meeting['id']) }}"><img data-src="{{ Avatar::create($meeting['meeting_title'])->toBase64() }}" alt="course" class="img-fluid owl-lazy"></a>
                            @endif


                        </div>
                        <div class="view-user-img">

                            @if(optional($meeting->user)['user_img'] !== NULL && optional($meeting->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$meeting->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$meeting->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif


                        </div>
                        @if(asset('images/meeting_icons/jitsi.png') == !NULL)
                        <div class="meeting-icon"><img src="{{ asset('images/meeting_icons/jitsi.png')}}" class="img-circle" alt=""></div>
                        @endif

                        <div class="view-dtl">
                            <div class="view-heading"><a href="#">
                                    {{ str_limit($meeting->meeting_title, $limit = 30, $end = '...') }}</a></div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$meeting->user->id) }}"> {{ optional($meeting->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="img-wishlist">
                                <div class="protip-wishlist">
                                    <ul>

                                        <li class="protip-wish-btn"><a href="https://calendar.google.com/calendar/r/eventedit?text={{ $discount['title'] }}" target="__blank" title="reminder"><i data-feather="bell"></i></a></li>

                                        @if(Auth::check())

                                        <li class="protip-wish-btn"><a class="compare" data-id="{{filter_var($discount->id)}}" title="compare"><i data-feather="bar-chart"></i></a></li>

                                        @php
                                        $wish = App\Wishlist::where('user_id', Auth::User()->id)->where('course_id',
                                        $discount->id)->first();
                                        @endphp
                                        @if ($wish == NULL)
                                        <li class="protip-wish-btn">
                                            <form id="demo-form2" method="post" action="{{ url('show/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn" title="Add to wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @else
                                        <li class="protip-wish-btn-two">
                                            <form id="demo-form2" method="post" action="{{ url('remove/wishlist', $discount->id) }}" data-parsley-validate class="form-horizontal form-label-left">
                                                {{ csrf_field() }}

                                                <input type="hidden" name="user_id" value="{{Auth::User()->id}}" />
                                                <input type="hidden" name="course_id" value="{{$discount->id}}" />

                                                <button class="wishlisht-btn heart-fill" title="Remove from Wishlist" type="submit"><i data-feather="heart"></i></button>
                                            </form>
                                        </li>
                                        @endif
                                        @else
                                        <li class="protip-wish-btn"><a href="{{ route('login') }}" title="heart"><i data-feather="heart"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-6{{$meeting['meeting_id']}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading"><a href="{{ route('zoom.detail', $meeting->id) }}">{{ $meeting['meeting_title'] }}</a>
                            </h5>
                            <div class="protip-img">
                                <h6 class="user-name">{{ __('by') }}
                                    @if(isset($meeting->user)) {{ $meeting->user['fname'] }} @endif</h6>
                                <p class="meeting-owner btm-10"><a herf="#">{{ __('Meeting Owner')}}:
                                        {{ $meeting->owner_id }}</a></p>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">Start At: </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['start_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-des meeting-main-des">
                                <div class="main-des-head">{{ __('End At')}}: </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($meeting['end_time'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($meeting['end_time'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="des-btn-block">
                                <a href="{{url('meetup-conferencing/'.$meeting->meeting_id) }}" target="_blank" class="btn btn-light">{{ __('Join Meeting')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif


        </div>

        @endif

    </div>
</section>
@endif
@endif
<!-- Zoom end -->

<!-- google class room start -->
@if(Schema::hasTable('googleclassrooms') && Module::has('Googleclassroom') &&
Module::find('Googleclassroom')->isEnabled())
@include('googleclassroom::frontend.home')
@endif

<!-- google class room end -->
{{-- @if($hsetting->batch_enable == 1 && ! $instruct->isEmpty() )
<section id="instructor-home-two" class="instructor-home-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-7">
                <h4 class="student-heading">{{ __('Featured Instructor') }}</h4>
</div>

</div>

<div id="instructor-home-slider-two" class="instructor-home-main-slider owl-carousel" data-fein="{{ count($instruct) }}">
    @foreach($instruct as $inst)
    <div class="item">
        <div class="instructor-home-block text-center">
            <div class="instructor-home-block-one">
                @if($inst->user->user_img !== NULL && $inst->user->user_img !== '')
                <a href="#" title=""><img src="{{ url('/images/user_img/'.$inst->user->user_img) }}" class="img-fluid" /></a>
                @else
                <a href="#" title=""><img src="{{ Avatar::create($inst->user->fname)->toBase64() }}" alt="course" class="img-fluid"></a>
                @endif
                <div class="instructor-home-hover-icon">
                    <ul>
                        <li>
                            <div class="tooltip">
                                <div class="tooltip-icon">
                                    <i data-feather="share-2"></i>
                                </div>
                                <span class="tooltiptext">
                                    <div class="instructor-home-social-icon">
                                        <ul>
                                            <li><a href="{{ $inst->fb_url }}"><i data-feather="facebook"></i></a></li>
                                            <li><a href="{{ $inst->twitter_url }}"><i data-feather="twitter"></i></a></li>
                                            <li><a href="{{ $inst->youtube_url }}"><i data-feather="youtube"></i></a></li>
                                            <li><a href="{{ $inst->linkedin_url }}"><i data-feather="linkedin"></i></a></li>
                                        </ul>
                                    </div>
                                </span>
                            </div>
                        </li>
                        <li>
                            <div class="instructor-home-btn">
                                <a href="{{ route('allinstructor/profile',$inst->id) }}" class="btn btn-primary" title="View Profile"><i data-feather="eye"></i></a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="instructor-home-dtl">
                    <h4 class="instructor-home-heading"><a href="#" title="">{{ $inst->fname }} {{ $inst->lname }}</a></h4>
                    <p>{{ $inst->role }}</p>

                    @php

                    $followers = App\Followers::where('user_id', '!=', $inst->user_id)->where('follower_id', $inst->user_id)->count();

                    $followings = App\Followers::where('user_id', $inst->user_id)->where('follower_id','!=', $inst->user_id)->count();
                    $course = App\Course::where('user_id', $inst->user_id)->count();

                    @endphp
                    <div class="instructor-home-info">
                        <ul>
                            <li>{{ $course }} {{ __('Courses') }}</li>
                            <li>{{ $followers }} {{ __('Follower') }}</li>
                            <li>{{ $followings }} {{ __('Following') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>
</div>
</section>
@endif --}}
<!-- Blogs start -->
@if($hsetting->blog_enable == 1 && ! $blogs->isEmpty() )
<section id="student" class="student-main-block">
    <div class="container-xl">

        <h4 class="student-heading">{{ __('Recent Blogs') }}</h4>
        <div id="blog-post-slider" class="student-view-slider-main-block owl-carousel" data-rbs="{{ count($blogs) }}">
            @foreach($blogs as $blog)


            <div class="item student-view-block student-view-block-1">
                <div class="genre-slide-image @if($gsetting['course_hover'] == 1) protip @endif" data-pt-placement="outside" data-pt-interactive="false" data-pt-title="#prime-next-item-description-block-8{{$blog->id}}">
                    <div class="view-block">
                        <div class="view-img">
                            @if($blog['image'] !== NULL && $blog['image'] !== '')
                            @if($blog->slug != NULL)
                            <a href="{{ route('blog.detail', ['id' => $blog->id, 'slug' => $blog->slug ]) }}">
                                @else
                                <a href="{{ route('blog.detail', ['id' => $blog->id, 'slug' => str_slug(str_replace('-','&',$blog->heading)) ]) }}">
                                    @endif

                                    <img data-src="{{ asset('images/blog/'.$blog['image']) }}" alt="course" class="img-fluid owl-lazy">
                                </a>
                                @else
                                @if($blog->slug != NULL)
                                <a href="{{ route('blog.detail', ['id' => $blog->id, 'slug' => $blog->slug ]) }}">
                                    @else
                                    <a href="{{ route('blog.detail', ['id' => $blog->id, 'slug' => str_slug(str_replace('-','&',$blog->heading)) ]) }}">
                                        @endif
                                        <img data-src="{{ Avatar::create($blog->heading)->toBase64() }}" alt="course" class="img-fluid owl-lazy">
                                    </a>
                                    @endif
                        </div>
                        <div class="view-user-img">

                            @if(optional($blog->user)['user_img'] !== NULL && optional($blog->user)['user_img'] !== '')
                            <a href="{{ route('all/profile',$blog->user->id) }}" title=""><img src="{{ asset('images/user_img/'.$blog->user['user_img']) }}" class="img-fluid user-img-one" alt=""></a>
                            @else
                            <a href="{{ route('all/profile',$blog->user->id) }}" title=""><img src="{{ asset('images/default/user.png') }}" class="img-fluid user-img-one" alt=""></a>
                            @endif


                        </div>
                        <div class="tooltip">
                            <div class="tooltip-icon">
                                <i data-feather="share-2"></i>
                            </div>
                            <span class="tooltiptext">
                                <div class="instructor-home-social-icon">
                                    <ul>
                                        <li><a href="{{ $blog->user->fb_url }}"><i data-feather="facebook"></i></a></li>
                                        <li><a href="{{ $blog->user->twitter_url }}"><i data-feather="twitter"></i></a></li>
                                        <li><a href="{{ $blog->user->youtube_url }}"><i data-feather="youtube"></i></a></li>
                                        <li><a href="{{ $blog->user->linkedin_url }}"><i data-feather="linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </span>
                        </div>
                        <div class="view-dtl">
                            <div class="view-heading">
                                @if($blog->slug != NULL)
                                <a href="{{ route('blog.detail', ['id' => $blog->id, 'slug' => $blog->slug ]) }}">
                                    {{ str_limit($blog['heading'], $limit = 25, $end = '...') }}
                                    @else
                                    <a href="{{ route('blog.detail', ['id' => $blog->id, 'slug' => str_slug(str_replace('-','&',$blog->heading)) ]) }}">

                                        {{ str_limit($blog['heading'], $limit = 25, $end = '...') }}
                                        @endif
                                    </a>
                            </div>
                            <div class="user-name">
                                <h6>By <span><a href="{{ route('all/profile',$blog->user->id) }}"> {{ optional($blog->user)['fname'] }}</a></span></h6>
                            </div>
                            <div class="view-footer">

                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-date">
                                            <a href="#"><i data-feather="calendar"></i>
                                                {{ date('d-m-Y',strtotime($blog['created_at'])) }}</a>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="view-time">
                                            <a href="#"><i data-feather="clock"></i>
                                                {{ date('h:i:s A',strtotime($blog['created_at'])) }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="prime-next-item-description-block-8{{$blog->id}}" class="prime-description-block">
                    <div class="prime-description-under-block">
                        <div class="prime-description-under-block">
                            <h5 class="description-heading">{{ $blog['heading'] }}</h5>
                            <div class="row btm-20">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="view-date">
                                        <a href="#"><i data-feather="calendar"></i> {{ date('d-m-Y',strtotime($blog['created_at'])) }}</a>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                    <div class="view-time">
                                        <a href="#"><i data-feather="clock"></i> {{ date('h:i:s A',strtotime($blog['created_at'])) }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="main-des">
                                <p>{{substr(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($blog->detail))), 0, 400)}}
                                </p>
                            </div>
                            <div class="des-btn-block">
                                <div class="row">
                                    <div class="col-lg-12">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </div>

    </div>
</section>
@endif
<!-- Blogs end -->
<!-- recommendations start -->
@if($hsetting->became_enable == 1)
<section id="border-recommendation" class="border-recommendation">
    @php
    $gets = App\JoinInstructor::first();
    @endphp
    @if(isset($gets))
    <!-- <div class="top-border"></div> -->
    <div class="recommendation-main-block  text-center">
        <div class="container-fluid p-0">
            <div class="row no-gutters">
                <div class="col-lg-4 col-sm-5">
                    <div class="recommendations-block">
                        <h4 class="recommendations-heading"> {{ $gets->text }}</h4>
                        <p>{{ $gets->detail }}</p>
                        <div class="recommendation-btn">
                            <a href="" data-toggle="modal" data-target="#myModalinstructor" class="btn btn-primary" title="Become an Instructor">{{__('Become an Instructor')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-sm-7">
                    <div id="recommendations-slider" class="recommendations-main-slider owl-carousel">
                        <div class="item">
                            <div class="recommendations-img">
                                @if($gets['img'] !== NULL && $gets['img'] !== '')
                                <img src="{{ url('/images/joininstructor/'.$gets->img) }}" height="100px;" width="100px;" />
                                @else
                                <img src="{{ Avatar::create($gets->text)->toBase64() }}" alt="course" class="img-fluid">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>
@endif
<!-- recommendations end -->
<!-- categories start -->
@if($hsetting->featuredcategories_enable == 1 && count($category->where('featured', '1')) > 0)
<section id="categories" class="categories-main-block">
    <div class="categories-bg-image"></div>
    <div class="container-xl">
        @if( count($category->where('featured', '1')) > 0)

        <h3 class="categories-heading">{{ __('Featured Categories') }}</h3>
        <div class="row">
            @foreach($category as $t)
            @if($t->status == 1 && $t->featured == 1)

            <div class="col-lg-2 col-md-4 col-sm-4 col-6">

                <div class="cat-container btm-20 text-center">
                    <a href="{{ route('category.page',['id' => $t->id, 'category' => str_slug(str_replace('-','&',$t->slug))]) }}">
                        <div class="cat-img">
                            @if($t['cat_image'] == !NULL)
                            <img src="{{ asset('images/category/'.$t['cat_image']) }}">
                            @else
                            <img src="{{ Avatar::create($t->title)->toBase64() }}">
                            @endif
                        </div>
                        <div class="cat-dtl">
                            <div>
                                <span>
                                    <h5 class="cat-name"><i class="fa {{ $t['icon'] }} mr-2"></i>{{ $t['title'] }}</h5>
                                    <div class="cat-img-count">{{ $t->courses->count() }} {{ __('Courses')}}</div>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- <a href="{{ route('category.page',['id' => $t->id, 'category' => str_slug(str_replace('-','&',$t->slug))]) }}">
                        <div class="image-overlay">
                            <span><i class="fa {{ $t['icon'] }}"></i>{{ $t['title'] }}
                                <div class="categories-img-count">{{ $t->courses->count() }} {{ __('Courses')}}</div>
                            </span>
                         </div>
                        @if($t['cat_image'] == !NULL)
                        <img src="{{ asset('images/category/'.$t['cat_image']) }}">
                        @else
                        <img src="{{ Avatar::create($t->title)->toBase64() }}">
                        @endif
                    </a> -->
                <!-- </div> -->

            </div>

            @endif
            @endforeach
        </div>

        @endif
    </div>
</section>
@endif
<!-- categories end -->
<!-- testimonial start -->
@if($hsetting->testimonial_enable == 1 && ! $testi->isEmpty() )
<section id="testimonial" class="testimonial-main-block">
    <div class="container-xl">
        <h4>{{ __('Home Testimonial') }}</h4>
        <div id="testimonial-slider" class="testimonial-slider-main-block owl-carousel">
            @foreach($testi as $tes)
            <div class="item testimonial-block text-center">
                <div class="testimonial-block-one">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="testimonial-img">
                                <img data-src="{{ asset('images/testimonial/'.$tes['image']) }}" alt="blog" class="img-fluid owl-lazy">
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="testimonial-name">
                                <h5 class="testimonial-heading">{{ $tes['client_name'] }}</h5>
                                <p class="testimonial-para">{{ $tes['designation'] }}</p>
                            </div>
                            <div class="testimonial-rating">
                                @for($i = 1; $i <= 5; $i++) @if($i<=$tes->rating)
                                    <i class='fa fa-star' style='color:orange'></i>
                                    @else
                                    <i class='fa fa-star' style='color:#ccc'></i>
                                    @endif
                                    @endfor
                            </div>
                        </div>
                    </div>
                    <p>{{ str_limit(preg_replace("/\r\n|\r|\n/",'',strip_tags(html_entity_decode($tes->details))) , $limit = 300, $end = '...') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- testimonial end -->

<!-- Advertisement start belowtestimonial -->
@if(isset($advs))
@foreach($advs as $adv)
@if($adv->position == 'belowtestimonial')
<br>
<section id="student" class="student-main-block btm-40">
    <div class="container-xl">
        <a href="{{ $adv->url1 }}" title="{{ __('Click to visit') }}">
            <img class="lazy img-fluid advertisement-img-one" data-src="{{ url('images/advertisement/'.$adv->image1) }}" alt="{{ $adv->image1 }}">
        </a>
    </div>
</section>
@endif
@endforeach
@endif
<!-- Advertisement end belowtestimonial -->
<!-- video start -->
@if($hsetting->video_enable == 1 && isset($videosetting) )
<section id="video" class="video-main-block pt-5">
    <div class="container-fluid">
        <div class="video-block">
            <div class="img-btn" data-id="{{$videosetting->url}}">
                @if($videosetting['image'] !== NULL && $videosetting['image'] !== '')
                <img src="{{ url('/images/videosetting/'.$videosetting->image) }}" class="img-fluid" />
                @else
                <img src="{{ Avatar::create($videosetting->tittle)->toBase64() }}" alt="course" class="img-fluid">
                @endif
                <div class="overlay-bg"></div>
                <div class="img-btn2">

                </div>
            </div>
        </div>
        <!-- <div class="video-play-btn">
            <a class="play-btn" href="#video_modal" data-toggle="modal"></a>
            <div id="video_modal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe id="elearningVideo" class="embed-responsive-item" width="560" height="315" src="{{$videosetting->url}}" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="video-dtl text-center">
            <h3 class="video-heading text-white">{{ $videosetting->tittle }}</h3>
            <p class="text-white">{{ $videosetting->description }}</p>
        </div>
    </div>
</section>
@endif
<!-- video end -->

<!-- instructor start -->
@if( $hsetting->instructor_enable == 1 && count($instructors) > 0)
<section id="instructor-home" class="instructor-home-main-block pt-5">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-7">
                <h4 class="student-heading">{{ __('Instructor') }}</h4>
            </div>
            @if(count($instructors) > 4)
            <div class="col-lg-6 col-md-6 col-5">
                <div class="instructor-button txt-rgt">
                    <a href="{{ route('allinstructor/view') }}" class="btn btn-secondary" title="All Instructor">{{ __('All Instructor') }} <i data-feather="chevron-right"></i>
                    </a>
                </div>
            </div>
            @endif
        </div>

        <div id="instructor-home-slider" class="instructor-home-main-slider owl-carousel" data-ali="{{ count($instructors) }}">
            @foreach($instructors as $inst)
            <div class="item">
                <div class="instructor-home-block text-center">
                    <div class="instructor-home-block-one">
                        @if($inst['user_img'] !== NULL && $inst['user_img'] !== '')
                        <a href="{{ route('allinstructor/profile',$inst->id) }}" title=""><img src="{{ url('/images/user_img/'.$inst->user_img) }}" class="img-fluid" /></a>
                        @else
                        <a href="{{ route('allinstructor/profile',$inst->id) }}" title=""><img src="{{ Avatar::create($inst->fname)->toBase64() }}" alt="course" class="img-fluid"></a>
                        @endif

                        <div class="instructor-home-dtl">

                            <ul>
                                <li>
                                    <div class="tooltip">
                                        <div class="tooltip-icon">
                                            <i data-feather="share-2"></i>
                                        </div>
                                        <span class="tooltiptext">
                                            <div class="instructor-home-social-icon">
                                                <ul>
                                                    <li><a href="{{ $inst->fb_url }}"><i data-feather="facebook"></i></a></li>
                                                    <li><a href="{{ $inst->twitter_url }}"><i data-feather="twitter"></i></a></li>
                                                    <li><a href="{{ $inst->youtube_url }}"><i data-feather="youtube"></i></a></li>
                                                    <li><a href="{{ $inst->linkedin_url }}"><i data-feather="linkedin"></i></a></li>
                                                </ul>
                                            </div>
                                        </span>
                                    </div>
                                </li>
                            </ul>

                            <h4 class="instructor-home-heading"><a href="#" title="">{{ $inst->fname }} {{ $inst->lname }}</a></h4>
                            <p>{{ $inst->role }}</p>

                            @php

                            $followers = App\Followers::where('user_id', '!=', $inst->id)->where('follower_id', $inst->id)->count();

                            $followings = App\Followers::where('user_id', $inst->id)->where('follower_id','!=', $inst->id)->count();
                            $course = App\Course::where('user_id', $inst->id)->count();

                            @endphp
                            <div class="instructor-home-info">
                                <ul>
                                    <li>{{ $course }} {{ __('Courses') }}</li>
                                    <li>{{ $followers }} {{ __('Follower') }}</li>
                                    <li>{{ $followings }} {{ __('Following') }}</li>
                                </ul>
                            </div>
                            <hr>
                            <div class="instructor-home-btn">
                                <a href="{{ route('allinstructor/profile',$inst->id) }}" class="btn btn-primary" title="View Profile"><i data-feather="eye"></i><span style="color:red;">VIEW PROFILE</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
@endif
@if($hsetting->get_enable == 1 && !empty($get_enable))
<section id="get-started" class="get-started-main-block">
    <div class="container-fluid p-0">
        <div class="get-started-block">
            <div class="get-started-bg-image">
                @if($get_enable['image'] !== NULL && $get_enable['image'] !== '')
                <img src="{{ url('/images/getstarted/'.$get_enable->image) }}" class="img-fluid" />
                @else
                <img src="{{ Avatar::create($get_enable->heading)->toBase64() }}" alt="course" class="img-fluid">
                @endif
                <div class="overlay-bg"></div>
            </div>
            <div class="get-started-dtl text-center">
                <h1 class="get-started-title text-white mb-2">{{ $get_enable->heading }}</h1>
                <h4 class="get-started-sub-title text-white">{{ $get_enable->sub_heading }}</h4>
                <a href="{{ $get_enable->link }}" type="button" class="btn btn-primary">{{ $get_enable->button_txt }}</a>
            </div>
        </div>
    </div>
</section>
@endif
@if( $hsetting->institute_enable == 1 && !$institute->isEmpty())
<section id="instructor-home" class="instructor-home-main-block">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-7">
                <h4 class="student-heading">{{ __('Institute') }}</h4>
            </div>
            {{-- @if(count($institute) > 4)
            <div class="col-lg-6 col-md-6 col-5">
                <div class="instructor-button txt-rgt">
                    <a href="{{ route('allinstructor/view') }}" class="btn btn-secondary" title="All Instructor">All Institute<i data-feather="chevron-right"></i>
            </a>
        </div>
    </div>
    @endif --}}
    </div>

    <div id="institute-home-slider" class="instructor-home-main-slider owl-carousel" data-ins="{{ count($institute) }}">
        @foreach($institute as $inst)
        @if(isset($inst->slug))
        <div class="item">
            <div class="instructor-home-block text-center">
                <div class="instructor-home-block-one">
                    @if($inst['image'] !== NULL && $inst['image'] !== '')
                    <a href="{{ route('ins.sluging',['id' => $inst->id, 'slug' => $inst->slug ]) }}" title=""><img src="{{ url('/files/institute/'.$inst->image) }}" class="img-fluid" /></a>
                    @else
                    <a href="{{ route('ins.sluging',['id' => $inst->id, 'slug' => $inst->slug ]) }}" title=""><img src="{{ Avatar::create($inst->fname)->toBase64() }}" alt="course" class="img-fluid"></a>
                    @endif
                    <div class="instructor-home-hover-icon">
                        <ul>
                            <li>
                                <div class="instructor-home-btn">
                                    <a href="{{ route('ins.sluging',['id' => $inst->id, 'slug' => $inst->slug ]) }}" class="btn btn-primary" title="View Page"><i data-feather="eye"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="instructor-home-dtl">
                        <h4 class="instructor-home-heading"><a href="{{ route('ins.sluging',['id' => $inst->id, 'slug' => $inst->slug ]) }}" title="">{{ $inst->title }} </a></h4>
                        <p>{{ $inst->email }}</p>
                        <p>{{ $inst->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach

    </div>
    </div>
</section>
@endif
<!-- instructor end -->

@php
$ad = App\Adsense::first();
@endphp
@if(!empty($ad))
<section id="trusted" class="trusted-main-block">
    <!-- google adsense code -->
    <div class="container-fluid" id="adsense">
        <?php
        if (isset($ad)) {
            if ($ad->ishome == 1 && $ad->status == 1) {
                $code = $ad->code;
                echo html_entity_decode($code);
            }
        }
        ?>
    </div>
</section>
@endif


@endsection

@section('custom-script')



<script>
    (function($) {
        "use strict";
        // $(window).scroll(function() {
        // console.log("Facts height is ", $("#facts").height());
        // console.log("Window scroll height is  ", $(window).scrollTop());
        // console.log("Document scroll height is  ", $(document).height() );
        // if($(window).scrollTop() >=  $("#facts").height()) {
        //     $("#facts").fadeIn(1500);
        // }
        // if($(window).scrollTop() >=  $("#student").height()){
        //     $("#student").fadeIn(1500);
        // }
        // if($(window).scrollTop() >=  $("#learning-courses").height()){
        //     $("#learning-courses").fadeIn(1500);
        // }
        // if($(window).scrollTop() >=  $("#subscription").height()){
        //     $("#subscription").fadeIn(1500);
        // }else{
        //     $("#facts").hide();
        //     $("#student").hide();
        //     $("#learning-courses").hide();
        //     $("#subscription").hide();
        // }
        // });
        $(function() {
            $("#home-tab").trigger("click");
        });
    })(jQuery);

    function showtab(id) {
        $.ajax({
            type: 'GET',
            url: '{{ url(' / tabcontent ') }}/' + id,
            dataType: 'json',
            success: function(data) {

                $('.btn_more').html(data.btn_view);
                $('#tabShow').html(data.tabview);

            }
        });
    }
</script>

{{-- <script src="{{ url('js/colorbox-script.js')}}"></script> --}}


<script>
    "use Strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(function() {
        $('.compare').on('click', function(e) {
            var id = $(this).data('id');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: 'compare/dataput',
                data: {
                    id: id
                },
                success: function(data) {}
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        /* Get iframe src attribute value i.e. YouTube video url
        and store it in a variable */
        var url = $("#elearningVideo").attr('src');

        /* Assign empty url value to the iframe src attribute when
        modal hide, which stop the video playing */
        $("#video_modal").on('hide.bs.modal', function() {
            $("#elearningVideo").attr('src', '');
        });

        /* Assign the initially stored url back to the iframe src
        attribute when modal is displayed again */
        $("#video_modal").on('show.bs.modal', function() {
            $("#elearningVideo").attr('src', url);
        });
        (function() {
            var v = document.getElementsByClassName("img-btn");
            for (var n = 0; n < v.length; n++) {
                v[n].onclick = function() {

                    var iframe = document.createElement("iframe");
                    iframe.setAttribute("src", this.dataset.id);
                    iframe.setAttribute("frameborder", "0");
                    iframe.setAttribute("id", "youtube-iframe");
                    iframe.setAttribute("style", "width: 100%; height: 100%; position: absolute; top: 0; left: 0;");
                    // if (this.dataset.fullscreen == 1){ iframe.setAttribute("allowfullscreen", ""); 
                    // } 
                    while (this.firstChild) {
                        this.removeChild(this.firstChild);
                    }
                    this.appendChild(iframe);
                };
            }
        })
        ();
    });
</script>

<script>
    $(document).ready(function() {
        $(".protip-container").mouseenter(function() {
            $(this).addClass("protip-show");
        }).mouseleave(function() {
            $(this).removeClass("protip-show");
        });
    });
</script>

<script>
    $(document).ready(function() {
        var owl = $("#home-background-slider");
        owl.owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 1000,
        });
        var searchInput = $(".searchTerm");
        searchInput.on("input", function() {
            if ($(this).val().trim() === "") {
                owl.trigger("play.owl.autoplay");
            } else {
                owl.trigger("stop.owl.autoplay");
            }
        });
    });
</script>

@endsection