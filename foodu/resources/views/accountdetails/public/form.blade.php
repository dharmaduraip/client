

		 {!! Form::open(array('url'=>'accountdetails', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Partner account details</legend>
				{!! Form::hidden('id', $row['id']) !!}{!! Form::hidden('partner_id', $row['partner_id']) !!}					
									  <div class="form-group row  " >
										<label for="Bank Name" class=" control-label col-md-4 text-left"> Bank Name </label>
										<div class="col-md-6">
										  <select name='Bank_Name' rows='5' id='Bank_Name' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> {!! Form::hidden('Bank_Code', $row['Bank_Code']) !!}					
									  <div class="form-group row  " >
										<label for="Bank AccName" class=" control-label col-md-4 text-left"> Bank AccName </label>
										<div class="col-md-6">
										  <input  type='text' name='Bank_AccName' id='Bank_AccName' value='{{ $row['Bank_AccName'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Bank AccNumber" class=" control-label col-md-4 text-left"> Bank AccNumber </label>
										<div class="col-md-6">
										  <input  type='text' name='Bank_AccNumber' id='Bank_AccNumber' value='{{ $row['Bank_AccNumber'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Ifsc Code" class=" control-label col-md-4 text-left"> Ifsc Code </label>
										<div class="col-md-6">
										  <input  type='text' name='ifsc_code' id='ifsc_code' value='{{ $row['ifsc_code'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> {!! Form::hidden('Email', $row['Email']) !!}{!! Form::hidden('Mobile', $row['Mobile']) !!}{!! Form::hidden('id_type', $row['id_type']) !!}{!! Form::hidden('nric_number', $row['nric_number']) !!}					
									  <div class="form-group row  " >
										<label for="Razor Account Id" class=" control-label col-md-4 text-left"> Razor Account Id </label>
										<div class="col-md-6">
										  <input  type='text' name='razor_account_id' id='razor_account_id' value='{{ $row['razor_account_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Fssai No" class=" control-label col-md-4 text-left"> Fssai No </label>
										<div class="col-md-6">
										  <input  type='text' name='fssai_no' id='fssai_no' value='{{ $row['fssai_no'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Aadhar No" class=" control-label col-md-4 text-left"> Aadhar No </label>
										<div class="col-md-6">
										  <input  type='text' name='aadhar_no' id='aadhar_no' value='{{ $row['aadhar_no'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Gst No" class=" control-label col-md-4 text-left"> Gst No </label>
										<div class="col-md-6">
										  <input  type='text' name='gst_no' id='gst_no' value='{{ $row['gst_no'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Pan No" class=" control-label col-md-4 text-left"> Pan No </label>
										<div class="col-md-6">
										  <input  type='text' name='pan_no' id='pan_no' value='{{ $row['pan_no'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> {!! Form::hidden('last_updated', $row['last_updated']) !!}</fieldset></div>

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
		
		
		$("#Bank_Name").jCombo("{!! url('accountdetails/comboselect?filter=abs_bank:id:name') !!}",
		{  selected_value : '{{ $row["Bank_Name"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
