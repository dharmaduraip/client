

		 {!! Form::open(array('url'=>'deliverychargesettings', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> DeliveryChargeSettings</legend>
				{!! Form::hidden('id', $row['id']) !!}					
									  <div class="form-group row  " >
										<label for="Charge Type" class=" control-label col-md-4 text-left"> Charge Type <span class="asterix"> * </span></label>
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
										<label for="Charge in RS." class=" control-label col-md-4 text-left"> Charge in RS. <span class="asterix"> * </span></label>
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
										<label for="Order Value Type" class=" control-label col-md-4 text-left"> Order Value Type </label>
										<div class="col-md-6">
										  <input  type='text' name='order_value_type' id='order_value_type' value='{{ $row['order_value_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Minimum Order Value" class=" control-label col-md-4 text-left"> Minimum Order Value <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='order_value_min' id='order_value_min' value='{{ $row['order_value_min'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Maximum Order Value" class=" control-label col-md-4 text-left"> Maximum Order Value <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='order_value_max' id='order_value_max' value='{{ $row['order_value_max'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Distance Type" class=" control-label col-md-4 text-left"> Distance Type </label>
										<div class="col-md-6">
										  <input  type='text' name='distance_type' id='distance_type' value='{{ $row['distance_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Distance Minimum KM" class=" control-label col-md-4 text-left"> Distance Minimum KM <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='distance_min' id='distance_min' value='{{ $row['distance_min'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Distance Maximum KM" class=" control-label col-md-4 text-left"> Distance Maximum KM <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='distance_max' id='distance_max' value='{{ $row['distance_max'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Tax" class=" control-label col-md-4 text-left"> Tax <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='tax' id='tax' value='{{ $row['tax'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='status' value ='active' required @if($row['status'] == 'active') checked="checked" @endif class='minimal-green' > Active 
					
					<input type='radio' name='status' value ='inactive' required @if($row['status'] == 'inactive') checked="checked" @endif class='minimal-green' > Inactive  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset></div>

			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-default btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-default btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
				  </div>	  
			
		</div> 
		 <input type="hidden" name="action_task" value="public" />
		 {!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
