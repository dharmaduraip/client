@if(!empty($fooditems))
<div class="procontinrpad borderbotm container-fluid" id="category_{!! $categoryid !!}">
	<div class="newvl">{!! $categoryname !!}</div>
	<div class="bottmword1 row d-flex flex-wrap">
		@foreach($fooditems as $cat)
		<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 mb-2 p-0">
			<div class="boxadd m-0 h-100">
				<div class="baddc" itemprop="name" data-id="{!! $cat->id !!}" style="cursor: pointer;" title="Click to view product details">
					{!! $cat->food_item !!} 
				</div>
				<div class="food_item_img">
					<a class="" data-bs-target="#modalIMG{!! $cat->id !!}"     data-bs-toggle="modal" href="#">
						<img src="{!! $cat->exact_src !!}" class="" width="90" height="94">
					</a>
				</div>
				<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal modalIMG fade" id="modalIMG{!! $cat->id !!}" role="dialog" tabindex="-1">
					<div class="modal-dialog modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-body mb-0 p-0">
								<img src="{!! $cat->exact_src !!}" class="" style="width: 100%;">
							</div>
						</div>
					</div>
				</div>
				<div class="d-flex align-items-center justify-content-between">
					<div class="_boxadd2 pad_top_no add_img"  data-id="{!! $cat->id !!}" style="cursor: pointer;" title="Click to view product details">
						<div class="baddd badde d-flex align-items-center justify-content-between more_details" data-id="{!! $cat->id !!}" style="cursor: pointer;" title="Click to view product details">
							{{-- {!! 'offerText' !!} --}}
						</div>
						@if($cat->strike_price > 0)
						<strike class="d-block" style="color: red;">{!! '₹ '.number_format(($cat->strike_price),2,'.','') !!}</strike>
						@endif
						<span class="ii0 d-block">{!! '₹ '.number_format(($cat->selling_price),2,'.','') !!}</span>
					</div>
					<?php $cart=\DB::table('abserve_user_cart')->where('food_id',$cat->id)->get();
					$combined = array();

					foreach( $cart as $values )  {
						if( ( $key = array_search( $values->food_id, array_column( $combined, 'food_id') ) ) !== false )  {
							$combined[$key]->quantity += $values->quantity;
						} else {
							$combined[] = $values;
						}
					}

					
					?>
					{{-- @if($cat->item_status == 1) --}}
					<?php $item_time_valid= \AbserveHelpers::getItemTimeValid($cat->id); ?>
					@if($item_time_valid == 1)
					<div class="text-right items_count_box fnitem_{!! $cat->id !!}" id="fnitem_{!! $cat->id !!}">
						<?php $item_count_val	= \AbserveHelpers::foodcheck($cat->id); ?>
						@if($item_count_val >= 1)
						<button data-fid="{!! $cat->id !!}" class="add_dec_option remove_item" data-type="more_details" data-isad="{!! $cat->show_addon !!}">-</button>
						<span class="item-count afid_{{$cat->id }}"  id="afid_{{ $cat->id }}" data-id="{{ $cat->id }}"><?php echo $combined[0]->quantity;?></span>
						<button data-fid="{{ $cat->id }}" class="add_dec_option add_item" data-id="{{ $cat->id }}" data-type="more_details" data-isad="{!! $cat->show_addon !!}">+</button>
						@else
						<span class="item-count hide-text afid_{{ $cat->id }}"  id="afid_{{ $cat->id }}" >0</span>
						<button data-fid="{{ $cat->id }}" data-id="{{ $cat->id }}" class="add_item add_text" data-type="more_details" data-isad="{!! $cat->show_addon !!}">ADD</button>
						@endif
					</div>
					@else
					 <?php $itemTimeText = \AbserveHelpers::getNextItemTime($cat->id); ?>
					  <div class="bestseller">{!! $itemTimeText !!}</div>
					@endif
				</div>
				{{-- @endif --}}
			</div>
		</div>
		@endforeach
	</div>
</div>
@endif