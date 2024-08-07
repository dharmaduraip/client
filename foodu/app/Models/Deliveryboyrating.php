<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class deliveryboyrating extends Sximo  {
	
	protected $table = 'abserve_rating_boy';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_rating_boy.* FROM abserve_rating_boy  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_rating_boy.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
