<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;
use App\Models\Foodcategories;
use App\Models\Addons;
use App\Models\Fooditems as food;

class Restaurant extends Sximo  {
	
	protected $table		= 'abserve_restaurants';
	protected $primaryKey	= 'id';
	protected $user_id      = 0;
	// protected $appends		= ['src'];
	public $timestamps		= false;
	public function __construct() {
		parent::__construct();
	}

	public function scopeCommonselect($query)
	{
		$query->addSelect('id','name','logo','mode','l_id');
	}

	public function setUser($user_id)
	{
		$this->user_id = $user_id;
		// $this->getFavouriteAttribute($user_id);
	}

	public function scopeNearby($query,$latitude=0.00,$longitude=0.00,$distance=0)
	{
		if ($distance == 0 || $distance > \AbserveHelpers::getMaxRadius())
			$distance	= \AbserveHelpers::getMaxRadius();
		$lat_lng		= " ( round(
			( 6371 * acos( least(1.0,
			cos( radians(".$latitude.") )
			* cos( radians(latitude) )
			* cos( radians(longitude) - radians(".$longitude.") )
			+ sin( radians(".$latitude.") )
			* sin( radians(latitude)
			) ) )
		), 2) ) ";
		$query->whereRaw($lat_lng . '<= '.$distance);
		return $query;
	}

	public function getLogoAttribute()
	{
		$logo	= $this->attributes['logo'];
		$return	= \URL::to('uploads/images/no-image.jpg');
		if($logo != '' && file_exists(base_path('/uploads/restaurants/'.$logo)))
			$return	= \URL::to('/uploads/restaurants').'/'.$logo;
		return $return;
	}

	public function getBannerImageAttribute()
	{
		$banners= explode(',', $this->attributes['banner_image']);
		$return	= [];
		if(!empty($banners)){
			foreach ($banners as $key => &$value) {
				if($value != '' && file_exists(base_path('/uploads/restaurants/'.$value))){
					$return[]  = \URL::to('/uploads/restaurants').'/'.$value ;
				}
			}
		}
		return $return;
	}

	public function getBannerAttribute()
	{
		$aBanner	= $this->select('id', \DB::raw("CONCAT(logo,',',banner_image) AS banners"))->where('id',$this->attributes['id'])->first();
		$return = [];
		if (!empty($aBanner)) {
			$banners = explode(',', $aBanner->banners);
			if(!empty($banners)) {
				foreach ($banners as $key => &$value) {
					if($value != '' && file_exists(base_path('/uploads/restaurants/'.$value))){
						$return[]  = \URL::to('/uploads/restaurants').'/'.$value ;
					}
				}
			}
		}
		return $return;
		/*$tags	= explode(',', $this->attributes['banner_image']);
		$id = $this->attributes['id'];
		if (request()->segment(1) != 'api' || ((!is_null(request()->header('version')) && request()->header('version') == '1.2') && (request()->segment(1) == 'api' && (request()->segment(2) == 'restaurant' || request()->segment(2) ==  'restaurantList')))) {
			if(!empty($tags)){
				foreach ($tags as $key => &$value) {
					if($value != '' && file_exists(base_path('/uploads/restaurants/'.$value))){
						$value  = \URL::to('/uploads/restaurants').'/'.$value ;
					}else {
						$value  =\URL::to('uploads/restaurants/Default_food.jpg') ;
					}
				}
			} else {
				$tags[]  =\URL::to('uploads/restaurants/Default_food.jpg') ;
			}
			return $tags;
		}else{
			return isset($tags[0]) ? $tags[0] : '';
		}*/
	}

	function getManagerInfoAttribute()
	{
		$parther_id = $this->partner_id;
		$partner = \DB::table('tb_users')->where('id',$parther_id)->first();
		$manager = $partner->manager_id > 0 ? \DB::table('tb_users')->where('id',$partner->manager_id)->first() : '';
		return $manager;
	}
	
	public function resrating($id='')
	{
		$overall_rate 	= $this->getRating($id);
		$round_overall	= round($overall_rate);
		return $round_overall;
	}

	public function getOverallRatingAttribute()
	{
		$star_1 = \DB::select("SELECT count(rating)as rating1 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 1");
		$star_2 = \DB::select("SELECT count(rating)as rating2 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 2");
		$star_3 = \DB::select("SELECT count(rating)as rating3 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 3");
		$star_4 = \DB::select("SELECT count(rating)as rating4 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 4");
		$star_5 = \DB::select("SELECT count(rating)as rating5 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 5");

		$str_1 = $star_1[0]->rating1;
		$str_2 = $star_2[0]->rating2;
		$str_3 = $star_3[0]->rating3;
		$str_4 = $star_4[0]->rating4;
		$str_5 = $star_5[0]->rating5;

		$total_count = $str_5 + $str_4 + $str_3 + $str_2 + $str_1;

		$Rating = (($str_5 * 5) + ($str_4 * 4) + ($str_3 * 3) + ($str_2 * 2) + ($str_1 * 1));
		if($total_count == 0 || $Rating == 0) {
			$tot = 0;
		} else {
			$tot = ($Rating/$total_count);
		}
		return round($tot);
	}

	function getRatingCountAttribute()
	{
		$star_1 = \DB::select("SELECT count(rating)as rating1 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 1");
		$star_2 = \DB::select("SELECT count(rating)as rating2 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 2");
		$star_3 = \DB::select("SELECT count(rating)as rating3 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 3");
		$star_4 = \DB::select("SELECT count(rating)as rating4 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 4");
		$star_5 = \DB::select("SELECT count(rating)as rating5 FROM `abserve_rating` WHERE `res_id` = ".$this->attributes['id']." AND `rating` = 5");
		$str_1 = $star_1[0]->rating1;
		$str_2 = $star_2[0]->rating2;
		$str_3 = $star_3[0]->rating3;
		$str_4 = $star_4[0]->rating4;
		$str_5 = $star_5[0]->rating5;

		$total_count = $str_5 + $str_4 + $str_3 + $str_2 + $str_1;
		return $total_count;
	}

	function getRatingAttribute()
	{
		return round($this->attributes['rating'], 1);
	}

	function getSrcAttribute()
	{
		$logo	= $this->attributes['logo'];
		$return	= \URL::to('uploads/restaurants/Default_food.jpg');
		if($logo != '' && file_exists(base_path('/uploads/restaurants/'.$logo)))
			$return	= \URL::to('/uploads/restaurants').'/'.$logo;
		return $return;
	} 

	function getRestaurantTimingAttribute()
	{
		$aDays = \DB::table('abserve_restaurant_timings')->select('day_id','start_time1','end_time1','start_time2','end_time2','day_status')->where('res_id','=',$this->attributes['id'])->get();
		$days = array( '1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thuesday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday' );
		if(count($aDays) > 0){
			foreach ($aDays as $key => $value) {
				$value->full_day = false;
				if($value->start_time1 == '12:00am' && $value->end_time1 == '12:00am'){
					$value->full_day = true;
				}
				$value->day = $days[$value->day_id];
			}
		}
		return $aDays;
	}

	function getTimeTextAttribute()
	{
		$currentDay = date('N');
		$timeArr	= $this->getRestaurantTimingAttribute();
		if (!empty($timeArr) && !empty($timeArr[$currentDay-1])) {
			return $timeArr[$currentDay-1]->start_time1.' To '.$timeArr[$currentDay-1]->end_time1;
		}
		return '';
	}

	function getAvailabilityAttribute()
	{
		$res_timeValid = 0;
		$text		= '';
		$res_id		= $this->attributes['id'];
		$resMode	= $this->attributes['mode'];
		$location	= \DB::table('location')->where('id',$this->l_id)->first();
		if($resMode && $resMode =='open'/* && !empty($location) && $location->emergency_mode == 'off'*/){
			$currentDay	= date('D');
			$dayofweek	= date('w');
			$dayofweek	= $dayofweek == 0 ? 7 : $dayofweek;
			$aDayInfo	= \DB::table('abserve_days')->select('*')->where('value',$currentDay)->first();
			$resInfo	= RestaurantTiming::where('res_id',$res_id)->where('day_id',$dayofweek)->first();
			$unavailable_date = \DB::table('abserve_restaurant_unavailable_date')->where('res_id','=',$res_id)->where('date',date("Y-m-d"))->first();
			$text = 'find_next';
			if($unavailable_date =='' ){
				$text = 'Unavailable';
				if(!empty($resInfo)){
					$text = 'find_next';
					$dayStatus	= $resInfo->day_status;
					if($dayStatus==1) {
						// $text = 'Available';
						if($resInfo->start_time1 != '' && $resInfo->end_time1 != ''){
							$text		= 'Available';
							$aStart1	= \DB::table('abserve_time')->where('name','like',$resInfo->start_time1)->first();
							$aEnd1		= \DB::table('abserve_time')->where('name','like',$resInfo->end_time1)->first();
							$aStart2	= \DB::table('abserve_time')->where('name','like',$resInfo->start_time2)->first();
							$aEnd2		= \DB::table('abserve_time')->where('name','like',$resInfo->end_time2)->first();
							$curMin		= (date('H') * 60 ) + date('i');
							$s1			= (!empty($aStart1)) ? $aStart1->time : 0; $e1 = (!empty($aEnd1)) ? $aEnd1->time : 0;
							$s2			= (!empty($aStart2)) ? $aStart2->time : 0; $e2 = (!empty($aEnd2)) ? $aEnd2->time : 0;
							if($s1 == '0' && $e1 == '0'){
								$res_timeValid=1;
							}elseif($s1 <= $curMin && $e1 >= $curMin){
								$res_timeValid=1;
							} elseif ($s2 <= $curMin && ( $e2 >= $curMin || ($e2 == '0' && $s2 > '0') )) {
								$res_timeValid=1;
							} else {
								if($curMin < $s1 && $curMin < $e1){
									$text = 'Opens at, '.date('g:i a',strtotime($resInfo->start_time1)).' today';
								} else if($curMin < $s2 && ( $curMin < $e2 || $e2 == '0' )){
									$text = 'Opens at, '.date('g:i a',strtotime($resInfo->start_time2)).' today';
								} else {
									$text = 'find_next';
								}
							}
						}
					}
				}
			}
			if($text == 'find_next'){
				$days = array( '1' => 'Monday', '2' => 'Tuesday', '3' => 'Wednesday', '4' => 'Thuesday', '5' => 'Friday', '6' => 'Saturday', '7' => 'Sunday' );

				$nextdays = \AbserveHelpers::getnextdays(7);
				unset($nextdays[0]);
				foreach ($nextdays as $key => $value) { 
					$find = \DB::table('abserve_restaurant_timings')->where('res_id',$res_id)->where('day_id',$value)->where('day_status',1)->first();
					if(!empty($find)){
						if($key == 1){
							$day = 'Tommorow';
						}else{
							$day = $days[$value];
						}
						if($find->start_time1 != ''){
							$text = 'Opens at, '.$find->start_time1.' '.$day;
							break;
						}elseif($find->start_time2 != ''){
							$text = 'Opens at, '.$find->start_time2.' '.$day; 
							break;
						}
					}
				}			
				if($text == 'find_next'){
					$text = 'Unavailable';
				}			
			}
		} else {
			$text = 'Closed';
		}
		$data['status'] = $res_timeValid;
		$data['text'] = $text;
		return $data;
	}

	function getNextAvailableTimeTextAttribute()
	{
		$text = '';
		$iRestaurantId = $this->attributes['id'];
		if($this->attributes['mode']=='open'){
			$dayofweek = date('w');
			$today = date('Y-m-d');
			$unavailable_date = \DB::table('abserve_restaurant_unavailable_date')->where('res_id','=',$iRestaurantId)->where('date',$today)->first();
			$resTiming = RestaurantTiming::where('res_id',$iRestaurantId)->where('day_id',$dayofweek)->first();
			$text = 'find_next';
			if($unavailable_date == ''){
				$text = 'Unavailable';
				if(!empty($resTiming)) {
					$text = 'find_next';
					if($resTiming->day_status == 1) {
						$resAvailCheck = $this->getAvailabilityAttribute();
						$text = 'Available';
						if($resAvailCheck['status'] == '0'){
							$aStart1 = \DB::table('abserve_time')->where('name','like',$resTiming->start_time1)->first();
							$aEnd1   = \DB::table('abserve_time')->where('name','like',$resTiming->end_time1)->first();
							$aStart2 = \DB::table('abserve_time')->where('name','like',$resTiming->start_time2)->first();
							$aEnd2   = \DB::table('abserve_time')->where('name','like',$resTiming->end_time2)->first();
							$curMin = (date('H') * 60 ) + date('i');
							$s1			= (!empty($aStart1)) ? $aStart1->time : 0; $e1 = (!empty($aEnd1)) ? $aEnd1->time : 0;
							$s2			= (!empty($aStart2)) ? $aStart2->time : 0; $e2 = (!empty($aEnd2)) ? $aEnd2->time : 0;
							if($curMin < $s1 && $curMin < $e1){
								$text = 'Opens at, '.date('g:i a',strtotime($resTiming->start_time1)).' today';
							} else if($curMin < $s2 && ( $curMin < $e2 || $e2 == '0' )){
								$text = 'Opens at, '.date('g:i a',strtotime($resTiming->start_time2)).' today';
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
					$find = \DB::table('abserve_restaurant_timings')->where('res_id',$iRestaurantId)->where('day_id',$value)->where('day_status',1)->first();
					if(isset($find) && !empty($find)){
						if($key == 1){
							$day = 'Tommorow';
						}else{
							$day = $days[$value];
						}
						if($find->start_time1 != ''){
							$text = 'Next Available at '.$day.' '.$find->start_time1; break;
						}elseif($find->start_time2 != ''){
							$text = 'Next Available at '.$day.' '.$find->start_time2; break;
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

	function getFavouriteAttribute($user_id='0')
	{
		if($user_id > 0){
			$fav = Favorites::where('user_id',$user_id)->where('resid',$this->attributes['id'])->where('status', 1)->first();
			if(isset($fav)){
				return 1;
			}else{
				return 0;
			}
		}
		return 0;
	}

	function getKeywordAttribute($keyword = '', $request = '')
	{ 
		$words = explode(' ', $keyword);

		$foods = collect(); 
		$fooditemBaseQuery = Fooditems::where('approveStatus', 'Approved')
		        ->where('item_status', 1)
		        ->where('del_status', 0)
		        ->select('id', 'food_item', 'selling_price', 'strike_price', 'image', 'restaurant_id','is_veg')
		        ->where('restaurant_id', $this->id);

		foreach ($words as $word) {
		    $foodItems = $fooditemBaseQuery->get();

		    $foodItems->each(function ($foodItem) {
		    	$foodItem->selling_price = round($foodItem->selling_price, 2);
		    	$foodItem->strike_price = intval($foodItem->strike_price);
		    	$res = Restaurant::find($foodItem->restaurant_id);
		    	$foodItem->rating = $res->rating;
		    	$foodItem->reviews = $res->getReviewAttribute();
                $foodItem->append('src');
            });

		    $foods = $foods->concat($foodItems);
		}

		$dishes = collect();
		if(isset($request->search) && $request->search == 'dishes'){
			$food = $fooditemBaseQuery->where('food_item', $keyword)->select('id', 'food_item', 'selling_price', 'strike_price', 'image', 'restaurant_id', 'main_cat','is_veg')->get();
			if($food->isEmpty()){
				$food = $fooditemBaseQuery->where('food_item', 'LIKE', "%$keyword%")->select('id', 'food_item', 'selling_price', 'strike_price', 'image', 'restaurant_id', 'main_cat','is_veg')->get();
			}
			if($food->isNotEmpty()){
				$foodItems = $fooditemBaseQuery->where('approveStatus', 'Approved')
					->where('food_item', 'NOT LIKE', $food[0]->food_item)
			        ->where('main_cat', $food[0]->main_cat)
			        /*->select('id', 'food_item', 'selling_price', 'strike_price' 'image', 'restaurant_id')*/
			        ->get(); 
			        $foodItems = $food->concat($foodItems);

			    $foodItems->each(function ($foodItem) use($request) {
			    	$foodItem->selling_price = round($foodItem->selling_price, 2);
		    		$foodItem->strike_price = intval($foodItem->strike_price);
			    	$res = Restaurant::find($foodItem->restaurant_id);
			    	$foodItem->rating = $res->rating;
			    	$foodItem->reviews = $res->getReviewAttribute();
			    	$foodItem->quantity = $foodItem->getCartCountAttribute($request);
	                $foodItem->append('src');
	                $foodItem->makeHidden('main_cat');
	            });

			    $dishes = $dishes->concat($foodItems);
			}
		    $foods = $dishes;
		}
		return $foods;
	}

	function getCuisineTextAttribute()
	{
		$sCuisineId = $this->attributes['cuisine'];
		$aCuisineId = explode(',', $sCuisineId);
		$cuisine = Cuisines::select(\DB::raw('GROUP_CONCAT(name) as cuisineName'))->whereIn('id',$aCuisineId)->first();
		return $cuisine->cuisineName;
	}

	function getPromoCodeAttribute($user_id=0,$code='',$cartPrice='')
	{
		$restaurant_id = $this->attributes['id'];
		$aPromocode = \AbserveHelpers::getAvailablePromos($user_id,$code,$cartPrice,$restaurant_id);

		return $aPromocode;
	}

	function getPromoCheckAttribute($user_id=0,$code='',$cartPrice='',$restaurant_id='',$promo_id = '',$loc='')
	{
		$restaurant_id	= $this->attributes['id'];
		$aPromocode		= \AbserveHelpers::getAvailablePromos($user_id,$code,$cartPrice,$restaurant_id);
		$promoStatus	= count($aPromocode) > 0 ? 1 : 0;
		return $promoStatus;
	}

	function getCalculatePromoAmountAttribute($user_id,$code,$itemPrice)
	{
		$aPromocode = $this->getPromoCodeAttribute($user_id,$code);
		$promoAmount = 0;
		if(count($aPromocode) > 0){
			$promoCode = $aPromocode[0];
			if(($promoCode->min_order_value > 0 && $itemPrice >= $promoCode->min_order_value) || $promoCode->min_order_value == 0){
				$data['promoId'] 	 = $promoCode->id;
				if($promoCode->promo_type == 'amount'){
					$promoAmount = $promoCode->promo_amount;
				} else {
					$percent = $promoCode->promo_amount / 100;
					$promoAmount = $itemPrice * $percent;
				}
				if($itemPrice < $promoAmount){
					$promoAmount = $itemPrice;
				}
				if($promoAmount > 0 && $promoCode->max_discount > 0 && $promoAmount > $promoCode->max_discount){
					$promoAmount = $promoCode->max_discount;
				}
				$data['promoCode'] = $promoCode;
				$message = 'You saved Rs'.$promoAmount.' on this order';
			} else {
				$message = 'Oops! Cart value is not sufficient';
			}
		} else {
			$message = 'Oops! The Coupon is invalid';
		}
		$data['promoAmount'] = number_format($promoAmount,2,'.','');
		$data['message'] = $message;
		return $data;
	}

	function getCartExistCheckAttribute($device_id,$user_id)
	{
		$field = $user_id > 0 ? 'user_id' : 'cookie_id';
		$fieldVal = $user_id > 0 ? $user_id : $device_id;
		return Usercart::where($field,$fieldVal)->where('res_id','!=',$this->attributes['id'])->exists();
	}

	function getMapSrcAttribute()
	{
		$fileName = $this->attributes['static_map_image'];
		$path = 'uploads/restaurants/map/';
		if($fileName != '' && file_exists(base_path($path.$fileName))){
			return url($path.$fileName);
		}
		return url('uploads/restaurants/Default_food.jpg');
	}

	function getRatingCountTextAttribute()
	{
		$rating_count = \DB::table('abserve_rating')->where('res_id',$this->id)->count();
		if($rating_count < 100){
			return $rating_count;
		} else {
			$reminder = $rating_count % 100;
			$rating = $rating_count - $reminder;
			return $rating.'+';
		}
	}

	function getReviewCount($id)
	{
		return \DB::table('abserve_rating')->where('res_id',$id)->where('comments','!=','')->count();
	}

	function getCategoryAttribute()
	{
		$query = Fooditems::where('restaurant_id',$this->attributes['id'])->where('del_status','0');
		$res =  $query->select('main_cat',\DB::raw('COUNT(id) as food_count'))->groupBy('main_cat')->get()->map(function ($result) {return $result->append('main_cat_name');
	});
		return $res;
	}

	function getAdvertiseAttribute()
	{
		$image = \DB::table('location')->where('id',$this->l_id)->pluck('image as advert')->first();
		return !empty($image) ? \URL('/uploads/location_ad/'.$image): \URL::to('uploads/location_ad/'.\AbserveHelpers::getDefaultAdvert());
	}

	function getAdvertiseTypeAttribute()
	{
		$image = \DB::table('location')->find($this->l_id,['image as advert']);
		// $image = \DB::table('location')->where('id',$this->l_id)->pluck('image as advert');
		$image =  (isset($image) && !empty($image->advert)) ? \URL('/uploads/location_ad/'.$image->advert): \URL::to('storage/app/public/avatar.jpg');
		$ext   =  pathinfo($image);
		return \AbserveHelpers::ImageOrVideo($ext['extension']);
	}

	function getAdvertiseExtUrlAttribute()
	{
		$image = \DB::table('location')->where('id',$this->l_id)->pluck('ext_url');
		$image =  !empty($image) ? $image: '';
		return $image;
	}

	function getResOfferAttribute()
	{
		$currentDay = date('Y-m-d');
		$offer = \DB::table('abserve_promocode')->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->whereRaw('FIND_IN_SET('.$this->id.',`res_id`)')->select('promo_amount as Offer_amount', 'min_order_value', 'promo_type as Offer_type')->first();
		if($offer != ''){
			return $offer;
		}
		return (object)["Offer_amount" => 0, "min_order_value" => 0, "Offer_type" => ''];
                    
	}

	function getReviewAttribute()
	{
		$review = Restaurantrating::where('res_id', $this->id)->count();
		$message = 'reviews';

		if ($review == 1) {
			return $review . ' review';
		} elseif ($review < 1000) {
			return $review . ' ' . $message;
		} elseif ($review < 1000000) {
			return number_format($review / 1000, 1) . 'k ' . $message;
		} else {
			return number_format($review / 1000000, 1) . 'M ' . $message;
		}
	}

	function getRestuarantItems()
	{
		return $this->hasMany(Fooditems::class,'restaurant_id','id');
	}

	public function fooditems()
	{
		return $this->hasMany(food::class,'restaurant_id','id');
	}

	/**
     * The categories that belong to the restaurant.
     */
	public function categories()
	{
		return $this->belongsToMany(Foodcategories::class, Fooditems::class, 'restaurant_id', 'main_cat', 'id')->groupBy('main_cat');
	}

	public function ratings()
	{
		return $this->hasmany(Restaurantrating::class,'res_id','id')/*->addSelect(\DB::raw('COUNT(id) as rating_count , sum(rating) as rating_total'))*/->groupBy('res_id');
	}

	public function addons()
	{
		return $this->hasmany(Addons::class,'user_id','partner_id');
	}


}
