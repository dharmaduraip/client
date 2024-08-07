@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

{!! Form::open(array('url'=>'masterdata?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
<div class="toolbar-nav">
	
</div>	


<div class="p-5">
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>		
	<div class="row">
		<div class="col-md-12">
			<fieldset><legend> Master Products</legend>
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
					<label for="Gst (%)" class=" control-label col-md-4 text-left"> Gst (%) <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='gst' id='gst' value='{{ $row['gst'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
						
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Category" class=" control-label col-md-4 text-left"> Category <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<select name='category' rows='5' id='category' class='select2 ' required  ></select> 
					</div> 
					<div class="col-md-2">
						
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Brand" class=" control-label col-md-4 text-left"> Brand <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<select name='brand' rows='5' id='brand' class='select2 ' required  ></select> 
					</div> 
					<div class="col-md-2">
						
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Image" class=" control-label col-md-4 text-left"> Image </label>
					<div class="col-md-6">
						
						<a href="javascript:void(0)" class="btn btn-xs btn-primary pull-right" onclick="addMoreFiles('image')"><i class="fa fa-plus"></i></a>
						<div class="imageUpl multipleUpl">	
							<div class="fileUpload btn " > 
								<span>  <i class="fa fa-camera"></i>  </span>
								<div class="title"> Browse File </div>
								<input type="file" name="image[]" class="upload"   accept="image/x-png,image/gif,image/jpeg"     />
							</div>		
						</div>
						<ul class="uploadedLists " >
							<?php $cr= 0; 
							$row['image'] = explode(",",$row['image']);
							?>
							@foreach($row['image'] as $files)
							@if(file_exists('.'.$files) && $files !='')
							<li id="cr-<?php echo $cr;?>" class="">							
								<a href="{{ url('/'.$files) }}" target="_blank" >
									{!! SiteHelpers::showUploadedFile( $files ,"/uploads/images/",100) !!}
								</a> 
								<span class="pull-right removeMultiFiles" rel="cr-<?php echo $cr;?>" url="{{$files}}">
									<i class="fa fa-trash-o  btn btn-xs btn-danger"></i></span>
									<input type="hidden" name="currimage[]" value="{{ $files }}"/>
									<?php ++$cr;?>
								</li>
								@endif
								
								@endforeach
							</ul>
							
						</div> 
						<div class="col-md-2">
							
						</div>
					</div> 	
					<?php if(isset($row['adon_type'])){?>				
						<div class="form-group row  " >
							<label for="Adon Type" class=" control-label col-md-4 text-left"> Adon Type </label>
							<div class="col-md-6">
								
								
								<input type='radio' name='adon_type' value ='-'  @if($row['adon_type'] == '-') checked="checked" @endif class='minimal-green' > None 
								
								<input type='radio' name='adon_type' value ='unit'  @if($row['adon_type'] == 'unit') checked="checked" @endif class='minimal-green' > Unit 
								
								<input type='radio' name='adon_type' value ='variation'  @if($row['adon_type'] == 'variation') checked="checked" @endif class='minimal-green' > Variation  
							</div> 
							<div class="col-md-2">
								
							</div>
						</div> 
					<?php } ?>					
					<div class="form-group row  " >
						<label for="Status" class=" control-label col-md-4 text-left"> Status </label>
						<div class="col-md-6">
							
							
							<input type='radio' name='status' value ='approved'  @if($row['status'] == 'approved') checked="checked" @endif class='minimal-green' > Approved 
							
							<input type='radio' name='status' value ='not_approved'  @if($row['status'] == 'not_approved') checked="checked" @endif class='minimal-green' > Not Approved  
						</div> 
						<div class="col-md-2">
							
						</div>
					</div> </fieldset></div>
					
				</div>
				<div class="row">
					
					<div class="col-md-6 " >
						<div class="submitted-button">
							<button name="apply" class="tips btn btn-sm   "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
							<button name="save" class="tips btn btn-sm "  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button> 
						</div>	
					</div>
					<div class="col-md-6 text-right " >
						<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn   btn-sm "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-times"></i></a> 
					</div>
				</div>
				
				<input type="hidden" name="action_task" value="save" />
				
			</div>
		</div>		
		{!! Form::close() !!}
		
		<script type="text/javascript">
			$(document).ready(function() { 
				
				
				
				$("#category").jCombo("{!! url('masterdata/comboselect?filter=abserve_food_categories:id:cat_name') !!}",
					{  selected_value : '{{ $row["category"] }}' });
				
				$("#brand").jCombo("{!! url('masterdata/comboselect?filter=abserve_food_categories:id:cat_name') !!}",
					{  selected_value : '{{ $row["brand"] }}' });
				
				

				$('.removeMultiFiles').on('click',function(){
					var removeUrl = '{{ url("masterdata/removefiles?file=")}}'+$(this).attr('url');
					$(this).parent().remove();
					$.get(removeUrl,function(response){});
					$(this).parent('div').empty();	
					return false;
				});		
				
			});
		</script>		 
		@stop