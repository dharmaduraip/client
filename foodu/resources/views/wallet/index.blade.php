@extends('layouts.app')

@section('content')

{{--*/ usort($tableGrid, "AbserveHelpers::_sort") /*--}}
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<!-- 			<div class="sbox-title"> <h5> <i class="fa fa-table"></i> </h5>
				<div class="sbox-tools" >
					<a href="{{ URL::to($pageModule) }}" class="btn btn-xs btn-white tips" title="Clear Search" ><i class="fa fa-trash-o"></i> Clear Search </a>
					@if(Session::get('gid') ==1)
					<a href="{{ URL::to('abserve/module/config/'.$pageModule) }}" class="btn btn-xs btn-white tips" title="{!! Lang::get('core.btn_config') !!}" ><i class="fa fa-cog"></i></a>
					@endif 
				</div>
			</div> -->
        <div class="p-3">
			<div class="sbox-title"> 
				<h5> <i class="fa fa-table"></i> </h5>
				<div class="sbox-tools">
					
					<a href="{{ URL::to('customer') }}" style="display: block ! important;" class="btn btn-xs btn-white tips" title="Back" >
					<i class="fa fa-old-icon"></i> {!! 'Back to Custromer' !!} 
					</a>
					
					<a href="#" class="btn btn-xs btn-white tips" title="" data-original-title=" Configuration">
					<i class="fa fa-cog"></i>
					</a>	 
				</div>
			</div>
			<div class="toolbar-line">
				@if(isset($_GET['search']))
					<?php
						$id_user = explode(":",  app('request')->input('search'));
						$u_id = $id_user[2];
					?>
					@endif
					@if(isset($_GET['search']))
					<div class="row m-0 bg-light pt-2">
						
						<a href="{{ URL::to('wallet/'.$u_id.'/edit') }}" class="col-md-2 tips btn btn-sm btn-warning my-auto mx-3 text-light"  title="{!! 'Add / Update' !!}">
							<i class="fa fa-plus-circle "></i>&nbsp;{!! 'Add Wallet' !!}
						</a>
					   
						<div class="col-md-6 mt-4">
							<label>Customer Name :</label> {!! \AbserveHelpers::getuname($u_id) !!}
						<br>
							<label>Total Wallet Balance :{!! $total_wallet !!}</label> 
						</div>
						
					</div>
					@endif
					{{-- @if($access['is_remove'] ==1)
					<a href="javascript://ajax"  onclick="AbserveDelete();" class="tips btn btn-sm btn-white" title="{!! Lang::get('core.btn_remove') !!}">
					<i class="fa fa-minus-circle "></i>&nbsp;{!! Lang::get('core.btn_remove') !!}</a>
					@endif 
					<a href="{{ URL::to( 'wallet/search') }}" class="btn btn-sm btn-white" onclick="AbserveModal(this.href,'Advance Search'); return false;" ><i class="fa fa-search"></i> Search</a>
					@if($access['is_excel'] ==1)
					<a href="{{ URL::to('wallet/download?return='.$return) }}" class="tips btn btn-sm btn-white" title="{!! Lang::get('core.btn_download') !!}">
					<i class="fa fa-download"></i>&nbsp;{!! Lang::get('core.btn_download') !!} </a>
					@endif --}}
			</div>			
			<div class="p-3 bg-light">
				<div class="table-container m-0">

						<!-- Table Grid -->
						
			 			{!! Form::open(array('url'=>'wallet?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
						
					    <table class="table  table-hover " id="{{ $pageModule }}Table">
									<thead>
										<tr>
											<th class="number"> No </th>
											{{-- <th> <input type="checkbox" class="checkall" /></th> --}}
											@if(!isset($_GET['search']))
											<th>User Name</th>
											@endif
											<th>Order Id</th>
											<th>Type</th>
											<th>Amount Added</th>
											<th>Reason</th>
											<th>Date</th>
											{{-- <th width="70" >{!! Lang::get('core.btn_action') !!}</th> --}}
										</tr>
									</thead>

									<tbody>
										<?php $p = 0; ?>
										@foreach ($rowData as $row)

										<tr>
											<td width="30"> {{ ++$i }} </td>
											{{-- <td width="50"><input type="checkbox" class="ids" name="ids[]" value="{{ $row->id }}" />  </td> --}}
											@if(!isset($_GET['search']))
											<td>{{ \AbserveHelpers::getuname($row->user_id) }}</td>
											@endif
											<td>{{ $row->order_id != '0' ? $row->order_id : '#' }}</td>
											<td>{{ $row->type }}</td>
											<td>{{ \AbserveHelpers::CurrencySymbol( number_format($row->amount,2,'.','')) }}</td>
											<td>{{ $row->title }}</td>
											<td>{{ $row->date }}</td>
											{{-- <td>
												@if(isset($_GET['search']))
												<a href="{{ URL::to('wallet/update/?userid='.$u_id) }}" class="tips btn btn-sm btn-white">
												<i class="fa fa-edit "></i>&nbsp;Edit</a>
												@endif
											</td> --}}
										</tr>
										<?php $p++; ?>
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
