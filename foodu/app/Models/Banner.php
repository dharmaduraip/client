<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class banner extends Sximo  {
	
	protected $table = 'abserve_banner';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_banner.* FROM abserve_banner  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_banner.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
