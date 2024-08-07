<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Hotelitems extends Sximo  {
	
	protected $table = 'abserve_hotel_items';
	protected $primaryKey = 'id';
	protected $appends = ['src'];

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_hotel_items.* FROM abserve_hotel_items  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_hotel_items.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	function getMainCatNameAttribute()
	{
		$category = Foodcategories::select('cat_name')->where('id',$this->attributes['main_cat'])->first();
		$name = !empty($category) ? $category->cat_name : '';
		return $name;
	}

	public function getSrcAttribute()
	{
		$path = base_path('uploads/res_items/'.$this->attributes['restaurant_id']);
		$image = $this->attributes['image'];
		if($image != '' && file_exists($path.'/'.$image)){
			return url('uploads/res_items/'.$this->attributes['restaurant_id'].'/'.$image);
		}
		return url('/uploads/restaurants/Default_food.jpg');
	}

	public function getRestaurant()
	{
		return $this->hasOne('App\Models\Restaurant','id','restaurant_id');
	}


}