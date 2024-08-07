<?php

namespace App\Models\Transport;

use App\Models\BaseModel;

use Auth;
use App\Models\Common\Admin;
use App\Models\Common\User;
use App\Models\Common\Provider;


class RideDeliveryVehicle extends BaseModel
{
    protected $connection = 'transport';

    protected $hidden = [
     	'company_id','created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function scopeSearch($query, $searchText='') {
        return $query
            ->where('vehicle_name', 'like', "%" . $searchText . "%")
            ->orWhere('vehicle_type', 'like', "%" . $searchText . "%")
            ->orWhere('ride_type_id', 'like', "%" . $searchText . "%");
    }

    public function ride_type()
    {
        return $this->belongsTo('App\Models\Transport\RideType');
    }

    public function ride()
    {
        return $this->has('App\Models\Common\ProviderService');
    }
    
    public function vehicle_type()
    {
        return $this->has('App\Models\Common\ProviderVehicle', 'vehicle_service_id');
    }



    public function priceDetails()
    {
        return $this->belongsTo('App\Models\Transport\RideCityPrice', 'id', 'ride_delivery_vehicle_id')->select('ride_delivery_vehicle_id','calculator','fixed','price','minute','hour','distance');
    }

    public function getVehicleNameAttribute()
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
        $column = "vehicle_name_".$language;
          return "{$this->$column}";
    }
}
