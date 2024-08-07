@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

{!! Form::open(array('url'=>'promocode?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}



<div class="p-3">
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>		
	<div class="row fieldset_border">
		<div class="col-md-12">
			<div class="sbox-title"> 
				<h5> <i class="fa fa-table"></i> </h5>
	        </div>
			<fieldset><h6 class="mb-3 pb-2"> PromoCode</h6>
				{!! Form::hidden('id', $row['id']) !!}					
				<div class="form-group row  " >
					<label for="Promo Name" class=" control-label col-md-4 text-md-right"> Promo Name <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='promo_name' id='promo_name' value='{{ $row['promo_name'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">

					</div>
				</div> 					
				<div class="form-group row  " >
					<?php
					$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$code = "";
					for ($i = 0; $i < 7; $i++) {
						$code .= $chars[mt_rand(0, strlen($chars)-1)];
					}
					?>
					<label for="Promo Code" class=" control-label col-md-4 text-md-right"> Promo Code </label>
					<div class="col-md-6">
										  <!-- <input  type='text' name='promo_code' id='promo_code' value='{{ $row['promo_code'] }}' 
										  	class='form-control form-control-sm ' />  -->

										  	@if($row['promo_code']!='')
										  	{!! Form::text('promo_code', ($row['id']!='') ? $row['promo_code'] : $code,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'' ,'id'=>'promo_code' ,"readonly"  )) !!} 
										  	@else
										  	{!! Form::text('promo_code', ($row['id']!='') ? $row['promo_code'] : $code,array('class'=>'form-control', 'placeholder'=>'', 'required'=>'' ,'id'=>'promo_code' )) !!}  
										  	@endif 
										  </div> 
										  <div class="col-md-2">

										  </div>
										</div> 					
										<div class="form-group row  " >
											<label for="Promo Desc" class=" control-label col-md-4 text-md-right"> Promo Desc <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<textarea name='promo_desc' rows='5' id='promo_desc' class='form-control form-control-sm '  
												required  >{{ $row['promo_desc'] }}</textarea> 
											</div> 
											<div class="col-md-2">

											</div>
										</div> 					
										<div class="form-group row  " >
											<label for="Start Date" class=" control-label col-md-4 text-md-right"> Start Date <span class="asterix"> * </span></label>
											<div class="col-md-6">

												<div class="input-group input-group-sm m-b" style="width:150px !important;">
													{!! Form::text('start_date', $row['start_date'],array('class'=>'form-control form-control-sm date')) !!}
													<div class="input-group-append">
														<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
													</div>
												</div> 
											</div> 
											<div class="col-md-2">

											</div>
										</div> 					
										<div class="form-group row  " >
											<label for="End Date" class=" control-label col-md-4 text-md-right"> End Date <span class="asterix"> * </span></label>
											<div class="col-md-6">

												<div class="input-group input-group-sm m-b" style="width:150px !important;">
													{!! Form::text('end_date', $row['end_date'],array('class'=>'form-control form-control-sm date')) !!}
													<div class="input-group-append">
														<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
													</div>
												</div> 
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
													{!! AbserveHelpers::showUploadedFile( $row["avatar"],"/uploads/slider/") !!}
												</div>

											</div> 
											<div class="col-md-2">

											</div>
										</div> 					
										<div class="form-group row  " >
											<label for="Promo Type" class=" control-label col-md-4 text-md-right"> Promo Type <span class="asterix"> * </span></label>
											<div class="col-md-6">


												<input type='radio' name='promo_type' value ='amount' required @if($row['promo_type'] == 'amount') checked="checked" @endif class='minimal-green' > Amount 

												<input type='radio' name='promo_type' value ='percentage' required @if($row['promo_type'] == 'percentage') checked="checked" @endif class='minimal-green' > Percentage  
											</div> 
											<div class="col-md-2">

											</div>
										</div> 					
										<div class="form-group row  " >
											<label for="Promo Offer" class=" control-label col-md-4 text-md-right"> Promo Offer <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<input  type='text' name='promo_amount' id='promo_amount' value='{{ $row['promo_amount'] }}' 
												required     class='form-control form-control-sm ' /> 
											</div> 
											<div class="col-md-2">

											</div>
										</div> 				
										<div class="form-group row  " >
											<label for="Limit " class=" control-label col-md-4 text-md-right"> Limit  <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<input  type='text' name='limit_values' id='limit_values' value='{{ $row['limit_values'] }}' 
												required     class='form-control form-control-sm ' /> 
											</div> 
											<div class="col-md-2">

											</div>
										</div>					
										<div class="form-group row  " >
											<label for="Min Order Amount" class=" control-label col-md-4 text-md-right"> Min Order Amount </label>
											<div class="col-md-6">
												<input  type='text' name='min_order_value' id='min_order_value' value='{{ $row['min_order_value'] }}' 
												class='form-control form-control-sm ' /> 
											</br><span>*If you dont want to set minimum order value, then just give "0"</span>
										</br>
									</div> 
									<div class="col-md-2">

									</div>
								</div> 					
								{{-- <div class="form-group row  " >
									<label for="Maximum Discount" class=" control-label col-md-4 text-md-right"> Maximum Discount </label>
									<div class="col-md-6">
										<input  type='text' name='max_discount' id='max_discount' value='{{ $row['max_discount'] }}' 
										class='form-control form-control-sm ' /> 
									</div> 
									<div class="col-md-2">

									</div>
								</div> --}}
								<?php $cust_array = array();
								$cust_array = explode(',',$row['user_id']); 
								if(!isset($is_refund)){ $is_refund=0;}
								?>
								@if($is_refund == 1)
								<input type="hidden" id="hid_refund" name="hid_refund" value="1">
								<input type="hidden" id="hid_order_id" name="hid_order_id" value="{{$order_id}}">
								@endif

								<div class="form-group row  " >
									<label for="Customer" class=" control-label col-md-4 text-md-right"> Customer <span class="asterix"> * </span></label>
									<div class="col-md-6">
										<?php  if($row['user_id']!=''){ $user_id=$row['user_id']; } else{
											$user_id=''; }  ?>
											<select name="user_id[]" id="user_id" multiple="multiple" class="select2"  >
												<option value="" disabled>Please Select...</option>

												@if($is_refund != 1)
												<option value="0" @if($user_id == 0) selected="" @endif >All User</option>
												@endif
												@if(count($userlist) > 0)
												@foreach($userlist as $user)
												<option value="{!! $user->id !!}" <?php if(in_array($user->id,$cust_array)) echo "selected";  ?>  >{!! $user->username !!}</option>
												@endforeach
												@endif
											</select>
										</div> 
										<div class="col-md-2">

										</div>
									</div> 					
									<div class="form-group row  " >
										<label for="Number of usage to single customer" class=" control-label col-md-4 text-md-right"> Number of usage to single customer <span class="asterix"> * </span></label>
										<div class="col-md-6">
											<input  type='text' name='usage_count' id='usage_count' value='{{ $row['usage_count'] }}' 
											required     class='form-control form-control-sm ' /> 
										</div> 
										<div class="col-md-2">

										</div>
									</div> 
									<?php  if($row['loc_res']==''){ $loc_res='loc'; } else{
										$loc_res='res'; } ?>

										{{--<div class="form-group  row" >
											<label for="End Date" class=" control-label col-md-4 text-md-right"> Type <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<input type="radio" class="loc_res" name="loc_res"   @if($loc_res == 'loc') checked @endif  value="loc"> Location
												<input type="radio" class="loc_res" name="loc_res"   @if($loc_res == 'res') checked @endif value="res"> Shop
											</div> 
											<div class="col-md-2">

											</div>
										</div>--}}	

										<?php
										if($row['res_id']!=''){ $res_id=0; } else{
											$res_id=''; }

													 // echo "<pre>";print_r($reslist);exit(); 


											$res_array = array();
											$res_array = explode(',',$res_id); 



											?>
											<div class="form-group row res_tab" id="res_tab" >
												<label for="Promo Amount" class=" control-label col-md-4 text-md-right"> Shop  </label>
												<div class="col-md-6">
													<select name="resid[]" id="resid" multiple="multiple" class="select2">
														<option value="" disabled>Please Select...</option>
														<option value="0" @if($res_id == 0) selected @endif >All Shop</option>
														@if(count($reslist) > 0)
														@foreach($reslist as $res)
														<option value="{{ $res->id }}" <?php if(in_array($res->id,$res_array)) echo "selected";  ?>  >{{ $res->name }}</option>
														@endforeach
														@endif
													</select>
												</div> 
												<div class="col-md-2"></div>
											</div> 
											<?php if($row['l_id']!=''){ $l_id=0; } else{
												$l_id=''; } ?>

												{{--<div class="form-group row loc_tab" id="loc_tab"  style="display:@if($loc_res != 'loc') none @endif">
													<label for="Status" class=" control-label col-md-4 text-md-right"> Location<span class="asterix"> * </span></label>

													<?php $myArray = array();
													$myArray = explode(',',$l_id); 
													?>
													<div class="col-md-6">
														<select name="locid[]" id="locid" multiple="multiple" class="select2">
															<option value="" disabled>Please Select...</option>
															<option value="0" @if($l_id == 0) selected @endif >All Location</option>
															<?php $location = \AbserveHelpers::location_list(); ?>
															@if(count($location) > 0)
															@foreach($location as $res)

															<option value="{{ $res->id }}" <?php if(in_array($res->id,$myArray)) echo "selected";  ?> >{{ $res->name }}</option>
															@endforeach
															@endif
														</select>
													</div> 

													<div class="col-md-2">

													</div>
												</div>--}}	


												<div class="form-group row  " >
													<label for="Promo Mode" class=" control-label col-md-4 text-md-right"> Promo Mode <span class="asterix"> * </span></label>
													<div class="col-md-6">


														<input type='radio' name='promo_mode' value ='on' required @if($row['promo_mode'] == 'on') checked="checked" @endif class='minimal-green' > On 

														<input type='radio' name='promo_mode' value ='off' required @if($row['promo_mode'] == 'off') checked="checked" @endif class='minimal-green' > Off  
													</div> 
													<div class="col-md-2">

													</div>
												</div> 


												{{--<div class="form-group row " >
													<label for="ext_url" class=" control-label col-md-4 text-md-right"> External URL</label>
													<div class="col-md-6">
														{!! Form::url('ext_url', $row['ext_url'],array('class'=>'form-control', 'placeholder'=>'','value'=>'0', 'id'=>'ext_url' )) !!} 
														<br/><span>(LEAVE EMPTY IF SHOP NEEDS TO BE SHOWN)</span>						
													</div>		
													<div class="col-md-2">
													</div>
												</div>--}}
												<div class="">
														<div class="d-flex justify-content-center">

															<div class="col-md-6 " >
																<div class="submitted-button">
																	<button name="apply" class="tips btn btn-sm  btn-green "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>

																	<button type="button" onclick="location.href='{{ URL::to('promocode?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>

																</div>	
															</div>
														</div>
									            </div> 	

											</fieldset>



										</div>


									</div>

									<input type="hidden" name="action_task" value="save" />



											
			<!-- <div class="col-md-6 text-right " >
				<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn   btn-sm "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-times"></i></a> 
			</div> -->
		</div>
	</div>	

</div>

</div>	


{!! Form::close() !!}

<script type="text/javascript">
	
	$(document).ready(function() { 
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("promocode/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});	
		
	});

	$('.loc_res').on('click', function(event){  
		
		var value=$(this).val();
		if(value == 'loc'){   
			$(".res_tab").css("display","none");
						$(".loc_tab").css("display","block");

		}	
		else if(value == 'res') {
			$(".loc_tab").css("display","none");
						$(".res_tab").css("display","block");

		}

	    
 	});	


</script>		 
@stop