<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class MasterFoodVariationsData extends Sximo  {
	
	// protected $connection = 'masterDetails';
	protected $table		= 'grozo_master_variants';
	protected $primaryKey	= 'id';

	public function __construct() {
		parent::__construct();
		
	}


}
