@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

	{!! Form::open(array('url'=>'sliderimages?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
	

	<div class="p-3">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>		
		<div class="row m-0">
			<div class="col-md-12">
				<fieldset>
					<legend> SliderImages</legend>
				{!! Form::hidden('id', $row['id']) !!}					
				  	<div class="form-group row  " >
						<label for="Image" class=" control-label col-md-4 text-md-right"> Image <span class="asterix"> * </span></label>
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
						<label for="Status" class=" control-label col-md-4 text-md-right"> Status <span class="asterix"> * </span></label>
						<div class="col-md-6">
							<input type='radio' name='status' value ='active' required @if($row['status'] == 'active') checked="checked" @endif class='minimal-green' > Active 

							<input type='radio' name='status' value ='inactive' required @if($row['status'] == 'inactive') checked="checked" @endif class='minimal-green' > Inactive  
						</div> 
						<div class="col-md-2">	
						</div>
					</div> 					
				  	<div class="form-group row  " >
						<label for="Url" class=" control-label col-md-4 text-md-right"> Url <span class="asterix"> * </span></label>
						<div class="col-md-6">
						  	<input  type='text' name='url' id='url' value='{{ $row['url'] }}' 
						required     class='form-control form-control-sm ' /> 
						</div> 
					 	<div class="col-md-2">
					 	
					 	</div>
					</div> 					
				  	<div class="form-group row  " >
						<label for="Ext Url" class=" control-label col-md-4 text-md-right"> Ext Url </label>
						<div class="col-md-6">
					  		<input  type='text' name='ext_url' id='ext_url' value='{{ $row['ext_url'] }}' class='form-control form-control-sm ' /> 
					 	</div> 
						 <div class="col-md-2">
						 </div>
				  	</div>

				  	<div class="">
				  		<div class="row">
				  			<div class="col-md-12 text-center" >
				  				<div class="submitted-button">
				  					<button name="apply" class="tips btn btn-sm  btn-green "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
				  					<button name="save" class="tips btn btn-sm btn-black"  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button> 
				  				</div>	
				  			</div>
				  			{{-- <div class="col-md-6 text-right " >
				  				<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn   btn-sm "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-times"></i></a> 
				  			</div> --}}
				  		</div>
				  	</div>	

				</fieldset>
			</div>
	
		</div>
		
		<input type="hidden" name="action_task" value="save" />
		
		</div>
	</div>		
	{!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		 	
		 	 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("sliderimages/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop