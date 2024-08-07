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
				<div class="d-flex">
					<div class="button-chng my-1">
						<button type="button" class="tips btn btn-sm btn-white" data-toggle="modal"  id="searchpopup"><i class="fa fa-search"></i> Search</button>
					</div>
					<div class="pl-3"><button class="btn btn-success download_excel" > Download excel</button> 
					</div>    
				</div>
			</div>	
	<div class="p-3">		
		  <div class="table-container for-icon m-0">
				{!! Form::open(array('url'=>'restaurantreport?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				<table class="table  table-hover " id="{{ $pageModule }}Table">
					<thead>
						<tr>
							<th class="number"> Sl.no </th>
							<th>Order Id</th>
							<th>Date</th>
							<th>Shop</th>
							<th>Order Charge</th> 
							<th>Commission Percentage</th>
							<th>Admin Commission</th>
							<th>Net Payable</th>
						</tr>
					</thead>
					<tbody>        						
						@foreach ($rowData as $row)
						<?php
						$order_items = \DB::table('abserve_order_items')->select(\DB::Raw('sum(selling_price * quantity) as sellingPrice'))->where('orderid',$row->id)->where('check_status','yes')->first();?>
						<tr>
							<td width="30"> {{ ++$i }} </td>
							<td> {{ $row->id }} </td>
							<td> {{ $row->date }} </td>
							<td> {{ AbserveHelpers::restsurent_name($row->res_id) }}</td>
							<td> @if($order_items->sellingPrice > 0) {!! number_format(abs($order_items->sellingPrice),2) !!} @else {!! number_format(abs($row->total_price),2) !!} @endif </td>
							<td> {{ $row->comsn_percentage }} </td>
							<td> @if($row->accept_host_amount > 0) {!! number_format(abs($order_items->sellingPrice - $row->accept_host_amount),2) !!} @else {!! number_format(abs($row->total_price - $row->host_amount),2) !!} @endif </td>
							<td> @if($row->accept_host_amount > 0){{ number_format($row->accept_host_amount,2) }} @else {!! number_format($row->host_amount,2) !!} @endif </td>
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
	@include('admin/search')
	<script>
		
	$(document).on('click','#searchpopup',function(){
		$('#abserve-modal').modal('show');
	});
	$(document).on('click','.download_excel',function(){
		$(".loader_event").show();
		var url = document.URL;
		var pathname = url.split('=')[1];
		$.ajax({
            type:'POST',
            url:<?php url(); ?>"restaurantreport/phpexcel",
            dataType: 'json',
            data:{'search':pathname},
            success:function(data){
              var res=data.split("~");
              if(res[0]=='0'){
                  window.location.href=("<?php url(); ?>resources/views/phpexcel/file/res_report_"+res[1]+".xlsx");
              }else{
                  alert('Somthing error.Try again');
              }
              $(".loader_event").hide();             
          }
      });
	
})
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
	
	@stop
