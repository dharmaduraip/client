<?php

namespace App\Http\Controllers\V1\Common\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Common\Setting;
use App\Models\Common\User;
use App\Models\Common\Provider;
use App\Models\Common\Admin;
use App\Models\Common\AdminWallet;
use App\Models\Common\AdminService;
use App\Models\Common\CompanyCountry;
use App\Helpers\Helper;
use Notification;
use Auth;
use DB;

class AdminController extends Controller
{
	public function settings_store(Request $request)
	{    

        $this->validate($request, [
		     'adminservice' => 'required_with:country_code',
		]);

		$setting = Setting::where('company_id', \Auth::user()->company_id)->first();

		if($setting->demo_mode == 1) {
			return Helper::getResponse(['status' => 403, 'message' => trans('admin.demomode') ]);
		}

		if($setting != null) {
			$data = json_decode(json_encode($setting->settings_data), true);

			if($request->has('mail_driver')) {
				if(!$request->has('send_email')) {
					$request->request->add(['send_email' => '0']);
				}
			}
			

			if($request->has('referral_count')) {
				if(!$request->has('referral')) {
					$request->request->add(['referral' => '0']);
				}

				if(!$request->has('date_format')) {
					$request->request->add(['date_format' => '0']);
				}
			}

			if($request->has('facebook_app_id')) {

				if(!$request->has('social_login')) {
					$request->request->add(['social_login' => '0']);
				}
 
			}

			if($request->has('sms_account_sid')){
				if(!$request->has('send_sms')) {
					$request->request->add(['send_sms' => '0']);
				}
			}

			if($request->has('provider_select_timeout')) {

				if(!$request->has('credit_ride_limit')) {
					$request->request->add(['credit_ride_limit' => '0']);
				}

				if(!$request->has('ride_otp')) {
					$request->request->add(['ride_otp' => '0']);
				}

				if(!$request->has('manual_request')) {
					$request->request->add(['manual_request' => '0']);
				}

				if(!$request->has('broadcast_request')) {
					$request->request->add(['broadcast_request' => '1']);
				}

			}

			if($request->has('service_provider_select_timeout')) {

				if(!$request->has('service_serve_otp')) {
					$request->request->add(['service_serve_otp' => '0']);
				}

				if(!$request->has('service_manual_request')) {
					$request->request->add(['service_manual_request' => '0']);
				}

				if(!$request->has('service_broadcast_request')) {
					$request->request->add(['service_broadcast_request' => '0']);
				}

			}

			if($request->has('store_search_radius')) {
				if(!$request->has('order_otp')) {
					$request->request->add(['order_otp' => '0']);
				}

				if(!$request->has('store_manual_request')) {
					$request->request->add(['store_manual_request' => '0']);
				}

				/*if(!$request->has('store_broadcast_request')) {
					$request->request->add(['store_broadcast_request' => '0']);
				}*/
			}
			if($request->has('delivery_provider_select_timeout')) {

				if(!$request->has('delivery_otp')) {
					$request->request->add(['delivery_otp' => '0']);
				}

				if(!$request->has('delivery_manual_request')) {
					$request->request->add(['delivery_manual_request' => '0']);
				}

				if(!$request->has('service_broadcast_request')) {
					$request->request->add(['service_broadcast_request' => '0']);
				}

			}

			foreach($request->except(['payment_name', 'payment_status', 'payment_key_name', 'payment_key_value','ride_otp', 'manual_request', 'broadcast_request', 'tax_percentage', 'commission_percentage', 'surge_trigger', 'provider_search_radius','store_search_radius', 'user_select_timeout', 'provider_select_timeout', 'surge_percentage', 'track_distance', 'booking_prefix', 'contact_number', 'service_provider_select_timeout', 'service_provider_search_radius', 'service_time_left_to_respond', 'service_tax_percentage', 'service_commission_percentage', 'service_surge_trigger', 'service_surge_percentage','service_manual_request', 'service_broadcast_request', 'service_serve_otp', 'service_booking_prefix', 'service_track_distance','store_search_radius', 'store_manual_request', 'store_broadcast_request', 'order_otp','max_items_in_order']) as $key => $req) {
				if(!empty($data['site'][$key])) {
					$data['site'][$key] = $request->$key;
				} else {
					$data['site'][$key] = $request->$key;
				}
			}

			foreach($request->only(['contact_number']) as $number) {

				$contact = new \stdClass();
				$contact->number = $number;

				$data['site']['contact_number'] = [$contact];

			}


			

			foreach($request->only(['user_select_timeout', 'provider_select_timeout', 'provider_search_radius', 'credit_ride_limit', 'manual_request', 'broadcast_request', 'ride_otp', 'booking_prefix']) as $key => $req) {

				if(!empty($data['transport'][$key])) {
					$data['transport'][$key] = $request->$key;
				} else {
					$data['transport'][$key] = $request->$key;
				}
			}
			$data['transport']['destination'] = $data['transport']['destination'];
			foreach($request->only(['service_provider_select_timeout', 'service_provider_search_radius', 'service_time_left_to_respond', 'service_tax_percentage', 'service_commission_percentage', 'service_surge_trigger', 'service_surge_percentage','service_manual_request', 'service_broadcast_request', 'service_serve_otp', 'service_booking_prefix', 'service_track_distance']) as $key => $req) {

				$key_name= str_replace(substr($key,0,strpos($key,'_')).'_', '', $key);

				if(!empty($data['service'][$key])) {
					$data['service'][$key_name] = $request->$key;
				} else {
					$data['service'][$key_name] = $request->$key;
				}
			}

			foreach($request->only(['store_search_radius', 'store_provider_select_timeout', 'store_manual_request', 'order_otp','store_booking_prefix','max_items_in_order','product_timeline','delivery_boy_response_time']) as $key => $req) {
				if($key == 'store_manual_request' || $key == 'store_provider_select_timeout' ||  $key == 'store_booking_prefix' ){
					$key_name = str_replace(substr($key,0,strpos($key,'_')).'_', '', $key);
				}else{
					$key_name = $key;
				}

				if(!empty($data['order'][$key])) {
					$data['order'][$key_name] = $request->$key;
				} else {
					$data['order'][$key_name] = $request->$key;
				}
			}
			if($request->has("delivery_manual_request")) {
				$data['site']['delivery_manual_request'] = 1;
			} else {
				$data['site']['delivery_manual_request'] = 0;
			}
			foreach($request->only(['delivery_user_select_timeout', 'delivery_broadcast_request', 'delivery_provider_select_timeout', 'delivery_provider_search_radius', 'delivery_unit_measurement', 'delivery_manual_request', 'delivery_otp', 'delivery_booking_prefix']) as $key => $req) {

				if(!$request->has('delivery_manual_request')) {
					$request->request->add(['delivery_manual_request' => '0']);
				}

				$key_name= str_replace(substr($key,0,strpos($key,'_')).'_', '', $key);

				if(!empty($data['delivery'][$key])) {
					$data['delivery'][$key_name] = $request->$key;
				} else {
					$data['delivery'][$key_name] = $request->$key;
				}
				\Log::info($data['delivery']);
			}
			//dd($data);
			$payment_name = $request->payment_name;
			$payment_status = $request->payment_status;
			$payment_key_name = $request->payment_key_name;
			$payment_key_value = $request->payment_key_value;

			if($request->has('payment_name')) {
				unset($data["payment"]);

				foreach($request->payment_name as $key => $value) {
                    	
					$credentials = [];

					foreach ($payment_key_name as $k => $credential_name) {
						if (preg_match("#^".$key."_#", $credential_name) === 1) {
							$credentials[] = ["name" => str_replace($key."_", "", $credential_name), "value" => str_replace($key."_", "", $payment_key_value[$k]) ];
						}
					}
					
					$data["payment"][] = ["name" => $value, "status" => isset($payment_status[$value]) ?  $payment_status[$value] : "0", "credentials" => $credentials ];
					
				}
			}

			if($request->hasFile('site_icon')) {
				$site_icon = Helper::upload_file($request->file('site_icon'), 'site', 'site_icon.'.$request->file('site_icon')->extension());
				$data['site']['site_icon'] = $site_icon;
			}

			if($request->hasFile('site_logo')) {
				$site_logo = Helper::upload_file($request->file('site_logo'), 'site', 'site_logo.'.$request->file('site_logo')->extension());
				$data['site']['site_logo'] = $site_logo;
			}

			if($request->hasFile('user_pem')) {
				$user_pem = Helper::upload_file($request->file('user_pem'), 'apns', 'user.pem');
				$data['site']['user_pem'] = $user_pem;
			}

			if($request->hasFile('provider_pem')) {
				$provider_pem = Helper::upload_file($request->file('provider_pem'), 'apns', 'provider.pem');
				$data['site']['provider_pem'] = $provider_pem;
			}

			if($request->hasFile('shop_pem')) {
				$shop_pem = Helper::upload_file($request->file('shop_pem'), 'apns', 'shop.pem');
				$data['site']['shop_pem'] = $shop_pem;
			}

			if($request->hasFile('home_page_video_1')) {
				$home_page_video_1 = Helper::upload_file($request->file('home_page_video_1'), 'site', 'home_page_video_1.'.$request->file('home_page_video_1')->extension());
				$data['site']['home_page_video_1'] = $home_page_video_1;
			}

			if($request->hasFile('home_page_video_2')) {
				$home_page_video_2 = Helper::upload_file($request->file('home_page_video_2'), 'site', 'home_page_video_2.'.$request->file('home_page_video_2')->extension());
				$data['site']['home_page_video_2'] = $home_page_video_2;
			}

			if($request->hasFile('home_page_video_3')) {
				$home_page_video_3 = Helper::upload_file($request->file('home_page_video_3'), 'site', 'home_page_video_3.'.$request->file('home_page_video_3')->extension());
				$data['site']['home_page_video_3'] = $home_page_video_3;
			}

			if($request->hasFile('home_page_video_4')) {
				$home_page_video_4 = Helper::upload_file($request->file('home_page_video_4'), 'site', 'home_page_video_4.'.$request->file('home_page_video_4')->extension());
				$data['site']['home_page_video_4'] = $home_page_video_4;
			}

			if($request->hasFile('home_page_video_5')) {
				$home_page_video_5 = Helper::upload_file($request->file('home_page_video_5'), 'site', 'home_page_video_5.'.$request->file('home_page_video_5')->extension());
				$data['site']['home_page_video_5'] = $home_page_video_5;
			}

			if($request->hasFile('home_page_video_6')) {
				$home_page_video_6 = Helper::upload_file($request->file('home_page_video_6'), 'site', 'home_page_video_6.'.$request->file('home_page_video_6')->extension());
				$data['site']['home_page_video_6'] = $home_page_video_6;
			}

			if($request->hasFile('home_page_video_7')) {
				$home_page_video_7 = Helper::upload_file($request->file('home_page_video_7'), 'site', 'home_page_video_7.'.$request->file('home_page_video_7')->extension());
				$data['site']['home_page_video_7'] = $home_page_video_7;
			}

			if($request->hasFile('home_page_video_8')) {
				$home_page_video_8 = Helper::upload_file($request->file('home_page_video_8'), 'site', 'home_page_video_8.'.$request->file('home_page_video_8')->extension());
				$data['site']['home_page_video_8'] = $home_page_video_8;
			}

			$setting->settings_data = json_encode($data);
			$setting->save();

			if(count(is_countable($request->adminservice) ? $request->adminservice : []) > 0 &&$request->has('adminservice')){
				
				AdminService::where('company_id',1)->update(['status'=>0]);
                foreach($request->adminservice as $k=>$v){
					AdminService::where('id',$k)->update(['status'=>1]);
                }

			}
			

			//Send message to socket
			$requestData = ['type' => 'SETTING'];
			app('redis')->publish('settingsUpdate', json_encode( $requestData ));

			return Helper::getResponse(['status' => 200,'data'=>json_encode($data)]);

		} else {

			return Helper::getResponse(['status' => 404]);

		}
   
	}
 
	public function dashboarddata($id)
	{
	  try{

		  $data['currency']=CompanyCountry::where('country_id',$id)->select('currency')->first();
		  $data['userdata']=User::where('country_id', $id)->where('company_id',\Auth::user()->company_id)->count();
		  $data['providerdata']=Provider::where('country_id', $id)->where('company_id',\Auth::user()->company_id)->count();
		  $data['fleetdata']=Admin::where('country_id', $id)->where('type','FLEET')->where('company_id',\Auth::user()->company_id)->count();

			$data['admin'] = AdminWallet::where('country_id', $id)->where('company_id',\Auth::user()->company_id)->sum('amount');
			$data['provider_debit'] = Provider::select(DB::raw('SUM(CASE WHEN wallet_balance<0 THEN wallet_balance ELSE 0 END) as total_debit'))->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->get()->toArray();
			$data['provider_credit'] = Provider::select(DB::raw('SUM(CASE WHEN wallet_balance>=0 THEN wallet_balance ELSE 0 END) as total_credit'))->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->get()->toArray();
			$data['fleet_debit'] = Admin::select(DB::raw('SUM(CASE WHEN wallet_balance<0 THEN wallet_balance ELSE 0 END) as total_debit'))->where('type','FLEET')->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->get()->toArray();
			$data['fleet_credit'] = Admin::select(DB::raw('SUM(CASE WHEN wallet_balance>=0 THEN wallet_balance ELSE 0 END) as total_credit'))->where('type','FLEET')->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->get()->toArray();

			$data['admin_tax'] = AdminWallet::where('transaction_type',9)->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->sum('amount');
			$data['admin_commission'] = AdminWallet::where('transaction_type',1)->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->sum('amount');
			$data['admin_discount'] = AdminWallet::where('transaction_type',10)->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->sum('amount');
			$data['admin_referral'] = AdminWallet::where('transaction_type',12)->orWhere('transaction_type',13)->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->sum('amount');
			$data['admin_dispute'] = AdminWallet::where('transaction_type',16)->orWhere('transaction_type',17)->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->sum('amount');
			$data['peak_commission'] = AdminWallet::where('transaction_type',14)->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->sum('amount');
			$data['waiting_commission'] = AdminWallet::where('transaction_type',15)->where('country_id', $id)->where('company_id',\Auth::user()->company_id)->sum('amount');
			return Helper::getResponse(['status' => 200,'data'=>$data]);

		 }
		 catch (Exception $e) {
			return Helper::getResponse(['status' => 500, 'message' => trans('api.something_went_wrong'), 'error' => $e->getMessage() ]);
		}
	  
   }   

	public function backup(Request $request) {

		$setting = Setting::where('company_id', \Auth::user()->company_id)->first();

		if($setting->demo_mode == 1) {
			return Helper::getResponse(['status' => 403, 'message' => trans('admin.demomode') ]);
		}

		$host           = env('DB_'.$request->backupdb.'_HOST','');
		$username       = env('DB_'.$request->backupdb.'_USERNAME','');
		$password       = env('DB_'.$request->backupdb.'_PASSWORD','');
		$database       = env('DB_'.$request->backupdb.'_DATABASE','');
		$dateFormat     = $database."_".(new \DateTime())->format('Y-m-d');
		$dir            = app()->basePath('storage/app/public');
		$path           = app()->basePath('storage/app/public/'.$dateFormat.".sql" );

		if (!file_exists( $dir  )) {
            mkdir( $dir , 0777, true);
        }

		if(!empty($password)) $command        = sprintf('mysqldump -h %s -u %s -p\'%s\' %s > %s', $host, $username,$password, $database, $path);
		else $command        = sprintf('mysqldump -h %s -u %s %s > %s', $host, $username, $database, $path);
		exec($command);
		return url().'/storage/'.$dateFormat.'.sql';
	}

 
	public function push_subscription(Request $request) {

		$this->validate($request,[
			'endpoint'    => 'required',
			'keys.auth'   => 'required',
			'keys.p256dh' => 'required'
		]);
		
		$endpoint = $request->endpoint;
		$token = $request->keys['auth'];
		$key = $request->keys['p256dh'];
		$user = Auth::user();
		$user->updatePushSubscription($endpoint, $key, $token);
		
		return response()->json(['success' => true],200);
	}



}
