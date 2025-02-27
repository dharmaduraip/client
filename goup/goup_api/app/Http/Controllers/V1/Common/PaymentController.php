<?php

namespace App\Http\Controllers\V1\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PaymentGateway;
use App\Models\Common\PaymentLog;
use App\Services\SendPushNotification;
use App\Models\Common\Country;
use App\Models\Common\Setting;
use App\Models\Common\State;
use App\Models\Common\City;
use App\Models\Common\Menu;
use App\Models\Common\Card;
use App\Models\Common\User;
use App\Models\Common\Provider;
use App\Helpers\Helper;
use App\Models\Common\Settings;
use App\Models\Common\UserWallet;
use App\Models\Common\ProviderCard;
use App\Models\Common\ProviderWallet;
use App\Services\Transactions;
use Auth;
use Carbon\Carbon;

use App\Traits\Actions;
use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;

class PaymentController extends Controller
{
	/**
     * add wallet money for user.
     *
     * @return \Illuminate\Http\Response
     */
    use Actions;

    public function nowpayment_payment($client, $pay_amount, $random)
    {
        \Log::info('payment amount:'.$pay_amount);
            $payload = [
                "form_params" => [
                    "price_amount" => $pay_amount,
                    "price_currency" => 'usd',
                    "pay_currency" => 'btc',
                    "ipn_callback_url" => "https://nowpayments.io",
                    "order_id" => $random,
                    "order_description" => "Add money to user wallet"
                ]
            ];
            $response = json_decode($client->request('POST', 'payment',$payload)->getBody());
            
               \Log::info('response: ' .$response->payment_id);
            return $response->payment_id;
            
    }
     public function nowpayment_invoice($request, $client, $pay_amount, $random)
    {
        \Log::info('payment amount:'.$pay_amount);
            $payload = [
                "form_params" => [
                    "price_amount" => $pay_amount,
                    "price_currency" => 'usd',
                    "pay_currency" => 'btc',
                    "ipn_callback_url" => "https://easyjek.com/",
                    "order_id" => $random,
                    "order_description" => "Add money to user wallet",
                    "success_url" => "https://easyjek.com/nowpayment/success?order_id=" . $random . "&payment_mode=" . $request->payment_mode . "&user_type=" . $request->user_type . "&admin_service=Wallet",
                    "cancel_url"=>  "https://easyjek.com/nowpayment/failure?order_id=".$random,
                ]
            ];
            $response = json_decode($client->request('POST', 'invoice',$payload)->getBody());
            
               \Log::info('response: ' .$response->invoice_url);
                \Log::info('response: ' .$response->success_url);

            return $response->invoice_url;
            
    }
     public function nowpayment_estimate($client, $apikey)
    {
            //generates and returns a unique access token.
            $payload = [
                "data" => [
                "amount" => '9',
                "currency_from" => 'usd',
                "currency_to" => 'btc'
                ]
            ];
            $response = json_decode($client->request('GET', 'estimate', ['query' => [  "amount" => '3999.5000',
                "currency_from" => 'usd',
                "currency_to" => 'btc']])->getBody());
            
               \Log::info('response: ' .$response->currency_from);
                return $response->currency_from;
            
    }
    public function revoult_order($client,$pay_amount,$random)
    {
           
            $payload = [
                      "amount"=> $pay_amount * 100,
                      "currency"=>"EUR",
                      "merchant_order_ext_ref"=> $random
            ];
            $response = json_decode($client->request('POST', 'orders',
                [
                "headers" => ['authorization' => "Bearer sk_V2Cd2qe3AYQDRrtCkmIVpxcUPyJhUG5dfkQKOkGMpfk4HwLBcvicD66XY739OMQR"],
                "Content-Type"     => "application/json",
                "json" => $payload
            ])->getBody());
            
                \Log::info('response: ' .$response->public_id);

            return $response;
            
    }
     public function revoult_order_get($client,$id)
    {
           
           // $params = [
           //            "order_id"=> $id
                     
           //  ];
            $response = json_decode($client->request('GET', 'orders/'.$id,
                [
                "headers" => ['authorization' => "Bearer sk_V2Cd2qe3AYQDRrtCkmIVpxcUPyJhUG5dfkQKOkGMpfk4HwLBcvicD66XY739OMQR"],
                "Content-Type"     => "application/json",
               // "json" => $payload
            ])->getBody());
            
                \Log::info('response: ' .$response->state);

            return $response;
            
    }
    public function add_money(Request $request)
    {
        $this->validate($request, [
            'user_type' => 'required',
            'amount' => 'required',
            'payment_mode' => 'required'
        ]);

        $random = 'easyjek_'.mt_rand(100000, 999999);

        $user_type = $request->user_type;

        if(strtoupper($request->payment_mode) == 'REVOLUT'){
           
            $pay_amount = $request->amount;
            $response = $this->revoult_order($this->client_revoult,$pay_amount,$random);

            $log = new PaymentLog();
            $log->user_type = $user_type;
            $log->admin_service = 'WALLET';
            $log->is_wallet = '1';
            $log->amount = $request->amount;
            // $log->order_id = $this->orderId;
            $log->transaction_code = $random;
            $log->payment_mode = strtoupper($request->payment_mode);
            $log->user_id = Auth::guard($user_type)->user()->id;
            $log->company_id = Auth::guard($user_type)->user()->company_id;
            $log->save();

            $data=[
                'data' => $response,
                'payment_mode' => 'REVOLUT'
            ];
            return  Helper::getResponse(['data' => $data]);

        }

         if(strtoupper($request->payment_mode) == 'NOWPAYMENT'){
            $pay_amount = $request->amount;

           // $response = $this->nowpayment_estimate($this->client, $this->api_key);
            // $response = $this->nowpayment_payment($this->client, $pay_amount, $random);
            $response = $this->nowpayment_invoice($request, $this->client, $pay_amount, $random);

            if(!empty($response)){
             $payment = [
                    'url' => $response,
                    'payment_mode' => 'NOWPAYMENT',

                ];

                $log = new PaymentLog();
                $log->user_type = $user_type;
                $log->admin_service = 'WALLET';
                $log->is_wallet = '1';
                $log->amount = $request->amount;
               // $log->order_id = $this->orderId;
                $log->transaction_code = $random;
                $log->payment_mode = strtoupper($request->payment_mode);
                $log->user_id = Auth::guard($user_type)->user()->id;
                $log->company_id = Auth::guard($user_type)->user()->company_id;
                $log->save();

                if ($request->ajax()) {
                    return  Helper::getResponse(['data' => $payment]);
                  } else {
                    return  Helper::getResponse(['data' => $payment]);
                  }

            }
            else{
                if ($request->ajax()) {
                    return  Helper::getResponse(['error' => 'Transaction failed']);
                  } else {
                    return  Helper::getResponse(['error' => 'Transaction failed']);
                  }
            }

         }
        $log = new PaymentLog();
        $log->user_type = $user_type;
        $log->admin_service = 'WALLET';
        $log->is_wallet = '1';
        $log->amount = $request->amount;
        $log->transaction_code = $random;
        $log->payment_mode = strtoupper($request->payment_mode);
        $log->user_id = Auth::guard($user_type)->user()->id;
        $log->company_id = Auth::guard($user_type)->user()->company_id;
        $log->save();

        switch (strtoupper($request->payment_mode)) {

          case 'BRAINTREE':

           $gateway = new PaymentGateway('braintree');
            return $gateway->process([
                'amount' => $request->amount,
                'nonce' => $request->braintree_nonce,
                'order' => $random,
            ]);

            break;

          case 'PAYPAL':

            $gateway = new PaymentGateway('paypal');

            return $gateway->process([
                'order' => $random,
                'item_name' => $random,
                'item_currency' => 'USD',
                'item_quantity' => 1,
                'amount' => $request->amount,
                'description' => 'Test',
            ]);

            break;


          case 'CARD':
            
            if ($user_type == 'provider') {

                ProviderCard::where('provider_id', Auth::guard('provider')->user()->id)->update(['is_default' => 0]);
                ProviderCard::where('card_id', $request->card_id)->update(['is_default' => 1]);


            } else {
                Card::where('user_id', Auth::guard('user')->user()->id)->update(['is_default' => 0]);
                Card::where('card_id', $request->card_id)->update(['is_default' => 1]);
            }

            
            $gateway = new PaymentGateway('stripe');
            $response = $gateway->process([
                "order" => $random,
                "amount" => $request->amount,
                "currency" => 'USD',
                "customer" => Auth::guard($user_type)->user()->stripe_cust_id, 
                "card" => $request->card_id,
                "description" => "Adding Money for " . Auth::guard($user_type)->user()->email,
                "receipt_email" => Auth::guard($user_type)->user()->email
            ]);
            if($response->status == "SUCCESS") { 
                if($user_type == 'user'){

                    //create transaction to user wallet
                    $transaction['id']=Auth::guard('user')->user()->id;
                    $transaction['amount']=$log->amount;
                    $transaction['company_id']=$log->company_id;                                        
                    (new Transactions)->userCreditDebit($transaction,1);

                    //update wallet balance
                    $wallet_balance = Auth::guard('user')->user()->wallet_balance+$log->amount;
                    User::where('id',Auth::guard('user')->user()->id)
                    ->where('company_id',Auth::guard('user')->user()->company_id)->update(['wallet_balance' => $wallet_balance]);

                    (new SendPushNotification)->WalletMoney(Auth::guard('user')->user()->id, Auth::guard('user')->user()->currency_symbol.$log->amount, 'common', 'Wallet amount added', ['amount' => $log->amount]);
                }else{
       
                    //create transaction to provider wallet
                    $transaction['id']=Auth::guard('provider')->user()->id;
                    $transaction['amount']=$log->amount;
                    $transaction['company_id']=$log->company_id;                                        
                    (new Transactions)->providerCreditDebit($transaction,1);

                    //update wallet balance
                    $wallet_balance = Auth::guard('provider')->user()->wallet_balance+$log->amount;

                    Provider::where('id',Auth::guard('provider')->user()->id)
                    ->where('company_id',Auth::guard('provider')->user()->company_id)->update(['wallet_balance' => $wallet_balance]);

                    (new SendPushNotification)->ProviderWalletMoney(Auth::guard('provider')->user()->id, Auth::guard('provider')->user()->currency_symbol.$log->amount, 'common', 'Wallet amount added', ['amount' => $log->amount]);
                }

                return Helper::getResponse(['data'=> ['wallet_balance' => $wallet_balance],'message' => trans('api.amount_added_to_your_wallet')]);
            }else{
                return Helper::getResponse(['status' => '500', 'message' => trans('Transaction Failed')]);
            }
            break;
        }
    }

    public function verify_payment(Request $request)
    {
        \Log::info($request->all());
        $response = (new PaymentGateway('paypal'))->verify($request);
\Log::info($response);
        if($response->admin_service == "WALLET") {
            if($response->user_type == 'user') {

                $user = User::find($response->user_id);

                $transaction['id']=$user->id;
                $transaction['amount']=$response->amount;
                $transaction['company_id']=$response->company_id;                                        
                (new Transactions)->userCreditDebit($transaction,1);

                //update wallet balance
                $wallet_balance = $user->wallet_balance+$response->amount;
                User::where('id',$user->id)
                ->where('company_id',$user->company_id)->update(['wallet_balance' => $wallet_balance]);

                (new SendPushNotification)->WalletMoney($user->id, $user->currency_symbol.$response->amount, 'common', 'Wallet amount added', ['amount' => $response->amount]);
            } else {

                $user = Provider::find($response->user_id);

                //create transaction to provider wallet
                $transaction['id']=$user->id;
                $transaction['amount']=$response->amount;
                $transaction['company_id']=$response->company_id;                                        
                (new Transactions)->providerCreditDebit($transaction,1);

                //update wallet balance
                $wallet_balance = $user->wallet_balance+$response->amount;

                Provider::where('id',$user->id)
                ->where('company_id',$user->company_id)->update(['wallet_balance' => $wallet_balance]);

                (new SendPushNotification)->ProviderWalletMoney($user->id, $user->currency_symbol.$response->amount, 'common', 'Wallet amount added', ['amount' => $response->amount]);
            }

        } else if($response->admin_service == "TRANSPORT") {

            $UserRequest = \App\Models\Transport\RideRequest::find($response->transaction_id);

            $UserRequest->paid = 1;
            $UserRequest->status = 'COMPLETED';
            $UserRequest->save();
            //for create the transaction
            (new \App\Http\Controllers\V1\Transport\Provider\TripController)->callTransaction($UserRequest->id);

            $requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' =>  $UserRequest->city_id, 'user' => $UserRequest->user_id ];
            app('redis')->publish('checkTransportRequest', json_encode( $requestData ));

            $response->type_id = $UserRequest->ride_type_id;

        }  else if($response->admin_service == "SERVICE") {

            $UserRequest = \App\Models\Service\ServiceRequest::find($response->transaction_id);

            $payment = \App\Models\Service\ServiceRequestPayment::where('service_request_id', $UserRequest->id)->first();
            $payment->payable = 0;
            $payment->save();

            $UserRequest->paid = 1;
            $UserRequest->status = 'COMPLETED';
            $UserRequest->save();

            //for create the transaction
            (new  \App\Http\Controllers\V1\Service\Provider\ServeController)->callTransaction($UserRequest->id);
            $requestData = ['type' => 'SERVICE', 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => $UserRequest->city_id, 'user' => $UserRequest->user_id ];
            app('redis')->publish('checkServiceRequest', json_encode( $requestData ));

            $response->type_id = $UserRequest->service_id;

        } else if($response->admin_service == "DELIVERY") {
            
             $UserRequest = \App\Models\Delivery\DeliveryRequest::find($response->transaction_id);
            $delivery = \App\Models\Delivery\Delivery::where('delivery_request_id',$UserRequest->id)->first();
            \Log::info('delivery details:'. $delivery );
            $deliveryPayment = \App\Models\Delivery\DeliveryPayment::where('delivery_id', $delivery->id)->update(['payment_id' => $response->payment_id]);
               $UserRequest->paid = 1;
               $UserRequest->status = 'PICKEDUP';
               $UserRequest->save();
                       //for create the transaction
          (new \App\Http\Controllers\V1\Delivery\Provider\TripController)->callTransaction($UserRequest->id);

         $requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => $UserRequest->city_id, 'user' => $UserRequest->user_id ];
         app('redis')->publish('checkDeliveryRequest', json_encode( $requestData ));

        $delivery->status = 'STARTED';
        $delivery->started_at = Carbon::now();
        $delivery->save();
        \Log::info('delivery details after save:'. $delivery );

        \App\Models\Delivery\Delivery::where('id', $UserRequest->id)->update(['paid' => 1]);
         $response->type_id = $UserRequest->delivery_type_id;

        } else {

            $log = PaymentLog::where('transaction_code', $request->order)->first();
            $log->save();
            
            return (new \App\Http\Controllers\V1\Order\User\HomeController)->createOrder($request);

        }

        return Helper::getResponse([ 'data' => $response, 'message' => 'Payment Success!' ]);
    }

    public function failure_payment(Request $request)
    {
        $response = PaymentLog::where('transaction_code', $request->order)->first();

        if($response->admin_service == "TRANSPORT") {
            $rideRequest = \App\Models\Transport\RideRequest::find($response->transaction_id);
            $response->type_id = $rideRequest->ride_type_id;
        }  else if($response->admin_service == "ORDER") {

        }  else if($response->admin_service == "SERVICE") {
            $serviceRequest = \App\Models\Service\ServiceRequest::find($response->transaction_id);
            $response->type_id = $serviceRequest->ride_type_id;
        } else if($response->admin_service == "DELIVERY") {

        }

        return Helper::getResponse([ 'data' => $response, 'message' => 'Payment Failed!' ]);
    }

    public function payment_redirect(Request $request){
         $response = PaymentLog::where('transaction_code', $request->order)->where('response','!=',null)->first();
         \Log::info($response);
         if(count($response) > 0){
            return response()->json(['message' => 'Payment Success!','paid' => 1,'foodie_id' => $response->transaction_id]);
        }else{
             return response()->json(['message' => 'Payment Failed!','paid' => 0,'foodie_id'=> "0"]);
        }
    }
    //now payment
      public function nowpayment_verify_payment(Request $request)
    {
        \Log::info($request->all());

        $response = PaymentLog::where('transaction_code', $request->order_id)->first();

        if($response->admin_service == "WALLET") {
            if($response->user_type == 'user') {

                $user = User::find($response->user_id);

                $transaction['id']=$user->id;
                $transaction['amount']=$response->amount;
                $transaction['company_id']=$response->company_id;                                        
                (new Transactions)->userCreditDebit($transaction,1);

                //update wallet balance
                $wallet_balance = $user->wallet_balance+$response->amount;
                User::where('id',$user->id)
                ->where('company_id',$user->company_id)->update(['wallet_balance' => $wallet_balance]);

                (new SendPushNotification)->WalletMoney($user->id, $user->currency_symbol.$response->amount, 'common', 'Wallet amount added', ['amount' => $response->amount]);
            } else {

                $user = Provider::find($response->user_id);

                //create transaction to provider wallet
                $transaction['id']=$user->id;
                $transaction['amount']=$response->amount;
                $transaction['company_id']=$response->company_id;                                        
                (new Transactions)->providerCreditDebit($transaction,1);

                //update wallet balance
                $wallet_balance = $user->wallet_balance+$response->amount;

                Provider::where('id',$user->id)
                ->where('company_id',$user->company_id)->update(['wallet_balance' => $wallet_balance]);

                (new SendPushNotification)->ProviderWalletMoney($user->id, $user->currency_symbol.$response->amount, 'common', 'Wallet amount added', ['amount' => $response->amount]);
            }

        } else if($response->admin_service == "TRANSPORT") {

            $UserRequest = \App\Models\Transport\RideRequest::find($response->transaction_id);

            $UserRequest->paid = 1;
            $UserRequest->status = 'COMPLETED';
            $UserRequest->save();
            //for create the transaction
            (new \App\Http\Controllers\V1\Transport\Provider\TripController)->callTransaction($UserRequest->id);

            $requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' =>  $UserRequest->city_id, 'user' => $UserRequest->user_id ];
            app('redis')->publish('checkTransportRequest', json_encode( $requestData ));

            $response->type_id = $UserRequest->ride_type_id;

        }  else if($response->admin_service == "SERVICE") {

            $UserRequest = \App\Models\Service\ServiceRequest::find($response->transaction_id);

            $payment = \App\Models\Service\ServiceRequestPayment::where('service_request_id', $UserRequest->id)->first();
            $payment->payable = 0;
            $payment->save();

            $UserRequest->paid = 1;
            $UserRequest->status = 'COMPLETED';
            $UserRequest->save();

            //for create the transaction
            (new  \App\Http\Controllers\V1\Service\Provider\ServeController)->callTransaction($UserRequest->id);
            $requestData = ['type' => 'SERVICE', 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => $UserRequest->city_id, 'user' => $UserRequest->user_id ];
            app('redis')->publish('checkServiceRequest', json_encode( $requestData ));

            $response->type_id = $UserRequest->service_id;

        } else if($response->admin_service == "DELIVERY") {
            
             $UserRequest = \App\Models\Delivery\DeliveryRequest::find($response->transaction_id);
            $delivery = \App\Models\Delivery\Delivery::where('delivery_request_id',$UserRequest->id)->first();
            \Log::info('delivery details:'. $delivery );
            $deliveryPayment = \App\Models\Delivery\DeliveryPayment::where('delivery_id', $delivery->id)->update(['payment_id' => $response->payment_id]);
               $UserRequest->paid = 1;
               $UserRequest->status = 'PICKEDUP';
               $UserRequest->save();
                       //for create the transaction
          (new \App\Http\Controllers\V1\Delivery\Provider\TripController)->callTransaction($UserRequest->id);

         $requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => $UserRequest->city_id, 'user' => $UserRequest->user_id ];
         app('redis')->publish('checkDeliveryRequest', json_encode( $requestData ));

        $delivery->status = 'STARTED';
        $delivery->started_at = Carbon::now();
        $delivery->save();
        \Log::info('delivery details after save:'. $delivery );

        \App\Models\Delivery\Delivery::where('id', $UserRequest->id)->update(['paid' => 1]);
         $response->type_id = $UserRequest->delivery_type_id;

        } else {

            $log = PaymentLog::where('transaction_code', $request->order)->first();
            $log->save();
            
            return (new \App\Http\Controllers\V1\Order\User\HomeController)->createOrder($request);

        }

        return Helper::getResponse([ 'data' => $response, 'message' => 'Payment Success!' ]);
    }

    public function nowpayment_failure_payment(Request $request)
    {
        $response = PaymentLog::where('transaction_code', $request->order)->first();

        if($response->admin_service == "TRANSPORT") {
            $rideRequest = \App\Models\Transport\RideRequest::find($response->transaction_id);
            $response->type_id = $rideRequest->ride_type_id;
        }  else if($response->admin_service == "ORDER") {

        }  else if($response->admin_service == "SERVICE") {
            $serviceRequest = \App\Models\Service\ServiceRequest::find($response->transaction_id);
            $response->type_id = $serviceRequest->ride_type_id;
        } else if($response->admin_service == "DELIVERY") {

        }

        return Helper::getResponse([ 'data' => $response, 'message' => 'Payment Failed!' ]);
    }

    
     //Revolut payment
      public function revoult_verify_payment(Request $request)
    {
        \Log::info($request->all());
       
        $response = $this->revoult_order_get($this->client_revoult,$request->id);
        if($response->state= "COMPLETED"){
             $response = PaymentLog::where('transaction_code', $request->merchant_order_ext_ref)->first();

            if($response->admin_service == "WALLET") {
                if($response->user_type == 'user') {

                    $user = User::find($response->user_id);

                    $transaction['id']=$user->id;
                    $transaction['amount']=$response->amount;
                    $transaction['company_id']=$response->company_id;                                        
                    (new Transactions)->userCreditDebit($transaction,1);

                    //update wallet balance
                    $wallet_balance = $user->wallet_balance+$response->amount;
                    User::where('id',$user->id)
                    ->where('company_id',$user->company_id)->update(['wallet_balance' => $wallet_balance]);

                    (new SendPushNotification)->WalletMoney($user->id, $user->currency_symbol.$response->amount, 'common', 'Wallet amount added', ['amount' => $response->amount]);
                } else {

                    $user = Provider::find($response->user_id);

                    //create transaction to provider wallet
                    $transaction['id']=$user->id;
                    $transaction['amount']=$response->amount;
                    $transaction['company_id']=$response->company_id;                                        
                    (new Transactions)->providerCreditDebit($transaction,1);

                    //update wallet balance
                    $wallet_balance = $user->wallet_balance+$response->amount;

                    Provider::where('id',$user->id)
                    ->where('company_id',$user->company_id)->update(['wallet_balance' => $wallet_balance]);

                    (new SendPushNotification)->ProviderWalletMoney($user->id, $user->currency_symbol.$response->amount, 'common', 'Wallet amount added', ['amount' => $response->amount]);
                }

            } else if($response->admin_service == "TRANSPORT") {

                $UserRequest = \App\Models\Transport\RideRequest::find($response->transaction_id);

                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();
                //for create the transaction
                (new \App\Http\Controllers\V1\Transport\Provider\TripController)->callTransaction($UserRequest->id);

                $requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' =>  $UserRequest->city_id, 'user' => $UserRequest->user_id ];
                app('redis')->publish('checkTransportRequest', json_encode( $requestData ));

                $response->type_id = $UserRequest->ride_type_id;

            }  else if($response->admin_service == "SERVICE") {

                $UserRequest = \App\Models\Service\ServiceRequest::find($response->transaction_id);

                $payment = \App\Models\Service\ServiceRequestPayment::where('service_request_id', $UserRequest->id)->first();
                $payment->payable = 0;
                $payment->save();

                $UserRequest->paid = 1;
                $UserRequest->status = 'COMPLETED';
                $UserRequest->save();

                //for create the transaction
                (new  \App\Http\Controllers\V1\Service\Provider\ServeController)->callTransaction($UserRequest->id);
                $requestData = ['type' => 'SERVICE', 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => $UserRequest->city_id, 'user' => $UserRequest->user_id ];
                app('redis')->publish('checkServiceRequest', json_encode( $requestData ));

                $response->type_id = $UserRequest->service_id;

            } else if($response->admin_service == "DELIVERY") {
                
                 $UserRequest = \App\Models\Delivery\DeliveryRequest::find($response->transaction_id);
                $delivery = \App\Models\Delivery\Delivery::where('delivery_request_id',$UserRequest->id)->first();
                \Log::info('delivery details:'. $delivery );
                $deliveryPayment = \App\Models\Delivery\DeliveryPayment::where('delivery_id', $delivery->id)->update(['payment_id' => $response->payment_id]);
                   $UserRequest->paid = 1;
                   $UserRequest->status = 'PICKEDUP';
                   $UserRequest->save();
                           //for create the transaction
              (new \App\Http\Controllers\V1\Delivery\Provider\TripController)->callTransaction($UserRequest->id);

             $requestData = ['type' => $UserRequest->admin_service, 'room' => 'room_'.$UserRequest->company_id, 'id' => $UserRequest->id, 'city' => $UserRequest->city_id, 'user' => $UserRequest->user_id ];
             app('redis')->publish('checkDeliveryRequest', json_encode( $requestData ));

            $delivery->status = 'STARTED';
            $delivery->started_at = Carbon::now();
            $delivery->save();
            \Log::info('delivery details after save:'. $delivery );

            \App\Models\Delivery\Delivery::where('id', $UserRequest->id)->update(['paid' => 1]);
             $response->type_id = $UserRequest->delivery_type_id;

            } else {

                // $log = PaymentLog::where('transaction_code', $request->order)->first();
                // $log->save();
                $request->request->add(['paymentId' => $request->merchant_order_ext_ref]);

                return (new \App\Http\Controllers\V1\Order\User\HomeController)->createOrder($request);

            }

            return Helper::getResponse([ 'data' => $response, 'message' => 'Payment Success!' ]);

            }
       
    }


}
