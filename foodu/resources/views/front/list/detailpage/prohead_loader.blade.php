<div class="row align-items-center m-sm-auto m-0">
	<div class="col-lg-6 col-md-7 col-sm-10 col-xs-12 p-0 pro-marginbottm"> 
		<div class="pro-center">
			<div class="tittle">
				<h1 title="FreshMenu" class="placeholder-glow">
					<span class="placeholder col-6"></span>
				</h1>
				{{-- <span class="area">
				</span> --}}
			</div>
			<div ></div>
			@if($restaurant->offer > 0)
			<div class="people placeholder-wave"> 
				<p class="offers_food  placeholder">
					<i class="fa fa-gift placeholder" aria-hidden="true"></i>{!! trans('core.offer_order',['offer_percent'=>$restaurant->offer]) !!}
				</p>
			</div>
			@endif
			<div class="d-block">
				<div class="pro-padrgt pro-middle placeholder-glow col-12">
					<div class="starword placeholder col-12"><span><span class=""></span></span></div>
					{{-- <div class="starbottom"><span>Address</span></div> --}}
				</div>
			</div>
		</div>
	</div>
	<div class="searchfavorite col-lg-2 col-md-3 col-sm-6 col-xs-12 d-flex justify-content-start">
		<div class="pro-padrgt placeholder-wave">
			<div class="starword placeholder"><span><span class="fas fa-star star star placeholder"></span>{!! $restaurant->overall_rating !!}</span>
			</div>
			<div class="starbottom placeholder-glow">
				<span class="placeholder col-12 d-block"></span>
			</div>
		</div>
		<div class="absolute">
			<div class="inlinesearch placeholder-glow col-12"> 
				{{-- <div class="searchdish">
					<span class="glyphicon glyphicon-search searchicn"></span>
					<span class="tablceel">
						<input type="text" class="inputdish search_filter_input" placeholder="Search for dishes..." value="">
					</span>
				</div> --}}
				<div class="favorite placeholder col-12 favoriteselection {!! ($favorite == 1) ? 'fav-active' : '' !!}" data-id="{!! (\Auth::check()) ? 1 : 0 !!}" data-userid="{!! $userid !!}" data-resid="{!! $restaurant->id !!}">
					<i class="glyphicon glyphicon-heart-empty  hearticon placeholder"></i>
					<span class="favrteword placeholder"> <a href="" class="cursr"></a></span>
				</div>
			</div>
		</div>
	</div>
			
</div>