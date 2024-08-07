<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use App\Setting;
use App\Cart;
use Auth;
use App\Currency;
use App\Wishlist;
use App\Order;
use Mail;
use App\Mail\SendOrderMail;
use App\Mail\AdminMailOnOrder;
use App\Course;
use App\User;
use Notification;
use Carbon\Carbon;
use App\InstructorSetting;
use App\PendingPayout;
use App\Helpers\TwilioMsg;
use App\Notifications\AdminOrder;
use App\Mail\GiftOrder;
use App\Helpers\Africastalking;
use App\Notifications\UserEnroll;


class PesapalPaymentController extends Controller
{
    public function payPesapal(Request $request)
    {  

        // $carts = Cart::with('courses','bundle')->where('user_id', Auth::User()->id)->get();
        // echo"<pre>";print_r($request->toArray());exit();
        $currency = Currency::where('default', '=', '1')->first();
        $currency_code = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
        $amount = $request->amount;
        $user = Auth::User();
        $settings = Setting::first();
        $pesapal_mode = getenv('PESAPAL_MODE');

       
         try{
            // 1. Authentication Endpoint
            $data = array(
                 'consumer_key' =>  getenv("PESAPAL_CONSUMER_KEY"),
                 'consumer_secret' => getenv("PESAPAL_CONSUMER_SECRET"),
            );
            
            $json = json_encode($data);
            if($pesapal_mode == "live")
            {
                $url = 'https://pay.pesapal.com/v3/api/Auth/RequestToken';
            }
            else if($pesapal_mode == "sandbox")
            {
                $url = 'https://cybqa.pesapal.com/pesapalv3/api/Auth/RequestToken';
            }
            $ch = curl_init($url);
             
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json'
            ));
             
            $response = curl_exec($ch);
            if(curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            } 
            curl_close($ch);
            $result = json_decode($response);
           
            if(!empty($result->token))
            {
                $settings->pesapal_token = $result->token;
                $settings->save();
            }
            else
            {
                return redirect()->back()->with('message',"Please Try again.");
            }

            if($settings->pesapal_ipn_id == Null)
            {
                  // 2. IPN URL Registration Endpoint
                $data = array(
                    'url' =>  url('/pesapal_status'),
                    'ipn_notification_type' => 'GET',
                );
                
                $json = json_encode($data);
                if($pesapal_mode == "live")
                {
                    $url = 'https://pay.pesapal.com/v3/api/URLSetup/RegisterIPN';
                }
                else if($pesapal_mode == "sandbox")
                {
                    $url = 'https://cybqa.pesapal.com/pesapalv3/api/URLSetup/RegisterIPN';
                }
                $ch = curl_init($url);
                 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: '.$settings->pesapal_token
                ));
                 
                $response = curl_exec($ch);
                if(curl_errno($ch)) {
                    echo 'Error: ' . curl_error($ch);
                } 
                curl_close($ch);
                $result1 = json_decode($response);
                if(!empty($result1->ipn_id))
                {
                    $settings->pesapal_ipn_id = $result1->ipn_id;
                    $settings->save();
                }
                else
                {
                    return redirect()->back()->with('message',"Please Try again..");
                }
            }

            $orderid = rand(0, 99999);
            $data = array(
                 'id' =>  'pesapal_'.$orderid,
                 'currency' => $currency_code,
                 'amount' => $amount,
                 'description' => 'course purchase',
                 'callback_url' => url('/pesapal_status'),
                 'notification_id' => $settings->pesapal_ipn_id,
                 'billing_address' => [
                        'email_address' => $user->email
                 ],
            );
            $json = json_encode($data);
            
            if($pesapal_mode == "live")
            {
                $url = 'https://pay.pesapal.com/v3/api/Transactions/SubmitOrderRequest';
            }
            else if($pesapal_mode == "sandbox")
            {
                $url = 'https://cybqa.pesapal.com/pesapalv3/api/Transactions/SubmitOrderRequest';
            }
            $ch = curl_init($url);
             
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: '.$settings->pesapal_token
            ));
             
            $response = curl_exec($ch);
            if(curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
            } 
            curl_close($ch);
            $result3 = json_decode($response);
            if(!empty($result3->redirect_url))
            {   
                return redirect($result3->redirect_url);
            }
            else
            {
                $settings->pesapal_ipn_id = NULL;
                $settings->save();
                if(empty($result3->error->message))
                {
                    return redirect()->back()->with('message',"Please Try again ...");
                }
                else
                {
                    return redirect()->back()->with('message',$result3->error->message.".Please Try again ...");
                }
            }
        }
        catch (\Swift_TransportException $e) {

        }
    }


    public function paymentStatus(Request $request,$sale_id = NULL, $file = NULL)
    {
        $carts = Cart::with('courses','bundle')->where('user_id', Auth::User()->id)->get();
        $settings = Setting::first();
        $user = Auth::User();
        $currency = Currency::where('default', '=', '1')->first();
        $currency_code = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
        $currency_symbol = Currency::where('code', $currency_code)->first();
        $currencysymbol = $currency_symbol->symbol;
        $pesapal_mode = getenv('PESAPAL_MODE');

        $curl_handle = curl_init();
        if($pesapal_mode == "live")
        {
            $url = "https://pay.pesapal.com/v3/api/Transactions/GetTransactionStatus?orderTrackingId=".$request->OrderTrackingId;
        }
        else if($pesapal_mode == "sandbox")
        {
            $url = "https://cybqa.pesapal.com/pesapalv3/api/Transactions/GetTransactionStatus?orderTrackingId=".$request->OrderTrackingId;
        }
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: '.$settings->pesapal_token
        ));
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        $curl_data = curl_exec($curl_handle);
        curl_close($curl_handle);
        $response_data = json_decode($curl_data);
        $gsettings = Setting::first();
        $current_date = Carbon::now();
        if($response_data->status_code == "1" || $response_data->payment_status_description == "Completed")
        {    
            if(Session::get('one_order_course') !== null && Session::get('one_order_user') !== null) {

                $payment_method = "pesapal";
                $txn_id = $request->OrderTrackingId;
                $pesapal_token = $gsettings->pesapal_token;
                $merchant_reference = $response_data->merchant_reference;
                $payment_status = "1";
                $auth_user_id = Auth::User()->id;
                return $this->oneorder($txn_id, $payment_method, $sale_id, $file, $payment_status, $auth_user_id,$pesapal_token,$merchant_reference);
            }
            foreach($carts as $cart)
            {
                if ($cart->offer_price != 0 && $cart->offer_price != NULL)
                {
                    $pay_amount =  $cart->offer_price;
                }
                else
                {
                    $pay_amount =  $cart->price;
                }
                $string =  currency($pay_amount, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) ;
                $str = preg_replace('/\D/', '', $string);
                $double = floatval($str);
                $pay_amount = $double/100;
                if ($cart->disamount != 0 || $cart->disamount != NULL)
                {
                    $cpn_discount =  $cart->disamount;
                }
                else
                {
                    $cpn_discount =  '';
                }


                $lastOrder = Order::orderBy('created_at', 'desc')->whereNotNull('order_id')->first();

                if ( ! $lastOrder )
                {
                    // We get here if there is no order at all
                    // If there is no number set it to 0, which will be 1 at the end.
                    $number = 0;
                }
                else
                { 
                    $number = substr($lastOrder->order_id, 3);
                }

                if($cart->type == 1)
                {
                    $bundle_id = $cart->bundle_id;
                    $bundle_course_id = $cart->bundle->course_id;
                    $course_id = NULL;
                    $duration = NULL;
                    $instructor_payout = 0;
                    $instructor_id = $cart->bundle->user_id;

                    if($cart->bundle->duration_type == "m")
                    {
                        
                        if($cart->bundle->duration != NULL && $cart->bundle->duration !='')
                        {
                            $days = $cart->bundle->duration * 30;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        }
                        else{
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    }
                    else
                    {

                        if($cart->bundle->duration != NULL && $cart->bundle->duration !='')
                        {
                            $days = $cart->bundle->duration;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        }
                        else{
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }

                    }
                }
                else
                {

                    if($cart->courses->duration_type == "m")
                    {
                        
                        if($cart->courses->duration != NULL && $cart->courses->duration !='')
                        {
                            $days = $cart->courses->duration * 30;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        }
                        else{
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }
                    }
                    else
                    {

                        if($cart->courses->duration != NULL && $cart->courses->duration !='')
                        {
                            $days = $cart->courses->duration;
                            $todayDate = date('Y-m-d');
                            $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                        }
                        else{
                            $todayDate = NULL;
                            $expireDate = NULL;
                        }

                    }
                    $setting = InstructorSetting::first();


                    if($cart->courses->instructor_revenue != NULL)
                    {
                        $x_amount = $pay_amount * $cart->courses->instructor_revenue;
                        $instructor_payout = $x_amount / 100;
                    }
                    else
                    {

                        if(isset($setting))
                        {
                            if($cart->courses->user->role == "instructor")
                            {
                                $x_amount = $pay_amount * $setting->instructor_revenue;
                                $instructor_payout = $x_amount / 100;
                            }
                            else
                            {
                                $instructor_payout = 0;
                            }
                            
                        }
                        else
                        {
                            $instructor_payout = 0;
                        }  
                    }

                    $bundle_id = NULL;
                    $course_id = $cart->course_id;
                    $bundle_course_id = NULL;
                    $duration = $cart->courses->duration;
                    $instructor_id = $cart->courses->user_id;

                }
                $created_order = Order::create([
                    'course_id' => $course_id,
                    'user_id' => Auth::User()->id,
                    'instructor_id' => $instructor_id,
                    'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                    'merchant_reference' => $response_data->merchant_reference,
                    'transaction_id' => $request->OrderTrackingId,
                    'pesapal_token' => $gsettings->pesapal_token,
                    'payment_method' => "pesapal",
                    'total_amount' => $pay_amount ?? '0',
                    'coupon_discount' => $cpn_discount,
                    'currency' => $currency_code,
                    'currency_icon' => $currencysymbol,
                    'duration' => $duration,
                    'enroll_start' => $todayDate,
                    'enroll_expire' => $expireDate,
                    'instructor_revenue' => $instructor_payout,
                    'bundle_id' => $bundle_id,
                    'sale_id' => $sale_id,
                    'proof' => $file,
                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                    ]
                );
                
                Wishlist::where('user_id',Auth::User()->id)->where('course_id', $cart->course_id)->delete();

                Cart::where('user_id',Auth::User()->id)->delete();


                if($instructor_payout != 0)
                {
                    if($created_order)
                    {
                        if($cart->type == 0)
                        {
                            if($cart->courses->user->role == "instructor")
                            {
                                $created_payout = PendingPayout::create([
                                    'user_id' => $cart->courses->user_id,
                                    'course_id' => $cart->course_id,
                                    'order_id' => $created_order->id,
                                    'transaction_id' => $request->OrderTrackingId,
                                    'total_amount' => $pay_amount,
                                    'currency' => $currency_code,
                                    'currency_icon' => $currencysymbol,
                                    'instructor_revenue' => $instructor_payout,
                                    'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                                    'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                                    ]
                                );
                            }
                        }
                    }
                }

                if($created_order){
                    if ($gsettings->twilio_enable == '1') {

                        try{
                            $recipients = Auth::user()->mobile;
                            
            
                            $msg = 'Hey'. ' ' .Auth::user()->fname . ' '.
                                    'You\'r successfully enrolled in '. $cart->courses->title .
                                    'Thanks'. ' ' . config('app.name');
                        
                            TwilioMsg::sendMessage($msg, $recipients);

                        }catch(\Exception $e){
                            
                        }

                    }
                    if ($gsettings->africas_talking_enable == '1') {
                        try{
                            $recipients = Auth::user()->mobile;
                            
            
                            $msg = 'Hey'. ' ' .Auth::user()->fname . ' '.
                                    'You\'r successfully enrolled in '. $cart->courses->title .
                                    'Thanks'. ' ' . config('app.name');
                        
                            Africastalking::sendMessage($msg, $recipients);

                        }catch(\Exception $e){
                            
                        }
                    }

                }
                


                if($created_order){
                    if (env('MAIL_USERNAME')!=null) {
                        try{
                            
                            /*sending user email*/
                            $x = 'You are successfully enrolled in a course';
                            $order = $created_order;
                            Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));


                            /*sending admin email*/
                            if(isset($cart->courses))
                            {
                                $x = 'User Enrolled in course '. $cart->courses->title;
                                $order = $created_order;
                                Mail::to($cart->courses->user->email)->send(new AdminMailOnOrder($x, $order)); 
                            }
                            


                        }catch(\Swift_TransportException $e){
                            
                        }

                    }
                }

                if($cart->type == 0)
                {

                    if($created_order){
                        // Notification when user enroll
                        $cor = Course::where('id', $cart->course_id)->first();

                        $course = [
                          'title' => $cor->title,
                          'image' => $cor->preview_image,
                        ];

                        $enroll = Order::where('user_id', Auth::User()->id)->where('course_id', $cart->course_id)->first();

                        if($enroll != NULL)
                        {
                            $user = User::where('id', $enroll->user_id)->first();
                            Notification::send($user,new UserEnroll($course));
                            
                        }

                        $order_id = $created_order->order_id;
                        $url = route('view.order', $created_order->id);

                        if($cor != NULL)
                        {
                            $user = User::where('id', $cor->user_id)->first();
                            Notification::send($user,new AdminOrder($course, $order_id, $url));
                            
                        }
                    }

                }
            }
            $gsettings->pesapal_ipn_id = NULL;
            $gsettings->save();
            return redirect('confirmation');
        }
        else
        {
            return redirect()->back()->with('message',$response_data->description);
        }

    }

    public function oneorder($txn_id, $payment_method, $sale_id = NULL, $file = NULL, $payment_status = NULL, $auth_user_id = NULL,$pesapal_token = NULL,$merchant_reference = NULL)
    {

        $course_id = Session::get('one_order_course');

        $user_id = Session::get('one_order_user');

        $course = Course::where('id', $course_id)->first();

        $user = User::where('id', $user_id)->first();


        $gsettings = Setting::first();

        $current_date = Carbon::now();

        $currency = Currency::where('default', '=', '1')->first();
        $currency_code = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code;
        $currency_symbol = Currency::where('code', $currency_code)->first();
        $currencysymbol = $currency_symbol->symbol;

        if($payment_status == '0')
        {
            $pay_status =  '0';
        }
        else
        {
            $pay_status =  1;
        }



            if ($course->discount_price != 0)
            {
                $pay_amount =  $course->discount_price;
            }
            else
            {
                $pay_amount =  $course->price;
            }
            $string =  currency($pay_amount, $from = $currency->code, $to = Session::has('changed_currency') ? Session::get('changed_currency') : $currency->code, $format = true) ;
            $str = preg_replace('/\D/', '', $string);
            $double = floatval($str);
            $pay_amount = $double/100;
            
            $cpn_discount =  NULL;
            
            $lastOrder = Order::orderBy('created_at', 'desc')->whereNotNull('order_id')->first();

            if ( ! $lastOrder )
            {
                // We get here if there is no order at all
                // If there is no number set it to 0, which will be 1 at the end.
                $number = 0;
            }
            else
            { 
                $number = substr($lastOrder->order_id, 3);
            }

            

                if($course->duration_type == "m")
                {
                    
                    if($course->duration != NULL && $course->duration !='')
                    {
                        $days = $course->duration * 30;
                        $todayDate = date('Y-m-d');
                        $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    }
                    else{
                        $todayDate = NULL;
                        $expireDate = NULL;
                    }
                }
                else
                {

                    if($course->duration != NULL && $course->duration !='')
                    {
                        $days = $course->duration;
                        $todayDate = date('Y-m-d');
                        $expireDate = date("Y-m-d", strtotime("$todayDate +$days days"));
                    }
                    else{
                        $todayDate = NULL;
                        $expireDate = NULL;
                    }

                }


                $setting = InstructorSetting::first();


                if($course->instructor_revenue != NULL)
                {
                    $x_amount = $pay_amount * $course->instructor_revenue;
                    $instructor_payout = $x_amount / 100;
                }
                else
                {

                    if(isset($setting))
                    {
                        if($course->user->role == "instructor")
                        {
                            $x_amount = $pay_amount * $setting->instructor_revenue;
                            $instructor_payout = $x_amount / 100;
                        }
                        else
                        {
                            $instructor_payout = 0;
                        }
                        
                    }
                    else
                    {
                        $instructor_payout = 0;
                    }  
                }

                

                $bundle_id = NULL;
                $course_id = $course->id;
                
                $duration = $course->duration;
                $instructor_id = $course->user_id;
            

           
                   
            $created_order = Order::create([
                'course_id' => $course_id,
                'user_id' => $user->id,
                'instructor_id' => $instructor_id,
                'order_id' => '#' . sprintf("%08d", intval($number) + 1),
                'transaction_id' => $txn_id,
                'merchant_reference' => $merchant_reference,
                'pesapal_token' => $pesapal_token,
                'payment_method' => $payment_method,
                'total_amount' => $pay_amount,
                'coupon_discount' => $cpn_discount,
                'currency' => $currency_code,
                'currency_icon' => $currencysymbol,
                'duration' => $duration,
                'enroll_start' => $todayDate,
                'enroll_expire' => $expireDate,
                'instructor_revenue' => $instructor_payout,
                'bundle_id' => $bundle_id,
                'sale_id' => $sale_id,
                'status' => $pay_status,
                'proof' => $file,
                'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                ]
            );
            
            

            if($instructor_payout != 0)
            {
                if($created_order)
                {
                    
                    if($course->user->role == "instructor")
                    {
                        $created_payout = PendingPayout::create([
                            'user_id' => $course->user_id,
                            'course_id' => $course->id,
                            'order_id' => $created_order->id,
                            'transaction_id' => $txn_id,
                            'total_amount' => $pay_amount,
                            'currency' => $currency_code,
                            'currency_icon' => $currencysymbol,
                            'instructor_revenue' => $instructor_payout,
                            'created_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                            'updated_at'  => \Carbon\Carbon::now()->toDateTimeString(),
                            ]
                        );
                    }
                    
                }
            }

            if($created_order){
                if ($gsettings->twilio_enable == '1') {

                    try{
                        $recipients = Auth::user()->mobile;
                        
        
                        $msg = 'Hey'. ' ' .Auth::user()->fname . ' '.
                                'You\'r successfully enrolled in '. $course->title .
                                'Thanks'. ' ' . config('app.name');
                    
                        TwilioMsg::sendMessage($msg, $recipients);

                    }catch(\Exception $e){
                        
                    }

                }
                if ($gsettings->africas_talking_enable == '1') {
                    try{
                        $recipients = Auth::user()->mobile;
                        
        
                        $msg = 'Hey'. ' ' .Auth::user()->fname . ' '.
                                'You\'r successfully enrolled in '. $course->title .
                                'Thanks'. ' ' . config('app.name');
                    
                        Africastalking::sendMessage($msg, $recipients);

                    }catch(\Exception $e){
                        
                    }
                }
            }
            


            if($created_order){
                if (env('MAIL_USERNAME')!=null) {
                    try{
                        
                        /*sending user email*/
                        $x = 'You are successfully enrolled in a course';
                        $order = $created_order;
                        Mail::to($user->email)->send(new SendOrderMail($x, $order));


                        /*sending user email*/
                        $x = 'A Gift for you !!';
                        $order = $created_order;
                        $order_id = $order->order_id;
                        Mail::to($user->email)->send(new GiftOrder($x, $order,$order_id,$course));


                        /*sending admin email*/
                        $x = 'User Enrolled in course'. $course->title;
                        $order = $created_order;
                        Mail::to($course->user->email)->send(new AdminMailOnOrder($x, $order));


                    }catch(\Swift_TransportException $e){
                        
                    }

                }
            }

            

            if($created_order){
                // Notification when user enroll
                $cor = Course::where('id', $course->id)->first();

                $course = [
                  'title' => $cor->title,
                  'image' => $cor->preview_image,
                ];

                

                if($user_id != NULL)
                {
                    $user = User::where('id', $user_id)->first();
                    Notification::send($user,new UserEnroll($course));
                    
                }

                $order_id = $created_order->order_id;
                $url = route('view.order', $created_order->id);

                if($cor != NULL)
                {
                    $user = User::where('id', $cor->user_id)->first();
                    Notification::send($user,new AdminOrder($course, $order_id, $url));
                    
                }
            }



        session()->forget('one_order_course');

        session()->forget('one_order_user');

        $gsettings = Setting::first();
        $gsettings->pesapal_ipn_id = NULL;
        $gsettings->save();
        \Session::flash('delete', 'Payment successfull');
        
        return redirect('confirmation');

    }

    
}
