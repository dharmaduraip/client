@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

	{!! Form::open(array('url'=>'wallet?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}

	<div class="p-3">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>		
		<div class="row m-0">
			<div class="col-md-12 p-0">
				<div class="sbox-content"> 	
					<?php
					$order = \App\Models\OrderDetail::where('cust_id',request()->segment(2))->get();
					$u_id = request()->segment(2);
					$username = \AbserveHelpers::getuname(request()->segment(2));
					?>

					{!! Form::open(array('url'=>'wallet/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
					<div class="col-md-12">
						<fieldset>
							<legend> {{ $username }}</legend>
							<div class="form-group hidethis row">
								<div class="col-md-6">
									{!! Form::hidden('user_id', $u_id,array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
								</div> 
								<div class="col-md-2">
								</div>
							</div> 					
							<!-- <div class="form-group row">
								<label for="User name" class=" control-label col-md-4 text-md-right"> Order Id </label>
								<div class="col-md-6">
									<select name='order_id' rows='5' id='order_id' class='select2 '   >
										@if(count($order)>0)
										@foreach($order as $uValue)
										<option @if($u_id == $uValue->id) selected="" @endif value="{!!$uValue->id!!}">{!!$uValue->id!!}</option>
										@endforeach
										@endif
									</select> 
								</div> 
							
							</div> -->
							{{-- <div class="form-group hidethis " style="display:none;">
									<label for="Order Id" class=" control-label col-md-4 text-md-right"> 
										Order Id 
									</label>
									<div class="col-md-6">
										{!! Form::text('order_id', $row['order_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									</div> 
									<div class="col-md-2">
									</div>
							</div> --}}
							<div class="form-group hidethis row">
								<label for="Type" class=" control-label col-md-4 text-md-right"> Type </label>
								<div class="col-md-6">
									<select name='type' rows='5' id='type' class='select2'>
										<option value="credit">{!! 'credit' !!}</option>
										<option value="debit">{!! 'debit' !!}</option>
									</select> 
								</div> 
								<div class="col-md-2">
								</div>
							</div>
							<div class="form-group row">
								<label for="Amount" class=" control-label col-md-4 text-md-right"> Amount </label>
								<div class="col-md-6">
									{!! Form::text('amount', $row['amount'],array('class'=>'form-control', 'placeholder'=>'', 'required'  )) !!} 
								</div> 
								<div class="col-md-2">
								</div>
							</div>
							<div class="form-group row">
								<label for="Reason" class=" control-label col-md-4 text-md-right"> Reason </label>
								<div class="col-md-6">
									<textarea name='reason' rows='5' id='reason' class='form-control' required   
									>{{ $row['reason'] }}</textarea> 
								</div> 
								<div class="col-md-2">
								</div>
							</div>
							{{-- <div class="form-group hidethis " style="display:none;">
								<label for="Added By" class=" control-label col-md-4 text-md-right"> Added By </label>
								<div class="col-md-6">
									{!! Form::text('added_by', $row['added_by'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
								</div> 
								<div class="col-md-2">

								</div>
							</div>
							<div class="form-group  " style="display:none;" >
								<label for="Date" class=" control-label col-md-4 text-md-right"> Date <span class="asterix"> * </span></label>
								<div class="col-md-6">
									<div class="input-group m-b" style="width:150px !important;">
										{!! Form::text('date', $row['created_at'],array('class'=>'form-control')) !!}
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div> 
								</div> 
								<div class="col-md-2">
								</div>
							</div>
							<div class="form-group hidethis " style="display:none;">
								<label for="Created At" class=" control-label col-md-4 text-md-right"> Created At </label>
								<div class="col-md-6">
									{!! Form::text('created_at', $row['created_at'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
								</div> 
								<div class="col-md-2">
								</div>
							</div> --}}

							<div style="clear:both"></div>
							<div class="form-group">
								<label class="col-sm-4 text-right">&nbsp;</label>
								<div class="col-sm-12 text-center">	
									{{-- <button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {!! Lang::get('core.sb_apply') !!}</button> --}}
									<button type="submit" name="submit" class="btn btn-black btn-sm" ><i class="fa  fa-save "></i> {!! Lang::get('core.sb_save') !!}</button>
									<button type="button" onclick="location.href='{{ URL::to('wallet?search=u_id:equal:'.$u_id) }}' " class="btn btn-success btn-sm "><i class="fa fa-arrow-circle-left "></i> {!! Lang::get('core.sb_cancel') !!} </button>
								</div>
							</div>
						</fieldset>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>

	{!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		 	
		 	 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("wallet/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop