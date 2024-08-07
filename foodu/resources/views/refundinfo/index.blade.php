@extends('layouts.app')

@section('content')
<div class="page-header">
	<h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2>

	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
		<li class="breadcrumb-item active">{{ $pageTitle }}</li>
	</ul>	  

</div>
</div>
<div class="toolbar-nav" > 
	<div class="sbox-title"> 
		<h5> <i class="fa fa-table"></i> </h5>

		<div class="sbox-tools">
			<a href="{{ URL::to($pageModule) }}" style="display: block ! important;" class="btn btn-xs btn-white tips" title="Clear Search" >
				<i class="fa fa-trash-o"></i> {!! trans('core.abs_clr_search') !!} 
			</a>
			@if( \Request::query('search') != '' )

			@endif
			<a href="#" class="btn btn-xs btn-white tips" title="" data-original-title=" Configuration">
				<i class="fa fa-cog"></i>
			</a>	 
		</div>
	</div>  
	<div class="row">
		<div class="col-md-8 button-chng my-1 mt-4"> 	
			@if($access['is_add'] ==1)
			<a href="{{ url('refundinfo/create?return='.$return) }}" class="btn  btn-sm"  
			title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create New </a>
			@endif
			<div class="col-sm">
				<a class="btn btn-success" id="searchpop"  data-toggle="modal" data-target="#neworder_modal" ><i class="fa fa-search"></i> Advanced Search</a>
			</div>
		</div>    
	</div>
	<div class="col-md-4 text-right">
		<div class="input-group ">
			<div class="input-group-prepend">
			</div>
		</div>    
	</div>
	<div class="alert alert-success adminActionRefundMessage" style="display: none;">
	</div>
	<div class="alert alert-danger adminActionRefundMessage" style="display: none;">

	</div>
	<div class="p-3">	
		<div class="table-container m-0">
			{!! Form::open(array('url'=>'refundinfo?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}

			<table class="table  table-hover " id="{{ $pageModule }}Table">
				<thead>
					<tr>
						<th style="width: 3% !important;" class="number"> No </th>
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
						<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th> 
					</tr>
				</thead>
				<tbody>        						
					@foreach ($rowData as $row)
					<tr>
						<td class="thead"> {{ ++$i }} </td>								
						@foreach ($tableGrid as $field)
						@if($field['view'] =='1')
						<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
						@if(SiteHelpers::filterColumn($limited ))
						@if($field['field'] == 'cust_id')
						<td>
							{{ \AbserveHelpers::getuname($row->cust_id)}}
						</td>
						@elseif($field['field'] == 'partner_id')
						<td>
							{{ \AbserveHelpers::getuname($row->cust_id)}}
						</td>
						@elseif($field['field'] == 'res_id')
						<td>
							{{ \AbserveHelpers::restsurent_name($row->res_id)}}
						</td>
						@elseif($field['field'] == 'status')
						<td>
							<span class="label status {{  \AbserveHelpers::getStatusLabel($row->status) }}">{{ \AbserveHelpers::getStatusTiming($row->status) }}</span>
						</td>
						@elseif($field['field'] == 'refund_status')
						<?php $refund_statusaddClass= ($row->refund_status == 'Customer Requested' ? 'label-info' : ''); ?>
						<td>
							<span class="label status {!! $refund_statusaddClass !!}">{{ $row->refund_status }}</span>
						</td>
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
							@if($access['is_detail'] ==1)
							<a href="{{ URL::to('refundinfo/show/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>
							@endif
							@if($access['is_edit'] ==1)
							<a  href="{{ URL::to('refundinfo/update/'.$row->id.'?return='.$return) }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
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
	</div>	
</div>
<div class="modal" id="neworder_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-default">
				<h4 class="modal-title abserve-modal-title">Advance Search</h4>
			</div>
			<div class="modal-body" id="abserve-modal-content">
				<div>
					<form id="ordersSearch">
						<table class="table search-table table-striped" id="advance-search">
							<tbody>
								<tr  id="orderid" class="fieldsearch">
									<td>Order Id</td>
									<td>
										<select id="order_id_operate" class="form-control oper" name="operate">
											<option value="equal"> = </option>
											<option value="bigger_equal"> &gt;= </option>
											<option value="smaller_equal"> &lt;= </option>
											<option value="smaller"> &lt; </option>
											<option value="bigger"> &gt; </option>
										</select>
									</td>
									<td id="order_id_search">
										<input type="text" autocomplete="off" name="id" id="id" data-name="id" value="" class="form-control search_pop">
									</td>
								</tr>
								<tr  id="serach" class="fieldsearch">
									<td> Date </td>
									<td>
										<select id="date_search_operate" class="form-control oper" name="operate">
											<option value="between"> Between </option>
										</select>
									</td>
									<td id="field_date_search">
										<input type="text" autocomplete="off" name="searchDate" id="searchDate" data-name="date" value="" class="form-control search_pop" placeholder="Search Date">
									</td>
								</tr>
								<tr>
									<td class="text-right" colspan="3">
										<button type="button" name="search" class="btn btn-sm btn-primary order_search_btn advanced_search_btn"> Search </button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>	
<div class="modal fade" id="orderModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<ul class="nav nav-tabs center_align">
				<li class="active tab-selection"><a data-toggle="tab" class="d-block" href="#oDetails">Order Details</a></li>
				<li class="tab-selection"><a data-toggle="tab" class="d-block" href="#rDetails">Refund Details</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active order-content" id="oDetails"></div>
				<div class="tab-pane refund-content" id="rDetails"></div>      
			</div>

		</div>
	</div>
</div>
<div class="modal" id="commentModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="updateAdminAction">
				<input type="hidden" name="id">
				<input type="hidden" name="action">
				<input type="hidden" name="updateFor">
				<div class="modal-body">
					<div class="form-group">
						<label for="comment">Comment:</label>
						<textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button  type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-primary">Update</button>
				</div>
			</form>
		</div>
	</div>
</div>
@include('footer')	
<style type="text/css">
	.order-content .mod-tittle {
		font-weight: normal;
		height: 75px;
	}
	#orderModal ul.nav.nav-tabs.center_align{
		display: flex;
		flex-wrap: wrap;
		padding-left: 0;
		margin-bottom: 0;
		list-style: none;
	} 
	#orderModal ul.nav.nav-tabs.center_align li{
		flex: 1 1 auto;
		text-align: center;
	}
	#orderModal .modal-content{
		min-height: 500px;
	}
</style>
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
	$(document).on('click','#searchpop',function(){
		$('#neworder_modal').modal('show');
	});
	$(document).on('click','.advanced_search_btn',function(){
		var search_val,oper,name,search = '';
		var url = window.location.origin + window.location.pathname;
		$('.fieldsearch').each(function(){
			search_val = $(this).find('.search_pop').val();
			oper = $(this).find('.oper').val();
			name = $(this).find('.search_pop').data('name');
			if(search_val != '' & search_val != 'undefined'){
				search +=  name+':'+oper+':'+search_val+'|';
			}
			window.location.href = url+'?search='+search;
		});
	});		
	$(document).on('click','.adminAction',function(){
		var id        = $(this).attr('data-id');
		var action    = $(this).attr('data-action');
		var updateFor = $(this).attr('data-for');
		$('form#updateAdminAction').find('input[name="id"]').val(id);
		$('form#updateAdminAction').find('input[name="action"]').val(action);
		$('form#updateAdminAction').find('input[name="updateFor"]').val(updateFor);
		$('form#updateAdminAction').find('textarea[name="comment"]').val('');
		$('#commentModal').modal('show');
	});
	$(document).on('click','.order-details',function(){
		var base_url = '<?php echo URL::to('/'); ?>';
		var id = $(this).attr('data-id');
		$.ajax({
			type : 'POST',
			url : base_url+'/user/refund-order-details',
			data : {id:id},
			success:function(data){
				var res= JSON.parse(JSON.stringify(data));
				$(".modal-dialog").removeClass(" modal-sm").addClass(" modal-lg");
				$('.order-content').html(res.mainOrderHtml);
				$('.refund-content').html(res.refundOrderHtml);
				$('#orderModal').modal('show');
			}
		})

	});
	$(document).on('submit','form#updateAdminAction',function(e){
		e.preventDefault();
		var url = window.location.origin + window.location.pathname;
		$('#commentModal').modal('hide');
		var data = $(this).serialize();
		console.log(url);
		$.ajax({
			type : 'POST',
			url : url+'/refund/admin-action-customer',
			data : data,
			success:function(data){
				if (data.updateFor == 'customer') {
					$('.adminActionMessage').html(data.alertMessage);
				}else{
					$('.adminActionMessageBoy').html(data.alertMessage);
				}
				setTimeout(function() {
					$('#orderModal').modal('hide');
				}, 3000);

			}
		})

	});
	$(document).on('submit','form#refundAmount',function(e){
		e.preventDefault();
		var data = $(this).serialize();
		var base_url = '<?php echo URL::to('/'); ?>';
		$.ajax({
			type : 'POST',
			url : base_url+'/refund/refund-amount',
			data : data,
				success:function(data){
				location.reload();
			}
		})
	})
</script>	

@stop
