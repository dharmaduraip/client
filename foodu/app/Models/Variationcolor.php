<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class variationcolor extends Sximo  {
	
	protected $table = 'tb_variation_color';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_variation_color.* FROM tb_variation_color  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_variation_color.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
