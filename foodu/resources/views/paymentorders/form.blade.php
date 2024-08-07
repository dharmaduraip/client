@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

{!! Form::open(array('url'=>'orderdetails?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
<div class="toolbar-nav">
</div>
<div class="p-5">
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>		
	<div class="row">
		<div class="col-md-12">			<fieldset>
				<legend> Assign To Rider</legend>
			{!! Form::open(array('url'=>'orderdetails/store?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
			<input type="hidden" name="id" id="id" value="{!!$row->id!!}" >	
			{{--<input type="hidden" name="orderid" id="orderid" value="{!!$row->orderid!!}" >--}}	
			<input type="hidden" name="orderid" id="orderid" value="{!!$row->id!!}" >						
				<div class="form-group "  >
					<label for="Boy Id" class=" control-label col-md-4 text-left"> Boy </label>
					<div class="col-md-6">
						<select class="form-control" id="boy_id" name="boy_id" 
						>
						<option value="" >Select a Rider</option>
						@foreach($deliveryBoy as $key=>$value)
						<option value="{!!$value->id!!}"  
							@if($value->id == $row->boy_id) selected="selected" @endif
							>{!!$value->username!!}
							@if($value->boy_status == 1)
							- Busy
							@elseif($value->boy_status == 0)
							- Free
							@endif
						</option>
						@endforeach
					</select>
				</div> 
				<div class="col-md-2">
					<input type="hidden" name="action_task" value="save" />
				</div>
			</div> 
		</fieldset>
			<div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
						<button type="submit" name="apply" class="btn btn-info btn-sm" ><i class="fa  fa-check-circle"></i> {!! Lang::get('core.sb_apply') !!}</button>
						<button type="submit" name="submit" class="btn btn-primary btn-sm" ><i class="fa  fa-save "></i> {!! Lang::get('core.sb_save') !!}</button>
						<button type="button" onclick="location.href='{{ URL::to('paymentorders?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
					</div>	  

				</div> 
				{!! Form::close() !!}
	</div>
	
</div>
</div>		
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() { 
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("paymentorders/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		

	});
</script>		 
@stop