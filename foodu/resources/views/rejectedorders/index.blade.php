@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="toolbar-nav" >   
	<div class="row">
		<div class="col-md-8">   
		</div>
		<div class="col-md-4 text-right">
				<button type="button" class="tips btn btn-sm btn-white search_pop_btn" data-toggle="modal" ><i class="fa fa-search"></i> Search</button> 
		</div>    
	</div>	
</div>	
<div class="table-container">
	{!! Form::open(array('url'=>'rejectedorders?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
	<table class="table  table-hover " id="{{ $pageModule }}Table">
		<thead>
			<tr>
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
				<th width="70" >View</th>
			</tr>
		</thead>
		<tbody>        						
			@foreach ($rowData as $row)
			<?php $res_call = \AbserveHelpers::getRestaurantDetails($row->res_id); 
			date_default_timezone_set("Asia/Kolkata"); ?>
			<tr @if($row->delivery_type=='razorpay' && $row->delivery =='unpaid') style="background-color: #FBD9D9" @endif>													
				@foreach ($tableGrid as $field)
				@if($field['view'] =='1')
				<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
				@if(SiteHelpers::filterColumn($limited ))
				@if($field['field'] == 'date')
				<td>{{ \AbserveHelpers::getdateformat($row->date) }}</td>
				@elseif($field['field'] == 'time')
				<td>{{date('g:i a',$row->time)}}</td>
				@elseif($field['field'] == 'cust_id')
				<td>{{ AbserveHelpers::getuname($row->cust_id) }}</td>	
				@elseif($field['field'] == 'res_id')
				<td> {{ AbserveHelpers::restsurent_name($row->res_id) }} </td>
				@elseif($field['field'] == 'status')
				<td>
					<span class="label status {{  \AbserveHelpers::getStatusLabel($row->status) }}">{{ \AbserveHelpers::getStatusTiming($row->status) }}</span>
				</td>
				@elseif($field['field'] == 'boy_id')
				<td>{!! AbserveHelpers::getboyname($row->id) !!} </td>
				@elseif($field['field'] == 'delivery_time')
				<td>{{\AbserveHelpers::getOrderStatusTime($row->id,$row->status)}}</td>
				@elseif($field['field'] == 'delivery')
				<td>{!! ($row->delivery =='paid' ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Unpaid</span>')  !!}</td>
				@elseif($field['field'] == 'order_type')
				<td>{{ strtoupper($row->order_type) }}</td>
				@else
				<?php $addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
				<td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >					 
					{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
				</td>
				@endif	
				@endif	
				@endif					 
				@endforeach
				<td>
					@if($row->is_dispute==1)
					<a href="javascript:void(0);" ><span class="label label-danger">Dispute already sent</span></a>
					@else
					<a href="javascript:void(0);" class="dispute" data-id="{!!$row->id!!}"><span class="label label-info">Dispute</span></a>
					@endif

					<a href="javascript:void(0);" class="btn order-details" data-id="{!!$row->id!!}"><i class="fa fa-info-circle"></i></a>
				</td>		 
			</tr>
			@endforeach
		</tbody>
	</table>
	<input type="hidden" name="action_task" value="" />
	{!! Form::close() !!}
</div>
@include('footer')
@include('admin/search')
<script>
	$(document).ready(function(){
		$('.copy').click(function() {
			var total = $('input[class="ids"]:checkbox:checked').length;
			if(confirm('are u sure Copy selected rows ?'))
			{
				$('input[name="action_task"]').val('copy');
				$('#SximoTable').submit();
			}
		})	
	});	
</script>	

@stop
