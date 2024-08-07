@extends('layouts.default.index')
@section('css')
<style type="text/css">
    .list-group .list-group-item{border:none;font-size: 16px;}
    .list-group .list-group-item:hover{background-color:#edf1f7;color:#000;font-weight:bold;font-size: 16px;}
    .bhoechie-tab .bhoechie-tab-content:not(.active) {display: none;}
    
    .account_details .editProfile.change_pwd {margin: 15px 0px;max-width: 450px;}
    .bdr_none {border: 0 !important;}
    .account_details .editProfile {display: flex;flex-direction: column;width: 100%;max-width: 350px;}
    .account_details .editProfile a {text-align: right;}
    .account_details .editProfile .new-editprofile {border: 1px solid #979494;margin-bottom: 20px;width: 100%;max-width: 350px;display: inline-block;}
    .editProfile.change_pwd > form {padding: 10px 5px;}
    .nopadding {padding: 0px !important;}
    .list-group-item{background: transparent;border-width: 0 0 1px;font-size: 12px;}
    .account_details .mainthemeOrange, .account_details a.mainthemeOrange:hover {color: #f5861f;}
    .account_details .largeHeading {font-size: 18px;padding: 3px 0;margin-bottom: 20px;}
    /*.account_details .editProfile {border: 1px solid #979494;margin-bottom: 20px;width: 100%;max-width: 350px;display: inline-block;}*/
    .account_details .profileField:nth-child(2){border-bottom: 1px solid #979494;}
    .account_details .profileField {padding: 10px;vertical-align: middle;margin: 0;overflow: hidden;}


    .account_details .profileField dd {
        /*margin-left: 60px;*/
        float: none;
        font-size: 13px;
        color: #9A9A9A;text-align:center;
    }
    .account_details .profileField .editLink {
        margin-left: 50px;
        font-size: 11px;
        line-height: normal;
        padding-top: 2px;
        display: inline-block;
        float: right;
        text-transform: uppercase;
        color: #767676;
    }
    /*.account_details .profileField:first-child {
        border-bottom: 1px solid #979494;
    }*/
    .account_details .profileField {
        padding: 10px;
        vertical-align: middle;
        margin: 0;
        overflow: hidden;
    }
    .account_details .profileField dt {
        float: left;
        font-weight: normal;
        /*font-size: 11px;*/
    }
    .fileinput {
        margin-bottom: 9px;
        display: inline-block;
    }
    .fileinput .btn {
        white-space: normal;
    }
    .upload_pro_pic input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        right: 0px;
        bottom: 0px;
        opacity: 0;
    }
    .fileinput {
        margin-bottom: 9px;
        display: inline-block;
    }
    .profile_img {
        width: 100%;
        max-width: 120px;
        height: 120px;
        object-fit: cover;
        margin-bottom: 20px;
    }
    .account_details .mainthemeOrange, .account_details a.mainthemeOrange:hover {
        color: #F26F5F;
    }
    .account_details .largeHeading {
        font-size: 20px;
        padding: 3px 0;
        margin-bottom: 20px;
    }
    div.bhoechie-tab-menu div.list-group>a {
        margin-bottom: 0;
        padding: 20px 15px;
    }
    .password_action input, .password_action a {
        margin-bottom: 15px;
    }
    .password_action {
        padding: 0 10px;
    }
    .form-control {
        background-color: #FFF;
        border: 1px solid #ccc;
        border-radius: 0;
        box-shadow: 0px 1px 1px rgba(0, 0, 0, 0.075);
        color: #444;
        display: block;
        height: 44px;
        padding: 10px 12px;
        width: 100%;
    }
    .account_details .editProfile.change_pwd .form-control {
        border-width: 0 0 1px;
        box-shadow: none;
    }
    .account_details table {
        border: 1px solid #dfdfdf;
        margin: 20px 0px;
    }
    .account_details table th {
        color: #F26F5F;
        font-weight: normal;
        padding: 12px 8px;
        background: #f6f6f6;
    }
    .account_details table td, .account_details table th {
        border-bottom: 1px solid #dfdfdf;
        padding: 10px;
        font-size: 12px;
        border-left: 1px solid #dfdfdf;
    }
    .user_address span.addr-line {
        font-weight: normal;
        font-size: 14px;
        word-break: break-all;
    }
    .modal-backdrop.in {
        opacity: .0;
    }
    #rating_popup{
        margin-top: 0px;
    }
</style>
@endsection
@section('content')
<div class="user_dashboard">
    <div class="container">
        <!-- @if(Session::has('message'))
        {!! Session::get('message') !!}
        @endif
        <ul class="parsley-error-list">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul> -->
        <div class="alert_fn alert_fn1"></div>
        <div class="user_detl col-xs-12">
                <div class="name-edit-prof">{!! \Auth::user()->username !!}</div>
                <div class="number-email-prof">{!! \Auth::user()->phone_number !!}<span>{!! \Auth::user()->email !!}</span></div>
                <div class="no_pad text-lg-end">
                <div class="number-email-prof"><b>Your available wallet amount : {{ \Session::get('currency_symbol') }} {!! \Auth::user()->customer_wallet !!}</b></div>
            </div>
            <!-- <div class="col-md-4 col-sm-12 col-xs-12 no_pad">
                <div class="btn btn-normal btn-edit-prof">Edit profile</div>
            </div> -->
        </div>
    </div>
    <div class="container_1300">
        <div class="bhoechie-tab-container">
            @include('front.profile.profiletabs')
            <div class="col-md-9 col-sm-12 col-12 bhoechie-tab">
                <div class="bhoechie-tab-content active nopadding">
                    @if($segment == 'profile')
                    @include('front/profile/profile')
                    @elseif($segment == 'changepass')
                    @include('front/profile/security')
                    @elseif($segment == 'orders')
                    @include('front/profile/myorders')
                    @elseif($segment == 'offers')
                    @include('front/profile/offers')
                    @elseif($segment == 'favourites')
                    @include('front/profile/favourites')
                    @elseif($segment == 'payments')
                    @include('front/profile/payments')
                    @elseif($segment == 'offer-wallet')
                    @include('front/profile/offerwallet')
                    @elseif($segment == 'manage_addresses')
                    @include('front/profile/myaddress')
                     
                    
                    
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in clear" tabindex="-1" role="dialog" id="switch_cart" >
              <div class="modal-dialog modal-md">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-danger" id="myModalLabel">{!! Lang::get('core.clear_cart') !!}?</h4>
                  </div>
                  <div class="modal-body text-center">
                    <p>{!! Lang::get('core.start_refresh') !!}</p>
                    <input type="hidden" name="order_id" id="order_id" value="">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn  btn red" data-bs-dismiss="modal">{!!'No'!!}</button>
                    <button type="button" class="btn  btn-primary add_new_cart_item" data-check="removecart">{!! Lang::get('core.start_refresh_yes') !!}</button>
                  </div>
                </div>
              </div>
            </div>

<div class="modal fade" id="orderModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content order-content">
        
      </div>
    </div>
  </div>
  <div id="refundModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cancel Order</h4>
        </div>
        <div class="modal-body">
          
        </div>
    </div>

    </div>
  </div>

<!-- Modal popup for top-up form -->
<div id="topup-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Top-Up Wallet</h5>
                <button type="button" class="btn close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Top-up form -->
                <form action="" method="POST" id="payment-form">
                    @csrf
                    <input type="number" name="amount" id="amount-input" min="0" class="w-100 mb-3" required placeholder="Enter Top-Up Amount" />
                    <button type="submit" id="rzp-button" class="btn btn-primary">Proceed</button>
                </form>

                <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                <script>
                      $(document).ready(function() {
                        var r_id = '<?php echo RAZORPAY_API_KEYID; ?>';
                        var user_email = '<?php echo Auth::user()->email; ?>';
                        var user_name  = '<?php echo Auth::user()->username; ?>';
                        $('#amount-input').on('input', function() {
                            var newAmount = parseInt($(this).val()) * 100; 
                            $('script[data-amount]').attr('data-amount', newAmount.toString());
                        });
                        $('#payment-form').submit(function(event) {
                            event.preventDefault();
                            var options = {
                                key: r_id,
                                amount: parseInt($('#amount-input').val()) * 100,
                                currency: 'INR',
                                name: user_name,
                                description: '',
                                prefill: {
                                    name: user_name,
                                    email: user_email
                                },
                                theme: {
                                    color: '#F44A4A'
                                },
                                "handler": function (response){
                                     topupwallet(response);
                                 },
                            };
                            var rzp = new Razorpay(options);
                            rzp.open();
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>       
    

@endsection
<div id="rating_popup" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm modal-sm-ex modal-xl">
         <div class="modal-content col-xs-12 nopadding" style="position: relative;">
                <button type="button" class="close" data-bs-dismiss="modal" style="width: 30px;height: 30px;position: absolute;right: 10px;top: 13px;">&times;</button>
            <div class="modal-header text-center">
                <h4>Order Rating</h4>
            </div>
            <div class="modal-body col-xs-12">
                <center class="rating_section">

                <div class="col-md-6 col-sm-6 col-xs-12">

                    <div id="empty_message" style="display: none;"><font color="red">{!! trans('core.abs_select_rating') !!}</font></div>
                    <div class="rest_img" style=""></div>
                    <div><a class="res_link" href="javascript:void(0);"><span class="popup_res_name">Restront name</span></a></div>
                    <div class="star-rating rating_content" id="restrating"></div>
                    <div><textarea id="restcomment" rows="3" placeholder="Please type your comments"></textarea></div>
                </div>  
                </center>
                <center class="rating_section1">
                   <div class="col-md-6 col-sm-6 col-xs-12">

                    <div id="empty_message" style="display: none;"><font color="red">{!! trans('core.abs_select_rating') !!}</font></div>
                    <div class="boy_img" style=""></div>
                    <div><span class="">Delivery Boy</span></div>
                    <div class="star1-rating1 rating_content1" id="boyrating"></div>
                    <div><textarea id="boycomment" rows="3" placeholder="Please type your comments"></textarea></div>
                </div>   
            </center>
              <center class="rating_section rating_btn">
                    <div class="col-xs-12">           
                        <input type="hidden" id="rat_boy_id" value="">           
                        <input type="hidden" id="rat_res_id"  value="">
                        <input type="hidden" id="rat_order_id" value="">
                        <button type="button" class="close" data-bs-dismiss="modal">Not Now</button>
                        <input type="button" id="rating_submit" class="btn btn-primary label-success pull-right"  placeholder="{{trans('core.msg_type_here')}}" value="Submit" onclick="sendrating();">
                    </div>
                </center> 
            </div>
         </div>
        </div>
      </div>
@push('scripts')
<script src="{{ URL::to('sximo5/js/plugins/jquery.validate.min.js')}}"></script> 
@endpush