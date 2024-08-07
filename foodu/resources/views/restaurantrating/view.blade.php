@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2></div>

<!---<div class="toolbar-nav">
	<div class="row">
		<div class="col-md-6 ">
			@if($access['is_add'] ==1)
	   		<a href="{{ url('restaurantrating/'.$id.'/edit?return='.$return) }}" class="tips btn btn-default btn-sm  " title="{{ __('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif
			<a href="{{ url('restaurantrating?return='.$return) }}" class="tips btn btn-default  btn-sm  " title="{{ __('core.btn_back') }}"><i class="fa  fa-times"></i></a>		
		</div>
		<div class="col-md-6 text-right">			
	   		<a href="{{ ($prevnext['prev'] != '' ? url('restaurantrating/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-default  btn-sm"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('restaurantrating/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-default btn-sm "> <i class="fa fa-arrow-right"></i>  </a>					
		</div>	

		
		
	</div>
</div> 
<div class="p-5">		

	<div class="table-responsive">
		<table class="table table-striped table-bordered " >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Id', (isset($fields['id']['language'])? $fields['id']['language'] : array())) }}</td>
						<td>{{ $row->id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Customer Name', (isset($fields['cust_id']['language'])? $fields['cust_id']['language'] : array())) }}</td>
						<td>{{ $row->cust_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Shop Name', (isset($fields['res_id']['language'])? $fields['res_id']['language'] : array())) }}</td>
						<td>{{ $row->res_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order id', (isset($fields['orderid']['language'])? $fields['orderid']['language'] : array())) }}</td>
						<td>{{ $row->orderid}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Rating', (isset($fields['rating']['language'])? $fields['rating']['language'] : array())) }}</td>
						<td>{{ $row->rating}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Comments', (isset($fields['comments']['language'])? $fields['comments']['language'] : array())) }}</td>
						<td>{{ $row->comments}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 	

	</div>

</div>   ---->
<div class="m-3 box-border">
	<div class="sbox-title"> 
		<h4> 
			<i class="fa fa-table text-light"></i> 
		</h4>
		<div class="sbox-tools">
		@if($access['is_add'] ==1)
	   		<a href="{{ url('restaurantrating/'.$id.'/edit?return='.$return) }}" class="tips btn btn-default btn-sm  " title="{{ __('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif
			<a href="{{ url('restaurantrating?return='.$return) }}" class="tips btn btn-default  btn-sm  " title="{{ __('core.btn_back') }}"><i class="fa  fa-times"></i></a>
			
			<a href="{{ ($prevnext['prev'] != '' ? url('restaurantrating/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-default  btn-sm"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('restaurantrating/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-default btn-sm "> <i class="fa fa-arrow-right"></i>  </a>					
			
	    </div>
	</div>
<div class="row m-0">
	<div class="col-md-12 p-0">
		<fieldset><!--<legend> Restaurants</legend>-->
			<div class="row fieldset_border">	
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
					<fieldset>
						<div class="form-group row" >
							<?php $res_name = \AbserveHelpers::restsurent_name($row->res_id);
								  $user_name = \AbserveHelpers::getuname($row->cust_id); ?>
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Id', (isset($fields['id']['language'])? $fields['id']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->id}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Customer Name', (isset($fields['cust_id']['language'])? $fields['cust_id']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $user_name}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Shop Name', (isset($fields['res_id']['language'])? $fields['res_id']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $res_name}} </label>
							</div> 
							<div class=""></div>
						</div>
						
					</fieldset>
					</div>			
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
						<fieldset>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Order id', (isset($fields['orderid']['language'])? $fields['orderid']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->orderid}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Rating', (isset($fields['rating']['language'])? $fields['rating']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->rating}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Comments', (isset($fields['comments']['language'])? $fields['comments']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label">{{ $row->comments}}  </label>
							</div> 
							<div class=""></div>
						</div> 
					</fieldset>
				</div>
			</div>
		</fieldset>
	</div>
</div>
@stop
