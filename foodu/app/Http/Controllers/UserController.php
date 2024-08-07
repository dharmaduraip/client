<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Libary\SiteHelpers;
use Socialize;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect, Authorizer ; 
use Illuminate\Support\Str;
use App\Models\Deliveryboy;
use App\Models\OrderDetail;
use App\Models\OrderItems;
use App\Models\Restaurant;
use App\Models\Partnertransac;
use App\Models\Wallet;
use App\Models\Refundinfo;
use App\Models\RefundDetails;
use App\Models\OfferUsers;
use App\Models\Front\Usercart;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller {

	protected $layout = "layouts.main";
	public function __construct()
	{
		parent::__construct();
		$this->data = array();
	}

	public function getRegister()
	{
        return redirect('/');
		if(config('sximo.cnf_regist') =='false') :    
			if(\Auth::check()):
				return redirect('')->with(['message'=>'Youre already login','status'=>'error']);
			else:
				 return redirect('user/login');
			  endif;			  
		else :
				$this->data['socialize'] =  config('services');
				return view('user.register', $this->data);  
		 endif ;        
	}

	public function postCreate( Request $request)
	{
	
		$rules = array(
			'username'=>'required|alpha|between:3,12|unique:tb_users',
			'firstname'=>'required|alpha_num|min:2',
			'lastname'=>'required|alpha_num|min:2',
			'email'=>'required|email|unique:tb_users',
			'password'=>'required|between:6,12|confirmed',
			'password_confirmation'=>'required|between:6,12'
		);	

		if($request->has('mobile')) {
			unset($rules['password_confirmation']);
			$rules['password'] = 'required|between:6,12';
		} 
		else {
			if(config('sximo.cnf_recaptcha') =='true') 
			{
				$return = $this->reCaptcha($request->all());
				if($return !== false)
				{
					if($return['success'] !='true')
					{
						return response()->json(['status' => $return['success'], 'message' =>'Invalid reCpatcha']);	
					}
					
				}
			}
		}

		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$code = rand(10000,10000000);			
			$authen = new User;
			$authen->username = $request->input('username');
			$authen->first_name = $request->input('firstname');
			$authen->last_name = $request->input('lastname');
			$authen->email = trim($request->input('email'));
			$authen->activation = $code;
			$authen->group_id = $this->config['cnf_group'];
			$authen->password = \Hash::make($request->input('password'));
			if($this->config['cnf_activation'] == 'auto') { $authen->active = '1'; } else { $authen->active = '0'; }
			$authen->save();
			
			$data = array(
				'firstname'	=> $request->input('firstname') ,
				'lastname'	=> $request->input('lastname') ,
				'email'		=> $request->input('email') ,
				'password'	=> $request->input('password') ,
				'code'		=> $code ,
				'subject'	=> "[ " .$this->config['cnf_appname']." ] REGISTRATION "				
			);
			if(config('sximo.cnf_activation') == 'confirmation')
			{ 
				$to = $request->input('email');
				$subject = "[ " .$this->config['cnf_appname']." ] REGISTRATION "; 			
				if($this->config['cnf_mail'] =='swift')
				{ 				
					\Mail::send('user.emails.registration', $data, function ($message) use ($data) {
			    		$message->to($data['email'])->subject($data['subject']);
			    	});				    	
				}  else {		
					$message = view('user.emails.registration', $data);
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.$this->config['cnf_appname'].' <'.$this->config['cnf_email'].'>' . "\r\n";
						mail($to, $subject, $message, $headers);	
				}

				$message = "Thanks for registering! . Please check your inbox and follow activation link";
								
			} elseif($this->config['cnf_activation']=='manual') {
				$message = "Thanks for registering! . We will validate you account before your account active";
			} else {
   			 	$message = "Thanks for registering! . Your account is active now ";         
			
			}	
			if($request->has('mobile') )
			{
				 return response()->json(['status' => 'success', 'message' => $message ]);
			} 
			else {
				return redirect('user/login')->with(['message' => $message,'status'=>'success']);
			}

		} else {
			if($request->has('mobile') )
			{
				 return response()->json(['status' => 'error', 'message' => $validator->errors() ]);
			} 
			else {
				return redirect('user/register')->with(['message'=>'The following errors occurred','status'=>'success'])
				->withErrors($validator)->withInput();
			}
			
		}
	}

	public function userdatas(Request $request)
	{
		$res['datas'] = \SiteHelpers::getAllUsers($request->group_id,$request->type);
		return json_encode($res);
	}

	public function getActivation( Request $request)
	{
		$num = $request->input('code');
		if($num =='')
			return redirect('user/login')->with(['message'=>'Invalid Code Activation!','status'=>'error']);
		
		$user =  User::where('activation','=',$num)->get();
		if (count($user) >=1)
		{
			User::where('activation', $num )->update(array('active' => 1,'activation'=>''));
			return redirect('user/login')->with(['message'=>'Your account is active now!','status'=>'success']);
			
		} else {
			return redirect('user/login')->with(['message'=>'Invalid Code Activation!','status'=>'error']);
		}
	}

	public function getLogin()
	{
		return redirect('/');
		if(\Auth::check()) {
			return redirect('')->with(['message'=>'success','Youre already login','status'=>'success']);
		} else {
			$this->data['socialize'] =  config('services');
			return View('user.login',$this->data);
			
		}	
	}

	public function reCaptcha( $request)
	{
		if(!is_null($request['g-recaptcha-response']))
        {
            $api_url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . config('sximo.cnf_recaptchaprivatekey') . '&response='.$request['g-recaptcha-response'];
            $response = @file_get_contents($api_url);
            $data = json_decode($response, true);
 
           return $data;
        }
        else
        {
           return false ;
        }		
	}

	public function postSignin( Request $request)
	{

		$rules = array(
			'email'=>'required',
			'password'=>'required',
		);		
		if(config('sximo.cnf_recaptcha') =='true') {
			$return = $this->reCaptcha($request->all());
			if($return !== false)
			{
				if($return['success'] !='true')
				{
					return response()->json(['status' => $return['success'], 'message' =>'Invalid reCpatcha']);	
				}
				
			}
		}
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {	

			$remember = (!is_null($request->get('remember')) ? 'true' : 'false' );
			
			if (\Auth::attempt(array('email'=>$request->input('email'), 'password'=> $request->input('password') ), $remember )
				or 
				\Auth::attempt(array('username'=>$request->input('email'), 'password'=> $request->input('password') ), $remember )

			) {
				if(\Auth::check())
				{
					$row = User::find(\Auth::user()->id); 	
					if($row->active =='Inactive')
					{
						// inactive 
						if($request->ajax() == true )
						{
							return response()->json(['status' => 'error', 'message' => 'Your Account is not active']);
						} else {
							\Auth::logout();
							return redirect('user/login')->with(['status' => 'error', 'message' => 'Your Account is not active']);
						}
						
					} else if($row->active=='Banned')
					{

						if($request->ajax() == true )
						{
							return response()->json(['status' => 'error', 'message' => 'Your Account is BLocked']);
						} else {
							// BLocked users
							\Auth::logout();
							return redirect('user/login')->with(['status' => 'error', 'message' => 'Your Account is BLocked']);
						}
					} else {
						User::where('id', '=',$row->id )->update(array('last_login' => date("Y-m-d H:i:s")));
						$level = 99;
						$sql = \DB::table('tb_groups')->where('group_id' , $row->group_id )->get();
				        if(count($sql))
				        {
				            $l = $sql[0];
				            $level = $l->level ;
				        }

						$session = array(
							'gid' => $row->group_id,
							'uid' => $row->id,
							'eid' => $row->email,
							'll' => $row->last_login,
							'fid' =>  $row->first_name.' '. $row->last_name,
							'username' =>  $row->username ,
							'join'	=>  $row->created_at ,
							'level'	=> $level 
						);
						/* Set Lang if available */
						if(!is_null($request->input('language')))
						{
							$session['lang'] = $request->input('language');		
						} else {
							$session['lang'] = config('sximo.cnf_lang');
							
						}
						
						if($request->ajax() == true )
						{

							if( config('sximo.cnf_front') =='false') :
								return response()->json(['status' => 'success', 'url' => url('dashboard')]);					
							else :
								return response()->json(['status' => 'success', 'url' => url('')]);
							endif;	

						} 
						else {
							session($session);
							if( config('sximo.cnf_front') =='false') :
								return redirect('dashboard');						
							else :
								return redirect('');
							endif;	
						}				
					}	
				}		
				
			} 
			else {

				if($request->ajax() == true )
				{
					return response()->json(['status' => 'error', 'message' => 'Your username/password combination was incorrect']);
				} else {

					return redirect('user/login')
						->with(['status' => 'error', 'message' => 'Your username/password combination was incorrect'])
						->withInput();					
				}
			}
		} 
		else {

				if($request->ajax() == true)
				{
					return response()->json(['status' => 'error', 'message' => 'The following  errors occurred']);
				} else {

					return redirect('user/login')
						->with(['status' => 'error', 'message' => 'The following  errors occurred'])
						->withErrors($validator)->withInput();
				}	

		}	
	}

	public function postSigninMobile( Request $request)
	{
		$rules = array(
			'email'                 =>'required|email',
			'password'              =>'required'
		);  
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$email      =  trim($request->input('email')) ;
			$password   =  trim($request->input('password')) ;
			if (\Auth::attempt(array('email'=> $email, 'password'=> $password ))) {

				$row = User::find(\Auth::user()->id);   
				if($row->status =='0')
				{
					return response()->json(['status' => 'error', 'message' => ' Your account is active yet ' ]);
				} 
				else if( $row->status == '2') {
					return response()->json(['status' => 'error', 'message' => ' Your account is blocked / banned ' ]);
				} 
				else {

					$data = array(
						'gid' => $row->group_id,
						'uid' => $row->id,
						'eid' => $row->email,
						'll' => $row->last_login,
						'fid' =>  $row->name,
						'uname'     => $row->username ,
						'logged_in' => true ,
						'join'  =>  $row->created_at                             
					);
					if(file_exists('./uploads/users/'.$row->avatar ) && $row->avatar !='') {
						$data['avatar'] = asset('uploads/users/'.$row->avatar) ;
					} else {
						$data['avatar'] =  asset('uploads/users/avatar.png') ;
					}
					$data['access'] = [];

					$token =  hash('sha256',Str::random(60)) ;

					\DB::table('tb_token')->insert([
						'userId'	=> $row->id ,
						'token'		=> $token ,
						'created'	=> date("Y-m-d H:i:s")
					]);

					return response()->json([
						'status' => 'success', 
						'message' => 'You are Logged',
						'token'=> $token,
						'data'   => $data
					]);
				}
			} 
			else {
				return response()->json(['status' => 'error', 'message' => 'Your username/password combination was incorrect']);
			}
		}
		else {
			return response()->json(['status' => 'error', 'message' => $validator->errors() ]);
		}
	}

	public function getProfile()
	{
		
		if(!\Auth::check()) return redirect('user/login');
		
		
		$info =	User::find(\Auth::user()->id);
		$this->data = array(
			'pageTitle'	=> 'My Profile',
			'pageNote'	=> 'View Detail My Info',
			'info'		=> $info,
		);
		return view('user.profile',$this->data);
	}

	public function getTheme()
	{
		
		return view('layouts.palette');
	}

	public function postSaveprofile( Request $request)
	{
		if(!\Auth::check()) return redirect('user/login');	
		
			
		if($request->input('email') != \Session::get('eid'))
		{
			$rules['email'] = 'required|email|unique:tb_users';
		}	

		if(!is_null($request->file('avatar'))) $rules['avatar'] = 'mimes:jpg,jpeg,png,gif,bmp';

				
		$validator = Validator::make($request->all(), $rules);


		if ($validator->passes()) {
			
			
			if(!is_null($request->file('avatar')))
			{
				$file = $request->file('avatar'); 
				$destinationPath = './uploads/users/';
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //if you need extension of the file
				$newfilename = \Session::get('uid').'.'.$extension;
				$uploadSuccess = $request->file('avatar')->move($destinationPath, $newfilename);				 
				if( $uploadSuccess ) {
				    $data['avatar'] = $newfilename; 
				}
				$orgFile = $destinationPath.'/'.$newfilename; 
				\SiteHelpers::cropImage('80' , '80' , $orgFile ,  $extension,	 $orgFile)	;
				
			}		
			
			$user = User::find(\Session::get('uid'));
			$user->phone_number 		= $request->input('phoneNumber');
			$user->email 		= $request->input('email');
			if(isset( $data['avatar']))  $user->avatar  = $newfilename; 			
			$user->save();

			$newUser = User::find(\Session::get('uid'));

			\Session::put('fid',$newUser->first_name.' '.$newUser->last_name);

			return redirect('user/profile')->with('message','Profile has been saved!')->with('status','success');
		} else {
			return redirect('user/profile')->with('message','The following errors occurred')->with('status','error')
			->withErrors($validator)->withInput();
		}	
	}

	public function postSavepassword( Request $request)
	{
		$rules = array(
			'password'=>'required|between:6,12',
			'password_confirmation'=>'required|between:6,12'
			);		
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$user = User::find(\Session::get('uid'));
			$user->password = \Hash::make($request->input('password'));
			$user->save();

			return redirect('user/profile')->with(['status' => 'success', 'message' => 'Password has been saved!'] );
		} else {
			return redirect('user/profile')->with(['status' => 'error', 'message' => 'The following errors occurred'])
			->withErrors($validator)->withInput();
		}	
	}

	public function getReminder()
	{
	
		return view('user.remind');
	}

	public function postRequest( Request $request)
	{

		$rules = array(
			'credit_email'=>'required|email'
		);	
		
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {	
	
			$user =  User::where('email','=',$request->input('credit_email'));
			if($user->count() >=1)
			{
				$user = $user->get();
				$user = $user[0];
				$data = array('token'=>$request->input('_token'));	
				$to = $request->input('credit_email');
				$subject = "[ " .config('sximo.cnf_appname')." ] REQUEST PASSWORD RESET "; 
				$data['subject'] =  $subject;	
				$data['email'] = $to;

				if(config('sximo.cnf_mail') =='swift')
				{ 
					
					\Mail::send('user.emails.auth.reminder', $data, function ($message) use ($data)  {
			    		$message->to($data['email'])->subject($data['subject']);
			    	});	 
			    	

				}  else {

							
					$message = view('user.emails.auth.reminder', $data);
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.config('sximo.cnf_appname').' <'.config('sximo.cnf_email').'>' . "\r\n";
						mail($to, $subject, $message, $headers);	
				}					
			
				
				$affectedRows = User::where('email', '=',$user->email)
								->update(array('reminder' => $request->input('_token')));
								
				return redirect('user/login')->with(['message' => 'Please check your email','status'=>'success']);	
				
			} else {
				return redirect('user/login?reset')->with(['message' => 'Cant find email address','status'=>'error']);
			}

		}  else {
			return redirect('user/login?reset')->with(['message' => 'The following errors occurred','status'=>'error'])->withErrors($validator)->withInput();
		}	 
	}

	public function getReset( $token = '')
	{
		if(\Auth::check()) return redirect('dashboard');

		$user = User::where('reminder','=',$token);;
		if($user->count() >=1)
		{
			$this->data['verCode']= $token;
			return view('user.remind',$this->data);

		} else {
			return redirect('user/login')->with(['message'=>'Cant find your reset code','status'=>'error']);
		}
	}

	public function postDoreset( Request $request , $token = '')
	{
		$rules = array(
			'password'=>'required|alpha_num|between:6,12|confirmed',
			'password_confirmation'=>'required|alpha_num|between:6,12'
			);		
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			
			$user =  User::where('reminder','=',$token);
			if($user->count() >=1)
			{
				$data = $user->get();
				$user = User::find($data[0]->id);
				$user->reminder = '';
				$user->password = \Hash::make($request->input('password'));
				$user->save();			
			}

			return redirect('user/login')->with(['message'=>'Password has been saved!','status'=>'success'] );
		} else {
			return redirect('user/reset/'.$token)->with(['message'=>'The following errors occurred','status'=>'error'])->withErrors($validator)->withInput();
		}	
	}

	public function postLogout()
	{
		\Auth::logout();
		\Session::flush();
		return redirect('')->with(['message'=>'Your are now logged out!','status'=>'success']);
	}

	function socialize( $social)
	{
		return Socialize::driver($social)->redirect();
	}

	function autosocialize( $social)
	{
		$user = Socialize::driver($social)->user();		
		$users = User::where('email',$user->email)->get();

		if(count($users)){
			$row = $users[0];
			return self::autoSignin($row->id);		

		} else {
			return redirect('user/login')
				->with(['message'=>'You have not registered yet ','status'=>'error']);
		}
	}

	function autoSignin($id)
	{
		
		if(is_null($id)){
		  return redirect('user/login')
				->with(['message'=>'You have not registered yet ','status'=>'error']);
		} else{

		    \Auth::loginUsingId( $id );
			if(\Auth::check())
			{
				$row = User::find(\Auth::user()->id); 

				if($row->active =='0')
				{
					// inactive 
					\Auth::logout();
					return redirect('user/login')->with(['message'=>'Your Account is not active','status'=>'error']);

				} else if($row->active=='2')
				{
					// BLocked users
					\Auth::logout();
					return redirect('user/login')->with(['message'=>'Your Account is BLocked','status'=>'error']);
				} else {
					$session = array(
						'gid' => $row->group_id,
						'uid' => $row->id,
						'eid' => $row->email,
						'll' => $row->last_login,
						'fid' =>  $row->first_name.' '. $row->last_name,
						'username' =>  $row->username ,
						'join'	=>  $row->created_at
					);
					if($this->config['cnf_front'] =='false') :
						return redirect('dashboard');						
					else :
						return redirect('');
					endif;					
					
										
				}
				
				
			}
		}
	}

	public function postCheckphone(Request $request)
	{
		$return	= 0;
		$phone	= $request->phone;
		$check	= User::where('phone_number',$phone)->exists();
		$check1	= Deliveryboy::where('phone_number',$phone)->exists();
		if($check1 || $check){
			$check	= User::where('phone_number',$phone)->where('active','1')->exists();
			$check1	= Deliveryboy::where('phone_number',$phone)->where('active','1')->exists();
			$check2 = '';
			 if($request->group_id == '3'){
			 	$check	= User::where('phone_number',$phone)->where('p_active','1')->exists();
			 	$check1	= Deliveryboy::where('phone_number',$phone)->where('p_active','1')->exists();	
			 	$check2 = User::where('phone_number',$phone)->where('p_active','0')->exists();
			 }
			 if($request->group_id == '5'){
			 	$check	= User::where('phone_number',$phone)->where('d_active','1')->exists();
			 	$check1	= Deliveryboy::where('phone_number',$phone)->where('d_active','1')->exists();
			 	$check2	= User::where('phone_number',$phone)->where('d_active','0')->exists();
			 }
         if($check1 || $check) {
				$return	= 1;
			} elseif($check2 != ''){
				$return = 3;
			} else {
				$return = 2;
			}
		}
		return $return;
	}

	public function postSendotpreg(Request $request)
	{
		$rules		= array('phone'=>'required');
		$validator	= Validator::make($request->all(),$rules);
		if ($validator->passes()) {
			if(isset($request->from) && $request->from == 'delivery'){
				$rand_no	= '1234';
			}else{
				$rand_no	= '12345';
			}
			if(TWO_FACTOR_OPTION == 'enable') {
				if(isset($request->from) && $request->from == 'delivery'){
					$rand_no = (string) rand(1000, 9999);
				}else{
					$rand_no = (string) rand(10000, 99999);
				}
			}
			\Session::put('register_step_mob', '+91'.$request->phone);
			\Session::put('register_step_otp', $rand_no);
			$mobile_num 	=	'+91'.$request->phone;

			if(TWO_FACTOR_OPTION == 'enable') {
				$sent = \SiteHelpers::sendSmsOtp(TWO_FACTOR_API_KEY, $mobile_num, $rand_no);
				if ($sent === 0) {
					$error['message'] = 'OTP Not Sent! Try some other time.';
					$error['status']  = false;
					print_r(json_encode($error));die;
				} 
				if ($sent === 2) {
					$error['message'] = 'Please enter valid number';
					$error['status']  = false;
					print_r(json_encode($error));die;
				}
			}
        	$updateotp = $this->updateotp($request->phone,$rand_no);
        	if(!isset($request->website)) {
				$result['otp'] = $rand_no;
        	}
			$result['status']  = true;
			$result['message'] = "Phone Number Exists";
  			return response()->json($result,200);
		}
	}

	public function updateotp($phone_number , $otp)
	{
		if(\Request::segment(2) != 'deliveryOtp'){
			Deliveryboy::where('phone_number','=',$phone_number)->update(array('phone_otp' => $otp));
			User::where('phone_number', '=',$phone_number)
				->update(array('phone_otp' => $otp));
		}
	}

	public function postCheckuser(Request $request)
	{
		$mobile = $request->mobile;
		if (!isset($request->social_id)) {
			$otp		= $request->otp;
			$response	= $this ->checkloginotp($mobile,$otp);
		} else {
			$response['result']	= 1;
		}
		$redirect = 'false';
		if ($response['result'] == 1) {
			$user_detail = User::where('phone_number',$mobile)->first();
			$user_id	= $user_detail->id;
			$active		= $user_detail->active;
			if (!empty($user_detail)) {
				if($active == 1) {
					if (\Auth::loginUsingId($user_id)) {
						if(\Auth::check()) {
							$row = User::find(\Auth::user()->id); 
							if($row->active =='0'){
								\Auth::logout();
								$msg = 'Your Account is not active';
							} else if($row->active=='2') {
								\Auth::logout();
								$msg = 'Your Account is BLocked';
							} else if($row->active=='3') {
								\Auth::logout();
								$msg = 'Your Account is BLocked';
							} else {
								$msg = 'success';
								User::where('id', '=',$row->id )->update(array('last_login' => date("Y-m-d H:i:s")));
								try {
									$sToken = JWTAuth::fromUser($row);
									if (! $sToken ) {
										$msg = 'OTP incorrect';
									} else {
										\Session::put('uid', $row->id);
										\Session::put('access_token', $sToken);
										$response['access_token'] 	= $sToken;
										\Session::put('gid', $row->group_id);
										\Session::put('eid', $row->mobile);
										\Session::put('ll', $row->last_login);
										\Session::put('fid', $row->first_name.' '. $row->last_name);	
										/*Cart itmes*/
										$cookie_name	= "mycart";
										$cookie_id		= \AbserveHelpers::getCartCookie();
										$old_cart = Usercart::where('user_id',$row->id)->get();
										$new_cart = Usercart::where('cookie_id',$cookie_id)->get();
										if($user_detail->p_active == '1' && count($new_cart) != '0'){
											$newcart = Usercart::where('cookie_id',$cookie_id)->first();
											$getmyres = Restaurant::where('partner_id', $user_detail->id)->pluck('id')->toArray();
											$myresid = $newcart->res_id;
											if(in_array($myresid ,$getmyres))
											{
												Usercart::where('cookie_id',$cookie_id)->delete();
											}
										}
										$new_cart = Usercart::where('cookie_id',$cookie_id)->get();
										if(count($old_cart) > 0 && count($new_cart) > 0){
											if($old_cart[0]->res_id != $new_cart[0]->res_id){
												Usercart::where('user_id',$row->id)->delete();
											}else{
												foreach ($new_cart as $key => $value) {
													$foodcheck = Usercart::where('user_id',$row->id)->where('food_id',$value->food_id)->first();
													if($foodcheck){
														Usercart::where('id',$foodcheck->id)->delete();
													}
												}
											}
										}

										Usercart::where('cookie_id',$cookie_id)->update(array('user_id'=>$row->id,'cookie_id'=>0));
										if(!is_null($request->input('language')))
										{
											\Session::put('lang', $request->input('language'));
										} else {
											\Session::put('lang', 'en');
										}  
										if(CNF_FRONT =='true') {
											if(\Auth::user()->group_id == 4 && \Auth::user()->p_active == '0' || \Auth::user()->group_id == '5'){
												if($redirecturl = \Session::get('redirect')){
													\Session::forget('redirect');
													$redirect = $redirecturl;
												}  else {
													$redirect = '';
												}
											} elseif(\Auth::user()->group_id == 4 || \Auth::user()->group_id == 5 && \Auth::user()->p_active == '1') {
												$redirect = 'user/profile';
											}elseif(\Auth::user()->group_id == 3) {
												$redirect = 'user/profile';
											}  
											else {
												$redirect = 'dashboard';
											}		
										} else {
											if ($redirecturl = \Session::get('redirect'))  {
												\Session::forget('redirect');
												$redirect = $redirecturl;
											} 
											else {
												$redirect = 'dashboard';
											}
										}
									}
								} catch (JWTException $e) {
									$msg = 'Could not create token';
								}
							}			
						} else {
							$msg = 'fail';
						}
					} else {
						$msg = 'noaccess';
					}
				}elseif($active == 2)
				{
					$msg = 'Your Account has been blocked';
				}else
				{
					$msg = 'Your Account is inactive';
				}
			} else {
				$msg = 'Login using Delivery Boy App';
			}
		} else {
			$msg = 'fail';
		}
		if($request->newpartner == '1'){
		   $redirect = 'partner-with-us';
		}else if($request->newdeliveryboy == '1'){
			$redirect = 'delivery-with-us';
		}
		$response['msg'] 		= $msg;
		$response['redirect'] 	= $redirect.'?'.time();
		return json_encode($response);
	}

	public function checkloginotp($phone,$otp)
	{
		$user_detail	= User::where('phone_number',$phone )->first();
		$del_detail	= Deliveryboy::where('phone_number','=',$phone)->first();
		if (!empty($user_detail)) {
			$phone_otp	= $user_detail->phone_otp;
		} elseif(!empty($del_detail)) {
			$phone_otp	= $del_detail->phone_otp;
		} else {
			$phone_otp  = \DB::table('tbl_otp_buffer')->where('phone_number', $phone)->orderBy('id', 'desc')->pluck('otp')->first();
		}
		if ($phone_otp == $otp) {
			$response["result"]	= 1;
		} else {
			$response["result"]	= 0;
		}
		return $response;
	}

	public function postCheckphoneuserotp(Request $request)
	{
		$phone	= '+91'.$request->phone;
		$otp	= $request->otp;
		$sess_mob	= \Session::get('register_step_mob');
		$sess_otp	= \Session::get('register_step_otp');
		if ($sess_otp == $otp && $phone == $sess_mob) {
			$response["result"]	= 1;
		} else {
			$response["result"]	= 0;
		}
		return \Response::json($response);
	}

	public function postCheckuname(Request $request)
	{
		$return		= '';
		$username	= $request->uname;
		$check		= User::where('username',$username)->exists();
		return ($check) ? 1 : $return;
	}

	public function postUsercreate(Request $request)
	{
		$code	= rand(10000,10000000);
		$sess_otp	= \Session::get('register_step_otp');
		$authen		= new User;
		$authen->phone_otp		= $sess_otp;
		$authen->activation		= $code;
		$authen->username		= $request->uname;
		$authen->group_id		= $request->group_id;
		$authen->phone_number	= $request->phone_number;
		$authen->phone_code		= $request->phone_code;
		$authen->nric_number	= $request->nric_number;
		$authen->id_type		= $request->id_type;
		$authen->address		= $request->address;
		$authen->p_active    = '0';
		$authen->d_active    = '0';
		if (isset($request->userData['email'])) {
			$authen->socialmediaImg	= isset($request->userData['imageURL'])?$request->userData['imageURL']:'' ;
			$authen->email		= isset($request->userData['email'])?$request->userData['email']:'' ;
			if ($request->userData['from'] != 'fb') {
				$authen->social_id	= $request->userData['id'] ;
			} else {
				$authen->fb_id		= $request->userData['id'] ;
			}
		}

		if ($request->input('group_id')=='3') {
			$authen->active = '0'; 
		} elseif(CNF_ACTIVATION == 'auto') { 
			$authen->active	= '1'; 
		} else { 
			$authen->active	= '0'; 
		}
		$authen->save();
		$user_id				= $authen->id;
		$response["user_id"]	= $user_id;
		$response["message"]	= "Thanks for registering! . Your account is active now ";
		$response["result"]		= "success";
		return \Response::json($response);
	}

	public function postChecksocial( Request $request)
	{
		if ($request->from == 'fb') {
			$rules = array('social_id'	=> 'required|unique:tb_users,fb_id',);
			$param = 'fb_id';
		} elseif($request->from == 'apple') {
			$rules = array( 'social_id'=> 'required|unique:tb_users,apple_id',);
			$param = 'apple_id';
		} else {
			$rules = array('social_id'	=> 'required|unique:tb_users,social_id',);
			$param = 'social_id';
		}
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			if(isset($request->integrate)) {
				$user_detail = \DB::table('tb_users')->where('id',$request->integrate )->update(array($param => $request->social_id));
				$result["result"]	= 1;
				$result['msg']		= 'success';
				return json_encode($result);
			} else {
				$result["result"]	= 0;
				$result['msg']		= 'NO-ACCOUNT';
				return json_encode($result);
			}
		} else {
			if (isset($request->integrate)) {
				$result["result"]	= 0;
				$result['msg']		= 'Error';
				return json_encode($result);
			}
			$messages	= $validator->messages();
			$error		= $messages->getMessages();
			$val			= $this->getStepvalidation($error);
			if (isset($error['social_id'])) {
				$response["field"]	= 'social_id';
			}
			$user_detail	= \DB::table('tb_users')->where($param,$request->social_id )->first();
			$request['social_id']	= $request->social_id;
			$request['mobile']		= $user_detail->phone_number;
			$request['grant_type']	= 'password';
			$result	= $this->postCheckuser($request);
			return $result;
		}
	}

	public function getStepvalidation($error)
	{
		foreach ($error as $key => $value) {
			$val= $value[0];
		}
		return $val;
	}

	public function postAllorderdetails(Request $request)
	{
		$orderid	= $request->id;
		$user_id	= \Auth::user()->id;
		$aOrder		= OrderDetail::find($orderid);
		$aOrder->append('inaugural_offer');
		$wallet		= 0;

		$cash_back_off	= OfferUsers::where('order_id',$orderid)->orderBy('id','Asc')->first();
		if (!empty($cash_back_off )&&$cash_back_off['type'] == 'debit') {
			$cash_back  = $cash_back_off['offer_price'];
			$aOrder->grand_total = $aOrder->grand_total - $cash_back;
		}else { 
			$cash_back  = 0;
		}
		$aOrder->except_grand_total	= $aOrder->s_tax1 + $aOrder->gst + $aOrder->del_charge + $aOrder->del_charge_tax_price + $aOrder->festival_mode_charge + $aOrder->bad_weather_charge - $aOrder->wallet_amount;
		$wallet 	= Wallet::where('order_id',$orderid)->where('type','credit')->sum('amount');
		$order_items= OrderItems::where('orderid',$orderid)->get();
		$customer	= User::where('id',$aOrder->cust_id)->first();
		$restaurant	= Restaurant::where('id',$aOrder->res_id)->first();
		$partner	= User::where('id',$restaurant->partner_id)->first();
		$commission	= Partnertransac::where('order_id',$orderid)->first();
		$boy_detail	= '';
		if ($aOrder->boy_id != '') {
			if ($aOrder->rapido_orderid == '') {
				$boy_detail	= \DB::table('abserve_deliveryboys')->where('id',$aOrder->boy_id)->first();
			} else {
				$boy_detail	= \DB::table('rapido_boys')->select(\DB::raw('name as username,mobile_number as phone_number'))->where('id',$aOrder->boy_id)->first();	
			}
		}
		$cur_symbol		= \AbserveHelpers::getBaseCurrencySymbol();
		$order_detail	= array(
			'order'			=> $aOrder, 
			'order_items'	=> $order_items,
			'customer'		=> $customer,
			'partner'		=> $partner,
			'restaurant'	=> $restaurant,
			'commission'	=> $commission,
			'boy'			=> $boy_detail,
			'type'			=> $request->type,
			'cur_symbol'	=> $cur_symbol,
			'aOrder'		=> $aOrder,
			'check'			=> $request->check,
			'wallet'		=> $wallet,
			'cash_back'		=> $cash_back
		);
		// echo "<pre>";print_r($order_detail); exit();
		return view('user.details-modal',$order_detail);
	}

	public function postCheckemail(Request $request)
	{
		$email = trim($request->email);
		$check = \DB::table('tb_users')->where('email',$email)->first();
		$check1 = \DB::table('abserve_deliveryboys')->where('email',$email)->first();
		if($check1 || $check){
			return 1;	
		}else{
			return '';
		}
	}

	public function postRefundOrderDetails(Request $request)
	{
		$orderid = $request->id;
		$user_id = \Auth::user()->id;
		$rOrder = OrderDetail::find($orderid);
		$rsOrder = OrderItems::where('orderid',$orderid)->first();
		$mainRequest = new \Illuminate\Http\Request();
		$mainRequest->setMethod('POST');
		$mainRequest->request->add(['id' => $orderid]);
		$rHtmlData['rsOrder'] = $response['rsOrder'] = $rsOrder;
		$rHtmlData['rOrder'] = $response['rOrder'] = $rOrder;
		$response['mainOrderHtml'] =(string) $this->postAllorderdetails($mainRequest);
		$response['refundOrderHtml'] =(string) view('user.admin-refund-detail',$rHtmlData);
		$response['mainOrder'] = OrderDetail::find($rOrder->refund_id);

		return $response;
	}

	public function postRefundAmount(Request $request)
	{
		$orderid = $request->rId;
		$user_id = \Auth::user()->id;
		$rOrder  = OrderDetail::find($orderid);
		$user_detail = User::find($rOrder->cust_id); 
		if($rOrder->accept_grand_total >= $request->amount){
			$data	= new Wallet;
			$data->user_id		= $rOrder->cust_id;
			$data->order_id	= $orderid;
			$data->amount		= $request->amount;
			$data->title		= 'Refund for Order #'.$orderid;
			$data->reason		= 'Refund for Order #'.$orderid;
			$data->type			= 'credit';
			$cBalance         = ($user_detail->customer_wallet + (abs($request->amount)));
			$data->added_by	= $user_id;
			$data->balance		= $cBalance;
			$data->date			= date("Y-m-d");
			$data->created_at	= date("Y-m-d H:i:s", time());
			$data->save();
			$rOrder->refund_status = 'Customer Request Accepted';
			$rOrder->refund_amount =  $request->amount;
			$rOrder->save();
			User::where('id',$rOrder->cust_id)->update(['customer_wallet'=>$cBalance]);
			$response['status']  = 200;
			$response['message']	= 'Refund amount added successfully in user account wallet';
			return \Response::json($response);
		} else {
			$response['status']  = 422;
			$response['message']	= 'The total amount is higher than you added to the wallet';
			return \Response::json($response);
		}
		
	}
   function boyregisteration(Request $request){

   	    $rules['username'] = 'required';
   	    $rules['id_type'] = 'required';
   	    $rules['id_num'] = 'required';
   	    $rules['address'] = 'required';
   	    $user = \Auth::user();
   	    $user->username = isset($request->username) ? $request->username : $user->username;
   	    $user->id_type  = isset($request->id_type) ? $request->id_type : $user->id_type;
   	    $user->id_num = isset($request->id_num) ? $request->id_num : $user->id_num;
   	    $user->address = isset($request->address) ? $request->address : $user->address;
   	    $user->latitude = isset($request->latitude) ? $request->latitude : $user->latitude;
   	    $user->longitude = isset($request->longitude) ? $request->longitude : $user->longitude;
   	    $user->city = isset($request->city) ? $request->city : $user->city;
   	    $user->state = isset($request->state) ? $request->state : $user->state;
   	    $user->country = isset($request->country) ? $request->country : $user->country;
   	    $user->zip_code = isset($request->zipcode) ? $request->zipcode : $user->zipcode;
   	    $user->d_active = '3';
   	    $user->save();
   	    return Redirect::to('delivery-with-us')->with('status','success');		
	}
}