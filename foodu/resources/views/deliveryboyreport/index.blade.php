@extends('layouts.app')

@section('content')
	<?php
	$cpage	= request()->has('page') ? request()->get('page') : '';
	$from	= request()->has('from') ? request()->get('from') : '';
	$url	= '?from='.$from.'&page='.$cpage;
	$dwnload= ['pdf'=>'PDF','xls'=>'EXCEL','csv'=>'CSV'];
	$dwnicon= ['pdf'=>'pdf','xls'=>'excel','csv'=>'csv'];
	?>
	<div class="page-header">
		<div class=""><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
		<div class="">
			<ul class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
				<li class="breadcrumb-item active">{{ $pageTitle }}</li>
			</ul>
		</div>
	</div>
	<div class="m-sm-4 m-3 box-border">	
		<div class="sbox-title"> 
			<h5> <i class="fa fa-table"></i> </h5>
			<div class="sbox-tools">
				@if( \Request::query('search') != '' )
				<a href="{{ URL::to($pageModule) }}" style="display: block ! important;" class="btn btn-xs btn-white tips" title="Clear Search" >
					<i class="fa fa-trash-o"></i> {!! trans('core.abs_clr_search') !!} 
				</a>
				@endif
				<a href="#" class="btn btn-xs btn-white tips" title="" data-original-title=" Configuration">
					<i class="fa fa-cog"></i>
				</a>
			</div>
		</div>
		<div class="toolbar-nav" >
			<div class="row">
				<div class="col-md-8 button-chng my-1">
					<div class="btn-group">
						<button type="button" class="tips btn btn-sm btn-white search_pop_btn" data-toggle="modal"><i class="fa fa-search"></i> Search</button></div>
						<button class="btn btn-success download_excel" > Download excel</button>
					</div>
				</div>
			</div>
		</div>
		<div class="p-3">
			<div class="table-container for-icon m-0">
				{!! Form::open(array('url'=>'deliveryboyreport?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				<table class="table  table-hover " id="{{ $pageModule }}Table">
					<thead>
						<tr>
							<th class="number"> No </th>
							<th>Delivery Boy</th>
							<th>Order ID</th>
							<th>Date</th>
							<th>Shop</th>
							<th>Order Value</th>
							<!-- <th>Pickup Distance</th> -->
							<!-- <th>Delivery Distance</th> -->
							<!-- <th>Total Distance & Charge</th> -->
							<th>Distance</th>
							<th>Payment Type</th>
							<th>Total Delivery Charge</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($rowData as $row)
						<?php $distance = \AbserveHelpers::getBoyTravelledReport($row->id); ?>
						<tr>
							<td width="30"> {{ ++$i }} </td>
							<td>{{ AbserveHelpers::getboyname($row->id) }}</td>
							<td>{{ $row->id }}</td>
							<td>{{ $row->date }}</td>
							<td> {{ AbserveHelpers::restsurent_name($row->res_id) }} </td>
							<td>{{ $row->del_charge }}</td>
							<!-- <td>{{ $distance['pickup'] }} KM</td> -->
							<!-- <td>{{ $distance['delivery'] }} KM</td> -->
							<!-- <td>{{ $distance['total'] }} KM </td> -->
							<td>{{$row->del_km}} KM</td>
							<td>{{ $row->delivery_type }} </td>
							<td>{{ AbserveHelpers::getDeliveryChargeForBoy($row->del_km) }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<input type="hidden" name="action_task" value="" />
				{!! Form::close() !!}
				<!-- End Table Grid -->
			</div>
		</div>
	</div>
@include('footer')
@include('admin/search')
<script>
	$(document).ready(function(){
		$(document).on('click','#searchpopup',function(){
			$('#abserve-modal').modal('show');
		});
		$('.copy').click(function() {
			var total = $('input[class="ids"]:checkbox:checked').length;
			if(confirm('are u sure Copy selected rows ?'))
			{
				$('input[name="action_task"]').val('copy');
				$('#SximoTable').submit();// do the rest here
			}
		})
	});
	$(document).on('click','.download_excel',function(){
		$(".loader_event").show();
		var url = document.URL;
		var pathname = url.split('=')[1];
		$.ajax({
			type:'POST',
			url:"deliveryboyreport/phpexcel",
			dataType: 'json',
			data:{'search':pathname},
			success:function(data){
				var res=data.split("~");
				if(res[0]== 0){
					window.location.href=("resources/views/phpexcel/file/delboy_report_"+res[1]+".xlsx");
				}else{
					alert('Somthing error.Try again');
				}
				$(".loader_event").hide();             
			}
		});
	});
</script>
@stop