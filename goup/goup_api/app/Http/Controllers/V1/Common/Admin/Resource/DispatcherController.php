<?php

namespace App\Http\Controllers\V1\Common\Admin\Resource;

use App\Models\Common\Admin;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Common\UserRequest;
use App\Models\Common\RequestFilter;
use App\Models\Common\AdminService;
use App\Models\Common\Setting;
use App\Models\Common\Country;
use App\Models\Common\State;
use App\Models\Common\User;
use App\Models\Common\Provider;
use App\Models\Order\StoreOrderStatus;
use App\Services\V1\Transport\Ride;
use Spatie\Permission\Models\Role;
use App\Models\Common\ProviderService;
use App\Services\SendPushNotification;
use App\Models\Order\StoreOrder;
use App\Models\Service\Service;
use App\Models\Service\ServiceRequest;
use App\Models\Common\CompanyCountry;
use App\Models\Transport\RideType;
use App\Models\Service\ServiceCategory;
use App\Models\Service\ServiceCancelProvider;
use App\Models\Transport\RideRequest;
use App\Services\V1\ServiceTypes;
use App\Services\V1\Common\UserServices;
use Carbon\Carbon;
use App\Traits\Actions;
use App\Traits\Encryptable;
use Exception;
use Auth;
use DB;
use Log;

class DispatcherController extends Controller
{
    use Actions;
    use Encryptable;

    private $model;
    private $request;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Admin $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $datum = Admin::where('company_id', Auth::user()->company_id);

        $column_name = $datum->first()->toArray();

        $columns = (count($column_name) > 0) ? array_keys($column_name) : [];

        if($request->has('search_text') && $request->search_text != null) {
            $datum->where(function ($query) use($columns, $request) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'LIKE', "%".$request->search_text."%");
                }
            });
        }

        if($request->has('order_by')) {
            $datum->orderby($request->order_by, $request->order_direction);
        }
        
        if($request->has('page') && $request->page == 'all') {
            $data = $datum->get();
        } else {
            $data = $datum->paginate(10);
        }

        return Helper::getResponse(['data' => $data]);
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:dispatchers,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try{
            $request->request->add(['company_id' => \Auth::user()->company_id]);
            $request->request->add(['parent_id' => \Auth::user()->id]);
            $Dispatcher = $request->all();
            $Dispatcher['password'] = Hash::make($request->password);   
            $Dispatcher = Admin::create($Dispatcher);

            $role = Role::where('name', 'DISPATCHER')->first();

            if($role != null) $Dispatcher->assignRole($role->id);

            return Helper::getResponse(['status' => 200, 'message' => trans('admin.create')]);
        } 
        catch (\Throwable $e) {
            return Helper::getResponse(['status' => 404, 'message' => trans('admin.something_wrong'), 'error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $dispatcher = Admin::findOrFail($id);
            return Helper::getResponse(['data' => $dispatcher]);
        } catch (\Throwable $e) {
            return Helper::getResponse(['status' => 404,'message' => trans('admin.something_wrong'), 'error' => $e->getMessage()]);
        }
    }

    public function trips(Request $request)
    {
        $settings = json_decode(json_encode(Setting::where('company_id', Auth::user()->company_id)->first()->settings_data));
        $siteConfig = $settings->site;
        $trips = UserRequest::with('user', 'provider', 'service')->orderBy('id','desc');
        if($request->type == "SEARCHING"){
            $trips = $trips->where('status',$request->type);
        }else if($request->type == "RECEIVED"){
            $trips = $trips->where('status',$request->type);
        }else if($request->type == "CANCELLED"){
            $trips = $trips->where('status',"CANCELLED");
        }else if($request->type == "ASSIGNED"){
            $trips = $trips->whereNotIn('status',['SEARCHING', 'ORDERED', 'RECEIVED','SCHEDULED','CANCELLED','COMPLETED']);
        }
        $trips = $trips->get();

        return Helper::getResponse(['data' => $trips]);
    }


    


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if($request->has('email') &&  $request->email != null) $request->request->add(['email' => strtolower($request->email)]);

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|unique:dispatchers,email|email|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        try {

            $dispatcher = Admin::findOrFail($id);
            $dispatcher->name = $request->name;
            $dispatcher->email = $request->email;
            $dispatcher->password = $request->password;
            $dispatcher->save();

            return Helper::getResponse(['status' => 200, 'message' => trans('admin.update')]);
        } 
        catch (\Throwable $e) {
            return Helper::getResponse(['status' => 404,'message' => trans('admin.something_wrong'), 'error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dispatcher  $dispatcher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->removeModel($id);
    }

    public function providers(Request $request)
    {
        if($request->has('latitude') && $request->has('longitude')) {
            $settings = json_decode(json_encode(Setting::where('company_id', Auth::user()->company_id)->first()->settings_data));
            $siteConfig = $settings->site;
            if($request->has('provider_service_id')) { 
                $ActiveProviders = ProviderService::where('company_id', Auth::user()->company_id)->where('ride_delivery_id', $request->provider_service_id)->where('admin_service','TRANSPORT')->get()
                    ->pluck('provider_id');
                $transportConfig = $settings->transport;
                $distance = isset($transportConfig->provider_search_radius) ? $transportConfig->provider_search_radius : 10;   
                $admin_service = "TRANSPORT";
            }
            if($request->has('store_type_id')) { 
                $ActiveProviders = ProviderService::where('company_id', Auth::user()->company_id)->where('category_id', $request->store_type_id)->where('admin_service','ORDER')->get()
                ->pluck('provider_id');
                $orderConfig = $settings->order;
                $distance = isset($orderConfig->store_search_radius) ? $orderConfig->store_search_radius : 100;   
                $admin_service = "ORDER";
            }
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $Providers = Provider::whereIn('id', $ActiveProviders)
                ->where('status', 'approved')
                ->where('is_online', 1)
                ->where('is_assigned', 0)
                ->where('wallet_balance' ,'>=',$siteConfig->provider_negative_balance)
                ->whereRaw("(1.609344 * 3956 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
                ->with(['service' => function($query) use($admin_service,$request) {
                    if($admin_service== 'ORDER') {
                        $query->where('admin_service', 'ORDER');
                        $query->where('category_id', $request->store_type_id);
                    } else if($admin_service == 'TRANSPORT'){
                        $query->where('admin_service', 'TRANSPORT');
                        $query->where('ride_delivery_id', $request->provider_service_id);
                    }
                }, 'service.vehicle', 'service.ride_vehicle'])->get();
            return Helper::getResponse(['status' => 200, 'data' => $Providers]);
        }

        return null;
    }


    public function assign(Request $request)
    {
        //try {

            $type = 'common';

            //try {

                if($request->admin_service == "TRANSPORT" ) {
                    $newRequest = \App\Models\Transport\RideRequest::find($request->id);

                    $setting = Setting::where('company_id', $newRequest->company_id)->first();
                    //Send message to socket
                    $requestData = ['type' => 'TRANSPORT', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $newRequest->city_id : 0, 'user' => $newRequest->user_id ];
                    app('redis')->publish('checkTransportRequest', json_encode( $requestData ));
                    $requestData = ['type' => 'TRANSPORT', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $newRequest->city_id : 0, 'user' => $newRequest->user_id ];
                    app('redis')->publish('newRequest', json_encode( $requestData ));

                    $type = 'TRANSPORT';

                } else if($request->admin_service == "ORDER") {
                    $newRequest = \App\Models\Order\StoreOrder::with('invoice', 'store.storetype')->where('id',$request->id)->first();
                    $setting = Setting::where('company_id', $newRequest->company_id)->first();
                    //Send message to socket
                    $requestData = ['type' => 'ORDER', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $newRequest->city_id : 0, 'user' => $newRequest->user_id ];
                    app('redis')->publish('checkOrderRequest', json_encode( $requestData ));
                     $requestData = ['type' => 'ORDER', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $newRequest->city_id : 0, 'user' => $newRequest->user_id ];
                    app('redis')->publish('newRequest', json_encode( $requestData ));

                    $type = 'order';
                }
           /* } catch(\Throwable $e) { }*/


            $Provider = Provider::findOrFail($request->provider_id);

            $newRequest->provider_id = $Provider->id;
            if($request->admin_service == "TRANSPORT")
            $newRequest->status = 'STARTED';
            else if($request->admin_service == "ORDER")
            $newRequest->status = 'PROCESSING';

            $newRequest->save();

            Provider::where('id',$newRequest->provider_id)->update(['is_assigned' =>'1']);
            //ProviderService::where('provider_id',$newRequest->provider_id)->update(['status' =>'riding']);

            (new SendPushNotification)->IncomingRequest($newRequest->provider_id, $type);
            if($request->admin_service == "TRANSPORT"){
                $rideType = RideType::find($newRequest->ride_type_id);
                $newRequest->request_method = $rideType->ride_name;
            }

            $user_request = UserRequest::where('request_id', $newRequest->id)->first();
            $user_request->provider_id = $newRequest->provider_id;
            $user_request->status = $newRequest->status;
            $user_request->request_data = json_encode($newRequest);

            $user_request->save();

            $filter = new RequestFilter;
            $filter->admin_service = $request->admin_service;
            $filter->request_id = $user_request->id;
            $filter->provider_id = $Provider->id; 
            $filter->company_id = Auth::user()->company_id; 
            $filter->save();

            return Helper::getResponse(['message' => trans('admin.dispatcher_msgs.request_assigned') ]);

        /*} catch (Exception $e) {
            return Helper::getResponse(['status' => 500, 'error' => $e->getMessage() ]);
        }*/
    }

    public function create_ride(Request $request)
    {
        if($request->has('email') &&  $request->email != null) $request->request->add(['email' => strtolower($request->email)]);
        $this->validate($request, [
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'd_latitude' => 'required|numeric',
            'd_longitude' => 'required|numeric',
            'country_code' => 'required|numeric',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);
        $geofence =(new UserServices())->poly_check_request((round($request->s_latitude,6)),(round($request->s_longitude,6)), $request->city_id);
        if($geofence == false) {
            return ['status' => 400, 'message' => trans('user.ride.service_not_available_location'), 'error' => trans('user.ride.service_not_available_location')];
        }
        $request->request->add(['geofence_id' => $geofence['id']]);
        $setting = Setting::where('company_id', Auth::user()->company_id)->first();
        $settings = json_decode(json_encode($setting->settings_data));
        $siteConfig = $settings->site;

        $transportConfig = $settings->transport;

        $country = Country::find($request->country_id);

        $state = State::where('country_id', $country->id)->first();

        $timezone = $state->timezone;

        $currency = $country->country_symbol;

        $mobile = $this->cusencrypt($request->mobile,env('DB_SECRET'));
        $email = $this->cusencrypt($request->email,env('DB_SECRET'));

        try {
            $User = User::where('mobile', $mobile)->firstOrFail();
        } catch (Exception $e) {
            try {
                $User = User::where('email', $email)->firstOrFail();
            } catch (Exception $e) {
                $User = User::create([
                    'company_id' => Auth::user()->company_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'country_code' => $request->country_code,
                    'mobile' => $request->mobile,
                    'password' => Hash::make($request->mobile),
                    'country_id' => $request->country_id,
                    'state_id' => $state->id,
                    'city_id' => $request->city_id,
                    'currency' => $currency,
                    'payment_mode' => 'CASH'
                ]);
            }
        }

        if($request->schedule_date != "" && $request->schedule_time != "" ){
            try {

                $schedule_time = (Carbon::createFromFormat('Y-m-d H:i:s', (Carbon::parse($request->schedule_date. ' ' .$request->schedule_time)->format('Y-m-d H:i:s')), $timezone))->setTimezone('UTC');

                $CheckScheduling = \App\Models\Transport\RideRequest::where('status', 'SCHEDULED')
                        ->where('user_id', $User->id)
                        ->where('schedule_at', '>', strtotime($schedule_time." - 1 hour"))
                        ->where('schedule_at', '<', strtotime($schedule_time." + 1 hour"))
                        ->firstOrFail();
                
                return Helper::getResponse(['message' => trans('api.ride.request_scheduled'), 'error' => trans('api.ride.request_scheduled') ]);

            } catch (Exception $e) {
                // Do Nothing
            }
        }

        $distance = $transportConfig->provider_search_radius ? $transportConfig->provider_search_radius : 100;

        $latitude = $request->s_latitude;
        $longitude = $request->s_longitude;
        $service_type = $request->provider_service_id;

        $Providers = Provider::with('service')
            ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id')
            ->where('status', 'approved')
            ->where('is_online', 1)
            ->where('is_assigned', 0)
            ->where('company_id', Auth::user()->company_id)
            ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
            ->whereHas('service', function($query) use ($service_type){
                        $query->where('status','active');
                        $query->where('ride_delivery_id', $service_type);
                    })
            ->orderBy('distance','asc')
            ->get();

        if(count($Providers) == 0) {
            return Helper::getResponse(['status' => 422, 'message' => trans('api.ride.no_providers_found')]);
        } 

        try {
            $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->d_latitude.",".$request->d_longitude."&mode=driving&key=".$siteConfig->server_key;

            $json = Helper::curl($details);

            $details = json_decode($json, TRUE);

            $route_key = (count($details['routes']) > 0) ? $details['routes'][0]['overview_polyline']['points'] : '';

            $newRequest = new \App\Models\Transport\RideRequest;
            $newRequest->request_type = $transportConfig->broadcast_request==1?'AUTO':'MANUAL';
            $newRequest->company_id = Auth::user()->company_id;
            $newRequest->admin_service = 'TRANSPORT';
            $newRequest->booking_id = Helper::generate_booking_id('TRNX');

            $newRequest->user_id = $User->id;
            if($transportConfig->manual_request == "1") $newRequest->request_type = "MANUAL";
            

            $newRequest->provider_service_id = $request->provider_service_id;
            $newRequest->ride_type_id = $request->ride_type_id;
            $newRequest->payment_mode = 'CASH';
            $newRequest->promocode_id = 0;
            
            $newRequest->status = 'SEARCHING';

            $newRequest->timezone = $timezone;
            $newRequest->currency = $currency;

            $newRequest->city_id = $request->city_id;
            $newRequest->country_id = $request->country_id;

            $newRequest->s_address = $request->s_address ? $request->s_address : "";
            $newRequest->d_address = $request->d_address ? $request->d_address  : "";

            $newRequest->s_latitude = $request->s_latitude;
            $newRequest->s_longitude = $request->s_longitude;

            $newRequest->d_latitude = $request->d_latitude;
            $newRequest->d_longitude = $request->d_longitude;
            $newRequest->ride_delivery_id = $request->provider_service_id;
            $newRequest->geofence_id = $request->geofence_id;


            $newRequest->track_distance = 1;
            
            $newRequest->track_latitude = $request->d_latitude ? $request->d_latitude : $request->s_latitude;
            $newRequest->track_longitude = $request->d_longitude ? $request->d_longitude : $request->s_longitude;

            if($request->d_latitude == null && $request->d_longitude == null) {
                $newRequest->is_drop_location = 0;
            }

            $newRequest->destination_log = json_encode([['latitude' => $newRequest->d_latitude, 'longitude' => $request->d_longitude, 'address' => $request->d_address]]);
            $newRequest->distance = $request->distance ? $request->distance  : 0;
            $newRequest->unit = isset($siteConfig->distance) ? $siteConfig->distance : 'Kms';

            $newRequest->is_track = "YES";

            $newRequest->otp = mt_rand(1000 , 9999);

            $newRequest->assigned_at = Carbon::now();
            $newRequest->route_key = $route_key;

            if($request->schedule_date != "" && $request->schedule_time != "" ){
                $newRequest->status = 'SCHEDULED';
                $newRequest->schedule_at = (Carbon::createFromFormat('Y-m-d H:i:s', (Carbon::parse($request->schedule_date. ' ' .$request->schedule_time)->format('Y-m-d H:i:s')), $timezone))->setTimezone('UTC');
                $newRequest->is_scheduled = 'YES';
            }

            if($newRequest->status != 'SCHEDULED') {
                if($transportConfig->manual_request == 0 && $transportConfig->broadcast_request == 0) {
                    //Log::info('New Request id : '. $newRequest->id .' Assigned to provider : '. $newRequest->provider_id);
                    //(new SendPushNotification)->IncomingRequest($Providers[0]->id);
                }
            }   
            $newRequest->save();
            $newRequest = RideRequest::with('ride', 'ride_type')->where('id', $newRequest->id)->first();
            if($transportConfig->manual_request == 1) {
                $admins = Admin::select('id')->get();
                foreach ($admins as $admin_id) {
                    $admin = Admin::find($admin_id->id);
                    //$admin->notify(new WebPush("Notifications", trans('api.push.incoming_request'), route('admin.dispatcher.index') ));
                }
            }
            //Add the Log File for ride
            $user_request = new UserRequest();
            $user_request->request_id = $newRequest->id;
            $user_request->user_id = $newRequest->user_id;
            $user_request->provider_id = $newRequest->provider_id;
            $user_request->admin_service =$newRequest->admin_service;
            $user_request->schedule_at = $newRequest->schedule_at;
            $user_request->status = $newRequest->status;
            $user_request->request_data = json_encode($newRequest);
            $user_request->company_id = Auth::user()->company_id; 
            $user_request->save();

            if ($request->schedule_date == "" && $request->schedule_time == "") {
                if($newRequest->status != 'SCHEDULED') {
                    if($transportConfig->manual_request == 0){ 
                        $first_iteration = true;
                        foreach ($Providers as $key => $Provider) {

                            if($transportConfig->broadcast_request == 1){
                               (new SendPushNotification)->IncomingRequest($Provider->id, 'transport'); 
                            }

                            $existingRequest =  RequestFilter::where('provider_id', $Provider->id)->first();
                            if($existingRequest == null) { 
                                $Filter = new RequestFilter;
                                // Send push notifications to the first provider
                                // incoming request push to provider
                                $Filter->admin_service = $newRequest->admin_service;
                                $Filter->request_id = $user_request->id;
                                $Filter->provider_id = $Provider->id; 

                                if($transportConfig->broadcast_request == 0 && $first_iteration == false ) {
                                    $Filter->assigned = 1;
                                }

                                $Filter->company_id = Auth::user()->company_id; 
                                $Filter->save();
                            }
                            $first_iteration = false;
                        }
                    }

                    //Send message to socket
                    $requestData = ['type' => 'TRANSPORT', 'room' => 'room_'.$newRequest->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $newRequest->city_id : 0, 'user' => $newRequest->user_id ];
                    app('redis')->publish('newRequest', json_encode( $requestData ));

                }
            }

            if( !empty($siteConfig->send_email) && $siteConfig->send_email == 1) {
                if( $siteConfig->mail_driver == 'SMTP') {
                    //  SEND OTP TO MAIL
                    $subject='Request|OTP';
                    $templateFile = 'mails/requestotp';
                    $toEmail = $User->email;
                    $data=['body' => $newRequest->otp, 'username' => $User->first_name];
                    //$result= Helper::send_emails($templateFile, $toEmail, $subject, $data);               
                }
            }

            if( !empty($siteConfig->send_sms) && $siteConfig->send_sms == 1) {
                $smsMessage ='Your Otp to start the request is '.$newRequest->otp;
                $plusCodeMobileNumber = $User->mobile;
                // send OTP SMS here            
                //Helper::send_sms($User->company_id, $plusCodeMobileNumber, $smsMessage);
            }

            return Helper::getResponse([ 'data' => [
                        'message' => ($newRequest->status == 'SCHEDULED') ? 'Schedule request created!' : 'New request created!',
                        'request_id' => $newRequest->id,
                        'current_provider' => $newRequest->provider_id,
                    ]]);

        } catch (Exception $e) {  
            return Helper::getResponse(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function cancel_ride(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:user_requests,request_id',
            'admin_service' => 'required|in:TRANSPORT,ORDER,SERVICE',
        ]);

        try{

            $newRequest = UserRequest::where('admin_service', $request->admin_service)->where('request_id', $request->id)->first();
            if($newRequest->status == 'CANCELLED')
            {
                return Helper::getResponse(['status' => 404, 'message' => trans('api.ride.already_cancelled')]);
            }
            if(in_array($newRequest->status, ['SEARCHING','STARTED','ARRIVED','SCHEDULED'])) {
                if($request->admin_service == "TRANSPORT" ) { 
                    try {
                        $rideRequest = \App\Models\Transport\RideRequest::find($request->id);
                        $rideRequest->cancelled_by = 'ADMIN';
                        $rideRequest->status = 'CANCELLED';
                        $rideRequest->save();
                        $setting = Setting::where('company_id', $rideRequest->company_id)->first();
                        //Send message to socket
                        $requestData = ['type' => 'TRANSPORT', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $rideRequest->city_id : 0, 'user' => $rideRequest->user_id ];
                        app('redis')->publish('newRequest', json_encode( $requestData ));
                    } catch(\Throwable $e) { }
                } else if ($request->admin_service == "ORDER") {
                     try {
                        $storeorder=\App\Models\Order\StoreOrder::find($request->id);
                        $storeorder->cancelled_by = 'ADMIN';
                        $storeorder->status = 'CANCELLED';
                        $storeorder->save();
                        $setting = Setting::where('company_id', $storeorder->company_id)->first();
                        $requestData = ['type' => 'ORDER', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $storeorder->city_id : 0, 'user' => $newRequest->user_id ];
                        app('redis')->publish('newRequest', json_encode( $requestData ));

                     } catch(\Throwable $e) { }
                } else if ($request->admin_service == "SERVICE") {
                     try {
                        $serviceRequest = \App\Models\Service\ServiceRequest::find($request->id);
                        $serviceRequest->cancelled_by = 'ADMIN';
                        $serviceRequest->status = 'CANCELLED';
                        $serviceRequest->save();
                        $setting = Setting::where('company_id', $serviceRequest->company_id)->first();
                        $requestData = ['type' => 'ORDER', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $serviceRequest->city_id : 0, 'user' => $newRequest->user_id ];
                        app('redis')->publish('newRequest', json_encode( $requestData ));
                     } catch(\Throwable $e) { }
                }

                RequestFilter::where('admin_service', $request->admin_service )->where('request_id', $newRequest->id)->delete();
                UserRequest::where('id',$newRequest->id)->delete();
                $newRequest->delete();
                return Helper::getResponse(['message' => trans('api.ride.ride_cancelled')]);
            } else {
                return Helper::getResponse(['status' => 403, 'message' => trans('api.ride.already_onride')]);
            }
        }

        catch (ModelNotFoundException $e) {
            return Helper::getResponse(['status' => 500, 'error' => $e->getMessage()]);
        }
    }

    public function create_service(Request $request)
    {
        if($request->has('email') &&  $request->email != null) $request->request->add(['email' => strtolower($request->email)]);
        $this->validate($request, [
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'country_code' => 'required|numeric',
            'country_id' => 'required',
            'city_id' => 'required',
        ]);
        // return $request->all();
        $country = Country::find($request->country_id);
        $state = State::where('country_id', $country->id)->first();
        $timezone = $state->timezone;
        $currency = $country->country_currency;
        $mobile = $this->cusencrypt($request->mobile,env('DB_SECRET'));
        $email = $this->cusencrypt($request->email,env('DB_SECRET'));
        try {
            $User = User::where('mobile', $mobile)->firstOrFail();
        } catch (Exception $e) {
            try {
                $User = User::where('email', $email)->firstOrFail();
            } catch (Exception $e) {
                $User = User::create([
                    'company_id' => Auth::user()->company_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'country_code' => $request->country_code,
                    'mobile' => $request->mobile,
                    'password' => Hash::make($request->mobile),
                    'country_id' => $request->country_id,
                    'state_id' => $state->id,
                    'city_id' => $request->city_id,
                    'currency' => $currency,
                    'payment_mode' => 'CASH'
                ]);
            }
        }
        $provider_id = $request->provider_id;
        $provider = Provider::find($provider_id);
        $company_id = $User->company_id; 
        $FilterCheck = RequestFilter::where(['admin_service'=>'SERVICE','provider_id'=>$provider_id,'company_id'=>$company_id])->first();
        if($FilterCheck != null) {
            return Helper::getResponse(['status' => 422, 'message' => trans('api.ride.request_inprogress')]);
        }
        $ActiveRequests = ServiceRequest::PendingRequest($User->id)->count();
        if($ActiveRequests > 0) {
            return Helper::getResponse(['status' => 422, 'message' => trans('api.ride.request_inprogress')]);
        }
        $setting = Setting::where('company_id', Auth::user()->company_id)->first();
        $settings = json_decode(json_encode($setting->settings_data));
        $siteConfig = $settings->site;
        $serviceConfig = $settings->service;
        $timezone =  ($User->state_id) ? State::find($User->state_id)->timezone : '';
        $currency = CompanyCountry::where('company_id',$company_id)->where('country_id', $User->country_id)->first();
        if($request->has('schedule_date') && $request->has('schedule_time')){
            $schedule_date = (Carbon::createFromFormat('Y-m-d H:i:s', (Carbon::parse($request->schedule_date. ' ' .$request->schedule_time)->format('Y-m-d H:i:s')), $timezone))->setTimezone('UTC');
            $beforeschedule_time = (new Carbon($schedule_date))->subHour(1);
            $afterschedule_time = (new Carbon($schedule_date))->addHour(1);
            $CheckScheduling = ServiceRequest::where('status','SCHEDULED')
                            ->where('user_id', $User->id)
                            ->whereBetween('schedule_at',[$beforeschedule_time,$afterschedule_time])
                            ->count();
            if($CheckScheduling > 0){
                return Helper::getResponse(['status' => 422, 'message' => trans('api.ride.request_already_scheduled')]);
            }
        }
        $distance = $serviceConfig->provider_search_radius ? $serviceConfig->provider_search_radius : 100;
        // $distance = config('constants.provider_search_radius', '10');
        $latitude =$request->s_latitude;
        $longitude = $request->s_longitude;
        $service_id = $request->service_id;
        $Provider = Provider::with('service','rating')
            ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id','first_name','picture')
            ->where('id', $provider_id)
            ->orderBy('distance','asc')
            ->first();
        try {
            $details = 'https://maps.googleapis.com/maps/api/directions/json?origin='.$request->s_latitude.','.$request->s_longitude.'&destination='.$request->s_latitude.','.$request->s_longitude.'&mode=driving&key='.$siteConfig->server_key;
            $json = Helper::curl($details);
            $details = json_decode($json, TRUE);
            $route_key = (count($details['routes']) > 0) ? $details['routes'][0]['overview_polyline']['points'] : '';
            $serviceRequest = new ServiceRequest;
            $serviceRequest->company_id = $company_id;
            $prefix = $serviceConfig->booking_prefix;
            $serviceRequest->booking_id = Helper::generate_booking_id($prefix);
            $serviceRequest->admin_service =  'SERVICE';
            $serviceRequest->user_id = $User->id;
            //$serviceRequest->provider_service_id = $request->service_id;
            $serviceRequest->service_id = $request->service_id;
            $serviceRequest->provider_id =  $provider_id;
            //$serviceRequest->rental_hours = $request->rental_hours;
            $serviceRequest->payment_mode = 'CASH';
            $serviceRequest->promocode_id = 0;
            $serviceRequest->status = 'ACCEPTED';
            $serviceRequest->timezone = $timezone;
            $serviceRequest->currency = ($currency != null) ? $currency->currency : '' ;
            $serviceRequest->city_id = $request->city_id;
            $serviceRequest->country_id = $request->country_id;
            $serviceRequest->s_address = $request->s_address ? $request->s_address : "Address";
            $serviceRequest->s_latitude = $latitude;
            $serviceRequest->s_longitude = $longitude;
            $serviceRequest->track_latitude = $latitude;
            $serviceRequest->track_longitude =  $longitude;
            $serviceRequest->allow_description = $request->allow_description;
            if($request->hasFile('allow_image')) {
                $serviceRequest->allow_image = Helper::upload_file($request->file('allow_image'), 'service/image', null, $company_id);
            }
            // $serviceRequest->quantity = $request->quantity;
            // $serviceRequest->price = $request->price;
            $serviceRequest->distance = $request->distance ? $request->distance  : 0;
            $serviceRequest->unit = config('constants.distance', 'Kms');
            if($User->wallet_balance > 0){
                $serviceRequest->use_wallet = $request->use_wallet ? : 0;
            }
            $serviceRequest->otp = mt_rand(1000 , 9999);
            $serviceRequest->assigned_at = (Carbon::now())->toDateTimeString();
            $serviceRequest->route_key = $route_key;
            $serviceRequest->admin_id = $provider->admin_id;
            /*if($Providers->count() <= config('constants.surge_trigger') && $Providers->count() > 0){
                $serviceRequest->surge = 1;
            }*/
            if($request->has('schedule_date') && $request->has('schedule_time') && trim($request->schedule_date) != '' && trim($request->schedule_time) != ''){
                $serviceRequest->status = 'SCHEDULED';
                $serviceRequest->schedule_at = (Carbon::createFromFormat('Y-m-d H:i:s', (Carbon::parse($request->schedule_date. ' ' .$request->schedule_time)->format('Y-m-d H:i:s')), $timezone))->setTimezone('UTC');
                $serviceRequest->is_scheduled = 'YES';
            }
            if($serviceRequest->status != 'SCHEDULED') {
                if($serviceConfig->manual_request == 0 && $serviceConfig->broadcast_request == 0) {
                    //Log::info('New Request id : '. $rideRequest->id .' Assigned to provider : '. $rideRequest->provider_id);
                    // (new SendPushNotification)->IncomingRequest($Providers[0]->id, 'service');
                }
            }   
            $serviceRequest->save();
            if($serviceConfig->manual_request == 1) {

                // $admins = Admin::select('id')->get();

                // foreach ($admins as $admin_id) {
                //     $admin = Admin::find($admin_id->id);
                //     //$admin->notify(new WebPush("Notifications", trans('api.push.incoming_request'), route('admin.dispatcher.index') ));
                // }

            }
            $serviceRequest = ServiceRequest::with('service','service.serviceCategory','service.servicesubCategory')->where('id', $serviceRequest->id)->first();
            //Add the Log File for ride
            $serviceRequestId = $serviceRequest->id;
            $user_request = new UserRequest();
            $user_request->request_id = $serviceRequest->id;
            $user_request->user_id = $serviceRequest->user_id;
            $user_request->provider_id = $serviceRequest->provider_id;
            $user_request->schedule_at = $serviceRequest->schedule_at;
            $user_request->company_id = $company_id;
            $user_request->admin_service ='SERVICE';
            $user_request->status = $serviceRequest->status;
            $user_request->request_data = json_encode($serviceRequest);
            $user_request->save();

            if($serviceRequest->status != 'SCHEDULED') {
                if($serviceConfig->manual_request == 0){
                    (new SendPushNotification)->IncomingRequest($Provider->id, 'service');
                    /* if($serviceConfig->broadcast_request == 1){
                       //(new SendPushNotification)->IncomingRequest($Provider->id, 'service'); 
                    }*/
                    $Filter = new RequestFilter;
                    // Send push notifications to the first provider
                    // incoming request push to provider
                    $Filter->admin_service = 'SERVICE';
                    $Filter->request_id = $user_request->id;
                    $Filter->provider_id = $provider_id; 
                    $Filter->company_id = $company_id; 
                    $Filter->save(); 
                }
                //Send message to socket
                $requestData = ['type' => 'SERVICE', 'room' => 'room_'.$company_id, 'id' => $serviceRequest->id, 'city' => ($setting->demo_mode == 0) ? $serviceRequest->city_id : 0, 'user' => $serviceRequest->user_id ];
                app('redis')->publish('newRequest', json_encode( $requestData ));
            }
            if( !empty($siteConfig->send_email) && $siteConfig->send_email == 1) {
                if( $siteConfig->mail_driver == 'SMTP') {
                    //  SEND OTP TO MAIL
                    $subject='Request|OTP';
                    $templateFile = 'mails/requestotp';
                    $toEmail = $User->email;
                    $data=['body' => $serviceRequest->otp, 'username' => $User->first_name];
                    $result= Helper::send_emails($templateFile, $toEmail, $subject, $data);               
                }
            }
            if( !empty($siteConfig->send_sms) && $siteConfig->send_sms == 1) {
                $smsMessage ='Your Otp to start the request is '.$serviceRequest->otp;
                $plusCodeMobileNumber = $User->mobile;
                // send OTP SMS here            
                Helper::send_sms($User->company_id, $plusCodeMobileNumber, $smsMessage);
            }
            return Helper::getResponse([ 'data' => [
                'message' => ($serviceRequest->status == 'SCHEDULED') ? 'Schedule request created!' : 'New request created!',
                'request_id' => $serviceRequest->id
            ]]);
        } catch (Exception $e) {  
            return Helper::getResponse(['status' => 500, 'message' => trans('api.service.request_not_completed'), 'error' => $e->getMessage() ]);
        }
    }

    public function cancel_service(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|numeric|exists:user_requests,request_id',
            'admin_service' => 'required|in:TRANSPORT,ORDER,SERVICE',
        ]);

        try{

            $newRequest = UserRequest::where('admin_service', 'SERVICE')->where('request_id', $request->id)->first();

            if($newRequest->status == 'CANCELLED')
            {
                return Helper::getResponse(['status' => 404, 'message' => trans('api.ride.already_cancelled')]);
            }

            if(in_array($newRequest->status, ['SEARCHING','STARTED','ARRIVED','SCHEDULED'])) {

                $admin_service = AdminService::find($request->service_id);

                if($request->admin_service == "TRANSPORT" ) { 

                    try {
                        $rideRequest = \App\Models\Transport\RideRequest::find($request->id);
                        $rideRequest->cancelled_by = 'ADMIN';
                        $rideRequest->status = 'CANCELLED';
                        $rideRequest->save();

                $setting = Setting::where('company_id', $rideRequest->company_id)->first();
                         
                         //Send message to socket
                $requestData = ['type' => 'TRANSPORT', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $rideRequest->city_id : 0, 'user' => $rideRequest->user_id ];
                app('redis')->publish('newRequest', json_encode( $requestData ));

                    } catch(\Throwable $e) { }
                    
                } else if ($request->admin_service == "ORDER") {
                     try {
                   $storeorder=\App\Models\Order\StoreOrder::find($request->id);
                   $storeorder->cancelled_by = 'ADMIN';
                   $storeorder->status = 'CANCELLED';
                   $storeorder->save();

                   $setting = Setting::where('company_id', $storeorder->company_id)->first();
                   
                   $requestData = ['type' => 'ORDER', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $request->city_id : 0, 'user' => $newRequest->user_id ];
                    app('redis')->publish('newRequest', json_encode( $requestData ));

                     } catch(\Throwable $e) { }
                } else if ($request->admin_service == "SERVICE") {
                     try {
                        $serviceRequest = \App\Models\Service\ServiceRequest::find($request->id);
                        $serviceRequest->cancelled_by = 'ADMIN';
                        $serviceRequest->status = 'CANCELLED';
                        $serviceRequest->save();

                        $setting = Setting::where('company_id', $serviceRequest->company_id)->first();
                   
                        $requestData = ['type' => 'ORDER', 'room' => 'room_'.Auth::user()->company_id, 'id' => $newRequest->id, 'city' => ($setting->demo_mode == 0) ? $request->city_id : 0, 'user' => $newRequest->user_id ];
                        app('redis')->publish('newRequest', json_encode( $requestData ));

                     } catch(\Throwable $e) { }
                }

                RequestFilter::where('admin_service', 'SERVICE' )->where('request_id', $newRequest->id)->delete();
                UserRequest::where('id',$newRequest->id)->delete();
                $newRequest->delete();
               return Helper::getResponse(['message' => trans('api.ride.ride_cancelled')]);

            } else {
                return Helper::getResponse(['status' => 403, 'message' => trans('api.ride.already_onride')]);
            }
        }

        catch (ModelNotFoundException $e) {
            return Helper::getResponse(['status' => 500, 'error' => $e->getMessage()]);
        }
    }
    public function create_order(Request $request)
    {
        if($request->has('email') &&  $request->email != null) $request->request->add(['email' => strtolower($request->email)]);
        $this->validate($request, [
            's_latitude' => 'required|numeric',
            's_longitude' => 'required|numeric',
            'country_code' => 'required|numeric',
            'country_id' => 'required',
            'city_id' => 'required',
            'productId'=>'required|unique:order.store_orders,productId',
            'package_description'=>'required',
            'number_of_packages'=>'required',
            'collectable_delivery_cost'=>'required'
        ]);
        $country = Country::find($request->country_id);
        $state = State::where('country_id', $country->id)->first();
        $timezone = $state->timezone;
        $currency = $country->country_currency;
        $mobile = $this->cusencrypt($request->mobile,env('DB_SECRET'));
        $email = $this->cusencrypt($request->email,env('DB_SECRET'));
        try {
            $User = User::where('mobile', $mobile)->firstOrFail();
        } catch (Exception $e) {
            try {
                $User = User::where('email', $email)->firstOrFail();
            } catch (Exception $e) {
                $User = User::create([
                    'company_id' => Auth::user()->company_id,
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'country_code' => $request->country_code,
                    'mobile' => $request->mobile,
                    'password' => Hash::make($request->mobile),
                    'country_id' => $request->country_id,
                    'state_id' => $state->id,
                    'city_id' => $request->city_id,
                    'currency' => $currency,
                    'payment_mode' => 'CASH'
                ]);
            }
        }
        $provider_id = $request->provider_id;
        $provider = Provider::find($provider_id);
        $company_id = $User->company_id; 
        $FilterCheck = RequestFilter::where(['admin_service'=>'ORDER','provider_id'=>$provider_id,'company_id'=>$company_id])->first();
        if($FilterCheck != null) {
            return Helper::getResponse(['status' => 422, 'message' => trans('api.ride.request_inprogress')]);
        }
        $ActiveRequests = ServiceRequest::PendingRequest($User->id)->count();
        if($ActiveRequests > 0) {
            return Helper::getResponse(['status' => 422, 'message' => trans('api.ride.request_inprogress')]);
        }
        $setting = Setting::where('company_id', Auth::user()->company_id)->first();
        $settings = json_decode(json_encode($setting->settings_data));
        $siteConfig = $settings->site;
        $serviceConfig = $settings->order;
        $timezone =  ($User->state_id) ? State::find($User->state_id)->timezone : '';
        $currency = CompanyCountry::where('company_id',$company_id)->where('country_id', $User->country_id)->first();
        if($request->has('schedule_date') && $request->has('schedule_time')){
            $schedule_date = (Carbon::createFromFormat('Y-m-d H:i:s', (Carbon::parse($request->schedule_date. ' ' .$request->schedule_time)->format('Y-m-d H:i:s')), $timezone))->setTimezone('UTC');
            \Log::info($schedule_date." time schedule");
            $beforeschedule_time = (new Carbon($schedule_date))->subHour(1);
            $afterschedule_time = (new Carbon($schedule_date))->addHour(1);
            $CheckScheduling = ServiceRequest::where('status','SCHEDULED')
                            ->where('user_id', $User->id)
                            ->whereBetween('schedule_at',[$beforeschedule_time,$afterschedule_time])
                            ->count();
            if($CheckScheduling > 0){
                return Helper::getResponse(['status' => 422, 'message' => trans('api.ride.request_already_scheduled')]);
            }
        }
        $distance = $serviceConfig->provider_search_radius ? $serviceConfig->provider_search_radius : 100;
        // $distance = config('constants.provider_search_radius', '10');
        $latitude =$request->s_latitude;
        $longitude = $request->s_longitude;
        $service_id = $request->service_id;
        $Provider = Provider::with('service','rating')
            ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id','first_name','picture')
            ->where('id', $provider_id)
            ->orderBy('distance','asc')
            ->first();
        try {
            $order = new StoreOrder();
            $order->latitude = $latitude;
            $order->longitude = $longitude;
            $order->productId = $request->productId;
            $order->package_description = $request->package_description;
            $order->number_of_packages = $request->number_of_packages;
            $order->collectable_delivery_cost = $request->collectable_delivery_cost;
            $order->qrcode_url = Helper::qrCode(json_encode(["productId" => $request->productId]), $request->productId.'.png', Auth::user()->company_id);
            $order->schedule_datetime = (new Carbon($schedule_date))->addMinutes(330);
            if($request->s_latitude) {
                $details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$request->s_latitude.",".$request->s_longitude."&mode=driving&key=".$siteConfig->server_key;
                // $order->delivery_address = json_encode($address_details);
                $json = Helper::curl($details);
                $details = json_decode($json, TRUE);
                $route_key = (count($details['routes']) > 0) ? $details['routes'][0]['overview_polyline']['points'] : '';
                $order->route_key = $route_key;
                $order->distance = (count($details['routes']) > 0) ? ($details['routes'][0]['legs'][0]['distance']['value'] ) : 0;
                $order->user_address_id = '1';
            }
            $order->description = isset($request->description)?$request->description:'';
            $bookingprefix = $serviceConfig->booking_prefix;
            $order->store_order_invoice_id = $bookingprefix.time().rand('0','999');
            if(!empty($payment_id)){
              $order->paid=1;
            }
            $order->user_id = $User->id;
            $order->assigned_at = (Carbon::now())->toDateTimeString();
            $order->order_type = $request->order_type;
            if($settings->order->manual_request==1){
                $order->request_type = 'MANUAL';
            }
            $order->order_otp = mt_rand(1000 , 9999);
            $order->leave_at_door = $request->payment_mode != 'CASH' && $request->order_type == 'DELIVERY' ? $request->leave_at_door : 0;
            $order->timezone = ($User->state_id) ? State::find($User->state_id)->timezone : '';
            $order->city_id = $User->city_id;
            $order->country_id = $User->country_id;
            $order->promocode_id = !empty($cart['promocode_id']) ? $cart['promocode_id']:0;
            if($request->has('delivery_date') && $request->delivery_date !=''){
                $order->delivery_date = Carbon::parse($request->delivery_date)->format('Y-m-d H:i:s');
                $order->schedule_status = 1;
            }
            $order->store_id = $request->shopName;
            $order->store_type_id = '6';
            $order->qrCode = 0;
            $order->admin_service = 'ORDER';
            $order->order_ready_status = 0;
            $order->company_id = 1;
            $order->currency = "$";
            $order->status = 'ORDERED';
            $order->order_type = 'TAKEAWAY';
            $order->pickup_address = $request->s_address;
            $order->save();
            if($order->id){
                // $store_commision_amount = ($cart['net']*($cart['store_commision_per']/100));
                // $orderinvoice = new StoreOrderInvoice();
                // $orderinvoice->store_order_id = $order->id;
                // $orderinvoice->store_id = $order->store_id;
                // $orderinvoice->payment_mode = $request->payment_mode;
                // $orderinvoice->payment_id = $payment_id;
                // $orderinvoice->company_id = 1;
                // $orderinvoice->item_price = $cart['total_item_price'];
                // $orderinvoice->gross = $cart['total_price'];
                // $orderinvoice->net = $cart['net'];
                // $orderinvoice->discount = $cart['shop_discount'];
                // $orderinvoice->promocode_id = $cart['promocode_id'];
                // $orderinvoice->promocode_amount = $cart['promocode_amount'];
                // $orderinvoice->wallet_amount = $cart['wallet_balance'];
                // $orderinvoice->tax_per = $cart['shop_gst'];
                // $orderinvoice->tax_amount = $cart['shop_gst_amount'];
                // $orderinvoice->commision_per = $cart['store_commision_per'];
                // $orderinvoice->commision_amount = $store_commision_amount;
                // /*$orderinvoice->delivery_per = $cart['total_price'];*/
                // if($request->order_type == 'DELIVERY') $orderinvoice->delivery_amount = $cart['delivery_charges']?$cart['delivery_charges']:0;
                // $orderinvoice->store_package_amount = $cart['shop_package_charge'];
                // $orderinvoice->total_amount = $cart['total_price'];
                // $orderinvoice->cash = $cart['payable'];
                // $orderinvoice->payable = $cart['payable'];
                // $orderinvoice->status = 0;
                // $orderinvoice->cart_details = json_encode($cart['carts']);
                // $orderinvoice->save();
                $orderstatus = new StoreOrderStatus();
                $orderstatus->company_id = '1';
                $orderstatus->store_order_id = $order->id;
                $orderstatus->status = 'ORDERED';
                $orderstatus->save();
                $store_details = 'test';
                // if($store_details->storetype->category == "OTHERS")
                // {
                //     foreach ($cart['carts'] as $value) {
                //         $storeitem = StoreItem::findOrFail($value->product->id);
                //         if(!empty($storeitem->quantity))
                //         {
                //             $total_quantity =$storeitem->quantity - $value->quantity;
                //             if($storeitem->low_stock >= $total_quantity)
                //             {
                //                 $Notifications = new Notifications;
                //                 $Notifications->notify_type = "shop";
                //                 $Notifications->user_id = $storeitem->store_id;
                //                 $Notifications->title = " Low stock";   
                //                 $Notifications->service = "ORDER";  
                //                 $Notifications->company_id = Auth::guard('user')->user()->company_id;
                //                 $Notifications->descriptions = $storeitem->item_name." is lesser than stock limit. Please add in inventory";
                //                 $Notifications->save();
                //             }
                //             $storeitem->quantity = $total_quantity;
                //         }else
                //         {
                //             $Notifications = new Notifications;
                //             $Notifications->notify_type = "shop";
                //             $Notifications->user_id = $storeitem->store_id;
                //             $Notifications->title = " Low stock";   
                //             $Notifications->service = "ORDER";  
                //             $Notifications->company_id = Auth::guard('user')->user()->company_id;
                //             $Notifications->descriptions = $storeitem->item_name." is not available";
                //             $Notifications->save();
                //             $storeitem->status =0;
                //         }
    
                //         $storeitem->save();
                //     }
                // }
    
                //$User = User::find($this->user->id);
                // $Wallet = Auth::guard('user')->user()->wallet_balance;
                //$Total = 
                //
                // if($cart['wallet_balance'] > 0){
                //     // charged wallet money push 
                //     // (new SendPushNotification)->ChargedWalletMoney($UserRequest->user_id,$Wallet, 'wallet');
                //     (new SendPushNotification)->ChargedWalletMoney($this->user->id,Helper::currencyFormat($cart['wallet_balance'],Auth::guard('user')->user()->currency_symbol), 'wallet', 'Wallet Info');
    
                //     $transaction['amount']=$cart['wallet_balance'];
                //     $transaction['id']=$this->user->id;
                //     $transaction['transaction_id']=$order->id;
                //     $transaction['transaction_alias']=$order->store_order_invoice_id;
                //     $transaction['company_id']=$this->company_id;
                //     $transaction['transaction_msg']='order deduction';
                //     $transaction['admin_service']=$order->admin_service;
                //     $transaction['country_id']=$order->country_id;
    
                //     (new Transactions)->userCreditDebit($transaction,0);
                // }
                //user request
                $user_request = new UserRequest();
                $user_request->company_id = '1';
                $user_request->user_id = $User->id;
                $user_request->request_id = $order->id;
                $user_request->request_data = json_encode(StoreOrder::with('invoice', 'store.storetype')->where('id',$order->id)->first());
                $user_request->admin_service = 'ORDER';
                $user_request->status = 'SEARCHING';
                $user_request->save();
    
                // $CartItem_ids  = StoreCart::where('company_id',$this->company_id)->where('user_id',$this->user->id)->pluck('id','id')->toArray();
                // $CartItems  = StoreCart::where('company_id',$this->company_id)->where('user_id',$this->user->id)->delete();
    
                if($order->promocode_id != null) {
                    $PromocodeUsage = new PromocodeUsage;
                    $PromocodeUsage->user_id = $this->user->id;
                    $PromocodeUsage->company_id = $this->company_id;
                    $PromocodeUsage->promocode_id = $order->promocode_id;
                    $PromocodeUsage->status = 'USED';
                    $PromocodeUsage->save();
                }
                // StoreCartItemAddon::whereIN('store_cart_id',$CartItem_ids)->delete();
                $schedule_status = 1;
                //Send message to socket
                $requestData = ['type' => 'ORDER', 'room' => 'room_'.'1', 'id' => $order->id,'shop'=> 1, 'user' => $order->user_id ];
                app('redis')->publish('newRequest', json_encode( $requestData ));
                (new SendPushNotification)->ShopRequest($order->store_id, $order->admin_service); 
                return Helper::getResponse([ 'data' => [
                    'message' => 'Order request created!',
                    'request_id' => $order->id
                ]]);
                // return  $this->orderdetails($order->id);
            }

        } catch (Exception $e) {  
            \Log::info($e);
            return Helper::getResponse(['status' => 500, 'message' => trans('api.service.request_not_completed'), 'error' => $e->getMessage() ]);
        }
    }







    public function fare(Request $request){

        $this->validate($request,[
                's_latitude' => 'required|numeric',
                's_longitude' => 'numeric',
                'd_latitude' => 'required|numeric',
                'd_longitude' => 'numeric',
                'provider_service' => 'required',
            ]);

        $settings = json_decode(json_encode(Setting::where('company_id', Auth::user()->company_id)->first()->settings_data));

        $siteConfig = $settings->site;

        $transportConfig = $settings->transport;

        try {
            if($request->admin_service == "TRANSPORT" ) {
                $newRequest = \App\Models\Transport\RideRequest::find($request->id);
            }
        } catch(\Throwable $e) { }

        try{
            $geofence =(new UserServices())->poly_check_request((round($request->s_latitude,6)),(round($request->s_longitude,6)), $request->city);  

            if($geofence == false) {
                return ['status' => 400, 'message' => trans('user.ride.service_not_available_location'), 'error' => trans('user.ride.service_not_available_location')];
            } 

            $response = new Ride();
            $request->request->add(['server_key' => $siteConfig->server_key]);
            $request->request->add(['service_type' => $request->provider_service]);
            $request->request->add(['city_id' => $request->city]);
            $request->request->add(['company_id' => Auth::user()->company_id]);
            $request->request->add(['geofence_id' => $geofence['id']]);
            $responsedata=$response->calculateFare($request->all(),1);

            if(!empty($responsedata['errors'])){
                throw new Exception($responsedata['errors']);
            }
            else{
                return response()->json($responsedata['data']);
            }

        } catch(Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function providerServiceList(Request $request)
    {
        $settings = json_decode(json_encode(Setting::where('company_id', Auth::user()->company_id)->first()->settings_data));

        $siteConfig = $settings->site;
        $serviceConfig = $settings->service;

        $distance = $serviceConfig->provider_search_radius ? $serviceConfig->provider_search_radius : 100;
       
        $latitude = $request->lat;
        $longitude = $request->long;
        $service_id = $request->id;
        
        //$timezone =  (Auth::user()->state_id) ? State::find(Auth::user()->state_id)->timezone : '';
        // $currency =  Country::find(Auth::user()->country_id) ? Country::find(Auth::user()->country_id)->country_currency : '' ;

        $currency = CompanyCountry::where('company_id',Auth::user()->company_id)->where('country_id',Auth::user()->country_id)->first();
        // $service_cancel_provider = ServiceCancelProvider::select('id','provider_id')->where('company_id',Auth::user()->company_id)->where('user_id',Auth::user()->id)->pluck('provider_id','provider_id')->toArray();

        $callback = function ($q) use ($service_id) {
            $q->where('admin_service','SERVICE');
            $q->where('service_id',$service_id);
        };

  
        $provider_service_init = Provider::with(['service'=> $callback,'service_city','request_filter'])
        ->select(DB::Raw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) AS distance"),'id','first_name','picture','rating','city_id','latitude','longitude')
        ->where('status', 'approved')
        ->where('is_online',1)->where('is_assigned',0)
        ->where('company_id', Auth::user()->company_id)
        ->whereRaw("(6371 * acos( cos( radians('$latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$longitude') ) + sin( radians('$latitude') ) * sin( radians(latitude) ) ) ) <= $distance")
        ->whereDoesntHave('request_filter')
        ->whereHas('service', function($q) use ($service_id){          
            $q->where('admin_service','SERVICE');
            $q->where('service_id',$service_id);
        });
        if($request->has('name')){
            $provider_service_init->where('first_name','LIKE', '%' . $request->name . '%');
            //$provider_service_init->orderBy('first_name','asc');
        }
        $provider_service_init->orderBy('distance','asc');
        

        // $provider_service_init->whereNotIn('id',$service_cancel_provider);
        $provider_service = $provider_service_init->get();

        if($provider_service){
            $providers = [];
            if(!empty($provider_service[0]->service)){
                $serviceDetails=Service::with('serviceCategory')->where('id',$service_id)->where('company_id',Auth::user()->company_id)->first();
                foreach($provider_service as $key=> $service){ 
                    unset($service->request_filter);
                    $provider = new \stdClass();
                    $provider->distance=$service->distance;
                    $provider->id=$service->id;
                    $provider->first_name=$service->first_name;
                    $provider->picture=$service->picture;
                    $provider->rating=$service->rating;
                    $provider->city_id=$service->city_id;
                    $provider->latitude=$service->latitude;
                    $provider->longitude=$service->longitude;
                    if($service->service_city==null){
                        $provider->fare_type='FIXED';
                        $provider->base_fare='0';
                        $provider->per_miles='0';
                        $provider->per_mins='0';
                        $provider->price_choose='';
                    }
                    else{
                        $provider->fare_type=$service->service_city->fare_type;
                        if($serviceDetails->serviceCategory->price_choose=='admin_price'){
                           if(!empty($request->qty))
                               $provider->base_fare=Helper::decimalRoundOff($service->service_city->base_fare*$request->qty);
                           else
                               $provider->base_fare=Helper::decimalRoundOff($service->service_city->base_fare);

                           $provider->per_miles=Helper::decimalRoundOff($service->service_city->per_miles);
                           $provider->per_mins=Helper::decimalRoundOff($service->service_city->per_mins*60);
                       }
                       else{
                           if(!empty($request->qty))
                               $provider->base_fare=Helper::decimalRoundOff($service->service->base_fare*$request->qty);
                           else
                               $provider->base_fare=Helper::decimalRoundOff($service->service->base_fare);

                           $provider->per_miles=Helper::decimalRoundOff($service->service->per_miles);
                           $provider->per_mins=Helper::decimalRoundOff($service->service->per_mins*60);
                       }

                        $provider->price_choose=$serviceDetails->serviceCategory->price_choose;
                    }    

                    $providers[] = $provider;
                }

            }

            return Helper::getResponse(['data' =>['provider_service' => $providers,'currency' => ($currency != null) ? $currency->currency: '']]);

        }
    }

}
