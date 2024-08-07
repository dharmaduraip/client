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
<input type="hidden" value="{!! $restaurant->id !!}" id="res_id" name="res_id" />
<input type="hidden" value="{!! $fCount !!}" id="fCount" />
<div class="pro-head">
	<div class="container no_pad">
		{{-- <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pro-marginbottm">
			<div class="pro-image">
				<img src="{!! $restaurant->logo !!}" class="img-responsive widthimage headerimg" onerror="this.onerror=null;this.src='../../uploads/images/no-image.png';" style="opacity: 1;">
			</div>
		</div> --}}
		{{-- @include('front.list.detailpage.prohead_loader') --}}
		<div class="row align-items-center m-sm-auto m-0">
			<div class="col-lg-6 col-md-7 col-sm-10 col-xs-12 p-0 pro-marginbottm"> 
				<div class="pro-center">
					<div class="tittle">
						<h1 title="FreshMenu" class="d-inline-block">{!! $restaurant->name !!}</h1>
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
						<div class="pro-padrgt pro-middle" style="padding: 5px 0;">
							<div class="starword"><span><span class=""></span>{!! $restaurant->location !!}</span></div>
							{{-- <div class="starbottom"><span>Address</span></div> --}}
						</div>
					</div>
				</div>
			</div>
			<div class="searchfavorite col-lg-2 col-md-3 col-sm-6 col-xs-12 d-flex justify-content-start">
				<div class="pro-padrgt">
					<div class="starword"><span><span class="fas fa-star star star"></span>{!! $restaurant->overall_rating !!}</span>
					</div>
					<div class="starbottom">
						<span>{!! $restaurant->rating_count !!} Ratings</span>
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
						<div class="favorite favoriteselection {!! ($favorite == 1) ? 'fav-active' : '' !!}" data-id="{!! (\Auth::check()) ? 1 : 0 !!}" data-userid="{!! $userid !!}" data-resid="{!! $restaurant->id !!}">
							<i class="glyphicon glyphicon-heart-empty  hearticon"></i>
							<span class="favrteword"> <a href="" class="cursr">Favorite</a></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@if(isset($restaurant->banner) && count($restaurant->banner) > 0)
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
			<div class="leftsidemenu col-lg-3 d-lg-block d-none" id="leftsidecontent">
				<div class="h-100"> 
					{{-- @include('front.list.detailpage.leftsidemenu_loader') --}}
					<div class="leftorangemnu">
						@foreach($shopCategories as $ky => $sCat)
						<a class="cart_menulink @if($ky == 0){!! 'active' !!}@endif" data-catid={!! $sCat->id !!} href="#category_{!! $sCat->id !!}">
							<div class="leftmenudiv">{!! $sCat->cat_name !!}</div>
						</a>
						@endforeach
					</div>
				</div>
			</div>
			<div class=" col-lg-9 col-sm-12">
				<div class="d-md-flex flex-md-row-reverse">
					<div class="righthidecontent col-md-4 col-12" id="righthidecontent">
						<div class="rightsidecart">
							<div class="rightimagebox menu_cart">
								{{-- @include('front.list.detailpage.rightside_loader') --}}
								{!! $carthtml !!} 
								<div class="text_add">
									<p>The product images displayed are for visual purpose only. The original product may differ from the image.</p>
								</div>   
							</div>
						</div>
					</div>
					<div class="contentcenter detail-blj col-md-8">
						<div class="centercontent" style="padding:0">
							<div class="search_filter_content"></div>
							<div class="bottmword fillData">
								{{-- @include('front.list.detailpage.loader') --}}
								@include('front.list.detailpage.products',['fooditems' => $restaurant->fooditems, 'categoryid' => $shopCategories[0]->id, 'categoryname' => $shopCategories[0]->cat_name])
							</div>
							<div class="loadData"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@include('front.modal')
@endsection