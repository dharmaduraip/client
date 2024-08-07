

		 {!! Form::open(array('url'=>'orderdetails', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> order details</legend>
				{!! Form::hidden('id', $row['id']) !!}					
									  <div class="form-group row  " >
										<label for="Partner Id" class=" control-label col-md-4 text-left"> Partner Id </label>
										<div class="col-md-6">
										  <input  type='text' name='partner_id' id='partner_id' value='{{ $row['partner_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Orderid" class=" control-label col-md-4 text-left"> Orderid <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='orderid' id='orderid' value='{{ $row['orderid'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Order Value" class=" control-label col-md-4 text-left"> Order Value </label>
										<div class="col-md-6">
										  <input  type='text' name='order_value' id='order_value' value='{{ $row['order_value'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Order Details" class=" control-label col-md-4 text-left"> Order Details </label>
										<div class="col-md-6">
										  <input  type='text' name='order_details' id='order_details' value='{{ $row['order_details'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Order Status" class=" control-label col-md-4 text-left"> Order Status </label>
										<div class="col-md-6">
										  <input  type='text' name='order_status' id='order_status' value='{{ $row['order_status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Order Accepted Time" class=" control-label col-md-4 text-left"> Order Accepted Time </label>
										<div class="col-md-6">
										  <input  type='text' name='order_accepted_time' id='order_accepted_time' value='{{ $row['order_accepted_time'] }}' 
						     class='form-control form-control-sm ' /> 
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
