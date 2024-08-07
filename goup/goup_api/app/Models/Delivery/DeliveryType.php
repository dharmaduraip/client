<?php

namespace App\Models\Delivery;

use App\Models\BaseModel;
use Auth;
use App\Models\Common\Admin;
use App\Models\Common\User;
use App\Models\Common\Provider;

class DeliveryType extends BaseModel
{
    protected $connection = 'delivery';

    protected $fillable = [
        'company_id','delivery_name','status','delivery_category_id'
    ];

    protected $hidden = [
     	'company_id', 'created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function servicelist() {
        return $this->hasMany('\App\Models\Delivery\DeliveryVehicle','delivery_type_id','id')->where('status',1);
    }

    public function providerservicelist() {
        return $this->hasOne('App\Models\Common\ProviderService','category_id','id');
    }

    public function providerservice() {
        return $this->hasOne('App\Models\Common\ProviderService','category_id','id')->where('admin_service','DELIVERY')->where('provider_id',Auth::guard('provider')->user()->id)->with('providervehicle');
    }

     public function getDeliveryNameAttribute()
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
        $column = "delivery_name_".$language;
          return "{$this->$column}";
    }

}
