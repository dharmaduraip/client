

		 {!! Form::open(array('url'=>'allorders', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}

	@if(Session::has('messagetext'))
	  
		   {!! Session::get('messagetext') !!}
	   
	@endif
	<ul class="parsley-error-list">
		@foreach($errors->all() as $error)
			<li>{{ $error }}</li>
		@endforeach
	</ul>		


<div class="col-md-12">
						<fieldset><legend> AllOrders</legend>
									
									  <div class="form-group row  " >
										<label for="Id" class=" control-label col-md-4 text-left"> Id </label>
										<div class="col-md-6">
										  <input  type='text' name='id' id='id' value='{{ $row['id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Order Type" class=" control-label col-md-4 text-left"> Order Type </label>
										<div class="col-md-6">
										  <input  type='text' name='order_type' id='order_type' value='{{ $row['order_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cust Id" class=" control-label col-md-4 text-left"> Cust Id </label>
										<div class="col-md-6">
										  <input  type='text' name='cust_id' id='cust_id' value='{{ $row['cust_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Res Id" class=" control-label col-md-4 text-left"> Res Id </label>
										<div class="col-md-6">
										  <input  type='text' name='res_id' id='res_id' value='{{ $row['res_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Partner Id" class=" control-label col-md-4 text-left"> Partner Id </label>
										<div class="col-md-6">
										  <input  type='text' name='partner_id' id='partner_id' value='{{ $row['partner_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Orderid" class=" control-label col-md-4 text-left"> Orderid </label>
										<div class="col-md-6">
										  <input  type='text' name='orderid' id='orderid' value='{{ $row['orderid'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Is Rapido" class=" control-label col-md-4 text-left"> Is Rapido </label>
										<div class="col-md-6">
										  <input  type='text' name='is_rapido' id='is_rapido' value='{{ $row['is_rapido'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Rapido Orderid" class=" control-label col-md-4 text-left"> Rapido Orderid </label>
										<div class="col-md-6">
										  <input  type='text' name='rapido_orderid' id='rapido_orderid' value='{{ $row['rapido_orderid'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Mobile Num" class=" control-label col-md-4 text-left"> Mobile Num </label>
										<div class="col-md-6">
										  <input  type='text' name='mobile_num' id='mobile_num' value='{{ $row['mobile_num'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Total Price" class=" control-label col-md-4 text-left"> Total Price </label>
										<div class="col-md-6">
										  <input  type='text' name='total_price' id='total_price' value='{{ $row['total_price'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Host Withcommission" class=" control-label col-md-4 text-left"> Host Withcommission </label>
										<div class="col-md-6">
										  <input  type='text' name='host_withcommission' id='host_withcommission' value='{{ $row['host_withcommission'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Host Amount" class=" control-label col-md-4 text-left"> Host Amount </label>
										<div class="col-md-6">
										  <input  type='text' name='host_amount' id='host_amount' value='{{ $row['host_amount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Accept Host Amount" class=" control-label col-md-4 text-left"> Accept Host Amount </label>
										<div class="col-md-6">
										  <input  type='text' name='accept_host_amount' id='accept_host_amount' value='{{ $row['accept_host_amount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Hiking" class=" control-label col-md-4 text-left"> Hiking </label>
										<div class="col-md-6">
										  <input  type='text' name='hiking' id='hiking' value='{{ $row['hiking'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="FixedCommission" class=" control-label col-md-4 text-left"> FixedCommission </label>
										<div class="col-md-6">
										  <input  type='text' name='fixedCommission' id='fixedCommission' value='{{ $row['fixedCommission'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Admin Camount" class=" control-label col-md-4 text-left"> Admin Camount </label>
										<div class="col-md-6">
										  <input  type='text' name='admin_camount' id='admin_camount' value='{{ $row['admin_camount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Del Km" class=" control-label col-md-4 text-left"> Del Km </label>
										<div class="col-md-6">
										  <input  type='text' name='del_km' id='del_km' value='{{ $row['del_km'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Del Charge" class=" control-label col-md-4 text-left"> Del Charge </label>
										<div class="col-md-6">
										  <input  type='text' name='del_charge' id='del_charge' value='{{ $row['del_charge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Del Charge Tax Percent" class=" control-label col-md-4 text-left"> Del Charge Tax Percent </label>
										<div class="col-md-6">
										  <input  type='text' name='del_charge_tax_percent' id='del_charge_tax_percent' value='{{ $row['del_charge_tax_percent'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Del Charge Tax Price" class=" control-label col-md-4 text-left"> Del Charge Tax Price </label>
										<div class="col-md-6">
										  <input  type='text' name='del_charge_tax_price' id='del_charge_tax_price' value='{{ $row['del_charge_tax_price'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="F Del Charge" class=" control-label col-md-4 text-left"> F Del Charge </label>
										<div class="col-md-6">
										  <input  type='text' name='f_del_charge' id='f_del_charge' value='{{ $row['f_del_charge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Add Del Charge" class=" control-label col-md-4 text-left"> Add Del Charge </label>
										<div class="col-md-6">
										  <input  type='text' name='add_del_charge' id='add_del_charge' value='{{ $row['add_del_charge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Min Night" class=" control-label col-md-4 text-left"> Min Night </label>
										<div class="col-md-6">
										  <input  type='text' name='min_night' id='min_night' value='{{ $row['min_night'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Boy Del Charge" class=" control-label col-md-4 text-left"> Boy Del Charge </label>
										<div class="col-md-6">
										  <input  type='text' name='boy_del_charge' id='boy_del_charge' value='{{ $row['boy_del_charge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Admin Del Charge" class=" control-label col-md-4 text-left"> Admin Del Charge </label>
										<div class="col-md-6">
										  <input  type='text' name='admin_del_charge' id='admin_del_charge' value='{{ $row['admin_del_charge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Delivery Boy Charge Per Km" class=" control-label col-md-4 text-left"> Delivery Boy Charge Per Km </label>
										<div class="col-md-6">
										  <input  type='text' name='delivery_boy_charge_per_km' id='delivery_boy_charge_per_km' value='{{ $row['delivery_boy_charge_per_km'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="S Tax1" class=" control-label col-md-4 text-left"> S Tax1 </label>
										<div class="col-md-6">
										  <input  type='text' name='s_tax1' id='s_tax1' value='{{ $row['s_tax1'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Gst" class=" control-label col-md-4 text-left"> Gst </label>
										<div class="col-md-6">
										  <input  type='text' name='gst' id='gst' value='{{ $row['gst'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Online Pay Chanrge" class=" control-label col-md-4 text-left"> Online Pay Chanrge </label>
										<div class="col-md-6">
										  <input  type='text' name='online_pay_chanrge' id='online_pay_chanrge' value='{{ $row['online_pay_chanrge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="S Tax2" class=" control-label col-md-4 text-left"> S Tax2 </label>
										<div class="col-md-6">
										  <input  type='text' name='s_tax2' id='s_tax2' value='{{ $row['s_tax2'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Comsn Percentage" class=" control-label col-md-4 text-left"> Comsn Percentage </label>
										<div class="col-md-6">
										  <input  type='text' name='comsn_percentage' id='comsn_percentage' value='{{ $row['comsn_percentage'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Offer Price" class=" control-label col-md-4 text-left"> Offer Price </label>
										<div class="col-md-6">
										  <input  type='text' name='offer_price' id='offer_price' value='{{ $row['offer_price'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Offer Percentage" class=" control-label col-md-4 text-left"> Offer Percentage </label>
										<div class="col-md-6">
										  <input  type='text' name='offer_percentage' id='offer_percentage' value='{{ $row['offer_percentage'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Coupon Price" class=" control-label col-md-4 text-left"> Coupon Price </label>
										<div class="col-md-6">
										  <input  type='text' name='coupon_price' id='coupon_price' value='{{ $row['coupon_price'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Coupon Type" class=" control-label col-md-4 text-left"> Coupon Type </label>
										<div class="col-md-6">
										  <input  type='text' name='coupon_type' id='coupon_type' value='{{ $row['coupon_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Coupon Value" class=" control-label col-md-4 text-left"> Coupon Value </label>
										<div class="col-md-6">
										  <input  type='text' name='coupon_value' id='coupon_value' value='{{ $row['coupon_value'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Grand Total" class=" control-label col-md-4 text-left"> Grand Total </label>
										<div class="col-md-6">
										  <input  type='text' name='grand_total' id='grand_total' value='{{ $row['grand_total'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Accept Grand Total" class=" control-label col-md-4 text-left"> Accept Grand Total </label>
										<div class="col-md-6">
										  <input  type='text' name='accept_grand_total' id='accept_grand_total' value='{{ $row['accept_grand_total'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Paid Amount" class=" control-label col-md-4 text-left"> Paid Amount </label>
										<div class="col-md-6">
										  <input  type='text' name='paid_amount' id='paid_amount' value='{{ $row['paid_amount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Address" class=" control-label col-md-4 text-left"> Address </label>
										<div class="col-md-6">
										  <input  type='text' name='address' id='address' value='{{ $row['address'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Building" class=" control-label col-md-4 text-left"> Building </label>
										<div class="col-md-6">
										  <input  type='text' name='building' id='building' value='{{ $row['building'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Landmark" class=" control-label col-md-4 text-left"> Landmark </label>
										<div class="col-md-6">
										  <input  type='text' name='landmark' id='landmark' value='{{ $row['landmark'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Status" class=" control-label col-md-4 text-left"> Status </label>
										<div class="col-md-6">
										  <input  type='text' name='status' id='status' value='{{ $row['status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Customer Status" class=" control-label col-md-4 text-left"> Customer Status </label>
										<div class="col-md-6">
										  <input  type='text' name='customer_status' id='customer_status' value='{{ $row['customer_status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Boy Called" class=" control-label col-md-4 text-left"> Boy Called </label>
										<div class="col-md-6">
										  <input  type='text' name='boy_called' id='boy_called' value='{{ $row['boy_called'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Coupon Id" class=" control-label col-md-4 text-left"> Coupon Id </label>
										<div class="col-md-6">
										  <input  type='text' name='coupon_id' id='coupon_id' value='{{ $row['coupon_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Time" class=" control-label col-md-4 text-left"> Time </label>
										<div class="col-md-6">
										  <input  type='text' name='time' id='time' value='{{ $row['time'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Date" class=" control-label col-md-4 text-left"> Date </label>
										<div class="col-md-6">
										  <input  type='text' name='date' id='date' value='{{ $row['date'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Delivery" class=" control-label col-md-4 text-left"> Delivery </label>
										<div class="col-md-6">
										  <input  type='text' name='delivery' id='delivery' value='{{ $row['delivery'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Delivery Type" class=" control-label col-md-4 text-left"> Delivery Type </label>
										<div class="col-md-6">
										  <input  type='text' name='delivery_type' id='delivery_type' value='{{ $row['delivery_type'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Lat" class=" control-label col-md-4 text-left"> Lat </label>
										<div class="col-md-6">
										  <input  type='text' name='lat' id='lat' value='{{ $row['lat'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Lang" class=" control-label col-md-4 text-left"> Lang </label>
										<div class="col-md-6">
										  <input  type='text' name='lang' id='lang' value='{{ $row['lang'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Order Note" class=" control-label col-md-4 text-left"> Order Note </label>
										<div class="col-md-6">
										  <input  type='text' name='order_note' id='order_note' value='{{ $row['order_note'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Skip Status" class=" control-label col-md-4 text-left"> Skip Status </label>
										<div class="col-md-6">
										  <input  type='text' name='skip_status' id='skip_status' value='{{ $row['skip_status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Payment Token" class=" control-label col-md-4 text-left"> Payment Token </label>
										<div class="col-md-6">
										  <input  type='text' name='payment_token' id='payment_token' value='{{ $row['payment_token'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Mol Status" class=" control-label col-md-4 text-left"> Mol Status </label>
										<div class="col-md-6">
										  <input  type='text' name='mol_status' id='mol_status' value='{{ $row['mol_status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Coupon Min Val" class=" control-label col-md-4 text-left"> Coupon Min Val </label>
										<div class="col-md-6">
										  <input  type='text' name='coupon_min_val' id='coupon_min_val' value='{{ $row['coupon_min_val'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cancelled By" class=" control-label col-md-4 text-left"> Cancelled By </label>
										<div class="col-md-6">
										  <input  type='text' name='cancelled_by' id='cancelled_by' value='{{ $row['cancelled_by'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Accepted Time" class=" control-label col-md-4 text-left"> Accepted Time </label>
										<div class="col-md-6">
										  <input  type='text' name='accepted_time' id='accepted_time' value='{{ $row['accepted_time'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Dispatched Time" class=" control-label col-md-4 text-left"> Dispatched Time </label>
										<div class="col-md-6">
										  <input  type='text' name='dispatched_time' id='dispatched_time' value='{{ $row['dispatched_time'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Completed Time" class=" control-label col-md-4 text-left"> Completed Time </label>
										<div class="col-md-6">
										  <input  type='text' name='completed_time' id='completed_time' value='{{ $row['completed_time'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cancelled Time" class=" control-label col-md-4 text-left"> Cancelled Time </label>
										<div class="col-md-6">
										  <input  type='text' name='cancelled_time' id='cancelled_time' value='{{ $row['cancelled_time'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Duration" class=" control-label col-md-4 text-left"> Duration </label>
										<div class="col-md-6">
										  <input  type='text' name='duration' id='duration' value='{{ $row['duration'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Delivery Time" class=" control-label col-md-4 text-left"> Delivery Time </label>
										<div class="col-md-6">
										  <input  type='text' name='delivery_time' id='delivery_time' value='{{ $row['delivery_time'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Device" class=" control-label col-md-4 text-left"> Device </label>
										<div class="col-md-6">
										  <input  type='text' name='device' id='device' value='{{ $row['device'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Order Value" class=" control-label col-md-4 text-left"> Order Value </label>
										<div class="col-md-6">
										  <textarea name='order_value' rows='5' id='order_value' class='form-control form-control-sm '  
				           >{{ $row['order_value'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Order Details" class=" control-label col-md-4 text-left"> Order Details </label>
										<div class="col-md-6">
										  <textarea name='order_details' rows='5' id='order_details' class='form-control form-control-sm '  
				           >{{ $row['order_details'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Created At" class=" control-label col-md-4 text-left"> Created At </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('created_at', $row['created_at'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Updated At" class=" control-label col-md-4 text-left"> Updated At </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('updated_at', $row['updated_at'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Delivery Preference" class=" control-label col-md-4 text-left"> Delivery Preference </label>
										<div class="col-md-6">
										  <input  type='text' name='delivery_preference' id='delivery_preference' value='{{ $row['delivery_preference'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Ordertype" class=" control-label col-md-4 text-left"> Ordertype </label>
										<div class="col-md-6">
										  <input  type='text' name='ordertype' id='ordertype' value='{{ $row['ordertype'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Later Deliver Date" class=" control-label col-md-4 text-left"> Later Deliver Date </label>
										<div class="col-md-6">
										  <input  type='text' name='later_deliver_date' id='later_deliver_date' value='{{ $row['later_deliver_date'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Later Deliver Time" class=" control-label col-md-4 text-left"> Later Deliver Time </label>
										<div class="col-md-6">
										  <input  type='text' name='later_deliver_time' id='later_deliver_time' value='{{ $row['later_deliver_time'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Later Delivery Timestamp" class=" control-label col-md-4 text-left"> Later Delivery Timestamp </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('later_delivery_timestamp', $row['later_delivery_timestamp'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Free Delivery" class=" control-label col-md-4 text-left"> Free Delivery </label>
										<div class="col-md-6">
										  <input  type='text' name='free_delivery' id='free_delivery' value='{{ $row['free_delivery'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Boy Id" class=" control-label col-md-4 text-left"> Boy Id </label>
										<div class="col-md-6">
										  <input  type='text' name='boy_id' id='boy_id' value='{{ $row['boy_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Vendor Price Val" class=" control-label col-md-4 text-left"> Vendor Price Val </label>
										<div class="col-md-6">
										  <input  type='text' name='vendor_price_val' id='vendor_price_val' value='{{ $row['vendor_price_val'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Bad Weather Charge" class=" control-label col-md-4 text-left"> Bad Weather Charge </label>
										<div class="col-md-6">
										  <input  type='text' name='bad_weather_charge' id='bad_weather_charge' value='{{ $row['bad_weather_charge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Festival Mode Charge" class=" control-label col-md-4 text-left"> Festival Mode Charge </label>
										<div class="col-md-6">
										  <input  type='text' name='festival_mode_charge' id='festival_mode_charge' value='{{ $row['festival_mode_charge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Festival Mode Charge Perkm" class=" control-label col-md-4 text-left"> Festival Mode Charge Perkm </label>
										<div class="col-md-6">
										  <input  type='text' name='festival_mode_charge_perkm' id='festival_mode_charge_perkm' value='{{ $row['festival_mode_charge_perkm'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Del Charge Discount" class=" control-label col-md-4 text-left"> Del Charge Discount </label>
										<div class="col-md-6">
										  <input  type='text' name='del_charge_discount' id='del_charge_discount' value='{{ $row['del_charge_discount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Manager Id" class=" control-label col-md-4 text-left"> Manager Id </label>
										<div class="col-md-6">
										  <input  type='text' name='manager_id' id='manager_id' value='{{ $row['manager_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Manager Commission Percent" class=" control-label col-md-4 text-left"> Manager Commission Percent </label>
										<div class="col-md-6">
										  <input  type='text' name='manager_commission_percent' id='manager_commission_percent' value='{{ $row['manager_commission_percent'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Manager Commission Price" class=" control-label col-md-4 text-left"> Manager Commission Price </label>
										<div class="col-md-6">
										  <input  type='text' name='manager_commission_price' id='manager_commission_price' value='{{ $row['manager_commission_price'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Refund Id" class=" control-label col-md-4 text-left"> Refund Id </label>
										<div class="col-md-6">
										  <textarea name='refund_id' rows='5' id='refund_id' class='form-control form-control-sm '  
				           >{{ $row['refund_id'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Refund Order" class=" control-label col-md-4 text-left"> Refund Order </label>
										<div class="col-md-6">
										  <input  type='text' name='refund_order' id='refund_order' value='{{ $row['refund_order'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Refund Status" class=" control-label col-md-4 text-left"> Refund Status </label>
										<div class="col-md-6">
										  <input  type='text' name='refund_status' id='refund_status' value='{{ $row['refund_status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cancel Reason" class=" control-label col-md-4 text-left"> Cancel Reason </label>
										<div class="col-md-6">
										  <textarea name='cancel_reason' rows='5' id='cancel_reason' class='form-control form-control-sm '  
				           >{{ $row['cancel_reason'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Wallet Amount" class=" control-label col-md-4 text-left"> Wallet Amount </label>
										<div class="col-md-6">
										  <input  type='text' name='wallet_amount' id='wallet_amount' value='{{ $row['wallet_amount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cash Offer" class=" control-label col-md-4 text-left"> Cash Offer </label>
										<div class="col-md-6">
										  <input  type='text' name='cash_offer' id='cash_offer' value='{{ $row['cash_offer'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Is Dispute" class=" control-label col-md-4 text-left"> Is Dispute </label>
										<div class="col-md-6">
										  <input  type='text' name='is_dispute' id='is_dispute' value='{{ $row['is_dispute'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Dispute By" class=" control-label col-md-4 text-left"> Dispute By </label>
										<div class="col-md-6">
										  <input  type='text' name='dispute_by' id='dispute_by' value='{{ $row['dispute_by'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Dispute Category Id" class=" control-label col-md-4 text-left"> Dispute Category Id </label>
										<div class="col-md-6">
										  <input  type='text' name='dispute_category_id' id='dispute_category_id' value='{{ $row['dispute_category_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Dispute Reason" class=" control-label col-md-4 text-left"> Dispute Reason </label>
										<div class="col-md-6">
										  <textarea name='dispute_reason' rows='5' id='dispute_reason' class='form-control form-control-sm '  
				           >{{ $row['dispute_reason'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Dispute Status" class=" control-label col-md-4 text-left"> Dispute Status </label>
										<div class="col-md-6">
										  <input  type='text' name='dispute_status' id='dispute_status' value='{{ $row['dispute_status'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="When Dispute Raised" class=" control-label col-md-4 text-left"> When Dispute Raised </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('when_dispute_raised', $row['when_dispute_raised'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="When Dispute Closed" class=" control-label col-md-4 text-left"> When Dispute Closed </label>
										<div class="col-md-6">
										  
				<div class="input-group input-group-sm m-b" style="width:150px !important;">
					{!! Form::text('when_dispute_closed', $row['when_dispute_closed'],array('class'=>'form-control form-control-sm datetime')) !!}
					<div class="input-group-append">
					 	<div class="input-group-text"><i class="fa fa-calendar"></i></span></div>
					 </div>
				</div>
				 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Chef Received Amount" class=" control-label col-md-4 text-left"> Chef Received Amount </label>
										<div class="col-md-6">
										  <input  type='text' name='chef_received_amount' id='chef_received_amount' value='{{ $row['chef_received_amount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cancelled Customer Refund" class=" control-label col-md-4 text-left"> Cancelled Customer Refund </label>
										<div class="col-md-6">
										  <input  type='text' name='cancelled_customer_refund' id='cancelled_customer_refund' value='{{ $row['cancelled_customer_refund'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Razorpay Transfer Id" class=" control-label col-md-4 text-left"> Razorpay Transfer Id </label>
										<div class="col-md-6">
										  <input  type='text' name='razorpay_transfer_id' id='razorpay_transfer_id' value='{{ $row['razorpay_transfer_id'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cancelled Boy Del Charge" class=" control-label col-md-4 text-left"> Cancelled Boy Del Charge </label>
										<div class="col-md-6">
										  <input  type='text' name='cancelled_boy_del_charge' id='cancelled_boy_del_charge' value='{{ $row['cancelled_boy_del_charge'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Enc Order Id" class=" control-label col-md-4 text-left"> Enc Order Id </label>
										<div class="col-md-6">
										  <textarea name='enc_order_id' rows='5' id='enc_order_id' class='form-control form-control-sm '  
				           >{{ $row['enc_order_id'] }}</textarea> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> 					
									  <div class="form-group row  " >
										<label for="Cod Amount" class=" control-label col-md-4 text-left"> Cod Amount </label>
										<div class="col-md-6">
										  <input  type='text' name='cod_amount' id='cod_amount' value='{{ $row['cod_amount'] }}' 
						     class='form-control form-control-sm ' /> 
										 </div> 
										 <div class="col-md-2">
										 	
										 </div>
									  </div> </fieldset></div>

			<div style="clear:both"></div>	
				
					
				  <div class="form-group">
					<label class="col-sm-4 text-right">&nbsp;</label>
					<div class="col-sm-8">	
					<button type="submit" name="apply" class="btn btn-default btn-sm" ><i class="fa  fa-check-circle"></i> {{ Lang::get('core.sb_apply') }}</button>
					<button type="submit" name="submit" class="btn btn-default btn-sm" ><i class="fa  fa-save "></i> {{ Lang::get('core.sb_save') }}</button>
				  </div>	  
			
		</div> 
		 <input type="hidden" name="action_task" value="public" />
		 {!! Form::close() !!}
		 
   <script type="text/javascript">
	$(document).ready(function() { 
		
		 

		$('.removeCurrentFiles').on('click',function(){
			var removeUrl = $(this).attr('href');
			$.get(removeUrl,function(response){});
			$(this).parent('div').empty();	
			return false;
		});		
		
	});
	</script>		 
