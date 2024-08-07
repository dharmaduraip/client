

		 {!! Form::open(array('url'=>'fooditems', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> Hotel_food_items</legend>
				{!! Form::hidden('id', $row['id']) !!}					
									  <div class="form-group row  " >
										<label for="Restaurant Id" class=" control-label col-md-4 text-left"> Restaurant Id <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='restaurant_id' id='restaurant_id' value='{{ $row['restaurant_id'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Food Item" class=" control-label col-md-4 text-left"> Food Item <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='food_item' id='food_item' value='{{ $row['food_item'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Description" class=" control-label col-md-4 text-left"> Description </label>
										<div class="col-md-6">
										  <input  type='text' name='description' id='description' value='{{ $row['description'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Specification" class=" control-label col-md-4 text-left"> Specification </label>
										<div class="col-md-6">
										  <input  type='text' name='specification' id='specification' value='{{ $row['specification'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Price" class=" control-label col-md-4 text-left"> Price <span class="asterix"> * </span></label>
										<div class="col-md-6">
										  <input  type='text' name='price' id='price' value='{{ $row['price'] }}' 
						required     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Selling Price" class=" control-label col-md-4 text-left"> Selling Price </label>
										<div class="col-md-6">
										  <input  type='text' name='selling_price' id='selling_price' value='{{ $row['selling_price'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Strike Price" class=" control-label col-md-4 text-left"> Strike Price </label>
										<div class="col-md-6">
										  <input  type='text' name='strike_price' id='strike_price' value='{{ $row['strike_price'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Original Price" class=" control-label col-md-4 text-left"> Original Price </label>
										<div class="col-md-6">
										  <input  type='text' name='original_price' id='original_price' value='{{ $row['original_price'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Hiking" class=" control-label col-md-4 text-left"> Hiking </label>
										<div class="col-md-6">
										  <input  type='text' name='hiking' id='hiking' value='{{ $row['hiking'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Status" class=" control-label col-md-4 text-left"> Status </label>
										<div class="col-md-6">
										  <input  type='text' name='status' id='status' value='{{ $row['status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Gst" class=" control-label col-md-4 text-left"> Gst </label>
										<div class="col-md-6">
										  <input  type='text' name='gst' id='gst' value='{{ $row['gst'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Available From" class=" control-label col-md-4 text-left"> Available From </label>
										<div class="col-md-6">
										  <textarea name='available_from' rows='5' id='available_from' class='form-control form-control-sm '  
				           >{{ $row['available_from'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Available To" class=" control-label col-md-4 text-left"> Available To </label>
										<div class="col-md-6">
										  <textarea name='available_to' rows='5' id='available_to' class='form-control form-control-sm '  
				           >{{ $row['available_to'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Available From2" class=" control-label col-md-4 text-left"> Available From2 </label>
										<div class="col-md-6">
										  <textarea name='available_from2' rows='5' id='available_from2' class='form-control form-control-sm '  
				           >{{ $row['available_from2'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Available To2" class=" control-label col-md-4 text-left"> Available To2 </label>
										<div class="col-md-6">
										  <textarea name='available_to2' rows='5' id='available_to2' class='form-control form-control-sm '  
				           >{{ $row['available_to2'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Item Status" class=" control-label col-md-4 text-left"> Item Status </label>
										<div class="col-md-6">
										  <input  type='text' name='item_status' id='item_status' value='{{ $row['item_status'] }}' 
						     class='form-control form-control-sm ' /> 
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
										<label for="Main Cat" class=" control-label col-md-4 text-left"> Main Cat </label>
										<div class="col-md-6">
										  <input  type='text' name='main_cat' id='main_cat' value='{{ $row['main_cat'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Adon Type" class=" control-label col-md-4 text-left"> Adon Type </label>
										<div class="col-md-6">
										  <input  type='text' name='adon_type' id='adon_type' value='{{ $row['adon_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Sub Cat" class=" control-label col-md-4 text-left"> Sub Cat </label>
										<div class="col-md-6">
										  <input  type='text' name='sub_cat' id='sub_cat' value='{{ $row['sub_cat'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Recommended" class=" control-label col-md-4 text-left"> Recommended </label>
										<div class="col-md-6">
										  
					
					<input type='radio' name='recommended' value ='1'  @if($row['recommended'] == '1') checked="checked" @endif class='minimal-green' > Yes 
					
					<input type='radio' name='recommended' value ='0'  @if($row['recommended'] == '0') checked="checked" @endif class='minimal-green' > No  
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Ingredients" class=" control-label col-md-4 text-left"> Ingredients </label>
										<div class="col-md-6">
										  <input  type='text' name='ingredients' id='ingredients' value='{{ $row['ingredients'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Quantity" class=" control-label col-md-4 text-left"> Quantity </label>
										<div class="col-md-6">
										  <input  type='text' name='quantity' id='quantity' value='{{ $row['quantity'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Created" class=" control-label col-md-4 text-left"> Created </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('created', $row['created'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="ApproveStatus" class=" control-label col-md-4 text-left"> ApproveStatus </label>
										<div class="col-md-6">
										  <input  type='text' name='approveStatus' id='approveStatus' value='{{ $row['approveStatus'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Del Status" class=" control-label col-md-4 text-left"> Del Status </label>
										<div class="col-md-6">
										  <input  type='text' name='del_status' id='del_status' value='{{ $row['del_status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Created At" class=" control-label col-md-4 text-left"> Created At </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('created_at', $row['created_at'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Updated At" class=" control-label col-md-4 text-left"> Updated At </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('updated_at', $row['updated_at'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
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
