@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="toolbar-nav" >   
	<div class="row">
		


</div>	
				<div class="toolbar-line ">
					@if($access['is_add'] ==1)
					{{-- <a href="{{ URL::to('offerwallet/update') }}" class="tips btn btn-sm btn-white"  title="{!! Lang::get('core.btn_create') !!}">
						<i class="fa fa-plus-circle "></i>&nbsp;{!! Lang::get('core.btn_create') !!}
					</a> --}}
					@endif  
					@if($access['is_remove'] ==1)
					{{-- <a href="javascript://ajax"  onclick="AbserveDelete();" class="tips btn btn-sm btn-white" title="{!! Lang::get('core.btn_remove') !!}">
						<i class="fa fa-minus-circle "></i>&nbsp;{!! Lang::get('core.btn_remove') !!}
					</a> --}}
					@endif 
					{{-- <a href="{{ URL::to( 'offerwallet/search') }}" class="btn btn-sm btn-white" onclick="AbserveModal(this.href,'Advance Search'); return false;" ><i class="fa fa-search"></i> Search
					</a> --}}
					@if($access['is_excel'] ==1)
					{{-- <a href="{{ URL::to('offerwallet/download?return='.$return) }}" class="tips btn btn-sm btn-white" title="{!! Lang::get('core.btn_download') !!}">
						<i class="fa fa-download"></i>&nbsp;{!! Lang::get('core.btn_download') !!}
					</a> --}}
					@endif
					@if(isset($_GET['search']))
					<?php
						$total	= (object) [];
						$search = explode(':', $_GET['search']);
						if (!empty($search) && $search[0] == 'cust_id') {
							$total	= \App\User::find($search[2],['offer_wallet']);
							?>
							@if(!empty($total))
							<label style="color:red;">Total Offer Wallet Balance : {!! $total->offer_wallet !!}</label>
							@endif
							{!! Form::open(array('url'=>'offerwallet/cleardata/', 'method'=>'post', 'class'=>'form-horizontal')) !!}
							<input type="hidden" name="user_id" value="{!! $search[2] !!}">
							<button class="btn btn-danger" type="submit">Clear Offer wallet and history</button>
							{!! Form::close() !!}
						<?php
						}
					?>
					@endif
				</div>
<div class="table-container">

			<!-- Table Grid -->
			
 			{!! Form::open(array('url'=>'offerwallet?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
			
		    <table class="table  table-hover " id="{{ $pageModule }}Table">
						<thead>
							<tr>
								<th class="number"> No </th>
								<th> Customer Name </th>
								<th> Order ID </th>
								<th> Amount </th>
								<th> Reason </th>
								{{-- <th width="70" >{!! Lang::get('core.btn_action') !!}</th> --}}
							</tr>
						</thead>

						<tbody>
							@foreach ($rowData as $row)
							<tr>
								<td width="30"> {!! ++$i !!} </td>
								<td>{!! \AbserveHelpers::getuname($row->cust_id) !!}</td>
								<td>{!! $row->order_id !!}</td>
								<td @if($row->type == 'credit') style="color:green;" @else style="color:red;" @endif>{!! \AbserveHelpers::CurrencySymbol( number_format($row->offer_price,2,'.','')) !!}</td>
								<td>{!! $row->reason !!}</td>
							</tr>
							@endforeach
						</tbody>
		      
		    </table>
			<input type="hidden" name="action_task" value="" />
			
			{!! Form::close() !!}
			
			
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
