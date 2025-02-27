<?php 

namespace App\Services\V1\Delivery;

use Illuminate\Http\Request;
use Validator;
use Exception;
use DateTime;
use Carbon\Carbon;
use Auth;
use Lang;
use App\Helpers\Helper;
use GuzzleHttp\Client;
use App\Models\Common\Card;
use App\Models\Common\User;
use App\Models\Common\State;
use App\Models\Common\Admin;
use App\Models\Delivery\Delivery;
use App\Models\Delivery\DeliveryRequest;
use App\Models\Common\CompanyCountry;
use App\Models\Delivery\DeliveryPayment;
use App\Models\Transport\RideRequestWaitingTime;
use App\Models\Delivery\DeliveryCityPrice;
use App\Models\Transport\RidePeakPrice;
use App\Services\SendPushNotification;
use App\Models\Common\PromocodeUsage;
use App\Models\Common\Promocode;
use App\Models\Common\AdminWallet;
use App\Models\Common\PeakHour;
use App\Models\Common\Setting;
use App\Services\Transactions;
use App\Services\V1\Common\UserServices;
use App\Services\V1\Common\ProviderServices;
use App\Models\Common\UserRequest;
use App\Models\Common\GeoFence;
use App\Models\Common\Chat;
use App\Traits\Actions;
use Illuminate\Support\Facades\Mail;
use Storage;

class DeliveryService { 

	use Actions;

	/**
		* Get a validator for a tradepost.
		*
		* @param  array $data
		* @return \Illuminate\Contracts\Validation\Validator
	*/
	protected function validator(array $data) {
		$rules = [
			'location'  => 'required',
		];

		$messages = [
			'location.required' => 'Location Required!',
		];

		return Validator::make($data,$rules,$messages);
	}

   
	public function createRide(Request $request) {
		\Log::info($request->all());

			$delivery_city_price = DeliveryCityPrice::where('delivery_vehicle_id', $request->service_type)->first();

			if ($delivery_city_price == null) {
				return ['status' => 400, 'message' => trans('user.delivery.service_not_available_location'), 'error' => trans('user.delivery.service_not_available_location')];
			}

			$credit_delivery_limit = isset($this->settings->delivery->credit_delivery_limit) ? $this->settings->delivery->credit_delivery_limit : 0;
			\Log::info('credit limit:'.$credit_delivery_limit);

			$ActiveRequests = DeliveryRequest::PendingRequest($this->user->id)->count();

			if ($ActiveRequests > $credit_delivery_limit) {
				return ['status' => 422, 'message' => trans('api.delivery.request_inprogress')];
			}

			$timezone =  (Auth::guard('user')->user()->state_id) ? State::find($this->user->state_id)->timezone : '';

			$country =  CompanyCountry::where('country_id', $this->user->country_id)->first();

			$currency =  ($country != null) ? $country->currency : '';

			if ($request->has('schedule_date') && $request->schedule_date != "" && $request->has('schedule_time') && $request->schedule_time != "") {

				$schedule_date = (Carbon::createFromFormat('Y-m-d H:i:s', (Carbon::parse($request->schedule_date . ' ' . $request->schedule_time)->format('Y-m-d H:i:s')), $timezone))->setTimezone('UTC');


				$beforeschedule_time = (new Carbon($schedule_date))->subHour(1);
				$afterschedule_time = (new Carbon($schedule_date))->addHour(1);


				$CheckScheduling = DeliveryRequest::where('status', 'SCHEDULED')
					->where('user_id', $this->user->id)
					->whereBetween('schedule_at', [$beforeschedule_time, $afterschedule_time])
					->count();


				if ($CheckScheduling > 0) {
					return ['status' => 422, 'message' => trans('api.delivery.request_already_scheduled')];
				}
			}

			$distance = $this->settings->delivery->provider_search_radius ? $this->settings->delivery->provider_search_radius : 100;

			$d_latitude = $request->d_latitude;
			$d_longitude = $request->d_longitude;
			$d_address = $request->d_address;
			$package_type = $request->package_type_id;
			\Log::info($package_type);
			$receiver_name = $request->receiver_name;
			$receiver_mobile = $request->receiver_mobile;
			$receiver_instruction = $request->receiver_instruction;
			$weight = $request->weight;
			$is_fragile = $request->is_fragile;

			$location_distance=$this->getLocationDistance($request);


			//$distance = $request->distance;

			$request->request->add(['latitude' => $request->s_latitude]);
			$request->request->add(['longitude' => $request->s_longitude]);

			$request->request->add(['distance' => $distance]);
			$request->request->add(['provider_negative_balance' => $this->settings->site->provider_negative_balance]);

			$callback = function ($q) use ($request) {
				$q->where('admin_service', 'DELIVERY');
				$q->where('delivery_vehicle_id', $request->service_type);
			};

			$withCallback = ['service' => $callback, 'service.delivery_vehicle'];
			$whereHasCallback = ['service' => $callback];


			$Providers = (new UserServices())->availableProviders($request, $withCallback, $whereHasCallback, 'delivery');

			\Log::info($Providers);

			if (count($Providers) == 0) {
				return ['status' => 422, 'message' => trans('api.delivery.no_providers_found')];
			}

			$locations = [];
			$total_weight = 0;
			$total_distance = 0;

			\Log::info($request->all());
			foreach ($d_latitude  as $key => $d_lat) {
				$location = new \stdClass;
				$location->d_latitude = $request->d_latitude[$key];
				$location->d_longitude = $request->d_longitude[$key];
				$location->d_address = $request->d_address[$key];
				$location->package_type_id = $request->package_type_id[$key];
				$location->receiver_name = $request->receiver_name[$key];
				$location->receiver_mobile =  $request->receiver_mobile[$key];
				$location->receiver_instruction = $request->receiver_instruction[$key];
				$location->weight = $request->weight[$key];
				$location->device_type = $request->device_type;
				// $location->length = $request->length[$key];
				// $location->breadth = $request->breadth[$key];
				// $location->height = $request->height[$key];
				$location->is_fragile = $request->is_fragile[$key];
				if(isset($location_distance['data']) && isset($location_distance['data'][$key])) 
					$location->distance = $location_distance['data'][$key]['distance'];

					
				if(isset($request->picture[$key])) {
					$location->picture = $request->picture[$key];
				} else {
					$location->picture = "";
				}
				$locations[] = $location;

				$total_weight += $request->weight[$key];
				if(isset($location_distance['data']) && isset($location_distance['data'][$key]))
				$total_distance += $location_distance['data'][$key]['distance'];
	
			}

			usort($locations, function($a, $b) { return $a->distance > $b->distance; });

			$location_list = $locations;

			$destination = array_pop($location_list);

			$waypoints = [];

			foreach ($location_list as $key => $list) {
				$waypoints[] = $list->d_latitude.',' .$list->d_longitude;
			}

			try {
				
				$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$request->s_latitude.",".$request->s_longitude."&destination=".$destination->d_latitude.",".$destination->d_longitude."&waypoints=" . implode('|', $waypoints )."&mode=driving&key=".$this->settings->site->server_key;

				$json = Helper::curl($details);

				$details = json_decode($json, TRUE);

				$route_key = (count($details['routes']) > 0) ? $details['routes'][0]['overview_polyline']['points'] : '';

				$deliveryRequest = new DeliveryRequest;
				$deliveryRequest->company_id = $this->company_id;
				$deliveryRequest->admin_service = 'DELIVERY';
				$prefix = $this->settings->delivery->booking_prefix;
				$deliveryRequest->booking_id = Helper::generate_booking_id($prefix);
				$deliveryRequest->user_id = $this->user->id;
				$deliveryRequest->provider_service_id = $request->service_type;
				$deliveryRequest->delivery_mode = count($request->d_latitude) > 1 ? 'MULTIPLE' : 'SINGLE';
				$deliveryRequest->delivery_vehicle_id = $request->service_type;
				$deliveryRequest->delivery_type_id = $request->delivery_type_id;
				$deliveryRequest->distance = ($this->settings->delivery->unit_measurement=='Kms') ? round($total_distance/1000,1) : round($total_distance/1609.344,1) ;
				$deliveryRequest->payment_mode = $request->payment_mode;
				$deliveryRequest->promocode_id = $request->promocode_id ?: 0;
				$deliveryRequest->status = 'SEARCHING';
				$deliveryRequest->timezone = $timezone;
				$deliveryRequest->currency = $currency;
				if ($this->settings->delivery->manual_request == "1") $deliveryRequest->request_type = "MANUAL";
				$deliveryRequest->country_id = $this->user->country_id;
				$deliveryRequest->city_id = $this->user->city_id;
				$deliveryRequest->s_address = $request->s_address ? $request->s_address : "";
				$deliveryRequest->s_latitude = $request->s_latitude;
				$deliveryRequest->s_longitude = $request->s_longitude;
				$deliveryRequest->payment_by = $request->payment_by;
				//$deliveryRequest->d_latitude = $request->d_latitude;
				//$deliveryRequest->d_longitude = $request->d_longitude;
				//$deliveryRequest->d_address = $request->d_address ? $request->d_address  : "";
				$deliveryRequest->track_distance = 1;
				$deliveryRequest->track_latitude = $request->s_latitude;
				$deliveryRequest->track_longitude = $request->s_longitude;

				//$deliveryRequest->destination_log = json_encode([['latitude' => $deliveryRequest->d_latitude, 'longitude' => $request->d_longitude, 'address' => $request->d_address]]);
				$deliveryRequest->unit = isset($this->settings->site->distance) ? $this->settings->site->distance : 'Kms';
				$deliveryRequest->weight = $total_weight;
				if ($this->user->wallet_balance > 0) $deliveryRequest->use_wallet = $request->use_wallet ?: 0;

				//$deliveryRequest->otp = $otp;
				$deliveryRequest->assigned_at = (Carbon::now())->toDateTimeString();
				$deliveryRequest->route_key = $route_key;
				if ($Providers->count() <= (isset($this->settings->delivery->surge_trigger) ? $this->settings->delivery->surge_trigger : 0) && $Providers->count() > 0) {
					$deliveryRequest->surge = 1;
				}

				if ($request->has('schedule_date') && $request->schedule_date != "" && $request->has('schedule_time') && $request->schedule_time != "") {
					$deliveryRequest->status = 'SCHEDULED';
					$deliveryRequest->schedule_at = (Carbon::createFromFormat('Y-m-d H:i:s', (Carbon::parse($request->schedule_date . ' ' . $request->schedule_time)->format('Y-m-d H:i:s')), $timezone))->setTimezone('UTC');
					$deliveryRequest->is_scheduled = 'YES';
				}

				$deliveryRequest->save();

				// update payment mode
				User::where('id', $this->user->id)->update(['payment_mode' => $request->payment_mode]);

				if ($request->has('card_id')) {
					Card::where('user_id', Auth::guard('user')->user()->id)->update(['is_default' => 0]);
					Card::where('card_id', $request->card_id)->update(['is_default' => 1]);
				}



				foreach ($locations as $key => $location) {

					
					$delivery = new Delivery;
					$delivery->delivery_request_id = $deliveryRequest->id;
					$delivery->package_type_id = $location->package_type_id;
				    $delivery->admin_service = 'DELIVERY';
					//$delivery->provider_id = $deliveryRequest->provider_id;
					//--$delivery->geofence_ida
					$delivery->status = 'PROCESSING';
					//$delivery->paid
					$delivery->distance = $location->distance;
					$delivery->weight = $location->weight;
					// $delivery->length = $location->length;
					// $delivery->breadth =$location->breadth;
					// $delivery->height = $location->height;
					//$delivery->location_points
					//--$delivery->timezone
					//$delivery->travel_time
					//--$delivery->s_address
					//--$delivery->s_latitude
					//--$delivery->s_longitude
					$delivery->name = $location->receiver_name;
					$delivery->mobile = $location->receiver_mobile;
					$delivery->instruction = $location->receiver_instruction;
					$delivery->d_address = $location->d_address;
					$delivery->d_latitude = $location->d_latitude;
					$delivery->d_longitude = $location->d_longitude;
					$delivery->is_fragile = $location->is_fragile;
					// if($location->picture != "") $delivery->picture = $location->picture->store('deliveries');
					if($location->device_type != "" && $location->device_type == "web") {
						if($location->picture != "") {
							\Log::info('image controller');
							\Log::info($location->picture);
						$image = $location->picture;  // your base64 encoded
						$image = str_replace('data:image/jpeg;base64,', '', $image);
						$image = str_replace(' ', '+', $image);
						
						$imagePath= str_random(10) . '.jpeg';
						//$imagePath1= 'storage/deliveries/'.str_random(10) . '.jpeg';

                        Storage::disk('public')->put($imagePath, base64_decode($image));
						
						$delivery->picture = url().'/storage/'.$imagePath;

						// $delivery->picture = url().'/storage/'.$location->picture->store('deliveries');
						}

					}else{
						if($location->picture != "") $delivery->picture = $location->picture->store('deliveries');

					}
					
					//$delivery->track_distance
					//$delivery->destination_log
					$delivery->unit = isset($this->settings->site->distance) ? $this->settings->site->distance : 'Kms';
					//--$delivery->currency
					//$delivery->track_latitude
					//$delivery->track_longitude
					$delivery->otp = mt_rand(1000, 9999);
					$delivery->assigned_at = (Carbon::now())->toDateTimeString();
					//--$delivery->schedule_at
					//$delivery->started_at
					//$delivery->finished_at
					//--$delivery->surge
					//$delivery->route_key = $route_key;
					//--$delivery->admin_id
					$delivery->save();



					$delivery = Delivery::with('delivery_vehicle')->where('id', $delivery->id)->first();

					$delivery->company_id = $deliveryRequest->company_id;
					$delivery->admin_service = $deliveryRequest->admin_service;
					$delivery->user_id = $deliveryRequest->user_id;
					$delivery->assigned_at = $deliveryRequest->assigned_at;
					$delivery->schedule_at = $deliveryRequest->schedule_at;
					$delivery->city_id = $deliveryRequest->city_id;

					
				}
				$deliveryRequest = DeliveryRequest::with('deliveries','deliveries.package_type','delivery.package_type','service')->where('id', $deliveryRequest->id)->first();
				(new UserServices())->createRequest($Providers, $deliveryRequest, 'DELIVERY');


			return ['message' => ($deliveryRequest->status == 'SCHEDULED') ? 'Schedule request created!' : 'New request created!', 'data' => [
				'message' => ($deliveryRequest->status == 'SCHEDULED') ? 'Schedule request created!' : 'New request created!',
				'request' => $deliveryRequest->id
			]];
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}

	}

	public function cancelRide($request) {

		try{

			$delivery_request = DeliveryRequest::findOrFail($request->id);
			
			if($delivery_request->status == 'CANCELLED')
			{
				return ['status' => 404, 'message' => trans('api.ride.already_cancelled')];
			}

			if(in_array($delivery_request->status, ['SEARCHING','STARTED','ARRIVED','SCHEDULED'])) {

				if($delivery_request->status != 'SEARCHING'){

					$validator = Validator::make($request->all(), [
						'cancel_reason'=> 'max:255',]);

					if ($validator->fails()) {

						$errors = [];
						foreach (json_decode( $validator->errors(), true ) as $key => $error) {
						   $errors[] = $error[0];
						}

						header("Access-Control-Allow-Origin: *");
						header("Access-Control-Allow-Headers: *");
						header('Content-Type: application/json');
						http_response_code(422);
						echo json_encode(Helper::getResponse(['status' => 422, 'message' => !empty($errors[0]) ? $errors[0] : "",  'error' => !empty($errors[0]) ? $errors[0] : "" ])->original);
						exit;
					}
				}

				$delivery_request->status = 'CANCELLED';
				$delivery_request->save();

				$delivery_request->status = 'CANCELLED';
				if($request->cancel_reason=='ot')
					$delivery_request->cancel_reason = $request->cancel_reason_opt;
				else
					$delivery_request->cancel_reason = $request->cancel_reason;

				$delivery_request->cancelled_by = $request->cancelled_by;
				$delivery_request->save();

				$request->request->add(['admin_service' => 'DELIVERY']);
				if($request->cancelled_by == "PROVIDER") {
					if($this->settings->delivery->broadcast_request == 1){
						(new ProviderServices())->cancelRequest($request);
						(new SendPushNotification)->ProviderCancelRide($delivery_request,'delivery');
						return ['status' => 200, 'message' => trans('api.ride.request_rejected') ];
					 }else{
					 	(new ProviderServices())->cancelRequest($request);
					 	(new SendPushNotification)->ProviderCancelRide($delivery_request,'delivery');
						return ['status' => 200, 'message' => trans('api.ride.request_rejected') ];
						// (new ProviderServices())->assignNextProvider($delivery_request->id, $delivery_request->admin_service );
						// return ['status' => 200, 'message' => trans('api.ride.request_rejected'),'data' => $delivery_request->with('user')->get() ];
					 }
				} else {
					(new UserServices())->cancelRequest($delivery_request);
					(new SendPushNotification)->UserCancelRide($delivery_request->provider_id,'delivery');
				}

				return ['status' => 200, 'message' => trans('api.ride.ride_cancelled')];

			} else {

				return ['status' => 403, 'message' => trans('api.ride.already_onride')];
			}
		}

		catch (ModelNotFoundException $e) {
			return $e->getMessage();
		}
	}


	public function updateRide(Request $request) { 

		//try{

			$ride_otp = $this->settings->delivery->otp;

			$delivery = Delivery::with(['user', 'payment'])->findOrFail($request->id);


			$delivery_request = DeliveryRequest::with('user','deliveries','deliveries.package_type','delivery.package_type')->findOrFail($delivery->delivery_request_id);


			$user_request = UserRequest::where('request_id', $delivery_request->id)->where('admin_service', 'DELIVERY')->first();
		

			

			if($request->status == 'ARRIVED'){

				/*if($delivery_request->payment_by == 'RECEIVER') {
					$delivery->status = 'STARTED';
					$delivery->started_at = Carbon::now();
					$delivery->save();
				}*/ 
				
				if($this->settings->transport->ride_otp==1 && $delivery_request->created_type != "ADMIN"){
					if(isset($request->otp) && $delivery_request->request_type != "MANUAL"){
						if($request->otp == $delivery_request->otp){
							$delivery_request->started_at = Carbon::now();
							// (new SendPushNotification)->Pickedup($delivery_request, 'delivery');
						}else{
							header("Access-Control-Allow-Origin: *");
							header("Access-Control-Allow-Headers: *");
							header('Content-Type: application/json');
							http_response_code(400);
							echo json_encode(Helper::getResponse(['status' => 400, 'message' => trans('api.otp'), 'data'=>$delivery_request,  'error' => trans('api.otp')])->original);
							exit;
						}
					}else{
						$delivery_request->started_at = Carbon::now();
						// (new SendPushNotification)->Pickedup($delivery_request, 'delivery');
					}
				}else{
					$delivery_request->started_at = Carbon::now();
					// (new SendPushNotification)->Pickedup($delivery_request, 'delivery');
				}

				$delivery_request->status = 'ARRIVED';
				$delivery_request->save();

				
				$deliveries = Delivery::where('delivery_request_id', $delivery_request->id)->get();

				foreach ($deliveries as $key => $value) {
					$reqnumber = ($key == 0) ? 1 : 0;	//Here We are adding basefare for the first reuqest alone. So we are set flag.
					$this->invoice($value->id,0,$reqnumber);
					// $this->invoice($value->id,0,0);
				}
				// if($delivery_request->use_wallet == 1)
				// {
				// 	$request->status = 'PAYMENT';
				// }
				(new SendPushNotification)->DeliveryArrived($delivery_request, 'delivery');
				
			}

			if($request->status == 'PICKEDUP'){

				if($delivery_request->payment_by == 'RECEIVER' && $delivery_request->payment_mode == 'CASH') {
					$delivery->status = 'STARTED';
					$delivery->started_at = Carbon::now();
					$delivery->save();

					(new SendPushNotification)->Pickedup($delivery_request, 'delivery');

				}

				$delivery_request->status = 'PICKEDUP';
				$delivery_request->save();
			}

			if($request->status == 'PAYMENT'){

				if($delivery_request->payment_by == 'SENDER' && $delivery_request->payment_mode == 'CASH') {
					$delivery->status = 'STARTED';
					$delivery->started_at = Carbon::now();
					$delivery->save();

					$delivery_request->paid = '1';
					$delivery_request->save();


					Delivery::where('delivery_request_id', $delivery_request->id)->update(array('paid' => 1));

					if(($delivery_request->payable_amount != 0)) {
						(new SendPushNotification)->DeliveryPayment($delivery_request, 'delivery');
					}

				}

				
				/*if($this->settings->transport->ride_otp==1 && $delivery_request->created_type != "ADMIN"){
					if(isset($request->otp) && $delivery_request->request_type != "MANUAL"){
						if($request->otp == $delivery_request->otp){
							$delivery_request->started_at = Carbon::now();
							(new SendPushNotification)->Pickedup($delivery_request, 'delivery');
						}else{
							header("Access-Control-Allow-Origin: *");
							header("Access-Control-Allow-Headers: *");
							header('Content-Type: application/json');
							http_response_code(400);
							echo json_encode(Helper::getResponse(['status' => 400, 'message' => trans('api.otp'), 'data'=>$delivery_request,  'error' => trans('api.otp')])->original);
							exit;
						}
					}else{
						$delivery_request->started_at = Carbon::now();
						(new SendPushNotification)->Pickedup($delivery_request, 'delivery');
					}
				}else{
					$delivery_request->started_at = Carbon::now();
					(new SendPushNotification)->Pickedup($delivery_request, 'delivery');
				}*/

				$delivery_request->status = 'PICKEDUP';
				$delivery_request->save();
			}

			$user_request->save();

			//$delivery->save();

			if($delivery_request->status == 'DROPPED' && $delivery_request->payment_mode != 'CASH') {
					$delivery->status = 'COMPLETED';
					//$delivery->paid = 0;
					$delivery->save();
					(new SendPushNotification)->Complete($delivery_request, 'delivery');
			} else if ($request->status == 'COMPLETED' && $delivery_request->payment_by == 'RECEIVER') {
				
				if($delivery->status=='COMPLETED'){
					//for off cross clicking on change payment issue on mobile
					return true;
				}
				
				$delivery->status = $request->status;
				$delivery->paid = 1;                
				$delivery->save();
				(new SendPushNotification)->Complete($delivery_request, 'delivery');

				$nextDelivery = Delivery::where('delivery_request_id', $delivery_request->id)->where('status', 'PROCESSING')->first();

				if($nextDelivery) {
					$nextDelivery->status = 'STARTED';
					$nextDelivery->started_at = (Carbon::now())->toDateTimeString();
					$nextDelivery->save();
				} else {
					$delivery_request->paid = '1';
					$delivery_request->save();

					//(new SendPushNotification)->Payment($delivery_request, 'delivery');
				}

			} else if ($request->status == 'COMPLETED' && $delivery_request->payment_by == 'SENDER') {
				
				if($delivery->status=='COMPLETED'){
					//for off cross clicking on change payment issue on mobile
					return true;
				}
				
				$delivery->status = $request->status;
				$delivery->paid = 1;                
				$delivery->save();
				(new SendPushNotification)->DeliveryComplete($delivery_request, 'delivery');
				
				$nextDelivery = Delivery::where('delivery_request_id', $delivery_request->id)->where('status', 'PROCESSING')->first();

				if($nextDelivery) {
					$nextDelivery->status = 'STARTED';
					$nextDelivery->started_at = (Carbon::now())->toDateTimeString();
					$nextDelivery->save();
				}
			}



			$deliveries = Delivery::with('payment')->where('status', '<>', 'COMPLETED')->where('delivery_request_id', $delivery_request->id)->get();

            if(count($deliveries) == 0){

            	$delivery_payment = Delivery::with('payment')->where('delivery_request_id', $delivery_request->id)->get();

            	$total_amount = 0;
            	$payable_amount = 0;
            	$total_distance = 0;

            	foreach ($delivery_payment as $key => $value) {
            		if($value->payment != null){
            			$total_amount += $value->payment->total;
						$payable_amount += $value->payment->provider_pay;
						$total_distance += $value->distance;

            		}
            	}


				$delivery_request->status = 'COMPLETED';
				$delivery_request->finished_at = Carbon::now();
				$StartedDate  = date_create($delivery_request->started_at);
				$FinisedDate  = Carbon::now();
				$TimeInterval = date_diff($StartedDate,$FinisedDate);
				$MintuesTime  = $TimeInterval->i;
				$delivery_request->travel_time = $MintuesTime;
				$delivery_request->total_amount = $total_amount;
				$delivery_request->payable_amount = $payable_amount;
				$delivery_request->distance = $total_distance;

				$delivery_request->save();
            }




			$user_request->provider_id = $delivery_request->provider_id;
			$user_request->status = $delivery_request->status;
			$user_request->request_data = json_encode($delivery_request);

			$user_request->save();


			if($delivery_request->use_wallet != 1 && $delivery_request->payment_mode == 'CASH' && $delivery_request->status == 'COMPLETED'){
				 (new \App\Http\Controllers\V1\Delivery\Provider\TripController)->callTransaction($delivery_request->id);
			}


			if($request->status == 'DROPPED') {

				$waypoints = [];

				$chat=Chat::where('admin_service', 'DELIVERY')->where('request_id', $delivery_request->id)->where('company_id', Auth::guard('provider')->user()->company_id)->first();

				if($chat != null) {
					$chat->delete();
				}

				if($request->has('distance')) {
					$delivery->distance  = ($request->distance / 1000); 
				}

				if($request->has('location_points')) {

					foreach($request->location_points as $locations) {
						$waypoints[] = $locations['lat'].",".$locations['lng'];
					}

					$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$delivery_request->s_latitude.",".$delivery_request->s_longitude."&destination=".$request->latitude.",".$request->longitude."&waypoints=" . implode($waypoints, '|')."&mode=driving&key=".$siteConfig->server_key;

					$json = Helper::curl($details);

					$details = json_decode($json, TRUE);

					$route_key = (count($details['routes']) > 0) ? $details['routes'][0]['overview_polyline']['points'] : '';

					$delivery->route_key = $route_key;
					$delivery->location_points = json_encode($request->location_points);
				}
				
				$delivery->finished_at = Carbon::now();
				$StartedDate  = date_create($delivery->started_at);
				$FinisedDate  = Carbon::now();
				$TimeInterval = date_diff($StartedDate,$FinisedDate);
				$MintuesTime  = $TimeInterval->i;
				$delivery->travel_time = $MintuesTime;
				$delivery->status = 'DROPPED';
				$delivery->save();
				$delivery->with('user')->findOrFail($request->id);
				(new SendPushNotification)->DeliveryDropped($delivery_request, 'delivery');


				//$invoice = $this->invoice($request->id, ($request->toll_price != null) ? $request->toll_price : 0);

				//$delivery->invoice = ($invoice) ? $invoice : (object)[];
				//$delivery_request->payment = $delivery->payment;
			   

			}



			//Send message to socket
			$requestData = ['type' => 'DELIVERY', 'room' => 'room_'.$this->company_id, 'id' => $delivery_request->id, 'city' => ($this->settings->demo_mode == 0) ? $delivery_request->city_id : 0, 'user' => $delivery_request->user_id ];
			app('redis')->publish('checkDeliveryRequest', json_encode( $requestData ));
			
			// Send Push Notification to User
			return ['data' => $delivery ];

		/*} catch (Exception $e) {
			throw new \Exception($e->getMessage());
		}*/
	}

	public function calculateFare($request, $cflag=0){

		//try{
			$total=$tax_price='';
			$commission_price=0;
			$location=$this->getLocationDistance($request);

			$settings = json_decode(json_encode(Setting::where('company_id', $request['company_id'])->first()->settings_data));

			$city_price = DeliveryCityPrice::where('delivery_vehicle_id', $request['service_type'])->where('city_id',$request['city_id'])->first();

			if($city_price == null) {
				header("Access-Control-Allow-Origin: *");
				header("Access-Control-Allow-Headers: *");
				header('Content-Type: application/json');
				http_response_code(400);
				echo json_encode(Helper::getResponse(['status' => 400, 'message' => trans('user.ride.service_not_available_location'),  'error' => trans('user.ride.service_not_available_location')])->original);
				exit;
			}

			$siteConfig = $settings->site;
			$transportConfig = $settings->delivery;

			if(!empty($location['errors'])){
				throw new Exception($location['errors']);
			}
			else{

				
				$total_meter = $location['distance'];

				$location_list = [];

				foreach ($location['data'] as $key => $value) {
					$location['data'][$key]['city_id'] = $request['city_id'];
					$location['data'][$key]['service_type'] = $request['service_type'];
					$location['data'][$key]['weight'] = $request['weight'][$key];
					$location['data'][$key]['height'] = $request['height'][$key];
					$location['data'][$key]['length'] = $request['length'][$key];
					$location['data'][$key]['breadth'] = $request['breadth'][$key];

					$location['data'][$key]['unit'] = $transportConfig->unit_measurement;
					$location['data'][$key]['total_deliveries']=$request['total_deliveries'];
				}


				$requestarr['city_id']=$request['city_id'];
				$requestarr['meter']=$total_meter;
				$requestarr['distance'] = $location['distance'];
				$requestarr['location']=$location['data'];
				$requestarr['service_type']=$request['service_type'];
				$requestarr['city_id']=$request['city_id']; 
				$requestarr['weight']=array_sum($request['weight']);
				$requestarr['height']=array_sum($request['height']);
				$requestarr['length']=array_sum($request['length']);
				$requestarr['breadth']=array_sum($request['breadth']);

				$requestarr['unit'] = $transportConfig->unit_measurement;
				$requestarr['total_deliveries']=$request['total_deliveries'];

				$tax_percentage = $city_price->tax;
				$commission_percentage = $city_price->commission;
				$surge_trigger = isset($transportConfig->surge_trigger) ? $transportConfig->surge_trigger : 0 ;

\Log::info($requestarr);
				$price_response=$this->applyPriceLogic($requestarr);

				$total = $price_response['price'];
				$distance_fare = $price_response['distance_fare'];
             
				if($cflag!=0){

					if($commission_percentage>0){

						// $commission_price = $this->applyPercentage($price_response['price'],$commission_percentage);
						$commission_price = ($total) * ( $commission_percentage/100 );
						$total = $total + $commission_price;

					}
				   
				}   


				if($tax_percentage>0){
					$tax_price = $this->applyPercentage($total,$tax_percentage);
					\Log::info('Price');
					\Log::info($total);
					\Log::info('tax');
					\Log::info($tax_price);
					$total = $total + $tax_price;

				}
				
				$total = $total + $distance_fare;


				$updated_base_price = $price_response['base_price'] + $commission_price; 


				$return_data['estimated_fare']=$this->applyNumberFormat(floatval($total)); 
				$return_data['distance']=$location['distance'];    
				$return_data['weight']=array_sum($request['weight']);
				$return_data['height']=array_sum($request['height']);
				$return_data['length']=array_sum($request['length']);
				$return_data['breadth']=array_sum($request['breadth']);

				$return_data['tax_price']=$this->applyNumberFormat(floatval($tax_price));    
				$return_data['base_price']=$this->applyNumberFormat(floatval($updated_base_price));    
				$return_data['service_type']=(int)$request['service_type'];   
				$return_data['service']=$price_response['service_type']; 
				$return_data['unit'] = $transportConfig->unit_measurement;  

				$individual_price = [];

				foreach ($location['data'] as $key => $value) {
					$individual_price[] = $this->applyPriceLogic($value);
				}

				$return_data['individual_price'] = $individual_price;
				

				if(Auth::guard('user')->user()){
					$return_data['wallet_balance']=$this->applyNumberFormat(floatval(Auth::guard('user')->user()->wallet_balance));  
				}

				$service_response["data"]=$return_data;                    
			}

		/*} catch(Exception $e) {
			$service_response["errors"]=$e->getMessage();
		}*/
	
		return $service_response;    
	} 

	public function applyPriceLogic($requestarr,$iflag=0,$invoice=0){

		$fn_response=array();

\Log::info($requestarr);
		$city_price = DeliveryCityPrice::where('delivery_vehicle_id', $requestarr['service_type'])->where('city_id', $requestarr['city_id'])->first();

		if($city_price == null) {
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Allow-Headers: *");
			header('Content-Type: application/json');
			http_response_code(400);
			echo json_encode(Helper::getResponse(['status' => 400, 'message' => trans('user.ride.service_not_available_location'),  'error' => trans('user.ride.service_not_available_location')])->original);
			exit;
		}


		$fn_response['service_type']=$requestarr['service_type'];  


		$total_kilometer =  $requestarr['distance'];
		$total_weight = round($requestarr['weight']); //TW

		$per_kilogram= ($city_price == null) ? 0 : $city_price->weight; //PKG
		$per_kilometer= ($city_price == null) ? 0 : $city_price->price; //PKM
		$base_distance= ($city_price == null) ? 0 : $city_price->distance; //BD    
		if($invoice==1) {
			// $base_price= ($city_price == null) ? 0 : $city_price->fixed/$requestarr['total_deliveries']; //BP		
				
			$base_price = ($requestarr['reqnumber'] == 1)	? (($city_price == null) ? 0 : $city_price->fixed) : 0;
		} else {
			$base_price= ($city_price == null) ? 0 : $city_price->fixed; //BP
		}		
		\Log::info('city price');
		\Log::info($city_price);
		\Log::info('base price');
		\Log::info($base_price);
		$price = 0;
		if($city_price != null) {
			if($city_price->calculator == 'WEIGHT') {
				//BP+(TW*PKG)
				$price = $base_price+($total_weight * $per_kilogram);
				\Log::info('total weight');
				\Log::info($total_weight);
				\Log::info('per kilogram');
				\Log::info($per_kilogram);
			} else if($city_price->calculator == 'DISTANCE') {
				//BP+((TKM-BD)*PKM)  
				if($base_distance>$total_kilometer){
					$price = $base_price;
				}else{
					$price = $base_price+(($total_kilometer - $base_distance)*$per_kilometer);            
				}         
			} else if($city_price->calculator == 'DISTANCEWEIGHT') {
				//BP+((TKM-BD)*PKM)+(TM*PM)
				if($base_distance>$total_kilometer){
					$price = $base_price+($total_weight * $per_kilogram);
				}
				else{
					$price = $base_price+((($total_kilometer - $base_distance)*$per_kilometer)+($total_weight * $per_kilogram));
				}    
			} else {
				//by default set Ditance price BP+((TKM-BD)*PKM) 
				$price = $base_price+(($total_kilometer - $base_distance)*$per_kilometer);
			}
		}
		

		$fn_response['price']=$price;
		$fn_response['base_price']=$base_price;
		if($base_distance>$total_kilometer){
			$fn_response['distance_fare']=0;
		}
		else{
			$fn_response['distance_fare']=($total_kilometer - $base_distance)*$per_kilometer;
		}   
		$fn_response['weight_fare']=$total_weight * $per_kilogram; 
		$fn_response['total_weight'] = $total_weight;
		
		$fn_response['calculator']=($city_price == null) ? null : $city_price->calculator;
		$fn_response['city_price']=$city_price;

		//$fn_response['city_price']=$city_price;
		//dd($total_weight);
		return $fn_response;
	}

	public function applyPercentage($total,$percentage){
		return ($percentage/100)*$total;
	}

	public function applyNumberFormat($total){
		return round($total, Helper::setting()->site->round_decimal != "" ? Helper::setting()->site->round_decimal : 2 );
	}
	
	public function getLocationDistance($locationarr){

		$fn_response=array('data'=>null,'distance'=>0,'errors'=>null);

		//try{

			$s_latitude = $locationarr['s_latitude'];
			$s_longitude = $locationarr['s_longitude'];
			$distance = 0;

			//$locations = [];
			$data = [];

			/*foreach ($locationarr['d_longitude'] as $key => $value) {
				$details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$s_latitude.",".$s_longitude."&destination=".$locationarr['d_latitude'][$key].",".$locationarr['d_longitude'][$key]."&mode=driving&key=".$this->settings->site->server_key;

				$json = Helper::curl($details);

				$details = json_decode($json, TRUE);*/


				/*if(!empty($location['rows'][0]['elements'][0]['status']) && $location['rows'][0]['elements'][0]['status']=='ZERO_RESULTS'){
					throw new Exception("Out of service area", 1);
				}*/

				//$distance += $details['routes'][0]['legs'][0]['distance']['value'];

				/*$locations[] = ['latitude' => $locationarr['d_latitude'][$key], 'longitude' => $locationarr['d_longitude'][$key], 'km' => $details['routes'][0]['legs'][0]['distance']['text'], 'meter' => $details['routes'][0]['legs'][0]['distance']['value'], 'time' => $details['routes'][0]['legs'][0]['duration']['text'], 'seconds' => $details['routes'][0]['legs'][0]['duration']['value']];

			}*/

			/*usort($locations, function($a, $b) { return $a['meter'] > $b['meter']; });

			$location_list = $locations;

			$destination = array_pop($location_list);
*/
			$waypoints = [];

//dd($locationarr);
			foreach ($locationarr['d_longitude'] as $key => $value) {
				$waypoints[] = $locationarr['d_latitude'][$key].',' .$locationarr['d_longitude'][$key];
			}

			$destination = explode(',',array_pop($waypoints));
			$way_details = "https://maps.googleapis.com/maps/api/directions/json?origin=".$s_latitude.",".$s_longitude."&destination=".$destination[0].",".$destination[1]."&waypoints=" . implode('|', $waypoints )."&mode=driving&key=".$this->settings->site->server_key;

			$json_way = Helper::curl($way_details);

			$way_details = json_decode($json_way, TRUE);

			foreach ($way_details['routes'][0]['legs'] as $key => $value) {
				\Log::info('Source');
				\Log::info($s_latitude.'-'.$s_longitude);
				\Log::info('destination');
				\Log::info($destination[0].'-'.$destination[1]);
				$unit = isset($this->settings->site->distance) ? $this->settings->site->distance : 'Kms';
				if($unit=='Kms')
					$each_distance = round($value['distance']['value']/1000,1); //TKM
				else
					$each_distance = round($value['distance']['value']/1609.344,1); //TMi     
				\Log::info('Distance');
				\Log::info($each_distance);
				$distance += $each_distance;

				$data[] = ['latitude' => $value['end_location']['lat'], 'longitude' => $value['end_location']['lng'], 'km' => $value['distance']['text'], 'meter' =>$value['distance']['value'], 'distance' => $each_distance,'time' => $value['duration']['text'], 'seconds' => $value['duration']['value']];
			}

				\Log::info('Total Distance');
				\Log::info($distance);
			$fn_response["distance"] = $distance;
			$fn_response["data"] = $data;	

		/*}
		catch(Exception $e){
			$fn_response["errors"]=trans('user.maperror');
		} */ 

		return $fn_response;    
	}

	public function invoice($request_id, $toll_price = 0, $reqnumber = 0)
	{
		//try {                      



			//$delivery = Delivery::with('provider')->where('delivery_request_id', $request_id)->get(); 
			//dd($request_id);
			$delivery = Delivery::findOrFail($request_id);  

			$deliveryRequest = DeliveryRequest::where('id', $delivery->delivery_request_id)->first();	

			$total_deliveries = Delivery::where('delivery_request_id', $deliveryRequest->id)->count();  

			$distance = $delivery->distance;
			$weight = $delivery->weight;

			/*$RideCommission = RideCity::where('city_id',$delivery->city_id)->first();
			$tax_percentage = $RideCommission->tax ? $RideCommission->tax : 0;
			$commission_percentage = $RideCommission->comission ? $RideCommission->comission : 0;
			$peak_percentage = $RideCommission->peak_percentage ? $RideCommission->peak_percentage : 0;*/

			$tax_percentage = $commission_percentage = $peak_percentage =0;

			$Fixed = 0;
			$Distance = 0;
			$Discount = 0; // Promo Code discounts should be added here.
			$Wallet = 0;            
			$ProviderPay = 0;
			$Distance_fare =0;
			$Minute_fare =0;
			$calculator ='DISTANCE';
			$discount_per =0;

			//added the common function for calculate the price
			$requestarr['meter']=$distance;
			$requestarr['distance']=$distance;
			$requestarr['weight']=$weight;
			$requestarr['delivery_delivery_id']=$deliveryRequest->delivery_vehicle_id;
			$requestarr['city_id']=$deliveryRequest->city_id;
			$requestarr['service_type']=$deliveryRequest->delivery_vehicle_id;
			$requestarr['unit']=$deliveryRequest->unit;
			$requestarr['total_deliveries']=$total_deliveries;
			$requestarr['reqnumber']=$reqnumber;
			
			$response = new DeliveryService();         
			$pricedata=$response->applyPriceLogic($requestarr,1,1);

			/*$newRequest = RideRequest::findOrFail($delivery->id);
			$newRequest->status = "PICKEDUP";
			$newRequest->save();
			dd($pricedata);
			return false;*/


			
			if(!empty($pricedata)){
				$Distance =$pricedata['price'];
				$Fixed = $pricedata['base_price'];
				$Distance_fare = $pricedata['distance_fare'];
				$Weight_fare = $pricedata['weight_fare'];
				$TotalWeight = $pricedata['total_weight'];
				//$Minute_fare = $pricedata['minute_fare'];
				//$Hour_fare = $pricedata['hour_fare'];
				$calculator = $pricedata['calculator'];
				$RideCityPrice = $pricedata['city_price'];
				$deliveryRequest->calculator=$pricedata['calculator'];
				//$delivery->save();

				\Log::info($RideCityPrice);
				$tax_percentage = isset($RideCityPrice->tax) ? $RideCityPrice->tax : 0;
				$commission_percentage = isset($RideCityPrice->commission) ? $RideCityPrice->commission : 0;
				//$waiting_percentage = isset($RideCityPrice->waiting_commission) ? $RideCityPrice->waiting_commission : 0;
				$peak_percentage = isset($RideCityPrice->peak_commission) ? $RideCityPrice->peak_commission : 0;
			}


		$Total = $Distance;
		$payable_amount = $Distance;
		

		//$Commision = ($Total) * ( $commission_percentage/100 );
			//$Total += $Commision;
			//$payable_amount += $Commision;
			

			if($deliveryRequest->promocode_id>0){
				if($Promocode = Promocode::find($deliveryRequest->promocode_id)){
					$max_amount = $Promocode->max_amount;
					$discount_per = $Promocode->percentage;

					$discount_amount = (($Distance) * ($discount_per/100));

					if($discount_amount>$Promocode->max_amount){
						$Discount = $Promocode->max_amount;
					}
					else{
						$Discount = $discount_amount;
					}

					$PromocodeUsage = new PromocodeUsage;
					$PromocodeUsage->user_id =$deliveryRequest->user_id;
					$PromocodeUsage->company_id =Auth::guard('provider')->user()->company_id;
					$PromocodeUsage->promocode_id =$deliveryRequest->promocode_id;
					$PromocodeUsage->status ='USED';
					$PromocodeUsage->save();

					// $Total = $Distance + $Tax;
					// $payable_amount = $Distance + $Tax - $Discount;

				}                
			}

			$Total = $Total - $Discount;
			$payable_amount = $payable_amount - $Discount;
			
			if($Total < 0){
				$Total = 0.00; // prevent from negative value
				$payable_amount = 0.00;
			}


			//changed by tamil
			

			// if($Discount <= $Commision) {
			// 	$Commision -= $Discount;
			// }else {
			// 	$Commision -= $Discount;
			// }
			if($Discount > 0){
			$transation['transaction_desc']='Discount amount debited from admin commission';
			$transation['type']='D';
			$transation['transaction_type']=10;
			$transation['company_id'] = $deliveryRequest->company_id;
			$transation['admin_service'] = $deliveryRequest->admin_service;
			$transation['country_id'] = $deliveryRequest->country_id;
			$transation['company_id'] = $deliveryRequest->company_id;
			$transation['transaction_id'] = $deliveryRequest->id;
			$transation['transaction_alias'] = $deliveryRequest->booking_id;
			$transation['amount']= 1 * ($Discount);
			$this->createAdminWallet($transation);
			}

	
			//$ProviderPay = (($Total+$Discount) - $Commision);
			$ProviderPay = ($Total+$Discount);

			$Payment = new DeliveryPayment;


			$Payment->company_id = Auth::guard('provider')->user()->company_id;
			$Payment->delivery_id = $request_id;

			$Payment->user_id=$deliveryRequest->user_id;
			$Payment->provider_id=$deliveryRequest->provider_id;


			if(!empty($deliveryRequest->admin_id)){
				$Fleet = Admin::where('id',$deliveryRequest->admin_id)->where('type','FLEET')->where('company_id',Auth::guard('provider')->user()->company_id)->first();

				$fleet_per=0;


				if(!empty($Fleet)){
					if(!empty($Commision)){                                     
						$fleet_per=$Fleet->commision ? $Fleet->commision : 0;
					}
					else{
						$fleet_per=$RideCityPrice->fleet_commission ? $RideCityPrice->fleet_commission :0;
					}
					

					$Payment->fleet_id=$deliveryRequest->provider->admin_id;
					$Payment->fleet_percent=$fleet_per;
				}
			}


			//check peakhours and waiting charges
			$peakamount=$peak_comm_amount=0;

			/*if($RideCityPrice->waiting_min_charge>0){
				$total_waiting=round($this->total_waiting($deliveryRequest->id)/60);
				if($total_waiting>0){
					if($total_waiting > $RideCityPrice->waiting_free_mins){
						$total_waiting_time = $total_waiting - $RideCityPrice->waiting_free_mins;
						$total_waiting_amount = $total_waiting_time * $RideCityPrice->waiting_min_charge;
						$waiting_comm_amount = ($waiting_percentage/100) * $total_waiting_amount;

					}
				}
			}
*/
			$start_time = $delivery->started_at;
			$end_time = $delivery->finished_at;

			/*$start_time_check = PeakHour::where('start_time', '<=', $start_time)->where('end_time', '>=', $start_time)->where('timezone', $delivery->timezone)->where('company_id', Auth::guard('provider')->user()->company_id)->first();

			if($start_time_check){

				$RideCityPriceList = RideCityPrice::where('geofence_id',$delivery->geofence_id)->where('ride_delivery_vehicle_id',$delivery->ride_delivery_id)->where('company_id', Auth::guard('provider')->user()->company_id)->first();

				$Peakcharges = RidePeakPrice::where('ride_city_price_id',$RideCityPriceList->id)->where('ride_delivery_id',$delivery->ride_delivery_id)->where('peak_hour_id',$start_time_check->id)->first();


				if($Peakcharges){
					$peakamount=($Peakcharges->peak_price/100) * $Fixed;
					$peak_comm_amount = ($peak_percentage/100) * $peakamount;
				}

			}*/

			$Total += $peakamount+$toll_price;
			$payable_amount += $peakamount+$toll_price;
			$Tax = ($Total) * ( $tax_percentage/100 );
			$Total =  $Total +  $Tax;

			$Commision = ($Total) * ( $commission_percentage/100 );
			$Total =  $Total  +$Commision;

			$payable_amount = $payable_amount + $Tax + $Commision;


	     	$ProviderPay = $ProviderPay + ($peakamount) + $toll_price - $Commision;

			$Payment->fixed = $Fixed + $Commision + $peakamount;
		//	$Payment->fixed = $Fixed  + $peakamount;
			$Payment->distance = $Distance_fare;
			$Payment->weight  = $TotalWeight;
			$Payment->weight_fare = $Weight_fare;
			//$Payment->hour  = $Hour_fare;
			$Payment->payment_mode  = $deliveryRequest->payment_mode;
			$Payment->commision = $Commision;
			$Payment->commision_percent = $commission_percentage;
			//$Payment->toll_charge = $toll_price;
			$Payment->total = $Total;
			$Payment->provider_pay = $ProviderPay;
			$Payment->peak_amount = $peakamount;
			$Payment->peak_comm_amount = $peak_comm_amount;
			/*$Payment->total_waiting_time = $total_waiting_time;
			$Payment->waiting_amount = $total_waiting_amount;
			$Payment->waiting_comm_amount = $waiting_comm_amount;*/
			if($deliveryRequest->promocode_id>0){
				$Payment->promocode_id = $deliveryRequest->promocode_id;
			}
			$Payment->discount = $Discount;
			$Payment->discount_percent = $discount_per;
			$Payment->company_id = Auth::guard('provider')->user()->company_id;


			if($Discount  == ($Distance + $Tax)){
				$delivery->paid = 1;
				$delivery->save();
			}

			if($deliveryRequest->use_wallet == 1 && $payable_amount > 0){

				$User = User::find($deliveryRequest->user_id);
				$currencySymbol = $deliveryRequest->currency;
				$Wallet = $User->wallet_balance;

				if($Wallet != 0){

					if($payable_amount > $Wallet) {

						$Payment->wallet = $Wallet;
						$Payment->is_partial=1;
						$Payable = $payable_amount - $Wallet;
						
						$Payment->payable = abs($Payable);

						$wallet_det=$Wallet;  

						if($deliveryRequest->payment_mode == 'CASH'){
							$Payment->round_of = round($Payable)-abs($Payable);
							$Payment->total = $Total;
							$Payment->payable = round($Payable);
						}                    

					} else {

						$Payment->payable = 0;
						$WalletBalance = $Wallet - $payable_amount;
						
						$Payment->wallet = $payable_amount;
						
						$Payment->payment_id = 'WALLET';
						$Payment->payment_mode = $deliveryRequest->payment_mode;

						$delivery->paid = 1;
						$delivery->status = 'STARTED';
						$delivery->save();

						$wallet_det=$payable_amount;
					   
					}
					
					(new SendPushNotification)->ChargedWalletMoney($deliveryRequest->user_id,Helper::currencyFormat($wallet_det,$currencySymbol), 'delivery');

					//for create the user wallet transaction

					$wallet_det_with_providerpay = $wallet_det - $ProviderPay;

					$transaction['amount']=$wallet_det;
					$transaction['id']=$deliveryRequest->user_id;
					$transaction['provider_id']=$deliveryRequest->provider_id;
					$transaction['wallet_det_with_providerpay'] = $wallet_det_with_providerpay;
					$transaction['providerpay'] = $ProviderPay;
					$transaction['trans_desc']='delivery provider pay amount credited to provider wallet';
					$transaction['transaction_id']=$delivery->id;
					$transaction['transaction_alias']=$deliveryRequest->booking_id;
					$transaction['company_id']=$deliveryRequest->company_id;
					$transaction['transaction_msg']='delivery deduction';
					$transaction['admin_service']=$deliveryRequest->admin_service;
					$transaction['country_id']=$deliveryRequest->country_id;


					(new Transactions)->userCreditDebit($transaction,0);


				}

			} else {
				if($deliveryRequest->payment_mode == 'CASH' || $deliveryRequest->payment_mode == 'RAZORPAY'){
					$Payment->round_of = round($payable_amount)-abs($payable_amount);
					$Payment->total = $Total;
					$Payment->payable = round($payable_amount);
				}
				else{
					$Payment->total = abs($Total);
					$Payment->payable = abs($payable_amount);   
				}               
			}

			$Payment->tax = $Tax;

			$Payment->tax_percent = $tax_percentage;

			$Payment->save();

			return $Payment;

		/*} catch (\Throwable $e) {
			$newRequest = Delivery::findOrFail($request_id);
			$newRequest->status = "PICKEDUP";
			$newRequest->save();
			return false;
		}*/
	}


	protected function createAdminWallet($request){

        $admin_data=AdminWallet::orderBy('id', 'DESC')->first();

        $adminwallet=new AdminWallet;
        $adminwallet->company_id=$request['company_id'];
        if(!empty($request['admin_service']))
            $adminwallet->admin_service=$request['admin_service'];
        if(!empty($request['country_id']))
            $adminwallet->country_id=$request['country_id'];
        $adminwallet->transaction_id=$request['transaction_id'];        
        $adminwallet->transaction_alias=$request['transaction_alias'];
        $adminwallet->transaction_desc=$request['transaction_desc'];
        $adminwallet->transaction_type=$request['transaction_type'];
        $adminwallet->type=$request['type'];
        $adminwallet->amount=$request['amount'];

        if(empty($admin_data->close_balance))
            $adminwallet->open_balance=0;
        else
            $adminwallet->open_balance=$admin_data->close_balance;

        if(empty($admin_data->close_balance))
            $adminwallet->close_balance=$request['amount'];
        else            
            $adminwallet->close_balance=$admin_data->close_balance+($request['amount']);        

        $adminwallet->save();

        return $adminwallet;
    }

	public function total_waiting($id){

		$waiting = RideRequestWaitingTime::where('ride_request_id', $id)->whereNotNull('ended_at')->sum('waiting_mins');

		$uncounted_waiting = RideRequestWaitingTime::where('ride_request_id', $id)->whereNull('ended_at')->first();

		if($uncounted_waiting != null) {
			$waiting += (Carbon::parse($uncounted_waiting->started_at))->diffInSeconds(Carbon::now());
		}

		return $waiting;
	}
}
