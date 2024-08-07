<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Otp_buffer;
use App\Models\Front\Deliveryboy;
use App\Models\Accountdetails;
use App\Models\Useraddress;
use JWTAuth;
use Illuminate\Validation\Rule;
use App\Models\cuisineimg;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class AuthController extends Controller {

	function __construct()
	{
		$this->segment  = \Request::segment(1);
		$this->method		= \Request::method();
		$from   = (!is_null($this->segment) && $this->segment == 'api') ? 'mobile' : 'web';
		$cookie = ($from == 'mobile') ? ((request('cookie')) ? request('cookie') : 0) : ((\Session::has('cookie')) ? \Session::get('cookie') : self::cookie());
		\Request::merge(['cookie' => $cookie]);
		self::middleware('auth:api', ['except' => ['register','verifyotp','sendotp']]);
	}

	private $status		= 422;
	private $message	= "unresponsible entity!";

	public function generateOTP($mobileNum='')
	{
		if ($mobileNum != '') {
			$user = User::where('phone_number', $mobileNum)->first();
			$rand_no = (TWO_FACTOR_OPTION!='disable') ? (string) rand(1000, 9999) : 12345;
			if (!empty($user)) {
				$user->phone_otp = $rand_no;
				$user->save();
				//$return['userstatus']	= 'Existing user';
			} else {
				$query 	= Otp_buffer::insert([
					"phone_number"	=>	$mobileNum,
					"otp"			=>	$rand_no
				]);
				//$return['userstatus']	= 'New user';
			}
			$return['smsstatus']	= \SiteHelpers::sendSmsOtp(TWO_FACTOR_API_KEY, $mobileNum, $rand_no);
			return $return;
		}
	}

	public function sendotp(Request $request)
	{
		$rules['phone_number']	= 'required|numeric';
		$this->validateDatas($request->all(),$rules);

		$result	= $this->generateOTP($request->phone_number);
		if ($result['smsstatus']	=== 1) {
			//$response['userstatus']	= $result['userstatus'];
			$response['message'] = 'Please enter the OTP send to your mobile number';
			$status	= 200;
		} else {
			if ($result['smsstatus']=== 0) {
				$response['message'] = 'OTP Not Sent! Try some other time.';
				$status  = $this->status;
			} else if ($result['smsstatus'] === 2) {
				$response['message'] = 'Please enter valid number';
				$status  = $this->status;
			}
		}
		return \Response::json($response,$status);
	}

	public function verifyotp(Request $request)
	{
		$rules['phone_number']	= 'required|numeric';
		$rules['phone_otp']	= 'required';
		$rules['group_id']	= 'required';
		$rules['fcm_token']	= 'required';
		$rules['device']  = ['required' , 'in:android,ios'];
		$this->validateDatas($request->all(),$rules);

		$user	= User::commonselect()->where('phone_number',$request->phone_number);
		$buffer	= Otp_buffer::where('phone_number',$request->phone_number);
		$u1	= clone($user); $u1	= $u1->first();
		$b1	= clone($buffer); $b1	= $b1->first();
		if (empty($u1) && empty($b1)) {
			$response['userstatus']	= 'New user';
			$response['message']	= 'Please register!';
			return \Response::json($response);
		}
		$user	= $user->where('phone_otp',$request->phone_otp)->first();
		$buffer	= $buffer->where('otp',$request->phone_otp)->first();

		if ((!empty($u1) && empty($user)) || (!empty($b1) && empty($buffer))) {
			$response['message'	]	= 'Invalid OTP';
			return \Response::json($response);
		} elseif ((!empty($u1) && !empty($user)) || (!empty($b1) && !empty($buffer))) {
			if (!empty($user)) {
				if ($user->group_id	== $request->group_id) {
					$userdata	= User::find($u1->id);
					$userdata->log_status	= 'login';
					$userdata->device	= $request->device;
					$userdata->save();
					$model	= ($request->group_id	== '5') ? 'App\Models\Front\Deliveryboy' : (($request->group_id	== '3') ? 'App\Models\Front\Partner' :
						'App\User');
					$userselect	= $model::commonselect()->where('phone_number',$request->phone_number)->first();
					$response['userData']	= $userselect;
					$response['userData']['token'] = JWTAuth::fromUser($u1);
				} else {
					if($user->group_id	== 3) {
						$user	= 'Partner';
					} elseif ($user->group_id	== 4) {
						$user	= 'Customer';
					} elseif ($user->group_id	== 5) {
						$user	= 'Deliveryboy';
					}
					$response['message']	=   "Please login as a ".$user." in ".$user.  " app";
					return \Response::json($response);
				}
				
			}		
			$response['userstatus']	= 'Existing user';
			$response['message']	= 'Otp is valid';
			return \Response::json($response);
		}
	}

	public function register(Request $request)
	{
		if($request->page != 'vehicle_page' && $request->page != 'bank_page' && $request->page != 'location_page'){
			$rules['group_id']   = 'required|in:3,4,5,6';
			$rules['phone_number']   = 'required';
			$group_id = $request->group_id;
			$phone_number = $request->phone_number;
			$rules = [
				'phone_number' => ['required',                            
					Rule::Unique('tb_users')                     
					->where('group_id', $group_id)->where('phone_number',$phone_number) 
				],   
				                                                                   
			];
			$rules['group_id']   = 'required|in:3,4,5,6';
			$rules['first_name']   = ['required', 'string', 'max:255'];
			$rules['last_name']    = ['required', 'string', 'max:255'];
			// $rules['phone_number']  = 'required|unique:tb_users,phone_number';
			$rules['device']  = ['required' , 'in:android,ios'];
		}else{
			$rules['group_id'] = 'required';
		}
		if ($request->group_id	== '3') {
			if(isset($request->email)){
				$rules['email'] 		= 'required|email';
			}
			// $rules['address'] 			= 'required';
			$rules['business_name']     = 'required';
			$rules['business_addr'] 	= 'required';
			$rules['Bank_Name'] 		= 'required';
			$rules['Bank_AccName'] 		= 'required';
			$rules['Bank_AccNumber'] 	= 'required';
			$rules['ifsc_code'] 		= 'required';
			$rules['aadhar_no'] 		= 'required|min:12|max:12';
			$rules['gst_no'] 			= 'required|min:15|max:15';
			$rules['fssai_no'] 			= 'required|min:14|max:14';
			$rules['pan_no'] 			= 'required|min:10|max:10';
			$rules['fcm_token']         = 'required';
		} elseif ($request->group_id	== '5') {
			$rules['page'] = 'required|in:profile_page,vehicle_page,bank_page,location_page';
			$rules['fcm_token']  = 'required';
			if($request->page == 'profile_page'){
				$rules['aadhar_no'] 	= 'required';
				$rules['avatar'] = 'required';
			}
			if($request->page == 'vehicle_page'){
				$rules['user_id'] = 'required';
				$rules['bike'] 		= 'required|in:yes,no';
				if($request->bike == 'yes'){
					$rules['rc_image'] 	= 'required';
					$rules['insurance_image'] 	= 'required';
				}
				$rules['license'] 	= 'required';
				if($request->license != 'no'){
					$rules['license_image'] = 'required';
					$rules['expiry_date'] = 'required';
				}
			}
			if($request->page == 'bank_page'){
				$rules['user_id'] = 'required';
				$rules['bank_name'] 	= 'required';
				$rules['account_holder_name'] 	= 'required';
				$rules['account_number'] 	= 'required';
				$rules['ifsc_code'] 	= 'required';
			}
			if($request->page == 'location_page'){
				$rules['user_id'] = 'required';
				$rules['address'] 			= 'required';
				$rules['latitude'] 			= 'required';
				$rules['longitude'] 		= 'required';
			}
		} elseif ($request->group_id	== '4') {
			$rules['fcm_token']  = ['required'];
		}
		$this->validateDatas($request->all(),$rules);
		$check_mob = User::where('phone_number',$request->phone_number)->first();
		if($check_mob != ''){
			$user = $check_mob;
		} elseif($request->group_id != '5')
		{
			$user	= isset($request->user_id) && $request->user_id != '0' ? User::where('id',$request->user_id)->first() : new User();
		    $user->group_id	= $request->group_id;
		}
		if($request->group_id != '5'){
			$user->first_name	= $request->first_name;
			$user->last_name	= $request->last_name;
			$user->username     = $request->first_name.' '.$request->last_name;
			$user->phone_number	= $request->phone_number;
			$user->location	= '';
			$user->device	= $request->device;
			$user->log_status	= 'register';
		}
		if(isset($request->referral_code) && $request->referral_code != ''){
			$u_update = User::where('referral_code', $request->referral_code)->first();
			$update_user_balance = $u_update->customer_wallet;
			if($u_update != ''){
				$ref_amount = $u_update->customer_wallet;
				$u_update->customer_wallet = $ref_amount + 50;
				$u_update->save();

				$currentDateTime = now();
				$timeFormatted = $currentDateTime->format('h:i:s');
				$notification = \DB::table('user_notification')->insert([
					'user_id' => $u_update->id,
					'notification' => 'Referral',
					'status' => 0,
					'content' => "You have earned your referral amount check in your wallet.",
					'date' => date('Y-m-d'),
					'time' => $timeFormatted
				]);

				$wallet = new Wallet;
				$wallet->user_id = $u_update->id;
				$wallet->amount  = 50;
				$wallet->title   = 'refer amount';
				$wallet->type    = 'credit';
				$wallet->balance = $u_update->customer_wallet;
				$wallet->date    = date('Y-m-d');
				$wallet->time    = $timeFormatted;
				$wallet->save();

				$title = 'Referral';
				$message = 'You have earned your referral amount';
				// \AbserveHelpers::sendPushNotification($u_update->mobile_token, $title, $message);
				$this->sendpushnotification($u_update->id,'user',$message);
			}else{
				$response['message'] = 'Please Enter Valid Referral Code.';
				return \Response::json($response,422);
			}
		}
		if($request->group_id	== '4'){
			$length = 10;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = str_shuffle($characters);
			$randomString = substr($randomString, 0, $length);
			$user->referral_code = $randomString;
			$user->mobile_token	= $request->fcm_token;
			$user->address	= isset($request->address) ? $request->address : '';
			$activation = $request->group_id != '4' ? 'manual' : CNF_ACTIVATION;
		    $user->active = $activation == 'auto' ? '1' : '0';
		    if($check_mob == ''){
		    $user->p_active = '0';
		    $user->d_active = '0';
		    }
		    $user->date_of_birth = $request->dob;
		    $user->email = $request->email;
		    $user->gender = $request->gender;
		    $user->latitude = $request->latitude;
		    $user->longitude = $request->longitude;
		    if($request->hasFile('avatar')){
			    $image = $request->file('avatar');
			    $filename = time() . '_' . $image->getClientOriginalName();
	            $image->move('uploads/users', $filename);
	            $user->avatar = $filename;
	        }
			$user->save();

			$u_address = new Useraddress;
			$u_address->user_id      = $user->id;
			$u_address->address_type = $request->addr_type;
			$u_address->building     = $request->building;
			$u_address->landmark     = $request->landmark;
			$u_address->address      = $request->address;
			$u_address->lat          = $request->latitude;
			$u_address->lang         = $request->longitude;
			$u_address->other_label  = $request->other_label;
			$u_address->del_status   = 0;
			$u_address->apply_status = 1;
			$u_address->save();
			
			$currentDateTime = now();
			$timeFormatted = $currentDateTime->format('h:i:s');
			$notification = \DB::table('user_notification')->insert([
				'user_id' => $user->id,
				'notification' => 'Account Setup Successful!',
				'status' => 0,
				'content' => "Your account creation is successful, you can now experience our services.",
				'date' => date('Y-m-d'),
				'time' => $timeFormatted
			]);

			$title = 'Register';
			$message = 'Thank you for registering';
			// \AbserveHelpers::sendPushNotification($user->mobile_token, $title, $message);

			$this->sendpushnotification($user->id,'user',$message);

			$response['userData'] = $user;
			$response['userData']['token'] = JWTAuth::fromUser($user);
			$response['message'] = 'Thanks for registering!';
			$status = 200;
		} elseif ($request->group_id	== '3') {
			if (isset($request->email)) {
				$user->email	= $request->email;
			}
			// $user->address	= $request->address;
			$user->business_name	= $request->business_name;
			$user->business_addr	= $request->business_addr;
		    $user->active = '1';
		    $user->p_active = '1';
		    if($check_mob == ''){
		      $user->d_active = '0';
		    }
			$user->mobile_token	= $request->fcm_token;
			$user->save();
			$bankFields = ['Bank_Name','Bank_AccName','Bank_AccNumber','ifsc_code','aadhar_no','gst_no','fssai_no','pan_no'];
			foreach ($bankFields as $key => $value) {
				$bank[$value] = $request->{$value};
			}
			$bank['partner_id']	= $user->id;
			$bank['Mobile']		= $request->phone_number;
			$postField = ['name' => $request->Bank_AccName, 'email' => '', 'type' => 'customer'];
			$url = 'https://api.razorpay.com/v1/contacts';
			$curlResponse = \AbserveHelpers::processCURL($url, $postField);

			if($curlResponse['status']){
				$Contact = json_decode($curlResponse['response']);
				$postField_fund = ['contact_id' => $Contact->id, 'account_type' => 'bank_account', 'bank_account' => array('name'=> $request->Bank_AccName,'ifsc'=> $request->ifsc_code,'account_number'=>$request->Bank_AccNumber)];
				$url_found = 'https://api.razorpay.com/v1/fund_accounts';
				$curlResponse_found = \AbserveHelpers::processCURL($url_found, $postField_fund);
				if($curlResponse_found['status']){
					$Found = json_decode($curlResponse_found['response']);
					$razorpay_contact_id = $Found->contact_id;
					$razorpay_fund_account_id = $Found->id;
					$bank['razor_account_id']=$razorpay_fund_account_id;
				}
            }
			\DB::table('tb_partner_accounts')->insert($bank);

			$response["data"]["email"]	= (isset($user) && $user->email != '' ) ? ($user->email) : '';
			$bank = \DB::table('tb_partner_accounts')->where('partner_id',$user->id)->first();
			$response["data"]["cuisine_type"]	= $user->cuisine_type;
			$response["data"]["Bank_Name"]		= (isset($bank) && $bank->Bank_Name != '' ) ? ($bank->Bank_Name) : '';
			$response["data"]["Bank_AccName"]	= (isset($bank) && $bank->Bank_AccName != '') ? ($bank->Bank_AccName) : '' ;
			$response["data"]["Bank_AccNumber"]	= (isset($bank) && $bank->Bank_AccNumber != '') ? $bank->Bank_AccNumber : '';
			$response["data"]["ifsc_code"]		= (isset($bank) && $bank->ifsc_code != '') ? $bank->ifsc_code : '';
			$response["data"]["aadhar_no"]		= (isset($bank) && $bank->aadhar_no != '') ? $bank->aadhar_no : '';
			$response["data"]["gst_no"]		= (isset($bank) && $bank->gst_no != '') ? $bank->gst_no : '';
			$response["data"]["fssai_no"]		= (isset($bank) && $bank->fssai_no != '') ? $bank->fssai_no : '';
			$response["data"]["pan_no"]		= (isset($bank) && $bank->pan_no != '') ? $bank->pan_no : '';
			$shop_cat = cuisineimg::select('id','name')->get();
			$response['shop_cat'] 	 = $shop_cat;
			$response['userData'] = $user;
			$response['userData']['token'] = JWTAuth::fromUser($user);
			$response['message'] = 'Thanks for registering!';
			$status = 200;

		} elseif ($request->group_id	== '5') {
			/*$user->address	= $request->address;
			$user->latitude	= $request->latitude;
			$user->longitude	= $request->longitude;
			$user->bike	= $request->bike;
		    $user->d_active = '1';
		    $user->active = '1';
		    if($check_mob == ''){
		      $user->p_active = '0';
		    }
			if ($request->bike	== 'yes') {			
				$user->license	= $request->license;
			}
			if($request->hasFile('license_image')){
				$image = $request->file('license_image');
			    $filename = time() . '_' . $image->getClientOriginalName();
	            $image->move('uploads/deliveryboy', $filename);
	            $user->license_image = $filename;
			}
			if($request->hasFile('rc_image')){
				$image = $request->file('rc_image');
			    $filename = time() . '_' . $image->getClientOriginalName();
	            $image->move('uploads/deliveryboy', $filename);
	            $user->rc_image = $filename;
			}
			if($request->hasFile('insurance_image')){
				$image = $request->file('insurance_image');
			    $filename = time() . '_' . $image->getClientOriginalName();
	            $image->move('uploads/deliveryboy', $filename);
	            $user->insurance_image = $filename;
			}

			// $user->date_of_birth = $request->dob;
			// $user->nick_name = $request->nickname;
			// $user->gender = $request->gender;
			// $user->email = $request->email;
			$user->mobile_token	= $request->fcm_token;
			$user->save();

			$bank['del_boy_id'] = $user->id;
			$bank['aadhar_no'] = $request->aadhar_no;
			$bank['Bank_Name'] = $request->bank_name;
			$bank['Bank_AccName'] = $request->account_holder_name;
			$bank['Bank_AccNumber'] = $request->account_number;
			$bank['ifsc_code'] = $request->ifsc_code;
			$bank['mobile'] = $user->phone_number;
			\DB::table('tb_partner_accounts')->insert($bank);*/

			if($request->page == 'profile_page'){
				$user	= isset($request->user_id) && $request->user_id != '0' ? User::where('id',$request->user_id)->first() : new User();
				$user->group_id	= $request->group_id;
				$user->first_name	= $request->first_name;
				$user->last_name	= $request->last_name;
				$user->username     = $request->first_name.' '.$request->last_name;
				$user->phone_number	= $request->phone_number;
				$user->location	= '';
				$user->device	= $request->device;
				$user->log_status	= 'register';
				$user->c_page = 'vehicle_page';
				$user->d_active = '1';
				$user->active = '1';
				$user->mobile_token	= $request->fcm_token;
				if($request->hasFile('avatar')){
					$image = $request->file('avatar');
				    $filename = time() . '_' . $image->getClientOriginalName();
		            $image->move('uploads/users', $filename);
		            $user->avatar = $filename;
				}
				$user->save();
				$user = User::where('id', $user->id)->first();
				$bank['del_boy_id'] = $user->id;
				$bank['aadhar_no'] = $request->aadhar_no;
				\DB::table('tb_partner_accounts')->insert($bank);
			}
			if($request->page == 'vehicle_page'){
				$user = User::find($request->user_id);
				$user->bike	= $request->bike;
				// if ($request->bike	== 'yes') {			
					$user->license	= $request->license;
				// }
				if($request->hasFile('license_image')){
					$image = $request->file('license_image');
				    $filename = time() . '_' . $image->getClientOriginalName();
		            $image->move('uploads/deliveryboy', $filename);
		            $user->license_image = $filename;
				}
				if($request->hasFile('rc_image')){
					$image = $request->file('rc_image');
				    $filename = time() . '_' . $image->getClientOriginalName();
		            $image->move('uploads/deliveryboy', $filename);
		            $user->rc_image = $filename;
				}
				if($request->hasFile('insurance_image')){
					$image = $request->file('insurance_image');
				    $filename = time() . '_' . $image->getClientOriginalName();
		            $image->move('uploads/deliveryboy', $filename);
		            $user->insurance_image = $filename;
				}
				$user->c_page = 'bank_page';
				$user->license_expiry_date = $request->expiry_date;
				$user->save();
			}
			if($request->page == 'bank_page'){
				$user = User::find($request->user_id);

				$postField = ['name' => $request->Bank_AccName, 'email' => '', 'type' => 'customer'];
				$url = 'https://api.razorpay.com/v1/contacts';
				$curlResponse = \AbserveHelpers::processCURL($url, $postField);

				if($curlResponse['status']){
					$Contact = json_decode($curlResponse['response']);
					$postField_fund = ['contact_id' => $Contact->id, 'account_type' => 'bank_account', 'bank_account' => array('name'=> $request->Bank_AccName,'ifsc'=> $request->ifsc_code,'account_number'=>$request->Bank_AccNumber)];
					$url_found = 'https://api.razorpay.com/v1/fund_accounts';
					$curlResponse_found = \AbserveHelpers::processCURL($url_found, $postField_fund);
					if($curlResponse_found['status']){
						$Found = json_decode($curlResponse_found['response']);
						$razorpay_contact_id = $Found->contact_id;
						$razorpay_fund_account_id = $Found->id;
					}
	            }

				$bank = Accountdetails::where('del_boy_id', $request->user_id)->update([
					// 'aadhar_no'      => $request->aadhar_no,
					'Bank_Name'      => $request->bank_name,
					'Bank_AccName'   => $request->account_holder_name,
					'Bank_AccNumber' => $request->account_number,
					'ifsc_code'      => $request->ifsc_code,
					'mobile'         => $user->phone_number,
					'razor_account_id' => $razorpay_fund_account_id,
				]);
				$user->c_page = 'location_page';
				$user->save();
			}
			if($request->page == 'location_page'){
				$user = User::find($request->user_id);
				$user->address = $request->address;
				$user->latitude	= $request->latitude;
				$user->longitude	= $request->longitude;
				$user->c_page = 'Completed';
				$user->save();
			}

			if($request->group_id == '5'){
				$userArray = array_map(function($value) {
			        return $value === null ? '' : $value;
			    }, $user->toArray());

			    // Create a new instance of User model
			    $user = new User();
			    $user->forceFill($userArray);
			    $user->profile = $userArray['avatar'];
			}

			$response['userData'] = $user;
			$response['userData']['token'] = JWTAuth::fromUser($user);
			$response['message'] = 'Thanks for registering!';
			$status = 200;
		}
		return \Response::json($response,$status);
	}

	/**
	 * Get the authenticated User.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function me()
	{
		$user	= auth('api')->user();
		$userid	= $user->id;
		$group_id	= $user->group_id;	
		$model	= ($group_id	== '5') ? 'App\Models\Front\Deliveryboy' :
		'App\User';
		$response['userdata']	= ($group_id	== '5') ? $model::commonselect()->find($userid) :  $model::commonselect()->find($userid);
		return \Response::json($response);
	}

	/**
	 * Log the user out (Invalidate the token).
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function logout( Request $request)
	{
		$user   = auth('api')->user();
		$rules['device']        = 'required|in:android,ios,web';
		$this->validateDatas($request->all(),$rules);

		$data   = User::find($user->id);
		$data->device       = $request->device;
		$data->log_status   = 'logout';
		$data->save();

		if($request->device == 'web') {
			\Auth::logout();
		} else {
			auth('api')->logout();
		}
		return response()->json(['status' => true], 200);
	}

	/**
	 * Refresh a token.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function refresh()
	{
		return $this->respondWithToken(auth('api')->refresh());
	}

	/**
	 * Get the token array structure.
	 *
	 * @param  string $token
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function respondWithToken($token)
	{
		return response()->json([
			'access_token'  => $token,
			'token_type'    => 'bearer',
			'expires_in'    => auth('api')->factory()->getTTL() * 60
		]);
	}

	public function userprofile(Request $request)
	{
		$user	= $this->authCheck();
		$userId	= $user['userId'];
		$userdata	= $user['user'];
		$group_id	= $user['group_id'];
		$rules = [];
		if (empty($userdata)) {
			$response['message']	= 'User not exists';
			return \Response::json($response,$this->status);
		}
		if ($this->method	== 'PATCH') {

			$rules['username']   = ['required', 'string', 'max:255'];
			// $rules['location']      = 'required|exists:location,id';
			$rules['phone_number']  = 'required|unique:tb_users,phone_number,'.$userId;
			if(isset($request->email)){
				$rules['email'] 			= 'required|email|unique:tb_users,email,'.$userId;
			}
			if ($userdata->p_active	== '1' && $request->group_id == '3') {
				if (isset($request->function) && ($request->function	== 'bankdetails')) {
					$rules['Bank_Name'] 		= 'required';
					$rules['Bank_AccName'] 		= 'required';
					$rules['Bank_AccNumber'] 	= 'required';
					$rules['ifsc_code'] 		= 'required';
					$rules['aadhar_no'] 		= 'required|min:12|max:12';
					$rules['gst_no'] 			= 'required|min:15|max:15';
					$rules['fssai_no'] 			= 'required|min:14|max:14';
					$rules['pan_no'] 			= 'required|min:10|max:10';
				} else { 
					$rules['business_name']     = 'required';
					$rules['business_addr'] 	= 'required';
				}
			} elseif ($userdata->d_active	== '1' && $request->group_id == '5') {
				if (isset($request->function) && ($request->function	== 'boylocation')) {
					// $rules['latitude'] 			= 'required';
					// $rules['longitude'] 		= 'required';
				} else {
					$rules['bike'] 		= 'required|in:yes,no';
					$rules['license'] 	= 'required';
				}
			}
		} elseif ($this->method	== 'PUT') {
			$rules['mode']	= 'required';
		}
		$this->validateDatas($request->all(),$rules);

		if ($this->method == 'GET') {
			$model	= ($userdata->d_active	== '1' && $request->group_id == '5') ? 'App\Models\Front\Deliveryboy' : (($userdata->p_active		== '1' && $request->group_id == '3') ? 'App\Models\Front\Partner' :
				'App\User');
			$response['userdata']	=  $model::commonselect()->find($userId);
			$response['message']	= 'Profile data fetched sucessfully';
			$status	= 200;
		} elseif ($this->method == 'PUT') {
			if ($userdata->d_active	!= '1' && $request->group_id != '5') {
				$response['message']	= "Access Denied";
				return \Response::json($response,$this->status);
			}
			$user	= User::find($userId);
			$user->mode	= $request->mode;
			$user->online_sts	= ($request->mode=='online') ? '1' : '0';
			$user->save();
			$response['message']	= 'Status updated sucessfully';
			$status	= 200;			
		} elseif ($this->method == 'PATCH') {
			$user	= User::find($userId);
			$user->username	= $request->username;
			$user->phone_number	= $request->phone_number;
			$user->location	= '';
			$user->address	= isset($request->address) ? $request->address : $user->address;
			$user->email	= isset($request->email) ? $request->email : $user->email;
			$response['message'] = 'Profile sucessfully updated';
			$status	= 200;
			if ($userdata->p_active		== '1' && $request->group_id == '3') {
				if (isset($request->function) && ($request->function	== 'bankdetails')) {
					$bankFields = ['Bank_Name','Bank_AccName','Bank_AccNumber','ifsc_code','aadhar_no','gst_no','fssai_no','pan_no'];
					foreach ($bankFields as $key => $value) {
						$bank[$value] = $request->{$value};
					}
					$bank['Mobile']		= $request->phone_number;
					Accountdetails::where('partner_id',$userId)->update($bank);				
					$bank = \DB::table('tb_partner_accounts')->where('partner_id',$user->id)->first();
					$response["data"]["Bank_Name"]		= (isset($bank) && $bank->Bank_Name != '' ) ? ($bank->Bank_Name) : '';
					$response["data"]["Bank_AccName"]	= (isset($bank) && $bank->Bank_AccName != '') ? ($bank->Bank_AccName) : '' ;
					$response["data"]["Bank_AccNumber"]	= (isset($bank) && $bank->Bank_AccNumber != '') ? $bank->Bank_AccNumber : '';
					$response["data"]["ifsc_code"]		= (isset($bank) && $bank->ifsc_code != '') ? $bank->ifsc_code : '';
					$response["data"]["aadhar_no"]		= (isset($bank) && $bank->aadhar_no != '') ? $bank->aadhar_no : '';
					$response["data"]["gst_no"]		    = (isset($bank) && $bank->gst_no != '') ? $bank->gst_no : '';
					$response["data"]["fssai_no"]		= (isset($bank) && $bank->fssai_no != '') ? $bank->fssai_no : '';
					$response["data"]["pan_no"]		= (isset($bank) && $bank->pan_no != '') ? $bank->pan_no : '';
					$user->business_name	=  isset($request->business_name) ? $request->business_name : $user->business_name;
					$user->business_addr	=  isset($request->business_addr) ? $request->business_addr : $user->business_addr;
				}
			} elseif ($userdata->d_active	== '1' && $request->group_id == '5') {
				if (isset($request->function) && ($request->function	== 'boylocation')) {
					$user->latitude	= '';
					$user->longitude	= '';
				} else {
					$user->bike	= $request->bike;
					$user->license	= $request->license;
				}
			}
			$user->save();
			$user	= User::find($userId);
			if($userdata->d_active		== '1' && $request->group_id == '5'){
				$response["data"]["bike"]	    = $user->bike;
				$response["data"]["license"]	= $user->license;
			}
			$response["data"]["phone_number"]	= (string) $user->phone_number;
			$response["data"]["name"]	= (isset($user) && $user->username != '' ) ? ($user->username) : '';
			$response["data"]["address"] = (isset($user) && $user->address != '' ) ? ($user->address) : '';
			$response["data"]["email"]	= (isset($user) && $user->email != '' ) ? ($user->email) : '';
			if($userdata->p_active		== '1' && $request->group_id == '3'){
				$response["data"]["business_name"]	= $user->business_name;
				$response["data"]["business_addr"]	= $user->business_addr;
			}
		}
		return \Response::json($response,$status);
	}

	function updateBoyStatus(Request $request)
	{
		$rules['group_id'] = 'required|in:3,4,5';
		// $rules['action'] = 'required|in:location,online_sts';
		$aFields = [];

		$rules['latitude'] = 'required';
		$rules['longitude'] = 'required';
		$aFields = ['latitude','longitude'];
		
		$this->validateDatas($request->all(),$rules);
		// print_r($authorizer);exit();
		$aUser = \Auth::user();
		$user = Deliveryboy::find($aUser->id);
		if(count($aFields) > 0){
			foreach ($aFields as $key => $value) {
				$user->{$value} = $request->{$value};
			}
		}
		$user->save();
		if($request->action == 'location'){
			$this->deliveryBoyDistance($request->latitude,$request->longitude,$aUser->id);
		}
		return \Response::json(['message' => 'Updated Successfully'],200);
	}

	function deliveryBoyDistance($lat,$long,$id)
	{
		if($lat > 0 && $long > 0){
			$Order = OrderDetail::where('boy_id',$id)->whereIn('status',['2','3','boyPicked','boyArrived'])->first();
			if(!empty($Order)){
				$distance = RiderLocationLog::select(\DB::raw(" ( round( 
					( 6371 * acos( least(1.0,  
					cos( radians(".$lat.") ) 
				    * cos( radians(latitude) ) 
				    * cos( radians(longitude) - radians(".$long.") ) 
					+ sin( radians(".$lat.") ) 
				    * sin( radians(latitude) 
					) ) ) ), 2) ) 
					AS distance"),'travelled')->where('boy_id',$id)->where('status',0)->whereIn('order_status',['2','3','boyPicked','boyArrived'])/*->where('order_id',$Order->id)*/->latest()->first();
				if(!empty($distance))
				{
					if($distance->distance > 0){
						$travelled = number_format((float)$distance->distance, 5, '.', '') + $distance->travelled;
					}else{
						$travelled = $distance->travelled;
					}
					$distance = $distance->distance;
				}else{
					$distance = 0;
					$travelled = 0;
				}
				$OrderId = OrderDetail::select(\DB::raw('GROUP_CONCAT(id) as id'))->where('boy_id',$id)->whereIn('status',['2','3','boyPicked','boyArrived'])->first();
				$arr = Array('boy_id'=>$id,'order_id'=>$OrderId->id,'order_log'=>$OrderId->id,'latitude'=>$lat,'longitude'=>$long,'order_status'=>$Order->status,'travelled'=>$travelled,'distance'=>$distance);
				$log =  RiderLocationLog::updateOrCreate($arr,$arr);
			}
		}
	}

	public function showProfile(Request $request)
	{
		$user_id = \Auth::user()->id;
		$user = User::where('id', $user_id)->select('id', 'avatar', 'first_name', 'last_name', 'phone_number', 'bike', 'rc_image', 'insurance_image', 'license', 'license_image', 'address', 'latitude', 'longitude', 'license_expiry_date')->first();
		if($user){
		    $user->rc_image = $user->getBikercImageAttribute();
		    $user->insurance_image = $user->getBikensuranceImageAttribute();
		    $user->license_image = $user->getBikelicenseImageAttribute();
		}
		$bankFields = Accountdetails::where('del_boy_id', $user_id)->first();

		$response['userDetails'] = $user;
		$response['userDetails']['aadhar_no'] = $bankFields->aadhar_no;
		$response['userDetails']['Bank_Name'] = $bankFields->Bank_Name;
		$response['userDetails']['Bank_AccNumber'] = $bankFields->Bank_AccNumber;
		$response['userDetails']['Bank_AccName'] = $bankFields->Bank_AccName;
		$response['userDetails']['ifsc_code'] = $bankFields->ifsc_code;
		$response['userDetails']['Bank_id'] = \DB::table('abs_bank')->where('name', $bankFields->Bank_Name)->first()->id;
		return \Response::json($response,200);
	}

	public function updateProfile(Request $request)
	{
		$user_id = \Auth::user()->id;
		$user = User::where('id', $user_id)->first();
		$bankFields = Accountdetails::where('del_boy_id', $user_id);
		$rules['page'] = 'required|in:profile_page,vehicle_page,bank_page,location_page';
			if($request->page == 'profile_page'){
				$rules['first_name'] = 'required';
				$rules['last_name'] = 'required';
				$rules['aadhar_no'] 	= 'required';
			}
			if($request->page == 'vehicle_page'){
				$rules['bike'] 		= 'required|in:yes,no';
				$rules['license'] 	= 'required';
				if($request->license != 'no'){
					$rules['expiry_date'] = 'required';
					if($user->license_image == ''){
						$rules['license_image'] = 'required';
					}
				}
				if($request->bike == 'yes'){
					if($user->rc_image == ''){
						$rules['rc_image'] = 'required';
					}
					if($user->insurance_image == ''){
						$rules['insurance_image'] = 'required';
					}
				}
			}
			if($request->page == 'bank_page'){
				$rules['bank_name'] 	= 'required';
				$rules['account_holder_name'] 	= 'required';
				$rules['account_number'] 	= 'required';
				$rules['ifsc_code'] 	= 'required';
			}
			if($request->page == 'location_page'){
				$rules['address'] 			= 'required';
				$rules['latitude'] 			= 'required';
				$rules['longitude'] 		= 'required';
			}
			$this->validateDatas($request->all(),$rules);

			if($request->page == 'profile_page'){
				$user->first_name = $request->first_name;
				$user->last_name = $request->last_name;
				$user->username = $request->first_name.' '.$request->last_name;
				if($request->hasFile('avatar')){
					$image = $request->file('avatar');
				    $filename = time() . '_' . $image->getClientOriginalName();
		            $image->move('uploads/users', $filename);
		            $user->avatar = $filename;
				}
				$user->save();
				$bankFields = $bankFields->update(['aadhar_no' => $request->aadhar_no]);
			}

			if($request->page == 'vehicle_page'){
				$user->bike = $request->bike;
				$user->license = $request->license;
				if($request->bike == 'no' || $request->bike == 'No'){
					$rc_file = 'uploads/deliveryboy/'.$user->rc_image;
			        if($user->rc_image != '' && File::exists(base_path($rc_file))){
			        	File::delete(base_path($rc_file));
			        	$user->rc_image = '';
			        }
			        $insurance_file = 'uploads/deliveryboy/'.$user->insurance_image;
			        if($user->insurance_image != '' && File::exists(base_path($insurance_file))){
			        	File::delete(base_path($insurance_file));
			        	$user->insurance_image = '';
			        }
			        // $user->save();
				}

				if($request->license == 'no' || $request->license == 'No'){
					$user->license_expiry_date = '';
					$license_file = 'uploads/deliveryboy/'.$user->license_image;
			        if($user->license_image != '' && File::exists(base_path($license_file))){
			        	File::delete(base_path($license_file));
			        	$user->license_image = '';
			        }
				}


				if($request->hasFile('license_image')){
					$image = $request->file('license_image');
				    $filename = time() . '_' . $image->getClientOriginalName();
		            $image->move('uploads/deliveryboy', $filename);
		            $user->license_image = $filename;
				}
				if($request->hasFile('rc_image')){
					$image = $request->file('rc_image');
				    $filename = time() . '_' . $image->getClientOriginalName();
		            $image->move('uploads/deliveryboy', $filename);
		            $user->rc_image = $filename;
				}
				if($request->hasFile('insurance_image')){
					$image = $request->file('insurance_image');
				    $filename = time() . '_' . $image->getClientOriginalName();
		            $image->move('uploads/deliveryboy', $filename);
		            $user->insurance_image = $filename;
				}
				$user->license_expiry_date = $request->expiry_date;
				$user->save();
			}

			if($request->page == 'bank_page'){
				$bankFields = $bankFields->update(['Bank_Name' => $request->bank_name, 'Bank_AccName' => $request->account_holder_name, 'Bank_AccNumber' => $request->account_number, 'ifsc_code' => $request->ifsc_code]);
			}

			if($request->page == 'location_page'){
				$user->address = $request->address;
				$user->latitude = $request->latitude;
				$user->longitude = $request->longitude;
				$user->save();
			}

			$userArray = array_map(function($value) {
		        return $value === null ? '' : $value;
		    }, $user->toArray());

		    // Create a new instance of User model
		    $bank_del = Accountdetails::where('del_boy_id', $user->id)->first();
		    $user = new User();
		    $user->forceFill($userArray);
		    if($user){
		    	$user->profile = $userArray['avatar'];
		    	$user->makeHidden('avatar');
		    	$user->rc_image = $user->getBikercImageAttribute();
		    	$user->insurance_image = $user->getBikensuranceImageAttribute();
		    	$user->license_image = $user->getBikelicenseImageAttribute();
		    }
			$response['userDetails'] = $user;
			$response['userDetails']['bankDetails'] = $bank_del;
			return \Response::json($response,200);
	}


}