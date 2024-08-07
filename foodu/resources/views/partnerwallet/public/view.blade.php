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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Partner Id', (isset($fields['partner_id']['language'])? $fields['partner_id']['language'] : array())) }}</td>
						<td>{{ $row->partner_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Id', (isset($fields['order_id']['language'])? $fields['order_id']['language'] : array())) }}</td>
						<td>{{ $row->order_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Transaction Id', (isset($fields['transaction_id']['language'])? $fields['transaction_id']['language'] : array())) }}</td>
						<td>{{ $row->transaction_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Transaction Type', (isset($fields['transaction_type']['language'])? $fields['transaction_type']['language'] : array())) }}</td>
						<td>{{ $row->transaction_type}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Transaction Amount', (isset($fields['transaction_amount']['language'])? $fields['transaction_amount']['language'] : array())) }}</td>
						<td>{{ $row->transaction_amount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Transaction Status', (isset($fields['transaction_status']['language'])? $fields['transaction_status']['language'] : array())) }}</td>
						<td>{{ $row->transaction_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Transac Through', (isset($fields['transac_through']['language'])? $fields['transac_through']['language'] : array())) }}</td>
						<td>{{ $row->transac_through}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Trans Date', (isset($fields['trans_date']['language'])? $fields['trans_date']['language'] : array())) }}</td>
						<td>{{ $row->trans_date}} </td>
						
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