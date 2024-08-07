<?php namespace App\Http\Controllers;

use App\Http\Controllers\controller;
use App\Http\Controllers\PayPalRefund;
use App\Http\Controllers\lib\Twocheckout;
use Omnipay\TwoCheckout\Gateway;
use App\Models\Payment;
use App\User;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\URL;
use App\Models\Restaurant;
use App\Models\Partnertransac;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, Response ; 
use Omnipay\Omnipay;
use Session, DB, DateTime, Auth;
use App\Library\PaypalComponent;		
use App\Library\paypal;
use App\Http\Controllers\mobile\UserController as notification;
use App\Http\Controllers\FrontEndController as frontCon;
use Razorpay\Api\Api;
// require_once(app_path('Http/Controllers/stripe/Stripe.php'));
class OmniPaymentController extends Controller {

	public function paypalValues()
	{
		$values = \DB::table('abserve_paypal_settings')->select('*')->first();
		return $values;
	}

	public function postPayment()
	{
		if(\Auth::check()){
			$orders = $this->getCartTotal();
			$address_id = $_POST['address_id'];
			$order_note = $_POST['order_note'];
			//$orders			= $this->paymentorder($_POST['address_id'],"paypal",$_POST['order_note']);
			$order_details	= \DB::table('abserve_order_details')->select('*')-> where("id",'=',$orders['id'])->get();

			$params = array(
				'cancelUrl'		=> URL::to('').'/payment/cancelorder',
				'returnUrl'		=> URL::to('').'/payment/paymentsuccess', 
				'name'			=> 'New order',
				'description'	=> 'description', 
				'amount'		=> $orders['grand_total'],
				'currency'		=> 'USD',
				'cart_res_id'		=> $orders['res_id'],
				'cart_address_id'	=> $address_id,
				'cart_order_note'	=> $order_note,
			);

			Session::put('params', $params);
			Session::save();
			$Paypal		= $this->paypalValues();
			$gateway	= Omnipay::create('PayPal_Express');
			$gateway->setUsername($Paypal->username);
			$gateway->setPassword($Paypal->password);
			$gateway->setSignature($Paypal->signature);
			$gateway->setTestMode($Paypal->url_setting);

		  	$response = $gateway->purchase($params)->send();
		  	if ($response->isSuccessful()) {
				// payment was successful: update database
		  		print_r($response);
		  	} elseif ($response->isRedirect()) {
				// redirect to offsite payment gateway
		  		$response->redirect();
		  	} else {
				// payment failed: display message to customer
		  		echo $response->getMessage();
		  	}
		} else {
			return Redirect::to('user/login');
		}
	}	
	
	function razorpayRefund($razorpay_payment_id, $customer_refund)
	{
		try {
				//test
				$api_key = RAZORPAY_API_KEYID; //RAZORPAY_API_KEYID;
		        $api_secret = RAZORPAY_API_KEY_SECRET; //RAZORPAY_API_KEY_SECRET;

		        $api = new Api($api_key, $api_secret);
		      	$transfer = $api->refund->create(array('payment_id' => $razorpay_payment_id, 'amount'=>$customer_refund));
		      	if($transfer)
		      		return $transfer->id;
												
			} catch (Exception $e) {
				$transfer_result = 'fail';
				$error_msg = $e->getMessage();
				if(is_array($error_msg)){
					if(count($error_msg) > 0 ){
						foreach ($error_msg as $key => $emsg) {
							$transfer_error_msg .= ($emsg.',');
						}
						$transfer_error_msg = rtrim($transfer_error_msg,',');
					}
				} else {
					$transfer_error_msg .= $error_msg;
				}

				echo $transfer_error_msg;
				return $transfer_error_msg;
			}
	}

	function getCartTotal()
	{
		$user_id = Auth::user()->id;
		$foods_items = \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$user_id)->get();
		$cid = $foods_items[0]->coupon_id;
		$food_item ="";
		$food_id ="";
		$total =0;
		$res_id = $foods_items[0]->res_id;
		$res_charge = \DB::table('abserve_restaurants')->select('delivery_charge','offer','free_delivery','partner_id','service_tax1','service_tax2')->where('id',$res_id)->first();
		$partner = \DB::table('tb_users')->select('commission')->where('id',$res_charge->partner_id)->first();		
		//$comsn_percentage = ($partner->commission > 0 && $partner->commission <= 100) ? $partner->commission : 5;
		//$comsn = $comsn_percentage / 100;
		$comsn_percentage = $partner->commission;
		$comsn = $partner->commission; //changes by mk
		//Item total calculation start
		foreach ($foods_items as $key => $value) {
			$total	= round($total + (($value->price + ($value->price * ($comsn / 100)))* $value->quantity),2);
			$res_id	= $value->res_id;
		}
		//Item Total Calculation end
		//Delivery Charge Start
		if($res_charge->free_delivery == 0) {
			$del_charge = round(($res_charge->delivery_charge),2);
		} else {
			$del_charge = 0;
		}
		//Delivery Charge End
		//Offer start
		if($res_charge->offer > 0){
			$offer = round(($total * ($res_charge->offer / 100)),2);
			$offerPercentage = $res_charge->offer;
		} else {
			$offer = 0;
			$offerPercentage = 0;
		}
		// Offer End
		//Promo code Start
		$coupon_type = 'empty'; $coupon_price = $coupon_value = $coupon_id = 0;
		if($cid != 0){
			$promostatus = \SiteHelpers::getPromoUserCheck($cid,$user_id);
			if($promostatus == 1){
				$date = date('Y-m-d');
				$couponInfo = \DB::table('abserve_promocode')->select('*')->where('id',$cid)->where('start_date','<=',$date)->where('end_date','>=',$date)->whereIn('user_id',array('0' => 0,'1'=>$user_id))->where('min_order_value','<=',$total)->where('limit_count','!=',0)->first();
				if(count($couponInfo) > 0){
					if($couponInfo->promo_type == 'amount'){
						if(($total > $couponInfo->min_order_value) && ($total > ($offer + $couponInfo->promo_amount))){
							$coupon_price 	= round($couponInfo->promo_amount,2);
							$coupon_type 	= 'amount';
							$coupon_value 	= $couponInfo->promo_amount;
							$coupon_id 		= $couponInfo->id;
						}
					} else if($couponInfo->promo_type == 'percentage') {
						if(($total > $couponInfo->min_order_value) && ($total > ($offer + (($couponInfo->promo_amount / 100) * $total)))) {
							$coupon_price 	= round((($couponInfo->promo_amount / 100) * $total),2);
							$coupon_type 	= 'percentage';
							$coupon_value 	= $couponInfo->promo_amount;
							$coupon_id 		= $couponInfo->id;
						}
					}
				}
			}
		}
		//Promo code end
		//Service Tax Calculation Start 
		$s_tax1 = $s_tax2 = $stax1_percent = $stax2_percent = 0;
        if($res_charge->service_tax1 > 0 && $res_charge->service_tax1 <= 100){
        	$stax1_percent = $res_charge->service_tax1 / 100;
        }
        if($res_charge->service_tax2 > 0 && $res_charge->service_tax2 <= 100){
        	$stax2_percent = $res_charge->service_tax2 / 100;
        }
        if($stax1_percent > 0){
        	$s_tax1 = round($total * $stax1_percent,2);
        }
        if($stax2_percent > 0){
        	$s_tax2 = round($total * $stax2_percent,2);
        }
		//Service Tax Calculation End
		$grand_total = ($total - ($offer + $coupon_price) )  + $del_charge + $s_tax1 + $s_tax2;
		$grand_total = round($grand_total,2);
		$this->data['grand_total'] = $grand_total;
		$this->data['res_id'] = $res_id;
		return $this->data;
	}

	public function postTwocheckout()
	{
		//$orders = $this->paymentorder($_POST['address_id'],"2checkout",$_POST['order_note']);   
		//$grand_total = \DB::select("SELECT `grand_total` from abserve_order_details where `abserve_order_details`.`id`='".$orders['id']."'"); 
		if(\Auth::check()) {
			$orders = $this->getCartTotal();
			$address_id = $_POST['address_id'];
			$order_note = $_POST['order_note'];

			$params = array(
				'total' 			=> $orders['grand_total'],
				'cart_res_id'		=> $orders['res_id'],
				'cart_address_id'	=> $address_id,
				'cart_order_note'	=> $order_note,
				
			);
			Session::put('order', $params);
        	Session::save(); 
			$data['order_id'] 	= $orders['id'];
			$data['total'] 		= $orders['grand_total'];
			echo json_encode($data);
		} else {
			$data['msg'] = 'unauthorized';
		}
	}

	public function paymentorder($address_id,$paytype,$ordernote='',$payment_status='unpaid',$payment_token='',$orderid='') 
	{
		$address = \DB::table('abserve_user_address')->select('*')->where("id",'=',$address_id)->get();

		if($ordernote == '' || $ordernote == undefined || $ordernote == null){
			$ordernote = '';
		}
		if(!empty($address)){
			$address_location =$address[0]->building." ".$address[0]->address;
			$landmark =$address[0]->landmark;
			$building =$address[0]->building;
			$lat = $address[0]->lat;
			$lang = $address[0]->lang;
		}
		$user_id = Auth::user()->id;
		$foods_items = \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$user_id)->get();
		$cid = $foods_items[0]->coupon_id;
		$food_item ="";
		$food_id ="";
		$total =0;
		$res_id = $foods_items[0]->res_id;
		$res_charge = \DB::table('abserve_restaurants')->select('location','delivery_charge','offer','free_delivery','partner_id','service_tax1','service_tax2','commission')->where('id',$res_id)->first();

		// $partner = \DB::table('tb_users')->select('commission')->where('id',$res_charge->partner_id)->first();
		/*$comsn_percentage = ($partner->commission > 0 && $partner->commission <= 100) ? $partner->commission : 5;
		$comsn = $comsn_percentage / 100;*/
		$comsn_percentage = isset($res_charge->commission) >0 ? $res_charge->commission : 20 ;
		$comsn = $res_charge->commission; //changes by mk
		//Item total calculation start
		foreach ($foods_items as $key => $value) {
			if($food_item==""){
				$food_item = $value->food_item;
				$food_id = $value->food_id;
				$food_quantity = $value->quantity;
				$food_price = $value->price;//without commission
			} else {
				$food_item .= ",".$value->food_item;
				$food_id .= ",".$value->food_id;
				$food_quantity .=",".$value->quantity;
				$food_price.= ",".$value->price;//without commission
			}
			$total	= round($total + (($value->price + ($value->price * ($comsn / 100)))* $value->quantity),2); 
			$res_id	= $value->res_id;
		}
		//Item Total Calculation end
		//Delivery Charge Start
		// if($res_charge->free_delivery == 0) {
		// 	$del_charge = round($res_charge->delivery_charge,2);
		// } else {
		// 	$del_charge = 0;
		// }
		$keys = \SiteHelpers::site_setting('googlemap_key');

		$ch		= curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.urlencode($res_charge->location).'&destinations='.urlencode($address_location).'&mode=drive&key='.$keys->googlemap_key);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output	= curl_exec($ch);
		curl_close($ch);

		$rwes	= json_decode($output);
		if($rwes->status == "OK"){
			//$distance = $rwes->rows[0]->elements[0]->distance->value;
			$distance = $rwes->rows[0]->elements[0]->distance->text;
		} else {
			$distance = 0;
		}
		// return $distance;
	
		$total_km=round(explode(" ", $distance)[0]);
		$tb_settings=\DB::table('tb_settings')->first();
		if($total_km<=$tb_settings->km){
			$del_charge=$tb_settings->upto_four_km;
			$f_del_charge=$tb_settings->upto_four_km;
			$add_del_charge=0;
			$boy_del_charge=$tb_settings->u_delivery_boy;
			$admin_del_charge=$tb_settings->u_admin;
		}else{
			$del_charge=$tb_settings->upto_four_km+(($total_km-$tb_settings->km)*$tb_settings->per_km);
			$f_del_charge=$tb_settings->upto_four_km;
			$add_del_charge=(($total_km-$tb_settings->km)*$tb_settings->per_km);
			$boy_del_charge=$tb_settings->u_delivery_boy+(($total_km-$tb_settings->km)*$tb_settings->p_delivery_boy);
			$admin_del_charge=$tb_settings->u_admin+(($total_km-$tb_settings->km)*$tb_settings->p_admin);
		}
		
		//Delivery Charge End
		//Offer start
		if($res_charge->offer > 0){
			$offer = round($total * ($res_charge->offer / 100),2);
			$offerPercentage = $res_charge->offer;
		} else {
			$offer = 0;
			$offerPercentage = 0;
		}
		// Offer End
		//Promo code Start
		$coupon_min_val = 0;
		$coupon_type = 'empty'; $coupon_price = $coupon_value = $coupon_id = (int) 0;
		if($cid != 0){
			$promostatus = \SiteHelpers::getPromoUserCheck($cid,$user_id);
			if($promostatus == 1){
				$date = date('Y-m-d');
				$couponInfo = \DB::table('abserve_promocode')->select('*')->where('id',$cid)->where('start_date','<=',$date)->where('end_date','>=',$date)->whereIn('user_id',array('0' => 0,'1'=>$user_id))->where('min_order_value','<=',$total)->where('limit_count','!=',0)->first();
				if(count($couponInfo) > 0){
					if($couponInfo->promo_type == 'amount'){
						if(($total > $couponInfo->min_order_value) && ($total > ($offer + $couponInfo->promo_amount))){
							$coupon_price 	= round($couponInfo->promo_amount,2);
							$coupon_type 	= 'amount';
							$coupon_value 	= $couponInfo->promo_amount;
							$coupon_id 		= $couponInfo->id;
							$coupon_min_val = $couponInfo->min_order_value;
						}
					} else if($couponInfo->promo_type == 'percentage') {
						if(($total > $couponInfo->min_order_value) && ($total > ($offer + (($couponInfo->promo_amount / 100) * $total)))) {
							$coupon_price 	= round(($couponInfo->promo_amount / 100) * $total,2);
							$coupon_type 	= 'percentage';
							$coupon_value 	= $couponInfo->promo_amount;
							$coupon_id 		= $couponInfo->id;
							$coupon_min_val = $couponInfo->min_order_value;

						}
					}
				}
			}
		}
		//Promo code end
		//Service Tax Calculation Start 
		$s_tax1 = $s_tax2 = $stax1_percent = $stax2_percent =$online_pay_chanrge= 0;
        // if($res_charge->service_tax1 > 0 && $res_charge->service_tax1 <= 100){
        // 	$stax1_percent = $res_charge->service_tax1 / 100;
        // }
        // if($res_charge->service_tax2 > 0 && $res_charge->service_tax2 <= 100){
        // 	$stax2_percent = $res_charge->service_tax2 / 100;
        // }
        // if($stax1_percent > 0){
        // 	$s_tax1 = round($total * $stax1_percent,2);
        // }
        // if($stax2_percent > 0){
        // 	$s_tax2 = round($total * $stax2_percent,2);
        // }
			$tb_settings=\DB::table('tb_settings')->first();
			if($tb_settings->tax){
				$online_pay_chanrge= round($total * ($tb_settings->tax/100),2);
			}

			$host_amount=$total-($total*($comsn_percentage/100));
			$admin_camount=($total*($comsn_percentage/100));

			$min_night=0;
			$current_time = date('h:i a');
			$stime = "12:01 am";
			$etime = "08:00 pm";
			$date1 = DateTime::createFromFormat('H:i a', $current_time);
			$date2 = DateTime::createFromFormat('H:i a', $stime);
			$date3 = DateTime::createFromFormat('H:i a', $etime);
			if ($date1 > $date2 && $date1 < $date3)
			{
				$tb_settings=\DB::table('tb_settings')->select('min_night')->where('id',1)->first();
				$min_night=isset($tb_settings->min_night) ? $tb_settings->min_night : 0;
			}

		//Service Tax Calculation End
		$grand_total = round((($total - ($offer + $coupon_price) )  + $del_charge + $s_tax1 + $s_tax2+$min_night+$online_pay_chanrge),2);

		$data =array('cust_id'=>$user_id,'total_price'=>$total,'del_charge'=>$del_charge,'f_del_charge'=>$f_del_charge,'add_del_charge'=>$add_del_charge,'s_tax1'=>$s_tax1,'s_tax2'=>$s_tax2,'comsn_percentage'=>$comsn_percentage,'offer_price'=>$offer,'offer_percentage'=>$offerPercentage,'coupon_price'=>$coupon_price,'coupon_type'=>$coupon_type,'coupon_value'=> $coupon_value,'coupon_id'=>$coupon_id,'grand_total'=>$grand_total,'res_id'=>$res_id,'address'=>$address_location,'building'=>$building,'landmark'=>$landmark,'food_item'=>$food_item,'food_id'=>$food_id,'quantity'=>$food_quantity,'price'=>$food_price,'coupon_min_val'=>$coupon_min_val,'online_pay_chanrge'=>$online_pay_chanrge,'host_amount'=>$host_amount,'admin_camount'=>$admin_camount,'boy_del_charge'=>$boy_del_charge,'admin_del_charge'=>$admin_del_charge,'del_km'=>$total_km,'orderid'=>$orderid,'min_night'=>$min_night);
		$in_data = $data;
		$aFields = array('cust_id','total_price','del_charge','f_del_charge','add_del_charge','s_tax1','s_tax2','comsn_percentage','offer_price','offer_percentage','coupon_id','coupon_price','coupon_type','coupon_value','grand_total','res_id','address','building','landmark','coupon_min_val','online_pay_chanrge','host_amount','admin_camount','boy_del_charge','admin_del_charge','del_km','min_night');
		$cust_id = $user_id;
		$removepost=DB::table('abserve_user_cart')->where('user_id', '=', $user_id)->delete();
		$i=1;
		$keys=array();
		foreach ($data as $key => $name_value) {
			if(in_array($key, $aFields)){
				$keys[] = $key;
				$vals[] = $name_value;
				if($key != 'time'){
					$keys[] = 'time';
					$vals[] = time();
				}
				if($key != 'date'){
					$keys[] = 'date';
					$vals[] = date('Y-m-d');
				}
			}
			$i++;
		}
		$keys[] = 'lat';
		$vals[] = $lat;
		$keys[] = 'lang';
		$vals[] = $lang;
		$keys[] = 'delivery';
		$vals[] = $payment_status;
		$keys[] = 'delivery_type';
		$vals[] = $paytype;
		$keys[] = 'order_note';
		$vals[] = $ordernote;
		if($payment_token != ''){
			$keys[] = 'payment_token';
			$vals[] = $payment_token;
		}

		$details_ins = (array_combine($keys, $vals));
		\DB::table('abserve_order_details')->insert($details_ins);
		$oid = \DB::getPdo()->lastInsertId();
		$food_items = array_intersect_key($data, array_flip(array('food_item','food_id','quantity','price')));
		
		foreach ($food_items as $key => $value) {
			$items[$key]=(explode(',', $value));
			$coutn = count($items[$key]);
		}
		for ($i=0; $i <$coutn ; $i++) { 
			foreach ($items as $key => $value) {
				$rt[] = $key."=> ".$value[$i];
			}
			$final = implode(',', $rt);
			$first_array = explode(',',$final);
			$final_array = array();
			$pass = array("orderid"=>$oid);
			array_unshift($final_array, $pass);
			$rest = call_user_func_array('array_merge_recursive', $final_array);
			foreach($first_array as $arr){
				$data = explode('=>',$arr);
				$rest[$data[0]] = $data[1];
			}
			\DB::table('abserve_order_items')->insert($rest);
		}
		$ins_val = $in_data;
		if($ins_val['price'] != ''){
			$ins_val['order_value'] = str_replace(",","+",$ins_val['price']);
			if($ins_val['del_charge'] != ''){
				$ins_val['order_value'] = $ins_val['order_value']."+".$ins_val['del_charge'];
			}if($ins_val['coupon_price'] != ''){
				$ins_val['order_value'] = $ins_val['order_value']."-".$ins_val['coupon_price'];
			}
		}
		for ($i=0; $i <$coutn ; $i++) { 
			foreach ($items as $ky => $vle) {
				$ins_val['order_details'][] = $items['quantity'][$i]."x".$items['food_item'][$i]."-".$items['price'][$i];
				$ins_val['orderid'] = $oid;
				$ins_val['order_status'] = 0;
			}
		}
		$ins_val['order_details'] = implode(',', array_unique($ins_val['order_details']));
		$ins = array_intersect_key($ins_val, array_flip(array('cust_id','res_id','order_value','order_details','orderid','order_status')));
		$pre = array_intersect_key($ins_val, array_flip(array('partner_id','order_value','order_details','orderid','order_status')));
		$var 	= $res_id;
		$sql2	= "SELECT `partner_id` FROM `abserve_restaurants` WHERE `id`=".$var;
		$ab_cu 	= \DB::select($sql2);
		\DB::table('abserve_orders_customer')->insert($ins);
		\DB::table('abserve_orders_partner')->insert($pre);
		\DB::table('abserve_orders_partner')
		->where('orderid', $oid)
		->update(['partner_id' => $ab_cu[0]->partner_id]);
		$this->data['id'] = $oid;
		$this->data['partner_id'] = $ab_cu[0]->partner_id;	

		$this->send_noti($ab_cu[0]->partner_id);

		return $this->data;
	}
	
	public function getCancelorder()
	{
		return Redirect::to('frontend/checkout');
	}

	public function getPaymentsuccess()
  	{

		$gateway = Omnipay::create('PayPal_Express');
		$gateway->setUsername('jambulingam-business-us_api1.gmail.com');
		$gateway->setPassword('TS7NKH2H7FBNV46C');
		$gateway->setSignature('AFcWxV21C7fd0v3bYYYRCpSSRl31ACLXnJYTapj4v820AqE2FhH6UzI9');
		$gateway->setTestMode(true);
      	
		$params = Session::get('params');
		$params['token']=$_GET['token'];

  		$response = $gateway->completePurchase($params)->send();
  		$paypalResponse = $response->getData(); // this is the raw response object
  		
		//print_r($paypalResponse['']);exit;
  		if(isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {

  			$orders			= $this->paymentorder($params['cart_address_id'],"paypal",$params['cart_order_note'],'paid',$params['token']);
         	//$updated = \DB::select("UPDATE `abserve_order_details` SET `delivery`='paid' WHERE `abserve_order_details`.`id` ='".$params['order_id']."'");  
        	//Partner Share Start
			$order_details = \DB::table('abserve_order_details')->select('*')->where('id','=',$orders['id'])->first();
			$order_items = \DB::table('abserve_order_items')->select('*')->where('orderid',$orders['id'])->get();
			$resInfo = Restaurant::find($order_details->res_id);
			$pid = $resInfo->partner_id;
			$partnerInfo = User::find($pid);
			$item_total = $comsn_amount = 0;
			if(count($order_items) > 0){
				foreach ($order_items as $key => $value) {
					$item_total += ($value->price * $value->quantity);
				}
			}
			$item_total = round($item_total,2);
			$comsn_amount = round($order_details->total_price - $item_total,2);
			$part_amount = ($item_total + $s_tax1 + $s_tax2) - $order_details->offer_price;
			$admin_share = ($comsn_amount + $order_details->del_charge) - $order_details->coupon_price;
			$part_bal['partner_id'] = $pid;
			$part_bal['balance'] = $part_amount;
			$part_bal['order_id'] = $orders['id'];
			$part_bal['item_total'] = $item_total;
			$part_bal['admin_share'] = $admin_share;
			$part_bal['del_charge'] = $order_details->del_charge;
			$part_bal['admin_commission'] = $comsn_amount;
			$part_bal['offer_price'] = $order_details->offer_price;
			$part_bal['coupon_price'] = $order_details->coupon_price;
			$part_bal['created'] = time();
			\DB::table('abserve_partner_balance')->insert(array($part_bal));
			//Partner Share Start
			if($order_details->coupon_id != 0){
				$promo['coupon_id'] = $order_details->coupon_id;
				$promo['order_id'] = $orders['id'];
				$promo['user_id'] = $order_details->cust_id;
				$promo['created'] = time();
				\DB::table('abserve_promo_user_status')->insert(array($promo));
			}
			return Redirect::to('/payment/thankyouorder');
		} else {
			echo 'transaction failed';
		}
	}		

  	public function postCancel()
  	{
  		return redirect('user/login');
  	}

  	public function postCheckoutpayment()
  	{
 		$params= $_REQUEST;
 		$hashSecretWord = 'YjA2YTU4ZWItYTg5MS00NjU3LTlkMjQtYWNhMjExYjMzNTI1'; //2Checkout Secret Word
 		$hashSid = 901350888; //2Checkout account number
		$hashTotal = $params['total']; //Sale total to validate against
		$hashOrder = '1';//in sandbox you should use '1' instead of $hashOrder //$params['order_number']; //2Checkout Order Number
		$StringToHash = strtoupper(md5($hashSecretWord . $hashSid . 1 . $hashTotal));
		if ($StringToHash != $_REQUEST['key']) {
			$result = 'Fail - Hash Mismatch'; 
			$this->data['pages'] 		= 'frontend.cancelorder';
			$page = 'layouts.'.CNF_THEME.'.index';
			return view($page, $this->data);
		} else { 
			$result = 'Success - Hash Matched';
			$order_det = Session::get('order');
			$orders			= $this->paymentorder($order_det['cart_address_id'],"2checkout",$order_det['cart_order_note'],'paid','');
			//$orders			= $this->paymentorder($order_det['cart_address_id'],"paypal",$order_det['cart_order_note'],'paid',$params['token']);
			//\DB::select("UPDATE `abserve_order_details` SET `delivery`='paid' WHERE `abserve_order_details`.`id` ='".$order_det['order_id']."'");
			//Partner Share Start
			$order_details = \DB::table('abserve_order_details')->select('*')->where('id','=',$orders['id'])->first();
			$order_items = \DB::table('abserve_order_items')->select('*')->where('orderid',$orders['id'])->get();
			$resInfo = Restaurant::find($order_details->res_id);
			$pid = $resInfo->partner_id;
			$partnerInfo = User::find($pid);
			$item_total = $comsn_amount = 0;
			if(count($order_items) > 0){
				foreach ($order_items as $key => $value) {
					$item_total += ($value->price * $value->quantity);
				}
			}
			$item_total = round($item_total,2);
			$comsn_amount = round($order_details->total_price - $item_total,2);
			$part_amount = ($item_total + $s_tax1 + $s_tax2) - $order_details->offer_price;
			$admin_share = ($comsn_amount + $order_details->del_charge) - $order_details->coupon_price;
			$part_bal['partner_id'] = $pid;
			$part_bal['balance'] = $part_amount;
			$part_bal['order_id'] = $orders['id'];
			$part_bal['item_total'] = $item_total;
			$part_bal['admin_share'] = $admin_share;
			$part_bal['del_charge'] = $order_details->del_charge;
			$part_bal['admin_commission'] = $comsn_amount;
			$part_bal['offer_price'] = $order_details->offer_price;
			$part_bal['coupon_price'] = $order_details->coupon_price;
			$part_bal['created'] = time();
			\DB::table('abserve_partner_balance')->insert(array($part_bal));
			//Partner Share Start
			if($order_details->coupon_id != 0){
				$promo['coupon_id'] = $order_details->coupon_id;
				$promo['order_id'] = $orders['id'];
				$promo['user_id'] = $order_details->cust_id;
				$promo['created'] = time();
				\DB::table('abserve_promo_user_status')->insert(array($promo));
			}
            
			return Redirect::to('/payment/thankyouorder');
		}
	}  

	public function getThankyouorder()
	{
		$this->data['pages'] 		= 'frontend.thankyou';
		$page = 'layouts.'.CNF_THEME.'.index';
		return view($page, $this->data);
	}

	public function getTransactionfailure()
	{
		$this->data['pages'] 		= 'frontend.transactionfailure';
		$page = 'layouts.'.CNF_THEME.'.index';
		return view($page, $this->data);
	}

    public function postDelivery()
    {
    	if(\Auth::check()){
			$address_id = $_POST['address_id']; 
			$ordernote = (isset($_POST['address_id'])) ? $_POST['order_note'] : '';
			$address = \DB::table('abserve_user_address')->select('*')->where("id",'=',$address_id)->get();

			if(!empty($address)){

			$address_location =$address[0]->address;
			$landmark =$address[0]->landmark;
			$building =$address[0]->building;
			$lat = $address[0]->lat;
			$lang = $address[0]->lang;
			}

			$user_id = Auth::user()->id;

			$foods_items = \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$user_id)->get();
			$food_item ="";
			$food_id ="";
			$total =0;
			$cid = $foods_items[0]->coupon_id;
			$res_id = $foods_items[0]->res_id;
			$res_charge = \DB::table('abserve_restaurants')->select('delivery_charge','offer','free_delivery','partner_id','service_tax1','service_tax2')->where('id',$res_id)->first();
			$partner = \DB::table('tb_users')->select('commission')->where('id',$res_charge->partner_id)->first();
			/*$comsn_percentage = ($partner->commission > 0 && $partner->commission <= 100) ? $partner->commission : 5;
			$comsn = $comsn_percentage / 100;*/
			$comsn_percentage = $partner->commission;
			$comsn = $partner->commission ; //changes by mk
			foreach ($foods_items as $key => $value) {
				if($food_item=="") {
					$food_item = $value->food_item;
					$food_id = $value->food_id;
					$food_quantity = $value->quantity;
					$food_price = $value->price;// without commission
				} else {
					$food_item .= ",".$value->food_item;
					$food_id .= ",".$value->food_id;
					$food_quantity .=",".$value->quantity;
					$food_price.= ",".$value->price;// without commission
				}
				$total	= round($total + (($value->price + ($value->price * ($comsn / 100))) * $value->quantity),2);
				$res_id	= $value->res_id;
			}
			//Delivery charge Start
			if($res_charge->free_delivery == 0) {
				$del_charge = round($res_charge->delivery_charge,2);
			} else {
				$del_charge = 0;
			}
			//Delivery Charge End
			//Offer Start
			if($res_charge->offer > 0){
				$offer = round($total * ($res_charge->offer / 100),2);
				$offerPercentage = $res_charge->offer;
			} else {
				$offer = 0;
				$offerPercentage = 0;
			}
			//Offer End
			//PromoCode start
			$coupon_type = 'empty'; $coupon_price = $coupon_value = $coupon_id = 0;
			if($cid != 0){
				$promostatus = \SiteHelpers::getPromoUserCheck($cid,$user_id);
				if($promostatus == 1){
					$date = date('Y-m-d');
					$couponInfo = \DB::table('abserve_promocode')->select('*')->where('id',$cid)->where('start_date','<=',$date)->where('end_date','>=',$date)->whereIn('user_id',array('0' => 0,'1'=>$user_id))->where('min_order_value','<=',$total)->where('limit_count','!=',0)->first();
					if(count($couponInfo) > 0){
						if($couponInfo->promo_type == 'amount'){
							if(($total > $couponInfo->min_order_value) && ($total > ($offer + $couponInfo->promo_amount))){
								$coupon_price 	= round($couponInfo->promo_amount,2);
								$coupon_type 	= 'amount';
								$coupon_value 	= $couponInfo->promo_amount;
								$coupon_id 		= $couponInfo->id;
							}
						} else if($couponInfo->promo_type == 'percentage') {
							if(($total > $couponInfo->min_order_value) && ($total > ($offer + (($couponInfo->promo_amount / 100) * $total)))) {
								$coupon_price 	= round(($couponInfo->promo_amount / 100) * $total,2);
								$coupon_type 	= 'percentage';
								$coupon_value 	= $couponInfo->promo_amount;
								$coupon_id 		= $couponInfo->id;
							}
						}
					}
				}
			}
			//Prmocode End
			//Service tax calculation start
			$s_tax1 = $s_tax2 = $stax1_percent = $stax2_percent = 0;
	        if($res_charge->service_tax1 > 0 && $res_charge->service_tax1 <= 100){
	        	$stax1_percent = $res_charge->service_tax1 / 100;
	        }
	        if($res_charge->service_tax2 > 0 && $res_charge->service_tax2 <= 100){
	        	$stax2_percent = $res_charge->service_tax2 / 100;
	        }
	        if($stax1_percent > 0){
	        	$s_tax1 = round($total * $stax1_percent,2);
	        }
	        if($stax2_percent > 0){
	        	$s_tax2 = round($total * $stax2_percent,2);
	        }
			//Service tax calculation end
			$grand_total = ($total - ($offer + $coupon_price) )  + $del_charge + $s_tax1 + $s_tax2;

			$data =array('cust_id'=>$user_id,'total_price'=>$total,'del_charge'=>$del_charge,'s_tax1'=>$s_tax1,'s_tax2'=>$s_tax2,'comsn_percentage'=>$comsn_percentage,'offer_price'=>$offer,'offer_percentage'=>$offerPercentage,'coupon_id'=>$coupon_id,'grand_total'=>$grand_total,'res_id'=>$res_id,'address'=>$address_location,'building'=>$building,'landmark'=>$landmark,'food_item'=>$food_item,'food_id'=>$food_id,'quantity'=>$food_quantity,'price'=>$food_price,'coupon_price'=>$coupon_price,'coupon_type'=>$coupon_type,'coupon_value'=>$coupon_value);

			$in_data = $data;
			$aFields = array('cust_id','total_price','del_charge','s_tax1','s_tax2','comsn_percentage','offer_price','offer_percentage','coupon_id','coupon_price','coupon_type','coupon_value','grand_total','res_id','address','building','landmark');

	 		$cust_id = $user_id;

			$removepost=DB::table('abserve_user_cart')->where('user_id', '=', $user_id)->delete();
		
				$i=1;

				foreach ($data as $key => $name_value) {
					if(in_array($key, $aFields)){
							$keys[] = $key;
							$vals[] = $name_value;
							if($key != 'time'){
								$keys[] = 'time';
								$vals[] = time();
							}
							if($key != 'date'){
								$keys[] = 'date';
								$vals[] = date('Y-m-d');
							}
					}
					$i++;
				}
				$keys[] = 'lat';
				$vals[] = $lat;
				$keys[] = 'lang';
				$vals[] = $lang;
				 
				 $keys[]='delivery';
				 $vals[]='on_delivery';

				$keys[]='delivery_type';
			    $vals[]='cash on delivery';

			    $keys[] = 'order_note';
				$vals[] = $ordernote;

				$details_ins = (array_combine($keys, $vals));

			    \DB::table('abserve_order_details')->insert($details_ins);
				$oid = \DB::getPdo()->lastInsertId();
				if($cid != 0){
					if($promostatus == 1) {
						$promo['coupon_id'] = $cid;
						$promo['order_id'] = $oid;
						$promo['user_id'] = $user_id;
						$promo['created'] = time();
						\DB::table('abserve_promo_user_status')->insert(array($promo));
					}
				}
		       $food_items = array_intersect_key($data, array_flip(array('food_item','food_id','quantity','price')));

				foreach ($food_items as $key => $value) {
					$items[$key]=(explode(',', $value));
					$coutn = count($items[$key]);
				}

				
				for ($i=0; $i <$coutn ; $i++) { 
					foreach ($items as $key => $value) {
						$rt[] = $key."=> ".$value[$i];
					}
					$final = implode(',', $rt);
					$first_array = explode(',',$final);
					$final_array = array();


					$pass = array("orderid"=>$oid);

					array_unshift($final_array, $pass);
					$rest = call_user_func_array('array_merge_recursive', $final_array);

					foreach($first_array as $arr){
					    $data = explode('=>',$arr);
					    $rest[$data[0]] = $data[1];
					}

					\DB::table('abserve_order_items')->insert($rest);
				}


	          
	            $ins_val = $in_data;

				if($ins_val['price'] != ''){
				
					$ins_val['order_value'] = str_replace(",","+",$ins_val['price']);
					if($ins_val['del_charge'] != ''){
						$ins_val['order_value'] = $ins_val['order_value']."+".$ins_val['del_charge'];
					}if($ins_val['coupon_price'] != ''){
						$ins_val['order_value'] = $ins_val['order_value']."-".$ins_val['coupon_price'];
					}
				}

				

				for ($i=0; $i <$coutn ; $i++) { 
					foreach ($items as $ky => $vle) {
						$ins_val['order_details'][] = $items['quantity'][$i]."x".$items['food_item'][$i]."-".$items['price'][$i];
						$ins_val['orderid'] = $oid;
						$ins_val['order_status'] = 0;
					}
				}

				$ins_val['order_details'] = implode(',', array_unique($ins_val['order_details']));

				$ins = array_intersect_key($ins_val, array_flip(array('cust_id','res_id','order_value','order_details','orderid','order_status')));

				$pre = array_intersect_key($ins_val, array_flip(array('partner_id','order_value','order_details','orderid','order_status')));

				$var 	= $res_id;
			
				$sql2	= "SELECT `partner_id` FROM `abserve_restaurants` WHERE `id`=".$var;
				$ab_cu 	= \DB::select($sql2);

				\DB::table('abserve_orders_customer')->insert($ins);
				\DB::table('abserve_orders_partner')->insert($pre);

				\DB::table('abserve_orders_partner')
				->where('orderid', $oid)
				->update(['partner_id' => $ab_cu[0]->partner_id]);	



				 return Redirect::to('/payment/thankyouorder'); 
			} else {
				return Redirect::to('user/login');
			}   
		}

	public function postPaypaltransaction(Request $request)
	{
		//echo '<pre>';print_r($request);exit;
		$ptransid = $request->ptransid;
		$req_amount = $_POST['req_amount'];
		$acc_email = trim($_POST['account_email']);
		$id = $_POST['hidden_id'];
		/*$available = DB::select("SELECT `balance` FROM `abserve_partner_balance` WHERE `partner_id` = ".$id);
		$available_balance = $available[0]->balance;
		$paypal = new Paypal();
		$result = $paypal->withdraw($acc_email,$req_amount,$id); 
		if($result['ACK']=='Success')
		{
			$trans_no = rand();
			$today_date = date("Y-m-d");
			$trans_thru ='pay pal';
			$new_bal=0;
			$new_bal = $available_balance-$req_amount;
			DB::table('abserve_partner_balance')
			->where('partner_id', $id)
			->update(['balance' => $new_bal]);
			$insert_mywallet = "INSERT INTO `abserve_partner_wallet` (`transaction_id`,`partner_id`,`transac_through`,`transaction_amount`,`trans_date`) VALUES ('".$trans_no."','".$id."','".$trans_thru."','".$req_amount."','".$today_date."')";
			$query  =  \DB::insert($insert_mywallet);
			return Redirect::to('partnertransac')->with('messagetext','Transfered Successfully')->with('msgstatus','success');
		}elseif ($result['ACK']=='Failure') {
			return Redirect::to('partnertransac')->with('messagetext','Sorry Not able to transfered')->with('msgstatus','error');
		}*/
		$error_msg='';
		$abserve_stripe_settings 	=  \DB::select("SELECT * FROM `abserve_stripe_settings` ");
		\Stripe\Stripe::setApiKey($abserve_stripe_settings[0]->private_key);
		$host=$_POST['hidden_id'];
		$tra_amt=(($_POST['req_amount'])-($_POST['req_amount']*(5/100)));
		$tra_amt1=number_format($tra_amt, 2, '.', '');
		$amt=($tra_amt1)*100;
		//$amt=($_POST['amount'])*100;
		$ac=\DB::table('tb_users')->select('ext_acc_id')->where('id',$host)->first();
		$acc_id=$ac->ext_acc_id;
		if($acc_id=='')
			$error_msg.='Bank account details not created. ';
		if($amt<1)
			$error_msg.='Minimum Request amount is &euro; 1. ';
		if($acc_id!='' and $amt>=1)
		{
			$v=\Stripe\Balance::retrieve();
			$bal_amt=0;
			foreach($v->available as $key => $vv)
			{
				$currency=$v->available[$key]['currency'];
				if($currency=="eur")
					$bal_amt=($v->available[$key]['amount']);
			}
			//echo $bal_amt;
			if($bal_amt>=$amt)
			{
				$trans=\Stripe\Transfer::create(array(
				  "amount" => $amt,
				  "currency" => "USD",
				  "destination" => $acc_id,
				  "transfer_group" => "Group_Host_".$host
				));
				//print_r($trans);
				$trans_id=$trans->id;

				$data=Array ( 
				  'host_id'				=> $host,
				  'amount'				=> $req_amount,
				  'status' 				=>'Completed',
				  'trans_id'			=>$trans_id,
				  'transfered_amount'	=>$tra_amt1
				  );
				$id = \DB::table('abserve_host_transfer')->insertGetId(array($data));
				$old_pbal = \DB::table('abserve_partner_balance')->where('partner_id',$host)->first();
				$old_bal = $old_pbal->balance;
				if($old_bal <= $req_amount)
					$newBal = $req_amount - $old_bal;
				elseif($old_bal > $req_amount)
					$newBal = $old_bal - $req_amount;
				\DB::table('abserve_partner_balance')->where('partner_id',$host)->update(array('balance'=>$newBal));

			}
			else
			{
				$error_msg.='You have only &euro; '.($bal_amt/100).' in your account';
			}
			
		}
		if($trans_id!='')
		{
			//return Redirect::to('transactionrequest?return=')->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
		}
		else
		{
			$error_msg.='Your Transaction is failed.';
			//return Redirect::to('transactionrequest/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus',$error_msg);
		}
		$return = 'partnertransac/show/'.$ptransid.'?return='.self::returnUrl();
		return Redirect::to($return)->with('messagetext',$error_msg)->with('msgstatus','success');
	}

	public function pay_via_stripe(Request $request, EmailController $email)
	{
		if(\Auth::check()) {
			//echo "token===".$_POST['stripeToken'];exit;
			$address_id = $_POST['address_id'];
			$order_note = $_POST['order_note'];
			$abserve_stripe_settings 	=  DB::select("SELECT * FROM `abserve_stripe_settings` ");
			$params = array(
				"testmode"   => $abserve_stripe_settings[0]->test_mode,
				"private_live_key" => $abserve_stripe_settings[0]->private_key,
				"public_live_key"  => $abserve_stripe_settings[0]->public_key,
				"private_test_key" => $abserve_stripe_settings[0]->private_key, 
				"public_test_key"  => $abserve_stripe_settings[0]->public_key
				);

			if ($params['testmode'] == "on") {
				\Stripe\Stripe::setApiKey($params['private_test_key']);
				$pubkey = $params['public_test_key'];
			} else {
				\Stripe\Stripe::setApiKey($params['private_live_key']);
				$pubkey = $params['public_live_key'];
			}
			$orders = $this->getCartTotal();
			$usd_amount = number_format((float)$orders['grand_total'],2,'.','');
			$amount_cents = str_replace(".","",$usd_amount);
			$description = "order"; 
			// echo '<pre>';
			// echo '<br>orders=';print_r($orders);
			// echo '<br>usd_amount='.$usd_amount;
			// echo '<br>amount_cents='.$amount_cents;
			// exit();
		try {

			$charge = \Stripe\Charge::create(array(
				"amount" => $amount_cents,
				"currency" => "USD",
				"source" => $_POST['stripeToken'],
				"description" => $description)
			);

			if ($charge->card->address_zip_check == "fail") {
				throw new Exception("zip_check_invalid");
			} else if ($charge->card->address_line1_check == "fail") {
				throw new Exception("address_check_invalid");
			} else if ($charge->card->cvc_check == "fail") {
				throw new Exception("cvc_check_invalid");
			}
				// Payment has succeeded, no exceptions were thrown or otherwise caught
				$result = "success";

			} catch(Stripe_CardError $e) {

				$error = $e->getMessage();
				$result = "declined";

			} catch (Stripe_InvalidRequestError $e) {
				$result = "declined";
			} catch (Stripe_AuthenticationError $e) {
				$result = "declined";
			} catch (Stripe_ApiConnectionError $e) {
				$result = "declined";
			} catch (Stripe_Error $e) {
				$result = "declined";
			} catch (Exception $e) {

				if ($e->getMessage() == "zip_check_invalid") {
					$result = "declined";
				} else if ($e->getMessage() == "address_check_invalid") {
					$result = "declined";
				} else if ($e->getMessage() == "cvc_check_invalid") {
					$result = "declined";
				} else {
					$result = "declined";
				}
			}

			if($result=="success") {
				$transid = $charge['id'];
				$order_insert		= $this->paymentorder($address_id,"stripe",$order_note,'paid',$transid);
				//Partner Share Start
				$order_details = \DB::table('abserve_order_details')->select('*')->where('id','=',$order_insert['id'])->first();
				$order_items = \DB::table('abserve_order_items')->select('*')->where('orderid',$order_insert['id'])->get();
				$resInfo = Restaurant::find($order_details->res_id);
				$pid = $resInfo->partner_id;
				$partnerInfo = User::find($pid);
				$item_total = $comsn_amount = 0;
				if(count($order_items) > 0){
					foreach ($order_items as $key => $value) {
						$item_total += ($value->price * $value->quantity);
					}
				}
				$item_total = round($item_total,2);
				$comsn_amount = round($order_details->total_price - $item_total,2);
				$part_amount = ($item_total + $s_tax1 + $s_tax2) - $order_details->offer_price;
				$admin_share = ($comsn_amount + $order_details->del_charge) - $order_details->coupon_price;
				$part_bal['partner_id'] = $pid;
				$part_bal['balance'] = $part_amount;
				$part_bal['order_id'] = $order_insert['id'];
				$part_bal['item_total'] = $item_total;
				$part_bal['admin_share'] = $admin_share;
				$part_bal['del_charge'] = $order_details->del_charge;
				$part_bal['admin_commission'] = $comsn_amount;
				$part_bal['offer_price'] = $order_details->offer_price;
				$part_bal['coupon_price'] = $order_details->coupon_price;
				$part_bal['created'] = time();
				\DB::table('abserve_partner_balance')->insert(array($part_bal));
				//Partner Share end
				if($order_details->coupon_id != 0){
					$promo['coupon_id'] = $order_details->coupon_id;
					$promo['order_id'] = $order_insert['id'];
					$promo['user_id'] = $order_details->cust_id;
					$promo['created'] = time();
					\DB::table('abserve_promo_user_status')->insert(array($promo));
				}
				return Redirect::to('/payment/thankyouorder');
			} else {
				$response = "<div class='text-danger'>Stripe Payment Status : \".$result.</div>";
				$this->data['stripeerror'] = $result;
				$this->data['pages'] 		= 'frontend.cancelorder';
				$page = 'layouts.'.CNF_THEME.'.index';
				return view($page, $this->data);
			}
		} else {
			return Redirect::to('user/login');
		}
	}

	public function postCcavenueresponse(Request $request)
	{
		error_reporting(0);

		$workingKey='FF18A8CCA6BF67AA52F34AB93A56BA6C';		
		$encResponse=$_POST["encResp"];	
		$rcvdString=$this->decrypt($encResponse,$workingKey);
		//echo $rcvdString;exit;
		//$data = array('encResponse'=>$encResponse,'workingKey'=>$workingKey,'rcvdString'=>$rcvdString);		
		$order_status="";
		$decryptValues=explode('&', $rcvdString);
		$dataSize=sizeof($decryptValues);
		for($i = 0; $i < $dataSize; $i++) {
			$information=explode('=',$decryptValues[$i]);
			if($i==3)	$order_status=$information[1];
			if($i==1)	$tracking_id=$information[1];
		}

		if($order_status==="Success")
		{
			$params = \Session::get('params');
			\Session::forget('params');
			$orders	= $this->paymentorder($params['address_id'],"ccavenue",$params['order_note'],'paid',$tracking_id);			
			return Redirect::to('/payment/thankyouorder');exit;
		}
		else if($order_status==="Aborted")
		{			
			return Redirect::to('frontend/checkout')->with('status','Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail.');exit;
		}
		else if($order_status==="Failure")
		{			
			return Redirect::to('frontend/checkout')->with('status','Thank you for shopping with us.However,the transaction has been declined.');exit;
		}
		else
		{			
			return Redirect::to('frontend/checkout')->with('status','Security Error. Illegal access detected');exit;
		}		
		
	}

	public function encrypt($plainText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
	  	$blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
		$plainPad = $this->pkcs5_pad($plainText, $blockSize);
	  	if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) 
		{
		      $encryptedText = mcrypt_generic($openMode, $plainPad);
	      	      mcrypt_generic_deinit($openMode);
		      			
		} 
		return bin2hex($encryptedText);
	} 

	public function decrypt($encryptedText,$key)
	{
		$secretKey = $this->hextobin(md5($key));
		$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
		$encryptedText=$this->hextobin($encryptedText);
	  	$openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '','cbc', '');
		mcrypt_generic_init($openMode, $secretKey, $initVector);
		$decryptedText = mdecrypt_generic($openMode, $encryptedText);
		$decryptedText = rtrim($decryptedText, "\0");
	 	mcrypt_generic_deinit($openMode);
		return $decryptedText;
		
	}
 
	public function pkcs5_pad ($plainText, $blockSize)
	{
	    $pad = $blockSize - (strlen($plainText) % $blockSize);
	    return $plainText . str_repeat(chr($pad), $pad);
	}
 
	public function hextobin($hexString)
	{
    	$length = strlen($hexString); 
    	$binString="";   
    	$count=0; 
    	while($count<$length) {       
    	    $subString =substr($hexString,$count,2);           
    	    $packedString = pack("H*",$subString); 
    	    if ($count==0){
				$binString=$packedString;
	    	} else {
				$binString.=$packedString;
	    	} 
	    	$count+=2; 
    	} 
	    return $binString; 
	} 

	public function send_noti($userid)
	{

		$moblie_con = new notification;

		$note_id = \DB::table('tb_users')->select('device','mobile_token')->where('id',$userid)->get();

		$appapi_details	= $moblie_con->appapimethod(2);
		$mobile_token 	= $note_id[0]->mobile_token;

		$message 		= "New orders found in your restaurant";

		$app_name		= $appapi_details->app_name;
		$app_api 		= $appapi_details->api;				

		if($note_id[0]->device == 'ios'){
			$moblie_con->iospushnotification($mobile_token,$message,'1');
    	}else{
	    	$moblie_con->pushnotification($app_api,$mobile_token,$message,$app_name);	
    	}
	}

	public function mol_cancel(Request $request)
    {
      $this->data['pages'] 		= 'frontend.transactionfailure';
		$page = 'layouts.'.CNF_THEME.'.index';
		return view($page, $this->data);
    }

    public function mol_calback(Request $request)
    {
    	$vkey ="32dd62fbe3196a32fbd9d6995c88e9ce";
    	$tranID=$_POST['tranID'];
    	$orderid=$_POST['orderid'];
    	$status=$_POST['status'];
    	$domain=$_POST['domain'];
    	$amount=$_POST['amount'];
    	$currency=$_POST['currency'];
    	$appcode=$_POST['appcode'];
    	$paydate=$_POST['paydate'];
    	$skey=$_POST['skey'];
    	// $key0 = md5( $tranID.$orderid.$status.$domain.$amount.$currency );
    	// $key1 = md5( $paydate.$domain.$key0.$appcode.$vkey );
    	// if( $skey != $key1 ) {$status= -1;}
    	if($status == "00"){
    		$params = Session::get('params');
    		// $orders			= $this->paymentorder($params['cart_address_id'],"molpay",$params['cart_order_note'],'paid',$tranID,$orderid);
    		$order_details = \DB::table('abserve_order_details')->where('orderid',$orderid)->first();
    		
    		\DB::table('abserve_order_details')->where('orderid',$orderid)->update(array('status'=>2,'delivery'=>'paid','payment_token'=>$tranID));
				\DB::table('abserve_orders_partner')->where('orderid',$order_details->id)->update(['order_status'=>2]);

        	//Partner Share Start
    		$order_details = \DB::table('abserve_order_details')->select('*')->where('orderid','=',$orderid)->first();
    		$order_items = \DB::table('abserve_order_items')->select('*')->where('orderid',$order_details->id)->get();
    		$resInfo = Restaurant::find($order_details->res_id);
    		$pid = $resInfo->partner_id;
    		$partnerInfo = User::find($pid);
    		$item_total = $comsn_amount = 0;
    		if(count($order_items) > 0){
    			foreach ($order_items as $key => $value) {
    				$item_total += ($value->price * $value->quantity);
    			}
    		}
    		$item_total = round($item_total,2);
    		$comsn_amount = round($order_details->total_price - $item_total,2);
    		$part_amount = ($item_total + $s_tax1 + $s_tax2) - $order_details->offer_price;
    		$admin_share = ($comsn_amount + $order_details->del_charge) - $order_details->coupon_price;
    		$part_bal['partner_id'] = $pid;
    		$part_bal['balance'] = $part_amount;
    		$part_bal['order_id'] = $orders;
    		$part_bal['item_total'] = $item_total;
    		$part_bal['admin_share'] = $admin_share;
    		$part_bal['del_charge'] = $order_details->del_charge;
    		$part_bal['admin_commission'] = $comsn_amount;
    		$part_bal['offer_price'] = $order_details->offer_price;
    		$part_bal['coupon_price'] = $order_details->coupon_price;
    		$part_bal['created'] = time();
    		\DB::table('abserve_partner_balance')->insert(array($part_bal));
			//Partner Share Start
    		if($order_details->coupon_id != 0){
    			$promo['coupon_id'] = $order_details->coupon_id;
    			$promo['order_id'] = $orders;
    			$promo['user_id'] = $order_details->cust_id;
    			$promo['created'] = time();
    			\DB::table('abserve_promo_user_status')->insert(array($promo));
    		}

    		if(SOCKET_ACTION == 'true'){

    			require_once SOCKET_PATH;

				$aData = array(
					'customer_id' => $order_details->cust_id,
					'partner_id' => $pid,
					'order_id' => $orders
					);
				$client->emit('customer paid', $aData);
			}	

    		return Redirect::to('/payment/thankyouorder');
    	} else {  

    		$order_details = \DB::table('abserve_order_details')->where('orderid',$orderid)->first();
			if($order_details){
				$data=array(
					'order_id'=>$order_details->id,
					'mol_order_id'=>$orderid,
					'tran_id'=>$tranID,
					'status'=>$status
					);
				\DB::table('abserve_fp_transaction')->insert($data);
				$orid=time();
				\DB::table('abserve_order_details')->where('orderid',$orderid)->update(array('orderid'=>$orid,'mol_status'=>$status,'payment_token'=>$tranID));
				$update = \DB::table('abserve_orders_partner')->where('orderid','=',$order_details->id)->update(['order_accepted_time'=>time()]);


    		return Redirect::to('/payment/transactionfailure');
    	
    	 }
    	 // Merchant is r
    	}
	}
   
	public function postCatpaywithrazor(Request $request)
	{
		if(\Auth::check()){	
			$user_id = Auth::user()->id;
			if(!isset($request->repay))
			{
				$rs_query = \DB::table('abserve_user_cart')->select('res_id')->where("user_id",'=',$user_id)->first();
				$exists = \DB::table('abserve_user_cart')->select('res_id')->where("user_id",'=',$user_id)->exists();
				 $restaurant_id = $rs_query->res_id;
				if($exists){
					if($restaurant_id != ''){
						$resInfo = Restaurant::find($restaurant_id);
						$resName=$resInfo->name;
					}else{
							$resName='';
						}
					}else{
						$resName='';
					} 
					

				$authId = \Auth::user()->id;	
				$frontCon= new frontCon	;

				$amount = $frontCon->getCheckoutcartprice($user_id,$restaurant_id)['grandTotal'];
				$wallet = $frontCon->getCheckoutcartprice($user_id,$restaurant_id)['walletAmount'];
				$cashoffer = $frontCon->getCheckoutcartprice($user_id,$restaurant_id)['grozoOffer'];
				$amount = $amount - $cashoffer;
				$paise_amount = round($amount * 100);
				$api_key = RAZORPAY_API_KEYID;
				$api_secret = RAZORPAY_API_KEY_SECRET;
				$api = new Api($api_key, $api_secret);
				$rorderidcreation  = $api->order->create([
					'receipt'         => 'order_rcptid_11',
					'amount'          => $paise_amount,
					'currency'        => 'INR',
					'payment_capture' =>  '1'
				]);
				$razorid=$rorderidcreation->id;		
			}else{
				$orderid = $request->repay;
				$order_details = OrderDetail::where('id',$orderid)->first();
				$razorid=$order_details->orderid;		
				$amount=$order_details->order_repay_info->amount;		
			}
			$paise_amount = round($amount * 100);
			$custInfo = \DB::table('tb_users')->select('username','email','phone_number')->where('id',$user_id)->first();			
			
						
			$response['key'] = RAZORPAY_API_KEYID;
			$response['amount'] = $paise_amount;
			$response['name'] = $resName;
			$response['description'] = 'Order Checkout';
			$response['image'] = url('public/'.CNF_THEME.'/images/backend-logo.png');
			$response['prefill_name'] = $custInfo->username;	
			$response['email'] = $custInfo->email;
			$response['phone_number'] = $custInfo->phone_number;
			$response['orderid'] = $razorid;
			$response['address'] = 'hello thanks for using '.CNF_APPNAME;
			$response['color'] = '#60b246';	
			$response['orders'] = '';					
			$msg = 'success';
							
		} else {
			$msg = 'unauthorized';
		}
		$response['msg'] = $msg;
		return Response::json($response);
	}

	public function postCatrazorhandler(Request $request)
	{
		if(\Auth::check()){					

			if(isset($request->razorpay_payment_id) && $request->razorpay_payment_id != '') {
					$razorpay_payment_id = $request->razorpay_payment_id;
					$Rorderid = $request->Rorderid;
					$deliveryType = 'unpaid';
					if($razorpay_payment_id != '0'){

						$api_key = RAZORPAY_API_KEYID;
						$api_secret = RAZORPAY_API_KEY_SECRET;
						$api = new Api($api_key, $api_secret);
						$razor  = $api->payment->fetch($razorpay_payment_id);
						$razor_status = $razor->status;
						$razor_amount = $razor->amount;

						/*try {
							$api->payment->fetch($razorpay_payment_id)->capture(array('amount'=>$razor_amount));
						} catch (Exception $e) {
							$payment1 = $e->getMessage();
							$response['msg'] = 'fail';
							$response['error_msg'] = $payment1;
							return Response::json($response);
						}*/
					}	
				if(!isset($request->repay)) {
					$res_id = $request->res_id;
					$paymentType = 'razorpay';
					$deliveryType = 'paid';
					$user_id = \Auth::id();
					
					$mol_address_id=$request->mol_address_id;
					$order_note=$request->order_note;
					$mobile_num = $request->input('mobile_num') !== null && $request->mobile_num != '' ? $request->mobile_num : \Auth::user()->phone_number;
					$frontCon = new frontCon;
					$data = $frontCon->orderInsert($user_id,$mobile_num,$order_note,$paymentType,$razorpay_payment_id,'web',$request->type);
					$response['modalContent']=$frontCon->TrackModal($data['orderId']);
				} else {
					if($razor_status == 'captured'){
						$paid_amount = $razor->amount;
						OrderDetail::where('orderid',$Rorderid)->increment('paid_amount', round($paid_amount/100));
					}
				}
				$msg = 'success';
			} else {
				$msg = 'paymentnotfound';
			}
		}else{
			$msg = 'unauthorized';
		}
		
		$response['msg'] = $msg;
		$response['orderId'] = $data['orderId'];
		return Response::json($response);
	}

}