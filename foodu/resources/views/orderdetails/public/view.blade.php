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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Orderid', (isset($fields['orderid']['language'])? $fields['orderid']['language'] : array())) }}</td>
						<td>{{ $row->orderid}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Value', (isset($fields['order_value']['language'])? $fields['order_value']['language'] : array())) }}</td>
						<td>{{ $row->order_value}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Details', (isset($fields['order_details']['language'])? $fields['order_details']['language'] : array())) }}</td>
						<td>{{ $row->order_details}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Status', (isset($fields['order_status']['language'])? $fields['order_status']['language'] : array())) }}</td>
						<td>{{ $row->order_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Accepted Time', (isset($fields['order_accepted_time']['language'])? $fields['order_accepted_time']['language'] : array())) }}</td>
						<td>{{ $row->order_accepted_time}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	