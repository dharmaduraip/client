<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;
use App\Models\Foodcategories;
use App\Models\FooditemsUnit;
use App\Models\FooditemsVariation;

class Fooditems extends Sximo  {
	
	protected $table = 'abserve_hotel_items';
	protected $primaryKey = 'id';
	// protected $appends = ['gst'];
	protected $guarded = array();
	protected $fillable = ['restaurant_id','food_item','price','selling_price','original_price','hiking','main_cat','sub_cat','item_status','adon_type','image','approveStatus','strike_price'];
	// protected $appends = ['restaurant'];

	public function getResdetail($res_id)
	{
		return \DB::select("  SELECT abserve_restaurants.`logo`,`name`,`budget` FROM abserve_restaurants WHERE `id` = ".$res_id);
	}
	
	public function getUserrestaurants($user_id,$group_id)
	{
		if($group_id != 1)
			return \DB::select("SELECT abserve_restaurants.* FROM abserve_restaurants WHERE `partner_id` = ".$user_id);
		else
			return \DB::select("SELECT abserve_restaurants.* FROM abserve_restaurants ");
	}

	public function scopeCommonselect($query)
	{
		$query->addSelect('id','restaurant_id','food_item as item_name','food_item','description','price','selling_price','original_price','status','main_cat','start_time1','end_time1','start_time2','end_time2','item_status','image','approveStatus','strike_price');
	}

	public function scopeNotdeleted($query)
	{
		$query->where('del_status','0');
	}

	public function scopeApproved($query)
	{
		$query->where('approveStatus','Approved');
	}

	function main_cat_info()
	{
		return $this->belongsTo('App\Models\Foodcategories','main_cat','id');
	}

	function getMainCatNameAttribute()
	{
		$category = Foodcategories::select('cat_name')->where('id',$this->attributes['main_cat'])->first();
		$name = !empty($category) ? $category->cat_name : '';
		return $name;
	}

	public function getimageAttribute()
	{
		$path   = 'storage/app/public/restaurant/'.$this->restaurant_id.'/'.$this->attributes['image'];
		if ($this->attributes['image'] != '' && \File::exists(base_path($path))) {
			$url    = \URL::to($path);
		} else {
			$url    = \AbserveHelpers::getCommonImageUser();
		}
		return $url;
	}

	public function getRestaurantAttribute()
	{
		$res = Restaurant::where('id', $this->restaurant_id)->first();
		return $res;
	}

	function getSrcAttribute()
	{
		/*$fileName = $this->attributes['image'];
		$aFilename = explode(',', $fileName);
		$aSrc = [];
		if($fileName != ''){
			foreach ($aFilename as $key => $value) {
				if($value != ''){
					$path = 'uploads/images/'.$value;
					if($fileName != '' && file_exists(base_path($path))){
						$aSrc[] = \URL::to($path);
					}
				}
			}
		}
		if(count($aSrc) == 0){
			$aSrc[] = \URL::to('uploads/images/no-image.jpg');
		}
		return $aSrc;*/

		$image	= $this->attributes['image'];
		$return	= \URL::to('uploads/images/no-image.jpg');
		if($image != '' && file_exists(base_path('/uploads/images/'.$image)))
			$return	= \URL::to('/uploads/images').'/'.$image;


		if($return == \URL::to('uploads/images/no-image.jpg')){
			$path   = 'storage/app/public/restaurant/'.$this->restaurant_id.'/'.$this->attributes['image'];
			if ($this->attributes['image'] != '' && \File::exists(base_path($path))) {
				$return    = \URL::to($path);
			} else {
				$return    = \AbserveHelpers::getCommonImageUser();
			}
		}

		return $return;
		
	}

	/*function getGstAttribute()
	{
		return $this->attributes['gst'];
	}*/

	function getExactSrcAttribute()
	{
		$exp		= explode(',', $this->attributes['image']);
		foreach ($exp as $key => $value) {
			$path = 'storage/app/public/restaurant/'.$this->attributes['restaurant_id'].'/'.$value;
			if($value != '' && file_exists(base_path($path))){
				// $path = 'uploads/images/'.rawurlencode($value);
				$path = 'storage/app/public/restaurant/'.$this->attributes['restaurant_id'].'/'.rawurlencode($value);
				return \URL::to($path);
				break;
			}
		}
		return \URL::to('uploads/images/no-image.jpg');
	}
	function restaurant()
	{
		return $this->belongsTo('App\Models\Front\Restaurant','restaurant_id','id');
	}
	function getAvailabilityAttribute()
	{
		$text = ''; $status = 1;
		$cur_time = date("H:i:s");
		$start 	= $this->attributes['start_time1'];
		$end 	= $this->attributes['end_time1'];
		$start2 = $this->attributes['start_time2'];
		$end2 	= $this->attributes['end_time2'];
		$shop_check = $this->restaurant->gst_applicable;
		if ($this->attributes['item_status'] == 0) {
			$text = 'Out of stock';
				$status = 0;
		} else if ($shop_check == 'no') {
			$text = '';
		} else if(($start == $end) || ($cur_time >= $start && $cur_time <= $end || $cur_time >= $start2 && $cur_time <= $end2 )) {
		} else {
			if($cur_time < $start && $cur_time < $end){
				$text = 'Next at, '.date("g:i a",strtotime($this->attributes['start_time1'])).' today';
				$status = 0;
			} else if($cur_time < $start2 && $cur_time < $end2){
				$text = 'Next at, '.date("g:i a",strtotime($this->attributes['start_time2'])).' today';
				$status = 0;
			} else if(($cur_time > $start && $cur_time > $end) && ($cur_time > $start2 && $cur_time > $end2)) {
				$text = 'Next at, '.date("g:i a",strtotime($this->attributes['start_time1'])).' tomorrow';
				$status = 0;
			}
		}
		$data['status'] = $status;
		$data['text']	= $text;
		return $data;
	}

	function getNextAvailableTimeTextAttribute()
	{
		$text = '';
		$cur_time = (int)date("Hi");
		$start 	= (int)($this->attributes['start_time1'] != '') ? (date("Hi",strtotime($this->attributes['start_time1']))) : '';
		$end 	= (int)($this->attributes['end_time1'] != '') ? (date("Hi",strtotime($this->attributes['end_time1']))) : '';
		$start2 	= (int)($this->attributes['start_time2'] != '') ? (date("Hi",strtotime($this->attributes['start_time2']))) : '';
		$end2 	= (int)($this->attributes['end_time2'] != '') ? (date("Hi",strtotime($this->attributes['end_time2']))) : '';
		if($this->attributes['item_status'] == 0){
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
					$text = 'Opens at, '.date("g:i a",strtotime($this->attributes['start_time1'])).' today';
				} else if($cur_time < $start2 && $cur_time < $end2){
					$text = 'Opens at, '.date("g:i a",strtotime($this->attributes['start_time2'])).' today';
				} else if(($cur_time > $start && $cur_time > $end) && ($cur_time > $start2 && $cur_time > $end2)) {
					$text = 'Opens at, '.date("g:i a",strtotime($this->attributes['start_time1'])).' tomorrow';
				}
			}
		}
		return $text;
	}

	function getCartQuantityValueAttribute($device_id='',$user_id=0)
	{
		$field = $user_id > 0 ? 'user_id' : 'cookie_id';
		$fieldVal = $user_id > 0 ? $user_id : $device_id;
		$cart = Usercart::where('food_id',$this->attributes['id'])->where($field,$fieldVal)->select('quantity')->first();
		$quantity = !empty($cart) ? $cart->quantity : 0;
		return $quantity;
	}

	function getCartCountAttribute($request)
	{
		$cart = Usercart::where('food_id',$this->attributes['id'])->where('user_id',$request->user_id)->select('quantity')->first();
		$quantity = !empty($cart) ? $cart->quantity : 0;
		return $quantity;
	}

	function getCartInfoAttribute($device_id='',$user_id=0,$cartid='')
	{
		$field = $user_id > 0 ? 'user_id' : 'cookie_id';
		$fieldVal = $user_id > 0 ? $user_id : $device_id;
		$cart = Usercart::where('food_id',$this->attributes['id'])->where($field,$fieldVal)->select('quantity','item_note','food_item','adon_type','adon_details','adon_id','strike_price');
		if (!empty($cartid)) {
			$cart = $cart->where('id',$cartid);
		}
		$cart = $cart->first();
		if(empty($cart)){
			$cart1['quantity'] = 0;
			// $cart1['item_note'] = '';
			$cart_Detail = json_decode(json_encode($cart1));
		} else {
			if($cart->adon_id == 0) {
				$cart->adon_id = '';
			}
			$cart_Detail = $cart;
		}
		return $cart_Detail;
	}

	function getCartItemAttribute($device_id='',$user_id=0)
	{
		$field = $user_id > 0 ? 'user_id' : 'cookie_id';
		$fieldVal = $user_id > 0 ? $user_id : $device_id;
		$cart = Usercart::where('food_id',$this->attributes['id'])->where($field,$fieldVal)->select('quantity','item_note')->first();
		if(empty($cart)){
			$cart1['quantity'] = 0;
			$cart1['item_note'] = '';
			$cart_Detail = json_decode(json_encode($cart1));
		} else {
			$cart_Detail = $cart;
		}
		return $cart_Detail;
	}

	function getShowPriceAttribute()
	{
		$price = $this->attributes['selling_price'] > 0 ? $this->attributes['selling_price'] : $this->attributes['price'];
		$price =  $this->attributes['price'];
		return (string) number_format($price,2,'.','');
	}

	function getFoodItemsSearchAttribute($device_id,$user_id,$keyword)
	{
		$aFoodItems = Fooditems::select('id','restaurant_id','food_item','description','price','selling_price','original_price','status','start_time1','end_time1','start_time2','end_time2','item_status','image','strike_price')->where('restaurant_id',$this->restaurant_id)->where('del_status','0')->where('approveStatus','Approved')
			->where(function($fquery) use($keyword){
				$fquery->where('food_item','like',  $keyword );
				$fquery->orWhere('food_item','like', '%'. $keyword .'%' );
			})
			->orderByRaw('(case 
				when (food_item LIKE "'.$keyword.'") then 1 
				when food_item LIKE "%'.$keyword.'%" then 2
				end)'
			)
			->get()->map(function ($fresult) use($device_id,$user_id){
		       	$fresult->append('exact_src','availability','show_price');
		       	$fresult->cart_quantity = $fresult->getCartQuantityValueAttribute($device_id,$user_id);
				$fresult->cart_detail = $fresult->getCartInfoAttribute($device_id,$user_id);
		       	return $fresult;
		    });
		return $aFoodItems;
	}

	function getRestaurantInfoAttribute($device_id,$user_id)
	{
		$restaurant_id = $this->attributes['restaurant_id'];
		$select = ['id','name','cuisine','rating','delivery_time','mode','logo','minimum_order','free_delivery','show','preoder'];
		$where = 'where';$whereCondition = '';$whereField = 'id';$whereValues = $restaurant_id;
		$restaurant = \AbserveHelpers::getRestaurantBaseQuery($select,$where,$whereCondition,$whereField,$whereValues)->first();
		$restaurant->append('availability','cuisine_text','src');
		$restaurant->cart_exist = $restaurant->getCartExistCheckAttribute($device_id,$user_id);
		return $restaurant;
	}

	function getShowAddonAttribute()
	{
		if($this->adon_type == 'unit' || $this->adon_type == 'variation'){
			return true;
		}
		return false;
	}

	function getFoodItemDetailAttribute($restaurant_id)
	{
		$select = ['id','restaurant_id','food_item','description','specification','main_cat','status','item_status','recommended','adon_type','start_time1','end_time1','start_time2','end_time2','image','price','selling_price','original_price','gst','strike_price'];
		$query = Fooditems::where('restaurant_id',$restaurant_id)->where('del_status','0');
		$res = $query->where('main_cat',$this->main_cat)->select($select)->get();
		return $res->map(function ($result) {
		       	$result->append('exact_src');
		       	return $result;
		    });;
	}

	function getResrulesAttribute()
	{
		$res = Restaurant::where('id', $this->id)->where('status', 1)->where('mode', 'open')->where('admin_status', 'approved')->first();
		return $res;
	}

	function unit()
	{
		return $this->hasMany(FooditemsUnit::class,'food_id','id');
	}

	function variation()
	{
		return $this->hasMany(FooditemsVariation::class,'food_id','id');
	}

}
