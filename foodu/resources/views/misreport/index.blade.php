@extends('layouts.app')

@section('content')
<?php
$cpage	= request()->has('page') ? request()->get('page') : '';
$from	= request()->has('from') ? request()->get('from') : '';
$url	= '?from='.$from.'&page='.$cpage;
$dwnload= ['pdf'=>'PDF','xls'=>'EXCEL','csv'=>'CSV'];
$dwnicon= ['pdf'=>'pdf','xls'=>'excel','csv'=>'csv']; ?>
<style type="text/css">
	.add{
		height: 75px;
		overflow-y: scroll;
		display: block;
		width: 120px;
		font-size: 12px !important;
	}
</style>
<style type="text/css">
	.tableFixHead {
		overflow: auto;
		height: 100px;
	}

	.tableFixHead thead tr th {
		position: sticky;
		top: 0;
		z-index: 99;
	}

	#example1_wrapper{
		height: 490px;
	}
</style>
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
				<div class="d-flex flex-wrap justify-content-end">
					<div class="button-chng my-1">
						<div class="btn-group">
							<form id="dailyreportSearch">		
								<?php if(isset($_GET['search']) && $_GET['search']!=''){
									$exp=explode("date:between:", $_GET['search'])[1];
									$exp1=explode(":", $exp);
									$from=$exp1[0];
									$to=$exp1[1];
								}else{
									$from = '';
									$to = '';
									} ?>		 	
								<div class=""><input type="text" autocomplete="off" name="searchDate" id="searchDate" value="" class="form-control" placeholder="Search Date"></div>
								<input type="hidden" name="sdate" id="sdate" value="{!! $from !!}">
								<input type="hidden" name="edate" id="edate" value="{!! $to !!}">
								<div class="">
									<button class="btn btn-success order_search_btn" type="button" > Search</button></div>
							</form>
							</div>
						</div>
						<div class="pl-2 button-chng my-1">
							<div class="btn-group">
								<div class=""><button class="btn btn-success download_excel" > Download excel</button>
								</div>    
							</div>   
						</div>	
			</div>	
	<div class="p-1 table-top">	 
				<div class="table-responsive data-table1 tableFixHead" style="min-height:500px;">
					{!! Form::open(array('url'=>'misreport?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
			<table class="table table-striped " id="example1">
						<thead>
							<tr>
								<th>Sl.no</th>
								<th>Order Date</th>
								<th>Order ID</th>
								<th>Customer ID</th>
								<th>Customer Name</th>
								<th>Customer Mobile</th>
								<th>Customer Mail</th>
								<th class="">Delivery Address</th>
								<th>Store ID</th>
								<th>Store Name</th>
								<th class= "">Store Address</th>
								<th>Store Price</th>
								<th>Total Base Price</th>
								<th>Gst Amount(of the item)</th>
								<th>Total Amount Hiked</th>
								<th>GST on Hiked Amount</th>
								<th>Final Product Price</th>
								<th>Delivery Fees</th>
								<th>Delivery Tax</th>
								<th>Conv. Fee</th>
								<th>Conv. Tax</th>
								<th>Total Cost</th>
								<th>Promo Code Discount</th>
								<th>Promo Amount</th>
								<th>Order Value</th>
								<th>Commission Percentage</th>
								<th>Commission Value</th>
								<th>Net Payable to Shop</th>
								<th>Total Earning</th>
								<th>Payment Mode</th>
								<th>Delivery Boy Name</th>
								<th>Pickup Travel in KM</th>
								<th>Delivery Travel In KM</th>
								<th>Total Travel</th>
								<th>Rate Per KM</th>
								<th>TA Earned</th>
								<th>Order Placed time</th>
								<th>Accepted Time</th>
								<th>Dispatched time</th>
								<th>Completed time</th>
								<th>Detail View</th>
							</tr>
						</thead>
						<tbody>        						
							@foreach ($rowData as $row)
							<tr>
								<?php 
								$distance = \AbserveHelpers::getBoyTravelledReport($row->id);
								if($row->coupon_id>0){
									$coupon_code=\DB::table('abserve_promocode')->where('id',$row->coupon_id)->first();
									$Ccode=$coupon_code->promo_code;

								}else{
									$Ccode='';
								}
								$order_items = \DB::table('abserve_order_items')->select(\DB::Raw('sum(base_price * quantity) as baseprice'),\DB::Raw('sum((price - base_price) * quantity) as gst_amount'),\DB::Raw('sum(hiking_gst_price * quantity) as hikingGstPrice'),\DB::Raw('sum(admin_cmsn_amt * quantity) as admin_cmsn_value'),\DB::Raw('sum(((base_price - admin_cmsn_amt) + vendor_gstamount) * quantity) as netPayableShop'),\DB::Raw('sum((hiking_price) * quantity) as totalHikingPrice'),\DB::Raw('sum((hiking_gst_price) * quantity) as totalHikingGST'),\DB::Raw('sum((base_price + base_price_gst + hiking_price + hiking_gst_price) * quantity) as finalPPrice'))->where('orderid',$row->id)->where('check_status','yes')->first();
								?>
								<td> {{ ++$i }} </td>	
								<td>{!!date('d-m-Y',strtotime($row->date))!!}</td>
								<td>{!!$row->id!!}</td>
								<td>{!!$row->cust_id!!}</td>
								<td>{!!\AbserveHelpers::getuname($row->cust_id)!!}</td> 
								<td>{!!\AbserveHelpers::getumobile($row->cust_id)!!}</td>
								<td>{!!\AbserveHelpers::getuemail($row->cust_id)!!}</td>
								<td class="add">{!!$row->address!!}</td>
								<td>{!!$row->res_id!!}</td>
								<td>{!!\AbserveHelpers::restsurent_name($row->res_id)!!}</td>
								<td class="add">{!!\AbserveHelpers::restsurent_address($row->res_id)!!}</td>
								<td>{{-- {!!number_format($row->total_price,2)!!} --}} {!!number_format($row->accept_host_amount,2)!!}</td>
								<td>{!!number_format($order_items->baseprice,2)!!}</td>
								<td>{!!number_format($row->gst,2)!!}</td>
								<td>{!!number_format($order_items->totalHikingPrice,2)!!}</td>
								<td>{!!number_format($order_items->totalHikingGST,2)!!}</td>
								<td>{!!number_format($order_items->finalPPrice,2)!!}</td>
								<td>{!!number_format($row->del_charge,2)!!}</td>
								<td>{!!number_format($row->del_charge_tax_price,2)!!}</td>
								<td>{!!number_format(0,2)!!}</td>
								<td>{!!number_format(0,2)!!}</td>
								<td>{!!number_format($row->accept_grand_total,2)!!}</td>
								<td>{{-- !!$Ccode!! --}} {!!$row->coupon_value!!}</td>
								<td>{!!number_format($row->accept_coupon_price,2)!!}</td>
								<td>{!!number_format($row->accept_grand_total,2)!!}</td>
								<td>{!!$row->comsn_percentage!!}</td>
								<td>{{-- number_format($row->fixedCommission,2) --}} {!!number_format($order_items->admin_cmsn_value,2)!!}</td>
								<td>{!!number_format($order_items->netPayableShop,2)!!}</td>
								<td>{!!number_format(($row->accept_grand_total - $order_items->netPayableShop),2)!!}</td>
								<td>{!!$row->delivery_type!!}</td>
								<td>{!!\AbserveHelpers::getboyname($row->id)!!}</td>
								<td>{{ $distance['pickup'] }} KM</td>
								<td>{{ number_format($distance['delivery'],2) }} KM</td>
								<?php $del_dist = number_format($distance['total'],2) ?>
								<td>{{ $del_dist }} KM</td>
								<?php $api_settings= \DB::table('tb_settings')->select('delivery_boy_charge_per_km')->first();
								$rate= $api_settings->delivery_boy_charge_per_km; 
								$ta_earn = ($api_settings->delivery_boy_charge_per_km) * $del_dist;?>
								<td>{{ number_format($rate,2)  }} KM </td>
								<td>{{ number_format($ta_earn,2)  }} </td>
								<td>{{date('g:i a',$row->time)}}</td>
								<td>@if($row->accepted_time>0) {!!date('d-m-Y h:i a',$row->accepted_time)!!} @endif</td>
								<td>@if($row->dispatched_time>0) {!!date('d-m-Y h:i a',$row->dispatched_time)!!} @endif</td>
								<td>@if($row->completed_time>0) {!!date('d-m-Y h:i a',$row->completed_time)!!} @endif</td>
								<td><a href="{{ URL::to( 'misreport/misorder/'.$row->id) }}" class="btn btn-success mis-report btn-mis" data-id="{!!$row->id!!}" id="download">Detail View</a></td>	
							</tr>
							@endforeach
						</tbody>
					</table>
					<input type="hidden" name="action_task" value="" />
					{!! Form::close() !!}
				</div>
	</div>
</div>
		@include('footer')
<link rel="stylesheet" type="text/css" media="all" href="{{ asset('sximo5/css/admin/daterangepicker/daterangepicker.css') }}" />
<script type="text/javascript" src="{{ asset('sximo5//js/admin/daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('sximo5/js/admin/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">
		$(document).ready(function(){
			$('#example1').DataTable( {
				responsive: true,searching: false, paging: false,
				ordering: false,
				info: false 
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
			$('#searchDate').daterangepicker({
				"ranges": {
					"Today": [
					new Date(),
					new Date()
					],
					"Yesterday": [
					new Date().setDate(new Date().getDate() - 1),
					new Date().setDate(new Date().getDate() - 1)
					],
					"Last Week": [
					new Date().setDate(new Date().getDate() - 6),
				new Date()
				],	        	        
				"Last Month": [
				new Date(new Date().getFullYear(), new Date().getMonth()-1, 1),
				new Date(new Date().getFullYear(), new Date().getMonth(), 0)
				],
				"This Month": [
				new Date(new Date().getFullYear(), new Date().getMonth(), 1),
				new Date()
				]
			},	    
			"autoApply": true,	    
			"showCustomRangeLabel": true,	    	    
			"maxDate": new Date(),
			"locale": {
				"format": 'Y-MM-DD'
			}
		}, function(start, end, label) {	  
			var start_date = $.datepicker.formatDate('yy-mm-dd', start._d);  	  
			var end_date = $.datepicker.formatDate('yy-mm-dd', end._d);  	  	  	  	  
			$('#sdate').val(start_date);
			$('#edate').val(end_date);     
		});	

		var sDate = $('#sdate').val();
		var eDate = $('#edate').val();     

		if(sDate != '' && eDate != ''){		
			$('#searchDate').data('daterangepicker').setStartDate(sDate);
			$('#searchDate').data('daterangepicker').setEndDate(eDate);
		}else{
			$('#searchDate').val('');
		}	

	});

</script>	

<script>
	$(document).on('click','.order_search_btn',function(){
		var search_val,oper,name,search = '';
		var url = window.location.origin + window.location.pathname;
		if($("#searchDate").val()!=''){
			var split=$("#searchDate").val().split(' - ');
			window.location.href = url+'?search=date:between:'+split[0]+':'+split[1];
		}else{
			alert('Must choose start date and end date');
		}

	});
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
	$(document).on('click','.download_excel',function(){

		$(".loader_event").show();
		var sdate=$("#searchDate").val().split(' - ')[0];
		var edate=$("#searchDate").val().split(' - ')[1];
		$.ajax({
			type:'POST',
			url:"misreport/phpexcel",
			dataType: 'json',
			data:{'sdate':sdate,'edate':edate},
			success:function(data){
				var res=data.split("~");
				if(res[0]=='0'){
					window.location.href=("resources/views/phpexcel/file/mis_report_"+res[1]+".xlsx");
				}else{
					alert('Somthing error.Try again');
				}
				$(".loader_event").hide();             
			}
		});

	})
</script>	

@stop
