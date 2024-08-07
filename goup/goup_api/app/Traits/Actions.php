<?php

namespace App\Traits;

use App\Helpers\Helper;
use App\Models\Common\Setting;
use Auth;
use GuzzleHttp\Client;

trait Actions
{

    public $settings;
    public $user;
    public $company_id;

    public $api_key = 'A7M40XV-CG1448Z-KVVED3G-NW3V0TK';
    public function __construct() {

         $this->client = new Client([
            'base_uri' => 'https://api.nowpayments.io/v1/',
            'headers' => [
                    "x-api-key" => 'A7M40XV-CG1448Z-KVVED3G-NW3V0TK',
                    "Content-Type"=>'application/json'
            ],
            'timeout' => '5000'
        ]);
        $this->settings = Helper::setting();
        $this->user = Auth::guard(strtolower(Helper::getGuard()))->user();
        $this->company_id = ( Auth::guard(strtolower(Helper::getGuard()))->user() ) ? $this->user->company_id : 1;

         $this->client_revoult = new Client([
            'base_uri' => 'https://sandbox-merchant.revolut.com/api/1.0/',
            // 'headers' => [
            //         "Authorization" => 'Bearer sk_V2Cd2qe3AYQDRrtCkmIVpxcUPyJhUG5dfkQKOkGMpfk4HwLBcvicD66XY739OMQR',
            //         "Content-Type"=>'application/json'
            // ],
            'timeout' => '5000'
        ]);
    }

	public function removeModel($id)
    {
        try{
            $model = $this->model->find($id);

            $model->delete();
            return Helper::getResponse(['message' => trans('admin.user_msgs.user_delete')]);
        } 
        catch (\Throwable $e) {
            return Helper::getResponse(['status' => 404, 'message' => trans('admin.user_msgs.user_not_found'), 'error' => $e->getMessage()]);
        }
    }

    public function removeMultiple()
    {
    	
        try{
            $request = $this->request;
            $items = explode(',', $request->id);

            $this->model->destroy($items);

            return Helper::getResponse(['message' => trans('admin.user_msgs.user_delete')]);
        } 
        catch (\Throwable $e) {
            return Helper::getResponse(['status' => 404, 'message' => trans('admin.user_msgs.user_not_found'), 'error' => $e->getMessage()]);
        }

    }

    public function changeStatus()
    {
    	$request = $this->request;

        try{
            $this->model->where('id', $request->id)->update(['status' => $request->status]);

            return Helper::getResponse(['message' => trans('admin.user_msgs.user_delete')]);
        } 
        catch (\Throwable $e) {
            return Helper::getResponse(['status' => 404, 'message' => trans('admin.user_msgs.user_not_found'), 'error' => $e->getMessage()]);
        }
        
    }

    public function changeStatusAll()
    {
        try{
    	    $request = $this->request;
            $items = explode(',', $request->id);

            $this->model->whereIn('id', $items)->update(['status' => $request->status]);

            return Helper::getResponse(['message' => trans('admin.user_msgs.user_delete')]);
        } 
        catch (\Throwable $e) {
            return Helper::getResponse(['status' => 404, 'message' => trans('admin.user_msgs.user_not_found'), 'error' => $e->getMessage()]);
        }
    }

    public function sendUserData($maildata)
    {
        try{
            $settings = Setting::where('company_id', \Auth::user()->company_id)->first()->settings_data->site;

            
            if( !empty($settings->send_email) && $settings->send_email == 1) {
               $toEmail = isset($maildata['email'])?$maildata['email']:'';

                if(isset($maildata['first_name'])){
                    $name = $maildata['first_name'];
                }else{
                    $name = $maildata['name'];
                }
                     
            //  SEND MAIL TO USER, PROVIDER, FLEET
                $subject = "Notification";
                $data=['body'=> $maildata['body'],'username'=> $name,'contact_mail' => $settings->contact_email, 'contact_number' => $settings->contact_number[0]->number];
                

                $templateFile='mails/notification_mail';


                Helper::send_emails($templateFile,$toEmail,$subject, $data);

            } 
                          
            return true;
        } 
        catch (\Throwable $e) {           
            throw new \Exception($e->getMessage());
        } 

    }
}