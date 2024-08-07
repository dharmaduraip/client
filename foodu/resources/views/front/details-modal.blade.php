@php
$first_unit='';
$unit_price=$foodDetails->price;
@endphp
@if($foodDetails->unit_detail)
@php
$first_unit=$foodDetails->unit_detail[0]['id'];
$unit_price=$foodDetails->unit_detail[0]['price'];
@endphp
@endif
<style>
	.add_dec_option{
		cursor: pointer;
	    background-color: #a1a1a11c;
	    border-radius: 50%;
	    height: 30px;
	    width: 30px;
	    color: #f65a60;
	    line-height: 30px !important;
	    font-weight: 400;
	    text-align: center;
	    display: inline-block;
	    /*margin: 0px 10px 0px 0px*/
	}
</style>
<div class="modal-header d-block"> 
	<h5 class="modal-title" id="exampleModalLabel">
		<span class="foodname font-opensans">{{$foodDetails['food_item']}}</span>
		<div class="d-flex justify-content-between">
			<div class="itembuttn d-flex" id="fnitem_<?php echo $foodDetails['id']; ?>">
				<span class="add_dec_option  font-montserrat me-2" data-fid="{{$foodDetails['id']}}" data-type="more_details" data-isad="1">-</span>
				<h5 class="item-count font-montserrat afid_{{$foodDetails['id']}} unit_{{$foodDetails['id']}} my-auto"  id="afid_{{$foodDetails['id']}}" data-id="{{$foodDetails['id']}}" data-acprice="{{$foodDetails['id']}}">1</h5>
				<span data-fid="{{$foodDetails['id']}}" class="add_dec_option adding_item font-montserrat ms-2" data-isad="1" data-id="{{$foodDetails['id']}}" data-type="more_details">+</span>
			</div>
			<div class="text-theme price_s">
				&#8377;<span id="unitprice{{$foodDetails['id']}}" class="font-montserrat unitprice">{{$unit_price}}</span>
			</div>
		</div>
	</h5>

	<button type="button" class="close datatime{{$foodDetails['id']}}" data-bs-dismiss="modal" aria-label="Close" data-unit="{{$first_unit}}" data-id="{{$foodDetails['id']}}" data-myval="">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body">
	<form action="" data-pric="{{$unit_price}}" class="resrt ids{{$foodDetails->id}}">
		@php
		$first_unit='';
		@endphp
		@if($foodDetails->unit_detail)

		@php
		$first_unit=$foodDetails->unit_detail[0]['id'];
		@endphp
		
		<div class="addon-sec over-hid @if(count($foodDetails->unit_detail) <= 1) d-none @endif">
			<div class="modalbody-head">
				<h5 class="text-black font-opensans font-weight-bold">Units</h5>
			</div>
			<div class="cont" style="line-height: 2;">
				<ul class="over-hid ord-mod">
					@foreach($foodDetails->unit_detail as $ke => $unit_val)
					<li>
						<div class="float-left">
							<div class=" custom-checkbox">
								<label class="container-check" for="">
									<input type="radio" class="custom-control-input unit unit{{$foodDetails->id}}" name="unit" value="{{ $unit_val['id'] }}" data-id="{{$foodDetails['id']}}" data-val="{{ $unit_val['price'] }}" @if($ke == 0) checked @endif >
									<span class="checkmark"></span>
									{{ $unit_val['name'] }}
								</label>
							</div>
						</div>
						<div class="float-right">
							<div class="foodprice">&#8377;{{ $unit_val['price'] }}</div>
						</div>
					</li>
					@endforeach

				</ul>
			</div>
		</div>

		@endif
		@if($foodDetails->addons)
		<div class="addon-sec over-hid">
			<div class="modalbody-head">
				<h5 class="text-black font-opensans font-weight-bold">Addons</h5>
			</div>
			<div class="cont" style="line-height: 2;">
				<ul class="over-hid ord-mod">

					@foreach($v->addons as $ke => $addon_val)
					<li>
						<div class="float-left">
							<div class=" custom-checkbox">
								<label class="container-check" for="">{{ $addon_val->name }}
									<input type="checkbox" class="custom-control-input addon addon{{$foodDetails['id']}}" name="addon" value="{{ $addon_val->id }}" data-id="{{$foodDetails['id']}}" data-val="{{ $addon_val->price }}">
									<span class="checkmarks"></span>
								</label>
							</div>
						</div>
						<div class="float-right">
							<div class="foodprice font-montserrat">&#8377;{{ $addon_val->price }}</div>
						</div>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
		@endif
	</form>
	@php
	$hours	= date(('H'),strtotime($foodDetails->preparation_time));
	@endphp
	{{--$hours--}}
</div>
<div class="modal-footer justify-content-center">
	<div class="over-hid ord-mod-total">
		<span class="float-left text-theme font-weight-bold font-montserrat f-24">Total</span>
		<span class="float-right text-theme font-montserrat f-24">&#8377;<span id="total_price{{$foodDetails['id']}}">{{$unit_price}}</span></span>
	</div>

	<span class="item-count hide-text afid_{{ $foodDetails['id'] }}"  id="afid_{{ $foodDetails['id'] }}" >0</span>
	<button data-fid="{{ $foodDetails['id'] }}" data-id="{{ $foodDetails['id'] }}" class="add_item add_text" data-type="unit_details" data-isad="{!! $foodDetails['id'] !!}">ADD</button>
	
</div>
</div>
</div>
</div>
<!--modal end-->




<script type="text/javascript">

	$('.owl-carousel').owlCarousel({
		loop:true,
		margin:10,
		responsiveClass:true,
		nav:false,
		autoplay:true,
		dots:true,
		autoplayTimeout:6000,
		autoplaySpeed:2000,
		responsive:{
			0:{
				items:1,
			},
			600:{
				items:1,
			},
			1000:{
				items:1,
			}
		}
	})
</script>

<style type="text/css">
	.bestseller{top: -18px!important;}
	.carousel{width: 100%!important;}
	.carousel-inner{width: 100%!important}
	.carousel-control {
		padding-top: 23%!important;
		width: 11%!important;
	}
	.carousel.slide .list_image{
		height:100px;
		object-fit:cover;
	}
	.btn-close{background-color:}
	.ord-his{
		margin-bottom: 20px;
	}
	.detail-user p{
		margin-bottom: 5px;
		margin-top: 10px;
	}
	.detail-user{
		border: 1px solid #ccc;
		line-height: 20px
	}
	.address-section{margin-right: 12px;}
	.address-section .datetime{margin-top: 5px;}
	.address-section .label-success{padding: 5px 7px;font-size: 13px;margin-bottom: 12px;}
	.boy-detail{ line-height: 3px;margin-left: 10px;margin-bottom: 20px;}
	.btn-default.btn-close{background-color:#ed5565;font-weight:bold;}
	.side-title{font-weight:bold;color: #212121;}
	.mod-tittle{font-weight:normal;}
</style>