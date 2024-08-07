<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Restaurant;
use App\Models\Location;
use App\Models\Accountdetails;
use App\Models\Deliveryboyneworder;


class User extends Authenticatable  implements JWTSubject
{
    use Notifiable;

    
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
        'updated_at','created_at', 
        'log_status','mobile_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //protected $appends = ['location_name'];

    public function scopeCommonselect($query)
    {
        return $query->addSelect('id','group_id','username','email','phone_number','avatar');
    }

    public function getAvatarAttribute()
    {
        // $path   = 'storage/app/public/avatar/'.$this->attributes['avatar'];
        $path   = 'uploads/users/'.$this->attributes['avatar'];
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

    // function getBankAccountDetailAttribute()
    // {
    //     return \DB::table('tb_partner_accounts')->where('partner_id',$this->id)->first();
    // }

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
    
    function getBankAccountDetailAttribute()
    {
        return \DB::table('tb_partner_accounts')->where('partner_id',$this->id)->first();
    }

    public function getBikercImageAttribute()
    {
        $image = $this->attributes['rc_image'];
        $file = 'uploads/deliveryboy/'.$image;
        if($image != '' && file_exists(base_path($file))){
            return \URL::to($file);
        }
        return \URL::to('uploads/images/avatar_dummy.png');
    }

    public function getBikensuranceImageAttribute()
    {
        $image = $this->attributes['insurance_image'];
        $file = 'uploads/deliveryboy/'.$image;
        if($image != '' && file_exists(base_path($file))){
            return \URL::to($file);
        }
        return \URL::to('uploads/images/avatar_dummy.png');
    }

    public function getBikelicenseImageAttribute()
    {
        $image = $this->attributes['license_image'];
        $file = 'uploads/deliveryboy/'.$image;
        if($image != '' && file_exists(base_path($file))){
            return \URL::to($file);
        }
        return \URL::to('uploads/images/avatar_dummy.png');
    }


}
