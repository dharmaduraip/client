<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class FooditemsVariation extends Abserve  {
	
	protected $table = 'tb_food_variation';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}
}