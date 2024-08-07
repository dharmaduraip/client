<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;

class partnerwallet extends Sximo  {
	
	protected $table = 'abserve_partner_wallet';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_partner_wallet.* FROM abserve_partner_wallet  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_partner_wallet.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
	function orderdetails(){
		return $this->belongsTo('App\Models\OrderDetail','order_id','id');
	}


}
