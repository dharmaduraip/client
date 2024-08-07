@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

	{!! Form::open(array('url'=>'restaurantrating?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
	


	<div class="p-3">
		<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>		
		<div class="row m-0">
			<div class="col-md-12">
				<fieldset>
					<legend> Restaurant Rating</legend>
					{!! Form::hidden('id', $row['id']) !!}					
					<div class="form-group row  " >
						<label for="Customer Name" class=" control-label col-md-4 text-md-right"> Customer Name </label>
						<div class="col-md-6">
							<select name='cust_id' rows='5' id='cust_id' class='select2 '   ></select> 
						</div> 
						<div class="col-md-2">

						</div>
					</div> 					
					<div class="form-group row  " >
						<label for="Shop Name" class=" control-label col-md-4 text-md-right"> Shop Name </label>
						<div class="col-md-6">
							<select name='res_id' rows='5' id='res_id' class='select2 '   ></select> 
						</div> 
						<div class="col-md-2">

						</div>
					</div> 					
					<div class="form-group row  " >
						<label for="Order Id" class=" control-label col-md-4 text-md-right"> Order Id </label>
						<div class="col-md-6">
							<input  type='text' name='orderid' id='orderid' value='{{ $row['orderid'] }}' 
							class='form-control form-control-sm ' /> 
						</div> 
						<div class="col-md-2">

						</div>
					</div> 					
					<div class="form-group row  " >
						<label for="Rating" class=" control-label col-md-4 text-md-right"> Rating </label>
						<div class="col-md-6">
							<input  type='text' name='rating' id='rating' value='{{ $row['rating'] }}' 
							class='form-control form-control-sm ' /> 
						</div> 
						<div class="col-md-2">

						</div>
					</div> 					
					<div class="form-group row  " >
						<label for="Comments" class=" control-label col-md-4 text-md-right"> Comments </label>
						<div class="col-md-6">
							<textarea name='comments' rows='5' id='comments' class='form-control form-control-sm '  
							>{{ $row['comments'] }}</textarea> 
						</div> 
						<div class="col-md-2">

						</div>
					</div> 

					<div class="">
						<div class="row">
							
							<div class="col-md-12 text-center" >
								<div class="submitted-button">
									<button name="apply" class="tips btn btn-sm  btn-green "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
									<button name="save" class="tips btn btn-sm btn-black "  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button> 
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
		
		
		
		$("#cust_id").jCombo("{!! url('restaurantrating/comboselect?filter=tb_users:id:username') !!}",
		{  selected_value : '{{ $row["cust_id"] }}' });
		
		$("#res_id").jCombo("{!! url('restaurantrating/comboselect?filter=abserve_restaurants:id:name') !!}",
		{  selected_value : '{{ $row["res_id"] }}' });
		 	
		 	 

		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("restaurantrating/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
@stop