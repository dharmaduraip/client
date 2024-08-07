@extends('layouts.app')
@section('content')
<?php
$cpage	= request()->has('page') ? request()->get('page') : '';
$from	= request()->has('from') ? request()->get('from') : '';
$url	= '?from='.$from.'&page='.$cpage;
$dwnload= ['pdf'=>'PDF','xls'=>'EXCEL','csv'=>'CSV'];
$dwnicon= ['pdf'=>'pdf','xls'=>'excel','csv'=>'csv']; ?>
<?php $baseCurSymbol = \AbserveHelpers::getBaseCurrencySymbol();?>
<div class="page-header"><div class=""><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
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
			@if( \Request::query('search') != '' && (\Auth::user()->group_id != '5' && \Auth::user()->group_id != '2') )
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
				@if($access['is_add'] ==1)
				<a href="{{ url('deliverychargesettings/create?return='.$return) }}" class="btn  btn-sm"
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create  </a>
				@endif
				<a href="javascript://ajax"  onclick="SximoDelete();" class="btn  btn-sm" title="{{ __('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
				Remove  </a>
				<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>
				<button type="button" class="btn bg-transparent text-success border-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-download"></i> Download</button>
				<div class="dropdown-menu dropdown-menu-right" style="">
					
					<?php 
					 $i =0; 
					 ?>
					@foreach($dwnload as $dn => $dv)
					@if($i != 0)
					<div class="dropdown-divider"></div>
					@endif
					<a href="{!! url('deliverychargesettings/deliveryExports/'.$dn.'?search='.\Request::query('search')) !!}" class="dropdown-item"><i class="fas fa-file-{!! $dwnicon[$dn] !!}"></i> {!! $dv !!}</a>
					
					<?php 
					 $i++; ?>

					@endforeach
				</div>
				<!-- <button type="button" class="tips btn btn-sm btn-white" data-toggle="modal" data-target="#edit_restaurent_det" data-original-title="" id="mymodal" title=""><i class="fa fa-plus-circle"></i> Additional charge settings</button> -->


				<button type="button" class="tips btn btn-sm btn-white" data-toggle="modal" data-target="#edit_restaurent_det" data-original-title="" id="mymodal" title=""><i class="fa fa-plus-circle"></i> Additional charge settings</button>
			</div>
		</div>	
	</div>

	<div class="p-3">
		<div class="table-container for-icon m-0">
	{!! Form::open(array('url'=>'deliverychargesettings/store'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
			<table class="table  table-hover " id="{{ $pageModule }}Table">
				<thead>
					<tr>
						<th class="number"> No </th>
						<th> <input type="checkbox" class="checkall" /></th>
						<th> Charge Type </th>
						<th> Charge Value </th>
						<th> Order Value </th>
						<th> Distance </th>
						<th> Tax </th>
						<th> Status </th>
						<th> Location </th>
						<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
					</tr>
				</thead>
				<tbody>        						
					@foreach ($rowData as $row)
					<tr>
						<td class="thead"> {{ ++$i }} </td>
						<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
						<td>{{$row->charge_type}}</td>														
						<td>{{$row->charge_value}}</td>
						@if($row->order_value_type == 'above')
						<td>Above {{$row->order_value_min}}</td>
						@else	
						<td>{{$row->order_value_min}} - {{$row->order_value_max}}</td>
						@endif
						@if($row->distance_type == 'above')
						<td>Above {{$row->distance_min}}</td>
						@else   	
						<td>{{$row->distance_min}} - {{$row->distance_max}}</td>
						@endif	
						<td>{{$row->tax}}</td>
						<td>{{$row->status}}</td>
						<td>{!! \AbserveHelpers::locationName($row->location)!!}</td>
						<td>
							@if($access['is_detail'] ==1)
							<a href="{{url('deliverychargesettings/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>
							@endif
							@if($access['is_edit'] == 1)
							<a  href="{{ url('deliverychargesettings/'.$row->id.'/edit?return='.$return) }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
							@endif
						</td>		
					</tr>
					@endforeach
				</tbody>
			</table>
			<input type="hidden" name="action_task" value="" />
			{!! Form::close() !!}

	</div>
</div>

<div class="modal fade" id="edit_restaurent_det" tabindex="-1" role="dialog" aria-hidden="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-default ">
				<button type="button " class="close" data-dismiss="modal">×</button>
				<h4 class="modal-title w-100 text-center position-absolute ">Additonal charges</h4>
			</div>
			<div class="modal-body" id="modal-content"><div>
				<form action="{!!URL::to('/')!!}/restauranttax" method="POST">
					<table class="table search-table table-striped" id="advance-search">
						<tbody>
							<tr id="payment_type" class="">
								<td>Delivery Upto (<strong><=</strong>)</td>
								<td id="field_time">{!! Form::text('km', $tax->km,array('class'=>'form-control float_number', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number' ,'id'=>'km'  )) !!}</td>
							</tr>
							<tr id="payment_type" class="">
								<td>Delivery charge upto (<b></td>
								<td id="field_time">{!! Form::text('upto_four_km', $tax->upto_four_km,array('class'=>'form-control float_number', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number' ,'id'=>'upto_four_km'  )) !!}</td>
							</tr>
							<tr id="payment_type" class="">
								<td>Additional charges Per KM ({!! $baseCurSymbol !!})</td>
								<td id="field_time">{!! Form::text('per_km', $tax->per_km,array('class'=>'form-control float_number', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number' ,'id'=>'per_km'  )) !!}</td>
							</tr>
							<tr id="payment_type" class="">
								<td>Delivery charge tax (%)</td>
								<td id="field_time">{!! Form::text('delivery_tax', $tax->delivery_tax,array('class'=>'form-control float_number', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number' ,'id'=>'delivery_tax'  )) !!}</td>
							</tr>
							<tr id="payment_type" class="">           
								<td>Festival Charge ({!! $baseCurSymbol !!})</td>
								<td id="field_time">{!! Form::text('festival_charge', $tax->festival_charge,array('class'=>'form-control float_number', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number','id'=>'festival_charge'   )) !!}</td>
							</tr>
							<tr id="payment_type" class="">           
								<td>Delivery boy Charge ({!! $baseCurSymbol !!})</td>
								<td id="field_time">{!! Form::text('delivery_boy_charge_per_km', $tax->delivery_boy_charge_per_km,array('class'=>'form-control float_number', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number','id'=>'delivery_boy_charge_per_km'   )) !!}</td>
							</tr>
							<tr id="payment_type" class="">           
								<td>Bad Weather Charge ({!! $baseCurSymbol !!})</td>
								<td id="field_time">{!! Form::text('bad_weather_charge', $tax->bad_weather_charge,array('class'=>'form-control float_number', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number','id'=>'bad_weather_charge'   )) !!}</td>
							</tr>
							<tr>
								<td class="text-right" colspan="3"><button type="submit" name="submit" class="btn btn-sm btn-primary order_search_btn"> Update </button></td>      
							</tr>
						</tbody>
					</table>
				</form> 
			</div>
		</div>
	</div>
</div>
</div>

@include('admin/search')

<script type="text/javascript">
	$(document).ready(function(){
		$('.copy').click(function() {
			var total = $('input[class="ids"]:checkbox:checked').length;
			if(confirm('are u sure Copy selected rows ?'))
			{
				$('input[name="action_task"]').val('copy');
$('#SximoTable').submit();// do the rest here	
}
})
		$(".search_pop_btn").on('click', function(){
			$('.loaderOverlay').show();
			$.ajax({
				url:'user/userdatas',
				type: 'post',
				dataType : 'json',
				data: { group_id : '4', type : 'users' },
				success:function(res){
					var count = res.datas.length;
					$('.usernameDatas').html('<option value="">Select</option>');
					$.each(res.datas, function(key,value){
						$('.usernameDatas').append('<option value="'+value.id+'">'+value.username+'</option>');
						if(!--count){
							$('.loaderOverlay').hide();
							$('#neworder_modal').modal('show');
						}
					});
					if(count == 0){
						$('.loaderOverlay').hide();
						$('#neworder_modal').modal('show');
					}
				}
			});
		});
		$(document).on('click','.order_search_btn',function(){
			var search_val,oper,name,search = '';
			var url = window.location.origin + window.location.pathname;
			$('.fieldsearch').each(function(){
				search_val = $(this).find('.search_pop').val();
				oper = $(this).find('.oper').val();
				name = $(this).find('.search_pop').data('name');
				if(search_val != ''){
					search +=  name+':'+oper+':'+search_val+'|';
				}
			});
			window.location.href = url+'?search='+search;
		});
		$('#mymodal').click(function() {
			$('#edit_restaurent_det').modal('show');
		});
	});
</script>
@stop