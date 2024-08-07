<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class wallet extends Sximo  {
	
	protected $table = 'wallet';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " SELECT wallet.* FROM wallet ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE wallet.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
