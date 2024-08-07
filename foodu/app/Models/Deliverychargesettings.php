<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class deliverychargesettings extends Sximo  {
	
	protected $table = 'abserve_charge_settings';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_charge_settings.* FROM abserve_charge_settings  ";
	}	

	public static function queryWhere(  ){
		
		if(\Auth::user()->group_id == 2 || \Auth::user()->group_id == 5){
			return " WHERE abserve_charge_settings.id IS NOT NULL AND abserve_charge_settings.location=".\Auth::user()->location."";
		}
		return "  WHERE abserve_charge_settings.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
