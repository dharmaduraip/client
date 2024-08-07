@extends('layouts.app')
@section('content')
<script type="text/javascript" src="{{ url('/sximo5/js/plugins/jquery.nestable.js') }}"></script>
<div class="page-content row">
	<!-- Page header -->
	<div class="page-header"> 
		<div class="page-title">
			<h3> {{ 'Category ordering' }}</h3>
		</div>
		<ul class="breadcrumb">
			<li><a href="{{ URL::to('dashboard') }}"> {!! trans('core.abs_dashboard') !!} </a></li>
			<li><a href="{{ URL::to('restaurant/') }}"> Shops</a></li>
		</ul>
	</div>
	<div class="row drag-drop-asw ">
		<div class="col-md-4">
			<div class="panel panel-body border-top-info p-4">
				<div class="text-center">
					<p class="content-group-sm text-muted">Shop Categories</p>
				</div>
				<div id="list2" class="dd" style="min-height:350px;">
					<ol class="dd-list " >
						@foreach ($cate_list_shop as $key => $val)
						<li data-id="{{$val->id}}" class="dd-item dd3-item">
							<div class="dd-handle dd3-handle"></div><div class="dd3-content">{{$val->cat_name}}
							<span class="pull-right">
								<a href="{{ URL::to('restaurant/category/')}}">
								</a></span></div></li>
								@endforeach
							</ol>   
							{!! Form::open(array('url'=>'restaurant/savecategory/'.Request::segment(3), 'class'=>'form-horizontal','files' => true)) !!}	
							<input type="hidden" name="reorder" id="reorder" value="" />
							<button type="submit" class="btn btn-primary ">  {!! Lang::get('core.sb_reorder') !!} </button>	
							{!! Form::close() !!}	
						</div>
					</div> 
				</div>
			</div>
		</div>
<script>
	$(document).ready(function(){
		$('.dd').nestable();
		update_out('#list2',"#reorder");

		$('#list2').on('change', function() {
			var out = $('#list2').nestable('serialize');
			$('#reorder').val(JSON.stringify(out));	  

		});	

	});		
	function update_out(selector, sel2){

		var out = $(selector).nestable('serialize');
		$(sel2).val(JSON.stringify(out));

	}
</script>		
@stop 