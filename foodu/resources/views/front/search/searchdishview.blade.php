<section class="container contar">
	<div class="restaurants_option">
		<span class="restaurants_tab">Shops</span>
		{{-- <select class="sort_by">
			<option value="relevance" >Relevance</option>
			<option value="rating" >Rating</option>
		</select> --}}
	</div>
	<div class="res_listing col-xs-12">
		<div class="relate_to">RELATED TO <span>"{!! 'dish' !!}"</span></div>
		<div class="flex_blocks">
	  @if(count($res_data) > 0)
	  @foreach($res_data as $key => $value)
	  @if($value->availability['status'] != 0)	
		<a class="col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-6 full_width mar-bottm columpad item-list" href="{!! URL::to('details/'.$value->id) !!}">
			<div class="boxcontent">
					<div class="box">
						<div class="align"> 
							<div class="food_img" style="background-image: url('{!! $value->logo !!}');"></div>
						</div>
						<div class="exclusive_success">Time : {!! $value->time_text !!}</div>
						{{-- <div class="exclusive">Closed</div> --}}
						<h3>{!! $value->name !!}</h3>
						<p>{!! $value->cuisine_text !!}</p>
						<div class="botm-box">
                            <div class="starbck">
                                <i class="fa fa-star star"></i>
                                <span class="four">{!! $value->overall_rating !!}</span>
                            </div>
                        </div>
						<div class="sbox"><p>{!! $value->location !!}</p></div>
						{{-- <div class="sbox4">
							<span class=""><i class="fas fa-certificate deliveryicon1"></i>
								<i class="fas fa-percent deliveryicon"></i>
							</span> 
							<span class="delivery">Free Delivery</span>
						</div> --}}
					</div>
			</div>
		</a>
	   @endif
	   @endforeach	
		</div>
		@else
		<div class="unrelated_dish">
			<div class="error_img"></div>
			<div class="alert_msg1">Sorry..!</div>
			<div class="alert_msg2">We can't find anything related to your search.</div>
			<div class="alert_msg2">Try a different search</div>
		</div>
		@endif
	</div>
</section>
<section class="unservicable_restaurants">
	<div class="container contar">
	<strong>Currently Unserviceable</strong>
	<div class="row">
	@if(isset($res_data))
	@foreach($res_data as $key => $value)
	@if($value->availability['status'] == 0)
		<div class="col-md-4 col-sm-6 col-xs-6 full_width">
			<a href="{!! URL::to('details/'.$value->id) !!}">
				<div class="unservicable_content">
					<img src="{!! $value->logo !!}">
					<b>{!! $value->name !!}</b>
					<p>{!! $value->cuisine_text !!}</p>
				</div>
			</a>
		</div>
	@endif
	@endforeach
	@endif	
	</div>
	</div>
</section>