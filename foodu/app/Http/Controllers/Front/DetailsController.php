<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Front\Offers;
use App\Models\Front\Usercart;
use App\Models\Front\Restaurant;
use App\Models\Front\Favorites;
use App\Models\Front\Fooditems;
use App\Models\Front\RecentSearch;
use App\Models\Foodcategories;
use App\Models\Useraddress;

use App\Models\Fooditems as food;

use App\Http\Controllers\Api\OrderController as ordercon;
use App\Http\Controllers\Api\RestaurantController as restacon;
use App\Http\Controllers\Front\CheckoutController as checkout;

/**
 * @author Suganya
 */
class DetailsController extends Controller
{
	public function productsPage(Request $request, $id)
	{
		$restaurant	= Restaurant::where('status','!=','3')/*->where('del_status','0')*/->find($id,['id','shop_categories']);
		if(\Auth::check() && \Auth::user()->p_active == '1') 
		{
			$restrict = \Auth::user()->id;
			$restaurant	= Restaurant::where('status','!=','3')->where('partner_id','!=',$restrict)/*->where('del_status','0')*/->find($id,['id','shop_categories']);
		}
		if (empty($restaurant)) {
			return \Redirect::back()->with('message',\SiteHelpers::alert('error','No such shop found'));
		}

		$Favorites	= 0;
		$catString	= [];
		$user_id	= $data['userid']	= (\Auth::check()) ? \Auth::user()->id : 0;
		$cookie_id	= $data['cookie_id']= \AbserveHelpers::getCartCookie();
		if ( !$cookie_id ) {
			$cookie_id	= $data['cookie_id'] = \AbserveHelpers::setCartCookie();
		}
		$product['cookie_id']   = $cookie_id;
		/* Category listing Begins */
		if(!preg_match('/[0-9]/', $restaurant->shop_categories))
			$restaurant->shop_categories	= '';	// TEMP FIX
		if (!empty($restaurant->shop_categories) && trim($restaurant->shop_categories) != '')
			$catString	= $restaurant->shop_categories;
		if (empty($catString)) {
			$foodCategories	= Fooditems::select(\DB::raw('GROUP_CONCAT(DISTINCT(main_cat)) as categories'))->notdeleted()->approved()->where('restaurant_id',$id)->first();
			$catString	= $foodCategories->categories;
		}
        if($catString != ''){
		$shopCategories	= Foodcategories::select('*')->whereIn('id',explode(",",$catString))->orderByRaw('FIELD(id,'.$catString.')')->get();
	     }
	     else{
	     	$shopCategories = [];
	     }

		/* Category listing End */

		if (count($shopCategories) == 0) {
			return \Redirect::to('')->with('message',\SiteHelpers::alert('error','No such shop found'));
		}
		if(\Auth::check()){
			$recentSearch = RecentSearch::where('user_id','=',$user_id)->where('res_id','=',
				$restaurant->id)->first();
			if (!empty($recentSearch)) {
				$insertSearch			= new RecentSearch();
				$insertSearch->user_id	= $user_id;
				$insertSearch->res_id	= $restaurant->id;
				$insertSearch->save();
			}
			$Favorites	= Favorites::where('user_id',$user_id)->where('resid',$restaurant->id)->count();
		}
		$restaurant = Restaurant::with(['fooditems' => function ($query) use ($shopCategories) {
			$query->commonselect()->where('main_cat',$shopCategories[0]->id)->notdeleted()->approved();
		}])->find($id);
		$restaurant->append('overall_rating','rating_count');

		$usercart	= \AbserveHelpers::uCartQuery($user_id, $cookie_id)->first();
		$carResId	= (!empty($usercart)) ? $usercart->res_id : 0  ;
		$checkout	= new checkout;
		$data['carthtml']	= $checkout->Showcart($restaurant->id,$carResId,$user_id,$cookie_id);
		$data['favorite']	= $Favorites;
		$data['restaurant']	= $restaurant;
		$data['fCount']		= count($restaurant->fooditems);
		$data['shopCategories']	= $shopCategories;
		return view('front.list.details',$data);
	}

	public function loadmore(Request $request)
	{
		if (!isset($request->from))
			$response['products']	= '';
		if (isset($request->category_id) && $request->category_id != '') {
			$response['categoryid']	= $categoryid	= $request->category_id;
			$categoryname	= Foodcategories::find($request->category_id,['id','cat_name']);
			if (empty($categoryname)) {
				$response['categoryname']	= "";
				$response['fooditems']		= [];
				return \Response::json($response);
			}
			$categoryname	= $categoryname->cat_name;
			$fooditems		= Food::commonselect()->notdeleted()->approved()->where('main_cat',$request->category_id)->where('restaurant_id',$request->shop_id)->get();
			if (isset($request->from) && $request->from == 'api') {
				$device_id = $request->device_id;
				$user_id   = $request->user_id;
				$fooditems = $fooditems->map(function ($result) use($device_id,$user_id) {
				$res 	   = new Request;
				$res['cookie_id'] = $device_id;
				$res['user_id']   = $user_id;
				$res['food_id']   = $result->id;
				$result->append('exact_src','availability');
				$result->cart_detail = $result->getCartInfoAttribute($device_id,$user_id);
				$item = restacon::postProductdetailview($res);
				$result->variation = $item['itemDetail'][0]->variation;
				return $result;
				});
				$response['categoryname']	= $categoryname;
				$response['fooditems']		= $fooditems;
				return \Response::json($response);
			}
			$response['products']	= (string) view('front.list.detailpage.products',compact('fooditems','categoryid','categoryname'));
		}
		// $response['loader']	= (string) view('front.list.detailpage.loader');
		return \Response::json($response);
	}

	public static function postCheckneareraddress(Request $request,$auth = false)
	{
		if(\Auth::check() || $auth != false) {
			$cookie_id				= (\AbserveHelpers::getCartCookie() != '') ?  \AbserveHelpers::getCartCookie() : \AbserveHelpers::setCartCookie();
			$user_id				= $auth!=false ? $auth : \Auth::user()->id;
			$selhtml				= $html = $distance = $status = '';
			$request->deliverDate	= strtr($request->deliverDate, '/', '-');
			$delivertype			= ($request->deliverType != '') ? $request->deliverType : 'asap';
			$deliverdate			= ($request->deliverDate != '') ? date('Y/m/d',strtotime($request->deliverDate)) : NULL;
			$delivertime			= ($request->deliverTime != '') ? $request->deliverTime : '';
			$ucart					= \AbserveHelpers::uCartQuery($user_id, $cookie_id);
			$ucartupdate			= clone $ucart;
			// $cartItems			= clone ($ucart);
			$aRestaurant			= Restaurant::find($request->res_id);

			$authid					= $user_id;
			$updateVal['distance_km']	= 0;
			$updateVal['duration']		= 0;
			$updateVal['address_id']	= 0;
			$updateVal['ordertype']		= $request->ordertype;
			$updateVal['delivertype']	= $delivertype;
			$updateVal['deliverdate']	= $deliverdate;
			$updateVal['delivertime']	= $delivertime;
			$ucartupdate->update($updateVal);
			$addressCheck				= false;
			$addressInsert				= false;
			if ($request->ordertype != 'pickup') {
				$msg					= 'success';
				$addressCheck			= true;
				$dist['from_address']	= $aRestaurant->location;
				$dist['lat1']		    = $aRestaurant->latitude;
				$dist['long1'] 			= $aRestaurant->longitude;
				$dist['type']			= 'address';
				$ordercon = new ordercon;
				if($request->address_id > 0){
					$aUserAddress		= Useraddress::find($request->address_id);
					$addressID			= $request->address_id;
					$dist['to_address']	= $aUserAddress->address;
					$dist['lat2'] 			= $aUserAddress->lat;
					$dist['long2']  		= $aUserAddress->lang;
				} else {
					$adrsExist	= Useraddress::where('user_id',$user_id)->where('address',$request->a_addr)/*->where('lat',$request->a_lat)->where('lang',$request->a_lang)*/->where('del_status','0')->first();
					$dist['to_address']	= $request->a_addr;
					if($adrsExist != ''){
						$dist['lat2'] = $adrsExist->lat;
						$dist['long2'] = $adrsExist->lang;
					} else {
						$dist['lat2'] = $request->a_lat;
						$dist['long2'] = $request->a_lang;
					}
					if(empty($adrsExist)){
						$addressID		= $request->address_id;
						$addressInsert	= true;
					} else {
						$addressID		= $adrsExist->id;
						Usercart::where('user_id',$user_id)->update(array("address_id"=>$addressID));
						$aUserAddress	= Useraddress::find($addressID);
						if(!empty($aUserAddress)) {
							Useraddress::where('id',$addressID)->where('user_id',$user_id)->update(["lat"=>$request->a_lat,"lang"=>$request->a_lang,"building"=>$request->building,"landmark"=>$request->landmark,"address_type"=>$request->address_type]);
						}
					}
				}
			} else if($request->ordertype == 'pickup') {
				$msg		= 'success';
				$selhtml	= '<b class="selected_address_type" data-id="'.$request->address_id.'" id="sel_add" >blank</b>';
			}
			if($addressCheck){
				$dist['type'] = 'coordinates'; 
				if($dist['lat1'] == '' || $dist['long1'] =='' || $dist['lat2']== '' || $dist['long2'] == '' ){
					$dist['type']	= 'address';						
				}
				$aDistanceDatas	= $ordercon->calculate_distance($dist);
				if($aDistanceDatas['status']){
					$validKm	= \AbserveHelpers::site_setting1('delivery_distance');
					$distance	= $aDistanceDatas['total_km'];
					if($distance <= $validKm){
						if($addressInsert){
							$aUserAddress			= new Useraddress;
							$aUserAddress->user_id	= $authid;
							$aUserAddress->lat		= $request->a_lat;
							$aUserAddress->lang		= $request->a_lang;
							$aUserAddress->address_type	= $request->address_type;
							$aUserAddress->landmark		= $request->landmark;
							$aUserAddress->building		= $request->building;
							$aUserAddress->address		= $request->a_addr;
							if($auth != false) {
								$aUserAddress->hide	= 1;
							}
							$aUserAddress->created_at	= date('Y-m-d H:i:s');
							$aUserAddress->updated_at	= date('Y-m-d H:i:s');
							$aUserAddress->save();
						} else {
							$aUserAddress	= Useraddress::find($addressID);
						}
						$duration_text	='';
						$html			.= '<div class="col-md-6 col-sm-6 col-xs-12"><label class="delivery_new_box plain_border" id="plain_border_'.$aUserAddress->id.'" data-id="'.$aUserAddress->id.'" for="'.$aUserAddress->id.'"><b>'.$aUserAddress->address_type_text.'</b><address>'.$aUserAddress->building.$aUserAddress->landmark.$aUserAddress->address.'</address><strong>'.$duration_text.' </strong><div class="green_box">Deliver Here</div><input id="'.$aUserAddress->id.'" class="hid_adrs_id" type="radio" name="address" value="'.$aUserAddress->id.'" style="display:none;"></label></div>';
						$response['html']	= $html;
						$seconds			= $aDistanceDatas['duration'] + ($aRestaurant->delivery_time * 60);
						$duration_text		= $ordercon->getReadabletimeFromSeconds($seconds);
						$updateVal['distance_km']	= $distance;
						$updateVal['duration']		= $aDistanceDatas['duration'];
						$updateVal['address_id']	= $aUserAddress->id;
						$adrstype					= ($aUserAddress->address_type == '1') ? 'Home' : (($aUserAddress->address_type == '2') ? 'Work' : 'Others');
						$building	= ($aUserAddress->building != '') ? $aUserAddress->building.', ' : '';
						$landmark	= ($aUserAddress->landmark != '') ? $aUserAddress->landmark.', ' : '';
						$address	= ($building.$landmark.$aUserAddress->address);
						$selhtml	.= '<b class="selected_address_type">'.$aUserAddress->address_type_text.'</b>
						<address class="selected_address_adrs"  data-id="'.$aUserAddress->id.'" id="sel_add" >'.$address.'</address>
						<b class="selected_address_time">'.$duration_text.'</b>';
						$carts		= \DB::table('abserve_user_cart')->select('*')->where('user_id',$authid)->where('res_id',$request->res_id)->get();
						$msg		= 'success';
						$response['address_id']	= $aUserAddress->id;
					} else {
						$msg	= 'Sorry, we are unable to provide service at your location at this time!';
					}
				} else {
					$msg	= 'Provide a Valid Address';
				}
			}
			$ucartupdate->update($updateVal);
			if($msg == 'success'){
				$response['ordertype']	= $request->ordertype;
				$response['selhtml']	= $selhtml;
				$aCartPriceInfo			= \AbserveHelpers::getCheckoutcartprice($authid,$request->res_id);
				$cartInfo				= $ucart->first();
				$aCartPriceInfo['wallet_used']	= $cartInfo->wallet;
				$response['cart']		= (string) view('front.cart.checkoutcart',$aCartPriceInfo);
				$response['mol_amount']	= $aCartPriceInfo['grandTotal'];
				$amount					= $response['mol_amount'];
				$orderid				= $request->mol_orderid;
				$response['mol_vcode']	= \AbserveHelpers::get_MolVcode($amount,$orderid);
				$response['distance']	= $distance;
				$response['status']		= $status;
			}
		} else {
			$msg			= 'unauthorized';
		}
		$response['msg']	= $msg;
		return \Response::json($response);
	}

	public function postAddtofavorites(Request $request)
	{
		if(!empty($request->userid)) {
			$values = array("user_id"=>$request->userid,"resid"=>$request->resid);
			$wishexist = collect(Favorites::select('id')->where('user_id',$request->userid)->where('resid',$request->resid)->first());
			$wish = $request->wishval;
			if($wish == 1){
				if(count($wishexist) == 0){
					Favorites::insert($values);
				}
				echo 1;exit;
			} else {
				if(count($wishexist) > 0){
					Favorites::where('user_id',$request->userid)->where('resid',$request->resid)->delete();
				}
				echo 2;exit;
			}
		}else{
			echo 0;exit;
		}
	}

	public function postShowavailabletime(Request $request)
	{

		if($request->week_id==''){
			$date=$request->date;
			$currentDay = date('D',strtotime($date));
			$aDayInfo = \DB::table('abserve_days')->select('*')->where('value',$currentDay)->first();
			$request['week_id']=$aDayInfo->id;
			$request['current_time']=date('H')*60+date('i')*30;
		}
		$resStatus  = \AbserveHelpers::getOpenClosingStatus($request->res_id,$request->week_id,$request->date);
		$option_html= '';
		if($resStatus['timevalid'] == 1) {

			$field = \Auth::check() && \Auth::user()->id > 0 ? 'user_id' : 'cookie_id';
			$fieldvalue = \Auth::check() && \Auth::user()->id > 0 ? \Auth::user()->id : $cookie_id;

			$abserve_user_cart=\DB::table('abserve_user_cart')->where('res_id',$request->res_id)->where($field,$fieldvalue)->first();

			$time           = \DB::table('abserve_time')->select('*')->get();
			$avail          = \DB::table('abserve_restaurant_timings')->where('res_id',$request->res_id)->where('day_id',$request->week_id)->select('*')->first();
			$start_time     = \DB::table('abserve_time')->select('*')->where('name',$avail->start_time1)->first();
			$endtime        = \DB::table('abserve_time')->select('*')->where('name',$avail->end_time1)->first();
			$datetime = $request->date;
			$datetime =  preg_replace('/( \(.*)$/','',$datetime);
			$timestamp = strtotime($datetime);
			$date_cur = date('Y-m-d', $timestamp);
            // echo "<pre>";echo strtotime($date_cur);exit();
			for($i=0;$i<2;$i++){
				if( ($avail->start_time1=='12:00am' && $avail->end_time1=='12:00am') || time()< strtotime($date_cur)){
					foreach($time as $ky => $times){
						if($abserve_user_cart && $abserve_user_cart->delivertime!=''){
							$check =  ($abserve_user_cart->delivertime == $times->name) ? 'selected' : '';
						}else{
							$check =  ($ky == 0) ? 'selected' : '';
						}
						
						$option_html.='<option '.$check.' value="'.$times->name.'">'.$times->name.'</option>';
					}
				}else{
					foreach($time as $ky => $times){
						$current_time = empty($request->current_time) ? 0:$request->current_time;
						if($start_time->time <= $times->time && $endtime->time >= $times->time && $times->time>=$current_time && $times->time-$current_time >= 720){
							if($abserve_user_cart && $abserve_user_cart->delivertime!=''){
								$check =  ($abserve_user_cart->delivertime == $times->name) ? 'selected' : '';
							}else{
								$check =  ($ky == 0) ? 'selected' : '';
							}
							$option_html.='<option '.$check.' value="'.$times->name.'">'.$times->name.'</option>';
						}
					}
				}
				if(!empty($avail->start_time2) && !empty($avail->end_time2)){
					$start_time = \DB::table('abserve_time')->select('*')->where('name',$avail->start_time2)->first();
					$endtime = \DB::table('abserve_time')->select('*')->where('name',$avail->end_time2)->first();
				}
			}
			$response['msg'] = 'opened';
		} else {
			$response['msg'] = 'closed';
		}
		$unavailDates = array();
		if(!empty($resStatus['datesunavail'])) {
			foreach ($resStatus['datesunavail'] as $value) {
				$unavailDates[] = date('m/d/Y',strtotime($value->date));
			}
		}
		$response['datesunavail']   = $unavailDates;
		$response['option_html']    = $option_html;
		return \Response::json($response);
	}
	public function postFooddetails(Request $request)
	{
		$id=$request->id;
		$menuitem   = food::where('id',$id)->first();
		if(empty($menuitem)) {
			return redirect()->back();
		}
		$menuitem->unit_det = $menuitem->unit_detail;
		$unitid=$menuitem->unit_det;
		$items=array();
		foreach($unitid as $key=>$val){

			$items[]= $val['id'];

		};
		$unitid1=$items;
		$foodDetails=\App\Models\Fooditems::find($id);
		$unitDetails=\DB::table('abserve_food_categories')->whereIn('id',$unitid1)->get();
		//print_r($unitDetails);exit;

		return view('front.details-modal',compact('foodDetails','unitDetails'));
	}



}
?>