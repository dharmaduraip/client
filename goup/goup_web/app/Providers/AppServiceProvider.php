<?php

namespace App\Providers;

use Helper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('service', function () {

            $args = func_get_args();

            $services = (Helper::getCache())->services;

            $data = [];

            foreach ($services as $service) {
                $data[] = $service->admin_service;
            }

            foreach ($args as $arg) {
                if (in_array(strtoupper($arg), $data)) {
                    return true;
                }

            }

            return false;
        });
        //For user Permission
        Blade::if('permission', function ($permission) {
            $permissions = Helper::PermissionList();

            if(count($permissions) == 0) {
                return redirect('/admin/logout');
            }
            if (in_array($permission, $permissions)) {
                return true;
            }

            return false;
        });
    }
}
