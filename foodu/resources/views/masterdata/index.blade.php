@extends('layouts.app')
@section('content')
<div class="page-header">
	<h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2>
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
			<div class="col-md-8 button-chng"> 	
				@if($access['is_add'] ==1)
				<a href="{{ url('masterdata/create?return='.$return) }}" class="btn  btn-sm"  
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create New </a>
				@endif
				<button type="button" class="tips btn btn-sm btn-white search_pop_btn" page="subadmin"><i class="fa fa-search"></i> Search</button>
				<button type="button" class="tips btn btn-sm btn-white foodimp" data-toggle="modal" data-target="#food_import"><i class="fa fa-download"></i> Product Import</button>
				<button type="button" class="tips btn btn-sm btn-white imgimp" data-toggle="modal" data-target="#csv_image_upload"><i class="fa fa-download"></i> Product image upload</button>
				<div class="btn-group">
					<a href="javascript://ajax"  onclick="SximoDelete();" class="btn  btn-sm" title="{{ __('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
					Remove  </a>
					@if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)
					<a href="javascript://ajax"  onclick="SximoRemoveAll();" class="tips btn btn-sm btn-white" title="{!! Lang::get('core.btn_remove') !!}">
						<i class="fa fa-minus-circle "></i>&nbsp;Remove All</a>
						@endif
				</div>    
			</div>
			<!---<div class="col-md-4 text-right">
				<div class="input-group ">
					<div class="input-group-prepend">
						<button type="button" class="btn btn-default btn-sm " 
						onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " ><i class="fa fa-filter"></i> Filter </button>
					</div> /btn-group 
					<input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." placeholder=" Type And Hit Enter ">
				</div>
			</div> -->    
		</div>	

	</div>	
	<div class="p-3">
		<div class="table-container for-icon m-0">

			<!-- Table Grid -->
			{!! Form::open(array('url' =>'masterdata/remove' ,'class'=>'form-horizontal','id'=>'SximoRemove' )) !!}
			{!!  Form::close() !!}
			{!! Form::open(array('url'=>'masterdata/store?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}

			<table class="table  table-hover " id="{{ $pageModule }}Table">
				<thead>
					<tr>
						<th style="width: 3% !important;" class="number"> No </th>
						<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>

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
						<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>

						@foreach ($tableGrid as $field)
						@if($field['view'] =='1')
						<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
						@if(AbserveHelpers::filterColumn($limited ))					 
						@if($field['field'] =='image')
						<td>
							{!! AbserveHelpers::showUploadedFile($row->{$field['field']},'/uploads/images/') !!}
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
							<a href="{{ URL::to('masterdata/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>
							@endif
							@if($access['is_edit'] ==1)
							<a  href="{{ URL::to('masterdata/'.$row->id.'/edit?return='.$return) }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
							@endif
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
	@include('admin.search')
	@include('footer')
	<div class="modal" id="food_import" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-default">
					<h4 class="modal-title abserve-modal-title">Product import option</h4>
					<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body" id="abserve-modal-contents">
					<form class="form-horizontal" method="POST" action="{{ URL::to('/fooditems/importmaster') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="col-sm-4">Upload csv file</label>
							<input accept=".csv" type="file" name="csv_file" class="form-control col-sm-8" style="width: 200px;">

						</div>
						<div class="form-group">
							<small>Sample file link -  <a href="{{ URL::to('/resources/views/phpexcel/sample/master_template.csv') }}" target="_BLANK"><b><i class="fa fa-download"></i></b></a></small>
						</div>	
						<div class="modal-footer">					
							<button class="btn btn-success" type="submit">Import</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal" id="csv_image_upload" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-default">
					<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title abserve-modal-title">Product import option</h4>
				</div>
				<div class="modal-body" id="abserve-modal-contentimg">
					<form class="form-horizontal" method="POST" action="{{ URL::to('/fooditems/importimage') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="col-sm-4">Image</label>
							<input  type='file' name='image[]' id='image' multiple="" style='width:150px !important;'  />
						</div>	
						<div class="modal-footer">					
							<button class="btn btn-success" type="submit">Import</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
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
		$(document).on('click','.foodimp',function(){
			$('#food_import').modal('show');
		});
		$(document).on('click','.imgimp',function(){
			$('#csv_image_upload').modal('show');
		});
		function SximoRemoveAll()
		{
			if(confirm('Are u sure removing all rows ? '))
			{
				$('#SximoRemove').submit();
			}
		}
	</script>	

	@stop
