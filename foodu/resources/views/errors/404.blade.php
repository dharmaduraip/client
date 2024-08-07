<!DOCTYPE html> 
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title> {{ config('sximo.cnf_appname')}} </title>
<meta name="keywords" content="">
<meta name="description" content=""/>
<link rel="shortcut icon" href="{{ asset('favicon.ico')}}" type="image/x-icon">  
<script type="text/javascript">
var base_url = '{!! URL::to('').'/' !!}';
</script>

 <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
 <link rel="stylesheet" type="text/css" href="https://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">

        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        {{-- <link rel="stylesheet" href="{{ asset('sximo5/bootstrap/css/bootstrap.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('sximo5/themes/abserve/css/font-awesome.css') }}">
        <link rel="stylesheet" href="{{ asset('sximo5/css/icons.min.css') }}">
        {{-- <link rel="stylesheet" href="{{ asset('sximo5/css/sximo.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('sximo5/css/front/style.css') }}">
        <link rel="stylesheet" href="{{ asset('sximo5/css/front/static-style.css') }}">
        <link rel="stylesheet" href="{{ asset('sximo5/css/icon_font.css') }}"> 
        <link rel="stylesheet" type="text/css" href="{{ asset('sximo5/css/front/front.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.2.0/css/all.min.css"/>
        {{-- <script src="{{ asset(CNF_THEME.'/themes/abserve/js/modernizr.js') }}"></script> --}}
        <script type="text/javascript" src="{{ asset('sximo5/js/plugins/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo5/js/bootstrap.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('sximo5/js/plugins/parsley.js') }}"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        {{-- <script type="text/javascript" src="{{ asset(CNF_THEME.'/themes/abserve/js/fancybox/source/jquery.fancybox.js') }}"></script>  --}}
        <script type="text/javascript" src="{{ asset('sximo5/js/jquery.mixitup.min.js') }}"></script>

        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->        
    </head>
<body>

    <header class="head_hgt">
        <nav class="navbar navbar-expand-lg navbar-inverse navcolor" id="fixed-top-bg">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <div class="navbar-header d-lg-block d-flex align-items-center  justify-content-between">
                        <a class="navbar-brand" href="{!! URL::to('/') !!}">
                            <img src="{{ asset('uploads/logo.png')}}"  class="img-responsive logo">
                        </a>
                        <button type="button" class="navbar-toggler navbar-toggle nav-toggle" data-bs-toggle="collapse" data-bs-target="#myNavbar" aria-controls="myNavbar" aria-label="Toggle navigation">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse justify-content-lg-end" id="myNavbar">
                        <ul class="nav navbar-nav navmenu align-items-lg-center">
                            @if(\Auth::check())
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><span>{!! Lang::get('core.welcome') !!} <span class="text-caps">@if(Auth::user()->username != ''){{Auth::user()->username}}@else{{Auth::user()->first_name}}@endif</span></span><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ URL::to('account/profile') }}">{!! Lang::get('core.account') !!}</a></li>
                                    @if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)
                                    <li><a href="{{ URL::to('dashboard') }}">Dashboard</a></li>
                                    @endif
                                    <li><a href="{{ URL::to('logout') }}">{!! Lang::get('core.m_logout') !!}</a></li>
                                </ul>
                            </li>
                            @else
                            <li class="loginhomeslide"> Login</li>
                            <li><span class="back signup-show"> Sign up </span></li>
                            <li class="cart1">
                                <a href="{{ URL::to('checkout') }}">
                                    <span class="ccart_count">
                                        <i class="fa fa-shopping-bag"></i>
                                        <span class="cart_head_count">{!! \AbserveHelpers::getCartItemCount() !!}</span>
                                    </span>
                                </a>
                                <div class="cartpopup header_menu_cart">
                                    <?php //echo $head_cart_items_html; ?>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="pre-header abserve mt-100">
            <div class="global-wrap">
            </div>
            <!-- TOP AREA -->
            <div style="min-height:440px;">
                <div class="bg-holder-content error_page">
                    <div class="full-center-d">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-hero">{!! trans('core.abs_404') !!}</p>
                                    <h1>{!! trans('core.abs_page_is_not_found') !!}</h1>
                                    {{-- <p>Aptent vulputate gravida curae lacinia imperdiet tempus erat vulputate posuere mollis quisque magna facilisi sagittis ridiculus consequat a nisl tincidunt </p> --}}
                                    <a class="btn btn-white btn-ghost btn-lg mt5" href="{{ URL::to('')}}">{!! trans('core.abs_to_home_page') !!}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
    </div>
    <div class="abs_footer_code"></div>
    {{-- <footer id="main-footer">
        <div class="container">
            <div class="row row-wrap">
                <?php $blocks = DB::select("SELECT * FROM `abserve_blocks` ");
                foreach($blocks as $block)
                {
                    $var = '7';
                    if($block->id == $var )
                    {
                        $str = $block->template; 
                        echo $str. "\n";
                    }
                }?>
                <div class="col-lg-3 col-md-3 col-sm-5 col-xs-6 full_width">
                    <h4>{!! trans('core.abs_news_letter') !!}</h4>
                    <form id="new_ltr">
                        <label>{!! trans('core.abs_enter_your_email_adrs') !!}</label>
                        <input type="text" id="n_email" class="form-control" style="max-width:240px;">
                        <p class="mt5"><small>{!! trans('core.abs_we_have_send_spam') !!}</small>
                        </p>
                        <p id="n_status"></p>
                        <input type="submit" class="btn btn-primary news_letter" value="Subscribe">
                    </form>
                </div>
                <?php
                foreach($blocks as $block)
                {
                    $var = '5';
                    if($block->id == $var )
                    {
                        $str = $block->template; 
                        echo $str. "\n";
                    }
                    $var = '6';
                    if($block->id == $var )
                    {
                        $str = $block->template; 
                        echo $str. "\n";
                    }
                }
                ?>
            </div>
        </div>
    </footer> --}} 
    <footer>
        <div class="foot">
            <div class="container nopad">
                <div class="row m-0">
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
                </div>

                <div class="foot-bottom ">
                    <div class="container nopad">
                        <div class="row m-0">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="footcenter">
                                    <img class="footerlogo" src="{{ asset('uploads/logo.png')}}" width="230" alt="{!! CNF_APPNAME !!}">
                                    <span class="copy_right">© <?php echo date("Y");?> Tastyeats Enterprises LLP </span>
                                    {{-- <span class="bottom-pad">
                                        <a target="_blank"  class="zoom" href="javascript:void(0);"><i class="fab fa-facebook transform"></i></a>
                                        <a target="_blank" class="zoom" href="javascript:void(0);"><i class="fab fa-twitter transform"></i></a>

                                        <a target="_blank" class="zoom" href="javascript:void(0);"><i class="fab fa-instagram transform"></i></a>
                                    </span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </footer>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
    <script src="{{ asset(CNF_THEME.'/themes/'.CNF_THEME.'/js/custom.js') }}"></script>
</body> 
</html>