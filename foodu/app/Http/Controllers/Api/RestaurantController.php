<?php namespace App\Http\Controllers\Api;
ini_set( 'serialize_precision', -1 );
use App\Http\Controllers\Controller;
use Input, Response, DB ;
use Illuminate\Http\Request;
use App\Models\Sliderimages;
use App\Models\Front\Banner;
use App\Models\Dishes;
use App\Models\Front\Cuisines;
use App\Models\Front\Fooditems;
use App\Models\Front\Usercart;
use App\Models\Useraddress;
use App\Models\Promocode;
use App\Models\Foodcategories;
use App\Models\Hotelitems;
use App\Models\Restaurantrating;
use App\Models\Front\Offers;
use App\Models\UserSearchKeyword;
use App\User;
use App\Models\Deliveryboy;
use App\Models\Front\Restaurant;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Api\OrderController as ordercon;
use App\Models\Fooditems as food;
use App\Models\Front\Days;
use App\Models\Front\RestaurantTiming;
use App\Models\cuisineimg;
use App\Models\OrderDetail;
use App\Models\OrderItems;
use JWTAuth;

// use LucaDegasperi\OAuth2Server\Authorizer;

class RestaurantController extends Controller {

	function restaurantList(Request $request)
	{
		if($request->input('nearby') !== null && $request->nearby != ''){
			$request['distance'] = CNF_NEARBY_RADIUS;
		}

		if($request->input('city') !== null && $request->city != ''){
			$cityFilter = true;
			$rules = [];
		} else {
			$cityFilter = false;
			$rules['latitude'] 	= 'required';
			$rules['longitude']	= 'required';
		}

		$this->validateDatas($request->all(),$rules);

		\DB::select("SET `sql_mode` = '' ");

		$segment = $request->segment;

		$perPage = 10;

		$curPage = $request->input('page') !== null && $request->page > 0 ? $request->page : 1;

		$offset = $curPage > 1 ? (($curPage - 1) * $perPage) : 0;

		$user_id = $request->input('user_id') !== null && $request->user_id > 0 ? $request->user_id : 0;
		$select = ['id','name','location','logo','partner_id','delivery_time','budget','rating','res_desc','mode','cuisine','minimum_order','free_delivery','city','l_id','show','preoder'];
		$query = \AbserveHelpers::getRestaurantBaseQuery($select);
		$latitude = $request->latitude;
		$longitude = $request->longitude;
		$lat_lng = " ( round( 
			  ( 6371 * acos( least(1.0,  
			    cos( radians(".$latitude.") ) 
			    * cos( radians(latitude) ) 
			    * cos( radians(longitude) - radians(".$longitude.") ) 
			    + sin( radians(".$latitude.") ) 
			    * sin( radians(latitude) 
			  ) ) ) 
			), 2) ) AS distance ";
		$query->addSelect(\DB::raw($lat_lng));
		if($cityFilter){
			$query->where('city','like',$request->city);
		} else {
			$radius = $request->input('distance') !== null && $request->input('distance') !== '' ? $request->distance : \AbserveHelpers::getkm();
			$query->having('distance', '<=' , $radius);
		}
		$query->orderBy('show','desc');
		$itemQuery = clone $query;

		if($request->input('dish') !== null && $request->dish != ''){
			$dish = $request->dish;
			$itemQuery->where(function($subquery)use($dish){
				$subquery->where('abserv_restaurant.name','like', '%' . $dish . '%');
				$subquery->orWhereRaw('(SELECT COUNT(id) FROM abserve_hotel_items WHERE abserve_hotel_items.restaurant_id = abserve_restaurants.id AND abserve_hotel_items.food_item like %'.$dish.'% AND abserve_hotel_items.del_status = 0 AND abserve_hotel_items.approveStatus = "Approved") > 0');
			});
		}

		if($request->input('cuisines') !== null && $request->cuisines != '' && $request->cuisines != '0'){
			$aSelCuisines = explode(',',$request->cuisines);
			if(count($aSelCuisines) > 0){
				$itemQuery->where(function($subquery) use($aSelCuisines){
					foreach ($aSelCuisines as $key => $value) {
						if($key > 0){
							$subquery->orWhereRaw('FIND_IN_SET(?,cuisine)', [$value]);
						} else {
							$subquery->whereRaw('FIND_IN_SET(?,cuisine)', [$value]);
						}
					}
				});
			}
		}

		if($request->input('budget') !== null && $request->budget != ''){
			if($request->budget == 3)
			{
				$arr = array( '4' , $request->budget); 
				$itemQuery->whereIn('id',$arr);
			}else
			{
				$itemQuery->where('budget',$request->budget);
			}
		}
		if($request->input('categories') !== null && $request->categories != '')
		{
			$categories = explode(',',$request->categories);
			if(count($categories) > 0)
			{
				$aCategories = \DB::table('abserve_food_categories')->select(\DB::raw('GROUP_CONCAT(`id`) as catids'))->whereIn('id',$categories)->where('root_id','=',0)->where('del_status',0)->first();
				$sCatIds = $aCategories->catids;
				if($aCategories != '')
				{
					$itemQuery->whereRaw('(SELECT COUNT(id) FROM abserve_hotel_items WHERE abserve_hotel_items.restaurant_id = abserve_restaurants.id AND abserve_hotel_items.del_status = 0 AND abserve_hotel_items.approveStatus = "Approved" AND abserve_hotel_items.main_cat IN ('.$sCatIds.') ) > 0');
				}
			}
		}
		if($request->input('ordering') !== null && $request->ordering != ''){
			if($request->ordering == '1'){
				$itemQuery->where('ordering',1);
			} 
		}

		if($request->input('show') !== null && $request->show != ''){
			if($request->show == '1'){
				$itemQuery->where('show',1);
			}
		}

		if($request->input('preorder') !== null && $request->preorder != ''){
			if($request->preorder == '1'){
				$itemQuery->where('preoder','yes');
			} 
		}

		if($request->input('restaurant_list') !== null && $request->restaurant_list != ''){
			$restaurant_list = explode(',', $request->restaurant_list);
				$itemQuery->whereIn('id',$restaurant_list);
		}
		if($request->input('sort_by') !== null && $request->sort_by != ''){
			if($request->sort_by == 'Distance'){
				$itemQuery->orderBy('distance');
			} elseif($request->sort_by == 'Rating'){
				$itemQuery->orderBy('rating','desc');
			} else {
				$itemQuery->orderBy('id','desc');
			}
		} else {
			$itemQuery->orderBy('distance');
		}

		if($request->input('rating') !== null && $request->rating >= 0){
			$itemQuery->where('rating','>=',$request->rating);
		}

		$restaurant = $itemQuery->offset($offset)->limit($perPage)->get()->map(function ($result) use ($user_id) {
	       	$result->append('src','availability','cuisine_text');
	       	$result->promo_status = $result->getPromoCheckAttribute($user_id);
	       	$result->favourite_status = $result->getFavouriteAttribute($user_id);
	       	return $result;
	    });

		$restaurant = $restaurant->toArray();
	    $response['restaurant'] = array_values($restaurant);
	    //Filter Master Datas
	    $aAllRestaurant = $query->get();
		$restaurantCount = count($aAllRestaurant);
		$aAllRestaurant = $aAllRestaurant->toArray();
		$response['restaurantCount'] = $restaurantCount;
		$response['max_radius'] = \AbserveHelpers::getkm();
		$response['totalPages'] = $restaurantCount > 0 ? round($restaurantCount / $perPage ) : 0;
		//At first time we will receive slider status = 1 from client side
		$first_status = $request->input('first_status') !== null && $request->first_status && $segment == 'home' ? true : false;
		if($first_status){
			$request_response = new request;
			$request_response['ordering'] = 1;
			$request_response['latitude'] = $request->latitude;
			$request_response['longitude']= $request->longitude;
			$request_response['show'] 	  = 1;
			$feature = $this->restaurantlist($request_response);
			$feature = $feature->getData();
			$response['FeaturedRestaurants'] = $feature->restaurant;
			if ($request->slider_city!='') {
				$locationDetail = \DB::table('location')->where('name','like','%'.$request->slider_city.'%')->first();
				$c_id=(isset($locationDetail) && $locationDetail->id !='') ? $locationDetail->id : '';
			} else {
				$c_id = $restaurant[0]['l_id'];
			}
			 $c_id = $c_id == '' ? isset($restaurant[0]['l_id']) : $c_id;
			/*$aSlider = Sliderimages::select('id','image','url as rest_id','ext_url')->where('status','active')->where(function($query) use ($c_id){
				if($c_id!=''){
					$query->whereRaw('FIND_IN_SET(?,l_id)', [$c_id])->ORwhereRaw('l_id IS NULL');
				}else{
					$query->orWhere('l_id','!=','');
				}

				})->get()->map(function ($slider) {
	        	return $slider->append('src','ext_url');
	    	});*/
			$aAllRestaurantIDS = implode(',',array_column($aAllRestaurant, 'id'));
			$coupons = \AbserveHelpers::getAvailablePromos('','','','','',$c_id);
			$promo_banner = [];
			foreach ($coupons as $zkey => $v) {
				$slideFile = base_path().'/uploads/slider/'.$v['avatar'];
					if($v['loc_res'] == 'loc')
					{
						$res_id 	= $aAllRestaurantIDS;
					}else
					{
						$res_id 	=   $v['res_id'];
					}
					$image = base_path().'/uploads/slider/'.$v['avatar'];
					if($v['avatar'] != '' && file_exists($image)){
						 $src = URL::to('/uploads/slider/'.$v['avatar']);
						 $image_name = $v['avatar'];
					}else
					{
						$src = URL::to('/uploads/images/Default_food.jpg');
						$image_name = 'Default_food.jpg';
					}
					array_push($promo_banner, 
						array(
							"image"	=>	$image,
							"id"	=>	$v['id'],
							"rest_id" =>  $res_id,
							"src" =>  $src,
							"ext_url" =>  $v['ext_url'],
						));
			}
			// $aSlider = array_merge($promo_banner,$aSlider->toArray());
			// $response['aSlider'] = $aSlider;
			$response['banner'] = Banner::get();
		}
		$response['offer_banne'] = $response['offer_terms'] = '';
		$offer	= (object) [];
		$offer	= \App\Models\Front\Offers::whereRaw('? between usage_from and usage_to', [date('Y-m-d')])->orWhereRaw('? between offer_from and offer_to', [date('Y-m-d')])->where('status','active')->first();
		    $date = date('Y-m-d');
            $date =date('Y-m-d', strtotime($date));
            $begindate = date('Y-m-d', strtotime("04/01/2022"));
            $enddate = date('Y-m-d', strtotime("04/20/2022"));
			// if(!empty($offer)) {
				if(($date >= $begindate) && ($date <= $enddate)){
				$response['offer_banne']= \URL::to('public/'.CNF_THEME.'/images/newyrapp.jpg');
				// $response['offer_terms']= \URL::to('/megaoffer?appview=1');
				$response['offer_terms']= "";
				}
			// }

		$response['demo'] = 0;
		if(CNF_DEMO == 'true' && $restaurantCount == 0 && $first_status){
			$response['demo'] = 1;
			$select = ['city'];
			$restaurantCities = \AbserveHelpers::getRestaurantBaseQuery($select)->groupBy('city')->get();
			$response['restaurantCities'] = $restaurantCities;
		}

		if($request->segment == 'search' && $request->locationChange == 1){
			$response['aDishes'] = Dishes::select('name','image')->get()->map(function ($dish) {
	        	return $dish->append('src');
	    	});

		}

		$response['aFilter'] = $this->getFilterArrays($aAllRestaurant);
		$fieldData	= \AbserveHelpers::getCurrentUserFieldVal($request);
		$aCart		= Usercart::select(\DB::raw('CONVERT(COUNT(`quantity`),CHAR(50)) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),'res_id')->where($fieldData['field'],$fieldData['fieldVal'])->first();
		$aCart->append('restaurant_name');
		$response['aCart'] = $aCart;

		return \Response::json($response,200);
	}

	function homePage( Request $request)
	{
		request()->merge(['from'=>'api']);
		$response	= \App::call('App\Http\Controllers\Front\SearchController@Search')->getData();
		$offer		= (object) [];
		if(!isset($request->device) && $request->device != 'android'){
			$response['offer_banne']	= $response['offer_terms']	= '';
		}
		$fieldData	= \AbserveHelpers::getCurrentUserFieldVal($request);
		$aCart		= Usercart::select(\DB::raw('CONVERT(COUNT(`quantity`),CHAR(50)) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),'res_id')->where($fieldData['field'],$fieldData['fieldVal'])->first();
		$aCart->append('restaurant_name');
		if($request->user_id != ''){
			$getlastorderid= OrderDetail::where('cust_id',$request->user_id)->latest()->where('status','!=','4')->where('status','!=','5')->pluck('id')->first();
			if($getlastorderid != ''){	
				$lastorderid['id'] = strval($getlastorderid);
				$lastorderid['status'] = '1';
			}else{
				$lastorderid['id'] = '';
				$lastorderid['status'] = '0';
			}			
		}else{
			$lastorderid['id'] = '';
			$lastorderid['status'] = '0';
		}
		$currentDay = date('Y-m-d');
		$banner	= \DB::table('abserve_promocode')->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->select('id','promo_name','promo_desc','promo_type','promo_amount','res_id','promo_code','min_order_value','avatar')->get()->map(function($data){
			$data->avatar = URL('uploads/slider/'.$data->avatar);
			return $data;
		});
		if($banner->isEmpty()){
			$banner	= Banner::get()->map(function($ban){
				$ban->promo_name = '';
				$ban->promo_desc = '';
				$ban->promo_type = '';
				$ban->promo_amount = 0;
				$ban->res_id = '';
				$ban->promo_code = '';
				$ban->min_order_value = 0;
				$ban->avatar = $ban->src;
				$ban->makeHidden(['src','image','created_at','updated_at']);
				return $ban;
			});
		}
		$response['banner'] = $banner;
		$offer		= Offers::whereRaw('? between usage_from and usage_to', [date('Y-m-d')])->orWhereRaw('? between offer_from and offer_to', [date('Y-m-d')])->where('status','active')->first();
		$date		= date('Y-m-d');
		$date		= date('Y-m-d', strtotime($date));
		$begindate	= date('Y-m-d', strtotime("03/31/2022")); 
		$enddate	= date('Y-m-d', strtotime("04/20/2022"));
		if(!isset($request->device) && $request->device != 'android'){
			$response['lastorderid'] = $lastorderid;
			$response['aCart']	= $aCart;
			if(($date >= $begindate) && ($date <= $enddate)){
				$response['offer_banne']= \URL::to('public/'.CNF_THEME.'/images/newyrapp.jpg');
				$response['offer_terms']= "";
			}
			$response['max_radius']	= \AbserveHelpers::getkm();
			$response['aFilter']	= $this->getFilterArrays();
		}
		$response['notification_count'] = \DB::table('user_notification')->where('user_id', $request->user_id)->where('status', 0)->count();
		return \Response::json($response,200);
	}

	function getFilterArrays($restaurant = [])
	{
		if (!empty($restaurant)) {
			$cuisineList	= array_column($restaurant, 'cuisine');
			$aUniqueCuisine	= array_unique(explode(',', implode(',', $cuisineList)));
			$res_id			= array_column($restaurant, 'id');
		}
		$aCuisines		= Cuisines::select('id','name','image');
		$foodItem		= Fooditems::select(\DB::raw('GROUP_CONCAT(`main_cat`) as cat'))->where('del_status','0')->orderBy('id')->where('approveStatus','Approved');
		if (!empty($restaurant)) {
			$foodItem	= $foodItem->whereIn('restaurant_id',$res_id);
		}
		$foodItem		= $foodItem->first();
		$fCategory		= Foodcategories::select('id','cat_name')->where('type','category')->where('root_id',0)->where('del_status','0');

		if (!empty($restaurant)) {
			if (!empty($foodItem))
				$fCategory	= $fCategory->whereIn('id',array_unique(explode(',', $foodItem->cat)));
			$aCuisines	= $aCuisines->whereIn('id',$aUniqueCuisine);
		}
		$aCuisines		= $aCuisines->get()->makeHidden('image ')->append('src');
		$fCategory		= $fCategory->get();

		$filter[0]['filter_name']	= 'Sort-by';
		$filter[1]['filter_name']	= 'Rating';
		$filter[2]['filter_name']	= 'Cusines';
		$filter[3]['filter_name']	= 'Categories';

		for ($i=0; $i < 2; $i++) { 
			$filter[0]['filter_values'][$i]['id']	= $i+1;
			$filter[0]['filter_values'][$i]['name']	= ($i == 0) ? 'Distance' : 'Rating';
		}
		for ($i=0; $i < 5; $i++) {
			$val	= $i+1;
			$filter[1]['filter_values'][$i]['id']	= $val;
			$filter[1]['filter_values'][$i]['name']	= "$val";
		}
		$filter[2]['filter_values'] = $aCuisines;
		foreach ($fCategory as $key => $value) {
			$filter[3]['filter_values'][$key]['id']		= $value->id;
			$filter[3]['filter_values'][$key]['name']	= $value->cat_name;
		}

		$aFilter = json_decode(json_encode($filter));
		return $aFilter;
	}

	function searchRestaurantDish(Request $request)
	{
		$rules['latitude'] 	= 'required';
		$rules['longitude']	= 'required';
		if($request->input('city') !== null && $request->city != ''){
			$cityFilter = true;
			$rules = [];
		} else {
			$cityFilter = false;
			
		}
		$rules['for'] = 'required|in:search,searchview';
		$rules['keyword'] = 'required';

		$this->validateDatas($request->all(),$rules);

		$segment = $request->segment;		

		$user_id = $request->input('user_id') !== null && $request->user_id > 0 ? $request->user_id : 0;

		$query = \AbserveHelpers::getRestaurantBaseQuery();

		$latitude = $request->latitude;
		$longitude = $request->longitude;
		$lat_lng = " ( round( 
			  ( 6371 * acos( least(1.0,  
			    cos( radians(".$latitude.") ) 
			    * cos( radians(latitude) ) 
			    * cos( radians(longitude) - radians(".$longitude.") ) 
			    + sin( radians(".$latitude.") ) 
			    * sin( radians(latitude) 
			  ) ) ) 
			), 2) ) AS distance ";
		$query->addSelect(\DB::raw($lat_lng));

		if($cityFilter){
			$query->where('city','like',$request->city);
		} else {
			$radius = $request->input('distance') !== null ? $request->distance : \AbserveHelpers::getkm();
			$query->having('distance', '<=' , $radius);
		}
		$query->orderBy('show','desc');
		$status = 422;
		$keyword = addslashes($request->keyword);
		$resQuery = clone $query;
		$restaurant = $query->addSelect('id')->get();
		if(count($restaurant)> 0){
			$status = 200;
			$aResIds = [];
			$arrRestaurant = $restaurant->toArray();
			$aResIds = array_column($arrRestaurant, 'id');
			if($request->for == 'search'){
				$foodItemQuery = Fooditems::select('id as food_id','food_item as name','image','restaurant_id','strike_price')->whereIn('restaurant_id',$aResIds)->where('del_status','0')->orderBy('id')->where('approveStatus','Approved');

				$foodItemQueryTemp = clone $foodItemQuery;

				$aFoodItems = $foodItemQuery->where('food_item','like', $keyword )->limit(10)->get()->map(function ($result) {
				       	$result->append('src','availability');
				       	return $result;
				    });
				if(count($aFoodItems) > 0) {
					$response['searchList'] = $aFoodItems;
					$response['type'] = 'Dish';
				} else {
					$resQuery->addSelect('id as restaurant_id','name','logo');
					$resTempQuery = clone $resQuery;
					$aRestaurant = $resQuery->where('name','like', $keyword )->limit(10)->orderBy('id')->get()->map(function ($result) {
				       	$result->append('src','availability');
				       	$result->promo_status = $result->getPromoCheckAttribute($user_id);
				       	$result->favourite_status = $result->getFavouriteAttribute($user_id);
				       	return $result;
				    });
				    if(count($aRestaurant) > 0){
						$response['searchList'] = $aRestaurant;
						$response['type'] = 'Restaurant';
					} else {
						$aFoodItems = $foodItemQueryTemp->where('food_item','like', '%'. $keyword .'%')->limit(10)->orderBy('id')->get()->map(function ($result) {
						       	$result->append('src','availability');
						       	return $result;
						    });
						if(count($aFoodItems) > 0) {
							$response['searchList'] = $aFoodItems;
							$response['type'] = 'Dish';
						} else {
							$aRestaurant = $resTempQuery->where('name','like', '%'. $keyword .'%')->limit(10)->orderBy('id')->get()->map(function ($result) {
						       	$result->append('src','availability');
						       	$result->promo_status = $result->getPromoCheckAttribute($user_id);
						       	$result->favourite_status = $result->getFavouriteAttribute($user_id);
						       	return $result;
						    });
							$response['searchList'] = $aRestaurant;
							$response['type'] = count($aRestaurant) > 0 ? 'Restaurant' : 'Empty';
						}
					}
				}
			} elseif($request->for == 'searchview'){
				$user_id = $request->input('user_id') !== null && $request->user_id > 0 ? $request->user_id : 0;
				$device_id = $request->input('device_id') !== null && $request->device_id != '' ? $request->device_id : '';
				//Dish Details
				$aFoodItems = Fooditems::select('id','restaurant_id','food_item','strike_price')->whereIn('restaurant_id',$aResIds)->where('del_status','0')->where('approveStatus','Approved')
				->where(function($query) use($keyword){
					$query->where('food_item','like',  $keyword );
					$query->orWhere('food_item','like', '%'. $keyword .'%' );
				})
				->orderByRaw('(case 
					when (food_item LIKE "'.$keyword.'") then 1 
					when food_item LIKE "%'.$keyword.'%" then 2
					end)'
				)
				->groupBy('restaurant_id')
				->get()->map(function ($result) use($device_id,$user_id,$keyword){
					$result->restaurant_detail = $result->getRestaurantInfoAttribute($device_id,$user_id);
			       	$result->food_item_view = $result->getFoodItemsSearchAttribute($device_id,$user_id,$keyword);
			       	return $result;
			    });

			    //Fooditem Details
			    $cuisine =  \DB::table('abserve_food_cuisines')->select('id')->where('name',$keyword)->first();
				$aRestaurant = $resQuery->addSelect('id','name','location','logo','partner_id','delivery_time','budget','rating','res_desc','mode','delivery_time','cuisine','l_id','show','preoder')
					->where(function($query) use($keyword,$cuisine){
						if(!empty($cuisine))
						{
							$query->WhereRaw('FIND_IN_SET(?,cuisine)', [$cuisine->id]);
						}else
						{
							$query->where('name','like',  $keyword );
							$query->orWhere('name','like', '%'. $keyword .'%' );
							$query->orWhereRaw("(SELECT COUNT(id) FROM `abserve_hotel_items` WHERE `abserve_hotel_items`.`restaurant_id` = `abserve_restaurants`.`id` AND `del_status` = '0' AND `approveStatus` = 'Approved' AND `food_item` LIKE '".$keyword."' ) > 0 ");
							$query->orWhereRaw("(SELECT COUNT(id) FROM `abserve_hotel_items` WHERE `abserve_hotel_items`.`restaurant_id` = `abserve_restaurants`.`id` AND `del_status` = '0' AND `approveStatus` = 'Approved' AND `food_item` LIKE '%".$keyword."%' ) > 0 ");
						}
					})
					->orderByRaw('(case 
						when ( name LIKE "'.$keyword.'" ) then 1 
						when ( name LIKE "%'.$keyword.'%" ) then 2
						when ((SELECT COUNT(id) FROM `abserve_hotel_items` WHERE `abserve_hotel_items`.`restaurant_id` = `abserve_restaurants`.`id` AND `del_status` = "0" AND `approveStatus` = "Approved" AND `food_item` LIKE "'.$keyword.'" ) > 0) then 3
						when ((SELECT COUNT(id) FROM `abserve_hotel_items` WHERE `abserve_hotel_items`.`restaurant_id` = `abserve_restaurants`.`id` AND `del_status` = "0" AND `approveStatus` = "Approved" AND `food_item` LIKE "%'.$keyword.'%" ) > 0) then 4
						end)'
					)
					->orderBy('show','desc')
					->get()->map(function ($result) use($device_id,$user_id) {
				       	$result->append('src','availability','cuisine_text');
				       	$result->promo_status 		= $result->getPromoCheckAttribute($user_id);
				       	$result->favourite_status 	= $result->getFavouriteAttribute($user_id);
				       	$result->cart_exist 		= $result->getCartExistCheckAttribute($device_id,$user_id);
				       	return $result;
				    });
				$response['aRestaurant'] = $aRestaurant;
				$response['aFoodItems'] = $aFoodItems;
			}
		} else {
			$response['message'] = 'No shops found';
		}
		$fieldData = \AbserveHelpers::getCurrentUserFieldVal($request);

		$aCart = Usercart::select(\DB::raw('CONVERT(COUNT(`quantity`),CHAR(50)) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),'res_id','strike_price')->where($fieldData['field'],$fieldData['fieldVal'])->first();
		$aCart->append('restaurant_name');
		$response['aCart'] = $aCart;
		return \Response::json($response);
	}

	function restaurantold(Request $request)
	{
		$rules['restaurant_id'] = 'required';
		$rules['device_id'] = 'required';
		$rules['latitude'] 	= 'required';
		$rules['longitude']	= 'required';
		if ($request->input('city') !== null && $request->city != '') {
			$cityFilter	= true;
			$rules		= [];
		} else {
			$cityFilter	= false;
		}
		$this->validateDatas($request->all(),$rules);

		/* Notes :

		For the first time  , you wont get main_cat and food count, For the second time you will get main_cat and food count which is sent in response, and this is last object main_cat and food count in "catFoodItems" collection; By using this we will set offset, This is for pagination purpose only. If main mategory contiued in next api, then foodcount added with previous api foodcount (from request you will get)

		For the first time only , total page count will be send.

		*/
		$device_id		= $request->device_id;
		$user_id		= $request->input('user_id') !== null && $request->user_id > 0 ? $request->user_id : '0';
		$iRestaurantId	= $request->restaurant_id;
		$select			= ['id','name','logo','rating','res_desc','show','src']; 
		$where			= 'where';$whereCondition = '';$whereField = 'id';$whereValues = $iRestaurantId;
		$restaurantQuery= \AbserveHelpers::getRestaurantBaseQuery($select,$where,$whereCondition,$whereField,$whereValues);
		$latitude	= $request->latitude;
		$longitude	= $request->longitude;
		// $lat_lng	= " ( round( 
		// 	  ( 6371 * acos( least(1.0,  
		// 	    cos( radians(".$latitude.") ) 
		// 	    * cos( radians(latitude) ) 
		// 	    * cos( radians(longitude) - radians(".$longitude.") ) 
		// 	    + sin( radians(".$latitude.") ) 
		// 	    * sin( radians(latitude) 
		// 	  ) ) ) 
		// 	), 2) ) AS distance ";
		// $restaurantQuery->addSelect(\DB::raw($lat_lng));

		if ($cityFilter) {
			// $restaurantQuery->where('city','like',$request->city);
		} else {
			$radius = $request->input('distance') !== null ? $request->distance : \AbserveHelpers::getkm();
		}

		$restaurant	= $restaurantQuery->first();
		$Rcount		= 0;/*Fooditems::select('id')->where('restaurant_id',$iRestaurantId)->where('recommended',1)->where('del_status','0')->where('approveStatus','Approved')->count();*/
		if(empty($restaurant)){
			return response()->json(['message'=>'Shop Not found'],422);
		}
		$restaurant->append('banner');
		$restaurant->favourite_status	= $restaurant->getFavouriteAttribute($user_id);
		// $restaurant->promo_status		= $restaurant->getPromoCheckAttribute($user_id);
		$restaurant->promocode			= $restaurant->getPromoCodeAttribute($user_id);
		// $restaurant->cart_exist			= $restaurant->getCartExistCheckAttribute($device_id,$user_id);
		// $restaurant->reviewCount		= $restaurant->getReviewCount($iRestaurantId);
		$catString = [];
		$main_cat = Hotelitems::select(\DB::raw('GROUP_CONCAT(DISTINCT(main_cat)) as categories'))->where('restaurant_id',$iRestaurantId)->first();
		if (!empty($main_cat)) {
			$catString = $main_cat->categories;
		}
		$shop_cate	= Restaurant::find($iRestaurantId,['shop_categories']);
		if(!preg_match('/[0-9]/', $shop_cate->shop_categories)){ $shop_cate->shop_categories = ''; }/////TEMP FIX
		if (trim($shop_cate->shop_categories) != '') {
			$catString = $shop_cate->shop_categories;
		}
		if ($catString != '') {
			$cate_list_shop	= Foodcategories::select('*')->whereIn('id',explode(",",$catString))->orderByRaw('FIELD(id,'.$catString.')')->get();
		}
		// This is for pagnation
		$reqMainCat		= $request->input('main_cat') !== null && $request->main_cat > 0 ? $request->main_cat : 0;
		// In app screen there is an search for category id alone,
		$reqCategoryId	= $request->input('category_id') !== null && $request->category_id > 0 ?$request->category_id : 0;
		$reqFoodCount	= $request->input('foodcount') !== null && $request->foodcount > 0 ? $request->foodcount : 0;
		$catFoodItemsQuery	= Fooditems::select('main_cat')->where('restaurant_id',$iRestaurantId)->where('del_status','0')->where('approveStatus','Approved')->whereIn('main_cat',explode(",",$catString))->orderByRaw('FIELD(main_cat,'.$catString.')');
		$firstPageCheck		= $reqFoodCount > 0 ? false : true;

		if($request->input('dish') !== null && $request->dish != ''){
			$catFoodItemsQuery->where('food_item','like','%'.$request->dish.'%');
		}
		$pageCatId	= 0;
		if($reqMainCat > 0){
			$pageCatId	= $reqMainCat;
			$catFoodItemsQuery->where('main_cat','>=',$reqMainCat);
		} else if($reqCategoryId > 0) {
			$filter		= true;
			$pageCatId	= $reqCategoryId;
			$catFoodItemsQuery->where('main_cat','=',$reqCategoryId);
		}
		
		// $limit = 10;
		$foodCntQuery = clone $catFoodItemsQuery;
		$foodCatQuery = clone $catFoodItemsQuery;
		if($firstPageCheck){
			$cnt	= $foodCntQuery->count();
			// $response['totalPages'] = round($cnt/$limit);
			$category = $foodCatQuery->select('main_cat',\DB::raw('COUNT(id) as foodCount'))->groupBy('main_cat')->get()->map(function ($result) {
				$result->makeHidden('gst');
				return $result->append('main_cat_name');
			});
			if($Rcount > 0) {
				$temp	= $category[0];
				$category[0]	= new \stdClass();
				$category[0]->main_cat = 0;
				$category[0]->foodCount = $Rcount;
				$category[0]->main_cat_name = "Recommended";
				$category[count($category)] = $temp;
			}
			$response['aCateory'] = $category;
		}
		$catFoodItems	= $catFoodItemsQuery->groupBy('main_cat')->orderBy('main_cat')->get()->map(function ($result) {
	       	return $result->append('main_cat_name');
	    });
		$iCatCount		= count($catFoodItems);
		if($iCatCount == 0){
			return response()->json(['message'=>'Products Not found'],422);
		}
		$totalFoodCount	= 0;
		$device_id	= $request->input('device_id') !== null ? $request->device_id : '';
		$user_id	= $request->input('user_id') !== null && $request->user_id > 0 ? $request->user_id : '';
		$aCatFoodItems	= [];
		if ($iCatCount > 0) {
			if($Rcount > 0) {
				$catFoodItems[$iCatCount] = new \stdClass();
				$catFoodItems[$iCatCount]->main_cat = 0;
				$catFoodItems[$iCatCount]->main_cat_name = "Recommended";
			}
			$breakKey = '';
			foreach ($catFoodItems as $key => $value) {
				// if($limit > 0){
					/*
						"original_price" - Strike Price
						Show "price" If selling price is zero 
					*/
					$fquery = Fooditems::select('id','image','restaurant_id','food_item','description','selling_price','item_status','strike_price')->where('restaurant_id',$iRestaurantId);
						if($value->main_cat == 0)
						{
							$fquery = $fquery->where('recommended',1);
						}else
						{
							$fquery = $fquery->where('main_cat',$value->main_cat);
						}
					$fquery = $fquery->where('del_status','0')->where('approveStatus','Approved')->orderBy('id');

					if($request->input('dish') !== null && $request->dish != ''){
						$fquery->where('food_item','like','%'.$request->dish.'%');
					}

					// if($firstPageCheck || $pageCatId != $value->main_cat){
					// 	$offset = 0;
					// } else {
					// 	$offset = $reqFoodCount;
					// }

					// $fquery->limit($limit)->offset($offset);

					$food_items = $fquery->get()->map(function ($result) use($device_id,$user_id) {
						$res = new Request;
						$res['cookie_id'] = $device_id;
						$res['user_id'] = $user_id;
						$res['food_id'] = $result->id;
						$result->makeHidden('gst');
				       	$result->append('exact_src');
				       	$result->cart_detail = $result->getCartInfoAttribute($device_id,$user_id);
						$item = $this->postProductdetailview($res);
				       	$result->adon_type = $item['itemDetail'][0]->adon_type;
				       	// $result->unit 	   = $item['itemDetail'][0]->unit;
				       	$result->variation = $item['itemDetail'][0]->variation;
				       	// $result->selling_price = (float)$result->selling_price;
					       	return $result;
					    });

					$foodcount = count($food_items);
					if($foodcount > 0){	
						// $value->foodcount = $offset > 0 ? $offset+$foodcount : $foodcount;

						// $value->continution = $request->input('main_cat') !== null && $request->main_cat == $value->main_cat ? 1 : 0;

						$value->food_item_view = $food_items;

						// $limit -= $foodcount;

						$totalFoodCount += $foodcount;
						$aCatFoodItems[] = $value;
					} else {
						// $catFoodItems->forget($key);
					}
				// } else {
				// 	$breakKey = $key;
				// 	break;
				// }
			}
			// if($breakKey != '' && $breakKey >= 0){
			// 	$length = $iCatCount - 1;
			// 	for ($i=$breakKey; $i <= $length; $i++) { 
			// 		$catFoodItems->forget($i);
			// 	}
			// }
		}
		$response['restaurant']   = $restaurant;
		$response['food_item_baseUrl']   = URL::to('/').'/uploads/images/';
		if($Rcount > 0)
		{
			$count = $iCatCount;
			$temp = $aCatFoodItems[$count];
			$aCatFoodItems[$count] = $aCatFoodItems[0];
			$aCatFoodItems[0] = $temp;
		}
		request()->merge(['from'=>'api']);
		$fooditem = \App::call('App\Http\Controllers\Front\DetailsController@loadmore')->getData();
		$response['catFoodItems'] = $fooditem;
		// print_r($fooditem);exit();
		// $response['catFoodItems'] = $aCatFoodItems;
		// $Aitems = [];
		// $catFoodItems = (array)$catFoodItems->toArray();
		// $catFoodItems = json_decode(json_encode($catFoodItems), true);
		// foreach ($catFoodItems as $key => $value) {
		// 	if(is_array($value['food_item_view'])){
		// 		$Aitems = array_merge($Aitems,$value['food_item_view']);
		// 	}
		// }
		// $response['AllItems'] = $Aitems;

		$fieldData = \AbserveHelpers::getCurrentUserFieldVal($request);
		if($user_id == 1){
			dd($response);
		}
		// $aCart = Usercart::select(\DB::raw('COUNT(quantity) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),'res_id')->where($fieldData['field'],$fieldData['fieldVal'])->first();
		// $aCart->append('restaurant_name');
		// $response['aCart'] = $aCart;
		$request['addressChange'] = 0;
		$request['action'] = 'view';
		$result = $this->viewCart($request)->getData();
		$response['aCart'] = $result->aCart;

		return response()->json($response,200);
	}

	function restaurant(Request $request)
	{
		$rules['restaurant_id']	= 'required';
		$rules['device_id']		= 'required';
		$this->validateDatas($request->all(),$rules);
		$device_id		= $request->device_id;
		$user_id		= $request->input('user_id') !== null && $request->user_id > 0 ? $request->user_id : '0';
		$iRestaurantId	= $request->restaurant_id;
		$catString		= [];
		$main_cat		= Hotelitems::select(\DB::raw('GROUP_CONCAT(DISTINCT(main_cat)) as categories'))->where('restaurant_id',$iRestaurantId)->first();
		if (!empty($main_cat))
			$catString	= $main_cat->categories;
		$shop_cate		= Restaurant::find($iRestaurantId,['shop_categories']);
		if(!preg_match('/[0-9]/', $shop_cate->shop_categories)){ $shop_cate->shop_categories = ''; }
		if (trim($shop_cate->shop_categories) != '')
			$catString	= $shop_cate->shop_categories;
		if ($catString != '')
			$cate_list_shop	= Foodcategories::select('*')->whereIn('id',explode(",",$catString))->orderByRaw('FIELD(id,'.$catString.')')->get();
		$catFoodItemsQuery	= Fooditems::select('main_cat')->where('restaurant_id',$iRestaurantId)->where('del_status','0')->where('approveStatus','Approved')->whereIn('main_cat',explode(",",$catString))->orderByRaw('FIELD(main_cat,'.$catString.')');
		$category			= $catFoodItemsQuery->select('main_cat',\DB::raw('COUNT(id) as foodCount'))->groupBy('main_cat')->get()->map(function ($result) {
			$result->makeHidden('gst');
			return	$result->append('main_cat_name');
		});
		$select	= ['id','name','logo','rating','res_desc','show']; 
		$where	= 'where'; $whereCondition = ''; $whereField = 'id'; $whereValues = $iRestaurantId;
		$restaurantQuery= \AbserveHelpers::getRestaurantBaseQuery($select,$where,$whereCondition,$whereField,$whereValues);
		$restaurant		= $restaurantQuery->first();
		if (empty($restaurant))
			return response()->json(['message' => 'Shop Not found'],422);

		$restaurant->append('banner','src');
		$restaurant->favourite_status	= $restaurant->getFavouriteAttribute($user_id);
		$restaurant->promocode			= $restaurant->getPromoCodeAttribute($user_id);
		if (!isset($request->category_id) && ($request->category_id == 0 || $request->category_id == '')) {
			$request->category_id	= $category[0]->main_cat;
		}
		request()->merge(['from' => 'api','shop_id' => $iRestaurantId,'user_id' => $user_id,'device_id' => $device_id]);
		$products = \App::call('App\Http\Controllers\Front\DetailsController@loadmore')->getData();
		$response['aCateory']			= $category;
		$response['restaurant']			= $restaurant;
		$response['food_item_baseUrl']	= URL::to('/').'/uploads/images/';
		$response['products']			= $products;
		$request['addressChange']		= 0;
		$request['action']				= 'view';
		$result				= $this->viewCart($request)->getData();
		$response['aCart']	= $result->aCart;
		return response()->json($response,200);
	}	

	function productsearch(Request $request)
	{
		$rules['restaurant_id']	= 'required';
		$rules['search_val']	= 'required';
		$rules['device_id']	= 'required';
		$rules['user_id']	= 'required';
		$this->validateDatas($request->all(),$rules);
		// $fooditems		= Fooditems::commonselect()->notdeleted()->approved()->where('restaurant_id',$request->restaurant_id)->where('food_item', 'like', '%'.$request->search_val.'%')->get();
		$fooditems		= Fooditems::commonselect()->notdeleted()->approved()->where('restaurant_id',$request->restaurant_id)->orderBy(DB::raw('CASE
							    WHEN food_item regexp "(^|[[:space:]])'.$request->search_val.'([[:space:]]|$)" THEN 1
							    WHEN food_item LIKE "'.$request->search_val.'%" THEN 2
							    WHEN food_item LIKE "%'.$request->search_val.'%" THEN 3
							    ELSE 4
							END'))
				->limit(50)->get();
		$device_id = $request->device_id;
		$user_id   = $request->user_id;
		$fooditems = $fooditems->map(function ($result) use($device_id,$user_id) {
			$res 	   = new Request;
			$res['cookie_id'] = $device_id;
			$res['user_id']   = $user_id;
			$res['food_id']   = $result->id;
			$result->append('exact_src');
			$result->cart_detail = $result->getCartInfoAttribute($device_id,$user_id);
			$item = self::postProductdetailview($res);
			$result->variation = $item['itemDetail'][0]->variation;
			return $result;
		});
		$response['fooditems']		= $fooditems;
		return \Response::json($response);
	}	

	function saveSearchKeyword(Request $request)
	{
		$rules['device_id'] = 'required';
		if($request->action !== null && $request->action == 'clear'){
		} else {
			$rules['keyword'] = 'required';
			if($request->input('food_id') !== null && $request->food_id > 0){
				$food_id = $request->food_id;
				$restaurant_id = 0;
			} else {
				$food_id = 0;
				$rules['restaurant_id'] = 'required';
				if($request->input('restaurant_id') !== null && $request->restaurant_id > 0){
					$restaurant_id = $request->restaurant_id;
				}
			}
		}

		$this->validateDatas($request->all(),$rules);

		$fieldData = \AbserveHelpers::getCurrentUserFieldVal($request);
		$user_id = $fieldData['user_id'];
		$device_id = $request->device_id;
		if($request->action !== null && $request->action == 'clear'){
			$query = UserSearchKeyword::query();
			if($request->clearId !== null && $request->clearId != ''){
				$aClearIds = explode(',', $request->clearId);
				$query->whereIn('id',$aClearIds);
			}
			$query->where(function($subquery) use($user_id,$device_id){
				$subquery->where('cookie_id',$device_id);
				if($user_id > 0){
					$subquery->orWhere('user_id',$user_id);
				}
			});
			$tempQuery = clone $query;
			if($query->count() == 0){
				$response['message'] = 'There is no search for this user';
			} else {
				$tempQuery->delete();
				$response['message'] = 'Removed successfully';
			}
		} else {

			$check = UserSearchKeyword::where($fieldData['field'],$fieldData['fieldVal'])->where('keyword','like',$request->keyword)->where('restaurant_id',$restaurant_id)->where('food_id',$food_id)->first();

			if(!empty($check)){
				$search = UserSearchKeyword::find($check->id);
				$search_count = $check->search_count + 1;
			} else {
				$search = new UserSearchKeyword;
				$search->created_at = date('Y-m-d H:i:s');
				$search_count = 1;
			}
			$search->user_id 		= $user_id;
			$search->cookie_id 		= $request->device_id;
			$search->keyword 		= $request->keyword;
			$search->search_count 	= $search_count;
			$search->food_id 		= $food_id;
			$search->restaurant_id 	= $restaurant_id;
			$search->updated_at 	= date('Y-m-d H:i:s');
			$search->save();

			$response['message'] = 'Saved successfully';
		}
		return \Response::json($response,200);
	}

	function savedSearchKeywords(Request $request)
	{
		$rules['device_id'] = 'required';

		$rules['latitude'] 	= 'required';
		$rules['longitude']	= 'required';
		if($request->input('city') !== null && $request->city != ''){
			$cityFilter = true;
			$rules = [];
		} else {
			$cityFilter = false;
		}

		$this->validateDatas($request->all(),$rules);

		$query = \AbserveHelpers::getRestaurantBaseQuery();

		$latitude = $request->latitude;
		$longitude = $request->longitude;
		$lat_lng = " ( round( 
			  ( 6371 * acos( least(1.0,  
			    cos( radians(".$latitude.") ) 
			    * cos( radians(latitude) ) 
			    * cos( radians(longitude) - radians(".$longitude.") ) 
			    + sin( radians(".$latitude.") ) 
			    * sin( radians(latitude) 
			  ) ) ) 
			), 2) ) AS distance ";
		$query->addSelect(\DB::raw($lat_lng));
		if($cityFilter){
			$query->where('city','like',$request->city);
		} else {
			$radius = $request->input('distance') !== null ? $request->distance : \AbserveHelpers::getkm();
			$query->having('distance', '<=' , $radius);
		}
		$restaurant = $query->first();

		$aResIds = explode(',', $restaurant->resids);

		$foodItems = Fooditems::select(\DB::raw('GROUP_CONCAT(id) as foodIds'))->whereIn('restaurant_id',$aResIds)->where('del_status','0')->where('approveStatus','Approved')->first();

		$aFoodIds	= explode(',', $foodItems->foodIds);
		$fieldData	= \AbserveHelpers::getCurrentUserFieldVal($request);
		$query		= UserSearchKeyword::select('id','keyword','restaurant_id','food_id');
		$device_id	= $request->device_id;
		$user_id	= $fieldData['user_id'];
		if($user_id > 0){
			$query->where('user_id',$user_id);
			// $query->where(function($subQuery) use($user_id,$device_id){
			// 	$subQuery->where('cookie_id',$device_id);
			// 	$subQuery->orWhere('user_id',$user_id);
			// });
		} else {
			$query->where('cookie_id',$request->device_id);
		}

		$query->where(function($subquery) use($aResIds,$aFoodIds){
			$subquery->whereIn('restaurant_id',$aResIds);
			$subquery->orWhereIn('food_id',$aFoodIds);
		});
		$query->limit(10);

		$queryTemp		= clone $query;
		$aTopSearch		= $query->orderBy('search_count')->get();
		$aRecentSearch	= $queryTemp->orderBy('updated_at')->get();
		$aCuisines		=  collect(\DB::table('abserve_food_cuisines')->select('id','name','image')->get());
		$aCuisines = $aCuisines->map(function($item, $key) {
			return [
				'id' => $item->id,
				'name' => $item->name,
				'image' => URL::to('/').'/uploads/cuisine/'.$item->image
			];
		});

		$response['aTopSearch']		= $aTopSearch;
		$response['aRecentSearch']	= $aRecentSearch;
		$response['aCuisines']		= $aCuisines;
		$aCart = Usercart::select(\DB::raw('CONVERT(COUNT(`quantity`),CHAR(50)) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),'res_id')->where($fieldData['field'],$fieldData['fieldVal'])->first();
		$aCart->append('restaurant_name');
		$response['aCart'] = $aCart;

		return \Response::json($response,200);
	}

	function cartAction(Request $request)
	{
		$rules['device_id'] = 'required';
		if ($request->input('action') !== null && $request->action == 'resdelete') {
		} else {
			$rules['food_id'] = 'required';
			if($request->action == 'itemnote'){
				$rules['item_note'] = 'required';
			}
		}
		$rules['action'] = 'required|in:add,remove,delete,resdelete,itemnote';
		$this->validateDatas($request->all(),$rules);

		$fieldData	= \AbserveHelpers::getCurrentUserFieldVal($request);
		$action		= $request->action;
		$ad_type	= isset($request->ad_type);
		$food_id	= $request->food_id;
		$user_id	= $fieldData['user_id'];
		$device_id	= $request->device_id;
		if($action != 'resdelete' && $action != 'delete') {
			/*Check for food item*/
			$aFoodItem = Fooditems::where('id',$food_id)->where('del_status','0')->where('approveStatus','Approved')->first();
			if(empty($aFoodItem)){
				Usercart::where($fieldData['field'],$fieldData['fieldVal'])->where('food_id',$food_id)->delete();
				$response['message'] = 'Product item not found';
				return \Response::json($response,422);
			}
			$aFoodItem->append('availability');

			/*Check for food Restaurat*/
			$select	= '';
			$where	= 'where'; $whereCondition	= ''; $whereField	= 'id'; $whereValues	= $aFoodItem->restaurant_id;
			$restaurant	= \AbserveHelpers::getRestaurantBaseQuery($select,$where,$whereCondition,$whereField,$whereValues)->first();
			if (empty($restaurant)) {
				$response['message'] = 'Shop Not Available';
				return \Response::json($response,422);
			}
			$restaurant->append('availability');
			if (empty($restaurant)) {
				Usercart::where($fieldData['field'],$fieldData['fieldVal'])->where('res_id',$aFoodItem->restaurant_id)->delete();
				$response['message'] = 'Shop not found';
				return \Response::json($response,422);
			}
		}

		/*Check restaurant and food available or not. If available proceed further else items will be deleted based on variable action*/
		if($action == 'add' &&  $aFoodItem->availability['status'] != 1 && !Usercart::where($fieldData['field'],$fieldData['fieldVal'])->where('food_id',$food_id)->exists()){
			$status = 422;
			$message = 'Currently unserviceable';
		} else {
			if($action == 'resdelete' || $action == 'delete' || ($aFoodItem->availability['status'] == 1/* && $restaurant->availability['status'] == 1*/)){
				$status = 422;
				if($action == 'delete' || $action == 'resdelete'){
					$status = 200;
					/*Delete item / items*/
					$del_query = Usercart::where($fieldData['field'],$fieldData['fieldVal']);
					if($action == 'delete'){
						$aFoodIds = explode(',', $food_id);
						$del_query->whereIn('food_id',$aFoodIds);
					}
					$del_temp_query = clone $del_query;
					if($del_temp_query->exists()){
						$del_query->delete();
						$message = $action == 'delete'? 'Item deleted successfully' : 'Items deleted successfully';
					} else {
			        	$aCart["total_price"] = $aCart["tax"] = $aCart["grandTotal"] = $aCart["delivery_charge"] = null;
			        	$response['aCart'] = $aCart;
			        	$response['message'] = $message;
						$message = $action == 'delete'? 'No such items in cart' : 'Empty cart';
						return \Response::json($response,422);
					}
				} else {
					/*Check for other restaurant cart. If exist other restaurant cart will be deleted if otherCartClear value is true else cartexist response will be send*/
					$otherCartCheck = Usercart::where($fieldData['field'],$fieldData['fieldVal'])->where('res_id','!=',$restaurant->id)->exists();

					if($otherCartCheck){
						if($request->input('otherCartClear') !== null && $request->otherCartClear == 'true'){
							Usercart::where($fieldData['field'],$fieldData['fieldVal'])->where('res_id','!=',$restaurant->id)->delete();
						} else {
							return \Response::json(['message'=>'cartExist'],$status);	
						}
					}
					/*Add or remove cart items*/
					$status = 200;
					$cart = Usercart::where($fieldData['field'],$fieldData['fieldVal'])->where('food_id',$food_id);
					if($request->ad_id != null && $request->ad_id != '')
					{
						$cart = $cart->where('adon_id',$request->ad_id);
						if($ad_type=='unit'){
							$addonF = \DB::table('tb_food_unit')->select('selling_price','original_price')->where('food_id', $food_id)->where('id', $request->ad_id)->first();
						}else if($ad_type=='variation'){
							$addonF = \DB::table('tb_food_variation')->select('selling_price','original_price')->where('food_id', $food_id)->where('id', $request->ad_id)->first();
						}
						$price = $addonF->price;
						$show_price = $addonF->selling_price;
					}else
					{
						$price = $aFoodItem->price;
						$show_price = $aFoodItem->selling_price;
					}
					$cart = $cart->first();
					$newQuantity = 0;
					if($action == 'remove'){
						if(!empty($cart) && $cart->quantity > 1){
							$newQuantity = $cart->quantity - 1;
						}
						$item_note = (!empty($cart)) ? $cart->item_note : '';
						$message = 'Item removed successfully';
					} elseif ($action == 'itemnote') {
						if(empty($cart)){
							return \Response::json(['message'=>'No such items in cart'],422);
						}
						$newQuantity = $cart->quantity;
						$item_note = $request->item_note;
						$message = 'Item Note Added successfully';
					} else {
						$newQuantity = ($request->status == 'from_reorder' && $request->quantity > 0) ? ((!empty($cart) && $cart->quantity > 0) ? $cart->quantity + $request->quantity : $request->quantity) : ((!empty($cart) && $cart->quantity > 0) ? ($cart->quantity + 1) : 1);
						$item_note = !empty($cart) ? $cart->item_note : '';
						$message = 'Item Added successfully';
					}
					if($newQuantity > 0){
						$update_device_id 		= $user_id > 0 ? '0' : $request->device_id;
						if(!empty($cart)){
							$usercart = Usercart::find($cart->id);
						} else {
							$usercart = new Usercart;
							$usercart->created_at = date('Y-m-d H:i:s');
							$cartCheck = \DB::table('abserve_user_cart')->where('user_id',$user_id)->where('cookie_id',$update_device_id)->where('res_id',$restaurant->id)->first();
							if(!empty($cartCheck)){
								$usercart->distance_km 	= $cartCheck->distance_km;
								$usercart->duration 	= $cartCheck->duration;
								$usercart->address_id 	= $cartCheck->address_id;
								$usercart->coupon_id 	= $cartCheck->coupon_id;
								$usercart->ordertype 	= $cartCheck->ordertype;
								$usercart->delivertype 	= $cartCheck->delivertype;
								$usercart->deliverdate 	= $cartCheck->deliverdate;
								$usercart->delivertime 	= $cartCheck->delivertime;
							}
						}
						/*In food item table "price" = vendor price;  */
						
						$usercart->user_id 		= $user_id;
						$usercart->cookie_id 	= $update_device_id;
						$usercart->res_id 		= $restaurant->id;
						$usercart->food_id 		= $aFoodItem->id;
						$usercart->food_item 	= $aFoodItem->food_item;
						$usercart->strike_price = $aFoodItem->strike_price;
						$usercart->price 		= $show_price;
						$usercart->vendor_price = $price;
						$usercart->quantity 	= $newQuantity;
						$usercart->adon_type 	= $ad_type;
						$usercart->adon_id	 	= $request->ad_id;
						$usercart->adon_details	= $request->adon_details == '0' ? "" : $request->adon_details ;
						$usercart->tax 			= 0;
						$usercart->item_note 	= $item_note;
						$usercart->updated_at 	= date('Y-m-d H:i:s');
						$usercart->save();
					} else {
						Usercart::where($fieldData['field'],$fieldData['fieldVal'])->where('food_id',$food_id)->delete();
					}
				}
				$aCart = Usercart::select(\DB::raw('CONVERT(COUNT(`quantity`),CHAR(50)) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),\DB::raw('GROUP_CONCAT(food_id) as food_ids'),'res_id','strike_price')->where($fieldData['field'],$fieldData['fieldVal'])->first();
				$aCart->append('restaurant_name');
				$device_id = $request->device_id;
				$fquery = Fooditems::select('id','restaurant_id','food_item','description','price','selling_price','original_price','status','start_time1','end_time1','start_time2','end_time2','item_status','image','strike_price')->whereIn('id',explode(',', $aCart->food_ids));
				$food_items = $fquery->get()->map(function ($result) use($device_id,$user_id) {
					$result->append('exact_src','availability','show_price');
					$result->cart_detail = $result->getCartInfoAttribute($device_id,$user_id);
					return $result;
				});
				$request['addressChange'] = 0;
				Usercart::where($fieldData['field'],$fieldData['fieldVal'])->update(['wallet'=> 0]);
				$result = $this->viewCart($request)->getData();
				$response['aCart'] = $result->aCart;
				$response['customer_wallet'] = $result->customer_wallet;
				$response['restaurant'] = $restaurant;
				$response['food_item_view'] = $food_items;
			} else {
				$status = 422;
				/*if($restaurant->availability['status'] != 1){
					$message = 'Shop not available';
				} else {*/
					$message = 'Product not available';
				// }
			}
		}
		$response['message'] = $message;
		return \Response::json($response,$status);
	}

	function viewCart(Request $request)
	{
		$orderCon			= new ordercon;	
		$rules['device_id']	= 'required';
		/* addressChange = 1 => Need to calculate distance, 2=> already calculated you will get distance in request,
			0 => address,distance provided
		 */
		$rules['addressChange'] = 'required|in:1,2,0';
		if($request->input('addressChange') !== null){
			if($request->addressChange == '1'){
				$rules['address'] = 'required';
			} else if($request->addressChange == '2'){
				$rules['distance'] = 'required';
			}
		}
		$this->validateDatas($request->all(),$rules);

		$fieldData	= \AbserveHelpers::getCurrentUserFieldVal($request);
		$user_id	= $fieldData['user_id'];
		$aUserCart	= Usercart::where($fieldData['field'],$fieldData['fieldVal'])->get();
		$iUserCart	= count($aUserCart);
		$status		= 422; $message	= ''; $unavailableFoodIds	= '';
		if($user_id != 0 && $user_id !=''){
			$response['customer_wallet']	= User::find($user_id,['id','customer_wallet'])->customer_wallet;
		}else{
			$response['customer_wallet']  = '';
		}
		if($iUserCart == 0){
			$message	= 'No items in cart';
			$aCart["total_quantity"] = $aCart["food_ids"] = $aCart["restaurant_name"] = $aCart["promocode"] =  '0';
			$aCart["res_id"] = $aCart["total_price"] = $aCart["del_charge_tax_price"] = $aCart["delivery_charge"] = $aCart["bad_weather_charge"]= $aCart["festival_mode_charge"] = $aCart["promoamount"] = $aCart["grandTotal"] = $aCart["tax"] = $aCart["package_charge"]	= 0;
			$response['aCart']		= $aCart;
		} else {
			$select	= ['id','name','logo','location','delivery_time','mode','minimum_order','free_delivery','city','l_id','latitude','longitude','service_tax1','budget','rating','res_desc','preoder as preorder'];
			$where	= 'where';$whereCondition = '';$whereField = 'id';$whereValues = $aUserCart[0]->res_id;
			$aRestaurant = \AbserveHelpers::getRestaurantBaseQuery($select,$where,$whereCondition,$whereField,$whereValues)->first();
			if(empty($aRestaurant)){
				$action = new Request;
				$action['user_id'] = $user_id;
				$action['device_id'] = $request->device_id;
				$action['action'] = 'resdelete';
				$this->cartAction($action);
				$message = 'Sorry! Shop is either Closed or Unavailable';
				$aCart["total_quantity"] = $aCart["food_ids"] = $aCart["restaurant_name"] = $aCart["promocode"] =  '0';
				$aCart["res_id"] = $aCart["total_price"] = $aCart["del_charge_tax_price"] = $aCart["delivery_charge"] = $aCart["bad_weather_charge"]= $aCart["festival_mode_charge"] = $aCart["promoamount"] = $aCart["grandTotal"] = $aCart["tax"] = $aCart["package_charge"] = 0;
        		$response['aCart'] = $aCart;
			// } else if($aRestaurant->availability['status'] != 1){
				// $message = 'Restaurant not available';
			} else {
				$aRestaurant->append('src','availability');
				$aRestaurant->promo_status = $aRestaurant->getPromoCheckAttribute($user_id);
				$itemPrice = $itemOriginalPrice = 0;$aFoodIds = [];
				foreach ($aUserCart as $key => $value) {
					$checkstatus = 1;
					$aFoodItem = Food::where('id',$value->food_id)->where('restaurant_id',$aRestaurant->id)->where('del_status','0')->where('approveStatus','Approved')->first();
					if(!empty($aFoodItem)){
						$aFoodItem->append('availability');
					}
					if(empty($aFoodItem)){
						$message = 'Product item not found';
						$checkstatus = 0;
						if($unavailableFoodIds != ''){
							$unavailableFoodIds .= ',';
						}
						$unavailableFoodIds .= $value->food_id;
					} else if(isset( $aFoodItem->availability['status']) && $aFoodItem->availability['status'] != 1){
						$message = 'Product item not available';
						$checkstatus = 2;
						if($unavailableFoodIds != ''){
							$unavailableFoodIds .= ',';
						}
						$unavailableFoodIds .= $value->food_id;
						$aFoodIds[] = $aFoodItem->id;
						$aCartItems[] = $value;
					} else {
						if($checkstatus){
							$itemPrice += ($value->food_price->selling_price * $value->quantity);
							$itemOriginalPrice += ($value->food_price->price  * $value->quantity);
							$aFoodIds[] = $aFoodItem->id;
							$aCartItems[] = $value;
						}
					}
				}
				if($checkstatus) {
					$device_id	= $request->input('device_id') !== null && $request->device_id != '' ? $request->device_id : '';
					$user_id	= $request->input('user_id') !== null && $request->user_id > 0 ? $request->user_id : 0;
					$status		= 200;
					$message	= $checkstatus == 2 ? $message : 'success';
					$final		= $ucart	= [];
					foreach ($aFoodIds as $ke => $ids) {
						$array = Food::/*select('id','restaurant_id','food_item','description','price','selling_price','original_price','status','available_from','available_to','available_from2','available_to2','item_status','image','strike_price')*/commonselect()->where('id',$ids)->where('restaurant_id',$aRestaurant->id)->where('restaurant_id',$aRestaurant->id)->where('del_status','0')->where('approveStatus','Approved')->get()->map(function ($result) use($device_id,$user_id,$aCartItems,$ke/*,$aCartadonIds*/) {
							$result->append('exact_src','availability','show_price');
							$result->cart_detail = $result->getCartInfoAttribute($device_id,$user_id,$aCartItems[$ke]->id);
							if($aCartItems[$ke]->adon_id != null) {
								if($aCartItems[$ke]->adon_type=='unit') {
									$addonF = \DB::table('tb_food_unit')->select('selling_price','original_price')->where('id', $aCartItems[$ke]->adon_id)->first();
								} elseif ($aCartItems[$ke]->adon_type=='variation') {
									$addonF = \DB::table('tb_food_variation')->select('selling_price','original_price')->where('id', $aCartItems[$ke]->adon_id)->first();
								}
								$result->original_price	= $addonF->original_price;
								$result->selling_price	= $addonF->selling_price;
								$result->show_price		= number_format(($addonF->selling_price * $aCartItems[$ke]->quantity) ,2,'.','');
							}
							return $result;
						})->toArray();
						$final = array_merge($array,$final);
					}
					$response['food_item_view'] = $final;
					//Delivery change calculation start
					$distCheck	= true;
					$validKm	= \AbserveHelpers::site_setting1('delivery_distance');
					$Cartdata	= Usercart::where($fieldData['field'],$fieldData['fieldVal'])->first();

					if($request->addressChange == '1' ) {
						// $dist['from_address'] 	= $aRestaurant->location;
						$dist['lat1'] 	= $aRestaurant->latitude;
						$dist['long1'] 	= $aRestaurant->longitude;
						$saveAddress = true;
						if($request->input('address_id') !== null && $request->input('address_id') != 'null' && $request->address_id > 0 && $user_id > 0){
							$aUserAddress = Useraddress::find($request->address_id);
							if($aUserAddress->user_id == $user_id){
								$saveAddress = false;
								// $dist['to_address'] 	= $aUserAddress->address;
								$dist['lat2'] 	= $aUserAddress->lat;
								$dist['long2'] 	= $aUserAddress->lang;
							} else {
								return \Response::json(['message'=>'This is not your address'],422);
							}
						} else { 
							if($request->save !== null && $request->input('save') == 0) {
								$saveAddress = false;
							}
							// $dist['to_address'] 	= $request->address;
							$dist['lat2'] 	= $request->lat;
							$dist['long2'] 	= $request->lang;
						}
						$dist['type']	= 'coordinates';
						$aDistanceDatas	= $orderCon->calculate_distance($dist);
						
						if ($aDistanceDatas['status'] && (($request->lat > 0 && $request->lang > 0) || ($request->lat < 0 && $request->lang < 0))) {
							if ($aDistanceDatas['total_km'] <= $validKm) {
								$distance	= $aDistanceDatas['total_km'];
								$seconds	= $aDistanceDatas['duration'] + ($aRestaurant->delivery_time * 60);
								$duration_text	= $orderCon->getReadabletimeFromSeconds($seconds);
								if($user_id > 0){
									if($saveAddress){
										$acheck = Useraddress::where('user_id',$user_id)->where('lat',$request->latitude)->where('lang',$request->longitude)->where('del_status','0')->first();
										if(!empty($acheck)){
											$useraddress = Useraddress::find($acheck->id);
										} else {
											$useraddress = new Useraddress;
											$useraddress->created_at = date('Y-m-d H:i:s');
										}
										$addressAveFields = ['user_id','address_type','building','landmark','address','lat','lang','city','state'];
										foreach ($addressAveFields as $key => $value) {
											$useraddress->{$value} = $request->input($value) !== null ? $request->{$value} : '';
										}
										$useraddress->del_status = '0';
										$useraddress->updated_at = date('Y-m-d H:i:s');
										$useraddress->save();
										$response['address_id'] = $useraddress->id;
										$response['address'] = $request->address;
										$ucart['address_id'] = $useraddress->id;
									} else {
										$response['address_id'] = $aUserAddress->id;
										$response['address'] = $aUserAddress->address;
										$ucart['address_id'] = $aUserAddress->id;
									}
									$ucart['distance_km'] = $distance;
									$ucart['duration'] = $aDistanceDatas['duration'];
									Usercart::where($fieldData['field'],$fieldData['fieldVal'])->update($ucart);
								}
							} else {
								return \Response::json(['message'=>'Sorry, we are unable to provide service at your location at this time!'],422);
							}
						} else {
							return \Response::json(['message'=>'Address not valid'],422);
						}
					} elseif($Cartdata->address_id > 0){
						$distance	= $Cartdata->distance_km;
						if($distance > $validKm) {
							return \Response::json(['message'=>'Sorry, we are unable to provide service at your location at this time!'],422);
						}
						$duration 				= $Cartdata->duration + ($aRestaurant->delivery_time / 160);
						$duration_text 			= $orderCon->getReadabletimeFromSeconds($duration);
					} else {
						$distCheck 				= false;
					}
					if($distCheck) {
						$response['distance'] = $distance;
						$response['duration_text'] = $duration_text;
						$tb_settings	= \DB::table('tb_settings')->first();
						if($aRestaurant->free_delivery == '1'){
							$f_del_Charge = $add_del_charge = 0;
						} else {
							$f_del_Charge = $tb_settings->upto_four_km;
							if($distance <= $tb_settings->km){
								$add_del_charge = 0;
							} else {
								$extraDistance 		= $distance - $tb_settings->km;
								$add_del_charge 	= $extraDistance * $tb_settings->per_km;
							}
						}
						$delivery_charge = number_format(($f_del_Charge + $add_del_charge),2,'.','');
					} else {
						$delivery_charge = 0.0;
						$response['distance'] = '';
						$distance = $response['distance'] ;
						$response['duration_text'] = '';
					}
					if($user_id == 4722){
						$distance = 0;
					}
					$aDelCharges = \AbserveHelpers::getDeliveryChargeValues($distance,$aRestaurant,$itemPrice);
					$delivery_charge		= $aDelCharges['delivery'];
					$del_charge_tax_price	= $aDelCharges['deliveryTax'];
					// $response['delivery_charge'] = (float) number_format($delivery_charge,2,'.','');

					//Delivery change calculation end
					//Promocode start
					$promoamount		=  (float) number_format(0,2,'.','');
					$ucart['coupon_id']	= 0;
					$promoRemove		= $request->input('promo_remove') !== null && $request->promo_remove == '1' ? true : false;
					$response['selectedCouponCode'] = '';
					$promoApply = false;
					if($user_id > 0 && !$promoRemove){
						$code = '';
						if($request->input('promo_code') !== null && $request->promo_code != ''){
							$code		= $request->promo_code;
							$promoApply	= true;
						} elseif ($aUserCart[0]->coupon_id > 0) {
							$promo = Promocode::find($aUserCart[0]->coupon_id);
							$code = !empty($promo) ? $promo->promo_code : '';
						}
						if($code != ''){
							$promoCheck = $aRestaurant->getCalculatePromoAmountAttribute($user_id,$code,$itemPrice);
							if($promoCheck['promoAmount'] > 0){
								$promoamount			= $promoCheck['promoAmount'];
								$ucart['coupon_id']		= $promoCheck['promoId'];
								$response['selectedCouponCode']	= $promoCheck['promoCode']->promo_code;
							}
						}
						if($promoApply){
							$message = $promoCheck['message'];
						}
					}
					if($promoRemove){
						$message = 'Coupon Removed';
					}
					//Promocode end
					if(count($ucart) > 0){
						Usercart::where($fieldData['field'],$fieldData['fieldVal'])->update($ucart);
					}
					$aCart	= Usercart::select(\DB::raw('CONVERT(COUNT(`quantity`),CHAR(50)) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),\DB::raw('GROUP_CONCAT(food_id) as food_ids'),'res_id','wallet','id','strike_price')->where($fieldData['field'],$fieldData['fieldVal'])->first();
					$aRestaurant->reviewCount = $aRestaurant->getReviewCount($aRestaurant->id);
					if($aRestaurant->service_tax1 > 0){
						$stax1 = number_format(($itemPrice * ($aRestaurant->service_tax1 / 100)),2,'.','');
					}
					$hostShare = $itemPrice - $promoamount;
					$aCart['total_price'] 	= (float) number_format($aCart['total_price'],2,'.','');
					$aCart['grozoOffer']	= (float) '0';$aCart['grozoOfferName']	='';
					if ($user_id > 0) {
						$offerData	= \AbserveHelpers::Offerdata($user_id,$aCart['total_price']);
						if($offerData['cashOffer'] > 0) {
							$aCart['grozoOffer']		= (float) $offerData['cashOffer'];
							$aCart['grozoOfferName']	= $offerData['OfferName'];
						}
					}

					$itemOfferPrice	= $itemOriginalPrice > $itemPrice ? $itemOriginalPrice - $itemPrice : 0;
					$itemSavedPrice	= $itemOfferPrice;
					$otherOffers	= $promoamount + $aCart['grozoOffer'];
					$itemSavedPrice	+= $otherOffers;
					$response['itemPrice']			= $itemPrice;
					$response['itemOriginalPrice']	= $itemOriginalPrice;
					$response['promoamount']	= (float) number_format($promoamount,2,'.','');
					$response['itemOfferPrice']	= $itemOfferPrice;
					$response['stax1']			= (float) number_format(0,2,'.','');
					$response['delivery_charge']= (float) number_format($delivery_charge,2,'.','');
					$response['delivery_charge_discount']	= (float) number_format(0,2,'.','');
					$response['del_charge_tax_price']	= (float) number_format($aDelCharges['deliveryTax'],2,'.','');
					$response['package_charge']			= (float) number_format(($aDelCharges['package'] + $aDelCharges['packageTax']),2,'.','');
					$response['festival_charge']		= (float) number_format(($aDelCharges['festival'] + $aDelCharges['festivalTax']),2,'.','');
					$response['weather_charge']		= (float) number_format(($aDelCharges['badWeather'] + $aDelCharges['badWeatherTax']),2,'.','');
					$response['savedPrice']	= $itemSavedPrice;
					$GtotalWithoutoff = $itemPrice + $aDelCharges['delivery'] + $aDelCharges['deliveryTax'] + $aDelCharges['package'] + $aDelCharges['packageTax'] + $aDelCharges['festival'] + $aDelCharges['festivalTax'] + $aDelCharges['badWeather'] + $aDelCharges['badWeatherTax'];

					/* Wallet Begin */
					if ((isset($request->wallet_amt) && $request->wallet_amt != '') && $request->wallet_amt <= $response['customer_wallet'] && $request->wallet_amt <= $GtotalWithoutoff) {
						$walletResult = self::ApplyWallet($request,$user_id,$fieldData);
						if (!$walletResult) { return \Response::json(['message'=>'Not Applicable....','data'=>$walletResult],422); }
						$response['customer_wallet'] = (float) $walletResult['customer_wallet'];
						$aCart['wallet'] 			 = (float) $walletResult['wallet'];
					} else {
						$response['customer_wallet'] = ($aCart['wallet'] > 0) ? ( $response['customer_wallet'] - $aCart['wallet'] ) :  $response['customer_wallet'] ;
					}
					/* Wallet End */
					$grandTotal = ( $GtotalWithoutoff ) - $promoamount - $aCart['wallet'] - $aCart['grozoOffer'];
					$response['grandTotal']	= (float) number_format($grandTotal,2,'.','');
					$response['restaurant']	= $aRestaurant;
					$userSelect		= ['username','email','phone_number'];
					$response_aUser	= $user_id > 0 ? User::find($user_id,$userSelect) : null;
					if(!empty($response_aUser) && $request->phone_number != ''){
						$response_aUser->phone_number = $request->phone_number;
					}
					$response['aUser']				= $response_aUser;
					$response['customer_wallet']    =(String) $response['customer_wallet'];
					$aCart->append('restaurant_name');
					$aCart['tax']					= $response['stax1'];
					$aCart['grandTotal']			= (float) number_format($response['grandTotal'],2,'.','');
					$aCart['bad_weather_charge']	= (float) number_format($response['weather_charge'],2,'.','');
					$aCart['festival_mode_charge']	= (float) number_format($response['festival_charge'],2,'.','');
					$aCart['package_charge']		= $response['package_charge'];
					$aCart['delivery_charge']		= (float) number_format($response['delivery_charge'],2,'.','');
					$aCart['del_charge_tax_price']	= $response['del_charge_tax_price'];
					$aCart['promocode']				= $response['selectedCouponCode'] != '' ? $response['selectedCouponCode']:null;
					$aCart['promoamount']			= $response['promoamount'] != '' ? $response['promoamount']:null;
				}
			}
		}

		$response['message']				= $message;
		$response['customer_phone_number']	= (string) User::select('phone_number')->where('id',$user_id)->pluck('phone_number');
		$response['unavailableFoodIds']		= $unavailableFoodIds;
		$offers = Offers::whereRaw('? between usage_from and usage_to', [date('Y-m-d')])->orWhereRaw('? between offer_from and offer_to', [date('Y-m-d')])->where('status','active')->first();
		$response['mega_offer']	= $aCart['mega_offer'] = (!empty($offers)) ? \URL::to('mega-offer?appview=1') : '' ;

		$response['aCart']				= $aCart;

		return \Response::json($response,$status);
	}

	public function ApplyWallet($request,$user_id,$fieldData)
	{
		$customer_wallet	= User::select('customer_wallet')->where('id',$user_id)->pluck('customer_wallet');
		$ucart['wallet']	= $request->wallet_amt;
		Usercart::where($fieldData['field'],$fieldData['fieldVal'])->update($ucart);
		request()->merge(['from' => 'mobile','amount' => $request->wallet_amt,'user_id' => $request->user_id,'device_id' => $request->device_id,'customer_wallet'=> $customer_wallet]);
		$updateWallet			= (\App::call('App\Http\Controllers\Front\CheckoutController@postUpdatewallet')->getData());
		if ($updateWallet->status != 1) { return false; }
		$result['customer_wallet']	= $customer_wallet[0] - $request->wallet_amt;
		$result['wallet'] 			= $ucart['wallet'];
		return $result;
	}

	public function postProductdetailview(Request $request)
	{
		$response = array();
		$user_id=$request->user_id;
		$cookie_id=$request->cookie_id;
		$itemDetail=\DB::table('abserve_hotel_items')->select('id','restaurant_id','food_item','description','price','image','adon_type')->where('id',$request->food_id)->get();

			foreach ($itemDetail as $key => $value) {
				$restaurantDet=\DB::table('abserve_restaurants')->select('minimum_order')->where('id',$value->restaurant_id)->first();
				$value->minimum_order=($restaurantDet->minimum_order!='') ? $restaurantDet->minimum_order : '0';
				
				$value->description=($value->description!='') ? str_replace(array("\n\r","\\n", "\n", "\r","\t","<p>",'</p>'), '',strip_tags($value->description)) : '';
				$value->quantity=(int)\AbserveHelpers::foodcheck_app($value->id,'','',$user_id,$cookie_id);

				$value->available_status = (int)\AbserveHelpers::getItemTimeValid($value->id);
					if(\AbserveHelpers::gettimeval($value->id)==0){
						$value->next_available_time = \AbserveHelpers::getNextAvailableTimeRes($value->restaurant_id,'1');
					}else{
						$currentDay = date('D');
						$aDayInfo = \DB::table('abserve_days')->select('*')->where('value',$currentDay)->first();
						$rest_times = \DB::table('abserve_restaurant_timings')->select('*')->where('res_id','=',$value->id)->where('day_id',$aDayInfo->id)->get();
						if($rest_times!=''){
							if($rest_times[0]->day_status=='1'){
								if($rest_times[0]->start_time1!='' && $rest_times[0]->end_time1!='' && $rest_times[0]->start_time1==$rest_times[0]->end_time1){
									$value->next_available_time='24 Hours';
								}else{
									if($rest_times[0]->start_time2!='' && $rest_times[0]->end_time2!=''){
										$value->next_available_time=$rest_times[0]->start_time1." to ".$rest_times[0]->end_time1."<br>".$rest_times[0]->start_time2." to ".$rest_times[0]->end_time2;
									}else{
										$value->next_available_time=$rest_times[0]->start_time1." to ".$rest_times[0]->end_time1;
									}
								}

							}else{
								$value->next_available_time='Holiday';
							}

						}
					}


				if($value->image){
					$img='';
					foreach (explode(",", $value->image) as $key1 => $value1) {
						$img.= \URL::to('').'/uploads/images/'.$value->restaurant_id.'/'.$value1.",";
					}
					$value->image = rtrim($img,',');
				}else{
					$value->image = '';
				}
				$unit=array();
				$variation=array();

				if($value->adon_type=='unit'){
					$unit=\DB::table('abserve_food_categories')->where('id',$value->id)->get();
					foreach ($unit as $keyU => $valueU) {
						$valueU->quantity=(int)\AbserveHelpers::foodcheck_app($value->id,$valueU->id,'unit',$user_id,$cookie_id);
						$valueU->show_price = (string)$valueU->selling_price;
					}

					
				}
				if($value->adon_type=='variation'){
					$variation=\DB::table('tb_food_variation')->where('food_id',$value->id)->get();
					foreach ($variation as $keyV => $valueV) {
						$valueV->quantity=(int)\AbserveHelpers::foodcheck_app($value->id,$valueV->id,'variation',$user_id,$cookie_id);
						$valueV->show_price = (string)$valueV->selling_price;

						if($valueV->image){
							$img='';
							foreach (explode(",", $valueV->image) as $key1V => $value1V) {
								$img.= \URL::to('').'/uploads/images/'.$value->restaurant_id.'/variation/'.$value1V.",";
							}
							$valueV->image = rtrim($img,',');
						}else{
							$valueV->image = '';
						}
					}
				}
				$value->unit=$unit;
				$value->variation=$variation;
			}
			 $response["itemDetail"] 	= $itemDetail;
			 $response['message'] = 'success';
			 return $response;
	}

    public function shopcreate(Request $request)
	{
		$rules['action'] = 'required|in:add,update';
		if($request->action == 'update'){
			$rules['res_id'] = 'required';
		}
		$rules['partner_id'] = 'required|numeric';
		$rules['name'] = 'required';
		$rules['location'] = 'required';
		$rules['latitude'] = 'required';
		$rules['longitude'] = 'required';
		$rules['cuisine'] = 'required';
		$rules['res_desc'] = 'required';
		$rules['preorder'] = 'required';
		$rules['gst_applicable'] = 'required';
		// $rules['res_status'] = 'required';
		$rules['restaurant_cat'] = 'required';
		$rules['mode'] = 'required';
		$rules['phone'] = 'required';
		// $rules['tagline'] = 'required';
		$rules['fassai_no'] = 'required';
		$rules['pan_no'] = 'required';
		$rules['gst_no'] = 'required';
		if($request->action == 'add'){
			$rules['restaurant_image'] = 'required';
		}
		// $rules['Closed_dates'] = 'required';
		if($request->gst_applicable == 'yes'){
			$rules['service_tax1'] = 'required|numeric';
			// $rules['gst'] = 'required|numeric';
		}
		$gst = 0;
		if($request->mode=='open'){
			$mode_filter='1';
		}else{
			$mode_filter='2';
		}
		$this->validateDatas($request->all(),$rules);

		$values = array(
			"partner_id"	=> $request->partner_id,
			"name"			=> $request->name,
			"location"		=> $request->location,
			"longitude"		=> $request->longitude,
			"latitude"		=> $request->latitude,
			"res_desc"		=> (isset($request->res_desc)) ? $request->res_desc : '',
			"preoder"       => $request->preorder,
			"entry_by"		=> $request->partner_id,
			"phone"			=> $request->phone,
			"gst_applicable"=> $request->gst_applicable,
			"gst"	        => $gst ,
			"cuisine"		=> $request->cuisine,
			"tagline" 	    => $request->tagline,
			"partner_code"	=> $request->partner_code,
			"flatno" 			=>  (isset($request->flatno)) ? $request->flatno : '',
			"adrs_line_1" 		=> (isset($request->adrs_line_1)) ? $request->adrs_line_1 : '',
			"adrs_line_2" 		=> (isset($request->adrs_line_2)) ? $request->adrs_line_2 : '',
			"sub_loc_level_1" 	=> (isset($request->sub_loc_level_1)) ? $request->sub_loc_level_1 : '',
			"city" 				=> (isset($request->city)) ? $request->city : '',
			"state" 			=> (isset($request->state)) ? $request->state : '',
			"country" 			=> (isset($request->country)) ? $request->country : '',
			"zipcode" 			=> (isset($request->zipcode)) ? $request->zipcode : '',	
			"preoder"		=> $request->preorder,
			"delivery_time"	=> isset($_REQUEST['delivery_time']) ? $_REQUEST['delivery_time']: 0,
			"offer"			=> isset($request->offer) ? $request->offer: 0,			
			"budget"		=> isset($request->budget) ? $request->budget: 0,
			"mode"				=> $request->mode,
			"mode_filter"		=> $mode_filter,
			'r_fassai_no'       => $request->fassai_no,
			'r_pan_no'          => $request->pan_no,
			'r_gst_no'          => $request->gst_no, 
			'restaurant_cat'    => $request->restaurant_cat,
			'service_tax1'      => $request->service_tax1 ?? 0,
		);
		if((!is_null($request->restaurant_image) && $request->restaurant_image !='') && $request->hasFile('restaurant_image')){
			$file= $request->file('restaurant_image');
			$filename= date('YmdHi').$file->getClientOriginalName();
			$file-> move(base_path()."/uploads/restaurants/",$filename);            
			$compress = \AbserveHelpers::urlimg_compress(base_path()."/uploads/restaurants/".$filename);
			$values['logo']=$filename;
		}
		
		if($request->action == 'add'){
			$res_id = \DB::table('abserve_restaurants')->insertGetId($values);
		}
		if($request->action == 'update'){
			$res_id = \DB::table('abserve_restaurants')->where('id', $request->res_id)->update($values);
			$res_id = $request->res_id;
		}
			$days = Days::all();
		    $time = \DB::table('abserve_time')->select('*')->get();

          	foreach ($days as $value) {
				$day_status = ($request->input('day_'.$value->id) != '') ? 1 : 0 ;
				$entryBy = 'partner';
				$firsttime = ($request->input('resTime_'.$value->id.'_1') != '') ? explode('-', $request->input('resTime_'.$value->id.'_1')) : '';
				$secondtime = ($request->input('resTime_'.$value->id.'_2') != '') ? explode('-', $request->input('resTime_'.$value->id.'_2')) : '';
				$resTime = RestaurantTiming::where('res_id', $request->res_id)->where('day_id', $value->id)->first();	
					if(!$resTime){			
						$resTime = new RestaurantTiming;
					}
					$resTime->res_id 		= $res_id;
					$resTime->day_id 		= $value->id;
					$resTime->created_at 	= date('Y-m-d H:i:s');
					$resTime->updated_at 	= date('Y-m-d H:i:s');
				
				$resTime->start_time1 	= ($firsttime != '') ? $firsttime[0] : '';
				$resTime->end_time1 	= ($firsttime != '') ? $firsttime[1] : '';
				$resTime->start_time2 	= ($secondtime != '') ? $secondtime[0] : '';
				$resTime->end_time2 	= ($secondtime != '') ? $secondtime[1] : '';
				$resTime->day_status 	= $day_status;
				$resTime->entry_by 		= $entryBy;
				$resTime->save();
			}
				$response['id'] = $request->partner_id;
				$response['message'] = 'Shop Created successfully';
				$user = User::find($request->partner_id);
				$response['access_token'] = JWTAuth::fromUser($user);    
                return \Response::json($response);
	}

	public function shopcategories(Request $request)
	{
		$shop_cat = cuisineimg::select('id','name')->get();
		/*if($request->from == 'partner'){
		    $shop_cat = cuisineimg::select('id','name')->get()->map(function($cat) use($request){
			$is_check = false;
			$cuisineString = Restaurant::where('id', $request->res_id)->pluck('cuisine')->first();
            $cuisineArray = explode(',', $cuisineString);
			if(in_array($cat->id, $cuisineArray)){
				$is_check = true;
			}
			$cat->is_check = $is_check;
			return $cat;
		});
		}*/
		if($request->from != 'partner'){
			$shop_cat->prepend(['name' => 'All']);
		}
		$response['shop_cat'] 	 = $shop_cat;
		$status = 200;
		return \Response::json($response,$status);
	}

	public function categoryFoods(Request $request)
	{
		$rules['cat_id'] = 'required';
		$rules['user_id'] = 'required';
		$this->validateDatas($request->all(),$rules);
		$cat_id = $request->cat_id;
		$user_id = $request->user_id;
		$distance = 20;
		$user = User::find($user_id);
		$userLat = (isset($user->lat) && $user->lat != '') ? $user->lat : $user->latitude;
		$userLong = (isset($user->lang) && $user->lang != '') ? $user->lang : $user->longitude;
		// $foods = Fooditems::where('main_cat', $cat_id)->where('approveStatus', 'Approved')->where('item_status', 1)->where('del_status', 0)->where('status', 'active')->get()->append('restaurant');
        /*$foods = Fooditems::select('abserve_hotel_items.*')->where('main_cat', $cat_id)
	    ->where('abserve_hotel_items.approveStatus', 'Approved')
	    ->where('abserve_hotel_items.item_status', 1)
	    ->where('abserve_hotel_items.del_status', 0)
	    ->where('abserve_hotel_items.status', 'active')
	    ->join('abserve_restaurants', function ($join) {
	        $join->on('abserve_hotel_items.restaurant_id', '=', 'abserve_restaurants.id')
	            ->where('abserve_restaurants.status', '1')
	            ->where('abserve_restaurants.mode', 'open')
	            ->where('abserve_restaurants.admin_status', 'approved');
	    })
	    ->get();

	    $foods = $foods->map(function ($food) {
		    $restaurant = Restaurant::find($food->restaurant_id);
		    $food->availability_status = $restaurant->getAvailabilityAttribute();
		    return $food;
		});

		$foods = $foods->filter(function ($food) use ($userLat, $userLong, $distance) {
			$res = Restaurant::where('id', $food->restaurant_id)->first();
            $restaurantLatitude = $res->latitude;
            $restaurantLongitude = $res->longitude;
            $distanceKm = \AbserveHelpers::calculateDistance($userLat, $userLong, $restaurantLatitude, $restaurantLongitude);
            return $distanceKm <= $distance;
        })->values()->toArray();*/

        $cat_name = Foodcategories::where('id', $cat_id)->pluck('cat_name')->first();
        $foods = Fooditems::where('main_cat', $cat_id)->where('approveStatus', 'Approved')->where('item_status', 1)->where('del_status', 0)/*->where('status', 'active')*/->groupBy('restaurant_id')->get()->pluck('restaurant_id');

        $res = Restaurant::select('id', 'name', 'logo', 'tagline', 'location', 'mode', 'l_id', 'latitude', 'longitude', 'rating')->where('mode', 'open')->where('admin_status', 'approved')->where('status', 1)->whereIn('id', $foods)->get();
        $res = $res->map(function ($restaurant) use ($user_id) {
		    $restaurant->status = $restaurant->getFavouriteAttribute($user_id);
		    $restaurant->src = $restaurant->getSrcAttribute();
		    $restaurant->availability = $restaurant->getAvailabilityAttribute();
		    $restaurant->offer = $restaurant->getResOfferAttribute();
		    $restaurant->reviews = $restaurant->getReviewAttribute();
		    $restaurant->makeHidden('logo');
		    $restaurant->makeHidden('mode');
		    $restaurant->makeHidden('l_id');
		    return $restaurant;
		});

		$res = $res->filter(function ($restaurant) use ($userLat, $userLong, $distance) {
            $restaurantLatitude = $restaurant->latitude;
            $restaurantLongitude = $restaurant->longitude;
            $distanceKm = \AbserveHelpers::calculateDistance($userLat, $userLong, $restaurantLatitude, $restaurantLongitude);
            return $distanceKm <= $distance;
        })->values()->toArray();

		$response['cat_foods'] = $res;
		$response['cat_id']    = $cat_id;
		$response['cat_name']  = $cat_name;
		$status = 200;
		return \Response::json($response,$status);
	}

	public function foodView(Request $request)
	{
		$rules['res_id'] = 'required';
		$rules['user_id'] = 'required';
		$this->validateDatas($request->all(), $rules);
		if($request->res_id){
			$averageSpeedKmph = 40;
			$user_id = $request->user_id;
			$res_category = $request->res_category;
			$auser = Useraddress::where('user_id', $user_id)->where('apply_status', 1)->select('id', 'address', 'lat', 'lang')->first();
			if($auser == null){
				$cuser = User::find($user_id)->select('latitude','longitude','address');
			}
			$userLat =  (isset($auser) && $auser->lat != '') ? $auser->lat : $cuser->latitude;
			$userLong =  (isset($auser) && $auser->lang != '') ? $auser->lang : $cuser->longitude;
			$restaurant = Restaurant::select('id', 'name', 'rating', 'location', 'latitude', 'longitude')->where('id', $request->res_id)->first();
			$distance = \AbserveHelpers::calculateDistance($userLat, $userLong, $restaurant->latitude, $restaurant->longitude);
			$restaurant->review = $restaurant->getReviewAttribute();
			$restaurant->user_location = isset($auser->address) ? $auser->address : $cuser->address;
			$travelTimeInMinutes = ($distance / $averageSpeedKmph) * 60;
			$restaurant->travelTime = round($travelTimeInMinutes, 2) ?? 0;
			$response['restaurant_detail'] = $restaurant;
			/*$orders = OrderDetail::select('id')->where('res_id', $restaurant->id)->get();
			$data = [];
			foreach($orders as $order){
				$food = OrderItems::select('food_id')->where('orderid', $order->id)->first();
				array_push($data, $food->food_id);
			}*/
			$orderIds = OrderDetail::where('res_id', $restaurant->id)->pluck('id');
			$data = OrderItems::whereIn('orderid', $orderIds)->pluck('food_id')->toArray();

			$res_foods = Fooditems::select('id', 'food_item', 'restaurant_id', 'description', 'selling_price', 'strike_price', 'image', 'is_veg')->whereIn('id', $data)->where('approveStatus', 'Approved')->where('item_status', 1)->where('del_status', 0)->when(isset($res_category) && $res_category !== '', function ($query) use ($res_category) {
				return $query->where('is_veg', $res_category);
				})->get();

			$res_foods = $res_foods->map(function ($food) use($request) {
			    $food->selling_price = round($food->selling_price, 2);
			    $food->strike_price = intval($food->strike_price);
			    $food->src = $food->getSrcAttribute();
			    $food->quantity = $food->getCartCountAttribute($request);
				$food->makeHidden('image');
			    return $food;
			});
			if($request->from == 'category'){
				$cat_id = $request->cat_id;
				$res_foods = Fooditems::select('id', 'food_item', 'restaurant_id', 'description', 'selling_price', 'strike_price', 'image', 'is_veg')->where('main_cat', $cat_id)->where('approveStatus', 'Approved')->where('item_status', 1)->where('del_status', 0)->where('restaurant_id', $restaurant->id)->when(isset($res_category) && $res_category !== '', function ($query) use ($res_category) {
					return $query->where('is_veg', $res_category);
					})->get()->map(function($res_food) use ($request) {
					$res_food->selling_price = round($res_food->selling_price, 2);
			    	$res_food->strike_price = intval($res_food->strike_price);
					$res_food->src = $res_food->getSrcAttribute();
					$res_food->quantity = $res_food->getCartCountAttribute($request);
					return $res_food;
				});
			}
			$response['for_you']  = $res_foods;
			$response['category_foods'] = [];
			$res_cats = Fooditems::where('restaurant_id', $request->res_id)->where('approveStatus', 'Approved')->where('item_status', 1)->where('del_status', 0)->groupBy('main_cat')->when(isset($res_category) && $res_category !== '', function ($query) use ($res_category) {
					return $query->where('is_veg', $res_category);
					})->get()->pluck('main_cat');
			if($res_cats){
				$res_cate = \DB::table('abserve_food_categories')->whereIn('id', $res_cats)->select('id','cat_name')->get()->map(function($cat) use ($request,$res_foods,$res_category) {
					$response['cat_name'] = $cat->cat_name;
					$response['cat_name_list'] = Fooditems::where('approveStatus', 'Approved')->where('item_status', 1)->where('del_status', 0)->where('restaurant_id',$request->res_id)->where('main_cat',$cat->id)->select('id', 'food_item', 'restaurant_id', 'description', 'selling_price', 'strike_price', 'image', 'is_veg')->whereNotIn('id',$res_foods->pluck('id'))->when(isset($res_category) && $res_category != '', function ($query) use ($res_category) {
						return $query->where('is_veg', $res_category);
						})->get()->each(function ($foodItem) use($request) {
			            $foodItem->selling_price = round($foodItem->selling_price, 2);
			            $foodItem->strike_price = intval($foodItem->strike_price);
			            $foodItem->src = $foodItem->getSrcAttribute();
			            $foodItem->quantity = $foodItem->getCartCountAttribute($request);
			            $res = Restaurant::find($foodItem->restaurant_id);
			            $foodItem->rating = $res->rating;
			            $foodItem->reviews = $res->getReviewAttribute();
				        $foodItem->makeHidden('image');
				        })->filter()->all();
					if(!empty($response['cat_name_list'])){
						return $response;
					}
				})->filter()->values()->all();
				$response['category_foods']['category_list'] = $res_cate;
			}
			$ucart = Usercart::select('id', 'user_id', 'res_id', 'food_id', 'food_item', 'quantity', 'vendor_price')->where('user_id', $user_id)->get();
			if($ucart->isNotEmpty()){
				$response['total_items'] = $ucart->sum('quantity');
				$response['total_price'] = round($ucart->sum('vendor_price'), 2);
				$response['res_name'] = Restaurant::where('id', $ucart[0]->res_id)->pluck('name')->first();
			}elseif($ucart->isEmpty()){
				$response['total_items'] = 0;
				$response['total_price'] = 0;
				$response['res_name'] = '';
			}
		}
		$status = 200;
		return \Response::json($response,$status);
	}

	public function showFoodRating(Request $request)
	{
		// $rules['food_id'] = 'required';
		// $this->validateDatas($request->all(),$rules);
		if($request->food_id){
		$food_id = $request->food_id;
		$foods = Restaurantrating::where('food_id', $food_id)->select('comments', 'rating','cust_id', 'created_at')->get()->append(['comment','user']);
		$ratingsCounts = $foods->groupBy('rating')->map(function ($items) {
            return $items->count();
        });
		if($foods->isNotEmpty()){
        	$totalRatings = $foods->count();
			$totalSumRatings = $foods->sum('rating');
			$overallAverageRating = $totalSumRatings / $totalRatings;
        	$response['ratings'] = [
				'five_stars' => $ratingsCounts->get(5, 0),
				'four_stars' => $ratingsCounts->get(4, 0),
				'three_stars' => $ratingsCounts->get(3, 0),
				'two_stars' => $ratingsCounts->get(2, 0),
				'one_star'  => $ratingsCounts->get(1, 0),
			];
			if(!$request->filter){
				$response['user_cmnts'] = $foods;
			}
			$response['overall_average_rating'] = $overallAverageRating;
			$response['total_user_counts'] = $totalRatings;
        if($request->filter == 'sortby'){
        	$sortby = Restaurantrating::where('food_id', $food_id)->select('comments', 'rating', 'cust_id', 'created_at')->orderBy('rating', 'desc')->get()->append(['comment','user']);
        	$response['sortlist'] = $sortby;
        }elseif($request->filter == 'five'){
        	$fi_rating = Restaurantrating::where('food_id', $food_id)->select('comments', 'rating', 'cust_id', 'created_at')->where('rating', 5)->get()->append(['comment','user']);
        	$response['five_ratings'] = $fi_rating;
        }elseif($request->filter == 'four'){
        	$fi_rating = Restaurantrating::where('food_id', $food_id)->select('comments', 'rating', 'cust_id', 'created_at')->where('rating', 4)->get()->append(['comment','user']);
        	$response['four_ratings'] = $fi_rating;
        }elseif($request->filter == 'three'){
        	$fi_rating = Restaurantrating::where('food_id', $food_id)->select('comments', 'rating', 'cust_id', 'created_at')->where('rating', 3)->get()->append(['comment','user']);
        	$response['three_ratings'] = $fi_rating;
        }
    	}else{
    	$response['ratings'] = [
				'five_stars' => 0,
				'four_stars' => 0,
				'three_stars' => 0,
				'two_stars' => 0,
				'one_star'  => 0,
			];
			$response['user_cmnts'] = [];
			$response['overall_average_rating'] = 0;
			$response['total_user_counts'] = 0;
    	}
    }elseif($request->res_id){
    	$res_id = $request->res_id;
    	$res = Restaurantrating::where('res_id', $res_id)->select('comments', 'rating','cust_id', 'created_at')->get()->append(['comment','user']);
    	$ratingsCounts = $res->groupBy('rating')->map(function ($items) {
            return $items->count();
        });
    	if($res->isNotEmpty()){
        	$totalRatings = $res->count();
			$totalSumRatings = $res->sum('rating');
			$overallAverageRating = $totalSumRatings / $totalRatings;
        	$response['ratings'] = [
				'five_stars' => $ratingsCounts->get(5, 0),
				'four_stars' => $ratingsCounts->get(4, 0),
				'three_stars' => $ratingsCounts->get(3, 0),
				'two_stars' => $ratingsCounts->get(2, 0),
				'one_star'  => $ratingsCounts->get(1, 0),
			];
			if(!$request->filter){
				$response['user_cmnts'] = $res;
			}
			$response['overall_average_rating'] = $overallAverageRating;
			$response['total_user_counts'] = $totalRatings;
        if($request->filter == 'sortby'){
        	$sortby = Restaurantrating::where('res_id', $res_id)->select('comments', 'rating', 'cust_id', 'created_at')->orderBy('rating', 'desc')->get()->append(['comment','user']);
        	$response['sortlist'] = $sortby;
        }elseif($request->filter == 'five'){
        	$fi_rating = Restaurantrating::where('res_id', $res_id)->select('comments', 'rating', 'cust_id', 'created_at')->where('rating', 5)->get()->append(['comment','user']);
        	$response['five_ratings'] = $fi_rating;
        }elseif($request->filter == 'four'){
        	$fi_rating = Restaurantrating::where('res_id', $res_id)->select('comments', 'rating', 'cust_id', 'created_at')->where('rating', 4)->get()->append(['comment','user']);
        	$response['four_ratings'] = $fi_rating;
        }elseif($request->filter == 'three'){
        	$fi_rating = Restaurantrating::where('res_id', $res_id)->select('comments', 'rating', 'cust_id', 'created_at')->where('rating', 3)->get()->append(['comment','user']);
        	$response['three_ratings'] = $fi_rating;
        }
    	}else{
    	$response['ratings'] = [
				'five_stars' => 0,
				'four_stars' => 0,
				'three_stars' => 0,
				'two_stars' => 0,
				'one_star'  => 0,
			];
			$response['user_cmnts'] = [];
			$response['overall_average_rating'] = 0;
			$response['total_user_counts'] = 0;
    	}
    }
		$status = 200;
		return \Response::json($response,$status);
	}

	public function foodDetail(Request $request)
	{
		// $rules['food_id'] = 'required'; 
		// $this->validateDatas($request->all(),$rules);
		if($request->food_id){
		$food_id = $request->food_id;
		$f_detail = Fooditems::where('id', $food_id)->first()->append('restaurant');
		$foods = Restaurantrating::where('food_id', $food_id)->select('comments', 'rating','created_at')->get();

		$response['food_details'] = $f_detail;
		if($foods->isNotEmpty()){
			$totalRatings = $foods->count();
			$totalSumRatings = $foods->sum('rating');
			$overallAverageRating = $totalSumRatings / $totalRatings;
			$ratingsCounts = $foods->groupBy('rating')->map(function ($items) {
				return $items->count();
			});
			$response['ratings'] = [
				'five_stars' => $ratingsCounts->get(5, 0),
				'four_stars' => $ratingsCounts->get(4, 0),
				'three_stars' => $ratingsCounts->get(3, 0),
				'two_stars' => $ratingsCounts->get(2, 0),
				'one_star'  => $ratingsCounts->get(1, 0),
			];
			$response['overall_average_rating'] = $overallAverageRating;
			$response['total_user_counts'] = $totalRatings;
		}else{
			$response['ratings'] = [
				'five_stars' => 0,
				'four_stars' => 0,
				'three_stars' => 0,
				'two_stars' => 0,
				'one_star'  => 0,
			];
			$response['overall_average_rating'] = 0;
			$response['total_user_counts'] = 0;
		}
	}elseif($request->res_id){
		$res_id = $request->res_id;
		$restaurant = Restaurant::where('id', $res_id)->first();
		$res_timing = RestaurantTiming::where('res_id', $res_id)->select('day_id', 'start_time1', 'end_time1', 'start_time2', 'end_time2')->get();
		$res = Restaurantrating::where('res_id', $res_id)->select('comments', 'rating', 'created_at')->get();
		$response['restaurant_details'] = $restaurant;
		$response['restaurant_timing'] = $res_timing;
		// dd($res_timing);
		if($res->isNotEmpty()){
			$totalRatings = $res->count();
			$totalSumRatings = $res->sum('rating');
			$overallAverageRating = $totalSumRatings / $totalRatings;
			$ratingsCounts = $res->groupBy('rating')->map(function ($items) {
				return $items->count();
			});
			$response['ratings'] = [
				'five_stars' => $ratingsCounts->get(5, 0),
				'four_stars' => $ratingsCounts->get(4, 0),
				'three_stars' => $ratingsCounts->get(3, 0),
				'two_stars' => $ratingsCounts->get(2, 0),
				'one_star'  => $ratingsCounts->get(1, 0),
			];
			$response['overall_average_rating'] = $overallAverageRating;
			$response['total_user_counts'] = $totalRatings;
		}else{
			$response['ratings'] = [
				'five_stars' => 0,
				'four_stars' => 0,
				'three_stars' => 0,
				'two_stars' => 0,
				'one_star'  => 0,
			];
			$response['overall_average_rating'] = 0;
			$response['total_user_counts'] = 0;
		}
	}
		$status = 200;
		return \Response::json($response,$status);
	}

	public function addCart(Request $request)
	{
		$rules['food_id'] = 'required'; 
		$rules['quantity'] = 'required'; 
		$rules['user_id'] = 'required'; 
		$this->validateDatas($request->all(),$rules);
		$user_id = 0;
		if($request->user_id > 0){
			$user_id = $request->user_id;
		}
		$food_id   = $request->food_id;
		$quantity  = $request->quantity;
		$notes     = $request->note;
		$food = Fooditems::where('id', $food_id)->first();
		$gst  = $food->selling_price * ($food->gst / 100);
		$uCart = Usercart::where('user_id', $user_id)->first();
		if($quantity > 0 || $quantity != '0'){
			if(!$request->replace){
				if($uCart){
					if($uCart->res_id == $food->restaurant_id){
						$cart = Usercart::where('user_id', $user_id)->where('food_id', $food_id)->first();
						if(!$cart){
							$cart = new Usercart();
						}
						$cart->user_id      = $user_id;
						$cart->res_id       = $food->restaurant_id;
						$cart->food_id      = $food_id;
						$cart->food_item    = $food->food_item;
						// $cart->price        = $food->price * $quantity;
						$cart->price        = $food->selling_price;
						$cart->strike_price = $food->strike_price;
						// $cart->vendor_price = $food->selling_price * $quantity;
						$cart->vendor_price = $food->price;
						$cart->quantity     = $quantity;
						// $cart->gst          = $food->gst * $quantity;
						$cart->gst          = $gst;
						$cart->item_note    = (isset($notes) && $notes != '') ? $notes : '';
						$cart->save();
						$response['message'] = 'Cart action successfully';
						$response['food_empty'] = false;
						// $response['u_cart'] = $cart;
						// $response['u_cart'] = Usercart::where('user_id', $user_id)->get()->append(['food_price', 'food_items']);
					}else{
						$old_res = Restaurant::where('id', $uCart->res_id)->pluck('name')->first();
						$new_res = Restaurant::where('id', $food->restaurant_id)->pluck('name')->first();
						$response['message'] = 'The food you have already selected is in '.$old_res.' but the currently selected food is in '.$new_res.'';
						$response['food_id'] = $food_id;
						$response['quantity'] = $quantity;
						$response['cart'] = 1;
						$response['food_empty'] = false;
					}
				}else{
					$cart = new Usercart();
					$cart->user_id      = $user_id;
					$cart->res_id       = $food->restaurant_id;
					$cart->food_id      = $food_id;
					$cart->food_item    = $food->food_item;
					// $cart->price        = $food->price * $quantity;
					$cart->price        = $food->selling_price;
					$cart->strike_price = $food->strike_price;
					// $cart->vendor_price = $food->selling_price * $quantity;
					$cart->vendor_price = $food->price;
					$cart->quantity     = $quantity;
					// $cart->gst          = $food->gst * $quantity;
					$cart->gst          = $gst;
					$cart->item_note    = (isset($notes) && $notes != '') ? $notes : '';
					$cart->save();
					$response['message'] = 'Cart action successfully';
					$response['food_empty'] = false;
					// $response['u_cart'] = $cart;
					// $response['u_cart'] = Usercart::where('user_id', $user_id)->get()->append(['food_price', 'food_items']);
				}
			}elseif($request->replace){
				$cart = Usercart::where('user_id', $user_id)->delete();
				$cart = new Usercart();
				$cart->user_id      = $user_id;
				$cart->res_id       = $food->restaurant_id;
				$cart->food_id      = $food_id;
				$cart->food_item    = $food->food_item;
				// $cart->price        = $food->price * $quantity;
				$cart->price        = $food->selling_price;
				$cart->strike_price = $food->strike_price;
				// $cart->vendor_price = $food->selling_price * $quantity;
				$cart->vendor_price = $food->price;
				$cart->quantity     = $quantity;
				// $cart->gst          = $food->gst * $quantity;
				$cart->gst          = $gst;
				$cart->item_note    = (isset($notes) && $notes != '') ? $notes : '';
				$cart->save();
				$response['message'] = 'Cart action successfully';
				$response['food_empty'] = false;
				// $response['u_cart'] = $cart;
				// $response['u_cart'] = Usercart::where('user_id', $user_id)->get()->append(['food_price', 'food_items']);
			}
		}else/*if($request->replace != true)*/{
			$response['food_empty'] = true;
			$response['message'] = 'Cart action successfully';
			$del = Usercart::where('food_id', $food_id)->where('user_id',$user_id)->first();
			if(!empty($del)){
				$del->delete();
			}
		}
		$t_price = Usercart::where('user_id', $user_id)->sum(DB::raw('price * quantity'));
		$response['total_items'] = Usercart::where('user_id', $user_id)->sum('quantity');
		$response['total_price'] = round($t_price, 2);
		$cart = Usercart::where('user_id', $user_id)->first();
		$response['res_name'] = (isset($cart)) ? Restaurant::where('id', $cart->res_id)->pluck('name')->first() : '';
		$status = 200;
		return \Response::json($response,$status);
	}

	public function userSearchKeyword(Request $request)
	{
		$rules['keyword'] = 'required';
		$rules['page'] = 'required';
		if($request->page == 'restaurant'){
			$rules['res_id'] = 'required';
		}
		$this->validateDatas($request->all(),$rules);
		$user_id = 0;
		$cookie_id = '';
		$keyword = $request->keyword;
		if($request->user_id > 0){
			$user_id = $request->user_id;
		}else{
			$cookie_id = $request->cookie_id;
		}
		$distance= 20;
		$user = User::where('id', $user_id)->first();
		$userLat = $user->lat;
		$userLong = $user->lang;
		if($request->page == 'home'){
			$res = Restaurant::select('id', 'name', 'logo', 'l_id')
			    ->where('status', 1)
			    ->where('mode', 'open')
			    ->where('admin_status', 'approved')
			    ->where('name', 'like', '%' . $keyword . '%')
			    ->get()->map(function($res)use($userLat, $userLong, $distance){
			    	$res->this_is = 'restaurants';
			    	$res->src = $res->getSrcAttribute();
			    	$res->quantity = 0;
			    	$res->makeHidden('logo');
			    	$res->makeHidden('l_id');
			    	$restaurantLatitude = $res->latitude;
			    	$restaurantLongitude = $res->longitude;
			    	$distanceKm = \AbserveHelpers::calculateDistance($userLat, $userLong, $restaurantLatitude, $restaurantLongitude);
			    	$res->distance = $distanceKm;
                    return $res;
                })
                ->filter(function($res) use ($distance) {
                    return $res->distance <= $distance;
                });

			$foods = Fooditems::select('id', 'food_item as name', 'image', 'restaurant_id')
				->where('food_item', 'like', '%' . $keyword . '%')
			    ->where('approveStatus', 'Approved')
			    ->where('item_status', 1)
			    ->where('del_status', 0)
			    ->get()->map(function($food) use ($request, $userLat, $userLong, $distance) {
			    	$food->this_is = 'dishes';
			    	$food->src = $food->getSrcAttribute();
			    	$food->quantity = $food->getCartCountAttribute($request);
			    	$food->makeHidden(['image','restaurant_id']);
			    	$res = Restaurant::find($food->restaurant_id);
			    	$restaurantLatitude = $res->latitude;
			    	$restaurantLongitude = $res->longitude;
			    	$distanceKm = \AbserveHelpers::calculateDistance($userLat, $userLong, $restaurantLatitude, $restaurantLongitude);
			    	$food->distance = $distanceKm;
			    	return $food;
			    })
			    ->filter(function($food) use ($distance) {
                    return $food->distance <= $distance;
                });
			$searches = $res->concat($foods);
		}elseif($request->page == 'restaurant'){
			$searches = Fooditems::select('id', 'food_item as name', 'image')->where('food_item', 'like', '%'.$keyword.'%')->where('approveStatus', 'Approved')->where('item_status', 1)->where('del_status', 0)->where('restaurant_id', $request->res_id)->get()->map(function($food) use ($request) {
					$food->this_is = 'dishes';
					$food->src = $food->getSrcAttribute();
					$food->quantity = $food->getCartCountAttribute($request);
					$food->makeHidden('image');
					return $food;
				});
		}
		$response['restaurants_and_foods'] = $searches;
		$status = 200;
		return \Response::json($response,$status);
	}

	public function userRecentSearch(Request $request)
	{
		$user_id = 0;
		$cookie_id = '';
		if($request->user_id > 0){
			$user_id = $request->user_id;
			$recent_search = UserSearchKeyword::where('user_id', $user_id)->select('keyword as cat_name', 'search', 'cat_id as id')->groupBy('keyword')->limit(10)->orderBy('id', 'desc')->get();
		}else{
			$cookie_id = $request->cookie_id;
			$recent_search = UserSearchKeyword::where('cookie_id', $cookie_id)->select('keyword as cat_name')->groupBy('keyword')->limit(10)->get();
		}
		$food_names = Foodcategories::select('id', 'cat_name', 'image_url')->where('type', 'category')->where('del_status', '0')->get()->map(function($food) {
				$food->src = $food->getSrcAttribute();
			    $food->makeHidden('image_url');
				return $food;
			});
		$popular_foods = OrderItems::groupBy('food_id')->pluck('food_id');
		$popular_foods = Fooditems::whereIn('id', $popular_foods)->limit(10)->pluck('main_cat');
		$popular_foods = Foodcategories::select('id', 'cat_name', 'image_url')->whereIn('id', $popular_foods)->get()->map(function($food) {
				$food->src = $food->getSrcAttribute();
			    $food->makeHidden('image_url');
				return $food;
			});
		$response['recent_searches'] = $recent_search;
		$response['All_cuisines'] = $food_names;
		$response['Popular_cuisines'] = $popular_foods;
		$status = 200;
		return \Response::json($response,$status);
	}

	public function catFilter(Request $request)
	{
		$rules['shop_cat_id'] = 'required';
		$user_id = $request->user_id;
		$this->validateDatas($request->all(),$rules);
		$shop_cat_id = $request->shop_cat_id;
		if($shop_cat_id == 'All'){
			$restaurants = Restaurant::select('id', 'name', 'logo', 'tagline', 'location', 'mode', 'l_id', 'latitude', 'longitude')->where('mode', 'open')->where('admin_status', 'approved')->where('status', 1)->get();
			$restaurants = $restaurants->map(function ($restaurant) use ($user_id) {
			    $restaurant->status = $restaurant->getFavouriteAttribute($user_id);
			    $restaurant->src = $restaurant->getSrcAttribute();
			    $restaurant->availability = $restaurant->getAvailabilityAttribute();
			    $restaurant->makeHidden('logo');
			    $restaurant->makeHidden('mode');
			    $restaurant->makeHidden('l_id');
			    return $restaurant;
			});
		}else{
			$restaurants = Restaurant::select('id', 'name', 'logo', 'tagline', 'location', 'mode', 'l_id', 'latitude', 'longitude')->whereRaw('FIND_IN_SET('.$shop_cat_id.',`cuisine`)')->where('mode', 'open')->where('admin_status', 'approved')->where('status', 1)->get();
			$restaurants = $restaurants->map(function ($restaurant) use ($user_id) {
			    $restaurant->status = $restaurant->getFavouriteAttribute($user_id);
			    $restaurant->src = $restaurant->getSrcAttribute();
			    $restaurant->availability = $restaurant->getAvailabilityAttribute();
			    $restaurant->makeHidden('logo');
			    $restaurant->makeHidden('mode');
			    $restaurant->makeHidden('l_id');
			    return $restaurant;
			});
		}
		$response['cuisines'] = $restaurants;
		return \Response::json($response,200);
	}

	public function filter(Request $request)
	{
		$restaurants = Restaurant::select('id', 'name', 'logo', 'location', 'tagline', 'mode', 'l_id', 'latitude', 'longitude')->where('status', 1)->where('mode', 'open')->where('admin_status', 'approved');
		$currentDay = date('Y-m-d');
		$user_id = $request->user_id;
		$distance = 20;
		$user = User::find($request->user_id);
		$userLat = (isset($user->lat) && $user->lat != '') ? $user->lat : $user->latitude;
		$userLong = (isset($user->lang) && $user->lang != '') ? $user->lang : $user->longitude;
		if(in_array('recommended',explode(',',$request->sort_by))){
			$r_ids = OrderDetail::where('cust_id', $user_id)->groupBy('res_id')->pluck('res_id');
			if($r_ids->isNotEmpty()){
				$restaurants = $restaurants->whereIN('id', $r_ids);
			}else{
				$restaurants = $restaurants;
			}
		}elseif(in_array('popularity',explode(',',$request->sort_by))){
			$restaurants = $restaurants->where('ordering', 1);
		}elseif(in_array('rating',explode(',',$request->sort_by))){
			$restaurants = $restaurants->orderByDesc('rating');
		}elseif(in_array('distance',explode(',',$request->sort_by)) && $userLat != '' && $userLong != ''){
			$restaurants = $restaurants->selectRaw('(6371 * acos(cos(radians(' . $userLat . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $userLong . ')) + sin(radians(' . $userLat . ')) * sin(radians(latitude)))) AS distance')->orderBy('distance', 'asc');
		}
		if(in_array('promo',explode(',',$request->restaurant))){
			$r_ids = \DB::table('abserve_promocode')->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->where('created_by', 'restaurant')->where('res_id', '!=', 0)->pluck('res_id')->toArray();
			if($r_ids->isNotEmpty()){
				$restaurants = $restaurants->whereIN('id', $r_ids);
			}else{
				$restaurants = $restaurants;
			}
		}
		if(in_array(50,explode(',',$request->delivery_fee)) && $userLat != '' && $userLong != ''){
			$restaurant = Restaurant::select('id', 'name', 'logo', 'tagline', 'location', 'l_id')->selectRaw('(6371 * acos(cos(radians(' . $userLat . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $userLong . ')) + sin(radians(' . $userLat . ')) * sin(radians(latitude)))) AS distance')->orderBy('distance', 'asc')->get();
			$res_ids = [];
			foreach($restaurant as $res){
				$distance = $res->distance;
				$aDelCharges = \AbserveHelpers::getDeliveryChargeValues($distance,$res,0);
				if($aDelCharges['delivery'] <= $request->delivery_fee){
					array_push($res_ids, $aDelCharges['res_id']);
				}
			}
			$restaurants = $restaurants->whereIn('id', $res_ids);
		}elseif(in_array(150,explode(',',$request->delivery_fee)) && $userLat != '' && $userLong != ''){
			$restaurant = Restaurant::select('id', 'name', 'logo', 'tagline', 'location', 'l_id')->selectRaw('(6371 * acos(cos(radians(' . $userLat . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $userLong . ')) + sin(radians(' . $userLat . ')) * sin(radians(latitude)))) AS distance')->orderBy('distance', 'asc')->get();
			$res_ids = [];
			foreach($restaurant as $res){
				$distance = $res->distance;
				$aDelCharges = \AbserveHelpers::getDeliveryChargeValues($distance,$res,0);
				if($aDelCharges['delivery'] <= $request->delivery_fee){
					array_push($res_ids, $aDelCharges['res_id']);
				}
			}
			$restaurants = $restaurants->whereIn('id', $res_ids);
		}elseif(in_array(250,explode(',',$request->delivery_fee)) && $userLat != '' && $userLong != ''){
			$restaurant = Restaurant::select('id', 'name', 'logo', 'tagline', 'location', 'l_id')->selectRaw('(6371 * acos(cos(radians(' . $userLat . ')) * cos(radians(latitude)) * cos(radians(longitude) - radians(' . $userLong . ')) + sin(radians(' . $userLat . ')) * sin(radians(latitude)))) AS distance')->orderBy('distance', 'asc')->get();
			$res_ids = [];
			foreach($restaurant as $res){
				$distance = $res->distance;
				$aDelCharges = \AbserveHelpers::getDeliveryChargeValues($distance,$res,0);
				if($aDelCharges['delivery'] <= $request->delivery_fee){
					array_push($res_ids, $aDelCharges['res_id']);
				}
			}
			$restaurants = $restaurants->whereIn('id', $res_ids);
		}
		if($request->cuisines){
			$cuisines = explode(',', $request->cuisines);
			$restaurants = $restaurants->where(function ($query) use ($cuisines) {
		        foreach ($cuisines as $cuisine) {
		            $query->orWhereRaw('FIND_IN_SET(' . $cuisine . ', `cuisine`)');
		        }
		    });
		}
		$restaurants = $restaurants->get();
		$restaurants = $restaurants->map(function ($restaurant) use ($user_id) {
		    $restaurant->status = $restaurant->getFavouriteAttribute($user_id);
		    $restaurant->src = $restaurant->getSrcAttribute();
		    $restaurant->availability = $restaurant->getAvailabilityAttribute();
		    $restaurant->food_items = [];
		    $restaurant->makeHidden('logo');
		    $restaurant->makeHidden('mode');
		    $restaurant->makeHidden('l_id');
		    return $restaurant;
		});
		$restaurants = $restaurants->filter(function ($restaurant) use ($userLat, $userLong, $distance) {
            $restaurantLatitude = $restaurant->latitude;
            $restaurantLongitude = $restaurant->longitude;
            $distanceKm = \AbserveHelpers::calculateDistance($userLat, $userLong, $restaurantLatitude, $restaurantLongitude);
            return $distanceKm <= $distance;
        })->values()->toArray();
		$response['restaurants_and_foods'] = $restaurants;
		return \Response::json($response,200);
	}

	public function resOffers(Request $request)
	{
		$claim = $request->offer_claim;
		$res_id = $request->res_id;
		$user_id = 0;
		if(isset($request->user_id) && $request->user_id != ''){
			$user_id = $request->user_id;
		}

		if(isset($claim) && $claim == true){
			$claimed = \DB::table('abserve_promo_user_status')->insert(['user_id' => $user_id, 'coupon_id' => $request->offer_id, 'offer_claim' => 1]);
		}
		$check = [];
		if($request->user_id > 0){
			$check = \DB::table('abserve_promo_user_status')->where('user_id', $user_id)->get();
		}
		if(count($check) == 0){
			$currentDay = date('Y-m-d');
				$offers = \DB::table('abserve_promocode')->select( 'id', 'promo_name as offer_name','promo_desc as offer_desc', 'start_date', 'end_date', 'promo_type as offer_type', 'promo_amount as offer_amount', 'min_order_value', 'promo_mode as offer_mode', 'promo_code')->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->where('res_id', $res_id)->get();
				$offers = $offers->map(function($offer){
					$offer->user_claim = ($offer->offer_type == 'amount' || $offer->offer_type == 'percentage') ? true : false;
					return $offer;
				});
		}elseif(!empty($check)){
			foreach($check as $checked){
				$currentDay = date('Y-m-d');
				$offers = \DB::table('abserve_promocode')->select( 'id', 'promo_name as offer_name','promo_desc as offer_desc', 'start_date', 'end_date', 'promo_type as offer_type', 'promo_amount as offer_amount', 'min_order_value', 'promo_mode as offer_mode', 'promo_code')->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->where('res_id', $res_id)->get();
				$offers = $offers->map(function($offer)use($checked){
					if($checked->coupon_id == $offer->id){
						$offer->user_claim = true;
					}elseif($offer->offer_type == 'amount' || $offer->offer_type == 'percentage'){
						$offer->user_claim = true;
					}else{
						$offer->user_claim = false;
					}
					return $offer;
				});
			}
		}
		$response['offers'] = $offers;
		return \Response::json($response,200);
	}

	public function filterOptions()
	{
		/*$response = [
		    'Sort By' => [
		        'recommended',
		        'popularity',
		        'rating',
		        'distance'
		    ],
		    'restaurant' => [
		    	'promo'
		    ],
		    'delivery_fee' => [
		    	'50',
		    	'150',
		    	'250'
		    ],
		    'cuisines' => cuisineimg::select('id', 'name')->get()
		]; 
		$response['cuisines'] = cuisineimg::select('id', 'name')->get()*/

		$response = [
		    'Sort By' => [
		        'recommended',
		        'popularity',
		        'rating',
		        'distance'
		    ],
		    'Restaurant' => [
		        'promo'
		    ],
		    'Delivery Fee' => [
		        '50',
		        '150',
		        '250'
		    ],
		    'Cuisines' => cuisineimg::select('id', 'name')->get()->append('is_from')
		];

		$transformedResponse = [];

		foreach ($response as $key => $values) {
		    if (is_array($values)) {
		        $transformedValues = array_map(function ($value) use($key) {
		        	if($key == "Sort By"){
			            return [
			            	'id'   => 0,
			            	'name' => $value,
			            	'is_from' => 'sort_by'
			            ];
			        }elseif($key == 'Restaurant'){
			        	return [
			            	'id'   => 0,
			            	'name' => $value,
			            	'is_from' => 'restaurant'
			            ];
			        }elseif($key == 'Delivery Fee'){
			        	return [
			            	'id'   => 0,
			            	'name' => $value,
			            	'is_from' => 'delivery_fee'
			            ];
			        }
		        }, $values);
		    } else {
		        $transformedValues = $values;
		    }

		    $item = [
		        'name' => $key,
		        'values' => $transformedValues
		    ];

		    $transformedResponse[] = $item;
		}
		return response()->json(['data' => $transformedResponse]);
	}

	public function userSearchResAndDish(Request $request)
	{
		$rules['keyword'] = 'required';
		$rules['search']  = 'required|in:restaurants,dishes,cats';
		$this->validateDatas($request->all(),$rules);
		$user_id = 0;
		$cat_id = 0;
		$cookie_id = '';
		$keyword = $request->keyword;
		if($request->user_id > 0){
			$user_id = $request->user_id;
		}else{
			$cookie_id = $request->cookie_id;
		}

		if(isset($request->cat_id)){
			$cat_id = $request->cat_id;
		}

		$user = User::select('id', 'lat', 'lang', 'latitude', 'longitude')->find($user_id);
		$userLatitude = (isset($user->lat) && $user->lat != '') ? $user->lat : $user->latitude;
		$userLongitude = (isset($user->lang) && $user->lang != '') ? $user->lang : $user->longitude;
		$baseQuery = Restaurant::select('id', 'name', 'location', 'tagline', 'cuisine', 'latitude', 'longitude', 'logo', 'mode', 'l_id', 'rating')->where('status', 1)->where('mode', 'open')->where('admin_status', 'approved');

		if(isset($request->search)){

			if($request->search == 'restaurants'){
				$is_from = 'restaurants';
				$restaurant = $baseQuery->where('name', 'like', '%'.$keyword.'%')->get()->map(function($res) use($user_id, $keyword, $userLatitude, $userLongitude){
					$res->status = $res->getFavouriteAttribute($user_id);
				    $res->src = $res->getSrcAttribute();
				    $res->availability = $res->getAvailabilityAttribute();
				    $res->offer = $res->getResOfferAttribute();
				    $res->reviews = $res->getReviewAttribute();
				    $res->food_items = $res->getKeywordAttribute($keyword);
				    $restaurantLatitude = $res->latitude;
				    $restaurantLongitude = $res->longitude;
				    $distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
				    $res->makeHidden(['logo', 'mode', 'l_id', 'cuisine']);
				    if($distanceKm <= 20){
				    	return $res;
					}
				});
				$words = explode(' ', $keyword);
				foreach ($words as $word) {
					$moreres = $baseQuery->where('name', 'LIKE', "%$word%")->where('name', 'NOT LIKE', "%$keyword%")->get()->map(function($more) use($user_id, $keyword, $userLatitude, $userLongitude) {
						$more->status = $more->getFavouriteAttribute($user_id);
						$more->src = $more->getSrcAttribute();
						$more->availability = $more->getAvailabilityAttribute();
						$more->offer = $more->getResOfferAttribute();
						$more->reviews = $more->getReviewAttribute();
						$more->food_items = $more->getKeywordAttribute($keyword);
						$restaurantLatitude = $res->latitude;
				    	$restaurantLongitude = $res->longitude;
						$distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
						$more->makeHidden(['logo', 'mode', 'l_id', 'cuisine']);
						if($distanceKm <= 20){
					    	return $more;
						}
					});
					$moreres = $moreres->filter(function($res){
						if($res && $res->food_items && $res->food_items->isNotEmpty()){
					        return $res;
					    }
					})->values()->toArray();
				}
			}

			elseif($request->search == 'dishes'){
				$is_from = 'dishes';
				$restaurant = $baseQuery->get()->map(function($res) use($user_id, $keyword, $request, $userLatitude, $userLongitude){
					$res->status = $res->getFavouriteAttribute($user_id);
				    $res->src = $res->getSrcAttribute();
				    $res->availability = $res->getAvailabilityAttribute();
				    $res->offer = $res->getResOfferAttribute();
				    $res->reviews = $res->getReviewAttribute();
				    $res->food_items = $res->getKeywordAttribute($keyword, $request);
				    $restaurantLatitude = $res->latitude;
				    $restaurantLongitude = $res->longitude;
					$distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
				    $res->makeHidden(['logo', 'mode', 'l_id', 'cuisine']);
				    if($distanceKm <= 20){
				    	return $res;
					}
				}); 
				$restaurant = $restaurant->filter(function($res){
					if($res && $res->food_items && $res->food_items->isNotEmpty()){
				        return $res;
				    }
				})->values()->toArray();

				$moreres = $baseQuery->where('name', 'NOT LIKE', "%".$restaurant[0]['name']."%")->get()->map(function($more) use($user_id, $keyword, $request, $userLatitude, $userLongitude) {
					$more->status = $more->getFavouriteAttribute($user_id);
					$more->src = $more->getSrcAttribute();
					$more->availability = $more->getAvailabilityAttribute();
					$more->offer = $more->getResOfferAttribute();
					$more->reviews = $more->getReviewAttribute();
					$more->food_items = $more->getKeywordAttribute($keyword, $request);
					$restaurantLatitude = $more->latitude;
				    $restaurantLongitude = $more->longitude;
					$distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
					$more->makeHidden(['logo', 'mode', 'l_id', 'cuisine']);
					if($distanceKm <= 20){
				    	return $more;
					}
				});
				$moreres = $moreres->filter(function($res){
					if($res && $res->food_items && $res->food_items->isNotEmpty()){
				        return $res;
				    }
				})->values()->toArray();


			}

			elseif($request->search == 'cats' && $cat_id > 0){
				$is_from = 'dishes';
				$cat = $cat_id;
				$restaurant = $baseQuery->get()->map(function($res) use($user_id, $cat, $request, $userLatitude, $userLongitude){
					$res->status = $res->getFavouriteAttribute($user_id);
				    $res->src = $res->getSrcAttribute();
				    $res->availability = $res->getAvailabilityAttribute();
				    $res->offer = $res->getResOfferAttribute();
				    $res->reviews = $res->getReviewAttribute();
				    $res->food_items = Fooditems::where('main_cat', $cat)->where('item_status', 1)
			        ->where('del_status', 0)->where('restaurant_id', $res->id)->select('id', 'food_item', 'selling_price', 'strike_price', 'image', 'restaurant_id', 'main_cat', 'is_veg')->get()->map(function($food) use($request) {
			        	$food->selling_price = round($food->selling_price, 2);
			        	$food->strike_price = intval($food->strike_price);
			        	$res = Restaurant::find($food->restaurant_id);
				    	$food->rating = $res->rating;
				    	$food->reviews = $res->getReviewAttribute();
				    	$food->quantity = $food->getCartCountAttribute($request);
		                $food->append('src');
		                return $food;
			        });
			        $restaurantLatitude = $res->latitude;
				    $restaurantLongitude = $res->longitude;
					$distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
				    $res->makeHidden(['logo', 'mode', 'l_id', 'cuisine']);
				    if($distanceKm <= 20){
				    	return $res;
					}
				}); 

				$restaurant = $restaurant->filter(function($res){
					if($res && $res->food_items && $res->food_items->isNotEmpty()){
				        return $res;
				    }
				})->values()->toArray();

				$moreres = $baseQuery->where('name', 'NOT LIKE', "%".$restaurant[0]['name']."%")->get()->map(function($more) use($user_id, $cat, $userLatitude, $userLongitude) {
					$more->status = $more->getFavouriteAttribute($user_id);
					$more->src = $more->getSrcAttribute();
					$more->availability = $more->getAvailabilityAttribute();
					$more->offer = $more->getResOfferAttribute();
					$more->reviews = $more->getReviewAttribute();
					$more->food_items = Fooditems::where('main_cat', $cat)->where('item_status', 1)
			        ->where('del_status', 0)->where('restaurant_id', $more->id)->select('id', 'food_item', 'selling_price', 'image', 'restaurant_id', 'main_cat')->get();
			        $restaurantLatitude = $more->latitude;
				    $restaurantLongitude = $more->longitude;
					$distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
					$more->makeHidden(['logo', 'mode', 'l_id', 'cuisine']);
					if($distanceKm <= 20){
				    	return $more;
					}
				});
				$moreres = $moreres->filter(function($res){
					if($res && $res->food_items && $res->food_items->isNotEmpty()){
				        return $res;
				    }
				})->values()->toArray();
			}



			$usersearch = new UserSearchKeyword();
			$usersearch->user_id = $user_id;
			$usersearch->cookie_id = $cookie_id;
			$usersearch->keyword = $keyword;
			$usersearch->search = $request->search;
			$usersearch->cat_id = $cat_id;
			$usersearch->save();

			$data['restaurant'] = $restaurant;
			$data['more'] = $moreres;
			$data['is_from'] = $is_from;
		}
		$response['searches'] = $data;
		$ucart = Usercart::select('id', 'user_id', 'res_id', 'food_id', 'food_item', 'quantity', 'vendor_price')->where('user_id', $user_id)->get();
		if($ucart->isNotEmpty()){
			$response['total_items'] = $ucart->sum('quantity');
			$response['total_price'] = round($ucart->sum('vendor_price'), 2);
			$response['res_name'] = Restaurant::where('id', $ucart[0]->res_id)->pluck('name')->first();
		}elseif($ucart->isEmpty()){
			$response['total_items'] = 0;
			$response['total_price'] = 0;
			$response['res_name'] = '';
		}
		return \Response::json($response,200);

	}

	public function shopEdit(Request $request)
	{
		$rules['res_id'] = 'required';
		$this->validateDatas($request->all(),$rules);
		$res = Restaurant::find($request->res_id);
		$resTime = RestaurantTiming::where('res_id', $request->res_id)->get();
		$response['restaurant_detail'] = $res;
		$response['restaurant_timing'] = $resTime;
		return \Response::json($response,200);
	}

	public function shopList(Request $request)
	{
		$rules['from'] = 'required|in:home,offer';
		if(isset($request->from) && $request->from == 'offer'){
			$rules['res_id'] = 'required';
			$rules['promo_id'] = 'required';
		}
		$rules['user_id'] = 'required';
		$this->validateDatas($request->all(),$rules);
		$shop_cat_id = $request->shop_cat_id;
		$user = User::find($request->user_id);
		$user_id = $user->id;
		$userLatitude = (isset($user) && $user->lat != '') ? $user->lat : $user->latitude;
		$userLongitude = (isset($user) && $user->lang != '') ? $user->lang : $user->longitude;
		$distance = 20;
		$res = new \App\Models\Front\Restaurant();
		$res->setUser($user_id);
		$res = $res->select('id', 'name', 'logo', 'tagline', 'location', 'mode', 'l_id', 'latitude', 'longitude', 'rating')
		->where('mode', 'open')
		->where('admin_status', 'approved')
		->where('status', 1)
		->when(isset($shop_cat_id) && $shop_cat_id !== 'All', function ($query) use ($shop_cat_id) {
			return $query->whereRaw('FIND_IN_SET(?, `cuisine`)', [$shop_cat_id]);
			})
		->when($request->from == 'offer' && $request->res_id != '0', function ($query) use ($request){
			return $query->whereIn('id', explode(',', $request->res_id));
			})
		->get();

		$res = $res->filter(function ($restaurant) use ($user_id, $userLatitude, $userLongitude, $distance) {
		    $restaurant->status = $restaurant->getFavouriteAttribute($user_id);
		    $restaurant->src = $restaurant->getSrcAttribute();
		    $restaurant->availability = $restaurant->getAvailabilityAttribute();
		    $restaurant->review = $restaurant->getReviewAttribute();
		    $restaurant->offer = $restaurant->getResOfferAttribute();
		    $restaurant->makeHidden(['logo', 'mode', 'l_id']);
		    $foods = Fooditems::where('restaurant_id', $restaurant->id)
		        ->where('approveStatus', 'Approved')
		        ->where('item_status', 1)
		        ->where('del_status', 0)
		        ->get();
		    if ($foods->isNotEmpty()) {
		        $restaurantLatitude = $restaurant->latitude;
		        $restaurantLongitude = $restaurant->longitude;
		        $distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
		        return $distanceKm <= $distance;
		    }
		    return false;
		});
		
		$once = 5;
		$cpage = request()->input('page', 1);
		$currentPageResults = array_slice($res->toArray(), ($cpage - 1) * $once, $once);
		$res = new \Illuminate\Pagination\LengthAwarePaginator(
		    $currentPageResults,
		    count($res),
		    $once,
		    $cpage,
		    ['path' => $request->url(), 'query' => $request->query()]
		);

		$currentDay = date('Y-m-d');
		$promo	= \DB::table('abserve_promocode')->where('id', $request->promo_id)->select('id','promo_name','promo_desc','promo_type','promo_amount','res_id','promo_code','min_order_value','avatar')->first();
			$response['restaurant_detail'] = $res->items();
			$response['restaurant_detail_pagination'] = [
				'total' => $res->total(),
				'per_page' => $res->perPage(),
				'current_page' => $res->currentPage(),
				'last_page' => $res->lastPage(),
				'links' => [
			        'prev' => $res->previousPageUrl() ?? '',
			        'first' => $res->url(1),
			        'next' => $res->nextPageUrl() ?? '',
			        'last' => $res->url($res->lastPage())
			    ]
			];
		if($promo && $promo != null){
			$response['promo_details'] = $promo;
		}else{
			$response['promo_details'] = (object)['id' => 0, 'promo_name' => '', 'promo_desc' => '', 'promo_type' => '', 'promo_amount' => 0, 'res_id' => 0, 'promo_code' => '', 'min_order_value' => 0, 'avatar' => ''];
		}
		return \Response::json($response,200);
	}

	public function resSearch(Request $request)
	{
		$rules['keyword'] = 'required';
		$rules['res_id'] = 'required';
		$rules['user_id'] = 'required';
		$this->validateDatas($request->all(),$rules);
		$searches = Fooditems::select('id', 'food_item as name', 'restaurant_id', 'description', 'selling_price', 'strike_price', 'image', 'is_veg')->where('food_item', 'like', '%'.$request->keyword.'%')->where('approveStatus', 'Approved')->where('item_status', 1)->where('del_status', 0)->where('restaurant_id', $request->res_id)->get()->map(function($food) use ($request) {
				$food->selling_price = round($food->selling_price, 2);
			    $food->strike_price = intval($food->strike_price);	
				$food->src = $food->getSrcAttribute();
				$food->quantity = $food->getCartCountAttribute($request);
				$food->makeHidden('image');
				return $food;
			});

		$searches->each(function ($foodItem) {
	    	$res = Restaurant::find($foodItem->restaurant_id);
	    	$foodItem->rating = $res->rating;
	    	$foodItem->reviews = $res->getReviewAttribute();
        });
        $ucart = Usercart::select('id', 'user_id', 'res_id', 'food_id', 'food_item', 'quantity', 'vendor_price')->where('user_id', $request->user_id)->get();
		if($ucart->isNotEmpty()){
			$response['total_items'] = $ucart->sum('quantity');
			$response['total_price'] = round($ucart->sum('vendor_price'), 2);
			$response['res_name'] = Restaurant::where('id', $ucart[0]->res_id)->pluck('name')->first();
		}elseif($ucart->isEmpty()){
			$response['total_items'] = 0;
			$response['total_price'] = 0;
			$response['res_name'] = '';
		}
        $response['datas'] = $searches;
        return \Response::json($response,200);
	}
}
?>
