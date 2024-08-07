<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class RestaurantTiming extends Sximo  {
	
	protected $table = 'abserve_restaurant_timings';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_restaurant_timings.* FROM abserve_restaurant_timings  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_restaurant_timings.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}