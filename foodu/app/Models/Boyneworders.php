<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class boyneworders extends Sximo  {
	
	protected $table = 'delivery_boy_new_orders';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " SELECT delivery_boy_new_orders.* FROM delivery_boy_new_orders ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE delivery_boy_new_orders.id IS NOT NULL AND  delivery_boy_new_orders.status = 'Pending' ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
