@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
{!! Form::open(array('url'=>'location?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
<div class="p-3">
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>		
	<div class="row m-0">
		<div class="col-md-12">
			<fieldset><legend> Location</legend>
				{!! Form::hidden('id', $row['id']) !!}					
				<div class="form-group row  " >
					<label for="Name" class=" control-label col-md-4 text-md-right"> Name <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='name' id='name' value='{{ $row['name'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Emergency Mode" class=" control-label col-md-4 text-md-right"> Emergency Mode <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input type='radio' name='emergency_mode' value ='on' required @if($row['emergency_mode'] == 'on') checked="checked" @endif class='minimal-green' > On 
						<input type='radio' name='emergency_mode' value ='off' required @if($row['emergency_mode'] == 'off') checked="checked" @endif class='minimal-green' > Off  
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Festival Mode" class=" control-label col-md-4 text-md-right"> Festival Mode <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input type='radio' name='festival_mode' value ='on' required @if($row['festival_mode'] == 'on') checked="checked" @endif class='minimal-green' > On 
						<input type='radio' name='festival_mode' value ='off' required @if($row['festival_mode'] == 'off') checked="checked" @endif class='minimal-green' > Off  
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Bad Weather Mode" class=" control-label col-md-4 text-md-right"> Bad Weather Mode <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input type='radio' name='bad_weather_mode' value ='on' required @if($row['bad_weather_mode'] == 'on') checked="checked" @endif class='minimal-green' > On 
						<input type='radio' name='bad_weather_mode' value ='off' required @if($row['bad_weather_mode'] == 'off') checked="checked" @endif class='minimal-green' > Off  
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Reason" class=" control-label col-md-4 text-md-right"> Reason </label>
					<div class="col-md-6">
						<textarea name='reason' rows='5' id='reason' class='form-control form-control-sm '  
						>{{ $row['reason'] }}</textarea> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Image" class=" control-label col-md-4 text-md-right"> Image </label>
					<div class="col-md-6">
						<div class="fileUpload btn " > 
							<span>  <i class="fa fa-camera"></i>  </span>
							<div class="title"> Browse File </div>
							<input type="file" name="image" class="upload"   accept="image/x-png,image/gif,image/jpeg"     />
						</div>
						<div class="image-preview preview-upload">
							{!! AbserveHelpers::showUploadedFile( $row["image"],"/uploads/location_ad/") !!}
						</div>
					</div> 
					<div class="col-md-2">
					</div>
				</div> 					
				<div class="form-group row  " >
					<label for="Ext Url" class=" control-label col-md-4 text-md-right"> Ext Url </label>
					<div class="col-md-6">
						<textarea name='ext_url' rows='5' id='ext_url' class='form-control form-control-sm '  
						>{{ $row['ext_url'] }}</textarea> 
					</div> 
					<div class="col-md-2">
					</div>
				</div> 
				<div class="toolbar-nav bg-white">
					<div class="row">
						<div class="col-md-12 text-center" >
							<div class="submitted-button">
								<button name="apply" class="tips btn btn-sm  btn-green"  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
								<button name="save" class="tips btn btn-sm  btn-black"  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button>
								<button type="button" onclick="location.href='{{ URL::to('location?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
							</div>	
						</div>
					</div>
				</div>	
			</fieldset></div>
		</div>	
		<input type="hidden" name="action_task" value="save" />	
	</div>
</div>		
{!! Form::close() !!}	 
<script type="text/javascript">
	$(document).ready(function() { 
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("location/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
	});
</script>		 
@stop