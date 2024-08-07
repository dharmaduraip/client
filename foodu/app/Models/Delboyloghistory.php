<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class delboyloghistory extends Sximo  {
	
	protected $table = 'deliveryboy_loghistory';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT deliveryboy_loghistory.* FROM deliveryboy_loghistory  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE deliveryboy_loghistory.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
