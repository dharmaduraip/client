@extends('layouts.app')

@section('content')

<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="toolbar-nav" >   
	<div class="row">
		<div class="col-md-8"> 	
			@if($access['is_add'] ==1)
			<a href="{{ url('boyacceptedorders/create?return='.$return) }}" class="btn  btn-sm"  
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create New </a>
			@endif

			<div class="btn-group">
				<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> Bulk Action </button>
		        <ul class="dropdown-menu">
		        @if($access['is_remove'] ==1)
					 <li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link tips" title="{{ __('core.btn_remove') }}">
					Remove Selected </a></li>
				@endif 
				@if($access['is_add'] ==1)
					<li class="nav-item"><a href="javascript://ajax" class=" copy nav-link " title="Copy" > Copy selected</a></li>
					<div class="dropdown-divider"></div>
					<li class="nav-item"><a href="{{ url($pageModule .'/import?return='.$return) }}" onclick="SximoModal(this.href, 'Import CSV'); return false;" class="nav-link "> Import CSV</a></li>

					
				@endif
				<div class="dropdown-divider"></div>
		        @if($access['is_excel'] ==1)
					<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=excel&return='.$return) }}" class="nav-link "> Export Excel </a></li>	
				@endif
				@if($access['is_csv'] ==1)
					<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=csv&return='.$return) }}" class="nav-link "> Export CSV </a></li>	
				@endif
				@if($access['is_pdf'] ==1)
					<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=pdf&return='.$return) }}" class="nav-link "> Export PDF </a></li>	
				@endif
				@if($access['is_print'] ==1)
					<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=print&return='.$return) }}" class="nav-link "> Print Document </a></li>	
				@endif
				<div class="dropdown-divider"></div>
					<li class="nav-item"><a href="{{ url($pageModule) }}"  class="nav-link "> Clear Search </a></li>
		          	
		        
		          
		        </ul>
		    </div>    
		</div>
		<div class="col-md-4 text-right">
			<div class="input-group ">
			      <div class="input-group-prepend">
			        <button type="button" class="btn btn-default btn-sm " 
			        onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " ><i class="fa fa-filter"></i> Filter </button>
			      </div><!-- /btn-group -->
			      <input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." placeholder=" Type And Hit Enter ">
			    </div>
		</div>    
	</div>	

</div>	
<div class="table-container ">

			<!-- Table Grid -->
			
 			{!! Form::open(array('url'=>'boyacceptedorders?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
			
		  
                  <table class="display nowrap" id="example1" cellspacing="0" width="100%"> 
					<thead>
						<tr>								
							<th> Order Id </th>
							<!-- <th> Date </th>													 -->
							<!-- <th> Ordered Time </th>	 -->
							<th> Shop Name </th>
							<th> Shop Address </th>
							<th> {!! trans('core.abs_payment_type') !!}</th>
							<th> Delivery address </th>
							<th> Amount to collect</th>
							<th> Status </th>
							<th> Order Items </th>
							
						</tr>
					</thead>
					<?php $aOrder = $boyaccepted->aOrder; 
                           // foreach($aOrder as $order){
                           //     $accept = $order->accepted_order_items;
                           //     foreach($accept as $items){

                           //     }
                           // }
					 ?>
                      <tbody class="table_Content">
						@foreach ($aOrder as $row)
						<?php  $amount = $row->order_items;  $amount1 = $amount[0]->order; 
						$cod_amount = $amount1->cod_amount;
						?>
						<?php $res_call = \AbserveHelpers::getRestaurantDetails($row->res_id); 
						date_default_timezone_set("Asia/Kolkata"); ?>
						<tr @if($row->delivery_type=='razorpay' && $row->delivery =='unpaid') style="background-color: #FBD9D9" @endif>							
							<td width="50">{{$row->id}}</td>	
							<td width="50"> {{ AbserveHelpers::restsurent_name($row->res_id) }} </td>
							<td width="50">{{ AbserveHelpers::getRestaurantAddress($row->res_id)}}</td>`
							<td width="50">{{ $row->delivery_type }}</td> 
							<td width="50">{{$row->address}}</td>
							<td>{{\AbserveHelpers::CurrencyValueBackend($row->accept_grand_total)}}</td>
							<td>
		    					@if($row->status == '3')
		    					<button type="button" class="btn btn-success fn_accept arcls" data-oid="{{$row->id}}" data-customerstatus = "boyPicked" id="show_accept">Order Picked</button>			           @elseif($row->status == 'boyPicked')
		    					<button type="button" class="btn btn-success fn_accept arcls" data-oid="{{$row->id}}" data-customerstatus = "boyArrived" id="show_accept">Boy Picked</button>	
		    					@elseif($row->status == 'boyArrived')
		    					<button type="button" class="btn btn-success fn_accept arcls" data-oid="{{$row->id}}" data-codamount = "{{$cod_amount}}" data-customerstatus = "4" id="show_accept">Order Delivered</button>
		    					@else
		    					<button type="button" class="btn btn-success">Waiting for prepare order</button>
		    					@endif
		    					</td>
                               <?php $accept = $row->accepted_order_items; ?>
                               <td width="50">
                               	@foreach($accept as $items)
                               	<?php $total = $items->quantity * $items->selling_price; ?> 
                               	{{$items->food_item}} {{$items->quantity}} x {{$items->selling_price}} Rs {{$total}} 
                               	@endforeach
                               </td>			
						</tr>

						@endforeach
					</tbody>





















				</table>







			<input type="hidden" name="action_task" value="" />
			
			{!! Form::close() !!}
			
			
			<!-- End Table Grid -->

</div>
@include('footer')
<script>

	$(document).ready(function(){
		$('#example1').DataTable( {
			dom: 'Bfrtip',
			buttons: [            
			{ extend:'csv',text: '<i class="fa fa-download"></i>&nbsp;Download',title: 'Zinggr_accepted_orders'}
			],
			"order": [[ 0, "desc" ]],
			responsive: true
		} );
		$('.buttons-csv').addClass('tips btn btn-sm btn-white');
		$('.do-quick-search').click(function(){
			$('#AbserveTable').attr('action','{{ URL::to("orders/multisearch")}}');
			$('#AbserveTable').submit();
		});
		$('#example1_info').hide();
		$('#example1_paginate').hide();
	});
$(document).ready(function(){
	$('.copy').click(function() {
		var total = $('input[class="ids"]:checkbox:checked').length;
		if(confirm('are u sure Copy selected rows ?'))
		{
			$('input[name="action_task"]').val('copy');
			$('#SximoTable').submit();// do the rest here	
		}
	})	
	
});	


$(document).on("click",'.fn_accept',function(){
    var oid = $(this).attr('data-oid');
    var current_status = $(this).attr('data-customerstatus');
    var cod_amount =  $(this).attr('data-codamount');
	$.ajax({
			url: 'boyacceptedorders/orders',
			type: "get",
			dataType: "json",
			data: {
			    order_id:oid, status:current_status,cod_amount:cod_amount
			},
			success: function(data) {
				console.log(data);
				alert('success');
			
			},
			error: function (error) {
				location.reload();
			}
		});
});

</script>

</script>	
	
@stop
