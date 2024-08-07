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

			<?php 
			if(isset($_GET['from']) && $_GET['from']!=''){
			//$from=base64_decode(explode("||",$_GET['search'])[0]);
			//$to=base64_decode(explode("||",$_GET['search'])[1]);
			$from=$_GET['from'];
			$to=$_GET['to'];
			$search=base64_encode(date('d-m-Y',strtotime($from))).'||'.base64_encode(date('d-m-Y',strtotime($to)));
			$searchView=date('Y-m-d',strtotime($from)).':'.date('Y-m-d',strtotime($to));
			}
			else{
			$from=date('Y-m-d', strtotime('+1 days'));
			$to=date('Y-m-d', strtotime('-1 days'));
			$search=base64_encode(date('Y-m-d', strtotime('+1 days'))).'||'.base64_encode(date('Y-m-d', strtotime('-1 days')));
			$searchView=date('Y-m-d',strtotime('monday this week')).':'.date('Y-m-d',strtotime('sunday this week'));
		}
			?>
			

<!--<div class="toolbar-nav" >   
	<div class="row">
		<div class="col-md-8 button-chng my-1"> 	

		 <button type="button" class="tips btn btn-sm btn-white " data-toggle="modal"  id="searchpopup"><i class="fa fa-search"></i> Search</button> 

			<a class="btn btn-success"  data-toggle="modal" data-target="#neworder_modal" id="searchpopup" ><i class="fa fa-search"></i> Advanced Search</a>

					<a href="{{ URL::to($pageModule) }}" class="btn btn-xs btn-white tips" title="Clear Search" ><i class="fa fa-trash-o"></i> Clear Search </a>
					@if(Session::get('gid') ==1)
					<a href="{{ URL::to('abserve/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title="{!! Lang::get('core.btn_config') !!}" ><i class="fa fa-cog"></i></a>
					@endif
			


			@if($access['is_add'] ==1)
			<a href="{{ url('weeklypaymentfordeliveryboy/create?return='.$return) }}" class="btn  btn-sm"  
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create  </a>
			@endif

			<div class="btn-group">
				<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> Bulk Action </button>
				<button type="button" class="btn bg-transparent text-success border-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-download"></i> Download</button>
				<div class="dropdown-menu dropdown-menu-right" style="">
					@php $i =0; @endphp
					@foreach($dwnload as $dn => $dv)
					@if($i != 0)
					<div class="dropdown-divider"></div>
					@endif
					<a href="{!! url('weeklypaymentfordeliveryboy/weeklypaymentboyexport/'.$dn) !!}" class="dropdown-item"><i class="fas fa-file-{!! $dwnicon[$dn] !!}"></i> {!! $dv !!}</a>
					@php $i++; @endphp
					@endforeach
				</div>
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
				
				<div class="dropdown-divider"></div>
					<li class="nav-item"><a href="{{ url($pageModule) }}"  class="nav-link "> Clear Search </a></li>
		          	
		        
		          
		        </ul>
		    </div>    
		</div> -->
		<!-- <div class="col-md-4 text-right">
			<div class="input-group ">
			      <div class="input-group-prepend">
			        <button type="button" class="btn btn-default btn-sm " 
			        onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " ><i class="fa fa-filter"></i> Filter </button>
			      </div>
			      <input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." placeholder=" Type And Hit Enter ">
			    </div>
		</div>     
	</div>	
</div>-->
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

		 <div class="d-flex pl-4 pt-4">
			<a class="btn btn-success text-light"  data-toggle="modal" data-target="#neworder_modal" id="searchpopup" ><i class="fa fa-search text-light"></i> Advanced Search</a>
		 </div>	
		<div class="p-3">
			<div class="table-container for-icon m-0">

						<!-- Table Grid -->
						
			 			{!! Form::open(array('url'=>'weeklypaymentfordeliveryboy?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
						
					    <table class="table  table-hover " id="{{ $pageModule }}Table">
					        <thead>
								<tr>
									<th style="width: 3% !important;" class="number"> No </th>
									<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
									
									
									@foreach ($tableGrid as $t)
										@if($t['view'] =='1')				
											<?php $limited = isset($t['limited']) ? $t['limited'] :''; 
											if(AbserveHelpers::filterColumn($limited ))
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
									<th>Paid Amount</th>
									<th>Payable Amount</th>
							     	<th>Status</th>

									<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
									
								  </tr>
					        </thead>

					        <tbody>     
					        <?php $currsymbol = \AbserveHelpers::getCurrencySymbol(); ?>   						
					            @foreach ($rowData as $row)
					                <tr>
										<td class="thead"> {{ ++$r }} </td>
										<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
																							
									 @foreach ($tableGrid as $field)
										 @if($field['view'] =='1')
										 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
										 	@if(SiteHelpers::filterColumn($limited ))
										 	 <?php $addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
											 <td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >					 
											 	{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
											 </td>
											@endif	
										 @endif					 
									 @endforeach	

		   
									 	<!-- <?php $pay_amount = \AbserveHelpers::getDel_boy_payable_weekly_amt($row->id,$from,$to,'0');
									 		
									 	if($pay_amount > 0){ ?>
								     <td>{!! $pay_amount !!} {!! $currsymbol !!}</td>
								   <?php }else{
								   $paid_amount = \AbserveHelpers::getDel_boy_payable_weekly_amt($row->id,$from,$to,'1'); ?>
								   	<td>{!! $paid_amount !!} {!! $currsymbol !!}</td>
								   <?php } ?> -->

								   <?php  $payable_amount = \AbserveHelpers::Delboypayableamount($row->id);
								   				$paid_amount = \AbserveHelpers::Delboypaidamount($row->id); ?>

									   <td style="width: 200px;">
										  	{!! $currsymbol !!} {!!$paid_amount!!}
										</td>

										<td style="width: 200px;">
										  	{!! $currsymbol !!} {!!$payable_amount!!}
										</td>

								        {{--<td>{!!explode('~',\AbserveHelpers::getWeekly_payable_status($row->id,$from,$to,'2'))[1]!!}</td>--}}

								        <td>
													{!! ((\AbserveHelpers::DeliveryboypayoutsStatus($row->id)) =='Paid' ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Unpaid</span>')  !!}
													
												</td>	

									 	<td>

									 		@if($payable_amount > 0)
									 		<a href="{{ URL::to('weeklypaymentfordeliveryboy/'.$row->id.'/edit')}}" class="tips btn btn-xs btn-primary" title="Click to pay">Click to pay</a>
									 		@else
									 		<a href="javascript:void(0)"  class="tips btn btn-xs btn-default" title="Amount must greater than 1 {!! $currsymbol !!}">Click to pay</a>
									 		@endif
									 		@if($paid_amount > 0 || $payable_amount > 0)
											<a href="{{ URL::to('weeklypaymentfordeliveryboy/'.$row->id)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}">History</a>
											@else
											<a href="javascript:void(0)" class="tips btn btn-xs btn-default" title="{!! Lang::get('core.btn_view') !!}">History</a>
											@endif

										 <!-- @if(explode('~',\AbserveHelpers::getWeekly_payable_status($row->id,$from,$to,'2'))[0]=='1')
									@if(\AbserveHelpers::getDel_boy_payable_weekly_amt($row->id,$from,$to)>=1)
									<a href="{{ URL::to('weeklypaymentfordeliveryboy/'.$row->id.'/edit?date='.$search)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}">Click to pay</a>
									<a href="{{ URL::to('deliveryboyreport/boyreport?search=boy_id:equal:'.$row->id.'|date:between:'.$searchView)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}">History</a> 

									@else
									<a href="javascript:void(0)"  class="tips btn btn-xs btn-default" title="Amount must greater than 1 {!! $currsymbol !!}">Click to pay</a>
									<a href="javascript:void(0)" class="tips btn btn-xs btn-default" title="{!! Lang::get('core.btn_view') !!}">History</a>

									@endif
									@endif -->
										</td>	 
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
$(document).on('click','#searchpopup',function(){
	$('#abserve-modal').modal('show');
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

// $(document).on('click','.advanced_search_btn',function(){

// 	var search_val,oper,name,search = '';
// 	var url = window.location.origin + window.location.pathname;
// 	$('.fieldsearch').each(function(){

// 		search_val = $(this).find('.search_pop').val();
// 		alert(search_val);
// 		return false;
// 		oper = $(this).find('.oper').val();
// 		name = $(this).find('.search_pop').data('name');
		
// 		var split=$('#searchDate').val().split(' - ');
		
// 		var search_date = $('#searchDate').val();
		
// 		if(search_date != '' & search_date != 'undefined'){
			
// 		search +=  name+':'+oper+':'+search_val+'|';
// 		alert(split[0]);
// 		 var split_date=split[0].split(':');

// 		alert(split_date[0]); alert('test');
// 		alert(split_date[1]);
// 		alert(search);

// 	}
// 			window.location.href = url+'?from='+split_date[0]+'&'+'to='+split_date[1]+'&'+'search='+search;
// 	});
// });

$(document).on('click','.advanced_search_btn',function(){

	var search_val,oper,name,search = '';
	var url = window.location.origin + window.location.pathname;
	$('.fieldsearch').each(function(){
		search_val = $(this).find('.search_pop').val();
		
		oper = $(this).find('.oper').val();
		name = $(this).find('.search_pop').data('name');
		var split=$('#searchDate').val().split(' - ');
		var search_date = $('#searchDate').val();
		// alert(oper);
		// alert(name);
		var split_date=search_date.split(':');
		if(search_val != '' & search_val != 'undefined'){

		search +=  name+':'+oper+':'+search_val+'|';
	}
			window.location.href = url+'?from='+split_date[0]+'&'+'to='+split_date[1]+'&'+'search='+search;
	});
});


</script>	
	
@stop
