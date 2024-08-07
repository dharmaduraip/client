<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\fooditems;

class OrderItems extends Sximo  {
	
	protected $table = 'abserve_order_items';
	protected $primaryKey = 'id';
	protected $appends = ['mrp','mrpselling','vendorprice','availability'];
	public function __construct() {
		parent::__construct();
		
	}

	function getSellingPriceTotalAttribute()
	{
		return (/*$this->price*/  $this->selling_price * $this->quantity);
		//return number_format(($this->price * $this->quantity),2,',','');
	}
	function getVendorpriceAttribute()
	{
		return number_format(($this->attributes['vendor_price'] + $this->attributes['vendor_gstamount']),2,'.',''); 
	}

	function getOriginalPriceTotalAttribute()
	{
		return number_format(($this->vendor_price * $this->quantity),2);
		//return number_format(($this->vendor_price * $this->quantity),2,',','');
	}

	function getMrpsellingAttribute()
	{
		return number_format(($this->selling_price),2,'.','');
	}

	function getMrpAttribute()
	{
		return number_format((($this->selling_price) * $this->quantity),2,'.','');
	}

	/*public function newQuery($excludeDeleted = true) {
		return parent::newQuery($excludeDeleted)
		->append('veg_nonveg');
	}*/
	function getVegNonvegAttribute()
	{
		return fooditems::select('status')->where('id',$this->food_id)->pluck('status');
	}

	function order()
	{
		return $this->belongsTo(OrderDetail::class,'orderid','id');
	}

	function getAvailabilityAttribute()
	{
		$hotelitems  = Fooditems::where('restaurant_id',$this->order->res_id)->where('food_item','like','%'.$this->food_item.'%')->where('item_status',1)->first();
		if (empty($hotelitems)) {
			return false;
		}
		return true;
	}
}
