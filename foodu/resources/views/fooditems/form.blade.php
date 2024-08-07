@extends('layouts.app')
@section('content')
<link href="{{ asset('sximo5/css/pickatime/components.css') }}" rel="stylesheet">
<?php $sitedetails = \AbserveHelpers::site_setting();?>
<input type="hidden" name="min_val" id="delicharge" value="<?php if(!empty($sitedetails)){ echo $sitedetails->minimum_delivery_charge; } ?>">
<div class="page-header"> 
	<div class="page-title">
		<h3> {{ 'Product details' }}</h3>
	</div>
	<ul class="breadcrumb bg-trans mx-sm-0 mx-0 my-sm-0 my-1 p-0">
		<li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}">{!! Lang::get('core.m_dashboard') !!}</a></li>
		<li class="breadcrumb-item"><a href="{{ URL::to('fooditems/resdatas/'.$row['restaurant_id']) }}">{!! 'Product list' !!}</a></li>
		<li class="breadcrumb-item active">{!! Lang::get('core.addedit') !!} </li>
	</ul>
</div>
<div class="">
	<div class="page-content-wrapper head-table p-3">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
		<div class="sbox animated fadeInRight">
			<div class="sbox-title">
				<h5> <i class="fa fa-table"></i> </h5>
			</div>
			<div class="sbox-content fieldset_border"> 	
				{!! Form::open(array('url'=>'fooditems/store?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true , 'parsley-validate'=>'','id'=>'FormTable')) !!}
				<input type="hidden" name="partner_edit" value="@if(\Auth::user()->group_id == 3){!! 1 !!}@endif">
				<fieldset>
					<div class="d-flex flex-wrap">
						<div class="col-md-6">
							<fieldset> 
								<h6 class="mb-3 pb-2"> {!! trans('core.abs_food_item_details') !!} </h6>
								<div class="form-group hidethis " style="display:none;">
									<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
									<div class="col-md-8">
										{!! Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
									</div>
								</div>
								<div class="form-group row " > 
									<label for="Restaurant Id" class=" control-label col-md-4 text-md-right"> {!! trans('core.abs_restaurant_name') !!} <span class="asterix"> * </span></label>
									<div class="col-md-6">
										@if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)
										<input type="hidden" class="group_id" value="{{\Auth::user()->group_id}}">
										<select name='restaurant_id' rows='5' id='restaurant_id' class='select2' required  ></select> 
										@else
										<input type="hidden" class="group_id" value="{{\Auth::user()->group_id}}">
										<!--  <select name='restaurant_id' rows='5' id='restaurant_id' class='select2 ' required  > -->

											<input type="hidden" class="group_id" value="{{\Auth::user()->group_id}}">
											<select name='restaurant_id' rows='5' id='restaurant_id' class='select2' required  ></select> 
												<!-- </select> -->
												@endif
											</div>
										</div>
										<div class="form-group  row" > 
											<label for="Product Item" class=" control-label col-md-4 text-md-right"> {!! trans('core.abs_food_item') !!} <span class="asterix"> * </span></label>
											<div class="col-md-6">
												{!! Form::text('food_item', $row['food_item'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'maxlength'=>"32")) !!} 
											</div>
										</div>
										<div class="form-group row " >  
											<label for="Price" class=" control-label col-md-4 text-md-right"> Price<span class="asterix"> * </span></label>
											<div class="col-md-6">
												<input class="form-control price" placeholder="" required="true" name="price" type="text" value="{!! $row['price'] !!}">
											</div>
										</div>
										@if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 5 || \Auth::user()->group_id == 2 || \Auth::user()->group_id == 3)
										{{--<div class="form-group row">  
											<label for="Price" class=" control-label col-md-4 text-md-right"> Hiking Percent<span class="asterix"> * </span></label>
											<div class="col-md-6">
												<input class="form-control hike" placeholder="" required="true" parsley-type="number" name="hiking" type="text" value="{!! $row['hiking'] ?? 0 !!}">
											</div>
										</div> --}}
										<div class="form-group row">  
											<label for="Price" class=" control-label col-md-4 text-md-right"> Selling Price<span class="asterix"> * </span></label>
											<div class="col-md-6"> 
												<input class="form-control price selling_price" placeholder="" required="true" parsley-type="number" name="selling_price" type="text" value="{!! $row['selling_price'] !!}">
											</div>
										</div>
										<div class="form-group row">  
											<label for="StrikePrice" class=" control-label col-md-4 text-md-right"> Strike Price<span class="asterix"> * </span></label>
											<div class="col-md-6"> 
												<input class="form-control price strike_price" placeholder="" required="true" parsley-type="number" name="strike_price" type="text" value="{!! $row['strike_price'] !!}">
											</div>
										</div>
										@if(\Auth::user()->group_id != 3) 
										<div class="form-group row" > 
											<label for="Approved Status" class=" control-label col-md-4 text-md-right"> {!! trans('core.abs_approve_status') !!} <span class="asterix"> * </span>
											</label>
											<div class="col-md-6">
												<label class='radio radio-inline'>
													<input type='radio' name='approveStatus' value ='Waiting' required @if($row['approveStatus'] == 'Waiting') checked="checked" @endif > Waiting
												</label>
												<label class='radio radio-inline'>
													<input type='radio' name='approveStatus' value ='Approved' required @if($row['approveStatus'] == 'Approved') checked="checked" @endif > Approve
												</label> 
												<label class='radio radio-inline'>
													<input type='radio' name='approveStatus' value ='Rejected' required @if($row['approveStatus'] == 'Rejected') checked="checked" @endif > Reject
												</label> 
											</div>
										</div>
										@endif
										@endif
										<div class="form-group row" > 
											<label for="Approved Status" class=" control-label col-md-4 text-md-right"> Food Category 
											</label>
											<div class="col-md-6">
												<label class='radio radio-inline'>
													<input type='radio' name='is_veg' value ='1' @if($row['is_veg'] == '1') checked="checked" @endif > is-veg
													<input type='radio' name='is_veg' value ='0' @if($row['is_veg'] == '0') checked="checked" @endif > is-non-veg
												</label>
											</div>
										</div>
										{{--<div class="form-group row" > 
											<label for="food_unit" class=" control-label col-md-4 text-md-right">Unit Or Variation<span class="asterix"> * </span>
											</label>
											<div class="col-md-6">
												<label class='radio radio-inline'>
													<input type='radio' class="food_unit" name='adon_type' value ='-' required @if($row['unit'] == '-' || $row['unit'] == '' || empty($menuitem->unit_det) ) checked="checked" @endif > None
												</label>
												<label class='radio radio-inline'>
													<input type='radio' class="food_unit" name='adon_type' value ='unit' required @if(!empty($menuitem->unit_det)>0) checked="checked" @endif > Unit
												</label>
											</div>
										</div>--}}


									</fieldset>
								</div>
								<div class="col-md-6">
									<fieldset> 
										<h6 class="mb-3 pb-2">{!! trans('core.abs_other_details') !!} </h6> 
										<div class="form-group row " > 
											<label for="Main Category" class=" control-label col-md-4 text-md-right required"> {!! trans('core.abs_main_category') !!} <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<select name='main_cat' rows='5' id='main_cat' class='select2 ' required></select>
											</div>
										</div> 
										<!-- <div class="form-group row " > 
											<label for="Main Category" class=" control-label col-md-4 text-md-right"> {!! trans('core.abs_sub_category') !!} <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<select name='sub_cat' rows='5' id='sub_cat' class='select2 ' ></select>
											</div>
										</div> -->
										<div class="form-group row  " >  
											<label for="GST" class=" control-label col-md-4 text-md-right"> GST (%)<span class="asterix"> * </span></label>
											<div class="col-md-6"> 
												<input class="form-control" required placeholder="GST - Sale"  parsley-type="number" name="gst" type="text" value="{!! $row['gst'] !!}">
											</div>
										</div>
										<div class="form-group row"> 
											<label for="Item Status" class=" control-label col-md-4 text-md-right"> {!! trans('core.abs_item_status') !!} <span class="asterix"> * </span>
											</label>
											<div class="col-md-6"> 
												<label class='radio radio-inline'>
													<input type='radio' name='item_status' value ='1' required @if($row['item_status'] == '1') checked="checked" @endif > {!! trans('core.abs_in_stack') !!} 
												</label>
												<label class='radio radio-inline' style="margin-left:0px;">
													<input type='radio' name='item_status' value ='0' required @if($row['item_status'] == '0') checked="checked" @endif > {!! trans('core.out_of_stock') !!}  
												</label> 
											</div>
										</div>

										@if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 5 || \Auth::user()->group_id == 2 || \Auth::user()->group_id == 3)
										<input type="hidden" name="deletedImg" id="deletedImg" value="">
										<div class="form-group row " > 
											<label for="Image3" class=" control-label col-md-4 text-md-right"> {!! trans('core.abs_image_main') !!} <span class="asterix"> * </span></label>
											<input  type='file' name='image[]' id='image'  @if($row['image'] =='') class='required' required @endif style='width:150px !important;' accept="image/x-png,image/gif,image/jpeg" />
											<div >
												@if($row['image']!='' && count(explode(",", $row['image']))>0)
												@foreach(explode(",", $row['image']) as $img)
												{!! AbserveHelpers::showUploadedFileFood($img,'/storage/app/public/restaurant/'.$row['restaurant_id'].'/','100','-') !!}
												@endforeach
												@endif
											</div>
										</div>
										@endif
										{{--<div class="form-group row " > 
											<label for="Addons" class=" control-label col-md-4 text-md-right"> Addons <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<select name='addons[]' rows='5' id='addons' class='select2 '  multiple ></select>
											</div>
										</div>--}} 


										<div class="form-group row" > 
										<label for="Available From" class=" control-label col-md-4 text-left"> Available time  <span class="asterix"> * </span></label>
										<div class="col-md-3">
											<input type="text" id="startTime1" name="start_time1" class="timepicker"required @if($row['start_time1'] =='')value ="" @else value="{!! date('h:i a',strtotime($row['start_time1'])) !!}" @endif>
										</div>
										<div class="col-md-3">
											<input type="text" id="endTime1" name="end_time1" class="timepicker" required @if($row['end_time1'] =='')value ="" @else value="{!! date('h:i a',strtotime($row['end_time1'])) !!}" @endif>
											
											</div>
										</div>
										{{--<div class="form-group row" > 
											<label for="Available From" class=" control-label col-md-4 text-left"> Available time 2 </label>
											<div class="col-md-3">
											<input type="text" id="startTime2" name="start_time2" class="timepicker" @if($row['start_time2'] =='')value ="" @else value="{!! date('h:i a',strtotime($row['start_time2'])) !!}"@endif>
												
											</div>
											<div class="col-md-3">
											<input type="text" id="endTime2" name="end_time2" class="timepicker" @if($row['end_time2'] =='')value ="" @else value="{!! date('h:i a',strtotime($row['end_time2'])) !!}" @endif>
												
												</div>
											</div>--}}



									</fieldset> 
								</div>
							</div>
							<div class="form-group" id="unit_div" @if(empty($menuitem->unit_det)) style="display: none;" @endif >
								<legend><button class="btn-sm btn-success unit_add" type="button">Add Unit</button> </legend>
							

								<div class="col-md-12">
									<table class="table">		
										<thead>
											<tr>
												<th>Unit</th>
												<th>Price</th>
												<th></th>
											</tr>
										</thead>
										<tbody id="unit_div_body">
											@if(isset($menuitem->unit_det) && count($menuitem->unit_det) > 0)
											<?php $Aunit=[]; ?>
											@foreach($menuitem->unit_det as $kuf=>$valuf)
											<tr class="unitdiv{!!$kuf!!}">
												<td class="disabled_div unit_event{!!$kuf!!}">
													<input type="hidden" name="unit_id[]" value="{!!$valuf['id']!!}">
													<select class="form-control unit_class" name="unit[]" id="unit_get">
														<option value="">Select one</option>
														@if(count($unit)>0)
														@foreach($unit as $uky=>$uval)
														<option @if($valuf['id']==$uval->id) selected="selected" @endif value="{!!$uval->id!!}">{!!$uval->cat_name!!}</option>
														@endforeach
														@endif
													</select>
												</td>
												<td class="disabled_div unit_event{!!$kuf!!}">
													<input type="text" name="price_unit[]" class="form-control req_class" placeholder="Chef Price" value="{!!$valuf['price']!!}" style="width: 100px">
												</td>

												<td>
													<button type="button" class="btn btn-success btn-sm unit_edit" data-id="{!! $kuf+1 !!}">Edit</button>
													<button class="btn btn-sm btn-danger unit_remove" type="button">Remove</button>

												</td>

											</tr>
											@endforeach
											@else
											<tr class="unitdiv0">
												<td class="unit_event0s">
													<input type="hidden" name="unit_id[]" value="">
													<select name="unit[]" class="form-control unit_class" id="unit_get">
														<option selected value="">Select any one</option>
														@if(isset($unit) && count($unit)>0)
														@foreach($unit as $uky=>$uval)
														<option value="{!!$uval->id!!}">{!!$uval->cat_name!!}</option>
														@endforeach
														@endif
													</select>
												</td>
												<td>
													<input type="text" name="price_unit[]" class="form-control req_class" placeholder="Price" style="width: 100px">
												</td>
												<td>
													<button class="btn-sm btn-danger unit_remove" type="button">-</button>

												</td>

											</tr>
											@endif
										</tbody>
									</table>
								</div>
							</div> 
							<div class="form-group d-flex justify-content-center">
								<label class="col-sm-4 text-right">&nbsp;</label>
								<div class="col-sm-8">	
									<button type="submit" name="apply" class="btn btn-green btn-sm" value="apply"><i class="fa  fa-check-circle"></i> {!! Lang::get('core.sb_apply') !!}</button>
									<button type="submit" name="submit" class="btn btn-dark btn-sm" ><i class="fa  fa-save "></i> {!! Lang::get('core.sb_save') !!}</button>
									
									<button type="button" onclick="location.href='{{ URL::to('customer?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
								</div>	  
							</div>
						</fieldset>	

						<div style="clear:both"></div>
						{!! Form::close() !!}

					</div>
				</div>		 
			</div>	
		</div>			 
		<style type="text/css">
			.changePrice{
				color: #2230dc;
				font-weight: 600;
				cursor: pointer;
			}
			.changePriceInfo{
				color: #2230dc;    	
			}
			.changePriceMsg{
				padding: 10px;
				color: red;
				display: none;
			}
			.changedPriceMsg{
				padding: 10px;
				color: blue;    	
			}	
		</style>

		<style type="text/css">
			.disabled_div{ pointer-events   : none;opacity: 0.4; }
		</style>

	
		<script src="https://jonthornton.github.io/Datepair.js/dist/datepair.js"></script>
		<script src="https://jonthornton.github.io/Datepair.js/dist/jquery.datepair.js"></script>
		<script type="text/javascript" src="{{ asset('sximo5/js/front/picker.js') }}"></script>
		<script type="text/javascript" src="{{ asset('sximo5/js/front/picker.time.js') }}"></script>
			<script type="text/javascript">
			@if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)

			const unitString = '<td><input type="text" name="unit_hiking[]" class="form-control" placeholder="Hiking Percent" value="" style="width: 100px"></td> <td><input type="text" name="unit_sprice[]" class="sellPrice form-control" placeholder="Selling Price" style="width: 100px"></td>';
			const variString = '<td><input type="text" name="vari_hiking[]" class="form-control"placeholder="Hiking Percent" style="width: 100px"></td><td><input type="text" name="vari_sprice[]" class="sellPrice form-control" placeholder="Selling Price" style="width: 100px"></td>';
			@else
			const unitString = '';
			const variString = '';
			@endif
			$(document).on('ifChecked','.food_unit',function(){
				var fUnit=$(this).val();
				if(fUnit=='unit'){
					$("#unit_div").show();
					$("#variation_div").hide();
				}else if(fUnit=='variation'){
					$("#unit_div").hide();
					$("#variation_div").show();
				}else{
					$("#unit_div").hide();
					$("#variation_div").hide();
				}
			})
			// $(document).on('click','.unit_add',function(){
			// 	var unit_get=$("#unit_get").html();
			// 	$("#unit_div_body").append('<tr><td><input type="hidden" name="unit_id[]"><select class="form-control unit_class" name="unit[]" id="unit_get">'+unit_get+'</select></td><td><input type="text" name="price_unit[]" class="priceUV form-control req_class" placeholder="Price" style="width: 100px"></td><td><button class="btn-sm btn-danger unit_remove" type="button">-</button></td></tr>');
			// })
			$(document).on('click','.variation_add',function(){
				var color=$("#Fcolor_get").html();
				var unit=$("#Fvari_unit").html();
				$("#variation_div_body").append('<tr><td><input type="hidden" name="variation_id[]"><select class="form-control" name="Fcolor[]" >'+color+'</select></td><td><select class="form-control" name="vari_unit[]" >'+unit+'</select></td><td><input type="text" name="vari_price[]" class="priceUV form-control" placeholder="Price" style="width: 100px"></td>'+variString+'<td><button class="btn-sm btn-danger variation_remove" type="button">-</button></td></tr>');
			})
			$(document).on('click','.unit_remove',function(){
				$(this).closest('tr').remove();
			})
			$(document).on('click','.variation_remove',function(){
				$(this).closest('tr').remove();
			})
			$(document).on('click','.remove_Img',function(){
				var imageval = $(this).attr('data-img');
				var section = $(this).attr('data-val');
				if(section == 'variation'){
					var deletedImg = $(this).closest('tr').find('.variation_deleted_Image').val();
				} else {
					var deletedImg = $("#deletedImg").val();
				}
				var updateImage = '';
				if(deletedImg != ''){
					updateImage += ','+imageval;
				} else {
					updateImage = imageval;
				}
				if(section == 'variation'){
					$(this).closest('tr').find('.variation_deleted_Image').val(updateImage);
				} else {
					$("#deletedImg").val(updateImage);
				}
				$(this).closest('div').remove();
			})
			$('.changePrice').on('click',function(){
				if ($('.price').prop('readonly') == true) {
					$('.price').prop('readonly',false);
					$('.changePriceMsg').slideDown();
					$(this).html('Cancel');
				} else {
					$('.price').prop('readonly',true);
					$('.changePriceMsg').slideUp();
					$(this).html('Change Price');
				}				
			});

			// $(document).on('change',".startTimeChange",function(){	
			// 	var starttime = $(this).find('option:selected').attr('data-val');
			// 	var startText = $(this).find('option:selected').text();
			// 	var idVal = $(this).attr('id');
			// 	var split = idVal.toString().split('_');
			// 	var dayId = split[1];
			// 	var timeId = split[2];
			// 	timeAppend(starttime,'end',dayId,timeId,startText);
			// 	if(timeId == 1) {
			// 		$("#resTime_"+dayId+"_2").val('');
			// 	}
			// })
			// function timeAppend(time,type='start',dayId,timeId,startText=''){
			// 	var timeType = type;
			// 	var stText = startText;
			// 	$.ajax({
			// 		url : base_url+"restaurant/endtimefood",
			// 		type : "POST",
			// 		data : {
			// 			value 	: time,
			// 			type 	: type,
			// 			dayId 	: dayId,
			// 			timeId 	: timeId,
			// 		},
			// 		dataType : "json",
			// 		success : function(result){
			// 			var html = result.html;
			// 			$(".endTimeChange").select2("destroy");
			// 			$(".endTimeChange").html(html);
			// 			$(".endTimeChange").select2({width:"180px"});


			// 		}
			// 	})
			// }

			// $(document).on('change',".startTimeChange1",function(){	
			// 	var starttime = $(this).find('option:selected').attr('data-val');
			// 	var startText = $(this).find('option:selected').text();
			// 	var idVal = $(this).attr('id');
			// 	var split = idVal.toString().split('_');
			// 	var dayId = split[1];
			// 	var timeId = split[2];
			// 	timeAppend1(starttime,'end',dayId,timeId,startText);
			// 	if(timeId == 1) {
			// 		$("#resTime_"+dayId+"_2").val('');
			// 	}
			// })
			// function timeAppend1(time,type='start',dayId,timeId,startText=''){
			// 	var timeType = type;
			// 	var stText = startText;
			// 	$.ajax({
			// 		url : base_url+"restaurant/endtimefood",
			// 		type : "POST",
			// 		data : {
			// 			value 	: time,
			// 			type 	: type,
			// 			dayId 	: dayId,
			// 			timeId 	: timeId,
			// 		},
			// 		dataType : "json",
			// 		success : function(result){
			// 			var html = result.html;
			// 			$(".endTimeChange1").select2("destroy");
			// 			$(".endTimeChange1").html(html);
			// 			$(".endTimeChange1").select2({width:"180px"});


			// 		}
			// 	})
			// }

			// $(document).on('change',".endTimeChange",function(){	
			// 	var starttime = $(this).find('option:selected').attr('data-val');
			// 	var startText = $(this).find('option:selected').text();
			// 	var idVal = $(this).attr('id');
			// 	var split = idVal.toString().split('_');
			// 	var dayId = split[1];
			// 	var timeId = split[2];
			// 	timeAppend2(starttime,'secondstart',dayId,timeId,startText);
			// 	if(timeId == 1) {
			// 		$("#resTime_"+dayId+"_2").val('');
			// 	}
			// })
			// function timeAppend2(time,type='start',dayId,timeId,startText=''){
			// 	var timeType = type;
			// 	var stText = startText;
			// 	$.ajax({
			// 		url : base_url+"restaurant/endtimefood",
			// 		type : "POST",
			// 		data : {
			// 			value 	: time,
			// 			type 	: type,
			// 			dayId 	: dayId,
			// 			timeId 	: timeId,
			// 		},
			// 		dataType : "json",
			// 		success : function(result){
			// 			var html = result.html;
			// 			$(".startTimeChange1").select2("destroy");
			// 			$(".startTimeChange1").html(html);
			// 			$(".startTimeChange1").select2({width:"180px"});

			// 			$(".endTimeChange1").select2("destroy");
			// 			$(".endTimeChange1").html('<option value="" selected>End Time</option>');
			// 			$(".endTimeChange1").select2({width:"180px"});


			// 		}
			// 	})
			// }
			var base_url    = "<?php echo URL::to('/').'/'; ?>";
			$(document).ready(function() {
				$("input[name$='adon_type']").click(function() {
					$value=$(this).val();
					if($value=='unit'){
						$("#unit_div").show();
					}
					else{
						$("#unit_div").hide();
					}
				});
				var group_id = $('.group_id').val();

				if(group_id == 3){
					var user_id	= '{!! Auth::user()->id !!}';
					$("#restaurant_id").jCombo("{!! url('fooditems/comboselect?filter=abserve_restaurants:id:name:partner_id&limit=where:status:!=:3&limit=where:partner_id:=:"+user_id+"') !!}",
						{  selected_value : '{!! $row["restaurant_id"] !!}' });
				}  else {
					$("#restaurant_id").jCombo("{!! url('fooditems/comboselect?filter=abserve_restaurants:id:name&limit=where:status:!=:3') !!}",{
									"selected_value" : '{{ $row["restaurant_id"] }}',
								})
				}

				$('#restaurant_id').on('change', function() {
					var res_id	= this.value;
					if(res_id!='')
						bindAddons(res_id);
				});

				$("#main_cat").jCombo("{!! url('fooditems/comboselect?filter=abserve_food_categories:id:cat_name&limit=where:type:=:category') !!}",
					{  selected_value : '{!! $row["main_cat"] !!}' });
				$("#sub_cat").jCombo("{!! url('fooditems/comboselect?filter=abserve_food_categories:id:cat_name&limit=where:type:=:brand')!!}",
					{  selected_value : '{!! $row["sub_cat"] !!}' });
				$('.removeCurrentFiles').on('click',function(){
					var removeUrl = $(this).attr('href');
					$.get(removeUrl,function(response){});
					$(this).parent('div').empty();	
					return false;
				});
			});

			function bindAddons(res_id) {
				var addons = '{!! $row["addon"] !!}';
				addons = addons.split(',');
				$.ajax({
					url: base_url+'getpartner',
					type: 'get',
					data: { res_id : res_id },
					dataType:'json',
					success:function(res){
						var options = "";
						$("#addons").empty();
						$("#addons").append('<option>Select addons</option>');
						for (var i = 0; i < res.length; i++) {
							let select = jQuery.inArray(res[i].id.toString(), addons) !== -1 ? 'selected' : '';
							options += "<option "+select+" value='"+res[i].id+"'>" + res[i].name + "</option>";
						}
						$("#addons").append(options);

					}
				});
			}
		

			$("input[parsley-type='number']").on("keypress keyup blur",function (event) {    
				$(this).val($(this).val().replace(/[^\d].+/, ""));
				if(event.which == 8){

				} else if((event.which < 48 || event.which > 57 )) {
					event.preventDefault();
				}
			});
			$(".hike").on("keypress keyup blur",function (event) {    
				var val = $(this).val();
				if($(this).parent().get( 0 ).tagName == 'TD'){
					var price = $(this).parent().parent().find('.priceUV').val();
					var tax   =	parseFloat(price * ( val / 100 ));
					price  	  = parseFloat(tax) + parseFloat(price);
					$(this).parent().parent().find('.sellPrice').val(price);
				}else{
					var price = $('input[name="price"]').val();
					var tax   =	parseFloat(price * ( val / 100 ));
					price  	  = parseFloat(tax) + parseFloat(price);
					$('.selling_price').val(price);
				}
			});
			/*$(".strike_price").on('focusout',function(){
				var strikeprice  = $(this).val();
				var sellingprice = $('.selling_price').val();
				if (strikeprice > 80 || 80.00) {
					$(this).val(strikeprice);
				}
				else {
					$(this).val(0);
				}
			});*/

			$(document).on('focusout', '.strike_price', function() {
				var strikeprice = parseFloat($(this).val());
				var sellingprice = parseFloat($('.selling_price').val());
				
				if (strikeprice > 80) {
					$(this).val(strikeprice.toFixed(2)); // Ensure the value is formatted to two decimal places
				} else {
					$(this).val('0');
				}
			});

			$('#datepairExample .time').timepicker({
				'showDuration': true,
				'timeFormat': 'g:i:sa'
			});
			$('#datepairExample').datepair();

			$(document).on('click','.unit_add',function(){
				var cnt=$(".unit_class").length;
        //console.log(cnt);  
        var rcnt=$(".req_class").length;
        //console.log(rcnt); 
        var valid = false;
        if(rcnt == 0) {
        	valid = true;
        } else {		
        	valid = true;
        	$('.req_class').each(function(){
        		if ($(this).val() == '' || $(this).val() == null) {
        			valid = false;
        		}
        	});
        }
        if (valid) {
        	variants(cnt);
        }
    });

			function variants(cnt) {
				var option=$("#unit_get").html();
				$("#unit_div_body").append(`
					<tr class="unitdiv0">
					<td class="unit_event"><input type="hidden" name="unit_id[]">
					<select name="unit[]" class="form-control unit_class req_class" id="unit_class`+(cnt)+`">
					`+option+`
					</select>
					</td>
					<td class="col-md-3 unit_event`+(cnt)+`">
					<input type="text" name="price_unit[]" class="form-control req_class priceUV" id="unit_price" placeholder="Price" style="width: 100px">
					</td>
					<td class="col-md-1">
					<button type="button" class="btn-sm btn-danger unit_minus" id="unit_minus`+(cnt)+`" data-id="`+(cnt)+`">-</button>
					</td>
					</tr>`);
				$(".unit_class").each(function(){
					$("#unit_class"+(cnt)+' option[value="'+$(this).val()+'"]').attr('disabled', true);
				})
        //$("#unit_minus"+(cnt-1)).hide();
        //$("#unit_class"+(cnt)).select2();
        $(".unit_event"+(cnt-1)).addClass('disabled_div');
        if ($(".unitdiv"+(cnt-1)).find('.unit_edit').length == 0) {
        	$(".unitdiv"+(cnt-1)).append(`  <td class="col-md-1">
        		<button type="button" class="btn btn-success btn-xs unit_edit" data-id="`+(cnt)+`"><i class="fa fa-edit"></i></button>
        		</td>`);
        }
    }

    $(document).on('click','.unit_minus',function(e){
    	e.preventDefault();
    	var id=$(this).attr('data-id');
    	$("#unit_minus"+(id-1)).show();
        //$(".unit_event"+(id-1)).removeClass('disabled_div');
        $(this).closest('.unitdiv'+(id)).remove();
    });

    $(document).on('click','.unit_edit',function(e){
    	e.preventDefault();
    	var id=$(this).attr('data-id');
    	console.log(id);
    	$(".unit_event"+(id-1)).removeClass('disabled_div');
        // $(".unit_event"+(id-1)).attr('disabled',false);
    });



	var $st1 = $('#startTime1').pickatime();
	var startT1 = $st1.pickatime('picker');

	var $et1 = $('#endTime1').pickatime();
	var endT1 = $et1.pickatime('picker');

	var $st2 = $('#startTime2').pickatime();
	var startT2 = $st2.pickatime('picker');

	var $et2 = $('#endTime2').pickatime();
	var endT2 = $et2.pickatime('picker');
	var time = $st1.pickatime('picker').get('select');
	$(document).ready(function() {
		var a1 = time.mins;
		var b1 = time.hour;
		endT1.set('disable', [{ from: [0,0], to: [b1,a1] }] );
		startT2.set('disable', [{ from: [0,0], to: [b1,a1] }] );
		endT2.set('disable', [{ from: [0,0], to: [b1,a1] }] );
	});
	
	$('#startTime1').on('change',function(){
		var time = $st1.pickatime('picker').get('select');
		var a1 = time.mins;
		var b1 = time.hour;

		var endtime = $et1.pickatime('picker').get('select');
		var eth = endtime.hour;
		var etm = endtime.mins;

		$("#endTime1").val('');
		endT1.set('enable', true);
		endT1.set('disable', [{ from: [0,0], to: [b1,a1] }] );

		startT2.set('enable', true);
		startT2.set('disable', [{ from: [0,0], to: [eth,etm] }] );

		endT2.set('enable', true);
		endT2.set('disable', [{ from: [0,0], to: [b1,a1] }] );
	})
	$('#startTime2').on('change',function(){
		var time = $st2.pickatime('picker').get('select');
		var a2 = time.mins;
		var b2 = time.hour;

		$("#endTime2").val('');
		endT2.set('enable', true);
		endT2.set('disable', [{ from: [0,0], to: [b2,a2] }] );
	});
</script>	 
@stop

<style type="text/css">
	.cust{position:relative;z-index:2}
	.cust .iradio_square-green{position: relative;z-index:-1;}
</style> 