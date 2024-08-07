<div class="overlay"></div>
<section>
	<div class="navbartwo hidesearch">
		<nav class="navbar snav-color snavbar filter_header" id="navmenu2">
			<div class="topborder w-100 py-lg-2" id="myHeader"> 
				<h5 >{!! $listCount !!} Shops</h5>
				<ul class="nav nav-tabs snavtabs ntabs"  >
					<li @if((\Request::has('sort_by') && \Request::get('sort_by') == 'relevance') || !(\Request::has('sort_by'))) class="active" @endif><a data-toggle="tab" href="#home" class="sort_by pb-2" data-value="relevance">Relevance
					</a></li>
					<li @if(\Request::has('sort_by') && \Request::get('sort_by') == 'rating') class="active" @endif><a data-toggle="tab" href="#menu3" class="sort_by pb-2" data-value="rating">Rating</a></li>
					<li  class="rigt_search"><a data-toggle="tab" href="javascript::void(0);">Filters
						<span class="filtericon" ><i class="fas fa-sliders-h iconsize" ></i> </span></a>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<div id="mySidenav" class="right-popup right-menu filter_popup">
		<div class="leftcontainer">
			<div class="leftbox">
				<div class="filter-div">
					<div class="closebtn">
						<i class="closefilter close-filter-toggle"></i><span class="filter">Filters</span>
					</div>
				</div>
				<div class="filter_options text-left">
					<h5>Shop Categories</h5>
					<div class="row col-xs-12 col-md-12 no_pad"> 
						@foreach($cuisines as $cus)
						<div class="col-md-6 col-md-6 col-xs-12 no_pad">
							@php
							$cCusn	= (\Request::has('cuisines')) ? explode(",", trim(\Request::get('cuisines'))) : [];
							$chck	= (!empty($cCusn) && in_array($cus->id, $cCusn)) ? "checked" : '';
							@endphp
							<label class="control control--checkbox checkspace">
								<input type="checkbox" {!! $chck !!} class="cuisines"  value="{!! $cus->id !!}" id="cuisine_{!! $cus->id !!}">{!! $cus->name !!}
								<div class="control__indicator"></div>
							</label>
						</div>
						@endforeach
					</div>
					<h5>{!! Lang::get('core.abs_main_category') !!}</h5>
					<div class="row col-xs-12 col-md-12 no_pad"> 
						@foreach($categories as $cat)
						<div class="col-md-6 col-md-6 col-xs-12 no_pad">
							@php
							$cCat	= (\Request::has('categories')) ? explode(",", trim(\Request::get('categories'))) : [];
							$chck	= (!empty($cCat) && in_array($cat->id, $cCat)) ? "checked" : '';
							@endphp
							<label class="control control--checkbox checkspace">
								<input type="checkbox" {!! $chck !!} class="categories"  value="{!! $cat->id !!}" id="cuisine_{!! $cat->id !!}">{!! $cat->cat_name !!}
								<div class="control__indicator"></div>
							</label>
						</div>
						@endforeach
					</div>
					<h5>Kilo meter</h5>
					<div class="col-xs-8 col-md-12 no_pad"> 
						<div class="row flex-div">
							<input type="range" class="custom-range" id="customRange1" value="@if((\Request::has('distance'))){!! \Request::get('distance') !!}@else{!! \AbserveHelpers::getMaxRadius() !!}@endif" min='1' max="{!! \AbserveHelpers::getMaxRadius() !!}">
							<div class="label label-success label_flex" id="dis_rang">{!! (\Request::has('distance')) ? \Request::get('distance') : \AbserveHelpers::getMaxRadius() !!} KM</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="rightnavbutton">
			<div class="">
				@php
				$keyword= (\Request::has('keyword'))  ? 'keyword='.\Request::get('keyword').'&' : '';
				$lat	= (\Request::has('lat') && \Request::get('lat') != '') ? 'lat='.\Request::get('lat').'&' : 0.00;
				$lang	= (\Request::has('lang') && \Request::get('lang') != '') ? 'lang='.\Request::get('lang').'&' : 0.00;
				$city	= (\Request::has('city'))  ? 'city='.\Request::get('city') : '';
				@endphp
				<a href="{!! URL::to('search?'.$keyword.$lat.$lang.$city) !!}"  class="backgrnd">CLEAR</a>
			</div>
			<div><button class="backgrnd1">SHOW SHOPS</button></div>
		</div>
	</div>
</section>
<div id="accordion" class="panel-group1 absfilter">
	<form role="form" action="{!! URL::to('search') !!}" method="get" id="search_form">
		<input type="hidden" name="keyword" value="@if((\Request::has('keyword'))){!! \Request::get('keyword') !!}@endif">
		<input type="hidden" name="lang" value="@if((\Request::has('lang'))){!! \Request::get('lang') !!}@endif">
		<input type="hidden" name="lat" value="@if((\Request::has('lat'))){!! \Request::get('lat') !!}@endif">
		<input type="hidden" name="city" value="@if((\Request::has('city'))){!! \Request::get('city') !!}@endif">
		<input type="hidden" name="cuisines" id="cuisines" value="@if((\Request::has('cuisines'))){!! \Request::get('cuisines') !!}@endif">
		<input type="hidden" name="categories" id="categories" value="@if((\Request::has('categories'))){!! \Request::get('categories') !!}@endif">
		<input type="hidden" name="distance" id="distance" value="@if((\Request::has('distance'))){!! \Request::get('distance') !!}@endif">
		<input type="hidden" name="sort_by" id="sort_by" value="@if((\Request::has('sort_by'))){!! \Request::get('sort_by') !!}@endif">
		<input type="submit" name="search_btn" id="search_btn" value="Search"  class="hidden"/>
	</form>
</div>