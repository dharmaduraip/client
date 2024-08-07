<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class addons extends Sximo  {
	
	protected $table = 'abserve_addons';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_addons.* FROM abserve_addons  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_addons.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
