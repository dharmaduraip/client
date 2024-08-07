@extends('layouts.app')	
@section('content')
<div class="page-header"><div class=""><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="">
	<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}"> {!! trans('core.abs_Dashboard') !!} </a></li>
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
		<div class="row">
			<div class="col-md-8 my-1 button-chng"> 	
				@if($access['is_add'] ==1)
				<a href="{{ url('partners/create?return='.$return) }}" class="btn  btn-sm"  
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create </a>
				@endif
				<a href="javascript://ajax" onclick="disablefunc();" class="btn  btn-sm" title="{{ __('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
				Remove  </a>
				<a href="javascript://ajax"  onclick="deleteperfunc();" class="btn  btn-sm" title="{{ __('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
				Permanent Delete </a>
				<button type="button" class="tips btn btn-sm btn-white search_pop_btn" page="partner"><i class="fa fa-search"></i> Search</button>
			</div>
		</div>
	</div>	
	<div class="p-3">	
		<div class="table-container for-icon m-0">
			{!! Form::open(array('url'=>'partners?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
			<table class="table  table-hover " id="{{ $pageModule }}Table">
				<thead>
					<tr>
						<th style="width: 3% !important;" class="number"> No </th>
						<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
						<th  style="width: 10% !important;">Partner Id</th>
						<th  style="width: 10% !important;">Shop Name</th>
						@foreach ($tableGrid as $t)
						@if($t['label'] == 'Partner Id')
						@elseif($t['label'] == 'Username')
						<th>Owner Name</th>
						@elseif($t['label'] == 'First Name')
						@elseif($t['label'] == 'Activation')
						@elseif($t['label'] == 'Phone Verified')
						@else
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
						@endif
						@endforeach
						<th  style="width: 10% !important;">Action</th>
					</tr>
				</thead>
				<tbody>        						
					@foreach ($rowData as $row)
					<tr>
						<td class="thead"> {{ ++$r }} </td>
						<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
						<td>{{$row->id}}</td>
						<td><a href="{{ URL('restaurant/'.\AbserveHelpers::PartnerrestaurantId($row->id).'/edit'.'?return=')}}">{{\AbserveHelpers::Partnerrestaurants($row->id)}}</td>														
							@foreach ($tableGrid as $field)
							@if($field['view'] =='1')
							<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
							@if(SiteHelpers::filterColumn($limited ))
							@if($field['label'] == 'First Name')
							@elseif($field['label'] == 'Activation')
							@elseif($field['label'] == 'Avatar')
							<td>
								{!! AbserveHelpers::showUploadedFile($row->avatar,'/uploads/users/') !!}
							</td>
							@elseif($field['label'] == 'Phone Verified')
							@elseif($field['label'] == 'Active')
							<td>
								@if($row->p_active == 1)
								Active
								@elseif($row->p_active == 3)	
								InActive
								@else
								Block	
								@endif
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
								@if($access['is_edit'] ==1)
								<a  href="{{ URL::to('partners/'.$row->id.'/edit?return='.$return) }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit " style="color:white;"></i></a>

								<a  href="{{ URL::to('accountdetails/'.$row->id.'/edit?type=part&return='.$return) }}" class="tips btn btn-xs btn-success" title="click to edit bank account details"><i class="icon-office" style="color:white;"></i></a>
								@endif
								<a  href="{{ URL::to('partnerwallet?search=partner_id:equal:'.$row->id.'') }}" class="tips btn btn-xs btn-success" title="click to view wallet details"><i class="fa fa-credit-card"></i></a>
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
	function disablefunc(){
		var getid = '';
		$('.ids').each(function(){
			if($(this).is(':checked')) {   
				getid += $(this).val()+',';
			}
		}); 
		// alert(getid);
		if(getid != ''){
			if(confirm('Are u sure removing selected rows ?'))
			{
				$.ajax({
					url: 'partners/blockpartners',
					type: 'get',
					data: {'_token': '{!! csrf_token() !!}', getid: getid },
					success:function(res){
						location.reload();
					}
				})
			}	
		}
	}			
	function deleteperfunc(){
		var getid = '';
		$('.ids').each(function(){
			if($(this).is(':checked')) {   
				getid += $(this).val()+',';
			}
		}); 
		if(getid != ''){
			if(confirm('Are u sure removing selected rows ?'))
			{
				$.ajax({
					url: 'partners/deletepartners',
					type: 'get',
					data: {'_token': '{!! csrf_token() !!}', getid: getid },
					success:function(res){
						location.reload();
					}
				})
			}	
		}
	}
</script>	

@stop

