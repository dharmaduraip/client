@extends('layouts.app')

@section('content')
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
	<div class="toolbar-nav"> 
		<button type="button" class="tips btn btn-sm btn-white search_pop_btn" id="tips" data-toggle="modal" ><i class="fa fa-search"></i> Search</button>  
		<div class="message-control" style="display: none;color: #F00;">
		</div> 
		<div class="row">
			<div class="table-container table-given">
				{!! Form::open(array('url'=>'paymentorders?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				<table class="display nowrap" id="example1" cellspacing="0" width="100%"> 
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
							<th>Delivery Boy</th>
							<th>Boy Phone Number</th>
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
							<th width="70" >
								@if(in_array(\Auth::user()->group_id,[1,6,2]))
								{!! Lang::get('core.btn_action') !!}					
								@endif
							</th>								
							<th>Extra</th>
						</tr>
					</thead>
					<tbody class="table_Content">
						@foreach ($rowData as $key => $row)
						<?php $res_call = \AbserveHelpers::getRestaurantDetails($row->res_id); 
						date_default_timezone_set("Asia/Kolkata"); ?>
						<tr @if($row->delivery_type=='razorpay' && $row->delivery =='unpaid') style="background-color: #FBD9D9" @endif>							
							<td width="50">{{$row->id}}</td>	
							<td width="50">{{\AbserveHelpers::getdateformat($row->date)}}</td> 
							<td width="50">{{date('g:i a',$row->time)}}</td>
							<td width="50">{{ AbserveHelpers::getuname($row->cust_id) }}</td>	
							@if(\Auth::user()->group_id!='3')						
							<td width="50">{{$row->mobile_num}}</td>
							@endif
							<td width="50"> {{ AbserveHelpers::restsurent_name($row->res_id) }} </td>
							@if(\Auth::user()->group_id=='1')
							<td>{{\AbserveHelpers::CurrencyValueBackend($row->accept_grand_total)}}</td>
							@else
							<td>{{\AbserveHelpers::CurrencyValueBackend($row->accept_grand_total)}}</td>
							@endif
							<td>
								{!! $n =  AbserveHelpers::getboyname($row->id) !!} 
							</td>
							<td>
								{!! $n =  AbserveHelpers::getboynum($row->id) !!} 
							</td>
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
								@if(\Auth::user()->group_id=='1' || \Auth::user()->group_id == '2')
								<a href="javascript:void(0);" id="reject" data-oid="{!! $row->id !!}"  data-toggle="tooltip" title="Reject Order" ><i class="icon-cancel-circle2 "></i></a>
								@endif
								@if(\Auth::user()->group_id=='1' || \Auth::user()->group_id=='6' || \Auth::user()->group_id=='2')
								@if($row->status == 1 || $row->status == 6)
								&nbsp; <a href="{{ URL::to( 'paymentorders/'.$row->id.'/edit') }}" class="btn btn-sm btn-primary">Assign To Boy</a> 
								@elseif($row->status == '2' || $row->customer_status == 'Packing')
								&nbsp; <a href="{{ URL::to( 'paymentorders/'.$row->id.'/edit') }}" class="btn btn-sm btn-primary">Re-assign To Boy</a> 
								@endif
								@endif
							</td>
							<td>
								<input type="hidden" value="{{$row->partner_id}}" class="partner_id" />
								<input type="hidden" value="{{$row->orderid}}" class="orderid" />
								<input type="hidden" value="" data-userid="{{ \Auth::user()->id }}" data-groupid="{{ \Auth::user()->group_id }}" class="user_details" />
								@if($row->status == 1)
								<span class="label label-info">Waiting for boy to accept</span>
								@endif
								@if($row->status == 3)
								<span class="label label-warning">Order Dispatched</span>
								@endif
								@if(\Auth::user()->group_id == '1' || \Auth::user()->group_id == '2')
								<input type="hidden" id="cod_amount" value="{!! ($row->accept_grand_total) !!}">
								@endif
								@if($row->status == 3 && \Auth::user()->group_id == '1')
								<button type="button" class="btn btn-info aricon arcls fn_picked" data-oid="{!!$row->id!!}"><i class="fa fa-square" style="color:white;" aria-hidden="true" style="cursor: pointer;"></i> Boy Picked</button>
								@endif
								@if($row->status == 'boyPicked')
								<span class="label label-success">Order Picked Up by Boy</span>
								<button type="button" class="btn btn-info aricon arcls fn_arrived" data-oid="{!!$row->id!!}" style="background-color:#2f4050 ;"><i class="fa fa-user-md" style="color:white;cursor: pointer;" aria-hidden="true"></i> Boy Arrived</button>
								@endif
								@if($row->status == 'boyArrived')
								<span class="label label-default">Boy Arrived at customer location</span>
								<button type="button" class="btn btn-info aricon arcls fn_delivered"  data-codamount = "{!!$row->accept_grand_total!!}" data-oid="{!!$row->id!!}" style="background-color: #961111;border-color: #961111;"><i class="fa fa-shipping" style="color:white;cursor: pointer;" aria-hidden="true"></i> Delivered to Customer</button>
								@endif
								@if($row->customer_status == 'Cooking' && $row->status == 2)
								<span class="rem_td">
									<button type="button" class="btn btn-info aricon arcls fn_pack" data-oid="{!!$row->id!!}"><i class="fa fa-plus-square" style="color:white;" aria-hidden="true" style="cursor: pointer;"></i> Enable Packing</button>
								</span>
								@endif
								@if(($row->ordertype == 'pickup' || ($row->ordertype != 'pickup' && $row->boy_id != '0') && $row->customer_status == 'Packing'))
								<span class="rem_td">
									<button type="button" class="btn btn-success aricon arcls  fn_handovertoboy" data-oid="{!!$row->id!!}" ><i class="fa fa-truck" style="color:white;" style="cursor: pointer;"></i>
									Handover to Boy</button>
								</span>
								@endif
								@if($row->ordertype != 'pickup' && $row->boy_id == '0' && $row->customer_status == 'Packing')
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
	</div>		
</div>
@include('footer')
@include('admin/search')
<div class="modal" id="orderModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content order-content">
		</div>
	</div>
</div>
<div id="hidden_block" style="display:none;">
	<b>Select Cancellation Category:</b>
	<select class="form-control" required name="cancel_category_id" id="cancel_category_id">
		<option value="0">Please select</option>
		@foreach( $cancel_categories as $k => $v)
		<option value="{{$v->id}}">{{$v->category_name}}</option>
		@endforeach
	</select>	
	<span id="category_error" style="color:red;" ></span>
</div>
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
<script src="https://www.gstatic.com/firebasejs/4.10.1/firebase.js"></script> 
<?php $googleKey = \AbserveHelpers::site_setting('googlemap_key'); ?>
<script async defer
src="https://maps.googleapis.com/maps/api/js?key={!! $googleKey->googlemap_key !!}&libraries=geometry">
</script>
<script type="text/javascript">
	$(document).on('click','.trackDeliveryBoy',function(){		
		$('.loader_event').show();	
		var orderId = $(this).data('orderid');
		$.ajax({
			type : 'post',
			url : base_url+'/user/trackdeliveryboy',
			data : {orderId : orderId},
			success : function(res){
				$('#trackDeliveryBoy-content').html(res);				
			}
		});
	});	
	var firebaseConfig = {
		apiKey: "AIzaSyD_xl8xANIRl6CBBy2-haLeZp76XwiHdVM",
		authDomain: "grozo-784b8.firebaseapp.com",    
		databaseURL: "https://grozo-784b8-default-rtdb.firebaseio.com/",	    
		storageBucket: "grozo-784b8.appspot.com",    
	};
	firebase.initializeApp(firebaseConfig);
	var database = firebase.database();
</script>
<style>
</style> 
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
	$(document).on('click','.order-details',function(){
		var base_url = '<?php echo URL::to(''); ?>';
		var id = $(this).attr('data-id');
		console.log("jiii");
		$.ajax({
			type : 'POST',
			url : base_url+'/user/allorderdetails',
			data : {id:id},
			success:function(data){
				$(".modal-dialog").removeClass(" modal-sm").addClass(" modal-lg");
				$('#orderModal').modal('show');
				$('.order-content').html(data);
			}
		})
	});
	$(document).on("click",'#reject',function(){
		var oid = $(this).attr('data-oid');
		$(".modal-dialog").addClass(" modal-sm").removeClass(" modal-lg");
		$(".order-content").html('<div class="modal-header"><h4 class="modal-title">Notification</h4><button type="button" class="close" data-dismiss="modal">&times;</button></div><div class="modal-body">'+

			'<div id="import_select"></div>'+
			'<p>Cancel Reason:</p><textarea class="form-control" id="cancel_reason"></textarea><span id="reason_error" style="color:red;" ></span></div><div class="modal-footer"><button class="btn btn-success" type="button" id="reject_submit">Submit</button><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div>');
		$("#reject_submit").attr('data-oid',oid);
		$('#orderModal').modal('show');

		$("#hidden_block").css("display","block");
		$("#import_select").append($("#hidden_block").html());
	});
	$(document).on("click",'#reject_submit',function(){ 
		var oid = $(this).attr('data-oid');
		var reason = $("#cancel_reason").val();
		var cancel_category_id = $("#cancel_category_id").val();
		if(cancel_category_id == 0){
			$("#category_error").html("Cancellation category is empty!"); 
			event.preventDefault();
		}
		if($.trim(reason).length > 0 && cancel_category_id != 0 ){
			$("#reject_submit").attr('disabled','true');

			$.ajax({
				type : 'POST',
				url : 'cancellation_order',
				data : {
					oid : oid,reason:reason, cancel_category_id:cancel_category_id
				},
				success:function(result){
					console.log(result);
					$('#orderModal').modal('hide');
					$('.message-control').show().html(result);
					setTimeout(function(){
						$('.message-control').hide();
						window.location.reload();
					},3000);
				}
			});
		}else if($.trim(reason).length == 0){
			$("#reason_error").html("Reason field is empty!"); 
		}
	});
	$(document).on("keyup",'#cancel_reason',function(){

		if($.trim($(this).val()).length == 0)
			$("#reason_error").html("Reason field is empty!"); 
		else
			$("#reason_error").html(""); 	
	});
	$(document).on("click",'#cancel_category_id',function(){
		if($("#cancel_category_id").val() != 0)
			$("#category_error").html(""); 
		else
			$("#category_error").html("Cancellation category is empty!"); 	
	});
	$(document).on("click",'.arcls',function() {
		var base_url = '<?php echo URL::to(''); ?>';
		$('.loaderOverlay').show();
		// var status		= ($(this).hasClass('fn_reject')) ? 5 : ($(this).hasClass('fn_handovertocus')) ? 4 : ($(this).hasClass('fn_pack')) ? 'Packing' : 3;
		var status	= '3';
		if($(this).hasClass('fn_reject')) {
			status	= '5';
		} else if ($(this).hasClass('fn_handovertocus')){
			status	= '4';
		} else if ($(this).hasClass('fn_pack')) {
			status	= 'Packing';
		} else if ($(this).hasClass('fn_picked')) {
			status  = 'boyPicked';
		} else if ($(this).hasClass('fn_arrived')) {
			status  = 'boyArrived';
		} else if ($(this).hasClass('fn_delivered')) {
			status = '4';
		}
		var order_id	= $(this).attr('data-oid');
		var cod_amount = $(this).attr('data-codamount');
		$.ajax({
			url		: 'orderdetails/orders',
			type	: "POST",
			dataType: "json",
			data	: {
				order_id	: order_id,
				status		: status,
				cod_amount  : cod_amount
			},
			success	: function(data) {	
				window.location.reload();
			},
			complete: function(data) {
				$('.loaderOverlay').hide();
			}
		});
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
	$(document).on("click",'.fn_handovertocus',function(){ 
		var order_id = $(this).attr('data-id');
		var boy_id =  $(this).attr('data-boyid');
		var $this = $(this);
		$.ajax({
			url: '<?php echo URL::to(''); ?>/mobile/user/boyorderdelivered',
			type: "post",
			dataType: "json",
			data: {
				boy_id : boy_id,order_id:order_id
			},
			success: function(data) {
				console.log(data);
				if(data.message != ''){
					$(".sbox").before('<div class="alert alert-success fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Success!</strong> '+data.message+'</div>');
					if(data.id==1)
					{
						$this.closest("tr").find(".label").removeClass().addClass('label label-success').text("Delivered To The Customer");
						$this.closest("tr").find(".rem_td").removeClass().addClass('label label-primary').text("");
					}
					if(data.id==2)
					{
						$this.closest("tr").find(".label").removeClass().addClass('label label-primary').text("Delivered To The Customer");
						$this.closest("tr").find(".rem_td").removeClass().addClass('label label-primary').text("");

					}
					if(data.id==3)
					{
						$this.closest("tr").find(".label").removeClass().addClass('label label-info').text("Doesn't exists");
					}
					if(data.id==4)
					{
						$this.closest("tr").find(".label").removeClass().addClass('label label-default').text("Doesn't exists");
					}
					if(data.id != 0){				
						$this.closest("td").html('<i class="icon-checkmark-circle2" aria-hidden="true"></i>');
					}
				}
			}
		});
	});
</script>
@stop
