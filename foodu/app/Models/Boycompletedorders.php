<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class boycompletedorders extends Sximo  {
	
	protected $table = 'abserve_order_details';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_order_details.* FROM abserve_order_details  ";
	}	

	public static function queryWhere(  ){
		if(\Auth::user()->group_id == '1' || \Auth::user()->group_id == '2'){
		   return "  WHERE abserve_order_details.id IS NOT NULL AND (abserve_order_details.status = '4' OR abserve_order_details.status = '5')";
		}
		
		return "  WHERE abserve_order_details.id IS NOT NULL AND (abserve_order_details.status = '4' OR abserve_order_details.status = '5')  AND abserve_order_details.boy_id = ".\Auth::user()->id." ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
