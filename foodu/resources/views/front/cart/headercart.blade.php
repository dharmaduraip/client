@if(!empty($resInfo) && $resTime == 1 && !empty($foods_items))
<section class="header_cart">
	<div class="h_cart_rdetail">
		<div class="h_cart_img" style="background-image:url({!! $resInfo->logo !!});"></div>
		<div class="h_cart_rest">{!! $resInfo->name !!}</div>
		<div class="h_cart_city">{!! $resInfo->city !!}</div>
		@if(\Auth::check())
			<a href='{!! \URL::to('/details/'.$resInfo->id) !!}'>VIEW FULL MENU</a>
		@endif
		<div class="menu-cart-body">
			@php $item_total = 0; @endphp
			@foreach ($foods_items as $ky => $val)
			<div class="flex_block" id="item_{!! $val->food_id !!}">
				<div class="flex_block_1"><div class="green_square"></div>{!! $val->food_item !!}</div>
				<div class="text-right">{!! $currsymbol !!} <span class="item-price">{!! round(($val->quantity * $val->price),2) !!}</span>
				</div>
			</div>
			@php
			$item_total	+= ($val->quantity * $val->price);
			$cash_offer	= (!empty($offer)) ? $item_total * ( $offer->usage_value / 100) : 0;
			$cash_back	= ($item_total > $cash_offer || $item_total == $cash_offer) ? $cash_offer : 0; 
			@endphp
			@endforeach
		</div>
		@if ($cash_back != 0)
			<span class="flex_block" > Cash back offer amount :
				<div class="text-right"> {!! $currsymbol !!}
					<span class="grand_total">{!! $cash_back !!}
				</span>
			</div>
			</span>
		@endif
		<div class="menu-cart-footer">
			<div class="final-total">
				<h5><span class="sub_total">Sub total:</span>
					<span class="pull-right">{!! $currsymbol !!} 
						<span class="grand_total">{!! round($item_total,2) !!}</span>
					</span>
				</h5>
				<div class="extra_charge">Extra charges may apply</div>
				@if($resInfo->minimum_order > 0 && $resInfo->minimum_order > $item_total)
				@php $Bcolor = ($resInfo->minimum_order <= $item_total) ? "green" : "#b55a5a"; @endphp
				<div style="text-align: center;font-weight: bold;color: #FFF;font-size: 17px;background-color:{!! $Bcolor !!};padding:10px"  class="extra_charge">Minimum order value is {!! $currsymbol !!} {!! $resInfo->minimum_order !!}
				</div>
				@endif
			</div>
			@if(Auth::check())
				@if($resInfo->minimum_order>=0 && $resInfo->minimum_order<=$item_total)
				<a href="{{ URL::to('/checkout') }}"><button class='btn-checkout' id='btn-checkout' >Checkout</button></a>
				@else
				<button class='btn-checkout disabled' id='btn-checkout' >Checkout</button>
				@endif
			@else
				<button class="btn-checkout loginhomeslide" id="btn-checkout" >Checkout</button>
			@endif
		</div>
	</div>
</section>
@else
<section>
	<div class="menu-cart-title"></div>
	<div class="menu-cart-empty" >
		<div class="cart_empy">Cart is empty</div>
	</div>
</section>
@endif