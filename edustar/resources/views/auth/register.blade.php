@extends('theme.master')
@section('title', 'Sign Up')
@section('custom-head')
    <style type="text/css">
        .toggle-password{
            position: absolute;
            top: 7px;
            right: 15px; 
        }
        .toggle-password1{
            position: absolute;
            top: 7px;
            right: 15px; 
        }
        #phone_code .select2.select2-container.select2-container--default{
            width: 73px!important;
        }
        #phone_code .select2-selection.select2-selection--single{
            padding-left: 0px;
        }
        #phone_code .select2-container--default .select2-selection--single{
            height: calc(1.5em + 0.6rem + 1px) !important;
        }
        .phone_icon{
            left: 95px!important;
        }
        #mobile{
            padding-left: 30px;
        }
        .select2-dropdown{
            z-index: 1111;
        }
    </style>
@endsection
@section('content')

@include('admin.message')

<!-- Signup start-->
<section id="signup" class="signup-block-main-block register-page">
    <div class="container">
        <div class="login-signup">
            <div class="row no-gutters">
                <div class="col-lg-6 col-md-6">
                    <div class="signup-side-block">
                        <img src="{{ url('images/login/login.png')}}" class="img-fluid" alt="">
                        <div class="login-img">
                            <img src="{{ url('/images/login/'.$gsetting->img) }}" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="signup-heading">
                        
                        {{ $gsetting->text }}

                        <div class="signup-block">
                            <form class="signup-form" method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <i data-feather="user"></i>
                                            <input type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ old('fname') }}" id="fname" placeholder="First Name" required>
                                            @if ($errors->has('fname'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('fname') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <i data-feather="user"></i>
                                            <input type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{ old('lname') }}" id="lname" placeholder="Last Name" required>
                                            @if($errors->has('lname'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('lname') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <i data-feather="mail"></i>
                                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" id="email" placeholder="Email" required>
                                            @if($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        @if($gsetting->mobile_enable == 1)
                                        <div class="d-flex " id="phone_code">
                                            <div class="">
                                                @php
                                                    $countries = App\Allcountry::get();
                                                @endphp
                                                <select name="phone_code" class="phone_code select2" required>
                                                    @foreach ($countries as $country)
                                                        <option value="+{{$country->phonecode}}" {{(old('phone_code') == $country->phonecode) ? 'selected':''}}>+{{ $country->phonecode }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="">
                                                <i data-feather="phone" class="phone_icon"></i>
                                                <input type="text" class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" value="{{ old('mobile') }}" id="mobile" placeholder="Mobile" required>
                                                @if($errors->has('mobile'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('mobile') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group position-relative">
                                            <i data-feather="lock"></i>
                                            <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Password" required>
                                            <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group position-relative">
                                            <i data-feather="lock"></i>
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                                            <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password1"></span>
                                        </div>
                                    </div>
                                </div>
                                @if($gsetting->captcha_enable == 1)
                                <div class="{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    <div class="text-center">
                                        {!! app('captcha')->display() !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <br>
                                @endif
                                
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="term" id="term" required>

                                        <label class="form-check-label" for="term">
                                            <div class="signin-link text-center btm-20">
                                                <b>{{ __('I agree to ') }}<a href="{{url('terms_condition')}}" title="Policy">{{ __('Terms & Condition') }} </a>{{ __('and')}} <a href="{{url('privacy_policy')}}" title="Policy">{{ __('Privacy Policy') }}.</a></b>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <button type="submit" title="Sign Up" class="btn btn-primary">{{ __('Signup') }}</button> 
                                
                            </form>
                            <div class="social-link btm-10">
                                <h2><span>{{ __('Or Signup Using') }}</span></h2>
                                <div class="row">
                                    @if($gsetting->fb_login_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <a href="{{ url('/auth/facebook') }}" target="_blank" title="facebook" class="social-icon facebook-icon" title="Facebook"><i class="fa fa-facebook"></i></a>
                                    </div>
                                    @endif       
                                    @if($gsetting->google_login_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <div class="google">
                                            <a href="{{ url('/auth/google') }}" target="_blank" title="google" class="social-icon google-icon" title="google"><i class="fa fa-google"></i></a>
                                        </div>
                                    </div>
                                    @endif
                                    @if($gsetting->amazon_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <div class="signin-link amazon-button">
                                            <a href="{{ url('/auth/amazon') }}" target="_blank" title="amazon" class="social-icon amazon-icon" title="Amazon"><i class="fab fa-amazon"></i></a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($gsetting->linkedin_enable == 1)
                                    <div class="col-lg-2 col-4"> 
                                        <div class="signin-link linkedin-button">
                                            <a href="{{ url('/auth/linkedin') }}" target="_blank" title="linkedin" class="social-icon linkedin-icon" title="Linkedin"><i class="fab fa-linkedin"></i></a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($gsetting->twitter_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <div class="signin-link twitter-button">
                                            <a href="{{ url('/auth/twitter') }}" target="_blank" title="twitter" class="social-icon twitter-icon" title="Twitter"><i class="fab fa-twitter"></i></a>
                                        </div>
                                    </div>
                                    @endif

                                    @if($gsetting->gitlab_login_enable == 1)
                                    <div class="col-lg-2 col-4">
                                        <div class="signin-link btm-10">
                                            <a href="{{ url('/auth/gitlab') }}" target="_blank" title="gitlab" class="social-icon gitlab-icon" title="gitlab"><i class="fa fa-github"></i></a>
                                        </div>
                                    </div>
                                    @endif
                                </div>  
                            </div>
                            <div class="sign-up text-center">{{ __('Already have an account') }}?<a href="{{ route('login') }}" title="sign-up"> {{ __('Login') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Signup end-->

@endsection

@section('custom-script')
<script type="text/javascript">
    $('.select2').select2();
    $(document).on('click', '.toggle-password', function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#password");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    }); 
    $(document).on('click', '.toggle-password1', function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $("#password-confirm");
        input.attr('type') === 'password' ? input.attr('type','text') : input.attr('type','password')
    });
</script>
@endsection