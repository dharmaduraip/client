<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Redis;
use Session;

class Helper
{
    /**
     * @param int $user_id User-id
     *
     * @return string
     */
    public static function getCache() 
    {
        $domain = $_SERVER['SERVER_NAME'];

        $site_settings = Redis::get($domain);

        return json_decode($site_settings);
    }

    public static function getAccessKey() 
    {
        $domain = $_SERVER['SERVER_NAME'];
        $path = storage_path('license') . '/' . $domain . '.json';
        $config_file = file_exists($path);

        if ($config_file) {

            $config = file_get_contents($path);
            $access_key = json_decode($config, true)['accessKey'];

            return $access_key;
        }

        return '123456';
    }

    public static function getFavIcon() 
    {
        $settings = !empty((self::getCache())->settings) ?  (self::getCache())->settings : null;

        if($settings != null) {
            return !empty($settings->settings_data) ? $settings->settings_data->site->site_icon : null;
        }
    }

    public static function getSiteLogo() 
    {
        $settings = !empty((self::getCache())->settings) ?  (self::getCache())->settings : null;

        if($settings != null) {
            return !empty($settings->settings_data) ? $settings->settings_data->site->site_logo : null;
        } 
    }

    public static function getDefaultCountry() 
    {
        $settings = !empty((self::getCache())->settings) ?  (self::getCache())->settings : null;

        if($settings != null) {
            return !empty($settings->settings_data) && !empty($settings->settings_data->site->country) ? $settings->settings_data->site->country : null;
        } 
    }

    public static function getCheckSms() 
    {
        $settings = !empty((self::getCache())->settings) ?  (self::getCache())->settings : null;

        if($settings != null) {
            return !empty($settings->settings_data) ? $settings->settings_data->site->send_sms : null;
        } 
    }

    public static function getrideotp() 
    {
        $settings = !empty((self::getCache())->settings) ?  (self::getCache())->settings : null;

        if($settings != null) {
            return !empty($settings->settings_data) ? $settings->settings_data->transport->ride_otp : null;
        } 
    }

    public static function getCheckEmail() 
    {
        $settings = !empty((self::getCache())->settings) ?  (self::getCache())->settings : null;

        if($settings != null) {
            return !empty($settings->settings_data) ? $settings->settings_data->site->send_email : null;
        } 
    }

    public static function getBaseUrl()
    {
        
        $base_url = !empty((self::getCache())->base_url)? (self::getCache())->base_url : null ;

        return $base_url;
    }

    public static function getSocketUrl()
    {
        
        $socket_url = !empty((self::getCache())->socket_url)? (self::getCache())->socket_url : null ;

        return $socket_url;
    }

    public static function getServiceBaseUrl()
    {
        $services = !empty((self::getCache())->services) ? (self::getCache())->services : [] ;

        $services_base_url = [];

        foreach ($services as $service) {
            $services_base_url[$service->admin_service] = $service->base_url;
        }

        $base = json_encode($services_base_url);

        return $base;
    }

    public static function getSettings()
    { 
        $settings = !empty((self::getCache())->settings) ?  (self::getCache())->settings : null;
      
        return !empty($settings->settings_data) ? $settings->settings_data : null;
    }

    public static function isDestination()
    { 
        $destination = isset(self::getSettings()->transport->destination) ? self::getSettings()->transport->destination : 1;

        return ($destination == 1) ? true : false;
    }

    public static function getDemomode()
    {
        $settings = (self::getCache())->settings;

        return !empty($settings->demo_mode) ? $settings->demo_mode : 0;
    }

    public static function getChatmode()
    {
        $settings = (self::getCache())->settings;

        return !empty($settings->chat) ? $settings->chat : 0;
    }

    public static function getEncrypt()
    {
        $settings = (self::getCache())->settings;

        return !empty($settings->encrypt) ? $settings->encrypt : 0;
    }

    public static function getBanner()
    {
        $settings = (self::getCache())->settings;

        return !empty($settings->banner) ? $settings->banner : 0;
    }

    public static function getSaltKey()
    {
        $settings = (self::getCache())->settings;

        return !empty($settings) ? base64_encode($settings->company_id)
        : null;
    }

    public static function getServiceList()
    {
        $services = (self::getCache())->services;
        $data = [];
        foreach ($services as $service) {
            $data[$service->id] = $service->admin_service;
        }
        return $data;
    }

    public static function checkService($type)
    {
        return in_array($type, self::getServiceList());
    }

    public static function getcmspage()
    {
        $cmspage = (self::getCache())->cmspage;

        return $cmspage;
    }

    public static function checkPayment($type)
    {
        $paymentConfig = json_decode( json_encode( self::getSettings()->payment ) , true);
        $payment = array_values(array_filter( $paymentConfig, function ($e) use($type) { return $e['name'] == $type; }));
        return (count($payment) > 0) ? ($payment[0]["status"] == 1 ? true : false) : false;
    }
    
    public static function getCountryList()
    {

        $country_list = (self::getCache())->country;

        $data = [];

        foreach ($country_list as $country) {
            $data[$country->country->id] = $country->country->country_name;
        }

        return $data;

    }

    public static function PermissionList()
    {

        $user = Session::get('user_id');
        $permissions = Redis::get($user);

        if($permissions == null) {
            return [];
        }

        return json_decode($permissions);

    }

    public static function getCountryCurrency($id)
    {

        $country_list = (self::getCache())->country;

        $data = [];

        foreach ($country_list as $country) {
            $data[$country->country->id] = $country->currency;
        }

        return $data[$id];

    }
}
