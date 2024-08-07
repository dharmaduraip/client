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
			<a href="{{ URL::to($pageModule) }}" style="display: block ! important;" class="btn btn-xs btn-white tips" title="Clear Search" >
			<i class="fa fa-trash-o"></i> {!! trans('core.abs_clr_search') !!} 
			</a>
			@endif
			<a href="#" class="btn btn-xs btn-white tips" title="" data-original-title=" Configuration">
			<i class="fa fa-cog"></i>
			</a>	 
		</div>
	</div>
	<div class="toolbar-nav" >   
		<div class="row">
			<div class="col-md-8 button-chng my-1"> 	
				@if($access['is_add'] ==1)
				<a href="{{ url('restaurant/create?return='.$return) }}" class="btn  btn-sm"  
				title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create </a>
				@endif
				<div class="btn-group">
					<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>
				</div>
			</div>
		</div>
	</div>
	<div class="p-3">
		<div class="table-container for-icon m-0">

			{!! Form::open(array('url'=>'restaurant?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}

			<table class="table  table-hover " id="{{ $pageModule }}Table">
				<thead>
					<tr>
						<th class="number"> No </th>
						<th> Image</th>
						<th >Name</th>
						<th>Ratings</th>
						<th>Status</th>
						<th>Action</th>

					</tr>
				</thead>

				<tbody>  
					<?php $i= $pagination->currentPage() > 1 ? $pagination->perPage() * ($pagination->currentPage()-1) +1 : 1;?>
					@foreach ($rowData as $row)
					<?php $res_image = explode(',', $row->logo);
					?>      						

					<tr>
						<td class="thead"> {{ $i }} </td>
						<!-- <td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td> -->


						<td>
							@if($row->logo != '')
							<a href="{{URL::to('restaurant/'.$row->id.'/edit?return='.$return)}}" target="_blank" class="previewImage">
								<img width="100px" height="100px" src="<?php echo URL::to('/').'/uploads/restaurants/'.$res_image[0];?>">
							</a>
							@else
							<a href="{{URL::to('restaurant/'.$row->id.'/edit?return='.$return)}}">
								<img width="100px" height="100px" src="<?php echo URL::to('uploads/images/no-image.png')?>">
							</a>
							@endif
						</td>
						<td>{!! $row->name !!}</td>
						<td>

						</td>
						<td>
							<?php if($row->admin_status == 'rejected'){ ?>
							<span class="label  label-danger" > Rejected</span> <?php if($row->admin_status == 'rejected'){?>&nbsp<i class="fa fa-question-circle tips" aria-hidden="true" title = "<?php echo $row->rejectreason ?>"></i><?php } ?>
							<?php }else if($row->admin_status == 'approved'){ ?>
							<span class="label  label-success"> Approved</span>
							<?php }else if($row->admin_status == 'waiting'){ ?>
							@if(\Auth::user()->group_id=='1')
							<span class="label  label-info"> Waiting for your approval</span>
							@else
							<span class="label  label-info"> Waiting for admin approval</span>
							@endif
							<?php } ?>
						</td>

						<td>
							@if($access['is_detail'] ==1)
							<!-- <a href="{{url('restaurant/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a> -->
							@endif
							<a href="{{URL::to('restaurant/category/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-success" title="" data-original-title="Category"><i class="icon-delicious"></i></a>

							{{--<a href="{{URL::to('restaurant/resOffer/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-success" title="" data-original-title="Category"><i class="fa fa-gift"></i></a>--}}


							@if($access['is_edit'] == 1)
							<a  href="{{ url('restaurant/'.$row->id.'/edit?return='.$return) }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
									<!-- @if($access['is_remove'] ==1)
												<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white" title="{{ __('core.btn_remove') }}">
												<i class="fa  fa-remove "></i></a>
												@endif -->
												<a class="tips btn btn-xs btn-success" id="del" title="Click to delete" data-href="{{URL::to('restaurant/resdelete/'.$row->id.'?return='.$return)}}" data-toggle="modal" data-target="#confirm-delete1"><i class="fa fa-minus-square"></i></a>

												@endif
											</td>		 
										</tr>
										<?php $i++;?>
										@endforeach
	      </tbody>
	    </table>
								<input type="hidden" name="action_task" value="" />

								{!! Form::close() !!}


								<!-- End Table Grid -->
	  </div>
	</div>
</div>
					@include('footer')
					<!-- search model start -->
					@include('admin/search')	
					<script>
						$(document).ready(function(){
							$('.copy').click(function() {
								var total = $('input[class="ids"]:checkbox:checked').length;
								if(confirm('are u sure Copy selected rows ?'))
								{
									$('input[name="action_task"]').val('copy');
$('#SximoTable').submit();// do the rest here	
}
})
							$(".search_pop_btn").on('click', function(){ 
								$('.loaderOverlay').show(); 
								$.ajax({
									url:'user/userdatas',
									type: 'post',
									dataType : 'json',
									data: { group_id : '4', type : 'users' },
									success:function(res){
										var count = res.datas.length;
										$('.usernameDatas').html('<option value="">Select</option>');
										$.each(res.datas, function(key,value){
											$('.usernameDatas').append('<option value="'+value.id+'">'+value.username+'</option>');
											if(!--count){
												$('.loaderOverlay').hide();
												$('#abserve-modal').modal('show');
											}
										});
										if(count == 0){
											$('.loaderOverlay').hide();
											$('#abserve-modal').modal('show');
										}
									}
								});
							});
							$(document).on('click','.order_search_btn',function(){
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

						});


					</script>	
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


$(document).on("click",'.tips',function(e){
	$('.restaurant_hide_icon_block').removeClass('active');
    // $('#confirm-delete1').toggleClass('in').toggle();
    // $('#confirm-delete1').find(".btn-ok").attr("href",$(this).data("href"));
});
$(document).on("click",'#del',function(e){
	
	$('#confirm-delete1').toggleClass('in').toggle();
	$('#confirm-delete1').find(".btn-ok").attr("href",$(this).data("href"));
});

$(document).on("click",'#confirm-delete1 .cls_popup',function(e){
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
