@extends('layouts.app')

@section('content')
<div class="page-header">
	<div class=""><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small> </h2></div>
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
			<div class="col-md-9 col-12 button-chng"> 	
				

				<div class="toolbar-line ">
	    	<form action="{{ route('innaugral') }}" method="POST">
			    	<div class="d-flex flex-wrap justify-content-between">
					    @if(\Auth::user()->group_id!=6)
						<div class="">
							@if($access['is_add'] ==1)
					   		<a href="{{ url('promocode/create?return='.$return) }}" class="tips btn btn-sm btn-white"  title="{!! Lang::get('core.btn_create') !!}">
							<i class="fa fa-plus-circle "></i>&nbsp;{!! Lang::get('core.btn_create') !!}</a>
							@endif  
							@if($access['is_remove'] ==1)
							<a href="javascript://ajax"  onclick="SximoDelete();" class="tips btn btn-sm btn-white" title="{!! Lang::get('core.btn_remove') !!}">
							<i class="fa fa-minus-circle "></i>&nbsp;{!! Lang::get('core.btn_remove') !!}</a>
							@endif 
						</div>
						
						<!-- <div class="d-flex flex-wrap">
							<div class="my-auto mr-3">
							    <h3 style="font-size: 16px;">Innaugral Offer Limit</h3>
						    </div>
							<div class="">
								<input type="text" readonly autocomplete="off" name="searchDate" id="searchDate" value="" class="form-control" placeholder="Offer Date">
								<input type="hidden" name="sdate" id="sdate" value="{!! $innaugral->neworder_from !!}">
								<input type="hidden" name="edate" id="edate" value="{!! $innaugral->neworder_to !!}">
							</div>
							<div class="ml-2"><button class="btn btn-success" type="submit" > Save</button></div>
						</div> -->
						<!-- <div class="">

							<a class="btn btn-success" href="{!! \URL::to('offersetting/1/edit') !!}">Cash back offer settings</a>
						</div> -->
						@endif
			    	</div>
		    	</form>
			</div> 		



				
			</div>
			
		</div>	

	</div>	
	<div class="p-3">
		<div class="table-container for-icon m-0">

				<!-- Table Grid -->
				
	 			{!! Form::open(array('url'=>'promocode/store?'.$return, 'class'=>'form-horizontal m-t' ,'id' =>'SximoTable' )) !!}
				
			    <table class="table  table-hover " id="{{ $pageModule }}Table">
			        <thead>
						<tr>
							<th style="width: 3% !important;" class="number"> No </th>
							<th  style="width: 3% !important;"> <input type="checkbox" class="checkall minimal-green" /></th>
							
							
							@foreach ($tableGrid as $t)
								@if($t['view'] =='1')				
									<?php $limited = isset($t['limited']) ? $t['limited'] :''; 
									if(SiteHelpers::filterColumn($limited ))
									{
										$addClass='class="tbl-sorting" ';
										if($insort ==$t['field'])
										{
											$dir_order = ($inorder =='desc' ? 'sort-desc' : 'sort-asc'); 
											$addClass='class="tbl-sorting '.$dir_order.'" ';
										}
										echo '<th align="'.$t['align'].'" '.$addClass.' width="'.$t['width'].'">'.\SiteHelpers::activeLang($t['label'],(isset($t['language'])? $t['language'] : array())).'</th>';				
									} 
									?>
								@endif
							@endforeach
							<th  style="width: 10% !important;">{{ __('core.btn_action') }}</th>
							
						  </tr>
			        </thead>

			        <tbody>        						
			            @foreach ($rowData as $row)
			                <tr>
								<td class="thead"> {{ ++$i }} </td>
								<td class="tcheckbox"><input type="checkbox" class="ids minimal-green" name="ids[]" value="{{ $row->id }}" />  </td>
																				
							 @foreach ($tableGrid as $field)
							

								 @if($field['view'] =='1')
								 	<?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
								 	@if(SiteHelpers::filterColumn($limited ))

						  @if($field['field'] == 'user_id')
							<td>

								

								<!-- {{$row->user_id}} -->
									@if($row->user_id == 0)
										All Users
									@else
										{!! \AbserveHelpers::getuname($row->user_id) !!}
									@endif
								
							</td>
							

							@else



								 	 <?php $addClass= ($insort ==$field['field'] ? 'class="tbl-sorting-active" ' : ''); ?>
									 <td align="{{ $field['align'] }}" width=" {{ $field['width'] }}"  {!! $addClass !!} >					 
									 	{!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}						 
									 </td>

							@endif	 
									@endif
	                        

								 @endif					 
							 @endforeach	
							<!--  <td>

								 	<div class="dropdown">
									  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> {{ __('core.btn_action') }} </button>
									  <ul class="dropdown-menu">
									 	@if($access['is_detail'] ==1)
										<li class="nav-item"><a href="{{ url('promocode/'.$row->id.'?return='.$return)}}" class="nav-link tips" title="{{ __('core.btn_view') }}"> {{ __('core.btn_view') }} </a></li>
										@endif
										@if($access['is_edit'] ==1)
										<li class="nav-item"><a  href="{{ url('promocode/'.$row->id.'/edit?return='.$return) }}" class="nav-link  tips" title="{{ __('core.btn_edit') }}"> {{ __('core.btn_edit') }} </a></li>
										@endif
										<div class="dropdown-divider"></div>
										@if($access['is_remove'] ==1)
											<li class="nav-item"><a href="javascript://ajax"  onclick="SximoDelete();" class="nav-link  tips" title="{{ __('core.btn_remove') }}">
											Remove Selected </a></li>
										@endif 
									  </ul>
									</div>

								</td>	 -->

								 <td>
						 	@if($access['is_detail'] ==1)
							<a href="{{ url('promocode/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-primary" title="{!! Lang::get('core.btn_view') !!}"><i class="fa  fa-search "></i></a>
							@endif
							@if($access['is_edit'] ==1 && \Auth::user()->group_id!=6)
								<?php $date= date('Y-m-d'); ?>
							@if($row->end_date >= $date)
							<a  href="{{ URL::to('promocode/'.$row->id.'/edit?return='.$return) }}" class="tips btn btn-xs btn-success" title="{!! Lang::get('core.btn_edit') !!}"><i class="fa fa-edit "></i></a>
							@endif
							@endif
													
						
					</td>				 
			                </tr>
							
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

<style>
.switch-left{display: none;}
.switch-right{display: none;}
.switch {
  position: relative;
  display: inline-block;
  width: 90px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ca2222;
  -webkit-transition: .4s;
  transition: .4s;
   border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2ab934;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(55px);
}

/*------ ADDED CSS ---------*/
.slider:after
{
 content:'OFF';
 color: white;
 display: block;
 position: absolute;
 transform: translate(-50%,-50%);
 top: 50%;
 left: 50%;
 font-size: 10px;
 font-family: Verdana, sans-serif;
}

input:checked + .slider:after
{  
  content:'ON';
}

/*--------- END --------*/

.onoffswitch4 {
    position: relative; width: 90px;
    -webkit-user-select:none; -moz-user-select:none; -ms-user-select: none;
}

.onoffswitch4-checkbox {
    display: none;
}

.onoffswitch4-label {
    display: block; overflow: hidden; cursor: pointer;
    border: 2px solid #27A1CA; border-radius: 0px;
}

.onoffswitch4-inner {
    display: block; width: 200%; margin-left: -100%;
    -moz-transition: margin 0.3s ease-in 0s; -webkit-transition: margin 0.3s ease-in 0s;
    -o-transition: margin 0.3s ease-in 0s; transition: margin 0.3s ease-in 0s;
}

.onoffswitch4-inner:before, .onoffswitch4-inner:after {
    display: block; float: left; width: 50%; height: 30px; padding: 0; line-height: 26px;
    font-size: 14px; color: white; font-family: Trebuchet, Arial, sans-serif; font-weight: bold;
    -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
    border: 2px solid transparent;
    background-clip: padding-box;
}

.onoffswitch4-inner:before {
    content: "Yes";
    padding-left: 10px;
    background-color: #FFFFFF; color: #27A1CA;
}

.onoffswitch4-inner:after {
    content: "No";
    padding-right: 10px;
    background-color: #FFFFFF; color: #666666;
    text-align: right;
}

.onoffswitch4-switch {
    display: block; width: 25px; margin: 0px;
    background: #27A1CA;
    position: absolute; top: 0; bottom: 0; right: 65px;
    -moz-transition: all 0.3s ease-in 0s; -webkit-transition: all 0.3s ease-in 0s;
    -o-transition: all 0.3s ease-in 0s; transition: all 0.3s ease-in 0s; 
}

.onoffswitch4-checkbox:checked + .onoffswitch4-label .onoffswitch4-inner {
    margin-left: 0;
}

.onoffswitch4-checkbox:checked + .onoffswitch4-label .onoffswitch4-switch {
    right: 0px; 
}
</style>
<link rel="stylesheet" type="text/css" media="all" href="{{ asset('sximo5/css/admin/daterangepicker/daterangepicker.css') }}" />
<script type="text/javascript" src="{{ asset('sximo5//js/admin/daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('sximo5/js/admin/daterangepicker/daterangepicker.js') }}"></script>
<script>
$(document).on('click','.switch',function() {
	if($('#togBtn').prop("checked") == true){
       $('#togBtn').prop('checked',false);
       $(".loaderOverlay").show();
       $.ajax({
                url : base_url+"promocode/changemode",
                type: 'post',
                data : {mode : "off"},
                dataType : 'json',
                success : function(res){
                	$(".loaderOverlay").hide();
                }
            });
       return false;
    }else{
       $('#togBtn').prop('checked',true);
       $(".loaderOverlay").show();
        $.ajax({
                url : base_url+"promocode/changemode",
                type: 'post',
                data : {mode : "on"},
                dataType : 'json',
                success : function(res){
                	$(".loaderOverlay").hide();
                }
            });
        return false;
    }
})
$(document).ready(function(){

	$('.do-quick-search').click(function(){
		$('#AbserveTable').attr('action','{{ URL::to("promocode/multisearch")}}');
		$('#AbserveTable').submit();
	});
	
	$('#searchDate').daterangepicker({
		"autoApply": true,	    
		"showCustomRangeLabel": true,	    	    
		// "maxDate": new Date(),
		"locale": {
			"format": 'Y-MM-DD'
		}
		}, function(start, end, label) {	  
			var start_date = $.datepicker.formatDate('yy-mm-dd', start._d);  	  
			var end_date = $.datepicker.formatDate('yy-mm-dd', end._d);  	  	  	  	  
			$('#sdate').val(start_date);
			$('#edate').val(end_date);     
		});	

		var sDate = $('#sdate').val();
		var eDate = $('#edate').val();     

		if(sDate != '' && eDate != ''){		
			$('#searchDate').data('daterangepicker').setStartDate(sDate);
			$('#searchDate').data('daterangepicker').setEndDate(eDate);
		}else{
			$('#searchDate').val('');
		}	

});
</script>		
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
</script>	
	
@stop
