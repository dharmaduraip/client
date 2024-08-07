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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Restaurant Id', (isset($fields['restaurant_id']['language'])? $fields['restaurant_id']['language'] : array())) }}</td>
						<td>{{ $row->restaurant_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Food Item', (isset($fields['food_item']['language'])? $fields['food_item']['language'] : array())) }}</td>
						<td>{{ $row->food_item}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Description', (isset($fields['description']['language'])? $fields['description']['language'] : array())) }}</td>
						<td>{{ $row->description}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Price', (isset($fields['price']['language'])? $fields['price']['language'] : array())) }}</td>
						<td>{{ $row->price}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Selling Price', (isset($fields['selling_price']['language'])? $fields['selling_price']['language'] : array())) }}</td>
						<td>{{ $row->selling_price}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Original Price', (isset($fields['original_price']['language'])? $fields['original_price']['language'] : array())) }}</td>
						<td>{{ $row->original_price}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Hiking', (isset($fields['hiking']['language'])? $fields['hiking']['language'] : array())) }}</td>
						<td>{{ $row->hiking}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Status', (isset($fields['status']['language'])? $fields['status']['language'] : array())) }}</td>
						<td>{{ $row->status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Gst', (isset($fields['gst']['language'])? $fields['gst']['language'] : array())) }}</td>
						<td>{{ $row->gst}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Available From', (isset($fields['available_from']['language'])? $fields['available_from']['language'] : array())) }}</td>
						<td>{{ $row->available_from}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Available To', (isset($fields['available_to']['language'])? $fields['available_to']['language'] : array())) }}</td>
						<td>{{ $row->available_to}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Available From2', (isset($fields['available_from2']['language'])? $fields['available_from2']['language'] : array())) }}</td>
						<td>{{ $row->available_from2}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Available To2', (isset($fields['available_to2']['language'])? $fields['available_to2']['language'] : array())) }}</td>
						<td>{{ $row->available_to2}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Item Status', (isset($fields['item_status']['language'])? $fields['item_status']['language'] : array())) }}</td>
						<td>{{ $row->item_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Image', (isset($fields['image']['language'])? $fields['image']['language'] : array())) }}</td>
						<td>{{ $row->image}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Main Cat', (isset($fields['main_cat']['language'])? $fields['main_cat']['language'] : array())) }}</td>
						<td>{{ $row->main_cat}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Adon Type', (isset($fields['adon_type']['language'])? $fields['adon_type']['language'] : array())) }}</td>
						<td>{{ $row->adon_type}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Sub Cat', (isset($fields['sub_cat']['language'])? $fields['sub_cat']['language'] : array())) }}</td>
						<td>{{ $row->sub_cat}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Recommended', (isset($fields['recommended']['language'])? $fields['recommended']['language'] : array())) }}</td>
						<td>{{ $row->recommended}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Customize', (isset($fields['customize']['language'])? $fields['customize']['language'] : array())) }}</td>
						<td>{{ $row->customize}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Ingredients', (isset($fields['ingredients']['language'])? $fields['ingredients']['language'] : array())) }}</td>
						<td>{{ $row->ingredients}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Entry By', (isset($fields['entry_by']['language'])? $fields['entry_by']['language'] : array())) }}</td>
						<td>{{ $row->entry_by}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('ApproveStatus', (isset($fields['approveStatus']['language'])? $fields['approveStatus']['language'] : array())) }}</td>
						<td>{{ $row->approveStatus}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	