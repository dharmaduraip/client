@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

<div class="m-3 box-border">
	<div class="sbox-title"> 
		<h4> 
			<i class="fa fa-table text-light"></i> 
		</h4>
		<div class="sbox-tools">
			<a href="{{ URL::to('approval') }}" style="display: block ! important;font-size: 13px" class="btn btn-xs btn-white tips" title="Clear Search"  ><i class="fa fa-chevron-left mr-2" style="font-size: 13px"></i> {!! "Back" !!} 
			</a>
			
	    </div>
	</div>
<div class="row m-0">
	<div class="col-md-12 p-0">
		<fieldset><!--<legend> Restaurants</legend>-->
			<div class="row fieldset_border">	
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
					<fieldset>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> Shop Name <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{$row->name}} </label>
							</div> 
							<div class=""></div>
						</div> 	
						<div class="form-group row  " >
							<label for="Phone" class=" control-label col-md-4 text-md-right"> Phone :</label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->phone }} </label>
							</div>
							<div class=""></div>
						</div> 	

						<div class="form-group row" >
							<label for="Location" class=" control-label col-md-4 text-md-right"> Location of Shop<span class="asterix"> : </span></label>
							<div class="col-md-6">
								<label for="Location" class=" control-label"> {{ $row->location }}</label>
								
								<div id="fn_map" style="display: none;"><a href="javascript:" class="fn_map_modal">Click Here to view Exact location</a></div>
								<div class="loc_error"></div>
							</div> 
							<div class=""></div>
						</div> 	

						@if(\Auth::user()->group_id ==1 || \Auth::user()->group_id == 2)
						<div class="form-group  row" >
							<label for="Partner Id" class=" control-label col-md-4 text-md-right"> Owner Name <span class="asterix"> : </span></label>
							<div class="col-md-6">
								<label class=" control-label">{{ AbserveHelpers::getuname($row->partner_id)}}</label>
							</div> 
							<div class=""></div>
						</div> 
						@else
						<input type="hidden" id="partner_id" name="partner_id" value="{{ \Auth::user()->id }}" />
						@endif				
						<div class="form-group row " >
							<label for="Cuisine" class=" control-label col-md-4 text-md-right"> Shop Category <span class="asterix"> : </span></label>
							<div class="col-md-6">
								<label class=" control-label">
								<?php
								    $cuisineIds = explode(',', $row->cuisine);
								    $cuisineNames = [];
								    foreach ($cuisineIds as $id) {
								       $cuisine = AbserveHelpers::getCuisines(trim($id));
								        if ($cuisine->isNotEmpty()) {
								            $cuisineNames[] = $cuisine->first()->name;
								        }
								    }
								    echo implode(', ', $cuisineNames);
								?>
								</label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group  row" >
							<label for="res_desc" class=" control-label col-md-4 text-md-right"> Description :</label>
							<div class="col-md-6">
								<label class=""> {!! $row->res_desc !!} </label>
							</div> 
							<div class=""></div>
						</div> 
						@if(PICKDEL_OPTION=='enable')
						<?php $deliver_status = explode(',', $row['deliver_status']); ?>
						<div class="form-group  row" >
							<label for="Delivery Status" class=" control-label col-md-4 text-md-right"> Delivery status :</label>
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
						<!-- @if(PREORDER_OPTION=='enable')
						<div class="form-group d-flex flex-wrap" >
							<label for="Delivery Status" class=" control-label col-md-4 text-md-right"> Pre order status :</label>
							<div class="col-md-6 delivery_stat_div">
								<div class="col-xs-12 no-pad">
									<label class='delivery_stat'>
										<label for="Name" class=" control-label"> {{ $row->preoder=='yes' ? "Yes" : "No"  }} </label>
									</label>
								</div>
							</div>
							<div class=""></div>
						</div>
						@endif-->
						<div class="form-group d-flex flex-wrap" >
							<label for="Restaurant Category" class="control-label col-md-4 text-md-right">Restaurant Category:</label>
							<div class="col-md-6 delivery_stat_div">
								<div class="col-xs-12 no-pad">
									<label class='delivery_stat'>
										@if($row->restaurant_cat =='veg')
										<label for="Name" class=" control-label"> {{ 'Pure-veg '}} </label>
										@elseif($row->restaurant_cat =='non-veg')
										<label for="Name" class=" control-label"> {{ 'Non-veg' }} </label>
										@else
										<label for="Name" class=" control-label"> {{ 'Veg & Non-veg'  }} </label>
										@endif
									</label>
								</div>
							</div>
							<div class=""></div>
						</div>
						<div class="form-group d-flex flex-wrap" >
							<label for="Restaurant Category" class="control-label col-md-4 text-md-right">Fassai no:</label>
							<div class="col-md-6 delivery_stat_div">
								<div class="col-xs-12 no-pad">
									<label class=" control-label"> {{ $row->r_fassai_no }} </label>
								</div>
							</div>
							<div class=""></div>
						</div>
						<div class="form-group d-flex flex-wrap" >
							<label for="Restaurant Category" class="control-label col-md-4 text-md-right">Pan Card No:</label>
							<div class="col-md-6 delivery_stat_div">
								<div class="col-xs-12 no-pad">
									<label class=" control-label"> {{ $row->r_pan_no }} </label>
								</div>
							</div>
							<div class=""></div>
						</div>
						<div class="form-group d-flex flex-wrap" >
							<label for="Restaurant Category" class="control-label col-md-4 text-md-right">GST No:</label>
							<div class="col-md-6 delivery_stat_div">
								<div class="col-xs-12 no-pad">
										<label class=" control-label"> {{ $row->r_gst_no }} </label>
								</div>
							</div>
							<div class=""></div>
						</div>
						<!-- <div class="d-flex justify-content-center">
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
						</div> -->
						
					</fieldset>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
					<fieldset>
						<legend>Other Details</legend>
						<div class="form-group d-flex flex-wrap" >
							<label for="GST Applicable" class=" control-label col-md-4 text-right"> GST Applicable :</label>
							<div class="col-md-6">
								<label class=" control-label">
									{{ isset($row->gst_applicable) && $row->gst_applicable =='yes' ? 'Yes' : 'No'}}
								</label>
							</div>
						</div>
						<div class="form-groupgst tax_div " @if($row->gst_applicable == 'no') style="display:none;" @endif>
							<div class="form-group d-flex flex-wrap" >
								<label for="Service Tax" class=" control-label col-md-4 text-right"> Service Tax(%) :</label>
								<div class="col-md-6">
									<label class=" control-label">
									{{ $row->service_tax1}}
								    </label>
								</div> 
							</div>
						</div>
						<script type="text/javascript">
							$('.float_number').keypress(function(event) {
								if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
									event.preventDefault();
								}
							});
						</script>
						<div class="form-group row del_charge_err_div">
							<label for="Delivery Charge" class=" control-label col-md-4 text-md-right">Status :</label>
							<div class="col-md-6">
								<label class=" control-label">
									{{ $row->status == '1' ? 'Active' : 'Inactive'}}
								</label>
							</div> 
							<div class=""></div>
						</div> 	
						<div class="form-group row del_charge_err_div">
							<label for="Delivery Charge" class=" control-label col-md-4 text-md-right">Mode :</label>
							<div class="col-md-6">
								<label class=" control-label">
									{{ $row->mode == 'open' ? 'Open' : 'Close'}}
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
						<!-- <div class="form-group row " >
							<label for="commission"  class=" control-label col-md-4 text-md-right">Commission Charge :</label>

							<div class="col-md-6">
								<label class=" control-label">
									{{ $row->commission}}
								</label>
							</div> 
							<div class=""></div>
						</div> -->

						{{--<div class="form-group row " >
							<label for="Name" class=" control-label col-md-4 text-md-right"> Tagline <span class="asterix"> * </span></label>
							<div class="col-md-6">
								{!! Form::text('tagline', $row->tagline,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true'  )) !!} 
							</div> 
							<div class=""></div>
						</div> --}}
						
						<div class="form-group " style="display: none;">
							<label for="Offer" class=" control-label col-md-4 text-md-right"> Offer ( in % ) </label>
							<div class="col-md-6">
								{!! Form::text('offer', $row->offer,array('class'=>'form-control allownumericwithoutdecimal', 'placeholder'=>'',   )) !!} 
							</div> 
							<div class=""></div>
						</div> 
						<div class="pt-3">
							<legend>SHOP STATUS</legend>
							<div class="col-xs-12" style="padding: 10px 15px 20px">
								<img id="imageid" name="imageid" class="center-block" alt="" />
								<input type="hidden" name="restaurant_image"  id="user_image" >
							</div>
							<div class="col-md-0"></div>
							@if(\Auth::user()->group_id == '1' || \Auth::user()->group_id == '2')
							<div class="form-group row">
								<label for="Admin Status" class=" control-label col-md-4 text-md-right">Admin Status :</label>
								<div class="col-md-6">
									<label for="Name" class=" control-label"> {{ $row->admin_status }} </label>
								</div> 
								<div class=""></div>
							</div> 
							<div class="form-group row" >
								<label for="Name" class=" control-label col-md-4 text-md-right"> Featured shop :</label>
								<div class="col-md-6">
									<label class=" control-label">
										{{ $row->ordering == '1' ? 'Enable' : 'Disable'}}
									</label>
								</div> 
								<div class=""></div>
							</div> 
						</div>
						@endif
									
						</fieldset>
						</div>
						</div>
						<input type="hidden" class="validate" name="latitude" id="lat" value="{{$row->latitude}}">
						<input type="hidden" class="validate" name="longitude" id="lang" value="{{$row->longitude}}">
						<input type="hidden" name="flatno" id="flatno" value="{!! $row->flatno !!}">
						<input type="hidden" name="adrs_line1" id="adrs_line1" value="{!! $row->adrs_line_1 !!}">
						<input type="hidden" name="adrs_line2" id="adrs_line2" value="{!! $row->adrs_line_2 !!}">
						<input type="hidden" name="sub_loc_level" id="sub_loc_level" value="{!! $row->sub_loc_level_1 !!}">
						<input type="hidden" name="city" id="city" value="{!! $row->city !!}">
						<input type="hidden" name="state" id="state" value="{!! $row->state !!}">
						<input type="hidden" name="country" id="country" value="{!! $row->country !!}">
						<input type="hidden" name="zipcode" id="zipcode" value="{!! $row->zipcode !!}">
						<div style="clear:both"></div>	
						<!-- <input type="text" name="placeSelect" id="placeSelect"> -->
						<!-- <div class="form-group row " > 
							<label for="Image" class=" control-label col-md-2 text-md-right"> {!! trans('core.abs_image_main') !!} <span class="asterix"> * </span></label>
							<div class="col-md-10">
								<input  type='file' name='image[]' id='image' multiple="" @if(!empty($row->banner)) class='required' @endif style='width:150px !important;' accept="image/png, image/jpeg, image/jpg"/>
								<div>
									@if(!empty($row->banner) && count($row['banner'])>0)
									@foreach($row->banner as $img)
									{{-- <img src="{{ $img }}" border="0" width="100" class="img-circle"> --}}
									{!! SiteHelpers::showUrlFileFood($img,'100','-') !!}
									@endforeach
									@endif
								</div>
							</div> 
						</div> -->
						
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
									{  selected_value : '{{ $row->partner_id }}' });

								$("#cuisine").jCombo("{!! url('restaurant/comboselect?filter=abserve_food_cuisines:id:name') !!}",
									{  selected_value : '{{ $row->cuisine }}' });
								$('.removeMultiFiles').on('click',function(){
									var removeUrl = '{{ url("restaurant/removefiles?file=")}}'+$(this).attr('url');
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
									{  selected_value : '{{ $row->cuisine }}' });
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
					@stop