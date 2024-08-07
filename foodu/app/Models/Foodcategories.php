<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Foodcategories extends Sximo  {
	
	protected $table = 'abserve_food_categories';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_food_categories.* FROM abserve_food_categories  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_food_categories.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
	public function menuitems()
    {
        return $this->hasMany('App\Models\Front\Fooditems', 'main_cat', 'id');
    }

    function getSrcAttribute()
	{
		$logo	= $this->attributes['image_url'];
		$return	= \URL::to('uploads/categories/Default_food.jpg');
		if($logo != '' && file_exists(base_path('/uploads/categories/'.$logo)))
			$return	= \URL::to('/uploads/categories').'/'.$logo;
		return $return;
	} 

}
