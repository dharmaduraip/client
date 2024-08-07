<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Useraddress extends Abserve  {
	
	protected $table = 'abserve_user_address';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public function scopeNearby($query,$latitude=0.00,$longitude=0.00,$distance=0)
	{
		if ($distance == 0 || $distance > \AbserveHelpers::getMaxRadius())
			$distance	= \AbserveHelpers::getMaxRadius();
		$lat_lng		= " ( round(
			( 6371 * acos( least(1.0,
				cos( radians(".$latitude.") )
				* cos( radians(lat) )
				* cos( radians(lang) - radians(".$longitude.") )
				+ sin( radians(".$latitude.") )
				* sin( radians(lat)
				) ) )
			), 2) ) ";
		$query->whereRaw($lat_lng . '<= '.$distance);
		return $query;
	}

	function getAddressTypeTextAttribute()
	{
		$address_type = $this->attributes['address_type'];
		if(!empty($this->attributes['other_label']))
			{$other = $this->attributes['other_label'];}else{$other = "Others";}
		return $address_type == '1' ? 'Home' : ($address_type == '2' ? 'Work' : $other);
	}

	function getAddressTypeIconAttribute()
	{
		$address_type = $this->attributes['address_type'];
		return $address_type == '1' ? 'fa fa-home' : ($address_type == '2' ? 'fa fa-briefcase' : 'fa fa-location-arrow');
	}
}
