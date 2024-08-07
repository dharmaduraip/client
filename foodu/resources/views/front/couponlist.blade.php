@if(count($coupons) > 0)
<?php $currencySymbol = \AbserveHelpers::getCurrencySymbol();?>
<div class="">
<h5>AVAILABLE COUPONS</h5>
@foreach($coupons as $coupon)
    <?php if($coupon->promo_type == 'amount'){ $offValue = number_format((float)\AbserveHelpers::CurrencyValue($coupon->promo_amount));}
        if($coupon->min_order_value > 0) {$minOrderVal = number_format((float)\AbserveHelpers::CurrencyValue($coupon->min_order_value));}
        $promo_status = \AbserveHelpers::getPromoUserCheck($coupon->id,$authid);
    ?>
    @if($promo_status == 1)
    <?php 
    $orderCount = \AbserveHelpers::getPromoUserOrderCheck($coupon->id,$authid);
    ?>
        <div class="available_border">
            <div class="coupn_num">{!! $coupon->promo_name !!}</div>
            <b>Get @if($coupon->promo_type == 'amount') {!! $currencySymbol.$offValue !!} @else {!! $coupon->promo_amount !!}% @endif OFF</b>
            <p>{!! $coupon->promo_desc !!}</p>
            <div class="know_more">KNOW MORE</div>
            <ul class="more_coupn">
                @if(count($coupon->all_text_values) > 0)
                    @foreach($coupon->all_text_values as $text_Values)
                        <li>{!! $text_Values !!}</li>
                    @endforeach
                @endif
            </ul>
            @if($coupon->usage_count>0)
                @if($coupon->usage_count>$orderCount)
                    <button type="button" class="select_coupon" data-users="{!! $coupon->user_id !!}" data-coupon-id="{!! $coupon->id !!}">APPLY COUPON</button>
                @else
                <button type="button" class="disable">USAGE COUNT IS OVER</button>
                @endif
            @else
            <button type="button" class="select_coupon" data-users="{!! $coupon->user_id !!}" data-coupon-id="{!! $coupon->id !!}">APPLY COUPON</button>
            @endif
        </div>
    @endif
@endforeach
</div>
@endif

