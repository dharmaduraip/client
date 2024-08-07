

		 {!! Form::open(array('url'=>'location', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Location</legend>
				{!! Form::hidden('id', $row['id']) !!}					
									  <div class="form-group row  " >
										<label for="Name" class=" control-label col-md-4 text-left"> Name <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='name' id='name' value='{{ $row['name'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Emergency Mode" class=" control-label col-md-4 text-left"> Emergency Mode <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='emergency_mode' value ='on' required @if($row['emergency_mode'] == 'on') checked="checked" @endif class='minimal-green' > On 
					
					<input type='radio' name='emergency_mode' value ='off' required @if($row['emergency_mode'] == 'off') checked="checked" @endif class='minimal-green' > Off  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Festival Mode" class=" control-label col-md-4 text-left"> Festival Mode <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='festival_mode' value ='on' required @if($row['festival_mode'] == 'on') checked="checked" @endif class='minimal-green' > On 
					
					<input type='radio' name='festival_mode' value ='off' required @if($row['festival_mode'] == 'off') checked="checked" @endif class='minimal-green' > Off  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Bad Weather Mode" class=" control-label col-md-4 text-left"> Bad Weather Mode <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='bad_weather_mode' value ='on' required @if($row['bad_weather_mode'] == 'on') checked="checked" @endif class='minimal-green' > On 
					
					<input type='radio' name='bad_weather_mode' value ='off' required @if($row['bad_weather_mode'] == 'off') checked="checked" @endif class='minimal-green' > Off  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Reason" class=" control-label col-md-4 text-left"> Reason </label>
										<div class="col-md-6">
										  <textarea name='reason' rows='5' id='reason' class='form-control form-control-sm '  
				           >{{ $row['reason'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Image" class=" control-label col-md-4 text-left"> Image </label>
										<div class="col-md-6">
										  
						<div class="fileUpload btn " > 
						    <span>  <i class="fa fa-camera"></i>  </span>
						    <div class="title"> Browse File </div>
						    <input type="file" name="image" class="upload"   accept="image/x-png,image/gif,image/jpeg"     />
						</div>
						<div class="image-preview preview-upload">
							{!! SiteHelpers::showUploadedFile( $row["image"],"") !!}
						</div>
					 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Ext Url" class=" control-label col-md-4 text-left"> Ext Url </label>
										<div class="col-md-6">
										  <textarea name='ext_url' rows='5' id='ext_url' class='form-control form-control-sm '  
				           >{{ $row['ext_url'] }}</textarea> 
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
