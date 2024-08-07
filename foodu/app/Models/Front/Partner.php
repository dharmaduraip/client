<?php

namespace App\Models\Front;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Restaurant;
use App\Models\Location;
use App\Models\Accountdetails;

class Partner extends Authenticatable  implements JWTSubject
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
		'updated_at','created_at'
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
		->where('group_id', '3');
	}

	public function scopeCommonselect($query)
	{
		return $query->addSelect('id','group_id','username','email','address','business_name','business_addr','phone_number','mobile_token','latitude','longitude','mode','location');
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


}
