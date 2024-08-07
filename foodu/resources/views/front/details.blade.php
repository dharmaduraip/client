@extends('layouts.default.index')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<div id="snackbar" style="display: none"></div>
<style type="text/css">
	.procontinrpad:first-child{
		border-top: unset !important;
		margin-top: 0;
	}
	strike{
		display: none;
	}
	 .modalIMG .modal-content {
		width: 550px;
		margin: auto;
	}
	.modalIMG .modal-body img {
		width: 100%;
		height: auto;
		object-fit: contain;
		margin-bottom: 0;
	}
	.modalIMG .modal-dialog.modal-lg{
		height: 100%;
		display: flex;
		align-items: center;
		justify-content: center;
		width: 550px;
	}

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
	@-webkit-keyframes fadeout {
		from {top: : 0; opacity: 1;} 
		to {top: 250px; opacity: 0;}
	}
	.navbar-fixed-top { position: relative !important;  right: 0; left: 0; z-index: 1030; }
	li.active a{ color: #f5861f; }
	.cat_list li a{cursor:pointer;}
	.menu-cart-block .menu-cart-body, .menu-cart-block-md .menu-cart-body { position: relative; background-color: #fff; padding: 1em 0 1em 1em; border-bottom: 1px solid #cbcbcb; min-height: 50px; overflow-y: auto; -webkit-transition: min-height ease-in-out .75s; transition: min-height ease-in-out .75s; }
	.menu-cart-body.empty{display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center; padding:20px; overflow: hidden; font-size: 1.2em; line-height: 1.5; text-align: center; color: #d4d4d4; position: relative; background-color: #fff; }
	.btn-checkout:disabled { background-color: #d4d4d4; }
	.item { max-height: 240px; border-radius: 3px; overflow: hidden; /*margin-bottom: 2em;*/ box-shadow: 0 1px 3px 0 rgba(0,0,0,.12), 0 1px 2px 0 rgba(0,0,0,.24); }
	.item > .header { height: 152px; overflow: hidden; }
	.item > .header img { max-width: 100%; height: 100%; }
	.restaurant-item { padding: 0px; position: relative; border-bottom: 0 solid #f6f6f6; }
	.restaurant-item .food-item { padding: 0em 0 1em; }
	.restaurant-item .food-item span.item-type { position: absolute; font-family: swgy-icon; height: 14px; width: 14px; top: 0; left: -4px; text-align: center; }
	.repeat-wrapper .restaurant-item .food-item h5.recommended { position: relative; margin: 0 0 12px 15px; padding-bottom: 12px; display: inline-flex; font-size: 13px; }
	.restaurant-item .food-item .item-count { position: relative; top: 0px; }
	.no-pad{padding:0;}
	.title { border-bottom: 1px solid #f6f6f6; background-color: #fff; text-align: center; padding: 0 1.25em 1.25em 0; }
	.title h5 { margin: 0 0 2px; font-weight: 700; }
	.title span { color: #585858; }
	.restaurant-items-unit .restaurant-items-title { border-bottom: 1px solid #f6f6f6; padding: 1.25em; background-color: #fbfafa; font-size: 12px; }
	.repeat-wrapper .restaurant-item { padding: 0 1em; }
	.repeat-wrapper .restaurant-item { border-bottom: 1px solid #f6f6f6; }
	.repeat-wrapper .restaurant-item .food-item { padding: 1em 0;}
	.repeat-wrapper .restaurant-item .food-item span.item-type { position: absolute; font-family: swgy-icon; height: 14px; width: 14px; top: 0; left: -4px; text-align: center;}
	.repeat-wrapper .restaurant-item .food-item h5 { margin: 0 0 3px; position: relative; font-weight: 700; font-size: 14px; }
	#login-form .state-error + em { display: block; margin-top: 6px; padding: 0 1px; font-style: normal; font-size: 12px; line-height: 15px; color: #f00; }
	.restaurant_info { width: 300px; border: 1px #f5861f ; padding: 25px; }
	.positionfixed{  position: fixed; top: 199px; left: auto; width: 262px; margin-top: 15px; }
	.cart_btn_content { position: relative; cursor: pointer; font-size: 15px; }
	.cart_btn_content .cart_btn { position: absolute; }
	.cart_btn_content .cart_plus { position: absolute; width: 33.3%; right: 0;}
	.cart_btn_content .cart_count { position: absolute; width: 33.3%; left: 33.3%; }
	.cart_btn_content .cart_minus { position: absolute; width: 33.3%; left: 0; }
	.cart_count_content { display: none; }
	.hide-text {display: none; }

	.cartsectionclas{
		background: url(<?php echo URL::to(''); ?>/'.CNF_THEME.'/images/lodi.gif) no-repeat center center;
		background-size: 100px 100px;
		z-index: 999;
		opacity: 0.5;
		pointer-events: none;
	}
	.cartsectioncla{
		pointer-events: none;
	}
</style>
@endsection
@section('content')
@php
$rating     = \AbserveHelpers::getOverallRating($restaurant->id);
$ratingCount= \AbserveHelpers::getRatingCount($restaurant->id);
$currsymbol = (\Session::has('currency_symbol')) ? \Session::get('currency_symbol') : '₹' ;
@endphp
<input type="hidden" value="{!! $restaurant->id !!}" id="res_id" name="res_id" />
<div class="pro-head">
	<div class="container no_pad">
		{{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pro-marginbottm">
			<div class="pro-image">
				<img src="{!! $restaurant->logo !!}" class="img-responsive widthimage headerimg" onerror="this.onerror=null;this.src='../../uploads/images/no-image.png';" style="opacity: 1;">
			</div>
		</div> --}}
		<div class="col-lg-5 col-md-9 col-sm-6 col-xs-12 pro-padleft pro-marginbottm"> 
			<div class="pro-center">
				<div class="tittle">
					<h1 title="FreshMenu" class="">{!! $restaurant->name !!}</h1>
					<span class="area">
					</span>
				</div>
				<div ></div>
				@if($restaurant->offer > 0)
				<div class="people"> 
					<p class="offers_food">
						<i class="fa fa-gift" aria-hidden="true"></i>{!! trans('core.offer_order',['offer_percent'=>$restaurant->offer]) !!}
					</p>
				</div>
				@endif
				<div class="d-flex">
				   
					<div class="pro-padrgt pro-middle">
						<div class="starword"><span><span class=""></span>{{$restaurant->location}}</span></div>
						<!-- <div class="starbottom"><span>Address</span>
						</div>
 -->                    </div>
				</div>
			</div>
		</div>
		<div class="searchfavorite col-lg-2 col-md-2 col-sm-6 col-xs-12 d-flex justify-content-start">
			 <div class="pro-padrgt">
						<div class="starword"><span><span class="fas fa-star star star"></span>{!! $rating !!}</span></div>
						<div class="starbottom"><span>{!! $ratingCount !!} Ratings</span>
						</div>
					</div>
			<div class="absolute">
				<div class="inlinesearch"> 
							{{-- <div class="searchdish">
								<span class="glyphicon glyphicon-search searchicn"></span>
								<span class="tablceel">
									<input type="text" class="inputdish search_filter_input" placeholder="Search for dishes..." value="">
								</span>
							</div> --}}
							<div class="favorite favoriteselection <?php if($favorite==1){ echo 'fav-active';}?>" data-id="<?php echo $authcheck; ?>" data-userid="<?php echo $userid; ?>" data-resid="<?php echo $restid; ?>">
								<i class="glyphicon glyphicon-heart-empty  hearticon"></i>
								<span class="favrteword"> <a href="" class="cursr">Favorite</a></span>
							</div>
						</div>
					</div>
				</div>
				@if($restaurant->free_delivery == 1 || $restaurant->offer > 0)
				<div class="col-lg-3 hidden-md hidden-sm col-xs-12 pro-marginbottm padleftt pro-mrgntop">
					<div class="pro-border1">
						<span class=""><i class="fas fa-certificate delivryicon1"></i>
							<i class="fas fa-percent delivryicon"></i></span> offer
						</div>
						<div class="pro-border2">
							@if($restaurant->free_delivery == 1 && $restaurant->offer > 0)
							{!! trans('core.offer_order',['offer_percent'=>$restaurant->offer]) !!}<br><br>
							{!! Lang::get('core.abs_free_del_offer') !!}
							@elseif($restaurant->free_delivery == 1)
							{!! Lang::get('core.abs_free_del_offer') !!} 
							@else 
							{!! trans('core.offer_order',['offer_percent'=>$restaurant->offer]) !!}
							@endif
						</div> 
					</div>
					@endif
				</div>
			</div>


		@if($restaurant->free_delivery == 1 || $restaurant->offer > 0)
		<div class="col-lg-3 hidden-md hidden-sm col-xs-12 pro-marginbottm padleftt pro-mrgntop">
			<div class="pro-border1">
				<span class=""><i class="fas fa-certificate delivryicon1"></i>
					<i class="fas fa-percent delivryicon"></i></span> offer
			</div>
			<div class="pro-border2">
				@if($restaurant->free_delivery == 1 && $restaurant->offer > 0)
				{!! trans('core.offer_order',['offer_percent'=>$restaurant->offer]) !!}<br><br>
				{!! Lang::get('core.abs_free_del_offer') !!}
				@elseif($restaurant->free_delivery == 1)
				{!! Lang::get('core.abs_free_del_offer') !!} 
				@else 
				{!! trans('core.offer_order',['offer_percent'=>$restaurant->offer]) !!}
				@endif
			</div> 
		</div>
		@endif
	</div>
</div>
@if(isset($restaurant->banner))
<div class="container">
	<div class="owl-carousel detailbanner-blj owl-theme">
		@foreach ($restaurant->banner as $k => $v)
		<div class="item">
			<div><img src="{{ $v }}"></div>
		</div>
		@endforeach
	</div>
</div>
@endif
<div class="orderitem">
	<div class="container">
		<div class="row">
			<div class="leftsidemenu col-md-3" id="leftsidecontent">
				<div class=""> 
					<div class="leftorangemnu hidden-sm hidden-xs   ">
						@foreach($cate_list_shop as $key => $cat)
						<a class="cart_menulink " href="#category_{{$key+1}}"><div class="leftmenudiv">{{$cat->cat_name}}</div></a>
						@endforeach
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="row d-md-flex flex-md-row-reverse">
					<div class="righthidecontent col-sm-4" id="righthidecontent">
						<div class="rightsidecart">
							<div class="rightimagebox menu_cart">
								{!! $cart_items_html !!} 
								<div class="text_add">
									<p>The product images displayed are for visual purpose only. The original product may differ from the image.</p>
								</div>   
							</div>
							
						</div>
					</div>
					<div class="contentcenter detail-blj col-sm-8">
						<div class="centercontent">
							<div class="search_filter_content"></div>
							<div class="bottmword">
								@foreach($cate_list_shop as $mkey => $val)
								<div class="procontinrpad borderbotm container-fluid" id="category_{{$mkey+1}}"> 
									<div class="newvl">{{$val->cat_name}}</div>
									<div class="bottmword1 row d-flex flex-wrap">
										<?php  
										$res_id = Request::segment(2);        
										$cate_item  = AbserveHelpers::categoryList($val->id,$res_id); 
										?>
										@foreach($cate_item as $key => $cat)
										<?php 
										$aFoodItem = \App\Models\Fooditems::find($cat->id);
										$item_class='non_veg_item';
										if($cat->status == 'Veg')
											$item_class='veg_item';
										?>
										<div class="col-12 col-xs-6 col-sm-6 col-md-6 col-lg-4 p-0 mb-2 {!! $item_class !!}">
											<div class="boxadd m-0 h-100">
												<div class="baddc 
												@if($aFoodItem->show_addon)more_details @endif" itemprop="name" data-id="{!!$cat->id!!}" style="cursor: pointer;" title="Click to view product details">
												{!! $cat->food_item !!} 
											</div>

											<?php
											$defaultImg = \URL::to('/uploads/images/no-image.jpg');
											$path = 'uploads/images/';
											$curImg = [];
											$aImage = explode(',', $cat->image);
											if(count($aImage) > 0){
												foreach ($aImage as $ikey => $ivalue) {
													if($ivalue != '' && file_exists(base_path($path.$ivalue))){
														$curImg[] = \URL::to($path.$ivalue);
													}
												}
											}
											if(count($curImg) == 0){
												$curImg[] = $defaultImg;
											}
											?>
											<div class="food_item_img">
												@if(count($curImg) > 1)
												<div class="owl-carousel food_slider owl-theme">
													@foreach($curImg as $iKey => $iValue)
													<div class="item">
														<img src="{!! $iValue !!}" width="90" height="94">
														{{--  <img data-src="{!! $iValue !!}" width="90" height="94" class="lazy" src="{{ URl::to($path.'gray.png')  }}"> --}}
													</div>
													@endforeach
												</div>
												@else
												<a class="" data-target="#modalIMG{!! $cat->id !!}"     data-toggle="modal" href="#">
												   <img src="{!! $curImg[0] !!}" class="" width="90" height="94">
												   {{--  <img width="90" height="94" data-src="{!! $curImg[0] !!}" src="{{ URl::to($path.'gray.png')  }}" class="lazy"> --}}
											   </a>
											   @endif
										   </div>

										   <div aria-hidden="true" aria-labelledby="myModalLabel" class="modal modalIMG fade" id="modalIMG{!! $cat->id !!}" role="dialog" tabindex="-1">
											<div class="modal-dialog modal-lg" role="document">
												<div class="modal-content">
													<div class="modal-body mb-0 p-0">
														<img src="{!! $curImg[0] !!}" class="" style="width: 100%;">
													</div>
												</div>
											</div>
										</div>

										<div class="_boxadd2 pad_top_no add_img @if($aFoodItem->show_addon)more_details @endif"  data-id="{!!$cat->id!!}" style="cursor: pointer;" title="Click to view product details">
											{{-- <div class="badd"> --}}
												@if($cat->status=='Non_veg')
												{{-- <div class="rsquare"></div> --}}
												@else
												{{-- <div class="square"></div> --}}
												@endif

											{{-- </div> --}}
											{{-- <p class="baddcd @if($aFoodItem->show_addon)more_details @endif" data-id="{!!$item->id!!}" style="cursor: pointer;" title="Click to view product details">{{$item->description}} &nbsp;  --}}
												@if($aFoodItem->show_addon)
												{{-- <span class="label label-success @if($aFoodItem->show_addon)more_details @endif" data-id="{!!$item->id!!}" style="cursor: pointer;" title="Click to view product details">View details</span> --}}
												@endif
											{{-- </p> --}}
											<div class="baddd badde d-flex align-items-center justify-content-between @if($aFoodItem->show_addon)more_details @endif" data-id="{!! $cat->id !!}" style="cursor: pointer;" title="Click to view product details">
												{!! $offerText !!}
												<?php
												$hikedPrice     = ($cat->original_price * ($cat->hiking /100));
												$gstHikedPrice  = ($hikedPrice * ($cat->gst /100));
												?>
												<div>
													@if($cat->strike_price > 0)
													<strike class="d-block" style="color: red;">{!! $currsymbol.' '.number_format(($cat->strike_price ),2,'.','') !!}</strike>
													@endif
													<span class="ii0 d-block">{!! $currsymbol.' '.number_format(($cat->selling_price),2,'.','')!!}</span>
													{{--  <span class="ii0 d-block">{!! $currsymbol.' '.number_format(($cat->price + $hikedPrice + $gstHikedPrice),2,'.','')!!}</span> --}}
												</div>
												<?php
												$itemquants     = \AbserveHelpers::foodcheck($cat->id);
												$item_time_valid= \AbserveHelpers::getItemTimeValid($cat->id);
												?>

												@if($item_time_valid == 1)
												<?php $item_count_val = \AbserveHelpers::foodcheck($cat->id);
												?>
												<div class="text-right items_count_box fnitem_{!! $cat->id !!}" id="fnitem_{!! $cat->id !!}">
													@if($item_count_val >= 1)
													<button data-fid="{!! $cat->id !!}" class="add_dec_option remove_item" data-type="more_details" data-isad="{!! $aFoodItem->show_addon !!}">-</button>
													<span class="item-count afid_{{$cat->id}}"  id="afid_{{$cat->id}}" data-id="{{$cat->id}}">{!! \AbserveHelpers::foodcheck($cat->id) !!}</span>
													<button data-fid="{{$cat->id}}" class="add_dec_option add_item" data-id="{{$cat->id}}" data-type="more_details" data-isad="{!! $aFoodItem->show_addon !!}">+</button>
													@else
													<span class="item-count hide-text afid_{{$cat->id}}"  id="afid_{{$cat->id}}" >{!! \AbserveHelpers::foodcheck($cat->id) !!}</span>
													<button data-fid="{{$cat->id}}" data-id="{{$cat->id}}" class="add_item add_text" data-type="more_details" data-isad="{!! $aFoodItem->show_addon !!}">ADD</button>
													@endif
												</div>
												@else
												<?php $itemTimeText = \AbserveHelpers::getNextItemTime($cat->id);
												?>
												<div class="bestseller">{!! $itemTimeText !!}</div>
												@endif
											</div>
										</div>
									</div>
								</div> 
								@endforeach
							</div>
						</div>
						@endforeach
					</div>
				</div>
				<div class="modal fade clear-cart " tabindex="-1" role="dialog" id="switch_cart" >
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title text-danger" id="myModalLabel">{!! Lang::get('core.clear_cart') !!}?</h4>
							</div>
							<div class="modal-body text-center">
								<p>{!! Lang::get('core.start_refresh') !!}</p>
								<input type="hidden" name="cart_item" id="cart_item" value="">
								<input type="hidden" name="cart_qty" id="cart_qty" value="">
								<input type="hidden" name="cart_res" id="cart_res" value="">
								<input type="hidden" name="ad_id" id="ad_id" value="">
								<input type="hidden" name="ad_type" id="ad_type" value="">
							</div>
							<div class="modal-footer">
								<button type="button" class="btn  btn red" data-dismiss="modal">{!! Lang::get('core.take_back') !!}</button>
								<button type="button" class="btn  btn-primary add_new_cart_item" >{!! Lang::get('core.start_refresh_yes') !!}</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<div class="modal fade" id="foodModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content order-content">
		</div>
	</div>
</div>
{{-- <script type="text/javascript">
	!function(window){
		var $q = function(q, res){
			if (document.querySelectorAll) {
				res = document.querySelectorAll(q);
			} else {
				var d=document
				, a=d.styleSheets[0] || d.createStyleSheet();
				a.addRule(q,'f:b');
				for(var l=d.all,b=0,c=[],f=l.length;b<f;b++)
					l[b].currentStyle.f && c.push(l[b]);

				a.removeRule(0);
				res = c;
			}
			return res;
		}
		, addEventListener = function(evt, fn){
			window.addEventListener
			? this.addEventListener(evt, fn, false)
			: (window.attachEvent)
			? this.attachEvent('on' + evt, fn)
			: this['on' + evt] = fn;
		}
		, _has = function(obj, key) {
			return Object.prototype.hasOwnProperty.call(obj, key);
		}
		;

		function loadImage (el, fn) {
			var img = new Image()
			, src = el.getAttribute('data-src');
			setTimeout(
				img.onload = function() {
					if (!! el.parent)
						el.parent.replaceChild(img, el)
					else
						el.src = src;

					fn? fn() : null;
				}
				, 6000);
			img.src = src;
		}

		function elementInViewport(el) {
			var rect = el.getBoundingClientRect()

			return (
				rect.top    >= 0
				&& rect.left   >= 0
				&& rect.top <= (window.innerHeight || document.documentElement.clientHeight)
				)
		}

		var images = new Array()
		, query = $q('img.lazy')
		, processScroll = function(){
			for (var i = 0; i < images.length; i++) {
				if (elementInViewport(images[i])) {
					loadImage(images[i], function () {
						images.splice(i, i);
					});
				}
			};
		}
		;
		for (var i = 0; i < query.length; i++) {
			images.push(query[i]);
		};

		processScroll();
		addEventListener('scroll',processScroll);

	}(this);
</script> --}}
@endsection
@push('scripts')
<script src="{{ asset('sximo5/js/front/jquery.sticky-sidebar-scroll.min.js') }}"></script>
<script src="{!! asset('sximo5/js/front/detail.js') !!}"></script>
@endpush
