<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Abserve  {
	
	protected $table = 'abserve_order_payment_detail';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}
}