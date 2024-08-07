<?php

namespace App\Models\Front;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Restaurant;
use App\Models\Location;
use App\Models\Accountdetails;
use App\Models\Deliveryboyneworder;


class Deliveryboy extends Authenticatable  implements JWTSubject
{
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

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $table = 'tb_users';
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
		'updated_at', 'remember_token',
		'created_at', 'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	protected $appends = ['location_name'];

	public function newQuery($excludeDeleted = true) {
		return parent::newQuery($excludeDeleted)
		->where('d_active','!=','0' );
	}

	public function scopeCommonselect($query)
	{
		return $query->addSelect('id','group_id','username','email','boy_status','phone_number','mobile_token','latitude','longitude','mode','location','bike','license');
	}

	public function scopeNearby($query,$latitude=0.00,$longitude=0.00,$distance=0)
	{
		if ($distance == 0 || $distance > \AbserveHelpers::getMaxRadius())
			$distance   = \AbserveHelpers::getMaxRadius();
		$lat_lng        = " ( round(
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

	// public function scopeNewordercount($query)
	// {
	//     $count= $query->deliveryboyneworder()->where(\DB::raw("SUBSTRING(update_at,1,10) = '".date('Y-m-d')."'"));
	//     return $count;
	// }

	public function scopeOrdercount($query)
	{
	   return $query->has('newordercount', '>' ,'0');
	   
	}

	public function scopeLatlang($query,$latitude=0.00,$longitude=0.00,$distance=0)
	{
		if ($distance == 0 || $distance > \AbserveHelpers::getMaxRadius())
			$distance   = \AbserveHelpers::getMaxRadius();
		$lat_lng        = " ( round(
			( 6371 * acos( least(1.0,
			cos( radians(".$latitude.") )
			* cos( radians(latitude) )
			* cos( radians(longitude) - radians(".$longitude.") )
			+ sin( radians(".$latitude.") )
			* sin( radians(latitude)
			) ) )
		), 2) ) ";
		// $query->whereRaw($lat_lng . '<= '.$distance);
		return $lat_lng;
	}

	public function getAvatarAttribute()
	{
		$path   = 'storage/app/public/avatar/'.$this->attributes['avatar'];
		if ($this->attributes['avatar'] != '' && \File::exists(base_path($path))) {
			$url    = \URL::to($path);
		} else {
			$url    = \AbserveHelpers::getCommonImageUser();
		}
		return $url;
	}

	public function getLocationNameAttribute()
	{
		return $this->location()->pluck('name')->first() ?? '';
	}

	function getSrcAttribute()
	{
		$socialImage = $this->socialmediaImg;
		if(!is_null($socialImage) && $socialImage != ''){
			return $socialImage;
		} else {
			$image = $this->attributes['avatar'];
			$file = 'uploads/users/'.$image;
			if($image != '' && file_exists(base_path($file))){
				return \URL::to($file);
			}
			return \URL::to('uploads/images/avatar_dummy.png');
		}
	}

	public  function shops()
	{
		return $this->hasMany(Restaurant::class, 'partner_id', 'id');
	}

	public  function location()
	{
		return $this->hasOne(Location::class, 'id', 'location');
	}

	public  function accountdetails()
	{
		return $this->hasOne(Accountdetails::class, 'partner_id', 'id');
	}

	public function deliveryboyneworder()
	{
		return $this->hasMany(Deliveryboyneworder::class, 'boy_id', 'id');
	}

	public function newordercount()
	{
		return $this->deliveryboyneworder()->whereRaw("SUBSTRING(update_at,1,10) = '".date('Y-m-d')."'")->where('status','Accepted');
	}

}
