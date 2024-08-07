

		 {!! Form::open(array('url'=>'restaurant', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Restaurants</legend>
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
										<label for="Location" class=" control-label col-md-4 text-left"> Location <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='location' id='location' value='{{ $row['location'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="L Id" class=" control-label col-md-4 text-left"> L Id <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='l_id' id='l_id' value='{{ $row['l_id'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Logo" class=" control-label col-md-4 text-left"> Logo <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
						<div class="fileUpload btn " > 
						    <span>  <i class="fa fa-camera"></i>  </span>
						    <div class="title"> Browse File </div>
						    <input type="file" name="logo" class="upload"   accept="image/x-png,image/gif,image/jpeg"     />
						</div>
						<div class="logo-preview preview-upload">
							{!! SiteHelpers::showUploadedFile( $row["logo"],"") !!}
						</div>
					 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Partner Id" class=" control-label col-md-4 text-left"> Partner Id <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <select name='partner_id' rows='5' id='partner_id' class='select2 ' required  ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Phone" class=" control-label col-md-4 text-left"> Phone <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='phone' id='phone' value='{{ $row['phone'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cuisine" class=" control-label col-md-4 text-left"> Cuisine </label>
										<div class="col-md-6">
										  <select name='cuisine[]' multiple rows='5' id='cuisine' class='select2 '   ></select> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Budget" class=" control-label col-md-4 text-left"> Budget </label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='budget' value ='1'  @if($row['budget'] == '1') checked="checked" @endif class='minimal-green' > Low 
					
					<input type='radio' name='budget' value ='2'  @if($row['budget'] == '2') checked="checked" @endif class='minimal-green' > Medium 
					
					<input type='radio' name='budget' value ='3'  @if($row['budget'] == '3') checked="checked" @endif class='minimal-green' > High 
					
					<input type='radio' name='budget' value ='4'  @if($row['budget'] == '4') checked="checked" @endif class='minimal-green' > Very High  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Res Desc" class=" control-label col-md-4 text-left"> Res Desc </label>
										<div class="col-md-6">
										  <input  type='text' name='res_desc' id='res_desc' value='{{ $row['res_desc'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Status" class=" control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='status' value ='1' required @if($row['status'] == '1') checked="checked" @endif class='minimal-green' > Active 
					
					<input type='radio' name='status' value ='2' required @if($row['status'] == '2') checked="checked" @endif class='minimal-green' > Inactive  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Commission" class=" control-label col-md-4 text-left"> Commission <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='commission' id='commission' value='{{ $row['commission'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Admin Status" class=" control-label col-md-4 text-left"> Admin Status </label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='admin_status' value ='approved'  @if($row['admin_status'] == 'approved') checked="checked" @endif class='minimal-green' > Approved 
					
					<input type='radio' name='admin_status' value ='rejected'  @if($row['admin_status'] == 'rejected') checked="checked" @endif class='minimal-green' > Rejected 
					
					<input type='radio' name='admin_status' value ='waiting'  @if($row['admin_status'] == 'waiting') checked="checked" @endif class='minimal-green' > Waiting  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Tagline" class=" control-label col-md-4 text-left"> Tagline <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='tagline' id='tagline' value='{{ $row['tagline'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Mode" class=" control-label col-md-4 text-left"> Mode <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='mode' value ='open' required @if($row['mode'] == 'open') checked="checked" @endif class='minimal-green' > Open 
					
					<input type='radio' name='mode' value ='close' required @if($row['mode'] == 'close') checked="checked" @endif class='minimal-green' > Close  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Shop Categories" class=" control-label col-md-4 text-left"> Shop Categories <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <textarea name='shop_categories' rows='5' id='shop_categories' class='form-control form-control-sm '  
				         required  >{{ $row['shop_categories'] }}</textarea> 
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
		
		
		$("#partner_id").jCombo("{!! url('restaurant/comboselect?filter=tb_users:id:username') !!}",
		{  selected_value : '{{ $row["partner_id"] }}' });
		
		$("#cuisine").jCombo("{!! url('restaurant/comboselect?filter=abserve_food_cuisines:id:name') !!}",
		{  selected_value : '{{ $row["cuisine"] }}' });
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
