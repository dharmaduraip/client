@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2></div>

<!---<div class="toolbar-nav">
	<div class="row">
		<div class="col-md-6 ">
			@if($access['is_add'] ==1)
	   		<a href="{{ url('partnerrequest/'.$id.'/edit?return='.$return) }}" class="tips btn btn-default btn-sm  " title="{{ __('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif
			<a href="{{ url('partnerrequest?return='.$return) }}" class="tips btn btn-default  btn-sm  " title="{{ __('core.btn_back') }}"><i class="fa  fa-times"></i></a>		
		</div>
		<div class="col-md-6 text-right">			
	   		<a href="{{ ($prevnext['prev'] != '' ? url('partnerrequest/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-default  btn-sm"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('partnerrequest/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-default btn-sm "> <i class="fa fa-arrow-right"></i>  </a>					
		</div>	

		
		
	</div>
</div> --->
<div class="m-3 box-border">
	<div class="sbox-title"> 
		<h4> 
			<i class="fa fa-table text-light"></i> 
		</h4>
		<div class="sbox-tools">
		@if($access['is_add'] ==1)
			<!-- <a href="{{ url('partnerrequest/'.$id.'/edit?return='.$return) }}" class="tips btn btn-default btn-sm  " title="{{ __('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a> -->
			@endif
			<a href="{{ url('partnerrequest?return='.$return) }}" class="tips btn btn-default  btn-sm  " title="{{ __('core.btn_back') }}"><i class="fa  fa-times"></i></a>

			<!-- <a href="{{ ($prevnext['prev'] != '' ? url('partnerrequest/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-default  btn-sm"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('partnerrequest/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-default btn-sm "> <i class="fa fa-arrow-right"></i>  </a> -->					
			
	    </div>
	</div>
<div class="row m-0">
	<div class="col-md-12 p-0">
		<fieldset><!--<legend> Restaurants</legend>-->
			<div class="row fieldset_border">	
				<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
					<fieldset>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Id', (isset($fields['id']['language'])? $fields['id']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->id}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Name', (isset($fields['name']['language'])? $fields['name']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->name}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Address', (isset($fields['address']['language'])? $fields['address']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->address}} </label>
							</div> 
							<div class=""></div>
						</div><div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Email', (isset($fields['email']['language'])? $fields['email']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->email}} </label>
							</div> 
							<div class=""></div>
						</div><div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Shop Name', (isset($fields['shop_name']['language'])? $fields['shop_name']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->shop_name}} </label>
							</div> 
							<div class=""></div>
						</div><div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Contact Number', (isset($fields['contact_number']['language'])? $fields['contact_number']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->contact_number}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Category', (isset($fields['category']['language'])? $fields['category']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->category}} </label>
							</div> 
							<div class=""></div>
						</div> 
					</fieldset>
					</div>			
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
						<fieldset>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Created At', (isset($fields['created_at']['language'])? $fields['created_at']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->created_at}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Updated At', (isset($fields['updated_at']['language'])? $fields['updated_at']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->updated_at}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Is Accept', (isset($fields['is_accept']['language'])? $fields['is_accept']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<?php
							$status = $row->is_accept == 0 ? 'Waiting' : ($row->is_accept == 1 ? 'Accepted' : ($row->is_accept == 2 ? 'Rejected' : ''));
						?>
							<label for="Name" class=" control-label"> {{ $status}} </label>
							</div> 
							<div class=""></div>
						</div> 
					</fieldset>
				</div>
			</div>
		</fieldset>
	</div>
</div>



<!----<div class="p-5">		

	<div class="table-responsive">
		<table class="table table-striped table-bordered " >
			<tbody>	
		
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Id', (isset($fields['id']['language'])? $fields['id']['language'] : array())) }}</td>
						<td>{{ $row->id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Name', (isset($fields['name']['language'])? $fields['name']['language'] : array())) }}</td>
						<td>{{ $row->name}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Address', (isset($fields['address']['language'])? $fields['address']['language'] : array())) }}</td>
						<td>{{ $row->address}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Email', (isset($fields['email']['language'])? $fields['email']['language'] : array())) }}</td>
						<td>{{ $row->email}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Shop Name', (isset($fields['shop_name']['language'])? $fields['shop_name']['language'] : array())) }}</td>
						<td>{{ $row->shop_name}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Contact Number', (isset($fields['contact_number']['language'])? $fields['contact_number']['language'] : array())) }}</td>
						<td>{{ $row->contact_number}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Category', (isset($fields['category']['language'])? $fields['category']['language'] : array())) }}</td>
						<td>{{ $row->category}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Message', (isset($fields['message']['language'])? $fields['message']['language'] : array())) }}</td>
						<td>{{ $row->message}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Created At', (isset($fields['created_at']['language'])? $fields['created_at']['language'] : array())) }}</td>
						<td>{{ $row->created_at}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Updated At', (isset($fields['updated_at']['language'])? $fields['updated_at']['language'] : array())) }}</td>
						<td>{{ $row->updated_at}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Is Accept', (isset($fields['is_accept']['language'])? $fields['is_accept']['language'] : array())) }}</td>
						<?php
							$status = $row->is_accept == 0 ? 'Waiting' : ($row->is_accept == 1 ? 'Accepted' : ($row->is_accept == 2 ? 'Rejected' : ''));
						?>
						<td>{{ $status}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 	

	</div>

</div> --->
@stop
