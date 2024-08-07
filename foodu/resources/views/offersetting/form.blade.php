@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2>
	<div class="">
	  <ul class="breadcrumb">
	        <li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}"> Home </a></li>
	        <li class="breadcrumb-item"><a href=""> offers </a></li>
	        <li class="breadcrumb-item"> Add - Edit</li>
	      </ul>	  
	</div>

</div>

	{!! Form::open(array('url'=>'offersetting?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
	


<div class="m-3">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
		<div class="sbox-title"> 
		  <h5> <i class="fa fa-table"></i> </h5>
		</div>
	<fieldset>		
		<div class="d-flex flex-wrap fieldset_border">
		    <div class="col-md-6">
		    	<fieldset>
							<h6> Basic details</h6>
							{!! Form::hidden('id', $row['id']) !!}					
							<div class="form-group row  pt-3" >
								<label for="Name" class=" control-label col-md-4 text-md-right"> Name </label>
								<div class="col-md-6">
								  <input  type='text' name='name' id='name' value='{{ $row['name'] }}' 
				     					class='form-control form-control-sm ' /> 
							    </div> 
							 	<div class="col-md-2">
							 	</div>
							</div> 

			                <div class="form-group row  " >
								<label for="Offer From" class=" control-label col-md-4 text-md-right"> Offer From </label>
								<div class="col-md-6">
										<div class="input-group input-group-sm m-b" style="width:150px !important;">
										{!! Form::text('offer_from', $row['offer_from'],array('class'=>'form-control form-control-sm date')) !!}
										<div class="input-group-append">
										 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
										 </div>
								     </div> 
								</div>
								<div class="col-md-2"></div>
							</div> 					
							<div class="form-group row  " >
								<label for="Offer To" class=" control-label col-md-4 text-md-right"> Offer To </label>
								<div class="col-md-6">
									<div class="input-group input-group-sm m-b" style="width:150px !important;">
										{!! Form::text('offer_to', $row['offer_to'],array('class'=>'form-control form-control-sm date')) !!}
										<div class="input-group-append">
										 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
										 </div>
								     </div> 
								</div> 
					            <div class="col-md-2"></div>
							</div> 					
							<div class="form-group row  " >
								<label for="Offer Type" class=" control-label col-md-4 text-md-right"> Offer Type </label>
								<div class="col-md-6">
								  <input  type='text' name='offer_type' id='offer_type' value='{{ $row['offer_type'] }}' 
				     				class='form-control form-control-sm ' /> 
								</div> 
							 	<div class="col-md-2">
							 	</div>
							</div> 					
							<div class="form-group row  " >
								<label for="Offer Value" class=" control-label col-md-4 text-md-right"> Offer Value </label>
								<div class="col-md-6">
								  <input  type='text' name='offer_value' id='offer_value' value='{{ $row['offer_value'] }}' 
				                  class='form-control form-control-sm ' /> 
							    </div> 
							 	<div class="col-md-2"> </div>
							</div> 		
				</fieldset>	   
			</div> 
			<div class="col-md-6">
				<fieldset>
					    
					          <h6> Usage details</h6>   	
							<div class="form-group row pt-3 " >
								<label for="Status" class=" control-label col-md-4 text-md-right"> Status </label>
								<div class="col-md-6">
									<input type='radio' name='status' value ='active'  @if($row['status'] == 'active') checked="checked" @endif class='minimal-green' > Active 
									<input type='radio' name='status' value ='inactive'  @if($row['status'] == 'inactive') checked="checked" @endif class='minimal-green' > Inactive  
								</div> 
								<div class="col-md-2"></div>
							</div> 					
							<div class="form-group row  " >
								<label for="Usage Type" class=" control-label col-md-4 text-md-right"> Usage Type </label>
								<div class="col-md-6">
												  <input  type='text' name='usage_type' id='usage_type' value='{{ $row['usage_type'] }}' 
								     class='form-control form-control-sm ' /> 
							    </div> 
								<div class="col-md-2"></div>
							</div> 					
							<div class="form-group row  " >
								<label for="Usage Value" class=" control-label col-md-4 text-md-right"> Usage Value </label>
								<div class="col-md-6">
											  <input  type='text' name='usage_value' id='usage_value' value='{{ $row['usage_value'] }}' 
							     class='form-control form-control-sm ' /> 
								 </div> 
								<div class="col-md-2"></div>
							</div> 					
						    <div class="form-group row  " >
								<label for="Usage From" class=" control-label col-md-4 text-md-right"> Usage From </label>
								<div class="col-md-6">			  
									<div class="input-group input-group-sm m-b" style="width:150px !important;">
									{!! Form::text('usage_from', $row['usage_from'],array('class'=>'form-control form-control-sm date')) !!}
										<div class="input-group-append">
									 		<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
									  	</div>
							     	</div> 
								</div> 
								<div class="col-md-2"></div>					 
							</div> 					
							<div class="form-group row  " >
								<label for="Usage To" class=" control-label col-md-4 text-md-right"> Usage To </label>
								<div class="col-md-6">
									<div class="input-group input-group-sm m-b" style="width:150px !important;">
									{!! Form::text('usage_to', $row['usage_to'],array('class'=>'form-control form-control-sm date')) !!}
									<div class="input-group-append">
										<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
										</div>
									</div> 
								</div> 
								<div class="col-md-2"></div>					 
							</div> 					
							<div class="form-group row  " >
								<label for="Offer Limit" class=" control-label col-md-4 text-md-right"> Offer Limit </label>
								<div class="col-md-6">
												  <input  type='text' name='offer_limit' id='offer_limit' value='{{ $row['offer_limit'] }}' 
								     class='form-control form-control-sm ' /> 
								</div> 
								 <div class="col-md-2"></div>
							</div>	

							
						{!! Form::hidden('created_at', $row['created_at']) !!}{!! Form::hidden('updated_at', $row['updated_at']) !!}
				</fieldset>
			</div>
		</div>
		<div class="d-flex justify-content-center">
						<div>
							<div class="submitted-button">
								<button name="apply" class="tips btn btn-sm btn-green  "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
								<!-- <button name="save" class="tips btn btn-sm "  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button>  -->
								<button type="button" onclick="location.href='{{ url($pageModule.'?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button>
							</div>	
						</div>
						<!-- <div class="col-md-6 text-right " >
							<a href="{{ url($pageModule.'?return='.$return) }}" class="tips btn   btn-sm "  title="{{ __('core.btn_back') }}" >Cancel</a> 
						</div> -->
		</div>
		
		<input type="hidden" name="action_task" value="save" />
    </fieldset>		
</div>
	<!-- </div>	 -->	
	{!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		
		 	
		 	 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("offersetting/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop