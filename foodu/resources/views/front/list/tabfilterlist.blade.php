@if(!empty($featureList))
@foreach($featureList as  $filter_value)
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 full_width mar-bottm columpad">
	<div class="box">
<div class="res  @if($filter_value->availability['status'] == 0) {!! 'closed_restaurant' !!} @endif">
		<div class="align">
			<a href="{!! \URL::to('details').'/'.$filter_value->id !!}">
				<div class="food_img" style="background-image: url('{!! \URL::to($filter_value->logo) !!}');"> </div>
			</a>
		</div>
		@php
		$wishcheck = \AbserveHelpers::wishcheck($filter_value->id);
		@endphp
		@if($filter_value->availability['status'] == 0)
		<div class="exclusive">{!! $filter_value->next_available_timetext !!}</div>
		@else
		<div class="exclusive_success">Time : {!! $filter_value->time_text !!}</div>
		@endif
		@if($wishcheck == 'true')
		<div class="icon_heart">
			<span><i class="fa fa-heart" aria-hidden="true"></i></span>
		</div>
		@endif
		<a href="<?php echo \URL::to('details').'/'.$filter_value->id; ?>">
			<h3><?php echo $filter_value->name; ?></h3>
		</a>
		<p>{!! $filter_value->cuisine_text !!}</p>
		<div class="botm-box">
			<div class="starbck">
				<i class="fa fa-star star"></i>
				<span class="four">{!! round($filter_value->overall_rating) !!}</span>
			</div>
		</div>
	</div>
	</div>
</div>
@endforeach
<div class="w-100 toolbar-nav page-sec">
	<div class="d-flex flex-wrap align-items-center justify-content-between">
		<div class="">
			<div class="" style=" margin: 20px 0">
				@lang('core.grid_displaying')
				<b> {{ ($featureList->currentpage()-1) * $featureList->perpage()+1 }} </b>
				@lang('core.grid_to')
				<b>  {{$featureList->currentpage() * $featureList->perpage()}} </b>
				@lang('core.grid_of')
				<b>  {{$featureList->total()}} </b>
				Featured shops
			</div>		
		</div>
		<div class="text-right">
			{!! $featureList->appends(request()->all())->links() !!}
		</div>
	</div>
</div>
@else
<div class="item-list">
	<div class="col-sm-12 no-padding text-center">
		{!! \Lang::get('core.no_restaurnts') !!}
	</div>
</div>
@endif