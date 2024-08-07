<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Offers extends Sximo  {
	
	protected $table		= 'abserve_offers';
	protected $primaryKey	= 'id';

	public function __construct() {
		parent::__construct();
	}
}
