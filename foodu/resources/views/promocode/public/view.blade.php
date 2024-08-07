<div class="container" class="pt-3 pb-3">
    <div class="row m-b-lg animated fadeInDown delayp1 text-center">
        <h3> {{ $pageTitle }} <small> {{ $pageNote }} </small></h3>
        <hr />       
    </div>
</div>
<div class="m-t">
	<div class="table-container" > 	

		<table class="table table-striped table-bordered" >
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
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	