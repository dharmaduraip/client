<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Restaurantrating extends Sximo  {
	
	protected $table		= 'abserve_rating';
	protected $primaryKey	= 'id';
	public $timestamps		= false;
}
?>