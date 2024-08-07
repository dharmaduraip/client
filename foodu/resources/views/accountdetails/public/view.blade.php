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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Bank Name', (isset($fields['Bank_Name']['language'])? $fields['Bank_Name']['language'] : array())) }}</td>
						<td>{{ $row->Bank_Name}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Bank Code', (isset($fields['Bank_Code']['language'])? $fields['Bank_Code']['language'] : array())) }}</td>
						<td>{{ $row->Bank_Code}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Bank AccName', (isset($fields['Bank_AccName']['language'])? $fields['Bank_AccName']['language'] : array())) }}</td>
						<td>{{ $row->Bank_AccName}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Bank AccNumber', (isset($fields['Bank_AccNumber']['language'])? $fields['Bank_AccNumber']['language'] : array())) }}</td>
						<td>{{ $row->Bank_AccNumber}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Ifsc Code', (isset($fields['ifsc_code']['language'])? $fields['ifsc_code']['language'] : array())) }}</td>
						<td>{{ $row->ifsc_code}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Email', (isset($fields['Email']['language'])? $fields['Email']['language'] : array())) }}</td>
						<td>{{ $row->Email}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Mobile', (isset($fields['Mobile']['language'])? $fields['Mobile']['language'] : array())) }}</td>
						<td>{{ $row->Mobile}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Id Type', (isset($fields['id_type']['language'])? $fields['id_type']['language'] : array())) }}</td>
						<td>{{ $row->id_type}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Nric Number', (isset($fields['nric_number']['language'])? $fields['nric_number']['language'] : array())) }}</td>
						<td>{{ $row->nric_number}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Razor Account Id', (isset($fields['razor_account_id']['language'])? $fields['razor_account_id']['language'] : array())) }}</td>
						<td>{{ $row->razor_account_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Fssai No', (isset($fields['fssai_no']['language'])? $fields['fssai_no']['language'] : array())) }}</td>
						<td>{{ $row->fssai_no}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Aadhar No', (isset($fields['aadhar_no']['language'])? $fields['aadhar_no']['language'] : array())) }}</td>
						<td>{{ $row->aadhar_no}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Gst No', (isset($fields['gst_no']['language'])? $fields['gst_no']['language'] : array())) }}</td>
						<td>{{ $row->gst_no}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Pan No', (isset($fields['pan_no']['language'])? $fields['pan_no']['language'] : array())) }}</td>
						<td>{{ $row->pan_no}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Last Updated', (isset($fields['last_updated']['language'])? $fields['last_updated']['language'] : array())) }}</td>
						<td>{{ $row->last_updated}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	