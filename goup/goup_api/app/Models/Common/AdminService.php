<?php

namespace App\Models\Common;

use App\Models\BaseModel;
use Auth;

class AdminService extends BaseModel
{
    protected $connection = 'common';

    protected $hidden = [
        'company_id','created_type', 'created_by', 'modified_type', 'modified_by', 'deleted_type', 'deleted_by', 'created_at', 'updated_at', 'deleted_at'
    ];

    public function providerservices() {
        return $this->hasone('App\Models\Common\ProviderService','admin_service','admin_service')->where('provider_id',Auth::guard('provider')->user()->id);
    }

    public function getDisplayNameAttribute()
    {
        $provider = null;
        if(Auth::guard('admin')->check()){
            $provider = Admin::where('id',\Auth::guard('admin')->user()->id)->first();
        }elseif(Auth::guard('user')->check()){
            $provider = User::where('id',\Auth::guard('user')->user()->id)->first();
        }elseif(Auth::guard('provider')->check()){
            $provider = Provider::where('id',\Auth::guard('provider')->user()->id)->first();
        }

        if($provider && $provider->language){
            $language = $provider->language;
            // app('translator')->setLocale($language);
        }else{
            $language='en';
        }
        // $locale = App::getLocale();
        $column = "display_name_".$language;
        return "{$this->$column}";
    }
	
}
