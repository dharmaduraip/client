@extends('layouts.app')
@section('content')
<div class="mt-lg-5 mt-md-5 mt-sm-3">
	<div class="page-content-wrapper m-t">	 	
		<div class="sbox">
			<div class="sbox-title"> <h5> <i class="fa fa-table"></i> </h5>
				<div class="sbox-tools" >
					<a href="{{ URL::to('') }}" class="btn btn-xs btn-white tips" title="Clear Search" ><i class="fa fa-trash-o"></i> Clear Search </a>
				</div>
			</div>
			<div class="sbox-content"> 	
				<div class="toolbar-line ">
					<a href="javascript:void(0);" class="btn btn-success mis-report" data-id="{!!$orderData->id!!}" id="download">Download</a>
					<label>Order Id & Date :</label>
					{!! $orderData->id !!} & {!! $orderData->date !!}
					<div class="table-responsive tableFixHead" style="min-height:500px;">
						<table class="table table-striped " id="example1">
							<thead>
								<tr>
									<th>Sl.no</th>
									<th>Order Date</th>
									<th>Order ID</th>
									<th>Customer ID</th>
									<th>Customer Name</th>
									<th>Customer Mobile</th>
									<th>Customer Mail</th>
									<th>Delivery Address</th>
									<th>Store ID</th>
									<th>Store Name</th>
									<th>Store Address</th>
									<th>Store Price</th>
									<th>Total Base Price</th>
									<th>Gst Amount(of the item)</th>
									<th>Total Amount Hiked</th>
									<th>GST on Hiked Amount</th>
									<th>Final Product Price</th>
									<th>Delivery Fees</th>
									<th>Delivery Tax</th>
									<th>Conv. Fee</th>
									<th>Conv. Tax</th>
									<th>Total Cost</th>
									<th>Promo Code Discount</th>
									<th>Promo Amount</th>
									<th>Order Value</th>
									<th>Commission Percentage</th>
									<th>Commission Value</th>
									<th>Net Payable to Shop</th>
									<th>Total Earning</th>
									<th>Payment Mode</th>
									<th>Delivery Boy Name</th>
									<th>Pickup Travel in KM</th>
									<th>Delivery Travel In KM</th>
									<th>Total Travel</th>
									<th>Rate Per KM</th>
									<th>TA Earned</th>
									<th>Order Placed time</th>
									<th>Accepted Time</th>
									<th>Dispatched time</th>
									<th>Completed time</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$distance = \AbserveHelpers::getBoyTravelledReport($orderData->id);
								if(count(array($orderData))>0)
								{
									if($orderData->coupon_id>0){
										$coupon_code=\DB::table('abserve_promocode')->where('id',$orderData->coupon_id)->first();
										if($coupon_code){
											$Ccode=$coupon_code->promo_code;
										}else{
											$Ccode='';
										}
									}
									$order_items_old = \DB::table('abserve_order_items')->select(\DB::Raw('sum(base_price * quantity) as baseprice'),\DB::Raw('sum((price - base_price) * quantity) as gst_amount'),\DB::Raw('sum(hiking_gst_price * quantity) as hikingGstPrice'),\DB::Raw('sum(admin_cmsn_amt * quantity) as admin_cmsn_value'),\DB::Raw('sum(((base_price - admin_cmsn_amt) + vendor_gstamount) * quantity) as netPayableShop'),\DB::Raw('sum((hiking_price) * quantity) as totalHikingPrice'),\DB::Raw('sum((hiking_gst_price) * quantity) as totalHikingGST'),\DB::Raw('sum((base_price + base_price_gst + hiking_price + hiking_gst_price) * quantity) as finalPPrice'),'food_item','quantity')->where('orderid',$orderData->id)->where('check_status','yes')->first();
									$order_items = \DB::table('abserve_order_items')->select(\DB::Raw('sum((price / (100+gst))*100) as baseprice'),\DB::Raw('sum((price - (price / (100+gst))*100)) as gst_amount'),\DB::Raw('sum(price) as store_price'),\DB::Raw('sum(hiking_gst_price * quantity) as hikingGstPrice'),\DB::Raw('sum(admin_cmsn_amt * quantity) as admin_cmsn_value'),\DB::Raw('sum(((base_price - admin_cmsn_amt) + vendor_gstamount) * quantity) as netPayableShop'),\DB::Raw('sum((hiking_price) * quantity) as totalHikingPrice'),\DB::Raw('sum((hiking_gst_price) * quantity) as totalHikingGST'),\DB::Raw('sum((base_price + base_price_gst + hiking_price + hiking_gst_price) * quantity) as finalPPrice'),'food_item','quantity')->where('orderid',$orderData->id)->where('check_status','yes')->first();
									$i=1;
									?>
									<tr>
										<td>{{ $i++ }}</td>
										<td>{!!date('d-m-Y',strtotime($orderData->date))!!}</td>
										<td>{!!$orderData->id!!}</td>
										<td>{!!$orderData->cust_id!!}</td>
										<td>{!!\AbserveHelpers::getuname($orderData->cust_id)!!}</td>
										<td>{!!\AbserveHelpers::getumobile($orderData->cust_id)!!}</td>
										<td>{!!\AbserveHelpers::getuemail($orderData->cust_id)!!}</td>
										<td class="add">{!!$orderData->address!!}</td>
										<td>{!!$orderData->res_id!!}</td>
										<td>{!!\AbserveHelpers::restsurent_name($orderData->res_id)!!}</td>
										<td class="add">{!!\AbserveHelpers::restsurent_address($orderData->res_id)!!}</td>
										<td>{{-- {!!number_format($orderData->total_price,2)!!} --}} {!!number_format($order_items->store_price,2)!!}</td>
										<td>{!!number_format($order_items->baseprice,2)!!}</td>
										<td>{!!number_format($order_items->gst_amount,2)!!}</td>
										<td>{!!number_format($order_items->totalHikingPrice,2)!!}</td>
										<td>{!!number_format($order_items->totalHikingGST,2)!!}</td>
										<td>{!!number_format($order_items->finalPPrice,2)!!}</td>
										<td>{!!number_format($orderData->del_charge,2)!!}</td>
										<td>{!!number_format($orderData->del_charge_tax_price,2)!!}</td>
										<td>{!!number_format(0,2)!!}</td>
										<td>{!!number_format(0,2)!!}</td>
										<td>{!!number_format($orderData->accept_grand_total,2)!!}</td>
										<td>{{-- !!$Ccode!! --}} {!!$orderData->coupon_value!!}</td>
										<td>{!!number_format($orderData->accept_coupon_price,2)!!}</td>
										<td>{!!number_format($orderData->accept_grand_total,2)!!}</td>
										<td>{!!$orderData->comsn_percentage!!}</td>
										<td>{{-- number_format($orderData->fixedCommission,2) --}} {!!number_format($order_items->admin_cmsn_value,2)!!}</td>
										<td>{!!number_format($order_items->netPayableShop,2)!!}</td>
										<td>{!!number_format(($orderData->accept_grand_total - $order_items->netPayableShop),2)!!}</td>
										<td>{!!$orderData->delivery_type!!}</td>
										<td>{!!\AbserveHelpers::getboyname($orderData->id)!!}</td>
										<td>{{ $distance['pickup'] }} KM</td>
										<td>{{ number_format($distance['delivery'],2) }} KM</td>
										<?php $del_dist = number_format($distance['total'],2) ?>
										<td>{{ $del_dist }} KM</td>
										<?php $api_settings= \DB::table('tb_settings')->select('delivery_boy_charge_per_km')->first(); 
										$rate= $api_settings->delivery_boy_charge_per_km; 
										$ta_earn = ($api_settings->delivery_boy_charge_per_km) * $del_dist;?>
										<td>{{ number_format($rate,2)  }} KM </td>
										<td>{{ number_format($ta_earn,2)  }} </td>
										<td>{{date('g:i a',$orderData->time)}}</td>
										<td>@if($orderData->accepted_time>0) {!!date('d-m-Y h:i a',$orderData->accepted_time)!!} @endif</td>
										<td>@if($orderData->dispatched_time>0) {!!date('d-m-Y h:i a',$orderData->dispatched_time)!!} @endif</td>
										<td>@if($orderData->completed_time>0) {!!date('d-m-Y h:i a',$orderData->completed_time)!!} @endif</td>
									<?php }	?>	
								</tr>
							</tbody>
						</table>
						<table class="table table-striped" id="example1">
							<thead>
								<tr>
									<th>Sl.NO</th>
									<th>ITEM NAME</th>
									<th>QUANTITY ORDERD</th>
									<th>MRP ( Shop Price )</th>
									<th>GST % APPLICABLE</th>
									<th>BASE PRICE (OF THE ITEM)</th>
									<th>GST AMOUNT (OF THE ITEM)</th>
									<th>BASE PRICE * QUANTITY ORDERED</th>
									<th>GST * QUANTITY ORDERED</th>
									<th>TOTAL VALUE</th>
									<th>ADMIN COMM. %</th>
									<th>ADMIN COMM. AMOUNT</th>
									<th>PAYANLE AMOUNT TO VENDOR / SHOP</th>
									<th>GST ON PAYABLE AMOUNT TO VENDOR / SHOP</th>
									<th>NET PAYABLE TO VENDOR / SHOP</th>
									<th>HIKED %</th>
									<th>AMOUNT HIKED * Qnty.</th>
									<th>GST AMOUNT</th>
									<th>TOTAL COST OF THE ITEM DISPLAYED (to cutomer)</th>
								</tr>
							</thead>
							<tbody>  
								<?php    						
								$order_items = \DB::table('abserve_order_items')->select('*')->where('orderid',$orderData->id)->where('check_status','yes')->get();
								if(!empty($order_items))
								{
									foreach($order_items as $k => $v)
									{
										$rest=\DB::table('abserve_restaurants')->select('commission')->find($orderData->res_id);
										$original= ($v->price / (100 + $v->gst)) * 100;
										$gst_price = ($original * ($v->gst / 100));
										$base = $v->quantity * $original;
										$gst_quan = $v->quantity * $gst_price;
										$tot_val= ($v->quantity * $original) + ($v->quantity * $gst_price);
										$admin_com_amt = ($original * ($rest->commission / 100));
										$admin_com=($v->quantity * $admin_com_amt);
										$payanle=(($v->quantity * $original) - $admin_com);
										$gst_payable=(($v->gst/100)*$payanle);
										$net_payable = ($payanle + $gst_payable);
										$amt_hike = ($v->quantity * $original * ($v->hiking/100));
										$gst_amt=(($v->gst/100)*$amt_hike);
										$tot= (($v->price* $v->quantity) + $amt_hike + $gst_amt) ;
										$quant = 0;$price = 0;$base_p = 0;$base_pr = 0;$tot_v = 0;
										$gst_qu = 0;$tot_v = 0;$base_p_gst = 0;$ac=0;$pay=0;$gst_pay=0;$net_pay = 0;$amt_hi = 0;$gstamt = 0;$tot_price = 0;
										$quant += $v->quantity;
										$price += $v->price;
										$base_p += $v->base_price;
										$base_p_gst += $v->base_price_gst;
										$base_pr += $base;
										$gst_qu += $gst_quan;
										$tot_v +=$tot_val;
										$ac +=$admin_com;
										$pay += $payanle;
										$gst_pay += $gst_payable;
										$net_pay +=$net_payable;
										$amt_hi +=$amt_hike;
										$gstamt += $gst_amt;
										$tot_price += $tot;	
										$e= 0;
										?>
										<tr>
											<td> {{ ++$e }} </td>	
											<td>{!!$v->food_item!!}</td>
											<td>{!!$v->quantity!!}</td>
											<td>{!!$v->price!!}</td>
											<td>{!!$v->gst!!}</td>
											<td>{!!number_format($original,2)!!}</td>
											<td>{!! number_format($gst_price,2) !!}</td>
											<td>{!!number_format($base,2)!!}</td>
											<td>{!!number_format($gst_quan,2)!!}</td>
											<td>{!!number_format($tot_val,2)!!}</td>
											<td>{!!$rest->commission!!}</td>
											<td>{!!number_format($admin_com,2)!!}</td>
											<td>{!!number_format( $payanle,2)!!}</td>
											<td>{!!number_format($gst_payable,2)!!}</td>
											<td>{!!number_format($net_payable,2)!!}</td>
											<td>{!!number_format($v->hiking,2)!!}</td>
											<td>{!!number_format($amt_hike,2)!!}</td>
											<td>{!!number_format($gst_amt,2)!!}</td> 
											<td>{!!number_format($tot,2)!!}</td>
										</tr>
										<tr>
											<td></td>
											<td></td>
											<td> {{ $quant }}</td>
											<td> {{ $price }}</td>
											<td> </td>
											<td> {{ $base_p }}</td>
											<td> {{ $base_p_gst }}</td>
											<td> {{ number_format($base_pr,2) }}</td>
											<td> {{ number_format($gst_qu,2) }}</td>
											<td> {{  number_format($tot_v,2) }}</td>
											<td></td>
											<td> {{ number_format($ac,2) }}</td>
											<td> {{ number_format($pay,2) }}</td>
											<td> {{ number_format($gst_pay,2) }}</td>
											<td> {{ number_format($net_pay,2) }}</td>
											<td></td>
											<td> {{ number_format($amt_hi,2) }}</td>
											<td> {{ number_format($gstamt,2) }} </td>
											<td> {{  number_format($tot_price,2) }}</td>
										<?php }?>
									<?php }?>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).on('click','.mis-report',function(){
$(".loader_event").show();
var id = $("#download").attr("data-id");
$.ajax({
type:'POST',
url:"{{ URL::to('') }}/misreport/download",
dataType: 'json',
data:{'id':id},
success:function(data){
var res=data.split("~");
if(res[0]=='0'){
window.location.href=("{{ URL::to('') }}/resources/views/phpexcel/file/"+id+"mis_report_.xlsx");
}else{
alert('Somthing error.Try again');
}
$(".loader_event").hide();
}
});
})
</script>
@endsection