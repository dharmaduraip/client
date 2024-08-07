<div class="rt-site-footer  dark-footer">
    <div class="footer-top  ">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-5 col-sm-6 rt-single-widget ">
                    <a href="#" class="footer-logo">
                        <img src="{{ $setting->light_logo_url }}" alt="">
                    </a>
                    <address>
                        <div class="body-font-2 ">
                            @if ($cms_setting->footer_phone_no)
                                <div class="body-font-2 ">
                                    <span>{{ __('call_now') }}:</span>
                                    <a href="tel:{{ $cms_setting->footer_phone_no }}" class="">
                                        {{ $cms_setting->footer_phone_no }}</a>
                                </div>
                            @endif
                            <div class="max-312 body-font-4 mt-2 ">
                                {{ $cms_setting->footer_address }}
                            </div>
                        </div>
                    </address>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 rt-single-widget ">
                    <h2 class="footer-title">{{ __('quick_link') }}</h2>
                    <ul class="rt-usefulllinks2">
                        <li><a href="{{ route('website.about') }}">{{ __('about') }}</a></li>
                        <li><a href="{{ route('website.contact') }}">{{ __('contact') }}</a></li>
                        @guest
                            <li><a href="{{ route('website.plan') }}">{{ __('pricing') }}</a></li>
                        @endguest
                        @if (auth('user')->check() && auth('user')->user()->role != 'candidate')
                            <li><a href="{{ route('website.plan') }}">{{ __('pricing') }}</a></li>
                        @endif
                        <li><a href="{{ route('website.posts') }}">{{ __('blog') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 rt-single-widget ">
                    <h2 class="footer-title">{{ __('candidate') }}</h2>
                    <ul class="rt-usefulllinks2">
                        <li><a href="{{ route('website.job') }}">{{ __('browse_jobs') }}</a></li>
                        @if (!auth('user')->check() || auth('user')->user()->role != 'candidate')
                            <li><a href="{{ route('website.candidate') }}">{{ __('browse_candidates') }}</a></li>
                        @endif
                        <li><a href="{{ route('candidate.dashboard') }}">{{ __('candidate_dashboard') }}</a></li>
                        <li><a href="{{ route('candidate.bookmark') }}">{{ __('saved_jobs') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 rt-single-widget ">
                    <h2 class="footer-title">{{ __('employers') }}</h2>
                    <ul class="rt-usefulllinks2">
                        <li><a href="{{ route('company.job.create') }}">{{ __('post_a_job') }}</a></li>
                        @if (!auth('user')->check() || auth('user')->user()->role != 'company')
                            <li><a href="{{ route('website.company') }}">{{ __('browse_employers') }}</a></li>
                        @endif
                        <li><a href="{{ route('company.dashboard') }}">{{ __('employers_dashboard') }}</a></li>
                        <li><a href="{{ route('company.myjob') }}">{{ __('applications') }}</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 rt-single-widget ">
                    <h2 class="footer-title">{{ __('support') }}</h2>
                    <ul class="rt-usefulllinks2">
                        <li><a href="{{ route('website.faq') }}">{{ __('faqs') }}</a></li>
                        <li><a href="{{ route('website.privacyPolicy') }}">{{ __('privacy_policy') }}</a></li>
                        <li><a href="{{ route('website.termsCondition') }}">{{ __('terms_condition') }}</a></li>
                        <li><a href="{{ route('website.refundPolicy') }}">{{ __('refund_policy') }}</a></li>
                    </ul>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.footer-top -->
    <div class="footer-bottom ">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start f-size-14 text-gray-500">
                    <x-website.footer-copyright />
                </div><!-- /.col-lg-6 -->
                <div class="col-lg-6 text-center text-lg-end">
                    <ul class="footer-social-links">
                        @if ($cms_setting->footer_facebook_link)
                            <li>
                                <a class="fb" href="{{ $cms_setting->footer_facebook_link }}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            </li>
                        @endif
                        @if ($cms_setting->footer_instagram_link)
                            <li>
                                <a class="insta" href="{{ $cms_setting->footer_instagram_link }}">
                                  <i class="fab fa-instagram"></i>  
                                </a>
                            </li>
                        @endif
                        @if ($cms_setting->footer_youtube_link)
                            <li>
                                <a class="utube" href="{{ $cms_setting->footer_youtube_link }}">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            </li>
                        @endif
                        @if ($cms_setting->footer_twitter_link)
                            <li>
                                <a class="twit" href="{{ $cms_setting->footer_twitter_link }}">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div><!-- /.col-lg-6 -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.footer-bottom -->
</div><!-- /.rt-site-footer -->
