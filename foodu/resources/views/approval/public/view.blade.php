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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Manager Id', (isset($fields['manager_id']['language'])? $fields['manager_id']['language'] : array())) }}</td>
						<td>{{ $row->manager_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Name', (isset($fields['name']['language'])? $fields['name']['language'] : array())) }}</td>
						<td>{{ $row->name}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Show', (isset($fields['show']['language'])? $fields['show']['language'] : array())) }}</td>
						<td>{{ $row->show}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Location', (isset($fields['location']['language'])? $fields['location']['language'] : array())) }}</td>
						<td>{{ $row->location}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('L Id', (isset($fields['l_id']['language'])? $fields['l_id']['language'] : array())) }}</td>
						<td>{{ $row->l_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Logo', (isset($fields['logo']['language'])? $fields['logo']['language'] : array())) }}</td>
						<td>{{ $row->logo}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Banner Image', (isset($fields['banner_image']['language'])? $fields['banner_image']['language'] : array())) }}</td>
						<td>{{ $row->banner_image}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Partner Id', (isset($fields['partner_id']['language'])? $fields['partner_id']['language'] : array())) }}</td>
						<td>{{ $row->partner_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Partner Code', (isset($fields['partner_code']['language'])? $fields['partner_code']['language'] : array())) }}</td>
						<td>{{ $row->partner_code}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Minimum Order', (isset($fields['minimum_order']['language'])? $fields['minimum_order']['language'] : array())) }}</td>
						<td>{{ $row->minimum_order}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Opening Time', (isset($fields['opening_time']['language'])? $fields['opening_time']['language'] : array())) }}</td>
						<td>{{ $row->opening_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Closing Time', (isset($fields['closing_time']['language'])? $fields['closing_time']['language'] : array())) }}</td>
						<td>{{ $row->closing_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Phone', (isset($fields['phone']['language'])? $fields['phone']['language'] : array())) }}</td>
						<td>{{ $row->phone}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Service Tax1', (isset($fields['service_tax1']['language'])? $fields['service_tax1']['language'] : array())) }}</td>
						<td>{{ $row->service_tax1}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Gst Applicable', (isset($fields['gst_applicable']['language'])? $fields['gst_applicable']['language'] : array())) }}</td>
						<td>{{ $row->gst_applicable}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Free Delivery', (isset($fields['free_delivery']['language'])? $fields['free_delivery']['language'] : array())) }}</td>
						<td>{{ $row->free_delivery}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Delivery Charge', (isset($fields['delivery_charge']['language'])? $fields['delivery_charge']['language'] : array())) }}</td>
						<td>{{ $row->delivery_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Delivery Limit', (isset($fields['delivery_limit']['language'])? $fields['delivery_limit']['language'] : array())) }}</td>
						<td>{{ $row->delivery_limit}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Gst', (isset($fields['gst']['language'])? $fields['gst']['language'] : array())) }}</td>
						<td>{{ $row->gst}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cuisine', (isset($fields['cuisine']['language'])? $fields['cuisine']['language'] : array())) }}</td>
						<td>{{ $row->cuisine}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Call Handling', (isset($fields['call_handling']['language'])? $fields['call_handling']['language'] : array())) }}</td>
						<td>{{ $row->call_handling}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Delivery Time', (isset($fields['delivery_time']['language'])? $fields['delivery_time']['language'] : array())) }}</td>
						<td>{{ $row->delivery_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Offer', (isset($fields['offer']['language'])? $fields['offer']['language'] : array())) }}</td>
						<td>{{ $row->offer}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Budget', (isset($fields['budget']['language'])? $fields['budget']['language'] : array())) }}</td>
						<td>{{ $row->budget}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Budget Old', (isset($fields['budget_old']['language'])? $fields['budget_old']['language'] : array())) }}</td>
						<td>{{ $row->budget_old}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Rating', (isset($fields['rating']['language'])? $fields['rating']['language'] : array())) }}</td>
						<td>{{ $row->rating}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Entry By', (isset($fields['entry_by']['language'])? $fields['entry_by']['language'] : array())) }}</td>
						<td>{{ $row->entry_by}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Latitude', (isset($fields['latitude']['language'])? $fields['latitude']['language'] : array())) }}</td>
						<td>{{ $row->latitude}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Longitude', (isset($fields['longitude']['language'])? $fields['longitude']['language'] : array())) }}</td>
						<td>{{ $row->longitude}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Flatno', (isset($fields['flatno']['language'])? $fields['flatno']['language'] : array())) }}</td>
						<td>{{ $row->flatno}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Adrs Line 1', (isset($fields['adrs_line_1']['language'])? $fields['adrs_line_1']['language'] : array())) }}</td>
						<td>{{ $row->adrs_line_1}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Adrs Line 2', (isset($fields['adrs_line_2']['language'])? $fields['adrs_line_2']['language'] : array())) }}</td>
						<td>{{ $row->adrs_line_2}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Sub Loc Level 1', (isset($fields['sub_loc_level_1']['language'])? $fields['sub_loc_level_1']['language'] : array())) }}</td>
						<td>{{ $row->sub_loc_level_1}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('City', (isset($fields['city']['language'])? $fields['city']['language'] : array())) }}</td>
						<td>{{ $row->city}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('State', (isset($fields['state']['language'])? $fields['state']['language'] : array())) }}</td>
						<td>{{ $row->state}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Country', (isset($fields['country']['language'])? $fields['country']['language'] : array())) }}</td>
						<td>{{ $row->country}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Zipcode', (isset($fields['zipcode']['language'])? $fields['zipcode']['language'] : array())) }}</td>
						<td>{{ $row->zipcode}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Res Desc', (isset($fields['res_desc']['language'])? $fields['res_desc']['language'] : array())) }}</td>
						<td>{{ $row->res_desc}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Status', (isset($fields['status']['language'])? $fields['status']['language'] : array())) }}</td>
						<td>{{ $row->status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Commission', (isset($fields['commission']['language'])? $fields['commission']['language'] : array())) }}</td>
						<td>{{ $row->commission}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Admin Status', (isset($fields['admin_status']['language'])? $fields['admin_status']['language'] : array())) }}</td>
						<td>{{ $row->admin_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Rejectreason', (isset($fields['rejectreason']['language'])? $fields['rejectreason']['language'] : array())) }}</td>
						<td>{{ $row->rejectreason}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Tagline', (isset($fields['tagline']['language'])? $fields['tagline']['language'] : array())) }}</td>
						<td>{{ $row->tagline}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Ordering', (isset($fields['ordering']['language'])? $fields['ordering']['language'] : array())) }}</td>
						<td>{{ $row->ordering}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Mode', (isset($fields['mode']['language'])? $fields['mode']['language'] : array())) }}</td>
						<td>{{ $row->mode}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Mode Filter', (isset($fields['mode_filter']['language'])? $fields['mode_filter']['language'] : array())) }}</td>
						<td>{{ $row->mode_filter}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Static Map Image', (isset($fields['static_map_image']['language'])? $fields['static_map_image']['language'] : array())) }}</td>
						<td>{{ $row->static_map_image}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Deliver Status', (isset($fields['deliver_status']['language'])? $fields['deliver_status']['language'] : array())) }}</td>
						<td>{{ $row->deliver_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Preoder', (isset($fields['preoder']['language'])? $fields['preoder']['language'] : array())) }}</td>
						<td>{{ $row->preoder}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Shop Categories', (isset($fields['shop_categories']['language'])? $fields['shop_categories']['language'] : array())) }}</td>
						<td>{{ $row->shop_categories}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Restaurant Cat', (isset($fields['restaurant_cat']['language'])? $fields['restaurant_cat']['language'] : array())) }}</td>
						<td>{{ $row->restaurant_cat}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('R Fassai No', (isset($fields['r_fassai_no']['language'])? $fields['r_fassai_no']['language'] : array())) }}</td>
						<td>{{ $row->r_fassai_no}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('R Pan No', (isset($fields['r_pan_no']['language'])? $fields['r_pan_no']['language'] : array())) }}</td>
						<td>{{ $row->r_pan_no}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('R Gst No', (isset($fields['r_gst_no']['language'])? $fields['r_gst_no']['language'] : array())) }}</td>
						<td>{{ $row->r_gst_no}} </td>
						
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