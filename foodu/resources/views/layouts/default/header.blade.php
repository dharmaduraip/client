{{-- <header id="header">
    <div class="container">
        <div id="logo" class="pull-left">
            <h1>
                <a href="{{ url('')}}"> 
                    @if(file_exists(public_path().'/uploads/images/'.config('sximo')['cnf_logo']) && config('sximo')['cnf_logo'] !='')
                    <img src="{{ asset('uploads/images/'.config('sximo')['cnf_logo'])}}" alt="{{ config('sximo')['cnf_appname'] }}" width="30" />
                    @else
                    <img src="{{ asset('uploads/logo.png')}}" alt="{{ config('sximo')['cnf_appname'] }}"  width="30" />
                    @endif
                </a>
            </h1>
        </div>
        <nav id="nav-menu-container">
            @include('layouts.default.navigation')
        </nav>  
    </div>
</header> --}}
@if(Request::segment(1) != '' && !isset($_GET['appview'])) 
<header>
    <div class="sheader-menu">
       <div class="overlay" style="display: none;"></div>
        <nav class="navbar navbar-inverse snav-color nvbar @if(Request::segment(2) == 'search' ) topfixed @endif" id="navmenu"> 
            <div class="container">
                <div class="d-flex align-items-center justify-content-between pading-header no_pad w-100">
                    <div class="navbar-header d-md-inline-block d-flex justify-content-between align-items-center">
                        <a class="navbar-brand nav_logo" href="{!! URL::to('/') !!}">
                            <img src="{{ asset('uploads/logo.png')}}" width="135px" alt="{{CNF_APPNAME}}" data-retina="true" class="logo_normal">
                        </a>
                        <button type="button" class="navbar-toggler nav-toggle navbar-toggle snavtogle d-md-none" data-bs-toggle="collapse" data-bs-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>                        
                        </button>
                        <?php 
                        $city = \Session::get('city');
                        $lat = \Session::get('latitude');
                        $lang = \Session::get('longitude');
                    ?>
                </div>
                <div class="collapse navbar-collapse snav1 justify-content-md-between" id="myNavbar">
                    <ul class="nav navbar-nav snav-acolor sfont nav1">
                        @if(\Request::segment(2) == 'search')
                        @php
                        $cookie_id  = (\AbserveHelpers::getCartCookie() != '') ? \AbserveHelpers::getCartCookie() : \AbserveHelpers::setCartCookie();
                        $user_id    = (\Auth::check()) ? \Auth::user()->id : 0;
                        $authid     = (\Auth::check()) ? \Auth::user()->id : $cookie_id;
                        $cond       = (\Auth::check()) ? 'user_id' : 'cookie_id';
                        $baseurl    = Urlsettings::where($cond,$authid)->first();
                        @endphp
                        @if(!empty($baseurl) && $baseurl->lat != 0)
                        <li class="dropdown right_search">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">{!! $baseurl->keyword !!} , {!! $keyword->city !!}
                                <span class="fas fa-chevron-down sdownarrow">
                                </span>
                            </a>
                        </li>
                        @endif
                        @endif
                    </ul>

                    {{-- <ul class="nav navbar-nav snav-acolor sfont nav1">
                        <li class="dropdown right_search">
                        <a class="dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);" aria-expanded="false">147, N Marret St, near Bharath Petroleum, Simmakkal, Madurai Main, Madurai, Tamil Nadu 625001, India <span class="fas fa-chevron-down sdownarrow">
                        </span>
                        </a>
                        </li>
                     </ul> --}}
                
                    <ul class="nav navbar-nav navbar-right flex-md-row snav-acolor snav margin-header">
                        @if(Request::is('account/*'))
                        @if(!empty($city) && !empty($lat) && !empty($lang))
                        <li><a href="{!! URL::to('search') !!}?city={{$city}}&lat={{$lat}}&lang={{$lang}}"><b><span class="glyphicon glyphicon-arrow-left iconpad"></span></i>Back to Orders</b></a></li>
                        @endif
                        @endif
                        <li><a href="{!! URL::to('searchdish') !!}?city={!!isset($_GET['city']) ? $_GET['city'] : '' !!}&lat={!!isset($_GET['lat']) ? $_GET['lat'] : '' !!}&lang={!!isset($_GET['lang']) ? $_GET['lang'] : '' !!}" id="opensearch"><span class="fas fa-search iconpad"></span>Search</a></li> 

                        @if(\Auth::check())
                        <li class="dropdown-search">
                            <a href="javascript::void(0);" class="textalign dropdown-toggle sign_logout_search" data-toggle="dropdown"><svg class="_1GTCc undefined" viewBox="6 0 12 24" height="17" width="17" fill="#686b78"><path d="M11.9923172,11.2463768 C8.81761115,11.2463768 6.24400341,8.72878961 6.24400341,5.62318841 C6.24400341,2.5175872 8.81761115,0 11.9923172,0 C15.1670232,0 17.740631,2.5175872 17.740631,5.62318841 C17.740631,8.72878961 15.1670232,11.2463768 11.9923172,11.2463768 Z M11.9923172,9.27536232 C14.0542397,9.27536232 15.7257581,7.64022836 15.7257581,5.62318841 C15.7257581,3.60614845 14.0542397,1.97101449 11.9923172,1.97101449 C9.93039471,1.97101449 8.25887628,3.60614845 8.25887628,5.62318841 C8.25887628,7.64022836 9.93039471,9.27536232 11.9923172,9.27536232 Z M24,24 L0,24 L1.21786143,19.7101449 L2.38352552,15.6939891 C2.85911209,14.0398226 4.59284263,12.7536232 6.3530098,12.7536232 L17.6316246,12.7536232 C19.3874139,12.7536232 21.1256928,14.0404157 21.6011089,15.6939891 L22.9903494,20.5259906 C23.0204168,20.63057 23.0450458,20.7352884 23.0641579,20.8398867 L24,24 Z M21.1127477,21.3339312 L21.0851024,21.2122487 C21.0772161,21.1630075 21.0658093,21.1120821 21.0507301,21.0596341 L19.6614896,16.2276325 C19.4305871,15.4245164 18.4851476,14.7246377 17.6316246,14.7246377 L6.3530098,14.7246377 C5.4959645,14.7246377 4.55444948,15.4231177 4.32314478,16.2276325 L2.75521062,21.6811594 L2.65068631,22.0289855 L21.3185825,22.0289855 L21.1127477,21.3339312 Z"></path></svg>
                                {!! \Auth::user()->username !!}
                            </a>
                            <ul class="dropdown-menu menu-sub">
                                <li><a href="{!! URL::to('profile') !!}">Profile</a></li>
                                <li><a href="{!! URL::to('orders') !!}">Order</a></li>
                                @if(\Auth::user()->group_id == 1)
                                <li><a href="{!! URL::to('dashboard?time()') !!}">Dashboard</a></li>
                                @endif
                                <li><a href="{!! URL::to('favourites') !!}">Favourites</a></li>
                                <li> 
                                    <a  href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>Logout
                                    </a>
                                </li>
                            </ul>
                        </li>

                        @else
                        @if(\Request::segment(1) == 'user' && (\Request::segment(2) == 'login' || \Request::segment(2)=='register' || \Request::segment(2)=='partnerregister' ))
                        @else
                        <li>
                            <a class="sign_search"><span class="loginhomeslide">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                    <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                </svg>
                                <span class="textalign ">Sign in</span></span>
                            </a>
                        </li>
                        <li>
                            <a class="signup"><span class="signup-show"><svg class="_1GTCc undefined" viewBox="6 0 12 24" height="17" width="17" fill="#686b78"><path d="M11.9923172,11.2463768 C8.81761115,11.2463768 6.24400341,8.72878961 6.24400341,5.62318841 C6.24400341,2.5175872 8.81761115,0 11.9923172,0 C15.1670232,0 17.740631,2.5175872 17.740631,5.62318841 C17.740631,8.72878961 15.1670232,11.2463768 11.9923172,11.2463768 Z M11.9923172,9.27536232 C14.0542397,9.27536232 15.7257581,7.64022836 15.7257581,5.62318841 C15.7257581,3.60614845 14.0542397,1.97101449 11.9923172,1.97101449 C9.93039471,1.97101449 8.25887628,3.60614845 8.25887628,5.62318841 C8.25887628,7.64022836 9.93039471,9.27536232 11.9923172,9.27536232 Z M24,24 L0,24 L1.21786143,19.7101449 L2.38352552,15.6939891 C2.85911209,14.0398226 4.59284263,12.7536232 6.3530098,12.7536232 L17.6316246,12.7536232 C19.3874139,12.7536232 21.1256928,14.0404157 21.6011089,15.6939891 L22.9903494,20.5259906 C23.0204168,20.63057 23.0450458,20.7352884 23.0641579,20.8398867 L24,24 Z M21.1127477,21.3339312 L21.0851024,21.2122487 C21.0772161,21.1630075 21.0658093,21.1120821 21.0507301,21.0596341 L19.6614896,16.2276325 C19.4305871,15.4245164 18.4851476,14.7246377 17.6316246,14.7246377 L6.3530098,14.7246377 C5.4959645,14.7246377 4.55444948,15.4231177 4.32314478,16.2276325 L2.75521062,21.6811594 L2.65068631,22.0289855 L21.3185825,22.0289855 L21.1127477,21.3339312 Z"></path></svg>
                                <span class="textalign ">Sign up</span></span>
                            </a>
                        </li>
                        @endif
                        @endif
                        @if(\Request::segment(1) == 'search' || \Request::segment(1) == 'details')
                        <li class="cart">
                            <a href="javascript:void(0);">
                                <span class="ccart_count">
                                    <svg class="_1GTCc _2MSid" viewBox="-1 0 37 32" height="18" width="18" fill="#686b78"><path d="M4.438 0l-2.598 5.11-1.84 26.124h34.909l-1.906-26.124-2.597-5.11z"></path></svg>
                                    <span class="cart_head_count">{!! \AbserveHelpers::getCartItemCount() !!}</span>
                                </span> 
                                <span class="textalign">Cart</span>
                            </a>
                            <div class="cartpopup header_menu_cart">
                                {!! \AbserveHelpers::headerCart() !!}
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</div>
</header>
@endif
<div class="rightsignin ">
    <div class="p-fix signin_popup_pfix" style="display: none;"><div class="loader-img"></div></div>
    <div class="signpading">
        <div class="closebutton sign_search">
            <i class="closefilter closeicon2"></i><span class="filter"></span>
        </div>
        <div class="logintextbox">
            <div class="login">Login</div>  
            <div class="or"> or <a class="account clickshow" >create an account</a></div>
            <div class="image"> <img src="{!! asset('sximo5/images/themes/images/signin.png') !!}" width="90" height="94"></div>
            <div class="alert alert-success alert-dismissible" id="reg_success" style="display: none;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> <p class="reg_s"></p>
            </div>
        </div>
        <form method="post" autocomplete="off" id="login_form_slide" action="{{ URL::to('user/signin')}}" class="form-vertical">
            <div class="p-fix signup_popup_pfix" style="display: none;"><div class="loader-img"></div> </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form">
                <div class="alert alert-success alert-dismissible" id="reg_success" style="display: none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> <p class="reg_s"></p>
                </div>
                <div class="alert alert-success alert-dismissible" id="login_check" style="display: none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> Now you are logged in
                </div>
                <div class="loginerror"></div>
                <div class="inputbox1 lG1r mobile_login mobile_login12" >
                    <input type="text" maxlength="10" required  class="forminput1 mobile-cl allownumericwithoutdecimal" value="" name="mobile" id="mobile"  
                    autocomplete="on" placeholder="" >
                    <div class="_2EeI1"></div>
                    <label class="floating-label" id="mm" for="mobile">{!! Lang::get('core.phone_number') !!}</label>
                </div>
                <div class="inputbox1 lG1r otp_login" style="display: none;">   
                    <span class="show_above_input back_to_login_phone" style="display:none;" >Different Number?</span>   
                    <span id="timer_Otp" class="show_above_input resend_login_otp" style="right: 0;">Resend otp?</span>
                    <input type="text" maxlength="5"  required  class="forminput1" value="" name="login_otp" id="login_otp" autocomplete="off" placeholder="" >
                    <label class="floating-label" id="login_otp_err" for="login_otp">{!! Lang::get('core.enter_otp') !!}</label>
                </div>
            </div>
            @if(\Request::segment(1)=='user' && (\Request::segment(2)=='login' || \Request::segment(2)=='register'))
            @else
                {{-- <div class="">
                    <input type="checkbox" id="remember" name="rememberme" value="1" style="float: left; margin-left: 4px;margin-right: 4px;" >
                    <label for="remember">{!! trans('core.abs_rem_me') !!}</label>
                </div> --}}
                @endif
                @if(CNF_RECAPTCHA =='true')
                @if(\Request::segment(2) != 'login' && \Request::Segment(2) != 'register')
                <div class="g-recaptcha-contact" data-sitekey="6LcB820UAAAAALbN6rHYxLSVYAFmPF4aFVvTMfxv" id="RecaptchaField2"></div>
                <input type="hidden" class="hiddenRecaptcha" name="ct_hiddenRecaptcha" id="ct_hiddenRecaptcha">
                <div class="hiddenRecaptcha_error"></div>
                @endif
                @endif  
                <div class="topmargin mobile_login12">
                    <button type="button" class="a-ayg login_otp_check" >LOGIN</button>
                </div>   
                <div class="topmargin">
                    <div id="my-signin3">Google Signin</div>
                </div>   
                <div class="topmargin">
                    <fb:login-button data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true" data-width="" scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>   
                </div>
            </form>
        </div>
    </div>
    <div class="rightsignin forgetsignin" style="display:none;">
        <div class="signpading">
            <div class="closebutton sign_search">
                <i class="closefilter closeicon2"></i><span class="filter"></span>
            </div>
            <div class="logintextbox">
                <div class="forget-login">{!! Lang::get('core.forgot_pwd') !!}</div>  

                <div class="or">  <a class="account backtologin" ><span class="fa fa-arrow-left"></span></a></div>
                <div class="image"> <img src="{!! asset('sximo5/images/themes/images/signin.png') !!}" width="90" height="94"></div>
            </div>
            @if(\Request::segment(1)=='user' && (\Request::segment(2)=='login' || \Request::segment(2)=='register'))
            @else
            <form method="post" action="{{ URL::to('user/request')}}" class="form-vertical box" id="fr">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form">
                    <div class="forgetinput lG1r">
                        <input type="text" class="forminput1" value="" name="credit_email" tabindex="1" 
                        autocomplete="off" placeholder="" required="">
                        <div class="_2EeI1"></div>
                        <label class="floating-label" for="mobile">{!! Lang::get('core.abs_email') !!}</label>
                    </div>
                </div>
                <div class="topmargin">
                    <button type="submit" class="a-ayg" >Send My Password</button>  
                </div>
            </form>
            @endif
        </div>
    </div>
    <div class="rightotpverification">
        <div class="signpading">
            <div class="closebutton sign_search">
                <i class="closefilter closeicon2"></i><span class="filter"></span>
            </div>
            <div class="logintextbox">
                <div class="forget-login">{!! Lang::get('core.otp_verification') !!}</div>
                <div class="image"> <img src="{!! asset('sximo5/images/themes/images/signin.png') !!}" width="90" height="94"></div>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form">
                <div class="alert alert-danger alert-dismissible" id="otp_fail" style="display: none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Invalid OTP!</strong>
                </div>
                <div class="forgetinput lG1r">
                    <input type="text" class="forminput1" value="" readonly="" name="otp_verification_num" id="otp_verification_num" tabindex="1" 
                    autocomplete="off" placeholder="" required="">
                    <div class="_2EeI1"></div>
                    <label class="floating-label readonly_focus" for="mobile">{!! Lang::get('core.abs_phone_number') !!}</label>
                </div>
                <div class="forgetinput lG1r">
                    <input type="text" class="forminput1" value="" name="otp_verification_otp" id="otp_verification_otp" tabindex="1" 
                    autocomplete="off" placeholder="" required="">
                    <div class="_2EeI1"></div>
                    <label class="floating-label" id="otp_verification_otp_msg" for="mobile">{!! Lang::get('core.enter_otp') !!}</label>
                </div>
            </div>
            <div class="topmargin">
                <button type="button" class="a-ayg" id="otp_check" >Submit</button>  
            </div>
        </div>
    </div>
    <div class="rightsignup  signup">
        <div class="signpading">
            <div class="closebutton sign_close">
                <i class="closefilter closeicon2"></i><span class="filter"></span>
            </div>
            <div class="logintextbox">
                <div class="login">Sign up</div>  
                <div class="or"> or <a class="account clicksignin">login to your account</a></div>
                <div class="image"> <img src="{!! asset('sximo5/images/themes/images/signin.png') !!}" width="90" height="94"></div>
            </div>

            <?php $countries = \AbserveHelpers::country(); ?>
            {!! Form::open(array( 'class'=>'form-signup')) !!}
            <div class="p-fix signup_popup_pfix" style="display: none;"><div class="loader-img"></div></div>
            <div class="form reg_1">
                <div class="alert alert-success alert-dismissible" id="google_success" style="display: none;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> <p class="google_thanks"></p>
                </div>
                <div class="inputbox1 lG1r" style="display: none;">
                    <select name="group_id" class="form-control signup-divider group_id" id="group_id" >
                        <option value="">Select Group</option>
                        <option value="3">{!! Lang::get('core.partner') !!}</option>
                        <option selected="" value="4">{!! Lang::get('core.guest') !!}</option>
                    </select>
                </div>

                <div class="inputbox1 lG1r pp_box">
                    <select disabled="" readonly name="phone_code" class="form-control signup-divider  phone_code" id="phone_code1">
                        <option  value="" selected="disabled">Choose country</option>
                        @foreach($countries as $country)
                        <option value="{{$country->phonecode}}" @if($country->phonecode == '91') selected @endif>{{$country->name}} (+{{$country->phonecode}})</option>
                        @endforeach
                    </select>
                    <span id="phone_codeerr"></span>
                </div>              
                <input type="hidden" name="phone_code" id="phone_code" value="91">
                <div class="inputbox1 lG1r">
                    <input type="text" name="phone_number" class="forminput1 phone allownumericwithoutdecimal" id="phone_id" maxlength="10" value="">

                    <div class="_2EeI1"></div>
                    <label class="floating-label" id="phone" for="phone_id">Phone number</label>
                </div>
                <script type="text/javascript">
                    $(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
                        $(this).val($(this).val().replace(/[^\d].+/, ""));
                        if(event.which == 8){

                        } else if((event.which < 48 || event.which > 57 )) {
                            event.preventDefault();
                        }
                    });
                </script>
            </div>
            @if(CNF_RECAPTCHA =='true') 
            <div class="g-recaptcha-quote" data-sitekey="6LcB820UAAAAALbN6rHYxLSVYAFmPF4aFVvTMfxv" id="RecaptchaField1"></div>
            <input type="hidden" class="hiddenRecaptcha" name="qt_hiddenRecaptcha" id="qt_hiddenRecaptcha">
            <div class="hidden_signup_Recaptcha_error"></div>
            @endif
            <div class="form reg_2" style="display: none;">
                <div class="otp_fail"></div>               
                <div class="inputbox1 lG1r">
                    <input type="text" maxlength="5"  required  class="forminput1" value="" name="mobile_otp" id="mobile_otp" autocomplete="off" placeholder="" >                  
                    <label class="floating-label" id="mobile_otp_err" for="mobile_otp">{!! Lang::get('core.enter_otp') !!}</label>                  
                </div>
            </div>
           <input type="hidden" value ="" id="newpartner" >
           <input type="hidden" value ="" id="newdeliveryboy" >
            <div class="form reg_3" style="display: none;">
                <div class="inputbox1 lG1r">
                    {!! Form::text('user_name', null, array('class'=>'forminput1 username','required'=>'' , 'id' => 'user_name' )) !!}
                    <div class="_2EeI1"></div>
                    <label class="floating-label" id="uname" for="uname">User Name</label>
                </div>
            </div>
            <div class="form reg_3" style="display: none;">
                <div class="inputbox1 lG1r">
                    {!! Form::text('address', null, array('class'=>'forminput1 address','required'=>'' )) !!}
                    <div class="fgfg"></div>
                    <label class="floating-label" id="address" for="address">Address</label>
                </div>
            </div>
            <!-- <div class="referral">Have a referral code?</div> -->
            <div class="topmargin">
                <a href="javascript:void(0);" class="a-ayg reg_otp_check" >Submit</a>
            </div>
            <div class="terms">By creating an account, I accept the  <a href="{{ URL::to('/terms') }}">Terms &amp; Conditions</a></div>
            <div class="topmargin">                  
                <div id="my-signin2">Google Signin</div>   
            </div>
            <div class="topmargin">      
                <fb:login-button data-size="large" data-button-type="login_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="false" data-width="" scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    
    <script>
        $(document).ready(function(){
            $(".right_search").on("click", function () {
                $(".left-menu").toggleClass("left-active");
                $(".overlay").toggle();
            });
            // $("#login_otp").click(function(){
            //     $("#login_otp").focus();
            //     alert();
            // });
        });
    </script>
    <script>
        $( document ).ready(function() {
            $( "#user_name" ).keypress(function(e) {
                var key = e.keyCode;
                if (key >= 48 && key <= 57) {
                    e.preventDefault();
                }
            });/*
            $( "#lname" ).keypress(function(e) {
                var key = e.keyCode;
                 if (key >= 48 && key <= 57) {
                    e.preventDefault();
                }
             });*/
        });
    </script>