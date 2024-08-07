

		 {!! Form::open(array('url'=>'promocode', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> PromoCode</legend>
				{!! Form::hidden('id', $row['id']) !!}					
									  <div class="form-group row  " >
										<label for="Promo Name" class=" control-label col-md-4 text-left"> Promo Name <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='promo_name' id='promo_name' value='{{ $row['promo_name'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Promo Code" class=" control-label col-md-4 text-left"> Promo Code </label>
										<div class="col-md-6">
										  <input  type='text' name='promo_code' id='promo_code' value='{{ $row['promo_code'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Promo Desc" class=" control-label col-md-4 text-left"> Promo Desc <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <textarea name='promo_desc' rows='5' id='promo_desc' class='form-control form-control-sm '  
				         required  >{{ $row['promo_desc'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Start Date" class=" control-label col-md-4 text-left"> Start Date <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('start_date', $row['start_date'],array('class'=>'form-control form-control-sm date')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="End Date" class=" control-label col-md-4 text-left"> End Date <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('end_date', $row['end_date'],array('class'=>'form-control form-control-sm date')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Avatar" class=" control-label col-md-4 text-left"> Avatar </label>
										<div class="col-md-6">
										  
						<div class="fileUpload btn " > 
						    <span>  <i class="fa fa-camera"></i>  </span>
						    <div class="title"> Browse File </div>
						    <input type="file" name="avatar" class="upload"   accept="image/x-png,image/gif,image/jpeg"     />
						</div>
						<div class="avatar-preview preview-upload">
							{!! SiteHelpers::showUploadedFile( $row["avatar"],"") !!}
						</div>
					 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Promo Type" class=" control-label col-md-4 text-left"> Promo Type <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='promo_type' value ='amount' required @if($row['promo_type'] == 'amount') checked="checked" @endif class='minimal-green' > Amount 
					
					<input type='radio' name='promo_type' value ='percentage' required @if($row['promo_type'] == 'percentage') checked="checked" @endif class='minimal-green' > Percentage  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Promo Offer" class=" control-label col-md-4 text-left"> Promo Offer <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='promo_amount' id='promo_amount' value='{{ $row['promo_amount'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Limit " class=" control-label col-md-4 text-left"> Limit  <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='limit_values' id='limit_values' value='{{ $row['limit_values'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Min Order Amount" class=" control-label col-md-4 text-left"> Min Order Amount </label>
										<div class="col-md-6">
										  <input  type='text' name='min_order_value' id='min_order_value' value='{{ $row['min_order_value'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Maximum Discount" class=" control-label col-md-4 text-left"> Maximum Discount </label>
										<div class="col-md-6">
										  <input  type='text' name='max_discount' id='max_discount' value='{{ $row['max_discount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Customer" class=" control-label col-md-4 text-left"> Customer <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <textarea name='user_id' rows='5' id='user_id' class='form-control form-control-sm '  
				         required  >{{ $row['user_id'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Number of usage to single customer" class=" control-label col-md-4 text-left"> Number of usage to single customer <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='usage_count' id='usage_count' value='{{ $row['usage_count'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Promo Mode" class=" control-label col-md-4 text-left"> Promo Mode <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='promo_mode' value ='on' required @if($row['promo_mode'] == 'on') checked="checked" @endif class='minimal-green' > On 
					
					<input type='radio' name='promo_mode' value ='off' required @if($row['promo_mode'] == 'off') checked="checked" @endif class='minimal-green' > Off  
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
