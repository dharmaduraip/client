<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class promocode extends Sximo  {
	
	protected $table = 'abserve_promocode';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_promocode.* FROM abserve_promocode  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_promocode.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	function getPromoCodeTextAttribute()
	{
		$promo_type = $this->attributes['promo_type'];
		$currency_symbol = \AbserveHelpers::getBaseCurrencySymbol();
		$text='';
		if($promo_type == 'percentage'){
			$text = $this->attributes['promo_amount'].'%';
		} else {
		    $text .= ' Flat ';
			$text .= $currency_symbol.$this->attributes['promo_amount'];
		}
		$text .= ' /- off';
		// $text .= ' on all foods';
		if($this->attributes['min_order_value'] > 0){
			$text .= '. Min order '.$currency_symbol.$this->attributes['min_order_value'];
		}
		return $text;
	}
	function getAllTextAttribute($user_id=0)
	{
		$aText = [];
		$currency_symbol = \AbserveHelpers::getBaseCurrencySymbol();
		if($this->min_order_value > 0){
			$aText[] = 'Minimum order value is '.$currency_symbol.' '.$this->min_order_value;
		}
		$aText[] = 'Valid on all payment methods.';
		$aText[] = 'Offer Valid till '.date('M d,Y',strtotime($this->end_date));

		if($this->max_discount > 0){
			$aText[] = 'Maximum coupon amount is '.$currency_symbol.' '.$this->max_discount;
		}

		$orderCount = 0;
		if($user_id > 0){
			$orderCount = \DB::table('abserve_order_details')->select('id')->where('coupon_id',$this->id)->where('cust_id',$user_id)->where('status','!=','5')->count();
			if($orderCount > 0) {
				if($this->usage_count <= $orderCount){
					$aText[] = 'USAGE COUNT IS OVER';
				} else if($this->usage_count > 0 && $this->usage_count < $this->limit_values){
					$aText[] = 'Valid '.$this->usage_count.' time(s) per user';
					$aText[] = 'Already '.$orderCount.' Time(s) used';
				} else if($this->usage_count > 0){
					$aText[] = 'Already '.$orderCount.' Time(s) used';
				}
			} else if($this->usage_count > 0 && $this->usage_count < $this->limit_values){
				$aText[] = 'Valid '.$this->usage_count.' time(s) per user';
			}
		} else if($this->usage_count > 0 && $this->usage_count < $this->limit_values){
			$aText[] = 'Valid '.$this->usage_count.' time(s) per user';
		}
		return $aText;
	}

	function getResDetailAttribute()
	{
		$res = Restaurant::where('id', $this->res_id)->select('id', 'name', 'latitude', 'longitude')->first();
		return $res;
	}

}
