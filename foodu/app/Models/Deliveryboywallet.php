<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderDetail;
use App\Models\Restaurant;

class DeliveryBoyWallet extends Sximo  {
	
	protected $table = 'abserve_del_boy_wallet';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_del_boy_wallet.* FROM abserve_del_boy_wallet  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_del_boy_wallet.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
	function restaurant(){
		return $this->belongsTo('App\Models\Front\Restaurant','res_id','id');
	}

	function orderdetails(){
		return $this->belongsTo('App\Models\OrderDetail','order_id','id');
	}

}
