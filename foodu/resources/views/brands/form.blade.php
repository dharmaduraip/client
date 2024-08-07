@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>

{!! Form::open(array('url'=>'brands?return='.$return, 'class'=>'form-horizontal validated sximo-form','files' => true ,'id'=> 'FormTable' )) !!}
<div class="p-3">
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>		
	<div class="row m-0">
		<div class="col-md-12">
			<fieldset><legend> Brands</legend>
				{!! Form::hidden('id', $row['id']) !!}					
				<div class="form-group row  " >
					<label for="Brand Name" class=" control-label col-md-4 text-md-right"> Brand Name <span class="asterix"> * </span></label>
					<div class="col-md-6">
						<input  type='text' name='cat_name' id='cat_name' value='{{ $row['cat_name'] }}' 
						required     class='form-control form-control-sm ' /> 
					</div> 
					<div class="col-md-2">
					</div>
				</div>
				<div class="">
					<div class="row">
						<div class="col-md-12 text-center" >
							<div class="submitted-button">
								<button name="apply" class="tips btn btn-sm btn-green  "  title="{{ __('core.btn_back') }}" ><i class="fa  fa-check"></i> {{ __('core.sb_apply') }} </button>
								<button name="save" class="tips btn btn-sm btn-black"  id="saved-button" title="{{ __('core.btn_back') }}" ><i class="fa  fa-paste"></i> {{ __('core.sb_save') }} </button>
								<button type="button" onclick="location.href='{{ url($pageModule.'?return='.$return) }}' " class="btn btn-success btn-sm "><i class="fa  fa-arrow-circle-left "></i>  {!! Lang::get('core.sb_cancel') !!} </button> 
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
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function() {
		$('.removeMultiFiles').on('click',function(){
			var removeUrl = '{{ url("brands/removefiles?file=")}}'+$(this).attr('url');
			$(this).parent().remove();
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		

	});
</script>		 
@stop