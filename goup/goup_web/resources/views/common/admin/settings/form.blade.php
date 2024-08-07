@extends('common.admin.layout.base')
{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}

@section('title') {{ __('Settings') }} @stop

@section('styles')
@parent
    <link rel="stylesheet" href="{{ asset('assets/plugins/chart/css/jquery-jvectormap.css')}}">
@stop

@section('content')

<div class="main-content-container container-fluid px-4">
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">{{ __('Dashboard') }}</span>
        <h3 class="page-title">{{ __('Dashboard') }} {{ __('Overview') }}</h3>
    </div>
</div>

<!-- End Page Header -->
<div class="row">
    <div class="registration_form basic_form   setting_form">
        <div class="stepwizard">
            <div class="stepwizard-row setup-panel">
                <div class="stepwizard-step">
                    <a href="#general" type="button" class="btn btn-success tabs btn-circle">{{ __('General') }}</a>

                </div>
                 <div class="stepwizard-step">
                    <a href="#home_video" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Home Page Video') }}</a>

                </div>
                <div class="stepwizard-step">
                    <a href="#company-profile" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Comp. Profile Links') }}</a>

                </div>
                <div class="stepwizard-step">
                    <a href="#social-link" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Social Link Config') }}</a>

                </div>
               
                <div class="stepwizard-step">
                    <a href="#map-sms" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Map & SMS Config') }}</a>

                </div>
                <div class="stepwizard-step">
                    <a href="#mail" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Mail Config') }}</a>

                </div>
                <div class="stepwizard-step">
                    <a href="#push" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Push Notification') }}</a>

                </div>
                <div class="stepwizard-step">
                    <a href="#payment-setting" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Payment Settings') }}</a>

                </div>
                
                @if(Helper::checkService('TRANSPORT'))
                <div class="stepwizard-step">
                    <a href="#transport" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Transport') }}</a>
                </div>
                @endif

                @if(Helper::checkService('SERVICE'))
                <div class="stepwizard-step">
                    <a href="#service" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Service') }}</a>
                </div>
                @endif

                @if(Helper::checkService('ORDER'))
                <div class="stepwizard-step">
                    <a href="#order" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Order') }}</a>
                </div>
                @endif

                @if(Helper::checkService('DELIVERY'))
                <div class="stepwizard-step">
                    <a href="#delivery" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Delivery') }}</a>
                </div>
                @endif

                <div class="stepwizard-step">
                    <a href="#others" type="button" class="btn btn-default tabs btn-circle" disabled="disabled">{{ __('Others') }}</a>

                </div>
            </div>
        </div>
        <form role="form" method="post" enctype="multipart/form-data">

            <div id="general" class="row setup-content registration form_bdy">
                <div class="col-xs-12">
                    <div class="col-md-12">

                        <div class="form-row">
                            
                            <div class="col-xl-12">
                                <label for="site_title" class="col-form-label">@lang('admin.setting.Site_Name')</label>
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->site_title  }}" name="site_title" required id="site_title" placeholder="Site Name" readonly>
                            </div>
                           
                        </div>

                       
                        <div class="form-row">
                            <div class="col-xl-6">
                            <label for="site_icon" class="col-form-label">@lang('admin.setting.Site_Icon')</label>
                                @if(config('constants.site_icon')!='')
                                <img style="height: 90px; margin-bottom: 15px;" src=""> @endif
                                <input type="file" accept="image/*" name="site_icon" class="dropify form-control-file"  autocomplete="off" id="site_icon" aria-describedby="fileHelp" disabled>
                            </div>
                             <div class="col-xl-6">
                             <label for="site_logo" class="col-xs-3 col-form-label">@lang('admin.setting.Site_Logo')</label>

                                @if(config('constants.site_logo')!='')
                                <img style="height: 90px; margin-bottom: 15px;" src=""> @endif
                                <input type="file" accept="image/*" name="site_logo" class="dropify form-control-file" autocomplete="off" id="site_logo" aria-describedby="fileHelp" disabled>
                            </div>
                             
                        </div>
                        
                        <div class="form-row">
                            <div class="col-xl-6">
                            <label for="contact_number" class="col-xs-3 col-form-label">@lang('admin.setting.Contact_Number')</label>
                                <input class="form-control phone" type="tel" minlength="6" name="contact_number" required id="contact_number" placeholder="Contact Number" value="{{Helper::getSettings()->site->contact_number[0]->number  }}"   readonly >
                            </div>
                            <div class="col-xl-6">
                            <label for="contact_email" class="col-form-label">@lang('admin.setting.Contact_Email')</label>
                                <input class="form-control" type="email" value="{{ Helper::getSettings()->site->contact_email  }}" name="contact_email" required id="contact_email" placeholder="Contact Email" readonly>
                            </div>
                           
                        </div>

                        <div class="form-row">
                             <div class="col-xl-6">
                            <label for="sos_number" class="col-form-label">@lang('admin.setting.SOS_Number')</label>
                                <input class="form-control phone" type="tel" minlength="1" maxlength="10" required value="{{ Helper::getSettings()->site->sos_number  }}" name="sos_number"  id="sos_number" placeholder="SOS Number" readonly>
                            </div>
                            <div class="col-xl-6">
                                <label for="tax_percentage" class=" col-form-label">@lang('admin.setting.Copyright_Content')</label>
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->site_copyright  }}" name="site_copyright" id="site_copyright" placeholder="Site Copyright" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xl-6">
                            <label for="country" class="col-xs-3 col-form-label">@lang('admin.setting.default_country')</label>
                            <select name="country" id="country" class="form-control"></select>
                                
                            </div>
                             <div class="col-xl-6">
                             <label for="distance" class="col-xs-3 col-form-label">@lang('admin.setting.distance')</label>
                           
                                <select name="unit_measurement" class="form-control" disabled="">
                                    <option value="Kms" {{ Helper::getSettings()->site->unit_measurement == 'Kms' ? 'selected' : '' }}>Kms</option>
                                    <option value="Miles" {{ Helper::getSettings()->site->unit_measurement == 'Miles' ? 'selected' : '' }}>Miles</option>
                                </select>
                            </div>
                        </div>
                           <div class="form-group">
                           
                        </div>

                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg mt-3" disabled type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>


         <form role="form" method="post" enctype="multipart/form-data">
            <div id="home_video" class="row setup-content business_form form_bdy">
                <div class="col-xs-12">
                    <div class="col-md-12">

                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="home_page_video_1" class="col-xs-3 col-form-label">@lang('admin.setting.home_page_video_1')</label>
                                <input class="form-control" type="file" value="" name="home_page_video_1" id="home_page_video_1"  autocomplete="off" placeholder="@lang('admin.setting.home_page_video_1')">
                            </div>
                             <div class="col-xl-6">
                                <label for="home_page_video_2" class="col-xs-3 col-form-label">@lang('admin.setting.home_page_video_2')</label>
                                 <input class="form-control" type="file" value="" name="home_page_video_2" id="home_page_video_2"  autocomplete="off" placeholder="@lang('admin.setting.home_page_video_2')">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="home_page_video_3" class="col-xs-3 col-form-label">@lang('admin.setting.home_page_video_3')</label>
                               <input class="form-control" type="file" value="" name="home_page_video_3" id="home_page_video_3"  autocomplete="off" placeholder="@lang('admin.setting.home_page_video_3')">
                            </div>
                            <div class="col-xl-6">
                                <label for="home_page_video_4" class="col-xs-3 col-form-label">@lang('admin.setting.home_page_video_4')</label>
                                <input class="form-control" type="file" value="" name="home_page_video_4" id="home_page_video_4"  autocomplete="off" placeholder="@lang('admin.setting.home_page_video_4')">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="home_page_video_5" class="col-xs-3 col-form-label">@lang('admin.setting.home_page_video_5')</label>
                                <input class="form-control" type="file" value="" name="home_page_video_5" id="home_page_video_5"  autocomplete="off" placeholder="@lang('admin.setting.home_page_video_5')">
                            </div>
                             <div class="col-xl-6">
                                <label for="home_page_video_6" class="col-xs-3 col-form-label">@lang('admin.setting.home_page_video_6')</label>
                              <input class="form-control" type="file" value="" name="home_page_video_6" id="home_page_video_6"  autocomplete="off" placeholder="@lang('admin.setting.home_page_video_6')">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="home_page_video_7" class="col-xs-3 col-form-label">@lang('admin.setting.home_page_video_7')</label>
                                 <input class="form-control" type="file" value="" name="home_page_video_7" id="home_page_video_7"  autocomplete="off" placeholder="@lang('admin.setting.home_page_video_7')">
                            </div>
                             <div class="col-xl-6">
                                <label for="home_page_video_8" class="col-xs-3 col-form-label">@lang('admin.setting.home_page_video_8')</label>
                               <input class="form-control" type="file" value="" name="home_page_video_8" id="home_page_video_8"  autocomplete="off" placeholder="@lang('admin.setting.home_page_video_8')">
                            </div>
                        </div>

                       
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>
        </form>
            {{-- </div> --}}

        <form role="form" method="post" enctype="multipart/form-data">

            <div id="company-profile" class="row setup-content business_form form_bdy">
                <div class="col-xs-12">
                    <div class="col-md-12">

                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="store_link_android_user" class="col-xs-3 col-form-label">@lang('admin.setting.Android_user_link')</label>
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->store_link_android_user  }}" name="store_link_android_user" id="store_link_android_user" placeholder="@lang('admin.setting.Android_user_link')">
                            </div>
                            
                            <div class="col-xl-6">
                                <label for="store_link_android_provider" class="col-xs-3 col-form-label">@lang('admin.setting.Android_provider_link')</label>
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->store_link_android_provider  }}" name="store_link_android_provider" id="store_link_android_provider" placeholder="@lang('admin.setting.Android_provider_link')">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="store_link_ios_user" class="col-xs-3 col-form-label">@lang('admin.setting.Ios_user_Link')</label>
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->store_link_ios_user  }}" name="store_link_ios_user" id="store_link_ios_user" placeholder="@lang('admin.setting.Ios_user_Link')">
                            </div>
                            
                            <div class="col-xl-6">
                                <label for="store_link_ios_provider" class="col-xs-3 col-form-label">@lang('admin.setting.Ios_provider_Link')</label>
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->store_link_ios_provider  }}" name="store_link_ios_provider" id="store_link_ios_provider" placeholder="@lang('admin.setting.Ios_provider_Link')">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="store_link_ios_shop" class="col-xs-3 col-form-label">@lang('admin.setting.Android_shop_Link')</label>
                                <input class="form-control" type="text" value="{{ isset(Helper::getSettings()->site->store_link_ios_shop)?Helper::getSettings()->site->store_link_ios_shop:''  }}" name="store_link_ios_shop" id="store_link_ios_shop" placeholder="@lang('admin.setting.Android_shop_Link')">
                            </div>
                            
                            <div class="col-xl-6">
                                <label for="store_link_android_shop" class="col-xs-3 col-form-label">@lang('admin.setting.Ios_shop_Link')</label>
                                <input class="form-control" type="text" value="{{ isset(Helper::getSettings()->site->store_link_android_shop)?Helper::getSettings()->site->store_link_android_shop:''  }}" name="store_link_android_shop" id="store_link_android_shop" placeholder="@lang('admin.setting.Ios_shop_Link')">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-xl-6">
                                <label for="store_facebook_link" class="col-xs-3 col-form-label">@lang('admin.setting.Facebook_Link')</label>
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->store_facebook_link  }}" name="store_facebook_link" id="store_facebook_link" placeholder="@lang('admin.setting.Facebook_Link')">
                            </div>
                            
                            <div class="col-xl-6">
                                <label for="store_twitter_link" class="col-xs-3 col-form-label">@lang('admin.setting.Twitter_Link')</label>
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->store_twitter_link  }}" name="store_twitter_link" id="store_twitter_link" placeholder="@lang('admin.setting.Twitter_Link')">
                            </div>
                        </div>
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        <form role="form" method="post" enctype="multipart/form-data">

            <div id="social-link" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">

                    <div class="col-md-12">

                        
                        <div class="form-group">
                            <label for="social_login">@lang('admin.setting.Social_Login')</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{Helper::getSettings()->site->social_login == '1' ? 'checked' : ''}} type="checkbox" id="social_login" name="social_login"  class="custom-control-input social_login" value ='1'>
                                <label class="custom-control-label " for="social_login"></label>
                            </div>
                        </div>

                        <div class="social_container hidesocial" style=" {{Helper::getSettings()->site->social_login == '0' ? 'display: none;' : '' }} ">
                            <hr>
                            <div class="form-group">
                                <label for="facebook_app_id" class="col-xs-3 col-form-label">@lang('admin.setting.facebook_app_id')</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" value="{{ Helper::getSettings()->site->facebook_app_id  }}" name="facebook_app_id" id="facebook_app_id" placeholder="@lang('admin.setting.facebook_app_id')">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="facebook_app_secret" class="col-xs-3 col-form-label">@lang('admin.setting.facebook_app_secret')</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="password" value="{{ Helper::getSettings()->site->facebook_app_secret  }}" name="facebook_app_secret" id="facebook_app_secret" placeholder="@lang('admin.setting.facebook_app_secret')">
                                </div>
                            </div>

                           
                           

                            <div class="form-group">
                                <label for="google_client_id" class="col-xs-3 col-form-label">@lang('admin.setting.google_client_id')</label>
                                <div class="col-xs-9">
                                    <input class="form-control" type="text" value="{{ Helper::getSettings()->site->google_client_id  }}" name="google_client_id" id="google_client_id" placeholder="@lang('admin.setting.google_client_id')">
                                </div>
                            </div>

                            <hr>
                        </div>
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>

        <form role="form" method="post" enctype="multipart/form-data">

            <div id="map-sms" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">

                    <div class="col-md-12">

                        <div class="form-group">

                            <label for="browser_key" class="col-xs-3 col-form-label">@lang('admin.setting.browser_key')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->browser_key  }}" name="browser_key" required id="browser_key" placeholder="@lang('admin.setting.browser_key')">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="server_key" class="col-xs-3 col-form-label">@lang('admin.setting.server_key')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->server_key  }}" name="server_key" required id="server_key" placeholder="@lang('admin.setting.server_key')">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="android_key" class="col-xs-3 col-form-label">@lang('admin.setting.android_key')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->android_key  }}" name="android_key" required id="android_key" placeholder="@lang('admin.setting.android_key')">
                            </div>
                        </div>

                        <div class="form-group">

                            <label for="ios_key" class="col-xs-3 col-form-label">@lang('admin.setting.ios_key')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->ios_key  }}" name="ios_key" required id="ios_key" placeholder="@lang('admin.setting.ios_key')">
                            </div>
                        </div>

                        <div id="sms" class="col-md-12 row ">
                    <div class="col-md-12">
                        <div class="form-group" id="sms_request">
                            <label for="customToggle6"> @lang('admin.setting.send_sms')</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input type="checkbox" id="sendsmsCheck" name="send_sms" class="custom-control-input" value ='0' {{ Helper::getSettings()->site->send_sms == '1' ? 'checked' : ''}}>
                                <label class="custom-control-label" for="sendsmsCheck"></label>
                            </div>
                        </div>
                        <div class="form-group hidesms">
                            <label for="social_login" class="col-xs-3 col-form-label">@lang('admin.setting.sms_provider')</label>
                            <div class="col-xs-9">
                                <select class="form-control" name="sms_driver" required id="sms_driver">
                                <option value=''>No SMS</option>
                                    <option value="TWILIO" {{ Helper::getSettings()->site->sms_provider == 'TWILIO' ? 'selected' : '' }}>@lang('admin.setting.twilio')</option>
                                    <option value="MSG91" {{ Helper::getSettings()->site->sms_provider == 'MSG91' ? 'selected' : '' }}>@lang('admin.setting.msg91')</option>
                                    <option value="AWSSNS" {{ Helper::getSettings()->site->sms_provider == 'AWSSNS' ? 'selected' : '' }}>@lang('admin.setting.awssns')</option>

                                </select>
                            </div>
                        </div>

                      {{--  <div class="form-group hidesms awssnsInputs">
                            <label for="aws_sns_key" class="col-xs-3 col-form-label">@lang('admin.setting.aws_settings.aws_sns_key')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->aws_sns_key  }}" name="aws_sns_key" required id="aws_sns_key" placeholder="@lang('admin.setting.aws_settings.aws_sns_key')">
                            </div>
                        </div>
                        <div class="form-group hidesms awssnsInputs">
                            <label for="aws_sns_secret" class="col-xs-3 col-form-label">@lang('admin.setting.aws_settings.aws_sns_secret')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->aws_sns_secret  }}" name="aws_sns_secret" required id="aws_sns_secret" placeholder="@lang('admin.setting.aws_settings.aws_sns_secret')">
                            </div>
                        </div>
                        <div class="form-group hidesms awssnsInputs">
                            <label for="aws_sns_region" class="col-xs-3 col-form-label">@lang('admin.setting.aws_settings.aws_sns_region')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->aws_sns_region  }}" name="aws_sns_region" required id="aws_sns_region" placeholder="@lang('admin.setting.aws_settings.aws_sns_region')">
                            </div>
                        </div> --}}



                        <div class="form-group hidesms twilInputs">
                            <label for="sms_account_sid" class="col-xs-3 col-form-label">@lang('admin.setting.twilio_settings.sms_twilio_sid')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->sms_account_sid  }}" name="sms_account_sid" required id="sms_account_sid" placeholder="@lang('admin.setting.twilio_settings.sms_twilio_sid')">
                            </div>
                        </div>
                        <div class="form-group hidesms twilInputs">
                            <label for="sms_auth_token" class="col-xs-3 col-form-label">@lang('admin.setting.twilio_settings.sms_auth_token')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->sms_auth_token  }}" name="sms_auth_token" required id="sms_auth_token" placeholder="@lang('admin.setting.twilio_settings.sms_auth_token')">
                            </div>
                        </div>
                        <div class="form-group hidesms twilInputs">
                            <label for="sms_from_number" class="col-xs-3 col-form-label">@lang('admin.setting.twilio_settings.sms_from_number')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->sms_from_number  }}" name="sms_from_number" required id="sms_from_number" placeholder="@lang('admin.setting.twilio_settings.sms_from_number')">
                            </div>
                        </div> 
                        
                    </div>
                </div>
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>

        <form role="form" method="post" enctype="multipart/form-data">

            <div id="mail" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <div class="form-group" id="mail_request">
                            <label for="customToggle2"> @lang('admin.setting.send_mail')</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{ Helper::getSettings()->site->send_email == '1' ? 'checked' : ''}} type="checkbox" id="sendmailCheck" name="send_email" class="custom-control-input" value ='0'>
                                <label class="custom-control-label" for="sendmailCheck"></label>
                            </div>
                        </div>
                        <div class="form-group hidemail">
                            <label for="social_login" class="col-xs-3 col-form-label">@lang('admin.setting.mail_driver')</label>
                            <div class="col-xs-9">
                                <select class="form-control" name="mail_driver" required id="mail_driver">
                                    <option value="SMTP" {{ Helper::getSettings()->site->mail_driver == 'SMTP' ? 'selected' : '' }}>@lang('admin.setting.smtp')</option>
                                    <option value="MAILGUN" {{ Helper::getSettings()->site->mail_driver == 'MAILGUN' ? 'selected' : '' }}>@lang('admin.setting.mailgun')</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group hidemail">
                            <label for="mail_host" class="col-xs-3 col-form-label">@lang('admin.setting.mail_host')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ isset(Helper::getSettings()->site->mail_host) ? Helper::getSettings()->site->mail_host : ''  }}" name="mail_host" required id="mail_host" placeholder="@lang('admin.setting.mail_host')">
                            </div>
                        </div>

                        <div class="form-group hidemail">
                            <label for="mail_port" class="col-xs-3 col-form-label">@lang('admin.setting.mail_port')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->mail_port  }}" name="mail_port" required id="mail_port" placeholder="@lang('admin.setting.mail_port')">
                            </div>
                        </div>

                        <div class="form-group hidemail">
                            <label for="mail_username" class="col-xs-3 col-form-label">@lang('admin.setting.mail_username')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->mail_username  }}" name="mail_username" required id="mail_username" placeholder="@lang('admin.setting.mail_username')">
                            </div>
                        </div>

                        <div class="form-group hidemail">
                            <label for="mail_password" class="col-xs-3 col-form-label">@lang('admin.setting.mail_password')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->mail_password  }}" name="mail_password" required id="mail_password" placeholder="@lang('admin.setting.mail_password')">
                            </div>
                        </div>

                        <div class="form-group hidemail">
                            <label for="mail_from_address" class="col-xs-3 col-form-label">@lang('admin.setting.mail_from_address')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="email" value="{{ Helper::getSettings()->site->mail_from_address  }}" name="mail_from_address" required id="mail_from_address" placeholder="@lang('admin.setting.mail_from_address')">
                            </div>
                        </div>

                        <div class="form-group hidemail">
                            <label for="mail_from_name" class="col-xs-3 col-form-label">@lang('admin.setting.mail_from_name')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->mail_from_name  }}" name="mail_from_name" required id="mail_from_name" placeholder="@lang('admin.setting.mail_from_name')">
                            </div>
                        </div>

                        <div class="form-group hidemail">
                            <label for="mail_encryption" class="col-xs-3 col-form-label">@lang('admin.setting.mail_encryption')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->mail_encryption  }}" name="mail_encryption" required id="mail_encryption" placeholder="@lang('admin.setting.mail_encryption')">
                            </div>
                        </div>

                        <div class="form-group hidemail mail_domain">
                            <label for="mail_domain" class="col-xs-3 col-form-label">@lang('admin.setting.mail_domain')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->mail_domain  }}" name="mail_domain" id="mail_domain" placeholder="@lang('admin.setting.mail_domain')">
                            </div>
                        </div>

                        <div class="form-group hidemail mail_secret">
                            <label for="mail_secret" class="col-xs-3 col-form-label">@lang('admin.setting.mail_secret')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->mail_secret  }}" name="mail_secret" id="mail_secret" placeholder="@lang('admin.setting.mail_secret')">
                            </div>
                        </div>
                    </div>
                </div>
                
                @if(Helper::getDemomode() == 0)
                <div class="col-md-8 row">
                    <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                </div>
                @endif
            </div>
        </form>

        <form role="form" method="post" enctype="multipart/form-data">

            <div id="push" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">

                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="mail_driver" class="col-xs-3 col-form-label">@lang('admin.setting.environment')</label>
                            <div class="col-xs-9">
                                <select name="environment" required id="environment" class="form-control">
                                    <option value="development">Development</option>
                                    <option value="production">Production</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mail_driver" class="col-xs-3 col-form-label">@lang('admin.setting.ios_push_user_pem')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="file" value="" name="user_pem" id="user_pem"  autocomplete="off" placeholder="@lang('admin.setting.ios_push_user_pem')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mail_driver" class="col-xs-3 col-form-label">@lang('admin.setting.ios_push_provider_pem')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="file" value="" name="provider_pem" id="provider_pem"  autocomplete="off" placeholder="@lang('admin.setting.ios_push_provider_pem')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mail_driver" class="col-xs-3 col-form-label">@lang('admin.setting.ios_push_shop_pem')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="file" value="" name="shop_pem" id="shop_pem"  autocomplete="off" placeholder="@lang('admin.setting.ios_push_provider_pem')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mail_host" class="col-xs-3 col-form-label">@lang('admin.setting.ios_push_password')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->ios_push_password  }}" name="ios_push_password" required id="ios_push_password" placeholder="@lang('admin.setting.ios_push_password')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="mail_port" class="col-xs-3 col-form-label">@lang('admin.setting.android_push_key')</label>
                            <div class="col-xs-9">
                                <input class="form-control" type="text" value="{{ Helper::getSettings()->site->android_push_key  }}" name="android_push_key" required id="android_push_key" placeholder="@lang('admin.setting.android_push_key')">
                            </div>
                        </div>
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>
        
        <form role="form" method="post" class="payment-setting" enctype="multipart/form-data">

            <div id="payment-setting" class="row setup-content edu_form form_bdy">
                <div class="form-group row">

                <?php //dd(Helper::getSettings()->payment); ?>
                    @foreach(Helper::getSettings()->payment as $key => $payment)
                    
                        <div class="col-md-12">
                            <label for="customToggle2"> {{ __(ucfirst($payment->name)) }} </label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input type="hidden" name ="payment_name[]" value="{{$payment->name}}" autocomplete="off" /><br>
                                <input  {{ $payment->status == '1' ? 'checked' : ''}} type="checkbox" id="{{ $payment->name }}" name="payment_status[{{$payment->name}}]" class="custom-control-input" value ='1' autocomplete="off">
                                <label class="custom-control-label" for="{{ $payment->name }}"></label>
                            </div>
                        </div>
                            @if(count($payment->credentials))
                            <br><br><br>
                            <div class="col-md-12 @if($payment->status != 1) hidepayment @endif">
                                <div class="row pay-form">
                                    <br>
                                    @foreach($payment->credentials as $credential)
                                    @if($credential->name=='stripe_secret_key')
                                    <div class="col-md-6 credentials " data-id={{$key}}> 
                                        <label for="{{$credential->name}}">{{ __(ucwords(str_replace('_', ' ', $credential->name))) }}</label>
                                        <input type="hidden" name ="payment_key_name[]" value="{{$credential->name}}" autocomplete="off" /><br>
                                        <input type="password" class="form-control" id="{{$credential->name}}" name ="payment_key_value[]" placeholder="Secret key" value="{{$credential->value}}"  autocomplete="off">
                                    </div>
                                    @else
                                        <div class="col-md-6 credentials " data-id={{$key}}> 
                                        <label for="{{$credential->name}}">{{ __(ucwords(str_replace('_', ' ', $credential->name))) }}</label>
                                        <input type="hidden" name ="payment_key_name[]" value="{{$credential->name}}" autocomplete="off" /><br>
                                        <input type="text" class="form-control" id="{{$credential->name}}" name ="payment_key_value[]" placeholder="Secret key" value="{{$credential->value}}"  autocomplete="off">
                                    </div>
                                    @endif

                                    @endforeach
                                </div>
                            </div>
                            @endif
                    @endforeach

                    </div>
                    @if(Helper::getDemomode() == 0)
                    <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                    @endif
            </div>
            
        </form>

        @if(Helper::checkService('TRANSPORT'))
        <form role="form" method="post" enctype="multipart/form-data">

            <div id="transport" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">

                    <div class="col-md-12">

                    <div class="form-group">
                            <label for="user_accept_timeout" class="col-xs-3 col-form-label">@lang('admin.setting.User_Accept_Timeout') (Secs)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ @Helper::getSettings()->transport->user_select_timeout  }}" name="user_select_timeout" required id="user_accept_timeout" placeholder="User Timeout">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="provider_accept_timeout" class="col-xs-3 col-form-label">@lang('admin.setting.Provider_Accept_Timeout') (Secs)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ Helper::getSettings()->transport->provider_select_timeout  }}" name="provider_select_timeout" required id="provider_accept_timeout" placeholder="Provider Timout">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ride_search_radius" class="col-xs-3 col-form-label">@lang('admin.setting.credit_ride_limit')</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="<?php echo isset(Helper::getSettings()->transport->credit_ride_limit) ? Helper::getSettings()->transport->credit_ride_limit:0 ;?>" name="credit_ride_limit" required id="ride_search_radius" placeholder="@lang('admin.setting.credit_ride_limit')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ride_search_radius" class="col-xs-3 col-form-label">@lang('admin.setting.Provider_Search_Radius') (Kms)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ Helper::getSettings()->transport->provider_search_radius  }}" name="provider_search_radius" required id="ride_search_radius" placeholder="Provider Search Radius">
                            </div>
                        </div>
                       
                     
                        <div class="form-group">
                            <label for="transport_manual_request"> {{ __('Manual Assigning') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{ Helper::getSettings()->transport->manual_request == '1' ? 'checked value="1"' : ''}} type="checkbox" id="transport_manual_request" name="manual_request" class="custom-control-input" value='1' >
                                <label class="custom-control-label" for="transport_manual_request"></label>
                            </div>
                        </div>
                        <!-- @if(Helper::getSettings()->transport->broadcast_request == '1')
                        <div class="form-group">
                            <label for="broadcast_request">{{ __('Broadcast') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{ Helper::getSettings()->transport->broadcast_request == '1' ? 'checked value="1"' : ''}} type="checkbox" id="broadcast_request" name="broadcast_request" class="custom-control-input" value='1'>
                                <label class="custom-control-label" for="broadcast_request"></label>
                            </div>
                        </div>
                        @endif -->

                        <div class="form-group">
                            <label for="customToggle_rotp">{{ __('Ride Otp') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{Helper::getSettings()->transport->ride_otp == '1' ? 'checked' : ''}} type="checkbox" value="1" id="customToggle_rotp" name="ride_otp"  class="custom-control-input" >
                                <label class="custom-control-label" for="customToggle_rotp"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ride_booking_prefix" class="col-xs-3 col-form-label">@lang('admin.payment.booking_id_prefix')</label>
                            <div class="col-xs-8">
                                <input class="form-control" type="text" value="{{Helper::getSettings()->transport->booking_prefix}}" id="booking_prefix" name="booking_prefix"  placeholder="Booking ID Prefix">
                            </div>
                        </div>
                       
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>
        @endif

        @if(Helper::checkService('SERVICE'))
        <form role="form" method="post" enctype="multipart/form-data">

            <div id="service" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">

                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="service_accept_timeout" class="col-xs-3 col-form-label">@lang('admin.setting.Provider_Accept_Timeout') (Secs)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ Helper::getSettings()->service->provider_select_timeout  }}" name="service_provider_select_timeout" required id="service_accept_timeout" placeholder="@lang('admin.setting.Provider_Accept_Timeout')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="service_search_radius" class="col-xs-3 col-form-label">@lang('admin.setting.Provider_Search_Radius') (Kms)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ Helper::getSettings()->service->provider_search_radius  }}" name="service_provider_search_radius" required id="service_search_radius" placeholder="@lang('admin.setting.Provider_Search_Radius')">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="customToggle_sotp">{{ __('Serve Otp') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{Helper::getSettings()->service->serve_otp == '1' ? 'checked' : ''}} type="checkbox" id="customToggle_sotp" name="service_serve_otp"  class="custom-control-input" value ='1'>
                                <label class="custom-control-label" for="customToggle_sotp"></label>
                            </div>
                        </div>
                       

                        <div class="form-group">
                            <label for="service_booking_prefix" class="col-xs-3 col-form-label">@lang('admin.payment.booking_id_prefix')</label>
                            <div class="col-xs-8">
                                <input class="form-control" type="text" value="{{Helper::getSettings()->service->booking_prefix}}" id="service_booking_prefix" name="service_booking_prefix" required   placeholder="@lang('admin.payment.booking_id_prefix')">
                            </div>
                        </div>

                       
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>
        @endif

        @if(Helper::checkService('ORDER'))
        <form role="form" method="post" enctype="multipart/form-data">

            <div id="order" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">

                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="store_search_radius" class="col-xs-3 col-form-label">@lang('admin.setting.Store_Search_Radius') </label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ Helper::getSettings()->order->store_search_radius  }}" name="store_search_radius" required id="store_search_radius" placeholder="@lang('admin.setting.Store_Search_Radius')">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="transporter_response_time" class="col-xs-3 col-form-label">@lang('admin.setting.transporter_response_time') (Secs)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ Helper::getSettings()->order->provider_select_timeout  }}" name="store_provider_select_timeout" required id="transporter_response_time" placeholder="@lang('admin.setting.transporter_response_time')">
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label for="customToggle_om"> {{ __('Manual Assigning') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{ Helper::getSettings()->order->manual_request == '1' ? 'checked' : ''}} type="checkbox" id="customToggle_om" name="store_manual_request" class="custom-control-input" value ='1'>
                                <label class="custom-control-label" for="customToggle_om"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="customToggle_ootp">{{ __('Order Otp') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{Helper::getSettings()->order->order_otp == '1' ? 'checked' : ''}} type="checkbox" id="customToggle_ootp" name="order_otp"  class="custom-control-input" value ='1'>
                                <label class="custom-control-label" for="customToggle_ootp"></label>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label for="service_booking_prefix" class="col-xs-3 col-form-label">@lang('admin.payment.booking_id_prefix')</label>
                            <div class="col-xs-8">
                                <input class="form-control" type="text" value="{{Helper::getSettings()->order->booking_prefix}}" id="store_booking_prefix" name="store_booking_prefix" required   placeholder="@lang('admin.payment.booking_id_prefix')">
                            </div>
                        </div>
                       {{--  <div class="form-group">
                            <label for="ride_booking_prefix" class="col-xs-3 col-form-label">{{ __('New Product Timeline')  }} (In Days)</label>
                            <div class="col-xs-8">
                                <input class="form-control" type="text" value="{{Helper::getSettings()->order->product_timeline}}" id="product_timeline" name="product_timeline"  placeholder="Product Timeline">
                            </div>
                        </div> --}}


                        {{--  <div class="form-group">
                            <label for="ride_booking_prefix" class="col-xs-3 col-form-label">{{ __('Delivery Boy Response Time') }} (Secs)</label>
                            <div class="col-xs-8">
                                <input class="form-control" type="text" value="{{isset(Helper::getSettings()->order->delivery_boy_response_time) ? Helper::getSettings()->order->delivery_boy_response_time : ''}}" id="delivery_boy_response_time" name="delivery_boy_response_time"  placeholder="Delivery Boy Response Time">
                            </div>
                        </div> --}}
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>
        @endif

        @if(Helper::checkService('DELIVERY'))
        <form role="form" method="post" enctype="multipart/form-data">

            <div id="delivery" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">

                    <div class="col-md-12">
                        @php
                            $user_select_timeout = '';
                            $provider_select_timeout = '';
                            $provider_search_radius = '';
                            $unit_measurement = '';
                            $manual_request = '';
                            $broadcast_request = '';
                            $otp = '';
                            $booking_prefix = '';
                            if(isset(Helper::getSettings()->delivery)){

                                $user_select_timeout = Helper::getSettings()->delivery ? Helper::getSettings()->delivery->user_select_timeout : '';
                                $provider_select_timeout = Helper::getSettings()->delivery ? Helper::getSettings()->delivery->provider_select_timeout : '';
                                $provider_search_radius = Helper::getSettings()->delivery ? Helper::getSettings()->delivery->provider_search_radius : '';
                                $unit_measurement = Helper::getSettings()->delivery ? Helper::getSettings()->delivery->unit_measurement : '';
                                $manual_request = Helper::getSettings()->delivery ? Helper::getSettings()->delivery->manual_request : '';
                                // $broadcast_request = Helper::getSettings()->delivery ? Helper::getSettings()->delivery->broadcast_request : '';
                                $otp = Helper::getSettings()->delivery ? Helper::getSettings()->delivery->otp : '';
                                $booking_prefix = Helper::getSettings()->delivery ? Helper::getSettings()->delivery->booking_prefix : '';
                            }

                        @endphp


                    <div class="form-group">
                            <label for="delivery_user_select_timeout" class="col-xs-3 col-form-label">@lang('admin.setting.User_Accept_Timeout') (Secs)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ @$user_select_timeout  }}" name="delivery_user_select_timeout" required id="delivery_user_select_timeout" placeholder="User Timeout">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="delivery_provider_select_timeout" class="col-xs-3 col-form-label">@lang('admin.setting.Provider_Accept_Timeout') (Secs)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ $provider_select_timeout  }}" name="delivery_provider_select_timeout" required id="provider_accept_timeout" placeholder="Provider Timout">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="delivery_provider_search_radius" class="col-xs-3 col-form-label">@lang('admin.setting.Provider_Search_Radius') (Kms)</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{ $provider_search_radius  }}" name="delivery_provider_search_radius" required id="ride_search_radius" placeholder="Provider Search Radius">
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label for="distance" class="col-xs-3 col-form-label">@lang('admin.setting.distance')</label>
                            <div class="col-xs-9">
                                <select name="delivery_unit_measurement" class="form-control">
                                    <option value="Kms" {{ $unit_measurement == 'Kms' ? 'selected' : '' }}>Kms</option>
                                    <option value="Miles" {{ $unit_measurement == 'Miles' ? 'selected' : '' }}>Miles</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="deliverymanual_request"> {{ __('Manual Assigning') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{ $manual_request == '1' ? 'checked value="1"' : ''}} type="checkbox" id="delivery_manual_request" name="delivery_manual_request" class="custom-control-input" value='1' >
                                <label class="custom-control-label" for="delivery_manual_request"></label>
                            </div>
                        </div>
                        <!-- @if($broadcast_request == '1')
                        <div class="form-group">
                            <label for="broadcast_request">{{ __('Broadcast') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{ $broadcast_request == '1' ? 'checked value="1"' : ''}} type="checkbox" id="broadcast_request" name="broadcast_request" class="custom-control-input" value='1'>
                                <label class="custom-control-label" for="broadcast_request"></label>
                            </div>
                        </div>
                        @endif -->

                        <div class="form-group">
                            <label for="customToggle_dotp">{{ __('Delivery Otp') }}</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{$otp == '1' ? 'checked' : ''}} type="checkbox" value="1" id="customToggle_dotp" name="delivery_otp"  class="custom-control-input" >
                                <label class="custom-control-label" for="customToggle_dotp"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="delivery_booking_prefix" class="col-xs-3 col-form-label">@lang('admin.payment.booking_id_prefix')</label>
                            <div class="col-xs-8">
                                <input class="form-control" type="text" value="{{$booking_prefix}}" id="delivery_booking_prefix" name="delivery_booking_prefix"  placeholder="Booking ID Prefix">
                            </div>
                        </div>
                        @if(Helper::getDemomode() == 0)
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        @endif
                    </div>
                </div>
            </div>

        </form>
        @endif

        <form role="form" method="post" enctype="multipart/form-data">
            <div id="others" class="row setup-content edu_form form_bdy">
                <div class="col-xs-12">
                    <div class="col-md-12">
                        @if(Helper::getDemomode() == 0)
                        @permission('db-backup')
                        <div class="form-group">
                            <div class="col-xs-12">
                            <label for="referral_amount" class="col-form-label">@lang('admin.db_backup')</label>
                            <div class="col-xs-9">
                                <select name="backup_db" required id="backup_db" class="form-control">
                                    <option value="COMMON">Common</option>
                                    <option value="ORDER">Order</option>
                                    <option value="SERVICE">Service</option>
                                    <option value="TRANSPORT">Transport</option>
                                </select>
                            </div>
                            <button class="btn btn-primary btn-md backup" type="submit">{{ __('admin.db_backup_btn') }}</button>
                            </div>
                        </div>

                        @endpermission
                        @endif
                        </form>

                        <div class="form-group" id="referral_request">
                            <label for="referral"> @lang('admin.setting.referral')</label>
                            <br>
                            <div class="custom-control custom-toggle">
                                <input {{ Helper::getSettings()->site->referral == '1' ? 'checked' : ''}} type="checkbox" id="referral" name="referral" class="custom-control-input" value ='1'>
                                <label class="custom-control-label" for="referral"></label>
                            </div>
                        </div>

                        <div class="form-group hidereferral">
                            <label for="referral_count" class="col-xs-3 col-form-label">@lang('admin.setting.referral_count')</label>
                            <div class="col-xs-9">
                                <input class="form-control number" type="text" value="{{Helper::getSettings()->site->referral_count}}" name="referral_count" required id="referral_count" placeholder="@lang('admin.setting.referral_count')" min="0">
                            </div>
                        </div>

                        <div class="form-group hidereferral">
                            <label for="referral_amount" class="col-xs-3 col-form-label">@lang('admin.setting.referral_amount')</label>
                            <div class="col-xs-9">
                                <input class="form-control price" type="text" value="{{Helper::getSettings()->site->referral_amount}}" name="referral_amount" required id="referral_amount" placeholder="@lang('admin.setting.referral_amount')">
                            </div>
                        </div>
                        <div class="form-group" >
                            <label for="date_format"> @lang('admin.setting.24hrs')</label>
                            <br>
                            <div class="custom-control custom-toggle">
                            
                                <input <?php  if(isset(Helper::getSettings()->site->date_format)){  $date_format= Helper::getSettings()->site->date_format; } else{ $date_format=0; }  echo $date_format=="1" ? 'checked' : '' ?> type="checkbox" id="date_format" name="date_format" class="custom-control-input" value =1>
                                <label class="custom-control-label" for="date_format"></label>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="referral_amount" class="col-xs-3 col-form-label">@lang('admin.setting.provider_max_negetive_balance')</label>
                            <div class="col-xs-9">
                                <input class="form-control " type="text" value="{{@Helper::getSettings()->site->provider_negative_balance}}" name="provider_negative_balance" required id="provider_negative_balance" placeholder="@lang('admin.setting.negetive_amount')">
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="referral_amount" class="col-xs-3 col-form-label">@lang('admin.setting.Country_code')</label>
                            <div class="col-xs-9">
                                <input class="form-control " type="text" value="<?php echo isset(Helper::getSettings()->site->country_code)? Helper::getSettings()->site->country_code :'in'; ?>" name="country_code" required id="country_code" placeholder="@lang('admin.setting.Country_code')">
                            </div>
                        </div>

                        <div class="form-group " style="width:100%; float:left;">
                            <label class="col-xs-3 col-form-label">@lang('admin.setting.modules')</label>
                            <div class="col-xs-9">
                                <div style="float: left; padding-right: 30px;" class="custom-control custom-toggle">
                                    <input style="float: left; position: absolute;" <?php echo Helper::checkService('TRANSPORT') ? 'checked' : '' ?> type="checkbox" id="transport_enable" name="adminservice[1]" class="custom-control-input" value ='1'>
                                    <label style="float: left;" class="custom-control-label" for="transport_enable"> @lang('admin.setting.transport')</label>
                                </div>
                                <div style="float: left; padding-right: 30px;" class="custom-control custom-toggle">
                                    <input style="float: left; position: absolute;" <?php echo Helper::checkService('SERVICE') ? 'checked' : '' ?> type="checkbox" id="service_enable" name="adminservice[3]" class="custom-control-input" value ='1'>
                                    <label style="float: left;" class="custom-control-label" for="service_enable">@lang('admin.setting.service')</label>
                                </div>
                                <div style="float: left; padding-right: 30px;" class="custom-control custom-toggle">
                                    <input style="float: left; position: absolute;" <?php echo Helper::checkService('ORDER') ? 'checked' : '' ?> type="checkbox" id="order_enable" name="adminservice[2]" class="custom-control-input" value ='1'>
                                    <label style="float: left;" class="custom-control-label" for="order_enable">@lang('admin.setting.order')</label>
                                </div>
                                <div style="float: left; padding-right: 30px;" class="custom-control custom-toggle">
                                    <input style="float: left; position: absolute;" <?php echo Helper::checkService('DELIVERY') ? 'checked' : '' ?> type="checkbox" id="delivery_enable" name="adminservice[4]" class="custom-control-input" value ='1'>
                                    <label style="float: left;" class="custom-control-label" for="delivery_enable">@lang('admin.setting.delivery')</label>
                                </div>
                            </div>
                        </div>

                        @if(Helper::getDemomode() == 0)
                        <div style class="form-group">
                        <div class="col-xs-12">
                        <button class="btn btn-success nextBtn btn-lg" type="submit">{{ __('Submit') }}</button>
                        </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

        


    </div>

    <!-- End Top Referrals Component -->
</div>
</div>

@stop
@section('scripts')
@parent
<script>

$(document).ready(function() {

    var site_logo, site_icon, user_pem, provider_pem, shop_pem, home_page_video_1, home_page_video_2, home_page_video_3, home_page_video_4, home_page_video_5, home_page_video_6, home_page_video_7, home_page_video_8;

    if(typeof localStorage.current_tab !== 'undefined') {
        $('.stepwizard-step a').removeClass('btn-success');
        $('.stepwizard-step a[href="#'+localStorage.current_tab+'"]').addClass('btn-success');
    }

    $( 'input[name=site_logo]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            site_logo = $( 'input[name=site_logo]' )[0].files[0];
		}
    });

    $( 'input[name=site_icon]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            site_icon = $( 'input[name=site_icon]' )[0].files[0];
		}
    });

    $( 'input[name=user_pem]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            user_pem = $( 'input[name=user_pem]' )[0].files[0];
        }
    });

    $( 'input[name=provider_pem]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            provider_pem = $( 'input[name=provider_pem]' )[0].files[0];
        }
    });

    $( 'input[name=shop_pem]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            shop_pem = $( 'input[name=shop_pem]' )[0].files[0];
        }
    });

    $( 'input[name=home_page_video_1]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            home_page_video_1 = $( 'input[name=home_page_video_1]' )[0].files[0];
        }
    });

    $( 'input[name=home_page_video_2]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            home_page_video_2 = $( 'input[name=home_page_video_2]' )[0].files[0];
        }
    });

    $( 'input[name=home_page_video_3]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            home_page_video_3 = $( 'input[name=home_page_video_3]' )[0].files[0];
        }
    });

    $( 'input[name=home_page_video_4]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            home_page_video_4 = $( 'input[name=home_page_video_4]' )[0].files[0];
        }
    });

    $( 'input[name=home_page_video_5]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            home_page_video_5 = $( 'input[name=home_page_video_5]' )[0].files[0];
        }
    });

    $( 'input[name=home_page_video_6]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            home_page_video_6 = $( 'input[name=home_page_video_6]' )[0].files[0];
        }
    });

    $( 'input[name=home_page_video_7]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            home_page_video_7 = $( 'input[name=home_page_video_7]' )[0].files[0];
        }
    });
    
    $( 'input[name=home_page_video_8]' ).on('change', function(e) {
        if(e.target.files.length > 0) {
            home_page_video_8 = $( 'input[name=home_page_video_8]' )[0].files[0];
        }
    });

    @php

        $domain = $_SERVER['SERVER_NAME'];
        $path = storage_path('license') . '/' . $domain . '.json';
        $config_file = file_exists($path);

        if ($config_file) {

            $config = file_get_contents($path);
            $access_key = json_decode($config, true)['accessKey'];

            try {
                $client = new \GuzzleHttp\Client();
                $params['form_params'] = ['access_key' => $access_key, 'domain' => $domain];

                $result = $client->post(env('BASE_URL') . '/verify', $params);

                $redis = \Illuminate\Support\Facades\Redis::connection();

                $redis->set($domain, json_encode(json_decode($result->getBody())));

            } catch (GuzzleHttp\Exception\ClientException $exception) {
                dd(json_decode($exception->getResponse()->getBody())->message);
            } catch (\Exception $exception) {
                dd($exception);
            }

        } else {
            return abort(500, 'Contact our team to access your domain');
        }
    
    @endphp

    $('.backup').on('click', function(e) {
        e.preventDefault();

        var data = new FormData();

        if(typeof $('select[name=backup_db]') != "undefined") {
            data.append( 'backupdb', $('select[name=backup_db]').val() );
        }
        $.ajax({
            url: getBaseUrl() + "/admin/backup",
            type: "post",
            data: data,
            processData: false,
            contentType: false,
            headers: {
                Authorization: "Bearer " + getToken('admin')
            },
            beforeSend: function (request) {
                showInlineLoader();
            },
            success: function(response, textStatus, jqXHR) {
                console.log(response);
                hideInlineLoader();
                var n = response.lastIndexOf('/');
                var file = response.substring(n + 1);
                var link = document.createElement("a");
                link.download = file;
                link.target = "_blank";

                // Construct the URI
                link.href = response;
                document.body.appendChild(link);
                link.click();

                // Cleanup the DOM
                document.body.removeChild(link);
                delete link;

                //location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                
                if (jqXHR.status == 401) {
                    window.location.replace("/admin/login");
                }

                if (jqXHR.responseJSON) {
                    
                    alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                }
                hideInlineLoader();
            }
        });

    });

    $('.nextBtn').on('click', function(e) {
        e.preventDefault();
        var that = $(this);
        var idv = $($(this).closest('form')).valid();
        if(!idv){
            return false;
        }

        if($(this).closest('form').hasClass('payment-setting')) {
            $(this).closest('form').find('.credentials input').each(function() {
                var value =  $(this).closest('.credentials').data('id') + "_"  + $(this).val();
                $(this).val(value);
            });
        }

        var data = new FormData();
         

        if(typeof site_logo != "undefined") {
            data.append( 'site_logo', $( 'input[name=site_logo]' )[0].files[0] );
        }

        if(typeof site_icon != "undefined") {
            data.append( 'site_icon', $( 'input[name=site_icon]' )[0].files[0] );
        }

        if(typeof user_pem != "undefined") {
            data.append( 'user_pem', $( 'input[name=user_pem]' )[0].files[0] );
        }

        if(typeof provider_pem != "undefined") {
            data.append( 'provider_pem', $( 'input[name=provider_pem]' )[0].files[0] );
        }

        if(typeof shop_pem != "undefined") {
            data.append( 'shop_pem', $( 'input[name=shop_pem]' )[0].files[0] );
        }

        if(typeof home_page_video_1 != "undefined") {
            data.append( 'home_page_video_1', $( 'input[name=home_page_video_1]' )[0].files[0] );
        }

        if(typeof home_page_video_2 != "undefined") {
            data.append( 'home_page_video_2', $( 'input[name=home_page_video_2]' )[0].files[0] );
        }

        if(typeof home_page_video_3 != "undefined") {
            data.append( 'home_page_video_3', $( 'input[name=home_page_video_3]' )[0].files[0] );
        }

        if(typeof home_page_video_4 != "undefined") {
            data.append( 'home_page_video_4', $( 'input[name=home_page_video_4]' )[0].files[0] );
        }

        if(typeof home_page_video_5 != "undefined") {
            data.append( 'home_page_video_5', $( 'input[name=home_page_video_5]' )[0].files[0] );
        }

        if(typeof home_page_video_6 != "undefined") {
            data.append( 'home_page_video_6', $( 'input[name=home_page_video_6]' )[0].files[0] );
        }

        if(typeof home_page_video_7 != "undefined") {
            data.append( 'home_page_video_7', $( 'input[name=home_page_video_7]' )[0].files[0] );
        }

        if(typeof home_page_video_8 != "undefined") {
            data.append( 'home_page_video_8', $( 'input[name=home_page_video_8]' )[0].files[0] );
        }
        
        var formGroup = $(this).closest('form').serialize().split("&");

        for(var i in formGroup) {
            var params = formGroup[i].split("=");
            data.append( decodeURIComponent(params[0]), decodeURIComponent(params[1]) );
        }
       

        if($(this).closest('form').hasClass('payment-setting')) {
            $(this).closest('form').find('.credentials input').each(function() {
                var value =  ($(this).val()).replace( $(this).closest('.credentials').data('id') + "_" , "");
                $(this).val(value);
            });
        }

        localStorage.setItem( "current_tab", that.closest('.setup-content').attr('id'));

        $.ajax({
            url: getBaseUrl() + "/admin/settings",
            type: "post",
            data: data,
            processData: false,
            contentType: false,
            headers: {
                Authorization: "Bearer " + getToken('admin')
            },
            beforeSend: function (request) {
                showInlineLoader();
            },
            success: function(response, textStatus, jqXHR) {
                hideInlineLoader();
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.status == 401) {
                    window.location.replace("/admin/login");
                }

                if (jqXHR.responseJSON) {
                    
                    alertMessage(textStatus, jqXHR.responseJSON.message, "danger");
                }
                hideInlineLoader();
            }
        });

    });
});

</script>

<script type="text/javascript">
   $(document).ready(function () {


    $.ajax({
        type:"GET",
        url: getBaseUrl() + "/admin/company_country_list",
        headers: {
            Authorization: "Bearer " + getToken("admin")
        },
        success:function(data){
                $("#country").empty();
                $("#country").append('<option value="">Select</option>');
                $.each(data.responseData,function(key,item){
                  if(item.country.length !=0){
                    var selected = '';

                    if(item.country.id == "{{ Helper::getDefaultCountry()  }}") selected = 'selected';

                    $("#country").append('<option ' + selected + ' value="'+item.country.id+'">'+item.country.country_name+'</option>');
                  }
                });
             }
    });

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });


    /* allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    }); */

    $('div.setup-panel div a.btn-success').trigger('click');
    //payment setting  tab
    $(document).ready(function(){
        $('input[name="card"]').click(function(){
            if($(this).prop("checked") == true){
                // alert("Checkbox is checked.");
                $('.pay-form').removeClass('d-none').fadeIn('slow');
            }
            else if($(this).prop("checked") == false){
                // alert("Checkbox is unchecked.");
                $('.pay-form').addClass('d-none').fadeOut('slow');
            }
        });

       
    });

    $(document).ready(function(){
    $('.social_container').click(function(){
           
            if($(this).prop("checked") == true){
                // alert("Checkbox is checked.");
                $('.social_container').removeClass('d-none').fadeIn('slow');
            }
            else if($(this).prop("checked") == false){
                // alert("Checkbox is unchecked.");
                $('.social_container').addClass('d-none').fadeOut('slow');
            }
        });

    });
});
switchMailDomain();
switchmail();
switchSmsDomain();
switchsms();
switchCard();
switchreferral();
switchSocial();
switchBroadcast();
//switchManual();

$('#broadcast_request').click(function(e) {
    switchBroadcast();
});
/*$('#transport_manual_request').click(function(e) {
    switchManual();
});*/

$('#mail_request').click(function(e) {
   switchMailDomain();
   switchmail();
   
});
$('#mail_driver').click(function(e) {
   switchMailDomain();
});
$('#sms_request').click(function(e) {
    switchsms();
});
$('#sms_driver').click(function(e) {
    switchSmsDomain();
});
$('#card').click(function(e) {
    switchCard();
});
$('#referral').click(function(e) {
    switchreferral();
});
$('#social_login').click(function(e) {
    switchSocial();
});
function switchBroadcast(){
	var isChecked = $("#broadcast_request").is(":checked");
	if(isChecked){
        $("#broadcast_request").val(1);
		$("#broadcast_request").closest('.form-group').find('label:first').text("{{ __('Broadcast') }}");
	}   
	else{
        $("#broadcast_request").val(0);
        $("#broadcast_request").prop('checked',false);
		$("#broadcast_request").closest('.form-group').find('label:first').text("{{ __('Unicast') }}");
        
    }
}
/*function switchManual(){ 
    var isChecked = $("#transport_manual_request").is(":checked");
    if(isChecked){ 
        $("#transport_manual_request").val(1);
        $("#transport_manual_request").prop('checked',true);
        $("#broadcast_request").val(0);
        $("#broadcast_request").prop('checked',false);       
    }   
    else{     
        $("#broadcast_request").val(1);
        $("#broadcast_request").prop('checked',true);
        $("#transport_manual_request").val(0);
        $("#transport_manual_request").prop('checked',false);
    }
}*/
function switchreferral(){
	var isChecked = $("#referral").is(":checked");
	if(isChecked){
        $("#referral").val(1);
		$(".hidereferral").find('input').attr('required', true);
		$(".hidereferral").show();
	}   
	else{
        $("#referral").val(0);
		$(".hidereferral").find('input').attr('required', false);
		$(".hidereferral").hide();
    }
}
function switchSocial(){
    var isChecked = $("#social_login").is(":checked");
	if(isChecked){
        $("#social_login").val(1);
		$(".hidesocial").find('input').attr('required', true);
		$(".hidesocial").show();
	}   
	else{
        $("#social_login").val(0);
		$(".hidesocial").find('input').attr('required', false);
		$(".hidesocial").hide();
    }
}
function switchCard(){
	var isChecked = $("#card").is(":checked");
	if(isChecked){
        $("#card").val(1);
		$(".hidepayment").find('input').attr('required', true);
		$(".hidepayment").show();
        $('.pay-form').show();
	}   
	else{
        $("#card").val(0);
		$(".hidepayment").find('input').attr('required', false);
		$(".hidepayment").hide();
        $('.pay-form').hide();
    }
}
function switchmail(){
	var isChecked = $("#sendmailCheck").is(":checked");
	if(isChecked){
        $("#sendmailCheck").val(1);
		$(".hidemail").find('input').attr('required', true);
		$(".hidemail").show();
	}   
	else{
        $("#sendmailCheck").val(0);
        $(".hidemail").find('input').attr('required', false);
		$(".hidemail").hide();
        console.log("yes");
    }
}
function switchMailDomain(){
	var mailDriver = $("#mail_driver").val();
	if(mailDriver =="SMTP"){
		$(".hidemail").find('.mail_secret').attr('required', false);
		$(".hidemail").find('.mail_domain').attr('required', false);
		$(".mail_secret").hide();
		$(".mail_domain").hide();
	}   
	else{
		$(".hidemail").find('.mail_secret').attr('required', true);
		$(".hidemail").find('.mail_domain').attr('required', true);
		$(".mail_secret").show();
		$(".mail_domain").show();
	}
}

function switchsms(){
    var isChecked = $("#sendsmsCheck").is(":checked");
	if(isChecked){
        $("#sendsmsCheck").val(1);
		$(".hidesms").find('input').attr('required', true);
		$(".hidesms").show();
	}   
	else{
        $("#sendsmsCheck").val(0);
		$(".hidesms").find('input').attr('required', false);
		$(".hidesms").hide();
	}
}
function switchSmsDomain(){
	var mailDriver = $("#sms_driver").val();
	// if(mailDriver =="TWILIO"){
    //     $(".hidesms").find('.twilInputs').attr('required', true);
	// 	$(".twilInputs").show();
	// }else 
    if(mailDriver=="AWSSNS"){		
		$(".hidesms").find('.awssnsInputs').attr('required', true);
		$(".awssnsInputs").show();
	}
     else{		
		$(".hidesms").find('.mail_secret').attr('required', false);
		$(".awssnsInputs").hide();
	}
}
 </script>
@stop