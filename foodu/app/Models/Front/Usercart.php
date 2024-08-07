<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Usercart extends Sximo  {

	protected $table = 'abserve_user_cart';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
	}
	protected $fillable = ['wallet'];
	
	function getRestaurantNameAttribute()
	{
		$res_id = $this->attributes['res_id'];
		$res = \DB::table('abserve_restaurants')->select('name')->where('id',$res_id)->first();
		$name = !empty($res) ? $res->name : '';
		return $name;
	}

	function getFoodItemsAttribute()
	{
		return Fooditems::where('id',$this->food_id)->where('restaurant_id',$this->res_id)->where('del_status','0')->where('approveStatus','Approved')->first();
	}

	function getFoodPriceAttribute()
	{
		if($this->adon_type == 'unit'){
			return FooditemsUnit::select('price','selling_price','original_price','selling_price as show_price','hiking')->where('id', $this->adon_id)->where('food_id', $this->food_id)->first();
		} elseif ($this->adon_type == 'variation') {
			return FooditemsVariation::select('price','selling_price','original_price','selling_price as show_price','hiking')->where('id', $this->adon_id)->where('food_id', $this->food_id)->first();
		} else {
			return Fooditems::select('price','selling_price','selling_price as show_price','original_price','hiking')->where('id',$this->food_id)->where('restaurant_id',$this->res_id)->where('del_status','0')->where('approveStatus','Approved')->first();
		}
	}

	function getFoodItemDetailAttribute($device_id,$user_id)
	{
		$food = Fooditems::select('id','restaurant_id','food_item','description','price','selling_price','original_price','status','start_time1','end_time1','start_time2','end_time2','item_status','image')->where('id',$this->food_id)->where('restaurant_id',$this->res_id)->where('del_status','0')->where('approveStatus','Approved')->first();
		if(!empty($food)){
			$food->append('src','availability','show_price');
			$food->cart_detail = $food->getCartInfoAttribute($device_id,$user_id);
			$food->cart = $food->getCartItemAttribute($device_id,$user_id);
		}
		return $food;
	}
}
