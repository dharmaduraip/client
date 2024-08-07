@if(count($aUserCart) > 0)
	<?php 
		$wallet_used = $aUserCart[0]->wallet;
		$customer	= \App\User::find($aUserCart[0]->user_id);
		$customer_wallet = $customer->customer_wallet;
		if ($customer_wallet != '' && $customer_wallet != null && $customer_wallet > 0) {
			$wallet			= $customer_wallet;
			$wallet_remain	= $customer_wallet - $wallet_used;
		} else {
			$wallet			= 0;
			$wallet_used	= 0;
			$wallet_remain	= 0;
		}
	?> 
	<input type="hidden" value="{!! count($aUserCart) !!}" id="quan">
	<input type="hidden" value="{!! $itemcnt !!}" id="countitem">
	<section>
		<a href='{!! \URL::to("frontend/details/".$aRestaurant->id) !!}'>
			<div class="menu-cart-title">
				<div class="rest_img" style="background-image:url('{!! $aRestaurant->src !!}')"></div>
				<div class="rest_detail">
					<b>{!! $aRestaurant->name !!}</b>
					<div class="rest_city">{!! $aRestaurant->city !!}</div>
				</div>
			</div>
		</a>
		<?php //echo "<pre>"; print_r($aRestaurant); exit; ?>
		<div class="scroll_checkitem">
			<div class="menu-cart-body">
				<div class="cart-loader" style="display:none;"></div>
				@if($unavailableFoodIds != '')
					<span class="all_item_valid"><font color="red">Some of your orders not available now. Please change your order</font></span>
				@endif


				@foreach ($aUserCart as $ky => $val)
					<div class="menu-cart-items" id="item_{!! $val->food_id !!}_{!! $val->adon_id !!}">
						<div class="{{-- @if($val->food_item_info->status=='Non_veg') rsquare @else square @endif --}}"></div>
						<div class="item_naem">
							<p class="veg-item">{!! $val->food_item !!}</p>
						</div>
						@if(isset($val->food_item_info->availability['status']) == 1)
							<?php 
								$afid = $val->food_id; $deleteclass = ''; 
								if($val->adon_id>0)
									$afid.='_'.$val->adon_id;
							?>
							<div class="block-item text-center items_count" id="fnitem_{!! $afid !!}">
								<span class="count_in_dec remove_cart_item" data-faid="{!! $val->food_id !!}" data-aid="{!! $val->adon_id !!}" data-type="{!! $val->adon_type !!}">-</span>
								<span id="afid_{!! $afid !!}" class="item-count afid_{!! $afid !!}">{!! $val->quantity !!}</span>
								<span class="count_in_dec add_cart_item" data-faid="{!! $val->food_id !!}" data-aid="{!! $val->adon_id !!}" data-type="{!! $val->adon_type !!}">+</span>
							</div>
						@else
							<?php $deleteclass = 'item_delete'; ?>
							<div class="block-item text-center no-pad unavail_item"><span>Unavailable</span></div>
						@endif
						<div class="block-item text-right '.$deleteclass.'">
							@if($val->strike_price > 0)									 				
							<span class="strike-price" style="color:red;"><strike>{!!  $currsymbol.number_format(($val->strike_price * $val->quantity),2,'.','')  !!}</strike></span>
							@endif
							{!! $currsymbol !!}<span class="item-price">{!! number_format(($val->price * $val->quantity),2,'.','') !!}</span><br>
							@if(isset($val->food_item_info->availability['status']) != 1)
								<span class="delete_item" data-cart-id="{!! $val->id !!}"><i class="fas fa-trash-alt"></i></span>
							@endif
						</div>
					</div>
				@endforeach
				<div class="posrelative">
					<i class="fas fa-quote-left"></i>
					<textarea maxlength="150" class="suggestion" placeholder="Any suggestions? We will pass it on..." id="order_note"></textarea>
				</div>
			</div>
			<div class="menu-cart-footer">

				@if(isset($wallet) && $wallet != '' && $wallet != 0)
				<div class="flex_block">
					<div class="flex_block_1">Use Wallet: [You Have {!! $currsymbol !!} {!! number_format($wallet_remain,2,'.','') !!}]
					</div>
				</div>
				<div class="flex_block">
					<div class="input-group mb-3">
						<div class="input-group-btn">
							<button class="btn btn-outline-secondary" type="button" id="cancelWallet">Cancel</button>
						</div>
						<input type="text" class="form-control" placeholder="Enter Amount to Apply" id="walletAmount" value="{{$wallet_used}}" min="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
						<div class="input-group-btn">
							<button class="btn btn-outline-secondary" type="button" id="applicableWallet">Apply</button>
						</div>
					</div>
				</div>
				<span class="errorWallet" style="color: red;display: none;"></span>
				<br/>
				@endif
               
				@if($promoamount > 0)
					<div class="remove_promo"><div class="coupn_detail"><div class="text-uppercase">{!! $promoInfo->promo_name !!}</div><span>Offer applied on the bill</span></div><span class="remove_coupon">REMOVE</span></div>
				@else
				
					@if($aRestaurant->promo_status)
						<div class="apply_coupn" data-res="{!! $aRestaurant->id !!}"><i class="fas fa-ticket-alt"></i> Apply Coupon </div>
					@else
						{{-- <div class="coupn_box">
							<input type="text" placeholder="Enter coupon code" class="coupon_input">
							<input type="submit" class="apply_coupn_code" data-user="" data-coupon-id="" value="APPLY">
						</div> --}}
					@endif
					<div class="coupon_error" style="display: none;"><font color="red">Cart value is not sufficient</font></div>
					<div class="coupon_response" style="color: red;"></div>
				@endif

				<div class="flex_block"><div class="flex_block_1">Item Total : </div><div class="text-right" >{!! $currsymbol.' '.$itemOriginalPrice!!}</div></div>
				@if($itemOfferPrice > 0)
					<div class="flex_block" style="color:#60b246;">
						<div class="flex_block_1">Offers Discount :<span class="posrelative"></span></div>
						<div class="text-right">{!! '-'.$currsymbol.' '.$itemOfferPrice !!}</div>
					</div>
				@endif
				@if($stax1 > 0)
					<div class="flex_block">
						<div class="flex_block_1">Service Tax (%) :</div>
						<div class="text-right">{!! $currsymbol.' '.$stax1 !!}</div>
					</div>
				@endif
				@if($gst > 0)
				 <div class="flex_block">
					<div class="flex_block_1">GST And Restaurant Charges :</div>
					<div class="text-right">{!! $currsymbol.' '.$gst !!}</div>
				</div> 
				@endif
				@if(isset($grozoOffer) && $grozoOffer != '' && $grozoOffer != 0)
				<div class="flex_block" style="color:#60b246;">
					<div class="flex_block_1">{!! $OfferName !!} Discount : <span class="posrelative">
					<i class="fas fa-info-circle delivery_btn" aria-hidden="true"></i><span class="delivery_content">Remains {!! $currsymbol !!} {!! number_format((\Auth::user()->offer_wallet - $grozoOffer),2) !!}</span></span></div>
					<div class="text-right">{!! '-'.$currsymbol !!} {!! number_format($grozoOffer,2,'.','') !!}
					</div>
				</div>
				@endif
				@if(isset($wallet_used) && $wallet_used != null && $wallet_used != 0)
				<div class="flex_block" style="color:#60b246;">
					<div class="flex_block_1">Used Wallet: <span class="posrelative">
					<i class="fas fa-info-circle delivery_btn" aria-hidden="true"></i><span class="delivery_content">Remains {!! $currsymbol !!} {!! number_format($wallet_remain,2) !!}</span><!--<span style="color:red;">( - )</span>--></span>
					</div><div class="text-right">{!! '-'.$currsymbol !!} {!! number_format($wallet_used,2) !!}</div>
				</div>
				@endif

				<div class="flex_block">
					<div class="flex_block_1">Delivery Fees {{-- (Incl.{!! $aDelCharges['del_charge_tax_percent'] !!}% GST) --}} : <span class="posrelative"> 
						<i class="fas fa-info-circle delivery_btn" aria-hidden="true"></i><span class="delivery_content">Base delivery charges applicable on shop to help us serve you better</span></span>
					</div>
					<div class="text-right">{!! $currsymbol.' '.number_format(($aDelCharges['delivery']),2) !!}</div>
				</div>
				@if(isset($aDelCharges['delivery_charge_discount']) > 0)
					{{-- <div class="flex_block">
						<div class="flex_block_1">Delivery chargediscount :</div>
						<div class="text-right">{!! '-'.$currsymbol.' '.$aDelCharges['delivery_charge_discount'] !!}</div>
					</div> --}}
				@endif
				@if($aDelCharges['deliveryTax'] > 0)
					<div class="flex_block">
						<div class="flex_block_1">Delivery Charge Tax : </div>
						<div class="text-right">{!! $currsymbol.' '.number_format(($aDelCharges['deliveryTax']),2) !!}</div>
					</div>
				@endif
				@if($aDelCharges['package'] > 0)
					<div class="flex_block">
						<div class="flex_block_1">Packaging Charge (Incl. GST) : </div>
						<div class="text-right">{!! $currsymbol.' '.($aDelCharges['package'] + $aDelCharges['packageTax']) !!}</div>
					</div>
				@endif
				@if($aDelCharges['badWeather'] > 0)
					<div class="flex_block">
						<div class="flex_block_1">Bad Weather Charge (Incl. GST) : </div>
						<div class="text-right">{!! $currsymbol.' '.($aDelCharges['badWeather'] + $aDelCharges['badWeatherTax']) !!}</div>
					</div>
				@endif
				@if($aDelCharges['festival'] > 0)
					<div class="flex_block">
						<div class="flex_block_1">Festival Charge (Incl. GST) : </div>
						<div class="text-right">{!! $currsymbol.' '.($aDelCharges['festival'] + $aDelCharges['festivalTax']) !!}</div>
					</div>
				@endif
				@if($promoamount > 0)
					<div class="flex_block" style="color:#60b246;">
						<div class="flex_block_1">Coupons Discount :<span class="posrelative"></span></div>	
						<div class="text-right">{!! '-'.$currsymbol.' '.$promoamount !!}</div>
					</div>
				@endif
			</div>
		</div>
		<div class="final-total">
			TO PAY: <span class="pull-right show_tot_amount">{!! $currsymbol !!} <span class="grand_total checkout_payment"> {!! number_format(($grandTotal - $grozoOffer),2) !!}</span></span>
		</div>
	</section>
	{{-- if($savedPrice > 0)
	<div class="total_offer">You have saved {!! $currsymbol.' '.$savedPrice !!} on the bill</div>
	endif --}}
	<?php
		// $offers	= \App\Models\Front\Offers::find(1); 
		// $date = date('Y-m-d');
		// $date =date('Y-m-d', strtotime($date));
		// $begindate = date('Y-m-d', strtotime("02/19/2022"));
		// $enddate = date('Y-m-d', strtotime("03/08/2022"));
	?>
	{{-- if((!empty($offers) && $offers->status == 'active'))
	if(($date >= $begindate) && ($date <= $enddate))
	<div class="mega_offer text-center"><a href="javascript::void();" data-bs-toggle="modal" data-bs-target="#megaoffers" style="cursor: pointer;">View Offer details</a></div>
	endif
	<div id="megaoffers" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<iframe src="{!! URL('/').'/megaoffer?appview=1' !!}" style="width:91%;"></iframe>
				</div>
			</div>
		</div>
	</div>
	endif --}}
@endif

