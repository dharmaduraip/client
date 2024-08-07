<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class foodunit extends Sximo  {
	
	protected $table = 'tb_unit';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT tb_unit.* FROM tb_unit  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_unit.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
