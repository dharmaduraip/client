<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class RiderLocationLog extends sximo  {
	
	protected $table = 'abserve_rider_location_log';
	protected $primaryKey = 'id';
	protected $fillable = [
							"boy_id",
							"order_id",
							"order_log",
							"latitude",
							"longitude",
							"order_status",
							"travelled",
							"distance",
						 ];
}
