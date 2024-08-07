<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class refundinfo extends Sximo  {
	
	protected $table = 'abserve_order_details';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " SELECT abserve_order_details.* FROM abserve_order_details ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE abserve_order_details.id IS NOT NULL AND abserve_order_details.order_type != 'Initial' ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public function getNormalOrder()
	{
		return $this->hasOne(OrderDetail::class, 'id', 'id');
	}

	public function getCustomerInfo()
	{
		return $this->hasOne(User::class, 'id', 'cust_id');
	}

	function getBoyInfo(){
		return $this->hasOne('App\Models\Deliveryboy','id','boy_id');
	}
	
	function getOrderTiming(){
		return $this->hasMany('App\Models\Orderstatustime','order_id','id');
	}
	

}
