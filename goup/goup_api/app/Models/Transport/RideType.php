<?php

namespace App\Models\Transport;

use App\Models\BaseModel;
use Auth;
use App\Models\Common\Admin;
use App\Models\Common\User;
use App\Models\Common\Provider;

class RideType extends BaseModel
{
    protected $connection = 'transport';

    protected $fillable = [
        'company_id','ride_name','status'
    ];

    protected $hidden = [
     	'company_id', 'created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function ride() {
    	return $this->hasMany('App\Models\Transport\RideDeliveryVehicle');
    }

    public function servicelist() {
    return $this->hasMany('\App\Models\Transport\RideDeliveryVehicle','ride_type_id','id')->where('status',1);
    }

    public function providerservice() {
        return $this->hasOne('App\Models\Common\ProviderService','category_id','id')->where('admin_service','TRANSPORT')->where('provider_id',Auth::guard('provider')->user()->id)->with('providervehicle');
    }

    public function provideradminservice() {
        return $this->hasOne('App\Models\Common\ProviderService','category_id','id')->where('admin_service','TRANSPORT');
    }

    public function scopeSearch($query, $searchText='') {
        return $query
            ->where('ride_name', 'like', "%" . $searchText . "%");
          
    }

    public function getRideNameAttribute()
    {
        \Log::info('check');
        $provider = null;
        if(Auth::guard('admin')->check()){
           $provider = Admin::where('id',\Auth::guard('admin')->user()->id)->first();
        }elseif(Auth::guard('user')->check()){
           $provider = User::where('id',\Auth::guard('user')->user()->id)->first();
        }elseif(Auth::guard('provider')->check()){
           $provider = Provider::where('id',\Auth::guard('provider')->user()->id)->first();
        }
         
         \Log::info($provider);
         if($provider && $provider->language){
             $language = $provider->language;
            // app('translator')->setLocale($language);
         }else{
            $language='en';
         }
      //   $locale = App::getLocale();
        $column = "ride_name_".$language;
          return "{$this->$column}";
    }

}
