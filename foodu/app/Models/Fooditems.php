<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use App\Models\Front\Usercart;
use Illuminate\Database\Eloquent\Model;
use App\Models\Variations;

class fooditems extends Sximo  {
	
	protected $table = 'abserve_hotel_items';
	protected $primaryKey = 'id';

	protected $appends = [
		 'unit_detail'
	];

	protected $hidden = [
		'unit',
	];

	public function __construct() {
		parent::__construct();
		
	}
	
	public static function querySelect(  ){
		
		return "  SELECT abserve_hotel_items.* FROM abserve_hotel_items  ";
	}	
    function restaurant()
	{
		return $this->belongsTo('App\Models\Front\Restaurant','restaurant_id','id');
	}
	public static function queryWhere(  ){
		$whr = '';
		if(\Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) {
			$whr = "AND abserve_hotel_items.entry_by = ".\Auth::id();
		}
		return "  WHERE abserve_hotel_items.id IS NOT NULL ".$whr;
	}

	public function getResdetail($res_id){
		return \DB::select("  SELECT abserve_restaurants.`logo`,`name`,`budget` FROM abserve_restaurants WHERE `id` = ".$res_id);
	}
	
	public static function queryGroup(){
		return "  ";
	}

	public function scopeCommonselect($query)
	{
		$query->addSelect('id','restaurant_id','food_item','description','price','selling_price','original_price','status','hiking','main_cat','sub_cat','start_time1','end_time1','start_time2','end_time2','item_status','adon_type','image','approveStatus','strike_price','gst','unit');
	}

	public function scopeNotdeleted($query)
	{
		$query->where('del_status','0');
	}

	public function scopeApproved($query)
	{
		$query->where('approveStatus','Approved');
	}

	function getCartInfoAttribute($device_id='',$user_id=0,$cartid='')
	{
		$field = $user_id > 0 ? 'user_id' : 'cookie_id';
		$fieldVal = $user_id > 0 ? $user_id : $device_id;
		$cart = Usercart::where('food_id',$this->attributes['id'])->where($field,$fieldVal)->select('quantity','item_note','food_item','adon_type','adon_details','adon_id','strike_price');
		if (!empty($cartid)) {
			$cart = $cart->where('id',$cartid);
		}
		$cart = $cart->first();
		if(empty($cart)){
			$cart1['quantity'] = 0;
			$cart1['item_note'] = '';
			$cart_Detail = json_decode(json_encode($cart1));
		} else {
			if($cart->adon_id == 0) {
				$cart->adon_id = '';
			}
			$cart_Detail = $cart;
		}
		return $cart_Detail;
	}

	function getFoodItemDetailAttribute($restaurant_id)
	{
		$select = ['id','restaurant_id','food_item','description','specification','main_cat','status','item_status','recommended','adon_type','start_time1','end_time1','start_time2','end_time2','image','price','selling_price','original_price','gst','strike_price'];
		$query = Fooditems::where('restaurant_id',$restaurant_id)->where('del_status','0');
		$res = $query->where('main_cat',$this->main_cat)->select($select)->get();
		return $res->map(function ($result) {
		       	$result->append('exact_src');
		       	return $result;
		    });;
	}

	function getMainCatNameAttribute()
	{
		$category = Foodcategories::select('cat_name')->where('id',$this->attributes['main_cat'])->first();
		$name = !empty($category) ? $category->cat_name : '';
		return $name;
	}

	function getExactSrcAttribute()
	{
		$exp		= explode(',', $this->attributes['image']);
		foreach ($exp as $key => $value) {
			$path = 'storage/app/public/restaurant/'.$this->attributes['restaurant_id'].'/'.$value;
			if($value != '' && file_exists(base_path($path))){
				$path = 'storage/app/public/restaurant/'.$this->attributes['restaurant_id'].'/'.rawurlencode($value);
				return \URL::to($path);
				break;
			}
		}
		return \URL::to('uploads/images/no-image.jpg');
	}

	function unit(){
		return $this->hasMany(FooditemsUnit::class,'food_id','id');
	}

	function variation(){
		return $this->hasMany(FooditemsVariation::class,'food_id','id');
	}
	public function setUnitAttribute($value)
	{
		
		$Aunit	= [];
		if(!empty($value)){
			$unit	= $value['unit'];
			$price	= $value['price_unit'];
			if ( !empty($unit) &&  count($unit) > 0) {
				foreach ($unit as $key => $val) {
					if ($val != '' && $price[$key] > 0) {
						$Aunit[]	= ['unit'=> $val,'price'=> $price[$key]];
					}
				}
			}
		}
		return $this->attributes['unit']	= json_encode($Aunit);
	}

	public function getUnitDetailAttribute()
	{

		$unit		= json_decode($this->attributes['unit'],true);
		$Aunit		= [];
		if ($unit != '' && count($unit) > 0) {
			foreach ($unit as $key => $value) {
				$unit	= Variations::find($value['unit']);
				if (!empty($unit)) {
					$unit_name = $unit->cat_name;
					// $unit_name=$this->hasOne(Addon::class)->where('id', $value['unit'])->first();
					$Aunit[]   = ['id'=> $value['unit'], 'name' => $unit_name, 'price' => (float) $value['price']];
				}
			}
		}
		return $Aunit;
	}

	public function getUnitExportAttribute()
	{
		
		$variants_imp = '';
		$units = $this->getUnitDetailAttribute();
		if(!empty($units)){
			foreach($units as $key => $value){
				$variants[]   = $value['cat_name'].':'.$value['price'];
				$variants_imp = implode(',',$variants); 
			}
		}
		return $variants_imp;
	}

	function getAvailabilityAttribute()
	{
		$text = ''; $status = 1;
		$cur_time = date("H:i:s");
		$start 	= $this->attributes['start_time1'];
		$end 	= $this->attributes['end_time1'];
		$start2 = $this->attributes['start_time2'];
		$end2 	= $this->attributes['end_time2'];
		$shop_check = $this->restaurant->gst_applicable;
		if ($this->attributes['item_status'] == 0) {
			$text = 'Out of stock';
				$status = 0;
		} else if ($shop_check == 'no') {
			$text = '';
		} else if(($start == $end) || ($cur_time >= $start && $cur_time <= $end || $cur_time >= $start2 && $cur_time <= $end2 )) {
		} else {
			if($cur_time < $start && $cur_time < $end){
				$text = 'Next at, '.date("g:i a",strtotime($this->attributes['start_time1'])).' today';
				$status = 0;
			} else if($cur_time < $start2 && $cur_time < $end2){
				$text = 'Next at, '.date("g:i a",strtotime($this->attributes['start_time2'])).' today';
				$status = 0;
			} else if(($cur_time > $start && $cur_time > $end) && ($cur_time > $start2 && $cur_time > $end2)) {
				$text = 'Next at, '.date("g:i a",strtotime($this->attributes['start_time1'])).' tomorrow';
				$status = 0;
			}
		}
		$data['status'] = $status;
		$data['text']	= $text;
		return $data;
	}

	function getNextAvailableTimeTextAttribute()
	{
		$text = '';
		$cur_time = (int)date("Hi");
		$start 	= (int)($this->attributes['available_from'] != '') ? (date("Hi",strtotime($this->attributes['available_from']))) : '';
		$end 	= (int)($this->attributes['available_to'] != '') ? (date("Hi",strtotime($this->attributes['available_to']))) : '';
		$start2 	= (int)($this->attributes['available_from2'] != '') ? (date("Hi",strtotime($this->attributes['available_from2']))) : '';
		$end2 	= (int)($this->attributes['available_to2'] != '') ? (date("Hi",strtotime($this->attributes['available_to2']))) : '';
		if($this->attributes['item_status'] == 0){
			$text = 'Out of stock';
		}elseif($start != '' && $end != ''){
			if($start == $end){
				$text = 'Available';
			} else if($cur_time >= $start && $cur_time <= $end ){
				$text = 'Available';
			} else if($cur_time >= $start2 && $cur_time <= $end2 ){
				$text = 'Available';
			} else {
				if($cur_time < $start && $cur_time < $end){
					$text = 'Opens at, '.date("g:i a",strtotime($this->attributes['available_from'])).' today';
				} else if($cur_time < $start2 && $cur_time < $end2){
					$text = 'Opens at, '.date("g:i a",strtotime($this->attributes['available_from2'])).' today';
				} else if(($cur_time > $start && $cur_time > $end) && ($cur_time > $start2 && $cur_time > $end2)) {
					$text = 'Opens at, '.date("g:i a",strtotime($this->attributes['available_from'])).' tomorrow';
				}
			}
		}
		return $text;
	}

	function getShowPriceAttribute()
	{
		$price = $this->attributes['selling_price'] > 0 ? $this->attributes['selling_price'] : $this->attributes['price'];
		$price =  $this->attributes['price'];
		return (string) number_format($price,2,'.','');
	}
	
}
