<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Partnerrequest extends Sximo  {
	
	protected $table = 'abserve_partner_requests';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_partner_requests.* FROM abserve_partner_requests  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_partner_requests.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
