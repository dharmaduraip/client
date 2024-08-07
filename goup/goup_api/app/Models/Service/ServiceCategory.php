<?php

namespace App\Models\Service;

use App\Models\BaseModel;
use Auth;
use App\Models\Common\Admin;
use App\Models\Common\User;
use App\Models\Common\Provider;

class ServiceCategory extends BaseModel
{
    protected $connection = 'service';

    public function scopeSearch($query, $searchText='') {
        $word = 'active';
        $word2 = 'inactive';
        if (strpos($word, $searchText) !== FALSE) {
            $result =  $query
            ->where('service_category_name', 'like', "%" . $searchText . "%")
            ->orWhere('service_category_order', 'like', "%" . $searchText . "%")
            ->orWhere('service_category_status', 1);
        }if (strpos($word2, $searchText) !== FALSE) {            
            $result =  $query
            ->where('service_category_name', 'like', "%" . $searchText . "%")
            ->orWhere('service_category_order', 'like', "%" . $searchText . "%")
            ->orWhere('service_category_status', 2);
        }else{
            $result =  $query
            ->where('service_category_name', 'like', "%" . $searchText . "%")
            ->orWhere('service_category_order', 'like', "%" . $searchText . "%")
            ->orWhere('service_category_status', 'like', "%" . $searchText . "%");
        }
        return $result;
    }

    public function providerservicecategory() {
        return $this->hasMany('App\Models\Common\ProviderService','category_id','id')->where('admin_service','Service')->where('provider_id',Auth::guard('provider')->user()->id);
    }

    
    protected $hidden = [
     	'company_id','created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
     ];
    
    public function subcategories()
    {
        return $this->hasMany('App\Models\Service\ServiceSubcategory', 'service_category_id', 'id');
    }

    public function services()
    {
        return $this->hasMany('App\Models\Service\Service');
    }

     public function getServiceCategoryNameAttribute()
    {
        return $this->attributes['service_category_name'];
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
        $column = "service_category_name_".$language;
          return "{$this->$column}";
    }
}
