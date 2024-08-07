@extends('layouts.app')
@section('content')
			<?php
			$cpage	= request()->has('page') ? request()->get('page') : '';
			$from	= request()->has('from') ? request()->get('from') : '';
			$url	= '?from='.$from.'&page='.$cpage;
			$dwnload= ['pdf'=>'PDF','xls'=>'EXCEL','csv'=>'CSV'];
			$dwnicon= ['pdf'=>'pdf','xls'=>'excel','csv'=>'csv']; ?>

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
			<style type="text/css">
				.sbox-title {
			    border-width: 0px;
			    background-color: #364150;
			    color: #fff;
			}
			#btn_right{
			    background: #5bc0de;
			    color: #fff;
			    /*float: left;*/
			    padding: 1px 4px;
			    margin-top: -2px;

			}
			</style>

			<div class="page-header">
					<h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2>
			</div>
			<div class="m-3 box-border">
				<div class="toolbar-nav p-0" >  
		            <div class="sbox-title"> <h5> <i class="fa fa-table"></i> </h5>
		            	@if( \Request::query('search') != '' )
						<a href="{{ URL::to($pageModule) }}" id="btn_right" class="btn btn-xs btn-white tips" title="Clear Search" ><i class="fa fa-trash-o"></i> Clear Search </a>
		            	@endif
					</div>
					<div class="d-flex flex-wrap text-light pt-3 pl-3">
				        <div class="">
							<a class="btn btn-success"  data-toggle="modal" id="searchpopup" data-target="modal" ><i class="fa fa-search text-light"></i> Advanced Search</a>
						</div>
						{{--<div class="pl-5">
				          <button class="btn btn-success download_excel" id="download_excel" > Download excel</button>
						</div>--}}
					</div>	
				</div>	
				<div class="p-3">
					<div class="table-container for-icon m-0">
					<!-- Table Grid -->
		 			{!! Form::open(array('url'=>'weeklypaymentforhost?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				    <table class="table table-hover" id="{{ $pageModule }}Table">
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
											echo '<th align="'.$t['align'].'" '.$addClass.' width="'.$t['width'].'">'.\AbserveHelpers::activeLang($t['label'],(isset($t['language'])? $t['language'] : array())).'</th>';					
										} 
										?>
									@endif
								@endforeach
								<th>Shop(s)</th>
								<th>Paid Amount</th>
								<th>Payable Amount</th>
								<th>Status</th>
								<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
							  </tr>
				        </thead>
					    <tbody>        	
				        <?php $currsymbol = \AbserveHelpers::getCurrencySymbol();?>			@foreach ($rowData as $row)
				                <tr>
									<td class="thead"> {{ ++$i }} </td>
									<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
								 @foreach ($tableGrid as $field)
									 @if($field['view'] =='1')
									 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
									 	@if(SiteHelpers::filterColumn($limited ))
									 	 <?php $addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
										 <td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}</td>
										@endif	
									 @endif					 
								 @endforeach	
								<td style="width: 200px;">{!!\AbserveHelpers::Partnerrestaurants($row->id)!!}</td>

								<?php $paid_amount = \AbserveHelpers::Partnerpaidamount($row->id); ?>
								<td style="width: 200px;">
								  	{!! $currsymbol !!} {!!$paid_amount!!}
								</td>
								<?php $payable_amount = \AbserveHelpers::Partnerpayableamount($row->id); ?>
								<td>
									{!! $currsymbol !!} 
									{!!$payable_amount!!}
								</td>
								<td>
									{!! ((\AbserveHelpers::PartnerpayoutsStatus($row->id)) =='Paid' ? '<span class="label label-success">Paid</span>' : '<span class="label label-danger">Unpaid</span>')  !!}
									
								</td>
								<td>
									<!-- <div class="dropdown">
										  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> {{ __('core.btn_action') }} </button>
										  <ul class="dropdown-menu">
										 	@if($access['is_detail'] ==1)
											<li class="nav-item"><a href="{{ url('weeklypaymentforhost/'.$row->id.'?return='.$return)}}" class="nav-link tips" title="{{ __('core.btn_view') }}"> {{ __('core.btn_view') }} </a></li>
											@endif
											@if($access['is_edit'] ==1)
											<li class="nav-item"><a  href="{{ url('weeklypaymentforhost/'.$row->id.'/edit?return='.$return) }}" class="nav-link  tips" title="{{ __('core.btn_edit') }}"> {{ __('core.btn_edit') }} </a></li>
											@endif
											<div class="dropdown-divider"></div>
											@if($access['is_remove'] ==1)
												<li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link  tips" title="{{ __('core.btn_remove') }}">
												Remove Selected </a></li>
											@endif 
										  </ul>
										</div> -->
										
											@if($payable_amount > 0)
											<a href="{{ URL::to('weeklypaymentforhost/'.$row->id.'/edit')}}" class="tips btn btn-xs btn-primary" title="Click to pay">Click to pay</a>
											@else
											<a href="javascript:void(0)"  class="tips btn btn-xs btn-default" title="Amount must greater than 1 {!! $currsymbol !!}">Click to pay</a>
											@endif

											@if($paid_amount > 0 || $payable_amount > 0)
											<a href="{{ URL::to('weeklypaymentforhost/'.$row->id)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}">History</a> 
											@else
											<a href="javascript:void(0)" class="tips btn btn-xs btn-default" title="{!! Lang::get('core.btn_view') !!}">History</a>
											@endif
											<!-- <a href="javascript:void(0)"  class="tips btn btn-xs btn-default" title="Amount must greater than 1 {!! $currsymbol !!}">Click to pay</a>
											<a href="{{ URL::to('restaurantreport?search=res_id:equal:'.$row->id)}}" class="tips btn btn-xs btn-default" title="{!! Lang::get('core.btn_view') !!}">History</a> -->
											
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
	$(document).on('click','#download_excel',function(){
		$(".loader_event").show();
		var from = $("#from").val();
		var to = $("#to").val();
		// alert(from);
		// alert(to);
		$.ajax({
			type:'POST',
			//url:base_url+"weeklypaymentforhost/phpexcel",
			url:"weeklypaymentforhost/phpexcel",
			dataType: 'json',
			data:{from: from, to: to, page: 'weeklypaymentforhost'},
			success:function(data){
				var res=data.split("~");
				if(res[0]=='0'){
					window.location.href=("resources/views/phpexcel/file/weekpayhost_report_"+res[1]+".xlsx");
				}else{
					alert('Somthing error.Try again');
				}
				$(".loader_event").hide();
			}
		});
	})

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


	$(document).on('click','.advanced_search_btn',function(){
		var search_val,oper,name,search = '';
		var url = window.location.origin + window.location.pathname;
		$('.fieldsearch').each(function(){
			search_val = $(this).find('.search_pop').val();
			oper = $(this).find('.oper').val();
			name = $(this).find('.search_pop').data('name');
			
			var split=$('#searchDate').val().split(' - ');
			var search_date = $('#searchDate').val();
			var split_date=search_date.split(':');
			if(search_val != '' & search_val != 'undefined'){
			search +=  name+':'+oper+':'+search_val+'|';
		}
				window.location.href = url+'?from='+split_date[0]+'&'+'to='+split_date[1]+'&'+'search='+search;
		});
	});	
</script>	
	
@stop
