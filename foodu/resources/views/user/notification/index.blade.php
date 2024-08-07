@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2></div>

			<div class="m-sm-4 m-3 box-border">
				<div class="toolbar-nav">
				<!-- Toolbar Top -->
					<div class="row m-0">
						<div class="col-md-8 button-chng my-1"> 	

							<div class="btn-group">
								<button type="button" class="btn  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-menu5"></i> Bulk Action </button>
						        <ul class="dropdown-menu">
						        
						         @if($access['is_remove'] ==1)
									 <li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link tips" title="{{ __('core.btn_remove') }}"><i class="fa fa-trash-o"></i>
									Remove Selected </a></li>
								@endif 
						          
						        </ul>
						    </div>    
						</div>
						<div class="col-md-4 text-right">
							<div class="input-group">
							      <div class="input-group-prepend">
							        <button type="button" class="btn btn-default btn-sm " 
							        onclick="SximoModal('{{ url($pageModule."/search") }}','Advance Search'); " ><i class="fa fa-filter"></i> Filter </button>
							      </div><!-- /btn-group -->
							      <input type="text" class="form-control form-control-sm onsearch" data-target="{{ url($pageModule) }}" aria-label="..." placeholder=" Type And Hit Enter ">
						    </div>
						</div>    
					</div>		
				</div>				
				<!-- End Toolbar Top -->

				<!-- Table Grid -->
				<div class="p-3">
					<div class="table-container m-0" >
		 			{!! Form::open(array('url'=>'notification?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
					
					    <table class="table table-hover " id="{{ $pageModule }}Table">
					        <thead>
								<tr>
									<th style="width: 3% !important;" class="number"> No </th>
									<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
									
									@foreach ($tableGrid as $t)
									@if($t['field'] == 'url')
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
									<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
									
								  </tr>
					        </thead>

					        <tbody>        						
					            @foreach ($rowData as $row)
					                <tr>
										<td > {{ ++$i }} </td>
										<td ><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
																								
									 @foreach ($tableGrid as $field)
										 @if($field['view'] =='1')
										 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
										 	@if(SiteHelpers::filterColumn($limited ))
										 	@if($field['field'] == 'url')
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
									 	<a href="{{ url($row->url)}}"  class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>
									 

									</td>			 
					                </tr>
									
					            @endforeach
					              
					        </tbody>
					      
					    </table>
					<input type="hidden" name="action_task" value="" />
					
					{!! Form::close() !!}
					
					</div>
				</div>
			<!-- End Table Grid -->
			</div>
@include('footer')


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
