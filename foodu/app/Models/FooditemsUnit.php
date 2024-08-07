<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class FooditemsUnit extends Abserve  {
	
	protected $table = 'tb_food_unit';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}
}