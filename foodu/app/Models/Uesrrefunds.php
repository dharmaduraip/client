<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class uesrrefunds extends Sximo  {
	
	protected $table = 'user_refunds';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT user_refunds.* FROM user_refunds  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE user_refunds.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
