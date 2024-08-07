<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class MasterShopItems extends Sximo {

	// protected $connection	= 'masterDetails';
	protected $table		= 'grozo_master_shop_items';
	protected $primaryKey	= 'id';

	public function __construct() {
		parent::__construct();
	}

	public static function querySelect(  ){
		
		return "  SELECT grozo_master_shop_items.* FROM grozo_master_shop_items  ";
	}

	public static function queryWhere(  ){
		
		return "  WHERE grozo_master_shop_items.id IS NOT NULL";
	}

	public static function queryGroup(){
		return "  ";
	}
}
