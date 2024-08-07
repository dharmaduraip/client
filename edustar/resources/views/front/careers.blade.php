@extends('theme.master')
@section('title', 'Careers')
@section('content')

@include('admin.message')

@if($data['one_enable'] == 1)
<div class="careers-section">
    <img src="{{ asset('images/careers/'.$data->one_video) }}" class="img-fluid" alt="about-img">
    <div class="inner-section">
        <div class="content">
            <h1 class="careers-heading text-center text-white">{{ $data->one_heading }}</h1>
            <p class="text-center text-white mb-4">{{ $data->one_text }}</p>
            <div class="careers-btn btm-40 text-center">
                <a href="{{ $data->three_btntxt }}" class="btn btn-primary" title="careers">{{ $data->one_btntxt }}</a>
            </div>
        </div>
    </div>
</div>
<!-- about-home start -->
<!-- <section id="careers" class="about-home-one-main-block careers-main-block">
    <div class="container-xl">
        <div class="careers-block">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="careers-heading text-center text-white">{{ $data->one_heading }}</h1>
                    <p class="text-center text-white btm-40">{{ $data->one_text }}</p>
                    <div class="careers-btn btm-40 text-center">
                        <a href="{{ $data->three_btntxt }}" class="btn btn-primary" title="careers">{{ $data->one_btntxt }}</a>
                    </div>
                    <div class="">
                        <img src="{{ asset('images/careers/'.$data->one_video) }}" class="img-fluid" alt="about-img">
                    </div>
                </div>
            </div>
        </div>
</section> -->
<!-- about-home end -->
<!-- careers-video start -->
<!-- <section id="careers-video" class="careers-video-main-block">
    <div class="container-xl">
        <div class="careers-video">
            <a href="#" title="about">
                <img src="{{ asset('images/careers/'.$data->one_video) }}" class="img-fluid" alt="about-img">
            </a>
        </div>
    </div>
</section> -->
@endif
<!-- careers-video end -->
<!-- careers-info start -->
@if($data['two_enable'] == 1)
<!-- <section id="careers-info" class="careers-info-main-block">
    <div class="container-xl">
        <div class="careers-block-one">
            <div class="row">
                @php
                $items = App\Testimonial::limit(4)->get();
                @endphp
                @foreach($items as $item)
                <div class="col-lg-4">
                    <div class="careers-info-block bdr-right">
                        <div class="careers-info-img btm-20"><img src="{{ asset('images/testimonial/'. $item->image) }}" class="img-fluid"></div>
                        <h3 class="careers-info-heding btm-30">{{ $item->client_name }}</h3>
                        <p>{{ strip_tags(str_limit($item->details, $limit = 200, $end = '...')) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section> -->
<section id="testimonial" class="testimonial-main-block">
    <div class="container-xl">
        <h4>Testimonial</h4>
        <div id="testimonial-slider" class="testimonial-slider-main-block owl-carousel">
            @php
            $items = App\Testimonial::limit(4)->get();
            @endphp
            @foreach($items as $item)
            <div class="item testimonial-block text-center">
                <div class="testimonial-block-one">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="testimonial-img">
                                <img data-src="{{ asset('images/testimonial/'. $item->image) }}" alt="blog" class="img-fluid owl-lazy">
                            </div>
                            <div class="testimonial-rating"></div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-12">
                            <div class="testimonial-name">
                                <h5 class="testimonial-heading" style="border-right:none!important">{{ $item->client_name }}</h5>
                                <p class="testimonial-para">{{ $item['designation'] }}</p>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4">{{ strip_tags(str_limit($item->details, $limit = 500, $end = '...')) }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- careers-info end -->
<!-- careers-learn start -->
@if($data['three_enable'] == 1)
<section id="careers-learn" class="careers-learn-main-block" style="background-image: url('{{ asset('images/careers/'.$data->three_bg_image) }}')">
    <div class="container-xl">
        <div class="careers-learn-block">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="careers-learn-video bdr-right">
                        <a href="#" title="about">
                            <img src="{{ asset('images/careers/'.$data->three_video) }}" class="img-fluid" alt="careers">
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="careers-learn-video-one">
                        <div class="careers-learn-heading btm-10">{{ $data->three_heading }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- careers-learn end -->
<!-- learning-learn-img start-->
@if($data['four_enable'] == 1)
<section id="learning-learn-img-main-block" class="my-lg-4 my-3">
    <div class="Gallery">
        <h3 class="text-center">Our Gallery</h3>
    </div>
    <div class="d-flex flex-wrap justify-content-center align-items-center learning-learn-img">
        <div class="col-sm-3 col-12 d-flex justify-content-center">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_one) }}">
            </div>
        </div>
        <div class="col-sm-3 col-12 d-flex justify-content-center ">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_two) }}">
            </div>
        </div>
        <div class="col-sm-3 col-12 d-flex justify-content-center">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_three) }}">
            </div>
        </div>
        <div class="col-sm-3 col-12 d-flex justify-content-center">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_four) }}">
            </div>
        </div>
        <div class="col-sm-4 col-12 d-flex justify-content-center">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_five) }}">
            </div>
        </div>
        <div class="col-sm-4 col-12 px-0">
            <div class="image-sec bg-image">
                <h1 class="text-center">Our Gallery</h1>
            </div>
        </div>
        <div class="col-sm-4 col-12 d-flex justify-content-center">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_six) }}">
            </div>
        </div>
        <div class="col-sm-3 col-12 d-flex justify-content-center">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_seven) }}">
            </div>
        </div>
        <div class="col-sm-3 col-12 d-flex justify-content-center ">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_eight) }}">
            </div>
        </div>
        <div class="col-sm-3 col-12 d-flex justify-content-center ">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_nine) }}">
            </div>
        </div>
        <div class="col-sm-3 col-12 d-flex justify-content-center">
            <div class="image-sec">
                <img src="{{ asset('images/careers/'.$data->four_img_ten) }}">
            </div>
        </div>
    </div>
</section>

<!-- <section id="learning-learn-img" class="learning-learn-img-main-block">
    <div class="container-xl-fluid">
        <div class="learning-learn-img-block">
            <div class="row no-gutters">
                <div class="col-lg-2">
                    <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_one) }}" title="img" class="img-fluid"></a>
                    <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_two) }}" title="img" class="img-fluid"></a>
                </div>
                <div class="col-lg-3">
                    <div class="height">
                        <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_three) }}" title="img" class="img-fluid"></a>
                    </div>
                    <div class="height-one">
                        <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_four) }}" title="img" class="img-fluid"></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_five) }}" title="img" class="img-fluid"></a>
                    <div class="row no-gutters">
                        <div class="col-lg-6">
                            <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_six) }}" title="img" class="img-fluid"></a>
                        </div>
                        <div class="col-lg-6">
                            <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_seven) }}" title="img" class="img-fluid"></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="height-one">
                        <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_eight) }}" title="img" class="img-fluid"></a>
                    </div>
                    <div class="height">
                        <a href="#" title="NextClass-learn"><img src="{{ asset('images/careers/'.$data->four_img_nine) }}" title="img" class="img-fluid"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> -->
@endif
<!-- learning-learn-img end -->
<!-- careers-benefits start -->
@if($data['five_enable'] == 1)
<section id="careers-benefits" class="careers-benefits-main-block">
    <div class="container-xl">
        <div class="careers-benefits-block">
            <div class="careers-benefits-heading text-center">{{ $data->five_heading }}</div>
            <p class="text-center btm-40">{{ $data->five_text }}</p>
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="careers-benefits-dtl-block btm-40">
                        <div class="careers-benefits-icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="careers-benefits-dtl">
                            <div class="careers-benefits-dtl-heading">{{ $data->five_textone }}</div>
                            <p>{{ $data->five_dtlone }}</p>
                        </div>
                    </div>
                    @if($data->five_texttwo != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_texttwo }}</div>
                                <p>{{ $data->five_dtltwo }}</p>
                            </div>
                        </div>
                    @endif
                    @if($data->five_textthree != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_textthree }}</div>
                                <p>{{ $data->five_dtlthree }}</p>
                            </div>
                        </div>
                    @endif
                    @if($data->five_textfour != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_textfour }}</div>
                                <p>{{ $data->five_dtlfour }}</p>
                            </div>
                        </div>
                    @endif
                    @if($data->five_textfive != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_textfive }}</div>
                                <p>{{ $data->five_dtlfive }}</p>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="col-lg-6 col-md-6">
                    @if($data->five_textsix != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_textsix }}</div>
                                <p>{{ $data->five_dtlsix }}</p>
                            </div>
                        </div>
                    @endif
                    @if($data->five_textseven != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_textseven }}</div>
                                <p>{{ $data->five_dtlseven }}</p>
                            </div>
                        </div>
                    @endif
                    @if($data->five_texteight != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_texteight }}</div>
                                <p>{{ $data->five_dtleight }}</p>
                            </div>
                        </div>
                    @endif
                    @if($data->five_textnine != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_textnine }}</div>
                                <p>{{ $data->five_dtlnine }}</p>
                            </div>
                        </div>
                    @endif
                    @if($data->five_textten != NULL)
                        <div class="careers-benefits-dtl-block btm-40">
                            <div class="careers-benefits-icon">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="careers-benefits-dtl">
                                <div class="careers-benefits-dtl-heading">{{ $data->five_textten }}</div>
                                <p>{{ $data->five_dtlten }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- careers-benefits end -->
<!-- join-team start -->
@if($data['six_enable'] == 1)
<section id="join-team" class="join-team-main-block">
    <div class="container-xl">
        <div class="join-team-block">
            <div class="careers-benefits-heading text-center">{{ $data->six_heading }}</div>
            <p class="text-center">{{ $data->six_text }}</p>

            <div class="faq-block">
                <div class="faq-dtl">
                    <div id="accordion" class="second-accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <div class="mb-0">
                                    <h3 class="text-center">{{ $data->six_topic_one }}</h3>
                                </div>
                            </div>

                        </div>
                        <hr>
                        @if($data->six_topic_two != NULL)
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <div class="mb-0">
                                        <h3 class="text-center">{{ $data->six_topic_two }} </h3>

                                    </div>
                                </div>

                            </div>
                            <hr>
                        @endif
                        @if($data->six_topic_three != NULL)
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <div class="mb-0">
                                        <h3 class="text-center">{{ $data->six_topic_three }} </h3>

                                    </div>
                                </div>

                            </div>
                            <hr>
                        @endif
                        @if($data->six_topic_four != NULL)
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <div class="mb-0">
                                        <h3 class="text-center">{{ $data->six_topic_four }} </h3>

                                    </div>
                                </div>

                            </div>
                            <hr>
                        @endif
                        @if($data->six_topic_five != NULL)
                            <div class="card">
                                <div class="card-header" id="headingFive">
                                    <div class="mb-0">
                                        <h3 class="text-center">{{ $data->six_topic_five }} </h3>

                                    </div>
                                </div>

                            </div>
                            <hr>
                        @endif
                        @if($data->six_topic_six != NULL)
                            <div class="card">
                                <div class="card-header" id="headingSix">
                                    <div class="mb-0">
                                        <h3 class="text-center">{{ $data->six_topic_six }}</h3>

                                    </div>
                                </div>

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
<!-- join-team end -->
@if($data['one_enable'] != 1 && $data['two_enable'] != 1 && $data['three_enable'] != 1 && $data['four_enable'] != 1 && $data['five_enable'] != 1 && $data['six_enable'] != 1)
<div class="w-100 bg-black" style="height:500px">
    <img src="https://media.istockphoto.com/id/1222977692/vector/no-vacancy-neon-sign-on-brick-wall-background.jpg?s=612x612&w=0&k=20&c=9aJgeRDszwOrItI92KRy2c96Pa0cHdfsG9tKSHJ-87M=" class="w-100 h-100" />
</div>
@endif


@endsection