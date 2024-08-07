<?php namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Sximo;

class Deliveryboy extends Sximo  {
	
	protected $table = 'tb_users';
	protected $primaryKey = 'id';


	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims()
	{
		return [];
	}

	public function __construct() {
		parent::__construct();
	}

	public static function querySelect(  ){
		
		return " SELECT tb_users.* FROM tb_users ";
	}	

	public static function queryWhere(  ){
		
		return " WHERE tb_users.id IS NOT NULL AND tb_users.d_active != 0 ";
	}
	
	public static function queryGroup(){
		return "  ";
	}

	function getSrcAttribute()
	{
		$socialImage = $this->socialmediaImg;
		if(!is_null($socialImage) && $socialImage != ''){
			return $socialImage;
		} else {
			$image = $this->attributes['avatar'];
			$file = 'uploads/deliveryboys/'.$image;
			if($image != '' && file_exists(base_path($file))){
				return \URL::to($file);
			}
			return \URL::to('uploads/images/avatar_dummy.png');
		}
	}

	function getUserTypeAttribute()
	{
		return 'Delivery boy';
	}

	public function scopeNearby($query,$latitude=0.00,$longitude=0.00,$distance=0)
	{
		if ($distance == 0 || $distance > \AbserveHelpers::getMaxRadius())
			$distance	= \AbserveHelpers::getMaxRadius();
		$lat_lng		= " ( round(
			( 6371 * acos( least(1.0,
			cos( radians(".$latitude.") )
			* cos( radians(latitude) )
			* cos( radians(longitude) - radians(".$longitude.") )
			+ sin( radians(".$latitude.") )
			* sin( radians(latitude)
			) ) )
		), 2) ) ";
		$query->whereRaw($lat_lng . '<= '.$distance);
		return $query;
	}
}
