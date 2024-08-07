<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class sliderimages extends Sximo  {
	
	protected $table = 'abserve_slider_images';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_slider_images.* FROM abserve_slider_images  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_slider_images.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	
	function getSrcAttribute()
	{
		$fileName = $this->attributes['image'];
		$path = 'uploads/slider/';
		if($fileName != '' && file_exists(base_path($path.$fileName))){
			return url($path.$fileName);
		}
		return url('/uploads/restaurants/Default_food.jpg');
	}

	function getExtUrlAttribute()
	{
		$url = $this->attributes['ext_url'];
		$url =  !empty($url) ? $url: '';
		return $url;
	}

}
