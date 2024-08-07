<div class="modal-header">
	<div class="panel-group">
		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading d-none">
					<h4 class="panel-title">
						<a data-toggle="collapse" href="#refund_status">Refund Status</a>
					</h4>
				</div>
				<div id="refund_status" class="panel-collapse collapse">
					<div class="panel-body">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Status</th>
									<th>Timing</th>
								</tr> 
							</thead>
							<tbody>
								@if(!empty($status))
								@foreach ($status as $row)
								<tr>
									<td>
										@if($row->status == 1 )
										{!! trans('core.accepted') !!}
										@elseif($row->status == 2)
										{!! trans('core.abs_accept_by_boy') !!}
										@elseif($row->status == 3)
										{!! trans('core.abs_order_dispatch') !!}
										@elseif($row->status == 4)
										{!! trans('core.abs_order_finished') !!}
										@elseif($row->status == 5)
										{!! trans('core.abs_rejected') !!}
										@else
										{!! trans('core.pending') !!}
										@endif
									</td>
									<td>{{$row->updated_at}}</td>
								</tr>
								@endforeach
								@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#">Customer Request</a>
				</h4>
			</div>
			<div id="customer_request" class="panel-collapse collapse show">
				<div class="panel-body">
					<div>
						<p><strong>Customer Refund Reason:</strong></p>
						<ul>
							<li>{{ $rOrder->refund_reason }}</li>
						</ul>
					</div>	

					<div>
					<p><strong>Customer Refund Comment:</strong></p>
					<p style="text-indent:30px;">{{ $rOrder->refund_comment }}</p>
					</div>		

					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<p><strong>Image:</strong></p>
					   
						<div class="carousel-inner">
							<?php
							$refund_images = $rOrder->refund_image;
							$images = json_decode($refund_images)->refund_image;
							$imagesArray = [];
							if($images != '' && $images != null){
								$imagesArray = $images;
							}
							?>
							@if(!empty($imagesArray))
							<div class="row">
							@foreach($imagesArray as $iKey => $iValue)
								<div class="col-md-3">
									<img src="{{  url('uploads/refund').'/'.$rOrder->id.'/'.$iValue }}" alt="{{ $iKey }}" height="100px" width="100px">
								</div>
							@endforeach
						    </div>
							@else
							<div class="item active">
								<img src="{{ \URL::to('public/1280x853.png') }}" alt="No-Image">
							</div>
							@endif
						</div>
						<a class="left carousel-control" href="#myCarousel" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>

				</div>
				<div class="d-none">
					<label for="select_item">Select Items :
						<span class="errorNoItems alert alert-dismissible alert-danger fade"></span>
					</label>      
					<table class="table">
						<thead>
							<th>id</th>
							<th>Food Name</th>
							<th>adon_detail</th>
							<th>quantity</th>
							<th>amount</th>
						</thead>
						<tbody>
							@if(!empty($rsOrder->getOrder) && !is_null($rsOrder->getOrder->getNormalOrder->order_items) && $rsOrder->getOrder->getNormalOrder->order_items->count() > 0)
							@foreach($rsOrder->getOrder->getNormalOrder->order_items as $k => $v)
							<tr>
								<?php $TotPrice = 0; ?>
								@if($v->check_status === 'yes')
								<?php $TotPrice += $v->selling_price_total; ?>
								<td>{!! $k + 1 !!}</td>
								<td>{!! $v->food_item!!}</td>
								<td>{!! $v->adon_detail!!}</td>
								<td>{!! $v->quantity !!}</td>
								<td>&nbsp;{!! number_format($v->selling_price_total,2) !!}</td>
								@endif
							</tr>
							@endforeach
							@endif
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
					<div class="media">
						<div class="media-body">
							
							<h4 class="media-heading">Admin Comments</h4>
							<div class="row">
								@if($rOrder->refund_status == 'Customer Requested')
								<div class="col-md-12">
								<form id="refundAmount">
									<input type="hidden" name="rId" value="{{ $rOrder->id }}">
									<div class="form-group">
										<label for="email">Enter Refund Amount:</label>
										<input type="number" class="form-control" id="email" placeholder="Enter Amount" name="amount" required>
									</div>
									<button type="submit" class="btn btn-primary">Send</button>
								</form>
								</div>
								<!-- <div class="col-md-5">
									<a href="javascript:void(0);" data-for="customer" data-id={{ $rsOrder->id }} data-action="accept" class="adminAction">
										<span class="label label-success">
											Accept
										</span>
									</a>
								</div>
								<div class="col-md-5">
									<a href="javascript:void(0);" data-for="customer" data-id={{ $rsOrder->id }} data-action="reject" class="adminAction">
										<span class="label label-danger">
											Reject
										</span>
									</a>
								</div> -->
								@elseif($rOrder->refund_status == 'Customer Request Accepted')
								<div class="col-md-10">
									<p><strong>Customer Refund Amount : {{$rOrder->refund_amount}} </strong></p>
								</div>
								@endif
							</div>
						</div>
						<!-- <div class="pull-right">
							<img src="{{ \Auth::user()->src }}" class="media-object" style="width:60px">
						</div> -->
					</div>
				</div>
				<div class="adminActionMessage"></div>
			</div>
		</div>
	</div>
	@if($rsOrder->boy_image != '' && $rsOrder->boy_image != null &&  $rsOrder->customer_image_status == 'Approved')
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#boy_request">Boy Request <span class="label status label-info">{{ $rsOrder->boy_image_status }}</span></a>
				</h4>
			</div>
			<div id="boy_request" class="panel-collapse collapse">
				<div class="panel-body">
					<div id="myCarousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							{{--*/
							$images = $rsOrder->boy_src;
							$imagesArray = [];
							if($images != '' && $images != null){
								//$imagesArray = json_decode($images);
								$imagesArray = $images;
							}
							/*--}}
							@if(!empty($imagesArray))
							@foreach($imagesArray as $iKey => $iValue)
							<div class="item @if($iKey == 0) active @endif">
								<img src="{{ $iValue }}" alt="{{ $iKey }}">
							</div>
							@endforeach
							@else
							<div class="item active">
								<img src="{{ \URL::to('public/1280x853.png') }}" alt="No-Image">
							</div>
							@endif
						</div>
						<a class="left carousel-control" href="#myCarousel" data-slide="prev">
							<span class="glyphicon glyphicon-chevron-left"></span>
							<span class="sr-only">Previous</span>
						</a>
						<a class="right carousel-control" href="#myCarousel" data-slide="next">
							<span class="glyphicon glyphicon-chevron-right"></span>
							<span class="sr-only">Next</span>
						</a>
					</div>
				</div>
				<div class="panel-footer">
					<div class="media">
						<div class="pull-left">
							<img src="{{ $rsOrder->getMainOrder->getBoyInfo->src }}" class="media-object" style="width:60px">
						</div>
						<div class="media-body">
							<h4 class="media-heading">Boy Comments</h4>
							<p>{{ $rsOrder->boy_comment }}</p>
						</div>
					</div>
					<hr>
					<div class="media">
						<div class="pull-right">
							<img src="{{ \Auth::user()->src }}" class="media-object" style="width:60px">
						</div>
						<div class="media-body">
							<h4 class="media-heading">Admin Comments @if($rsOrder->boy_image_status != 'Pending') <span class="label status label-info"> {{ $rsOrder->boy_image_status }}</span> @endif</h4>
							<div class="row">
								@if($rsOrder->boy_image_status == 'Pending')
								<div class="col-md-5">
									<a href="javascript:void(0);" data-for="boy" data-id={{ $rsOrder->id }} data-action="accept" class="adminAction">
										<span class="label label-success">
											Accept
										</span>
									</a>
								</div>
								<div class="col-md-5">
									<a href="javascript:void(0);" data-for="boy" data-id={{ $rsOrder->id }} data-action="reject" class="adminAction">
										<span class="label label-danger">
											Reject
										</span>
									</a>
								</div>
								@else
								<div class="col-md-10">
									{{ json_decode($rsOrder->admin_comment)->for_boy }}
								</div>
								@endif
							</div>
						</div>
					</div>
					<div class="adminActionMessageBoy"></div>
				</div>
			</div>
		</div>
	</div>
	@endif
	@if($rsOrder->boy_image_status == 'Approved' && ($rsOrder->getOrder->order_type != 'Replace' || $rsOrder->getOrder->refund_status == 'Item Unavailable'))
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
					<a data-toggle="collapse" href="#refund_details">Transaction Details <span class="label status label-info">@if($rsOrder->gatCheckWallet()->count() > 0) Refunded @else Not Refunded @endif</span></a>
				</h4>
			</div>
			<div id="refund_details" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="adminActionRefundMessage"></div>
					@if($rsOrder->gatCheckWallet()->count() > 0)
					Refunded Amount : {{ $rsOrder->gatCheckWallet->amount }}
					@else
					<form id="refundAmount">
						<input type="hidden" name="rId" value="{{ $rsOrder->id }}">
						<div class="form-group">
							<label for="email">Enter Amount:</label>
							<input type="number" class="form-control" id="email" placeholder="Enter Amount" name="amount" required>
						</div>
						<button type="submit" class="btn btn-default">Send</button>
					</form>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endif
</div>