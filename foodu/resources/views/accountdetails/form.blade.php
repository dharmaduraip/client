@extends('layouts.app')

@section('content')
<div class="page-header">
	  <h3> @if($type=='part') Partner account details </h3>
	  	@else
	  	<h3>Delivery Boy account details @endif  <small>  {{ $pageNote }} </small></h3>
	

</div>
             @if($type=='part')
			{!! Form::open(array('url'=>'accountdetails/store?type=part&return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
				@else
				{!! Form::open(array('url'=>'accountdetails/store?type=del&return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
				@endif
	
	


	<div class="p-5">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>		
		<div class="row">
	<div class="col-md-12">
						<fieldset>
				@if($type=='part')
			<legend> Partner account details</legend>
				@else
				<legend> Delivery Boy account details</legend>
				@endif
					</fieldset>
				{!! Form::hidden('id', $row['id']) !!}
				
					<div class="col-md-6">
										@if($type=='part')
											{!! Form::hidden('partner_id', isset($row['partner_id']) ? $row['partner_id'] : $partner_id,array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
											<input type="hidden" name="partner_id" value="{{$row['partner_id'] == ''? $partner_id : $row['partner_id'];}}">	
											@else
											{!! Form::hidden('delboy_id', isset($row['del_boy_id']) ? $row['del_boy_id'] : $del_boy_id,array('class'=>'form-control', 'placeholder'=>'',   )) !!}
											<input type="hidden" name="delboy_id" value="{{isset($row['del_boy_id']) ? $row['del_boy_id'] : $del_boy_id}}">	
											@endif
										</div> 

									  <div class="form-group row  " >
										<label for="Bank Name" class=" control-label col-md-4 text-left"> Bank Name </label>
										<div class="col-md-6">
										  <select name='Bank_Name' rows='5' id='Bank_Name' class='select2 '   >
										  	<option value="">Select Bank name</option>
												@if(count($abs_bank)>0)
												@foreach($abs_bank as $key=>$val)
												<option @if($val->name==$row['Bank_Name']) selected='' @endif value="{!!$val->name!!}">{!!$val->name!!}</option>
												@endforeach
												@endif
										  </select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> {!! Form::hidden('Bank_Code', $row['Bank_Code']) !!}					
									  <div class="form-group row  " >
										<label for="Bank AccName" class=" control-label col-md-4 text-left"> Bank AccName </label>
										<div class="col-md-6">
										  <input  type='text' name='Bank_AccName' id='Bank_AccName' value="{{ $row['Bank_AccName'] }}" 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Bank AccNumber" class=" control-label col-md-4 text-left"> Bank AccNumber </label>
										<div class="col-md-6">
										  <input  type='text' name='Bank_AccNumber' id='Bank_AccNumber' value="{{ $row['Bank_AccNumber'] }}" 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Ifsc Code" class=" control-label col-md-4 text-left"> Ifsc Code </label>
										<div class="col-md-6">
										  <input  type='text' name='ifsc_code' id='ifsc_code' value="{{ $row['ifsc_code'] }}" 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> {!! Form::hidden('Email', $row['Email']) !!}{!! Form::hidden('Mobile', $row['Mobile']) !!}{!! Form::hidden('id_type', $row['id_type']) !!}{!! Form::hidden('nric_number', $row['nric_number']) !!}					
									 				
									  <div class="form-group row  " >
										<label for="Fssai No" class=" control-label col-md-4 text-left"> Fssai No </label>
										<div class="col-md-6">
										  <input  type='text' name='fssai_no' id='fssai_no' value="{{ $row['fssai_no'] }}" 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Aadhar No" class=" control-label col-md-4 text-left"> Aadhar No </label>
										<div class="col-md-6">
										  <input  type='text' name='aadhar_no' id='aadhar_no' value="{{ $row['aadhar_no'] }}" class='form-control form-control-sm ' pattern="^[0-9]*$" maxlength='16' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Gst No" class=" control-label col-md-4 text-left"> Gst No </label>
										<div class="col-md-6">
										  <input  type='text' name='gst_no' id='gst_no' value="{{ $row['gst_no'] }}"
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Pan No" class=" control-label col-md-4 text-left"> Pan No </label>
										<div class="col-md-6">
										  <input  type='text' name='pan_no' id='pan_no' value="{{ $row['pan_no'] }}" 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 
									   <div class="form-group row  " >
										<label for="Razor Account Id" class=" control-label col-md-4 text-left"> Razor Account Id </label>
										<div class="col-md-6">
										  <input  type='text' name='razor_account_id' id='razor_account_id' value="{{ $row['razor_account_id'] }}" 
						     class='form-control form-control-sm ' readonly /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 	
									  {!! Form::hidden('last_updated', $row['last_updated']) !!}
									</fieldset>
									</div>

									  <div class="toolbar-nav">
		<div class="row">
			
			<div class="col-md-12 " >
				<div class="submitted-button">
					
					<button name="save" class="tips btn btn-sm "  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button> 
					              @if($type=='part')
											<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn   btn-sm "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-times"></i>{{ __('core.sb_cancel') }}</a> 
	
											@else
											<a href="{{ url($pageModule_1.'?return='.$return) }}" class="tips btn   btn-sm "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-times"></i>{{ __('core.sb_cancel') }}</a> 
											@endif
					

				</div>	
			</div>
			<div class="col-md-12  " >
				
			</div>
		</div>
	</div>	
	
		</div>
		
		<input type="hidden" name="action_task" value="save" />
		
		</div>
	</div>		
	{!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() {		
		// $("#Bank_Name").jCombo("{!! url('accountdetails/comboselect?filter=abs_bank:id:name') !!}",
		// {  selected_value : '{{ $row['Bank_Name'] }}' });	

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("accountdetails/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop