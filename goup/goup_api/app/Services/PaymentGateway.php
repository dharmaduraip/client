<?php 

namespace App\Services;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Exception;
use DateTime;
use Auth;
use Lang;
use App\Models\Common\Setting;
use App\ServiceType;
use App\Models\Common\Promocode;
use App\Provider;
use App\ProviderService;
use App\Helpers\Helper;
use GuzzleHttp\Client;
use App\Models\Common\PaymentLog;


//PayuMoney
use Tzsk\Payu\Facade\Payment AS PayuPayment;

//Paypal
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payee;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

use Redirect;
use Session;
use URL;


class PaymentGateway {

	private $gateway;

	public function __construct($gateway){
		$this->gateway = strtoupper($gateway);
	}

	public function process($attributes) {
		$provider_url = '';

		$gateway = ($this->gateway == 'STRIPE') ? 'CARD' : $this->gateway ;

		$log = PaymentLog::where('transaction_code', $attributes['order'])->where('payment_mode', $gateway )->first();

		if($log->user_type == 'provider') {
			$provider_url = '/provider';
		}

		switch ($this->gateway) {

			case "STRIPE":

				try {
				
					$settings = json_decode(json_encode(Setting::first()->settings_data));
        			$paymentConfig = json_decode( json_encode( $settings->payment ) , true);

        			$cardObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'card'; }));
			        $card = 0;

			        $stripe_secret_key = "";
			        $stripe_publishable_key = "";
			        $stripe_currency = "";

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


        			\Stripe\Stripe::setApiKey( $stripe_secret_key );
					  $Charge = \Stripe\Charge::create([
		                "amount" => $attributes['amount'] * 100,
		                "currency" => $attributes['currency'],
		                "customer" => $attributes['customer'],
		                "card" => $attributes['card'],
		                "description" => $attributes['description'],
		                "receipt_email" => $attributes['receipt_email']
		             ]);
					$log->response = json_encode($Charge);
                	$log->save();

					$paymentId = $Charge['id'];

					return (Object)['status' => 'SUCCESS', 'payment_id' => $paymentId];

				} catch(StripeInvalidRequestError $e){
					// echo $e->getMessage();exit;
					return (Object)['status' => 'FAILURE', 'message' => $e->getMessage()];

	            } catch(Exception $e) {
	                return (Object)['status' => 'FAILURE','message' => $e->getMessage()];
	            }

				break;
				case "PAYPAL":

					$settings = json_decode(json_encode(Setting::first()->settings_data));
	
					$paymentConfig = json_decode( json_encode( $settings->payment ) , true);;
	
					$paypalObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'PayPal'; }));
					$paypal = 0;

					$client_id = "";
					$secret = "";
					$mode = "sandbox";
					$currency = "";
					$success_url = "";
					$cancel_url = "";
	
					if(count($paypalObject) > 0) { 
						$paypal = $paypalObject[0]['status'];
	
						$clientIdObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'client_id'; }));
						$secretObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'secret'; }));
						$modeObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'mode'; }));
						$currencyObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'currency'; }));
						$successUrlObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'success_url'; }));
						$cancelUrlObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'cancel_url'; }));
						if(count($clientIdObject) > 0) {
							$client_id = $clientIdObject[0]['value'];
						}
	
						if(count($secretObject) > 0) {
							$secret = $secretObject[0]['value'];
						}
	
						if(count($modeObject) > 0) {
							$mode = $modeObject[0]['value'];
						}
	
						if(count($currencyObject) > 0) {
							$currency = $currencyObject[0]['value'];
						}
	
						if(count($successUrlObject) > 0) {
							$success_url = $successUrlObject[0]['value'];
						}
	
						if(count($cancelUrlObject) > 0) {
							$cancel_url = $cancelUrlObject[0]['value'];
						}
					}
	
					$api_context = new ApiContext(new OAuthTokenCredential(
						$client_id,
						$secret)
					);
	
					$api_context->setConfig(array(
							'mode' => $mode,
							'http.ConnectionTimeOut' => 30,
							'log.LogEnabled' => true,
							'log.FileName' => storage_path() . '/logs/paypal.log',
							'log.LogLevel' => 'ERROR'
					));
	
					$payer = new Payer();
					$payer->setPaymentMethod('paypal');
	
					$item1 = new Item(); 
					$item1->setName($attributes['item_name'])->setCurrency($currency)->setQuantity($attributes['item_quantity'])->setPrice($attributes['amount']); 
					$itemList = new ItemList(); 
					$itemList->setItems(array($item1));
	
					$amount = new Amount();
					$amount->setCurrency($currency)
						->setTotal($attributes['amount']);
	
					$transaction = new Transaction();
					$transaction->setAmount($amount)
						->setItemList($itemList)
						->setDescription($attributes['description']);
	
					$redirect_urls = new RedirectUrls();
					$redirect_urls->setReturnUrl($success_url.'?order='. $attributes['order'])
					->setCancelUrl($cancel_url.'?order='. $attributes['order']);
	
					$payment = new Payment();
					$payment->setIntent('Sale')
						->setPayer($payer)
						->setRedirectUrls($redirect_urls)
						->setTransactions(array($transaction));
	
					try {
						$payment->create($api_context);
					} catch (\PayPal\Exception\PPConnectionException $ex) {
						if (config('app.debug')) {
							return ['url' => null, 'message' => 'Connection timeout'];
						} else {
							return ['url' => null, 'message' => 'Some error occur, sorry for inconvenient'];
						}
					}
					
					foreach ($payment->getLinks() as $link) {
						if ($link->getRel() == 'approval_url') {
							$redirect_url = $link->getHref();
							break;
						}
					}
	
					if (isset($redirect_url)) {
						return ['url' => $redirect_url, 'payment_mode'=>'paypal','message' => ''];
					}
	
				break;

			default:
				return redirect('dashboard');
		}
		

	}
	public function verify(Request $request) {

		$settings = json_decode(json_encode(Setting::first()->settings_data));
	
		$paymentConfig = json_decode( json_encode( $settings->payment ) , true);;

		$paypalObject = array_values(array_filter( $paymentConfig, function ($e) { return $e['name'] == 'PayPal'; }));
		$paypal = 0;

		$client_id = "";
		$secret = "";
		$mode = "sandbox";
		$currency = "";
		$success_url = "";
		$cancel_url = "";

		if(count($paypalObject) > 0) { 
			$paypal = $paypalObject[0]['status'];

			$clientIdObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'client_id'; }));
			$secretObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'secret'; }));
			$modeObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'mode'; }));
			$currencyObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'currency'; }));
			$successUrlObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'success_url'; }));
			$cancelUrlObject = array_values(array_filter( $paypalObject[0]['credentials'], function ($e) { return $e['name'] == 'cancel_url'; }));

			if(count($clientIdObject) > 0) {
				$client_id = $clientIdObject[0]['value'];
			}

			if(count($secretObject) > 0) {
				$secret = $secretObject[0]['value'];
			}

			if(count($modeObject) > 0) {
				$mode = $modeObject[0]['value'];
			}

			if(count($currencyObject) > 0) {
				$currency = $currencyObject[0]['value'];
			}

			if(count($successUrlObject) > 0) {
				$success_url = $successUrlObject[0]['value'];
			}

			if(count($cancelUrlObject) > 0) {
				$cancel_url = $cancelUrlObject[0]['value'];
			}
		}
		
        $api_context = new ApiContext(new OAuthTokenCredential(
             $client_id,
		     $secret)
        );

        $api_context->setConfig(array(
						'mode' => $mode,
						'http.ConnectionTimeOut' => 30,
						'log.LogEnabled' => true,
						'log.FileName' => storage_path() . '/logs/paypal.log',
						'log.LogLevel' => 'ERROR'
				));

        $payment = Payment::get($request->paymentId, $api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId($request->PayerID);

        //Execute the payment
        $result = $payment->execute($execution, $api_context);

        $log = PaymentLog::where('transaction_code', $request->order)->first();
        $orderData = [];

        if($log->admin_service == "ORDER") {
        	$orderData = json_decode($result, true);
        }


        $log->response = json_encode( json_decode($result) );
        $log->save();

        if ($result->getState() == 'approved') {
            $payment_id = $request->paymentId;
        }


        if($log->admin_service == "TRANSPORT") {
        	try {
        		$userRequest = \App\Models\Transport\RideRequest::find($log->transaction_id);
        		$log->type_id = $userRequest->ride_type_id;

        		$payment = \App\Models\Transport\RideRequestPayment::where('ride_request_id', $log->transaction_id)->first();
        		$payment->payment_id = $payment_id;
	    		$payment->save();
        	} catch (\Throwable $e) { }
        	
        } else if($log->admin_service == "ORDER") {
        	$log->transaction_id = $payment_id;
        	$log->save();
        } else if($log->admin_service == "SERVICE") {
        	try {
        		$userRequest = \App\Models\Service\ServiceRequest::find($log->transaction_id);
        		$log->type_id = $userRequest->service_id;

        		$payment = \App\Models\Service\ServiceRequestPayment::where('service_request_id', $log->transaction_id)->first();
        		$payment->payment_id = $payment_id;
	    		$payment->save();
        	} catch (\Throwable $e) { }
        	
        }else if($log->admin_service == "DELIVERY") {
        	try {
        		$userRequest = \App\Models\Delivery\DeliveryRequest::find($log->transaction_id);
        		$log->type_id = $userRequest->delivery_type_id;

        		$payment = \App\Models\Delivery\DeliveryPayment::where('delivery_id', $log->transaction_id)->first();
        		$payment->payment_id = $payment_id;
	    		$payment->save();
        	} catch (\Throwable $e) { }
        	
        }

        $log->payment_id = $payment_id;

        return $log;
	}
	
}