<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class MasterFoodUnitData extends Sximo  {
	
	// protected $connection = 'masterDetails';
	protected $table		= 'grozo_master_units';
	protected $primaryKey	= 'id';

	public function __construct() {
		parent::__construct();
		
	}


}
