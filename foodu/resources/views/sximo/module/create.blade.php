@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="toolbar-nav">
  	<div class="btn-group">
  		<a href="{{ url('sximo/module')}}" class="btn  btn-sm"> <i class="fa fa-times"></i> </a>
    </div>
</div>
<div class="p-5">
{!! Form::open(array('url'=>'sximo/module/create/', 'class'=>'form-horizontal validated', 'parsley-validate'=>'','novalidate'=>'')) !!}
<div class="row">
	<div class="col-md-8 offset-md-2">


	
      <div class="form-group row">
		<label class="col-sm-3 text-right"></label>
		<div class="col-sm-9">	
	  
			<ul class="parsley-error-list">
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
			</ul> 
		
		</div>	  
      </div>	

	<div class="form-group row has-feedback">
		<label class="col-sm-3 text-right"> {{ Lang::get('core.fr_modtitle') }} </label>
		<div class="col-sm-9">	
	  {!! Form::text('module_title', null, array('class'=>'form-control form-control-sm', 'placeholder'=>'Title Name', 'required'=>'true')) !!}
		</div>
	</div>		
	
	<div class="form-group row ">
		<label class="col-sm-3 text-right"> {{ Lang::get('core.fr_modnote') }}  </label>
		<div class="col-sm-9">	
	  {!! Form::text('module_note', null, array('class'=>'form-control form-control-sm', 'placeholder'=>'Short description module')) !!}
		
		</div>
	</div>

	<div class="form-group row ">
		<label class="col-sm-3 text-right"> Template :  </label>
		<div class="col-sm-9">	
			@foreach($cruds as $crud)
			<label class="" style="font-weight: 300;">	

				<input type="radio" name="module_template" value="{{ $crud->type }}" @if($crud->type =='native') checked="checked" @endif class="minimal-green" />
				<label style="font-size: 14px;"> {{ $crud->name }} </label>   <br />
				<small > {{ $crud->note }} </small> 
			</label> <br />
			@endforeach

				
					
		</div>
	</div>		


	<div class="form-group row ">
		<label class="col-sm-3 text-right">Class Controller </label>
		<div class="col-sm-9">	
	  {!! Form::text('module_name', null, array('class'=>'form-control form-control-sm', 'placeholder'=>'Class Controller / Module Name' ,  'required'=>'true')) !!}
		
		</div>
	</div>	
		
	
	<div class="form-group row">
		<label class="col-sm-3 text-right"> {{ Lang::get('core.fr_modtable') }}  </label>
		<div class="col-sm-9">	
		{!! Form::select('module_db', $tables , '' , 
			array('class'=>'form-control form-control-sm', 'required'=>'true' )); 
		!!}
	 	
		</div>
	</div>	
		
	<div class="form-group row " style="display:none;">
		<label class="col-sm-3 text-right">Author </label>
		<div class="col-sm-9">	
	  {!! Form::text('module_author',  null, array('class'=>'form-control form-control-sm', 'placeholder'=>'Author')) !!}
		
		</div>
	</div>	
		


	<div class="form-group row switchSql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">	
			<label class="">
				<input type="radio" name="creation" value="auto"  checked="checked"  class="minimal-green"/> 
				<label>{{ Lang::get('core.fr_modautosql') }} </label>
			</label>		
			<label class="">
				<input type="radio" name="creation" value="manual"  class="minimal-green" />
				<label>{{ Lang::get('core.fr_modmanualsql') }}</label>
			</label>		
		</div>
	</div>	
	
	<div class="form-group row manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
			{!! Form::textarea('sql_select', null, array('class'=>'form-control', 'placeholder'=>'SQL Select & Join Statement' ,'rows'=>'3' ,'id'=>'sql_select')) !!}
		  
		</div> 
	</div>	
	
	<div class="form-group row manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
		{!! Form::textarea('sql_where', null, array('class'=>'form-control', 'placeholder'=>'SQL Where Statement' ,'rows'=>'2','id'=>'sql_where')) !!}
		</div> 
	</div>		

	<div class="form-group row manualsql">
		<label class="col-sm-3 text-right">  </label>
		<div class="col-sm-9">
			{!! Form::textarea('sql_group', null, array('class'=>'form-control', 'placeholder'=>'SQL Grouping Statement' ,'rows'=>'2')) !!}
		</div> 
	</div>	
	
		
      <div class="form-group row">
		<label class="col-sm-3 text-right">&nbsp;</label>
		<div class="col-sm-9">	
	  	<button type="submit" class="btn btn-primary btn-sm "><i class="fa fa-save"></i>  {{ Lang::get('core.sb_submit') }}</button>

		</div>	  

      </div>
  </div>
    
    </div>
 {!! Form::close() !!}

</div>

</div>

<script type="text/javascript">
	$(document).ready(function(){



		$('.manualsql').hide();
		$('.switchSql input:radio').on('ifClicked', function() {
		  val = $(this).val(); 
			if(val == 'manual')
			{
				$('.manualsql').show();
				$('#sql_select').attr("required","true");
				$('#sql_where').attr("required","true");
				
			} else {
				$('.manualsql').hide();
				$('#sql_select').removeAttr("required");
				$('#sql_where').removeAttr("required");
	
			}		  
		  
		});

	});
	
</script>
@stop
