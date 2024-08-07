@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="toolbar-nav" >   
</div>	
<div class="table-container">

			<!-- Table Grid -->
			
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
							 	@if($field['field'] == 'is_accept')
							 	<?php
									$status = $row->is_accept == 0 ? 'Waiting' : ($row->is_accept == 1 ? 'Accepted' : ($row->is_accept == 2 ? 'Rejected' : ''));
								?>
								<td >
									{{$status}}
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
						 @if($row->is_accept == 0)
						 <td><button class="tips btn btn-xs btn-primary statuschange" data-id="{{$row->id}}" title="{!! Lang::get('core.btn_edit') !!}" value="accept"><i class="fa fa-check "></i></button>
						 <button class="tips btn btn-xs btn-danger statuschange" title="{!! Lang::get('core.btn_edit') !!}" data-id="{{$row->id}}" value="reject"><i class="fa fa-close "></i></button></td>
						 @else
						 <td><a href="{{url('partnerrequest/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a></td>
						 @endif			 
		                </tr>
						
		            @endforeach
		              
		        </tbody>
		      
		    </table>
			<input type="hidden" name="action_task" value="" />
			
			
			
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
	});

	$('.statuschange').click(function(){
		var base_url = '{{ url('') }}';
		var id = $(this).data('id');
		var status = $(this).val();
		$.ajax({
			url: base_url+'/statuschange',
			method : 'POST',
			data : {id:id, status:status},
			success:function(data){
				location.reload();
			}
		});
	})	
	
});	
</script>	
	
@stop
