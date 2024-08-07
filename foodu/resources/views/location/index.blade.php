@extends('layouts.app')

@section('content')
<?php
$cpage	= request()->has('page') ? request()->get('page') : '';
$from	= request()->has('from') ? request()->get('from') : '';
$url	= '?from='.$from.'&page='.$cpage;
$dwnload= ['pdf'=>'PDF','xls'=>'EXCEL','csv'=>'CSV'];
$dwnicon= ['pdf'=>'pdf','xls'=>'excel','csv'=>'csv']; ?>
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
			<div class="col-md-6 button-chng my-1 "> 	
					@if($access['is_add'] ==1)
					<a href="{{ url('location/create?return='.$return) }}" class="btn  btn-sm"  
					title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create </a>
					@endif         
					<a href="javascript://ajax"  onclick="SximoDelete();" class="btn  btn-sm" title="{{__('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
						Remove </a>
					

						<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>


						<button type="button" class="btn bg-transparent text-success border-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-download"></i> Download</button>
						<div class="dropdown-menu dropdown-menu-right" style="">
								@php $i =0; @endphp
								@foreach($dwnload as $dn => $dv)
								@if($i != 0)
								<div class="dropdown-divider"></div>
								@endif
								<a href="{!! url('location/LocationExports/'.$dn) !!}" class="dropdown-item"><i class="fas fa-file-{!! $dwnicon[$dn] !!}"></i> {!! $dv !!}</a>
								@php $i++; @endphp
								@endforeach
						</div>

			</div>
			<div class="col-md-3">
					<label>Upload Default Image</label>	
					<input type="file" id="defaultImage" class="tips btn btn-sm btn-white" title="Upload" value="Upload Default Image">
			</div>

			<div class="col-md-3">
					<?php 
					$img = \AbserveHelpers::getDefaultAdvert();
					$img = \URL::to('uploads/location_ad/'.$img); ?>
					<a class="previewImage" href="{!! $img !!}">
						<img width="50" height="50" src="{!! $img !!}" class="img-circle">
					</a>
			</div>
		</div>
				<!--
				<div class="col-md-4 text-right">
					<div class="input-group ">
					      <div class="input-group-prepend">
					        <button type="button" class="btn btn-default btn-sm " 
					        onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " ><i class="fa fa-filter"></i> Filter </button>
					      </div>/btn-group 
					      <input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." placeholder=" Type And Hit Enter ">
					    </div>
					</div>   !--> 
	</div>	

	<div class="p-3">
			<div class="table-container for-icon m-0">

				<!-- Table Grid -->
				
				{!! Form::open(array('url'=>'location/store'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				
				<table class="table  table-hover " id="{{ $pageModule }}Table" >
					<thead>
						<tr>
							<th style="width: 3% !important;" class="number"> No </th>
							<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
							
							<!--<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>!-->
							
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
							<th  width="100"> Action </th>
						</tr>
					</thead>

					<tbody>        						
						@foreach ($rowData as $row)
						<tr>
							<td class="thead"> {{ ++$r }} </td>

							<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
			                       <!--
									<td>
									 	<div class="dropdown">
										  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> {{ __('core.btn_action') }} </button>
										  <ul class="dropdown-menu">
										 	@if($access['is_detail'] ==1)
											<li class="nav-item"><a href="{{ url('location/'.$row->id.'?return='.$return)}}" class="nav-link tips" title="{{ __('core.btn_view') }}"> {{ __('core.btn_view') }} </a></li>
											@endif
											@if($access['is_edit'] ==1)
											<li class="nav-item"><a  href="{{ url('location/'.$row->id.'/edit?return='.$return) }}" class="nav-link  tips" title="{{ __('core.btn_edit') }}"> {{ __('core.btn_edit') }} </a></li>
											@endif
											<div class="dropdown-divider"></div>
											@if($access['is_remove'] ==1)
												<li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link  tips" title="{{ __('core.btn_remove') }}">
												Remove Selected </a></li>
											@endif 
										  </ul>
										</div>

									</td>!-->			

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

									<td>
										@if($access['is_detail'] ==1)
										<a href="{{url('location/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>
										@endif
										@if($access['is_edit'] == 1)
										<a  href="{{ url('location/'.$row->id.'/edit?return='.$return)  }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
										
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
					$(document).on('click','.doSearch',function(){
						var search_val,oper,name,search = '';
						var url = window.location.origin + window.location.pathname;
						$('.fieldsearch').each(function(){
							search_val = $(this).find('.search_pop').val();
							oper = $(this).find('.oper').val();
							name = $(this).find('.search_pop').data('name');
							if(search_val != ''){
								search +=  name+':'+oper+':'+search_val+'|';
							}
						});
						window.location.href = url+'?search='+search;
					});

				});

			</script>	


			<script>
				$(document).ready(function(){

					$('.do-quick-search').click(function(){
						$('#AbserveTable').attr('action','{{ URL::to("location/multisearch")}}');
						$('#AbserveTable').submit();
					});
					const actualBtn = document.getElementById('defaultImage');
					actualBtn.addEventListener('change', function(){
						var ofile=document.getElementById('defaultImage').files[0];
						var formdata = new FormData();
						formdata.append("image",ofile);
						$.ajax({
							type : 'POST',
							dataType : 'json',
							url:"DefaultImageChange",
							data : formdata,
							contentType: false,
							processData: false,
							success: function (data) {
								location.reload(); 
							},
							error: function (data,response) {
							}   
						});
					})
					
				});	

			</script>		

			@stop

