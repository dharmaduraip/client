<style>
    body.modal-open {
        overflow: visible;
    }
</style>
<div class="available_coupons col-xs-12 no_pad">
    @php 
    $authid = \Auth::id();
    $currencySymbol = \AbserveHelpers::getCurrencySymbol();
    @endphp
    @if(count($allcoupons) > 0)
        <div class="smallHeading">Available Coupons</div>
        <div class="row flex_wrap">
            @foreach($allcoupons as $acoupon)
            <?php 
            if($acoupon->promo_type == 'amount'){ $offValue = number_format((float)\AbserveHelpers::CurrencyValue($acoupon->promo_amount));}
                if($acoupon->min_order_value > 0) {$minOrderVal = number_format((float)\AbserveHelpers::CurrencyValue($acoupon->min_order_value));}
                $promo_status = \AbserveHelpers::getPromoUserCheck($acoupon->id,$authid);
            ?>
            @if($promo_status == 0)
            <?php 
            $orderCount = \AbserveHelpers::getPromoUserOrderCheck($acoupon->id,$authid);
            ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="available_coupns available_border">
                        <div class="coupn_num">{!! $acoupon->promo_name !!}</div>
                        <b>Get @if($acoupon->promo_type == 'amount') {!! $currencySymbol.$offValue !!} @else {!! $acoupon->promo_amount !!}% @endif OFF</b>
                        <p>{!! $acoupon->promo_desc !!}</p>
                        <div class="know_more" data-toggle="modal" data-target="#know_more_{!! $acoupon->id !!}">KNOW MORE</div>
                        <div class="know_more_{!! $acoupon->id !!}"></div>
                        <button type="button" class="theme_border_btn copy_code" data-coupon-id="{!! $acoupon->id !!}">Copy Code</button>
                        <input type="text" style="position: absolute; left: -999em;" id="code_{!! $acoupon->id !!}" value="{!! $acoupon->promo_code !!}" aria-hidden="true">
                    </div>
                
                <div id="know_more_{!! $acoupon->id !!}" class="modal fade" role="dialog" data-backdrop=''>
                  <div class="modal-dialog modal-coupn">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="close"><span>&times;</span></button>
                        <div class="available_border">
                            <div class="coupn_num">{!! $acoupon->promo_name !!}</div>
                            <b>Get @if($acoupon->promo_type == 'amount') {!! $currencySymbol.$offValue !!} @else {!! $acoupon->promo_amount !!}% @endif OFF</b>
                            <p>{!!  $acoupon->promo_desc !!}</p>
                            <ul class="more_coupn">
                                @if($acoupon->min_order_value > 0)
                                    <li>Minimum Order Value is {!! $currencySymbol.$minOrderVal !!}</li>
                                @endif
                                <li>Valid on all payment methods.  </li>
                                <li>Offer valid till {!! date('M d,Y',strtotime($acoupon->end_date)) !!}</li>
                                <li> @if($acoupon->usage_count>1) {!!$acoupon->usage_count!!} time Valid @else Valid Once @endif per User</li>
                                @if($orderCount>0)
                                <li>Already {!!$orderCount!!} Time(s) used</li>
                                @endif
                            </ul>
                            <button type="button" class="theme_border_btn copy_code" data-coupon-id="{!! $acoupon->id !!}">Copy Code</button>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                </div>
            @endif
            @endforeach
             @else
            <div class="item-list">
                <div class="col-sm-12 no-padding text-center no-address">
                    <img src="{{ url('sximo5/images/themes/images/sales.png') }}">
                    <h3>No offers available</h3>
                   
                </div>
            </div>
        </div>
    @endif
</div>
<div class="available_coupons col-xs-12 no_pad"> 
 @if(count($userCoupon) > 0)
        <div class="smallHeading">Coupons For you</div>
        <div class="row flex_wrap">
            @foreach($userCoupon as $ucoupon)
                <?php 
                if($ucoupon->promo_type == 'amount'){ $offValue = number_format((float)\AbserveHelpers::CurrencyValue($ucoupon->promo_amount));}
                    if($ucoupon->min_order_value > 0) {$minOrderVal = number_format((float)\AbserveHelpers::CurrencyValue($ucoupon->min_order_value));}
                    $promo_status = \AbserveHelpers::getPromoUserCheck($ucoupon->id,$authid);
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="available_coupns available_border">
                        <div class="coupn_num">{!! $ucoupon->promo_name !!}</div>
                        <b>Get @if($ucoupon->promo_type == 'amount') {!! $currencySymbol.$offValue !!} @else {!! $ucoupon->promo_amount !!}% @endif OFF</b>
                        <p>{!!  $ucoupon->promo_desc !!}</p>
                        <div class="know_more" data-toggle="modal" data-target="#know_more_{!! $ucoupon->id !!}">KNOW MORE</div>
                        <button type="button" class="theme_border_btn copy_code" data-coupon-id="{!! $ucoupon->id !!}">Copy Code</button>
                        <input type="text" style="position: absolute; left: -999em;" id="code_{!! $ucoupon->id !!}" value="{!! $ucoupon->promo_code !!}" aria-hidden="true">
                    </div>
                <div id="know_more_{!! $ucoupon->id !!}" class="modal fade" role="dialog" data-backdrop=''>
                  <div class="modal-dialog modal-coupn">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="available_border">
                            <div class="coupn_num">{!! $ucoupon->promo_name !!}</div>
                            <b>Get @if($ucoupon->promo_type == 'amount') {!! $currencySymbol.$offValue !!} @else {!! $ucoupon->promo_amount !!}% @endif OFF</b>
                            <p>{!!  $ucoupon->promo_desc !!}</p>
                            <ul class="more_coupn">
                                @if($ucoupon->min_order_value > 0)
                                    <li>Minimum Order Value is {!! $currencySymbol.$minOrderVal !!}</li>
                                @endif
                                <li>Valid on all payment methods.  </li>
                                <li>Offer valid till {!! date('M d,Y',strtotime($ucoupon->end_date)) !!}</li>
                                <li>Valid Once per User</li>
                            </ul>
                            <button type="button" class="theme_border_btn copy_code" data-coupon-id="{!! $ucoupon->id !!}" >Copy Code</button>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                </div>
            @endforeach
        </div>
 @endif
</div> 
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.12/clipboard.min.js" async></script>
<script type="text/javascript">
    $(document).on('click',".copy_code",function(){
        var cid = $(this).data('coupon-id');
        var copyText = document.getElementById("code_"+cid);
        copyText.select();
        document.execCommand("copy");
        $('.available_coupons').not($(this).closest('.col-md-6').find('.theme_border_btn')).find('.theme_border_btn').text('Copy Code');
        $(this).closest('.col-md-6').find('.theme_border_btn').text('Copied');
    })
</script>    