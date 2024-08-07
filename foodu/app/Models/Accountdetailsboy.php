<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class accountdetailsboy extends Abserve  {
	
	protected $table = 'tb_delboy_accounts';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_delboy_accounts.* FROM tb_delboy_accounts  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_delboy_accounts.delboy_id = '".\Auth::user()->id."' AND tb_delboy_accounts.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
