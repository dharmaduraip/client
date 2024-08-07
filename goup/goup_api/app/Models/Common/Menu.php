<?php

namespace App\Models\Common;

use App\Models\BaseModel;
use Auth;

class Menu extends BaseModel
{
	protected $connection = 'common';
  // protected $connection = 'transport';

    protected $fillable = [
        'bg_color','icon','title', 'admin_service', 'menu_type_id', 'company_id', 'sort_order'
    ];
	
    protected $hidden = [
     	'company_id', 'created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function service()
    {
       return $this->belongsTo('App\Models\Common\AdminService', 'admin_service', 'admin_service');
    } 

    public function cities()
    {
       return $this->hasMany('App\Models\Common\MenuCity');
    }
    public function adminservice()
    {
       return $this->belongsTo('App\Models\Common\AdminService', 'admin_service', 'admin_service');
    }
    public function ridetype()
    {
       return $this->hasone('App\Models\Transport\RideType', 'menu_type_id','id');
    }

     public function menu_ride()
    {
        return $this->hasone('App\Models\Transport\RideCityPrice', 'id', 'ride_delivery_vehicle_id');
    }

      public function menu_service()
    {
        return $this->hasone('App\Models\Transport\RideCityPrice', 'id', 'ride_delivery_vehicle_id');
    }

    public function scopeSearch($query, $searchText='') {
        return $query
                        ->whereHas('adminservice', function ($q) use ($searchText){
                            $q->where('admin_service', 'like', "%" . $searchText . "%");
                        })
                        ->orWhere('title', 'like', "%" . $searchText . "%");
                        // ->orwhereHas('ridetype', function ($q) use ($searchText){
                        //     $q->where('ride_name', 'like', "%" . $searchText . "%");
                        // })
                        // ->orWhere('bg_color', 'like', "%" . $searchText . "%");
    }

     public function getTitleAttribute()
    {
        \Log::info('check');
        $provider = [];
        if(Auth::guard('admin')->check()){
           $provider = Admin::where('id',\Auth::guard('admin')->user()->id)->first();
        }elseif(Auth::guard('user')->check()){
           $provider = User::where('id',\Auth::guard('user')->user()->id)->first();
        }elseif(Auth::guard('provider')->check()){
           $provider = Provider::where('id',\Auth::guard('provider')->user()->id)->first();
        }

         
         \Log::info($provider);
         if($provider){
             if($provider->language != null){
                 $language = $provider->language;
                // app('translator')->setLocale($language);
             }else{
                $language='en';
             }
        }else{
            $language='en';
         }
         \Log::info($language);
      //   $locale = App::getLocale();
        $column = "title_".$language;
          return "{$this->$column}";
    }
}
