<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Restaurantunavail extends Sximo  {
	
	protected $table = 'abserve_restaurant_unavailable_date';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}
}