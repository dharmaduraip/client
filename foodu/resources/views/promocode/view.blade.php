@extends('layouts.app')

@section('content')
<div class="page-header"><h2> {{ $pageTitle }} <small> {{ $pageNote }} </small></h2></div>
<!---
<div class="toolbar-nav">
	<div class="row">
		<div class="col-md-6 ">
			@if($access['is_add'] ==1)
	   		<a href="{{ url('promocode/'.$id.'/edit?return='.$return) }}" class="tips btn btn-default btn-sm  " title="{{ __('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a>
			@endif
			<a href="{{ url('promocode?return='.$return) }}" class="tips btn btn-default  btn-sm  " title="{{ __('core.btn_back') }}"><i class="fa  fa-times"></i></a>		
		</div>
		<div class="col-md-6 text-right">			
	   		<a href="{{ ($prevnext['prev'] != '' ? url('promocode/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-default  btn-sm"><i class="fa fa-arrow-left"></i>  </a>	
			<a href="{{ ($prevnext['next'] != '' ? url('promocode/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-default btn-sm "> <i class="fa fa-arrow-right"></i>  </a>					
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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Promo Name', (isset($fields['promo_name']['language'])? $fields['promo_name']['language'] : array())) }}</td>
						<td>{{ $row->promo_name}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Start Date', (isset($fields['start_date']['language'])? $fields['start_date']['language'] : array())) }}</td>
						<td>{{ $row->start_date}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('End Date', (isset($fields['end_date']['language'])? $fields['end_date']['language'] : array())) }}</td>
						<td>{{ $row->end_date}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Promo Type', (isset($fields['promo_type']['language'])? $fields['promo_type']['language'] : array())) }}</td>
						<td>{{ $row->promo_type}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Minimum Order Value', (isset($fields['min_order_value']['language'])? $fields['min_order_value']['language'] : array())) }}</td>
						<td>{{ $row->min_order_value}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('User Name', (isset($fields['user_id']['language'])? $fields['user_id']['language'] : array())) }}</td>
						<td>{{ $row->user_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Limit Count', (isset($fields['limit_count']['language'])? $fields['limit_count']['language'] : array())) }}</td>
						<td>{{ $row->limit_count}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Promo Desc', (isset($fields['promo_desc']['language'])? $fields['promo_desc']['language'] : array())) }}</td>
						<td>{{ $row->promo_desc}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Limit ', (isset($fields['limit_values']['language'])? $fields['limit_values']['language'] : array())) }}</td>
						<td>{{ $row->limit_values}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('L Id', (isset($fields['l_id']['language'])? $fields['l_id']['language'] : array())) }}</td>
						<td>{{ $row->l_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Avatar', (isset($fields['avatar']['language'])? $fields['avatar']['language'] : array())) }}</td>
						<td>{{ $row->avatar}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Loc Res', (isset($fields['loc_res']['language'])? $fields['loc_res']['language'] : array())) }}</td>
						<td>{{ $row->loc_res}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Promo Offer', (isset($fields['promo_amount']['language'])? $fields['promo_amount']['language'] : array())) }}</td>
						<td>{{ $row->promo_amount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Promo Code', (isset($fields['promo_code']['language'])? $fields['promo_code']['language'] : array())) }}</td>
						<td>{{ $row->promo_code}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Usage Count', (isset($fields['usage_count']['language'])? $fields['usage_count']['language'] : array())) }}</td>
						<td>{{ $row->usage_count}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Max Discount', (isset($fields['max_discount']['language'])? $fields['max_discount']['language'] : array())) }}</td>
						<td>{{ $row->max_discount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Res Id', (isset($fields['res_id']['language'])? $fields['res_id']['language'] : array())) }}</td>
						<td>{{ $row->res_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Promo Mode', (isset($fields['promo_mode']['language'])? $fields['promo_mode']['language'] : array())) }}</td>
						<td>{{ $row->promo_mode}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Ext Url', (isset($fields['ext_url']['language'])? $fields['ext_url']['language'] : array())) }}</td>
						<td>{{ $row->ext_url}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Created At', (isset($fields['created_at']['language'])? $fields['created_at']['language'] : array())) }}</td>
						<td>{{ $row->created_at}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Updated At', (isset($fields['updated_at']['language'])? $fields['updated_at']['language'] : array())) }}</td>
						<td>{{ $row->updated_at}} </td>
						
					</tr>
				
			</tbody>	
		</table>   

	 	

	</div>

</div>
--->
<div class="m-3 box-border">
	<div class="sbox-title"> 
		<h4> 
			<i class="fa fa-table text-light"></i> 
		</h4>
		<div class="sbox-tools">
		@if($access['is_add'] ==1)
	   		<!-- <a href="{{ url('promocode/'.$id.'/edit?return='.$return) }}" class="tips btn btn-default btn-sm  " title="{{ __('core.btn_edit') }}"><i class="fa  fa-pencil"></i></a> -->
			@endif
			<a href="{{ url('promocode?return='.$return) }}" class="tips btn btn-default  btn-sm  " title="{{ __('core.btn_back') }}"><i class="fa  fa-times"></i></a>	

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
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Promo Name', (isset($fields['promo_name']['language'])? $fields['promo_name']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->promo_name}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Start Date', (isset($fields['start_date']['language'])? $fields['start_date']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->start_date}} </label>
							</div> 
							<div class=""></div>
						</div><div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('End Date', (isset($fields['end_date']['language'])? $fields['end_date']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->end_date}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right"> {{ SiteHelpers::activeLang('Promo Type', (isset($fields['promo_type']['language'])? $fields['promo_type']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->promo_type}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Minimum Order Value', (isset($fields['min_order_value']['language'])? $fields['min_order_value']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->min_order_value}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('User Name', (isset($fields['user_id']['language'])? $fields['user_id']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->user_id}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Limit Count', (isset($fields['limit_count']['language'])? $fields['limit_count']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->limit_count}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Promo Desc', (isset($fields['promo_desc']['language'])? $fields['promo_desc']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->promo_desc}} </label>
							</div> 
							<div class=""></div>
						</div> 
						 <div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Promo Offer', (isset($fields['promo_amount']['language'])? $fields['promo_amount']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->promo_amount}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Promo Code', (isset($fields['promo_code']['language'])? $fields['promo_code']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->promo_code}} </label>
							</div> 
							<div class=""></div>
						</div> 	
					</fieldset>
					</div>			
					<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 res_name_div">
						<fieldset>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Limit ', (isset($fields['limit_values']['language'])? $fields['limit_values']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->limit_values}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('L Id', (isset($fields['l_id']['language'])? $fields['l_id']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->l_id}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Avatar', (isset($fields['avatar']['language'])? $fields['avatar']['language'] : array())) }} <span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->avatar}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Loc Res', (isset($fields['loc_res']['language'])? $fields['loc_res']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->loc_res}} </label>
							</div> 
							<div class=""></div>
						</div> <div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Usage Count', (isset($fields['usage_count']['language'])? $fields['usage_count']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->usage_count}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Max Discount', (isset($fields['max_discount']['language'])? $fields['max_discount']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->max_discount}} </label>
							</div> 
							<div class=""></div>
						</div> 
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Res Id', (isset($fields['res_id']['language'])? $fields['res_id']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->res_id}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Promo Mode', (isset($fields['promo_mode']['language'])? $fields['promo_mode']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->promo_mode}} </label>
							</div> 
							<div class=""></div>
						</div>
						<div class="form-group row" >
							<label for="Name" class=" control-label col-md-4 text-md-right">{{ SiteHelpers::activeLang('Ext Url', (isset($fields['ext_url']['language'])? $fields['ext_url']['language'] : array())) }}<span class="asterix"> : </span></label>
							<div class="col-md-6">
							<label for="Name" class=" control-label"> {{ $row->ext_url}} </label>
							</div> 
							<div class=""></div>
						</div>						
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
						
					</fieldset>
				</div>
			</div>
		</fieldset>
	</div>
</div>
@stop
