@extends('layouts.app')
@section('content')

<div class="page-header justify-content-between">
	<div class="page-title">
		<h3> {{ $restaurant->name }} <small><!-- {{ $pageTitle }} --></small></h3>
	</div>
	<ul class="breadcrumb bg-trans m-0 p-0">
		<li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
		<li class="breadcrumb-item"><a href="{{ URL::to('fooditems') }}">{{ 'Shops Products' }}</a></li>
		<li class="breadcrumb-item active" >{{ $restaurant->name }}</li>
	</ul>
</div>
<div class="edit-fooditem">
	<div class="page-content-wrapper m-0 p-3">
		<div class="sbox animated fadeInRight">
			<div class="sbox-content">
				<div class="title button-chng">
					<div class="white_bg p-2 mb-3">
						<!-- <a class="btn-lightgrey mb-2" href="{{URL::to('fooditems/'.$restaurant->id.'/edit')}}">Add Product</a> -->
						<a class="btn-lightgrey mb-2" href="{{URL::to('fooditems/create')}}">Add Product</a>
						@if(\Auth::user()->group_id == 1)
						<a class="pull-right btn-lightgrey mb-2" href="{{URL::to('foodcategories/create')}}">Add Product Categories</a>
						@endif
						<a href="javascript://ajax"  onclick="deleteperfunc();" class="btn  btn-sm" title="{{ __('core.btn_remove') }}"><i class=" fa fa-minus-circle "></i>
						Remove  </a>
						<!-- <button type="button" id="import" class="tips btn btn-sm btn-white" data-toggle="modal" data-target="#food_import"><i class="fa fa-download"></i> Product Import</button> -->
						@if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)
						<a href="javascript://ajax"  onclick="SximoRemoveAll();" 
						style="color: inherit;background: white;border: 1px solid #e7eaec;" class="tips btn btn-sm btn-white">
						<i class="fa fa-minus-circle "></i>&nbsp;Remove All</a>
						@endif
						<button type="button" class="tips btn btn-sm btn-white" data-toggle="modal" id="searchpopup" data-target="#neworder_modal"><i class="fa fa-search"></i> Search</button>
						@if(request()->get('name') != '')
						<a href="{{ Request::url() }}" style="color: inherit;background: white;border: 1px solid #e7eaec;" class="tips btn btn-sm btn-white"><i class="fa fa-minus-circle"></i> Clear</a>
						@endif
						<div>
							<button class="btn btn-success download_excel" > Download</button>
							<input type="hidden" name="res_id" id="res_id" value="{{ $restaurant->id }}" />
						</div>
						@if(\Auth::user()->group_id == 1)
						{{-- <button type="button" class="tips btn btn-sm btn-white" data-toggle="modal" data-target="#csv_image_upload"><i class="fa fa-download"></i> Product image upload</button> --}}
						@endif
					</div>
					<h3 class="text-left page_title d-inline-block border-tap bg-lightgrey py-1 px-4 m-0"><strong>{{$restaurant->name}}</strong></h3>
				</div>
				<div class="sbox animated fadeInRight for-theader">
					@if(!empty($allItems))
					<div class="sbox-content">
						{!! Form::open(array('url'=>'misreport/delete/', 'class'=>'form-horizontal' ,'id' =>'AbserveTable' )) !!}
						<div class="table-responsive for-icon border-tap bg-light p-3" style="min-height:300px;">
							<table class="table table-striped border-tap">
								<thead>
									<tr>
										<th class="number"> Sl.no </th>
										<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
										<th>Image</th>
										<th>Name</th>
										<th>Price (MRP)</th>
										@if(\Auth::user()->group_id == 1)
										{{--<th>Base Price</th>--}}
										{{--<th>Hiking (%)</th>--}}
										<th>Selling Price</th>
										@endif
										<th>GST (%)</th>
										<th>Stock Status</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$from_cnt	= ($page*$perPage)-$perPage;
									$i=$from_cnt;?>
									@foreach($allItems as $ritems)
									<tr>
										<td> {{ ++$i }} </td>
										<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $ritems->id_item }}" />  </td>
										<td>
											<?php //print_r($ritems);exit();?>
											@if($ritems->image != '' && count(explode(",", $ritems->image)) > 0)
											@foreach(explode(",", $ritems->image) as $img)
											{!! \AbserveHelpers::showUploadedFile($img,'/storage/app/public/restaurant/'.$ritems->restaurant_id.'/','50') !!}
											@endforeach
											@endif
										</td>
										<td> {!! $ritems->food_item !!} </td>
										<td> {!! $currencySymbol .' '. $ritems->price !!} </td>
										@if(\Auth::user()->group_id == 1)
										{{--<td> {!! $currencySymbol .' '. $ritems->original_price !!}</td>--}}
										{{--<td> {!! $ritems->hiking !!}</td>--}}
										<td> {!! $currencySymbol .' '. $ritems->selling_price !!}</td>
										@endif
										<td> {!! $ritems->foodGST !!} </td>
										<td>@if($ritems->item_status == '1'){!! 'Instock' !!}@else{!! 'Out of Stock' !!}@endif</td>	
										<td> {!! $ritems->approveStatus !!} </td>	
										<td>
											<a href="{!! \URL::to('fooditems/'.$ritems->id_item.'/edit?page='.Request::input('page')) !!}" class="tips btn btn-xs btn-success" title="" data-original-title="Edit"><i class="fa fa-edit "></i></a>
											<a class="cdelete tips btn btn-xs btn-danger" title="Click to delete" data-href="{!! \URL::to('fooditems/fooddelete/'.$ritems->id_item.'/'.$ritems->restaurant_id) !!}" data-toggle="modal" data-target="#confirm-delete1"><i class="fa fa-minus-square"></i></a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							<input type="hidden" name="md" value="" />
						</div>
						<div class="search_pagination col-xs-12 text-center">
							<div class="col-md-12 d-flex justify-content-center"> 
								{!! $allItems->appends($_REQUEST)->render() !!}
							</div>
						</div>
						<div class="col-md-6"> 
							<span>
								{{!!
								$from_cnt	= ($page*$perPage)-$perPage+1;
								$to_cnt		= ($from_cnt+count($allItems))-1;
								!!}}
							{!! $from_cnt !!} - {!! $to_cnt !!}   Product Items</span>
						</div>
						{!! Form::close() !!}
					</div>
					@else
					<div class="restaurant-items-title">No Items Found </div>
					@endif
				</div>
			</div>
		</div>
	</div>
	{!! Form::open(array('url' =>'fooditems/remove' ,'class'=>'form-horizontal','id'=>'SximoRemove' )) !!}
	<input type="hidden" name="res_id" id="res_id" value="{{ $restaurant->id }}" />
	{!! Form::close() !!}
	<!-- import model start -->
	<div class="modal" id="food_import" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-default">
					<h4 class="modal-title abserve-modal-title">Product import option</h4>
					<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body" id="abserve-modal-content">
					<form class="form-horizontal" method="POST" action="{{ URL::to('/fooditems/importfile') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="col-sm-4">Shop name</label>
							<select class="form-control col-sm-6" name="res_name" id="res_name" style="width: 200px;">
								<option>Select shop</option>
								@foreach(\AbserveHelpers::approvedrestaurant() as $key=>$value)
								<option value="{!!$value->id!!}">{!!$value->name!!}</option>
								@endforeach
							</select>
						</div>	
						@if(F_IMP_EXP_OPTION=='enable')
						<div class="form-group">
							<label class="col-sm-4">Upload csv file</label>
							<input accept=".csv" type="file" name="csv_file" class="form-control col-sm-8" style="width: 200px;">

						</div>
						<div class="form-group">
							<small>Sample file link -  <a href="{{ URL::to('fooditems/masterexcel') }}" target="_BLANK"><b><i class="fa fa-download"></i></b></a></small>
						</div>	
						@endif	
						<div class="modal-footer">					
							<button class="btn btn-success" type="submit">Import</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="csv_image_upload" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-default">
					<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title abserve-modal-title">Product import option</h4>
				</div>
				<div class="modal-body" id="abserve-modal-content">
					<form class="form-horizontal" method="POST" action="{{ URL::to('/fooditems/importimages') }}" enctype="multipart/form-data">
						{{ csrf_field() }}
						<div class="form-group">
							<label class="col-sm-4">Image</label>
							<input  type='file' name='image[]' id='image' multiple="" style='width:150px !important;'  />
						</div>	
						<div class="modal-footer">					
							<button class="btn btn-success" type="submit">Import</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal" id="neworder_modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header bg-default">

					<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title">Advance Search</h4>
				</div>
				<div class="modal-body" id="abserve-modal-content">
					<form id="ordersSearch">
						<table class="table search-table table-striped" id="advance-search">
							<tbody>
								<tr id="order_id" class="fieldsearch">
									<td>Name</td>
									<td> 
										<input type="text" class="form-control search_pop" id="food_name" required="true" name="name" style="border:1px solid black;" autocomplete="off">
									</td>
								</tr>
								<tr>
									<td class="text-right" colspan="3">
										<button type="button" name="search"  class="btn btn-sm btn-primary" id="search"> Search </button>
									</td>
								</tr>
							</tbody>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- import model end -->
<div class="back_layout" style="display: none;"></div>
<script type="text/javascript">
	var base_url    = "<?php echo URL::to('/').'/'; ?>";
	$(document).on("click",'.cdelete',function(e){
		$('.restaurant_hide_icon_block').removeClass('active');
		$('#confirm-delete1').toggleClass('in').toggle();
		$('#confirm-delete1').find(".btn-ok").attr("href",$(this).data("href"));
	});
	$(document).on("click",'#confirm-delete1 #cls_popup',function(e){
		$('#confirm-delete1').find(".btn-ok").removeAttr("href");
		$('.restaurant_hide_icon_block').removeClass('active');
		$('#confirm-delete1').toggleClass('in').toggle();
	});
	$(document).on("click",'#import',function(e){
		$('#food_import').modal('show');

	});
	$(document).on('click','#search',function(){
		var search_val	= $('#food_name').val();
		var url		= window.location.origin + window.location.pathname;
		window.location.href = url+'?name='+search_val;
	});
	$(document).on('click','#searchpopup',function(){
		$('#neworder_modal').modal('show');
	});
	$(document).on('click','.download_excel',function(){

		$(".loader_event").show();
		var id = document.getElementById('res_id').value;
		$.ajax({
			type:'POST',
			url:<?php url(); ?>"fooditems/phpexcelproduct",
			dataType: 'json',
			data:{id: id},
			success:function(data){
				window.location="{!! url('/') !!}/resources/views/phpexcel/file/products_det.csv";
				$(".loader_event").hide();             
			}
		});

	})
	function SximoRemoveAll()
	{
		if(confirm('Are u sure removing all rows ? '))
		{
			$('#SximoRemove').submit();
		}
	}
	function deleteperfunc(){
		var getid = '';
		$('.ids').each(function(){
			if($(this).is(':checked')) {   
				getid += $(this).val()+',';
			}
		}); 
		if(getid != ''){
			if(confirm('Are u sure removing selected rows ?'))
			{
				$.ajax({
					url: base_url+'fooditems/removeselected',
					type: 'get',
					data: { getid: getid },
					success:function(res){
						location.reload();
					}
				})
			}	
		}
	}	
	$(document).on('click','.cls_popup',function(){
		$("#confirm-delete1").hide();
	});
</script>
@stop