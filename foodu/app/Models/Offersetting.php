<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class offersetting extends Sximo  {
	
	protected $table = 'abserve_offers';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_offers.* FROM abserve_offers  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_offers.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
