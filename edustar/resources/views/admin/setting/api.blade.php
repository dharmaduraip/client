@extends('admin.layouts.master')
@section('title', 'API Setting - Admin')
@section('maincontent')
@component('components.breadcumb',['fourthactive' => 'active'])
@slot('heading')
   {{ __('Api Setting') }}
@endslot
@slot('menu1')
{{ __('Api Setting') }}
@endslot
@endcomponent
<div class="contentbar">
    <div class="row">
        @if ($errors->any())  
            <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)     
                    <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="color:red;">&times;</span></button></p>
                @endforeach  
            </div>
        @endif
        
        <div class="col-md-3">
            
            <div class="card p-3 mb-5">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                     <a class="nav-link active" id="v-pills-pesapal-tab" data-toggle="pill" href="#v-pills-pesapal" role="tab" aria-controls="v-pills-pesapal" aria-selected="true"><i class="feather icon-credit-card mr-2"></i>{{ __('Pesapal Payment') }}</a>
                    <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Stripe Payment') }}</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Paypal Payment') }}</a>
                    <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('InstaMojo Payment') }}</a>
                    <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('RazorPay Payment') }}</a>
                    <a class="nav-link" id="v-pills-PayStack-tab" data-toggle="pill" href="#v-pills-PayStack" role="tab" aria-controls="v-pills-PayStack" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('PayStack Payment') }}</a>
                    <a class="nav-link" id="v-pills-Paytm-tab" data-toggle="pill" href="#v-pills-Paytm" role="tab" aria-controls="v-pills-Paytm" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Paytm Payment') }}</a>
                    <a class="nav-link" id="v-pills-ReCaptcha-tab" data-toggle="pill" href="#v-pills-ReCaptcha" role="tab" aria-controls="v-pills-ReCaptcha" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('ReCaptcha') }}</a>
                    <a class="nav-link" id="v-pills-AWS-tab" data-toggle="pill" href="#v-pills-AWS" role="tab" aria-controls="v-pills-AWS" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('AWS Settings') }}</a>
                    <a class="nav-link" id="v-pills-Omise-tab" data-toggle="pill" href="#v-pills-Omise" role="tab" aria-controls="v-pills-Omise" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Omise Payment') }}</a>
                    <a class="nav-link" id="v-pills-PayUBiz-tab" data-toggle="pill" href="#v-pills-PayUBiz" role="tab" aria-controls="v-pills-PayUBiz" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('PayUBiz/Money') }}</a>
                    <a class="nav-link" id="v-pills-Moli-tab" data-toggle="pill" href="#v-pills-Moli" role="tab" aria-controls="v-pills-Moli" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Moli Payment') }}</a>
                    <a class="nav-link" id="v-pills-Cashfree-tab" data-toggle="pill" href="#v-pills-Cashfree" role="tab" aria-controls="v-pills-Cashfree" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Cashfree Payment') }}</a>
                    <a class="nav-link" id="v-pills-Skrill-tab" data-toggle="pill" href="#v-pills-Skrill" role="tab" aria-controls="v-pills-Skrill" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Skrill Payment') }}</a>
                    <a class="nav-link" id="v-pills-FlutterRave-tab" data-toggle="pill" href="#v-pills-FlutterRave" role="tab" aria-controls="v-pills-FlutterRave" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('FlutterRave Payment') }}</a>
                    <a class="nav-link" id="v-pills-Payhere-tab" data-toggle="pill" href="#v-pills-Payhere" role="tab" aria-controls="v-pills-Payhere" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Payhere Payment') }}</a>
                    <a class="nav-link" id="v-pills-Iyzipay-tab" data-toggle="pill" href="#v-pills-Iyzipay" role="tab" aria-controls="v-pills-Iyzipay" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Iyzipay Payment') }}</a>
                    <a class="nav-link" id="v-pills-SSLCommerze-tab" data-toggle="pill" href="#v-pills-SSLCommerze" role="tab" aria-controls="v-pills-SSLCommerze" aria-selected="false"><i class="feather icon-credit-card mr-1"></i>{{ __('SSLCommerze Payment') }}</a>
                    <a class="nav-link" id="v-pills-Youtube-tab" data-toggle="pill" href="#v-pills-Youtube" role="tab" aria-controls="v-pills-Youtube" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Youtube API Keys') }}</a>
                    <a class="nav-link" id="v-pills-Vimeo-tab" data-toggle="pill" href="#v-pills-Vimeo" role="tab" aria-controls="v-pills-Vimeo" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Vimeo API Keys') }}</a>
                    <a class="nav-link" id="v-pills-Aamar-tab" data-toggle="pill" href="#v-pills-Aamar" role="tab" aria-controls="v-pills-Aamar" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Aamar PAy API Keys') }}</a>
                    <a class="nav-link" id="v-pills-BrainTree-tab" data-toggle="pill" href="#v-pills-BrainTree" role="tab" aria-controls="v-pills-BrainTree" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('BrainTree Payment') }}</a>
                    <a class="nav-link" id="v-pills-Google-tab" data-toggle="pill" href="#v-pills-Google" role="tab" aria-controls="v-pills-Google" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Google Tag Manager') }}</a>
                    <a class="nav-link" id="v-pills-Payflexi-tab" data-toggle="pill" href="#v-pills-Payflexi" role="tab" aria-controls="v-pills-Payflexi" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Payflexi Payment') }}</a>
                    @if(Module::has('Esewa') && Module::find('Esewa')->isEnabled())
                        <a class="nav-link" id="v-pills-Esewa-tab" data-toggle="pill" href="#v-pills-Esewa" role="tab" aria-controls="v-pills-Esewa" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Esewa Payment') }}</a>
                    @endif
                    
                    @if(Module::has('Smanager') && Module::find('Smanager')->isEnabled())
                        <a class="nav-link" id="v-pills-Smanager-tab" data-toggle="pill" href="#v-pills-Smanager" role="tab" aria-controls="v-pills-Smanager" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Smanager Payment') }}</a>
                    @endif

                    @if(Module::has('Paytab') && Module::find('Paytab')->isEnabled())
                        <a class="nav-link" id="v-pills-Paytab-tab" data-toggle="pill" href="#v-pills-Paytab" role="tab" aria-controls="v-pills-Paytab" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Paytabs Payment') }}</a>
                    @endif

                    @if(Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())
                        <a class="nav-link" id="v-pills-DPOPayment-tab" data-toggle="pill" href="#v-pills-DPOPayment" role="tab" aria-controls="v-pills-DPOPayment" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('DPO Payment') }}</a>
                    @endif

                    @if(Module::has('AuthorizeNet') && Module::find('AuthorizeNet')->isEnabled())
                        <a class="nav-link" id="v-pills-AuthorizeNet-tab" data-toggle="pill" href="#v-pills-AuthorizeNet" role="tab" aria-controls="v-pills-AuthorizeNet" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('AuthorizeNet Payment') }}</a>
                    @endif

                    @if(Module::has('Bkash') && Module::find('Bkash')->isEnabled())
                        <a class="nav-link" id="v-pills-Bkash-tab" data-toggle="pill" href="#v-pills-Bkash" role="tab" aria-controls="v-pills-Bkash" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Bkash Payment') }}</a>
                    @endif

                    @if(Module::has('Midtrains') && Module::find('Midtrains')->isEnabled())
                        <a class="nav-link" id="v-pills-Midtrains-tab" data-toggle="pill" href="#v-pills-Midtrains" role="tab" aria-controls="v-pills-Midtrains" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Midtrains Payment') }}</a>
                    @endif

                    @if(Module::has('SquarePay') && Module::find('SquarePay')->isEnabled())
                        <a class="nav-link" id="v-pills-SquarePay-tab" data-toggle="pill" href="#v-pills-SquarePay" role="tab" aria-controls="v-pills-SquarePay" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('SquarePay Payment') }}</a>
                    @endif

                    @if(Module::has('Worldpay') && Module::find('Worldpay')->isEnabled())
                        <a class="nav-link" id="v-pills-Worldpay-tab" data-toggle="pill" href="#v-pills-Worldpay" role="tab" aria-controls="v-pills-Worldpay" aria-selected="false"><i class="feather icon-credit-card mr-2"></i>{{ __('Worldpay') }}</a>
                    @endif
                    @if(Module::has('Onepay') && Module::find('Onepay')->isEnabled())
                    @include('onepay::admin.list')
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-9 mb-3">
            <form action="{{ route('api.update') }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('POST') }}
                <div class="card p-3">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-pesapal" role="tabpanel" aria-labelledby="v-pills-pesapal-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('PESAPAL PAYMENT') }}</label><br>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitchpesapal" name="pesapal_enable" {{ $gsetting->pesapal_enable==1 ? 'checked' : '' }} />
                                </div>
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark" for="PESAPAL_CONSUMER_KEY">{{ __('Pesapal Consumer Key') }} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['PESAPAL_CONSUMER_KEY'] }}" autofocus name="PESAPAL_CONSUMER_KEY" type="text" class="form-control" placeholder="Enter Pesapal Consumer Key"/>
                                </div>
                                </div>
                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="PESAPAL_CONSUMER_SECRET">{{ __('Pesapal Consumer Secret Key') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PESAPAL_CONSUMER_SECRET'] }}" autofocus name="PESAPAL_CONSUMER_SECRET" type="text" class="form-control" placeholder="Enter Pesapal Consumer Secret Key"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_mode">{{ __('Pesapal Mode') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PESAPAL_MODE'] }}" autofocus name="PESAPAL_MODE" type="text" class="form-control" placeholder="Enter Pesapal Mode"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> For Test use <b>"sandbox"</b> and for Live use <b>"live"</b></small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                        {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('STRIPEPAYMENT') }}</label><br>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch1" name="stripe_check" {{ $gsetting->stripe_enable==1 ? 'checked' : '' }} />
                                </div>
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label class="text-dark" for="STRIPE_KEY">{{ __('StripeKey') }} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['STRIPE_KEY'] }}" autofocus name="STRIPE_KEY" type="text" class="form-control" placeholder="Enter Stripe Key"/>
                                </div>
                                </div>
                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="s_secretkey">{{ __('StripeSecretKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['STRIPE_SECRET'] }}" autofocus name="STRIPE_SECRET" type="text" class="form-control" placeholder="Enter Stripe Secret Key"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                        {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_enable">{{ __('PAYPALPAYMENT') }}</label><br>
                                        
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch2" name="paypal_check" {{ $gsetting->paypal_enable==1 ? 'checked' : '' }} />
                                </div>
                                    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_cid">{{ __('PaypalClientID') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYPAL_CLIENT_ID'] }}" autofocus name="PAYPAL_CLIENT_ID" type="text" class="form-control" placeholder="Enter Paypal Client ID"/>
                                    </div>
                                </div>
                                    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_sid">{{ __('PaypalSecretID') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYPAL_SECRET'] }}" autofocus name="PAYPAL_SECRET" type="text" class="form-control" placeholder="Enter Paypal Secret ID"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-dark" for="pay_mode">{{ __('PaypalMode') }} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['PAYPAL_MODE'] }}" autofocus name="PAYPAL_MODE" type="text" class="form-control" placeholder="Enter Paypal Mode"/>
                                    <small class="text-info"><i class="fa fa-question-circle"></i> For Test use <b>"sandbox"</b> and for Live use <b>"live"</b></small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                                
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_enable">{{ __('INSTAMOJOPAYMENT') }}</label><br>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch3" name="instamojo_check" {{ $gsetting->instamojo_enable==1 ? 'checked' : '' }} />
                                </div>
                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_cid">{{ __('InstaMojoApiKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['IM_API_KEY'] }}" autofocus name="IM_API_KEY" type="text" class="form-control" placeholder="Enter InstaMojo Api Key"/>
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_sid">{{ __('InstaMojoAuthToken') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['IM_AUTH_TOKEN'] }}" autofocus name="IM_AUTH_TOKEN" type="text" class="form-control" placeholder="Enter InstaMojo Auth Token"/>
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_mode">{{ __('InstaMojoURL') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['IM_URL'] }}" autofocus name="IM_URL" type="text" class="form-control" placeholder="Enter InstaMojo Url"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> For Test use <b>https://test.instamojo.com/api/1.1/</b> <br>
                                        <i class="fa fa-question-circle"></i> For Live use <b>https://www.instamojo.com/api/1.1/</b></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_mode">{{ __('InstaMojo Refund URL ') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['IM_REFUND_URL'] }}" autofocus name="IM_REFUND_URL" type="text" class="form-control" placeholder="Enter InstaMojo Url"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> For Test use <b>https://test.instamojo.com/api/1.1/refunds/</b> <br>
                                        <i class="fa fa-question-circle"></i> For Live use <b>https://instamojo.com/api/1.1/refunds/</b></small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 ">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="razorpay_enable">{{ __('RAZORPAYPAYMENT') }}</label><br>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch4" name="razor_check" {{ $gsetting->razorpay_enable==1 ? 'checked' : '' }} />
                                </div>
                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAZORPAY_KEY">{{ __('RazorpayKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['RAZORPAY_KEY'] }}" autofocus name="RAZORPAY_KEY" type="text" class="form-control" placeholder="Enter Razorpay Key"/>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAZORPAY_SECRET">{{ __('RazorpaySecretKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['RAZORPAY_SECRET'] }}" autofocus name="RAZORPAY_SECRET" type="text" class="form-control" placeholder="Enter Razorpay Secret Key"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-PayStack" role="tabpanel" aria-labelledby="v-pills-PayStack-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="paystack_enable">{{ __('PAYSTACKPAYMENT') }}</label><br>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch5" name="paystack_check" {{ $gsetting->paystack_enable==1 ? 'checked' : '' }} />
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAZORPAY_KEY">{{ __('PayStackPublicKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYSTACK_PUBLIC_KEY'] }}" autofocus name="PAYSTACK_PUBLIC_KEY" type="text" class="form-control" placeholder="Enter Paystack Public Key"/>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAZORPAY_SECRET">{{ __('PayStackSecretKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYSTACK_SECRET_KEY'] }}" autofocus name="PAYSTACK_SECRET_KEY" type="text" class="form-control" placeholder="Enter Paystack Secret Key"/>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAZORPAY_KEY">{{ __('PayStackPaymentUrl') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYSTACK_PAYMENT_URL'] }}" autofocus name="PAYSTACK_PAYMENT_URL" type="text" class="form-control" placeholder="Enter Paystack Payment URL"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('use')}} <b>https://api.paystack.co</b> </small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAZORPAY_SECRET">{{ __('PayStackMerchantEmail') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYSTACK_MERCHANT_EMAIL'] }}" autofocus name="PAYSTACK_MERCHANT_EMAIL" type="text" class="form-control" placeholder="Enter Paystack Merchant Email"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('use')}} <b>{{__('Paystack email')}}</b> </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAZORPAY_SECRET">{{ __('PaystackCallbackURL') }} <span class="text-danger">*</span></label>
                                        <input value="{{ url('callback') }}" autofocus type="text" class="form-control" placeholder="" disabled/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('use')}} <b>{{__('this callback url in Paystack account')}}</b> </small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Paytm" role="tabpanel" aria-labelledby="v-pills-Paytm-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="s_enable">{{ __('PAYTMPAYMENT') }}</label>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch6" name="paytm_check" {{ $gsetting->paytm_enable==1 ? 'checked' : '' }} />
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label class="text-dark" for="PAYTM_ENVIRONMENT">{{ __('PaytmEnviroment') }} <span class="text-danger">*</span></label>
                                    <small class="text-info"><i class="fa fa-question-circle"></i> For Test use <b>"local"</b> and for Live use <b>"production"</b></small>
                                    <input value="{{ $env_files['PAYTM_ENVIRONMENT'] }}" autofocus name="PAYTM_ENVIRONMENT" type="text" class="form-control" placeholder="Enter Paytm Enviroment"/>
                                    </div>
                                </div>
                                    
                                <div class="col-md-6 form-group">
                                    <label class="text-dark" for="PAYTM_MERCHANT_ID">{{ __('PaytmMerchantID') }} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['PAYTM_MERCHANT_ID'] }}" autofocus name="PAYTM_MERCHANT_ID" type="text" class="form-control" placeholder="Enter Paytm Merchant Id"/>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label class="text-dark" for="PAYTM_MERCHANT_KEY">{{ __('PaytmMerchantKey') }} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['PAYTM_MERCHANT_KEY'] }}" autofocus name="PAYTM_MERCHANT_KEY" type="text" class="form-control" placeholder="Enter Paytm Merchant Key"/>
                                </div>
                                    
                                


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYTM_MERCHANT_WEBSITE">{{ __('PaytmMerchantWebsite') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYTM_MERCHANT_WEBSITE'] }}" autofocus name="PAYTM_MERCHANT_WEBSITE" type="text" class="form-control" placeholder="Enter Paytm Merchant Website"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYTM_CHANNEL">{{ __('PaytmChannel') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYTM_CHANNEL'] }}" autofocus name="PAYTM_CHANNEL" type="text" class="form-control" placeholder="Enter Paytm Channel"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYTM_INDUSTRY_TYPE">{{ __('PaytmIndustryType') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYTM_INDUSTRY_TYPE'] }}" autofocus name="PAYTM_INDUSTRY_TYPE" type="text" class="form-control" placeholder="Enter Paytm Industry Type"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-ReCaptcha" role="tabpanel" aria-labelledby="v-pills-ReCaptcha-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="s_enable">{{ __('ReCaptcha') }}</label><br>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch7" name="captcha_check" {{ $gsetting->captcha_enable == 1 ? 'checked' : '' }} />
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                    <label class="text-dark" for="PAYTM_CHANNEL">{{ __('CaptchaSiteKey') }} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['NOCAPTCHA_SITEKEY'] }}" autofocus name="NOCAPTCHA_SITEKEY" type="text" class="form-control" placeholder="Enter Captcha Site Key"/>
                                    </div>
                                </div>
                                    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYTM_INDUSTRY_TYPE">{{ __('CaptchaSecretKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['NOCAPTCHA_SECRET'] }}" autofocus name="NOCAPTCHA_SECRET" type="text" class="form-control" placeholder="Enter Captcha Secret Key"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-AWS" role="tabpanel" aria-labelledby="v-pills-AWS-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="aws_enable">{{ __('AWSSettings') }}</label>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch8" name="aws_check" {{ $gsetting->aws_enable == 1 ? 'checked' : '' }} />
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="AWS_ACCESS_KEY_ID">{{ __('AWSAccessKeyID') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['AWS_ACCESS_KEY_ID'] }}" autofocus name="AWS_ACCESS_KEY_ID" type="text" class="form-control" placeholder="Enter AWS Access Key Id"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="AWS_SECRET_ACCESS_KEY">{{ __('AWSSecretAccessKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['AWS_SECRET_ACCESS_KEY'] }}" autofocus name="AWS_SECRET_ACCESS_KEY" type="text" class="form-control" placeholder="Enter AWS Secret Access Key"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="AWS_DEFAULT_REGION">{{ __('AWSDefaultRegion') }} <span class="text-danger">*</span></label>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="eg:ap-south-1"></i>
                                        <input value="{{ $env_files['AWS_DEFAULT_REGION'] }}" autofocus name="AWS_DEFAULT_REGION" type="text" class="form-control" placeholder="Enter AWS Default Region"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="AWS_BUCKET">{{ __('AWSBucketName') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['AWS_BUCKET'] }}" autofocus name="AWS_BUCKET" type="text" class="form-control" placeholder="Enter AWS Bucket Name"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="AWS_URL">{{ __('AWSURL') }} <span class="text-danger">*</span></label>
                                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="eg:https://bucket-name.s3.Region.amazonaws.com/"></i>
                                        <input value="{{ $env_files['AWS_URL'] }}" autofocus name="AWS_URL" type="text" class="form-control" placeholder="Enter AWS URL eg:https://bucket-name.s3.Region.amazonaws.com/"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i>  eg: https://bucket-name.s3.Region.amazonaws.com/</small>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Omise" role="tabpanel" aria-labelledby="v-pills-Omise-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="enable_omise">{{ __('Omise Payment Setting') }}</label><br>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch9" name="enable_omise" {{ $gsetting->enable_omise == 1 ? 'checked' : '' }} />
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="OMISE_PUBLIC_KEY">{{ __('OMISE PUBLIC KEY') }}<sup
                                                class="redstar">*</sup></label>
                                        <input value="{{ env('OMISE_PUBLIC_KEY') }}" autofocus
                                            name="OMISE_PUBLIC_KEY" type="text" class="form-control"
                                            placeholder="Enter omise app public key" />
                                    </div>
                                </div>
                                

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="OMISE_SECRET_KEY">{{ __('Omise Secret Key') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('OMISE_SECRET_KEY') }}" autofocus
                                            name="OMISE_SECRET_KEY" type="text" class="form-control"
                                            placeholder="Enter omise secret key" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="OMISE_API_VERSION">{{ __('OMISE API VERSION') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('OMISE_API_VERSION') }}" autofocus
                                            name="OMISE_API_VERSION" type="text" class="form-control"
                                            placeholder="Enter omise api version" />
                                        <small class="text-info">
                                            • Check API VERSION <a
                                                href="https://dashboard.omise.co/api-version/edit">HERE</a>
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-PayUBiz" role="tabpanel" aria-labelledby="v-pills-PayUBiz-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="s_enable">{{ __('PayUBiz/Money Payment Setting') }}</label>
                                    </div>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch10" name="enable_payu" {{ $gsetting->enable_payu == 1 ? 'checked' : '' }} />
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYU_DEFAULT">{{ __('PAYU DEFAULT') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('PAYU_DEFAULT') }}" autofocus name="PAYU_DEFAULT"
                                            type="text" class="form-control" placeholder="Choose Payu Enviroment" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Choose')}}
                                            <b>"payubiz"</b> or <b>"payumoney"</b> option</small>
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYU_METHOD">{{ __('PAYU METHOD') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('PAYU_METHOD') }}" autofocus name="PAYU_METHOD"
                                            type="text" class="form-control"
                                            placeholder="Choose PAYU METHOD Enviroment" />

                                        <small class="text-info"><i class="fa fa-question-circle"></i>{{__(' For Test use')}}
                                            <b>"test"</b> {{__('and for Live use')}} <b>"secure"</b> {{__('method')}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYU_MERCHANT_KEY">{{ __('PAYU MERCHANT KEY') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('PAYU_MERCHANT_KEY') }}" autofocus
                                            name="PAYU_MERCHANT_KEY" type="text" class="form-control"
                                            placeholder="Enter PAYU MERCHANT KEY" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Enter Payu
                                            Merchant key.')}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYU_MERCHANT_SALT">{{ __('PAYU MERCHANT SALT') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('PAYU_MERCHANT_SALT') }}" autofocus
                                            name="PAYU_MERCHANT_SALT" type="text" class="form-control"
                                            placeholder="Enter PAYU MERCHANT SALT" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Enter Payu
                                            Merchant salt key.')}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYU_AUTH_HEADER">{{ __('PAYU AUTH HEADER') }}</label>
                                        <input value="{{ env('PAYU_AUTH_HEADER') }}" autofocus
                                            name="PAYU_AUTH_HEADER" type="text" class="form-control"
                                            placeholder="Enter PAYU AUTH HEADER" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i>{{__(' Required if
                                            method is')}} <b>{{__('Payumoney')}}</b></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="payu_money">{{ __('PayU Money Account ?') }} <span class="text-danger">*</span></label><br>
                                        <input type="checkbox" class="custom_toggle" id="customSwitch11" name="payu_money" {{ env('PAYU_MONEY_TRUE') == true ? 'checked' : '' }} />
                                        <input type="hidden" name="free" value="0" for="status" id="customSwitch11">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Moli" role="tabpanel" aria-labelledby="v-pills-Moli-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('Moli Payment Setting') }}</label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch12" name="enable_moli" {{ $gsetting->enable_moli == 1 ? 'checked' : '' }} />
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="MOLLIE_KEY">{{ __('MOLI API KEY') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('MOLLIE_KEY') }}" autofocus name="MOLLIE_KEY"
                                            type="text" class="form-control" placeholder="Enter Moli Api Key" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Enter Moli
                                            Api Key')}}</small>
                                        <br>
                                        <small class="text-info">
                                            <b>{{__('Supported Moli Currency')}}</b> : <a title="Moli Supported Currency List"
                                                href="https://docs.mollie.com/payments/multicurrency">https://docs.mollie.com/payments/multicurrency</a>
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Cashfree" role="tabpanel" aria-labelledby="v-pills-Cashfree-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('Cashfree Payment Setting') }}</label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch13" name="enable_cashfree" {{ $gsetting->enable_cashfree == 1 ? 'checked' : '' }} />
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="CASHFREE_APP_ID">{{ __('CASHFREE APP ID') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('CASHFREE_APP_ID') }}" autofocus name="CASHFREE_APP_ID"
                                            type="text" class="form-control" placeholder="Enter cashfree app id" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Please enter
                                            Cashfree')}} <b>{{__('APP ID<')}}</b></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="CASHFREE_SECRET_KEY">{{ __('CASHFREE SECRET KEY') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('CASHFREE_SECRET_KEY') }}" autofocus
                                            name="CASHFREE_SECRET_KEY" type="text" class="form-control"
                                            placeholder="Enter CASHFREE SECRET KEY " />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Please enter
                                            Cashfree')}} <b>{{__('Secret Key')}}</b></small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="CASHFREE_END_POINT">{{ __('CASHFREE END POINT') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('CASHFREE_END_POINT') }}" autofocus
                                            name="CASHFREE_END_POINT" type="text" class="form-control"
                                            placeholder="Enter Cashfree end point Url" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i>
                                            • For <b>Live</b> use : https://api.cashfree.com
                                            <b>|</b>
                                            • For <b>Test</b> use : https://test.cashfree.com
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Skrill" role="tabpanel" aria-labelledby="v-pills-Skrill-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('Skrill Payment Setting') }}</label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch14" name="enable_skrill" {{ $gsetting->enable_skrill == 1 ? 'checked' : '' }}  />
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="SKRILL_MERCHANT_EMAIL">{{ __('SKRILL MERCHANT EMAIL') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('SKRILL_MERCHANT_EMAIL') }}" autofocus
                                            name="SKRILL_MERCHANT_EMAIL" type="text" class="form-control"
                                            placeholder="Enter skrill merchant email" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> For
                                            <b>test</b> use <b>demoqco@sun-fish.com</b></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="SKRILL_API_PASSWORD">{{ __('SKRILL API PASSWORD') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('SKRILL_API_PASSWORD') }}" autofocus
                                            name="SKRILL_API_PASSWORD" type="text" class="form-control"
                                            placeholder="Enter skrill api password" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('For')}}
                                            <b>{{__('test')}}</b> {{__('use')}} <b>{{__('skrill')}}</b></small>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="SKRILL_LOGO_URL">{{ __('SKRILL APP LOGO URL') }}</label>
                                        <input value="{{ env('SKRILL_LOGO_URL') }}" autofocus name="SKRILL_LOGO_URL"
                                            type="url" class="form-control" placeholder="Enter app logo url" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i>{{__('Enter your
                                            site logo url here.')}}</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-FlutterRave" role="tabpanel" aria-labelledby="v-pills-FlutterRave-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="enable_rave">{{ __('FlutterRave Payment Setting') }}</label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch15" name="enable_rave" {{ $gsetting->enable_rave == 1 ? 'checked' : '' }}/>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAVE_PUBLIC_KEY">{{ __('RAVE PUBLIC KEY') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('RAVE_PUBLIC_KEY') }}" autofocus name="RAVE_PUBLIC_KEY"
                                            type="text" class="form-control"
                                            placeholder="Enter rave public email" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> Public Key:
                                            Your Rave publicKey. Sign up on <a
                                                href="https://rave.flutterwave.com/">https://rave.flutterwave.com/</a>
                                            to get one from your settings page</small>
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAVE_SECRET_KEY">{{ __('RAVE SECRET KEY') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('RAVE_SECRET_KEY') }}" autofocus name="RAVE_SECRET_KEY"
                                            type="text" class="form-control" placeholder="Enter rave secret key" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Secret Key:
                                            Your Rave secretKey. Sign up on')}} <a
                                                href="https://rave.flutterwave.com/">https://rave.flutterwave.com/</a>
                                           {{__(' to get one from your settings page')}}</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAVE_SECRET_HASH">{{ __('RAVE SECRET HASH') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('RAVE_SECRET_HASH') }}" autofocus name="RAVE_SECRET_HASH"
                                            type="text" class="form-control" placeholder="Enter rave secret hash" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('This is the secret hash for your webhook')}}</small>
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAVE_ENVIRONMENT">{{ __('RAVE ENVIRONMENT') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('RAVE_ENVIRONMENT') }}" autofocus
                                            name="RAVE_ENVIRONMENT" type="text" class="form-control"
                                            placeholder="Enter rave app enviroment" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Environment:')}}
                                            {{__('This can either be')}} <b>'{{__('staging')}}'</b> {{__('or')}} <b>{{__('live')}}</b></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAVE_PREFIX">{{ __('RAVE Transcation Prefix') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('RAVE_PREFIX') }}" autofocus name="RAVE_PREFIX"
                                            type="text" class="form-control"
                                            placeholder="Enter rave transcation prefix" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Prefix: This
                                            is added to the front of your')}} <b>{{__('Transaction reference
                                                numbers')}}</b>.</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAVE_COUNTRY">{{ __('RAVE country code') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('RAVE_COUNTRY') }}" autofocus name="RAVE_COUNTRY"
                                            type="text" class="form-control"
                                            placeholder="Enter rave country code" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Enter rave
                                            country code')}} <b>{{__('eg : IN')}}</b>.</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="RAVE_LOGO">{{ __('RAVE Buisness APP Logo') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('RAVE_LOGO') }}" autofocus name="RAVE_LOGO" type="text"
                                            class="form-control" placeholder="Enter rave app logo url" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Logo: Enter
                                            the')}} <b>{{__('URL')}}</b> {{__('of your company/business logo.')}}</small>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Payhere" role="tabpanel" aria-labelledby="v-pills-Payhere-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('Payhere Payment Setting') }}</label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch16" name="enable_payhere" {{ $gsetting->enable_payhere == 1 ? 'checked' : '' }}/>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYHERE_MERCHANT_ID">{{ __('PAYHERE MERCHANT ID') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('PAYHERE_MERCHANT_ID') }}" autofocus
                                            name="PAYHERE_MERCHANT_ID" type="text" class="form-control"
                                            placeholder="Enter payhere merchant id" />
                                        
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYHERE_BUISNESS_APP_CODE">{{ __('PAYHERE BUISNESS APP CODE') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('PAYHERE_BUISNESS_APP_CODE') }}" autofocus
                                            name="PAYHERE_BUISNESS_APP_CODE" type="text" class="form-control"
                                            placeholder="Enter payhere buisness app code" />
                                        
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYHERE_APP_SECRET">{{ __('PAYHERE APP SECRET') }}</label>
                                        <input value="{{ env('PAYHERE_APP_SECRET') }}" autofocus name="PAYHERE_APP_SECRET"
                                            type="text" class="form-control" placeholder="Enter app logo url" />
                                        
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYHERE_MODE">{{ __('PAYHERE MODE') }}</label>
                                        <input value="{{ env('PAYHERE_MODE') }}" autofocus name="PAYHERE_MODE"
                                            type="text" class="form-control" placeholder="Enter payhere mode" />
                                        <small class="text-info"><i class="fa fa-question-circle"></i> For Test use <b>"sandbox"</b> and for Live use <b>"live"</b></small>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Iyzipay" role="tabpanel" aria-labelledby="v-pills-Iyzipay-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('Iyzipay Payment Setting') }}</label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch17" name="iyzico_enable" {{ $gsetting->iyzico_enable == 1 ? 'checked' : '' }}/>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="IYZIPAY_BASE_URL">{{ __('IYZIPAY BASE URL') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('IYZIPAY_BASE_URL') }}" autofocus
                                            name="IYZIPAY_BASE_URL" type="text" class="form-control"
                                            placeholder="Enter Iyzipay base url" />

                                        <small class="text-info"><i class="fa fa-question-circle"></i> For Sandbox use <b>https://sandbox-api.iyzipay.com</b> <br>
                                        <i class="fa fa-question-circle"></i> For Live use <b>https://api.iyzipay.com</b></small>
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="IYZIPAY_API_KEY">{{ __('IYZIPAY API KEY') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('IYZIPAY_API_KEY') }}" autofocus
                                            name="IYZIPAY_API_KEY" type="text" class="form-control"
                                            placeholder="Enter iyzipay api key" />
                                        
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="IYZIPAY_SECRET_KEY">{{ __('IYZIPAY SECRET KEY') }}</label>
                                        <input value="{{ env('IYZIPAY_SECRET_KEY') }}" autofocus name="IYZIPAY_SECRET_KEY"
                                            type="text" class="form-control" placeholder="Enter Iyzipay secret key" />
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-SSLCommerze" role="tabpanel" aria-labelledby="v-pills-SSLCommerze-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('SSLCommerze Payment Setting') }}</label><br>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch18" name="ssl_enable" {{ $gsetting->ssl_enable == 1 ? 'checked' : '' }}/>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="API_DOMAIN_URL">{{ __('SSL API DOMAIN URL') }} <span class="text-danger">*</span></label>
                                        
                                        <input value="{{ env('API_DOMAIN_URL') }}" autofocus
                                            name="API_DOMAIN_URL" type="text" class="form-control"
                                            placeholder="Enter Iyzipay base url" />

                                        <small class="text-info"><i class="fa fa-question-circle"></i> For Sandbox use <b>https://sandbox.sslcommerz.com</b> <br>
                                        <i class="fa fa-question-circle"></i> For Live use <b>https://securepay.sslcommerz.com</b></small>
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark">Enable LOCALHOST:</label><br>
                                        <input type="checkbox" class="custom_toggle" id="customSwitch19" name="IS_LOCALHOST" {{ env('IS_LOCALHOST') == true ? "checked"  : "" }}/>
                                        <input type="hidden" name="free" value="0" for="status" id="customSwitch19"><br>
                                        <small class="text-info">(Enable it to when it's when sandbox mode is true.) </small>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="text-dark" for="">SANDBOX MODE:</label><br>
                                    <input type="checkbox" class="custom_toggle" id="customSwitch20" name="SANDBOX_MODE" {{ env('SANDBOX_MODE') == true ? "checked"  :"" }}/>
                                    <input type="hidden" name="free" value="0" for="status" id="customSwitch20"><br>
                                    <small class="text-info">(Enable or disable sandbox by toggle it.) </small>
                                </div>
                                            
                                <div class="col-md-6 form-group">
                                    <div class="form-group">
                                        <label class="text-dark" for="STORE_ID">{{ __('SSL STORE ID') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('STORE_ID') }}" autofocus name="STORE_ID" type="text" class="form-control" placeholder="Enter iyzipay api key" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="STORE_PASSWORD">{{ __('SSL STORE PASSWORD') }}</label>
                                        <input value="{{ env('STORE_PASSWORD') }}" autofocus name="STORE_PASSWORD"
                                            type="text" class="form-control" placeholder="Enter Iyzipay secret key" />
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Youtube" role="tabpanel" aria-labelledby="v-pills-Youtube-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('Youtube API Keys') }}</label><br>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch21" name="youtube_enable" {{ $gsetting->youtube_enable == 1 ? 'checked' : '' }}/>
                                </div>
                                    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="YOUTUBE_API_KEY">{{ __('Youtube API Keys') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('YOUTUBE_API_KEY') }}" autofocus
                                            name="YOUTUBE_API_KEY" type="text" class="form-control"
                                            placeholder="Enter Youtube Api Keys" />
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Vimeo" role="tabpanel" aria-labelledby="v-pills-Vimeo-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="s_enable">{{ __('Vimeo API Keys') }}</label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch22" name="vimeo_enable" {{ $gsetting->vimeo_enable == 1 ? 'checked' : '' }}/>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="VIMEO_CLIENT">{{ __('VIMEO_CLIENT') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('VIMEO_CLIENT') }}" autofocus
                                            name="VIMEO_CLIENT" type="text" class="form-control"
                                            placeholder="Enter vimeo client" />
                                        
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="VIMEO_SECRET">{{ __('VIMEO SECRET') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('VIMEO_SECRET') }}" autofocus
                                            name="VIMEO_SECRET" type="text" class="form-control"
                                            placeholder="Enter vimeo secret" />
                                        
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="VIMEO_ACCESS">{{ __('VIMEO ACCESS') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('VIMEO_ACCESS') }}" autofocus
                                            name="VIMEO_ACCESS" type="text" class="form-control"
                                            placeholder="Enter vimeo access key" />
                                        
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="v-pills-Aamar" role="tabpanel" aria-labelledby="v-pills-Aamar-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="aamarpay_enable">{{ __('Aamar Pay API Keys') }}</label>
                                </div>
                                
                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch23" name="aamarpay_enable" {{ $gsetting->aamarpay_enable == 1 ? 'checked' : '' }}/>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="AAMARPAY_STORE_ID">{{ __('AAMARPAY STORE ID') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('AAMARPAY_STORE_ID') }}" autofocus
                                            name="AAMARPAY_STORE_ID" type="text" class="form-control"
                                            placeholder="Enter Aamarpay store ID" />
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="AAMARPAY_KEY">{{ __('AAMARPAY SIGNATURE KEY') }} <span class="text-danger">*</span></label>
                                        <input value="{{ env('AAMARPAY_KEY') }}" autofocus
                                            name="AAMARPAY_KEY" type="text" class="form-control"
                                            placeholder="Enter Aamarpay key" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="aamar_pay">{{ __('AAMARPAY SANDBOX ?') }}</label><br>
                                        <input type="checkbox" class="custom_toggle" id="customSwitch24" name="AAMARPAY_SANDBOX" {{ env('AAMARPAY_SANDBOX') == true ? 'checked' : '' }}/>
                                        <input type="hidden" name="free" value="0" for="status" id="customSwitch24">
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-BrainTree" role="tabpanel" aria-labelledby="v-pills-BrainTree-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="braintree_enable">{{ __('BrainTree Payment') }} </label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch25" name="braintree_check" {{ $gsetting->braintree_enable==1 ? 'checked' : '' }}/>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="text-dark" for="pay_cid">{{__('BrainTree Env')}} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['BRAINTREE_ENV'] }}" autofocus name="BRAINTREE_ENV" type="text" class="form-control" placeholder="Enter BrainTree Env"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="text-dark" for="pay_sid">{{__('BrainTree Merchant ID')}} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['BRAINTREE_MERCHANT_ID'] }}" autofocus name="BRAINTREE_MERCHANT_ID" type="text" class="form-control" placeholder="Enter BrainTree Merchant ID"/>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                    <label class="text-dark" for="pay_mode">{{__('BrainTree Public Key')}} <span class="text-danger">*</span></label>
                                    <input value="{{ $env_files['BRAINTREE_PUBLIC_KEY'] }}" autofocus name="BRAINTREE_PUBLIC_KEY" type="text" class="form-control" placeholder="Enter BrainTree Public Key"/>
                                    </div>
                                </div>
                                    
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_mode">{{__('BrainTree Private Key')}} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['BRAINTREE_PRIVATE_KEY'] }}" autofocus name="BRAINTREE_PRIVATE_KEY" type="text" class="form-control" placeholder="Enter BrainTree Private Key"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Google" role="tabpanel" aria-labelledby="v-pills-Google-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="gtm_enable">{{ __('Google Tag Manager') }}</label>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch26" name="GOOGLE_TAG_MANAGER_ENABLED" {{ env('GOOGLE_TAG_MANAGER_ENABLED') == true ? 'checked' : '' }}/>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="text-dark" for="pay_cid">{{__('GOOGLE TAG MANAGER ID')}} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['GOOGLE_TAG_MANAGER_ID'] }}" autofocus name="GOOGLE_TAG_MANAGER_ID" type="text" class="form-control" placeholder="Enter GTM ID"/>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-Payflexi" role="tabpanel" aria-labelledby="v-pills-Payflexi-tab">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label class="text-dark" for="payflexi_enable">{{ __('Payflexi Payment') }}</label><br>
                                </div>

                                <div class="col-md-12 form-group">
                                    <input type="checkbox" class="custom_toggle" id="customSwitch27" name="payflexi_check" {{ $gsetting->payflexi_enable==1 ? 'checked' : '' }}/>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYFLEXI_KEY">{{ __('PayFlexiPublicKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYFLEXI_PUBLIC_KEY'] }}" autofocus name="PAYFLEXI_PUBLIC_KEY" type="text" class="form-control" placeholder="Enter PayFlexi Public Key"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> Public Key: Your PayFlexi publicKey. Sign up on <a href="https://merchant.payflexi.co/">https://merchant.payflexi.co/</a>to get one from your settings page</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYFLEXI_SECRET">{{ __('PayFlexiSecretKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYFLEXI_SECRET_KEY'] }}" autofocus name="PAYFLEXI_SECRET_KEY" type="text" class="form-control" placeholder="Enter PayFlexi Secret Key"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Secret Key: Your PayFlexi secretKey. Sign up on')}} <a href="https://merchant.payflexi.co/">https://merchant.payflexi.co/</a>to get one from your settings page</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYFLEXI_PAYMENT_GATEWAY">{{ __('PayFlexiSecretKey') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYFLEXI_PAYMENT_GATEWAY'] }}" autofocus name="PAYFLEXI_PAYMENT_GATEWAY" type="text" class="form-control" placeholder="Enter Supported PayFlexi Gateway"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Mode:This can either be')}} <b>{{__('stripe')}}</b> {{__('or')}} <b>{{__('paystack')}}</b>. {{__('We are adding more gateways soon')}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYFLEXI_MODE">{{ __('PayFlexiMode') }} <span class="text-danger">*</span></label>
                                        <input value="{{ $env_files['PAYFLEXI_MODE'] }}" autofocus name="PAYFLEXI_MODE" type="text" class="form-control" placeholder="Enter PayFlexi Mode"/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('Mode:This can either be ')}}<b>{{__('test')}}</b> {{__('or')}} <b>{{__('live')}}</b>. {{__('Add your keys based on the mode')}}</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYFLEXI_WEBHOOK_URL">{{ __('PayFlexiWebhookURL') }} <span class="text-danger">*</span></label>
                                        <input value="{{ route('payflexi.webhook') }}" autofocus type="text" class="form-control" placeholder="" disabled/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('use')}} <b>{{__('this webhook url in PayFlexi Merchant settings page')}}</b> </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-dark" for="PAYFLEXI_WEBHOOK_URL">{{ __('PayFlexiCallbackURL') }} <span class="text-danger">*</span></label>
                                        <input value="{{ route('payflexi.callback') }}" autofocus type="text" class="form-control" placeholder="" disabled/>
                                        <small class="text-info"><i class="fa fa-question-circle"></i> {{__('use')}} <b>{{__('this callback url in PayFlexi Merchant settings page')}}</b> </small>
                                    </div>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="reset" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i> {{ __("Reset")}}</button>
                                    <button type="submit" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                                    {{ __("Update")}}</button>
                                </div>

                                
                            </div>
                        </div>
                        @if(Module::has('Esewa') && Module::find('Esewa')->isEnabled())
				            @include('esewa::admin.api_settings')
				        @endif
                        @if(Module::has('Smanager') && Module::find('Smanager')->isEnabled())
                            @include('smanager::admin.api_settings')
                        @endif

                        @if(Module::has('Paytab') && Module::find('Paytab')->isEnabled())
                            @include('paytab::admin.api_settings')
                        @endif

                        @if(Module::has('DPOPayment') && Module::find('DPOPayment')->isEnabled())
                            @include('dpopayment::admin.api_settings')
                        @endif

                        @if(Module::has('AuthorizeNet') && Module::find('AuthorizeNet')->isEnabled())
                            @include('authorizenet::admin.api_settings')
                        @endif

                        @if(Module::has('Bkash') && Module::find('Bkash')->isEnabled())
                            @include('bkash::admin.api_settings')
                        @endif

                        @if(Module::has('Midtrains') && Module::find('Midtrains')->isEnabled())
                            @include('midtrains::admin.api_settings')
                        @endif

                        @if(Module::has('SquarePay') && Module::find('SquarePay')->isEnabled())
                            @include('squarepay::admin.api_settings')
                        @endif

                        @if(Module::has('Worldpay') && Module::find('Worldpay')->isEnabled())
                            @include('worldpay::admin.api_settings')
                        @endif
                        @if(Module::has('Onepay') && Module::find('Onepay')->isEnabled())
                        @include('onepay::admin.api_settings')
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
(function($) {
  "use strict";

  $(function(){

      $('#customSwitch1').change(function(){
        if($('#customSwitch1').is(':checked')){
        	$('#s_sec').show('fast');
        }else{
        	$('#s_sec').hide('fast');
        }

      });


      $('#customSwitch2').change(function(){
        if($('#customSwitch2').is(':checked')){
        	$('#pay_sec').show('fast');
        }else{
        	$('#pay_sec').hide('fast');
        }

      });
      $('#payu_sec1').change(function(){
        if($('#payu_sec1').is(':checked')){
        	$('#payu_sec').show('fast');
        }else{
        	$('#payu_sec').hide('fast');
        }

      });
      $('#customSwitch3').change(function(){
        if($('#customSwitch3').is(':checked')){
        	$('#insta_sec').show('fast');
        }else{
        	$('#insta_sec').hide('fast');
        }

      });

      $('#customSwitch25').change(function(){
        if($('#customSwitch25').is(':checked')){
        	$('#brain_sec').show('fast');
        }else{
        	$('#brain_sec').hide('fast');
        }

      });

      $('#customSwitch4').change(function(){
        if($('#customSwitch4').is(':checked')){
        	$('#razor_sec').show('fast');
        }else{
        	$('#razor_sec').hide('fast');
        }

      });

      $('#customSwitch5').change(function(){
        if($('#customSwitch5').is(':checked')){
        	$('#paystack_sec').show('fast');
        }else{
        	$('#paystack_sec').hide('fast');
        }

      });

      $('#customSwitch6').change(function(){
        if($('#customSwitch6').is(':checked')){
        	$('#paytm_sec').show('fast');
        }else{
        	$('#paytm_sec').hide('fast');
        }

      });

      $('#customSwitch7').change(function(){
        if($('#customSwitch7').is(':checked')){
        	$('#captcha_sec').show('fast');
        }else{
        	$('#captcha_sec').hide('fast');
        }

      });

      	$('#customSwitch8').change(function(){
	        if($('#customSwitch8').is(':checked')){
	        	$('#aws_sec').show('fast');
	        }else{
	        	$('#aws_sec').hide('fast');
	        }

	    });


      	$('#customSwitch9').change(function () {
            if ($('#customSwitch9').is(':checked')) {
                $('#omise_sec').show('fast');
            } else {
                $('#omise_sec').hide('fast');
            }

        });

       	$('#customSwitch10').change(function () {
            if ($('#customSwitch10').is(':checked')) {
                $('#payu_sec').show('fast');
            } else {
                $('#payu_sec').hide('fast');
            }

        });

        $('#customSwitch12').change(function () {
            if ($('#customSwitch12').is(':checked')) {
                $('#moli_sec').show('fast');
            } else {
                $('#moli_sec').hide('fast');
            }

        });

        $('#customSwitch13').change(function () {
            if ($('#customSwitch13').is(':checked')) {
                $('#cf_sec').show('fast');
            } else {
                $('#cf_sec').hide('fast');
            }

        });

        $('#customSwitch14').change(function () {
            if ($('#customSwitch14').is(':checked')) {
                $('#sk_sec').show('fast');
            } else {
                $('#sk_sec').hide('fast');
            }

        });

        $('#customSwitch15').change(function () {
            if ($('#customSwitch15').is(':checked')) {
                $('#rave_sec').show('fast');
            } else {
                $('#rave_sec').hide('fast');
            }
        });


        $('#customSwitch16').change(function () {
            if ($('#customSwitch16').is(':checked')) {
                $('#payhere_sec').show('fast');
            } else {
                $('#payhere_sec').hide('fast');
            }
        });


        $('#customSwitch17').change(function () {
            if ($('#customSwitch17').is(':checked')) {
                $('#iyzico_sec').show('fast');
            } else {
                $('#iyzico_sec').hide('fast');
            }
        });

        $('#customSwitch18').change(function () {
            if ($('#customSwitch18').is(':checked')) {
                $('#ssl_sec').show('fast');
            } else {
                $('#ssl_sec').hide('fast');
            }
        });


        $('#customSwitch21').change(function () {
            if ($('#customSwitch21').is(':checked')) {
                $('#youtube_sec').show('fast');
            } else {
                $('#youtube_sec').hide('fast');
            }
        });


        $('#customSwitch22').change(function () {
            if ($('#customSwitch22').is(':checked')) {
                $('#vimeo_sec').show('fast');
            } else {
                $('#vimeo_sec').hide('fast');
            }
        });

        $('#customSwitch23').change(function () {
            if ($('#customSwitch23').is(':checked')) {
                $('#aamarpay_sec').show('fast');
            } else {
                $('#aamarpay_sec').hide('fast');
            }
        });

        $('#customSwitch26').change(function () {
            if ($('#customSwitch26').is(':checked')) {
                $('#gtm_sec').show('fast');
            } else {
                $('#gtm_sec').hide('fast');
            }
        });


        $('#customSwitch27').change(function(){
	        if($('#customSwitch27').is(':checked')){
	        	$('#payflexi_sec').show('fast');
	        }else{
	        	$('#payflexi_sec').hide('fast');
	        }
	    });


  });

})(jQuery);

</script>


<script src="{{ Module::asset('esewa:js/esewa.js') }}"></script>

<script src="{{ Module::asset('smanager:js/smanager.js') }}"></script>

<script src="{{ Module::asset('paytab:js/paytab.js') }}"></script>

<script src="{{ Module::asset('dpopayment:js/dpopayment.js') }}"></script>

<script src="{{ Module::asset('authorizenet:js/authorizenet.js') }}"></script>

<script src="{{ Module::asset('bkash:js/bkash.js') }}"></script>

<script src="{{ Module::asset('midtrains:js/midtrains.js') }}"></script>

<script src="{{ Module::asset('squarepay:js/squarepay.js') }}"></script>

<script src="{{ Module::asset('worldpay:js/worldpay.js') }}"></script>
@endsection
<!-- This section will contain javacsript end -->