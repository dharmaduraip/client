@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="toolbar-nav" >   
	<div class="row">
		<div class="col-md-8"> 	
			@if($access['is_add'] ==1)
			<a href="{{ url('boyneworders/create?return='.$return) }}" class="btn  btn-sm"  
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
<div class="table-container">
			<!-- Table Grid -->
			
 			{!! Form::open(array('url'=>'boyneworders?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
			
		    <table class="table  table-hover " id="{{ $pageModule }}Table">
		        <thead>
					<tr>
						<th style="width: 3% !important;" class="number"> No </th>
						<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
						<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
						
						@foreach ($tableGrid as $t)
							@if($t['view'] =='1')				
								<?php $limited = isset($t['limited']) ? $t['limited'] :''; 
								if(SiteHelpers::filterColumn($limited ))
								{
									$addClass='class="tbl-sorting" ';
									if($insort ==$t['field'])
									{
										$dir_order = ($inorder =='desc' ? 'sort-desc' : 'sort-asc'); 
										$addClass='class="tbl-sorting '.$dir_order.'" ';
									}
									echo '<th align="'.$t['align'].'" '.$addClass.' width="'.$t['width'].'">'.\SiteHelpers::activeLang($t['label'],(isset($t['language'])? $t['language'] : array())).'</th>';				
								} 
								?>
							@endif
						@endforeach
						<th style="width: 3% !important;" class="number"> Shop Name </th>
						<th style="width: 3% !important;" class="number"> Shop Address </th>
						<th style="width: 3% !important;" class="number"> Delivery Address </th>
						<th style="width: 3% !important;" class="number"> Amount to Collect </th>
						<th style="width: 3% !important;" class="number"> Order Items </th>
					  <th>accept</th>	
					  </tr>

		        </thead>
		        <tbody>        						
		            @foreach ($rowData as $row)
		                <tr>
							<td class="thead"> {{ ++$i }} </td>
							<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
							<td>

							 	<div class="dropdown">
								  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> {{ __('core.btn_action') }} </button>
								  <ul class="dropdown-menu">
								 	@if($access['is_detail'] ==1)
									<li class="nav-item"><a href="{{ url('boyneworders/'.$row->id.'?return='.$return)}}" class="nav-link tips" title="{{ __('core.btn_view') }}"> {{ __('core.btn_view') }} </a></li>
									@endif
									@if($access['is_edit'] ==1)
									<li class="nav-item"><a  href="{{ url('boyneworders/'.$row->id.'/edit?return='.$return) }}" class="nav-link  tips" title="{{ __('core.btn_edit') }}"> {{ __('core.btn_edit') }} </a></li>
									@endif
									<div class="dropdown-divider"></div>
									@if($access['is_remove'] ==1)
										<li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link  tips" title="{{ __('core.btn_remove') }}">
										Remove Selected </a></li>
									@endif 
								  </ul>
								</div>

							</td>														
						 @foreach ($tableGrid as $field)
							 @if($field['view'] =='1')
							 	<?php //$limited = isset($field['limited']) ? $field['limited'] :''; ?>
							 	@if(SiteHelpers::filterColumn($limited ))
							 	@if($field['field'] == 'boy_id')
							 	<?php $boy_name = \AbserveHelpers::getDelBoyname($row->boy_id); ?>
							 	<td>{{$boy_name}}</td>
							 	@else
							 	 <?php //$addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
								 <td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >					 
								 	{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
								 </td>
								@endif	
								@endif
							 @endif					 
						 @endforeach
						 <?php $order = \App\Models\Front\OrderDetails::find($row->order_id);
						 	   $shop_name = \AbserveHelpers::restsurent_name($order->res_id);
						 	   $shop_address = \AbserveHelpers::restsurent_address($order->res_id);
						 	   $accept = \AbserveHelpers::loadAcceptedOrderItems($order->id); ?>
						 <td>{{$shop_name}}</td>
						 <td>{{$shop_address}}</td>
						 <td>{{$order->address}}</td>
						 <td>{{$order->accept_grand_total}}</td>
						 <td>
							@foreach($accept as $items)
							<?php $total = $items->quantity * $items->selling_price; ?> 
							{{$items->food_item}} {{$items->quantity}} x {{$items->selling_price}} Rs {{$total}} 
							@endforeach
						</td>
						 <td>
						 <button type="button" class="btn btn-success fn_accept arcls" data-id="{{$row->boy_id}}" data-oid="{{$row->order_id}}" data-status = "2" id="show_accept">Accept</button>	
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
	$('.copy').click(function() {
		var total = $('input[class="ids"]:checkbox:checked').length;
		if(confirm('are u sure Copy selected rows ?'))
		{
			$('input[name="action_task"]').val('copy');
			$('#SximoTable').submit();// do the rest here	
		}
	})	
	
});	
</script>	


<script>
$(document).on("click",'.fn_accept',function(){
    var oid = $(this).attr('data-oid');
    var current_status = $(this).attr('data-status');
    var boy_id = $(this).data('id');
	$.ajax({
			url: 'boyneworders/orders',
			type: "get",
			dataType: "json",
			data: {
			    order_id:oid, status:current_status, boy_id:boy_id
			},
			success: function(data) {
				location.reload();
				console.log(data);
				// alert('success');
			
			},
			error: function (error) {
              location.reload();
}
		});
});


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
</script>

	
@stop
