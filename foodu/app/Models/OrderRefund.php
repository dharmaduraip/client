<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class OrderRefund extends Abserve  {
	
	protected $table = 'abserve_refund';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}
}
