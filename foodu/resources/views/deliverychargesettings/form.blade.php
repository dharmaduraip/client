@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
{!! Form::open(array('url'=>'deliverychargesettings?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
<div class="p-3">
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>		
	<div class="row m-0">
		<div class="col-md-12">
			<fieldset>
				<legend> DeliveryChargeSettings</legend>
				{!! Form::hidden('id', $row['id']) !!}					
				<div class="form-group row  " >
					<label for="Charge Type" class=" control-label col-md-4 text-md-right"> Charge Type <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<?php $charge_type = explode(',',$row['charge_type']);
						$charge_type_opt = array( 'package' => 'Package Charge' ,  'delivery' => 'Delivery Charge' ,  'festival' => 'Festival Charge' ,  'bad_weather' => 'Bad Weather Charge' , ); ?>
						<select name='charge_type' rows='5' required  class='select2 '  > 
							<?php 
							foreach($charge_type_opt as $key=>$val)
							{
								echo "<option  value ='$key' ".($row['charge_type'] == $key ? " selected='selected' " : '' ).">$val</option>"; 						
							}						
						?></select> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Charge in RS." class=" control-label col-md-4 text-md-right"> Charge in RS. <span class="asterix"> * </span></label>
					<div class="col-md-6">

						<?php $charge_value = explode(',',$row['charge_value']);
						$charge_value_opt = array( 'range' => 'Range' ,  'above' => 'Above' , ); ?>
						<select name='charge_value' rows='5' required  class='select2 '  > 
							<?php 
							foreach($charge_value_opt as $key=>$val)
							{
								echo "<option  value ='$key' ".($row['charge_value'] == $key ? " selected='selected' " : '' ).">$val</option>"; 						
							}						
						?></select> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Order Value Type" class=" control-label col-md-4 text-md-right"> Order Value Type </label>
					<div class="col-md-6">
						<input  type='text' name='order_value_type' id='order_value_type' value='{{ $row['order_value_type'] }}' 
						class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Minimum Order Value" class=" control-label col-md-4 text-md-right"> Minimum Order Value <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='order_value_min' id='order_value_min' value='{{ $row['order_value_min'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Maximum Order Value" class=" control-label col-md-4 text-md-right"> Maximum Order Value <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='order_value_max' id='order_value_max' value='{{ $row['order_value_max'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Distance Type" class=" control-label col-md-4 text-md-right"> Distance Type </label>
					<div class="col-md-6">
						<input  type='text' name='distance_type' id='distance_type' value='{{ $row['distance_type'] }}' 
						class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Distance Minimum KM" class=" control-label col-md-4 text-md-right"> Distance Minimum KM <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='distance_min' id='distance_min' value='{{ $row['distance_min'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Distance Maximum KM" class=" control-label col-md-4 text-md-right"> Distance Maximum KM <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='distance_max' id='distance_max' value='{{ $row['distance_max'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Tax" class=" control-label col-md-4 text-md-right"> Tax <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='tax' id='tax' value='{{ $row['tax'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Status" class=" control-label col-md-4 text-md-right"> Status <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input type='radio' name='status' value ='active' required @if($row['status'] == 'active') checked="checked" @endif class='minimal-green' > Active 
						<input type='radio' name='status' value ='inactive' required @if($row['status'] == 'inactive') checked="checked" @endif class='minimal-green' > Inactive  
					</div> 
					<div class="col-md-2">
					</div>
				</div> 

				<div class="form-group row " @if(\Auth::user()->group_id == '2' || \Auth::user()->group_id == '5') hidden @endif> 
					<label for="Location" class=" control-label col-md-4 text-md-right"> Location <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<select name='location' rows='5' id='location' required class='select2 '  >
							@foreach($location as $loc)
							<option value="{{$loc->id}}">{{$loc->name}}</option>
							@endforeach 
						</select> 
					</div> 
					<div class="col-md-2">
					</div>
				</div>
				
				<div class="">
					<div class="row">
						<div class="col-md-12 text-center" >
							<div class="submitted-button">
								<button name="apply" class="tips btn btn-sm btn-green  "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
								<button name="save" class="tips btn btn-sm btn-black"  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button>
								<button type="button" onclick="location.href='{{ url($pageModule.'?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
							</div>	
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
	<input type="hidden" name="action_task" value="save" />
</div>
</div>		
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("deliverychargesettings/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		

});
</script>		 
@stop