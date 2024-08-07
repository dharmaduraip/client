
@extends('layouts.app')

@section('content')
{{--*/ usort($tableGrid, "SiteHelpers::_sort") /*--}}
<?php $baseCurSymbol = \AbserveHelpers::getBaseCurrencySymbol();?>

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
				<?php $id=1 ?>
				<button type="button" class="tips btn btn-sm btn-white search_pop_btn"><i class="fa fa-search"></i> Search</button>
				<button type="button" class="tips btn btn-sm btn-white product_pop_btn"><i class="fa fa-search" ></i> Product Import</button>
				@if(request()->get('name') != '')

				<a href="{{ Request::url() }}" style="color: inherit;background: white;border: 1px solid #e7eaec;" class="tips btn btn-sm btn-white"><i class="fa fa-minus-circle"></i> Clear</a>
				@endif
			</div>	
	</div>		
		<div class="table-container m-0 px-2 for-icon">
			<!-- Table Grid -->
			{!! Form::open(array('url'=>'fooditems?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
			<table class="table  table-hover " id="{{ $pageModule }}Table">
						<tbody>        		
							<div class="row justify-content-sm-start justify-content-center m-0">
							@foreach ($rowData as $row)
								<div class="box-row">
									<div class="restaurant_block">
										<div class="restaurant_hide_icon">
											<i class="fa fa-circle"></i>
											<i class="fa fa-circle"></i>
											<i class="fa fa-circle"></i>
										</div>
										<div class="restaurant_hide_icon_block" onclick="location.href='{{URL::to('fooditems/resdatas/'.$row->id)}}'" style="cursor: pointer;">
											<a href="{{URL::to('fooditems/resdatas/'.$row->id)}}"  class="previewImage">{!! trans('core.btn_edit') !!}
											</a>
										</div>
										<?php $res_data = $model->getResdetail($row->id);?>
										<div class="image_blk text-center pb-3">
											@if($res_data[0]->logo != '')
											<a class="previewImage" href="{{URL::to('fooditems/resdatas/'.$row->id)}}" target="_blank" >
												<img width="135px" height="160px" src="<?php echo URL::to('').'/uploads/restaurants/'.$res_data[0]->logo?>">
											</a>
											@else
											<a class="previewImage" href="{{URL::to('fooditems/resdatas/'.$row->id)}}" target="_blank" >
												<img src="<?php echo URL::to('uploads/images/no-image.png')?>" width="135px" height="160px">
											</a>
											@endif
										</div>
										<a class="rest_name_link" href="{{ URL::to('fooditems/resdatas/'.$row->id.'?return='.$return)}}">{{$res_data[0]->name}}</a>
										<div class="star_rat d-flex justify-content-between mt-3 mb-1">
											<span>
												<?php $over_all = $rmodel->resrating($row->id);?>
												@for($a = 0; $a < $over_all; $a ++)
												<i class="fa fa-star"></i>
												@endfor
												@for($a = 0; $a < (5-($over_all)); $a++)
												<i class="fa fa-star-o"></i>
												@endfor
												<br>
											</span>
											<span>
												@for($a = 0; $a < isset($row->budget); $a ++)
												<span class="active pull-left">{!! $baseCurSymbol !!}</span>
												@endfor
												@for($a = 0; $a < (4-(isset($row->budget))); $a++)
												<span class="">{!! $baseCurSymbol !!}</span>
												@endfor
											</span>
										</div>
									</div>
								</div>
							@endforeach
							</div>
	          </tbody>
	    </table>
					<input type="hidden" name="action_task" value="" />

					{!! Form::close() !!}


					<!-- End Table Grid -->
	  </div>
</div>

			<div class="modal fade" id="neworder_modal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header bg-default">

							<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title abserve-modal-title">Advance Search</h4>
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

		<div class="modal fade" id="neworder_modal1" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">

					<div class="modal-header bg-default">
						<h4  class="modal-title abserve-modal-title">Product import option</h4>
						<button type="button " class="close" data-dismiss="modal" aria-hidden="true">×</button>
					</div>
					<div class="modal-body" id="abserve-modal-content">
						<form class="form-horizontal" method="POST" action="{{ URL::to('fooditems/importfile') }}" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="form-group" >

								<label class="col-sm-4 float-sm-left" >Shop name</label>
								<select class="form-control col-sm-4" name="res_name" id="res_name" style="width: 300px;">
									<option>Select shop</option>
									@foreach(\AbserveHelpers::approvedrestaurant() as $key=>$value)
									<option value="{!!$value->id!!}">{!!$value->name!!}</option>
									@endforeach
								</select>
							</div>	
							@if(F_IMP_EXP_OPTION=='enable')
							<div class="form-group">
								<label class="col-sm-4 float-sm-left">Upload csv file</label>
								<input accept=".csv" type="file" name="csv_file" class="form-control col-sm-8 " style="width: 200px;">

							</div>
							<div class="form-group">
								{{-- <small>Sample file link -  <a href="{{ URL::to('fooditems') }}" target="_BLANK"><b><i class="fa fa-download"></i></b></a></small> --}}
								<small>Sample file link -  <a href="{{ asset('storage/app/public/products_detail.csv') }}" target="_BLANK"><b><i class="fa fa-download"></i></b></a></small>
							</div>	
							@endif	
							<div class="modal-footer">					
								<button class="btn btn-info float-sm-right" type="submit">Import</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>












		@include('footer')
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

			});	


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

			$('.restaurant_hide_icon').on('click',function(){
				if($(this).siblings('.restaurant_hide_icon_block').hasClass('active')){
					$(this).siblings('.restaurant_hide_icon_block').removeClass('active');
				}
				else{
					$('.restaurant_hide_icon_block').removeClass('active');
					$(this).siblings('.restaurant_hide_icon_block').addClass('active');
				}
			});


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

							$('.loaderOverlay').hide();
							$('#abserve-modal').modal('show');

						});
						if(count == 0){
							$('.loaderOverlay').hide();
							$('#abserve-modal').modal('show');
						}
					}
				});
			});



			$(".product_pop_btn").on('click', function(){ 
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
								$('#neworder_modal1').modal('show');
							}
						});
						if(count == 0){
							$('.loaderOverlay').hide();
							$('#neworder_modal1').modal('show');
						}
					}
				});
			});

		</script>
	<script>

		function SximoRemoveAll(  )
		{	
			var total = $('input[class="ids"]:checkbox:checked').length;
			Swal.fire({
				title: 'Confirm ?',
				text: ' Are u sure deleting this record ? ',
				type: 'warning',
				showCancelButton: true,
				confirmButtonText: 'Yes, please',
				cancelButtonText: 'cancel'
			}).then((result) => {
				if (result.value) {
					$('input[name="action_task"]').val('delete');
			$('#SximoTable').submit();// do the rest here

		}
	})
		}
	</script>
	@stop
