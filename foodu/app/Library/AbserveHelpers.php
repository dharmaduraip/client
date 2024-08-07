<?php

use App\Models\Front\Restaurant;
use App\Models\Front\Location;
use App\Models\Front\Days;
use App\Models\Front\RestaurantTiming;
use App\Models\Front\Restaurantunavail;
use App\Models\Front\Blocks;
use App\Models\RiderLocationLog;
use App\Models\Foodcategories;
use App\Models\Front\Usercart;
use App\User;
use App\Models\Promocode;
use App\Models\Front\Fooditems;
use App\Models\OrderDetail;
use App\Models\OrderItems;
use Illuminate\Http\Request;
use App\Models\Hotelitems;
use App\Models\Deliverychargesettings;
use App\Models\Front\Offers;
use App\Models\OfferUsers;
use App\Http\Controllers\Front\FrontEndController;
use App\Http\Controllers\WalletController;
use Image as Image;
use App\Http\Controllers\Api\OrderController as ordercon;
use App\Http\Controllers\RazorpayPaymentController;
use App\Models\Partnerwallet;
use App\Models\Deliveryboywallet;

class AbserveHelpers
{
	public static function setCartCookie()
	{
		$cookie_name	= "mycart";
		$cart_cookie_val= uniqid();
		\Cookie::queue(\Cookie::make($cookie_name, $cart_cookie_val, 45000));
		return $cart_cookie_val;
	}

	public static function getDeliveryChargeForBoy($tot_km)
	{
		$api_settings= \DB::table('tb_settings')->select('delivery_boy_charge_per_km')->first();
		// $total_del_charge = ($tot_km*1000)/(1000*$api_settings->delivery_boy_charge_per_km);
		$total_del_charge = $tot_km * $api_settings->delivery_boy_charge_per_km;
		return $total_del_charge;
	}

	static function getStatusTiming($status)
	{
		$text = '';
		if($status == '0'){
			$text = 'Order Placed';
		} elseif($status == 'pending'){
			$text = 'Pending';
		} elseif($status == '1'){
			$text = 'Order Accepted';
		} elseif($status == '2'){
			$text = 'Rider Assigned';
		} elseif($status == '3'){
			$text = 'Handovered to rider';
		} elseif($status == 'Packing'){
			$text = 'Order Packed';
		} elseif($status == '4'){
			$text = 'Order Delivered';
		} elseif($status == '5'){
			$text = 'Rejected';
		} elseif($status == '6'){
			$text = 'No Rider found';
		} elseif($status == 'boyPicked'){
			$text = 'Rider Picked';
		} elseif($status == 'boyArrived'){
			// $text = 'Rider Arrived';
			$text = 'boy on the way';
		} elseif($status == 'Reached'){
			$text = 'Rider reached';
		} elseif($status == 'otpSend'){
			$text = 'delivery otp send';
		} elseif($status == 'otpVerify'){
			$text = 'delivery completed';
		}
		return $text;
	}

	public static function getuname($id)
	{
		$tb_users = DB::select("SELECT username FROM tb_users WHERE id ='". $id ."'");
		if ($tb_users) {
			return $tb_users[0]->username;
		}
			return "";
	}

	public static function getumobile($id)
	{
		$tb_users = DB::select("SELECT phone_number FROM tb_users WHERE id ='". $id ."'");
		if ($tb_users) {
			return $tb_users[0]->phone_number;
		}
		return "";	
	}

	static function getuemail($id)
	{
		$tb_users = DB::select("SELECT email FROM tb_users WHERE id ='". $id ."'");	
		if ($tb_users) {
			return $tb_users[0]->email;
		}
		return "";
	}

	public static function restsurent_name($id)
	{
		$res = \DB::table('abserve_restaurants')->select('name')->where('id',$id)->first();
		if ($res) {
			return $res->name;
		}
		return "";
	}

	static function getdateformat($value)
	{
		$date=date('d-m-Y', strtotime( $value));
		return $date;
	}

	public static function getOrderStatusTime($oid,$status)
	{
		$order_details = \DB::table('order_status_timing')->where('status','=',$status)->where('order_id','=',$oid)->first();
		return !empty($order_details) ? date('g:i A',strtotime($order_details->created_at)) : '';
	}

	public static function CurrencyValueBackend($value)
	{
		$currency_symbol=\Session::get('currency_symbol');
		if(\Session::has('currency')){
			
			return ($currency_symbol.' '.$value * \Session::get('currency_value'));
		} else {
			return ($currency_symbol.' '.$value * 1);
		}
	}

	public static function getRestaurantDetails($rid)
	{
		$gid = \Auth::user()->group_id;
		$res_call = 'false';
		if($rid != ''){
			$resinfo = Restaurant::find($rid);
			if(isset($resinfo) && !empty($resinfo)){
				$res_call_val = $resinfo->call_handling;
				if($gid == 1){
					if($res_call_val == 1)
						$res_call = 'true';
					else
						$res_call = 'false';
				} else {
					if($res_call_val == 1)
						$res_call = 'false';
					else
						$res_call = 'true';
				}
			}
		}
		return $res_call;
	}

	public static function getboyname($id)
	{
		$abserve_order_details=\DB::table('abserve_order_details')->select('boy_id')->where('id',$id)->first();
		if($abserve_order_details && $abserve_order_details->boy_id!=''){
			$abserve_deliveryboys=\DB::table('tb_users')->select('username')->where('id',$abserve_order_details->boy_id)->first();
			if($abserve_deliveryboys){
				return $abserve_deliveryboys->username;
			}else{
				return '';
			} 
		}else{
			$delivery_boy_new_orders=\DB::table('delivery_boy_new_orders')->select('boy_id')->where('order_id',$id)->orderBy('id','DESC')->first();
			if($delivery_boy_new_orders && $delivery_boy_new_orders->boy_id){
				$abserve_deliveryboys1=\DB::table('tb_users')->select('username')->where('id',$delivery_boy_new_orders->boy_id)->first();
				if(isset($abserve_deliveryboys1)){
					return $abserve_deliveryboys1->username;
				}else{
					return '';
				}
			}else{
				return '';
			}
			
		}
	}

	public static function approvedrestaurant()
	{
		$restaurants = \DB::table('abserve_restaurants')->select('id','name')->where('admin_status','approved')->where('status','1');
		if(\Auth::user()->group_id == "5"){
			$id = \Auth::user()->id;
			$partner_list	=  \SiteHelpers::managersPartner($id);
			if(!empty($partner_list))
			{
				$restaurants = $restaurants->whereIn('partner_id',$partner_list);
			}
		}
		$restaurants = $restaurants->get();
		return $restaurants;
	}

	public static function Partnerrestaurants($id)
	{
		$partner = \DB::table('abserve_restaurants')->select('name')->where('admin_status','approved')->where('status','1')->where('partner_id',$id)->pluck('name')->all();
		return implode(' | ', $partner);
	}

	public static function PartnerrestaurantId($id)
	{
		$partner = \DB::table('abserve_restaurants')->select('id')->where('admin_status','approved')->where('status','1')->where('partner_id',$id)->pluck('id')->all();
		return implode(' | ', $partner);
	}

	public static function Partnerpaidamount($id)
	{
		$payamount = Partnerwallet::where('partner_id', $id)->where('transaction_status','1')->sum('transaction_amount');
		$formattedAmount = number_format($payamount, 2);
		return $formattedAmount;
	}

	public static function Partnerpayableamount($id)
	{
		$payamount = Partnerwallet::where('partner_id', $id)->where('transaction_status','0')->sum('transaction_amount');
		$formattedAmount = number_format($payamount, 2);
		return $formattedAmount;
	}
	public static function PartnerpayableorderId($id)
	{
		$payamount = Partnerwallet::where('partner_id', $id)->where('transaction_status','0')->get();
		$orderIds = $payamount->pluck('order_id')->implode(',');
		return $orderIds;
	}

	public static function PartnerpayoutsStatus($id)
	{
		$payout_status = Partnerwallet::where('partner_id', $id)->where('transaction_status','0')->get();
		if (count($payout_status) > 0) {
			return "Not-paid";
		} else {
			return "Paid";
		}
	}

	public static function Delboypaidamount($id)
	{
		$payamount = Deliveryboywallet::where('del_boy_id', $id)->where('transaction_status','1')->where('transaction_type', 'credit')->sum('transaction_amount');
		$formattedAmount = number_format($payamount, 2);
		return $formattedAmount;
	}

	public static function Delboytoadminpaidamount($id)
	{
		$payamount = Deliveryboywallet::where('del_boy_id', $id)->where('transaction_status','1')->where('transaction_type', 'debit')->sum('transaction_amount');
		$formattedAmount = number_format($payamount, 2);
		return $formattedAmount;
	}

	public static function Delboypayableamount($id)
	{
		$payamount = Deliveryboywallet::where('del_boy_id', $id)->where('transaction_status','0')->where('transaction_type', 'credit')->sum('transaction_amount');
		$usedamount = Deliveryboywallet::where('del_boy_id', $id)->where('transaction_status', '1')->where('transaction_type', 'debit')->sum('wallet_amount');
		$payamount = $payamount - $usedamount;
		$payamount = ($payamount > 0) ? $payamount : 0;
		$formattedAmount = number_format($payamount, 2);
		return $formattedAmount;
	}

	public static function Delboytoadminpayableamount($id)
	{
		$amount = User::where('id', $id)->select('boy_cashIn_hand')->first();
		return $amount->boy_cashIn_hand;
	}

	public static function DeliveryboypayoutsStatus($id)
	{
		$payout_status = Deliveryboywallet::where('del_boy_id', $id)->where('transaction_status','0')->get();
		if (count($payout_status) > 0) {
			return "Not-paid";
		} else {
			return "Paid";
		}
	}

	public static function DelboypayableorderId($id)
	{
		$payamount = Deliveryboywallet::where('del_boy_id', $id)->where('transaction_status','0')->get();
		$orderIds = $payamount->pluck('order_id')->implode(',');
		return $orderIds;
	}

	public static function getBoyTravelledReport($oid)
	{
		/*$result['pickup'] = RiderLocationLog::where('order_id','=',$oid)->whereIn('order_status',['2','3'])->sum('distance') ?? 0;
		$result['delivery'] = RiderLocationLog::where('order_id','=',$oid)->whereIn('order_status',['boyPicked','boyArrived'])->sum('distance') ?? 0;
		$result['total']  = RiderLocationLog::where('order_id','=',$oid)->sum('distance') ?? 0;*/

		$result['pickup'] = RiderLocationLog::select('*')
		->from(DB::raw("( SELECT * FROM `abserve_rider_location_log`
			WHERE `order_id` = ".$oid." AND `order_status` in ('2','3') GROUP BY `created_at`,`order_status`,`latitude`) as `sub`"))
		->sum('distance') ?? 0;

		$result['delivery'] = RiderLocationLog::select('*')
		->from(DB::raw("( SELECT * FROM `abserve_rider_location_log`
			WHERE `order_id` = ".$oid." AND `order_status` in ('boyPicked','boyArrived') GROUP BY `created_at`,`order_status`,`latitude`) as `sub`"))
		->sum('distance') ?? 0;

		$result['total'] = RiderLocationLog::select('*')
		->from(DB::raw("( SELECT * FROM `abserve_rider_location_log`
			WHERE `order_id` = ".$oid." GROUP BY `created_at`,`order_status`,`latitude`) as `sub`"))
		->sum('distance') ?? 0;

		/*SELECT sum(`v`.`distance`) as aggregate FROM (SELECT * FROM `abserve_rider_location_log` WHERE `order_id` LIKE '1419' and `order_status` in ('boyPicked','boyArrived') group by `created_at`,`order_status`,`latitude` ) as `v` */

		return $result;
	}

	public static function location_list()
	{
		$location = \DB::table('location')->get();
		return $location;
	}

	public static function getCartCookie()
	{
		$cookie_name	= "mycart";
		if(\Cookie::has($cookie_name) && \Cookie::get($cookie_name) != null) {
			return  \Cookie::get($cookie_name);
		}
		return '';
	}

	public static function getBaseCurrencySymbol()
	{
		$baseCur = \DB::table('abserve_currency')->select('symbol')->where('base_currency',1)->first();
		return $baseCur->symbol == '&#8377;' ? '₹':$baseCur->symbol;
	}

	public static function menuNotificationUpdate($resId)
	{
		$exist = \DB::table('tb_notification')->where('userid',\Auth::user()->id)->where('url',$resId)->where('is_read','0')
		->where(function($query){
			$query->where('type','menuItem');
			$query->orWhere('type','menuItemPrice');
			return $query;
		})
		->exists();		
		if($exist == true){

			$time 	= date('Y-m-d h:i:s');

			$update = array(
				'is_read' => '1',											
				'updated_at' => $time						
				);

			\DB::table('tb_notification')->where('userid',\Auth::user()->id)->where('url',$resId)
			->where(function($query){
				$query->where('type','menuItem');
				$query->orWhere('type','menuItemPrice');
				return $query;
			})
			->update($update);

		}		

		return true;
	}

	// public static function gettimeval($res_id)
	// {
	// 	$res_timeValid	= 0;
	// 	$resMode		= Restaurant::find($res_id);
	// 	$locStatus		= new Location;
	// 	if(!empty($resMode) && $resMode->l_id != ''){
	// 		$locStatus	= $locStatus->where('id',$resMode->l_id);
	// 	} else {
	// 		return $res_timeValid;
	// 	}
	// 	$locStatus	= $locStatus->first();
	// 	$locSta		= ($locStatus->emergency_mode == 'on') ? 'close' : 'open';

	// 	if ($resMode && $resMode->mode == 'open' && $locSta == 'open') {
	// 		$aDayInfo	= Days::where('value',date('D'))->first();
	// 		$resInfo	= RestaurantTiming::where('res_id',$res_id)->where('day_id',$aDayInfo->id)->first();
	// 		$res_timeValid		= '1';
	// 	}
	// 	return $res_timeValid;
	// }

	public static function gettimeval($res_id){
		$res_timeValid = 0;
		$resMode = \DB::table('abserve_restaurants')->select('*')->where('id','=',$res_id)->first();

		/*if($resMode && $resMode->l_id!=''){
			$locStatus=\DB::table('location')->where('id',$resMode->l_id)->first();
			if( $locStatus->emergency_mode=='on'){
				$locSta='close';
			}else{
				$locSta='open';
			}
		}elseif(isset($resMode)){
			$locStatus=\DB::table('location')->where('name',$resMode->city)->first();
			if(isset($locStatus)){
				if( $locStatus->emergency_mode=='on'){
					$locSta='close';
				}else{
					$locSta='open';
				}
			}
		}*/

		if($resMode && $resMode->mode=='open'/* && $locSta=='open'*/){
			$currentDay=date('D');
			$aDayInfo = \DB::table('abserve_days')->select('*')->where('value',$currentDay)->first();
			$resInfo = \DB::table('abserve_restaurant_timings')->select('*')->where('res_id','=',$res_id)->where('day_id',$aDayInfo->id)->first();
			$today = date("Y-m-d");
			$unavailable_date = \DB::table('abserve_restaurant_unavailable_date')->where('res_id','=',$res_id)->where('date',$today)->first();
			$res_timeValid='0';
			if($unavailable_date =='' ){
				if($resInfo->start_time1 != '' && $resInfo->end_time1 != ''){
					$dayStatus=$resInfo->day_status;
					$aStart1 = \DB::table('abserve_time')->where('name','like',$resInfo->start_time1)->orWhere('name', '>=', $resInfo->start_time1)->first();
					$aEnd1   = \DB::table('abserve_time')->where('name','like',$resInfo->end_time1)->orWhere('name', '>=', $resInfo->end_time1)->first();
					$aStart2 = \DB::table('abserve_time')->where('name','like',$resInfo->start_time2)->first();
					$aEnd2   = \DB::table('abserve_time')->where('name','like',$resInfo->end_time2)->first();
					$ip = \AbserveHelpers::getUserIpAddr();
					//$ip == '103.113.190.1' && $res_id == '6' && $dayStatus==1
					if($dayStatus==1) {
						$curMin = (date('H') * 60 ) + date('i');
						$s1 = $aStart1->time; $e1 = $aEnd1->time;
						if(isset($aStart2) && isset($aEnd2)){
							$s2 = $aStart2->time; $e2 = $aEnd2->time;
						}
						if($s1 == '0' && $e1 == '0'){
							$res_timeValid='1';
						}elseif($s1 <= $curMin && $e1 >= $curMin){
							$res_timeValid='1';
						} elseif (isset($s2) && isset($e2) && $s2 <= $curMin && ( $e2 >= $curMin || ($e2 == '0' && $s2 > '0') )) {
							$res_timeValid='1';
						}
					}
				}

			}
		}
		return $res_timeValid;
	}

	public static function getCurrencySymbol()
	{
		if (\Session::has('currency_symbol')) {
			return \Session::get('currency_symbol');
		} else {
			$baseCur = \DB::table('abserve_currency')->select('symbol')->where('base_currency',1)->first();
			return $baseCur->symbol;
		}
	}

	public static function country()
	{
		return \DB::table('abserve_countries')->select('*')->get();
	}

	public static function blocks($id)
	{
		$return	= '';
		$blocks	= Blocks::find($id);
		if (!empty($blocks)) {
			return str_replace('baseurl', \URL::to(''), $blocks->template);
		}
	}

	public static function site_setting($select = '*')
	{
		return \DB::table('abserve_api_settings')->select($select)->where('id','1')->first();
	}

	public static function verifiedPhonenum($id)
	{
		$user	= \DB::table('tb_users')->where('id',$id)->first();
		if ($user) {
			return $user->phone_number;
		} else {
			return 0;
		}
	}

	public static function getCartItemCount()
	{
		$cartCount	= 0;
		$cookie_id	= (\AbserveHelpers::getCartCookie() != '') ? \AbserveHelpers::getCartCookie() : \AbserveHelpers::setCartCookie();
		$user_id	= (\Auth::check()) ? \Auth::user()->id : 0;
		$authid		= (\Auth::check()) ? \Auth::user()->id : $cookie_id;
		$cond		= (\Auth::check()) ? 'user_id' : 'cookie_id';
		$usercart	= Usercart::where($cond,$authid);
		$ucart		= clone ($usercart);
		$ucart		= $ucart->first();
		if (!empty($ucart)) {
			$res_timeValid		= \AbserveHelpers::gettimeval($ucart->res_id);
			if ($res_timeValid == 1) {
				$foods_items	= $usercart->where('res_id',$ucart->res_id)->get();
				$cartCount		= count($foods_items);
			}
		}
		return $cartCount;
	}

	public static function get_MolVcode($amount,$orderid)
	{
		$merchantID = "id";
		$verifykey = "key";
		$vcode= md5( $amount.$merchantID.$orderid.$verifykey );
		if(isset($vcode) && $vcode!=''){
			return $vcode;
		}else{
			return '';
		}
	}

	public static function getkm()
	{
		$abserve_api_settings=\DB::table('abserve_api_settings')->first();
		return round($abserve_api_settings->restaurant_distance);
	}

	public static function apiSettings()
	{
		return \DB::table('abserve_api_settings')->first();
	}

	public static function Refund($Order,$type)
	{
		$fund	= \AbserveHelpers::apiSettings()->fund_return_type;
		$amount= ($type == 'accept') ? ($Order->grand_total-$Order->accept_grand_total) : (($fund == 'refund') ? '' : $Order->grand_total);
		if ($fund	== 'refund') {
			$pay	= new RazorpayPaymentController;
			return $pay->refund($Order,$amount);
		} elseif ($fund == 'wallet') {
			$pay	= new WalletController;
			return $pay->wallet($Order,$amount);
		}
	}
	
	public static function getkmboy()
	{
		$abserve_api_settings=\DB::table('abserve_api_settings')->first();
		return round($abserve_api_settings->boy_distance*1.60934);
	}

	static function getValidationErrorMsg($validator)
	{
		$messages 	= $validator->messages();
		$error 		= $messages->getMessages();
		$val 		= 'Error';
		if(count($error) > 0){
			foreach ($error as $key => $value) {	
				$val= $value[0];
				break;		 	
			}
		}
		return $val;
	}

	static function getRestaurantBaseQuery($select='',$where='',$whereCondition='',$whereField='',$whereValues='')
	{
		$query = Restaurant::query();
		if ($select != '') {
			$query->select($select);
		}
		if (strpos($where, 'showAll') !== false) {
			$where = str_replace('showAll', '', $where);
		} else { 
			// $query->where('show','1');
		}
		if ($where != '') {
			if ($whereCondition != '') {
				$query->$where($whereField,$whereCondition,$whereValues);
			} else {
				$query->$where($whereField,$whereValues);
			}
		}
		$query->where('status','1')->where('admin_status','approved')->whereRaw('(SELECT COUNT(id) FROM abserve_hotel_items WHERE abserve_hotel_items.restaurant_id = abserve_restaurants.id AND abserve_hotel_items.del_status = 0 AND abserve_hotel_items.approveStatus = "Approved") > 0');
		return $query;
	}

	static function getAvailablePromos($user_id=0,$code='',$cartPrice='',$restaurant_id='',$promo_id = '',$loc='')
	{
		$promoMode = \AbserveHelpers::promoMode();
		if($promoMode == 'on'){
			if(!empty($restaurant_id)){
				$aRestaurant = \DB::table('abserve_restaurants')->where('id',$restaurant_id)->first();
				$aResid = [$restaurant_id,0];
				$aLocationIds = [$aRestaurant->l_id,0];
			} else {
				$aResid = [];
				$aLocationIds = [];
			}
			$locationDetail = \DB::table('location')->where('id',$loc)->first();
			$c_name=(isset($locationDetail) && $locationDetail->name !='') ? $locationDetail->name : '';
			$where = 'where';$whereCondition = '';$whereField = 'city';$whereValues = $c_name;
			$restaurantQuery = \AbserveHelpers::getRestaurantBaseQuery('',$where,$whereCondition,$whereField,$whereValues);
			$aRestaurant = $restaurantQuery->select(\DB::raw('GROUP_CONCAT(id) as res_ids'))->first();
			$aRestaurantid = explode(',', $aRestaurant->res_ids);
			$aRestaurantid = array_filter($aRestaurantid);
			$aResid = array_merge($aRestaurantid,$aResid);
			$curDay = date('Y-m-d');
			$query = Promocode::select('*')->where('promo_mode','on');
			if($promo_id != ''){
				$query->where('id',$promo_id);
			}
			if($loc != ''){
				array_push($aLocationIds, $loc);
			}
			if($code != ''){
				$query->where('promo_code',$code);
			}
			if(count($aResid) > 0 || count($aLocationIds) > 0){
		        $locResArr = array('location_ids_sql'=>$aLocationIds,'restaurant_ids_sql'=>$aResid);
		       
			    $location_ids_sql = $restaurant_ids_sql = "";
		        foreach ($locResArr as $key => $value) {
		        	$checkfield = $key == 'location_ids_sql' ? 'l_id' : 'res_id';
		        	if(count($value) > 0){
				        foreach ($value as $ikey => $ivalue) {
				        	if($ikey > 0){
				        		$$key .= " OR ";
				        	}
				        	$$key .= " FIND_IN_SET(".$ivalue.",".$checkfield.") ";
				        }
				    }
		        }
		        if($location_ids_sql == ''){
		        	$location_ids_sql = " (1)";
		        } else {
		        	$location_ids_sql = "( ".$location_ids_sql.") ";
		        }
		        if($restaurant_ids_sql == ''){
		        	$restaurant_ids_sql = " (1)";
		        } else {
		        	$restaurant_ids_sql = "( ".$restaurant_ids_sql.") ";
		        }
		        /*$query->where(function($subQuery) use($restaurant_ids_sql,$location_ids_sql){
		            $subQuery->whereRaw("(case when loc_res = 'loc' then ".$location_ids_sql." when  loc_res = 'res' then ".$restaurant_ids_sql." end)");
		        });*/
		    }
			$query->where('start_date','<=',$curDay)->where('end_date','>=',$curDay)->where('limit_count','>','0');
			if($user_id > 0){
				$query->where(function($subQuery) use($user_id){
					$subQuery->whereRaw('FIND_IN_SET(?,user_id)', [0])->orwhereRaw('FIND_IN_SET('.$user_id.',user_id)');
				});
				$query->whereRaw('(SELECT count(id) from abserve_order_details where abserve_order_details.coupon_id = abserve_promocode.id AND abserve_order_details.cust_id = '.$user_id.' AND abserve_order_details.status IN ("0","1","2","3","4") ) < usage_count');
			} else {
				$query->whereRaw('FIND_IN_SET(?,user_id)', [0]);
			}
			
			if($cartPrice != ''){
				$query->where(function($subQuery) use($cartPrice){
					$subQuery->where('min_order_value','0')->orWhere('min_order_value','<=',$cartPrice);
				});
			}
			$aPromocode = $query->get()->map(function ($result) use($user_id){
						       	$result->append('promo_code_text');
						       	$result->all_text_values = $result->getAllTextAttribute($user_id);
						       	return $result;
						    });
		} else {
			$aPromocode = [];
		}
		
		return $aPromocode;
	}

	static function getCurrentUserFieldVal(Request $request)
	{
		$user_id = 0;

		if($request->input('user_id') !== null && $request->user_id > 0){
			$iUserId = $request->user_id;
			$userCheck = \AbserveHelpers::userCheck($iUserId);
			if($userCheck){
				$user_id = $iUserId;
			}
		}

		$field = $user_id > 0 ? 'user_id' : 'cookie_id';
		$fieldVal = $user_id > 0 ? $user_id : $request->device_id;

		$data['field'] = $field;
		$data['fieldVal'] = $fieldVal;
		$data['user_id'] = $user_id;

		return $data;
	}

	static function userCheck($user_id/*,$group_id=4*/)
	{
		return User::where('id',$user_id)/*->where('group_id',$group_id)*/->where('active','1')->exists();
	}

	public static function promoMode()
	{
		$api_settings=\DB::table('abserve_api_settings')->select('promo_mode')->first();
		return $api_settings->promo_mode;
	}

	public static function CurrencyValue($value)
	{
		if(\Session::has('currency')){
			// echo "set session"; exit;
			return ((int)$value * \Session::get('currency_value'));
		} else {
			return ($value * 1);
		}
	}

	public static function getItemPriceWithComsn($hid,$adon_id='',$adon_type='')
	{
		$itemPriceWithOutOffer = $itemPriceWithOffer = 0;
		$item1 = \DB::table('abserve_hotel_items')->select('restaurant_id','price','selling_price','original_price')->where('id',$hid)->first();
		if($adon_type=='unit'){
			$item = \DB::table('tb_food_unit')->select('price','selling_price','original_price')->where('id',$adon_id)->first();
		}else if($adon_type=='variation'){
			$item = \DB::table('tb_food_variation')->select('price','selling_price','original_price')->where('id',$adon_id)->first();
		}else{
			$item = \DB::table('abserve_hotel_items')->select('restaurant_id','price','selling_price','original_price')->where('id',$hid)->first();
		}
		
		// print_r ($item); exit;
		if(isset($item) && !empty($item)){
			$resInfo = \DB::table('abserve_restaurants')->select('partner_id','offer')->where('id',$item1->restaurant_id)->first();
			// print_r ($resInfo); exit;
			if(isset($resInfo) && !empty($resInfo)){
				if($resInfo->offer > 0 && $resInfo->offer <= 100){
					$offerPercentage = $resInfo->offer / 100;
				} else {
					$offerPercentage = 0;
				}
				
				$itemPriceWithOutOffer = $item->original_price>0 ? $item->original_price : $item->price;
				$itemPriceWithOffer = $itemPriceWithOutOffer;

				// if(round($item->original_price) > 0){
					$itemPriceWithOffer = $item->selling_price;
				// }

			}
		}
		$data['itemPriceWithOffer'] = $itemPriceWithOffer;
		$data['itemPriceWithOutOffer'] = $itemPriceWithOutOffer;
		return $data;
	}

	public static function getNextItemTime($hid)
	{
		$text = '';
		$hotelitem = Fooditems::find($hid);
		$item=\DB::table('abserve_hotel_items')->select('item_status')->where('id',$hid)->get();
		$item1=$item[0]->item_status;
		if(isset($hotelitem) && !empty($hotelitem)){
			$cur_time = (int)date("Hi");
			$start 	= (int)($hotelitem->start_time1 != '') ? (date("Hi",strtotime($hotelitem->start_time1))) : '';
			$end 	= (int)($hotelitem->end_time1 != '') ? (date("Hi",strtotime($hotelitem->end_time1))) : '';

			$start2 	= (int)($hotelitem->start_time2 != '') ? (date("Hi",strtotime($hotelitem->start_time2))) : '';
			$end2 	= (int)($hotelitem->end_time2 != '') ? (date("Hi",strtotime($hotelitem->end_time2))) : '';
			if($hotelitem->item_status == 0){
				$text = 'Out of stock';
			}elseif($start != '' && $end != ''){
				if($start == $end){
					$text = 'Available';
				} else if($cur_time >= $start && $cur_time <= $end ){
					$text = 'Available';
				} else if($cur_time >= $start2 && $cur_time <= $end2 ){
					$text = 'Available';
				} else {
					if($cur_time < $start && $cur_time < $end){
						$text = 'Next available at '.date("g:i a",strtotime($hotelitem->start_time1)).' today';
					} else if($cur_time < $start2 && $cur_time < $end2){
						$text = 'Next available at '.date("g:i a",strtotime($hotelitem->start_time2)).' today';
					} else if(($cur_time > $start && $cur_time > $end) && ($cur_time > $start2 && $cur_time > $end2)) {
						$text = 'Next available at '.date("g:i a",strtotime($hotelitem->start_time1)).' tomorrow';
					}
				}
			}
		}
		return $text;
	}

	public static function getOverallRating($res_id)
	{
		$star_1 = \DB::select("SELECT count(rating)as rating1 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 1");
		$star_2 = \DB::select("SELECT count(rating)as rating2 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 2");
		$star_3 = \DB::select("SELECT count(rating)as rating3 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 3");
		$star_4 = \DB::select("SELECT count(rating)as rating4 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 4");
		$star_5 = \DB::select("SELECT count(rating)as rating5 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 5");

		$str_1 = $star_1[0]->rating1;
		$str_2 = $star_2[0]->rating2;
		$str_3 = $star_3[0]->rating3;
		$str_4 = $star_4[0]->rating4;
		$str_5 = $star_5[0]->rating5;
		$total_count = $str_5 + $str_4 + $str_3 + $str_2 + $str_1;
		$Rating = (($str_5 * 5) + ($str_4 * 4) + ($str_3 * 3) + ($str_2 * 2) + ($str_1 * 1));
		if($total_count == 0 || $Rating == 0) {
			$tot = 0;
		}
		else{
			$tot = ($Rating/$total_count);
		}
		$round_overall	= round($tot);
		return $round_overall;
	}

	public static function getRatingCount($res_id)
	{
		$star_1 = \DB::select("SELECT count(rating)as rating1 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 1");
		$star_2 = \DB::select("SELECT count(rating)as rating2 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 2");
		$star_3 = \DB::select("SELECT count(rating)as rating3 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 3");
		$star_4 = \DB::select("SELECT count(rating)as rating4 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 4");
		$star_5 = \DB::select("SELECT count(rating)as rating5 FROM `abserve_rating` WHERE `res_id` = ".$res_id." AND `rating` = 5");
		$str_1 = $star_1[0]->rating1;
		$str_2 = $star_2[0]->rating2;
		$str_3 = $star_3[0]->rating3;
		$str_4 = $star_4[0]->rating4;
		$str_5 = $star_5[0]->rating5;

		$total_count = $str_5 + $str_4 + $str_3 + $str_2 + $str_1;
		return $total_count;
	}

	public static function getUserIpAddr()
	{
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			// ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			// ip pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	static public function categoryList($id,$res_id,$status='')
	{
		$order_food 	= Hotelitems::select('*')->where('main_cat',$id)->where('restaurant_id',$res_id);
		if ($status == '') {
			$order_food = $order_food->where('approveStatus','Approved')->where('selling_price','>',0)->where('del_status','=',0)->orderBy('id');
		}
		$order_food = $order_food->get();
		return $order_food;
	}

	static function foodcheck($food_id,$ad_id='',$ad_type='')
	{
		if (\Auth::check()) {
			$userid = Auth::user()->id;
			if ($ad_id!='' && $ad_type!='') {
				$items = \DB::table('abserve_user_cart')->select(DB::raw('SUM(quantity) as total_quants'))->where('user_id',$userid)->where('food_id',$food_id)->where('adon_type',$ad_type)->where('adon_id',$ad_id)->get();
			} else {
				$items = \DB::table('abserve_user_cart')->select(DB::raw('SUM(quantity) as total_quants'))->where('user_id',$userid)->where('food_id',$food_id)->get();
			}
		} else {
			$cart_cookie_id	= (\AbserveHelpers::getCartCookie() != '') ? \AbserveHelpers::getCartCookie() : \AbserveHelpers::setCartCookie();
			if ($ad_id!='' && $ad_type!='') {
				$items = \DB::table('abserve_user_cart')->select(DB::raw('SUM(quantity) as total_quants'))->where('cookie_id',$cart_cookie_id)->where('food_id',$food_id)->where('adon_type',$ad_type)->where('adon_id',$ad_id)->get();
			} else {
				$items = \DB::table('abserve_user_cart')->select(DB::raw('SUM(quantity) as total_quants'))->where('cookie_id',$cart_cookie_id)->where('food_id',$food_id)->get();
			}
		}
		$quantity = $items[0]->total_quants;
		if (count($items)>0) {
			if($quantity != '')
				return $quantity;
			else 
				return 0;
		} else {
			return 0;
		}
	}

	public static function getItemTimeValid($hid)
	{
		$itemtimevalid = 0;
		if($hid != ''){
			$hid = (int)$hid;
			$iteminfo = Fooditems::find($hid);
			if(isset($iteminfo) && !empty($iteminfo)){
				if($iteminfo->item_status == 1){
					$date = new DateTime();
					$timeval1=(int)date("Hi ", time());
					$timeval2=(int)date("Hi ", strtotime($iteminfo->start_time1));
					$timeval3=(int)date("Hi ", strtotime($iteminfo->end_time1));
					$timeval4=(int)date("Hi ", strtotime($iteminfo->start_time2));
					$timeval5=(int)date("Hi ", strtotime($iteminfo->end_time2));


					if($timeval2!=$timeval3){
						// $itemtimevalid=$timeval1." || ".$timeval2." || ".$timeval3." || ".$timeval4." || ".$timeval5;
						if (($timeval1 > $timeval2 && $timeval1 < $timeval3) || ($timeval1 > $timeval4 && $timeval1 < $timeval5)) {
							$itemtimevalid = 1;
						} elseif(($timeval1 > $timeval2 && $timeval1 > $timeval3) || ($timeval1 > $timeval4 && $timeval1 > $timeval5) ) {
							if(($timeval3 >= 0 && $timeval3 < $timeval2) || ($timeval5 >= 0 && $timeval5 < $timeval4) ){
								$itemtimevalid = 1;
							}
						} 
					}else{
						$itemtimevalid = 1;
					}
				} 
			}
		}
		return $itemtimevalid;
	}

	public static function alert( $task , $message)
	{
		if($task =='error') {
			$alert ='
			<div class="alert alert-danger  fade in block-inner">
			<button data-bs-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-cancel-circle"></i> '. $message.' </div>
			';			
		} elseif ($task =='success') {
			$alert ='
			<div class="alert alert-success fade in block-inner">
			<button data-bs-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-checkmark-circle"></i> '. $message.' </div>
			';			
		} elseif ($task =='warning') {
			$alert ='
			<div class="alert alert-warning fade in block-inner">
			<button data-bs-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-warning"></i> '. $message.' </div>
			';			
		} else {
			$alert ='
			<div class="alert alert-info  fade in block-inner">
			<button data-bs-dismiss="alert" class="close" type="button"> x </button>
			<i class="icon-info"></i> '. $message.' </div>
			';			
		}
		return $alert;
	}

	public static function getTimeValids($res_id,$user_id)
	{
		$resInfo	= Restaurant::find($res_id);
		if (empty($resInfo)) {
			$data['restimevalid']	= 0;
			$data['itemtimevalid']	= 0;
			return $data;
		}
		$resInfo->append('availability');
		$res_timeValid	= $resInfo->availability['status'];
		$itemtimevalid	= 1;
		if ($res_timeValid == 1) {
			$carts = Usercart::where('res_id',$res_id)->where('user_id',$user_id)->get();
			if (count($carts) > 0) {
				foreach ($carts as $key => $cart) {
					$itemtimecheck = \AbserveHelpers::getItemTimeValid($cart->food_id);
					if($itemtimecheck != 1){
						$itemtimevalid = 0;
					}
				}
			}
		} else {
			$itemtimevalid = 0;
		}
		$data['restimevalid']	= $res_timeValid;
		$data['itemtimevalid']	= $itemtimevalid;
		return $data;
	}

	public static function wishcheck($resid)
	{
		$wishcheck = 'false';
		if(\Auth::check()){
			$authid = \Auth::user()->id;
			$wish = \DB::table('abserve_favourites')->select('id')->where('user_id',$authid)->where('resid',$resid)->first();
			if(isset($wish) && !empty($wish)){
				$wishcheck = 'true';
			}
		}
		return $wishcheck;
	}

	public static function getNextAvailableTimeRes($resId,$type='')
	{
		$text = '';
		$resInfo = Restaurant::find($resId);
		if($resInfo && $resInfo->l_id!=''){
			$locStatus=\DB::table('location')->where('id',$resInfo->l_id)->first();
			if( $locStatus->emergency_mode=='on'){
				$locSta='close';
			}else{
				$locSta='open';
			}
		}else{
			$locStatus=\DB::table('location')->where('name',$resInfo->city)->first();

			if( $locStatus->emergency_mode=='on'){
				$locSta='close';
			}else{
				$locSta='open';
			}
		}
		if($resInfo->mode=='open' && $locSta=='open'){
			$dayofweek = date('w');
			$today = date('Y-m-d');
			$unavailable_date = \DB::table('abserve_restaurant_unavailable_date')->where('res_id','=',$resId)->where('date',$today)->first();

			$resTiming = RestaurantTiming::where('res_id',$resId)->where('day_id',$dayofweek)->first();
			$text = 'find_next';
			if($unavailable_date == ''){
				$text = 'Unavailable';
				if(!empty($resTiming)) {
					$text = 'find_next';
					if($resTiming->day_status == 1) {
						$resAvailCheck = \AbserveHelpers::gettimeval($resId);
						$text = 'Available';
						if($resAvailCheck == '0'){
							$aStart1 = \DB::table('abserve_time')->where('name','like',$resTiming->start_time1)->first();
							$aEnd1   = \DB::table('abserve_time')->where('name','like',$resTiming->end_time1)->first();
							$aStart2 = \DB::table('abserve_time')->where('name','like',$resTiming->start_time2)->first();
							$aEnd2   = \DB::table('abserve_time')->where('name','like',$resTiming->end_time2)->first();
							$curMin = (date('H') * 60 ) + date('i');
							$s1 = (!empty($aStart1)) ? $aStart1->time : 0; $e1 = (!empty($aEnd1)) ? $aEnd1->time : 0;
							$s2 = (!empty($aStart2)) ? $aStart2->time : 0; $e2 = (!empty($aEnd2)) ? $aEnd2->time : 0;
							if($curMin < $s1 && $curMin < $e1){
								if($type==''){
									$text = 'Next Available at '.date('g:i a',strtotime($resTiming->start_time1)).' today';
								}else{
									$text = 'Available after '.date('g:i a',strtotime($resTiming->start_time1)).' today';
								}

							} else if($curMin < $s2 && ( $curMin < $e2 || $e2 == '0' )){
								if($type==''){
									$text = 'Next Available at '.date('g:i a',strtotime($resTiming->start_time2)).' today';
								}else{
									$text = 'Available after '.date('g:i a',strtotime($resTiming->start_time2)).' today';
								}

							} else {
								$text = 'find_next';
							}
						} 
					}
				}
			}

			if($text == 'find_next'){

				$days = array( '1' => 'Monday',
					'2' => 'Tuesday',
					'3' => 'Wednesday',
					'4' => 'Thuesday',
					'5' => 'Friday',
					'6' => 'Saturday',
					'7' => 'Sunday'						       
				);

				$nextdays = \AbserveHelpers::getnextdays(7);
				unset($nextdays[0]);

				foreach ($nextdays as $key => $value) { 
					$find = \DB::table('abserve_restaurant_timings')->where('res_id',$resId)->where('day_id',$value)->where('day_status',1)->first();
					if(isset($find) && !empty($find)){

						if($key == 1){
							$day = 'Tommorow';
						}else{
							$day = $days[$value];
						}

						if($find->start_time1 != ''){
							if($type==''){
								$text = 'Next Available at '.$day.' '.$find->start_time1; break;
							}else{
  								// $text = 'Available after '.$day.' '.$find->start_time1; break;
								if($day=='Tommorow'){
									$text = 'Available '.$day.' '.$find->start_time1; break;
								}else{
									$text = 'Available after '.$day.' '.$find->start_time1; break;
								}
							}

						}elseif($find->start_time2 != ''){
							if($type==''){
								$text = 'Next Available at '.$day.' '.$find->start_time2; break;
							}else{
								if($day=='Tommorow'){
									$text = 'Available '.$day.' '.$find->start_time2; break;
								}else{
									$text = 'Available after '.$day.' '.$find->start_time2; break;
								}
							}
						}
					}
				}			
				if($text == 'find_next'){
					$text = 'Unavailable';
				}			
			}
		}else{
			$text = 'Closed';
		}

		return $text;
	}

	public static function getnextdays($nextdays)
	{
		$day_num = array();
		$days = array( 'Mon' => '1',
					   'Tue' => '2',
				       'Wed' => '3',
				       'Thu' => '4',
				       'Fri' => '5',
				       'Sat' => '6',
				       'Sun' => '7'						       
					);
		$current_day = date('D');

		$day_num[] = $days[$current_day];

		for ($i=1; $i < $nextdays; $i++) { 
			$sigle_day = date('D', strtotime($current_day . ' +'.$i.' day'));
			$day_num[] = $days[$sigle_day];
		}       	        	  

		return $day_num;
	}

	static public function getStatusLabel($status)
	{
		if ($status == 1 ) {
			return "label-success";
		} elseif ($status == 2){
			return "label-primary";
		} elseif ($status == 3){
			return "label-info";
		} elseif ($status == 4){
			return "label-default";
		} elseif ($status == 5){
			return "label-danger";
		} elseif ($status == 6){
			return "label-danger";
		} elseif($status == 'Packing'){
			return "label-success";
		} elseif($status == 'boyPicked'){
			return "label-info";
		} elseif($status == 'boyArrived'){
			return "label-info";
		} else {
			return "label-primary";
		}
	}

	public static function getboyid($oid)
	{
		$order_details = '';
		$order_details = \DB::table('abserve_orders_partner')->where('orderid','=',$oid)->first();
		return $order_details;
	}

	public static function getMaxRadius()
	{
		return \AbserveHelpers::getkm() * 1.60934;
	}

	public static function site_setting1($select = '*',$res_id='')
	{
		if($res_id!=''){
			$dataRes = \DB::table('abserve_restaurants')->select('delivery_limit')->where('id',$res_id)->first();
			if($dataRes && $dataRes->delivery_limit>0){
				return $dataRes->delivery_limit;
			}else{
				$data = \DB::table('abserve_api_settings')->select('delivery_distance')->where('id','1')->first();
				return $data->delivery_distance;
			}
		}else{
			$data = \DB::table('abserve_api_settings')->select('delivery_distance')->where('id','1')->first();
			return $data->delivery_distance;
		}
	}

	public static function showUploadedFile($file,$path , $width = 50)
	{
		$files =  base_path(). $path . $file ;
		if(file_exists($files ) && $file !="") {
			$info = pathinfo($files);	
			if($info['extension'] == "jpg" || $info['extension'] == "jpeg" ||  $info['extension'] == "png" || $info['extension'] == "gif" || $info['extension'] == "JPG") 
			{
				$path_file = str_replace("./","",$path);
				return '<a title="Click to view" href="'.url( $path_file . $file).'" target="_blank" class="previewImage">
				<img src="'.asset( $path_file . $file ).'" border="0" width="'. $width .'" class="img-circle" /></a>';
			} else {
				$path_file = str_replace("./","",$path);
				return '<a title="Click to view" href="'.url($path_file . $file).'" target="_blank"> '.$file.' </a>';
			}
		} else {
			return "<img src='".asset('/uploads/images/no-image.jpg')."' border='0' width='".$width."' class='img-circle' />";
		}
	}

	public static function CurrencySymbol($value)
	{
		$currency_symbol='';
		if(\Session::has('currency')){
			$currency_symbol=\Session::get('currency_symbol');
			return ($currency_symbol.' '.$value);
		} else {
			return ($currency_symbol.' '.$value);
		}
	}

	public static function compressor($orgFile,$script=false)
	{
		try {
			$img = \Image::make($orgFile);
			if($img->filesize() > 1000000){
				if(strpos($img->mime(), 'png') !== false){
					$img->resize(500,500)->save($orgFile);
				}else{
					$img->save($orgFile,50);
				}
			}else{
				if(!$script){
					$img->save($orgFile,80);
				}
			}
		} catch (\Exception $e) {
			if($script){
				print_r($e->getMessage());
			}
		}
	}

	public static function processCURL($url = null, $data_to_process = null)
	{
		try {
			$razorpay_api_key = RAZORPAY_API_KEYID; //RAZORPAY_API_KEYID;
			$razorpay_secret_key = RAZORPAY_API_KEY_SECRET; //RAZORPAY_API_KEY_SECRET;
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => json_encode($data_to_process),
			));
			$headers[] = 'Accept: application/json';
			$headers[] = 'Content-Type: application/json';
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_USERPWD, $razorpay_api_key . ':' . $razorpay_secret_key);
			$response = curl_exec($curl);

			curl_close($curl);

			$decodeResponse = json_decode($response);

			if(isset($decodeResponse->error) && $decodeResponse->error->code=='BAD_REQUEST_ERROR'){
				throw new \Exception($decodeResponse->error->description);
			} else{
				$sendresponse['response'] = $response;
				$sendresponse['status'] = true;
			}

		} 

		catch (\Throwable $e) {
			$sendresponse['response'] = $e->getMessage();
			$sendresponse['status'] = false;
		}
		return $sendresponse;
	}

	static function getDeliveryCharge($distance)
	{
		$tb_settings	= \DB::table('tb_settings')->first();
		$f_del_charge		= $tb_settings->upto_four_km;
		if($distance <= $tb_settings->km){
            $add_del_charge		= 0;
			$boy_del_charge 	= $tb_settings->u_delivery_boy;
            $admin_del_charge 	= $tb_settings->u_admin;
		}else{
			$extraDistance 		= $distance - $tb_settings->km;
			$add_del_charge 	= $extraDistance * $tb_settings->per_km;
            $boy_del_charge 	= $tb_settings->u_delivery_boy + ($extraDistance * $tb_settings->p_delivery_boy);
            $admin_del_charge 	= $tb_settings->u_admin + ($extraDistance * $tb_settings->p_admin);
		}
		$data['delivery_charge'] = number_format(($add_del_charge + $f_del_charge),2,'.','');
		return $data;
	}

	public static function getMainCatName($rootid)
	{
		$mainCatName = '';
		$food_cat = Foodcategories::where('id',$rootid)->first();
		if(isset($food_cat) && !empty($food_cat)){
			if($food_cat->cat_name != '') 
				$mainCatName = $food_cat->cat_name;
		}
		return $mainCatName;
	}

	public static function restsurent_address($id)
	{
		$res = \DB::table('abserve_restaurants')->select('location')->where('id',$id)->first();
		if (isset($res->location)) {
		return $res->location;
		}
	}

	public static function auditTrail( $request , $note )
	{
		$data = array(
			'module'	=> $request->segment(1),
			'task'		=> $request->segment(2),
			'user_id'	=> \Session::get('uid'),
			'ipaddress'	=> $request->getClientIp(),
			'note'		=> $note
		);
		\DB::table( 'tb_logs')->insert($data);		
	}

	public static function addnotification( $request ,$url, $note )
	{
		$time 	= date('Y-m-d h:i:s');
		$data = array(
			'url'	=> $url,
			'userid'	=> \Session::get('uid'),
			'note'		=> $note,
			'created' => $time
		);
		\DB::table( 'tb_notification')->insert($data);		
	}

	public static function uCartQuery($user_id, $device_id)
	{
		return \DB::table('abserve_user_cart')
		->where(function($query) use ($user_id, $device_id) {
			if ($user_id == 0) {
				return $query->where('cookie_id', $device_id);
			} else {
				return $query->where('user_id', $user_id);
			}
		});
	}

	static function getDeliveryChargeValuesGrozo($distance=0, $restaurant, $itemTotal)
	{
		$badWeather	= $festival	= $delivery	= $package	= $chrgMin = $chrgMax = $maxDistance = $deliveryTax = $packageTax = $badWeatherTax	= $festivalTax	= $deliveryPercent = $packagePercent = $badWeatherPercent = $festivalPercent = 0;
		\DB::enableQueryLog();
		$chargeModel = Deliverychargesettings::where(function($squery) use ($itemTotal) {
			return $squery->where(function($squery) use ($itemTotal) {
				$squery->where('order_value_max', '>=', $itemTotal)->where('order_value_min', '<=', $itemTotal);
			})->orWhere(function($squery) use ($itemTotal) {
				$squery->where('order_value_type', 'above')->where('order_value_min', '<=', $itemTotal);
			});
		})->where('status','active');

		$charge			= clone ($chargeModel);
		$maxDistance	= clone ($chargeModel);
		$pCharge		= clone ($chargeModel);
		/* Delivery charge Begin */
		if ($distance > 0) {
			$dCharge		= $charge->where(function($query) use ($distance) {
				return $query->where(function($query) use ($distance) {
					$query->where('distance_min', '<=', $distance)->where('distance_max', '>=', $distance);
				})->orWhere(function($query) use ($distance) {
					$query->where('distance_type', 'above')->where('distance_min', '<=', $distance);
				});
			})->where('charge_type','delivery')->where('status','active');
			$chrgDetail		= clone ($dCharge);
			$chrgDetail		= $chrgDetail->get();
			$maxDistance	= $maxDistance->where('distance_type', 'above')->orderBy('id','Desc')->first(['distance_min'])->distance_min;
			if (!empty($chrgDetail)) {
				if (count($chrgDetail) > 1) {
					// $mCharge	= clone ($dCharge);
					$dCharge	= $dCharge->orderBy('charge_value', 'desc');
					// $mCharge	= $mCharge->orderBy('charge_value', 'asc')->first(['charge_value','tax']);
					// $chrgMin	= $mCharge->charge_value;
				}
				$dCharge	= $dCharge->first(['charge_value','tax']);
				$chrgMax	= $dCharge->charge_value;
			} else {
				$dCharge = [];
			}
			$aSettings	= \DB::table('tb_settings')->first();
			if (!empty($aSettings) && ($distance > $maxDistance)) {
				$extraDistance	= $distance - $maxDistance;
				$chrgMax		= $chrgMax + ($extraDistance * $aSettings->per_km);
			}
			if (!empty($dCharge)) {
				$delivery	= $chrgMax;
				$deliveryTax= $delivery * ($dCharge->tax / 100);
				$deliveryPercent = $dCharge->tax;
			}
		}
		/* Delivery charge End */
		/* Package charge Begin */
		$pCharge	= $pCharge->where('charge_type','package')->first(['charge_value','tax']);
		if (!empty($pCharge)) {
			$package	= $pCharge->charge_value;
			$packageTax = $package * ($pCharge->tax / 100);
			$packagePercent = $pCharge->tax;
		}
		/* Package charge End */
		/* Badweather & festival charge Begin */
		$aLocation	= \DB::table('location')->where('id',$restaurant->l_id)->first();
		if(!empty($aSettings) && !empty($aLocation)) {
			if($aLocation->bad_weather_mode == 'on') {
				$badWeather		= $aSettings->bad_weather_charge;
				$badWeatherTax	= $badWeather * (18 / 100);
				$badWeatherPercent = 18;
			}
			if($aLocation->festival_mode == 'on'){
				$festival		= $aSettings->festival_charge;
				$festivalTax	= $festival * (18 / 100);
				$festivalPercent = 18;
			}
		}
		/* Badweather & festival charge Begin */
		$data['delivery']		= $delivery;
		$data['deliveryPercent']= $deliveryPercent;
		$data['deliveryTax']	= $deliveryTax;
		$data['package']		= $package;
		$data['packagePercent']	= $packagePercent;
		$data['packageTax']		= $packageTax;
		$data['badWeather']		= $badWeather;
		$data['badWeatherPercent']	= $badWeatherPercent;
		$data['badWeatherTax']	= $badWeatherTax;
		$data['festival']		= $festival;
		$data['festivalPercent']= $festivalPercent;
		$data['festivalTax']	= $festivalTax;
		// print_r($data);exit;
		return $data;
	}

	static function getDeliveryChargeValues($distance=0, $restaurant, $itemTotal)
	{
		$badWeather	= $festival	= $delivery	= $package	= $chrgMin = $chrgMax = $maxDistance = $deliveryTax = $packageTax = $badWeatherTax	= $festivalTax	= $deliveryPercent = $packagePercent = $badWeatherPercent = $festivalPercent = $delCharge = 0;
		// print_r($distance);exit();
		/* Delivery charge Begin */
		if ($distance > 0) {
			$aSettings	= \DB::table('tb_settings')->first();
			if (!empty($aSettings)) {
				$delCharge		= $aSettings->upto_four_km;
				$deliveryPercent= $aSettings->delivery_tax;
				if (($distance > $aSettings->km)) {
					$extraDistance	= $distance - $aSettings->km;
					$delCharge		= $aSettings->upto_four_km + ($extraDistance * $aSettings->per_km);
				}
				if ($delCharge > 0) {
					$deliveryTax	= $delCharge * ($deliveryPercent / 100);
				}
			}
		}
		/* Delivery charge End */
		/* Badweather & festival charge Begin */
		$aLocation	= \DB::table('location')->where('id',$restaurant->l_id)->first();
		if(!empty($aSettings) && !empty($aLocation)) {
			if($aLocation->bad_weather_mode == 'on') {
				$badWeather		= $aSettings->bad_weather_charge;
			}
			if($aLocation->festival_mode == 'on'){
				$festival		= $aSettings->festival_charge;
			}
		}
		/* Badweather & festival charge Begin */
		$data['delivery']		= $delCharge;
		$data['deliveryPercent']= 0;
		$data['deliveryTax']	= 0;
		$data['badWeather']		= 0;
		$data['festival']		= 0;
		$data['badWeatherPercent']	= 0;
		$data['badWeatherTax']	= 0;
		$data['festivalPercent']= 0;
		$data['festivalTax']	= 0;
		$data['package']		= 0;
		$data['packagePercent']	= 0;
		$data['packageTax']		= 0;
		$data['res_id'] = $restaurant->id;
		return $data;
	}

	public static function Offerdata($userid,$orderAmount)
	{
		$wallet				= User::find($userid);
		$user_offer_wallet	= $wallet->offer_wallet;
		$offerData			= Offers::whereRaw('? between usage_from and usage_to', [date('Y-m-d')])->where('status','active')->first();
		$cash_offer			= 0;
		if (!empty($offerData) && $user_offer_wallet != '' && $user_offer_wallet > 0) {
			$cash_offer 	= ($offerData->usage_type == 'amount') ? $offerData->usage_value : $orderAmount * ( $offerData->usage_value / 100);
			if ($cash_offer >= $user_offer_wallet) {
				$cash_offer = $user_offer_wallet;
			}
		}
		$return['cashOffer']	= 0; $return['OfferName']	= '';
		if($orderAmount > 0 && $orderAmount >= $cash_offer && !empty($offerData)) {
			$return['cashOffer']  = $cash_offer;
			$return['OfferName']  = $offerData->name;
		}
		$return['cashOffer'] = number_format($return['cashOffer'],2,'.','');
		return $return;
	}

	public static function getOrderRating($rid)
	{
		$rating = 0;
		$authid = \Auth::user()->id;
		$ratingInfo = DB::table('abserve_rating')->where('res_id','=',$rid)->where('cust_id','=',$authid)->first();
		if(isset($ratingInfo) && !empty($ratingInfo)) {
			$rating = $ratingInfo->rating;
		}
		return $rating;
	}

	static public function GSTBifurcation($orderId)
	{
		$return		= [];
		$data	= OrderDetail::with('accepted_order_items')->find($orderId);
		$aItems = $data->order_items;
		if (count($aItems) > 0) {
			foreach($aItems as $val) {
				if($val['gst'] != 0){
				$return[$val['gst']]['gst'][] = ($val->check_status == 'yes') ? (($val->hiking_gst_price + $val->base_price_gst) * $val->quantity) : 0;
				$return[$val['gst']]['price'][] = ($val->check_status == 'yes') ? (($val->base_price+ $val->hiking_price ) * $val->quantity) : 0;
			}
			}
			return $return;
		}
		return [];
	}

	public static function getPromoUserCheck($cid,$uid)
	{
		$promo_status = 1;
		$promouser = \DB::table('abserve_promo_user_status')->select('*')->where('coupon_id',$cid)->where('user_id',$uid)->get();
		if(isset($promouser) && !empty($promouser)){
			$promo_status = 0;
		}
		return $promo_status;
	}

	public static function getPromoUserOrderCheck($cid,$uid)
	{
		$count = 0;
		$orderuser = \DB::table('abserve_order_details')->select('id')->where('coupon_id',$cid)->where('cust_id',$uid)->where('status','!=','5')->get();
		if(isset($orderuser) && !empty($orderuser)){
			$count = count($orderuser);
		}
		return $count;
	}

	public static function getOpenClosingStatus($resId,$dayofweek,$date)
	{
		date_default_timezone_set('ASIA/KOLKATA'); // timezone
		$returnText	= ''; $returnDiv = 'exc'; $returnTime = 0;
		$returnAvail= 'Available';
		$return		= array();
		$weekday	= date('l'); // today 
		// $dayofweek	= date("w");
		// if($dayofweek == 0) $dayofweek = 7;
		$unavailable	= \DB::table('abserve_restaurant_unavailable_date')->select('date')->where('res_id','=',$resId);
		$unavail		= clone $unavailable;
		$unavailable_date	= $unavailable->where('date',date('Y-m-d',strtotime($date)))->get();
		$unavailable_dates	= $unavail->get();
		$resTiming			= RestaurantTiming::where('res_id',$resId)->where('day_id',$dayofweek)->first();
		// print_r($unavailable_date);
		if(count($unavailable_date) == 0) {
			if(!empty($resTiming)) {
				// Opening and closing time for each day of the week
				$open1	= ($resTiming->start_time1) ? date("H:i", strtotime($resTiming->start_time1)) : '';
				$open2	= ($resTiming->start_time2) ? date("H:i", strtotime($resTiming->start_time2)) : '';
				$close1	= ($resTiming->end_time1) ? date("H:i", strtotime($resTiming->end_time1)) : '';
				$close2	= ($resTiming->end_time2) ? date("H:i", strtotime($resTiming->end_time2)) : '';
				// echo "<br>";
				// echo date("H:i")."<br>"; 
				// echo $open1.'==='.$close1.'<br>'; 
				// echo $open2.'==='.$close2.'<br>'; 

				if($resTiming->day_status != 0) {
					if (($open1 != '' || $open2 != '') && ($close1 != '' || $close2 != '')) {
						if($open1 == '00:00' && ($close1 == '23:59' || $close1 == '00:00')) {
							$returnText	= "Open 24x7";
							$returnDiv	= 'success';
							$returnTime = 1;
						} elseif((date("H:i") >= $open1 && date("H:i") <= $close1) || (date("H:i") >= $open2 && date("H:i") <= $close2)) {
							$returnTime = 1;
							if($close1 != '' && date("H:i") < $close1) {
								$returnText	= 'Closed at '.$resTiming->end_time1;
							} elseif ($close2 != '' && date("H:i") < $close2) {
								$returnText	= 'Closed at '.$resTiming->end_time2;
							}
						} /*else if (date("H:i") < $open_from || date("H:i") > $open_to ) {
							echo "Closed!"; // now check if the current time is before or after opening hours
						}*/ else { // hide the checkout button
							$returnAvail = 'Restaurant next available at ';
							if($open2 != '' && date("H:i") < $open2) {
								$returnText	= 'Opens next at '.$resTiming->start_time2;
								$returnAvail.=$resTiming->start_time2;
							} elseif ($open1 != '' && date("H:i") > $open1) {
								$returnText	= 'Opens next at tomorrow '.$resTiming->start_time1;
								$returnAvail.='tomorrow '.$resTiming->start_time1;
							} elseif ($open1 != '' && date("H:i") < $open1) {
								$returnText	= 'Open at '.$resTiming->start_time1;
								$returnAvail.=$resTiming->start_time1;
							}
						}
					} else { // show if timing is not set for this restaurant
						$returnText 	= 'Closed now';
						$returnAvail	= 'Restaurant not available now';
					}
				} else {
					$returnText 	= 'Closed Today';
					$returnAvail	= 'Restaurant not available today';
				}
			}
		} else {
			$returnText		= 'Closed Today';
			$returnAvail	= 'Restaurant not available today';
		}
		// echo 'rID ==== '.$resId.'<br> timevalid===='.$returnTime;
		$return['text']		= $returnText;
		$return['div']		= $returnDiv;
		$return['avail']	= $returnAvail;
		$return['timevalid']= $returnTime;
		$return['datesunavail']= $unavailable_dates;
		return $return;
	}

	public static function getCheckoutcartprice($user_id,$res_id,$orderinsert=false,$wallet_amount=0)
	{
		$response   = [];
		$device_id	= '';
		$stax1		= 0;
		$aUserCart	= Usercart::where('user_id',$user_id)->get();
		$iUserCart	= count($aUserCart);
		$html		= ''; $status = 422; $message = '';
		$unavailableFoodIds = '';
		if($iUserCart == 0 || ($orderinsert && $aUserCart[0]->address_id == 0)){
			$message = $iUserCart == 0 ? 'No items in cart' : 'Select Delivery Address';
		} else {
			// $select = ['id','name','logo','location','delivery_time','mode','minimum_order','free_delivery','l_id','service_tax1'];
			$where = 'where';$whereCondition = '';$whereField = 'id';$whereValues = $aUserCart[0]->res_id;
			$aRestaurant = \AbserveHelpers::getRestaurantBaseQuery('',$where,$whereCondition,$whereField,$whereValues)->first();
			if(empty($aRestaurant)){
				$message = 'Shop not found';
			} else {
				$aRestaurant->append('src','availability'/*,'manager_info'*/);	
				$validKm = \AbserveHelpers::site_setting1('delivery_distance');
				if($orderinsert && !$aRestaurant->availability['status']){
					$message = 'Shop not available';
				} elseif ($orderinsert && $aUserCart[0]->distance_km > $validKm) {
					$message = "Sorry we don't serve at your address currently.";
				} else {

					$aRestaurant->promo_status = $aRestaurant->getPromoCheckAttribute($user_id);
					$response['aRestaurant'] = $aRestaurant;
					$checkstatus = 1;
					$itemPrice = $itemOriginalPrice = $gst = 0;$aFoodIds = [];
					if($orderinsert){
						$aCartItems = [];$cartCnt = 0; $oHikingPrice = 0;				
					}
					$hostAmount = 0;
					foreach ($aUserCart as $key => $value) {
						$aFoodItem = Fooditems::where('id',$value->food_id)->where('restaurant_id',$aRestaurant->id)->where('del_status','0')->where('approveStatus','Approved')->first();
						if(!empty($aFoodItem)) {
							$aFoodItem->append('availability');
							if ($aFoodItem->item_status != 1) {
								$message = 'Some of your items not available now. Please change your order...';
								$checkstatus = 2;
								if($unavailableFoodIds != ''){
									$unavailableFoodIds .= ',';
								}
								$unavailableFoodIds .= $value->food_id;
							}
						} else {
							$message = 'Some of your items not available now. Please change your order...';
							$checkstatus = 0;
							if($unavailableFoodIds != ''){
								$unavailableFoodIds .= '';
							}
							$unavailableFoodIds .= $value->food_id;
						}
						if($orderinsert){
							// $original 	= ($aFoodItem->price / (100 + $aFoodItem->gst))*100;
							$original 	= $aFoodItem->selling_price;
							$aCartItems[$cartCnt]['food_id'] 		= $aFoodItem->id;
							$aCartItems[$cartCnt]['food_item'] 		= $aFoodItem->food_item;
							$aCartItems[$cartCnt]['adon_type'] 		= $value->adon_type;
							$aCartItems[$cartCnt]['adon_id'] 		= $value->adon_id;
							$aCartItems[$cartCnt]['adon_detail']	= $value->adon_details;
							$aCartItems[$cartCnt]['quantity'] 		= $value->quantity;
							$aCartItems[$cartCnt]['price'] 			= $value->food_price->price;
							$aCartItems[$cartCnt]['base_price']		= $original;
							$aCartItems[$cartCnt]['item_note'] 		= $value->item_note;
							$aCartItems[$cartCnt]['hiking'] 		= $value->food_price->hiking;
							$aCartItems[$cartCnt]['hiking_price']	= ($original * ($aFoodItem->hiking / 100));
							$aCartItems[$cartCnt]['base_price_value']	= abs($original - $value['price']);
							$aCartItems[$cartCnt]['selling_price'] 		=$aFoodItem->selling_price;
							$aCartItems[$cartCnt]['admin_cmsn_amt']		= ($original * ($aRestaurant->commission / 100));
							$vendorAmount	= ($aCartItems[$cartCnt]['base_price']	- $aCartItems[$cartCnt]['admin_cmsn_amt']);
							$aCartItems[$cartCnt]['vendor_price']		= $vendorAmount;
							// $aCartItems[$cartCnt]['vendor_gstamount']	= ($vendorAmount * ($aFoodItem->gst / 100));
							$aCartItems[$cartCnt]['vendor_gstamount']	= $value->gst;
							$aCartItems[$cartCnt]['gst'] = $aFoodItem->gst;

							$aCartItems[$cartCnt]['hiking_gst_price']	= ($aCartItems[$cartCnt]['hiking_price'] * ($aFoodItem->gst / 100));
							$aCartItems[$cartCnt]['base_price_gst']		= ($original * ($aFoodItem->gst / 100));

							$oHikingPrice	+= ($aCartItems[$cartCnt]['hiking_price'] * $value->quantity);
							$hostAmount		+= (($vendorAmount + $aCartItems[$cartCnt]['vendor_gstamount']) * $value->quantity);
							$cartCnt		+= 1;
						}
						/*$itemPrice	+= (isset($value->food_price->price) ? $value->food_price->price : 0 ) * ($value->quantity);*/
						$itemPrice	+= (isset($value->food_price->selling_price) ? $value->food_price->selling_price : 0 ) * ($value->quantity);
						$itemOriginalPrice += (isset($value->food_price->selling_price) ? $value->food_price->selling_price : 0 )  * ($value->quantity);
						$gst	+= $value->gst;
						$aFoodIds[] = isset($aFoodItem->id);
					}
					$status		= 200;
					$message	= $checkstatus == 1 ? 'success' : $message;
					$orderCon = new ordercon;
					//Delivery change calculation start
					$distCheck	= true;
					$validKm	= \AbserveHelpers::site_setting1('delivery_distance');
					$ucart		= [];
					if($user_id == '4722'){
						$distance = 0;
					}else {
						$distance 				= $aUserCart[0]->distance_km;

					}
					$duration 				= $aUserCart[0]->duration;
					$address_id				= $aUserCart[0]->address_id;
					$duration_text 			= '';
					if($distance > $validKm){
						$distance = $duration = $address_id = 0;
						$ucart['distance_km'] = $distance;
						$ucart['duration'] = $duration;
						$ucart['address_id'] = $address_id;
					}

					if($distance > 0){
						$seconds       = $duration + ($aRestaurant->delivery_time * 60);
						$duration_text = $orderCon->getReadabletimeFromSeconds($seconds);
					}
					$aDelCharges = \AbserveHelpers::getDeliveryChargeValues($distance,$aRestaurant,$itemOriginalPrice);

					//Promocode start
					$promoamount = (float) number_format(0,2,'.','');
					$ucart['coupon_id'] = 0;
					if($aUserCart[0]->coupon_id > 0){
						$availPromoCode = \AbserveHelpers::getAvailablePromos($user_id,'',$itemPrice,$restaurant_id=$aRestaurant->id,$aUserCart[0]->coupon_id);
						if(count($availPromoCode) > 0){
							$promoamount = \AbserveHelpers::getPromoAmount($aUserCart[0]->coupon_id,$itemPrice);
							if($promoamount > 0){
								$ucart['coupon_id'] = $aUserCart[0]->coupon_id;
								$response['promoInfo'] = $availPromoCode[0];
							}
						}
					}
					//Promocode end
					if(count($ucart) > 0){
						Usercart::where('user_id',$user_id)->update($ucart);
					}
					$hostShare = $itemPrice;
					if($aRestaurant->gst_applicable == 'yes'){
						$stax1 = ($aRestaurant->service_tax1 > 0) ? number_format(($hostShare * ($aRestaurant->service_tax1 / 100)),2,'.','') : 0;
						/*$gst = ($aRestaurant->gst > 0) ? number_format(($hostShare * ($aRestaurant->gst / 100)),2,'.','') : 0;*/
					}
					$gst = $gst + $stax1;

					$itemOfferPrice = /*$itemOriginalPrice > $itemPrice ? $itemOriginalPrice - $itemPrice :*/ 0;
					$itemSavedPrice	= $itemOfferPrice;
					$otherOffers	= $promoamount + isset($aDelCharges['delivery_charge_discount']);
					$itemSavedPrice	+= $otherOffers;

					$offerData	= \AbserveHelpers::Offerdata($user_id,$itemOriginalPrice);
					$response['grozoOffer']	= 0; $response['OfferName']	= 0;
					if($offerData['cashOffer'] > 0){
						$response['grozoOffer']	= $offerData['cashOffer'];
						$response['OfferName']	= $offerData['OfferName'];
					}
					$response['walletAmount']	= 0;
					if($aUserCart[0]->wallet > 0){
						$response['walletAmount']	= $aUserCart[0]->wallet;
					}
					$response['itemPrice'] 			= $itemPrice;
					$response['itemOriginalPrice'] 	= $itemOriginalPrice;
					$response['itemOfferPrice'] 	= $itemOfferPrice;
					$response['promoamount'] 		= $promoamount;
					$response['stax1'] 				= 0;
					$response['gst'] 				= $gst;
					$response['delivery_charge'] 	= number_format(isset($aDelCharges['delivery_charge']),2,'.','');
					$response['aDelCharges'] 		= $aDelCharges;
					$response['savedPrice'] 		= (float) number_format($itemSavedPrice,2,'.','');
					$GtotalWithoutoff = $itemOriginalPrice + /*$stax1 + */$aDelCharges['delivery'] +/*+ $aDelCharges['deliveryTax'] + $aDelCharges['badWeather'] + $aDelCharges['badWeatherTax'] +*/ /*$aDelCharges['package'] + $aDelCharges['packageTax'] +*/ /*$aDelCharges['festival'] + $aDelCharges['festivalTax'] + */$gst;
					$grandTotal = $GtotalWithoutoff - $promoamount;
					// if($response['grozoOffer'] > 0){
					// 	$grandTotal = $grandTotal - $response['grozoOffer'];
					// }

					$response['GtotalWithoutoff'] 	= number_format(($GtotalWithoutoff),2,'.','');
					$response['grandTotal'] 		= (float) number_format(($grandTotal-$response['walletAmount']),2,'.','');

					$response['restaurant'] 		= $aRestaurant;
					$response['duration_text'] 		= $duration_text;
					if($orderinsert){
						$adminShare 				= ($itemOriginalPrice * ($aRestaurant->commission / 100));
						$response['aCartItems'] 	= $aCartItems;
						$response['fixedCommission']= ($itemPrice * ($aRestaurant->commission / 100));
						$response['HikingPrice']	= $oHikingPrice;
						$response['commisisonPrice']= number_format(($response['fixedCommission'] + ( $response['HikingPrice'] )),0,'.','');
						$AdmincommissionPercent 	= $response['commisisonPrice'] * ($aRestaurant->commission / 100);
						$response['host_amount']	= $hostAmount;
						$response['AdmincommissionPercent'] 	= $AdmincommissionPercent;
					} else {
						$itemcount = \DB::table('tb_settings')->select('item_count')->where('id',1)->first();
						$response['itemcnt'] = $itemcount->item_count;
					}
					$response['wallet_amount']	= $response['walletAmount'];
				}
			}
		}
		$response['aUserCart'] = Usercart::where('user_id',$user_id)->get()->map(function($result) use($device_id,$user_id){
			$result->food_item_info = $result->getFoodItemDetailAttribute($device_id,$user_id);
			return $result;
		});
		$response['currsymbol']		= \AbserveHelpers::getBaseCurrencySymbol();
		$response['status']			= $status;
		$response['message']		= $message;
		$response['unavailableFoodIds'] = $unavailableFoodIds;
		return $response;
	}
	
	public static function urlimg_compress($imgurl)
	{
		$source_img = $imgurl;
		$destination = $imgurl;
		$quality = 90;

		$info = getimagesize($source_img);		
        
        if(isset($info['mime'])){
		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source_img);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source_img);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source_img);

		imagejpeg($image, $destination, $quality);
}
		return '1';
	}

	static function getPromoAmount($promoId,$cartTotal)
	{
		$aPromo = Promocode::find($promoId);
		$promoAmount = 0;
		if(!empty($aPromo) && $cartTotal >= $aPromo->min_order_value){
			if($aPromo->promo_type == 'amount'){
				$promoAmount = $aPromo->promo_amount;
			} elseif($aPromo->promo_type == 'percentage' && $aPromo->promo_amount > 0 && $aPromo->promo_amount < 100 ) {
				$promoAmount = $cartTotal * ($aPromo->promo_amount / 100);
			}
			if($promoAmount > $cartTotal){
				$promoAmount = $cartTotal;
			}
			if($promoAmount > 0 && $aPromo->max_discount > 0 && $promoAmount > $aPromo->max_discount){
				$promoAmount = $aPromo->max_discount;
			}
			$promoAmount = number_format($promoAmount,2,'.','');
		}
		return $promoAmount;
	}

	public static function getCartTotal($userID, $cookieID)
	{
		if ($userID != '')
			$authId = $userID;
		else 
			$authId = \Auth::id();
		
		$item_total = 0;
		$carts = \DB::table('abserve_user_cart')->select('*')->where('user_id',$authId)->get();
		if(isset($carts) && !empty($carts)){
			$rest = \DB::table('abserve_restaurants')->select('*')->where('id',$carts[0]->res_id)->first();
			$comsn = 0;
			//$comsn = 0.05;
			// if(isset($rest) && !empty($rest)){
			// 	$partner = \DB::table('tb_users')->select('commission')->where('id',$rest->partner_id)->first();
			// 	if(isset($partner) && !empty($partner) && $partner->commission > 0 && $partner->commission <= 100){
			// 		$comsn = $partner->commission / 100;
			// 	}
			// }
			foreach ($carts as $key => $cart) {
				$total = round($cart->quantity * ($cart->price + round($cart->price * $comsn)));
				$item_total += $total ;
			}
		}
		return round($item_total);
	}
	static function ImageOrVideo($ext)
	{
		$imgArr = ['tif', 'tiff','bmp','jpg','jpeg','gif','png','eps'];
		if(in_array($ext, $imgArr))
        { return 'img'; } else { return 'video'; }
	}
	public static function getDefaultAdvert($path=false)
	{
		$img = implode(',',preg_grep('~^DefaultAdvertise~', scandir("uploads/location_ad/")));
		return $img;
	}

	public static function getPartner_payable_weekly_amt($id,$from,$to)
	{


		$restaurant	= Restaurant::select(\DB::raw('GROUP_CONCAT(id) as id'))->where('partner_id',$id)->first();


		if (isset($restaurant) && $restaurant->id) {
			
			$orderData	= OrderDetail::select(\DB::raw('sum(accept_host_amount) as amount'))->whereBetween('date',array($from,$to))->where('partner_id',$id)->where('accept_host_amount','>',0)->where('status','4')->first();
			
			$amt	= number_format(abs($orderData->amount),2); 


			

			return \AbserveHelpers::i_currency($amt);
		} else {

			return number_format(0,2);
		}
	}


	public static function getWeekly_payable_status($id,$from,$to,$type)
	{
		$weeklypayment	= [];
		$weeklypayment	= \DB::table('abserve_weeklypayment')->select('id')->where('from_date',$from)->where('to_date',$to)->where('status','paid');
		if ($type == '1') {
			$weeklypayment	= $weeklypayment->where('partner_id',$id);
		} else if($type == '2') {
			$weeklypayment	= $weeklypayment->where('del_boy_id',$id);
		}
		if ($id != '') {
			$weeklypayment	= $weeklypayment->orderBy('id','DESC')->first();
		}
		if (isset($weeklypayment) && !empty($weeklypayment)) {
			return "0~<span class='label label-success'>Paid</span>";
		} else {
			return "1~<span class='label label-danger'>Not-paid</span>";
		}
	}

	public static function i_currency($amt)
	{
		// return explode(".",$amt)[0];		
		$exp=explode(".",$amt)[1];
		$scnd_dgt= substr($exp,1,2);
		$ww=array('1','2');
		$xx=array('3','4');
		$yy=array('6','7');
		$zz=array('8','9');
		if($scnd_dgt!='' && $scnd_dgt>0){
			if(in_array($scnd_dgt,$ww)){
				$res=explode(".",$amt)[0].'.'.substr($exp,0,1).'0';
			}else if(in_array($scnd_dgt,$xx)){
				$res=explode(".",$amt)[0].'.'.substr($exp,0,1).'5';
			}else if(in_array($scnd_dgt,$yy)){
				$res=explode(".",$amt)[0].'.'.substr($exp,0,1).'5';
			}else{
				$res=explode(".",$amt)[0].'.'.(substr($exp,0,1)+1).'0';
			}
		}else{
			$res=$amt;
		}
		return $res;   
	}


	public static function getWeekly_payable_status_removelabel($id,$from,$to,$type)
	{
		if($type=='1'){
			$abserve_weeklypayment=\DB::table('abserve_weeklypayment')->select('id')->where('partner_id',$id)->where('from_date',$from)->where('to_date',$to)->where('status','paid')->orderBy('id','DESC')->first();
		}else if($type=='2'){
			$abserve_weeklypayment=\DB::table('abserve_weeklypayment')->select('id')->where('del_boy_id',$id)->where('from_date',$from)->where('to_date',$to)->where('status','paid')->orderBy('id','DESC')->first();
		}else{
			$abserve_weeklypayment=[];
		}	
		
		if(isset($abserve_weeklypayment)){
			return "0~Paid";			
		}else{
			return "1~Not-paid";
		}
	}


	public static function filterColumn( $limit )
	{
		if($limit !='')
		{
			$limited = explode(',',$limit);	
			$uid = (\Session::has('uid') && \Session::get('uid') != '') ? \Session::get('uid') : \Auth::user()->id;
			if(in_array( $uid,$limited) )
			{
				return  true;
			} else {
				return false;	
			}
		} else {
			return true;
		}
	}

	public static function activeLang( $label , $l )
	{
		$activeLang = Session::get('lang');
		$lang = (isset($l[$activeLang]) ? $l[$activeLang] : $label );
		return $lang;
	}

	public static function getDel_boy_payable_weekly_amt($id,$from,$to,$type='no')
	{
		// $abserve_order_details=\DB::table('abserve_order_details')->select(\DB::raw('sum(del_charge) as amount'))->whereBetween('date',array($from,$to))->where('boy_id',$id)->where('status',4)->where('is_rapido',$type)->first();
		// $amt= number_format($abserve_order_details->amount,2);
		// return \SiteHelpers::i_currency($amt);
	
		# Del boy total charge calculation 
		$to=$to.' 11:59:59';
		$tot_km = 0;
	
			$distance = RiderLocationLog::where('boy_id','=',$id)->whereIn('order_status',['boyPicked','boyArrived','4','2'])->whereBetween('created_at',[date('Y-m-d H:i:s',strtotime($from)),date('Y-m-d H:i:s',strtotime($to))])->sum('distance') ?? 0;

			$tot_km = number_format(($distance),2);
		$api_settings= \DB::table('tb_settings')->select('delivery_boy_charge_per_km')->first();
		$delivery_boy_charge = (float)($api_settings->delivery_boy_charge_per_km) * (float)($tot_km);

		return $delivery_boy_charge;

	}

	public static function getMainCatID($name) {
		$mainCatName = '';
		$food_cat = Foodcategories::where('cat_name',$name)->first();
		if(isset($food_cat) && !empty($food_cat)){
			$mainCatName = $food_cat->id;
		}
		return $mainCatName;
	}

	static function foodcheck_app($food_id,$ad_id='',$ad_type='',$user_id,$cookie_id)
	{
		if($user_id>0){			
			if($ad_id!='' && $ad_type!=''){
				$items = \DB::table('abserve_user_cart')->select(DB::raw('SUM(quantity) as total_quants'))->where('user_id',$user_id)->where('food_id',$food_id)->where('adon_type',$ad_type)->where('adon_id',$ad_id)->get();
			}else{
				$items = \DB::table('abserve_user_cart')->select(DB::raw('SUM(quantity) as total_quants'))->where('user_id',$user_id)->where('food_id',$food_id)->get();
			}
		} else {
			if($ad_id!='' && $ad_type!=''){
				$items = \DB::table('abserve_user_cart')->select(DB::raw('SUM(quantity) as total_quants'))->where('cookie_id',$cookie_id)->where('food_id',$food_id)->where('adon_type',$ad_type)->where('adon_id',$ad_id)->get();
			}else{
				$items = \DB::table('abserve_user_cart')->select(DB::raw('SUM(quantity) as total_quants'))->where('cookie_id',$cookie_id)->where('food_id',$food_id)->get();
			}
		}
		$quantity = $items[0]->total_quants;
		if(count($items)>0)
		{
			if($quantity != '')
				return $quantity;
			else 
				return 0;
		}
		else
		{
			return 0;
		}
	}

	public static function headerCart()
	{
		$user_id	= $data['userid']	= (\Auth::check()) ? \Auth::user()->id : 0;
		$cookie_id	= $data['cookie_id']= \AbserveHelpers::getCartCookie();
		if ( !$cookie_id ) {
			$cookie_id	= $data['cookie_id'] = \AbserveHelpers::setCartCookie();
		}
		$usercart	= \AbserveHelpers::uCartQuery($user_id, $cookie_id)->first();
		$carRes = (!empty($usercart)) ? $usercart->res_id : 0 ;
		return (new FrontEndController)->ShowSearchcCart($carRes,$user_id,$cookie_id);
	}

	static function uploadImage($fileval,$path,$oldimagename='',$prefix='',$filenamenew)
	{
        $ext   =  pathinfo($path.$fileval->getClientOriginalName());
		if(\AbserveHelpers::ImageOrVideo($ext['extension']) == 'img')
		{
			$imageSize = getimagesize($fileval);
		}else
		{
			$imageSize = true;
		}
		if(!empty($imageSize)){
			$destinationPath	= base_path($path);

			$filename			= $fileval->getClientOriginalName();
			$extension			= $fileval->getClientOriginalExtension(); 
			$prefix 			= $prefix == '' ? '' : $prefix.'-';
			if ($filenamenew) {
				$newfilename		= $prefix.$filenamenew.'.'.$extension;
			} else {
				$newfilename		= $prefix.time().'-'.mt_rand(100000, 999999).'.'.$extension;
			}
			$uploadSuccess		= $fileval->move($destinationPath, $newfilename);		 
			if( $uploadSuccess ) {
				$data['image'] = $newfilename; 
				//Delete old File
				\AbserveHelpers::unlinkimage($path,$oldimagename);
				$data['success'] = true;
			} else {
				$data['success'] = false;
				$data['id'] = '2';
				$data['message'] = 'Image is not valid';
			}
		} else {
			$data['success'] = false;
			$data['id'] = '2';
			$data['message'] = 'Image is not valid';
		}
		return $data;
	}

	static function unlinkimage($path,$filename)
	{
		if($filename != '' && file_exists(base_path($path.$filename))){
			unlink(base_path($path.$filename));
		}
		return true;
	}

	static function updateCartAndSearchKeyword($user_id,$device_id)
	{
		$deviceIdUsercart = Usercart::where('cookie_id',$device_id)->where('user_id','0')->get();
		$userIdUserCart = Usercart::where('user_id',$user_id)->where('cookie_id','0')->first();

		$iUserIdUserCart = !empty($userIdUserCart) ? 1 : 0;
		$iDeviceIdUsercart = count($deviceIdUsercart);

		if($iDeviceIdUsercart > 0 && $iUserIdUserCart > 0){
			if($deviceIdUsercart[0]->res_id == $userIdUserCart->res_id){
				foreach ($deviceIdUsercart as $key => $value) {
					$cart = Usercart::where('user_id',$user_id)->where('cookie_id','0')->where('food_id',$value->food_id)->first();
					if(!empty($cart)){
						$newQuantity = $cart->quantity + $value->quantity;
						$item_note = $value->item_note != '' ? $value->item_note : ($cart->item_note != '' ? $cart->item_note : '');
						$aFoodItem = Fooditems::find($cart->food_id);
						$usercart = Usercart::find($cart->id);
						$usercart->user_id 		= $user_id;
						$usercart->cookie_id 	= '0';
						$usercart->res_id 		= $aFoodItem->restaurant_id;
						$usercart->food_id 		= $aFoodItem->id;
						$usercart->food_item 	= $aFoodItem->food_item;
						$usercart->price 		= $aFoodItem->selling_price > 0 ? $aFoodItem->selling_price : $aFoodItem->price;
						$usercart->vendor_price = $aFoodItem->price;
						$usercart->quantity 	= $newQuantity;
						$usercart->tax 			= 0;
						$usercart->item_note 	= $item_note;
						$usercart->updated_at 	= date('Y-m-d H:i:s');
						$usercart->save();
						Usercart::where('id',$value->id)->delete();
					}
				}
				Usercart::where('cookie_id',$device_id)->update(['user_id' => $user_id, 'cookie_id' => '0']);
			} else {
				Usercart::where('user_id',$user_id)->where('cookie_id','0')->delete();
				Usercart::where('cookie_id',$device_id)->update(['user_id' => $user_id, 'cookie_id' => '0']);
			}
		} elseif($iDeviceIdUsercart > 0 && $iUserIdUserCart == 0){
			Usercart::where('cookie_id',$device_id)->update(['user_id' => $user_id, 'cookie_id' => '0']);
		}

		/*Search keyword update*/

		// $deviceIdUserkeyword = UserSearchKeyword::where('cookie_id',$device_id)->where('user_id','0')->update(['user_id' => $user_id]);
	}

	static function getTrackOrder($field,$fieldVal)
	{
		return OrderDetail::where($field,$fieldVal)
				->whereRaw("(SELECT COUNT(id) FROM abserve_order_items WHERE abserve_order_items.orderid = abserve_order_details.id) > 0")
				->whereRaw(" `status` IN (1,2,3) OR ( `status` = '0' AND ( (`delivery_type` = 'cashondelivery' && `delivery` = 'unpaid') OR (`delivery_type` != 'cashondelivery' && `delivery` = 'paid') ) ) ")
				->get()
				->map(function ($result) {
       				$result->append('restaurant_info','status_text','created_date_time','food_available_count','ongoing_status','do_pay');
       				return $result;
    			});
	}

	static function getPayOrder($field,$fieldVal)
	{
		return OrderDetail::where($field,$fieldVal)
				->whereRaw("(SELECT COUNT(id) FROM abserve_order_items WHERE abserve_order_items.orderid = abserve_order_details.id) > 0")
				->where('delivery_type','!=','cashondelivery')
				->where('delivery','unpaid')
				->whereRaw("TIMESTAMPDIFF(SECOND, created_at, NOW()) < ".CNF_PAY_WAIT_TIME)
				->get()
				->map(function ($result) {
       				$result->append('restaurant_info','status_text','created_date_time','food_available_count','ongoing_status','do_pay');
       				return $result;
    			});
	}

	static function banks()
	{
		return \DB::table('abs_bank')->get();
	}

	static function foodItemsEditCheck($restaurant_id,$partner_id,$food_id='')
	{
		$resCheck = \AbserveHelpers::restaurantOwnerCheck($restaurant_id,$partner_id);
		if($resCheck){
			if($food_id != ''){
				$foodQuery = Fooditems::where('id',$food_id)->where('restaurant_id',$restaurant_id)->where('del_status','0')->exists();
				if($foodQuery){
					return true;
				}
			} else {
				return true;
			}
		}
		return false;
	}

	static function restaurantOwnerCheck($restaurant_id='',$partner_id)
	{
		if($restaurant_id == ''){
			return true;
		}
		$partner_id = explode(',', $partner_id);
		$query = Restaurant::where('id',$restaurant_id)->whereIn('partner_id',$partner_id);
		$restaurant = $query->first();
		if(!empty($restaurant)){
			return true;
		}
		return false;
	}

	static function restaurantCheckFront($restaurant_id)
	{
		return \DB::table('abserve_restaurants')->where('id',$restaurant_id)->where('status','1')->where('admin_status','approved')->exists();
	}

	public static function showUploadedFileFood($file,$path , $width = 50,$key='')
	{
		$files =  base_path(). $path . $file ;	
		if(file_exists($files ) && $file !="") {
			$info = pathinfo($files);	
			if($info['extension'] == "jpg" || $info['extension'] == "jpeg" ||  $info['extension'] == "png" || $info['extension'] == "gif" || $info['extension'] == "JPG") 
			{
				$path_file = str_replace("./","",$path);
				return '<div class="col-sm-2"><i class="fa fa-times-circle remove_Img  pull-right" id="" data-val="main" data-img="'.$file.'" aria-hidden="true" style="cursor:pointer" title="Click to remove image"></i>
				<input  type="hidden" name="image_old[]" value="'.$file.'"/>
				<a title="Click to view image" href="'.url( $path_file . $file).'" target="_blank" class="previewImage">
				<img src="'.asset( $path_file . $file ).'" border="0" width="'. $width .'" class="img-circle" /></a></div>';
			} else {
				$path_file = str_replace("./","",$path);
				return '<div class="col-sm-2"><i style="cursor:pointer" title="Click to remove image"
				class="fa fa-times-circle remove_Img  pull-right" id="" data-val="main" data-img="'.$file.'" aria-hidden="true"></i><input  type="hidden" name="image_old[]" value="'.$file.'"/><a title="Click to view image" href="'.url($path_file . $file).'" target="_blank"> '.$file.' </a></div>';
			}
		} else {
			return "<img src='".asset('/uploads/images/no-image.jpg')."' border='0' width='".$width."' class='img-circle' />";
		}
		// <img src='".asset('/uploads/images/no-image.png')."' border='0' width='".$width."' class='img-circle' />
	}

	public static function managersPartner($id)
	{
		$partner = \DB::table('tb_users')->select('id')->where('manager_id',$id)->where('group_id',3)->lists('id');
		return count($partner) > 0 ? $partner : [0];
	}

	public static function randomMail($mail_id)
	{
		if(EMAIL_OPTION=='enable'){
			$uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
			$uri_segments = explode('/', $uri_path);
			$email=$mail_id;
			$domain = strstr($email, '@');
			$user = strstr($email, '@', true);
			if(strlen($user) > 5){
				$output=substr_replace($user,'*****' , 2,5);
			}
			elseif(strlen($user) == 5)
			{
				$output=substr_replace($user,'***' , 2,3);
			}
			else{
				$output=substr_replace($user,'*' , 2,1);
			}
			return $output.$domain;

		}else{
			return $mail_id;
		}
	}

	public static function getCommonImageUser()
	{
		return \URL::to('storage/app/public/avatar.jpg');
	}

	public static function locationName($id)
	{
		$name =	Location::select('name')->where('id',$id)->first();
		return isset($name->name)? $name->name : '';
	}
   public static function getRestaurantAddress($id)
	{
		$name =	Restaurant::select('location')->where('id',$id)->first();
		return isset($name->location)? $name->location : '';
	}

	public static function getboynum($id)
	{
		$abserve_order_details=\DB::table('abserve_order_details')->select('boy_id')->where('id',$id)->first();
		if($abserve_order_details && $abserve_order_details->boy_id!=''){
			$abserve_deliveryboys=\DB::table('tb_users')->select('phone_number')->where('id',$abserve_order_details->boy_id)->first();
			if($abserve_deliveryboys){
				return $abserve_deliveryboys->phone_number;
			}else{
				return '';
			} 
		}else{
			$delivery_boy_new_orders=\DB::table('delivery_boy_new_orders')->select('boy_id')->where('order_id',$id)->orderBy('id','DESC')->first();
			if($delivery_boy_new_orders && $delivery_boy_new_orders->boy_id){
				$abserve_deliveryboys1=\DB::table('tb_users')->select('phone_number')->where('id',$delivery_boy_new_orders->boy_id)->first();
				if(isset($abserve_deliveryboys1)){
					return $abserve_deliveryboys1->phone_number;
				}else{
					return '';
				}
			}else{
				return '';
			}
			
		}
	}

	public static function calculateDistance($userLat, $userLng, $restaurantLat, $restaurantLng)
	{
	    $earthRadius = 6371; // Earth's radius in kilometers

	    $dLat = deg2rad($restaurantLat - $userLat);
	    $dLng = deg2rad($restaurantLng - $userLng);

	    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($userLat)) * cos(deg2rad($restaurantLat)) * sin($dLng / 2) * sin($dLng / 2);
	    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

	    $distance = $earthRadius * $c;

	    return $distance;
	}

	public static function sendPushNotification($token, $title, $message)
	{
		$firebase = \DB::table('abserve_app_apis')->where('id', 1)->first();
		$firebase_key = $firebase->api;
		$path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
		$fields = array(
			'to' => $token,
			'notification' => array('title' => $title, 'body' => $message, 'sound' => 'default', 'click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'icon' => 'fcm_push_icon'),
			'data' => array('title' => $title, 'body' => $message, 'sound' => 'default', 'icon' => 'fcm_push_icon'),
		);
		$headers = array(
			'Authorization:key=' . $firebase_key,
			'Content-Type:application/json'
		);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		$result = curl_exec($ch);
		curl_close($ch);
	}
	
	public static function loadAcceptedOrderItems($id)
	{
		$item = OrderItems::where('orderid', $id)->where('check_status', 'yes')->get();
		return $item;
	}
	
	public static function getDelBoyname($id)
	{
		$name = \DB::table('tb_users')->where('id', $id)->pluck('username')->first();
		return $name;
	}

	public static function getCuisines($id)
	{
		$name = \DB::table('abserve_food_cuisines')->where('id', $id)->get();
		return $name;
	}

}
?>