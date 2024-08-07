<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ContactInfo;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\ApplicationGroup;
// use App\Company;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Hash;
use Mail;
use Illuminate\Support\Facades\Auth;
use Config;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Http;

class RegisterController extends Controller
{

    public function login(Request $request)
	{
		/*$validator = Validator::make($request->all(),[
			'email' => 'required|string|email|max:255|exists:users',
			'password' => 'required|string|min:6'
		]);

		if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],400);
		}*/

		$rules['email'] = 'required';
		$rules['password'] = 'required';
		$validator = Validator::make($request->all(),$rules);

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

		if(Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password')  ]))
		{
			$user=User::where('id', Auth::user()->id)->first();
			
			// $token = $user->createToken('authToken')->plainTextToken;
			$token = $user->createToken('authToken')->accessToken;
			
			$user->api_token = $token;
			$user->save();

			$userId = $user->id;
			//php firbase database url
			// $firebaseDatabaseUrl = 'https://jobstar-46d49-default-rtdb.firebaseio.com/';
			//android firebase database url
			$firebaseDatabaseUrl = 'https://jobstar-e9588-default-rtdb.firebaseio.com/';
			$databasePath = 'userdata/' . $userId;

			$response = Http::put($firebaseDatabaseUrl . $databasePath . '.json', ['id' => $userId, 'auth_token' => $token, 'device_id' => $request->device_id]);

	        // Check if request was successful
	        /*if ($response->successful()) {
	            return response()->json(['message' => 'Data stored successfully'], 200);
	        } else {
	            // If request fails, return error message
	            return response()->json(['error' => 'Failed to store data in Firebase'], 500);
	        }*/
			
			return response()->json([
				'status_code' => 200,
				'access_token' => $token,
				'user' => $user,
			]);
		}
		else
		{
			return response()->json([
				'message'=>'validator error',
				'status_code' => 400,
			]);
		}
	}

 	public function generateOTP($mobileNum='',$role='')
    {
        if ($mobileNum != '') {
	        if($role == 'employer') {
	           $user = Company::where('phone', $mobileNum)->where('phone', '!=', 0)->first();
	        }
		 	else if($role == 'candidate'){
	           $user = User::where('mobile_num', $mobileNum)->where('mobile_num', '!=', 0)->first();
		 	}

            if (!empty($user)) {
               /* $config = \Config::get('twofactor');
                if($config['TWO_FACTOR_OPTION'] && $mobileNum != 9222479222 && $mobileNum != 9222379222) {
                    $rand_no = (string) rand(1000, 9999);
                    $details = array();
                    $details['phone']   = $mobileNum;
                    $details['content'] = $rand_no;
                    event(new OtpUserEvent($details));
                } else {*/
                    $rand_no = '1234';
                /*}*/
                $user->mobile_otp = $rand_no;
                $user->save();
                $message= "The OTP you entered is invalid.Please enter correct OTP";
                $status = 200;
                $response['message']    = $message;
    			return \Response::json($response,$status);
            }
        }
    }

    public function verifyOTP( Request $request)
    {
        $rules['role']           = 'required|in:employer,candidate';
        if ($request->role == 'candidate') {
        	$rules['mobile_num'] = 'required|exists:users';
		} else {
			$rules['mobile_num']      = 'required|exists:users';	
		}

        $rules['otp']            = 'required|numeric|min:4';
		$validator = Validator::make($request->all(),$rules);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],400);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

        if($request->role == 'employer') {
        	$user = User::where('mobile_num', $request->mobile_num)->where('mobile_num', '!=', 0)->where('mobile_otp', $request->otp)->first();
        }
        else if($request->role == 'candidate'){
        	$user = User::where('mobile_num', $request->mobile_num)->where('mobile_num', '!=', 0)->where('mobile_otp', $request->otp)->first();
        }
     
        if (!empty($user)) {
            $message    = 'success';
            $status     = 200;
          
            if ($status == 200) {
            	$tokenResult = $user->createToken('authToken')->accessToken;
            	if($tokenResult)
		            $response['access_token'] = $tokenResult;
		            $response['token_type'] = 'Bearer';
		            $response['message'] = 'Your otp is correct.';
		            $response['user']   =  $user;
					$status = 200;
            }

        } else {
		            $status = 500;
		            $message= "The OTP you entered is invalid.Please enter correct OTP";
        }
        $response['message']    = $message;
        return \Response::json($response,$status);
    }
    
    
        public function emailVerifyOTP( Request $request)
    {
        $rules['role']           = 'required|in:employer,candidate';
        if ($request->role == 'candidate') {
        	$rules['email'] = 'required|exists:users';
		} else {
			$rules['email']      = 'required|exists:users';	
		}

        $rules['code']            = 'required|numeric|min:4';
		$validator = Validator::make($request->all(),$rules);

		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],400);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

        /*if($request->role == 'employer') {
        	$user = User::where('email', $request->email)->where('mobile_otp', $request->otp)->first();
        }
        else if($request->role == 'candidate'){
        	$user = User::where('email', $request->email)->where('mobile_otp', $request->otp)->first();
        }*/
        
        if($request->role == 'employer') {
        	$user   = User::where('email',$request->email)->where('reminder',$request->code)->first();
        }
        else if($request->role == 'candidate'){
        	$user   = User::where('email',$request->email)->where('reminder',$request->code)->first();
        }
     
        if (!empty($user)) {
            $message    = 'success';
            $status     = 200;
          
            if ($status == 200) {
            	/*$tokenResult = $user->createToken('authToken')->accessToken;
            	if($tokenResult)*/
		            /*$response['access_token'] = $tokenResult;
		            $response['token_type'] = 'Bearer';*/
		            /*$response['user'] = $user;*/
		            $response['message'] = 'Your otp is correct.';
		            /*$response['user']   =  $user;*/
					$status = 200;
            }

        } else {
		            $status = 500;
		            $message= "The OTP you entered is invalid.Please enter correct OTP";
        }
        $response['message']    = $message;
        return \Response::json($response,$status);
    }
    

    public function getVerifyCode($digits = 4)
    {
    	if($digits == 5){
    		$code = mt_rand(10000,99999);
    	} else if($digits == 6){
    		$code = mt_rand(100000,999990);
    	} else {
    		$code = mt_rand(1000,9999);
    	// dd($code);
    	}
    	//$code = 1111;
    	return $code;
    }

    public function forgetPasswordrequest(Request $request)
    {
        $rules['role']  = 'required|in:employer,candidate';
        if ($request->role == 'candidate') {
        	$rules['email'] = 'required|exists:users|email';
		} else {
			$rules['email'] = 'required|exists:users|email';
		}

		$validator = Validator::make($request->all(),$rules);
		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],400);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

        $status = 422;
        $exist  = false;

        if($request->role == 'employer') {
        	$user   = User::where('email',$request->email)->first();
        }
        else if($request->role == 'candidate'){
        	$user   = User::where('email',$request->email)->first();
        }

        if (!empty($user)) {
            $exist      = true;
            if($request->role == 'employer') {
            	$update_user= User::find($user->id);
            }
            else if($request->role == 'candidate'){
            	$update_user= User::find($user->id);
            }
        }
        $otp = rand(0000,9999);
        $reminder = self::getVerifyCode();
       
        if ($exist) {
            $update_user->reminder      = $reminder;
            $update_user->updated_at    = date('Y-m-d H:i:s');
            //$update_user->mobile_otp    = $otp;
            $update_user->save();
            // dd($update_user->reminder);

            $data['user']   = $update_user;
            $data['reminder']   = $reminder;
            $data['from']   = 'App';
            $to             = $request->email;
            $from           = env('MAIL_FROM_ADDRESS');
            $subject        = config('app.name').' Forget Password';
            $view           = 'mails.forget_password';

            self::sendemail($view,$data,$from,$to,$subject);
        	

            $status = 200;
            $response['message']    = 'Code sent to your email address';
        } else {
            $response['message']    = 'Cant find user';
        }
        return \Response::json($response,$status);
    }

    public function resetPassword(Request $request)
    {
    	$rules['role']  = 'required|in:employer,candidate';
        $rules['code']      = 'required';
        $rules['password']  = 'required|min:6|required_with:confirm_password|same:confirm_password';
        $rules['confirm_password'] = 'required|min:6';
        if ($request->role == 'candidate') {
        	$rules['email'] = 'required|exists:users|email';
		} else {
			$rules['email'] = 'required|exists:users|email';
		}

        $validator = Validator::make($request->all(),$rules);
		/*if($validator->fails())
		{
			return response()->json(['message'=>$validator->messages()],400);
		}*/

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			$response['status_code'] = 422;
			return \Response::json($response);
		}

        $status = 422;
        $exist  = false;

        if($request->role == 'employer') {
        	$user   = User::where('email',$request->email)->where('reminder',$request->code)->first();
        }
        else if($request->role == 'candidate'){
        	$user   = User::where('email',$request->email)->where('reminder',$request->code)->first();
        }

        if (!empty($user)) {
            $exist      = true;
            if($request->role == 'employer') {
            	$update_user= User::find($user->id);
            }
            else if($request->role == 'candidate'){
            	$update_user= User::find($user->id);
            }
        }
        if ($exist) {
            $update_user->password      = Hash::make($request->password);
            $update_user->reminder      = null;
            $update_user->updated_at    = date('Y-m-d H:i:s');
            $update_user->save();

            /*if ($request->device == 'web') {
                $response['rurl'] = ($update_user->role == 2) ? 'login' : 'chef/login' ;
            }*/

            $status = 200;
            $response['message']    = 'Password changed successfully';
        } else {
            $response['message']    =  'Invalid code';
        }
        return \Response::json($response,$status);
    }

    public function signup(Request $request)
	{
		$rules['role'] = 'required|in:company,candidate';
		if ($request->role == 'candidate' || $request->role == 'company')  {
			$rules['first_name'] = 'required';
			$rules['last_name'] = 'required';
			if($request->role == 'candidate'){
				$rules['mobile_num'] = 'required|numeric|unique:users';
				// $rules['city'] = 'required';
				// $rules['country'] = 'required';
				// $rules['gender'] = 'required';
			}
			$tbl = 'users';
		} else {
			$rules['name'] = 'required';
			$rules['phone'] = 'required|numeric|unique:companies';
			$tbl = 'companies';	

		}
		$rules['email'] = 'required|email|unique:users,email';
		$rules['password'] = 'required|min:6|max:50';
		$rules['confirm_password'] = 'required|same:password|min:6';
		$validator = Validator::make($request->all(),$rules);
		$variablesmgs = $validator->messages();
		// if($validator->fails())
		// {
        //     return response()->json([
        //         'message'=> $variablesmgs,
        //         'status_code' => 400,
        //     ]);
        // }

		if($validator->fails())
		{
			$response['message'] = $validator->errors()->first();
			return \Response::json($response, 422);
		}

        // $tokenResult = $user->createToken('authToken')->accessToken;
        // if($tokenResult){
        // 	$response['access_token'] = $tokenResult;
        // }

		if ($request->role == 'candidate' || $request->role == 'company' ) {
			$aFields = ['first_name','last_name','mobile_num','country','city','gender','email'];
			foreach ($aFields as $key => $value) {
				$arr[$value] = $request->{$value};
			}
			$arr['name']  = $request->first_name.' '.$request->last_name;
			$arr['username']  = $request->first_name.' '.$request->last_name;

			if (isset($request->referral_code)) {
				$arr['referral_code'] = isset($request->referral_code) ? $request->referral_code : '';
			}
			$arr['role']  = $request->role;
		} else {
			$arr['slug'] = $this->createSlug($request->name,$tbl,'id');
			$aFields = ['name','email','is_subscribed','phone'];
			foreach ($aFields as $key => $value) {
				$arr[$value] = $request->{$value};
			}
		}
		$arr['password']  		  = Hash::make($request->password);
		$arr['confirm_password']  = Hash::make($request->confirm_password);
		$arr['created_at'] = date('Y-m-d H:i:s');			
		$arr['updated_at'] = date('Y-m-d H:i:s'); 
		if($request->role == 'candidate'){
			$arr['current_page'] = 'signup';
		}elseif($request->role == 'company'){			
			$arr['current_page'] = 'basic_info';
		}			
		$ins = \DB::table($tbl)->insertGetId($arr);
		// dd($ins);
		if($request->role == 'candidate'){
		$candidate           		= Candidate::insert(['user_id' => $ins]);
		$inputs['user_id'] 					= $ins;
		$inputs['phone'] 					= $request->mobile_num;
		$inputs['email']				 	= $request->email;
		$inputs['location']                 = $request->city;
		ContactInfo::create($inputs);
		}elseif ($request->role == 'company') {
		//$company = Company::insert(['user_id' => $ins,'created_at' => $arr['created_at'],'updated_at' => $arr['updated_at']]);
		 $company = Company::create([
           'user_id' => $ins,
           'created_at' => $arr['created_at'],
           'updated_at' => $arr['updated_at']
           ]);
		$user = ContactInfo::insert(['user_id' => $ins, 'phone' => $request->mobile_num, 'email' => $request->email, 'location' => $request->city,'created_at' => $arr['created_at'],'updated_at' => $arr['updated_at']]);
		}
		if ($ins) {
			if(Auth::attempt(['email'=>$request->input('email'),'password'=>$request->input('password')  ])){
				$user=User::where('id', Auth::user()->id)->first();
				
				// $token = $user->createToken('authToken')->plainTextToken;
				$token = $user->createToken('authToken')->accessToken;
				
				$user->api_token = $token;
				$user->save();
			}


			$userId = $user->id;
			$firebaseDatabaseUrl = 'https://jobstar-e9588-default-rtdb.firebaseio.com/';
			$databasePath = 'userdata/' . $userId;
			$fresponse = Http::put($firebaseDatabaseUrl . $databasePath . '.json', ['id' => $userId, 'auth_token' => $token, 'device_id' => $request->device_id]);

			$response['message'] = 'Thanks for registering!';
			$response['access_token'] = $user->api_token;
			$status = 200;
		} else {
			$status = 422;
			$response['message'] =  'Something went wrong! Please try someother time.';
		}
		return \Response::json($response,$status);				
	}

	public function settings(){
		// $data['user'] = User::with('company', 'contactInfo', 'socialInfo')->findOrFail(auth('user')->id());
        // $data['socials'] = $data['user']->socialInfo;
        // $data['contact'] = $data['user']->contactInfo;
        // $data['organization_types'] = OrganizationType::all();
        // $data['industry_types'] = IndustryType::all();
        // $data['team_sizes'] = TeamSize::all();
       
       }
      

    public function newtrainroute()
    {
        $xlsxFilePath = public_path('SA-ED.xlsx');

		if (!file_exists($xlsxFilePath)) {
		    return response()->json(['error' => 'XLSX file not found'], 404);
		}

		$spreadsheet = IOFactory::load($xlsxFilePath);
		$worksheet = $spreadsheet->getActiveSheet();
		$data = $worksheet->toArray();
        $desiredNames3 = [];
        /*$startPoints = ['390/1', '383/3', '376/13', '369/1', '364/15', '358/13', '351/1', '338/13'];*/

        $startPoints = ['336/2', '349/14', '356/8', '361/4', '368/2', '374/14', '382/4', '389/2'];
        $endPoints = ['337/2', '350/14', '357/8', '362/4', '368/14', '375/14', '383/4', '389/14'];

        $highestRow = $worksheet->getHighestRow();
		$data = $two = $stations = $m = $speed = null;
        $i = 1;
        $names = [];
        $ascDistance = $red = $blue = 0;
		$camsg = '60';

		for ($row = 2; $row <= $highestRow; ++$row) {
		    $rowData = $worksheet->getCellByColumnAndRow(3, $row)->getValue(); 
		    $lat = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
		    $lng = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
		    $points = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
		    $nextpoint = $worksheet->getCellByColumnAndRow(5, $row+1)->getValue();
		    $status = 0;
		    if(in_array($points, $startPoints)){
		    	$status = 1;
		    	array_push($names, $rowData);
		    }elseif(in_array($points, $endPoints)){
		    	$status = 2;
		    }
		    $nameParts = explode('-', $rowData);
    		$name = trim($nameParts[0]);
    		$distance = 0;
			
    		if($stations != null){
    			$firstlat = $stations['lat'];
    			$firstlng = $stations['lng'];
    			$distance = $this->calculateDistance($firstlat,$firstlng,$lat,$lng);
    		}
    		if($status == 1){
    			$m = null;
    			$ascDistance = 0;
    			$blue = 1;
    			$red = 1;
    			$speeds = ['30', '90', '40', '20', '50', '70', '80'];
				shuffle($speeds);
				$speed = $speeds[0];
				$camsg = $speed;
    		}elseif($status == 2){
    			// $blue = 0; Mar 6
    			$red = 1;
    			$m = 1;
    			$two = 1;
				$camsg = $speed;
    		}
    		if($m != null){
    			$ascDistance += $distance;
    			if($ascDistance >= 0.8){
    				$red = 2;
    				$blue = 0; // Mar 6
    			}if($ascDistance >= 0.8 && $two != null){
	    			$status = -2;
					$camsg = '60';
					$speeds = ['30', '90', '40', '20', '50', '70', '80'];
					shuffle($speeds);
					$speed = $speeds[0];
	    			$two = null;
	    		}elseif($ascDistance <= 0.8){
	    			$red = 1;
	    		}
    		}



		    $data1[] = [
		    	'id' => $i,
		    	'name' => strtoupper($name),
		    	'lat' => (string) $lat, 
		    	'lng' => (string) $lng,
		    	'distance' => (string) round($distance, 2),
		    	'ohe' => $points,
		    	'next_ohe' => $nextpoint ?? 'N/A',
		    	'status' => $status,
		    	'red' => $red,
		    	'blue' => $blue,
		    	'camsg' => $camsg,
		    ];
		    $result = array_map(function ($element) {
		    $parts = preg_split('/[-\s]/', $element);
			    return trim($parts[0]);
			}, $names);
			$result = array_filter($result);
			$desc = implode(' ', array_map('strtoupper', $result));
			$names = explode(' ', $desc);
			$firstValue = reset($names);
			$lastValue = end($names);

		    $data = ['name' => $firstValue . ' ' . $lastValue, 'desc' => $desc];
		    $data['station'] = $data1;
		    $stations = [
	            'lat' => $lat, 
	            'lng' => $lng, 
	        ];
		    $i++;
		}
		$array = array_reverse($data1);
		$c = $datas = null;
		$one = 1;
        $decDistance = 0;
		foreach($array as $arr){
			if($arr['status'] == 1){
				$c = 1;
				$one = 1;
				$decDistance = 0;
				$speed = $arr['camsg'];
			}elseif($arr['status'] == 2){
				$c = null;
				$one = null;
			}
			if($c != null){
				$decDistance += $arr['distance'];
				if($decDistance <= 1.0){
    				$arr['red'] = 1;
					// 13-03-2024 $arr['camsg'] = '90';
					// $arr['camsg'] = '30';
    			}if($decDistance >= 1.0 && $one != null){
    				$arr['status'] = -1;
    				// $speeds = ['30', '90', '40', '20'];
					// shuffle($speeds);
					// $speed = $speeds[0];
    				$arr['camsg'] = $speed; // 13-03-2024
    				$one = null;
    			}
			}
			$values[] = $arr;
			$datas = ['name' => $data['name'], 'desc' => $data['desc']]; 
			$datas['station'] = $values;
		}
		$datas["station"] = array_reverse($datas["station"]);


		$startreachDis = 0;
		$endreachDis = 0;
		$reachvalue = null;
		foreach($datas['station'] as $key => $value){
			if($value['red'] != 1){
				$startreachDis += $value['distance'];
			}else{
				$startreachDis = 0;
			}
			/*if($value['status'] != -2){
				$endreachDis   += $value['distance'];
			}else{
				$endreachDis = 0;
			}*/
			$r_s_ohe = '';
			$b_s_ohe = '';
			$b_e_ohe = '';
			$r_e_ohe = '';
			if($value['status'] == -1){
				$r_s_ohe = $value['ohe'];
			}if($value['status'] == 1){
				$b_s_ohe = $value['ohe'];
			}if($value['status'] == 2){
				$b_e_ohe = $value['ohe'];
			}if($value['status'] == -2){
				$r_e_ohe = $value['ohe'];
			}
			$value['start_reach_dis'] = (string) round($startreachDis, 2);
			$value['r_s_ohe'] = $r_s_ohe ?? '';
			$value['b_s_ohe'] = $b_s_ohe ?? '';
			$value['b_e_ohe'] = $b_e_ohe ?? '';
			$value['r_e_ohe'] = $r_e_ohe ?? '';
    		// $value['end_reach_dis']   = $endreachDis;
			$rvalue[] = $value;
    		$reachvalue = ['name' => $data['name'], 'desc' => $data['desc']]; 
    		$reachvalue['station'] = $rvalue;
		}

		$val = array_reverse($reachvalue['station']);
		$dat = $e = $s = null;
		// $r_s_tot = '0';
		foreach($val as $v){
			if($v['status'] == -1){
				$r_s_tot = $v['start_reach_dis'];
				$v['start_reach_dis'] = '0';
			}elseif($v['red'] == 1){
				$r_s_tot = '0';
			}elseif($v['status'] != -1 && $v['status'] != 2){
				$v['start_reach_dis'] = $r_s_tot ?? '0';
			}

			// if($v['red'] != 1 && $v['status'] != -1){
			// 	$r_s_tot += $v['distance']; 
			// }else{
			// 	$r_s_tot = '0';
			// }
			// $v['start_reach_dis'] = (string) round($r_s_tot, 2);

			if($v['status'] == -2){
				$r_e_ohe = $v['r_e_ohe'];
			}

			if($v['status'] == 2){
				$b_e_ohe = $v['b_e_ohe'];
			}elseif($v['status'] == -2){
				$b_e_ohe = '-';
			}

			// old
			// if($v['status'] == 1){
			// 	$b_s_ohe = $v['b_s_ohe'];
			// }elseif($v['status'] == -2 || $v['status'] == 2){
			// 	$b_s_ohe = '-';
			// }

			// new 
			if($v['status'] == 1){
				$b_s_ohe = $v['b_s_ohe'];
				$s = null;
			}elseif($v['status'] == -2 || $v['status'] == 2){
				if($s == null){
					$b_s_ohe = $b_s_ohe;
					$s = 1;
				}
			}elseif($s != null){
				$b_s_ohe = '-';
			}

			// old
			// if($v['status'] == -1){
			// 	$r_s_ohe = $v['r_s_ohe'];
			// }elseif($v['status'] == 1 || $v['status'] == 2 || $v['status'] == -2){
			// 	$r_s_ohe = '-';
			// }

			// new
			if($v['status'] == -1){
				$r_s_ohe = $v['r_s_ohe'];
			}elseif($v['status'] == -2 && $v['red'] == 2){
				$r_s_ohe = $r_s_ohe;
			}elseif($v['status'] == 0 && $v['red'] == 1){
				$r_s_ohe = '-';
			}

			$v['r_s_ohe'] = ($v['status'] == -1) ? '-' : $r_s_ohe;
			$v['b_s_ohe'] = ($v['status'] == 1) ? '-' : $b_s_ohe;
			$v['b_e_ohe'] = $b_e_ohe;
			$v['r_e_ohe'] = $r_e_ohe;
			$vv[] = $v;
			$dat = ['name' => $data['name'], 'desc' => $data['desc']]; 
			$dat['station'] = $vv;
		}

		// $dat["station"] = array_reverse($dat["station"]);
		$new_data = array_reverse($dat["station"]);
		$new = $reach_dis = $n = null;
		foreach($new_data as $neww){
			if($neww['red'] != 1){
				if($n == null){
					$reach_dis = $neww['start_reach_dis'];
					$n = 1;
				}
				$reach_dis = $reach_dis - $neww['distance'];
				$reach_dis = (string) round($reach_dis, 2);
			}if($neww['status'] == -1){
				$reach_dis = '0';
				$n = null;
			}			
			$neww['start_reach_dis'] = (string) round($reach_dis, 2) ?? '0';
			$n_val[] = $neww;
			$new = ['name' => $data['name'], 'desc' => $data['desc']]; 
			$new['station'] = $n_val;
		}







		$xlsxFilePathD = public_path('ED-SA.xlsx');

		if (!file_exists($xlsxFilePathD)) {
		    return response()->json(['error' => 'XLSX file not found'], 404);
		}

		$spreadsheetD = IOFactory::load($xlsxFilePathD);
		$worksheetD = $spreadsheetD->getActiveSheet();
		$dataD = $worksheetD->toArray();
        $desiredNames3D = [];
        $startPointsD = ['390/1', '383/3', '376/13', '369/1', '364/15', '358/13', '351/1', '338/13'];
        $endPointsD = ['389/1', '382/3', '375/13', '368/1', '363/15', '357/13', '350/1', '337/13'];

        $highestRowD = $worksheetD->getHighestRow();
		$dataD = $twoD = $stationsD = $mD = $speedD = null;
        $iD = 1;
        $namesD = [];
        $ascDistanceD = $redD = $blueD = 0;
		$camsgD = '60';

		for ($rowD = 2; $rowD <= $highestRowD; ++$rowD) {
		    $rowDataD = $worksheetD->getCellByColumnAndRow(3, $rowD)->getValue(); 
		    $latD = $worksheetD->getCellByColumnAndRow(10, $rowD)->getValue();
		    $lngD = $worksheetD->getCellByColumnAndRow(11, $rowD)->getValue();
		    $pointsD = $worksheetD->getCellByColumnAndRow(5, $rowD)->getValue();
		    $nextpointD = $worksheetD->getCellByColumnAndRow(5, $rowD+1)->getValue();
		    $statusD = 0;
		    if(in_array($pointsD, $startPointsD)){
		    	$statusD = 1;
		    	array_push($namesD, $rowDataD);
		    }elseif(in_array($pointsD, $endPointsD)){
		    	$statusD = 2;
		    }
		    $namePartsD = explode('-', $rowDataD);
    		$nameD = trim($namePartsD[0]);
    		$distanceD = 0;
			
    		if($stationsD != null){
    			$firstlatD = $stationsD['lat'];
    			$firstlngD = $stationsD['lng'];
    			$distanceD = $this->calculateDistance($firstlatD,$firstlngD,$latD,$lngD);
    		}
    		if($statusD == 1){
    			$mD = null;
    			$ascDistanceD = 0;
    			$blueD = 1;
    			$redD = 1;
    			$speedsD = ['30', '90', '40', '20', '50', '70', '80'];
				shuffle($speedsD);
				$speedD = $speedsD[0];
				$camsgD = $speedD;
				// $camsgD = '30';
    		}elseif($statusD == 2){
    			// $blueD = 0; Mar 6
    			$redD = 1;
    			$mD = 1;
    			$twoD = 1;
    			$camsgD = $speedD;
				// $camsgD = '120';
    		}
    		if($mD != null){
    			$ascDistanceD += $distanceD;
    			if($ascDistanceD >= 0.8){
    				$redD = 2;
    				$blueD = 0; // Mar 6
    			}if($ascDistanceD >= 0.8 && $twoD != null){
	    			$statusD = -2;
	    			$speedsD = ['30', '90', '40', '20', '50', '70', '80'];
					shuffle($speedsD);
					$speedD = $speedsD[0];
					$camsgD = $speedD;
					// $camsgD = '60';
	    			$twoD = null;
	    		}elseif($ascDistanceD <= 0.8){
	    			$redD = 1;
	    		}
    		}



		    $data1D[] = [
		    	'id' => $i,
		    	'name' => strtoupper($nameD),
		    	'lat' => (string) $latD, 
		    	'lng' => (string) $lngD,
		    	'distance' => (string) round($distanceD, 2),
		    	'ohe' => $pointsD,
		    	'next_ohe' => $nextpointD ?? 'N/A',
		    	'status' => $statusD,
		    	'red' => $redD,
		    	'blue' => $blueD,
		    	'camsg' => $camsgD,
		    ];
		    $resultD = array_map(function ($elementD) {
		    $partsD = preg_split('/[-\s]/', $elementD);
			    return trim($partsD[0]);
			}, $namesD);
			$resultD = array_filter($resultD);
			$descD = implode(' ', array_map('strtoupper', $resultD));
			$namesD = explode(' ', $descD);
			$firstValueD = reset($namesD);
			$lastValueD = end($namesD);

		    $dataD = ['name' => $firstValueD . ' ' . $lastValueD, 'desc' => $descD];
		    $dataD['station'] = $data1D;
		    $stationsD = [
	            'lat' => $latD, 
	            'lng' => $lngD, 
	        ];
		    $iD++;
		}
		$arrayD = array_reverse($data1D);
		$cD = $datasD = null;
		$oneD = 1;
        $decDistanceD = 0;
		foreach($arrayD as $arrD){
			if($arrD['status'] == 1){
				$cD = 1;
				$oneD = 1;
				$decDistanceD = 0;
				$speedD = $arrD['camsg'];
			}elseif($arrD['status'] == 2){
				$cD = null;
				$oneD = null;
			}
			if($cD != null){
				$decDistanceD += $arrD['distance'];
				if($decDistanceD <= 1.0){
    				$arrD['red'] = 1;
					// 13-03-2024 $arrD['camsg'] = '90';
					// $arrD['camsg'] = '30';
    			}if($decDistanceD >= 1.0 && $oneD != null){
    				$arrD['status'] = -1;
    				// $arrD['camsg'] = '90';
    				$arrD['camsg'] = $speedD; // 13-03-2024
    				$oneD = null;
    			}
			}
			$valuesD[] = $arrD;
			$datasD = ['name' => $dataD['name'], 'desc' => $dataD['desc']]; 
			$datasD['station'] = $valuesD;
		}
		$datasD["station"] = array_reverse($datasD["station"]);


		$startreachDisD = 0;
		$endreachDisD = 0;
		$reachvalueD = null;
		foreach($datasD['station'] as $key => $valueD){
			if($valueD['red'] != 1){
				$startreachDisD += $valueD['distance'];
			}else{
				$startreachDisD = 0;
			}
			$r_s_oheD = '';
			$b_s_oheD = '';
			$b_e_oheD = '';
			$r_e_oheD = '';
			if($valueD['status'] == -1){
				$r_s_oheD = $valueD['ohe'];
			}if($valueD['status'] == 1){
				$b_s_oheD = $valueD['ohe'];
			}if($valueD['status'] == 2){
				$b_e_oheD = $valueD['ohe'];
			}if($valueD['status'] == -2){
				$r_e_oheD = $valueD['ohe'];
			}
			$valueD['start_reach_dis'] = (string) round($startreachDisD, 2);
			$valueD['r_s_ohe'] = $r_s_oheD ?? '';
			$valueD['b_s_ohe'] = $b_s_oheD ?? '';
			$valueD['b_e_ohe'] = $b_e_oheD ?? '';
			$valueD['r_e_ohe'] = $r_e_oheD ?? '';
			$rvalueD[] = $valueD;
    		$reachvalueD = ['name' => $dataD['name'], 'desc' => $dataD['desc']]; 
    		$reachvalueD['station'] = $rvalueD;
		}

		$valD = array_reverse($reachvalueD['station']);
		$datD = $eD = $sD = null;
		// $r_s_tot = '0';
		foreach($valD as $vD){
			if($vD['status'] == -1){
				$r_s_totD = $vD['start_reach_dis'];
				$vD['start_reach_dis'] = '0';
			}elseif($vD['red'] == 1){
				$r_s_totD = '0';
			}elseif($vD['status'] != -1 && $vD['status'] != 2){
				$vD['start_reach_dis'] = $r_s_totD ?? '0';
			}

			if($vD['status'] == -2){
				$r_e_oheD = $vD['r_e_ohe'];
			}

			if($vD['status'] == 2){
				$b_e_oheD = $vD['b_e_ohe'];
			}elseif($v['status'] == -2){
				$b_e_oheD = '-';
			}

			if($vD['status'] == 1){
				$b_s_oheD = $vD['b_s_ohe'];
				$sD = null;
			}elseif($vD['status'] == -2 || $vD['status'] == 2){
				if($sD == null){
					$b_s_oheD = $b_s_oheD;
					$sD = 1;
				}
			}elseif($sD != null){
				$b_s_oheD = '-';
			}

			if($vD['status'] == -1){
				$r_s_oheD = $vD['r_s_ohe'];
			}elseif($vD['status'] == -2 && $vD['red'] == 2){
				$r_s_oheD = $r_s_oheD;
			}elseif($vD['status'] == 0 && $vD['red'] == 1){
				$r_s_oheD = '-';
			}

			$vD['r_s_ohe'] = ($vD['status'] == -1) ? '-' : $r_s_oheD;
			$vD['b_s_ohe'] = ($vD['status'] == 1) ? '-' : $b_s_oheD;
			$vD['b_e_ohe'] = $b_e_oheD;
			$vD['r_e_ohe'] = $r_e_oheD;
			$vvD[] = $vD;
			$datD = ['name' => $dataD['name'], 'desc' => $dataD['desc']]; 
			$datD['station'] = $vvD;
		}

		$new_dataD = array_reverse($datD["station"]);
		$newD = $reach_disD = $nD = null;
		foreach($new_dataD as $newwD){
			if($newwD['red'] != 1){
				if($nD == null){
					$reach_disD = $newwD['start_reach_dis'];
					$nD = 1;
				}
				$reach_disD = $reach_disD - $newwD['distance'];
				$reach_disD = (string) round($reach_disD, 2);
			}if($newwD['status'] == -1){
				$reach_disD = '0';
				$nD = null;
			}			
			$newwD['start_reach_dis'] = (string) round($reach_disD, 2) ?? '0';
			$n_valD[] = $newwD;
			$newD = ['name' => $dataD['name'], 'desc' => $dataD['desc']]; 
			$newD['station'] = $n_valD;
		}




        return response()->json([$new, $newD], 200);	
    }


    public static function calculateDistance($firstlat,$firstlng,$secondlat,$secondlng)
	{
	    $earthRadius = 6371; // Earth's radius in kilometers

	    $dLat = deg2rad($secondlat - $firstlat);
	    $dLng = deg2rad($secondlng - $firstlng);

	    $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($firstlat)) * cos(deg2rad($secondlat)) * sin($dLng / 2) * sin($dLng / 2);
	    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

	    $distance = $earthRadius * $c;
	    $distanceInMeters = $distance * 1000;

	    return $distance;
	}
}
