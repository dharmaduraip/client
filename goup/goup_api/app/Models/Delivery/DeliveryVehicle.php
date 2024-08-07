<?php

namespace App\Models\Delivery;
use App\Models\BaseModel;
use Auth;
use App\Models\Common\Admin;
use App\Models\Common\User;
use App\Models\Common\Provider;
class DeliveryVehicle extends BaseModel
{
    protected $connection = 'delivery';

    protected $hidden = [
     	'company_id','created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
     ];

     public function scopeSearch($query, $searchText='') {
        return $query
            ->where('vehicle_name', 'like', "%" . $searchText . "%")
            ->orWhere('vehicle_type', 'like', "%" . $searchText . "%")
            ->orWhere('delivery_type_id', 'like', "%" . $searchText . "%");
    }

    public function delivery_type()
    {
        return $this->belongsTo('App\Models\Delivery\DeliveryType', 'delivery_type_id', 'id');
    }

    public function priceDetails()
    {
        return $this->belongsTo('App\Models\Delivery\DeliveryCityPrice', 'id', 'delivery_vehicle_id')->select('delivery_vehicle_id','calculator','fixed','price','weight','distance');
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
