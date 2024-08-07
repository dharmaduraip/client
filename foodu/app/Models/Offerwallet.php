<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class offerwallet extends Sximo  {
	
	protected $table = 'offer_users';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " SELECT offer_users.* FROM offer_users ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE offer_users.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
