@extends('layouts.app')

@section('content')
<div class="page-header"><div class=""><h2> Offer Page <small> Offer detail </small> </h2></div>
<div class="">
  <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ URL::to('dashboard') }}"> Dashboard </a></li>
        <li class="breadcrumb-item active">Offer Page</li>
      </ul>	  
</div>
</div>
<div class="m-sm-4 m-3 box-border">
	<div class="sbox-title"> 
		<h5> <i class="fa fa-table"></i> </h5>
		<div class="sbox-tools">
			<a href="#" class="btn btn-xs btn-white tips" title="" data-original-title=" Configuration">
			<i class="fa fa-cog"></i>
			</a>	 
		</div>
	</div>
	<div class="toolbar-nav" >   
		<div class="row">
			<div class="col-md-8 button-chng my-1"> 	
				<a href="{{\URL::to('restaurantoffer/create/'.$res_id)}}" class="btn  btn-sm"  
					title="{{ __('core.btn_create') }}"><i class=" fa fa-plus "></i> Create  </a>
					@php $i =0; @endphp
			</div>
		</div>	
	</div>
	<div class="p-3">		
		<div class="table-container for-icon m-0">

					<!-- Table Grid -->
					
		 			{!! Form::open(array('url'=>'', 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
					
				    <table class="table  table-hover " id="Table">
				        <thead>
							<tr>
								<th style="width: 3% !important;" class="number"> No </th>
								<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
								<th>Offer Name</th>
								<th>Offer Description</th>
								<th>Start Date</th>
								<th>End date</th>
								<th>Offer Type</th>
								<th>Offer Mode</th>
								<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
							  </tr>
				        </thead>

				        <tbody>
				        	@foreach($res_off as $off)
				                <tr>
									<td class="thead"> {{++$i}} </td>
									<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="" />  </td>
									<td>{{$off->promo_name}}</td>
									<td>{{$off->promo_desc}}</td>
									<td>{{$off->start_date}}</td>
									<td>{{$off->end_date}}</td>
									<td>{{$off->promo_type}}</td>
									<td>{{$off->promo_mode}}</td>
								<td>
									{{--<a href="" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>--}}
									<a  href="{{\URL::to('restaurantoffer/edit/'.$off->id)}}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
								</td>														
				                </tr>
				            @endforeach
				        </tbody>
				    </table>
					{!! Form::close() !!}
		</div>
	</div>
</div>	
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

@stop
