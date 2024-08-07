@extends('layouts.app')

@section('content')

<div class="page-header"><h2>  Categories <small>  blog / post categories  </small> </h2></div>
<div class="toolbar-nav">
	<div class="row">
		<div class="col-md-8"> 	
			
			<a href="{{ url('cms/categories/create') }}" onclick="SximoModal( this.href ,'Edit Category'); return  false ;" class="btn btn-default btn-sm"  
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create New </a>


			   
		</div>
		<div class="col-md-4 ">
			
		</div>    
	</div>
</div>	
<div class="px-3">
	<div class="list-group">
		@foreach($rows as $row)
		<a href="{{ url('cms/categories/'.$row->cid.'/edit')}}" class="list-group-item list-group-item-action " onclick="SximoModal( this.href ,'Edit Category'); return  false ;">
			{{ $row->name }} ( {{ $row->total }} )
		</a>
		@endforeach
	</div>  

</div>

@stop