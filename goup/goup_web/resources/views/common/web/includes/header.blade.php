    <header class="topnav" id="myTopnav">
        <div class="container-fluid">
            <div class="col-lg-12 col-md-12 col-sm-12 dis-row p-0">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a class="" href="/#home">{{ __('Home') }}</a>
                    <a class="" href="/#about">{{ __('Services') }}</a>
                    <a class="" href="/#features">{{ __('Features') }}</a>
                    <a class="" href="/#screenShots">{{ __('How It Works') }}</a>
                    <a class="user_login" href="{{URL::to('/home')}}">{{ __('Login as Guest') }}</a>
                </div>
                
                      <div class="logo-sec">
                    <a href="{{URL::to('')}}" class="logo"><img src="{{ Helper::getSiteLogo() }}" class="img-fluid" alt="logo"></a>
               
                </div>
                <div id="mySidenav" class=" dis-ver-center col-md-7 col-sm-12 p-0">
                    <div id="sidebarCollapse" class="active" onclick="openNav()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                  
                </div>
                <div class=" col-md-5 p-0 user float-right p-0">
                    <ul class="w-100 dis-flex-end m-0">
                        <!-- <li class="menu-item active  d-none d-lg-block d-xl-block"><a class="" href="/#home">{{ __('Home') }}</a></li>
                        <li class="menu-item active  d-none d-lg-block d-xl-block "><a class="" href="/#about">{{ __('Services') }}</a></li>
                        <li class="menu-item  d-none d-lg-block d-xl-block"><a class="" href="/#features">{{ __('Features') }}</a>
                        </li>
                        <li class="menu-item  d-none d-lg-block d-xl-block "><a class="" href="/#screenShots">{{ __('How It Works') }}</a>
                        </li>
                        <li class="menu-item"><a class="btn btn-green go_app" href="javascript:;" onclick="openToggle()">{{ __('Go to App') }}</a>
                        </li> -->

                        <li class="menu-item d-lg-block d-xl-block user_login ">
                            <form >
                                <select name="default_language" id="default_language" >
                                    @foreach (Helper::getSettings()->site->language as $element)
                                    <option value="{{ $element->key }}" @if (Session::has('default_language') && Session::get('default_language') == $element->key ) selected="true" @endif>{{ $element->name }}</option>    
                                    @endforeach
                                </select>
                            </form>
                        </li>
                        <li class="menu-item d-lg-block d-xl-block user_login "><a class="btn-green-secondary" href="javascript:;" onclick="openToggle()">{{ __('Sign In') }}</a>
                        </li>

                        <li class="menu-item d-lg-block d-xl-block user_signup "><a class="btn-green-secondary" href="javascript:;" onclick="openToggle()">{{ __('Sign Up') }}</a>
                        </li>
                        <!-- <li class="menu-item d-lg-block d-xl-block user_login "><a class="btn-green-secondary" href="{{URL::to('/home')}}">{{ __('Sign In') }}</a>
                        </li>
                        <li class="menu-item d-lg-block d-xl-block user_signup "><a class="btn-green-secondary" href="{{URL::to('/home')}}">{{ __('Sign Up') }}</a>
                        </li> -->
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div id="toggle-bg" onclick="closeToggle()"></div>
    <div class="ongoing-service">
        <div id="sideToggle" class="side-toggle mt-3">
            <a href="javascript:void(0)" class="closebtn" onclick="closeToggle()">&times;</a>
            <ul class="ongoing-list">
                <li>
                    <div class="provider-section bg-green">
                        <h5 class="txt-white">{{ __('UserText') }}</h5>
                        <p class="txt-white">{{ __('Find everything you need to track your success on the road') }}.</p>
                        <div class="dis-column">
                            <a class="btn big-btn user_app" href="{{URL::to('/home')}}">{{ __('User App') }} <i class="fa fa-arrow-circle-right ml-2"
                                    aria-hidden="true"></i></a>
                            <a class="btn big-btn user_login" href="{{URL::to('/login')}}">{{ __('User Sign In') }} <i class="fa fa-arrow-circle-right ml-2"
                                    aria-hidden="true"></i></a>
                            <a class="btn big-btn mt-3 user_login" href="{{URL::to('/signup')}}">{{ __('User Sign Up') }} <i
                                    class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
                        </div>
                       </div>
                </li>

                <li>
                    <div class="provider-section bg-green">
                        <h5 class="txt-white">{{ __('ProviderText') }}</h5>
                        <p class="txt-white">{{ __('Find everything you need to track your success on the road') }}.</p>
                        <div class="dis-column">
                            <a class="btn big-btn provider_app" href="{{URL::to('provider/home')}}">{{ __('Provider App') }} <i class="fa fa-arrow-circle-right ml-2"
                                    aria-hidden="true"></i></a>
                            <a class="btn big-btn provider_login" href="{{URL::to('provider/login')}}">{{ __('Provider Sign In') }} <i class="fa fa-arrow-circle-right ml-2"
                                    aria-hidden="true"></i></a>
                            <a class="btn big-btn mt-3 provider_login" href="{{URL::to('provider/signup')}}">{{ __('Provider Sign Up') }} <i
                                    class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </li>

                @if(in_array('ORDER', Helper::getServiceList()))
                <li>
                    <div class="provider-section bg-green">
                        <h5 class="txt-white">Shop</h5>
                        <p class="txt-white">Find everything you need to track your success on the road.</p>
                        <div class="dis-column">
                            <a class="btn big-btn shop_app"  href="{{URL::to('shop')}}">Shop App <i class="fa fa-arrow-circle-right ml-2"
                                    aria-hidden="true"></i></a>
                            <a class="btn big-btn shop_login" href="{{URL::to('shop/login')}}">Shop Sign In <i class="fa fa-arrow-circle-right ml-2" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </li>
                @endif

            </ul>
        </div>
    </div>
