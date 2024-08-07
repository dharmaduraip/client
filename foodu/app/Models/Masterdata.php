<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class masterdata extends Sximo  {
	
	protected $table		= 'grozo_master_products';
	protected $primaryKey	= 'id';
 	public $timestamps		= false;

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return " SELECT grozo_master_products.* FROM grozo_master_products ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE grozo_master_products.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	function getSrcAttribute()
	{
		$fileName = $this->attributes['image'];
		$aFilename = explode(',', $fileName);
		$aSrc = [];
		if($fileName != ''){
			foreach ($aFilename as $key => $value) {
				if($value != ''){
					$path = 'uploads/images/'.$value;
					if($fileName != '' && file_exists(base_path($path))){
						$aSrc[] = \URL::to($path);
					}
				}
			}
		}
		if(count($aSrc) == 0){
			$aSrc[] = \URL::to('uploads/images/no-image.jpg');
		}
		return $aSrc;
	}
	public function getCategoryNameAttribute() {
		return \DB::table('abserve_food_categories')->where('id',$this->category)->where('root_id','=',0)->first()->cat_name ?? '';
	}

	public function getBrandNameAttribute() {
		return \DB::table('abserve_food_categories')->where('id',$this->brand)->where('type','=','brand')->first()->cat_name ?? '';
	}	

}
