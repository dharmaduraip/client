<?php namespace App\Models\Front;

use App\Models\Sximo;
use Illuminate\Database\Eloquent\Model;

class Location extends Sximo  {
	protected $table = 'location';
	protected $primaryKey = 'id';
	public function __construct() {
		parent::__construct();
		
	}
}
