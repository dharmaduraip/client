@extends('layouts.default.index')
@push('css')
<style type="text/css">
.flex-div { display:flex; }
.label_flex {
	margin-left: 20px;
	padding: 4px 4px;
	margin-bottom: 4px;
	background-color: #48c479;
}
</style>
@endpush
@section('content')
<div class="item space">
	<div class="">
		@if(\Session::has('message'))
		{!! \Session::get('message') !!}
		@endif
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
			<li>{!! $error !!}</li>
			@endforeach
		</ul>
	</div>
	@if($emergency_text != '')
	<section>
		<div class="alert alert-warning" style="color: #FFF!important;background-color: #f41b29!important;border-color: #FFF!important;font-size: 18px;">
			<strong>Warning!</strong> {!! $emergency_text !!}
		</div>
	</section>
	@endif
	<section class="search-left-menu">
		<div class="container no_pad">
			<div class="row m-0">
				<div class="col-md-3 d-lg-block d-none">
					<nav id="myScrollspy">
						<ul class="spy-menu nav nav-pills flex-column nav-stacked">
							<li>
								<a href="#all" class="active seeall"><span class="category_icon"><i class="fas fa-shopping-bag"></i></span><span class="margin_t_5"><b>All Shops</b><br><small>{!! $listCount !!} @if($listCount > 1)shops @else shop @endif</small></span></a>
							</li>
							@if($featureCount >= 1)
							<li>
								<a href="#feature"><span class="category_icon"><i class="fa fa-star"></i></span><span class="margin_t_5"><b>Featured</b><br><small>{!! $featureCount !!} @if($featureCount > 1)Shops @else Shop @endif</small></span></a>
							</li>
							@endif
						</ul>
					</nav>
				</div>
				<div class="col-lg-9 col-md-12 col-sm-12 col-xs-12" id="popular_list">
					<div id="all" class="property_list active">
						<div class="">
							@include('front.list.filter')
						</div>
						@include('front/list/resultlist')
					</div>
				</div>
			</div>
			<div class="decoratedLine vlabelBold"><span>Other Category Shops</span></div>
			@if(isset($featureList))
			<div id="feature" class="property_list">    
				<h1>Featured</h1>
				<div class="start col-xs-12 no-pad flex_blocks">
					@include('front/list/tabfilterlist')
				</div>
			</div>
			@endif
		</div>
	</section>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
	$(window).scroll(function(){
		scroll = $(window).scrollTop();
		var bookit = $('header').outerHeight() + $('.slider').outerHeight();
		var bookitright = ($('header').outerHeight() + $('.slider').outerHeight() + $('#popular_list').outerHeight()) - $('.spy-menu').outerHeight();
		var positionchange = $('#popular_list').outerHeight() - $('.spy-menu').outerHeight();
		if ( $(window).width() > 769 ){
			if (scroll >= bookit) {
				$('.spy-menu').addClass('fixe');
				if (scroll >= bookitright){
					$('.spy-menu').removeClass('fixe').css({"top": positionchange});
				} else{
					$('.spy-menu').removeAttr("style");
				}
			} else {
				$('.spy-menu').removeClass('fixe');
			}; 
		}
	});
	function onScroll(event){
		var scrollPos = $(document).scrollTop();
		$('.spy-menu li a').each(function () {
			var currLink = $(this);
			var refElement = $(currLink.attr("href"));
			if (refElement.position().top <= scrollPos && refElement.position().top + refElement.height() > scrollPos) {
				$('.spy-menu li a').removeClass("active");
				currLink.addClass("active");
			}
			else{
				currLink.removeClass("active");
			}
		});
	}
	function replaceQueryParam(param, newval, search) {
		var regex = new RegExp("([?;&])" + param + "[^&;]*[;&]?");
		var query = search.replace(regex,'$1').replace(/&$/,'');
		return (query.length > 2 ? query + "&" : "?") + (newval ? param + "=" + newval : '');
	}
	function getUrlParameter(sParam) {
		var sPageURL = decodeURIComponent(window.location.search.substring(1)),
		sURLVariables = sPageURL.split('&'),
		sParameterName,i;
		for (i = 0; i < sURLVariables.length; i++ ) {
			sParameterName = sURLVariables[i].split("=");
			if(sParameterName[0] === sParam) {
				return sParameterName[1] === undefined ? true : sParameterName[1];
			}
		}
	}
	$(document).on('click',".backgrnd1",function(){
		$("#search_btn").trigger('click');
	});
	$(document).on("click",'.cuisines',function(){
		var values = $('.cuisines:checked')
		.map(function(){return $(this).val();}).get();
		$('#cuisines').val(values);
	});
	$(document).on("click",'.categories',function(){
		var values = $('.categories:checked')
		.map(function(){return $(this).val();}).get();
		$('#categories').val(values);
	});
	$(document).on("click",'.sort_by',function(){
		var value = $(this).data('value');
		$("#sort_by").val(value);
		$("#search_btn").trigger('click');
	});
	$('form#search_form').submit(function() {
		$(':input', this).each(function() {
			this.disabled = !($(this).val());
		});
	});
	$('#customRange1').on('change',function(){
		$("#distance").val($(this).val());
		$("#dis_rang").html($(this).val()+' KM');
	})
	$(document).on('click',".cuisine_close",function(){
		var cVal = $(this).data('cuisine-id');
		$("#cuisine_"+cVal).prop('checked', false);
		var values = $('.cuisines:checked')
		.map(function(){return $(this).val();}).get();
		$('#cuisines').val(values);
		$("#search_btn").trigger('click');
	})
</script>
@endpush