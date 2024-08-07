<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Location extends Sximo  {
	
	protected $table = 'location';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT location.* FROM location  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE location.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
