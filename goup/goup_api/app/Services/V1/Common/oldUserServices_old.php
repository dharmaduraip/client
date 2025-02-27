<?php 

namespace App\Services\V1\Common;

use Illuminate\Http\Request;
use Validator;
use Exception;
use DateTime;
use Carbon\Carbon;
use DB;
use Auth;
use Lang;
use App\Helpers\Helper;
use GuzzleHttp\Client;
use App\Models\Order\Store;
use App\Models\Common\Setting;
use App\Models\Transport\RideCityPrice;
use App\Models\Common\PeakHour;
use App\Models\Common\AdminWallet;
use App\Models\Common\AdminService;
use App\Models\Common\User;
use App\Models\Common\UserWallet;
use App\Models\Common\FleetWallet;
use App\Models\Common\Provider;
use App\Models\Common\ProviderWallet;
use App\Models\Common\UserRequest;
use App\Models\Common\RequestFilter;
use App\Services\SendPushNotification;
use App\Models\Common\Admin;
use App\Models\Common\Card;
use App\Services\PaymentGateway;
use App\Models\Common\PaymentLog;
use App\Services\V1\Transport\Ride;
use App\Models\Common\GeoFence;
use App\Models\Common\Rating;
use App\Jobs\SendInvoiceEmailJob;
use App\Traits\Actions;



class UserServices_old {

    use Actions;

	public function checkRequest($request) {
  
	}

	public function createRequest($Providers, $newRequest, $type) {

		//Add the Log File for ride
		$user_request = new UserRequest();
		$user_request->request_id = $newRequest->id;
		$user_request->user_id = $newRequest->user_id;
		$user_request->provider_id = $newRequest->provider_id;
		$user_request->admin_service =$newRequest->admin_service;
		$user_request->status = $newRequest->status;
		$user_request->request_data = json_encode($newRequest);
		$user_request->company_id = $newRequest->company_id; 
		$user_request->schedule_at = $newRequest->schedule_at; 
		$user_request->save();
		if($newRequest->type == null || $newRequest->type == 'AIRPORT')
		{
			if($newRequest->status != 'SCHEDULED') {
				if($this->settings->transport->manual_request == 0){
					
					$first_iteration = true;
					foreach ($Providers as $key => $Provider) {

						if($this->settings->transport->broadcast_request == 1){
						   (new SendPushNotification)->IncomingRequest($Provider->id, $newRequest->admin_service); 
						}

						$existingRequest =  RequestFilter::where('provider_id', $Provider->id)->first();
						if($existingRequest == null) {
							$Filter = new RequestFilter;
							// Send push notifications to the first provider
							// incoming request push to provider
							$Filter->admin_service = $newRequest->admin_service;
							$Filter->request_id = $user_request->id;
							$Filter->provider_id = $Provider->id; 

							if($newRequest->type == 'AIRPORT')
							{
								if($first_iteration == false) {
									$Filter->assigned = 1;
								}

							}else{
								if($this->settings->transport->broadcast_request == 0 && $first_iteration == false ) {
									$Filter->assigned = 1;
								}
							}

							$Filter->company_id = $newRequest->company_id; 
							$Filter->save();
						}
						$first_iteration = false;
					}
				}
					
				//Send message to socket
				$requestData = ['type' => $newRequest->admin_service, 'room' => 'room_'.$newRequest->company_id, 'id' => $newRequest->id, 'city' => ($this->settings->demo_mode == 0) ? $newRequest->city_id : 0, 'user' => $newRequest->user_id ];
				//dd($publishUrl);
				app('redis')->publish('newRequest', json_encode( $requestData ));

			}
		}
	}

	public function cancelRequest($newRequest) {
		try{

			$user_request = UserRequest::where('admin_service', $newRequest->admin_service)->where('request_id',$newRequest->id)->first();
             if($user_request){
				RequestFilter::where('admin_service', $newRequest->admin_service )->where('request_id', $user_request->id)->delete();
				$user_request->delete();
			 }

			if($newRequest->status != 'SCHEDULED'){

				if($newRequest->provider_id != null){
					Provider::where('id', $newRequest->provider_id)->update(['is_assigned' => 0]);
				}
			}

			 if($newRequest->cancelled_by == "PROVIDER") {
			 	// Send Push Notification to User
				(new SendPushNotification)->ProviderCancelRide($newRequest, 'transport');
			 }
			else {
			 	// Send Push Notification to User
				(new SendPushNotification)->UserCancelRide($newRequest, 'transport');
			 }
			


			//Send message to socket
			$requestData = ['type' => $newRequest->admin_service, 'room' => 'room_'.$this->company_id, 'id' => $newRequest->id, 'city' => ($this->settings->demo_mode == 0) ? $newRequest->city_id : 0, 'user' => $newRequest->user_id ];

			if($newRequest->admin_service == "TRANSPORT") {
				app('redis')->publish('checkTransportRequest', json_encode( $requestData ));
			}

			if($newRequest->admin_service == "ORDER") {
				$requestData['shop']=$newRequest->store_id;
				app('redis')->publish('checkOrderRequest', json_encode( $requestData ));
			}

			if($newRequest->admin_service == "SERVICE") {
				app('redis')->publish('checkServiceRequest', json_encode( $requestData ));
			}

			app('redis')->publish('newRequest', json_encode( $requestData ));

		}

		catch (ModelNotFoundException $e) {
			return $e->getMessage() ;
		}
	}

    public function updatePaymentMode(Request $request, $newRequest, $payment = null) {

        try{

            if($request->has('card_id')){
                Card::where('user_id',$this->user->id)->update(['is_default' => 0]);
                Card::where('card_id',$request->card_id)->update(['is_default' => 1]);
            }
            
            $newRequest->payment_mode = $request->payment_mode;
            $newRequest->save();

            if($payment != null) {
                $payment->payment_mode = $request->payment_mode;
                $payment->save();
            }

            $user_request = UserRequest::where('request_id', $request->id)->where('admin_service', 'TRANSPORT' )->first();
            $user_request->request_data = json_encode($newRequest);
            $user_request->save();

            //Send message to socket
            $requestData = ['type' => $user_request->admin_service, 'id' => $request->id, 'room' => 'room_'.$this->company_id, 'payment_mode' => $request->payment_mode];
            app('redis')->publish('paymentUpdate', json_encode( $requestData )); 

            (new SendPushNotification)->updateProviderStatus($user_request->provider_id,'provider',trans('api.ride.payment_updated'). ' : '. $request->payment_mode); 

            return trans('api.ride.payment_updated');
        }

        catch (ModelNotFoundException $e) {
            return $e->getMessage();
        }
    }

	public function rate(Request $request, $newRequest ) {
		try {

			 $ratingRequest = Rating::where('request_id', $newRequest->id)->where('admin_service', $newRequest->admin_service )->first();

			 if(@$ratingRequest == null) {
					 Rating::create([
						 'company_id' => $this->company_id,
						 'admin_service' => $newRequest->admin_service,
						 'provider_id' => $newRequest->provider_id,
						 'user_id' => $newRequest->user_id,
						 'request_id' => $newRequest->id,
                    	 'store_id' => $newRequest->store_id,
						 'user_rating' => $request->rating,
                    	 'store_rating' => $request->has('shoprating') ? $request->shoprating : 0,
						 'user_comment' => $request->comment]);
			 } else {
					 $newRequest->rating->update([
					 	 'user_id' => $newRequest->user_id,
						 'request_id' => $newRequest->id,
                    	 'store_id' => $newRequest->store_id,
						 'user_rating' => $request->rating,
						 'user_comment' => $request->comment,
                    	 'store_rating' => $request->has('shoprating') ? $request->shoprating : 0,
					]);
			 }

			$newRequest->update(['user_rated' => 1]);

			$average = Rating::where('provider_id', $newRequest->provider_id)->avg('user_rating');

			$provider = Provider::find($newRequest->provider_id);

			 // Send Push Notification to Provider 
			if($newRequest->admin_service != "ORDER"){
				$provider->rating = $average;
				$provider->save();
			} else if($newRequest->order_type=='DELIVERY' && $newRequest->admin_service == "ORDER"){
				$provider->rating = $average;
				$provider->save();
			}

			 if($newRequest->store_id != null) {

			 	$store_average = Rating::where('store_id', $newRequest->store_id)->avg('store_rating');

			 	$StoreQuery = Store::find($newRequest->store_id);
             	$StoreQuery->rating=$store_average;
             	$StoreQuery->save();
			 }

			 //Send message to socket
			 $requestData = ['type' => $newRequest->admin_service, 'room' => 'room_'.$this->company_id, 'id' => $newRequest->id, 'city' => ($this->settings->demo_mode == 0) ? $newRequest->city_id : 0, 'user' => $newRequest->user_id ];
			 app('redis')->publish('newRequest', json_encode( $requestData ));

			return ['message' => trans('api.ride.request_completed') ];

		} catch (Exception $e) {
			return ['status' => 500, 'message' => trans('api.ride.request_not_completed').$e->getMessage(), 'error' =>trans('api.ride.request_not_completed') ];
		}
	}

	public function availableProviders(Request $request, $withCallback = null, $whereHasCallback = null) {

		$data = Provider::with($withCallback);

		if($whereHasCallback != null) {
			foreach ($whereHasCallback as $key => $whereHasCall) { 
				$data->whereHas($key, $whereHasCall);
			}
		}
		$distance = isset($this->settings->transport->provider_search_radius) ? $this->settings->transport->provider_search_radius : 100;

		$data->select('id', 'first_name', 'last_name', 'email', 'country_code', 'mobile', 'gender', 'latitude', 'longitude', DB::Raw("(6371 * acos( cos( radians('$request->latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$request->longitude') ) + sin( radians('$request->latitude') ) * sin( radians(latitude) ) ) ) AS distance"));
		$data->where('status', 'approved');
		$data->where('is_online',1);
		$data->where('is_assigned',0);
		$data->where('activation_status',1);
		$data->where('company_id', $this->company_id);
		$data->whereRaw("(6371 * acos( cos( radians('$request->latitude') ) * cos( radians(latitude) ) * cos( radians(longitude) - radians('$request->longitude') ) + sin( radians('$request->latitude') ) * sin( radians(latitude) ) ) ) <= $distance");
		if($request->type == 'AIRPORT'){
			$data->where('airport_at','!=',null);
		}
		$data->where('city_id', $this->user ? $this->user->city_id : $request->city_id);
		$data->where('wallet_balance' ,'>=',$this->settings->site->provider_negative_balance);
		if($request->type == 'AIRPORT'){
			$data->orderBy('airport_at','asc');
		}else{
			$data->orderBy('distance','asc');
		}
		$data = $data->get();

		return $data;
	}

	public function estimated_fare(Request $request){

		try{       
			$response = new Ride();

			$user = Auth::guard('user')->user();

	        $company_id = $user ? $user->company_id : 1;

			$request->request->add(['company_id' => $company_id]);

			$responsedata=$response->calculateFare($request->all(), 1);

			if(!empty($responsedata['errors'])){
				throw new \Exception($responsedata['errors']);
			}
			else{
				return response()->json( $responsedata['data'] );
			}

		} catch(Exception $e) {
			return response()->json( $e->getMessage() );
		}
	}

	public function payment_old(Request $request, $UserRequest, $payment) 
	{
		try {

			$tip_amount = $request->tips != "" ? $request->tips : 0;

			$transportConfig = $this->settings->transport;
			$paymentConfig = json_decode( json_encode( $this->settings->payment ) , true);

			$cardObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'card'; }));
			$card = 0;

			$stripe_secret_key = "";
			$stripe_publishable_key = "";
			$stripe_currency = "";

			$publishUrl = 'newRequest';
			if($UserRequest->admin_service == 'TRANSPORT') $publishUrl = 'checkTransportRequest';
			if($UserRequest->admin_service == 'ORDER') $publishUrl = 'checkOrderRequest';
			if($UserRequest->admin_service == 'SERVICE') $publishUrl = 'checkServiceRequest';

			if(count($cardObject) > 0) { 
				$card = $cardObject[0]['status'];

				$stripeSecretObject = array_values(array_filter( $cardObject[0]['credentials'], function ($e) { return $e['name'] == 'stripe_secret_key'; }));
				$stripePublishableObject = array_values(array_filter( $cardObject[0]['credentials'], function ($e) { return $e['name'] == 'stripe_publishable_key'; }));
				$stripeCurrencyObject = array_values(array_filter( $cardObject[0]['credentials'], function ($e) { return $e['name'] == 'stripe_currency'; }));

				if(count($stripeSecretObject) > 0) {
					$stripe_secret_key = $stripeSecretObject[0]['value'];
				}

				if(count($stripePublishableObject) > 0) {
					$stripe_publishable_key = $stripePublishableObject[0]['value'];
				}

				if(count($stripeCurrencyObject) > 0) {
					$stripe_currency = $stripeCurrencyObject[0]['value'];
				}
			}

			$random = $this->settings->transport->booking_prefix.mt_rand(100000, 999999);
			

			if (isset($request->tips) && !empty($request->tips)) {
				$tip_amount = round($request->tips, 2);
			}

			$totalAmount = $payment->payable + $tip_amount;


			$paymentMode = $request->has('payment_mode') ? strtoupper($request->payment_mode) : $UserRequest->payment_mode;
			

			if($paymentMode != 'CASH') {

				if ($totalAmount == 0) {

					$UserRequest->payment_mode = $paymentMode;
					$payment->card = $payment->payable;
					$payment->payable = 0;
					$payment->tips = $tip_amount;
					$payment->provider_pay = $payment->provider_pay + $tip_amount;
					$payment->save();

					$UserRequest->paid = 1;
					$UserRequest->status = 'COMPLETED';
					$UserRequest->save();

					//for create the transaction
					(new \App\Http\Controllers\V1\Transport\Provider\TripController)->callTransaction($request->id);

					$requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => ($this->settings->demo_mode == 0) ? $UserRequest->city_id : 0, 'user' => $UserRequest->user_id ];
					
					app('redis')->publish($publishUrl, json_encode( $requestData ));

					return trans('api.paid');

				} else {
					\Log::info('revoult enter old page check ');
					$log = new PaymentLog();
					$log->company_id = $this->company_id;
					$log->admin_service = $UserRequest->admin_service;
					$log->user_type = 'user';
					$log->transaction_code = $random;
					$log->amount = $totalAmount;
					$log->transaction_id = $UserRequest->id;
					$log->payment_mode = $paymentMode;
					$log->user_id = $UserRequest->user_id;
					$log->save();
					switch ($paymentMode) {
						case 'CARD':

						if($request->has('card_id')) {
							Card::where('card_id', $request->card_id)->update(['is_default' => 1]);
						}

						$card = Card::where('user_id', $UserRequest->user_id)->where('is_default', 1)->first();

						if($card == null)  $card = Card::where('user_id', $UserRequest->user_id)->first();

						$gateway = new PaymentGateway('stripe');

						$response = $gateway->process([
							'order' => $random,
							"amount" => $totalAmount,
							"currency" => $stripe_currency,
							"customer" => $this->user->stripe_cust_id,
							"card" => $card->card_id,
							"description" => "Payment Charge for " . $this->user->email,
							"receipt_email" => $this->user->email,
						]);

						break;
						
						case 'PAYPAL':
	
							$gateway = new PaymentGateway('paypal');
	
							return $gateway->process([
								'order' => $random,
								'item_name' => $random,
								'item_quantity' => 1,
								'amount' => $totalAmount,
								'description' => 'Test',
							]);
	
							break;
						
					}
					if($response->status == "SUCCESS") {

						$payment->payment_id = $response->payment_id;
						$payment->payment_mode = $paymentMode;
						$payment->card = $payment->payable;
						//$payment->payable = 0;
						$payment->tips = $tip_amount;
						//$payment->total = $totalAmount;
						$payment->provider_pay = $payment->provider_pay + $tip_amount;
						$payment->save();

						$UserRequest->paid = 1;
						$UserRequest->status = 'COMPLETED';
						$UserRequest->save();
						//for create the transaction
						(new \App\Http\Controllers\V1\Transport\Provider\TripController)->callTransaction($request->id);

						$requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => ($this->settings->demo_mode == 0) ? $UserRequest->city_id : 0, 'user' => $UserRequest->user_id ];
						app('redis')->publish($publishUrl, json_encode( $requestData ));

						 // send invoice email here
						/*$setting = Setting::where('company_id', $company_id )->first();

						$settings = json_decode(json_encode($setting->settings_data));
				        $siteConfig = $settings->site;*/
				       
						 if($UserRequest->admin_service == "TRANSPORT"){
							if( !empty($this->settings->site->send_email) && $this->settings->site->send_email == 1) {
								
									if($UserRequest->paid == 1){
										if($payment != null){
											dispatch(new SendInvoiceEmailJob($UserRequest, $payment, $payment->user->email));
										}
									} 
						      }
					     }

						return trans('api.paid');

					} else {
						return trans('Transaction Failed');
					}
				}

			} else {
				$UserRequest->paid = 1;
				$UserRequest->status = 'COMPLETED';
				$UserRequest->save();
				//for create the transaction
				(new \App\Http\Controllers\V1\Transport\Provider\TripController)->callTransaction($request->id);

				$requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => ($this->settings->demo_mode == 0) ? $UserRequest->city_id : 0, 'user' => $UserRequest->user_id ];
				app('redis')->publish($publishUrl, json_encode( $requestData ));

				 // send invoice email here
			/*$setting = Setting::where('company_id', $company_id )->first();

			$settings = json_decode(json_encode($setting->settings_data));
	        $siteConfig = $settings->site;*/

	        if($UserRequest->admin_service == "TRANSPORT"){
				if( !empty($this->settings->site->send_email) && $this->settings->site->send_email == 1) {
					
						if($UserRequest->paid == 1){
							if($payment != null){
								dispatch(new SendInvoiceEmailJob($UserRequest, $payment, $payment->user->email));
							}
						} 
			      }
		     }

				return trans('api.paid');
			}



		} catch (\Throwable $e) {
			throw new \Exception($e->getMessage());
		}
	}

public function userHistory(Request $request, $UserRequest, $callback) 
	{
		
        $showType = isset($request->type)?$request->type:'past';
        //dd($showType);

        try{

        	$UserRequest->with($callback)->withCount(['dispute', 'dispute as dispute_count' => function ($query) {
        												$query->where('dispute_type','user');
    										}])->HistoryUserTrips(Auth::guard('user')->user()->id,$showType);
        	if($request->has('search_text') && $request->search_text != null) {
        	   $provider = Provider::where('first_name', 'like', "%" . $request->search_text . "%")->orWhere('last_name', 'like', "%" . $request->search_text . "%")->pluck('id');
               $UserRequest->userHistorySearch($request->search_text);
               if(count($provider) > 0) {
               	$UserRequest->OrwhereIn('provider_id', $provider);
               	$UserRequest->where('user_id', Auth::guard('user')->user()->id);
               }
	        }  
	        if($request->has('order_by')) {
               $UserRequest->orderby($request->order_by, $request->order_direction);
			}
        	if($request->has('limit')) {
             $data=$UserRequest->where('company_id',$this->company_id)->take($request->limit)->offset($request->offset)->get(); 
            } else {
             $data=$UserRequest->where('company_id',$this->company_id)->orderby('id',"desc")->paginate(10); 	
            }

			if(!empty($data)){
				$map_icon = '';
				//asset('asset/img/marker-start.png');
				foreach ($data as $key => $value) {
					$data[$key]->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
							"autoscale=1".
							"&size=320x130".
							"&maptype=terrian".
							"&format=png".
							"&visual_refresh=true".
							"&markers=icon:".$map_icon."%7C".$value->s_latitude.",".$value->s_longitude.
							"&markers=icon:".$map_icon."%7C".$value->d_latitude.",".$value->d_longitude.
							"&path=color:0x191919|weight:3|enc:".$value->route_key.
							"&key=".$this->settings->site->server_key;
				}
			}

            return $data;		

        }
		catch (Exception $e) {
			
			return response()->json(['error' => $e->getMessage()]);
		}



    }


    public function userTripsDetails(Request $request, $UserRequest) 
	{
		try{
        	$data=$UserRequest->where('id',$request->id)->where('company_id',$this->company_id)->orderBy('created_at','desc')->first();
        	if(!empty($data)){
				$ratingQuery = Rating::select('id','user_rating','provider_rating','user_comment','provider_comment')
				->where('admin_service',$request->admin_service)
				->where('request_id',$request->id)
				->first();
				$data->rating = $ratingQuery;
				$map_icon = '';
				$data->static_map = "https://maps.googleapis.com/maps/api/staticmap?".
						"autoscale=1".
						"&size=320x130".
						"&maptype=terrian".
						"&format=png".
						"&visual_refresh=true".
						"&markers=icon:".$map_icon."%7C".$data->s_latitude.",".$data->s_longitude.
						"&markers=icon:".$map_icon."%7C".$data->d_latitude.",".$data->d_longitude.
						"&path=color:0x191919|weight:3|enc:".$data->route_key.
						"&key=".$this->settings->site->server_key;
			}
            return $data;		

        }
		catch (Exception $e) {
			return response()->json(['error' => $e->getMessage()]);
		}

    }

    public function userDisputeCreate(Request $request, $disputeRequest) 
	{
		try{
                $disputeRequest->company_id = $this->company_id;
                if($request->admin_service=="ORDER"){  
                   $disputeRequest->store_order_id = $request->id;
                   $disputeRequest->store_id =$request->store_id;
                 } else if($request->admin_service=="Transport"){
                   $disputeRequest->ride_request_id = $request->id;
                 }else if($request->admin_service=="SERVICE"){
                 	$disputeRequest->service_request_id = $request->id;
                 }
                
               
                $disputeRequest->dispute_type =$request->dispute_type;
                $disputeRequest->user_id = $request->user_id;
                $disputeRequest->provider_id = $request->provider_id;                  
                $disputeRequest->dispute_name = $request->dispute_name;
                $disputeRequest->dispute_title ="User Dispute"; 
                $disputeRequest->comments =  $request->comments; 

                $disputeRequest->save();
        	    return $disputeRequest;		

        }
		catch (Exception $e) {
			
			return response()->json(['error' => $e->getMessage()]);
		}

    }


public function poly_check_request($latitude, $longitude, $city_id = null)
	{
		$range_array = [];
		$range_data = GeoFence::select('id','ranges')->where('city_id', $city_id)->where('company_id', $this->company_id)->where('status', 1)->get();

		if(count($range_data)!=0){
			foreach($range_data as $ranges) {
				if(!empty($ranges)){

					$vertices_x = $vertices_y = [];

					$range_values = json_decode($ranges['ranges'],true);

					if(count($range_values)>0){
						foreach($range_values as $range ){
							$vertices_x[] = $range['lng'];
							$vertices_y[] = $range['lat'];
						}
					}

					$points_polygon = count($vertices_x) - 1; 
                     
					if ($this->inPolygon($points_polygon, $vertices_x, $vertices_y, $latitude, $longitude)){
						$range_array[] = $ranges['id'];

					}
				}
			}
		}
		if(count($range_array) > 0) {
			$airport = GeoFence::select('id','ranges')->where('type', 'AIRPORT')->whereIn('id', $range_array)->first();
			if($airport == null) {
				return ['id' => $range_array[0], 'type' => null];
			}
			return ['id' => $range_array[0], 'type' => $airport->id];
		}

		return false;

	}

	public function inPolygon($points_polygon, $vertices_x, $vertices_y, $latitude_y, $longitude_x) {
		$i = $j = $c = 0;
		for ($i = 0, $j = $points_polygon-1 ; $i < $points_polygon; $j = $i++) {
			if ( (($vertices_y[$i] > $latitude_y != ($vertices_y[$j] > $latitude_y)) && ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) ) 
			$c = !$c;
		}
		return $c;
	}

}

