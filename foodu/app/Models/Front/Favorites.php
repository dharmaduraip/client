<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Abserve;

class Favorites extends Abserve {
	
	protected $table = 'abserve_favourites';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

}