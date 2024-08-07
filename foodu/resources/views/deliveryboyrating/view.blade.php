@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2></div>

<!---<div class="toolbar-nav">
	<div class="row">
		<div class="col-md-6 ">
			@if($access['is_add'] ==1)
	   		<a href="{{ url('deliveryboyrating/'.$id.'/edit?return='.$return) }}" class="tips btn btn-default btn-sm  " title="{{ __('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif
			<a href="{{ url('deliveryboyrating?return='.$return) }}" class="tips btn btn-default  btn-sm  " title="{{ __('core.btn_back') }}"><i class="fa  fa-times"></i></a>		
		</div>
		<div class="col-md-6 text-right">			
	   		<a href="{{ ($prevnext['prev'] != '' ? url('deliveryboyrating/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-default  btn-sm"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('deliveryboyrating/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-default btn-sm "> <i class="fa fa-arrow-right"></i>  </a>					
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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cust Id', (isset($fields['cust_id']['language'])? $fields['cust_id']['language'] : array())) }}</td>
						<td>{{ $row->cust_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Res Id', (isset($fields['res_id']['language'])? $fields['res_id']['language'] : array())) }}</td>
						<td>{{ $row->res_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Orderid', (isset($fields['orderid']['language'])? $fields['orderid']['language'] : array())) }}</td>
						<td>{{ $row->orderid}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Boy Id', (isset($fields['boy_id']['language'])? $fields['boy_id']['language'] : array())) }}</td>
						<td>{{ $row->boy_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Rating', (isset($fields['rating']['language'])? $fields['rating']['language'] : array())) }}</td>
						<td>{{ $row->rating}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Comments', (isset($fields['comments']['language'])? $fields['comments']['language'] : array())) }}</td>
						<td>{{ $row->comments}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Entry By', (isset($fields['entry_by']['language'])? $fields['entry_by']['language'] : array())) }}</td>
						<td>{{ $row->entry_by}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 	

	</div>

</div>  --->


<div class="m-3 box-border">
	<div class="sbox-title"> 
		<h4> 
			<i class="fa fa-table text-light"></i> 
		</h4>
		<div class="sbox-tools">
		@if($access['is_add'] ==1)
	   		<a href="{{ url('deliveryboyrating/'.$id.'/edit?return='.$return) }}" class="tips btn btn-default btn-sm  " title="{{ __('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif
			<a href="{{ url('deliveryboyrating?return='.$return) }}" class="tips btn btn-default  btn-sm  " title="{{ __('core.btn_back') }}"><i class="fa  fa-times"></i></a>
			
			<a href="{{ ($prevnext['prev'] != '' ? url('deliveryboyrating/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-default  btn-sm"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('deliveryboyrating/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-default btn-sm "> <i class="fa fa-arrow-right"></i>  </a>				
			
	    </div>
	</div>
<div class="row m-0">
	<div class="col-md-12 p-0">
		<fieldset><!--<legend> Restaurants</legend>-->
			<div class="row fieldset_border">	
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
					<fieldset>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Id', (isset($fields['id']['language'])? $fields['id']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->id}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Cust Id', (isset($fields['cust_id']['language'])? $fields['cust_id']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->cust_id}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Shop Name', (isset($fields['res_id']['language'])? $fields['res_id']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->res_id}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Order id', (isset($fields['orderid']['language'])? $fields['orderid']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->orderid}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Boy Id', (isset($fields['boy_id']['language'])? $fields['boy_id']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->boy_id}} </label>
							</div> 
							<div class=""></div>
						</div> 
					</fieldset>
					</div>			
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
						<fieldset>
						
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
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Entry By', (isset($fields['entry_by']['language'])? $fields['entry_by']['language'] : array())) }}
							<label for="Name" class=" control-label">{{ $row->entry_by}}  </label>
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
