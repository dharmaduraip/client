<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class variationunit extends Sximo  {
	
	protected $table = 'tb_variation_unit';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_variation_unit.* FROM tb_variation_unit  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_variation_unit.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
