<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Response, Authorizer, Hash ;
use Illuminate\Http\Request;
use App\User;
use App\Models\Deliveryboy;
use App\Http\Controllers\EmailController as emailcon;
use App\Http\Controllers\UserController as usercon;
use App\Models\Restaurant;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Front\OrderDetails;
use App\Models\OrderDetail;

class RegisterController extends Controller {

	public function checkUserphone(Request $request)
	{

		$rules['phone_number'] 		= 'required|min:10';
		$this->validateDatas($request->all(),$rules);
		$usercon = new usercon;
		$request->phone = $request->phone_number;
		$result = $usercon->postCheckphone($request);
		$request->user = 1; 
		if($result == 1)
		{
			if($request->group_id == '3'){
			$res  = $this->check__partner_restaurant_status($request->phone);
			if($res)
			{
				return $res;
				exit();
			}
		    }
			$response['message'] = 'Phone Number Exist';
		}elseif($result == 2)
		{
			$response['message'] = 'Account is either inactive or blocked';
			$status = 422;
			return \Response::json($response,$status);
		}else
		{
			$request->register = "1";
			$response['message'] = 'Phone Number Does Not Exist';
		}
		$results = $this->sendotp($request);
		if($results)
		{
			$status = 200;
			$results['message'] = 'Success';
		}else
		{
			$results['message'] = 'Error';
			$status = 422;
		}
		return \Response::json($results,$status);
	}

	public function checkUserotp(Request $request)
	{
		$rules['phone_number'] 		= 'required|min:10';
		$rules['otp']			 	= 'required|min:5|max:5';
		if(isset($request->updatePhonenumber))
		{
			$rules['phone_number'] 	= 'required|unique:tb_users,phone_number|unique:abserve_deliveryboys,phone_number|numeric';
    		$rules['social_id']		= 'required';
		}
		$this->validateDatas($request->all(),$rules);
		$usercon = new usercon;
		$request->phone = $request->phone_number;
		$result = $usercon->postCheckphone($request);
		$request->user = 1;
		if($result == 1) {
			$results = $this->signin($request);
		} else {
			$results = $this->checkRegisterotp($request);
			if(isset($request->updatePhonenumber))
			{	
				if($results->getData()->message == 'OTP Valid')
				{
			    	$user_detail = \DB::table('tb_users')->where('apple_id',$request->social_id )->update(array('phone_number' => $request->phone_number));
			    	$response['message'] = 'Phone Number Updated Successfully';
					$status = 200;
					return \Response::json($response,$status);
				}
			}
		}
		return $results;
	}

	public function checksocialLogin(Request $request)
	{ 
		$usercon = new usercon;
		$result = $usercon->postChecksocial($request);
		if($request->from == 'fb'){
    		$param = 'fb_id';
		}elseif($request->from == 'apple'){
    		$param = 'apple_id'; }
		else{
    		$param = 'social_id';}
		if(json_decode($result)->result == 1)
		{
			$status = 200;
			$select = ['group_id','username','phone_number','id'];
			$user_detail = User::select($select)->where($param,$request->social_id )->first();
			$response['message'] = 'Success';
			$user_detail['access_token'] = json_decode($result)->access_token;
			$response['data'] = $user_detail;
			return \Response::json($response,$status);
		}else
		{
			$status = 422;
			$response['message'] = "NO-ACCOUNT";
			return \Response::json($response,$status);
		}
	}

	public function checkphone(Request $request)
	{
		$rules['phone_number'] 		= 'required|min:10';
		$this->validateDatas($request->all(),$rules);
		$usercon = new usercon;
		$request->phone = $request->phone_number;
		$result = $usercon->postCheckphone($request);
		if($request->register)
		{
			if($result == 1)
			{
				$response['message'] = 'Phone Number Already Exists';
				$status = 422;
				return \Response::json($response,$status);
			}else
			{
				$status = 200;
				$result = $this->sendotp($request);
				$response['message'] = 'Phone Number Does Not Exist';
				return $result;
			}
		}else
		{
			if($result == 1)
			{
				$response['message'] = 'Phone Number Exist';
				$status = 200;
				$result = $this->sendotp($request);
				return $result;
			}else
			{
				$response['message'] = 'Phone Number Does Not Exist';
				$status = 422;
				return \Response::json($response,$status);
			}
		}
	}

	public function sendotp(Request $request)
	{
		if($request->register)
		{
			$rules['phone_number'] 	= 'required';
		}else
		{
			$rules['phone_number'] 	= 'required';
		}
		// print_r($rules);exit;
		$this->validateDatas($request->all(),$rules);
		$usercon = new usercon;
		$req = new request;
		$req['phone'] = $request->phone_number;
		if(\Request::segment(2) == 'deliveryOtp'){
			$req['from'] = $request->from;
		}
		$result = $usercon->postSendotpreg($req);
		if($request->register)
		{
		$query 	= \DB::table('tbl_otp_buffer')->insert(
			[
				"phone_number"	=>	$request->phone_number,
				"otp"			=>	$result->getData()->otp
			]);
			$response['data']['register'] = '1';
		}
		if($request->user)
		{
			$u_check = User::where('phone_number', $request->phone)->first();
		    if($u_check != null && $u_check != ''){
				if($u_check->c_page != 'Completed' && $u_check->group_id == '5'){
					$response['data']['register'] = '1';
					// $response['data']['c_page'] = $u_check->c_page;
				}
		    }/*elseif(($u_check == null && $u_check == '') && $request->group_id == '5'){
		    	$response['data']['c_page'] = 'profile_page';
		    }*/
			$response['data']['otp'] = $result->getData()->otp;
			return $response;
		}else
		{
			$data = $result->getData();
			$otp = \DB::table('tb_users')->where('phone_number', $request->phone_number)->update(['delivery_otp' => $data->otp]);
			$order_update = OrderDetail::where('id', $request->order_id)->whereIn('status', ['boyPicked', 'Reached'])->update(['status' => 'otpSend']);
			return $result;
		}
	}

	public function checkRegisterotp(Request $request)
	{
		$rules['phone_number'] 		= 'required';
		$rules['otp']			 	= 'required|min:5|max:5';
		$this->validateDatas($request->all(),$rules);
		$usercon 		=	new usercon;
		$req 			=	new request;
		$req['phone']	=	$request->phone_number;
		$req['otp']		=	$request->otp;
		$result		 	=	\DB::table('tbl_otp_buffer')->where("phone_number",$req['phone'])->where("otp",$req['otp'])->get();
		if(count($result) > 0)
		{
			\DB::table('tbl_otp_buffer')->where('phone_number',$req['phone'])->delete();
			$response['message'] = 'OTP Valid';
			$response['register'] = 1;
			$status = 200;
		}else
		{
			$response['message'] = 'OTP Invalid';
			$status = 422;
		}
		return \Response::json($response,$status);
	}

	public function signin(Request $request)
	{
		if(!isset($request->social_id) || $request->social_id == '') {
			$mobile	= $request->phone_number;
			$otp	= $request->otp;
			$usercon	= new usercon;
			$response	= $usercon->checkloginotp($mobile,$otp);
		} else {
			$response['result'] = 1;
		}
		$rules['otp'] = 'required';
		$rules['phone_number'] = 'required';
		$rules['mobile_token'] = 'required';
		$rules['device_id'] = 'required';
		$request['grant_type'] = 'password';
		$request['password']  = $request->otp;
		$this->validateDatas($request->all(),$rules);

		$status		= 422;
		$usercon	= new usercon;
		$request->phone = $request->phone_number;
		$check = $usercon->postCheckphone($request);
		if($response['result'] == 1) {
			if($check == 1 || $check == 2) {
				$group_id = $request->group_id;
				if ($group_id == 8) {
					$request['user_type'] = 'delivery';
					$user_detail = \DB::table('abserve_deliveryboys')->where('phone_number',$mobile)->where('group_id',$group_id)->first();
				} else {
					$request['user_type'] = 'user';
					// $user_detail = \DB::table('tb_users')->where('phone_number',$mobile)->first();
					$user_detail = User::where('phone_number',$mobile)->where('group_id',$group_id)->first();
				}
				if(!empty($user_detail)) {
					$active = $user_detail->active;
					if($user_detail->p_active == '1' || $user_detail->d_active == '1' || $active == '1' && $user_detail->p_active != '2' && $user_detail->d_active != '2') {
						if($user_detail->active == '4'/*$user_detail->p_active == '1' && !Restaurant::where('partner_id',$user_detail->id)->exists() && $request->group_id == '3'*/){
							$message = 'Kindly create shop using Website and then login here';
							$code = 422;
						} else {
							$user_id = $user_detail->id;
							if(\Auth::loginUsingId($user_id)) {
							
								if($request->user_type !== null && $request->user_type == 'delivery') {
									$user = Deliveryboy::find(\Auth::user()->id);
								} else {
									$user = User::find(\Auth::user()->id);
								}
								$response['message'] = true;
								$response['message'] = 'success';
								$user->last_login	= date('Y-m-d H:i:s');
								$user->device		= isset($request->device) ? $request->device : '';
								$user->mobile_token = $request->mobile_token;
								$user->lat = $request->lat;
								$user->lang = $request->long;
								$user->save();
								\AbserveHelpers::updateCartAndSearchKeyword($user->id,$request->device_id);
								$message = 'Logged In';
								if($user_detail->p_active == 1 && $request->group_id == '3') {
									$response["data"]["email"]	= (isset($user_detail) && $user_detail->email != '' ) ? ($user_detail->email) : '';
									$bank = \DB::table('tb_partner_accounts')->where('partner_id',$user->id)->first();
									$response["data"]["business_name"]	= $user->business_name;
									$response["data"]["cuisine_type"]	= $user->cuisine_type;
									$response["data"]["business_addr"]	= $user->business_addr;
									$response["data"]["Bank_Name"]		= (isset($bank) && $bank->Bank_Name != '' ) ? ($bank->Bank_Name) : '';
									$response["data"]["Bank_AccName"]	= (isset($bank) && $bank->Bank_AccName != '') ? ($bank->Bank_AccName) : '' ;
									$response["data"]["Bank_AccNumber"]	= (isset($bank) && $bank->Bank_AccNumber != '') ? $bank->Bank_AccNumber : '';
									$response["data"]["ifsc_code"]		= (isset($bank) && $bank->ifsc_code != '') ? $bank->ifsc_code : '';
									$response["data"]["aadhar_no"]		= (isset($bank) && $bank->aadhar_no != '') ? $bank->aadhar_no : '';
									$response["data"]["gst_no"]		= (isset($bank) && $bank->gst_no != '') ? $bank->gst_no : '';
									$response["data"]["fssai_no"]		= (isset($bank) && $bank->fssai_no != '') ? $bank->fssai_no : '';
									$response["data"]["pan_no"]		= (isset($bank) && $bank->pan_no != '') ? $bank->pan_no : '';
									$checkrestaurant  = Restaurant::where('partner_id',$user->id)->exists();
									$response['register'] = '0';
									if(!$checkrestaurant){
										$response["register"]		= '2';
									}
								}
								if($user_detail->group_id == 5) {
									$response["data"]["avatar"]		= $user->src;
									$response["data"]["c_page"]     = $user->c_page;
									$response["data"]["mode"]       = $user->mode;
								}
								$response["data"]["phone_number"]	= (string) $user->phone_number;
								$response["data"]["address"] = (isset($user) && $user->address != '' ) ? ($user->address) : '';
								$response["data"]["name"]	        = $user_detail->username;
								$response["data"]["email"]	        = $user_detail->email;
								$response["data"]["avatar"]	        = URL($user_detail->avatar);
								if($request->group_id == '3' && $user_detail->p_active == '1'){
									$response["data"]['id'] = $user->id;
									$response["data"]['user_id'] = $user->id;
								} else {
									$response["data"]['user_id'] = $user->id;
									$response["data"]['id'] = $user->id;
								}
								if($user_detail->d_active == '1'){
								$response["data"]["bike"]	    = $user_detail->bike;
								$response["data"]["license"]	= $user_detail->license;
						     	}
								$code = 200;
								$sToken = JWTAuth::fromUser($user);
								$response["data"]["access_token"] = $sToken;
							} else {
								$message = 'Your Credentials are not match';
								$code = 422;
							}
						}
					} elseif($active == 2 ) {
						$message = 'Your Account has been blocked';
						$code = 422;
					} else {
						$message = 'Your Account is inactive';
						$code = 422;
					}
				} else {
					$user		= User::select('group_id')->where('phone_number',$mobile)->first();
					$group_name	= $this->get_groupname($user->group_id);
					$message	= 'This phone number is already registered as '.$group_name;
					$code		= 422;
				}
			} else {
				$message	= 'Account Not Found! Please Register';
				$code		= 422;
			}
		} else {
			$message	= 'OTP Incorrect';
			$code		= 422;
		}
		$response['message'] = $message;
		unset($response['result']);
		return Response::json($response,$code);
	}

	public function checkLoginotp(Request $request)
	{
		$rules['phone_number'] 	= 'required';
		$rules['otp']			= 'required|min:5|max:5';
		$this->validateDatas($request->all(),$rules);
		$usercon = new usercon;
		$req = new request;
		$phone = $request->phone_number;
		$otp = $request->otp;
		$result = $usercon->checkloginotp($phone,$otp);
		if($result['result'] == 1)
		{
			$exist = User::where('phone_number', $phone)->first();
			if($exist != null && $exist != ''){
				if($exist->group_id == '5' && $exist->c_page != 'Completed'){
					$result['c_page'] = $exist->c_page;
					$result['user_id'] = $exist->id;
				}
			}elseif(($exist == null && $exist == '') && $request->group_id == '5'){
				$result['c_page'] = 'profile_page';
				$result['user_id'] = 0;
			}
			$result['message'] = 'OTP Valid';
			$status = 200;
		}else
		{
			$result['message'] = 'OTP Invalid';
			$status = 422;
		}
		return \Response::json($result,$status);
	}

	public function checkUser(Request $request)
	{
		$rules['username'] 	= 'required|min:2|max:25|regex:/^[\pL\s\-]+$/u';
		$this->validateDatas($request->all(),$rules);
		$usercon = new usercon;
		$result = $usercon->postCheckuname($request);
		if($result == 1)
		{
			$response['message'] = 'Username Already Exists';
			$status = 422;
		}else
		{
			$status = 200;
			$response['message'] = 'Username does not exist';
		}
		return \Response::json($response,$status);
	}

	function get_groupname($group)
	{
		$result	= \DB::table('tb_groups')->select("name")->where("group_id",$group)->first();
		if (empty($result)) {
			return "Delivery Boy";
		}
		return strtolower(str_replace('s', '', $result->name));
	}

	function check__partner_restaurant_status($phone_number)
	{
		$user_detail = \DB::table('tb_users')->where('phone_number',$phone_number)->first();
		if(!empty($user_detail)){
			if($user_detail->p_active == 4 && !Restaurant::where('partner_id',$user_detail->id)->exists())
			{
				$response['message'] = 'Kindly create shop using Website and then login here';
				$status = 422;
				return \Response::json($response,$status);
				exit;
			}else{ return false; }
		}else{ return false; }
	}

	function register(Request $request)
	{
		$request->phone_code    = '91';
		$rules['username'] 		= 'required|min:2|max:25|regex:/^[\pL\s\-]+$/u';
		// $rules['phone_code'] 	= 'required';
		if($request->from == 'apple' && !empty($request->social_id) && empty($request->phone_number))
		{
			$request->phone_number = 0;
		}else{
			$rules['phone_number'] 	= 'required|unique:tb_users,phone_number|unique:abserve_deliveryboys,phone_number|numeric';
		}
		if(!empty($request->social_id))
		{
			$rules['social_id'] 	= 'required|unique:tb_users,social_id|unique:tb_users,fb_id|unique:tb_users,apple_id';
		}
		$rules['group_id'] 		= 'required|in:3,4,8';//3- partner, 4- customer, 8 -deliveryboy
		$rules['device'] 		= 'required|in:android,ios';
		$group_id = '4';
		if($request->input('group_id') !== null){
			if($request->group_id == '3'){
				$group_id = '3';
				// $rules['business_name'] 	= 'required';
				$rules['email'] 			= 'required|email';
				$rules['Bank_Name'] 		= 'required';
				$rules['Bank_AccName'] 		= 'required';
				$rules['Bank_AccNumber'] 	= 'required';
				$rules['ifsc_code'] 		= 'required';
				$rules['aadhar_no'] 		= 'required|min:12|max:12';
				$rules['gst_no'] 			= 'required|min:15|max:15';
				$rules['fssai_no'] 			= 'required|min:14|max:14';
				$rules['pan_no'] 			= 'required|min:10|max:10';
			} elseif ($request->group_id == '8') {
				$group_id = '8';
				$rules['address'] 			= 'required';
				$rules['latitude'] 			= 'required';
				$rules['longitude'] 		= 'required';
				$rules['nric_number'] 		= 'required';
				$rules['id_type'] 			= 'required';
				$rules['motorbike'] 		= 'required';
				$rules['motorbikelicense'] 	= 'required';
			}
		}

		$this->validateDatas($request->all(),$rules);
		if($group_id == '8'){
			$user = new Deliveryboy;
		} else {
			$user = new User;
		}
		$aRequestData = $request->all();
		$saveFields = 'username,phone_number,phone_code,group_id,device,address';
		if($group_id == '4'){
			$user->address = $request->business_addr;
			$user->socialmediaImg	= $request->imageURL;
			if($request->from == 'fb'){
	    		$param = 'fb_id';
			}elseif($request->from == 'apple'){
	    		$param = 'apple_id'; }
			else{
	    		$param = 'social_id';}
			$user->$param = $request->social_id;
			$user->social_type = $request->social_type;
		}elseif($group_id == '3'){
			$saveFields .= ',email';
		} elseif ($group_id == '8') {
			$saveFields .= ',address,latitude,longitude,nric_number,id_type,motorbike,motorbikelicense';
		}
		$aSaveFields = explode(',', $saveFields);
		foreach ($aSaveFields as $key => $value) {
			if($value == 'password'){
				$user->{$value} = Hash::make($request->{$value});
			} else {
				$user->{$value} = $request->{$value};
			}
		}
		$activation = $group_id != '4' ? 'manual' : CNF_ACTIVATION;
		$user->active = $activation == 'auto' ? '1' : '0';
		//$code = $activation == 'confirmation' ? rand(10000,10000000) : 0;
		$code = 1111;
		$user->activation = $code;
		$user->created_at = date('Y-m-d H:i:s');
		$user->updated_at = date('Y-m-d H:i:s');
		$user->save();

		if($activation == 'confirmation'){
			$message = "Thanks for registering! . Please check your inbox and enter verification code";
			$confirmation = 1;
		} elseif($activation=='manual'){
			$message = "Thanks for registering! . We will review your details and get back to you soon";
			$data['showMsg'] = $message;
			$confirmation = 2;
		} else {
			$message = "Thanks for registering! . Your account is active now ";   
			$confirmation = 0;
		}
		$to = $request->input('email');
		$subject = "[ " .CNF_APPNAME." ] REGISTRATION ";
		$data['aUser'] = $user;
		$data['activation'] = $activation;
		$data['password'] = $request->password;
		$view = 'emails.member.register';
		$emailcon = new emailcon;
		$emailcon->sendEmail($to,$subject,$view,$data);

		if($user->group_id == '3'){
			$data['link'] 	= \URL::to('partners/update/'.$user->id);
			$adminuser		=  User::where('group_id','1')->first();
			$toadmin		= $adminuser->email;			
			$subjectadm 	= "[ " .CNF_APPNAME." ] NEW PARTNER REGISTRATION ";
			$emailcon->sendEmail($toadmin,$subject,'emails.member.manual_account_register',$data);

			$bankFields = ['Bank_Name','Bank_AccName','Bank_AccNumber','ifsc_code','aadhar_no','gst_no','fssai_no','pan_no'];
			foreach ($bankFields as $key => $value) {
				$bank[$value] = $request->{$value};
			}
			$bank['partner_id']	= $user->id;
			$bank['Mobile']		= $request->phone_number;
			\DB::table('tb_partner_accounts')->insert($bank);
		}
		
		$response['message'] = $message;
		$response['confirmation'] = $confirmation;
		if($user->active == '1'){
			$check = [
				'email' => $request->email,
				'password' => $request->password
			];
			$login = \Auth::attempt($check);
			$user->last_login = date('Y-m-d H:i:s');
			$user->mobile_token = $request->mobile_token;
			$user->save();
			\AbserveHelpers::updateCartAndSearchKeyword($user->id,$request->device_id);
			if($request->from == 'apple' && !empty($request->social_id) && empty($request->phone_number))
			{
				$request['phone_number'] = $request->social_id;
				$data['password'] = $request->social_id;
			}
			$response["access_token"] = JWTAuth::fromUser($user);
			$response['id'] = $user->id;
			$response['phone_number'] = (string) $user->phone_number;
			$response['address'] =  $user->business_addr;
			$response['username'] = $user->username;
		}
		$status = 200;
		
		return Response::json($response,$status);
	}

	function activeAccount(Request $request)
	{
		$rules['code'] = 'required';

		$this->validateDatas($request->all(),$rules);

		$user = User::where('activation',$request->code)->first();
		if(!empty($user)){
			$uUser = User::find($user->id);
			$uUser->active = '1';
			$uUser->activation = 0;
			$uUser->email_verified = 1;
			$uUser->updated_at = date('Y-m-d H:i:s');
			$uUser->save();

			$message = 'Your account activated. Enjoy ordering...';


			$login = \Auth::loginUsingId($user->id);
			$user->last_login = date('Y-m-d H:i:s');
			$user->mobile_token = $request->mobile_token;
			$user->save();
			\AbserveHelpers::updateCartAndSearchKeyword($user->id,$request->device_id);
			$sToken = Authorizer::issueAccessToken();
			$response["access_token"] = $sToken['access_token'];
			$response['id'] = $user->id;

			$to = $uUser->email;
			$subject = "[ " .CNF_APPNAME." ] REGISTRATION ";
			$data['aUser'] = $uUser;
			$view = 'emails.member.register';
			$data['showMsg'] = $message;
			$emailcon = new emailcon;
			$emailcon->sendEmail($to,$subject,$view,$data);

			$status = 200;
			$response['message'] = $message;
		} else {
			$status = 422;
			$response['message'] = 'Invalid Code';
		}
		
		return Response::json($response,$status);
	}

	function forgetPasswordrequest(Request $request)
	{
		$rules['email'] ='required';
		$rules['user_type'] = 'required';

		$this->validateDatas($request->all(),$rules);
		$status = 422;

		$exist = false;
		if($request->user_type == 'user'){
			$user = User::where('email',$request->email)->first();
			if(!empty($user)){
				$exist = true;
				$update_user = User::find($user->id);
			}
		} elseif($request->user_type == 'deliveryboy') {
			$user = Deliveryboy::where('email',$request->email)->first();
			if(!empty($user)){
				$exist = true;
				$update_user = Deliveryboy::find($user->id);
			}
		}
		if($exist){
			$update_user->reminder = 1111;//mt_rand(1000,9999);
			$update_user->updated_at = date('Y-m-d H:i:s');
			$update_user->save();

			$data['user'] = $update_user;
			$data['from'] = 'App';
			$to = $request->email;
			$subject = CNF_APPNAME.' Forget Password';
			$view = 'emails.member.forgetPasswordRequest';

			$emailcon = new emailcon;
			$emailcon->sendEmail($to,$subject,$view,$data);

			$response['message'] = 'Code sent to your email address';
			$status = 200;
		} else {
			$status = 422;
			$response['message'] =  'Cant find user';
		}
		
		return \Response::json($response,$status);
	}

	function resetPassword(Request $request)
	{
		$rules['email']	 				= 'required';
		$rules['user_type'] 			= 'required';
		$rules['code'] 					= 'required';
		$rules['password']      		= 'required|between:6,12|confirmed';
		$rules['password_confirmation']	= 'required|between:6,12';

		$this->validateDatas($request->all(),$rules);
		$status = 422;

		$exist = false;
		if($request->user_type == 'user'){
			$user = User::where('email',$request->email)->where('reminder',$request->code)->first();
			if(!empty($user)){
				$exist = true;
				$update_user = User::find($user->id);
			}
		} elseif($request->user_type == 'deliveryboy') {
			$user = Deliveryboy::where('email',$request->email)->where('reminder',$request->code)->first();
			if(!empty($user)){
				$exist = true;
				$update_user = Deliveryboy::find($user->id);
			}
		}
		if($exist){
			$update_user->password = Hash::make($request->password);
			$update_user->reminder = '';
			$update_user->updated_at = date('Y-m-d H:i:s');
			$update_user->save();

			$response['message'] = 'Password changed successfully';
			$status = 200;
		} else {
			$status = 422;
			$response['message'] =  'Invalid code';
		}
		
		return \Response::json($response,$status);
	}

	function socialLogin(Request $request)
	{
		$rules['social_type']   = 'required|in:google,apple';
      	$rules['username']      = 'required';
      	$rules['device_id']   	= 'required';
      	/*$rules['mobile_token']  = 'required';*/
      	$rules['group_id'] 		= 'required|in:3,4,5';
      	$rules['email'] 		= 'required';
      	$rules['social_id'] 	= 'required';
      	$rules['device'] 		= 'required|in:android,ios';
      	if($request->input('social_type') !== null && $request->social_type != 'apple'){
      		$rules['socialmediaImg'] = 'required';
      	}
      	$this->validateDatas($request->all(),$rules);
      	$status = 200; $email = $request->email;
      	$check = User::where('email',$email)->where('social_id',$request->social_id)->where('social_type',$request->social_type)->where('group_id',$request->group_id)->first();
      	$newAcnt = false;
      	//existing user check
      	if(!empty($check)){
      	    $user_check = User::where('email',$request->email)->where('group_id',$request->group_id)->count();
      	    if($user_check > 1){
      	 	   return \Response::json(['message'=>"Already used this email id "],422);
      	    }
          	$response['new_user'] = '0';
          	
          	if ($request->group_id == 5) { //Delivery Boy
          		$response['register'] = $check->c_page == 'Completed' ? '1' : '0';
           	} elseif ($request->group_id == 3) { // Shop
          		$checkrestaurant  = Restaurant::where('partner_id',$check->id)->exists();
          	    $response['register'] = $check->phone_number == 0 ? '1' : '0';
				if(!$checkrestaurant && $response['register'] == '0'){
					$response["register"] = '2';
				}
          	} elseif ($request->group_id == 4) { // User
          		$response['register'] = $check->phone_number == 0 ? '1' : '0';
          	}
      		$user = User::find($check->id);
      	} else {
      	    //New user check
      		$aField = ['social_type','username','email','group_id','social_id','device'];
  			if($request->input('social_type') !== null && $request->social_type != 'apple'){
	      		$aField[] = 'socialmediaImg';
	      	}
      		if(!empty($check)){
		      	$user = User::find($check->id);
	      	} else {
	      		$newAcnt = true;
	      		$user = new User;
	      		$user->active = CNF_ACTIVATION == 'manual' ? '0' : '1';
	      		$user->created_at = date('Y-m-d H:i:s');
	      		$response['new_user'] = '1';
	      		$response['register'] = '1';
	      	}
	      	foreach ($aField as $key => $value) {
	      		$user->{$value} = $request->{$value};
	      	}
	      	
      	}

      	$user->email_verified = 1;
      	$user->last_login = date('Y-m-d H:i:s');
      	//$user->mobile_token = $request->mobile_token;
      	$user->updated_at = date('Y-m-d H:i:s');
      	$user->save();

      	$response['message'] = 'success';
      	$response['confirmation'] = 0;
      	
  		if($user->active == '1'){
			\AbserveHelpers::updateCartAndSearchKeyword($user->id,$request->device_id);
			//$sToken = Authorizer::issueAccessToken();
			$response["access_token"] = JWTAuth::fromUser($user);
			$response['id']   = $user->id;
			$user_data = User::select('id','username','email','socialmediaImg','phone_number','address','c_page','avatar')->where('id',$user->id)->first();
			$user_data['c_page'] = $user_data->c_page != '' ? $user_data->c_page : 'profile_page';
			$response['user']    = $user_data;
		} elseif($user->active == '0'){
			if($newAcnt){
				$response['confirmation'] = 2;
				$response['message'] = "Thanks for registering! . We will review your account and get back to you soon";
			} else {
				$status = 422;
				$response['message'] = 'Your Account is not active';
			}
		} elseif($user->active == '2'){
			$status = 422;
			$response['message'] = 'Your Account is BLocked';
		} elseif($user->active == '3'){
			$status = 422;
			$response['message'] = 'Invalid Credentials';
		}
		return \Response::json($response,$status);
	}

	public function verifyOtp(Request $request)
	{
		$rules['otp'] = 'required';
		$rules['user_id'] = 'required';
		$this->validateDatas($request->all(), $rules);
		$otp = $request->otp;
		$user_id = $request->user_id;
		$is_otp = User::where('id', $user_id)->where('delivery_otp', $otp)->first();
		if($is_otp != null || $is_otp != ''){
			$order_update = OrderDetail::where('id', $request->order_id)->where('status', 'otpSend')->update(['status' => 'otpVerify']);
			$message = 'Valid otp';
			$status = 200;
		}else{
			$message = 'Please enter valid otp';
			$status = 403;
		}
		$response['msg'] = $message;
		return \Response::json($response,$status);
	}
}