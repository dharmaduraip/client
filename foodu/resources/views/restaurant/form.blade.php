@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<style type="text/css">
	.cropit-image-preview {background-color: #f8f8f8;background-size: cover;border: 1px solid #ccc;border-radius: 3px;margin-top: 7px;width: 300px;height: 180px;cursor: move;}
	.cropit-image-preview1 {background-color: #f8f8f8;background-size: cover;border: 1px solid #ccc;border-radius: 3px;margin-top: 7px;width: 450px;height: 450px;cursor: move;}
	.cropit-image-background {opacity: .2;cursor: auto;}
	.image-size-label {margin-top: 10px;}
</style>
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

{!! Form::open(array('url'=>'restaurant?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
<div class="m-3 box-border">
	<div class="sbox-title"> <h4> <i class="fa fa-table text-light"></i> </h4></div>
<!-- <ul class="parsley-error-list">
@foreach($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul> -->		
<div class="row m-0">
	<div class="col-md-12 p-0">
		<fieldset><!--<legend> Restaurants</legend>-->
			{!! Form::open(array('url'=>'restaurant/save?return='.$return, 'class'=>'form-horizontal','id'=>'res_sub','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
			<div class="row fieldset_border">	
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
					<fieldset>
						{{-- <input type="hidden" value="{{$row['logo']}}" id="previous_image"> --}}
						<legend> Shop</legend>
						<div class="form-group hidethis row" style="display:none;">
							<label for="Id" class=" control-label col-md-4 text-md-right"> Id </label>
							<div class="col-md-6">
								{!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row"  style="display:none;">
							<label for="Name" class=" control-label col-md-4 text-md-right"> Partner code <span class="asterix"> * </span></label>
							<div class="col-md-6">
								{!! Form::text('partner_code', $row['partner_code'],array('class'=>'form-control', 'placeholder'=>''  )) !!} 
							</div> 
							<div class=""></div>
						</div> 						
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> Shop Name <span class="asterix"> * </span></label>
							<div class="col-md-6">
								{!! Form::text('name', $row['name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
							</div> 
							<div class=""></div>
						</div> 	
						{{--<div class="form-group  row" >
							<label for="Status" class=" control-label col-md-4 text-md-right">Location<span class="asterix"> * </span></label>
							<div class="col-md-6">
								<select class="form-control" required="" name="l_id">
									<option value="">Select..</option>
									<?php $location = \AbserveHelpers::location_list(); ?>
									@foreach($location as $valL)
									<option @if($valL->id==$row['l_id']) selected="" @endif value="{{$valL->id}}">{{$valL->name}}</option>
									@endforeach
								</select>	
							</div> 
							<div class="">	
							</div>
						</div>--}}				
						<div class="form-group row" >
							<label for="Location" class=" control-label col-md-4 text-md-right"> Location of Shop<span class="asterix"> * </span></label>
							<div class="col-md-6">
								{!! Form::text('location', $row['location'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' ,'id'=>'txtPlaces' )) !!} 
								<div id="fn_map" style="display: none;"><a href="javascript:" class="fn_map_modal">Click Here to view Exact location</a></div>
								<div class="loc_error"></div>
							</div> 
							<div class=""></div>
						</div> 	
						@if(\Auth::user()->group_id ==1 || \Auth::user()->group_id == 2)
						<div class="form-group  row" >
							<label for="Partner Id" class=" control-label col-md-4 text-md-right"> Owner Name <span class="asterix"> * </span></label>
							<div class="col-md-6"> 
								<select name='partner_id' rows='5' id='partner_id' class='select2' >
								</select>
							</div> 
							<div class=""></div>
						</div> 
						@else
						<input type="hidden" id="partner_id" name="partner_id" value="{{ \Auth::user()->id }}" />
						@endif				
						<div class="form-group row " >
							<label for="Cuisine" class=" control-label col-md-4 text-md-right"> Shop Category <span class="asterix"> * </span></label>
							<div class="col-md-6">
								<select name='cuisine[]' multiple rows='5' id='cuisine' class='select2 '  required='true' ></select> 
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group  row" >
							<label for="res_desc" class=" control-label col-md-4 text-md-right"> Description </label>
							<div class="col-md-6">
								<textarea rows="3" name="res_desc"  value="" class="form-control" style="resize: none;height: auto;">@if($row['res_desc'] != ''){!! $row['res_desc'] !!}@elseif(old('res_desc')) {{old('res_desc')}} @endif</textarea>
							</div> 
							<div class=""></div>
						</div> 
						@if(PICKDEL_OPTION=='enable')
						<?php $deliver_status = explode(',', $row['deliver_status']); ?>
						<div class="form-group  row" >
							<label for="Delivery Status" class=" control-label col-md-4 text-md-right"> Delivery status </label>
							<div class="col-md-6 delivery_stat_div">
								<div class="col-xs-12 no-pad">
									<label class='delivery_stat'>
										<input type='checkbox' required @if (in_array('pickup', $deliver_status)) checked @endif name='deliver_status[]' required='true' value ='pickup'> Pickup 
									</label>
								</div>
								<div class="col-xs-12 no-pad">
									<label class='delivery_stat'>
										<input type='checkbox' required @if (in_array('deliver', $deliver_status)) checked @endif name='deliver_status[]' value ='delivery'> Delivery
									</label> 
								</div>
							</div>
							<div class=""></div>
						</div>
						@endif
						@if(PREORDER_OPTION=='enable')
						<div class="form-group d-flex flex-wrap" >
							<label for="Delivery Status" class=" control-label col-md-4 text-md-right"> Pre order status </label>
							<div class="col-md-6 delivery_stat_div">
								<div class="col-xs-12 no-pad">
									<label class='delivery_stat'>
										<input type='radio' required @if ($row['preoder']=='yes') checked @endif name='preoder' required='true' value ='yes'> Yes 
										<input type='radio' required @if ($row['preoder']=='no' || $row['preoder']=='' ) checked @endif name='preoder' required='true' value ='no'> No 
									</label>
								</div>
							</div>
							<div class=""></div>
						</div>
						@endif

						<div class="form-group d-flex flex-wrap" >
							<label for="Restaurant Category" class=" control-label col-md-4 text-md-right"> Restaurant Category </label>
							<div class="col-md-6 delivery_stat_div">
								<div class="col-xs-12 no-pad">
									<label class='delivery_stat'>
										<input type='radio' required @if ($row['restaurant_cat']=='veg') checked @endif name='restaurant_cat' required='true' value ='veg'> Pure-veg 
										<input type='radio' required @if ($row['restaurant_cat']=='non-veg') checked @endif name='restaurant_cat' required='true' value ='non-veg'> Non-veg
										<input type='radio' required @if ($row['restaurant_cat']=='both') || $row['restaurant_cat']=='' ) checked @endif name='restaurant_cat' required='true' value ='both'> Both 
									</label>
								</div>
							</div>
							<div class=""></div>
						</div>

						<div class="d-flex justify-content-center">
							<div data-toggle="modal" href="#image" id="up_image" class="btn btn-success"><b id="chang_name">Click to Upload Image</b></div>
							<div id="img_valid" style="color: #cc0000;display: none;">This value is required.</div>
						</div>
						<div class="modal" id="image" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header" style="background-color:#1ABC9C">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
										<h4 class="modal-title" style="color:#FFF;font-weight:bold">Edit Image</h4>
									</div>
									<div class="modal-body">
										<div class="image-editor" align="center">
											<input type="file" class="cropit-image-input btn btn-default" id="image_file" name="res_image_input">
											<div class="cropit-image-preview"></div>
											<div class="image-size-label">
												Resize image
											</div>
											<button class="btn btn-success" type="button" onclick="return get_image()">Export</button>
											<div id="empty_image_note" value=""></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="pt-3">
							<legend>Only For Admin</legend>
							<div class="col-xs-12" style="padding: 10px 15px 20px">
								<img id="imageid" name="imageid" class="center-block" alt="" />
								<input type="hidden" name="restaurant_image"  id="user_image" >
							</div>
							<div class="col-md-0"></div>
							@if(\Auth::user()->group_id == '1' || \Auth::user()->group_id == '2')
							<div class="form-group row">
								<label for="Admin Status" class=" control-label col-md-4 text-md-right">Admin Status</label>
								<div class="col-md-6">
									<label class="radio radio-inline">
										<input type="radio" class="adminstatus" name="adminstatus" @if($row['admin_status'] == 'approved') checked @endif value="approved"> Approved
									</label>
									<label class="radio radio-inline">
										<input type="radio" class="adminstatus" name="adminstatus" @if($row['admin_status'] == 'rejected' || $row['admin_status'] =='' ) checked @endif value="rejected"> Rejected
									</label> 
									<label class="radio radio-inline">
										<input type="radio" class="adminstatus" name="adminstatus" @if($row['admin_status'] == 'waiting') checked @endif value="waiting"> Waiting
									</label> 
								</div> 
								<div class=""></div>
							</div> 
							<div class="form-group row" >
								<label for="Name" class=" control-label col-md-4 text-md-right"> Featured shop <span class="asterix"> * </span></label>
								<div class="col-md-6">
									<label class="radio radio-inline">
										<input type="radio" class="ordering" name="ordering" @if($row['ordering'] == '1') checked @endif value="1"> Enable
									</label>
									<label class="radio radio-inline">
										<input type="radio" class="ordering" name="ordering" @if($row['ordering'] == '2' || $row['ordering'] == '' ) checked @endif value="2"> Disable
									</label> 
								</div> 
								<div class=""></div>
							</div> 
						</div>
						@endif
					</fieldset>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<fieldset>
						<legend>Other Details</legend>
						<div class="form-group d-flex flex-wrap" >
							<label for="GST Applicable" class=" control-label col-md-4 text-right"> GST Applicable <span class="asterix"> * </span></label>
							<div class="col-md-6">
								<label class="radio radio-inline">
									<input type='radio' id="show_1" required @if (isset($row->gst_applicable) && ($row->gst_applicable=='yes')) checked @endif name='gst_applicable' required='true' value ='yes' checked> Yes 
								</label>
								<label class="radio radio-inline">
									<input type='radio' id="hide_1" required @if (isset($row->gst_applicable) && ($row->gst_applicable=='no' || $row->gst_applicable=='') ) checked @endif name='gst_applicable' required='true' value ='no'> No 
								</label>
							</div>
						</div>
						<div class="form-groupgst tax_div" @if(isset($row->gst_applicable) && $row->gst_applicable == 'no') style="display:none;" @endif>
							<div class="d-flex flex-wrap">
								<label for="Service Tax" class=" control-label col-md-4 text-right"> Service Tax(%) <span class="asterix"> * </span></label>
								<div class="col-md-6">
									{!! Form::text('service_tax1', $row['service_tax1'],array('class'=>'form-control float_number', 'placeholder'=>'', 'parsley-type'=>'number'   )) !!} 
								</div> 
							</div>
						</div>
						{{--<div class="form-groupgst tax_div" @if(isset($row->gst_applicable)=='no') style="display:none;" @endif >
							<div class="d-flex flex-wrap pb-3 pt-3">
								<label for="GST" class=" control-label col-md-4 text-right"> GST <span class="asterix"> * </span></label>
								<div class="col-md-6">
									{!! Form::text('gst', $row['gst'],array('class'=>'form-control float_number', 'placeholder'=>'',  'parsley-type'=>'number'   )) !!} 
								</div> 
							</div>
						</div>--}}
<script type="text/javascript">
	$('.float_number').keypress(function(event) {
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
			event.preventDefault();
		}
	});
</script>
<div class="form-group row del_charge_err_div">
	<label for="Delivery Charge" class=" control-label col-md-4 text-md-right">Status<span class="asterix"> * </span></label>
	<div class="col-md-6">
		<label class="radio radio-inline">
			<input type="radio" class="res_status" required name="res_status" @if($row['status'] == '1') checked @endif value="1"> Active
		</label>
		<label class="radio radio-inline">
			<input type="radio" class="res_status" required name="res_status" @if($row['status'] == '2' || $row['status']=='' ) checked @endif value="2"> Inactive
		</label>

	</div> 
	<div class=""></div>
</div> 	
<div class="form-group row del_charge_err_div">
	<label for="Delivery Charge" class=" control-label col-md-4 text-md-right">Mode<span class="asterix"> * </span></label>
	<div class="col-md-6">
		<label class="radio radio-inline">
			<input type="radio" class="mode" required name="mode" @if($row['mode'] == 'open') checked @endif value="open"> Open
		</label>
		<label class="radio radio-inline">
			<input type="radio" class="mode" required name="mode" @if($row['mode'] == 'close' || $row['mode']=='' ) checked @endif value="close"> Close
		</label>
	</div> 
	<div class=""></div>
</div>

<script type="text/javascript">
	$('.free_delivery').on('ifChanged', function(event){  
		if(this.checked && $(this).val() == 1) {  
			$(".delivery_price").hide();
		}else{
			$(".delivery_price").show();
		}
	});
</script>		
<div class="form-group row " >
	<label for="commission"  class=" control-label col-md-4 text-md-right">Commission Charge<span class="asterix"> * </span></label>

	<div class="col-md-6">
		{!! Form::text('commission', $row['commission'],array('class'=>'form-control allownumericwithoutdecimal', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'number', 'min' => '1',  )) !!} 
	</div> 
	<div class=""></div>
</div>
<div class="form-group row  " >
	<label for="Phone" class=" control-label col-md-4 text-md-right"> Phone <span class="asterix"> * </span></label>
	<div class="col-md-6">
		{!! Form::text('phone', $row['phone'],array('class'=>'form-control allownumericwithoutdecimal ', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'unique:abserve_restaurants,phone'   )) !!} 
		@error('phone')
    		<div class="parsley-required parsley-error"><span class="error" style = "color: #cc0000;font-size: 13px;font-style:italic;">{{ $message }}</span></div>
		@enderror
	</div> 
	<div class=""></div>
</div> 	
{{--<div class="form-group row " >
	<label for="Name" class=" control-label col-md-4 text-md-right"> Tagline <span class="asterix"> * </span></label>
	<div class="col-md-6">
		{!! Form::text('tagline', $row['tagline'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
	</div> 
	<div class=""></div>
</div> --}}
<div class="form-group row " >
	<div class="col-md-6">	
	</div> 
	<div class=""></div>
</div> 			
<div class="form-group">

	<div class=""></div>
</div> 
<div class="form-group  " style="display: none;">
	<label for="Offer" class=" control-label col-md-4 text-md-right"> Offer ( in % ) </label>
	<div class="col-md-6">
		{!! Form::text('offer', $row['offer'],array('class'=>'form-control allownumericwithoutdecimal', 'placeholder'=>'',   )) !!} 
	</div> 
	<div class=""></div>
</div> 

<div id="datepairExample" class="pt-3">
	<legend> Service </legend><br>

	{{--<div class="row">	
		<div class="col-md-4">
			<label for="unavail_dates" class="control-label col-md-12 text-md-right"> Closed dates <span class="asterix">  </span></label>
			<BR>
		</div>
		<div class="col-md-7">
			<input class="form-control  parsley-validated unavail_dates" autocomplete="off" type="text" name="choosedate" id="unavail_dates">
		</div> 
	</div>--}}
	<small style="color: red"><b>Note : </b>If you set 12:00 am to 12:00 am service period for your shop then it will consider as 24 hours available</small>
	@if(isset($days) && !empty($days))
	@foreach($days as $key => $day)
	<?php $defaultTime = '12:00am-11:30pm';  ?>
	<?php $dayStatus = isset($resTimings[$key]) ? $resTimings[$key]->day_status:'' ;  
	$start_time2 = isset($resTimings[$key]) ? $resTimings[$key]->start_time2:'' ; 
	$end_time2 =  isset($resTimings[$key]) ? $resTimings[$key]->end_time2:'' ;
	?> 
	<div class="error_{{$day->id}}"></div>
	<div class="form-group d-flex flex-wrap">

		<label class="control-label col-lg-4 col-md-6 col-sm-12 col-xs-12" style="text-align:left;">
			
		<input type="checkbox" name="day_{{$day->id}}" id="day_{{$day->id}}" class="day_status" value="1" @if(isset($resTimings) && !empty($resTimings) && ($dayStatus == 1 && $resTimings[$key]->start_time1 != '')) checked @endif>&emsp;{!! $day->day !!}

		</label>
		<div class="col-xl-8 col-lg-12 col-md-6 col-sm-12 col-xs-12 d-flex flex-wrap">
			<span class="restime_box">
                <input type="text" value="@if(isset($resTimings) && !empty($resTimings) && $dayStatus == 1){!! $resTimings[$key]->start_time1 !!}-{!! $resTimings[$key]->end_time1 !!}@elseif(isset($resTimings) && $dayStatus != 1)@endif" name="resTime_{{$day->id}}_1" id="resTime_{{$day->id}}_1" class="restime resTime1 @if(isset($resTimings) && !empty($resTimings) && $dayStatus) day_avail @endif" onkeydown="return false;" autocomplete="off">&emsp;
				<i class="fa fa-plus add_second_time" id="addsecond_time_{{$day->id}}_2" @if(isset($resTimings) && ($start_time2) == '' || $end_time2 == '') style="display:inline-block;" @else style="display:none;" @endif></i>
			</span>
			<span class="restime_box" id="restime_box_{{$day->id}}_2" @if(isset($resTimings) && ($start_time2 == '' || $end_time2 == '')) style="display: none;" @endif>
				<input type="text" value="@if(isset($resTimings) && !empty($resTimings) && $dayStatus == 1){!! $start_time2 !!}-{!! $end_time2 !!}@endif" name="resTime_{{$day->id}}_2" id="resTime_{{$day->id}}_2" class="restime resTime2  @if(isset($resTimings) && !empty($resTimings) && $dayStatus == '1') @endif" onkeydown="return false;" autocomplete="off">
				<i class="fa fa-minus remove_second_time" id="removesecond_time_{{$day->id}}_2" @if(isset($resTimings) && ( isset($start_time2) == '' || $end_time2 == '')) style="display: none;" @endif ></i>
			</span>
		</div>
	</div>
	@endforeach
	@endif
	<div class="restaurants_timing"  id="restaurants_timing_" style="display:none;">
		<div class="restaurants_timing_box d-flex">	
			<select id="starttime" name="res_time[]" class="form-field startTimeChange">
				<option value="">{!!trans('core.abs_start_time')!!}</option>
			</select>
			<select id="endtime" name="res_time[]" name=" " class="form-field endTimeChange">
				<option value="">{!!trans('core.abs_end_time')!!}</option>
			</select>
		</div>	
	</div>
<script type="text/javascript" src="{{asset('sximo5/js/jquery.cropit.js') }}"></script>
<script type='text/javascript' src="{{asset('sximo5/js/plugins/jquery/jquery-ui.min.js')}}"></script>
<script type='text/javascript' src="{{asset('sximo5/js/jquery-ui.multidatespicker.js')}}">
</script>
<script src="{{ asset('sximo5/js/plugins/fullcalender/lib/moment.min.js') }}"></script>
<script type="text/javascript">
	$(function() {	
		$('.image-editor').cropit();
	});
	function get_image(){
		$('#img_valid').hide();
		var imageData = $('.image-editor').cropit('export');
		if(imageData != null){
			document.getElementById("imageid").src=imageData;
			$("#user_image").val(imageData);
			document.getElementById('chang_name').innerHTML="Change Image";
			$("#image").modal('hide');
		} else {
			$("#empty_image_note").html('<font color="red">Please choose photo</font>');
			setTimeout(function(){
				$('#empty_image_note').html('');
			}, 2000);
		}
	}
</script>
<script type="text/javascript">
	<?php if(Request::segment(3)!=''){?>
		$(document).ready(function(){
			function toDataURL(url, callback) {
				var xhr = new XMLHttpRequest();
				xhr.onload = function() {
					var reader = new FileReader();
					reader.onloadend = function() {
						callback(reader.result);
					}
					reader.readAsDataURL(xhr.response);
				};
				xhr.open('GET', url);
				xhr.responseType = 'blob';
				xhr.send();
			}

			toDataURL('<?php echo isset($row->logo[0]); ?>', function(dataUrl) {
				document.getElementById(".imageid").src = dataUrl;

				$("#user_image").val(dataUrl);
				$(".cropit-image-preview").css('background-image','url("'+dataUrl+'")');
			})

		})
	<?php }else{ ?>						
		$('#res_sub').on('submit',function(e){							
			if($('#user_image').val() == ''){
				e.preventDefault();
				$('#img_valid').show();
				$("#img_valid").attr("tabindex",-1).focus();
				$("#img_valid").removeAttr("tabindex");
			}else{
				$('#img_valid').hide();
			}
		});
	<?php } ?>
	$(".allownumericwithoutdecimal").on("keypress keyup blur",function (event) {    
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if(event.which == 8){

		} else if((event.which < 48 || event.which > 57 )) {
			event.preventDefault();
		}
	});	
	$(".allownumericwithoutdecimalandzero").on("keypress keyup blur",function (event) {  
		$(this).val($(this).val().replace(/[^\d].+/, ""));
		if(event.which == 8){

		} else if(event.which < 48 || event.which > 57 ) {
			event.preventDefault();
		}
	});	
</script>
<script type="text/javascript">
	$('input[name="gst_applicable"]').on('ifClicked', function (event) {
		if(this.value == 'yes'){
			$('.form-groupgst').addClass('parsley-validated').attr('required','true');
			$('.tax_div').show();
		} else {
			$('.form-groupgst').removeAttr('required');
			$('.tax_div').hide();
		}
		$('#res_sub').parsley();
	});
</script>
<script type="text/javascript">
	$(document).on('click',".restime",function(){

		var idVal = $(this).attr('id');
var timeVal =  $(this).val();//empty
var split = idVal.toString().split('_');
var dayId = split[1];
var timeId = split[2]; // first time input or secont input
if(!$('#day_'+dayId).is(":checked")) {

	$(".error_"+dayId).html('<font color="red">Before choose time, Please check the checkbox</font');
	setTimeout(function(){ $('.error_'+dayId).html(''); }, 3000);
	$("#resTime_"+dayId+"_"+timeId).val('');
} else {
	var newStartId = 'starttime_'+dayId+'_'+timeId;
	var newEndId = 'endtime_'+dayId+'_'+timeId;

	$(".startTimeChange").attr('id',newStartId);
	$(".endTimeChange").attr('id',newEndId);
	$(".endTimeChange").html('<option value="">End Time</option');

	if(timeVal != ''){
		$.ajax({
			url :"restaurant/loadtime",
			type : "POST",
			data : {
				timeVal : timeVal
			},
			dataType : "json",
			success : function(result){
				if(result.msg == 'success'){
					$("#starttime_"+dayId+"_"+timeId).html(result.startTime);
					$("#endtime_"+dayId+"_"+timeId).html(result.endTime);
				}

			}
		})
	} else if(timeId == '1'){
var starttime = '';// to appent the startime
timeAppend(starttime,'start',dayId,timeId);
} else if(timeId == '2'){
	var starttime = $("#resTime_"+dayId+"_1").val();
	if(starttime != ''){
timeAppend(starttime,'secondstart',dayId,timeId);//for start select option
} else {

}
} else {

}

$('.restaurants_timing').attr('id','restaurants_timing_'+dayId+'_'+timeId);
$('.restaurants_timing').show();
$(this).closest(".restime_box").append($(".restaurants_timing"));
}

})
	$(document).on('change',".startTimeChange",function(){	
		var starttime = $(this).find('option:selected').val();
		var startText = $(this).find('option:selected').text();
		var idVal = $(this).attr('id');
		var split = idVal.toString().split('_');
		var dayId = split[1];
		var timeId = split[2];
timeAppend(starttime,'end',dayId,timeId,startText);//for end select option
if(timeId == 1) {
	$("#resTime_"+dayId+"_2").val('');
}
})
	$(document).on('change',".endTimeChange",function(){
		var endtime = $(this).find('option:selected').val();
		var idVal = $(this).attr('id');
		var split = idVal.toString().split('_');
		var dayId = split[1];
		var timeId = split[2];
		var starttime = $("#starttime_"+dayId+"_"+timeId).find('option:selected').val();
		$.ajax({
			url :"restaurant/filltime",
			type: "POST",
			data : { starttime : starttime, endtime : endtime},
			dataType : "json",
			success : function(result) {
				$("#resTime_"+dayId+"_"+timeId).val(result.text);
				if(timeId == 1){
					$("#resTime_"+dayId+"_2").val('');
				}
			}
		})

		$('.restaurants_timing').hide();
	})
	function timeAppend(time,type='start',dayId,timeId,startText=''){
		var timeType = type;
		var stText = startText;
		$.ajax({
			url : "restaurant/endtime",
			type : "POST",
			data : {
				value 	: time,
				type 	: type,
				dayId 	: dayId,
				timeId 	: timeId,
			},
			dataType : "json",
			success : function(result){
				var html = result.html;
				if(timeType == 'end') {
					var endText = result.endText;
					var time = stText+"-"+endText;
					$("#resTime_"+dayId+"_"+timeId).val(time);
					$("#endtime_"+dayId+"_"+timeId).html(html);
					if(timeId == 1) {
						$("#resTime_"+dayId+"_2").val('');
					}
				} else if(timeType == 'start'){
					$("#starttime_"+dayId+"_1").html(html);
				} else if(timeType == 'secondstart'){
					$("#starttime_"+dayId+"_2").html(html);
				}
			}
		})
	}
	$('.day_status').on('ifChanged', function(event){ 
		var idVal =$(this).attr('id');
		var split = idVal.toString().split('_');
		var dayId = split[1];
//alert("resTime_"+dayId+"_1");
$("#resTime_"+dayId+"_1").toggleClass('day_avail');
//$("#resTime_"+dayId+"_2").toggleClass('day_avail');
if(this.checked) {               

}else{
	$("#resTime_"+dayId+"_1").val('');
	$("#resTime_"+dayId+"_2").val('');
}
});
	$(function() {
		var $form = $('#res_sub');
		$form.submit(function(event) {
			var check = 1; var locCheck = 1;
			$form.attr('disabled','disabled');
			var value;
			$( ".day_avail" ).each(function( index ) {
				value = $(this).val();
				if(value == ''){
					$(this).val('');$(".error_1").html('<font color="red">Before choose time, Please check the checkbox</font');
					$('.error_1')[0].scrollIntoView(true);
					setTimeout(function(){ $('.error_1').html(''); }, 5000);
					return false;
					check = 0;
				}
			});
			$( ".validate" ).each(function( index ) {
				value = $(this).val();
				if(value == ''){
					locCheck = 0;
				}
			});

			if(check == '0'){
				$(".error_1").html('<font color="red">Before choose time, Please check the checkbox</font');
				$('.error_1')[0].scrollIntoView(true);
				setTimeout(function(){ $('.error_1').html(''); }, 5000);
				return false;
			}else if(locCheck == '0'){
				$(".loc_error").html('<font color="red">Enter Valid Address</font>');
				$('.res_name_div')[0].scrollIntoView(true);
				setTimeout(function(){ $('.loc_error').html(''); }, 5000);
				return false;
			} else if(del_check == 0){
				setTimeout(function(){ $('#delivery_msg').html(''); }, 5000);
				$('.del_charge_err_div')[0].scrollIntoView(true);
				return false;
			} else {
//$form.submit();
}
});
	});
	$('body').click(function(event){ 
		$('.restaurants_timing').hide(); 
	});
	$('.restaurants_timing').click(function(event){
		event.stopPropagation();
	});
	$(".restime").on("focusin focusout keypress keyup blur",function (event) { 
		var idVal = $(this).attr('id');
		var split = idVal.toString().split('_');
		var dayId = split[1];
		var timeId = split[2]; 
		if(!$('#day_'+dayId).is(":checked")) {
			$("#resTime_"+dayId+"_"+timeId).val('');
		}
	});	 
	$(document).on('click','.add_second_time',function(){
		var idVal = $(this).attr('id');
		var split = idVal.toString().split('_');
		var dayId = split[2];
		var timeId = split[3];
		var firstTime = $("#resTime_"+dayId+"_1").val();
		if(!$('#day_'+dayId).is(":checked") || firstTime == undefined) {
			if(!$('#day_'+dayId).is(":checked") && firstTime == undefined) {
				$(".error_"+dayId).html('<font color="red">Before Enter Second time, Please check the Day checkbox and choose First time</font');
			} else if(!$('#day_'+dayId).is(":checked")){
				$(".error_"+dayId).html('<font color="red">Before Enter Second time, Please check the Day checkbox</font');
			} else {
				$(".error_"+dayId).html('<font color="red">Before Enter Second time, Please choose the First Time</font');
			}
			setTimeout(function(){ $('.error_'+dayId).html(''); }, 3000);
		} else {
			$("#removesecond_time_"+dayId+"_2").show();
			$("#restime_box_"+dayId+"_2").show();
			$(this).hide();
		}

	})
	$(document).on('click','.remove_second_time',function(){
		var idVal = $(this).attr('id');
		var split = idVal.toString().split('_');
		var dayId = split[2];
		var timeId = split[3];
		$("#resTime_"+dayId+"_2").val('');
		$("#restime_box_"+dayId+"_2").hide();
		$(this).hide();
		$("#addsecond_time_"+dayId+"_2").show();
	}) 
</script>
<script type="text/javascript">
	$(document).on('click',"#up_image",function(){
		$('#image').modal('show');
	});
	$('.day_status').on('ifChanged', function(event){ 
		var idVal =$(this).attr('id');
		var split = idVal.toString().split('_');
		var dayId = split[1];
		$("#resTime_"+dayId+"_1").toggleClass('day_avail');
		if(this.checked) {               
		}else{
			$("#resTime_"+dayId+"_1").val('');
			$("#resTime_"+dayId+"_2").val('');
		}
	});
	$('body').click(function(event){ 
		$('.restaurants_timing').hide(); 
	});
	$('.restaurants_timing').click(function(event){
		event.stopPropagation();
	});
</script>
</div>					
</fieldset>
</div>
</div>
<input type="hidden" class="validate" name="latitude" id="lat" value="{{$row['latitude']}}">
<input type="hidden" class="validate" name="longitude" id="lang" value="{{$row['longitude']}}">
<input type="hidden" name="flatno" id="flatno" value="{!! $row['flatno'] !!}">
<input type="hidden" name="adrs_line1" id="adrs_line1" value="{!! $row['adrs_line_1'] !!}">
<input type="hidden" name="adrs_line2" id="adrs_line2" value="{!! $row['adrs_line_2'] !!}">
<input type="hidden" name="sub_loc_level" id="sub_loc_level" value="{!! $row['sub_loc_level_1'] !!}">
<input type="hidden" name="city" id="city" value="{!! $row['city'] !!}">
<input type="hidden" name="state" id="state" value="{!! $row['state'] !!}">
<input type="hidden" name="country" id="country" value="{!! $row['country'] !!}">
<input type="hidden" name="zipcode" id="zipcode" value="{!! $row['zipcode'] !!}">
<div style="clear:both"></div>	
<!-- <input type="text" name="placeSelect" id="placeSelect"> -->
<!-- <div class="form-group row " > 
	<label for="Image" class=" control-label col-md-2 text-md-right"> {!! trans('core.abs_image_main') !!} <span class="asterix"> * </span></label>
	<div class="col-md-10">
		<input  type='file' name='image[]' id='image' multiple="" @if(!empty($row['banner'])) class='required' @endif style='width:150px !important;' accept="image/png, image/jpeg, image/jpg"/>
		<div>
			@if(!empty($row['banner']) && count($row['banner'])>0)
			@foreach($row['banner'] as $img)
			{{-- <img src="{{ $img }}" border="0" width="100" class="img-circle"> --}}
			{!! SiteHelpers::showUrlFileFood($img,'100','-') !!}
			@endforeach
			@endif
		</div>
	</div> 
</div> -->
<div class="form-group">
	<label class="col-sm-4 text-right">&nbsp;</label>
	<div class="col-sm-12 text-center">	
		<button type="submit" name="apply" class="btn btn-green btn-sm res_submit" ><i class="fa  fa-check-circle"></i> {!! Lang::get('core.sb_apply') !!}</button>
		<input type="submit" name="submit" class="btn btn-black btn-sm res_submit" value="{!! Lang::get('core.sb_save') !!}" ><!-- <i class="fa  fa-save "></i> -->
		<a href="{{URL::to('restaurant')}}"><button type="button" class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i> {!! Lang::get('core.sb_cancel') !!} </button></a>
	</div>
</div>
<input type="hidden" name="action_task" value="save" />
{!! Form::close() !!}
<div id="map_modal" class="modal fade" role="dialog" >
	<div class="modal-dialog">
		<style>#myMap {max-width:100%;height: 350px;width: 520px;z-index:999999;}</style>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Map</h4>
			</div>
			<div class="modal-body">
				<div id="myMap"></div><br/>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() { 

		$("#partner_id").jCombo("{!! url('restaurant/comboselect?filter=tb_users:id:username&limit=where:p_active:=:1') !!}",
			{  selected_value : '{{ $row["partner_id"] }}' });

		$("#cuisine").jCombo("{!! url('restaurant/comboselect?filter=abserve_food_cuisines:id:name') !!}",
			{  selected_value : '{{ $row["cuisine"] }}' });
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("restaurant/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		

	});
</script>     
@if($closedate != '') 	
<script type="text/javascript">
	$(document).ready(function(){
		var closedates='<?php echo $closedate_json ?>';
		var close_date= jQuery.parseJSON(closedates);
		$('#unavail_dates').multiDatesPicker({
			dateFormat: "yy-mm-dd",
			minDate: new Date(),
			addDates: close_date,
			onSelect : function(date){
				var indate = $("#unavail_dates").val();
				if(indate == ''){
				} else {
					$("#empty_date_error").hide();
				}
			}
		});
	})
</script>
@else
<script type="text/javascript">
	$(document).ready(function(){
		$('#unavail_dates').multiDatesPicker({
			dateFormat: "yy-mm-dd",
			minDate: new Date(),
			onSelect : function(date){
				var indate = $("#unavail_dates").val();
				if(indate == ''){
				} else {
					$("#empty_date_error").hide();
				}
			}
		});
	})
</script>
<?php 
$keys = \AbserveHelpers::site_setting('googlemap_key');
?>
<script src="https://maps.google.com/maps/api/js?libraries=places&region=uk&language=en&sensor=true&key={{$keys->googlemap_key}}"></script>
<script type="text/javascript">
	var IsplaceChange = true;
	$(document).ready(function () {

		if($('#lat').val() != '' || $('#lang').val() != '' ){
			$('#fn_map').show();
		} else {
			$('#fn_map').hide();
		}
		var input = document.getElementById('txtPlaces');
		var autocomplete = new google.maps.places.Autocomplete(document.getElementById('txtPlaces'));
		google.maps.event.addListener(autocomplete, 'place_changed', function () {
			var place		= autocomplete.getPlace();
			var latitude	= place.geometry.location.lat();
			var longitude	= place.geometry.location.lng();
			var components = place.address_components;
			$("#flatno").val('');
			$("#adrs_line1").val('');
			$("#adrs_line2").val('');
			$("#sub_loc_level").val('');
			$("#city").val('');
			$("#state").val('');
			$("#country").val('');
			$("#zipcode").val('');
			for(var i = 0,component; component = components[i]; i++) {
				if(component.types[0] == 'street_number'){
					$("#flatno").val(component['long_name']);
				}
				if(component.types[0] == 'route'){
					$("#adrs_line1").val(component['long_name']);
				}
				if(component.types[0] == 'neighborhood'){
					$("#adrs_line2").val(component['long_name']);
				}
				if(component.types[0] == 'sublocality_level_1'){
					$("#sub_loc_level").val(component['long_name']);
				}
				if(component.types[0] == 'locality'){
					$("#city").val(component['long_name']);
				}
				if(component.types[0] == 'administrative_area_level_1'){
					$("#state").val(component['long_name']);
				}
				if(component.types[0] == 'country'){
					$("#country").val(component['long_name']);
				}
				if(component.types[0] == 'postal_code'){
					$("#zipcode").val(component['long_name']);
				}
			}
			$('#lat').val(latitude);
			$('#lang').val(longitude);
			IsplaceChange	= true;
			if($('#lat').val() != '' || $('#lang').val() != '' ){
				$('#fn_map').show();
			} else {
				$('#fn_map').hide();
			}
		});

		$("#txtPlaces").keydown(function () {
			IsplaceChange	= false;
		});
		$("#txtPlaces").focusout(function () {	    
			if (IsplaceChange) {
				$('#fn_map').show();
			} else {
				$('#lat').val('');
				$('#lang').val('');
				$('#fn_map').hide();
			}

		});
		$("#cuisine").jCombo("{{ URL::to('restaurant/comboselect?filter=abserve_food_cuisines:id:name') }}",
			{  selected_value : '{{ $row["cuisine"] }}' });
		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
	});
</script>
<script type="text/javascript">
	$("#ordering").keypress(function (e) {
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			$("#errmsg").html("Digits Only").show().fadeOut("slow");
			return false;
		}
	});
	$(function() {
		$('.image-editor').cropit();
	});

	$(".fn_map_modal").click(function(){
		initialize();
		$("#map_modal").modal("show");
	});

	var map;
	var marker;
	var myLatlng = new google.maps.LatLng($('#lat').val(),$('#lang').val());
	var geocoder = new google.maps.Geocoder();
	var infowindow = new google.maps.InfoWindow();
	function initialize(){

		var mapOptions = {
			zoom: 15,
			center: new google.maps.LatLng($('#lat').val(),$('#lang').val()),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById("myMap"), mapOptions);

		marker = new google.maps.Marker({
			map: map,
			position: new google.maps.LatLng($('#lat').val(),$('#lang').val()),
			draggable: true 
		});     

		geocoder.geocode({'latLng': myLatlng }, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				if (results[0]) {
					$('#lat').val(marker.getPosition().lat());
					$('#lang').val(marker.getPosition().lng());
					var components = results[0].address_components;
					$("#flatno").val('');
					$("#adrs_line1").val('');
					$("#adrs_line2").val('');
					$("#sub_loc_level").val('');
					$("#city").val('');
					$("#state").val('');
					$("#country").val('');
					$("#zipcode").val('');
					for(var i = 0,component; component = components[i]; i++) {
						if(component.types[0] == 'street_number'){
							$("#flatno").val(component['long_name']);
						}
						if(component.types[0] == 'route'){
							$("#adrs_line1").val(component['long_name']);
						}
						if(component.types[0] == 'neighborhood'){
							$("#adrs_line2").val(component['long_name']);
						}
						if(component.types[0] == 'sublocality_level_1'){
							$("#sub_loc_level").val(component['long_name']);
						}
						if(component.types[0] == 'locality'){
							$("#city").val(component['long_name']);
						}
						if(component.types[0] == 'administrative_area_level_1'){
							$("#state").val(component['long_name']);
						}
						if(component.types[0] == 'country'){
							$("#country").val(component['long_name']);
						}
						if(component.types[0] == 'postal_code'){
							$("#zipcode").val(component['long_name']);
						}
					}
				}
			}
		});


		google.maps.event.addListener(marker, 'dragend', function() {

			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						$('#txtPlaces').val(results[0].formatted_address);
						$('#lat').val(marker.getPosition().lat());
						$('#lang').val(marker.getPosition().lng());
						var components = results[0].address_components;
						$("#flatno").val('');
						$("#adrs_line1").val('');
						$("#adrs_line2").val('');
						$("#sub_loc_level").val('');
						$("#city").val('');
						$("#state").val('');
						$("#country").val('');
						$("#zipcode").val('');
						for(var i = 0,component; component = components[i]; i++) {
							if(component.types[0] == 'street_number'){
								$("#flatno").val(component['long_name']);
							}
							if(component.types[0] == 'route'){
								$("#adrs_line1").val(component['long_name']);
							}
							if(component.types[0] == 'neighborhood'){
								$("#adrs_line2").val(component['long_name']);
							}
							if(component.types[0] == 'sublocality_level_1'){
								$("#sub_loc_level").val(component['long_name']);
							}
							if(component.types[0] == 'locality'){
								$("#city").val(component['long_name']);
							}
							if(component.types[0] == 'administrative_area_level_1'){
								$("#state").val(component['long_name']);
							}
							if(component.types[0] == 'country'){
								$("#country").val(component['long_name']);
							}
							if(component.types[0] == 'postal_code'){
								$("#zipcode").val(component['long_name']);
							}
						}
					}
				}
			});
		});
		google.maps.event.addListener(map, 'click', function (event) {
			$('#mlatitude').val(event.latLng.lat());
			$('#mlongitude').val(event.latLng.lng());
			placeMarker(event.latLng);
			geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (results[0]) {
						$('#txtPlaces').val(results[0].formatted_address);
						$('#lat').val(marker.getPosition().lat());
						$('#lang').val(marker.getPosition().lng());
						var components = results[0].address_components;
						$("#flatno").val('');
						$("#adrs_line1").val('');
						$("#adrs_line2").val('');
						$("#sub_loc_level").val('');
						$("#city").val('');
						$("#state").val('');
						$("#country").val('');
						$("#zipcode").val('');
						for(var i = 0,component; component = components[i]; i++) {
							if(component.types[0] == 'street_number'){
								$("#flatno").val(component['long_name']);
							}
							if(component.types[0] == 'route'){
								$("#adrs_line1").val(component['long_name']);
							}
							if(component.types[0] == 'neighborhood'){
								$("#adrs_line2").val(component['long_name']);
							}
							if(component.types[0] == 'sublocality_level_1'){
								$("#sub_loc_level").val(component['long_name']);
							}
							if(component.types[0] == 'locality'){
								$("#city").val(component['long_name']);
							}
							if(component.types[0] == 'administrative_area_level_1'){
								$("#state").val(component['long_name']);
							}
							if(component.types[0] == 'country'){
								$("#country").val(component['long_name']);
							}
							if(component.types[0] == 'postal_code'){
								$("#zipcode").val(component['long_name']);
							}
						}
					}
				}
			});
		});

	}
	google.maps.event.addDomListener(window, "resize", resizingMap());

	$('#map_modal').on('show.bs.modal', function() {
		resizeMap();
	})

	function resizeMap() {
		if(typeof map =="undefined") return;
		setTimeout( function(){resizingMap();} , 400);
	}

	function resizingMap() {
		if(typeof map =="undefined") return;
		var center = new google.maps.LatLng($('#lat').val(),$('#lang').val());
		google.maps.event.trigger(map, "resize");
		map.setCenter(center); 
	}
	google.maps.event.addDomListener(window, 'load', initialize);
	function placeMarker(location) {
		if (marker == undefined){
			marker = new google.maps.Marker({
				position: location,
				map: map, 
				animation: google.maps.Animation.DROP,
			});
		} else {
			marker.setPosition(location);
		}
		map.setCenter(location);
	}
</script>
<script type="text/javascript">
	$(function(){
		$('input[type="checkbox"],input[type="radio"]').iCheck({
			checkboxClass: 'icheckbox_flat-blue',
			radioClass: 'iradio_flat-blue',
		});	

	})
</script>

<script>
	$(document).ready(function() {

		$('.day_status').on('ifChanged', function(event){ 
			var idVal =$(this).attr('id');
			var split = idVal.toString().split('_');
			var dayId = split[1];

			if($('#day_'+dayId).is(":checked")) {

				$('#resTime_'+dayId+'_1').attr('required','required');
			}
			else{
				$('#resTime_'+dayId+'_1').attr('required',false);
			}

		});

	});
</script>
@endif
@stop