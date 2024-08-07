<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class refundreasons extends Sximo  {
	
	protected $table = 'refund_reasons';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT refund_reasons.* FROM refund_reasons  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE refund_reasons.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
