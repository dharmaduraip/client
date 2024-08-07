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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Charge Type', (isset($fields['charge_type']['language'])? $fields['charge_type']['language'] : array())) }}</td>
						<td>{{ $row->charge_type}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Charge Value', (isset($fields['charge_value']['language'])? $fields['charge_value']['language'] : array())) }}</td>
						<td>{{ $row->charge_value}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Value Min', (isset($fields['order_value_min']['language'])? $fields['order_value_min']['language'] : array())) }}</td>
						<td>{{ $row->order_value_min}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Value Max', (isset($fields['order_value_max']['language'])? $fields['order_value_max']['language'] : array())) }}</td>
						<td>{{ $row->order_value_max}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Distance Min', (isset($fields['distance_min']['language'])? $fields['distance_min']['language'] : array())) }}</td>
						<td>{{ $row->distance_min}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Distance Max', (isset($fields['distance_max']['language'])? $fields['distance_max']['language'] : array())) }}</td>
						<td>{{ $row->distance_max}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Tax', (isset($fields['tax']['language'])? $fields['tax']['language'] : array())) }}</td>
						<td>{{ $row->tax}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Status', (isset($fields['status']['language'])? $fields['status']['language'] : array())) }}</td>
						<td>{{ $row->status}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	