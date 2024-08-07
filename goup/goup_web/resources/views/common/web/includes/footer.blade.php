<!--Footer Content Start-->
    <footer id="footer" class="footer dis-column p-0">
        <div class="space col-md-12">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-md-3 col-sm-12 ">
                        <h5 class="txt-green">{{ __('Contact Us') }}</h5>
                        <!-- <form class="dis-center mt-3">
                     <div class="col-md-12 p-0 dis-start">
                        <input id="name" name="name" class="textInput required" placeholder="First Name" aria-required="true" type="text" required="">
                        <input id="email" name="email" class="textInput required email" placeholder="E-mail Address" type="email" aria-required="true" required="">
                        <input id="contact" name="contact" class="textInput digits" value="" placeholder="Phone" type="text" minlength="10" maxlength="10" required="">
                        <textarea class="form-control" rows="4" cols="50"
                        placeholder="Leave Your Comments..."></textarea>
                        <a class=" btn btn-primary btn-md" href="#">Submit</a>
                        
                     </div>
                  </form> -->
                        <div class="footer-widget">
                            <ul class="">
                                <!-- <li>
                                    <p class="m-0"><b style="float:left; margin-right: 10px;">{{ __('Phone') }}:</b> @if(isset(Helper::getSettings()->site->contact_number)){{ Helper::getSettings()->site->contact_number[0]->number}}@endif</p>
                                </li> -->
                                <li>
                                    <p class="m-0"><b style="float:left; margin-right: 10px;">{{ __('Email') }}:</b> @if(isset(Helper::getSettings()->site->contact_email)){{ Helper::getSettings()->site->contact_email}}@endif</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-xl-3 mb-20 mb-sm-0">
                        <div class="footer-widget">
                            <h5 class="mb-20 txt-green">{{ __('Get Info') }}</h5>
                            <ul class="">
                            @if(Lang::locale() == 'ar' )
                                
                            @else
                                <li><a href="@if(isset(Helper::getSettings()->site->about_us)){{ Helper::getSettings()->site->about_us}}@else#@endif">{{ __('About Us') }}</a></li>
                                <li><a href="@if(isset(Helper::getSettings()->site->help)){{ Helper::getSettings()->site->help}}@else#@endif">{{ __('Help Center') }}</a></li>
                                <li><a href="@if(isset(Helper::getSettings()->site->legal)){{ Helper::getSettings()->site->legal}}@else#@endif">{{ __('Legal') }}</a></li>
                            @endif
                            </ul>
                        </div>
                    </div>
                    <!-- end of col -->
                    <div class="col-sm-12 col-md-3 col-xl-3 mb-20 mb-sm-0">
                        <div class="footer-widget">
                            <h5 class="mb-20 txt-green">{{ __('Learn More') }}</h5>
                            <ul>
                            @if(Lang::locale() == 'ar' )
                                
                            @else
                                <li><a href="@if(isset(Helper::getSettings()->site->faq)){{ Helper::getSettings()->site->faq}}@else#@endif">{{ __('FAQ') }}</a></li>
                                <li><a href="/#screenShots">{{ __('How It Work') }}</a></li>
                                <li><a href="@if(isset(Helper::getSettings()->site->page_privacy)){{ Helper::getSettings()->site->page_privacy}}@else#@endif">{{ __('Privacy Policy') }}</a></li>
                                <li><a href="@if(isset(Helper::getSettings()->site->terms)){{ Helper::getSettings()->site->terms}}@else#@endif">{{ __('Terms & Conditions') }}</a></li>
                            @endif
                            </ul>
                        </div>
                    </div>
                    <!-- end of col -->
                    <div class=" col-sm-12 col-md-3 col-xl-3 mb-20 mb-sm-0">
                        <div class="footer-widget">
                            <h5 class="mb-20 txt-green">{{ __('Social Links') }}</h5>

                            <ul class="social-lists d-flex mb-0 fsocial-links">
                                <li><a target="_blank" href="@if(isset(Helper::getSettings()->site->store_facebook_link)){{ Helper::getSettings()->site->store_facebook_link}}@else # @endif"><i class="fa fa-facebook"></i></a></li>
                                <li><a target="_blank" href="@if(isset(Helper::getSettings()->site->store_twitter_link)){{ Helper::getSettings()->site->store_twitter_link}}@else # @endif"><i class="fa fa-twitter"></i></a></li>
                                <li>
                                    <a href=""><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                </li>
                                <li>
                                    <a href=""><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                            <!-- end of social list -->

                        </div>
                    </div>
                    <!-- end of col -->
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container -->
        </div>
        <div class="bor-top py-4 col-md-12">
            <div class="container">
                <div class="row m-0">
                    <div class="col-md-12 col-sm-12 dis-center">
                        <div class="copyright_text">
                            <p class="txt-green">{{ Helper::getSettings()->site->site_copyright }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of container -->
        </div>
    </footer>
    <!--Footer Content End-->
    @include('common.settings')