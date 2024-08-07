<style>
#km{
	width: 25%;
}
</style>
<?php //print_r ($rowData); exit();?>
@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
<?php $baseCurSymbol = \AbserveHelpers::getBaseCurrencySymbol();?>
  <div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
	<!--Tam-->
	@if (session('msg'))   
	    <div class="alert alert-success">
	            {{ session('msg') }}
	    </div>
	@endif
	@if (session('error'))   
	    <div class="alert alert-danger">
	            {{ session('error') }}
	    </div>
	@endif

	<div class="page-content-wrapper m-t">	 	
{!! Form::open(array('url'=>'restaurant/disnon_feat', 'class'=>'form-horizontal p-4' , 'method' => 'get' )) !!}

	<div class="row justify-content-end">
		<div class="col-md-4">		
		  <select name="id" class="form-control form-control-sm ">
		  <option disabled selected value="">Please select</option>

			@foreach ($restaurants as $row)
				@if($row->ordering == 2)
					<option value="{!! $row->id !!}">{!! $row->name !!}</option>
				@endif
			@endforeach
		  </select>
		  </div>
		  <div class="col-md-1">		
			<input type="submit" value="Submit" class="btn btn-sm btn-green d-inline-block">
		  </div>
		
		</div>
		{!! Form::close() !!}
<div class="sbox animated fadeInRight restaurant_page">
	
	
 <div class="form-group  " >
	 
 	{!! Form::open(array('url'=>'restaurant/bulk_change_feature', 'class'=>'form-horizontal' ,'id' =>'AbserveTable', 'method' => 'post' )) !!}
	 <p style="font-size: 23px;">Featured Shops</p> 
	 <button type="submit" class="tips btn btn-xs btn-danger"  data-original-title="Disable">Disable</button>
	 <input type="hidden" name="upd_hid" value="2">

	 <table class="table table-striped ">
		 	<thead>
				<tr>
					<th class="number"> No </th>
					<th> <input type="checkbox" id="feature_ckbox_all"  ></th>
					<th> Image</th>
					<th >Name</th>
					<th>Partner Name</th>
					<th>Partner Mobile No</th>
					<th>Status</th>
					<th>Action</th>

				  </tr>
	        </thead>
	        <tbody> 
		<?php $i=1;?>
		@foreach ($pagination as $row)
			@if($row->ordering == 1)
			<tr>
				<td>{!!$i!!}</td>
				<td> <input type="checkbox"  class="feature_ckbox" name="feature_ckbox[]" value="{!! $row->id !!}"></td>
				<td>@if($row->logo != '')
						<a href="{{URL::to('restaurant/'.$row->id.'/edit?return='.$return)}}" target="_blank" class="previewImage">
							<img width="100px" height="100px" src="<?php echo URL::to('/').'/uploads/restaurants/'.$row->logo;?>">
						</a>
						@else
						<a href="{{URL::to('restaurant/update/'.$row->id.'?return='.$return)}}">
							<img width="100px" height="100px" src="<?php echo URL::to('uploads/images/no-image.png')?>">
						</a>
						@endif</td>
				<td>{!! $row->name !!}</td>
				<td>
					{!! $row->partner_name !!}
				</td>
				<td>
					{!! $row->phone_number !!}
				</td>
				<td><?php if($row->admin_status == 'rejected'){ ?>
					<span class="label  label-danger" > Rejected</span> <?php if($row->admin_status == 'rejected'){?>&nbsp<i class="fa fa-question-circle tips" aria-hidden="true" title = "<?php echo $row->rejectreason ?>"></i><?php } ?>
					<?php }else if($row->admin_status == 'approved'){ ?>
					<span class="label  label-success"> Approved</span>
					<?php }else if($row->admin_status == 'waiting'){ ?>
					@if(\Auth::user()->group_id=='1')
					<span class="label  label-info"> Waiting for your approval</span>
					@else
					<span class="label  label-info"> Waiting for admin approval</span>
					@endif
					<?php } ?></td>
				<td>
					<!--Tam
					<a href="{{URL::to('restaurant/update/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-success" title="" data-original-title="Edit"><i class="fa fa-edit "></i></a>
                		<a class="cdelete tips btn btn-xs btn-danger" title="Click to delete" data-href="{{URL::to('restaurant/resdelete/'.$row->id.'?return='.$return)}}" data-toggle="modal" data-target="#confirm-delete1"><i class="fa fa-minus-square"></i></a>
                		-->
                		<a href="{{URL::to('restaurant/change_feature/'.$row->id.'/2?return='.$return)}}" class="tips btn btn-xs btn-danger" title="" data-original-title="Disable">Disable</a>

				</td>
			</tr>
			@endif
<?php $i++;?>
		@endforeach
</tbody>
</table>

<script>
//Tam -  Featured Shops
var triggeredByChild = false;

$('#feature_ckbox_all').on('ifChecked', function(event){  	
       $('.feature_ckbox').iCheck('check');
           triggeredByChild = false;

});
$('#feature_ckbox_all').on('ifUnchecked', function(event){  	
    
   if (!triggeredByChild) {
       $('.feature_ckbox').iCheck('uncheck');
    }
     triggeredByChild = false;
});

$('.feature_ckbox').on('ifChecked', function (event) {
    if ($('.feature_ckbox').filter(':checked').length == $('.feature_ckbox').length) {
        $('#feature_ckbox_all').iCheck('check');
    }
});
$('.feature_ckbox').on('ifUnchecked', function (event) {
	 triggeredByChild = true;
          $('#feature_ckbox_all').iCheck('uncheck');
 });

</script>
{!! Form::close() !!}

<!--Tam-->
<BR><BR>
{!! Form::open(array('url'=>'restaurant/bulk_change_feature', 'class'=>'form-horizontal' ,'id' =>'AbserveTable', 'method' => 'post' )) !!}
 {{--<p style="font-size: 23px;">Non Featured Shops</p>
 <button type="submit" class="tips btn btn-xs btn-success" style="background-color: #1ab394" data-original-title="Enable">Enable</button>
 <input type="hidden" name="upd_hid" value="1">

 <table class="table table-striped ">
		 	<thead>
				<tr>
					<th class="number"> No </th>
					<th> <input type="checkbox" id="non_feature_ckbox_all" ></th>
					<th> Image</th>
					<th >Name</th>
					<th>Partner Name</th>
					<th>Partner Mobile No</th>
					<th>Status</th>
					<th>Action</th>

				  </tr>
	        </thead>
	        <tbody> 
		<?php $i=1;?>
		@foreach ($rowData as $row)
			@if($row->ordering == 2)
			<tr>
				<td>{!!$i!!}</td>
				<td> <input type="checkbox" class="non_feature_ckbox"  name="feature_ckbox[]" value="{!! $row->id !!}"  ></td>
				<td>@if($row->logo != '')
						<a href="{{URL::to('restaurant/update/'.$row->id.'?return='.$return)}}" target="_blank" class="previewImage">
							<img width="100px" height="100px" src="<?php echo URL::to('/').'/uploads/restaurants/'.$row->logo;?>">
						</a>
						@else
						<a href="{{URL::to('restaurant/update/'.$row->id.'?return='.$return)}}">
							<img width="100px" height="100px" src="<?php echo URL::to('uploads/images/no-image.png')?>">
						</a>
						@endif</td>
				<td>{!! $row->name !!}</td>
				<td>
					{!! $row->partner_name !!}
				</td>
				<td>
					{!! $row->phone_number !!}
				</td>
				<td><?php if($row->admin_status == 'rejected'){ ?>
					<span class="label  label-danger" > Rejected</span> <?php if($row->admin_status == 'Rejected'){?>&nbsp<i class="fa fa-question-circle tips" aria-hidden="true" title = "<?php echo isset($row->rejectreason)?>"></i><?php } ?>
					<?php }else if($row->admin_status == 'approved'){ ?>
					<span class="label  label-success"> Approved</span>
					<?php }else if($row->admin_status == 'waiting'){ ?>
					@if(\Auth::user()->group_id=='1')
					<span class="label  label-info"> Waiting for your approval</span>
					@else
					<span class="label  label-info"> Waiting for admin approval</span>
					@endif
					<?php } ?></td>
				<td>
					<!--Tam
					<a href="{{URL::to('restaurant/update/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-success" title="" data-original-title="Edit"><i class="fa fa-edit "></i></a>
                		<a class="cdelete tips btn btn-xs btn-danger" title="Click to delete" data-href="{{URL::to('restaurant/resdelete/'.$row->id.'?return='.$return)}}" data-toggle="modal" data-target="#confirm-delete1"><i class="fa fa-minus-square"></i></a>
                		-->
                		<a href="{{URL::to('restaurant/change_feature/'.$row->id.'/1?return='.$return)}}" class="tips btn btn-xs btn-success" style="background-color: #1ab394" title="" data-original-title="Enable">Enable</a>
				</td>
			</tr>
			@endif
<?php $i++;?>
		@endforeach
</tbody>
</table>--}}
<script>
	//Tam - Non Featured Shops
	var triggeredByChild1 = false;

$('#non_feature_ckbox_all').on('ifChecked', function(event){  	
       $('.non_feature_ckbox').iCheck('check');
       triggeredByChild1 = false;

});
$('#non_feature_ckbox_all').on('ifUnchecked', function(event){  	
        if (!triggeredByChild1) {
      	 $('.non_feature_ckbox').iCheck('uncheck');
   		}	
   		 triggeredByChild1 = false;
});

$('.non_feature_ckbox').on('ifChecked', function (event) {
    if ($('.non_feature_ckbox').filter(':checked').length == $('.non_feature_ckbox').length) {
        $('#non_feature_ckbox_all').iCheck('check');
    }
});
$('.non_feature_ckbox').on('ifUnchecked', function (event) {
	 triggeredByChild1 = true;
          $('#non_feature_ckbox_all').iCheck('uncheck');
 });
</script>
<!--Tam-->

		<!-- if($access['is_add'] ==1)
		<div class="col-lg-17 col-md-3 col-sm-4 col-xs-6">
			<div class="create_restaurant"><a href="{{ URL::to('restaurant/update') }}"> <i class="fa fa-plus-circle" aria-hidden="true"></i><div>{!! trans('core.abs_add_res') !!}</div></a></div>
		</div>
		endif -->
	</div>
	{!! Form::close() !!}
	@include('footer')
	</div>
</div>	
	</div>	  
</div>




<!-- search model start -->

<div class="modal fade" id="neworder_modal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
	<div class="modal-header bg-default">
		
		<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h4 class="modal-title abserve-modal-title">Advance Search</h4>
	</div>
	{{--<div class="modal-body" id="abserve-modal-content"><div>
<form id="ordersSearch">
<table class="table search-table table-striped" id="advance-search">
	<tbody>			
		@if(\Auth::user()->group_id=='1')
		<tr id="time" class="fieldsearch">
			<td>Partner code </td>
			<td> 
			<select id="time_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	
			</select> 
			</td>
			<td id="field_time"><input type="text" name="partner_code" data-name="partner_code" class="date_search form-control input-sm search_pop" value=""> </td>
		
		</tr>												
		
		<tr id="order_id" class="fieldsearch">
			<td>Partner Name </td>
			<td> 
			<select id="order_id_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_order_id">
				<select name="partner_id" data-name="partner_id" class="form-control input-sm search_pop">
					<option value="">Select partner name</option>
				@if(count($tb_users)>0)
					@foreach($tb_users as $Uky=>$Uval)
					<option value="{!!$Uval->id!!}">{!!$Uval->first_name!!}</option>
					@endforeach
				@endif
				</select>
			</td>
		
		</tr>

		<tr id="resraurant_name" class="fieldsearch">
			<td>Shop Name </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="name" data-name="name" class="form-control input-sm search_pop">
					<option value="">Select shop name</option>
				@if(count($restaurants)>0)
					@foreach($restaurants as $Rky=>$Rval)
					<option value="{!!$Rval->id!!}">{!!$Rval->name!!}</option>
					@endforeach
				@endif
				</select>
			</td>
		
		</tr>
		@endif
		<tr id="resraurant_name" class="fieldsearch">
			<td>Status </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="admin_status" data-name="admin_status" class="form-control input-sm search_pop">
					<option value="">Select status</option>
				<option value="waiting">Waiting</option>
				<option value="approved">Approved</option>
				<option value="rejected">Rejected</option>
				</select>
			</td>
		
		</tr>
		<tr id="resraurant_name" class="fieldsearch">
			<td>Mode </td>
			<td> 
			<select id="resraurant_name_operate" class="form-control oper" name="operate" >
				<option value="equal"> = </option>	

			</select> 
			</td>
			<td id="field_resraurant_name">
				<select name="mode" data-name="mode" class="form-control input-sm search_pop">
					<option value="">Select mode</option>
				<option value="open">Open</option>
				<option value="close">Close</option>
				</select>
			</td>
		
		</tr>
		<tr>
			<td class="text-right" colspan="3"><button type="button" name="search"  class="btn btn-sm btn-primary res_search_btn"> Search </button></td>		
		</tr>
	</tbody>     
	</table>
</form>	
</div>


</div>--}}

  </div>
</div>
</div>

<!-- search model end -->

<style type="text/css">
	.flt-number{width:50px;display:inline-block;margin: 0 7px;}
	.bottom_pad{padding-bottom: 15px;}
</style>
<script>


	$(document).on('click','.res_search_btn',function(){
	var search_val,oper,name,search = '';
	var url = window.location.origin + window.location.pathname;
	$('.fieldsearch').each(function(){
		search_val = $(this).find('.search_pop').val();
		oper = $(this).find('.oper').val();
		name = $(this).find('.search_pop').data('name');
		if(search_val != ''){
			search +=  name+':'+oper+':'+search_val+'|';
		}
	});
	window.location.href = url+'?search='+search;
});
$(document).on('keyup','#p_delivery_boy',function(){
	var value=$(this).val();
	var per_km=$("#per_km").val();
	if(value==''){
		value=0;
	}
	if(parseFloat(per_km)>=parseFloat(value)){

			$("#p_admin").val(parseFloat(per_km-value).toFixed(2));

	}else{
		alert('only allowed upto '+per_km+'RM');
			$("#p_delivery_boy").val('');
			$("#p_admin").val('');
	}
})

// $(document).on('keyup','#per_km',function(){
// 	$("#p_delivery_boy").val('');
// 	$("#p_admin").val('');
// })

$(document).on('keyup','#u_delivery_boy',function(){
	var value=$(this).val();
	if(value==''){
		value=0;
	}
	var upto_four_km=$("#upto_four_km").val();
	if(parseFloat(upto_four_km)>=parseFloat(value)){

			$("#u_admin").val(parseFloat(upto_four_km-value).toFixed(2));

	}else{
		alert('only allowed upto '+upto_four_km+'RM');
		$("#u_delivery_boy").val('');
		$("#u_admin").val('');	
	}
})

// $(document).on('keyup','#upto_four_km',function(){
// 	$("#u_delivery_boy").val('');
// 	$("#u_admin").val('');
// })


$(document).on("click",'.cdelete',function(e){
	$('.restaurant_hide_icon_block').removeClass('active');
    $('#confirm-delete1').toggleClass('in').toggle();
    $('#confirm-delete1').find(".btn-ok").attr("href",$(this).data("href"));
});

$(document).on("click",'#confirm-delete1 #cls_popup',function(e){
	$('.restaurant_hide_icon_block').removeClass('active');
    $('#confirm-delete1').toggleClass('in').toggle();
});

$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#AbserveTable').attr('action','{{ URL::to("restaurant/multisearch")}}');
		$('#AbserveTable').submit();
	});
	$('.restaurant_hide_icon').click(function(){
		$('.restaurant_hide_icon_block').removeClass('active');
		$(this).next('.restaurant_hide_icon_block').toggleClass('active');
	});
});	

$("#km").keyup(function(){


	$(".inner_km").html($(this).val());


});
</script>	
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
@stop
