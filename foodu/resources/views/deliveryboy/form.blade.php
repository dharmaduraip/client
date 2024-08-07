	@extends('layouts.app')

	@section('content')
	<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

	{!! Form::open(array('url'=>'deliveryboy?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
	<div class="p-3">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>		
		<div class="row m-0">
			<div class="col-md-12">
				<fieldset><legend> Delivery_Boys</legend>
					{!! Form::hidden('id', $row['id']) !!}					
					<div class="form-group row  " >
						<label for="Username" class=" control-label col-md-4 text-md-right"> Username <span class="asterix"> * </span></label>
						<div class="col-md-6">
							<input  type='text' name='username' id='username' value='{{ $row['username'] }}' 
							required     class='form-control form-control-sm ' /> 
						</div> 
						<div class="col-md-2">

						</div>
					</div> 					
					<div class="form-group row  " >
						<label for="Email" class=" control-label col-md-4 text-md-right"> {!! trans('core.abs_email') !!} <span class="asterix"  >  </span></label>
						<div class="col-md-6">
							{!! Form::text('email', \AbserveHelpers::randomMail($row['email']),array('class'=>'form-control', 'placeholder'=>'','id'=>'emailaddr' )) !!} 
						</div>
						<span id="email"></span>

						<div class="col-md-2">

						</div>
					</div> 						
					<div class="form-group row " >
						<label for="Phone Number" class=" control-label col-md-4 text-md-right"> {!! trans('core.phone_number') !!} <span class="asterix"> * </span></label>

						<div class="col-md-6">
							{!! Form::text('phone_number', $row['phone_number'],array('class'=>'form-control allownumericwithoutdecimal phone', 'placeholder'=>'', 'required'=>'true','min'=>0, 'parsley-type'=>'number'  )) !!} 
						</div> 
						<span id="phone"></span>
						<div class="col-md-2">
						</div>
					</div>
					<div class="form-group row " >
						<label for="Address" class=" control-label col-md-4 text-md-right"> Address <span class="asterix"> * </span></label>
						<div class="col-md-6">
							{!! Form::text('address', $row['address'],array('class'=>'form-control google_key', 'id'=>'google_key', 'required'=>'true'  )) !!} 
						</div> 
						<div class="col-md-2">
						</div>
					</div> 					
					<div class="form-group row  " >
						<label for="Avatar" class=" control-label col-md-4 text-md-right"> Avatar </label>
						<div class="col-md-6">
							<div class="fileUpload btn " > 
								<span>  <i class="fa fa-camera"></i>  </span>
								<div class="title"> Browse File </div>
								<input type="file" name="avatar" class="upload"   accept="image/x-png,image/gif,image/jpeg"     />
							</div>
							<div class="avatar-preview preview-upload">
								{!! AbserveHelpers::showUploadedFile( $row["avatar"],"/uploads/users/") !!}
							</div>
						</div> 
						<div class="col-md-2">
						</div>
					</div> 					
					<div class="form-group row  " >
						<label for="Active" class=" control-label col-md-4 text-md-right"> Active <span class="asterix"> * </span></label>
						<div class="col-md-6">
							<input type='radio' name='d_active' value ='1' required @if($row['d_active'] == '1') checked="checked" @endif class='minimal-green' > Active 

							<input type='radio' name='d_active' value ='3' required @if($row['d_active'] == '3') checked="checked" @endif class='minimal-green' > Inactive 
							<input type='radio' name='d_active' value ='2' required @if($row['d_active'] == '2') checked="checked" @endif class='minimal-green' > Block  
						</div> 
						<div class="col-md-2">
						</div>
					</div> 	
					<!-- <div class="form-group row  " >
						<label for="Active" class=" control-label col-md-4 text-md-right"> customer Active <span class="asterix"> * </span></label>
						<div class="col-md-6">
							<input type='radio' name='active' value ='1' required @if($row['active'] == '1') checked="checked" @endif class='minimal-green' > Active 
							<input type='radio' name='active' value ='0' required @if($row['active'] == '0') checked="checked" @endif class='minimal-green' > Inactive 
							<input type='radio' name='active' value ='2' required @if($row['active'] == '2') checked="checked" @endif class='minimal-green' > Block  
						</div> 
						<div class="col-md-2">
						</div>
					</div>  -->

					<div class="form-group row  ">
						<div class="col-md-12 " >
							<div class="submitted-button text-center mt-4">
								<button name="apply" class="tips btn btn-sm  btn-green "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
								<button name="save" class="tips btn btn-sm btn-black"  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button>
								<button type="button" onclick="location.href='{{ URL::to('deliveryboy?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
							</div>	
						</div>
					</div>
				</fieldset></div>
			</div>
			<input type="hidden" name="latitude" id="latitude" value="">
			<input type="hidden" name="longitude" id="longitude" value="">
			<input type="hidden" name="city" id="city" value="">
			<input type="hidden" name="state" id="state" value="">
			<input type="hidden" name="action_task" value="save" />
		</div>
	</div>		
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("deliveryboy/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});			
	});
</script>
<?php 
$keys = \AbserveHelpers::site_setting('googlemap_key');
?>
<script src="https://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key={{$keys->googlemap_key}}"></script><script type="text/javascript">
	var IsplaceChange = true;
	var base_url    = "<?php echo URL::to('/').'/'; ?>";
	$(document).ready(function () {
		var input = document.getElementById('google_key');
		var autocomplete = new google.maps.places.Autocomplete(document.getElementById('google_key'));
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place   = autocomplete.getPlace();
			var components = place.address_components;
			for (var i = 0, component; component = components[i]; i++) {
				if(component.types[0] == 'administrative_area_level_1'){
					$("#state").val(component.long_name);
				}
				if (component.types[0] == 'locality') {
					$("#city").val(component['long_name']);
				}
			}
			var latitude  = place.geometry.location.lat();
			var longitude = place.geometry.location.lng();
			$('#latitude').val(latitude);
			$('#longitude').val(longitude);
			IsplaceChange = true;
		});
		$("#google_key").keydown(function () {
			IsplaceChange = false;
		});
		$("#google_key").focusout(function () {      
			if (IsplaceChange) {
			} else {
				$('#latitude').val('');
				$('#longitude').val('');
				$("#google_key").val('');
			}
		});
	});

	$('#emailaddr').blur(function(){
		var email = $(this).val();
		var pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
		if(email != ''){
			if(!pattern.test(email)){
				$('#email').addClass('reg_err').html('Invalid Email').css('color','red');
			}else{
				$.ajax({
					type : 'POST',
					url:base_url+"user/checkemail",
					data : {'email':email},
					success: function (data) {
						if(data == 1){
							$('#email').addClass('reg_err').html('Email address already exists').css('color','red');
						}else{
							$('#email').removeClass('reg_err').html('Email ').css('color','#999');
						}
					} 
				});  
			}
	    }
	});
	$("#emailaddr").focusout(function () {
		var email = $(this).val();
		if(email == '')  {
			$('#email').addClass('reg_err').html('');
		}
	});
	$(".phone").focusout(function () {
		var phone = $(this).val();
		if(phone == '')  {
			$('#phone').addClass('reg_err').html('');
		}
	});
	$('.phone').blur(function(){
		var phone = $(this).val();
		if(phone != ''){
			if(phone.length<10){
				$('#phone').addClass('reg_err').html('Invalid Phone Number').css('color','red');
			}else{
				$.ajax({
					type : 'POST',
					url:base_url+"user/checkphone",
					data : {'phone':phone},
					success: function (data) {
						if(data == 1){
							$('#phone').addClass('reg_err').html('Phone number already exists').css('color','red');
						}else{
							$('#phone').removeClass('reg_err').html('Phone Number ').css('color','#999');
						}
					} 
				});    
			}
		}
	});
</script>		 
@stop