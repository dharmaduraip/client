

		 {!! Form::open(array('url'=>'deliveryboyrating', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Deliveryboy Rating</legend>
									
									  <div class="form-group row  " >
										<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
										<div class="col-md-6">
										  <input  type='text' name='id' id='id' value='{{ $row['id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Customer Name" class=" control-label col-md-4 text-left"> Customer Name </label>
										<div class="col-md-6">
										  <select name='cust_id' rows='5' id='cust_id' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Shop Name" class=" control-label col-md-4 text-left"> Shop Name </label>
										<div class="col-md-6">
										  <select name='res_id' rows='5' id='res_id' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Orderid" class=" control-label col-md-4 text-left"> Orderid </label>
										<div class="col-md-6">
										  <input  type='text' name='orderid' id='orderid' value='{{ $row['orderid'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Boy Name" class=" control-label col-md-4 text-left"> Boy Name </label>
										<div class="col-md-6">
										  <select name='boy_id' rows='5' id='boy_id' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Rating" class=" control-label col-md-4 text-left"> Rating </label>
										<div class="col-md-6">
										  <input  type='text' name='rating' id='rating' value='{{ $row['rating'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Comments" class=" control-label col-md-4 text-left"> Comments </label>
										<div class="col-md-6">
										  <input  type='text' name='comments' id='comments' value='{{ $row['comments'] }}' 
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
		
		
		$("#cust_id").jCombo("{!! url('deliveryboyrating/comboselect?filter=tb_users:id:username') !!}",
		{  selected_value : '{{ $row["cust_id"] }}' });
		
		$("#res_id").jCombo("{!! url('deliveryboyrating/comboselect?filter=abserve_restaurants:id:name') !!}",
		{  selected_value : '{{ $row["res_id"] }}' });
		
		$("#boy_id").jCombo("{!! url('deliveryboyrating/comboselect?filter=abserve_deliveryboys:id:username') !!}",
		{  selected_value : '{{ $row["boy_id"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
