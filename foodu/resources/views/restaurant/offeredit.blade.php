@extends('layouts.app')
<style>
	.demo-sec input{
		z-index: 99;
    width: 20px;
    height: 20px;
	}
</style>
@section('content')
<div class="page-header"><h2> Offer Create <small> Offer detail </small> </h2></div>

{!! Form::open(array('url'=>'restaurantoffer/store', 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}


<input type="hidden" name="res_id" value="{{$offer->res_id}}">
<input type="hidden" name="id" value="{{$offer->id}}">
<div class="p-3">		
	<div class="row fieldset_border">
		<div class="col-md-12">
			<div class="sbox-title"> 
				<h5> <i class="fa fa-table"></i> </h5>
	        </div>
			<fieldset><h6 class="mb-3 pb-2"> Offer</h6>					
				<div class="form-group row  " >
					<label for="Promo Name" class=" control-label col-md-4 text-md-right"> Promo Title <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='offer_name' id='promo_name' value='{{$offer->promo_name}}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">

					</div>
				</div> 					
										<div class="form-group row  " >
											<label for="Promo Desc" class=" control-label col-md-4 text-md-right"> Promo Desc <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<textarea name='offer_desc' rows='5' id='promo_desc' class='form-control form-control-sm '  
												required  >{{$offer->promo_desc}}</textarea> 
											</div> 
											<div class="col-md-2">

											</div>
										</div> 					
										<div class="form-group row  " >
											<label for="Start Date" class=" control-label col-md-4 text-md-right"> Start Date <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<input type="date" name="s_date" value="{{$offer->start_date}}">
												<div class="input-group input-group-sm m-b" style="width:150px !important;">
													<div class="input-group-append">
													</div>
												</div> 
											</div> 
											<div class="col-md-2">

											</div>
										</div> 					
										<div class="form-group row  " >
											<label for="End Date" class=" control-label col-md-4 text-md-right"> End Date <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<input type="date" name="e_date" value="{{$offer->end_date}}">
												<div class="input-group input-group-sm m-b" style="width:150px !important;">
													<div class="input-group-append">
													</div>
												</div> 
											</div> 
											<div class="col-md-2">

											</div>
										</div>

										<div class="form-group row  " >
											<label for="Promo Type" class=" control-label col-md-4 text-md-right"> Promo Type <span class="asterix"> * </span></label>
											<div class="col-md-6">


												<input type='radio' name='promo_type' value ='amount' required @if($offer->promo_type == 'amount') checked="checked" @endif class='minimal-green' > Amount 

												<input type='radio' name='promo_type' value ='percentage' required @if($offer->promo_type == 'percentage') checked="checked" @endif class='minimal-green' > Percentage  
											</div> 
											<div class="col-md-2">

											</div>
										</div>

												<div class="form-group row " id="Promo_Code"  >
													<label for="Promo Code" class=" control-label col-md-4 text-md-right"> Promo Code </label>
													<div class="col-md-6">
												   <input  type='text' name='promo_code' id='promo_code' value='{{$offer->promo_code}}' 
												  	class='form-control form-control-sm ' />  
												  </div> 
												  <div class="col-md-2">

												  </div>
												</div>


										<div class="form-group row  " >
											<label for="Promo Offer" class=" control-label col-md-4 text-md-right"> Offer in A/P  <span class="asterix"> * </span></label>
											<div class="col-md-6">
												<input  type='text' name='offer_amt' id='offer_amt' value='{{$offer->promo_amount}}'
												required     class='form-control form-control-sm ' /> 
											</div> 
											<div class="col-md-2">

											</div>
										</div> 				
										<div class="form-group row  " >
											<label for="Min Order Amount" class=" control-label col-md-4 text-md-right"> Min Order Amount </label>
											<div class="col-md-6">
												<input  type='text' name='min_order_value' id='min_order_value' value='{{$offer->min_order_value}}'class='form-control form-control-sm ' /> 
											</br><span>*If you dont want to set minimum order value, then just give "0"</span>
										</br>
									</div> 
									<div class="col-md-2">

									</div>
								</div>	


												<div class="form-group row  " >
													<label for="Promo Mode" class=" control-label col-md-4 text-md-right"> Promo Mode <span class="asterix"> * </span></label>
													<div class="col-md-6">


														<input type='radio' name='offer_mode' value ='on' required @if($offer->promo_mode == 'on') checked="checked" @endif class='minimal-green' > On 

														<input type='radio' name='offer_mode' value ='off' required @if($offer->promo_mode == 'off') checked="checked" @endif class='minimal-green' > Off  
													</div> 
													<div class="col-md-2">

													</div>
												</div> 
												<div class="">
														<div class="d-flex justify-content-center">

															<div class="col-md-6 " >
																<div class="submitted-button">
																	<button name="apply" class="tips btn btn-sm  btn-green "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
																</div>	
															</div>
														</div>
									            </div> 	

											</fieldset>



										</div>


									</div>

									<input type="hidden" name="action_task" value="save" />
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

 	/*$('.type_offer').click(function () {
 		value = $(this).val();
 		if(value == 'amount'){
        	$('#amount').parent().addClass("hover checked");
        	$('#percentage').parent().removeClass("hover checked");
        	$('#promo_code').parent().removeClass("hover checked");
        	$('#Promo_Code').css('display', 'none');
        }else if(value == 'percentage'){
        	$('#amount').parent().removeClass("hover checked");
        	$('#percentage').parent().addClass("hover checked");
        	$('#promo_code').parent().removeClass("hover checked");
        	$('#Promo_Code').css('display', 'none');
        }else if(value == 'promo_code'){
        	$('#amount').parent().removeClass("hover checked");
        	$('#percentage').parent().removeClass("hover checked");
        	$('#promo_code').parent().addClass("hover checked");
        	$('#Promo_Code').css('display', 'block');
        }
         $('#hidden_offer_type').val(value);
    });*/


</script>		 
@stop