@extends('layouts.app')

@section('content')
<div class="page-header"><div class=""><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
<div class="">
<ul class="breadcrumb">
<li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
<li class="breadcrumb-item active">{{ $pageTitle }}</li>
</ul>	  
</div>
</div>
<div class="m-sm-4 m-3 box-border">
<div class="sbox-title"> 
<h5> <i class="fa fa-table"></i> </h5>
<div class="sbox-tools">
@if( \Request::query('search') != '' )
{{--<a href="{{ URL::to($pageModule) }}" style="display: block ! important;" class="btn btn-xs btn-white tips" title="Clear Search" >
<i class="fa fa-trash-o"></i> {!! trans('core.abs_clr_search') !!} 
</a>--}}
@endif
<a href="#" class="btn btn-xs btn-white tips" title="" data-original-title=" Configuration">
<i class="fa fa-cog"></i>
</a>	 
</div>
</div>
<div class="toolbar-nav" >   
<div class="row">
{{--<div class="col-md-8 button-chng my-1"> 	
@if($access['is_add'] ==1)
<a href="{{ url('restaurant/create?return='.$return) }}" class="btn  btn-sm"  
title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create </a>
@endif
<div class="btn-group">
<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>
</div>
</div>--}}
</div>
</div>
<div class="p-3">
<div class="table-container for-icon m-0">

<table class="table  table-hover " id="{{ $pageModule }}Table">
<thead>
<tr>
<th class="number"> No </th>
<th> Image</th>
<th >Name</th>
<th>Status</th>
<th>Action</th>
<th>View</th>

</tr>
</thead>

<tbody>  
<?php $i= $pagination->currentPage() > 1 ? $pagination->perPage() * ($pagination->currentPage()-1) +1 : 1;?>
@foreach ($rowData as $row)
<?php $res_image = explode(',', $row->logo);
?>      						

<tr>
<td class="thead"> {{ $i }} </td>
<td>
@if($row->logo != '')
<img width="100px" height="100px" src="<?php echo URL::to('/').'/uploads/restaurants/'.$res_image[0];?>">
</a>
@else
<img width="100px" height="100px" src="<?php echo URL::to('uploads/images/no-image.png')?>">
</a>
@endif
</td>
<td>{!! $row->name !!}</td>
<td>{{ $row->admin_status }}</td>
<td>
<button class="accept-button changestatus" value="approved" data-id="{{$row->id}}">Accept</button>
<button class="reject-button changestatus" value="rejected" data-id="{{$row->id}}">Reject</button>
</td>
<td><a href="{{ url('approval/'.$row->id.'?return='.$return)}}" class="nav-link tips" title="{{ __('core.btn_view') }}" style="text-decoration: none; color: #3498db; padding: 8px 12px; background-color: #ecf0f1; border-radius: 5px; display: inline-block;"> {{ __('core.btn_view') }} </a></td>		 
</tr>
<?php $i++;?>
@endforeach
</tbody>
</table>
</div>
</div>
</div>
@include('footer')
<!-- search model start -->
@include('admin/search')	
<script>
	var base_url = '{{ url('') }}';
	$('.changestatus').click(function(){
		var id = $(this).data('id');
		var status = $(this).val();
		$.ajax({
			url: base_url+'/changeStatus',
			method : 'POST',
			data : {id:id, status:status},
			success:function(data){
				location.reload();
			}
		});
	});
</script>	
<style type="text/css">
.flt-number{width:50px;display:inline-block;margin: 0 7px;}
.bottom_pad{padding-bottom: 15px;}
</style>	
<style>
#snackbar {

min-width: 30px;

background-color: green;
color: #fff;
text-align: center;

padding: 5px;



font-size: 13px;
}

.rej
{
background-color:red;
width:153px;
text-align: center;
color: #fff;

}
.appr
{
background-color:green;
width:153px;
text-align: center;
color: #fff;
}
.wait
{
background-color:blue;
width:153px;
text-align: center;
color: #fff;
}

</style>

<style>
/* Add your custom styling here */
.action-buttons {
display: flex;
justify-content: space-around;
margin-top: 20px;
}

.accept-button, .reject-button {
padding: 10px;
font-size: 14px;
cursor: pointer;
}

.accept-button {
background-color: #4CAF50;
color: white;
border: none;
border-radius: 5px;
}

.reject-button {
background-color: #f44336;
color: white;
border: none;
border-radius: 5px;
}
</style>	
@stop
