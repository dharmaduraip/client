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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Delivery Boy', (isset($fields['boy_id']['language'])? $fields['boy_id']['language'] : array())) }}</td>
						<td>{{ $row->boy_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Id', (isset($fields['id']['language'])? $fields['id']['language'] : array())) }}</td>
						<td>{{ $row->id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Type', (isset($fields['order_type']['language'])? $fields['order_type']['language'] : array())) }}</td>
						<td>{{ $row->order_type}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cust Id', (isset($fields['cust_id']['language'])? $fields['cust_id']['language'] : array())) }}</td>
						<td>{{ $row->cust_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Date', (isset($fields['date']['language'])? $fields['date']['language'] : array())) }}</td>
						<td>{{ $row->date}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Shop', (isset($fields['res_id']['language'])? $fields['res_id']['language'] : array())) }}</td>
						<td>{{ $row->res_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Partner Id', (isset($fields['partner_id']['language'])? $fields['partner_id']['language'] : array())) }}</td>
						<td>{{ $row->partner_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Orderid', (isset($fields['orderid']['language'])? $fields['orderid']['language'] : array())) }}</td>
						<td>{{ $row->orderid}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Value', (isset($fields['del_charge']['language'])? $fields['del_charge']['language'] : array())) }}</td>
						<td>{{ $row->del_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Is Rapido', (isset($fields['is_rapido']['language'])? $fields['is_rapido']['language'] : array())) }}</td>
						<td>{{ $row->is_rapido}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Rapido Orderid', (isset($fields['rapido_orderid']['language'])? $fields['rapido_orderid']['language'] : array())) }}</td>
						<td>{{ $row->rapido_orderid}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Mobile Num', (isset($fields['mobile_num']['language'])? $fields['mobile_num']['language'] : array())) }}</td>
						<td>{{ $row->mobile_num}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Total Price', (isset($fields['total_price']['language'])? $fields['total_price']['language'] : array())) }}</td>
						<td>{{ $row->total_price}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Host Withcommission', (isset($fields['host_withcommission']['language'])? $fields['host_withcommission']['language'] : array())) }}</td>
						<td>{{ $row->host_withcommission}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Host Amount', (isset($fields['host_amount']['language'])? $fields['host_amount']['language'] : array())) }}</td>
						<td>{{ $row->host_amount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Accept Host Amount', (isset($fields['accept_host_amount']['language'])? $fields['accept_host_amount']['language'] : array())) }}</td>
						<td>{{ $row->accept_host_amount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Hiking', (isset($fields['hiking']['language'])? $fields['hiking']['language'] : array())) }}</td>
						<td>{{ $row->hiking}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('FixedCommission', (isset($fields['fixedCommission']['language'])? $fields['fixedCommission']['language'] : array())) }}</td>
						<td>{{ $row->fixedCommission}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Admin Camount', (isset($fields['admin_camount']['language'])? $fields['admin_camount']['language'] : array())) }}</td>
						<td>{{ $row->admin_camount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Del Km', (isset($fields['del_km']['language'])? $fields['del_km']['language'] : array())) }}</td>
						<td>{{ $row->del_km}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Del Charge Tax Percent', (isset($fields['del_charge_tax_percent']['language'])? $fields['del_charge_tax_percent']['language'] : array())) }}</td>
						<td>{{ $row->del_charge_tax_percent}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Del Charge Tax Price', (isset($fields['del_charge_tax_price']['language'])? $fields['del_charge_tax_price']['language'] : array())) }}</td>
						<td>{{ $row->del_charge_tax_price}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('F Del Charge', (isset($fields['f_del_charge']['language'])? $fields['f_del_charge']['language'] : array())) }}</td>
						<td>{{ $row->f_del_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Add Del Charge', (isset($fields['add_del_charge']['language'])? $fields['add_del_charge']['language'] : array())) }}</td>
						<td>{{ $row->add_del_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Min Night', (isset($fields['min_night']['language'])? $fields['min_night']['language'] : array())) }}</td>
						<td>{{ $row->min_night}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Boy Del Charge', (isset($fields['boy_del_charge']['language'])? $fields['boy_del_charge']['language'] : array())) }}</td>
						<td>{{ $row->boy_del_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Admin Del Charge', (isset($fields['admin_del_charge']['language'])? $fields['admin_del_charge']['language'] : array())) }}</td>
						<td>{{ $row->admin_del_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Delivery Boy Charge Per Km', (isset($fields['delivery_boy_charge_per_km']['language'])? $fields['delivery_boy_charge_per_km']['language'] : array())) }}</td>
						<td>{{ $row->delivery_boy_charge_per_km}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('S Tax1', (isset($fields['s_tax1']['language'])? $fields['s_tax1']['language'] : array())) }}</td>
						<td>{{ $row->s_tax1}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Gst', (isset($fields['gst']['language'])? $fields['gst']['language'] : array())) }}</td>
						<td>{{ $row->gst}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Online Pay Chanrge', (isset($fields['online_pay_chanrge']['language'])? $fields['online_pay_chanrge']['language'] : array())) }}</td>
						<td>{{ $row->online_pay_chanrge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('S Tax2', (isset($fields['s_tax2']['language'])? $fields['s_tax2']['language'] : array())) }}</td>
						<td>{{ $row->s_tax2}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Comsn Percentage', (isset($fields['comsn_percentage']['language'])? $fields['comsn_percentage']['language'] : array())) }}</td>
						<td>{{ $row->comsn_percentage}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Offer Price', (isset($fields['offer_price']['language'])? $fields['offer_price']['language'] : array())) }}</td>
						<td>{{ $row->offer_price}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Offer Percentage', (isset($fields['offer_percentage']['language'])? $fields['offer_percentage']['language'] : array())) }}</td>
						<td>{{ $row->offer_percentage}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Coupon Price', (isset($fields['coupon_price']['language'])? $fields['coupon_price']['language'] : array())) }}</td>
						<td>{{ $row->coupon_price}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Coupon Type', (isset($fields['coupon_type']['language'])? $fields['coupon_type']['language'] : array())) }}</td>
						<td>{{ $row->coupon_type}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Coupon Value', (isset($fields['coupon_value']['language'])? $fields['coupon_value']['language'] : array())) }}</td>
						<td>{{ $row->coupon_value}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Grand Total', (isset($fields['grand_total']['language'])? $fields['grand_total']['language'] : array())) }}</td>
						<td>{{ $row->grand_total}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Accept Grand Total', (isset($fields['accept_grand_total']['language'])? $fields['accept_grand_total']['language'] : array())) }}</td>
						<td>{{ $row->accept_grand_total}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Paid Amount', (isset($fields['paid_amount']['language'])? $fields['paid_amount']['language'] : array())) }}</td>
						<td>{{ $row->paid_amount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Address', (isset($fields['address']['language'])? $fields['address']['language'] : array())) }}</td>
						<td>{{ $row->address}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Building', (isset($fields['building']['language'])? $fields['building']['language'] : array())) }}</td>
						<td>{{ $row->building}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Landmark', (isset($fields['landmark']['language'])? $fields['landmark']['language'] : array())) }}</td>
						<td>{{ $row->landmark}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Status', (isset($fields['status']['language'])? $fields['status']['language'] : array())) }}</td>
						<td>{{ $row->status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Customer Status', (isset($fields['customer_status']['language'])? $fields['customer_status']['language'] : array())) }}</td>
						<td>{{ $row->customer_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Boy Called', (isset($fields['boy_called']['language'])? $fields['boy_called']['language'] : array())) }}</td>
						<td>{{ $row->boy_called}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Coupon Id', (isset($fields['coupon_id']['language'])? $fields['coupon_id']['language'] : array())) }}</td>
						<td>{{ $row->coupon_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Time', (isset($fields['time']['language'])? $fields['time']['language'] : array())) }}</td>
						<td>{{ $row->time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Delivery', (isset($fields['delivery']['language'])? $fields['delivery']['language'] : array())) }}</td>
						<td>{{ $row->delivery}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Payment Type', (isset($fields['delivery_type']['language'])? $fields['delivery_type']['language'] : array())) }}</td>
						<td>{{ $row->delivery_type}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Lat', (isset($fields['lat']['language'])? $fields['lat']['language'] : array())) }}</td>
						<td>{{ $row->lat}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Lang', (isset($fields['lang']['language'])? $fields['lang']['language'] : array())) }}</td>
						<td>{{ $row->lang}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Order Note', (isset($fields['order_note']['language'])? $fields['order_note']['language'] : array())) }}</td>
						<td>{{ $row->order_note}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Skip Status', (isset($fields['skip_status']['language'])? $fields['skip_status']['language'] : array())) }}</td>
						<td>{{ $row->skip_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Payment Token', (isset($fields['payment_token']['language'])? $fields['payment_token']['language'] : array())) }}</td>
						<td>{{ $row->payment_token}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Mol Status', (isset($fields['mol_status']['language'])? $fields['mol_status']['language'] : array())) }}</td>
						<td>{{ $row->mol_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Coupon Min Val', (isset($fields['coupon_min_val']['language'])? $fields['coupon_min_val']['language'] : array())) }}</td>
						<td>{{ $row->coupon_min_val}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cancelled By', (isset($fields['cancelled_by']['language'])? $fields['cancelled_by']['language'] : array())) }}</td>
						<td>{{ $row->cancelled_by}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Accepted Time', (isset($fields['accepted_time']['language'])? $fields['accepted_time']['language'] : array())) }}</td>
						<td>{{ $row->accepted_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Dispatched Time', (isset($fields['dispatched_time']['language'])? $fields['dispatched_time']['language'] : array())) }}</td>
						<td>{{ $row->dispatched_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Completed Time', (isset($fields['completed_time']['language'])? $fields['completed_time']['language'] : array())) }}</td>
						<td>{{ $row->completed_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cancelled Time', (isset($fields['cancelled_time']['language'])? $fields['cancelled_time']['language'] : array())) }}</td>
						<td>{{ $row->cancelled_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Duration', (isset($fields['duration']['language'])? $fields['duration']['language'] : array())) }}</td>
						<td>{{ $row->duration}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Delivery Time', (isset($fields['delivery_time']['language'])? $fields['delivery_time']['language'] : array())) }}</td>
						<td>{{ $row->delivery_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Device', (isset($fields['device']['language'])? $fields['device']['language'] : array())) }}</td>
						<td>{{ $row->device}} </td>
						
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
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Created At', (isset($fields['created_at']['language'])? $fields['created_at']['language'] : array())) }}</td>
						<td>{{ $row->created_at}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Updated At', (isset($fields['updated_at']['language'])? $fields['updated_at']['language'] : array())) }}</td>
						<td>{{ $row->updated_at}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Delivery Preference', (isset($fields['delivery_preference']['language'])? $fields['delivery_preference']['language'] : array())) }}</td>
						<td>{{ $row->delivery_preference}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Ordertype', (isset($fields['ordertype']['language'])? $fields['ordertype']['language'] : array())) }}</td>
						<td>{{ $row->ordertype}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Later Deliver Date', (isset($fields['later_deliver_date']['language'])? $fields['later_deliver_date']['language'] : array())) }}</td>
						<td>{{ $row->later_deliver_date}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Later Deliver Time', (isset($fields['later_deliver_time']['language'])? $fields['later_deliver_time']['language'] : array())) }}</td>
						<td>{{ $row->later_deliver_time}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Later Delivery Timestamp', (isset($fields['later_delivery_timestamp']['language'])? $fields['later_delivery_timestamp']['language'] : array())) }}</td>
						<td>{{ $row->later_delivery_timestamp}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Free Delivery', (isset($fields['free_delivery']['language'])? $fields['free_delivery']['language'] : array())) }}</td>
						<td>{{ $row->free_delivery}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Vendor Price Val', (isset($fields['vendor_price_val']['language'])? $fields['vendor_price_val']['language'] : array())) }}</td>
						<td>{{ $row->vendor_price_val}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Bad Weather Charge', (isset($fields['bad_weather_charge']['language'])? $fields['bad_weather_charge']['language'] : array())) }}</td>
						<td>{{ $row->bad_weather_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Festival Mode Charge', (isset($fields['festival_mode_charge']['language'])? $fields['festival_mode_charge']['language'] : array())) }}</td>
						<td>{{ $row->festival_mode_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Festival Mode Charge Perkm', (isset($fields['festival_mode_charge_perkm']['language'])? $fields['festival_mode_charge_perkm']['language'] : array())) }}</td>
						<td>{{ $row->festival_mode_charge_perkm}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Del Charge Discount', (isset($fields['del_charge_discount']['language'])? $fields['del_charge_discount']['language'] : array())) }}</td>
						<td>{{ $row->del_charge_discount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Manager Id', (isset($fields['manager_id']['language'])? $fields['manager_id']['language'] : array())) }}</td>
						<td>{{ $row->manager_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Manager Commission Percent', (isset($fields['manager_commission_percent']['language'])? $fields['manager_commission_percent']['language'] : array())) }}</td>
						<td>{{ $row->manager_commission_percent}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Manager Commission Price', (isset($fields['manager_commission_price']['language'])? $fields['manager_commission_price']['language'] : array())) }}</td>
						<td>{{ $row->manager_commission_price}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Refund Id', (isset($fields['refund_id']['language'])? $fields['refund_id']['language'] : array())) }}</td>
						<td>{{ $row->refund_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Refund Order', (isset($fields['refund_order']['language'])? $fields['refund_order']['language'] : array())) }}</td>
						<td>{{ $row->refund_order}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Refund Status', (isset($fields['refund_status']['language'])? $fields['refund_status']['language'] : array())) }}</td>
						<td>{{ $row->refund_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cancel Reason', (isset($fields['cancel_reason']['language'])? $fields['cancel_reason']['language'] : array())) }}</td>
						<td>{{ $row->cancel_reason}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Wallet Amount', (isset($fields['wallet_amount']['language'])? $fields['wallet_amount']['language'] : array())) }}</td>
						<td>{{ $row->wallet_amount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cash Offer', (isset($fields['cash_offer']['language'])? $fields['cash_offer']['language'] : array())) }}</td>
						<td>{{ $row->cash_offer}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Is Dispute', (isset($fields['is_dispute']['language'])? $fields['is_dispute']['language'] : array())) }}</td>
						<td>{{ $row->is_dispute}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Dispute By', (isset($fields['dispute_by']['language'])? $fields['dispute_by']['language'] : array())) }}</td>
						<td>{{ $row->dispute_by}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Dispute Category Id', (isset($fields['dispute_category_id']['language'])? $fields['dispute_category_id']['language'] : array())) }}</td>
						<td>{{ $row->dispute_category_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Dispute Reason', (isset($fields['dispute_reason']['language'])? $fields['dispute_reason']['language'] : array())) }}</td>
						<td>{{ $row->dispute_reason}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Dispute Status', (isset($fields['dispute_status']['language'])? $fields['dispute_status']['language'] : array())) }}</td>
						<td>{{ $row->dispute_status}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('When Dispute Raised', (isset($fields['when_dispute_raised']['language'])? $fields['when_dispute_raised']['language'] : array())) }}</td>
						<td>{{ $row->when_dispute_raised}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('When Dispute Closed', (isset($fields['when_dispute_closed']['language'])? $fields['when_dispute_closed']['language'] : array())) }}</td>
						<td>{{ $row->when_dispute_closed}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Chef Received Amount', (isset($fields['chef_received_amount']['language'])? $fields['chef_received_amount']['language'] : array())) }}</td>
						<td>{{ $row->chef_received_amount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cancelled Customer Refund', (isset($fields['cancelled_customer_refund']['language'])? $fields['cancelled_customer_refund']['language'] : array())) }}</td>
						<td>{{ $row->cancelled_customer_refund}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Razorpay Transfer Id', (isset($fields['razorpay_transfer_id']['language'])? $fields['razorpay_transfer_id']['language'] : array())) }}</td>
						<td>{{ $row->razorpay_transfer_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cancelled Boy Del Charge', (isset($fields['cancelled_boy_del_charge']['language'])? $fields['cancelled_boy_del_charge']['language'] : array())) }}</td>
						<td>{{ $row->cancelled_boy_del_charge}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Enc Order Id', (isset($fields['enc_order_id']['language'])? $fields['enc_order_id']['language'] : array())) }}</td>
						<td>{{ $row->enc_order_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>{{ SiteHelpers::activeLang('Cod Amount', (isset($fields['cod_amount']['language'])? $fields['cod_amount']['language'] : array())) }}</td>
						<td>{{ $row->cod_amount}} </td>
						
					</tr>
						
					<tr>
						<td width='30%' class='label-view text-right'></td>
						<td> <a href="javascript:history.go(-1)"> Back To Grid <a> </td>
						
					</tr>					
				
			</tbody>	
		</table>   

	 
	
	</div>
</div>	