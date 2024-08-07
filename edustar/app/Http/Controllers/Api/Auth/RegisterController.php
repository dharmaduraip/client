<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use App\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\Api\VerificationController;
class RegisterController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(2);
	}

    public function userregister()
    {
        $setting = Setting::first();
        return response()->json([
            'gsetting' => $setting
        ],200);
    }

    public function register(Request $request){
    	$this->validate($request, [
    		'fname' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'lname' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:6|confirmed',
    	]);
        
    	$config = Setting::first();

    	if($config->mobile_enable == 1){
    	    
    	    $request->validate([
    	           'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:15|unique:users,mobile'
    	    ]);
    	    
    	}
    	
        if($config->verify_enable == 0)
        {
            $verified = \Carbon\Carbon::now()->toDateTimeString();
        }
        else
        {
            $verified = NULL;
        }

    	$user = User::create([
    	    
    		'fname' => request('fname'),
            'lname' => request('lname'),
    		'email' => request('email'),
            'email_verified_at'  => $verified,
            'phone_code' => request('phone_code'),
            'iso_code' => request('iso_code'),
            'mobile' => request('mobile'),
    		'password' => bcrypt(request('password')),

    	]);
        
        $user->assignRole('User');

        if($config->w_email_enable == 1){
            if($config->verify_enable == 0)
            {
              try{
                    Mail::to(request('email'))->send(new WelcomeUser($user));
                    // return response()->json('Registration done.', 200);
                }
                catch(\Exception $e){
                    // return response()->json('Registration done. Mail cannot be sent', 201);
                }
            }
        }
    	
        if($config->verify_enable == 0)
        {
            return $this->issueToken($request, 'password');  
        }
        else
        {
            if($verified != NULL)
            {
                return $this->issueToken($request, 'password');  
            }
            else
            {
               $user->sendEmailVerificationNotificationViaAPI();
               Mail::to(request('email'))->send(new WelcomeUser($user));
               return response()->json('Verify your email', 402); 
            }
            
        }
    }

   

    public function verifyemail(Request $request){
        $user = User::where(['email' => $request->email, 'verifyToken' => $request->token])->first();
        if($user){
            $user->status=1; 
            $user->verifyToken=NULL;
            $user->save();
            Mail::to($user->email)->send(new WelcomeUser($user));
            return $this->issueToken($request, 'password');
        }else{
            return response()->json('user not found', 401);
        }
    }

}
