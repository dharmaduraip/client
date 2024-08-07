<style type="text/css">
	.addgst tr td{
		border: 1px solid #ddd;
		padding: 5px;
		width: 15%;
		white-space: nowrap;
	}

	.addgst1 td {
		padding: 5px;
		border:1px solid #ddd;
		white-space: nowrap;
	}
	.addgst1{
		width: 74%;
		float: right;
	}
	.addgst{
		float: right;
	}
</style>
@if($check=='')
<div class="modal-header head-modal align-items-start flex-row-reverse order-pg">
	<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
	<div class="pull-right address-section">
		<span class="label status {!! $aOrder->status_label !!}">{!! $aOrder->status_text !!}</span>
		@if($order->delivery_type != '')
		<div class="datetime">Payment Type : &nbsp;
			@if($order->refund_status == 1)Refunded @else
			{!! ($order->delivery_type =='cashondelivery' ? 'COD' : 'ONLINE')  !!}
			@endif
		</div>
		@endif
		<div class="datetime">Payment Status : &nbsp;
			@if($order->refund_status == 1)Refunded @else
			{!! ($order->delivery =='paid' ? 'Paid' : 'Unpaid')  !!}
			@endif
		</div>
	</div>
	<div class="">
		<h4 class="modal-title mod-tittle">
			<span class="side-title">Order ID :</span> #{!! $aOrder->id !!} - {!! $aOrder->restaurant_info->name !!}  <label class='label label-info'>Deliver {!! $aOrder->delivery_preference !!}</label>
			<div class="datetime"><span class="side-title">Order Date :</span> &nbsp;{!! $aOrder->created_at !!} </div>
			@if($aOrder->delivery_preference == 'later')
			<div class="datetime"><span class="side-title">Delivery Date :</span> &nbsp;{!! $aOrder->later_deliver_date !!}&nbsp;{!! $aOrder->later_deliver_time !!} </div>
			@endif
		</h4>
		@if(Auth::user()->group_id=='1' || Auth::user()->group_id == '2')
		<a href="{!!url('orderinvoice/'.$aOrder->id)!!}" class="btn btn-warning"><i class ="fa-fa-download"></i>Download</a>@endif
	</div>
</div>
<div class="modal-body">
	<div class="row ord-his">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="d-flex flex-wrap justify-content-between">
				<div class="detail-user col-md-5 mb-sm-2" >
					<h3>Customer</h3>
					<p><span class="side-title">Name :</span> {!! $aOrder->user_info->username !!}</p>
					<p><span class="side-title">Address :</span> {!! $aOrder->address !!}</p>
					@if(\Auth::user()->group_id!='3' && \Auth::user()->group_id!='4')
					{{-- <p><span class="side-title">Email :</span> {!! $aOrder->user_info->email!!}</p> --}}
					<p><span class="side-title">Phone :</span> {!! $aOrder->mobile_num !!}</p>
					@endif
				</div>
				{{-- <div class="col-md-2"></div> --}}
				<div class="detail-user col-md-5 mb-sm-2">
					<h3>Shop</h3>
					<p><span class="side-title">Name :</span> {!! $aOrder->restaurant_info->name !!}</p>
					<p><span class="side-title">Address :</span>
						{{--@if(\Auth::user()->group_id!='4')--}}
						{!! $aOrder->restaurant_info->location !!}
						{{--@else
						{!! $aOrder->restaurant_info->city !!}
						@endif--}}
					</p>
					@if(Auth::user()->group_id=='1')
					{{-- <p><span class="side-title">Email :</span> {!! $aOrder->partner_info->email !!}</p> --}}
					@if(substr($restaurant->phone, 0, 1)==0)<?php $mble=$restaurant->phone;?>  @else <?php $mble='0'.$restaurant->phone;?> @endif
					<p><span class="side-title">Phone :</span> {!! $mble!!}</p>@endif
				</div>
			</div>
		</div>
	</div>
	<div class="row ord-his">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="itemdetails table-responsive">
				<table class="table table-bordered table-striped table-hover mb-3">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Product Item</th>
							{{-- <th>Adon Detail</th> --}}
							<th>Price</th>
							<th>GST (%)</th>
							{{-- <th>Selling Price</th>
							<th>Original Price</th> --}}
							<th>Quantity</th>
							<th>Total</th>
						</tr>	
					</thead>
					<tbody>
						<tr>
						<?php
							$comm = $order->comsn_percentage;$comm_val = $comm /100;
							if ($aOrder->id == '1055') {
								//echo "<pre>";print_r($aOrder->order_items);exit();
							}
						?>
						@if(count($aOrder->order_items) > 0)
						@foreach($aOrder->order_items as $key => $value)
						<tr>
							<td>{!! $key + 1 !!}</td>
							<td>{!! $value->food_item!!} <span style="color:red;">{!! $value->availability == 0 ? '(Currently unavailable)' : ' '; !!}</span></td>
							{{-- <td>{!! $value->adon_detail!!}</td> --}}
							<td>{!! $cur_symbol !!}&nbsp;{!! number_format(((float)$value->mrpselling),2) !!}</td>
							<td>@if($value->gst > 0){!! $value->gst !!} - {!! (($value->hiking_gst_price + $value->base_price_gst) * $value->quantity) !!}@endif</td>
							{{-- <td>{!! $cur_symbol !!}&nbsp;{!! number_format(((float)$value->vendor_price ),2) !!}</td> --}}
							<td>{!! $value->quantity !!}</td>
							<td>{!! $cur_symbol !!}&nbsp;{!! number_format(((float)$value->mrp),2) !!}</td>
						</tr>
						@endforeach
						<tr>
							@if(!empty($aOrder->inaugural_offer) && $aOrder->inaugural_offer['isfirst'])
							<td style="background-color:#baf8f9"></td>
							<td style="background-color:#baf8f9">{!! $aOrder->inaugural_offer['offer_name'] !!}</td>
							<td style="background-color:#baf8f9;color: #008000;">FREE</td>
							<td ></td>
							@else
							<td ></td>
							<td ></td>
							<td ></td>
							<td ></td>
							@endif
							<td style="font-weight: bold;">Item Price</td>
							<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->total_price !!}</td>
						</tr>
						@if(\Auth::user()->group != 3)
						<!-- Showing only selected items End -->
						@if($aOrder->offer_price > 0)
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td style="font-weight: bold;">Offer Price</td>
							<td style="font-weight: bold;">-{!! $cur_symbol !!} {!! $aOrder->offer_price !!}</td>
						</tr>
						@endif
						@if($aOrder->s_tax1 > 0)
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td style="font-weight: bold;">Service Tax</td>
							<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->s_tax1 !!}</td>
						</tr>
						@endif
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">{!! 'Delivery Charge - ('.$aOrder->del_km.' KM)' !!})</td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->del_charge !!}</td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">Delivery Charge Tax</td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->del_charge_tax_price !!}</td>
					</tr>
					@if($aOrder->add_del_charge > 0)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">Packaging Charge (Incl. GST) </td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->add_del_charge !!}</td>
					</tr>
					@endif
					@if($aOrder->bad_weather_charge > 0)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">Bad Weather Charge (Incl. GST)</td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->bad_weather_charge !!}</td>
					</tr>
					@endif
					@if($cash_back > 0)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">Cash back offer</td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $cash_back !!}<span style="color:red;">( - )</span></td>
					</tr>
					@endif
					@if($aOrder->festival_mode_charge > 0)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;"> Festival Charge (Incl. GST) </td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->festival_mode_charge !!}</td>
					</tr>
					@endif
					@if($aOrder->del_charge_discount > 0)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">Delivery Charge Discount</td>
						<td style="font-weight: bold;">-{!! $cur_symbol !!} {!! $aOrder->del_charge_discount !!}</td>
					</tr>
					@endif
					@if($aOrder->coupon_price > 0)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">Coupon Discount</td>
						<td style="font-weight: bold;">-{!! $cur_symbol !!} {!! $aOrder->coupon_price !!}</td>
					</tr>
					@endif
					@if($aOrder->wallet_amount > 0)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">Wallet amount</td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->wallet_amount !!} <span style="color:red;">( - )</span></td>
					</tr>
					@endif
					@if($aOrder->gst > 0)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">GST</td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} {!! $aOrder->gst !!}</td>
					</tr>
					@endif
					@endif
					<tr>
						<td style="border:none"></td>
						<td style="border:none"></td>
						<td></td>
						<td></td>
						<td style="font-weight: bold;">Grand Total</td>
						<td style="font-weight: bold;">{!! $cur_symbol !!} 
							{!! $aOrder->grand_total !!}
						</td>
					</tr>
					<!-- Showing only selected items Start -->
					<?php $TotPrice = 0;$price = 0; ?>
					@if($aOrder->status != '0' && $aOrder->status != '5')	
					<tr><td colspan="6"> </td></tr>
					<tr><td colspan="6"> <b>ACCEPTED ITEMS:</b> </td></tr>
					<tr><td colspan="6"></td></tr>

					@if(count($aOrder->accepted_order_items) > 0)
					@foreach($aOrder->accepted_order_items as $k => $v)
					<!-- Total price calculation -->
					<tr>
						<?php $TotPrice += $v->quantity * ((float) $v->selling_price ); 
						$price += $v->base_price+ $v->hiking_price;
						?>
						<td>{!! $k + 1 !!}</td>
						<td>{!! $v->food_item!!} <span style="color:red;">{!! $v->availability == 0 ? '(Currently unavailable)': ' ' !!}</span></td>
						{{-- <td>{!! $v->adon_detail!!}</td> --}}
						<td>{!! $cur_symbol !!}&nbsp;{!! number_format(((float) $v->mrpselling ),2) !!}</td>
						<td>@if($v->gst > 0){!! $v->gst !!} - {!! (($v->hiking_gst_price + $v->base_price_gst) * $v->quantity) !!}@endif</td>
						{{-- <td>{!! $cur_symbol !!}&nbsp;{!! number_format(((float)$v->vendor_price ),2) !!}</td> --}}
						<td>{!! $v->quantity !!}</td>
						<td>{!! $cur_symbol !!}&nbsp;{!! number_format(((float)$v->mrp  ),2) !!}</td>
					</tr>
					@endforeach
					@endif

				</table>
				<table class="table table-bordered table-striped table-hover mb-3" style="border-spacing: 0; border-width: 0; padding: 0; border-width: 0;background: white;">
					<tr>
						<td>
							@if(Auth::user()->group_id=='1' || Auth::user()->group_id == '2')
							<table  style="width:100%;background: white;">
								<tbody>
									<tr>
										<td width="50%">
											<table class="addgst">
												<?php $id = $aOrder->id;
												$bifur = AbserveHelpers::GSTBifurcation($id);
												$delcharge = 0;$tGst = 0;$tPrice = 0;$festival_charge = 0;
												$weather_charge = 0;$packaging_charge=0;$festival_tax = 0;$weather_tax= 0;$packaging_tax= 0;
												$del_tax = 0;
												?>
												@if($bifur > 0)
												@foreach($bifur as $key => $val)
												<?php
												$per_val = (100/18);
												if($aOrder->add_del_charge > 0){
													$packaging_tax = number_format(($aOrder->add_del_charge / $per_val),2) ;
													$packaging_charge = number_format(($aOrder->add_del_charge - $packaging_tax),2);
												}
												if($aOrder->festival_mode_charge > 0){
													$festival_tax =  number_format(($aOrder->festival_mode_charge / $per_val),2) ;
													$festival_charge = number_format(($aOrder->festival_mode_charge - $festival_tax),2) ; 
												}
												if($aOrder->bad_weather_charge > 0){
													$weather_tax =  number_format(($aOrder->bad_weather_charge / $per_val),2);
													$weather_charge = number_format(($aOrder->bad_weather_charge - $weather_tax),2) ; 
												}
												$delcharge = $aOrder->del_charge;
												$del_tax = $aOrder->del_charge_tax_price;
												$tGst	+= array_sum($val['gst']);
												$tPrice	+= array_sum($val['price']);
												$gst 	= array_sum($val['gst']);
												$price_gst = array_sum($val['price']);
												?>
												<tr>
													<td colspan="2"><strong>{{ $key }} % GST </strong></td>

													@if($key == "18")
													<td colspan="2">{!! abs($price_gst + $delcharge + $packaging_charge + $festival_charge + $weather_charge) !!}</td>
													<td colspan="2">{!! $gst + $del_tax + $packaging_tax + $festival_tax + $weather_tax !!}</td>
													@else
													<td colspan="2">{{ abs($price_gst) }} </td>
													<td colspan="2">{{ $gst }} </td>
													@endif
												</tr>
												@endforeach
												@if(!(array_key_exists("18",$bifur)))
												<tr>
													<td colspan="2"><strong>18% GST </strong></td>
													<td colspan="2">{!! abs($delcharge + $packaging_charge + $festival_charge + $weather_charge) !!}</td>
													<td colspan="2">{!! $del_tax + $packaging_tax + $festival_tax + $weather_tax!!}</td>
												</tr>
												@endif
												<td colspan="2"><strong>Total GST = </strong></td>
												<td colspan="2"></td>
												<td colspan="2">{{ $tGst + $del_tax + $packaging_tax + $festival_tax + $weather_tax }}</td>
											</table>
											@endif
											@endif
										</td>

										<td style="float:right;width: 100%;">
											<table class="addgst1">
												@if($TotPrice != 0)
												<tr>
													<td colspan="4" style="font-weight: bold;">Accepted Item Price</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! number_format($TotPrice, 2,'.','') !!}</td>
												</tr>
												@endif
												@if(\Auth::user()->group != 3)
												@if($aOrder->offer_price > 0)
												<tr>
													<td colspan="4" style="font-weight: bold;">Offer Price</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">-{!! $cur_symbol !!} {!! $aOrder->offer_price !!}</td>
												</tr>
												@endif
												@if($aOrder->s_tax1 > 0)
												<tr>
													<td colspan="4" style="font-weight: bold;">Service Tax	</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! $aOrder->s_tax1 !!}</td>
												</tr>
												@endif
												<tr>
													<td colspan="4" style="font-weight: bold;">Delivery Charge(Incl. GST)</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! ($aOrder->del_charge + $aOrder->del_charge_tax_price)  !!}</td>
												</tr>
												@if($aOrder->add_del_charge > 0)
												<tr>
													<td colspan="4" style="font-weight: bold;">Packaging Charge (Incl. GST) </td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! $aOrder->add_del_charge !!}</td>
												</tr>
												@endif
												@if($aOrder->cash_offer > 0)
												<tr>
													<td colspan="4" style="font-weight: bold;">Cash back offer : </td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! $aOrder->cash_offer  !!}<span style="color:red;">( - )</span></td>
												</tr>
												@endif
												@if($aOrder->bad_weather_charge > 0)
												<tr>

													<td  colspan="4" style="font-weight: bold;">Bad Weather Charge (Incl. GST)</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! $aOrder->bad_weather_charge !!}</td>
												</tr>
												@endif
												@if($aOrder->festival_mode_charge > 0)
												<tr>
													<td  colspan="4" style="font-weight: bold;">Festival Mode Charge (Incl. GST)- {!! $cur_symbol !!}{!! $aOrder->festival_mode_charge_perkm !!}/Km</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! $aOrder->festival_mode_charge !!}</td>
												</tr>
												@endif
												@if($aOrder->del_charge_discount > 0)
												<tr>
													<td colspan="4" style="font-weight: bold;">Delivery Charge Discount</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">-{!! $cur_symbol !!} {!! $aOrder->del_charge_discount !!}</td>
												</tr>
												@endif
												@if($aOrder->accept_coupon_price > 0)
												<tr>
													<td colspan="4" style="font-weight: bold;">Coupon Discount</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">-{!! $cur_symbol !!} {!! $aOrder->accept_coupon_price !!}</td>
												</tr>
												@endif
												@if($aOrder->wallet_amount > 0)
												<tr>
													<td  colspan="4" style="font-weight: bold;">Wallet amount</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! $aOrder->wallet_amount !!} <span style="color:red;">( - )</span></td>
												</tr>
												@endif
												<?php  if($wallet != '') {
													$wallet= $wallet;
												} else {
													$wallet = 0;
												} ?>
												<tr>
													<td colspan="4" style="font-weight: bold;">Amount Refunded @if(Auth::user()->group_id=='1') (Customer wallet)@endif	</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;white-space: nowrap;">{!! $cur_symbol !!} {!! number_format($wallet,2) !!} </td>
												</tr>
												@if($aOrder->gst > 0)
												<tr>
													<td  colspan="4" style="font-weight: bold;">GST</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!} {!! $aOrder->gst !!}</td>
												</tr>
												@endif
												@endif
												<tr>
													<td colspan="4" style="font-weight: bold;">Grand Total</td>
													<td style="font-weight: bold;text-align:right;padding-right: 13px;">{!! $cur_symbol !!}
														<!--{!! abs($aOrder->accept_grand_total - $aOrder->cash_offer + $aOrder->gst + $aOrder->s_tax1) !!}-->
														{!! abs($aOrder->accept_grand_total) !!}
													</td>
												</tr>
												@endif
												@endif
											</table>
										</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</table>
				<table class="table table-bordered table-striped table-hover mb-3">
					<thead>
						<tr>
							<th>Status</th>
							<th>Timing</th>
						</tr>	
					</thead>
					<tbody>
						@foreach ($aOrder->getOrderTiming as $row)
						<tr>
							<td>
								{!! \AbserveHelpers::getStatusTiming($row->status); !!}
							</td>
							<td>{!! $row->updated_at !!}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				@if(!empty($boy))
				<div class="boy-detail">
					<h3> Delivery Boy Details 
						{{-- <button type="button" data-orderid="{!! $order->id !!}" class="btn btn-primary trackDeliveryBoy">Track</button> --}} </h3>
						<p><span class="side-title"> Name : </span> {!! $boy->username !!}</p>
						<p><span class="side-title"> Phone : </span>{!! $boy->phone_number !!}</p>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="trackDeliveryBoy-content">
					</div>
					@endif
				</div>
			</div>
			@if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 3 )
			{{-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="detail-user col-md-12">
					<h3>User Wise Charges</h3>
					<p>
						@if(\Auth::user()->group_id == 1 )
						<div class="tooltip-box"><p><span class="side-title">Admin</span>&emsp; {!! $cur_symbol !!} {!! $aOrder->admin_share !!}</p>
							<span class="tooltipcontent">{!! $aOrder->admin_share_text !!}</span>
						</div>

						<div class="tooltip-box"><p><span class="side-title">Boy</span>&emsp;&emsp;&nbsp; {!! $cur_symbol !!} {!! $aOrder->boy_share !!}</p>
							<span class="tooltipcontent">{!! $aOrder->host_share_text !!}</span>
						</div>
						@endif
						<div class="tooltip-box"><p><span class="side-title">Host</span>&emsp;&nbsp;&nbsp; {!! $cur_symbol !!} {!! $aOrder->host_share !!}</p>
							<span class="tooltipcontent">{!! $aOrder->host_share_text !!}</span>
						</div>
					</p>
				</div>
			</div> --}}
			@endif
		</div>
		@else
		<div class="modal-header">
			<b>Order #{{$aOrder->id}}</b>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
		<div class="modal-body">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<p><b>{{$restaurant->name}}</b> {{$restaurant->location}}</p>
				<p></p>
			</div>
			<table class="table table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>
							<div class="form-check">
								<input type="checkbox"  class="checkall" id="checkall" >
							</div></th>
							<th>S.No</th>
							<th>Product Item</th>
							<th>Adon Detail</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
						</tr>	
					</thead>
					<tbody>
						@if(count($aOrder->order_items) > 0)
						@foreach($aOrder->order_items as $key => $value)
						<tr>
							<td>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="check" data-id="{{ $value->id }}" data-price="{{ number_format(((float)$value->selling_price_total),2) }}" id="flexCheckDefault_{{$key}}">
								</div>
							</td>
							<td>{!! $key + 1 !!}</td>
							<td>{!! $value->food_item!!}</td>
							<td>{!! $value->adon_detail!!}</td>
							<?php $price = (\Auth::user()->group_id == 1 ) ? $value->selling_price : $value->vendor_price; ?>
							<td>{!! $cur_symbol !!}&nbsp;{!! number_format(((float)$price),2) !!}</td>
							<td>{!! $value->quantity !!}</td>
							<?php $totalprice = (\Auth::user()->group_id == 1 ) ? $value->selling_price_total : $value->original_price_total; ?>
							<td>{!! $cur_symbol !!}&nbsp;{!! number_format($totalprice,2) !!}</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
				<p><b>Notes : </b> {{$aOrder->order_note}}</p>
				<p><b>Delivery Preference : </b> {{$aOrder->delivery_preference}}</p>
				<table class="table table-bordered table-striped table-hover col-md-offset-3 " style="width:500px;">
					<thead>
						<tr>
							<th colspan="2">Order Detail Description</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Total Item Count</td>
							<td>{{ count($aOrder->order_items) }}</td>
						</tr>
						<tr>
							<td>Item Checked Count</td>
							<td id="item_checked">0</td>
						</tr>
						<tr>
							<td>Total Price</td>
							<td>{!! $cur_symbol !!} {!! $aOrder->total_price !!}</td>
						</tr>
						<tr>
							<td>Item Checked Price</td>
							<td>{!! $cur_symbol !!} <span id="checked_price">0</span></td>
						</tr>
						{{-- <tr>
							<td>Amount To Refund (Customer wallet)</td>
							<td>{!! $cur_symbol !!} <span id="refund_price">{!! $aOrder->total_price !!}</span></td>
						</tr> --}}
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success fn_accept arcls" data-oid="{{ $aOrder->id }}" data-partner="{{ $aOrder->partner_id }}" data-selected="" style="display:none;" id="show_accept">Accept</button>
				<button type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
			</div>
			@endif
			<script>

				$(document).ready(function() {
					$("#checkall").change(function(){
						$(".form-check-input").prop("checked",$(this).prop("checked"))
					})
					$(".form-check-input").change(function(){
						if($(this).prop("checked")==false){
							$("#checkall").prop("checked",false)
						}
						if($(".form-check-input:checked").length==$(".form-check-input").length){
							$("#checkall").prop("checked",true)
						}

					})


				$('.checkall').change(function(){
					$("#show_accept").hide();
					var selected_item = [];
					var total = "{{ $aOrder->total_price }}";
					var checkboxes = $('.form-check-input:checkbox:checked').length;
					$('#item_checked').html(checkboxes);
					var price =  refund = 0; 
					$.each($(".form-check-input:checkbox:checked"), function(){
						$("#show_accept").hide();
						price = parseFloat(price) + parseFloat($(this).attr("data-price"));
						selected_item.push($(this).attr("data-id"));
					});
					refund = total - price;
					$("#checked_price").html(price);
					$("#refund_price").html(refund);
					if(checkboxes>0)
					{
						$("#show_accept").show();
						$("#show_accept").attr("data-selected",selected_item);
					}

				})


				$('.form-check-input').click(function() {	
					$("#show_accept").hide();
					var selected_item = [];
					var total = "{{ $aOrder->total_price }}";
					var checkboxes = $('.form-check-input:checkbox:checked').length;
					$('#item_checked').html(checkboxes);
					var price =  refund = 0; 
					$.each($(".form-check-input:checkbox:checked"), function(){
						$("#show_accept").hide();

						price = parseFloat(price) + parseFloat($(this).attr("data-price"));
						selected_item.push($(this).attr("data-id"));
					});
					refund = total - price;
					$("#checked_price").html(price);
					$("#refund_price").html(refund);
					if(checkboxes>0)
					{
						$("#show_accept").show();
						$("#show_accept").attr("data-selected",selected_item);
					}
				})	
				});	

			</script>
			<script>
				$(".close").click(function(){
					$("#orderModal").modal('hide');
				});
			</script>
			<style type="text/css">
				.btn-close{background-color:}
				.ord-his{
					margin-bottom: 20px;
				}
				.detail-user p{
					margin-bottom: 5px;
					margin-top: 10px;
				}
				.detail-user{
					border: 1px solid #ccc;
					line-height: 20px
				}
				.address-section{margin-right: 12px;}
				.address-section .datetime{margin-top: 5px;}
				.address-section .label-success{padding: 5px 7px;font-size: 13px;margin-bottom: 12px;}
				.boy-detail{ line-height: 3px;margin-left: 10px;margin-bottom: 20px;}
				.btn-default.btn-close{background-color:#ed5565;font-weight:bold;}
				.side-title{font-weight:bold;color: #212121;}
				.mod-tittle{font-weight:normal;}
				.tooltip-box {
					position: relative;
					display: block;
					cursor: pointer;
				}

				.tooltip-box .tooltipcontent {
					visibility: hidden;
					background-color: #172028;
					color: #fff;
					text-align: center;
					border-radius: 6px;
					padding: 5px 10px;
					position: absolute;
					z-index: 1;
					bottom: 130%;
					left: 6%;
					margin-left: -60px;
					width: max-content;
					font-weight: 400;
					font-size: 14px;
				}

				.tooltip-box:hover .tooltipcontent {
					visibility: visible;
				}
			</style>