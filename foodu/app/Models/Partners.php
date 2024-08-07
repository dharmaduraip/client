<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class partners extends Sximo  {
	
	protected $table = 'tb_users';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " SELECT tb_users.* FROM tb_users ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE tb_users.id IS NOT NULL  AND tb_users.p_active != 0";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
