<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class orderstatustime extends Sximo  {
	
	protected $table = 'order_status_timing';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT order_status_timing.* FROM order_status_timing  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE order_status_timing.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}