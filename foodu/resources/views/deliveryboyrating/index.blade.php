@extends('layouts.app')

@section('content')
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
				@if($access['is_add'] ==1)
				<a href="{{ url('deliveryboyrating/create?return='.$return) }}" class="btn  btn-sm"  
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create New </a>
				@endif

				<a href="{{ URL::to( 'deliveryboyrating/search') }}" class="btn btn-sm btn-white" onclick="AbserveModal(this.href,'Advance Search'); return false;" ><i class="fa fa-search"></i> Search</a>	

				<div class="btn-group">
					<button type="button" class="btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> Bulk Action </button>
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
						@if($access['is_csv'] ==1)
						<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=csv&return='.$return) }}" class="nav-link "> Export CSV </a></li>	
						@endif
						@if($access['is_pdf'] ==1)
						<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=pdf&return='.$return) }}" class="nav-link "> Export PDF </a></li>	
						@endif
						@if($access['is_print'] ==1)
						<li class="nav-item"><a href="{{ url( $pageModule .'/export?do=print&return='.$return) }}" class="nav-link "> Print Document </a></li>	
						@endif
						<div class="dropdown-divider"></div>
						<li class="nav-item"><a href="{{ url($pageModule) }}"  class="nav-link "> Clear Search </a></li>
						
						
						
					</ul>
				</div>    
			</div>
			<div class="col-md-4 text-right">
				<div class="input-group ">
					<div class="input-group-prepend">
						<button type="button" class="btn btn-default btn-sm " 
						onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " ><i class="fa fa-filter"></i> Filter </button>
					</div><!-- /btn-group -->
					<input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." placeholder=" Type And Hit Enter ">
				</div>
			</div>    
		</div>	

	</div>
	<div class="p-3">	
		<div class="table-container for-icon m-0">

			<!-- Table Grid -->
			
			{!! Form::open(array('url'=>'deliveryboyrating/store?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
			
			<table class="table  table-hover " id="{{ $pageModule }}Table">
				<thead>
					<tr>
						<th style="width: 3% !important;" class="number"> No </th>
						<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
						<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
						
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
						
					</tr>
				</thead>

				<tbody>        						
					@foreach ($rowData as $row)
					<tr>
						<td class="thead"> {{ ++$i }} </td>
						<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
						<td>

							<div class="dropdown">
								<button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> {{ __('core.btn_action') }} </button>
								<ul class="dropdown-menu">
									@if($access['is_detail'] ==1)
									<li class="nav-item"><a href="{{ url('deliveryboyrating/'.$row->id.'?return='.$return)}}" class="nav-link tips" title="{{ __('core.btn_view') }}"> {{ __('core.btn_view') }} </a></li>
									@endif
									@if($access['is_edit'] ==1)
									<li class="nav-item"><a  href="{{ url('deliveryboyrating/'.$row->id.'/edit?return='.$return) }}" class="nav-link  tips" title="{{ __('core.btn_edit') }}"> {{ __('core.btn_edit') }} </a></li>
									@endif
									<div class="dropdown-divider"></div>
									@if($access['is_remove'] ==1)
									<li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link  tips" title="{{ __('core.btn_remove') }}">
									Remove Selected </a></li>
									@endif 
								</ul>
							</div>

						</td>														
						@foreach ($tableGrid as $field)
						@if($field['view'] =='1')
						<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
						@if(SiteHelpers::filterColumn($limited ))
						@if($field['field'] == 'cust_id')
						<td>{!! \AbserveHelpers::getuname($row->cust_id) !!}</td>
						@else
						<?php $addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
						<td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >					 
							{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
						</td>
						@endif	
						@endif	
						@endif					 
						@endforeach			 
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
