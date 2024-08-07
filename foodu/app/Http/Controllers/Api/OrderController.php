<?php namespace App\Http\Controllers\Api;
ini_set( 'serialize_precision', -1 );
use App\Http\Controllers\Controller;
use Input, Response, DB , Validator , Redirect;
use App\Models\Front\Deliveryboy;
use App\User;
use Illuminate\Http\Request;
use App\Models\Front\OrderDetails;
use App\Models\OrderDetail;
use App\Models\OrderItems;
use App\Models\OrderRefund;
use App\Models\RefundDetails;
use App\Models\Refundinfo;
use App\Models\OfferUsers;
use App\Models\Fooditems;
use App\Models\Front\RestaurantTiming;
use App\Models\Front\Restaurant;
use App\Models\Front\Usercart;
use App\Models\Wallet;
use App\Models\Front\Offers;
use App\Models\Orderstatustime;
use App\Models\RiderLocationLog;
use App\Models\OrderPayment;
use App\Http\Controllers\Front\CheckoutController as checkcon;
use App\Http\Controllers\mobile\UserController as MobileUserController;
use App\Http\Controllers\EmailController as emailcon;
use App\Http\Controllers\mobile\RapidoController as rapidoCon;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Front\DetailsController;
use App\Models\Deliveryboyneworder;
use App\Models\Useraddress;
use App\Models\Deliveryboywallet;
use App\Models\Partnerwallet;
//use LucaDegasperi\OAuth2Server\Authorizer;
use Razorpay\Api\Api;
class OrderController extends Controller {
	function __construct()
	{
		if( ( request('group_id') == 5 || request('user_type') == 'delivery' )  ){
			$user = User::class;
		} else {
			$user = User::class;
		}

	    \Config::set('jwt.user', $user);
	    \Config::set('auth.providers', ['users' => [
	            'driver' => 'eloquent',
	            'model' => $user,
	        ]]);
	    parent::__construct();
	}

	function getProfile( Authorizer $authorizer,$user_type )
	{
		$user_id = $authorizer->getResourceOwnerId(); // the token user_id
		if($user_type == 'user'){
			$user = User::find($user_id);
		} else {
			$user = Deliveryboy::find($user_id);
		}
		if(empty($user)){
			$response['message'] =  'Invalid User';
			response()->json($response, 422)->send();exit();
		}
		return $user;
	}

	function getStepvalidation($error)
	{
		foreach ($error as $key => $value) {  
			$val= $value[0];
		} 
		return $val;
	}

	function getReadabletimeFromSeconds($seconds)
	{
		if($seconds >0 ){
			$seconds = (int) $seconds;
			$dtF    = new \DateTime('@0');
			$dtT    = new \DateTime("@$seconds");
			$text   = '';
			$diff   = $dtF->diff($dtT);
			$days = $diff->format('%a');
			$hours = $diff->format('%h');
			$minutes = $diff->format('%i');
			if($days > 0){
				if($text != ''){
					$text .= ', ';
				}
				$text .= $days.' days';
			}
			if($hours > 0){
				if($text != ''){
					$text .= ', ';
				}
				$text .= $hours.' hours';
			}
			if($minutes > 0){
				if($text != ''){
					$text .= ', ';
				}
				$text .= $minutes.' minutes';
			}
			return $text;
		}else
		{
			return 0;
		}
	}

	function calculate_distance($values)
	{
		$keys = \AbserveHelpers::site_setting('googlemap_key');
		$ch		= curl_init();
		if($values['type'] == 'address'){
			$url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.urlencode($values['from_address']).'&destinations='.urlencode($values['to_address']).'&mode=drive&sensor=false&key='.$keys->googlemap_key;
		} elseif ($values['type'] == 'coordinates') {
			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$values['lat1'].",".$values['long1']."&destinations=".$values['lat2'].",".$values['long2']."&mode=driving&language=pl-PL&key=".$keys->googlemap_key;
		}
		
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output	= curl_exec($ch);
		curl_close($ch);

		$rwes = json_decode(json_encode(json_decode($output)));

		$data['rwes'] = $rwes;
		$data['status'] = false;
		$data['apiStatus'] = $rwes->status;
		$data['distance'] = $data['duration'] = $data['total_km'] = $data['total_time'] = 0;
		$data['durationText'] = '';
		if($rwes->status == "OK"){
			if($rwes->rows[0]->elements[0]->status == 'OK'){
				$data['distance'] = $rwes->rows[0]->elements[0]->distance->value;
				$data['duration'] = $rwes->rows[0]->elements[0]->duration->value;
				$data['durationText'] = $rwes->rows[0]->elements[0]->duration->text;
				$data['status'] = true;
				$data['total_km'] = number_format(($data['distance'] * 0.001),2,'.','');
			} else {
				$data['apiStatus'] = $rwes->rows[0]->elements[0]->status;
			}
		}
		// echo "<pre>";print_r($data);exit();

		return $data;
	}

	/*function insertOrder(Request $request)
	{
		// $rules['type'] 	 = 'required|in:later,asap';
		$rules['action'] = 'required|in:insert,payhandler,paymodeUpdate';
		if($request->input('action') !== null && ($request->action == 'payhandler' || $request->action == 'paymodeUpdate')){
			$rules['order_id'] = 'required';
			$rules['payment_type'] = 'required|in:cashondelivery,razorpay,wallet';
		} else {
			$rules['payment_type'] = 'required|in:cashondelivery,razorpay,wallet';
		}
		if($request->payment_type == 'razorpay'){
			$rules['payment_id'] = 'required';
		}

		$this->validateDatas($request->all(),$rules);

		$aUser =\Auth::user();
		$user_id = $aUser->id;
		$request['mobile_num'] = $aUser->phone_number;

		// if($request->action != 'insert'){
		// 	$aOrder = OrderDetail::find($request->order_id);
		// 	if(empty($aOrder) || $aOrder->cust_id != $aUser->id){
		// 		$status = 422;
		// 		$message = 'You do not have access';
		// 		return \Response::json(['message'=>$message],$status);
		// 	}
		// }

		$checkcon = new checkcon;
		$aCart = Usercart::where('user_id',$user_id)->first();
		$aCartPriceInfo = \AbserveHelpers::getCheckoutcartprice($user_id,$aCart->res_id,true);
		extract($aCartPriceInfo);	
		$request["address_id"]= $aUserCart[0]->address_id;
		$request["res_id"]= $aCart->res_id;
		$request["ordertype"]= "delivery";
		$request["deliverType"]= $request->type;
		$request["deliverDate"]= $request->l_date;
		$request["deliverTime"]= $request->l_time;
		
		$resp = DetailsController::postCheckneareraddress($request, $user_id);
		$resp1 = $resp->getData();
		$del_type = $request->type;
		if($resp1->msg != 'success' && $request->input('action') != 'payhandler')
		{
			return \Response::json(['message'=>$resp1->msg],422);
		}
		if($request->action == 'payhandler'){
			$data = $checkcon->orderPayHandler($request->order_id);
			$response['unavailableFoodIds'] = $unavailableFoodIds;
		} elseif ($request->action == 'paymodeUpdate') {
			$data = $checkcon->orderPaymentModeUpdate($request,$user_id);
		} else {
			$order_note=$request->order_note;
			$paymentType=$request->payment_type;
			$device=$request->device;
			$data = $checkcon->orderInsert($user_id,$aUser->phone_number,$order_note,$paymentType, $request->payment_id, $device,$del_type);
		}
		
		$response['message'] = 'Error';
		$response['message'] = $data['message'];
		if($data['status'] == 200){
			// $response['orderId'] = $data['orderId'];
			$response['aOrder'] = OrderDetail::find($data['orderId']);
			$response['aOrder']->append('do_pay','inaugural_offer');
		}else
		{
			$data['status'] = 422;
		}
		return \Response::json($response,$data['status']);
	}*/

	public function insertOrder(Request $request)
   {
      $rules['address_id']       = 'required';
      $rules['payment_type']      = 'required';
      $rules['total_price']      = 'required';
      $rules['del_charge']      = 'required';
      $rules['sub_total_price']      = 'required';
      $rules['discount_amount']      = 'required';
      $rules['device']      = 'required';
      if($request->payment_type == 'razorpay'){
      	$rules['payment_id'] = 'required';
      }
      // $message = 'failure';
      $this->validateDatas($request->all(),$rules);
      $user = \Auth::user();
      $paymentType = $request->payment_type;
      $grandTotal = $request->total_price;
      $delCharge = $request->del_charge;
      $sub_total_price = $request->sub_total_price;
      $razorpay_payment_id = $request->payment_id;
      if($request->wallet_amount > 0 && $request->wallet_amount != null){
      	$wallet_amount = $request->wallet_amount;
   	}
      $status = 200;
      $uCart = Usercart::where('user_id', $user->id)->get();
      if($uCart->isNotEmpty()){
         $res = Restaurant::where('id', $uCart[0]->res_id)->first();
         $addr = Useraddress::where('id', $request->address_id)->first();
         $userLat = $addr->lat;
         $userLng = $addr->lang;
         $restaurantLat = $res->latitude;
          $restaurantLng = $res->longitude;
         $distance = \AbserveHelpers::calculateDistance($userLat, $userLng, $restaurantLat, $restaurantLng);

         $distance = round($distance, 2);
         $s_tax = 0;
         $s_gst = $uCart->sum(function ($gst) {
	    		return $gst->gst;
			});
			if($res->service_tax1 > 0){
				$s_tax = $sub_total_price * ($res->service_tax1 / 100);
			}
			$gst = $s_gst + $s_tax;
         $order = new OrderDetail();
         $order->cust_id            = $user->id;
         $order->res_id             = $res->id;
         $order->partner_id         = $res->partner_id;
         $order->mobile_num         = $user->phone_number;
         $order->total_price        = $sub_total_price;
         $order->del_km             = $distance;
         $order->comsn_percentage   = $res->commission;
         $order->del_charge         = $delCharge;
         $order->grand_total        = $grandTotal;
         $order->paid_amount        = 0;
         $order->address            = $addr->address;
         $order->building           = $addr->building;
         $order->landmark           = $addr->landmark;
         $order->status             = 'pending';
         $order->time               = time();
         $order->date               = date('Y-m-d');
         $order->delivery           = 'unpaid';
         $order->delivery_type      = $paymentType;
         $order->lat                = $addr->lat;
         $order->lang               = $addr->lang;
         $order->ordertype          = 'delivery';
         $order->created_at         = date('Y-m-d H:i:s');
         $order->updated_at         = date('Y-m-d H:i:s');

         $order->orderid = '';
         $order->delivery_boy_charge_per_km = 0;
         $order->s_tax1 = 0;
         $order->s_tax2 = 0;
         $order->offer_price = $request->discount_amount;
         $order->coupon_price = $request->discount_amount;
         $order->coupon_id = $request->promo_id;
         $order->offer_percentage = 0;
         $order->device = $request->device;
         $order->delivery_preference = 'asap';
         $order->gst = $gst;
         $order->wallet_amount = $wallet_amount ?? 0;

         if($paymentType == 'razorpay') {
				$api_key	= RAZORPAY_API_KEYID;
				$api_secret	= RAZORPAY_API_KEY_SECRET;
				$api	= new Api($api_key, $api_secret);
				if($razorpay_payment_id != ''){
					$razor	= $api->payment->fetch($razorpay_payment_id);
					$transaction_status	= $razor->status;
					$paid_amount		= $razor->amount;
					$razor_capture = $api->payment->fetch($razorpay_payment_id)->capture(array('amount'=>$paid_amount,'currency' => 'INR'));
					if($razor_capture->status == 'captured' || $razor_capture->status == 'success'){
						$order->delivery	= 'paid';
						$order->paid_amount	= $order->grand_total;
					}else {
						$response['message'] = 'Your Payment Faild';
						$response['status'] = 422;
						return \Response::json($response,422);
					}
					$order->orderid			= $razor->order_id;
					$order->payment_token	= $razorpay_payment_id;
					$transaction_id			= $razorpay_payment_id;
					$transaction_orderid	= $order->orderid;
				}
			} /*elseif ($paymentType == 'wallet') {
			if($grandTotal >= $user->customer_wallet){
				$response['message'] = 'Insufficient Balance';
				$status = 422;
				return \Response::json($response,$status);
			}
			$balance = User::find($user->id);
			$exist_wallet = $balance->customer_wallet;
			$balance->customer_wallet = $exist_wallet - $order->grand_total;
			$balance->save();
			$currentDateTime = now();
			$timeFormatted = $currentDateTime->format('h:i:s');

			$order->delivery	= 'paid';
			$order->paid_amount	= $order->grand_total;
			$order->save();

		}*/
			if(isset($wallet_amount) && ($wallet_amount > 0)){
				$wallet = new Wallet;
				$wallet->user_id = $user->id;
				$wallet->order_id = $order->id;
				$wallet->amount  = $order->grand_total;
				$wallet->title   = 'Place Order';
				$wallet->type    = 'debit';
				$wallet->balance = $user->customer_wallet;
				$wallet->date    = date('Y-m-d');
				$wallet->time    = $timeFormatted;
				$wallet->save();
			}


         $order->save();
         $transaction_status = $transaction_id = $transaction_orderid = ''; $paid_amount = 0;

            /*$payment = new OrderPayment;
            $payment->order_id      = $order->id;
            $payment->pay_via       = $paymentType;
            $payment->amount     = $grandTotal;
            $payment->paid_amount   = $paid_amount;
            $payment->payment_staus = $order->delivery;
            $payment->transaction_status  = $transaction_status;
            $payment->transaction_id      = $transaction_id;
            $payment->transaction_orderid    = $transaction_orderid;
            $payment->type                = 'credit';
            $payment->created_at          = date('Y-m-d H:i:s');
            $payment->updated_at          = date('Y-m-d H:i:s');
            $payment->save();*/

         $order_value = $order_details = '';
         $hostAmount = 0;
         $oHikingPrice = 0;
         $itemPrice = $itemOriginalPrice = $gst = 0;$aFoodIds = [];
         foreach ($uCart as $key => $value) {
            $aFoodItem = Fooditems::where('id',$value->food_id)->where('restaurant_id',$res->id)->where('del_status','0')->where('approveStatus','Approved')->first();
            // $original   = ($aFoodItem->price / (100 + $aFoodItem->gst))*100;
            $original   = $aFoodItem->selling_price;
            $item['orderid']            = $order->id;
            $item['food_id']         = $aFoodItem->id;
            $item['food_item']          = $aFoodItem->food_item;
            $item['adon_type']          = $value->adon_type;
            $item['adon_id']         = $value->adon_id;
            $item['adon_detail']     = $value->adon_details;
            $item['quantity']        = $value->quantity;
            $item['price']           = $value->food_price->price;
            $item['item_note']          = $value->item_note;
            $item['selling_price']      = $aFoodItem->selling_price;
            $item['hiking']             = $value->food_price->hiking;
            $item['hiking_price']       = ($original * ($aFoodItem->hiking / 100));
            $item['base_price_value']  = abs($original - $value->food_price->price);
            $item['admin_cmsn_amt']    = ($original * ($res->commission / 100));
            $item['base_price']        = $original;
            $item['gst']            = $aFoodItem->gst;
            $item['hiking_gst_price']  = ($item['hiking_price'] * ($aFoodItem->gst / 100));
            $item['base_price_gst']    = ($original * ($aFoodItem->gst / 100));
            $vendorAmount  = ($item['base_price']  - $item['admin_cmsn_amt']);
            $item['vendor_price']       = $vendorAmount;
            // $item['vendor_gstamount']  = ($vendorAmount * ($aFoodItem->gst / 100));
            $item['vendor_gstamount']  = $value->gst;
            \DB::table('abserve_order_items')->insert($item);


            $hostAmount    += (($vendorAmount + $item['vendor_gstamount']) * $value->quantity);
            if($order_value != ''){
               $order_value .= ' + ';
            }
            $amount = number_format(($value->quantity * $value->food_price->price),2,'.','');
            $order_value .= $amount;
            if($order_details != ''){
               $order_details .= ', ';
            }
            // $newDetail = $adon_detail != '' && $adon_detail != '-' ? ' - '.$adon_detail : '';
            $newDetail = '';
            $order_details .= $value->quantity.' X '.$aFoodItem->food_item.$newDetail;
            /*$itemPrice  += (isset($value->food_price->price) ? $value->food_price->price : 0 ) * ($value->quantity);*/
            $itemPrice  += (isset($value->food_price->selling_price) ? $value->food_price->selling_price : 0 ) * ($value->quantity);
            $itemOriginalPrice += (isset($value->food_price->selling_price) ? $value->food_price->selling_price : 0 )  * ($value->quantity);
            $gst  += $value->gst;
            $aFoodIds[] = isset($aFoodItem->id);
            $oHikingPrice  += ($item['hiking_price'] * $value->quantity);
            $data['fixedCommission']= ($itemPrice * ($res->commission / 100));
            $data['HikingPrice'] = $oHikingPrice;
            $a_commission = number_format(($data['fixedCommission']/* + ( $data['HikingPrice'] )*/),0,'.','');
         }
         $order->admin_camount   = $a_commission;
         $order->fixedcommission   = $data['fixedCommission'];
         $order->host_amount     = $hostAmount;
         $order->order_value     = $order_value;
         $order->order_details   = $order_details;
         $order->save();

         $orderstat = new Orderstatustime;
			$orderstat->order_id	= $order->id;
			$orderstat->status		= '0';
			$orderstat->device 		= $request->device;
			$orderstat->created_at	= date('Y-m-d H:i:s');
			$orderstat->updated_at	= date('Y-m-d H:i:s');
			$orderstat->save();
			
         $uCart = Usercart::where('user_id', $user->id)->delete();
         $uOrder = OrderDetail::where('id', $order->id)->first();

         if(SOCKET_ACTION == 'true'){
				require_once SOCKET_PATH;
				// $client->emit('new order placed', $res->partner_id);
				$client->emit('placed the order', $res->partner_id);
				\DB::table('tbl_http_logger')->insert(['request' => 'placed the order', 'header' => $res->partner_id]);
			}

         $checkcon = new checkcon;
         $checkcon->sleep($uOrder->id);
         $response['message'] = 'Order Placed Successfully';
         $response['u_Order'] = $uOrder;
      }else{
         $response['message'] = 'Your cart is empty';
      }
      return \Response::json($response,$status);
    }

	function orderDetail(Request $request)
	{
		$rules['user_type'] = 'required|in:user,delivery';
		$rule['order_id'] = 'required';

		$this->validateDatas($request->all(),$rules);

		$aUser = \Auth::user();

		$iOrderId = $request->order_id;

		$data = $this->getOrderDetail($iOrderId,$aUser->id);
		// if(RAPIDO_ACTION)
		// {
		// 	$response['rapidoAPI'] = [ "url" =>  RAPIDO_LIVE_PATH , "key" => RAPIDO_LIVE_KEY , "live" => true];
		// }else{
		// 	$response['rapidoAPI'] = [ "url" =>  RAPIDO_TEST_PATH , "key" => RAPIDO_TEST_KEY , "live" => false];
		// }
		
		if($data['status'] == 200){
			$response['aOrder'] = $data['aOrder'];
			$response['helpline_number'] = CNF_HELPLINE;
		} else {
			$response['message'] = $data['message'];
		}
		// $aOrder = OrderDetail::with(['order_items' => function($query) {
		// 			    $query->select(['food_id','food_item','quantity','item_note']);
		// 			}])->find($iOrderId,$select);
		return \Response::json($response,$data['status']);
	}

	function getOrderDetail($iOrderId,$user_id)
	{
		$select = ['id','res_id','cust_id','partner_id','boy_id','created_at','status','order_details','grand_total','address','total_price','del_charge','del_charge_tax_price','s_tax1 as tax','coupon_price','offer_price','accept_grand_total','orderid','lat','lang','delivery_preference','later_deliver_date','later_deliver_time','order_note','host_amount as partner_earn','admin_camount as admin_earn','is_rapido','rapido_orderid','paid_amount','delivery_type','wallet_amount','cash_offer','gst','hiking','enc_order_id','accept_host_amount','bad_weather_charge','festival_mode_charge','add_del_charge'];
		$aOrder = OrderDetail::with(['order_items','accepted_order_items','grozooffer'])->find($iOrderId,$select);
		if($aOrder != ''){
			if (count($aOrder->accepted_order_items) > 0) {
				$aOrder->accept_total_price = $aOrder->accepted_order_items->sum(function($item) {
					return $item->mrp;
				});
			}
			$aOrder->accept_grand_total	= ($aOrder->accept_grand_total > 0) ? number_format($aOrder->accept_grand_total,2,'.','') : $aOrder->grand_total;

			$aOrder->grozoOffer		= "0";
			$aOrder->grozoOfferName	= "";
			if ($aOrder->grozooffer != null) {
				$aOrder->grozoOffer		= ($aOrder->grozooffer->offer_price > 0) ? number_format(($aOrder->grozooffer->offer_price),2,'.','') : "0";
				$aOrder->grozoOfferName	= ($aOrder->grozooffer->offer_name != '') ? $aOrder->grozooffer->offer_name : "";
			}
			$aOrder->grand_total		= number_format(($aOrder->grand_total - $aOrder->cash_offer),2,'.','');
			$aOrder->accept_grand_total = number_format(($aOrder->accept_grand_total - $aOrder->cash_offer),2,'.','');
			$aOrder->grozoOffer = (float) $aOrder->grozoOffer;

			$aOrder->accept_total_price	= ($aOrder->accept_total_price > 0) ? number_format($aOrder->accept_total_price,2,'.','') : $aOrder->total_price;
			$aOrder->accept_host_amount	= ($aOrder->accept_host_amount > 0) ? number_format($aOrder->accept_host_amount,2,'.','') : $aOrder->host_amount;
			$aOrder->admin_earn			= ($aOrder->accept_total_price > 0) ? number_format(($aOrder->accept_total_price - $aOrder->accept_host_amount),2,'.','') : number_format(($aOrder->total_price - $aOrder->host_amount),2,'.','');
		}
		if(empty($aOrder)){
			$data['status'] = 422;
			$data['message'] = 'No such Order';
		} else {
			$field = '';
			if($user_id == $aOrder->cust_id){
				$field = 'cust_id';
			} else if($user_id == $aOrder->partner_id){
				$field = 'partner_id';
			} else if($user_id == $aOrder->boy_id){
				$field = 'boy_id';
			}
			if($field == ''){
				$data['status'] = 422;
				$data['message'] = 'You do not have access';
			} else {
				if($field == 'boy_id'){
					$aOrder->travelDetail = \AbserveHelpers::getBoyTravelledReport($aOrder->id);
				}
				$aOrder->append('restaurant_detail','discount_price','order_time','order_recieve_text','driver_status_text','boy_detail','customer_detail','status_text','rating_info','do_pay','api_status_text','order_repay_info');
				if($field != 'partner_id') {
					$distance = \AbserveHelpers::calculateDistance($aOrder->lat, $aOrder->lang, $aOrder->restaurant_detail->latitude, $aOrder->restaurant_detail->longitude);
				    $averageSpeedKmph = 40;
        			$travelTime = $distance / $averageSpeedKmph;
        			$travelTimeInMinutes = $travelTime * 60;
        			$travelTime = $travelTimeInMinutes ?? 0;
        			$aOrder->distance = $distance;
        			$aOrder->travel_time = $travelTime;
        			foreach ($aOrder->accepted_order_items as &$item) {
                        $formattedAmount = $item['quantity'].' x '.floatval($item['selling_price']);
                        $f_total_price = $item['quantity'] * floatval($item['selling_price']);
                        $item['formatted_amount'] = $formattedAmount;
                        $item['total_price'] = $f_total_price;
                    }
					$aOrder->append('inaugural_offer');
				}
				unset($aOrder->grozooffer);
				$data['status'] = 200;
				$data['aOrder'] = $aOrder;
				if (count($aOrder->accepted_order_items) > 0)
					$aOrder->accepted_order_items = $aOrder->order_items;
			}
		}
		return $data;
	}

	function orders(Request $request)
	{
		$rules['user_type'] = 'required|in:user,delivery';
		$this->validateDatas($request->all(),$rules);
		$aUser	= \Auth::user();
		$not_partner = true;
		if($request->user_type == 'delivery'){
			$field = 'boy_id';
		} else {
			if($aUser->p_active == '1' && $request->group_id == '3'){
				$field = 'partner_id';	
			}  else if ((isset($request->appcall) && $request->appcall == 'orderview') && $request->user_type == 'Admin') {
				if ($aUser->group_id == 1 || $aUser->group_id == 2) {
					$field = 'Admin';
					$UserUpdatetatus = ['1','2','3','4','5','Packing','boyPicked','boyArrived'];
				}
			}else {
				$field = 'cust_id';
			}
		}
		$select = ['abserve_order_details.id','abserve_order_details.accept_host_amount','abserve_order_details.accept_grand_total','abserve_order_details.order_type','cust_id','boy_id','res_id','abserve_order_details.created_at','status','abserve_order_details.customer_status','order_details','total_price','grand_total','paid_amount','abserve_order_details.host_amount','delivery_type','delivery','del_charge','del_charge_tax_price','s_tax1 as tax','abserve_order_details.address','abserve_order_details.lat','abserve_order_details.lang','tb_users.username','tb_users.phone_number','abserve_order_details.order_note','abserve_order_details.boy_called','abserve_order_details.later_deliver_date','abserve_order_details.later_deliver_time','abserve_order_details.delivery_preference','abserve_order_details.bad_weather_charge','abserve_order_details.add_del_charge','abserve_order_details.festival_mode_charge','abserve_order_details.cancelled_by','abserve_order_details.refund_order','abserve_order_details.refund_status','abserve_order_details.wallet_amount','abserve_order_details.cash_offer','orderid'];
		if($aUser->group_id == '5')
		{
		$select = ['abserve_order_details.id','abserve_order_details.accept_host_amount','abserve_order_details.accept_grand_total','abserve_order_details.order_type','cust_id','boy_id','res_id','abserve_order_details.created_at','status','abserve_order_details.customer_status','order_details','total_price','grand_total','paid_amount','abserve_order_details.host_amount','delivery_type','delivery','del_charge','del_charge_tax_price','s_tax1 as tax','abserve_order_details.address','abserve_order_details.lat','abserve_order_details.lang','tb_users.username','tb_users.phone_number','abserve_order_details.order_note','abserve_order_details.boy_called','abserve_order_details.later_deliver_date','abserve_order_details.later_deliver_time','abserve_order_details.delivery_preference','abserve_order_details.bad_weather_charge','abserve_order_details.add_del_charge','abserve_order_details.festival_mode_charge','abserve_order_details.cancelled_by','abserve_order_details.refund_order','abserve_order_details.refund_status','abserve_order_details.wallet_amount','abserve_order_details.cash_offer','abserve_order_details.created_at','orderid'];
		}
		$orderQuery = OrderDetail::select($select)->whereRaw("((SELECT COUNT(id) FROM abserve_order_items WHERE abserve_order_items.orderid = abserve_order_details.id) > 0 OR abserve_order_details.order_type = 'Refund' OR abserve_order_details.order_type = 'Replace')")->leftjoin('tb_users','abserve_order_details.cust_id','=','tb_users.id');
		if($field != 'cust_id'){
			$orderQuery->whereRaw(" (`delivery_type` = 'cashondelivery' OR `delivery` = 'paid' ) ");
		}

		if(isset($request->refundalone) && $request->refundalone == 1){
			$orderQuery->where('refund_status',1);
		}
		$status = '';
		if($request->input('status') !== null && $request->status != ''){
			$status = $request->status;
		}

		
		if($status != '')	{
			if($status == 'neworders'){
				$orderQuery->whereIn('status',['0','1','2','6'])->where('order_type','Initial');
			}/*elseif($status == 'partnerAccepted'){
				$orderQuery->whereIn('status',['1','2','6'])->where('order_type','Initial');
			}*/elseif($status == 'partnerCompleted'){
				$orderQuery->whereIn('status',['4'])->where('order_type','Initial');
			}elseif($status == 'partnerCancelled'){
				$orderQuery->whereIn('status',['5'])/*->where('res_id', )*/;
			} elseif ($status == 'boyneworders') {
				$orderQuery->whereIn('status',['1','6']);
				$orderQuery->whereRaw('(SELECT COUNT(id) FROM `delivery_boy_new_orders` WHERE `delivery_boy_new_orders`.`order_id` = `abserve_order_details`.`id` AND `delivery_boy_new_orders`.`boy_id` = '.$aUser->id.' AND `delivery_boy_new_orders`.`status` = "Pending" ) = 1');
			} elseif ($status == 'boyorders') {
			   $orderQuery->WhereIn('status', ['2','3','boyPicked','boyArrived','Reached']);
				$orderQuery->orwhereIn('status',['1','6']);
				$orderQuery->whereRaw('(SELECT COUNT(id) FROM `delivery_boy_new_orders` WHERE `delivery_boy_new_orders`.`order_id` = `abserve_order_details`.`id` AND `delivery_boy_new_orders`.`boy_id` = '.$aUser->id.' AND `delivery_boy_new_orders`.`status` = "Pending" ) = 1');
			} elseif ($status == 'boyAccepted') {
				$orderQuery->whereIn('status',['2','3','boyPicked','boyArrived','Reached','otpSend','otpVerify']);
			} /*elseif ($status == 'Cancelled' && $isAdmin == 'true') {
				$orderQuery->whereIn('status',['5']);
			}*/ elseif ($status == 'Cancelled') {
				$orderQuery->whereIn('status',['5']);
			} elseif ($status == 'Completed') {
				$orderQuery->whereIn('status',['4']);
			} elseif ($status == 'Active') {
				$orderQuery->whereIn('status',['0','1','2','3','boyPicked','boyArrived','Reached','otpSend','otpVerify','6']);
			} elseif ($status == 'adminOrders') {
				$orderQuery->whereIn('status',['1','2','3','boyPicked','boyArrived','Reached','6']);
			} elseif ($status == 'boyHistory') {
				$orderQuery->whereIn('status',['4', '5']);
			}
		} 
		if($status == 'boyallorders' && $request->website == '1'){
			$orderQuery->whereIn('status',['4','5']);
		}elseif($status == 'boyordersnew' && $request->website == '1'){
			$orderQuery->whereIn('status',['1','6']);
			$orderQuery->whereRaw('EXISTS (SELECT * FROM `delivery_boy_new_orders` WHERE `delivery_boy_new_orders`.`order_id` = `abserve_order_details`.`id` AND `delivery_boy_new_orders`.`status` = "Pending")');

		}elseif($status == 'boyAcceptedorders'){
			$orderQuery->whereIn('status',['2','3','boyPicked','boyArrived','Reached','otpSend','otpVerify']);
		}/*elseif(isset($request->search)){
			$id = explode(':', $request->search);
			$id = str_replace('|', '', $id[2]);
			$orderQuery->whereIn('status',['4','5']);
			$orderQuery->where('id', $id);
		}*/
		/*if($status != 'boyneworders' && $status != 'boyAccepted' && ($aUser->group_id == 8 || $aUser->group_id == '3')){
			$orderQuery->where($field,$aUser->id)->whereIn('status',['4','5','boyArrived','boyPicked']);
		}*/

		if($status != 'boyneworders' && $status != 'boyallorders' && $status != 'boyordersnew' && $status != 'boyAcceptedorders'){
			$orderQuery->where($field,$aUser->id);
		}	
		if($request->input('payment_status') !== null && $request->payment_status != '') {
			$orderQuery->where('delivery',$request->payment_status);
		}
		if($aUser->p_active != '1' && $request->group_id != '3'){ $not_partner = true; }else { $not_partner = false; }
		if($aUser->d_active != '1' && $request->group_id != '5'){  $not_boy = true; }else {  $not_boy = false; }
		// print_r($not_partner);
		$requestgroup_id = $request->group_id;
		$aOrder = $orderQuery->with(['order_items','accepted_order_items','getRefundDetails','getBoyRefundDetails','grozooffer'])->orderBy('id','desc')->paginate(10)->map(function ($result) use ($not_partner,$aUser,$requestgroup_id) {
			$result->accept_total_price	= $result->accepted_order_items->sum(function($item) {
				return $item->mrp;
			});
			$result->makeHidden('veg_nonveg');
			$result->accept_total_price	= ($result->accept_total_price > 0) ? number_format($result->accept_total_price,2,'.','') : number_format($result->total_price,2,'.','');
			$result->accept_grand_total	= ($result->accept_grand_total > 0) ? number_format($result->accept_grand_total,2,'.','') : number_format($result->grand_total,2,'.','');
			$result->accept_grand_total	= number_format($result->accept_grand_total - $result->cash_offer,2,'.','');
			$result->grand_total		= number_format($result->grand_total -$result->cash_offer,2,'.','');
			$result->append('restaurant_info','status_text','created_date_time','ongoing_status','do_pay','api_status_text','refund_status_boolean','boy_detail','boy_rating_info','rating_info',/*'order_repay_info',*/'invoice_html');
			// if($not_partner === true) {
				$result->append('food_available_count');
			// }
				if(\Auth::user()->group_id == '4' || \Auth::user()->group_id == 4){
					$result->append('socket_status_text');
				}
			if ($aUser->p_active != '1' && $requestgroup_id != '3') {
				$result->grozoOffer		= (float) "0";
				$result->grozoOfferName	= "";
				if ($result->grozooffer != null) {
					$result->grozoOffer		= ($result->grozooffer->offer_price > 0) ? (float) number_format(($result->grozooffer->offer_price),2,'.','') : (float) "0";
					$result->grozoOfferName	= ($result->grozooffer->offer_name != '') ? $result->grozooffer->offer_name : '';
				}
				// unset($result->grozooffer);
				$result->append('inaugural_offer');
			}

			if (!is_null($result->getRefundDetails) || $result->getRefundDetails != '') {
				$result->getRefundDetails->map(function($refundResult){
					$refundResult->boy_comment = is_null($refundResult->boy_comment) ? '' : $refundResult->boy_comment;
					$refundResult->admin_comment = is_null($refundResult->admin_comment) ? '' : json_decode($refundResult->admin_comment);
					$refundResult->boy_image = (is_null($refundResult->boy_image) || $refundResult->boy_image == 'null') ? '' : $refundResult->boy_image;
					return $refundResult;

				});
			}

			if (!is_null($result->getBoyRefundDetails) || $result->getBoyRefundDetails != '') {
				$result->getBoyRefundDetails->map(function($refundResult){
					$refundResult->boy_comment = is_null($refundResult->boy_comment) ? '' : $refundResult->boy_comment;
					$refundResult->admin_comment = is_null($refundResult->admin_comment) ? '' : json_decode($refundResult->admin_comment);
					$refundResult->boy_image = (is_null($refundResult->boy_image) || $refundResult->boy_image == 'null') ? '' : $refundResult->boy_image;
					return $refundResult;

				});
			}
			return $result;
		});

		if($aOrder && $aUser->group_id == '5'){
         $aOrder = $aOrder->map(function($data){
             list($date, $time) = explode(' ', $data->created_at);
             $formattedTime = date('h:i A', strtotime($time));
             $data->date = $date;
             $data->time = $formattedTime;
             return $data;
         });
      }

      if($aOrder && $aUser->group_id == '3'){
        $aOrder = $aOrder->map(function($data){
            if($data->boy_id == null){
                $data->boy_id = 0;
            }
            return $data;
        });
      }

		$response['aOrder'] = $aOrder;
		if($not_boy == false) {
			$boy_status_boolean = Deliveryboy::find($aUser->id,['id','online_sts'])->online_sts;
			$response['boy_status_boolean'] = $boy_status_boolean == '1' ? 'online' : 'offline';
		} 
		$response['helpline_number'] = CNF_HELPLINE;
		if($request->website == '1'){
			return json_encode($response);
		}
		return \Response::json($response,200);
	}

	// function orders(Request $request)
	// {
	// 	$rules['status'] = 'required';
	// 	$this->validateDatas($request->all(),$rules);
	// 	$aUser =\Auth::user();
	// 	// dd($aUser);
	// 	if($aUser->group_id == 4){
	// 		$field = 'cust_id';
	// 	}elseif($aUser->group_id == 3){
	// 		$field = 'partner_id';
	// 	}
	// 	$uOrder = OrderDetail::select('id', 'cust_id', 'res_id', 'partner_id', 'mobile_num', 'del_km', 'grand_total', 'status', 'customer_status', 'delivery_type', 'order_details')->where($field, $aUser->id)->orderBy('id', 'desc');
	// 	if($request->status == 'Active'){
	// 		$uOrder->whereIn('status', ['0','1','2','3']);
	// 	}elseif($request->status == 'Completed'){
	// 		$uOrder->whereIn('status', ['4']);
	// 	}elseif($request->status == 'Cancelled'){
	// 		$uOrder->whereIn('status', ['5']);
	// 	}
	// 	$perPage = 10;
	// 	$uOrder = $uOrder/*->with('order_items')*/->paginate($perPage);
	// 	$uOrder->getCollection()->transform(function ($order) {
	// 	    $order->append('restaurant_info');
	// 	    $order->total_quantity = DB::table('abserve_order_items')
	// 	        ->where('orderid', $order->id)
	// 	        ->sum('quantity');
	// 	    return $order;
	// 	});
	// 	// $uOrder = $uOrder->with('order_items')->paginate(10)->get()->append('restaurant_info');
	// 	$response['aOrder'] = $uOrder;
	// 	$response['pagination'] = [
	// 	    'total' => $uOrder->total(),
	// 	    'per_page' => $uOrder->perPage(),
	// 	    'current_page' => $uOrder->currentPage(),
	// 	    'last_page' => $uOrder->lastPage(),
	// 	];
	// 	return \Response::json($response,200);
	// }

	function currentOrderDetail(Request $request)
	{
		$rules['user_type'] = 'required|in:user,delivery';
		$this->validateDatas($request->all(),$rules);
		$aUser =\Auth::user();
		if($request->user_type == 'delivery'){
			$field = 'boy_id';
		} else {
			if($aUser->group_id == '3'){
				$field = 'partner_id';	
			} else {
				$field = 'cust_id';
			}
		}

		$fieldVal = $aUser->id;
		$response['aTrackOrder'] = \AbserveHelpers::getTrackOrder($field,$fieldVal);
		if($field == 'cust_id')
			$response['aPayOrder'] = \AbserveHelpers::getPayOrder($field,$fieldVal);

		return \Response::json($response,200);
	}

	function orderStatusChangeRapido(Request $request)
	{
		$rules['order_id'] = 'required';
		$rules['status'] = 'required|in:2,4,6,boyreject';
		/* Status Meaning
			2 - Boy accepted
			4 - Order Delivered / Completed
			6 - Partner Accepted & No boy found
		*/
		$this->validateDatas($request->all(),$rules);

		$boy_id				= $request->boy_id;
		$UserUpdatetatus	= [];
		$field		= '';

		$field	= 'boy_id';
		$UserUpdatetatus = ['2','4','boyreject'];

		$fieldVal = $boy_id;

		$validStatus = ['0','1','2','3','5','pending','6'];
		$aOrderQuery = OrderDetail::where('id',$request->order_id)->whereRaw("(SELECT COUNT(id) FROM abserve_order_items WHERE abserve_order_items.orderid = abserve_order_details.id) > 0")->whereRaw(" ( (`delivery_type` = 'cashondelivery' && `delivery` = 'unpaid') OR (`delivery_type` != 'cashondelivery' && `delivery` = 'paid') ) ");
		if($field == 'boy_id' && ($request->status == '2' || $request->status == 'boyreject')){
			$aOrderQuery->whereRaw('(SELECT COUNT(id) FROM `delivery_boy_new_orders` WHERE `delivery_boy_new_orders`.`order_id` = `abserve_order_details`.`id` AND `delivery_boy_new_orders`.`boy_id` = '.$boy_id.' AND ( `delivery_boy_new_orders`.`status` = "Pending" OR `delivery_boy_new_orders`.`status` = "Accepted" ) ) = 1');
		} else {
			$aOrderQuery->where($field,$fieldVal);
		}
		$aOrder = $aOrderQuery/*->whereIn('status',$validStatus)*/->first();
		if($field == '' || empty($aOrder)){
			$response['message'] = 'You do not have access';
			return \Response::json($response,422);
		} elseif(!in_array($request->status, $UserUpdatetatus) || !in_array($aOrder->status, $validStatus) ){
			$status_text = $aOrder->status == '6' ? ' Accepted. Searching for boy' : $aOrder->status_text;
			return \Response::json(['message' => 'Order Already '.$status_text],422);
		}
		$status = $request->status;
		$orderStatus = $aOrder->status;

		$update = false;
		$order = OrderDetail::find($aOrder->id);
		$orderPartner = OrderDetails::where('orderid',$aOrder->id)->first();
		$responseMsg = '';
		if($status == '2'){
			if($orderStatus == '1' || $orderStatus == '6'){
				$update = true;
				$order->boy_id	= $boy_id;
				$order->status	= '2';
				// $order->accepted_time = time();
				$order->save();

				$orderPartner->order_status = '2';
				// $orderPartner->order_accepted_time = time();
				$orderPartner->save();

				$boyOrder['boy_id']		= $boy_id;
				$boyOrder['orderid']	= $aOrder->id;
				$boyOrder['partner_id']	= $aOrder->partner_id;
				$boyOrder['order_value']	= $aOrder->order_value;
				$boyOrder['order_details']	= $aOrder->order_details;
				$boyOrder['order_status']	= '1';
				$boyOrder['current_order']	= '1';
				$boyOrderId	= \DB::table('abserve_orders_boy')->insertGetId($boyOrder);

				$time = date('Y-m-d H:i:s');
              	\DB::table('delivery_boy_new_orders')->where('boy_id',$boy_id)->where('order_id',$aOrder->id)->update(['status'=>'Accepted','update_at'=>$time]);

              	$message    = "The order (#".$aOrder->id.") was accepted by a delivery boy";
              	$this->sendpushnotification($aOrder->partner_id,'user',$message);

              	$message    = "Your order on the shop ".$aOrder->restaurant_info->name." was accepted by the Delivery Boy";
              	$this->sendpushnotification($aOrder->cust_id,'user',$message);

              	//notify customer and partner through socket
              	if(SOCKET_ACTION == 'true'){
	                require_once SOCKET_PATH;
	                $aData = array(
	                  	'partner_id' => $aOrder->partner_id,
	                  	'customer_id' => $aOrder->cust_id,
	                  	'order_id' => $aOrder->id,
	                  	//'Molorder_id' => $order_exists->orderid,
	                  	'boy_id' => $boy_id,
	                	// 'amount' => $order_datas->order_value,
	                  	'amount' => $aOrder->grand_total,
	                  	'is_rapido' => $aOrder->is_rapido,
	                  	'rapido_orderid' => $aOrder->rapido_orderid,
	                  	'partner_name' => $aOrder->partner_info->username
	                );
	                $client->emit('boy accepted', $aData);
	            }
	            $message = "Order Accepted By Delivery Boy";
	            $response['restaurant_detail'] = Restaurant::where('id', $aOrder->res_id)->select('location', 'latitude', 'longitude')->first();
			} elseif ($orderStatus == '0') {
				$responseMsg = 'Shop owner should accpet this order to proceed';
			}
		} elseif($status == '4'){
			if($orderStatus == '3'){
				$boy_up = \DB::table('abserve_orders_boy')->where('orderid','=',$aOrder->id)->where('boy_id','=',$boy_id)->update(['order_status'=>'4','order_done_status'=>'1']);

				$update = true;
				$order->status = '4';
				$order->completed_time = time();
				$order->delivery = 'paid';
				$order->save();

				$orderPartner->order_status = '4';
				// $orderPartner->order_accepted_time = time();
				$orderPartner->save();

				\DB::table('abserve_deliveryboys')->where('id','=',$boy_id)->update(['boy_status'=>'0']);

				$message    = "Order delivered Successfully.Thank you for being an amazing customer";
				$this->sendpushnotification($aOrder->cust_id,'user',$message);

				$message    = "Delivery boy delivered the order (Order ID:".$aOrder->id.") to the customer";
				$this->sendpushnotification($aOrder->partner_id,'user',$message);

				//notify user through socket

                if(SOCKET_ACTION == 'true'){
                  	require_once SOCKET_PATH;
                  	$aData = array(
                    	'customer_id' => $aOrder->cust_id,
                    	'order_id' => $aOrder->id,
                    	'partner_id' => $aOrder->partner_id,
                    	'boy_id' => $aOrder->boy_id,
                  	);
                  	$client->emit('delivered to customer', $aData);
                }

            	// delivery boy share start 
                $boy_bal['boy_id'] = $aOrder->boy_id; 
                $boy_bal['order_id'] = $aOrder->id; 
                $boy_bal['delivery_distance'] = $aOrder->del_charge; 
                $boy_bal['delivery_charge'] = ($aOrder->min_night+$aOrder->del_charge);     
                if(\DB::table('abserve_boy_balance')->where('order_id',$aOrder->id)->exists()){
                	\DB::table('abserve_boy_balance')->where('order_id',$aOrder->id)->update($boy_bal);
                } else {
                	\DB::table('abserve_boy_balance')->insert($boy_bal);
                }
            	// delivery boy share end 
            	$message = 'Order delivered  Successfully';
			}
		} elseif($status == 'boyreject') {
				$time = date('Y-m-d H:i:s');
	            \DB::table('delivery_boy_new_orders')->where('boy_id',$boy_id)->where('order_id',$aOrder->id)->update(['status'=>'Rejected','update_at'=>$time]);
	            \DB::table('abserve_deliveryboys')->where('id','=',$boy_id)->update(['boy_status'=>'0']);
	            $response1 = $this->sendRequestToBoy($request,$aOrder->id);
	            $update = true;
	            $message = 'Rejected Successfully';
		} elseif($status == '6') {
	            $response1 = $this->sendRequestToBoy($request,$aOrder->id);
	            $update = true;
	            $message = 'Rejected Successfully';
		}
		if(!$update) {
			$response_status = 422;
			if($responseMsg != ''){
				$message = $responseMsg;
			} else {
				if($status <= $orderStatus || $status == '5'){
					$status_text = $aOrder->status == '6' ? ' Accepted. Searching for boy' : $aOrder->status_text;
					$message = 'Order Already '.$status_text;
				} else {
					$message = 'Order needs to be '.$aOrder->getStatusDoAttribute($orderStatus);
				}
			}
		} else {
			$response_status = 200;
		}
		$response['message'] = $message;
		return \Response::json($response,$response_status);
	}

	/*Status Meaning
		check grozo.txt in docs folder
	*/
	function orderStatusChange(Request $request)
	{
		$response_status	= 422;
		$rules['user_type']	= 'required|in:user,delivery,Admin';
		$rules['order_id']	= 'required';
		$rules['status']	= 'required|in:1,2,3,4,5,boyreject,Packing,boyArrived,boyPicked';
		$rules['group_id']	= 'required';
		$aGroup_id=[1,2];
		$bOrder	= OrderDetail::select('order_type','delivery_type')->where('id',$request->order_id)->first();
		$paytype = '';
		if (!empty($bOrder)) {
			$paytype	= $bOrder->delivery_type;	
			$orderType	= $bOrder->order_type;	
		}
		if($request->status == '1') {
			$rules['selected_item'] = 'required';
		} elseif($request->status == '4') {
			// $paytype	= OrderDetail::find($request->order_id,['delivery_type']);
			if($paytype == "cashondelivery" && $orderType == 'Initial') {
				$rules['cod_amount'] = 'required|numeric';
			}
			if ($orderType == 'Replace') {
				$rules['refund_status'] = 'required|in:itemUnavailable,itemCollected,itemsDispatched';
				// if (isset($request->refund_status) && $request->refund_status == 'itemCollected') {
				// 	$rules['image'] = 'required';
				// 	$rules['image.*'] = 'mimes:jpeg,jpg,png|max:10240';
				// }
			}
		}
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {
			if (isset($request->appcall) && $request->appcall == 'orderedit') {
				$aUser	= User::find(\Auth::id(),['*']);
			} elseif((isset($request->is_from) && $request->is_from == 'boyneworderspage') && (isset($request->is_this) && $request->is_this == 'website')){
				$aUser = User::find($request->user_id);
			} else {
				$aUser = \Auth::user();
			}

			$UserUpdatetatus	= []; $field	= '';
			if($request->user_type == 'delivery'){
				$field = 'boy_id';
				$UserUpdatetatus = ['2','4','boyreject','boyPicked','boyArrived','itemUnavailable','boyCollectPartnerItem'];
			} else {
				if($aUser->p_active == '1' && $request->group_id == '3'){
					$field = 'partner_id';
					$UserUpdatetatus = ['1','3','5','Packing'];	
				} elseif($aUser->group_id == '1'){
					$field = 'partner_id';
					$aUser->id = $request->partner_id;
					$UserUpdatetatus = ['1','2','3','4','5','Packing','boyPicked','boyArrived'];	
				} else {
					$field = 'cust_id';
					$UserUpdatetatus = ['5'];
				}
			}
			$fieldVal = $aUser->id;
			$validStatus = ['0','1','2','3','5','pending','6','boyPicked','boyArrived','Reached','otpSend','otpVerify'];
			$aOrderQuery = OrderDetail::where('id',$request->order_id)->whereRaw("((SELECT COUNT(id) FROM abserve_order_items WHERE abserve_order_items.orderid = abserve_order_details.id) > 0 OR abserve_order_details.order_type = 'Refund' OR abserve_order_details.order_type = 'Replace')")->whereRaw(" ( (`delivery_type` = 'cashondelivery' && `delivery` = 'unpaid') OR (`delivery_type` != 'cashondelivery' && `delivery` = 'paid') ) ");
			if($field == 'boy_id' && ($request->status == '2' || $request->status == 'boyreject')) {
				$aOrderQuery->whereRaw('(SELECT COUNT(id) FROM `delivery_boy_new_orders` WHERE `delivery_boy_new_orders`.`order_id` = `abserve_order_details`.`id` AND `delivery_boy_new_orders`.`boy_id` = '.$aUser->id.' AND ( `delivery_boy_new_orders`.`status` = "Pending" OR `delivery_boy_new_orders`.`status` = "Accepted" ) ) = 1');
			} else {
				$aOrderQuery->where($field,$fieldVal);
			}
			$aOrder = $aOrderQuery/*->whereIn('status',$validStatus)*/->first();
			if($field == '' || empty($aOrder)){
				$response['id']			= '2';
				$response['status']		= 'failure';
				$response['message'] 	= 'You do not have access';
				if (isset($request->appcall) && $request->appcall == 'orderedit') {
					return json_encode($response);
				} else {
					return \Response::json($response,422);
				}
			}
			 elseif(!in_array($request->status, $UserUpdatetatus) || !in_array($aOrder->status, $validStatus) ){
				$status_text = $aOrder->status == '6' ? ' Accepted. Searching for boy' : $aOrder->status_text;
				$response['id']			= '2';
				$response['status']		= 'failure';
				$response['message']	= 'Order Already '.$status_text;
				if (isset($request->appcall) && $request->appcall == 'orderedit') {
					return json_encode($response);
				} else {
					return \Response::json($response,422);
				}
			}

			$status         = $request->status;
			$orderStatus    = $aOrder->status;
			$orderType      = $aOrder->order_type;
			$customerStatus = $aOrder->customer_status;
			$status_text    = $aOrder->status_text;
			$currentStatus  = '';/*After current process succeed*/

			$update			= false;
			$order			= OrderDetail::find($aOrder->id);
			$orderPartner	= OrderDetails::where('orderid',$aOrder->id)->first();
			$responseMsg	= '';
			if($status == '1') {
				if($orderStatus == '0') {
					$sel_item	= $request->selected_item; 
					if($sel_item != '') {
						/*if(is_array($sel_item)) {
							$sel_item = implode(',',$sel_item);
						}*/
						$sel_item	= array_unique(explode(',',$sel_item));
						if (empty($sel_item)) {
							$response['message']= "No item selected for delivery";
							$response['id']		= '2';
							$response["status"]	= 'failure';
							if (isset($request->appcall) && $request->appcall == 'orderedit') {
								return json_encode($response);
							} else {
								return \Response::json($response,$response_status);
							}
						}

						$orderItem	= OrderItems::where('orderid',$aOrder->id)->whereIn('id',$sel_item);
						$orderItemData	= clone ($orderItem);
						$orderItemData	= $orderItemData->get();
						if (count($orderItemData) == 0) {
							$response['id']			= '2';
							$response['status']		= 'error';
							$response['message']	= 'Selected product is not in the list';
							if (isset($request->appcall) && $request->appcall == 'orderedit') {
								return json_encode($response);
							} else {
								return \Response::json($response,422);
							}
						}
						$orderItem->update(['check_status'	=> 'yes']);

						$check_item = OrderItems::where('orderid',$aOrder->id)->where('check_status', 'no')->get();
						$r_amount = $check_item->sum(function($minus){
							return $minus->selling_price;
						});
						if($r_amount > 0){
							$w_update = User::find($aOrder->cust_id);
							$w_update->customer_wallet = $w_update->customer_wallet + $r_amount;
							$w_update->save();
						}


						$tot_price	= $tot_Hprice	= $totAprice = $totHiprice  = 0;
						foreach($sel_item as $Skey =>$sel) {
							$item	= OrderItems::find($sel,['quantity','price','base_price','base_price_gst','hiking_price','hiking_gst_price','admin_cmsn_amt','vendor_gstamount','vendor_price','gst','selling_price']);
							$tot_price	= $tot_price + ($item->quantity * $item->price);
							$totAprice	= $totAprice + ($item->quantity * ($item->selling_price/* + $item->base_price_gst + $item->hiking_price + $item->hiking_gst_price*/));
							$tot_Hprice	= $tot_Hprice + ($item->quantity * (($item->base_price - $item->admin_cmsn_amt) + $item->vendor_gstamount));
							// $totHiprice	= $totHiprice + ($item->quantity * ($item->hiking_price + $item->hiking_gst_price));
						}
						$tot_price	= number_format($tot_price,2,'.','');
						$totAprice	= number_format($totAprice,2,'.','');
						$tot_Hprice	= number_format($tot_Hprice,2,'.','');
						// $totHiprice	= number_format($totHiprice,2,'.','');
						$wallet1	= abs($order->total_price - $totAprice);
						$walletH	= abs($order->host_amount - $tot_Hprice);
						$acceptCouponAmt = \AbserveHelpers::getPromoAmount($aOrder->coupon_id,$totAprice);

						$grandTotal = ($totAprice + $aOrder->del_charge + $aOrder->gst/*$aOrder->del_charge_tax_price + $aOrder->add_del_charge + $aOrder->festival_mode_charge + $aOrder->bad_weather_charge*/) /*- $acceptCouponAmt - $aOrder->wallet_amount*/;

						
						$update = true;
						$order->accept_host_amount	= abs($order->host_amount - $walletH);
						$order->accept_coupon_price	= abs($acceptCouponAmt);
						$order->accept_grand_total	= abs($grandTotal);
						$order->status				= '1';
						$order->customer_status		= 'Cooking';
						$order->accepted_time		= time();
						$order->save();

						if ($paytype != "cashondelivery") {
							if ($wallet1 > 0) {
								
								\AbserveHelpers::Refund($order,'accept');
							}
						}


						$orderstat = new Orderstatustime;
						$orderstat->order_id = $aOrder->id;
						$orderstat->status = '1';
						$orderstat->created_at = date('Y-m-d H:i:s');
						$orderstat->updated_at = date('Y-m-d H:i:s');
						$orderstat->save();
						/*$orderPartner->order_status = '1';
						$orderPartner->order_accepted_time = time();
						$orderPartner->save();*/
						if ($order->total_price != $totAprice) {
							$user_offer	= User::find($order->cust_id,['id','offer_wallet']);
							$user_offer->offer_wallet	= $user_offer->offer_wallet + $order->cash_offer;
							$user_offer->save();
							$offerDet	= Offers::find(1);
							$offerRefund	= new OfferUsers;
							$offerRefund->order_id	= $order->id;
							$offerRefund->cust_id	= $order->cust_id;
							$offerRefund->type		= 'credit';
							$offerRefund->reason	= $offerDet->name. ' offer redeem refunded (Order value changed)';
							$offerRefund->offer_price= $order->cash_offer;
							$offerRefund->offer_name = $offerDet->name;
							$offerRefund->grand_total= $order->grand_total; 
							$offerRefund->save();

							$offerData	= \AbserveHelpers::Offerdata($order->cust_id,$totAprice);
							$order->cash_offer	= $offerData['cashOffer'];
							$order->save();
							// $oldReedeem	= 0;
							if ($offerData['cashOffer'] > 0) {
								// $offer_table= OfferUsers::where('order_id',$order->id)->first();
								// $oldReedeem	= $offer_table->offer_price;
								$offerTable	= new OfferUsers;
								$offerTable->order_id	= $order->id;
								$offerTable->cust_id	= $order->cust_id;
								$offerTable->type		= 'debit';
								$offerTable->reason		= $offerData['OfferName']. ' offer redeem updated (Order value changed)';
								$offerTable->offer_price= $offerData['cashOffer'];
								$offerTable->offer_name	= $offerData['OfferName'];
								$offerTable->grand_total= $order->accept_grand_total; 
								$offerTable->save();
							}
							$cash_back_value	= ($user_offer->offer_wallet /*+ $oldReedeem*/) - $offerData['cashOffer'];
							$user_offer->offer_wallet	= $cash_back_value;
							$user_offer->save();
						}

						///GENERATE PRINT IMAGE

						// $home = new HomeController;
						// $home->imageconvert($aOrder->id);
						//Send Notification to Partner 
						$oOrder = OrderDetail::with(['outof_stock_items'])->find($aOrder->id);
						$outOfStockItems = (count($oOrder->outof_stock_items) > 0) ? implode(', ', $oOrder->outof_stock_items->pluck('food_item')->toArray()) : '' ;
						if (count($oOrder->outof_stock_items) > 0) {
							$message	= "Dear Customer, in order no. ".$oOrder->id.", dt. ".date('Y-m-d',strtotime($oOrder->created_at)).", the following items are out of stock ".$outOfStockItems.".
							Balance items will be delivered shortly.
							Your revised payable amount is Rs ".$grandTotal.".";
						} else {
							$message	= "Dear Customer, Your order accepted by shop & moved to packing stage.";
						}
						/*if(TWO_FACTOR_OPTION == 'enable')
						{
							$sent = \SiteHelpers::sendSmsTrsc(TWO_FACTOR_API_KEY, $from, $to,$message);
							if ($sent === 0) {
								$error['message'] = 'OTP Not Sent! Try some other time.';
								$error['status']  = false;
								print_r(json_encode($error));die;
							} 
							if ($sent === 2) {
								$error['message'] = 'Please enter valid number';
								$error['status']  = false;
								print_r(json_encode($error));die;
							}
						}*/
						// $this->sendpushnotification($aOrder->cust_id,'user',$message);
						$cus = User::find($aOrder->cust_id);
						$title = 'Order Accepted';
						\AbserveHelpers::sendPushNotification($cus->mobile_token, $title, $message);
						if ($order->delivery_preference == 'asap') {
							\DB::table('abserve_order_details')->where('id',$aOrder->id)->update(['boy_called'=>2]);
							$boyassign		= $this->sendRequestToBoy($request,$aOrder->id);
							if ($boyassign > 0) {
								$message	= "Order accepted and assigned to delivery boy"; 
								$response['boyassigned'] = '1';
								$boyassignedid = \DB::table('delivery_boy_new_orders')->select('boy_id')->where('order_id',$request->order_id)->where('status','Pending')->/*first*/get();
								foreach($boyassignedid as $boyassigned_id){
									$abserve_deliveryboys=\DB::table('tb_users')->select('username','phone_number')->where('id',$boyassigned_id->boy_id)->first();
									if($abserve_deliveryboys != ''){
										$response['boy_detail']['username'] = $abserve_deliveryboys->username != '' ?(string) $abserve_deliveryboys->username :'';
										$response['boy_detail']['phone_number'] = $abserve_deliveryboys->phone_number != '' ? (string) $abserve_deliveryboys->phone_number :'';
									}
								}
							} else {
								$order->status	= /*$orderPartner->order_status =*/ '6';
								$message		= "Order accepted and waiting for delivery boy";
								$response['boyassigned'] = '0';
								$response['boy_detail']['username'] = $response['boy_detail']['phone_number'] = '';
							}
						} else {
							\DB::table('abserve_order_details')->where('id',$aOrder->id)->update(['boy_called'=>1]);
							$message = "Order accepted Successfully! Call The Delivery Boy During Delivery Time"; 
						}
						$order->save();
						/*$orderPartner->save();*/
					} else {
						$responseMsg	= "No item selected for delivery";
					}
				}
			} elseif ($status == '2') {
				if($orderStatus == '1' || $orderStatus == '6'){
					$update = true;
					$order->boy_id = $aUser->id;
					$order->status = '2';
					// $order->accepted_time = time();
					$order->save();

					if ($orderType == 'Initial') {
						/*$orderPartner->order_status = '2';*/
						// $orderPartner->order_accepted_time = time();
						/*$orderPartner->save();*/
					}
					$orderstat = new Orderstatustime;
					$orderstat->order_id = $aOrder->id;
					$orderstat->status = '2';
					$orderstat->created_at = date('Y-m-d H:i:s');
					$orderstat->updated_at = date('Y-m-d H:i:s');
					$orderstat->save();
					$boyOrder['boy_id']			= $aUser->id;
					$boyOrder['orderid']		= $aOrder->id;
					$boyOrder['partner_id']		= $aOrder->partner_id;
					$boyOrder['order_value']	= $aOrder->order_value;
					$boyOrder['order_details']	= $aOrder->order_details;
					$boyOrder['order_status']	= '1';
					$boyOrder['current_order']	= '1';

					$boyOrderId	= \DB::table('abserve_orders_boy')->insertGetId($boyOrder);
					$time		= date('Y-m-d H:i:s');
					\DB::table('delivery_boy_new_orders')->where('boy_id',$aUser->id)->where('order_id',$aOrder->id)->update(['status'=>'Accepted','update_at'=>$time]);
					\DB::table('tb_users')->where('id', $aUser->id)->update(['boy_status' => '1']);
					\DB::table('delivery_boy_new_orders')->where('boy_id', '!=', $aUser->id)->where('order_id',$aOrder->id)->where('status', 'Pending')->delete();
					$message    = "The order (#".$aOrder->id.") was accepted by a delivery boy";
					$this->sendpushnotification($aOrder->partner_id,'user',$message);
					$message    = "Your order on the shop ".$aOrder->restaurant_info->name." was accepted by the Delivery Boy ".$order->boy_info->username;
					$this->sendpushnotification($aOrder->cust_id,'user',$message);
					//notify customer and partner through socket
					$socketData = array(
						'partner_id'	=> $aOrder->partner_id,
						'customer_id'	=> $aOrder->cust_id,
						'order_id'		=> $aOrder->id,
						//'Molorder_id'	=> $order_exists->orderid,
						'boy_id'		=> $aUser->id,
						'amount'		=> $aOrder->grand_total,
						'partner_name'	=> $aOrder->partner_info->username,
						'socketName'	=> 'boy accepted',
					);
					if (SOCKET_ACTION == 'true') {
						try {
					      require_once SOCKET_PATH;
							$client->emit('boy order accepted', $socketData);
							$client->emit('boy accepted', $socketData);
						} catch(\Exception $e) {
							$error_msg	= 'Some thing went worng,try again after some times';
							\DB::table('tbl_http_logger')->insert(array('request' => 'boy order accepted', 'header' => $e));
						}
					}
					$message = "Order Accepted By Delivery Boy";
					$Duser = User::find($aOrder->cust_id);
					$response['restaurant_detail'] = Restaurant::where('id', $aOrder->res_id)->select('location', 'latitude', 'longitude')->first();
					$response['user_address']['location'] = $aOrder->address; 
					$response['user_address']['lat'] = $aOrder->lat; 
					$response['user_address']['lang'] = $aOrder->lang; 
					$response['user_address']['user_id'] = $aOrder->cust_id;
					$response['user_address']['phone_number'] = $aOrder->mobile_num;
					$response['user_address']['name'] = $Duser->username;
					$response['user_address']['image'] = $Duser->avatar;
				} elseif ($orderStatus == '0') {
					$responseMsg = 'Shop owner should accpet this order to proceed';
				}
			} elseif ($status == '3') {
				if($orderStatus == '2' && $customerStatus == 'Packing'){
					$boy_up = \DB::table('abserve_orders_boy')->where('orderid','=',$aOrder->id)->update(['order_status'=>'3']);
					if($boy_up){
						$update = true;
						$order->status = '3';
						$order->customer_status	= 'Delivering';
						$order->dispatched_time = time();
						$order->save();

						$orderstat = new Orderstatustime;
						$orderstat->order_id = $aOrder->id;
						$orderstat->status = '3';
						$orderstat->created_at = date('Y-m-d H:i:s');
						$orderstat->updated_at = date('Y-m-d H:i:s');
						$orderstat->save();

						$partner_wallet = new Partnerwallet;
						$partner_wallet->order_id = $aOrder->id;
						$partner_wallet->partner_id = $aOrder->partner_id;
						// $partner_wallet->transaction_amount = $aOrder->host_amount;
						$partner_wallet->transaction_amount = $aOrder->accept_host_amount + $aOrder->gst;
						$partner_wallet->transac_through = 'wallet';	
						$partner_wallet->title = '# Order'.$aOrder->id;	
						$partner_wallet->transaction_type = 'credit';
						$partner_wallet->transaction_status = '0';
						$partner_wallet->trans_date =  now();
						$partner_wallet->save();

						/*$orderPartner->order_status = '3';*/
							// $orderPartner->order_accepted_time = time();
						/*$orderPartner->save();*/

						$message    = "Order (#".$aOrder->id.") from shop (".$aOrder->restaurant_info->name.") is ready now. Please proceed to deliver it to the customer.";
						$this->sendpushnotification($aOrder->boy_id,'delivery',$message);
						$message	= "Our delivery rider ".$aOrder->boy_info->username." picked your order from ".$aOrder->restaurant_info->name." and within a few minutes the order will be delivered to you.";
						$this->sendpushnotification($aOrder->cust_id,'user',$message);
						$socketData	= array(
							'partner_id'	=> $aOrder->partner_id,
							'customer_id'	=> $aOrder->cust_id,
							'order_id'		=> $aOrder->id,
							'boy_id'		=> $aOrder->boy_id,
							'socketName'	=> 'order handovered',
						);
						if (SOCKET_ACTION == 'true') {
    					   try {
    					      require_once SOCKET_PATH;
    							$client->emit('partner order handovered', $socketData);
    							$client->emit('order handovered', $socketData);
    						} catch(\Exception $e) {
    							$error_msg	= 'Some thing went worng,try again after some times';
    							\DB::table('tbl_http_logger')->insert(array('request' => 'partner order handovered', 'header' => $e));
    						}
    					}
						$message	= 'Order dispatched to delivery boy';

					} else {
						$responseMsg	= 'You do not have access';
					} 
				} elseif ($orderStatus == '2' && $customerStatus == 'Cooking') {
					$responseMsg	= 'Shop owner should change this order state from preparing state to packing';
				} else if($orderStatus == '0'){
					$responseMsg	= 'Shop owner should accpet this order to proceed';
				}
			} elseif ($status == 'boyPicked') {
				if(in_array(\Auth::user()->group_id, $aGroup_id) || \Auth::user()->d_active == '1'){
				if($orderStatus == '3') {
					//$event		= 'orderPickedByBoy';
					if ($orderType != 'Initial') {
						$refundStatus = $request->refund_status;
						$refundOrder = Refundinfo::find($order->id);
						if (!empty($refundOrder)) {
							$refundOrder->refund_status = 'Boy Collect Customer Item';
							$refundOrder->save();
						}
					}

					$update 	= true;
					$order->status			= 'boyPicked';
					$order->customer_status	= 'boyPicked';
					$order->save();
					if ($orderType == 'Initial') {			
						/*$orderPartner->order_status = 'boyPicked';
						$orderPartner->save();*/
					}
					$orderstat = new Orderstatustime;
					$orderstat->order_id = $aOrder->id;
					$orderstat->status = 'boyPicked';
					$orderstat->created_at = date('Y-m-d H:i:s');
					$orderstat->updated_at = date('Y-m-d H:i:s');
					$orderstat->save();
					$message	= 'Order status updated successfully';
					$Duser = User::find($aOrder->cust_id);
					$response['restaurant_detail'] = Restaurant::where('id', $aOrder->res_id)->select('location', 'latitude', 'longitude')->first();
					$response['user_address']['location'] = $aOrder->address; 
					$response['user_address']['lat'] = $aOrder->lat; 
					$response['user_address']['lang'] = $aOrder->lang; 
					$response['user_address']['user_id'] = $aOrder->cust_id;
					$response['user_address']['phone_number'] = $aOrder->mobile_num;
					$response['user_address']['name'] = $Duser->username;
					$response['user_address']['image'] = $Duser->avatar;

					$response['delivery_distance'] = (double) $aOrder->del_km;
					$cmessage	= "Our delivery rider ".$order->boy_info->username." picked your order from ".$aOrder->restaurant_info->name.".So, you can now able to track driver.";
					// Socket emit insertion for Customer
					$this->sendpushnotification($aOrder->cust_id,'user',$cmessage);
					$socketData = array(
						'customer_id'	=> $aOrder->cust_id,
						'order_id'		=> $aOrder->id,
						'partner_id'	=> $aOrder->partner_id,
						'boy_id'		=> $aOrder->boy_id,
						'socketName'	=> 'boy picked',
					);
					if (SOCKET_ACTION == 'true') {
 					   try {
 					      require_once SOCKET_PATH;
 							$client->emit('boy order picked', $socketData);
 							$client->emit('boy picked', $socketData);
 						} catch(\Exception $e) {
 							$error_msg	= 'Some thing went worng,try again after some times';
 							\DB::table('tbl_http_logger')->insert(array('request' => 'boy order picked', 'header' => $e));
 						}
 					}
				} elseif ($orderStatus == '4' || $orderStatus == '5' || $orderStatus == 'boyPicked' || $orderStatus == 'boyArrived') {
					$responseMsg = 'Order Already '.$status_text;
				} else {
					if ($orderType != 'Initial') {
						$responseMsg = "Wait for approval from support of this order.";
					}else{
						$responseMsg = "Shop owner should handover this order to proceed";
					}
				}
				}
			} elseif ($status == 'boyArrived') {
				if(in_array(\Auth::user()->group_id, $aGroup_id) || \Auth::user()->d_active == '1'){
				if($orderStatus == 'boyPicked') {
						//$event		= 'orderArrivedToCustomer';
					$update 	= true;
					$order->status			= 'boyArrived';
					$order->customer_status	= 'boyArrived';
					$order->save();

					$orderstat = new Orderstatustime;
					$orderstat->order_id = $aOrder->id;
					$orderstat->status = 'boyArrived';
					$orderstat->created_at = date('Y-m-d H:i:s');
					$orderstat->updated_at = date('Y-m-d H:i:s');
					$orderstat->save();
					
					if ($orderType == 'Initial') {

						$message	= 'Order status updated successfully';
						$cmessage	= "Our delivery rider ".$order->boy_info->username." has been arrived to your location.";
						$this->sendpushnotification($aOrder->cust_id,'user',$cmessage);

						/*$orderPartner->order_status = 'boyArrived';
						$orderPartner->save();*/
						$pmessage   = "Delivery rider ".$order->boy_info->username." reached the customer location.";
						$this->sendpushnotification($aOrder->partner_id,'user',$pmessage);
						$socketData = array(
							'customer_id'	=> $aOrder->cust_id,
							'order_id'		=> $aOrder->id,
							'partner_id'	=> $aOrder->partner_id,
							'boy_id'		=> $aOrder->boy_id,
							'socketName'	=> 'boy arrived',
						);
						if (SOCKET_ACTION == 'true') {
	 					   try {
	 					      require_once SOCKET_PATH;
	 							$client->emit('boy arrived', $socketData);
	 						} catch(\Exception $e) {
	 							$error_msg	= 'Some thing went worng,try again after some times';
	 							\DB::table('tbl_http_logger')->insert(array('request' => 'boy arrived', 'header' => $e));
	 						}
	 					}
					}
				} elseif ($orderStatus == '4' || $orderStatus == '5' || $orderStatus == 'boyPicked' || $orderStatus == 'boyArrived') {
					$responseMsg	= 'Order Already '.$status_text;
				} else {
					$responseMsg	= "You should first pickup this order to proceed";
				}
			  }
			} elseif ($status == '4') {
				if(in_array(\Auth::user()->group_id, $aGroup_id) || \Auth::user()->d_active == '1'){
					$statusOrder = 'boyArrived';
					if($request->device == 'android'){
						$statusOrder = 'otpVerify';
					}
				if($orderStatus == $statusOrder/* || $orderStatus == 'boyPicked'*/){
					$refundStatus = '';
					if ($orderType != 'Initial') {
						$refundStatus = $request->refund_status;
						$refundOrder = Refundinfo::find($order->id);
						if (!empty($refundOrder)) {
							if ($orderType == 'Replace') {
								if ($refundStatus == 'itemUnavailable') {
									$refundOrder->refund_status = 'Item Unavailable';
									$message	= "Replacement item not Unavailable";
									$this->sendpushnotification($aOrder->partner_id,'user',$message);
								} elseif ($refundStatus == 'itemCollected') {
									$rOrder = RefundDetails::where('child_order',$order->id)->first();

									/*if (!empty($rOrder)) {
										$boy_image	= json_decode($rOrder->boy_image); 
										$dataFile	= [];
										if($request->hasfile('image')) {
											foreach($request->file('image') as $fKey => $file) {
												$document = $file;
												$filename = time().'-'.($fKey+1).'.'.$document->getClientOriginalExtension();
												$destinationPath = base_path('/uploads/refund/'.$rOrder->parent_order.'/boy');
												$document->move($destinationPath, $filename);
												$dataFile[] = $filename;
											}
										} 
										$boy_image->partner_image = $dataFile;
										$rOrder->boy_image	 = json_encode($boy_image); 
										$rOrder->save();
									}*/

									$message	= "Boy Collect Partner Replacement Item";
									$this->sendpushnotification($aOrder->partner_id,'user',$message);
									$refundOrder->refund_status = 'Boy Collect Partner Item';
								} elseif ($refundStatus == 'itemsDispatched') {
									$refundOrder->refund_status = 'Boy Dispatch to Customer';
								}
							} else {
								$refundOrder->refund_status = 'Boy Dispatch to Partner';
							}
							$update		= true;
							$refundOrder->save();
						}
					}
					if ($orderType == 'Initial' || $orderType == 'Refund' || $refundStatus == 'itemUnavailable' || $refundStatus == 'itemsDispatched') {
						$OrderId = RiderLocationLog::select('order_id')->where('boy_id',$aUser->id)->WhereRaw('FIND_IN_SET(?,order_id)',[$aOrder->id])->update(['order_id'=> $aOrder->id, 'status'=> 1 ]);
						$boy_up = \DB::table('abserve_orders_boy')->where('orderid','=',$aOrder->id)->where('boy_id','=',$aUser->id)->update(['order_status'=>'4','order_done_status'=>'1']);

						$update					= true;
						$order->status			= '4';
						$order->completed_time	= time();
						$order->customer_status	= 'Delivered';
						$order->delivery		= 'paid';
						if(/*$request->paytype == "cashondelivery" &&*/ $orderType == 'Initial') {
							$order->cod_amount = $request->cod_amount;
						}
						$order->save();

						if ($orderType == 'Initial') {
							/*$orderPartner->order_status = '4';*/
							// $orderPartner->order_accepted_time = time();
							/*$orderPartner->save();*/
							$orderstat			= new Orderstatustime;
							$orderstat->order_id= $aOrder->id;
							$orderstat->status	= '4';
							$orderstat->created_at	= date('Y-m-d H:i:s');
							$orderstat->updated_at	= date('Y-m-d H:i:s');
							$orderstat->save();
						}
						$count	= Deliveryboy::ordercount()->where('id',$aUser->id)->count();
						// if($count	== '0'){
						// 	Deliveryboy::where('id','=',$aUser->id)->update(['boy_status'=>'0']);
						// }
						\DB::table('tb_users')->select('SELECT tb_users.`id` FROM `tb_users` WHERE `boy_status` = "1" AND tb_users.active = 1 AND tb_users.online_sts = 1 AND (SELECT COUNT(`id`) FROM `abserve_order_details` WHERE (`status` = "2" OR `status` = "3") AND `boy_id` = tb_users.`id`) = 0')->update(['boy_status'=>'0']);

						if ($orderType == 'Initial') {
							$message	= "Order delivered Successfully.Thank you for being an amazing customer"; 
							$this->sendpushnotification($aOrder->cust_id,'user',$message);
							$message	= "Delivery boy delivered the order (Order ID:".$aOrder->id.") to the customer";
							$this->sendpushnotification($aOrder->partner_id,'user',$message);
							$socketData = array(
								'customer_id'	=> $aOrder->cust_id,
								'order_id'		=> $aOrder->id,
								'partner_id'	=> $aOrder->partner_id,
								'boy_id'		=> $aOrder->boy_id,
								'socketName'	=> 'delivered to customer',
							);
							if (SOCKET_ACTION == 'true') {
		 					   try {
		 					      require_once SOCKET_PATH;
		 							$client->emit('delivered the order', $socketData);
		 							$client->emit('delivered to customer', $socketData);
		 						} catch(\Exception $e) {
		 							$error_msg	= 'Some thing went worng,try again after some times';
		 							\DB::table('tbl_http_logger')->insert(array('request' => 'delivered the order', 'header' => $e));
		 						}
		 					}
						}
						$boy_bal['boy_id']				= $aOrder->boy_id; 
						$boy_bal['order_id']			= $aOrder->id; 
						$boy_bal['delivery_distance']	= $aOrder->del_charge; 
						$boy_bal['delivery_charge']		= ($aOrder->min_night+$aOrder->del_charge);
						if(\DB::table('abserve_boy_balance')->where('order_id',$aOrder->id)->exists()){
							\DB::table('abserve_boy_balance')->where('order_id',$aOrder->id)->update($boy_bal);
						} else {
							\DB::table('abserve_boy_balance')->insert($boy_bal);
						}

						$riderlog = new RiderLocationLog;
						$riderlog->boy_id = $aOrder->boy_id;
						$riderlog->order_id = $aOrder->id;
						$riderlog->order_status = $order->status;
						$riderlog->distance = $aOrder->del_km;
						$riderlog->travelled = $aOrder->del_km;
						$riderlog->latitude = $aOrder->lat;
						$riderlog->longitude = $aOrder->lang;
						$riderlog->date = $aOrder->date;
						$riderlog->save();

						$offerData	= Offers::whereRaw('? between offer_from and offer_to', [date('Y-m-d')])->where('status','active')->first();
						if (!empty($offerData)) {
							$aOrder->accept_total_price	= $aOrder->accepted_order_items->sum(function($item) {
								return $item->mrp;
							});
							$userInfo	= User::find($aOrder->cust_id,['id','offer_wallet']);
							$redeemAmount	= ($offerData->offer_type == 'amount') ? $offerData->offer_value : ($offerData->offer_value / 100);
							$offerAmount	= $aOrder->accept_total_price * ($redeemAmount);
							$userInfo->offer_wallet	= $userInfo->offer_wallet + $offerAmount;
							$userInfo->save();
							// User::where('id',$aOrder->cust_id)->update(['offer_wallet'=>$offerAmount,'offer_id' => $offerData->id]);
							if ($offerAmount > 0) {
								$offer_table 				= new OfferUsers;
								$offer_table->order_id 		= $aOrder->id;
								$offer_table->cust_id 		= $aOrder->cust_id;
								$offer_table->type 			= 'credit';
								$offer_table->reason		= $offerData->name. ' offer added';
								$offer_table->offer_price 	= $offerAmount;
								$offer_table->offer_name 	= $offerData->name;
								$offer_table->grand_total 	= $aOrder->accept_grand_total; 
								$offer_table->save();
							}
						}
						// delivery boy share end
						$Duser = User::find($aOrder->cust_id);
						$Buser = User::find($aOrder->boy_id);
						$existWallet = $Buser->customer_wallet;
						//$per_order_min_amount_for_del_boy = DELIVERYBOY_MINIMUM_AMOUNT; 
						$api_settings= \DB::table('tb_settings')->select('delivery_boy_charge_per_km')->first();
						$order_delivery_amount = $aOrder->del_km * $api_settings->delivery_boy_charge_per_km;
						$Buser->customer_wallet = $existWallet + $order_delivery_amount;
						if($aOrder->delivery_type == 'cashondelivery'){
							$boy_cash_inHand = $Buser->boy_cashIn_hand;
							$Buser->boy_cashIn_hand = $boy_cash_inHand + $aOrder->accept_grand_total;
						}
						$Buser->save();

						$delBoyWallet = new Deliveryboywallet();			
						$delBoyWallet->del_boy_id = $aOrder->boy_id;
						$delBoyWallet->order_id   = $aOrder->id;
						$delBoyWallet->transac_through = 'wallet';
						$delBoyWallet->title	   =  '# Order'.$aOrder->id;
						$delBoyWallet->transaction_amount = $order_delivery_amount;
						$delBoyWallet->trans_date = now();
						$delBoyWallet->transaction_type = 'credit';
						$delBoyWallet->transaction_status = '0';
						$delBoyWallet->save();

						$order->delivery_boy_charge_per_km   = $api_settings->delivery_boy_charge_per_km;
						$order->boy_del_charge   = $order_delivery_amount;
						$order->save();
							
						$response['restaurant_detail'] = Restaurant::where('id', $aOrder->res_id)->select('location', 'latitude', 'longitude')->first();
						$response['user_address']['location'] = $aOrder->address; 
						$response['user_address']['lat'] = $aOrder->lat; 
						$response['user_address']['lang'] = $aOrder->lang;
						$response['user_address']['user_id'] = $aOrder->cust_id;
						$response['user_address']['phone_number'] = $aOrder->mobile_num;
						$response['user_address']['name'] = $Duser->username;
					   $response['user_address']['image'] = $Duser->avatar;
						$message = 'Order delivered  Successfully';
					}
				}
			}
			} elseif ($status == '5') {
				//if($orderStatus == '0' || ($orderStatus == '6' && $field == 'partner_id')){
				if($aOrder->coupon_id > 0){
					\DB::table('abserve_promocode')->where('id','=',$aOrder->coupon_id)->increment('limit_count');
				}
				if($field == 'cust_id' && $orderStatus != 'pending' && $orderStatus !='0'){
					$response['message'] = 'customer can not cancel order';
					$response['status'] = '422';
					return \Response::json($response);
				}
				$cancelled_by			= '';
				$update					= true;
				$order->status			= '5';
				$order->customer_status	= 'Cancelled';
				if($aUser->group_id == '1'){
				$cancelled_by			= 'admin';
				} elseif($aUser->p_active == '1'){
					$cancelled_by = 'vendor';
				} elseif($field == 'cust_id') {
					$cancelled_by = 'customer';
				} elseif($aUser->d_active == '1'){
					$cancelled_by = 'deliveryboy';
				}else{
					$cancelled_by = '';
				}
				$order->cancelled_by	= $cancelled_by;
				//$this->refund($order->id,$cancelled_by);
				$order->save();

				if ($cancelled_by == 'customer') {
					$offerData	= \AbserveHelpers::Offerdata($order->cust_id,$order->total_price);
					$oldReedeem	= 0;
					if ($order->cash_offer > 0) {
						$offer_table= OfferUsers::where('order_id',$order->id)->first();
						$oldReedeem	= $offer_table->offer_price;
						$offerTable	= new OfferUsers;
						if (!empty($offer_table)) {
							$offerTable->order_id	= $order->id;
							$offerTable->cust_id	= $order->cust_id;
							$offerTable->type		= 'credit';
							$offerTable->reason		= $offerData['OfferName']. ' offer redeem refunded (Due to cancellation)';
							$offerTable->offer_price= $order->cash_offer;
							$offerTable->offer_name	= $offerData['OfferName'];
							$offerTable->grand_total= $order->grand_total; 
							$offerTable->save();
						}
					}
					$user_offer	= User::find($order->cust_id,['id','offer_wallet']);
					$cash_back_value	= ($user_offer->offer_wallet + $oldReedeem);
					$user_offer->offer_wallet	= $cash_back_value;
					$user_offer->save();
				}
				$orderstat = new Orderstatustime;
				$orderstat->order_id = $aOrder->id;
				$orderstat->status = '5';
				$orderstat->created_at = date('Y-m-d H:i:s');
				$orderstat->updated_at = date('Y-m-d H:i:s');
				$orderstat->save();

				if($cancelled_by == 'customer'){
					$message = 'Order Cancelled Successfully';
				} else {
					$message    = " Oh No! ".$aOrder->restaurant_info->name." has cancelled order ".$order->id.". Sorry!";
					$this->sendpushnotification($aOrder->cust_id,'user',$message);
					$socketData = array(
						'customer_id'	=> $aOrder->cust_id,
						'order_id'		=> $aOrder->id,
						'partner_id'	=> $aOrder->partner_id,
						'cancelled_by'	=> $aOrder->cancelled_by,
						'socketName'	=> 'partner rejected',
					);
					if (SOCKET_ACTION == 'true') {
 					   try {
 					      require_once SOCKET_PATH;
 							$client->emit('partner rejected', $socketData);
 						} catch(\Exception $e) {
 							$error_msg	= 'Some thing went worng,try again after some times';
 							\DB::table('tbl_http_logger')->insert(array('request' => 'partner rejected', 'header' => $e));
 						}
 					}
				}
				$grandTotal_reject  = OrderDetail::find($aOrder->id);
				$fetch_users= User::find($order->cust_id,['customer_wallet']);
				$grandTotalReject   = $grandTotal_reject->grand_total;
				$check              = false;
				// $fund	= \AbserveHelpers::apiSettings()->fund_return_type;
				// if($fund=='wallet')
				// {
				// if ($paytype == "razorpay") {
				// 	if ($grandTotalReject > 0) {
				// 		$check      = true;
				// 		$wallet		= $fetch_users->customer_wallet + $grandTotalReject;
				// 	}
				// }else {
				// 	$check      	= true;
				// 	$wallet         = $fetch_users->customer_wallet + $order->wallet_amount;
				// }
				// if($check && $grandTotalReject > 0) {
				// 	$addwallet = new Wallet;
				// 	$addwallet->user_id		= $order->cust_id;
				// 	$addwallet->order_id	= $aOrder->id;
				// 	$addwallet->amount		= $grandTotalReject;
				// 	$addwallet->reason		= "Order Rejection";
				// 	$addwallet->type		= "credit";
				// 	$addwallet->balance		= $wallet;
				// 	$addwallet->added_by	= $aUser->id;
				// 	$addwallet->order_status= '0';
				// 	$addwallet->date		=  date('Y-m-d');
				// 	$addwallet->save();
				// 	User::where('id',$order->cust_id)->update(['customer_wallet'=>$wallet]);
						
				// }
			// }
			\AbserveHelpers::Refund($order,'reject');
				$message		= 'Order Cancelled Successfully';
			} elseif ($status == 'boyreject') {
				$time		= date('Y-m-d H:i:s');
				\DB::table('delivery_boy_new_orders')->where('boy_id',$aUser->id)->where('order_id',$aOrder->id)->update(['status'=>'Rejected','update_at'=>$time]);
				\DB::table('abserve_deliveryboys')->where('id','=',$aUser->id)->update(['boy_status'=>'0']);
				$order->cancelled_by = 'deliveryboy';
				$order->save();
				$response1	= $this->sendRequestToBoy($request,$aOrder->id);
				$update		= true;
				$message	= 'Rejected Successfully';
			} elseif ($status == 'Packing') {
				if ($customerStatus == 'Cooking') {
					$event	= 'orderPacking';
					$order->customer_status	= 'Packing';
					$order->save();

					$orderstat = new Orderstatustime;
					$orderstat->order_id = $aOrder->id;
					$orderstat->status = 'Packing';
					$orderstat->created_at = date('Y-m-d H:i:s');
					$orderstat->updated_at = date('Y-m-d H:i:s');
					$orderstat->save();

					$message	= 'Order status changed successfully';
					$update		= true;
					$smessage	= 'Your order was moved to packing state.';
					if($orderStatus == '2') {
						$this->sendpushnotification($aOrder->boy_id,'delivery',$smessage);
						$socketData = array(
							'customer_id'	=> $aOrder->cust_id,
							'order_id'		=> $aOrder->id,
							'partner_id'	=> $aOrder->partner_id,
							'socketName'	=> 'order packing',
						);
						if (SOCKET_ACTION == 'true') {
    					   try {
    					      require_once SOCKET_PATH;
    							$client->emit('partner order packing', $socketData);
    							$client->emit('order packing', $socketData);
    						} catch(\Exception $e) {
    							$error_msg	= 'Some thing went worng,try again after some times';
    							\DB::table('tbl_http_logger')->insert(array('request' => 'partner order packing', 'header' => $e));
    						}
    					}
					}
				} elseif ($status == $customerStatus) {
					$responseMsg	= 'Already moved to Packing state';
				} elseif ($orderStatus == '4' || $orderStatus == '5' || $orderStatus == 'boyPicked' || $orderStatus == 'boyArrived') {

					$status_text	= $aOrder->status_text;
					$responseMsg	= 'Order Already '.$status_text;
				} else {
					$responseMsg	= 'Shop owner should accpet this order to proceed';
				}
			}
			if (!$update) {
				$response_status = 422;
				if($responseMsg != ''){
					$message = $responseMsg;
				} else {
					if($status <= $orderStatus || $status == '5'){
						$status_text = $aOrder->status == '6' ? ' Accepted. Searching for boy' : $aOrder->status_text;
						$message = 'Order Already '.$status_text;
					} else {
						$stat = new orderDetail;
						$message = 'Order needs to be '.$stat->status_do($orderStatus);
					}
				}
			} else {

				$currentStatus = '';

				$tableStatus = $order->status;

				if ($tableStatus == '0') {
					$currentStatus = 'orderBeingPending';
				}elseif ($tableStatus == '1') {
					if($orderType == 'Initial'){
						$currentStatus = 'partnerAcceptOrder';
					}else{
						$currentStatus = 'adminApproveOrder';
					}
				}elseif ($tableStatus == '2') {
					$currentStatus = 'boyAcceptOrder';
				}elseif ($tableStatus == '3') {
					if($orderType == 'Initial'){
						$currentStatus = 'partnerDispatchOrder';
					}else{
						$currentStatus = 'customerDispatchOrder';
					}
				}elseif ($tableStatus == '4') {
					if($orderType == 'Replace' && $order->refund_status == 'Item Unavailable'){
						$currentStatus = 'orderDeliveredOnlyPartner';
					}else{
						$currentStatus = 'orderDelivered';
					}
				}elseif ($tableStatus == '5') {
					if($orderType == 'Initial'){
						$currentStatus = 'partnerCancelOrder';
					}else{
						$currentStatus = 'adminCancelOrder';
					}					
				}elseif ($tableStatus == '6') {
					$currentStatus = 'noBoyFound';					
				}elseif ($tableStatus == 'boyPicked') {
					$currentStatus = 'boyPickedItem';					
				}elseif ($tableStatus == 'boyArrived') {
					if($orderType == 'Initial' || $orderType == 'Refund'){
						$currentStatus = 'boyArrivedSpot';
					}else{
						if ($status == 'boyArrived') {
							$currentStatus = 'boyArrivedSpot';
						}elseif (isset($request->refund_status) && $request->refund_status == 'itemCollected' && $status == '4') {
							$currentStatus = 'itemCollectFromPartner';
						}
					}				
				}
				$response_status = 200;
			}
			
			if ($response_status == 200) {
				$response['id']		= '1';
				$response["status"]	= 'success';
				//Emit Socket
				if(SOCKET_ACTION == 'true' && !empty($socketData['socketName'])) {
					require_once SOCKET_PATH;
					\DB::table('tbl_http_logger')->insert(array(/*'created_at'=>$created_at,*/'request'=>$socketData['socketName'],'header'=>json_encode($socketData)));
					// $client->emit($socketData['socketName'], $socketData);
				}

				$response['order_type']		= $orderType;
				$response['current_status']	= $currentStatus;
				// push notification
				/*foreach ($emitTo as $key => $value) {
					$userData = explode('_', $value);
					$this->sendpushnotification($userData[1],$userData[0],$emitMessages[$key],$event);
				}*/
			} else {
				$response['id']		= '2';
				$response["status"]	= 'failure';
			}
			$response['message']	= $message;
		} else {
			$messages				= $validator->messages();
			$error					= $messages->getMessages();
			$val					= $this->getStepvalidation($error);
			$response['id']			= '2';
			$response["status"]		= 'error';
			$response["message"]	= $val;
		}
		if($request->website == '1'){
			return json_encode($response);
		}
		if((isset($request->is_from) && $request->is_from == 'boyneworderspage') && (isset($request->is_this) && $request->is_this == 'website')){
			return json_encode($response);
		}
		if (isset($request->appcall) && $request->appcall == 'orderedit') {
			return json_encode($response);
		} else {
			return \Response::json($response,$response_status);
		}
	}

	public function sendRequestToBoy(Request $request,$orderid, $type = '')
	{
		$radius = \AbserveHelpers::getkmboy();
		if($orderid > 0){
			$where = ' ';
			$order_details	= OrderDetail::select('id','created_at','res_id','cust_id','partner_id','accept_grand_total','del_charge','del_charge_tax_price')->with(['outof_stock_items','accepted_order_items'])->find($orderid);
			// $order_details->accept_total_price	= $order_details->accepted_order_items->sum(function($item) {
			// 	return $item->mrp;
			// });
			$restaurant		= Restaurant::select('id','latitude','longitude','partner_id')->where('id',$order_details->res_id)->first();
			if ($radius != '') {
				// $order_count= ", ( SELECT COUNT(id) as count FROM delivery_boy_new_orders WHERE `boy_id` = abserve_deliveryboys.`id` AND SUBSTRING(update_at,1,10) = '".date('Y-m-d')."' ) as `count`";
			}
			$freeBoys	= Deliveryboy::select()->addSelect(\DB::raw(Deliveryboy::latlang($restaurant->latitude,$restaurant->longitude,$radius). " as distance"))->nearby($restaurant->latitude,$restaurant->longitude,$radius)->where('boy_status','0')->where('d_active','1')->where('mode','online')->orderBy('distance','Asc')->/*first*/get();

			$created_at	= date('Y-m-d H:i:s');

			$stockStatus		= (count($order_details->outof_stock_items) > 0) ? 'yes' : 'no';
			$outOfStockItems	= (count($order_details->outof_stock_items) > 0) ? implode(', ', $order_details->outof_stock_items->pluck('food_item')->toArray()) : '' ;
			$omessage	= "The following items are out of stock".$outOfStockItems.".
			Balance items will be delivered shortly.
			Your revised payable amount is Rs ".$order_details->accept_grand_total. ".";

			/*if (!empty($freeBoys) > 0) {
				$boy_id		= $freeBoys->id;
				$created_at	= date('Y-m-d H:i:s');
				Deliveryboy::where('id',$boy_id)->update(['boy_status'=>'1']);
				OrderDetail::where('id',$orderid)->update(['rapido_orderid'=>NULL,'is_rapido'=>'no']);
				Deliveryboyneworder::insert(['boy_id'=>$boy_id,'order_id'=>$orderid,'is_rapido'=>'no','create_at'=>$created_at,'entry_by'=>$boy_id]);
				if (SOCKET_ACTION == 'true') {
					$boy_Arr[]	= $boy_id;
					require SOCKET_PATH;
					$aData		= array(
						'customer_id'	=> $order_details->cust_id,
						'partner_id'	=> $order_details->partner_id,
						'order_id'		=> $orderid,
						'boy_id'		=> $boy_Arr,
						'orderData'		=> $order_details,
						'message'		=> $omessage,
						'stockStatus'	=> $stockStatus
					);
					try {
						$client->emit('partner accepted', $aData);
					} catch(\Exception $e) {
						$error_msg	= 'Some thing went worng,try again after some times';
					}
				}
				return $boy_id;
			}*/if (!empty($freeBoys) > 0) {
					$boys_ids = [];
					foreach($freeBoys as $boys){
					$boy_id		= $boys->id;
					// $boys_id[] = $boys->id;
					$created_at	= date('Y-m-d H:i:s');
				//Deliveryboy::where('id',$boy_id)->update(['boy_status'=>'1']);
					OrderDetail::where('id',$orderid)->update(['rapido_orderid'=>NULL,'is_rapido'=>'no']);
					Deliveryboyneworder::insert(['boy_id'=>$boy_id,'order_id'=>$orderid,'is_rapido'=>'no','create_at'=>$created_at,'entry_by'=>$boy_id]);
					/*if (SOCKET_ACTION == 'true') {
						$boy_Arr[]	= $boy_id;
						require SOCKET_PATH;
						$aData		= array(
							'customer_id'	=> $order_details->cust_id,
							'partner_id'	=> $order_details->partner_id,
							'order_id'		=> $orderid,
							'boy_id'		=> $boy_Arr,
							'orderData'		=> $order_details,
							'message'		=> $omessage,
							'stockStatus'	=> $stockStatus
						);
						try {
							$client->emit('partner accepted', $aData);
						} catch(\Exception $e) {
							$error_msg	= 'Some thing went worng,try again after some times';
						}
					}*/
				array_push($boys_ids, $boy_id);
				}
				if (SOCKET_ACTION == 'true') {
						// $boy_Arr[]	= $boy_id;
						require SOCKET_PATH;
						$aData		= array(
							'customer_id'	=> $order_details->cust_id,
							'partner_id'	=> $order_details->partner_id,
							'order_id'		=> $orderid,
							'boy_id'		=> $boys_ids,
							'orderData'		=> $order_details,
							'message'		=> $omessage,
							'stockStatus'	=> $stockStatus
						);
						try {
							$client->emit('partner accepted', $aData);
							$client->emit('partner order accepted',$aData);
						} catch(\Exception $e) {
							$error_msg	= 'Some thing went worng,try again after some times';
						}
					}
					return $boys_ids;
			} elseif($type == '') {
				OrderDetail::where('id',$orderid)->update(['status'=>'6']);
				$message = 'Order accepted';
				$this->sendpushnotification($restaurant->partner_id,'user',$message);

				//notify partner through socket
				if (SOCKET_ACTION == 'true') {
					require SOCKET_PATH;
					$aData = array(
						'customer_id'	=> $order_details->cust_id,
						'partner_id'	=> $order_details->partner_id,
						'order_id'		=> $orderid,
						'orderData'		=> $order_details,
						'message'		=> $omessage,
						'stockStatus'	=> $stockStatus
					);
					try {
						$client->emit('no boys found', $aData);
					} catch (\Exception $e) {
						$error_msg	= 'Some thing went worng,try again after some times';
					}
				}
				return 0;
			} else {
				return 0;
			}
		}
	}

	public function postRapidocheck(Request $request,$orderId=791)
	{

		$request['clientOrderId']=(string)$orderId;
		$orderDetails=\DB::table('abserve_order_details')->select('res_id','cust_id','lat','lang','address','delivery_type')->where('id',$orderId)->first();
		$abserveRestaurants=\DB::table('abserve_restaurants')->select('latitude','longitude','location','name','phone')->where('id',$orderDetails->res_id)->first();
		$tbUsers=\DB::table('tb_users')->select('first_name','phone_number')->where('id',$orderDetails->cust_id)->first();

		$request['pickup_lat']=$abserveRestaurants->latitude;
		$request['pickup_lng']=$abserveRestaurants->longitude;
		$request['pickup_address']=$abserveRestaurants->location;
		$request['drop_lat']=$orderDetails->lat;
		$request['drop_lng']=$orderDetails->lang;
		$request['drop_address']=$orderDetails->address;
		$request['customerName']=$tbUsers->first_name;
		$request['customerNumber']=$tbUsers->phone_number;
		$request['restaurantName']=$abserveRestaurants->name;
		$request['restaurantPhone']=$abserveRestaurants->phone;
		$request['supportNumber']='9958483101';
		$request['billPaymentType']=($orderDetails->delivery_type=='razorpay') ? 'WALLET' : 'WALLET';
		$request['orderValue']=0;
		$request['pickup_otp']='1234';
		$aItems=[];
		$abserveOrderItems=\DB::table('abserve_order_items')->where('orderid',$orderid)->get();
		if(count($abserveOrderItems)>0){
			foreach ($abserveOrderItems as $key => $value) {
				$aItems[]=["name"=>$value->food_item,"price"=>$value->price,"quantity"=>$value->quantity];
			}
		}
		$request['items']=$aItems;
		$rapidoCon= new rapidoCon;
		$getEta=$rapidoCon->eta($request);
		$rapidoCon->store($orderId,$getEta,'');
		$data['getEta']=$getEta;
		$status=0;
		$data['orderId']=(string)$orderId;
		$rapidoOrderid='';
		if($getEta->info->status=='success'){
			$getEtaBook=$rapidoCon->etaBook($request);
			$rapidoCon->store($orderId,$getEtaBook,isset($getEtaBook->data->orderId) ? $getEtaBook->data->orderId : '' );

			$data['getEtaBook']=$getEtaBook;
			if($getEtaBook->info->status=='success'){
				if($getEtaBook->data->status=='new'){
					$status=1;
					$rapidoOrderid=$getEtaBook->data->orderId;
					\DB::table('abserve_order_details')->where('id',$orderId)->update(['rapido_orderid'=>$rapidoOrderid,'is_rapido'=>'yes']);
				}
			}
		}

		return $status;
	}

	public function PreOrderCallBoy(Request $request)
	{
  		$rules['user_type'] = 'required|in:user';
		$rules['order_id'] = 'required';
		$this->validateDatas($request->all(),$rules);
		$aUser =\Auth::user();
		$code = 422;
		$order_details=\DB::table('abserve_order_details')->where('id',$request->order_id)->first();
		if($aUser->id == $order_details->partner_id)
		{
			if(($order_details->status == '1' || $order_details->status == '6' ) && $order_details->delivery_preference != 'asap')
			{
				$code = 200;
				$boyassign = $this->sendRequestToBoy($request,$order_details->id);
				\DB::table('abserve_order_details')->where('id',$order_details->id)->update(['boy_called'=>2]);
				if($boyassign > 0) {                                    
		            $message = "Assigned to delivery boy"; 
		        } else {
		            $message = "Waiting for delivery boy"; 
		        }
			}else
			{
					$code = 422;
		            $message = "Can call boy only for Pre-Orders"; 
			}
		}else
		{
			$code = 422;
			$message = "Access Denied"; 
		}
		$response['message'] = $message;
		return \Response::json($response,$code);
	}

	public function appapimethod( $value = '')
	{
		$appapi = \DB::table('abserve_app_apis')->select('*')->where('id','=',$value)->get();

		return $appapi[0];
	}

	public function userapimethod($userid = '',$table)
	{

		$userapi = \DB::table($table)->select('mobile_token')->where('id','=',$userid)->get();

		return $userapi[0]->mobile_token;
	}

	// function razorWebhook(Request $request)
	// {
	// 	$val['gateway'] = 'razorpay';
	// 	$val['request_header'] = '';// json_encode(getallheaders());
	// 	$val['request_values'] = 'post='.json_encode($request->all());
	// 	$val['created_at'] = date('Y-m-d H:i:s');
	// 	// \DB::table('webhook_event')->insert($val);
	// 	$aRequest = json_decode(json_encode($request->all()));
	// 	$event = $aRequest->event;
	// 	if($event == 'order.paid'){
	// 		$razorOrderId = $aRequest->payload->order->entity->id;
	// 		$aOrder = OrderDetail::with('user_info')->where('orderid',$razorOrderId)->first();
	// 		if(!empty($aOrder)){
	// 			$checkcon = new checkcon;
	// 			$data = $checkcon->orderPayHandler($aOrder->orderid,$request->payload['payment']['entity']['id']);
	// 			if($data['status'] != 200 && $data['doRefund']){
	// 				$aOrder->append('restaurant_info');
	// 				$order = OrderDetail::find($aOrder->id);
	// 				$orderPartner = OrderDetails::where('orderid',$aOrder->id)->first();
	// 				$order->status = '5';
	// 				$cancelled_by = 'system';
	// 				$order->cancelled_by = $cancelled_by;

	// 				$this->refund($order->id,$cancelled_by);

	// 				$order->save();

	// 				$orderPartner->order_status = '5';
	// 				$orderPartner->save();
	// 				$message = 'Your order #'.$aOrder->id.' cancelled due to payment delay. We will refund your amount if deducted, you will receive amount within 5-7 business working days';
	// 				$this->sendpushnotification($aOrder->cust_id,'user',$message);

	// 				/*$data=array('order_id'=>$aOrder->id,
	// 					'res_name'=>$aOrder->restaurant_info->name,
	// 					'reason'=>$message
	// 				);
	// 				$subject='Order Cancelled';
	// 				$emailcon = new emailcon;
	// 				$emailcon->sendEmail($aOrder->user_info->email,$subject,'emails.order.cancel_mail',$data);*/ 
	// 			}else
	// 			{
	// 				return $data;
	// 			}
	// 		}
	// 	} elseif ($event == 'payment.captured') {
	// 		$paymentId	= $aRequest->payload->payment->entity->id;
	// 		$orderId	= $aRequest->payload->payment->entity->order_id;
	// 		$orderDetail= OrderDetail::where('orderid',$orderId)->first();
	// 		OrderDetail::where('orderid',$orderId)->update(['payment_token' => $paymentId]);
	// 		$payment = OrderPayment::where('order_id',$orderDetail->id)->first();
	// 		$payment->transaction_id	= $paymentId;
	// 		$payment->save();
	// 	} elseif ($event = 'refund.processed') {
	// 		$paymentId = $aRequest->payload->payment->entity->id;
	// 		$aOrder = OrderDetail::with('refund_info')->where('orderid',$paymentId)->first();
	// 		$this->refund($aOrder->id,'update');
	// 	} 
	// 	return 'true';
	// }

	/*private function updateRefundStatus($aOrder,$action,$refundResponse='',$toRefundAmount=0)
	{
		if(!empty($refundResponse))
		{
			if($action == 'add'){
				$refund = new OrderRefund;
				$refund->order_id = $aOrder->id;
				$refund->payment_order_id = $aOrder->orderid;
				$refund->payment_id = $aOrder->payment_token;
				$refund->refund_amount = $toRefundAmount;
				$refund->refund_id = $refundResponse->id;
				$refund->refunded_amount = $refundResponse->status == '1' ? ($refundResponse->amount / 100) : 0;
				$refund->refund_currency = $refundResponse->currency;
				$refund->refund_status = $refundResponse->status;
				$refund->created_at = date('Y-m-d H:i:s');
			} else {
				$refund = OrderRefund::find($aOrder->refund_info->id);
				if($aOrder->delivery_type != 'cashondelivery'){
					if($aOrder->delivery_type == 'razorpay'){
						$paymentId = $refund->payment_id;
						$refundId = $refund->refund_id;

						$api_key = RAZORPAY_API_KEYID;
				        $api_secret = RAZORPAY_API_KEY_SECRET;
				        $api = new Api($api_key, $api_secret);
						$Obrefund = $api->payment->fetch($paymentId)->refunds()->items[0];

						$refund->refund_status = $Obrefund->status;
						if($Obrefund->status == '1'){
							$refund->refunded_amount = $refundResponse->amount / 100;
							$message 		= "Refund process has been completed on order Id #".$aOrder->id;
							$this->sendpushnotification($aOrder->cust_id,'user',$message);
						}
					}
				}
			}
			$refund->updated_at = date('Y-m-d H:i:s');
			$refund->save();
			$data = \DB::update("UPDATE abserve_order_details SET refund_id=$refund->id, refund_status='processed' WHERE id=".$aOrder->id);
		}
		return true;
	}*/

	// private function refund($order_id,$action = '')
	// {
	// 	$aOrder = OrderDetail::with('refund_info')->find($order_id);
	// 	$validStatus = ['0','6','pending'];
	// 	if(in_array($aOrder->status, $validStatus)){
	// 		if($aOrder->delivery_type == 'cashondelivery' && $aOrder->delivery == 'paid'){
	// 			if(empty($aOrder->refund_info)){
	// 				$fnName = $aOrder->delivery_type.'Refund';
	// 				$refundData = $this->$fnName($aOrder);
	// 				$this->updateRefundStatus($aOrder,'add',$refundData['refund'],$refundData['amount']);
	// 			} else {
	// 				$this->updateRefundStatus($aOrder,'update');
	// 			}
	// 		}
	// 	}
	// }

	// private function razorpayRefund($aOrder)
	// {
	// 	$api_key = RAZORPAY_API_KEYID;
 //        $api_secret = RAZORPAY_API_KEY_SECRET;
 //        $api = new Api($api_key, $api_secret);
	// 	$paymentId = $aOrder->payment_token;
	// 	$payment = $api->payment->fetch($paymentId);
	// 	$amount = $this->getRefundAmount($aOrder);
	// 	if($amount > 0){
	// 		$refund = $payment->refund(array('amount' => $amount));
	// 	} else {
	// 		$refund = '';
	// 	}
	// 	$data['refund'] = $refund;
	// 	$data['amount'] = $amount / 100;
	// 	return $data;
	// }

	function getRefundAmount($aOrder)
	{
		$amount =  0;
		if($aOrder->status == 'pending') {
			$amount =  $aOrder->grand_total;
		}
		return $amount * 100;
	}

	function updateRating(Request $request)
	{
		$rules['order_id'] = 'required';
		$rules['action'] = 'required|in:skip,update';
		if($request->input('action') !== null && $request->action == 'update'){
			$rules['rating'] = 'required';
// 			$rules['comments'] = 'required';
			$rules['boy_rating'] = 'required';
			// $rules['boy_comments'] = 'required';
		}

		$this->validateDatas($request->all(),$rules);

		$aUser = \Auth::user();

		$iOrderId = $request->order_id;
		$aOrder = OrderDetail::find($iOrderId);
		$status = 422;
		if(empty($aOrder) || $aOrder->cust_id != $aUser->id){
			$response['message'] = 'No such Order';
		} else {
			if($aOrder->status == '4'){
				$status = 200;
				$response['message'] = 'success';
				$aOrder->skip_status = '1';
				if($request->action == 'update'){
					$value['cust_id'] = $aUser->id;
					$value['res_id'] = $aOrder->res_id;
					$value['orderid'] = $aOrder->id;
					$value['rating'] = $request->rating;
					$value['comments'] = $request->comments;
					$insert=\DB::table('abserve_rating')->insert($value);

					$resRating = \AbserveHelpers::getOverallRating($aOrder->res_id);
					$restaurant = Restaurant::find($aOrder->res_id);
					$restaurant->rating = $resRating;
					$restaurant->save();
					
					$value['boy_id'] = $aOrder->boy_id;
					$value['rating'] = $request->boy_rating;
					// $value['comments'] = $request->boy_comments;
					$insert=\DB::table('abserve_rating_boy')->insert($value);
				}
				$aOrder->updated_at = date('Y-m-d H:i:s');
				$aOrder->save();
			} else {
				$response['message'] = 'You could update rating for completed orders only';
			}
		}
		return \Response::json($response);
	}

	function pushNotifyAdminPanel($id,$user,$message)
	{
		$this->sendpushnotification($id,$user,$message);
	}

	// Cron function start
	function everyminuteCron(Request $request)
	{
		$val['created_at'] = date('Y-m-d H:i:s');
		$cronid = \DB::table('cron_check')->insertGetId($val);
		$this->RazorpayPendingOrders();

    	$this->RestaurantStatusUpdate();

		$this->BoyStatusUpdate();

		//If partner didnt response to the order assigned to him, the order will be rejected automatically(time exceeds) 
    	$this->CronPartnerNoAction();

		//If boy didnt response to the order assigned to him, it will be rejected automatically(time exceeds) then search for another boy and assigned if available
		$this->CronBoyNoAction($request);   

    	//Send notification to partner if he didnt accept / reject until the waiting time gets over
    	$this->CronNotificationPartner();

    	//Send notification to boy if he didnt accept / reject until the waiting time gets over
    	$this->CronNotificationBoy();

    	//Search boy for accepted orders
    	$this->Cronnoboyfound($request);

    	//Search boy for accepted orders
    	// 	$this->CronNoOrderAction();

    	//Search boy for accepted orders
    	$this->CronLateDelivery($request);


		\DB::table('cron_check')->where('id',$cronid)->update(['end'=>1]);
	}

	private function RazorpayPendingOrders()
	{
		// Make pending orders to paid state from the razorpay status
		$aOrder	= OrderDetail::where('status','pending')->where('delivery','unpaid')->where('delivery_type','razorpay')->whereRaw('date(now()) = date(created_at)')->get();
		$res	= '';
		if(count($aOrder) > 0){
			foreach ($aOrder as $key => $value) {
				$checkcon	= new checkcon;
				$data		= $checkcon->orderPayHandler($value->orderid);
				if($data['status'] != 200 && $data['doRefund']){
					$this->webhokCancellation($aOrder);
				}
			}
		} else {
			$res = '';
		}
		$res .= '';
		return $res;
	}

	private function webhokCancellation($aOrder)
	{
		$aOrder->append('restaurant_info');
		$order			= OrderDetail::find($aOrder->id);
		$orderPartner	= Orderdetails::where('orderid',$aOrder->id)->first();
		$order->status	= '5';
		$cancelled_by	= 'system';
		$order->cancelled_by = $cancelled_by;
		//$this->refund($order->id,$cancelled_by);
		$order->save();

		$orderPartner->order_status = '5';
		$orderPartner->save();
		$user	= User::find($order->cust_id,['id','penalty']);
		$user->penalty = $user->penalty + $order->penalty;
		$user->save();
		
		$message	= 'Your order #'.$aOrder->id.' cancelled due to payment delay. We will refund your amount if deducted, you will receive amount within 5-7 business working days';
		$this->sendpushnotification($aOrder->cust_id,'user',$message);
	}

	private function updateRefundStatus($aOrder,$action,$refundResponse='',$toRefundAmount=0)
	{
		if (!empty($refundResponse)) {
			if ($action == 'add') {
				$refund			= new OrderRefund;
				$refund->order_id			= $aOrder->id;
				$refund->payment_order_id	= $aOrder->orderid;
				$refund->payment_id			= $aOrder->payment_token;
				$refund->refund_amount		= $toRefundAmount;
				$refund->refund_id			= $refundResponse->id;
				$refund->refunded_amount	= $refundResponse->status == '1' ? ($refundResponse->amount / 100) : 0;
				$refund->refund_currency	= $refundResponse->currency;
				$refund->refund_status		= $refundResponse->status;
				$refund->created_at			= date('Y-m-d H:i:s');
			} else {
				$refund = OrderRefund::find($aOrder->refund_info->id);
				if($aOrder->delivery_type != 'cashondelivery'){
					if($aOrder->delivery_type == 'razorpay'){
						$paymentId	= $refund->payment_id;
						$refundId	= $refund->refund_id;

						$api_key	= RAZORPAY_API_KEYID;
						$api_secret	= RAZORPAY_API_KEY_SECRET;
						$api		= new Api($api_key, $api_secret);
						$Obrefund	= $api->payment->fetch($paymentId)->refunds()->items[0];

						$refund->refund_status = $Obrefund->status;
						if($Obrefund->status == '1'){
							$refund->refunded_amount = $refundResponse->amount / 100;
							$message	= "Refund process has been completed on order Id #".$aOrder->id;
							$this->sendpushnotification($aOrder->cust_id,'user',$message);
						}
					}
				}
			}
			$refund->updated_at	= date('Y-m-d H:i:s');
			$refund->save();
			$data = \DB::update("UPDATE abserve_order_details SET refund_id = $refund->id, refund_status = 'processed' WHERE id = ".$aOrder->id);
		}
		return true;
	}

	/*private function refund($order_id,$action = '')
	{
		$aOrder	= OrderDetail::with('refund_info')->find($order_id);
		$validStatus	= ['0','6','pending'];
		if(in_array($aOrder->status, $validStatus)){
			if($aOrder->delivery_type != 'cashondelivery' && $aOrder->delivery == 'paid'){
				if(empty($aOrder->refund_info)){
					$fnName		= $aOrder->delivery_type.'Refund';
					$refundData	= $this->$fnName($aOrder);
					$this->updateRefundStatus($aOrder,'add',$refundData['refund'],$refundData['amount']);
				} else {
					$this->updateRefundStatus($aOrder,'update');
				}
			}
		}
	}*/

	private function CronBoyNoAction(Request $request)
	{
		$getOrders = Deliveryboyneworder::where('status','Pending')->whereRaw("TIMESTAMPDIFF(second,create_at, CONVERT_TZ(UTC_TIMESTAMP,'+00:00','+05:30')) > ".CNF_BOY_WAIT_TIME)->get();
		foreach ($getOrders as $key => $value) {
			// $time = time() - strtotime($value->create_at);
			// if($time > CNF_BOY_WAIT_TIME){ // 10 mins
				$val['status']		= 'NotRespond';
				$val['update_at']	= date('Y-m-d H:i:s');
				Deliveryboyneworder::where('id',$value->id)->update($val);
				$this->sendRequestToBoy($request,$value->order_id);
				Deliveryboy::where('id',$value->boy_id)->update(['boy_status' => '0']);
				/* socket emited for not responding boy */
				$boy_Arr[]		= $value->boy_id;
				if (!empty($boy_Arr)) {
					if (SOCKET_ACTION == 'true') {
						require_once SOCKET_PATH;
						$orderDetails	= OrderDetail::select('res_id','cust_id','partner_id')->where('id',$value->order_id)->first();
						$aData		= array(
							'customer_id'	=> $orderDetails->cust_id,
							'partner_id'	=> $orderDetails->partner_id,
							'order_id'		=> $value->order_id,
							'boy_id'		=> $boy_Arr
						);
						try {
							$client->emit('partner accepted', $aData);
						} catch(\Exception $e) {
							$error_msg	= 'Some thing went worng,try again after some times';
						}
					}
				}
				/* socket emited for not responding boy end */
			// }
		}
	}

	private function CronPartnerNoAction()
	{
		$aOrder = OrderDetail::where('status','0')
		->whereRaw("TIMESTAMPDIFF(minute,created_at, CONVERT_TZ(UTC_TIMESTAMP,'+00:00','+05:30')) > ".CNF_PARTNER_WAIT_TIME)
		->get()->map(function($result){
			$result->append('restaurant_info');
			return $result;
		});

		if(count($aOrder)>0){	
			foreach ($aOrder as $key => $value) {
				\AbserveHelpers::Refund($value,'autoreject');
				\DB::table('abserve_order_details')->where('id',$value->id)->update(['status'=>'5','cancelled_by'=>'res_acc']);
				// CUTOMER NOTIFICATION
				$message    = "Shop unable to accept your order at the moment"; 
				$this->sendpushnotification($value->cust_id,'user',$message);                

				$data=array('order_id'=>$value->id,
					'res_name'=>$value->restaurant_info->name,
					'reason'=>'Your order was not successful because the shop is unable to accept your order at the moment. Please try again later. We apologize for the inconvenience caused.');
				$subject='Order Cancelled';
				$emailcon = new emailcon;
				$emailcon->sendEmail($value->user_info->email,$subject,'emails.order.cancel_mail',$data); 

				//Notify customer and partner through socket
				if(SOCKET_ACTION == 'true'){
					require_once SOCKET_PATH;
					$aData = array(
						'partner_id' => $value->partner_id,
						'customer_id' => $value->cust_id,
						'order_id' => $value->id
						);
					$client->emit('partner not accepted', $aData);
				}              
			}
		}
		return "Success";
	}

	private function CronNotificationPartner()
	{
		$aOrder = OrderDetail::
					whereRaw("  `status` = '0' AND ( (`delivery_type` = 'cashondelivery' && `delivery` = 'unpaid') OR (`delivery_type` != 'cashondelivery' && `delivery` = 'paid') )  ")
					->get();

		foreach ($aOrder as $key => $value) {
			$message    = "New orders found in your shop";
			$this->sendpushnotification($value->partner_id,'user',$message);         
		}

		return "Success";
	}

	private function CronNotificationBoy()
	{
		$aOrder = OrderDetail::select('abserve_order_details.*','boyOrders.boy_id as boy')
		->join('delivery_boy_new_orders as boyOrders','boyOrders.order_id','=','abserve_order_details.id')
		->where('abserve_order_details.status','1')
		->ORwhere('abserve_order_details.status','6')
		->where('boyOrders.status','Pending')
		->orderBy('abserve_order_details.id','DESC')
		->get();
		if(count($aOrder) > 0){
			foreach ($aOrder as $key => $value) {            
				$message    = "Hi One order has been placed. If you are available, please accept this order now.";
				$this->sendpushnotification($value->boy,'delivery',$message);
			}
		}

		return "Success";
	}

	private function Cronnoboyfound(Request $request)
	{
		// Assing delivery boy for pending orders
		$aOrder = OrderDetail::where('status','6')->get();
		$res = '';
		if(count($aOrder) > 0){
			foreach ($aOrder as $key => $value) {
				$find_boy = $this->sendRequestToBoy($request,$value->id);
				if($find_boy != 0){
					$order = OrderDetail::find($value->id);
					$orderPartner = OrderDetails::where('orderid',$value->id)->first();
					$order->status = '1';
					$order->accepted_time = time();
					$order->save();

					// $orderPartner->order_status = '1';
					// $orderPartner->order_accepted_time = time();
					// $orderPartner->save();
					$res .= $value->id.' Order assigned<br>';
				}else{
					$res .= 'No boy found<br>';
				} 
			}  
		}else{
			$res = 'All well';
		}   
		$res .= ' - Assingn boy';
		return $res;
	}

	public function assignordertoboy(Request $request)
	{
		$orderid = $request->orderid;
		// Assing delivery boy for pending orders
		$aOrder = OrderDetail::where('status','6')->get();
		$res = array();
		if(count($aOrder) > 0){
			foreach ($aOrder as $key => $value) {
				$find_boy = $this->sendRequestToBoy($request,$value->id);
				if($find_boy != 0){
					$order = OrderDetail::find($value->id);
					$orderPartner = OrderDetails::where('orderid',$value->id)->first();
					$order->status = '1';
					$order->accepted_time = time();
					$order->save();
					$res[] = $value->id;
				}
			} 
			if(in_array($orderid, $res)){
				$result = "success";
			}else{
				$result = "no boy found";
			} 
		}
		else{
			$result = "all order assigned";
		}
		$order = OrderDetail::find($orderid);
		if($order != ''){
			$abserve_deliveryboys=\DB::table('tb_users')->select('username','phone_number')->where('id',$order->boy_id)->first();
			$boyassignedid = \DB::table('delivery_boy_new_orders')->select('boy_id')->where('order_id',$request->orderid)->where('status','Pending')->first();
			if($abserve_deliveryboys != ''){
				$response['boy_detail']['username'] = $abserve_deliveryboys->username != '' ?(string) $abserve_deliveryboys->username :'';
				$response['boy_detail']['phone_number'] = $abserve_deliveryboys->phone_number != '' ? (string) $abserve_deliveryboys->phone_number :'';
			}
			if($boyassignedid != ''){
				$abserve_deliveryboys=\DB::table('tb_users')->select('username','phone_number')->where('id',$boyassignedid->boy_id)->first();
				$response['boy_detail']['username'] = $abserve_deliveryboys->username != '' ?(string) $abserve_deliveryboys->username :'';
				$response['boy_detail']['phone_number'] = $abserve_deliveryboys->phone_number != '' ? (string) $abserve_deliveryboys->phone_number :'';
			}
			else{
				$response['boy_detail']['username'] = $response['boy_detail']['phone_number'] ='';
			}
		}
		$response['message'] = $result;
		$status = 200;
		return \Response::json($response,$status);
	}

	private function CronNoOrderAction()
	{
		$getOrders = \DB::table('abserve_order_details')
						->select('id',\DB::raw("TIMESTAMPDIFF(second, created_at, CONVERT_TZ(UTC_TIMESTAMP,'+00:00','+05:30'))"))
				// 		->whereIn('status',["1","2","3","6"])
						 ->whereRaw("`status` in (1, 2, 3, 6) ")
						->whereRaw("TIMESTAMPDIFF(second, created_at, CONVERT_TZ(UTC_TIMESTAMP,'+00:00','+05:30')) > ".CNF_BOY_WAIT_TIME)
						->get();
		if(count($getOrders) > 0){
			foreach ($getOrders as $key => $value) {
				//\DB::table('abserve_orders_partner')->where('orderid',$value->id)->update(['order_status'=>'5']);
				$boyorder = \DB::table('abserve_orders_boy')->where('orderid',$value->id)->first();
				$boyneworder = \DB::table('delivery_boy_new_orders')->where('order_id',$value->id)->orderBy('id','desc')->first();
				$boy_id = $value->boy_id > 0 ? $value->boy_id : (!empty($boyorder) ? $boyorder->boy_id : (!empty($boyneworder) ? $boyneworder->boy_id : '' ) );
				\DB::table('abserve_orders_boy')->where('orderid',$value->id)->update(['order_status'=>'5']);
				\DB::table('delivery_boy_new_orders')->where('order_id',$value->id)->update(['status'=>'Rejected']);
				if($boy_id != ''){
					\DB::table('abserve_deliveryboys')->where('id',$boy_id)->update(['boy_status'=>'0']
						);
				}
				\DB::table('abserve_order_details')->where('id',$value->id)->update(['status'=>'5','cancelled_by'=>'res_acc']);
			}
		}
	}

	private function CronLateDelivery(Request $request)
	{
		$getOrders = \DB::table('abserve_order_details')
		->select('id',\DB::raw('later_deliver_date','later_deliver_time'))
		->where('delivery_preference','later')
		->where('status','1')
		->whereRaw("TIMESTAMPDIFF(minute, CONVERT_TZ(UTC_TIMESTAMP,'+00:00','+05:30') , later_delivery_timestamp) < ".CNF_LATER_ORDER_TIME)
		->get();
		$response1  = $this->sendRequestToBoy($request,$request->order_id);
		if($response1 != 0) {
			$response['message'] = "Order accepted and assigned to delivery boy";
		} else {
			$response['message'] = "Order accepted and waiting for delivery boy";
		}
	}

	static function BoyStatusUpdate()
	{
		// $boys = \DB::table('tb_users')->select('SELECT tb_users.`id` FROM `tb_users` WHERE `boy_status` = "1" AND tb_users.active = 1 AND tb_users.online_sts = 1 AND (SELECT COUNT(`id`) FROM `abserve_order_details` WHERE (`status` = "2" OR `status` = "3") AND `boy_id` = tb_users.`id`) = 0')->update(['boy_status'=>'0']);
	}

	static function RestaurantStatusUpdate($res_id='')
	{
		$select = ['id','name','location','logo','partner_id','delivery_time','budget','rating','res_desc','mode','cuisine','minimum_order','free_delivery','city','l_id'];
		$query = \AbserveHelpers::getRestaurantBaseQuery($select,'showAll');
		if($res_id != null && $res_id)
		{
			$query = $query->where('id',$res_id);
		}
		$result = $query->get();
		foreach($result as $keys => $res)
		{
			$res_timeValid = 0;
			$text = '';
			$res_id = $res->id;
			$resMode = $res->mode;
			$location = \DB::table('location')->where('id',$res->l_id)->first();
			if($resMode && $resMode =='open' && !empty($location) && $location->emergency_mode == 'off'){
				$currentDay=date('D');
				$dayofweek = date('w');
				$dayofweek = $dayofweek == 0 ? 7 : $dayofweek;
				$aDayInfo = \DB::table('abserve_days')->select('*')->where('value',$currentDay)->first();
				$resInfo = RestaurantTiming::where('res_id',$res_id)->where('day_id',$dayofweek)->first();
				$today = date("Y-m-d");
				$unavailable_date = \DB::table('abserve_restaurant_unavailable_date')->where('res_id','=',$res_id)->where('date',$today)->first();
				$text = 'find_next';
				if($unavailable_date =='' ){
					$text = 'Unavailable';
					if(!empty($resInfo)){
						$text = 'find_next';
						$dayStatus=$resInfo->day_status;
						if($dayStatus==1) {
							// $text = 'Available';
							if($resInfo->start_time1 != '' && $resInfo->end_time1 != ''){
								$text = 'Available';
								$aStart1 = \DB::table('abserve_time')->where('name','like',$resInfo->start_time1)->first();
								$aEnd1   = \DB::table('abserve_time')->where('name','like',$resInfo->end_time1)->first();
								$aStart2 = \DB::table('abserve_time')->where('name','like',$resInfo->start_time2)->first();
								$aEnd2   = \DB::table('abserve_time')->where('name','like',$resInfo->end_time2)->first();
								$curMin = (date('H') * 60 ) + date('i');
								$s1 = (!empty($aStart1)) ? $aStart1->time : 0; $e1 = (!empty($aEnd1)) ? $aEnd1->time : 0;
								$s2 = (!empty($aStart2)) ? $aStart2->time : 0; $e2 = (!empty($aEnd2)) ? $aEnd2->time : 0;
								if($s1 == '0' && $e1 == '0'){
									$res_timeValid=1;
								}elseif($s1 <= $curMin && $e1 >= $curMin){
									$res_timeValid=1;
								} elseif ($s2 <= $curMin && ( $e2 >= $curMin || ($e2 == '0' && $s2 > '0') )) {
									$res_timeValid=1;
								} 
							}
						}
					}
				}
			}
			Restaurant::where('id',$res_id)->update(['show'=>$res_timeValid]);
		}
	}

	//User Request RefundOrder
	public function UserRequestRefundOrder(Request $request)
	{
		$response_status   = 403;
		$rules['order_id'] = 'required|exists:abserve_order_details,id';
		$rules['reason']   = 'required';
		$rules['comment']  = 'required';
		$rules['image']    = 'required';
		$rules['image.*']  = 'mimes:jpeg,jpg,png|max:10240';
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {
			$oId = $request->order_id;
			$order	= OrderDetail::find($oId);
			if ($order->order_type == 'Initial') {
				$order->refund_reason = $request->reason;
				$order->refund_comment = $request->comment;
				$dataFile = array();
				if($request->hasfile('image')) {
					foreach($request->file('image') as $fKey => $file) {
						$document = $file;
						$filename = time().'-'.($fKey+1).'.'.$document->getClientOriginalExtension();
						$destinationPath = base_path('uploads/refund/'.$oId);
						$document->move($destinationPath, $filename);
						$dataFile[] = $filename;
					}
				} 
				$boy_image = array();
				$boy_image['refund_image'] = $dataFile;
				$order->refund_image	    = json_encode($boy_image);  
				$order->refund_status    = 'Customer Requested';
				$order->order_type       = 'Refund';
				$order->save();
				// $orderstat = new Orderstatustime;
				// $orderstat->order_id = $order->id;
				// $orderstat->status = 'Boy Requested';
				// $orderstat->created_at = date('Y-m-d H:i:s');
				// $orderstat->updated_at = date('Y-m-d H:i:s');
				// $orderstat->save();
				$response_status        = 200;
				$response['id']			= '1';
				$response["status"]		= 'success';
				$response['order_type']	= $order->order_type;
				$response["message"]	   = 'Refunded Request Successfully.Wait a moment support will response you.';

			}else{
				$response['id']			= '2';
				$response["status"]		= 'error';
				$response["message"]	   = 'Already Order Refunded';
			}

		} else {
			$messages				= $validator->messages();
			$error					= $messages->getMessages();
			$val					= $this->getStepvalidation($error);
			$response['id']			= '2';
			$response["status"]		= 'error';
			$response["message"]	= $val;
		}
		return \Response::json($response,$response_status);
	}


	public function UpdateRefundOrder(Request $request)
	{
		$response_status    = 503;
		$rules['user_type'] = 'required|in:user,delivery,Admin';
		$rules['order_id']  = 'required';
		$rules['comment']   = 'required';
		$rules['image']     = 'required';
		$rules['image.*']   = 'mimes:jpeg,jpg,png|max:10240';
		$validator = Validator::make($request->all(), $rules);

		if ($validator->passes()) {
			$oId = $request->order_id;
			$order	= OrderDetail::find($oId);
			if (!empty($order) && $order->status == '2') {
				$rOrder = RefundDetails::where('child_order',$oId)->first();
				$rOrder->boy_comment	 = $request->comment;
				$dataFile = array();
				if($request->hasfile('image'))
				{
					foreach($request->file('image') as $fKey => $file)
					{
						$document = $file;
						$filename = time().'-'.($fKey+1).'.'.$document->getClientOriginalExtension();
						$destinationPath = base_path('/uploads/refund/'.$rOrder->parent_order.'/boy');
						$document->move($destinationPath, $filename);
						$dataFile[] = $filename;
					}
				} 
				$boy_image = array();
				$boy_image['customer_image'] = $dataFile;
				$rOrder->boy_image	 = json_encode($boy_image);  
				
				$rOrder->save();

				$order->refund_status = 'Boy Requested';
				$order->save();

				// $orderstat = new Orderstatustime;
				// $orderstat->order_id = $order->id;
				// $orderstat->status = 'Boy Requested';
				// $orderstat->created_at = date('Y-m-d H:i:s');
				// $orderstat->updated_at = date('Y-m-d H:i:s');
				// $orderstat->save();

				$response_status        = 200;
				$response['id']			= '1';
				$response["status"]		= 'success';
				$response['order_type']			= $order->order_type;
				$response["current_status"]		= 'boyRequestAdminApprove';
				$response["message"]	= 'Details are updated.Wait a moment support will response you.';

			}else{
				$response['id']			= '2';
				$response["status"]		= 'error';
				$response["message"]	= 'Order not found';
			}

		} else {
			$messages				= $validator->messages();
			$error					= $messages->getMessages();
			$val					= $this->getStepvalidation($error);
			$response['id']			= '2';
			$response["status"]		= 'error';
			$response["message"]	= $val;
		}
		return \Response::json($response,$response_status);
	}

	public function giverefund(Request $request)
	{

		$response = array();
		$rules = array();
		$rules['oId']              = 'required|exists:abserve_order_details,id';
		$rules['customer_comment'] = 'required';
		$rules['image']            = 'required';
		$rules['image.*']          = 'mimes:jpeg,jpg,png|max:10240';
		$rules['type']             = 'required';
		$rules['items']            = 'required';
		// $rules['items.*']          = 'array|in:abserve_order_items,id';

		$status = 503;
		$message = 'Service is not available at the moment please try later ...';
		$validate = Validator::make($request->all(), $rules);
		if ($validate->passes()) {
			$oId = $request->oId;
			$itemsCount = !empty($request->items) ? count($request->items) : 0;
			$checkCount = OrderItems::whereIn('id',$request->items)->where('orderid',$oId)->count();
			$message = 'Mismatch with our order items ...';
			if ($checkCount == $itemsCount) {			
				$response['oId'] = $oId;
				$user = \Auth::user();
				$submit = app('App\Http\Controllers\Front\OrdersController')->giveRefundCommon($request,$user);
				$message = $submit['message'];
				$status = $submit['status'];
			}
		}else{
			$message = $validate->errors()->first();
		}

		$sMessage = 'danger';
		if ($status == 200) {
			$sMessage = 'success';
		}
		$response['message'] = $message;
		$response['status'] = $status;
		return \Response::json($response,$status);
	}

	public function postReorder(Request $request)
	{
		$rules['id'] 		= 'required';
		$rules['status']    = 'required|in:confirmation,removecart';
		$message = 'failure';
		$this->validateDatas($request->all(),$rules);
		$detail   	 = OrderDetail::find($request->id);
		$items       = OrderItems::where('orderid',$detail->id)->get();
		$cur_res_id  = $detail->res_id;
		$pre_res_id  = Usercart::select('res_id')->where('user_id',$detail->cust_id)->first();
		if(!empty($pre_res_id->res_id) && ($cur_res_id != $pre_res_id->res_id && $request->status == 'confirmation')) { 
			$message = 'differ';
		} elseif(($cur_res_id == isset($pre_res_id->res_id)) || ($request->status == 'removecart' || $request->status == 'confirmation')) {
			$added = [];
			$i = 0;
			if(count($items)>0){
				foreach ($items as $key => $value) {
					$hotelitems  = Fooditems::where('restaurant_id',$detail->res_id)->where('food_item','like','%'.$value->food_item.'%')->where('item_status',1)->first();
					if(!empty($hotelitems)) {
						$i++;	
						$req = ["action" => "add","ad_id" => "","ad_type" => "","adon_details" => "","device_id" => "0","food_id" => $hotelitems->id,"otherCartClear" => "true","previousRestaurant" => "","previousRestaurantName" => "","user_id" => $detail->cust_id,"status" => "from_reorder","quantity" => $value->quantity];
						request()->merge($req);
						$cartaction = \App::call('App\Http\Controllers\Api\RestaurantController@cartAction');
						$added[] = ($cartaction->status() == 200) ? 1 : 0;
					} else {
						array_push($added, 0); 
					}
				}
				$message = (in_array(0, $added)) ? 'failure' : 'cartadded';
				if ($i == 0) {
					$message = 'failure no items';
				}
			}
		} 
		return Response::json(['res_status' => $message]);
	}

	/*public function count(Request $request)
	{
		$count= Deliveryboy::ordercount()->where('id','79')->count();
		echo "<pre>";print_r($count);exit;
	}*/

	public function cancel_order(Request $request)
	{
		$rules['device'] 		= 'required';
		$rules['order_id']    = 'required';
		$this->validateDatas($request->all(),$rules);
		// {"device":"android","group_id":"4","order_id":"1282","status":"5","type":"user","user_type":"user"}
		$auser = \Auth::user();
		$order = OrderDetail::find($request->order_id);
		$order->status = '5';
		$order->customer_status = 'Cancelled';
		$order->cancelled_by = 'customer';
		$order->save();
     
		if($order->delivery_type == 'razorpay'){

			$api_key	= RAZORPAY_API_KEYID;
			$api_secret	= RAZORPAY_API_KEY_SECRET;
			$api	= new Api($api_key, $api_secret);

			try {
          if (!empty($order->grand_total) && $order->grand_total > 0) {
              $paisa  = $order->grand_total * 100;
              $refund = $api->refund->create(array('payment_id' => $order->payment_token, 'amount'=>$paisa));
          } else {
              $refund = $api->refund->create(array('payment_id' => $order->payment_token));
          }
          
          $message = $refund->status;

          $order->refund_id   = $refund->id;
          $order->refund_order    = 'active';
          $order->save();

       
			$razorpay_payment_id = $order->payment_token;

			$aOrder = OrderDetail::with('refund_info')->find($request->order_id);

          if(empty($aOrder->refund_info)){
				  $razor	= $api->payment->fetch($razorpay_payment_id);
				  $refund         = new OrderRefund;
	           $refund->order_id           = $aOrder->id;
	           $refund->payment_order_id   = $aOrder->orderid;
	           $refund->payment_id         = $aOrder->payment_token;
	           $refund->refund_amount      = $order->grand_total;
	           $refund->refund_id          = $razor->id;
	           $refund->refunded_amount    = $razor->status == '1' ? ($razor->amount / 100) : 0;
	           $refund->refund_currency    = $razor->currency;
	           $refund->refund_status      = $razor->status;
	           $refund->created_at         = date('Y-m-d H:i:s');
	        }
            else{
                    $refund = OrderRefund::find($aOrder->refund_info->id);
                    if($aOrder->delivery_type != 'cashondelivery'){
                        if($aOrder->delivery_type == 'razorpay'){
                            $paymentId  = $refund->payment_id;
                            $refundId   = $refund->refund_id;
                            $api        = new Api($api_key, $api_secret);
                            $Obrefund   = $api->payment->fetch($paymentId)->refunds()->items[0];

                            $refund->refund_status = $Obrefund->status;
                            if($Obrefund->status == '1'){
                                $refund->refunded_amount = $refundResponse->amount / 100;
                                $message    = "Refund process has been completed on order Id #".$aOrder->id;
                               // $this->sendpushnotification($aOrder->cust_id,'user',$message);
                            }
                        }
                    }

            }

           $refund->updated_at = date('Y-m-d H:i:s');
           $refund->save();
            } 
            catch (Exception $e){
                $status  = false;
                $message = $e->getMessage();
            }

				// $amount = $razor->amount / 100;
				// $user = User::where('id', $auser->id)->first();
				// $exist_wallet = $user->customer_wallet;
				// $user->customer_wallet = $amount + $exist_wallet;
				// $user->save();

				// $currentDateTime = now();
				// $timeFormatted = $currentDateTime->format('h:i:s');

				// $wallet = new Wallet;
				// $wallet->user_id = $auser->id;
				// $wallet->amount  = $order->grand_total;
				// $wallet->title   = 'Cancel Order';
				// $wallet->type    = 'credit';
				// $wallet->balance = $user->customer_wallet;
				// $wallet->date    = date('Y-m-d');
				// $wallet->time    = $timeFormatted;
				// $wallet->save();

			// }
		}
		if($order->wallet_amount > 0){
			$user = User::where('id', $auser->id)->first();
			$exist_wallet = $user->customer_wallet;
			$user->customer_wallet = $order->wallet_amount + $exist_wallet;
			$user->save();

			$currentDateTime = now();
			$timeFormatted = $currentDateTime->format('h:i:s');

			$wallet = new Wallet;
			$wallet->user_id = $auser->id;
			$wallet->amount  = $order->grand_total;
			$wallet->title   = 'Cancel Order';
			$wallet->type    = 'credit';
			$wallet->balance = $user->customer_wallet;
			$wallet->date    = date('Y-m-d');
			$wallet->time    = $timeFormatted;
			$wallet->save();
		}
		$res = Restaurant::where('id', $order->res_id)->select('name')->first();
		$currentDateTime = now();
		$timeFormatted = $currentDateTime->format('h:i:s');
		$notification = \DB::table('user_notification')->insert([
			'user_id' => $auser->id,
			'notification' => 'Orders Cancelled!',
			'status' => 0,
			'content' => "You have cancelled an order at ".$res->name.". We apologize for your inconvenience. We will try to improve our service next time.",
			'date' => date('Y-m-d'),
			'time' => $timeFormatted
		]);

		$title = 'Cancel Order';
		$message = 'Your Order Cancelled Successfully!';
		// \AbserveHelpers::sendPushNotification($auser->mobile_token, $title, $message);
		$this->sendpushnotification($auser->id,'user',$message);

		$orderstat = new Orderstatustime;
		$orderstat->order_id = $order->id;
		$orderstat->status = '5';
		$orderstat->device = $request->device;
		$orderstat->created_at = date('Y-m-d H:i:s');
		$orderstat->updated_at = date('Y-m-d H:i:s');
		$orderstat->save();
		$response['message'] = 'Order Cancelled Successfully';
		return \Response::json($response,200);
	}

	public function partnerChangeStatus(Request $request)
	{
		$rules['device'] = 'required';
		$rules['order_id'] = 'required';
		$rules['status'] = 'required';
		$this->validateDatas($request->all(),$rules);
		$message = false;
		$partner_id = \Auth::user()->id;
		$order = OrderDetail::find($request->order_id);
		$res = Restaurant::find($order->res_id);
		$data['resLat'] = $res->latitude;
		$data['resLong'] = $res->longitude;
		$order->status = $request->status;
		if($request->status == 1){
			$order->customer_status = 'Cooking';
			$order->save();
			$boy_list = $this->sendOrderReqToBoy($order->id, $data);
			if(!empty($boy_list)){
				$boy_id = \DB::table('delivery_boy_new_orders')->select('boy_id')->where('order_id', $order->id)->where('status', 'pending')->get();
				$boys = [];
				foreach($boy_id as $bid){
					$Boys = \DB::table('tb_users')->where('id', $bid->boy_id)->select('username', 'phone_number')->first();
					$d_data['name'] = $Boys->username;
					$d_data['phone'] = $Boys->phone_number;
					array_push($boys, $d_data);
				}
				$response['Delivery_Boys'] = $boys;
			}
			$message = 'Order Accepted Successfully';
		}elseif($request->status == 3){
			$order->customer_status = 'Packing';
			$order->save();
			$message = 'Order Packed Successfully';
		}elseif($request->status == 5){
			$order->customer_status = 'Cancelled';
			$order->cancelled_by = 'restaurant';
			$order->save();
			$message = 'Order Cancelled Successfully';
		}
		$orderstat = new Orderstatustime;
		$orderstat->order_id = $order->id;
		$orderstat->status = $request->status;
		$orderstat->device = $request->device;
		$orderstat->created_at = date('Y-m-d H:i:s');
		$orderstat->updated_at = date('Y-m-d H:i:s');
		$orderstat->save();
		$response['message'] = $message;
		return \Response::json($response,200);
	}

	public function sendOrderReqToBoy($id, $data)
	{
		$maxDistance = 15;
		$restaurantLatitude = $data['resLat'];
		$restaurantLongitude = $data['resLong'];
		$del_boys = Deliveryboy::select('id', 'username')->where('d_active', 1)->where('boy_status','0')->where('mode', 'online')->where('online_sts', 1)->where('latitude', '!=', NULL)->where('longitude', '!=', NULL)->selectRaw('(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',[$restaurantLatitude, $restaurantLongitude, $restaurantLatitude])->having('distance', '<=', $maxDistance)->orderBy('distance', 'asc')->get();
		foreach($del_boys as $boys){
			$newOrder = \DB::table('delivery_boy_new_orders')->insert([
				'order_id' => $id,
				'is_rapido' => 'no',
				'boy_id' => $boys->id,
				'status' => 'pending'
			]); 
		}
		return $del_boys;
	}
}