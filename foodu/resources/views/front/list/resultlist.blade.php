<div class="tab-content">
	<div id="home" class="tab-pane fade in active topcolor">
		<div class="no_pad">
			@if($filter == 'yes')
			<div class="col-xs-12 no_pad">
				<div class="container no_pad d-flex align-items-center">
					@if(isset($filter_cuisines) && $filter_cuisines != '')
					@foreach($filter_cuisines as $k => $cuisineVal)
					<span class="filter_opt d-flex align-items-center">
						<h6>{!! $cuisineVal->name !!}</h6>
						<span class="cuisine_close" data-cuisine-id="{!! $cuisineVal->id !!}">
							<i class="fas fa-times "></i>
						</span>
					</span>
					@endforeach
					@endif
					@if($filter == 'yes')
					@php
					$keyword= (\Request::has('keyword'))  ? 'keyword='.\Request::get('keyword').'&' : '';
					$lat	= (\Request::has('lat') && \Request::get('lat') != '') ? 'lat='.\Request::get('lat').'&' : 0.00;
					$lang	= (\Request::has('lang') && \Request::get('lang') != '') ? 'lang='.\Request::get('lang').'&' : 0.00;
					$city	= (\Request::has('city'))  ? 'city='.\Request::get('city') : '';
					@endphp
					<a href="{!! URL::to('search?'.$keyword.$lat.$lang.$city) !!}"  class="clear_all">CLEAR ALL</a>
					@endif
				</div>
			</div>
			@endif
			<div class="flex_blocks">
				<?php $iNc = '0'; $sNc = '1';  $j=0;?>
				@if($listCount == 0)
				<div class="item-list">
					<div class="col-sm-12 no-padding text-center">
						{!! \Lang::get('core.no_restaurnts') !!}
					</div>
				</div>
				@else
				@foreach($allList as $key => $rest)
				@php
					$wishcheck	= \AbserveHelpers::wishcheck($rest->id);
				@endphp
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 full_width mar-bottm columpad">
					<div class="box">
						@if($rest->availability['status'] == 0)
						<div class="exclusive">{!! $rest->next_available_timetext !!}</div>
						@else
						<div class="exclusive_success">Time : {!! $rest->time_text !!}</div>
						@endif
						<div class="res  @if($rest->availability['status'] == 0) {!! 'closed_restaurant' !!} @endif">
							<div class="align">
								<a class="item-list" href="{!! URL::to('details/'.$rest->id) !!}">
									<div class="food_img" style="background-image: url('{!! $rest->logo !!}');"></div>
								</a>
							</div>
							@if($wishcheck == 'true')
							<div class="icon_heart">
								<span><i class="fa fa-heart" aria-hidden="true"></i></span>
							</div>
							@endif
							<a class="item-list" href="{!! URL::to('details/'.$rest->id) !!}"><h3>{!! $rest->name !!}</h3></a>
							<p>{!! $rest->cuisine_text !!}</p>
							<div class="botm-box">
								<div class="starbck">
									<i class="fa fa-star star"></i>
									<span class="four">{!! round($rest->overall_rating) !!}</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endforeach
				<div class="w-100 toolbar-nav page-sec">
					<div class="d-flex flex-wrap justify-content-between align-items-center">
						<div class="">
							<div class="" style=" margin: 20px 0">
								@lang('core.grid_displaying')
								<b> {{ ($allList->currentpage()-1) * $allList->perpage()+1 }} </b>
								@lang('core.grid_to')
								<b>  {{$allList->currentpage() * $allList->perpage()}} </b>
								@lang('core.grid_of')
								<b>  {{$allList->total()}} </b>
								All shops
							</div>		
						</div>

						<div class="text-right">
							{!! $allList->appends(request()->all())->links() !!}
						</div>
						{{-- <?php echo "<pre>";print_r($cuisines);exit();?> --}}
					
					</div>
				</div>
				@endif
			</div>
		</div>
	</div>
</div>