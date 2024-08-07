<?php namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sximo;

class Time extends Sximo  {
	
	protected $table = 'abserve_time';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}
}