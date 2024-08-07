<?php

namespace App\Models\Order;

use App\Models\BaseModel;
use Auth;
use App\Models\Common\Admin;
use App\Models\Common\User;
use App\Models\Common\Provider;
use App\Models\Order\Store;
class StoreType extends BaseModel
{
    protected $connection = 'order';

    protected $hidden = [
     	'company_id','created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
     ];

      public function storetype() {
    	return $this->hasMany('App\Models\Order\Cuisine');
    }
     public function providerservice() {
    return $this->hasOne('App\Models\Common\ProviderService','category_id','id')->where('admin_service','ORDER')->where('provider_id',Auth::guard('provider')->user()->id)->with('providervehicle');
    }

    public function provideradminservice() {
        return $this->hasOne('App\Models\Common\ProviderService','category_id','id')->where('admin_service','ORDER');
    }

      public function scopeSearch($query, $searchText='') {
        return $query
            ->where('name', 'like', "%" . $searchText . "%");
            
    }

      public function getNameAttribute()
    {
        \Log::info('check');
        $provider = null;
        if(Auth::guard('admin')->check()){
           $provider = Admin::where('id',\Auth::guard('admin')->user()->id)->first();
        }elseif(Auth::guard('user')->check()){
           $provider = User::where('id',\Auth::guard('user')->user()->id)->first();
        }elseif(Auth::guard('provider')->check()){
           $provider = Provider::where('id',\Auth::guard('provider')->user()->id)->first();
        }elseif(Auth::guard('shop')->check()){
           $provider = Store::where('id',\Auth::guard('shop')->user()->id)->first();
        }
         
         \Log::info($provider);
         if($provider && $provider->language){
             $language = $provider->language;
            // app('translator')->setLocale($language);
         }else{
            $language='en';
         }
      //   $locale = App::getLocale();
        $column = "name_".$language;
          return "{$this->$column}";
    }
}
