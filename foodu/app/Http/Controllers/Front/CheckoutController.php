<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Front\Restaurant;
use App\Models\Front\Usercart;
use App\User;
use App\User as Users;
use App\Models\Front\Fooditems;
use App\Models\OrderDetail;
use App\Models\Wallet;
use App\Models\Front\Orderdetails; 
use App\Models\Orderstatustime;
use App\Models\OfferUsers;
use App\Models\Useraddress;
use App\Models\OrderPayment;
use App\Models\Promocode;

use App\Models\Fooditems as food;

use App\Models\Variations;
use App\Http\Controllers\Api\OrderController as ordercon;
use App\Http\Controllers\Front\FrontEndController as frontCon;

use Response,Redirect,Session,URL;
use Razorpay\Api\Api;


class CheckoutController extends Controller
{
	public function getCheckout( Request $request)
	{
		if (!(\Auth::check())) {
			return \Redirect::back();
		}
		$data	= [];
		$uCart	= \AbserveHelpers::uCartQuery(\Auth::id(), 0);
		$uCartCnt	= clone ($uCart); $uCartData = clone ($uCart); $cartInfo = clone ($uCart);
		$uCartCnt	= $uCartCnt->count();
		$uCartData	= $uCartData->get();
		$cartInfo	= $cartInfo->first();
		$data['uCartCnt']	= $uCartCnt;
		if ($uCartCnt > 0) {
			$resInfo	= Restaurant::find($uCartData[0]->res_id);
			if (empty($resInfo)) {
				return \Redirect::back('');
			}
			$resInfo->append('availability');
			$res_timeValid	= $resInfo->availability['status'];
			\Session::put('restimevalid',$res_timeValid);
			if ($res_timeValid == 1) {
				$gettimeValids	= \AbserveHelpers::getTimeValids($resInfo->id,\Auth::id());
				$aCartPriceInfo	= \AbserveHelpers::getCheckoutcartprice(\Auth::id(),$resInfo->id);
				$selAddress		= Useraddress::find($cartInfo->address_id);
				if (!empty($selAddress) && $selAddress->id != 0) {
					$selAddress->duration = $aCartPriceInfo['duration_text'];
				}
				$userAddress = Useraddress::where('user_id',\Auth::id())->nearby($resInfo->latitude, $resInfo->longitude)->orderByDesc('id')->get();

				$offerData	= \AbserveHelpers::Offerdata(\Auth::id(),$aCartPriceInfo['itemOriginalPrice']);
				$data['grozoOffer']	= 0; $data['OfferName']	= 0;
				if($offerData['cashOffer'] > 0){
					$data['grozoOffer']	= $offerData['cashOffer'];
					$data['OfferName']	= $offerData['OfferName'];
				}

				$data['access_token']	= \Session::get('access_token');
				$data['payable_amount']	= $aCartPriceInfo['grandTotal'];
				$data['address']		= $userAddress;
				$data['selAddress']		= (!empty($selAddress)) ? $selAddress : [];
				$data['selAddressId']	= (!empty($selAddress) && $selAddress->id != 0) ? $selAddress->id : 0;
				$data['itemtimevalid']	= $gettimeValids['itemtimevalid'];
				$data['resInfo']		= $resInfo;
				$data['uCartData']		= $uCartData;
				$data['cartInfo']		= $cartInfo;
				$data['wallet_used']	= $cartInfo->wallet;
				$data['restimevalid']	= $res_timeValid;
			} else {
				\Session::put('keyinfo','checkout');
				return \Redirect::to('details/'.$uCartData[0]->res_id);
			}
		}
		return view('front.cart.checkout',$data);
	}

	public function postCatpaywithrazor(Request $request)
	{
		if(\Auth::check()){	
			$user_id = \Auth::user()->id;
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
				// $frontCon= new frontCon	;

				$amount = \AbserveHelpers::getCheckoutcartprice($user_id,$restaurant_id)['grandTotal'];
				$wallet = \AbserveHelpers::getCheckoutcartprice($user_id,$restaurant_id)['walletAmount'];
				$cashoffer = \AbserveHelpers::getCheckoutcartprice($user_id,$restaurant_id)['grozoOffer'];
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

	public function Catrazorhandler(Request $request)
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
				}	
				if(!isset($request->repay)) {
					$res_id = $request->res_id;
					$paymentType = 'razorpay';
					$deliveryType = 'paid';
					$user_id = \Auth::id();

					$mol_address_id=$request->mol_address_id;
					$order_note=$request->order_note;
					$mobile_num = $request->input('mobile_num') !== null && $request->mobile_num != '' ? $request->mobile_num : \Auth::user()->phone_number;
					// $frontCon = new frontCon;
					$data = self::orderInsert($user_id,$mobile_num,$order_note,$paymentType,$razorpay_payment_id,'web',$request->type);
					// $response['modalContent']=$frontCon->TrackModal($data['orderId']);
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

	function orderInsert($user_id, $mobile_num, $order_note, $paymentType, $razorpay_payment_id, $device= 'web', $del_type = '', $wallet_amount = 0)
	{
		$aCart = Usercart::where('user_id',$user_id)->first();
		if(!empty($aCart)) {
			$res_status = Restaurant::find($aCart->res_id);
			if($res_status->mode == 'close') {
				$response['message']	= "Shop is closed now.So, you can't able to place your order now.";
				$response['status']		= 422;
				return $response;
			}
			$aCartPriceInfo	= \AbserveHelpers::getCheckoutcartprice($user_id,$aCart->res_id,true,$aCart->wallet);
			extract($aCartPriceInfo);
			$tb_settings	= \DB::table('tb_settings')->first();
			if ($message == 'success') {
				if($aRestaurant->minimum_order > $itemOriginalPrice){
					$currency_symbol = \AbserveHelpers::getBaseCurrencySymbol();
					$message = 'Minimum order value is '.$currency_symbol.' '.$aRestaurant->minimum_order;
					$status = 422;
				} else {
					$aAddressInfo	= Useraddress::find($aUserCart[0]->address_id);
					$order	= new OrderDetail;
					$order->cust_id 			= $user_id;
					$order->res_id 				= $aRestaurant->id;
					$order->partner_id 			= $aRestaurant->partner_id;
					$order->orderid 			= time();
					$orderidfk = $order->orderid;
					$order->mobile_num 			= $mobile_num;
					$order->total_price 		= $itemOriginalPrice;
					$order->host_amount 		= $host_amount;
					$order->fixedCommission		= $fixedCommission;
					$order->admin_camount 		= $commisisonPrice;
					$order->hiking 		 		= $HikingPrice;
					$order->del_km 				= $aUserCart[0]->distance_km;
					if($del_type != null && $del_type != ''){ $aUserCart[0]->delivertype = $del_type; }
					$order->delivery_preference = $aUserCart[0]->delivertype;
					$order->later_deliver_time	= $aUserCart[0]->delivertime;
					$order->later_deliver_date	= $aUserCart[0]->deliverdate;
					// later_delivery_timestamp
					$delivertime 				= $aUserCart[0]->delivertime;
					$time1 						= substr($delivertime,0,-2);
					$time2 						= substr($delivertime,-2);
					$later_delivery_timestamp 	= date("Y-m-d H:i:s", strtotime($order->later_deliver_date.' '.$time1.' '.$time2));
					$order->later_delivery_timestamp	= $later_delivery_timestamp;
					$order->ordertype 			= $aUserCart[0]->ordertype;
					$order->duration 			= $aUserCart[0]->duration;
					$order->delivery_time 		= $aRestaurant->delivery_time;
					$order->device 				= $device;
					$order->del_charge 			= $aDelCharges['delivery'];
					// $order->f_del_charge 		= $aDelCharges['festival'] + $aDelCharges['festivalTax'];
					$order->add_del_charge 		= ($aDelCharges['package'] + $aDelCharges['packageTax']);
					// $order->boy_del_charge 		= $aDelCharges['boy_del_charge'];
					// $order->admin_del_charge 	= $aDelCharges['admin_del_charge'];
					$order->del_charge_tax_percent		= $aDelCharges['deliveryPercent'];
					$order->del_charge_tax_price		= $aDelCharges['deliveryTax'];
					$order->del_charge_discount			= 0;
					$order->delivery_boy_charge_per_km	= $tb_settings->delivery_boy_charge_per_km;
				// 	$order->s_tax1 				= $stax1;
					$order->s_tax1 				= 0;
					$order->s_tax2 				= 0;
					$order->gst 				= $gst;
					$order->comsn_percentage 	= $aRestaurant->commission;
					// $order->offer_price 		= $itemOfferPrice;
					$order->offer_price 		= $promoamount;
					$order->offer_percentage 	= 0;
					$order->coupon_price 		= $promoamount;
					if($promoamount > 0){
						$order->coupon_type 		= $promoInfo->promo_type;
						$order->coupon_value 		= $promoInfo->promo_amount;
						$order->coupon_id 			= $promoInfo->id;
						$order->coupon_min_val 		= $promoInfo->min_order_value;
					}
					$order->grand_total 		= $grandTotal;
					// $order->grand_total			= ($aCartPriceInfo['cashOffer'] > 0 && $aCartPriceInfo['cashOffer'] < $grandTotal) ? ($grandTotal - $aCartPriceInfo['cashOffer']) : $grandTotal;
					// echo $order->grand_total;die();
					$order->wallet_amount 		= $aUserCart[0]->wallet;
					$order->address 			= $aAddressInfo->address;
					$order->building 			= $aAddressInfo->building;
					$order->landmark 			= $aAddressInfo->landmark;
					$order->lat 				= $aAddressInfo->lat;
					$order->lang 				= $aAddressInfo->lang;
					$order->status 				= 'pending';
					$order->time 				= time();
					$order->date 				= date('Y-m-d');
					$order->delivery 			= 'unpaid';
					$order->delivery_type 		= $paymentType;
					$order->order_note 			= $order_note;
					$order->free_delivery 		= $aRestaurant->free_delivery;
					$order->bad_weather_charge 		= ($aDelCharges['badWeather'] + $aDelCharges['badWeatherTax']);
					$order->festival_mode_charge 	= ($aDelCharges['festival'] + $aDelCharges['festivalTax']);
					$order->festival_mode_charge_perkm 	= 0;
					/*if(!empty($aRestaurant->manager_info)){
						$order->manager_id	= $aRestaurant->manager_info->id;
						$order->manager_commission_percent	= $aRestaurant->manager_info->commission;
						$order->manager_commission_price	= number_format((($itemPrice + $s_tax1) * ($order->manager_commission_percent / 100)),2,'.','');
					}*/
					$order->created_at		= date('Y-m-d H:i:s');
					$order->updated_at		= date('Y-m-d H:i:s');
					// $order->enc_order_id	= md5($id);
					// $order->save();

					$paid_amount = 0;$transaction_status = $transaction_id = $transaction_orderid = '';
					if($paymentType == 'razorpay') {
						$api_key	= RAZORPAY_API_KEYID;
						$api_secret	= RAZORPAY_API_KEY_SECRET;
						$api	= new Api($api_key, $api_secret);
						if($razorpay_payment_id != ''){
							$razor	= $api->payment->fetch($razorpay_payment_id);
							$transaction_status	= $razor->status;
							$paid_amount		= $razor->amount;
							if($transaction_status == 'captured'){
								$order->delivery	= 'paid';
								$order->paid_amount	= $order->grand_total;
							}elseif($transaction_status == 'failed'){
								$response['message'] = 'Your Payment Faild';
								$response['status'] = 422;
								return $response;
							}
							$order->orderid			= $razor->order_id;
							$order->payment_token	= $razorpay_payment_id;
							$transaction_id			= $razorpay_payment_id;
							$transaction_orderid	= $order->orderid;
						} else {
							$rorderidcreation	= $api->order->create([
								'receipt'			=> 'receipt_'.$order->id,
								'amount'			=> round(($grandTotal - $aCartPriceInfo['grozoOffer'])*100),
								'currency'			=> 'INR',
							]);
							$order->orderid = $rorderidcreation->id;
						}
						$order->save();
					} elseif ($paymentType == 'wallet') {
						$customer = User::find($user_id);
						if($grandTotal >= $customer->customer_wallet){
							$response['message'] = 'You have not a fulfill amount';
							$response['status'] = 422;
							return $response;
						}
						$order->delivery	= 'paid';
						$order->paid_amount	= $order->grand_total;
						$order->save();
					}
					$order->save();
					$payment = new OrderPayment;
					$payment->order_id 		= $order->id;
					$payment->pay_via 		= $paymentType;
					$payment->amount 		= $grandTotal;
					$payment->paid_amount 	= $paid_amount;
					$payment->payment_staus = $order->delivery;
					$payment->transaction_status 	= $transaction_status;
					$payment->transaction_id 	 	= $transaction_id;
					$payment->transaction_orderid 	= $transaction_orderid;
					$payment->type 					= 'credit';
					$payment->created_at 			= date('Y-m-d H:i:s');
					$payment->updated_at 			= date('Y-m-d H:i:s');
					$payment->save();
					
					$item['orderid'] = $order->id;
					$order_value = $order_details = '';
					foreach ($aCartItems as $key => $value) {
						$item['food_id']	 		= $value['food_id'];
						$item['food_item']	 		= $value['food_item'];
						$item['adon_type']	 		= $value['adon_type'];
						$item['adon_id']	 		= $value['adon_id'];
						$item['adon_detail']		= $value['adon_detail'];
						$item['quantity']	 		= $value['quantity'];
						$item['price']	 			= $value['price'];
						$item['vendor_price']		= $value['vendor_price'];
						$item['item_note']	 		= $value['item_note'];
						$item['selling_price']		= $value['selling_price'];
						$item['hiking']		 		= $value['hiking'];
						$item['hiking_price']		= $value['hiking_price'];
						$item['base_price_value']	= $value['base_price_value'];
						$item['admin_cmsn_amt']		= $value['admin_cmsn_amt'];
						$item['base_price']			= $value['base_price'];
						$item['vendor_gstamount']	= $value['vendor_gstamount'];
						$item['gst']				= $value['gst'];
						$item['hiking_gst_price']	= $value['hiking_gst_price'];
						$item['base_price_gst']		= $value['base_price_gst'];
						\DB::table('abserve_order_items')->insert($item);
						if($order_value != ''){
							$order_value .= ' + ';
						}
						$amount = number_format(($value['quantity'] * $value['price']),2,'.','');
						$order_value .= $amount;
						if($order_details != ''){
							$order_details .= ', ';
						}
						// $newDetail = $adon_detail != '' && $adon_detail != '-' ? ' - '.$adon_detail : '';
						$newDetail = '';
						$order_details .= $value['quantity'].' X '.$value['food_item'].$newDetail;
					}

					$order->order_value		= $order_value;
					$order->order_details	= $order_details;
					$order->save();

					/*$orderPartner				= new Orderdetails;
					$orderPartner->partner_id	= $aRestaurant->partner_id;
					$orderPartner->orderid		= $order->id;
					$orderPartner->order_value	= $order_value;
					$orderPartner->order_details= $order_details;
					$orderPartner->order_status	= '0';
					$orderPartner->created_at	= date('Y-m-d H:i:s');
					$orderPartner->updated_at	= date('Y-m-d H:i:s');
					$orderPartner->save();*/

					/*$orderCustomer = new Customerorder;
					$orderCustomer->cust_id 	= $user_id;
					$orderCustomer->res_id 		= $aRestaurant->id;
					$orderCustomer->orderid 	= $order->id;
					$orderCustomer->order_value = $order_value;
					$orderCustomer->order_details = $order_details;
					$orderCustomer->created_at 	  = date('Y-m-d H:i:s');
					$orderCustomer->updated_at 	  = date('Y-m-d H:i:s');
					$orderCustomer->save();*/

					$orderstat = new Orderstatustime;
					$orderstat->order_id	= $order->id;
					$orderstat->status		= '0';
					$orderstat->device 		= $device;
					$orderstat->created_at	= date('Y-m-d H:i:s');
					$orderstat->updated_at	= date('Y-m-d H:i:s');
					$orderstat->save();

					$data['orderId']	= $order->id;
					$data['payOrderId']	= $order->orderid;

					if($order->delivery_type == 'cashondelivery' || ($order->delivery_type != 'cashondelivery' && $order->delivery == 'paid')){
						Usercart::where('user_id',$user_id)->delete();
						$order->cash_offer	= $aCartPriceInfo['grozoOffer'];
						$order->save();

						if ($aCartPriceInfo['grozoOffer'] > 0) {
							$offer_table			= new OfferUsers;
							$offer_table->order_id	= $order->id;
							$offer_table->cust_id	= $order->cust_id;
							$offer_table->type		= 'debit';
							$offer_table->reason	= $aCartPriceInfo['OfferName']. ' offer redeem';
							$offer_table->offer_price	= $aCartPriceInfo['grozoOffer'];
							$offer_table->offer_name	= $aCartPriceInfo['OfferName'];
							$offer_table->grand_total	= $order->grand_total; 
							$offer_table->save();
						}
						$user_offer	= User::find($order->cust_id,['id','offer_wallet']);
						$cash_back_value	= $user_offer->offer_wallet - $aCartPriceInfo['grozoOffer'];
						$user_offer->offer_wallet	= $cash_back_value;
						$user_offer->save();
					}
					OrderDetail::where('id',$order->id)->update(['enc_order_id' => md5($order->id)]);
					if($order->delivery_type == 'cashondelivery'){
						self::UpdateWalletOrderinsert($order);
					}
					//Send Notification to Partner 
					$message 		= "New orders found in your shop";
					// $this->sendpushnotification($aRestaurant->partner_id,'user',$message);

					//Emit Socket
					if(SOCKET_ACTION == 'true'){
						require_once SOCKET_PATH;
				// 		$client->emit('new order placed', $aRestaurant->partner_id);
						$client->emit('placed the order', $aRestaurant->partner_id);
					}
				}
				$message = 'Order inserted successfully';
				$status = 200;
				$this::sleep($order->id);
			}
			$response['message']	= $message;
			$response['status']		= $status;
			$response['orderId']	= $order->id;
			return $response;
		} else {
			$response['message']	= 'Your cart is empty';
			$response['status']		= 422;
			return $response;
		}
	}

	public  function sleep($id)
	{
		$output = shell_exec('wget -q '.\URL::to('/trigger/'.$id).' -O /dev/null --background');
	}

	public  function trigger($id)
	{
		sleep(CNF_CANCEL_TIME);
		$update = OrderDetail::where('id',$id)->where('status','pending')
		/*->where(function($query){
			$query->where('delivery_type','cashondelivery');
			$query->orWhere(function($subQuery){
				$subQuery->where('delivery_type','!=','cashondelivery');
				$subQuery->where('delivery','paid');
			});
		})*/
		->update(["status"=>'0']);

		if($update){
			$order = OrderDetail::find($id);
			$currentDateTime = now();
			$timeFormatted = $currentDateTime->format('h:i:s');
			$res = Restaurant::where('id', $order->res_id)->select('name')->first();
			$notification = \DB::table('user_notification')->insert([
				'user_id' => $order->cust_id,
				'notification' => 'Orders Successful!',
				'status' => 0,
				'content' => "You have placed an order at ".$res->name." and paid ".$order->grand_total.". Your food will arrive soon. Enjoy our services.",
				'date' => date('Y-m-d'),
				'time' => $timeFormatted
			]);

			$token = \DB::table('tb_users')->where('id', $order->cust_id)->first();
			$token = $token->mobile_token;
			$title = 'Order Place';
			$message = 'Your order placed  successfully';
			\AbserveHelpers::sendPushNotification($token, $title, $message);
			// Send Notification to User for Create Order 
				// $message 		= "You create a new order";
				// $this->sendpushnotification($order->cust_id,'user',$message);

				//Send Notification to Partner 
				$message 		= "New orders found in your shop";
				$this->sendpushnotification($order->partner_id,'user',$message,'','',1);
		}

		// if($update){
		// 	$order = OrderDetail::find($id);
		// 	if($order->delivery_type == 'cashondelivery' || $order->delivery == 'paid'){
		// 		if($order->delivery == 'paid'){
		// 			self::UpdateWalletOrderinsert($order);
		// 		}

		// 		//Send Notification to User for Create Order 
		// 		/*$message 		= "You create a new order";
		// 		$this->sendpushnotification($order->cust_id,'user',$message);*/

		// 		//Send Notification to Partner 
		// 		/*$message 		= "New orders found in your shop";
		// 		$this->sendpushnotification($order->partner_id,'user',$message,'','',1);*/
			
		// 		//Emit Socket
		// 		if(SOCKET_ACTION == 'true'){
		// 			require_once SOCKET_PATH;		
		// 			$client->emit('new order placed', $order->partner_id);
		// 		}
		// 	}
		// }
	}

	public function getTimevaliditycheck(Request $request)
	{
		$res_id			= $request->res_id;
		$orderid		= $request->orderid;
		$wallet_amount	= $request->wallet_amount;
		$user_id		= \Auth::id();
		$aCartPriceInfo	= \AbserveHelpers::getCheckoutcartprice($user_id,$res_id,true,$wallet_amount);
		$topay_amt      = number_format($aCartPriceInfo['grandTotal'] - $aCartPriceInfo['wallet_amount'] - $aCartPriceInfo['grozoOffer'],2,'.','');
		$paymentType	= ($topay_amt == 0) ? 'wallet' : 'cashondelivery';
		$deliveryType	= ($topay_amt == 0) ? 'paid' : 'unpaid';
		$gettimeValids	= \AbserveHelpers::getTimeValids($res_id,$user_id);
		$response['restimevalid']  = $gettimeValids['restimevalid'];
		$response['itemtimevalid'] = $gettimeValids['itemtimevalid'];

		if ($gettimeValids['restimevalid'] == 1 || $gettimeValids['itemtimevalid'] == 1){
			$mol_address_id	= $request->mol_address_id;
			$mobile_num		= $request->input('mobile_num') !== null && $request->mobile_num != '' ? $request->mobile_num : \Auth::user()->phone_number;
			$order_note		= $request->mol_order_note;
			$orderid		= time();
			$mol_order_pref	= (PICKDEL_OPTION == 'enable') ? $request->deliver_status : 'deliver';
			$insertresult	= $this->orderInsert($user_id,$mobile_num,$order_note,$paymentType,'','web','',$wallet_amount);
			$response['message']		= $insertresult['message'];
			$response['orderId']		= $insertresult['orderId'];
			$response['orderIdmd5']		= md5($insertresult['orderId']);
			// $request->session()->put('trackAjax','2');
			 //$response['modalContent']	= $this->Trackorder($insertresult['orderId']);
			// $this->submit_order($mol_address_id,$mol_order_note,$paymentType,$deliveryType,'',$orderid,$mol_order_pref,$request->l_date,$request->l_time,$user_id,'web');	
		} 

		return Response::json($response);
	}

	public function UpdateWalletOrderinsert($order)
	{
		$user_id     = $order->cust_id;
		$userdetails = Users::where('id',$user_id)->first();
		$walletAmount= $order->wallet_amount;
		if($walletAmount > 0) {
			$balance	= $userdetails->customer_wallet - $walletAmount;
			$addwallet	= new Wallet;
			$addwallet->user_id		= $user_id;
			$addwallet->order_id	= $order->id;
			$addwallet->amount		= $walletAmount;
			$addwallet->reason		= "Used from wallet for order";
			$addwallet->type		= "debit";
			$addwallet->balance		= $balance;
			$addwallet->added_by	= $user_id;
			$addwallet->order_status= '0';
			$addwallet->date		=  date('Y-m-d');
			$addwallet->save();
			
			$userdetails->customer_wallet = $balance;
			$userdetails->save();
		}
	}

	public function getCheckcart(Request $request)
	{
		$ajax=false;
		if(isset($request->ajax) && $request->ajax=='true')
			$ajax=true;
		if(\Auth::check()){
			$user_id = \Auth::user()->id;
			$result = \DB::select("SELECT * FROM `abserve_user_cart` WHERE `user_id` = '".$user_id."' AND res_id!='".$request->res_id."'");
		}else{
			$cart_cookie_id = \AbserveHelpers::getCartCookie();
			$result = \DB::select("SELECT * FROM `abserve_user_cart` WHERE `cookie_id` = '".$cart_cookie_id."' AND res_id!='".$request->res_id."'");

		}
		if($ajax){
			echo count($result);exit;
		}else {
			return count($result);
		}
	}

	public function postAddtotcart(Request $request)
	{
		$hotel_item	= $product = array();
		$item_id	= $request->item;
		$res_id		= $request->res_id;
		$ad_id		= $request->ad_id;
		$adon_type	= $request->ad_type;
		$product['adon_details'] = 0;
		$unit=0;
		$unit_data  = $request->unit;
		if ($unit_data != '') {
			$unit = $unit_data;
		} else {
		}
		// $res_id	= $this->getResIdFromItemId($item_id);
		$html		= ''; $user_id = 0; $cart_cookie_id = 0;
		$hotel_item	= \DB::table('abserve_hotel_items')->select('id','gst','food_item','price','selling_price','original_price','strike_price','hiking')->where('id', $item_id)->first();
		if ($adon_type == 'unit') {
			$hotel_item_unit	= \DB::table('tb_food_unit')->select('price','selling_price','original_price','unit','unit_type')->where('id', $adon_id)->where('food_id', $item_id)->first();
			$product['price']	= round($hotel_item_unit->selling_price) > 0 ? $hotel_item_unit->selling_price : $hotel_item_unit->price;
			$product['vendor_price']	= $hotel_item_unit->original_price;
			$product['adon_details']	= $hotel_item_unit->unit.' '.ucfirst($hotel_item_unit->unit_type);
		} else if($adon_type == 'variation') {
			$hotel_item_variation	= \DB::table('tb_food_variation')->select('price','selling_price','original_price','color','unit')->where('id', $adon_id)->where('food_id', $item_id)->first();
			$product['price']		= round($hotel_item_variation->selling_price) >0 ? $hotel_item_variation->selling_price : $hotel_item_variation->price;

			$product['vendor_price']	= $hotel_item_variation->original_price;
			$product['adon_details']	= ucfirst($hotel_item_variation->color).':'.$hotel_item_variation->unit;
		} else {
			$product['price']			= round($hotel_item->selling_price) > 0 ? $hotel_item->selling_price : $hotel_item->price;
			$product['vendor_price']	= $hotel_item->original_price;
		}
		if($unit>0){
			$user_id = \Auth::user()->id;
			$uCartQuery	= \AbserveHelpers::uCartQuery($user_id, 0);
			$userCart	= clone ($uCartQuery); $pCart = clone ($uCartQuery);$gCart = clone ($uCartQuery); $ptCart = clone ($uCartQuery); $puCart = clone ($uCartQuery);
			$userCart	= $userCart->get();
			$stax	= \DB::table('abserve_restaurants')->select('service_tax1')->where('id',$res_id)->first();
			$product['unit']        =$unit;

			if (empty($userCart) && (in_array($this->method, $methods))) {
				$response['message']	= 'Your cart is empty';
				return \Response::json($response,422);
			}

			$foodData	= food::find($item_id);
			$data['food_id']	= $item_id;
			if ($user_id == 0)

				
				
			$product['user_id']	= $user_id;
			$product['res_id']		= $res_id;
			$product['food_id']		= $item_id;
			$product['food_item']	= $hotel_item->food_item;
			// $product['gst']			= 0;
			$product['gst']			= $hotel_item->selling_price * ($hotel_item->gst / 100);
			$product['quantity']	= $request->qty;
			$product['tax']			= $stax->service_tax1;
			$product['adon_type']	= $adon_type;
			$product['adon_id']		= $ad_id;
			$product['strike_price']= 0;
			$cart_cookie_id			= \AbserveHelpers::getCartCookie();
			if ( !$cart_cookie_id ) {
				$cart_cookie_id		= \AbserveHelpers::setCartCookie();
			}
			$product['cookie_id']	= $cart_cookie_id;
			$product['user_id']		= $user_id;

			if (isset($request->unit) && null !== $request->unit && $request->unit > 0) {
				$key	= array_search($request->unit, array_column($foodData->unit_detail, 'id'));
				$unit1	= $foodData->unit_detail[$key]['price'];
			}
			$price	= ($unit1 > 0) ? $unit1 : $foodData->price;
			$product['price']	= $price;

			$fCart	= $pCart->where('user_id',$item_id)->first();

			if (!empty($cartDetail))
				$cookieID=0;
					//self::offerCalc($cartDetail, $user_id, $cookieID);
			$message	= " ";
			$message	.= $request->qty > 0 ? "Added to " : "Removed from ";
			$message	.= " cart";
			
		}
		else{
			$stax	= \DB::table('abserve_restaurants')->select('service_tax1')->where('id',$res_id)->first();
			$product['food_id']		= $item_id;
			$product['food_item']	= $hotel_item->food_item;
			// $product['gst']			= 0;
			$product['gst']			= $hotel_item->selling_price * ($hotel_item->gst / 100);
			$product['price']		= $hotel_item->selling_price;
			$product['strike_price']= $hotel_item->strike_price;
			$product['quantity']	= $request->qty;
			$product['res_id']		= $res_id;
			$product['tax']			= $stax->service_tax1;

			$product['adon_type']	= $adon_type;
			$product['adon_id']		= $ad_id;
			$cart_cookie_id			= \AbserveHelpers::getCartCookie();
			if ( !$cart_cookie_id ) {
				$cart_cookie_id		= \AbserveHelpers::setCartCookie();
			}
			$product['cookie_id']	= $cart_cookie_id;
			$product['user_id']		= $user_id;
			$product['unit']        =$unit;
		}

		if (\Auth::check()) {
			$user_id = \Auth::user()->id;
			$product['user_id']		= $user_id;
			$product['cookie_id']	= 0;
		}

		//echo $adon_type;exit;

		$user1=Usercart::where('user_id',$user_id)->where('food_id',$item_id)->where('unit',$unit)->first();
		//echo "<pre>";print_r($user1);exit;
		if(!empty($user1) && $unit>0)
		{
			//$cartquantity= $user1->quantity;
			$update['quantity'] = $request->qty;
			$updatecart =Usercart::where('user_id',$user_id)->where('food_id',$item_id)->where('unit',$unit)->update($update);


		}
		else{



			$cart_data		= $this->Addcart($product);
		}
		if (isset($request->key) && $request->key == 'checkout') {
			$aCartPInfo	= \AbserveHelpers::getCheckoutcartprice($user_id,$res_id);
			$html		= (string) view('front.cart.checkoutcart',$aCartPInfo);
		} else {
			$cur_resid	= $res_id;
			//return $cart_data=json_encode($cart_data);
			$html		= $this->Showcart($cur_resid,$res_id,$user_id,$cart_cookie_id);
		}
		$searchhtml	= (new FrontEndController)->ShowSearchcCart($res_id,$user_id,$cart_cookie_id);
		$headCartCount	= \AbserveHelpers::getCartItemCount();
		$response['html']	= $html;
		$response['searchhtml']	= $searchhtml;
		$response['headCartCount']	= $headCartCount;
		return Response::json($response);
	}


	public function getRemovefromcart(Request $request)
	{
		$hotel_item = array();
		$item_id    = $request->item;
		$res_id     = $request->res_id;
		$adon_id    = $request->adon_id;
		$adon_type  = $request->adon_type;
		$html       = '';$user_id = 0;$cart_cookie_id = 0;
		$unit=0;
		$unit_data  = $request->unit;
		if ($unit_data != '') {
			$unit = $unit_data;
		} else {
		}
        // $hotel_item  = \DB::table('abserve_hotel_items')->select('food_item','price')->where('id', $item_id)->first();
		$hotel_item = \DB::table('abserve_hotel_items')->select('gst','food_item','price','selling_price','original_price','strike_price')->where('id', $item_id)->first();
		if ($adon_type == 'unit') {
			$hotel_item_unit    = \DB::table('tb_food_unit')->select('price','selling_price','original_price','unit','unit_type')->where('id', $adon_id)->where('food_id', $item_id)->first();
			$product['price']       = round($hotel_item_unit->selling_price) >0 ? $hotel_item_unit->selling_price : $hotel_item_unit->price;
			$product['vendor_price']= $hotel_item_unit->original_price;
			$product['adon_details']= $hotel_item_unit->unit.' '.ucfirst($hotel_item_unit->unit_type);
		} else if($adon_type == 'variation') {
			$hotel_item_variation   = \DB::table('tb_food_variation')->select('price','selling_price','original_price','color','unit')->where('id', $adon_id)->where('food_id', $item_id)->first();
			$product['price']       = round($hotel_item_variation->selling_price) >0 ? $hotel_item_variation->selling_price : $hotel_item_variation->price;

			$product['vendor_price']= $hotel_item_variation->original_price;
			$product['adon_details']= ucfirst($hotel_item_variation->color).':'.$hotel_item_variation->unit;
		} else {
			$product['price']       = round($hotel_item->selling_price) >0 ? $hotel_item->selling_price : $hotel_item->price;
			$product['vendor_price']= $hotel_item->original_price;
		}
		$stax   = \DB::table('abserve_restaurants')->select('service_tax1')->where('id',$res_id)->first();
		$product['food_id']     = $item_id;
		$product['food_item']   = $hotel_item->food_item;
		$product['gst']         = 0;
		$product['price']       = $hotel_item->selling_price;
		$product['strike_price']= $hotel_item->strike_price;
		$product['quantity']    = $request->qty;
		$product['res_id']      = $res_id;
		$product['tax']         = $stax->service_tax1;
		$product['adon_id']     = $adon_id;
		$product['adon_type']   = $adon_type;
		$product['unit']   = $unit;
		$cart_cookie_id = \AbserveHelpers::getCartCookie();
		if (!$cart_cookie_id) {
			$cart_cookie_id     = \AbserveHelpers::setCartCookie();
		}
		$product['cookie_id']   = $cart_cookie_id;
		$product['user_id']     = $user_id;
		$product['adon_details']= 0;
		if (\Auth::check()) {
			$user_id    = \Auth::user()->id;
			$product['user_id'] = $user_id;
			$cart_cookie_id     = 0;
		}
		$this->Addcart($product);
		if (isset($request->key) && $request->key == 'checkout') {
			$aCartPriceInfo = \AbserveHelpers::getCheckoutcartprice($user_id,$res_id);
			$html           = (string) view('front.cart.checkoutcart',$aCartPriceInfo);
		} else {
			$cur_resid      = $res_id;
			$html           = $this->Showcart($cur_resid,$res_id,$user_id,$cart_cookie_id);
		}
        $searchhtml         = (new FrontEndController)->ShowSearchcCart($res_id,$user_id,$cart_cookie_id);
		$headCartCount      = \AbserveHelpers::getCartItemCount();
		$response['html']   = (string) $html;
        $response['searchhtml']     = $searchhtml;
		$response['headCartCount']  = $headCartCount;
		$emptyhtml  = ''; $cart = 'notempty';
		if($html == '') {
			$cart   = 'empty';
			$emptyhtml = view('front.empty_checkout');
		}
		$response['emptyhtml'] = (string) $emptyhtml;
		$response['cart'] = $cart;
		return Response::json($response);
	}

	public function Addcart( $input)
	{
		$values = array("user_id" => $input['user_id'],"res_id" => $input['res_id'],"food_id" => $input['food_id'],"food_item" => $input['food_item'],"price" => $input['price'],"quantity" => $input['quantity'],"cookie_id" => $input['cookie_id'],"tax" => $input['tax'],'vendor_price' => $input['vendor_price'],'adon_id' => $input['adon_id'],'adon_type' => $input['adon_type'],'adon_details' => $input['adon_details'],'gst' => $input['gst'],'strike_price' => $input['strike_price'],'unit' => $input['unit']);
		if($input['user_id'] != '0'){
			$user_res_equal = \DB::table('abserve_user_cart')->where("user_id",$input['user_id'])->where("res_id",$input['res_id'])->exists();
		} else { 
			$user_res_equal = \DB::table('abserve_user_cart')->where("cookie_id",'=',$input['cookie_id'])->where("res_id",'=',$input['res_id'])->exists();	
		}

		if ($user_res_equal) {
			if ($input['user_id'] != '0') {
				if ($input['adon_id'] > 0) {
					$user_food_equal = \DB::table('abserve_user_cart')->where("user_id",'=',$input['user_id'])->where("food_id",'=',$input['food_id'])->where("adon_id",'=',$input['adon_id'])->where("adon_type",'=',$input['adon_type'])->exists();
				} else {
					$user_food_equal = \DB::table('abserve_user_cart')->where("user_id",'=',$input['user_id'])->where("food_id",'=',$input['food_id'])->where("unit",'=',$input['unit'])->exists();
				}
			} else {
				if ($input['adon_id'] > 0) {
					$user_food_equal = \DB::table('abserve_user_cart')->where("cookie_id",'=',$input['cookie_id'])->where("food_id",'=',$input['food_id'])->where("adon_id",'=',$input['adon_id'])->where("adon_type",'=',$input['adon_type'])->exists();
				} else {
					$user_food_equal = \DB::table('abserve_user_cart')->where("cookie_id",'=',$input['cookie_id'])->where("food_id",'=',$input['food_id'])->exists();
				}
			}
			if ($user_food_equal) {
				if ($input['user_id'] != '0') {
					if ($input['adon_id'] > 0) {
						$quantity = \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$input['user_id'])->where("food_id",'=',$input['food_id'])->where("adon_id",'=',$input['adon_id'])->where("adon_type",'=',$input['adon_type'])->where("unit",'=',$input['unit'])->get();
					} else {
						$quantity = \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$input['user_id'])->where("food_id",'=',$input['food_id'])->where("unit",'=',$input['unit'])->get();

					}
				} else {
					if ($input['adon_id'] > 0) {
						$quantity = \DB::table('abserve_user_cart')->select('*')->where("cookie_id",'=',$input['cookie_id'])->where("food_id",'=',$input['food_id'])->where("adon_id",'=',$input['adon_id'])->where("adon_type",'=',$input['adon_type'])->where("unit",'=',$input['unit'])->get();
					} else {
						$quantity = \DB::table('abserve_user_cart')->select('*')->where("cookie_id",'=',$input['cookie_id'])->where("food_id",'=',$input['food_id'])->where("unit",'=',$input['unit'])->get();
					}
				}
				$fid = $quantity[0]->id;
				if($input['quantity'] == 0){
					\DB::table('abserve_user_cart')->where("id",'=',$fid)->delete();
				} else {
					$vals	= array("user_id"=>$input['user_id'],"res_id"=>$input['res_id'],"food_id"=>$input['food_id'],"food_item"=>$input['food_item'],"price"=>$input['price'],"quantity"=>$input['quantity'],"cookie_id"=>$input['cookie_id'],"tax"=>$input['tax'],'vendor_price'=>$input['vendor_price'],'adon_details'=>$input['adon_details'],'gst'=>$input['gst'],'strike_price' => $input['strike_price']);
					\DB::table('abserve_user_cart')->where("id",'=',$fid)->update($vals);
				}
			} else {
				$cartCheck = \DB::table('abserve_user_cart')->where('user_id',$input['user_id'])->where('cookie_id',$input['cookie_id'])->where('res_id',$input['res_id'])->first();
				if(!empty($cartCheck)){
					$values['distance_km'] 	= $cartCheck->distance_km;
					$values['duration'] 	= $cartCheck->duration;
					$values['address_id'] 	= $cartCheck->address_id;
					$values['coupon_id'] 	= $cartCheck->coupon_id;
					$values['ordertype'] 	= $cartCheck->ordertype;
					$values['delivertype'] 	= $cartCheck->delivertype;
					$values['deliverdate'] 	= $cartCheck->deliverdate;
					$values['delivertime'] 	= $cartCheck->delivertime;
				}
				\DB::table('abserve_user_cart')->insert($values);
			}
		}else{
			if($input['user_id'] != '0'){
				\DB::table('abserve_user_cart')->where('user_id', '=', $input['user_id'])->delete();
			} else {
				\DB::table('abserve_user_cart')->where('cookie_id', '=', $input['cookie_id'])->delete();
			}
			\DB::table('abserve_user_cart')->insert($values);
		}
		//return $this->getCartData(true);
	}

	public function Showcart($cur_resid,$res_id,$user_id,$cookie_id,$keyinfo='') 
	{
		//session()->set('error','Item created successfully.');
		$min_val		= (\Session::has('min_order_val')) ? \Session::get('min_order_val') : '0';
		$min_order_val	= number_format((float)\AbserveHelpers::CurrencyValue($min_val),2,'.','');
		$resInfo		= Restaurant::find($cur_resid);
		$cartResInfo	= Restaurant::find($res_id);
		$res_timeValid			= \AbserveHelpers::gettimeval($cur_resid);
		$cart_res_time_valid	= \AbserveHelpers::gettimeval($res_id);
		\Session::put('restimevalid',$res_timeValid);
		$CartResTimeText	= $innerhtml = $html = $cnt_items ='';
		$item_total = 0;$delivery_charge = '0.00';
		if ($res_id == 0 || empty($cartResInfo)) {
			$empty_url	= \URL::to('').'/sximo5/images/themes/images/cartempty.png';
			$html		.= '<div class="righttittle">Cart Empty</div>
			<img src="'.$empty_url.'" class="rghtimg img-responsive"><div class="goodfood">
			</div>';
			return $html;
		}

		if ($user_id != '0') {
			$user_food_equal	= \DB::table('abserve_user_cart')->where("user_id",'=',$user_id)->exists();
			if ($user_food_equal) {
				$foods_items	= \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$user_id)->where("res_id",'=',$res_id)->get();
			} else {
				$cookie_food_equal	= \DB::table('abserve_user_cart')->where("cookie_id",'=',$cookie_id)->where("res_id",'=',$res_id)->exists();
				if ($cookie_food_equal) {
					$array['user_id']	= $user_id;
					\DB::table('abserve_user_cart')->where("cookie_id",'=',$cookie_id)->update($array);
					$foods_items		= \DB::table('abserve_user_cart')->select('*')->where("cookie_id",'=',$cookie_id)->where("res_id",'=',$res_id)->get();
				}
			}
		} else if($cookie_id != '0') {
			$foods_items = \DB::table('abserve_user_cart')->select('*')->where("cookie_id",'=',$cookie_id)->where("res_id",'=',$res_id)->get();
		}
		$innerhtml = '';$item_total = 0;$delivery_charge = '0.00'; $cnt_items ='';
		if (!empty($foods_items)) {
			$cartCount	= (count($foods_items) > 1) ? (count($foods_items).' Items') : (count($foods_items).' Item');
			$cnt_items	= count($foods_items);
			$itemcount	= \DB::table('tb_settings')->select('item_count')->where('id',1)->first();
			$itemcnt	= $itemcount->item_count;
			$quan		= 0;
			foreach ($foods_items as $key => $value) {
				$quan	+= $value->quantity;
			}
			$innerhtml	.= '<input type="hidden" value="'.$quan.'" id="quan">';
			$innerhtml	.= '<input type="hidden" value="'. $itemcnt.'" id="countitem">';
			$innerhtml	.= '<input type="hidden" value="'. $res_id.'" id="res_id_cart">';
			//if($quan <=  $itemcnt){
			$currsymbol	= \AbserveHelpers::getCurrencySymbol();
			$timeCheck	= 'true';
			// $innerhtml.=' <div class="cartsectionitems"><div class="cart-loader" style="display:none;"></div>';
			foreach ($foods_items as $ky => $val) {
				$aFoodItem		= \App\Models\Front\Fooditems::find($val->food_id);
				$deleteclass	= '';
				$item_time_valid= \AbserveHelpers::getItemTimeValid($val->food_id);
				$foodInfo		= \DB::table('abserve_hotel_items')->select('status')->where('id',$val->food_id)->first();
				if($item_time_valid != 1){
					$timeCheck	= 'false';
				}
				$hikedPrice		= (isset($aFoodItem->original_price) * (isset($aFoodItem->hiking) /100));
				$gstHikedPrice	= ($hikedPrice * ($val->gst /100));
				$price_val		= $val->price/* + $hikedPrice + $gstHikedPrice*/;
				$total			= ($val->quantity * $price_val);
				$strike_price	= ($val->quantity * $val->strike_price);
				$unitid         =$val->unit;

				$unitname		=Variations::where('id',$unitid)->get();
				$unitnameval='';
				if(!$unitname->isEmpty()){
					$unitnameval	=$unitname[0]->cat_name;
				}

				$innerhtml		.= ' <div class="menu-cart-items" id="item_'.$val->food_id.'_'.$val->adon_id.'">
				';
				$innerhtml		.= '<div class="item_naem" style="margin-right:20px">
				<p class="veg-item">'.$val->food_item.'<br>'.$unitnameval.'</p>
				
				
				</div>';
				if ($item_time_valid == 1) {
					$afid	= $val->food_id;
					if ($val->adon_id > 0) {
						$afid	.='_'.$val->adon_id;
					}
					$innerhtml	.= '<div class="block-item text-center no-pad items_count" id="fnitem_'.$val->food_id.'_'.$val->adon_id.'" style="margin-right:20px">
					<span class="remove_cart_item count_in_dec" data-isad="'.$aFoodItem->show_addon.'" data-faid="'.$val->food_id.'" data-type="'.$val->adon_type.'" >
					<i data-faid="'.$val->food_id.'" data-aid="'.$val->adon_id.'" data-type="'.$val->adon_type.'" class="fa fa-minus "  aria-hidden="true" style="cursor:pointer;"></i></span>
					<span id="afid_'.$afid.'_'.$val->adon_id.'" class="item-count afid_'.$afid.'" data-unit="'.$val->unit.'">'.$val->quantity.'</span>
					<span class="add_cart_item count_in_dec" data-faid="'.$val->food_id.'" data-aid="'.$val->adon_id.'" data-type="'.$val->adon_type.'"  data-isad="'.$aFoodItem->show_addon.'" >
					<i data-faid="'.$val->food_id.'"  id="fitem_'.$val->food_id.'" class="fa fa-plus " aria-hidden="true" style="cursor:pointer;"></i></span></div>';
					if($strike_price > 0) {
						$innerhtml .= '<span class="text-right"><s style="color:red;">'.$currsymbol.number_format($strike_price,2,'.','') .'</s></span>';
					}
					$innerhtml	.=   '<span class="block-item text-right '.$deleteclass.'">
					<div>'.$currsymbol.' <span class="item-price">'.number_format($total,2,'.','').'</span></span>';

				} else {
					$deleteclass	= 'item_delete';
					$innerhtml		.= '<div class="block-item text-center no-pad unavail_item"><span>Unavailable</span></div>';
					$innerhtml		.=   '<div class="block-item text-right '.$deleteclass.'">
					<div>'.$currsymbol.' <span class="item-price">'.number_format($total,2,'.','').'</span></div>';
					$innerhtml		.= '<span class="delete_item" data-cart-id="'.$val->id.'"><i class="fa fa-trash"></i></span>';
				}
				$innerhtml	.=  '</div>
				</div>';
				$item_total	+= $total;
			}
			// $innerhtml.=' </div>';
			$html = '';
			if ($innerhtml != '') {
				if ($keyinfo == 'checkout') {
					$closetime	= date("H:i a", strtotime($resInfo->opening_time));
						//$bookingnote = '<h5><font color="red">Restaurent will be closed sooner.Next available at '.$closetime.'</font></h5>';
					$bookingnote	= '';
				} else {
					$bookingnote	= '';
				}
				$astart	= '';
				if ($cur_resid != $res_id) {
					$astart .= "<div class='restaurent_name'>from <a href='".\URL::to('/frontend/details/'.$res_id)."'><b>".$cartResInfo->name."</b></a></div>";
				}
				$html = ' <section><div class="cartsection">
				<div class="menu-cart-title">
				<div class="rphidetitle">Cart</div>'.$bookingnote.$astart.'
				<div class="rphitem">'.$cartCount.'</div>'.$CartResTimeText.'
				</div>
				<div class="menu-cart-body " >'.$innerhtml.'</div>
				<div class="menu-cart-footer">';
				if ($cartResInfo->offer >0 &&  $cartResInfo->offer <= 100) {
					$offer_amount	= $item_total * ($cartResInfo->offer / 100);
				} else {
					$offer_amount	= 0;
				}
				$actual_total	= $item_total;
				$grand_total	= $item_total - $offer_amount;
				$offerText		= '';
				if($offer_amount > 0 && $offer_amount <= $item_total ) {
					$offerText	= '<strike>'.$currsymbol.number_format($actual_total,2,'.','').'</strike>';
				}
				$html	.= '<div class="final-total">
				<h5><span class="sub_total">Subtotal</span>
				<span class="pull-right">'.$offerText.''.$currsymbol.' <span class="grand_total">'.number_format($grand_total,2,'.','').'</span></span>
				</h5>
				<div class="extra_charge">Extra charges may apply</div>';
				if ($resInfo->minimum_order > 0 && $resInfo->minimum_order > $item_total) {
					if ($resInfo->minimum_order <= $grand_total) {
						$Bcolor	= "green";
					}else{
						$Bcolor	= "#b55a5a";
					}
					$html		.= '<div style="text-align: center;font-weight: bold;color: #FFF;font-size: 17px;background-color:'.$Bcolor.';padding:10px" class="extra_charge">Minimum order value is '.$currsymbol.' '.$resInfo->minimum_order.'</div>';
				}
				$html	.= '</div>';
				if ($res_id != '') { // If cart is not empty
					if ($cart_res_time_valid == 1) {
						if (\Auth::check()) {
							if ($timeCheck != 'true') {
								$checkout	= '<button class="btn btn-checkout" id="btn-checkout" disabled>Checkout</button>';
							} else {
								if($resInfo->minimum_order >= 0 && $resInfo->minimum_order<=$item_total){
									$checkout	= "<a href='".\URL::to('/checkout')."'><button class='btn btn-checkout' id='btn-checkout' >Checkout</button></a>";
								}else{
									$checkout	= '<button class="btn btn-checkout" id="btn-checkout" disabled>Checkout</button>';
								}
							}
						} else {
							$checkout	= '<button class="btn btn-checkout login_checkout" id="btn-checkout" >Checkout</button>';
						}
					} else {
						if ($cart_res_time_valid != 1) {
							if ( $res_id != $cur_resid) {
								$CartResTimeText	= '<div class="CartResTimeText"><font color="red">'.$cartResInfo->name.' not available now</font></div>';
							} else {
								$getText	= \AbserveHelpers::getNextAvailableTimeRes($cur_resid);
								$CartResTimeText = '<div class="CartResTimeText"><font color="red">'.$getText.'</font></div>';
							}
						}
						$checkout	= '<button class="btn btn-checkout" id="btn-checkout" disabled>Checkout</button>';
					}

				}
				$html	.= $checkout.'</div></section>';
			}else{
				$html	.= '<section>
				<div class="menu-cart-title"><h1>Your Cart</h1></div>
				<div class="menu-cart-body empty" ><div class="cart-quotes"></div></div>
				<div class="menu-cart-footer">
				<button class="btn btn-checkout" disabled id="btn-checkout">Checkout</button>
				</div>
				</section>';
			}
		} else {
			$empty_url	= \URL::to('').'/sximo5/images/themes/images/cartempty.png';
			$html		.= '<div class="righttittle">Cart Empty</div>
			<img src="'.$empty_url.'" class="rghtimg img-responsive"><div class="goodfood">
			</div>';
		}
		return $html;
	}

	public function postDeletecartitem(Request $request)
	{
		$cartId		= $request->cartId;
		$cur_resid	= $request->res_id;
		$exist		= Usercart::select('*')->where('id',$cartId)->first();
		if(!empty($exist)){
			$resId	= $exist->res_id;
			Usercart::where('id',$cartId)->delete();
		}
		$cart_cookie_id = \AbserveHelpers::getCartCookie();
		$msg = 'success';
		if(\Auth::check() || $request->from == 'checkout'){
			if($request->from != 'checkout'){
				$user_id = \Auth::id();
				$yourcart1	=  Usercart::where('user_id','=',$user_id)/*->where('id', DB::raw("(select max(`id`) from abserve_user_cart)"))*/->first();

			} else {
				if(\Auth::check()){
					$user_id	= \Auth::id();
					$yourcart1	=  Usercart::where('user_id','=',$user_id)/*->where('id', DB::raw("(select max(`id`) from abserve_user_cart)"))*/->first();
				} else {
					$msg = 'unauthorized';
				}
				$gettimeValids = \AbserveHelpers::getTimeValids($resId,$user_id);
				$response['restimevalid'] = $gettimeValids['restimevalid'];
				$response['itemtimevalid'] = $gettimeValids['itemtimevalid'];
			}
		} else {
			$user_id = 0;
			$yourcart1	=  Usercart::where('cookie_id','=',$cart_cookie_id)/*->where('id', DB::raw("(select max(`id`) from abserve_user_cart)"))*/->first();
		}
		if(!empty($yourcart1)){
			$resId	= $yourcart1->res_id;
		}
		if($request->from == 'checkout'){
			$aCartPriceInfo	= \AbserveHelpers::getCheckoutcartprice($user_id,$resId);
			$aCartPriceInfo['wallet_used']	= (!empty($yourcart1)) ? $yourcart1->wallet : 0;
			$html	= (string) view('frontend.checkoutcart',$aCartPriceInfo);
		} else {
			$html		= $this->Showcart($cur_resid,$resId,$user_id,$cart_cookie_id,'');
			$frontCon	= new frontCon();
			$searchhtml		= $frontCon->ShowSearchcCart($resId,$user_id,$cart_cookie_id);
			$headCartCount	= \AbserveHelpers::getCartItemCount();
			$response['searchhtml'] = $searchhtml;
			$response['headCartCount'] = $headCartCount;
		}
		$response['html'] = $html;
		
		return Response::json($response);
	}

	public function getCouponlist(Request $request)
	{
		$res_id=$request->res_id;
		if(\Auth::check()){
			$data['authid'] = $user_id = \Auth::user()->id;
			$coupons = \AbserveHelpers::getAvailablePromos($user_id,$code='',$cartPrice='',$res_id='',$promo_id = '');
			$data['coupons'] = $coupons;
			// return view('frontend.couponlist',$data);
			$html = view('front.couponlist',$data);
			$msg = 'success';
		}else {
			$html = '';
			$msg = 'unauthorized';
		}
		$response['html'] = (string)$html;
		$response['msg'] = $msg;
		return Response::json($response);
	}

	public function getPromocheck(Request $request)
	{
		$msg = $html = '';
		$res_id 	= $request->res_id;
		$user_id = \Auth::user()->id;
		if(\Auth::check()){
			$promoId = 0;
			$msg = 'invalid';
			if($request->couponcode != ''){
				$promocode = Promocode::where('promo_code',$request->couponcode)->first();
				if(!empty($promocode)){
					$promoId = $promocode->id;
				}
			} else {
				$promoId 	= $request->couponid;
				$promocode = Promocode::find($promoId);
			}

			if($promoId > 0){
				$users 		= $request->promouser;
				$user_id = \Auth::user()->id;
				$val['coupon_id'] = 0;
				$promoCheck = \AbserveHelpers::getAvailablePromos($user_id,$code='',$cartPrice='',$res_id,$promoId);
				
				if(count($promoCheck) == 1){
					$cartTotal = \AbserveHelpers::getCheckoutcartprice($user_id,$res_id)['itemPrice'];
					if($cartTotal >= $promoCheck[0]->min_order_value){
						$promoAmount = \AbserveHelpers::getPromoAmount($promoId,$cartTotal);
						$response['cartTotal'] = $cartTotal;
						$response['funsta'] = 'true';
						$response['promoId'] = $promoId;
						$response['promouser'] = 'all';
						$msg = 'success';
						$val['coupon_id'] = $promoId;
					} else {
						$msg = 'notsufficient';
					}
				}
				// echo '<pre>';print_r($promoAmount);exit();
				\DB::table('abserve_user_cart')->where('user_id',$user_id)->update($val);
				$yourcart1		=  \DB::table('abserve_user_cart')->where('user_id','=',$user_id)/*->where('id', DB::raw("(select max(`id`) from abserve_user_cart)"))*/->first();

				$aCartPriceInfo = \AbserveHelpers::getCheckoutcartprice($user_id,$res_id);
				$aCartPriceInfo['wallet_used']	= (!empty($yourcart1)) ? $yourcart1->wallet : 0;
				$html=(string) view('front.cart.checkoutcart',$aCartPriceInfo);
			}
			$gettimeValids = \AbserveHelpers::getTimeValids($res_id,$user_id);
			$response['restimevalid'] = $gettimeValids['restimevalid'];
			$response['itemtimevalid'] = $gettimeValids['itemtimevalid'];
		} else {
			$msg = 'unauthorized';
		}
		$response['msg'] = $msg;
		$response['html'] = $html;
		return Response::json($response);
	}

	public function getRemovecoupon(Request $request)
	{
		$html = '';
		if(\Auth::check()){
			$res_id = $request->res_id;
			$authid = \Auth::id();
			$exist = \DB::table('abserve_user_cart')->where('user_id',$authid)->where('res_id',$res_id)->exists();
			if($exist){
				\DB::table('abserve_user_cart')->where('user_id',$authid)->where('res_id',$res_id)->update(array('coupon_id' => 0));
			}
			$aCartPriceInfo = \AbserveHelpers::getCheckoutcartprice($authid,$res_id);
			$html=(string) view('front.cart.checkoutcart',$aCartPriceInfo);
			$msg = 'success';
		} else {
			$msg = 'unauthorized';
		}
		$response['msg'] = $msg;
		$response['html'] = $html;
		return Response::json($response);
	}

	public function postUpdatewallet(Request $request)
	{
		$status	= 0;
		$message= 'Something Went Wrong';
		if (\Auth::check() || ($request->user_id != '' && $request->user_id != 0)) {
			$status		= 0;
			$message	= 'Empty cart';
			$user_id	= (isset($request->from) && $request->from == 'mobile') ? $request->user_id : ((\Auth::check()) ? \Auth::id() : 0 ) ;
			$cookie_id	= ($request->device_id != '') ? $request->device_id : \Cookie::get('mycart') ;
			$userCart		= \AbserveHelpers::uCartQuery($user_id, $cookie_id);
			$foods_items	= clone ($userCart);
			$foods_items	= $foods_items->get();
			if (!empty($foods_items)) {
				$status		= 0;
				$message	= 'Not Applicable...';
				$cartTotal	= \AbserveHelpers::getCartTotal($user_id,$cookie_id);
				$cWallet	= (isset($request->from) && $request->from == 'mobile') ? $request->customer_wallet : \Auth::user()->customer_wallet;
				$aCartPriceInfo	= \AbserveHelpers::getCheckoutcartprice($user_id,$foods_items[0]->res_id);
				if ($aCartPriceInfo['GtotalWithoutoff'] > 0 && ($aCartPriceInfo['GtotalWithoutoff'] >= $request->amount && $cWallet >= $request->amount)) {
					$status		= 1;
					$message	= 'Applied';
					$userCart->update(['wallet' => $request->amount]);
					$aCartPriceInfo['wallet_used']	= $foods_items[0]->wallet;
					$response['html']	= (string) view('front.cart.checkoutcart',$aCartPriceInfo);
				}/*elseif($request->amount == 0){
					$status		= 1;
					$message	= 'Applied';
					$userCart->update(['wallet' => $request->amount]);
					$aCartPriceInfo['wallet_used']	= $foods_items[0]->wallet;
				}*/
			}
		}
		$response['status']		= $status;
		$response['message']	= $message;
		return Response::json($response);
	}

	public function Trackorder(Request $request)
	{
	    if (!(\Auth::check())) {
			return Redirect::to('/');
		} 	
		$orderid=$request->orderId;
		$order_Id1=base64_decode($orderid);
		$ordercon = new ordercon;
		$iOrderId = $order_Id1;
		$response = $ordercon->getOrderDetail($iOrderId,\Auth::user()->id);
		$response['orderidenc'] =$orderid;
		$access_token = \Session::get('access_token');
		return (string) view('front.cart.success',$response['aOrder'],$response)->with('access_token',$access_token);
	}

	public function postAcceptitem(Request $request)
	{
		$aOrder = OrderDetail::with(['accepted_order_items','outof_stock_items'])->find($request->id);
		$aOrder['outOfStockItems'] = (!empty($aOrder->outof_stock_items)) ? implode(', <br>', $aOrder->outof_stock_items->pluck('food_item')->toArray()) : '' ;
		return (string) view('front.accepteditems',$aOrder);
	}

	function orderPayHandler($order_id,$webhook = false)
	{
		$iOrderId	= $order_id;
		$aOrder		= OrderDetail::where('orderid',$iOrderId)->first();
		$status		= 422;
		$message	= 'You do not have access';
		$time		= strtotime(date("Y-m-d H:i:s")) - strtotime($aOrder->created_at);
		$doRefund	= false;

		if($aOrder->delivery == 'unpaid' && $aOrder->status == 'pending' ){
			if($aOrder->delivery_type == 'razorpay') {
				$api_key	= RAZORPAY_API_KEYID;
				$api_secret	= RAZORPAY_API_KEY_SECRET;
				/*if ($aOrder->cust_id == 4722) {
					$myfile	= fopen(base_path()."/newfile.txt", "w") or die("Unable to open file!");
					$ftime	= $aOrder->created_at;
					$ttime	= date("Y-m-d H:i:s");
					$seconds = (strtotime($ttime) - strtotime($ftime));
					$minutes = ($seconds / 60 );
					$txt	= "Suganya's Testing for Order ID -- " . $aOrder->id ."\n";
					$txt .= $ftime	. "\n";
					$txt .= $ttime	. "\n";
					$txt .= "Time ===> " . time(). "\n";
					$txt .= "Strtotime ===> " . strtotime(date("Y-m-d H:i:s")). "\n";
					$txt .= "Seconds ===> " . $seconds . "\n";
					$txt .= " Minutes ===> " . $minutes. "\n\n";
					fwrite($myfile, $txt);
					// fclose($myfile);
				}*/
				if (!$webhook) {
					$api	= new Api($api_key, $api_secret);
					$order	= $api->order->fetch($aOrder->orderid);
					// $token = $order->payments()->items[0]->id;
					/*if ($aOrder->cust_id == 4722) {
						fwrite($myfile, json_encode($order). "\n\n");
					}*/
					$token	= ( ($order->status == 'paid') && isset($order->payments()->items[0]) ) ? $order->payments()->items[0]->id : '';
				} else {
					$order = [];
					$token = $webhook;
				}
				/*if ($aOrder->cust_id == 4722) {
					fclose($myfile);
				}*/
				if ((!empty($order) && $order->status == 'paid') || $webhook) {
					if ($time < CNF_PAY_SUCCESS_WAIT_TIME) { // 10 mins
						$aOrder->delivery		= 'paid';
						$aOrder->paid_amount	= $aOrder->grand_total;
						$aOrder->payment_token	= $token;
						$aOrder->updated_at		= date('Y-m-d H:i:s');
						$aOrder->save();
						$payment = OrderPayment::where('order_id',$aOrder->id)->first();
						$payment->transaction_status	= 'paid';
						$payment->transaction_id		= $aOrder->payment_token;
						$payment->transaction_orderid	= $aOrder->orderid;
						$payment->type					= 'credit';
						$payment->updated_at			= date('Y-m-d H:i:s');
						$payment->save();
						// Offer wallet
						$offerData	= \AbserveHelpers::Offerdata($aOrder->cust_id,$aOrder->total_price);
						$aOrder->cash_offer	= $offerData['cashOffer'];
						$aOrder->save();
						if ($offerData['cashOffer'] > 0) {
							$offer_table			= new OfferUsers;
							$offer_table->order_id	= $aOrder->id;
							$offer_table->cust_id	= $aOrder->cust_id;
							$offer_table->type		= 'debit';
							$offer_table->reason	= $offerData['OfferName']. ' offer redeem';
							$offer_table->offer_price	= $offerData['cashOffer'];
							$offer_table->offer_name	= $offerData['OfferName'];
							$offer_table->grand_total	= $aOrder->grand_total; 
							$offer_table->save();
						}
						$user_offer	= Users::find($aOrder->cust_id,['id','offer_wallet']);
						$cash_back_value = $user_offer->offer_wallet - $offerData['cashOffer'];
						$user_offer->offer_wallet	= $cash_back_value;
						$user_offer->save();

						//Send Notification to Partner 
						$message	= "Your payment for #".$aOrder->id." paid successfully";
						$this->sendpushnotification($aOrder->cust_id,'user',$message);
						$this::sleep($aOrder->id);
						Usercart::where('user_id',$aOrder->cust_id)->delete();
						$status = 200;
						$message = 'Payment Completed successfully';
						$data['orderId'] = $aOrder->id;
					} else {
						$doRefund = true;
						$message = 'Your order #'.$aOrder->id.' cancelled due to delay. We will refund your amount and you will receive within 5-7 business working days';
					}
				} else if(!empty($order)) {
					$message = 'Payment Status : '.$order->status;
				} else {
					$message = 'Razor order not yet created';
				}
			} else {
				$message = 'This is not online payment';
			}
		} else {
			$message = $aOrder->delivery == 'paid' ? 'Already Paid' : 'Order Already '.$aOrder->status;
		}

		$data['doRefund'] = $doRefund;
		$data['status'] = $status;
		$data['message'] = $message;
		return $data;
	}

	function orderPaymentModeUpdate(Request $request,$user_id)
	{
		$iOrderId = $request->order_id;
		$aOrder = OrderDetail::find($iOrderId);
		$status = 422;
		$message = 'You could not process this order';
		$curTime = time();
		$placedTime = strtotime($aOrder->created_at);
		$time = $curTime - $placedTime;
		if($aOrder->delivery_type == 'razorpay' && $aOrder->delivery == 'unpaid' && $aOrder->status == '0') {
			if($time < CNF_PAY_WAIT_TIME){ // 600 - 10mins
				$update = false;
				if($request->payment_type == $aOrder->delivery_type){
					$update = true;
				} else {
					if($request->payment_type == 'cashondelivery'){
						$update = true;
						$aOrder->orderid = $placedTime;
					}
				}
				if($update){
					$message = 'success';
					$aOrder->delivery_type = $request->payment_type;
					$aOrder->updated_at = date('Y-m-d H:i:s');
					$aOrder->save();
					$status = 200;
					$data['orderId'] = $aOrder->id;

					if($aOrder->delivery_type == 'cashondelivery'){
							//Send Notification to Partner 
						$message 		= "New orders found in your shop";
						$this->sendpushnotification($aOrder->partner_id,'user',$message);

							//Emit Socket
						if(SOCKET_ACTION == 'true'){
							require_once SOCKET_PATH;		
							$client->emit('new order placed', $aOrder->partner_id);
						}
					}
				}
			}
		}
		$data['status'] = $status;
		$data['message'] = $message;
		return $data;
	}

	public function getCompress()
	{
		ini_set('max_execution_time', -1);
		$dir = base_path().'/uploads/images/';
		$array = scandir($dir,1);
		foreach ($array as $key => $value) {
			if($value != '.' && $value != '..' && $value != '.gitignore')
			{
				\AbserveHelpers::compressor($dir.$value,true);
			}
		}
	}
}
?>