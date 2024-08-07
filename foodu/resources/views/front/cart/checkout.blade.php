@extends('layouts.default.index')
@push('css')
<style type="text/css">
	body
	{
		background-color: #f6f6f6;
	}
	.cartsectionclas{
		content:"";
		/*background: url(<?php //echo URL::to(); ?>/'.CNF_THEME.'/images/lodingsmall.gif) no-repeat center center;*/
		opacity: 0.5;
		pointer-events: none;
		/*z-index:999;*/
	}
	.cartsectioncla{
		pointer-events: none;
	}
	.menu-cart-body{position:relative;}
	.cart-loader{
		background: url(<?php echo URL::to(''); ?>/'.CNF_THEME.'/images/lodi.gif) no-repeat center center;
		background-size: 100px 100px;
		/*opacity: 0.5;*/
		pointer-events: none;
		z-index:999;
		width: 100%;
		float: left;
		display: block;
		height: 100%;
		position: absolute;
		top: 0%;
		background-color: rgba(255, 255, 255, 0.5411764705882353);
	}
	.mol_overlay {position: fixed;top: 0px;bottom: 0px;left: 0px;right: 0px;background: rgba(255,255,255,0.7);z-index: 999;display:none;}
	#snackbar {
		visibility: hidden;
		min-width: 250px;
		margin-left: -125px;
		background-color: #DC143C;
		color: #fff;
		text-align: center;
		border-radius: 2px;
		padding: 20px;
		position: fixed;
		z-index: 1;
		left: 50%;
		bottom: 430px;
		font-size: 20px;
	}

	#snackbar.show {
		visibility: visible;
		-webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
		animation: fadein 0.5s, fadeout 0.5s 2.5s;
	}
	@-webkit-keyframes fadein {
		from {top: 0; opacity: 0;} 
		to {top: 250px; opacity: 1;}
	}

	/*@keyframes fadein {
	from {bottom: 0; opacity: 0;}
	to {bottom: 30px; opacity: 1;}
	}*/

	@-webkit-keyframes fadeout {
		from {top: : 0; opacity: 1;} 
		to {top: 250px; opacity: 0;}
	}
</style>
@endpush
@section('content')
<div id="snackbar" style="display: none"></div>
<div class="cart_overlay" style="display: none"><span class="theme_loader">Updating Cart...</span></div>
<div class="mol_overlay" style="display: none"><span class="theme_loader load_process_text">Processing...</span></div>
<div class="checkout-page">
	@if($uCartCnt > 0)
	<div class="container">
		<div class="row ">
			<div class="col-md-8 col-sm-8 col-xs-12 pad_l_35">
				@if($restimevalid == 1 && $itemtimevalid == 1)
				@php
				$dstat	= explode(',', $resInfo->deliver_status);
				@endphp
				@if( (PICKDEL_OPTION == 'enable' && count($dstat) > 1) || (PREORDER_OPTION=="enable"))
				<div id="delivery_preference" class="checkout_box">
					<span class="border_connect"></span>
					<div class="checkout_icon active"><i class="fas fa-star"></i></div>
					<h4>Select your Preference</h4>
					<div class="btn-group" data-toggle="buttons">
						@if(count($dstat) > 1)
						@if(in_array('pickup', $dstat))
						<label class="btn btn-default otpstat @if($cartInfo->ordertype == 'pickup') active @endif" data-id="otpp" id="OrderTypePickup">
							<input type="radio" id="otpp" name="ordertype" value="pickup" class="otrequired" hidden ><i class="fa fa-shopping-bag" aria-hidden="true"></i> Pickup
						</label>
						@endif
						@if(in_array('deliver', $dstat))
						<label class="btn btn-default otpstat @if($cartInfo->ordertype == 'delivery') active @endif" data-id="otpd" id="OrderTypeDelivery">
							<input type="radio" id="otpd" name="ordertype" value="deliver" class="otrequired" hidden> <i class="fa fa-truck" aria-hidden="true"></i> Delivery
						</label>
						@endif
						@else
						<label class="btn btn-default otpstat active" data-id="otpd" id="OrderTypeDelivery" style="display: none;">
							<input type="radio" id="otpd" checked name="ordertype" value="deliver" class="otrequired" hidden> <i class="fa fa-truck" aria-hidden="true"></i> Delivery
						</label>
						@endif
					</div>
					<div class="btn" data-toggle="buttons">
						@if($resInfo->preorder != 'yes')
						<label class="btn btn-default @if($cartInfo->delivertype == 'asap' || $cartInfo->delivertype=='') active @endif ordertime_stat"  id="ordertime_asap">
							<input type="radio" checked id="asap" name="ordertime_stat" value="asap" hidden><i class="fa fa-shopping-bag" aria-hidden="true"></i> ASAP
						</label>
						@endif
						<label class="btn btn-default ordertime_stat second @if($cartInfo->delivertype == 'later') active @endif"  id="ordertime_later">
							<input type="radio" id="later" name="ordertime_stat" value="later" hidden><i class="fa fa-shopping-bag" aria-hidden="true"></i> Later
						</label>
					</div> 
					<div class="deliverDateTime px-3" @if($cartInfo->delivertype == 'later') style="display: block;" @else style="display: none;" @endif >
						<div class="d-flex">
							<div class="form-group d-flex align-items-center me-3 ">
								<label>Order date</label>
								<input class="deliver_date form-control ms-3 w-auto" autocomplete="off" type="text" name="choosedate" id="deliver_date" @if($cartInfo->delivertype == 'later') value="{!! date('m/d/yy',strtotime($cartInfo->deliverdate)) !!}" @endif placeholder="choose delivery date" readonly>
							</div>
							<div class="form-group d-inline-block">
								<select class="form-control deliverTime" name="deliver_time" id="later_deliver_time">
									<option value="time">time</option>
								</select>
							</div>
						</div>
					</div>
					@if($cartInfo->delivertype == 'later' && $cartInfo->deliverdate!='') 
					<script type="text/javascript">
						$(document).ready(function() {
						show_later_time_onload();
						});
					</script>
					@endif
				</div>
				@else
				<label class="btn btn-default otpstat active" data-id="otpd" id="OrderTypeDelivery" style="display: none;">
					<input type="radio" id="otpd" checked name="ordertype" value="deliver" class="otrequired"> <i class="fa fa-truck" aria-hidden="true"></i> Delivery
				</label>
				<label class="btn btn-default ordertime_stat"  id="ordertime_asap"  style="display: none;">
					<input type="radio" checked id="asap" name="ordertime_stat" value="asap"><i class="fa fa-shopping-bag" aria-hidden="true"></i> ASAP
				</label>
				@endif
				<div id="delivery_add_block" class="checkout_box  @if(isset($cartInfo) && !empty($cartInfo)) @if(isset($selAddress) && !empty($selAddress))delivery_added @endif @endif">
					<input type="hidden" id="restaurant_id" value="{!! $resInfo->id !!}">
					<span class="border_connect"></span>
					<div class="checkout_icon active"><i class="fas fa-map-pin"></i></div>
					<div class="delivery_add" @if(!empty($cartInfo)) @if(isset($selAddress) && !empty($selAddress)) style="display:block;" @else style="display:none;" @endif @endif >
						<h4>
							Delivery address
							<div class="chage_add">Change</div>
						</h4>
						@if(!empty($selAddress))
						<div class="selected_address">
							<b class="selected_address_type">{!! (!empty($selAddress)) ? $selAddress->address_type_text : '' !!}</b>
							<address class="selected_address_adrs">@if($selAddress->building != ''){!! $selAddress->building.',' !!}@endif @if($selAddress->landmark != ''){!! $selAddress->landmark.',' !!}@endif {!! $selAddress->address !!}</address>
							<b class="selected_address_time">{!! $selAddress->duration !!}</b>
						</div>
						@endif
					</div>
					<div class="delivery_address" @if(isset($cartInfo) && !empty($cartInfo)) @if(isset($selAddress) && !empty($selAddress)) style="display:none;" @else style="display:block;" @endif @endif>
						<h4>Select delivery address</h4>
						<p>You have a saved address in this location</p>
						<div class="row deliver_adrs_append">
							@if(isset($address) && !empty($address))
							@foreach($address as $addr)
							<div class="col-md-6 col-sm-6 col-xs-12 listing_address">
								<div class="delivery_new_box plain_border" id="plain_border_{!! $addr->id !!}" data-id="{!! $addr->id !!}" for="list_address_{{$addr->id}}">
									<b class="address_list_type">{{$addr->address_type_text}}</b>
									<address class="address_list_adress">@if($addr->building !=''){!! $addr->building.',' !!}@endif @if($addr->landmark !=''){{ $addr->landmark.',' }}@endif {{$addr->address}}</address>
									<div class="green_box">Deliver Here</div>
									<input id="list_address_{{$addr->id}}" class="hid_adrs_id" type="radio" name="address" value="{{$addr->id}}" style="display: none;">
								</div>
							</div>
							@endforeach
							@endif 
							<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="delivery_new_box dot_border fn_map_modal">
									<b>Add new Address</b>
									<address>{!! $resInfo->location !!}</address>
									<div class=" green_box green_bbox">ADD NEW</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="checkout_box">
					<div class="checkout_icon payment_check"><i class="fas fa-briefcase"></i></div>
					<div class="payment_unselect">Payment </div>
					<div class="choose_payment" style="display:block;">
						<h4>Choose payment method</h4>
						@if (session('status'))
						<div class="alert alert-danger">
							{{ session('status') }}
						</div>
						@endif
						<div class="payment_method1">
							<input id="mol_address_id" class="address_id" name="address_id" type="hidden" value="{!! $selAddressId !!}">
							@if(number_format($payable_amount - $grozoOffer,2,'.','') > 0) 
							<div class="">
								<div class="paypal_block">
									<h5>Online Payment</h5>
									<div id="rzp-button1" class="form-check col-xs-12 col-sm-12 no-pad online-payment text-center" style="background-color: #b93538;margin-bottom: 50px;cursor: pointer;border-radius: 10px;">
										<!-- <img src="{{ asset('sximo5/images/themes/images/razorpay.png')}}"> -->
										<img src="https://cdn.razorpay.com/logo_invert.svg">
										<div class="row justify-content-center" style="margin-top:10px">
											<i class="far fa-credit-card"></i>
											<i class="fab fa-cc-mastercard"></i>
											<i class="fab fa-cc-visa"></i>
											<i class="fab fa-cc-stripe"></i>
											<i class="fab fa-cc-paypal"></i>
										</div>
									</div>
								</div>
								<div class="cash_ondelivery">
									<h5>Cash on Delivery</h5>
									<input name="mol_order_note" id="mol_order_note" name="order_note" type="hidden" class="orer_notes">
									@if(RAPIDO_ACTION == false)
									<button type="button" class="btn-green mol_submit"> <i class="fas fa-rupee-sign"></i>Cash on Delivery</button>
									@endif
								</div> 
							</div>
							@else 
							<div class="cash_ondelivery">
								<h5>Place your order</h5>
								<button type="button" class="btn-green mol_submit"> <i class="fas fa-rupee-sign"></i>Place your order</button> 
							</div>
							@endif
						</div>
					</div>
				</div>
				@else
				<div class="checkbox checkout_box">
					@if($restimevalid != 1)
					<div color="red"> {!! $resInfo->name !!} is not available now. Please search for some other shops </div>
					<a href="{!! URL::to('/') !!}">Go To Home Page </a>
					@else
					<div color="red"> Some of your orders not available now. Please change your order...  </div>
					<a href="{!! URL::to('details/'.$resInfo->id) !!}">Go To Shop Page </a>
					@endif
				</div>
				@endif
			</div>
			<div class="col-md-4 col-sm-4 col-xs-12 cart_items">
				@php
				$aCartPriceInfo = \AbserveHelpers::getCheckoutcartprice(\Auth::id(),$resInfo->id);
				@endphp
				@include('front.cart.checkoutcart',[extract($aCartPriceInfo)])
			</div>
		</div>
		<input type="hidden" id="pickOption" value="{!! PICKDEL_OPTION !!}">
        <input type="hidden" id="delivrP" value="">
        <input type="hidden" id="delivrT" value="asap">
		<input type="hidden" name="latitude" id="lat" value="">
		<input type="hidden" name="longitude" id="lang" value="">
		<input type="hidden" name="addr" id="addr" value="">
		<input type="hidden" value="{!! $resInfo->id !!}" id="res_id" name="res_id" />
	</div>
	@else
	<div class="empycart_page container text-center">
		<img src="{!! asset('sximo5/images/themes/images/cartempty.png') !!}">
		<div class="empy_cart">{!! trans('core.abs_empy_cart') !!}</div>
		<p>{!! trans('core.abs_empy_restaurants') !!}</p>
		<a href="{!! \URL::to('') !!}">{!! trans('core.abs_seenear_restaurants') !!}</a>
	</div>
	@endif
</div>
<div class="right-popup coupn_popup">
	<div class="signpading">
		<section class="fixed_search">
			<div class="closebutton sign_search">
				<i class="closefilter closeicon2"></i><span class="filter"></span>
			</div>
			<div class="coupn_box">
				<input type="text" placeholder="Enter coupon code" class="coupon_input">
				<input type="submit" class="apply_coupn_code" data-user="" data-coupon-id="" value="APPLY">
			</div>
			<div class="coupon_error" style="display: none;"><font color="red">Cart value is not sufficient</font></div>
			<div class="coupon_response"></div>
		</section>
		<div class="available_coupn">
			<div class="small_loader" style="display: none;"></div>
		</div>
	</div>
</div>
<div class="overlay-timer"></div>
<div id="timer" class="modal">
	<div class="modal-dialog modal-dialog-scrollable" role="document">
		<div class="modal-content">
			<div class="modal-body">
			</div>
		</div>
	</div>
</div>
<div id="map_modal" class="left-menu">
	<div class="closebtn">
		<i class="closefilter closeicon2"></i><span>Save delivery address</span>
	</div>
	<form role="form" action="" method="post" id="address_form">
		<div class="cart_overlay_save_address" style="display: none;"><span class="theme_loader">Updating Cart...</span></div>
		<div class="">

			<div class="step1">
				<div id="myaddrMap"></div><br/>
			</div>
			<div class="step2">
				<div class="no-pad" ng-show="vm.newAddressStep == '2'">
					<div class="col-xs-12 no_pad">
						<div class="address_values">
							<div class="input_group active" >
								<input class="input_box"  id="location" name="location"  value="{!! (!empty($resInfo)) ? $resInfo->location : '' !!}">
								<label class="floating-label" id="log_email" for="mobile">{!! Lang::get("core.address_details") !!}</label>
							</div>
							<div class="alert_fn"></div>
						</div>
						<div class="save_more_add">
							<div class="input_group" style="border-bottom-width: 1px !important;">
								<input class="input_box" name="building"  value="" id="building" >
								<label class="floating-label">E.g. House /Flat / Block No :</label>
							</div>
							<div class="input_group">
								<input class="input_box" name="landmark" id="landmark" >
								<label class="floating-label">{!! Lang::get("core.add_landmark") !!}</label>
							</div>
							<div class="group save_adrs">
								<input class="hide" type="radio" name="address_type" id="address_type_1" checked="" value="1" hidden>
								<label class="annotation" for="address_type_1">
									<i class="fa fa-home"></i>{!! Lang::get("core.home") !!}
									<span class="checkmark"></span>
								</label>
								<input class="hide" type="radio" name="address_type" id="address_type_2"  value="2" hidden>
								<label class="annotation" for="address_type_2">
									<i class="fa fa-briefcase "></i>{!! Lang::get("core.work") !!}
									<span class="checkmark"></span>
								</label>
								<input class="hide" type="radio" name="address_type" id="address_type_3"  value="3" hidden>
								<label class="annotation" for="address_type_3">
									<i class="fa fa-book"></i>{!! Lang::get("core.others") !!}
									<span class="checkmark"></span>
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="a_lat" id="a_lat" value="{{ (!empty($resInfo)) ? $resInfo->latitude : ''}}">
			<input type="hidden" name="a_lang" id="a_lang" value="{{ (!empty($resInfo)) ? $resInfo->longitude : ''}}">
			<input type="hidden" name="a_addr" id="a_addr" value="{{ (!empty($resInfo)) ? $resInfo->location : ''}}">
			<input type="hidden" name="a_res_id" id="a_res_id" value="{!!  (!empty($resInfo)) ? $resInfo->id : '' !!}">
		</div>
		<button type="submit" class="save_address go_to_step" >{!! Lang::get("core.save_address") !!}</button>
	</form>
</div>
@php
	$keys = \AbserveHelpers::site_setting('googlemap_key');
@endphp
@endsection
@push('scripts')
	<script src="//code.jquery.com/jquery-1.12.4.js"></script>
	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.min.js" integrity="sha512-8vfyGnaOX2EeMypNMptU+MwwK206Jk1I/tMQV4NkhOz+W8glENoMhGyU6n/6VgQUhQcJH8NqQgHhMtZjJJBv3A==" crossorigin="anonymous"></script>
	<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
	<script src="{!! asset('sximo5/js/front/checkout.js') !!}"></script>
	{{-- <script src="https://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key={!! $keys->googlemap_key !!}"></script> --}}
	  <script src="{{ asset('sximo5/js/plugins/jquery.validate.min.js')}}"></script> 
	<script type="text/javascript">
		document.getElementById('rzp-button1').onclick = function(e){ 
			$('.loader_event').show();
			$.ajax({
				url : base_url+"payment/catpaywithrazor",
				type : 'post',
				data : { },
				dataType : 'json',
				success : function(res){ 
					$('.loader_event').hide();
					var options = {
						"key": res.key,
						"amount": res.amount, 
						"name": res.name,
						"description": res.description,
						"image": res.image,
						"order_id":res.orderid,
						"handler": function (response){
							PlaceOrder(response.razorpay_payment_id,response.razorpay_order_id);
						},
						"prefill": {
							"name": res.prefill_name,
							"email": res.email,
							'contact' : res.phone_number
						},
						"notes": {
							"address": res.address
						},
						"theme": {
							"color": res.color
						}
					};
					var rzp1 = new Razorpay(options);
					rzp1.open();
					e.preventDefault();
				}
			})
		}
		function showhide(adrs_valid,order_valid) {
			var adrs_valid  = adressCheck();
			if(adrs_valid == 'true'){
				$('.payment_unselect').hide();
				$('.choose_payment').show();
			} else{
				$('.payment_unselect').show();
				$('.choose_payment').hide();
			}
			return true;
		}
		function adressCheck(){
			var adrs_valid = 'true';
			var adrs_id = $('.address_id').val();
			if(adrs_id == 0 || adrs_id == undefined){
				adrs_valid = 'false';
			}
			return adrs_valid;
		}
		function PlaceOrder(payment_id,orderid){
			// $('.loader_event').show(); 
			var res_id = $("#res_id").val();
			var mol_address_id = $("#mol_address_id").val();
			var mol_order_note = $("#mol_order_note").val();
			var dType   = $('#delivrT').val();
			var type="razorpay"; 
			var otp               = $('#delivrP').val();
			var l_date            = ($("#deliver_date").val() != '') ? $("#deliver_date").val() : '';
			var l_time            = ($("#later_deliver_time").val() != '') ? $("#later_deliver_time").val() : '';
			if(otp == 'otpd') {
				ordertype = 'deliver';
			} else if (otp == 'otpp') {
				ordertype = 'pickup';
			} else {
				ordertype = 'deliver';
			} 
			$(".mol_overlay").show();
			$.ajax({
				url : base_url+"payment/catrazorhandler",
				data : {'razorpay_payment_id' : payment_id,res_id : res_id,mol_address_id : mol_address_id,mol_order_note : mol_order_note,type : type,Rorderid:orderid,Rorderid:orderid, deliver_status : ordertype,l_date:'',l_time:'',type:dType  },
				type : 'post',
				dataType : 'json',
				success : function(result) {                                
					if(result.msg == 'success') {
						$('#orderid_key').val(result.orderId);
						$(".mol_overlay").hide();
						$('#timer .modal-body').html(result.modalContent);
				var url = base_url+'trackorder/'+btoa(result.orderId);
                window.history.pushState("", "", url);
                location.reload();  
						start_timer();
						// window.location.href = base_url+'payment/thankyouorder';
					} else if(result.msg == 'fail'){
						alert(result.error_msg);
					} else{
						location.reload();
					}
				}
			});
		}
		$(document).ready(function (e) {
			var access_token	= '{{ (!empty($access_token)) ? $access_token : '' }}';
			var totamount		= "PAY "+$(".show_tot_amount").text();
			$(".pay_amount").val(totamount);
			var tamount			= $(".grand_total").text();
			$('.avenue').val(parseFloat(tamount).toFixed(2));
			$(document).on("change",'.user_address .right .checkbox input',function(){
				if ($(this).is(":checked")) 
				{
					$(".user_address .desktop").removeClass("active_mode")
					$(this).closest('.user_address .desktop').addClass("active_mode");
				}
			})
			var resvalid = {!! (!empty($restimevalid)) ? $restimevalid : '' !!};
			var itemvalid = {!! (!empty($itemtimevalid)) ? $itemtimevalid : '' !!};
			resvalid = parseInt(resvalid);
			itemvalid = parseInt(itemvalid);
			if(resvalid == 1 && itemvalid == 1)
				showhide();
			$('input[type=radio][name=pay_via]').change(function() {

				if (this.value == 'paypal') {

					$('.paypal_selection').show();
					$('.credit_selection').hide();
					$('.cash_on_deliv').hide();


				}
				else if (this.value == 'credit') {

					$('.paypal_selection').hide();
					$('.credit_selection').show();
					$('.cash_on_deliv').hide();

				}else{

					$('.cash_on_deliv').show();
					$('.paypal_selection').hide();
					$('.credit_selection').hide(); 


				}

			});
		});
		$('.coupn_popup .signpading').scroll(function(){
			scroll = $('.coupn_popup .signpading').scrollTop();
			if (scroll > 20){
				$('.signpading').addClass('box_shadow');
			}
			else{
				$('.signpading').removeClass('box_shadow');
			}
		});
		$(".fn_map_modal").click(function(){
			getLocation_pos();
			setTimeout(function(){ resizingMap() }, 1000);
			$("#building").val('');
			$("#landmark").val('');
			$("input:radio[name='address_type']").each(function(e){
				this.checked = false;
			})
			$("#map_modal").addClass("left-active");
			$('.overlay').show();
		});
		$(".address_values input").keyup(function()
		{
			var v = $(this).val();
			if(v != '')
			{
				$(this).next().addClass('still');
			}
			else
			{
				$(this).next().removeClass('still');
			}
		});
		function initialize(){
			var map;
			var marker;
			var myLatlng = new google.maps.LatLng($('#a_lat').val(),$('#a_lang').val());
			var geocoder = new google.maps.Geocoder();
			var infowindow = new google.maps.InfoWindow();
			var mapOptions = {
				zoom: 15,
				center: new google.maps.LatLng($('#a_lat').val(),$('#a_lang').val()),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};

			map = new google.maps.Map(document.getElementById("myaddrMap"), mapOptions);

			marker = new google.maps.Marker({
				map: map,
				position: new google.maps.LatLng($('#a_lat').val(),$('#a_lang').val()),
				draggable: true 
			});     

			geocoder.geocode({'latLng': myLatlng }, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						$('#a_addr').val(results[0].formatted_address);
						$('#a_lat').val(marker.getPosition().lat());
						$('#a_lang').val(marker.getPosition().lng());
						infowindow.setContent(results[0].formatted_address);
						infowindow.open(map, marker);
					}
				}
			});


			google.maps.event.addListener(marker, 'dragend', function() {

				geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						if (results[0]) {
							$('#a_addr').val(results[0].formatted_address);
							$('#a_lat').val(marker.getPosition().lat());
							$('#a_lang').val(marker.getPosition().lng());
							infowindow.setContent(results[0].formatted_address);
							infowindow.open(map, marker);
							address_check();
						}
					}
				});
			});
			google.maps.event.addListener(map, 'click', function (event) {
				placeMarker(event.latLng);
				geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						if (results[0]) {
							$('#a_addr').val(results[0].formatted_address);
							$('#a_lat').val(marker.getPosition().lat());
							$('#a_lang').val(marker.getPosition().lng());
							infowindow.setContent(results[0].formatted_address);
							infowindow.open(map, marker);
							address_check();
						}
					}
				});
			});
		}
		google.maps.event.addDomListener(window, "resize", resizingMap());
		var input = document.getElementById('location');
		var placeVal = $("#location").val();
		var options = {
			componentRestrictions: {country: 'ca'},
			types: ['(regions)'],
		};
		var autocomplete = new google.maps.places.Autocomplete(document.getElementById('location'));
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place   = autocomplete.getPlace();
			var latitude  = place.geometry.location.lat();
			var longitude = place.geometry.location.lng();
			$('#a_lat').val(latitude);
			$('#a_lang').val(longitude);
			$('#a_addr').val(place.formatted_address);
			initialize()
			address_check();

		});
		function resizeMap() {
			if(typeof map =="undefined") return;
			setTimeout( function(){resizingMap();} , 400);
		}
		function resizingMap() {
			if(typeof map =="undefined") return;
			var center = new google.maps.LatLng($('#lat').val(),$('#lang').val());
			google.maps.event.trigger(map, "resize");
			map.setCenter(center); 
		}
		function placeMarker(location) {
			if (marker == undefined){
				marker = new google.maps.Marker({
					position: location,
					map: map, 
					animation: google.maps.Animation.DROP,
				});
			} else {
				marker.setPosition(location);
			}
			map.setCenter(location);
		}
		function address_check(){
			var addr = $('#a_addr').val();
			var from = $('#addr').val();
			var lat = $('#a_lat').val();
			var res_id = $("#res_id").val();
			var lang = $('#a_lang').val();
			$(".go_to_step").removeAttr("disabled");
			$("#location").val(addr);
			$(".alert_fn").html('');
		}
		function saveMapToDataUrl(addr,lat,lang) {
			<?php $keys = \AbserveHelpers::site_setting('googlemap_key'); ?>
			var dataUrl = " https://maps.googleapis.com/maps/api/staticmap?center="+lat+","+lang+"&zoom=13&size=400x400&markers=color:blue%7Clabel:S%7C11211%7C11206%7C11222&key=<?= $keys->googlemap_key ?>";
			$(".static-map").html('<img src="' + dataUrl + '"/>');
		}
		$("#address_form").validate({
			ignore:'',
			rules:
			{
				building:
				{
					required: false,

				},
				landmark:
				{
					required: false,

				},
				address_type:
				{
					required: false,

				}
			},

			messages:
			{
				building:
				{
					required: '{!! Lang::get("core.enter_building") !!}',
				},
				landmark:
				{
					required: '{!! Lang::get("core.enter_landmark") !!}'
				},
				address_type:
				{
					required: '{!! Lang::get("core.enter_address") !!}'
				}
			},                  
			submitHandler: function(form) {
				var purl = "{{ URL::to('/')}}/checkneareraddress";
				$('.cart_overlay_save_address').show();
				var dType   = $('#delivrT').val();
				var dDate   = $('#deliver_date').val();
				var dTime   = ($('#later_deliver_time').val() ==  '' || $('#later_deliver_time').val() == undefined) ? $(".deliver_time").val() : $('#later_deliver_time').val();
				var mol_orderid = $("#mol_orderid").val();
				var ordertype = $('#orderType').val();
				$.ajax({
					url: purl,
					type: 'post',
					data:  $('#address_form').serialize()+"&deliverType="+dType+"&deliverDate="+dDate+"&deliverTime="+dTime+"&address_id=0"+"&res_id="+$("#res_id").val()+"&ordertype="+ordertype+"&mol_orderid="+mol_orderid,
					dataType : 'json',
					success: function(data) {
						$('.cart_overlay_save_address').hide();
						if(data.msg == 'success'){
							$(".alert_fn").html('');
							$("#map_modal").removeClass("left-active");
							$('.overlay').hide();
							$(".left-menu").removeClass('left-active');
							$(".overlay").hide();
							$(".deliver_adrs_append").prepend(data.html);
							// $("#plain_border_"+data.address_id).trigger('click');
							$('.delivery_add').show();
							$('.delivery_address').hide();
							$('.payment_unselect').show();
							$('.choose_payment').hide();
							$('.delivery_add address').html($(this).find('address').html());
							$('#delivery_add_block').addClass('delivery_added');
							$('.checkout_icon').addClass('active');
							if(ordertype != 'pickup') {
								$('.address_id').val(data.address_id);
							}
							$('#mol_amount').val(data.mol_amount);
							$('#mol_vcode').val(data.mol_vcode);
							if(data.selhtml != 'blank'){
								$(".selected_address").html(data.selhtml);
							}
							$(".cart_items").html(data.cart);
							showhide();
						} else {
							$(".go_to_step").attr("disabled",'disabled');
							var alert = '<div class="clearfix"></div><div class="sorry_alert">{!! Lang::get("core.far_address_reataurent") !!}</div>';
							$('.alert_fn').html(alert);
						}

					}            
				});
			},
			errorPlacement: function(error, element)
			{
				error.insertAfter(element.parent());
			}
		});
	</script>
@endpush