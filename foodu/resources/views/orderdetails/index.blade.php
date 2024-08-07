@extends('layouts.app')

@section('content')
<?php
$cpage	= request()->has('page') ? request()->get('page') : '';
$from	= request()->has('from') ? request()->get('from') : '';
$url	= '?from='.$from.'&page='.$cpage;
$dwnload= ['pdf'=>'PDF','xls'=>'EXCEL','csv'=>'CSV'];
$dwnicon= ['pdf'=>'pdf','xls'=>'excel','csv'=>'csv']; ?>
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
					<button type="button" class="btn bg-transparent text-success border-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-download"></i> Download</button>
					<div class="dropdown-menu dropdown-menu-right" style="">
						@php $i =0; @endphp
						@foreach($dwnload as $dn => $dv)
						@if($i != 0)
						<div class="dropdown-divider"></div>
						@endif
						<a href="{!! url('orderdetails/orderdetailsexport/'.$dn) !!}" class="dropdown-item"><i class="fas fa-file-{!! $dwnicon[$dn] !!}"></i> {!! $dv !!}</a>
						@php $i++; @endphp
						@endforeach
					</div>
			    </div> 
				<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>    
			</div>
			<div class="col-md-4 text-right">
				<div class="input-group ">
					<div class="input-group-prepend">
						<button type="button" class="btn btn-default btn-sm " 
						onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " >Search </button>
					</div>
					<input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." >
				</div>
			</div>    
		</div>
	</div>
	<div class="p-3">	
			<div class="table-container table-given m-0">
				{!! Form::open(array('url'=>'orderdetails?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				<table class="display responsive nowrap " id="{{ $pageModule }}Table">
					<thead>
						<tr>								
							<th> Order Id </th>
							<th> Date </th>														
							<th> Ordered Time </th>	
							<th>Cust Name</th>
							@if(\Auth::user()->group_id!='3')
							<th>Cust Mobile</th>
							@endif
							<th> Shop Name </th>
							<th> Grand Total </th>
							<th> Status </th>
							<th> {!! trans('core.time') !!} </th>	
							<th> Payment Status </th>
							<th> {!! trans('core.abs_payment_type') !!}</th>
							@if(PICKDEL_OPTION == 'enable')
							<th> Customer Preference </th>
							@endif
							@if(PREORDER_OPTION == 'enable')
							<th> Order Type </th>
							@endif
							<th width="70" >View</th>
							<th width="70" >
								@if(in_array(\Auth::user()->group_id,[1,6]))
								{!! Lang::get('core.btn_action') !!}					
								@endif
							</th>								
						</tr>
					</thead>
					<tbody>  
						@foreach ($results as $key => $row)
						<?php  $res_call = \AbserveHelpers::getRestaurantDetails($row->res_id);
						date_default_timezone_set("Asia/Kolkata"); ?>
						<tr @if($row->delivery_type=='razorpay' && $row->delivery =='unpaid') style="background-color: #FBD9D9" @endif>							
							<td width="50">{{$row->id}}</td>	
							<td width="50">{{$row->date}}</td> 
							<td width="50">{{date('g:i a',$row->time)}}</td>
							<td width="50">{{\AbserveHelpers::getuname($row->cust_id)}}</td>	
							@if(\Auth::user()->group_id!='3')						
							<td width="50">{{$row->mobile_num}}</td>
							@endif
							<td width="50">{{\AbserveHelpers::restsurent_name($row->res_id)}}</td>
							@if(\Auth::user()->group_id=='1')
							<td>{{\AbserveHelpers::CurrencyValueBackend($row->grand_total)}}</td>
							@else
							<td>{{\AbserveHelpers::CurrencyValueBackend($row->grand_total)}}</td>
							@endif
							<td><span class="label status  {{  \AbserveHelpers::getStatusLabel($row->status) }}">{{ \AbserveHelpers::getStatusTiming($row->status) }}</span>
							</td>
							<td width="50">{{\AbserveHelpers::getOrderStatusTime($row->id,$row->status)}}</td>
							<td width="50" class="text-center">{!! ($row->delivery =='paid' ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Unpaid</span>')  !!}</td>
							<td width="50">{{ $row->delivery_type }}</td> 
							@if(PICKDEL_OPTION == 'enable')
							<td width="50">{{ strtoupper($row->delivery_preference) }}</td>
							@endif
							<td width="50">{{ strtoupper($row->order_type) }}</td>
							<td>
								<a href="javascript:void(0);" class="btn order-details" data-id="{!!$row->id!!}"><i class="fa fa-info-circle"></i></a>
							</td>
							<td>
								<input type="hidden" value="{{$row->partner_id}}" class="partner_id" />
								<input type="hidden" value="{{$row->id}}" class="orderid" /> 
								<a href="javascript:void(0);" data-toggle="tooltip" title="Accept order" class="order-details1 " data-id="{!!$row->id!!}" style="color: green;"><i class="fa fa-check-circle"></i></a>
								<i data-toggle="tooltip" title="Reject order" class="fa fa-times-circle fn_reject arcls aricon" aria-hidden="true" style="color: red;" data-oid="{!! $row->id !!}"></i> 
								<input type="hidden" value="{{$row->partner_id}}" class="partner_id" />
								<input type="hidden" value="{{$row->id}}" class="orderid" />
								<input type="hidden" value="" data-userid="{{ \Auth::user()->id }}" data-groupid="{{ \Auth::user()->group_id }}" class="user_details" />
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<div class="modal" id="orderModal" role="dialog">
			    <div class="modal-dialog modal-lg">
			      <div class="modal-content order-content">
			        
			      </div>
			    </div>
			  </div>
				<input type="hidden" name="action_task" value="" />
				{!! Form::close() !!}
			</div>
	</div>
</div>
@include('footer')
@include('admin/search')
<script>
$('#{{ $pageModule }}Table').DataTable({
			responsive: true,searching: false, paging: false,
			ordering: false,
			info: false        
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
						$('#abserve-modal').modal('show');
					}
				});
				if(count == 0){
					$('.loaderOverlay').hide();
					$('#abserve-modal').modal('show');
				}
			}
		});
	});
	$(document).on('click','.order-details1',function(){
		var id = $(this).attr('data-id');
		$.ajax({
			type : 'POST',
			url : 'user/allorderdetails',
			data : {id:id,check:"edit"},
			success:function(data){
				$('#orderModal').modal('show');
				$('.order-content').html(data);
			}
		})

	});
	$(document).on("click",'.arcls',function() {
		$('.loaderOverlay').show();
		var status			= ($(this).hasClass('fn_accept')) ? 1 : 5;
		//var order_id		= $(this).closest("tr").find('.orderid').val();
		var order_id 		= $(this).attr("data-oid");
		var selected_item	= $(this).attr("data-selected");
		var $this			= $(this);
		var partner_id = $(this).attr("data-partner");
		$.ajax({
			url		: 'orderdetails/orders',
			type	: "POST",
			dataType: "json",
			data	: {
				order_id	: order_id,
				status		: status,
				selected_item : selected_item,
				partner_id : partner_id
			},
			success: function(data) {
				window.location.reload();
			},
			complete: function(data) {
				$('.loaderOverlay').hide();
			}
		});
	});
	$(document).on("click",'.fn_accept',function(){
	var partner_id = $('.partner_id').val();
	var order_id = $('.orderid').val();
	var $this = $(this);
	$.ajax({
			url: 'orderdetails/orders',
			type: "get",
			dataType: "json",
			data: {
				partner_id : partner_id,order_id:order_id
			},
			success: function(data) {
				console.log(data);
				if(data.message != ''){
					
					$(".sbox").before('<div class="alert '+ data.alert +' fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+data.message+'</div>');
					if(data.id==1)
					{
						$this.closest("tr").find(".label").removeClass().addClass('label label-success').text("Accepted");
					}
					if(data.id==2)
					{
						$this.closest("tr").find(".label").removeClass().addClass('label label-primary').text("Accepted by Boy");

					}
					if(data.id==3)
					{
						$this.closest("tr").find(".label").removeClass().addClass('label label-info').text("Order Dispatch");
					}
					if(data.id==4)
					{
						$this.closest("tr").find(".label").removeClass().addClass('label label-default');
					}
					 if(data.id != 0){						
						// $this.closest("tr").remove();
						$this.closest("td").html('<i class="icon-checkmark-circle2" aria-hidden="true"></i>');

					}
				}
				
			
			}
		});
});
	$(document).on('click','.order-details',function(){
		var id = $(this).attr('data-id');
		$.ajax({
			type : 'POST',
			url : 'user/allorderdetails',
			data : {id:id},
			success:function(data){
				$('#orderModal').modal('show');
				$('.order-content').html(data);
			}
		})

	});
</script>	

@stop
