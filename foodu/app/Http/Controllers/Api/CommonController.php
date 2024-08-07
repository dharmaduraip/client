<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Response ;
use Illuminate\Http\Request;
use App\Models\Usercart;
use App\Models\Fooditems;

class CommonController extends Controller {
	function coreDatas(Request $request)
	{
		// $response['aClient'] = \DB::table('oauth_clients')->select('id','secret')->where('name',$request->device)->first();
		$response['aCountries'] = \DB::table('abserve_countries')->select('name','phonecode as phone_code','id')->get();

		$response['currency_symbol'] = \AbserveHelpers::getBaseCurrencySymbol();

		if(($request->input('from') && $request->from == 'partner' ) || ($request->input('from') && $request->from == 'deliveryboy' )){
			$response['aBanks'] = \AbserveHelpers::banks();
		}
		return Response::json($response,200);
	}

	function userDatas(Request $request)
	{
		$fieldData = \AbserveHelpers::getCurrentUserFieldVal($request);
		$aCart = Usercart::select(\DB::raw('SUM(quantity) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),'res_id')->where($fieldData['field'],$fieldData['fieldVal'])->first();
		$aCart->append('restaurant_name');
		$response['aCart'] = $aCart;

		return Response::json($response,200);
	}

	function keyDatas(Request $request)
	{
		$data['razor_key']= RAZORPAY_API_KEYID;
		$data['fb_key']	  = F_APP_KEY;
		$data['live']     = true;
		$response['data'] = $data;
		return Response::json($response,200);
	}

	function addCart( Request $request)
	{
		// todo validation
		// $c = implode('|',$Cuisine);
		// $subquery->orWhereRaw('cuisine_type REGEXP("('.$c.')")');
		$this->method= $request->method();
		$user		= $this->authCheck();
		$userId		= $user['userId'];
		$userData	= $user['user'];
		$status		= 200; $updateStatus = '';
		$price		= $count = 1; $rules = [];
		$methods	= ['GET','PATCH','PUT'];
		if (!in_array($this->method, $methods) && empty($userData) && $userId == 0) {
			$rules['cookie']	= 'required';
		}
		if ($this->method == 'POST') {
			$foodData	= Fooditems::find(request('food_id'));
			$rules['food_id']		= 'required|exists:abserve_hotel_items,id|exist_check:abserve_hotel_items,where:id:=:'.request('food_id').'-where:status:=:approved';
			$rules['date']			= ['required', 'date_format:Y-m-d','after_or_equal:'.date('Y-m-d')];
			$rules['time_slot']		= 'required|exist_check:time_slot_management,where:status:=:active';
			$rules['is_preorder']	= 'required|in:yes,no';
			$rules['is_addon']		= 'required|in:yes,no';
			if (request('is_addon') == 'yes') {
				if (is_array(request('addons'))) {
					$addons				= implode('~', request('addons'));
					$rules['addons']	= 'required|array';
					$rules['addons.*']	= 'required|exist_check:abserve_hotel_items,FIND_IN_SET:'.$addons.':addons-where:id:=:'.request('food_id').'|exist_check:addons,where:type:=:addon-where:status:=:active';
				}
			}
			if (request('is_preorder') == 'yes')
				array_push($rules['date'], 'after:today');
			if (!empty($foodData) && $foodData->unit != '')
				$rules['unit']	= ['required','exist_check:addons,where:type:=:unit-where:status:=:active'];
		} elseif($this->method == 'GET') {
		} elseif ($this->method == 'PATCH') {
		} elseif ($this->method == 'PUT') {
			$rules['address_id'] = 'required';
		}
		$this->validateDatas($request->all(),$rules,[],[]);
		// $cookieID	= (request()->get('cookie')) ? request()->get('cookie') : 0;
		$cookieID	= (!is_null($this->segment) && $this->segment == 'api') ? ((request('cookie')) ? request('cookie') : 0) : ((\Session::has('cookie')) ? \Session::get('cookie') : self::cookie());
		$uCartQuery	= uCartQuery($userId, $cookieID);
		$userCart	= clone ($uCartQuery); $pCart = clone ($uCartQuery);$gCart = clone ($uCartQuery); $ptCart = clone ($uCartQuery); $puCart = clone ($uCartQuery);
		$userCart	= $userCart->get();

		if (empty($userCart) && (in_array($this->method, $methods))) {
			$response['message']	= 'Your cart is empty';
			return \Response::json($response,422);
		}

		if ($this->method == 'POST') {
			$condition['where']	= ['where','where'];
			$condition['col']	= ['id','vendor_id'];
			$condition['cond']	= ['=','='];
			$condition['value']	= [request('food_id'),$userId];
			$vendorFood	= modelData('Menuitems', $condition);
			if (count($vendorFood) > 0) {
				$response['message']	= "You can not add your own dish into cart";
				return \Response::json($response,422);
			}
			$data	= [];$func	= 'save';$unit = 0;
			$aAddons	= (is_array(request('addons'))) ? request('addons') : [];
			$data['food_id']	= request('food_id');
			if ($userId == 0)
				$data['cookie']	= (!is_null($this->segment) && $this->segment == 'api') ? ((request('cookie')) ? request('cookie') : 0) : ((\Session::has('cookie')) ? \Session::get('cookie') : self::cookie());
			$data['quantity']	= request('quantity');
			$data['is_addon']	= request('is_addon');
			$data['is_preorder']= request('is_preorder');
			$data['date']		= request('date');
			$data['time_slot']	= request('time_slot');
			$data['unit']		= request('unit');
			$data['user_id']	= $userId;
			$data['res_id']		= $foodData->restaurant_id;
			if($userCart->isNotEmpty()){
				$data['deliverdistance']	= $userCart[0]['deliverdistance'];
				$data['delivermins']		= $userCart[0]['delivermins'];
				$data['address_id']			= $userCart[0]['address_id'];
				$data['rz_id']				= $userCart[0]['rz_id'];
			}
			if (isset($request->unit) && null !== $request->unit && $request->unit > 0) {
				$key	= array_search($request->unit, array_column($foodData->unit_detail, 'id'));
				$unit	= $foodData->unit_detail[$key]['price'];
			}
			$price	= ($unit > 0) ? $unit : $foodData->price;
			$data['price']	= (request('quantity') * $price);
			$fCart	= $pCart->where('food_id', request('food_id'))->where('date',request('date'))->where('time_slot',request('time_slot'))->first();
			if (!empty($fCart)) {
				if (request('quantity') > 0) {
					if ($fCart->is_addon != $request->is_addon) {
						$custid		= request('addons');
						sort($custid);
						$customData	= Cartaddon::select(\DB::raw("group_concat(addon_id) as catIds"))->where('cart_id',$fCart->id)->groupBy("cart_id")->having('catIds', '=', implode(',', $custid))->first();
						if(!empty($customData)) {
							$fCart->fill($data)->save();
							$cartDetail	= Cart::find($fCart->id);
							$func		= 'update';
						} else {
							$cartDetail	= Cart::create($data);
						}
					} else {
						$fCart->fill($data)->save();
						$cartDetail	= Cart::find($fCart->id);
					}
				} else {
					Cart::destroy($fCart->id);
				}
			} else {
				if (request('quantity') > 0)
					$cartDetail	= Cart::create($data);
			}
			if (request('is_addon') == 'yes') {
				if (request('quantity') > 0) {
					$addonData = array();
					if (is_array(request('addons')) && !empty($aAddons)) {
						foreach ($aAddons as $key => $value) {
							$maddon	= Fooditems::where('id', request('food_id'))->whereRaw('FIND_IN_SET("'.$value.'",addons)')->first();
							if (!empty($maddon)) {
								$addon	= Addon::find($value,['id','price']);
								$addonData['cart_id']	= $cartDetail->id;
								$addonData['addon_id']	= $value;
								$addonData['quantity']	= request('quantity');
								$addonData['price']		= $addon->price;
								if ($func != 'update') {
									$cartaddon	= Cartaddon::create($addonData);
									$cartDetail->increment('price',$addon->price);
								}
							}
						}
						if ($func == 'update') {
							$cartaddon	= Cartaddon::where('cart_id', $cartDetail->id)->update(['quantity'=>request('quantity')]);
						}
					}
				} else {
					if ($fCart) Cartaddon::where('cart_id',$fCart->id)->delete();
				}
			}
			if (!empty($cartDetail))
				self::offerCalc($cartDetail, $userId, $cookieID);
			$message	= " ";
			$message	.= request('quantity') > 0 ? "Added to " : "Removed from ";
			$message	.= " cart";
		} elseif($this->method == 'GET') {
			$message	= 'View Cart';
		} elseif ($this->method == 'PATCH') {
			if (request('ucart_id') > 0) {
				$uCart = $ptCart->where('id',request('ucart_id'))->with('getcoupon')->first();
				if (!empty($uCart)) {
					if (request('quantity') > 0) {
						$ucartFood	= Fooditems::find($uCart->food_id);
						$fprice		= $addonCart = $atotal = 0;
						if ($uCart->unit != 0) {
							$units	= json_decode($ucartFood->unit);
							foreach ($units as $key => $value) {
								if ($value->unit == $uCart->unit) {
									$fprice = $value->price;
								}
							}
						} else {
							$fprice = $ucartFood->price;
						}
						if ($uCart->is_addon == 'yes') {
							$addonCart	= Cartaddon::where('cart_id', $uCart->id)->sum('price');
						}
						$atotal	= $addonCart + (request('quantity') * $fprice);
						$arr	= ['quantity' => request('quantity'), 'price' => $atotal];
						$uCart->fill(['quantity' => request('quantity')])->save();
						Cart::where('id', request('ucart_id'))->update($arr);
					} else {
						$updateStatus = 'cleared';
						Cart::destroy($uCart->id);
						Cartaddon::where('cart_id', request('ucart_id'))->delete();
					}
					self::offerCalc($uCart, $userId, $cookieID);
					$message	= 'Cart updated successfully';
				} else {
					$status		= 422;
					$message	= 'Cart data does not exists';
				}
			}
		} elseif ($this->method == 'PUT') {
			$resInfo	= Restaurants::find($userCart[0]->res_id);
			$selAddress	= Address::find(request('address_id'));
			$calculate['type']	= 'coordinates';
			$calculate['lat1']	= $resInfo->latitude;
			$calculate['long1']	= $resInfo->longitude;
			$calculate['lat2']	= $selAddress->lat;
			$calculate['long2']	= $selAddress->lang;
			$distCheck	= calculate_distance($calculate);
			if($distCheck['apiStatus'] != 'OK'){
				$response['message']	= "Selected Address is not valid";
				return \Response::json($response,422);
			}
			if($distCheck['total_km'] > getMaxDistance()){
				$response['message']	= "Selected address is far away from the chef";
				return \Response::json($response,422);
			}
			$puCart->update(['address_id'=>request('address_id'),'deliverdistance'=>$distCheck['total_km'],'delivermins'=>$distCheck['durationmin']]);
			$message = 'Cart updated successfully';
		}
		$response['DelCharge']	= 0;
		$resTax	= 0;
		$response['package_charge'] = 0;
		if (in_array($this->method, $methods)) {
			$userData	= self::cartData(uCartQuery($userId, $cookieID));
			if(count($userCart) > 0 && isset($userData['cartData'][0])){
				$resTax	= $userData['cartData'][0]['taxTotal'];
			}
			$status	= ($status != 200 || $updateStatus != '') ? $status : $userData['status'];
			$response['tax']				= (float) $resTax;
			$response['couponId']			= $userData['couponId'];
			$response['couponCode']			= $userData['couponCode'];
			$response['couponValue']		= $userData['couponValue'];
			$response['cart_detail']		= $userData['cartData'];
			$response['selectedAdress']		= $userData['selectedAdress'];
			$response['subOrder_Count']		= $userData['subOrder_Count'];
			$response['razorKey']			= \Config::get('razorpay')['RAZORPAY_KEY'];
			$response['DelCharge']			= $response['subOrder_Count'] * getDelCharge();
			$response['package_charge']		= $userData['packagecharge'];
			$response['DelChargePerOrder']	= getDelCharge();
		}
		$uCart	= uCartQuery($userId, $cookieID);
		$ucart	= clone ($uCart);
		$total_coupon_value = 0;
		$priceTotal	= $ucart->sum('price');
		$response['cartTot'] = $priceTotal;
		$response['uCart']   = $uCart->first();
		$total_coupon_value  = isset($response['couponValue']) ? $response['couponValue'] : 0;
		// $total_coupon_value = $ucart->sum('total_coupon_value');
		if(!empty($ucart->first())) {
			$response['couponPrice']	=  $ucart->first()->total_coupon_value;
		}
		$response['userdetails']= ($userId > 0) ? User::find($userId,['id','name','email','mobile']) : (object) [];
		$response['price']		= ($priceTotal - $total_coupon_value) + $response['DelCharge'] + $resTax + $response['package_charge'];
		$response['count']		= $uCart->count();
		$response['message']	= $message;
		return \Response::json($response,$status);
	}

	public function TableDatasAll( Request $request)
	{
		$rules['requestdata']   = 'required';
		$this->validateDatas($request->all(),$rules);
		$tables     = explode(',', $request->requestdata);
		$response   = [];
		foreach ($tables as $key => $value) {
			$return = array();
			$dataName   = strtolower($value);
			$datas	= ['Categories','Units'];
			if(in_array($value,$datas)) {
				$return = ($value == 'Categories') ? ('App\Models\Foodcategories') : ('App\Models\variations');
				if ($value == 'Categories') {
					$return = $return::where('type','category')->get();
				} elseif ($value == 'Units') {
					$return = $return::where('type','variation')->get();
				}
				$response[$dataName]    = $return;
			}
		}
		return \Response::json($response,200);
	}

	public function helpCenter(Request $request)
	{
		$help_number = \DB::table('tb_users')->where('group_id', 1)->pluck('phone_number')->first();
		$helpCenterContent = [
            [
                "title" => "Order History",
                "content" => "Navigate to the Order History section. You can usually find this by clicking on your profile icon or by tapping the menu button..."
            ],
            [
                "title" => "Track Order",
                "content" => "Click or tap on the order you wish to track. You'll be taken to a page with more details about your order..."
            ],
            [
                "title" => "Live Tracking",
                "content" => "If your order supports live tracking, you'll see a map with the real-time location of your delivery driver. You can watch as your order makes its way to your doorstep..."
            ],
            [
                "title" => "Order Status",
                "content" => "Additionally, you'll see the order status displayed on this page. Common order statuses include Preparing, Out for Delivery, and Delivered. You can check the estimated delivery time as well..."
            ],
            [
                "title" => "Notifications",
                "content" => "Stay informed with real-time notifications. You may receive updates when your order is being prepared, when it's out for delivery, and when it's delivered to your address..."
            ],
            [
                "title" => "Contact Support",
                "content" => "If you encounter any issues while tracking your order or have any questions, don't hesitate to reach out to our customer support team..."
            ],
            [
                "title" => "Help Line Number",
                "content" => $help_number
            ],
        ];
		$response['How_to_Track_Your_Order'] = $helpCenterContent;
		return \Response::json($response,200);
	}

}

?>