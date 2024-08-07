<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class customerorder extends Abserve  {
	
	protected $table = 'abserve_orders_customer';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_orders_customer.* FROM abserve_orders_customer  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_orders_customer.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
