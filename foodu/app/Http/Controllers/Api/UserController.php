<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Response, Hash ;
use Illuminate\Http\Request;
use App\User;
use App\Models\Deliveryboy;
use App\Models\Useraddress;
use App\Models\Restaurant;
use App\Models\Wallet;
// use LucaDegasperi\OAuth2Server\Authorizer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\EmailController as emailcon;
use App\Http\Controllers\UserController as usercon;
use App\Models\OrderDetail;
use App\Models\Front\Favorites;
use App\Models\RiderLocationLog;
use App\Models\OfferUsers;
use App\Models\promocode;
use App\Models\Front\Usercart;
use JWTAuth;
use Razorpay\Api\Api;
use App\Http\Controllers\Api\OrderController;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Restaurantrating;
use Illuminate\Validation\Rule;
use Kreait\Laravel\Firebase\Facades\Firebase;
use League\Csv\Reader;
use App\Models\Deliveryboywallet;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class UserController extends Controller {

	function __construct()
	{
		if( ( request('group_id') == 8 || request('user_type') == 'delivery' ) ){
			$user = Deliveryboy::class;
		} else {
			$user = User::class;
		}

	    \Config::set('jwt.user', $user);
	    \Config::set('auth.providers', ['users' => [
	            'driver' => 'eloquent',
	            'model' => $user,
	        ]]);
	    parent::__construct();
	}

	function updateBoyStatus(Request $request)
	{
		$rules['mode'] = 'required|in:online,offline';
		$this->validateDatas($request->all(),$rules);
		if($request->mode == 'offline'){
			if(\DB::table('abserve_order_details')->where('boy_id',\Auth::user()->id)/*->whereIn('status',['2','3'])*/->where('customer_status', '!=', 'delivered')->exists()){
				$status = 1;
				return \Response::json(['message'=>'You have one unfinished order. Kindly complete it.', 'mode' => $status],200);
			}
		}
		$status = $request->mode == 'online' ? 1 : 0;
		User::where('id', \Auth::user()->id)->update(['mode' => $request->mode, 'online_sts' => $status]);
		return \Response::json(['message' => 'Status Updated Successfully', 'mode' => $status],200);
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

	function getProfile( Authorizer $authorizer,$user_type )
	{
		$user_id = $authorizer->getResourceOwnerId(); // the token user_id
		if($user_type == 'user'){
			$user = User::find($user_id);
		} else {
			$user = Deliveryboy::find($user_id);
		}
		if(empty($user)){
			$response['message'] =  'Invalid User';
			response()->json($response, 422)->send();exit();
		}
		return $user;
	}

	function integrateSocial(Request $request)
	{
		$aUser = \Auth::user();
		$usercon = new usercon;
		$request['integrate'] = $aUser->id;
		$result = $usercon->postChecksocial($request);
		$response['message'] =  'This account is already been used by another user. Try a different ID';
		$code = 422;
		if(json_decode($result)->result == 1)
		{
			$response['message'] =  'Integration Successful';
			$code = 200;
		}
		response()->json($response, $code)->send();exit();
		return $result;
	}

	function profile(Request $request)
	{
		$aUser = \Auth::user();

		$rules['user_type'] 	= 'required|in:user,delivery';
		$this->validateDatas($request->all(),$rules);

		$select = 'id,group_id,username,email,date_of_birth,gender,country,phone_code,phone_number,avatar,email_verified,address,updated_at,social_type,first_name,last_name,referral_code';
		if($request->user_type == 'user'){
			$update_user = User::find($aUser->id,explode(',', $select))->append('src','bank_account_detail');
			if($update_user->group_id == '3'){
				$from = 'partner';
				$select .= ',business_name,cuisine_type,business_addr,res_type';
				$update_user = User::find($aUser->id,explode(',', $select))->append('src','bank_account_detail');
			} else {
				$from = 'customer';
			}
		} else {
			$from = 'delivery';
			$select .= ',address,latitude,longitude,nric_number,id_type,motorbike,motorbikelicense';
			$update_user = Deliveryboy::find($aUser->id,explode(',', $select))->append('src');
		}
		if($request->input('updated_at') !== null && $update_user->updated_at <= $request->updated_at){
			$status = 304;
			$response['message'] = 'Not Modified';
		} else {
			$response['user'] = $update_user;
			if($update_user->group_id == '3'){
				$bank = \DB::table('abs_bank')->where('name',$update_user->bank_account_detail->Bank_Name)->first();
				$response['user']['bank_id'] = $bank->id ?? 0;
			}
			if($from == 'partner'){

			}
			$status = 200;
		}
		

		return \Response::json($response,$status);
	}

	function editprofile(Request $request)
	{
		$aUser = \Auth::user();
		
		$rules['user_type'] 	= 'required|in:user,delivery';
		if($request->first_name){
			$rules['first_name'] 		= 'required|min:2|max:25|regex:/^[\pL\s\-]+$/u';
		}elseif($request->last_name){
			$rules['last_name'] 		= 'required|min:2|max:25|regex:/^[\pL\s\-]+$/u';
		}elseif($request->email){
			$rules['email'] 		= 'required|email|unique:tb_users|unique:abserve_deliveryboys,email,'.$aUser->id;
			/*$rules['email'] = [
			    'required',
			    'email',
			    Rule::unique('tb_users')->ignore($aUser->id),
			    Rule::unique('abserve_deliveryboys', 'email')->ignore($aUser->id),
			];*/
		}
		if($request->has('avatar')){
			$rules['avatar'] 	= 'required|mimes:png,jpeg,jpg,png|max:1024';
		}
		if($request->user_type == 'user'){
			if($aUser->group_id == '3'){
				$rules['Bank_Name'] 		= 'required';
				$rules['Bank_AccName'] 		= 'required';
				$rules['Bank_AccNumber'] 	= 'required';
				$rules['business_name']     = 'required';
				$rules['business_addr']     = 'required';
				$rules['ifsc_code']     = 'required';
				$rules['aadhar_no']     = 'required';
				$rules['gst_no']     = 'required';
				$rules['fssai_no']     = 'required';
				$rules['pan_no']     = 'required';
			}
		} else {
			// $rules['email'] 		= 'required|email|unique:tb_users|unique:abserve_deliveryboys,email,'.$aUser->id;
			// $rules['phone_number'] 	= 'required|unique:tb_users,phone_number|unique:abserve_deliveryboys,phone_number,'.$aUser->id.'|numeric';
		}

		$this->validateDatas($request->all(),$rules);

		if($request->user_type == 'user'){
			$user = User::find($aUser->id);
			$path = 'uploads/users/';
		} else {
			$user = Deliveryboy::find($aUser->id);
			$path = 'uploads/deliveryboys/';
		}
		/*$params = ['username','address'];

		foreach ($params as $key => $value) {
			$user->{$value} = $request->{$value};
		}*/
		$user->first_name = $request->first_name;
		$user->last_name  = $request->last_name;
		$user->username     = $request->first_name.' '.$request->last_name;
		$user->date_of_birth = $request->date_of_birth;
		$user->email = $request->email;
		$user->gender = $request->gender;
		$user->address = $request->address;
		$user->business_addr = $request->business_addr;
		$user->business_name = $request->business_name;
		if($request->hasFile('avatar')){
			/*$oldImageName = $aUser->avatar;
			$upload = \AbserveHelpers::uploadImage($request->file('avatar'),$path,$oldImageName,'');
			if($upload['success']){
				$user->avatar = $upload['image'];
			}*/
			$image = $request->file('avatar');
		    $filename = time() . '_' . $image->getClientOriginalName();
            $image->move('uploads/users', $filename);
            $user->avatar = $filename;
		}
		$user->updated_at = date('Y-m-d H:i:s');
		$user->save();
		$response['message'] = 'Saved Successfully...';
		if($request->user_type == 'user' && $aUser->group_id == '3'){
			$bankFields = ['Bank_Name','Bank_AccName','Bank_AccNumber','ifsc_code','gst_no','aadhar_no','fssai_no','pan_no'];
			foreach ($bankFields as $key => $value) {
				$bank[$value] = $request->{$value};
			}
			$bank['partner_id']	= $user->id;
			$bank['Mobile']		= $user->phone_number;
			if(\DB::table('tb_partner_accounts')->where('partner_id',$aUser->id)->exists()){
				\DB::table('tb_partner_accounts')->where('partner_id',$aUser->id)->update($bank);
			} else {
				\DB::table('tb_partner_accounts')->insert($bank);
			}
		}
		$select = ['username','avatar','updated_at','address','email','date_of_birth','gender','first_name','last_name'];
		if($request->user_type == 'user'){
			$update_user = User::find($aUser->id,$select)->append('src');
		} else {
			$update_user = Deliveryboy::find($aUser->id,$select)->append('src');
		}
		$response['user'] = $update_user;
		return \Response::json($response,200);
	}

	function verifyEmailRequest(Request $request)
	{
		$aUser = \Auth::user();

		$rules['user_type'] 	= 'required|in:user,delivery';

		if($request->user_type == 'user'){
			$rules['email'] 		= 'required|email|unique:tb_users,email,'.$aUser->id.'|unique:abserve_deliveryboys,email';
		} else {
			$rules['email'] 		= 'required|email|unique:tb_users|unique:abserve_deliveryboys,email,'.$aUser->id;
		}

		$this->validateDatas($request->all(),$rules);

		if($request->user_type == 'user'){
			$user = User::find($aUser->id);
		} else {
			$user = Deliveryboy::find($aUser->id);
		}

		if($user->email_verified == '0'){

			$code = rand(10000,10000000);
			$code = 1111;
			$user->activation = $code;
			$user->updated_at = date('Y-m-d H:i:s');
			$user->save();

			$to = $request->input('email');
			$subject = "[ " .CNF_APPNAME." ] Email verification";
			$data['aUser'] = $user;
			$data['from'] = 'App';
			$view = 'emails.member.verifyemail';
			$emailcon = new emailcon;
			$emailcon->sendEmail($to,$subject,$view,$data);

			$response['message'] = 'Verification code send to your email. Check your inbox';
			$status = 200;

		} else {
			$response['message'] = 'Email already verified';
			$status = 422;
		}

		return Response::json($response,200);
	}

	function verifyEmail(Request $request)
	{
		$aUser = \Auth::user();

		$rules['user_type'] 	= 'required|in:user,delivery';
		$rules['type'] = 'required|in:submit,skip';

		if($request->user_type == 'user'){
			$rules['email'] 		= 'required|email|unique:tb_users,email,'.$aUser->id.'|unique:abserve_deliveryboys,email';
		} else {
			$rules['email'] 		= 'required|email|unique:tb_users|unique:abserve_deliveryboys,email,'.$aUser->id;
		}
		if($request->type !== null && $request->type == 'submit'){
			$rules['code'] = 'required';
		}

		$this->validateDatas($request->all(),$rules);

		if($request->user_type == 'user'){
			$userCheck = User::where('email',$request->email)->where('activation',$request->code)->first();
			$user = User::find($aUser->id);
		} else {
			$userCheck = Deliveryboy::where('email',$request->email)->where('activation',$request->code)->first();
			$user = Deliveryboy::find($aUser->id);
		}

		if(!empty($userCheck) || $request->type == 'skip'){
			if($request->type == 'skip'){
				$user->email_verified = 0;
				$response['message'] = 'Success';
			} else {
				$user->email_verified = 1;
				$response['message'] = 'Email verified Successfully';
			}
			$user->activation = 0;
			$user->updated_at = date('Y-m-d H:i:s');
			$user->save();
			$status = 200;

		} else {
			$response['message'] = 'Invalid Code';
			$status = 422;
		}

		return Response::json($response,$status);
	}

	function changePassword(Request $request)
	{
		$aUser = \Auth::user();

		$rules['user_type'] 	= 'required|in:user,delivery';
		$rules['old_password'] 		= 'required';
		$rules['new_password'] 		= 'required|between:6,12';

		$this->validateDatas($request->all(),$rules);

		$status = 422;

		if($request->old_password != $request->new_password) {

			$password_match = Hash::check($request->old_password, $aUser->password);

			if($password_match){
				$update_user = User::find($aUser->id);
				$update_user->password = Hash::make($request->new_password) ;
				$update_user->updated_at = date('Y-m-d H:i:s');
				$update_user->save();

				$response['message'] = 'Password changed Successfully';
				$status = 200;
			} else {
				$response['message'] = 'Old password is incorrect';
			}
		} else {
			$response['message'] = 'Old password and new password cant be same';
		}

		return Response::json($response,$status);
	}

	function favoriteAction(Request $request)
	{
		$rules['restaurant_id'] = 'required';

		$this->validateDatas($request->all(),$rules);

		$aUser = \Auth::user();

		$restaurantCheck = \AbserveHelpers::restaurantCheckFront($request->restaurant_id);

		if(!$restaurantCheck){
			return \Response::json(['message' => 'Restaurant not found'],422);
		}

		$check = Favorites::where('user_id',$aUser->id)->where('resid',$request->restaurant_id)->first();

		if(!empty($check)){
			Favorites::where('user_id',$aUser->id)->where('resid',$request->restaurant_id)->delete();
			$response['message'] = 'Removed';
		} else {
			$val['user_id'] 	= $aUser->id;
			$val['resid'] 		= $request->restaurant_id;
			$val['savedtime'] 	= date('Y-m-d H:i:s');
			\DB::table('abserve_favourites')->insert($val);
			$restaurant_id = $request->restaurant_id;
			$select = ['id','name','location','logo','partner_id','delivery_time','budget','rating','res_desc','mode','delivery_time','cuisine','minimum_order','free_delivery'];
			$where = 'showAllwhere';$whereCondition = '';$whereField = 'id';$whereValues = $restaurant_id;
			$user_id = $aUser->id;
			$device_id = $request->device_id;
			$restaurant = \AbserveHelpers::getRestaurantBaseQuery($select,$where,$whereCondition,$whereField,$whereValues)->first();
			$restaurant->append('src','availability','cuisine_text');
			$restaurant->favourite_status = $restaurant->getFavouriteAttribute($user_id);
			$restaurant->promo_status = $restaurant->getPromoCheckAttribute($user_id);
			$restaurant->cart_exist = $restaurant->getCartExistCheckAttribute($device_id,$user_id);

			$aRestaurant[] = $restaurant;
			$response['aRestaurant'] = $aRestaurant;
			$response['message'] = 'Added';
		}

		return \Response::json($response,200);
	}

	function savedAddress(Request $request)
	{

		$aUser = \Auth::user();

		$query = Useraddress::select('id','address_type','building','landmark','address','lat','lang','city','state','del_status', 'apply_status','other_label')->where('user_id',$aUser->id)->where('del_status','0')->where('hide','0');
		$orderBy = 'id';
		if($request->input('latitude') !== null && $request->latitude != '' && $request->latitude >= 0 &&$request->input('longitude') !== null && $request->longitude >= 0 && $request->longitude != '' ){
			$radius = \AbserveHelpers::site_setting1('delivery_distance');
			$latitude = $request->latitude;
			$longitude = $request->longitude;
			$lat_lng = " ( round( 
			( 6371 * acos( least(1.0,  
			cos( radians(".$latitude.") ) 
				    * cos( radians(lat) ) 
				    * cos( radians(lang) - radians(".$longitude.") ) 
			+ sin( radians(".$latitude.") ) 
				    * sin( radians(lat)
			) ) ) 
			), 6) ) AS distance ";
			$query->addSelect(\DB::raw($lat_lng))->having('distance', '<=' , $radius);
			$orderBy = 'distance';
		} elseif($request->input('city') !== null && $request->city != ''){
			$query->where('city',$request->city);
		}

		$response['aAddress'] = $query/*->orderBy($orderBy)*/->get()->map(function($result){
			return $result->append('address_type_text');
		});

		return \Response::json($response,200);
	}

	function savedFavorites(Request $request)
	{

		$aUser = \Auth::user();
		$user_id = $aUser->id;
		$device_id = $request->device_id;
		$Favorites = Favorites::select(\DB::raw('GROUP_CONCAT(resid) as resids'))->where('user_id',$user_id)->where('status', 1)->first();
		if($Favorites->resids != ''){
			$aResIds = explode(',', $Favorites->resids);
			$select = ['id','name','location','logo','partner_id','delivery_time','budget','rating','res_desc','mode','delivery_time','cuisine','minimum_order','free_delivery'];
			$where = 'whereIn';$whereCondition = '';$whereField = 'id';$whereValues = $aResIds;
			$aRestaurant = \AbserveHelpers::getRestaurantBaseQuery($select,$where,$whereCondition,$whereField,$whereValues)->get()->map(function ($result) use($device_id,$user_id) {
				$result->append('src','availability','cuisine_text');
				$result->promo_status 		= $result->getPromoCheckAttribute($user_id);
				$result->favourite_status 	= 1;
				$result->cart_exist 		= $result->getCartExistCheckAttribute($device_id,$user_id);
				return $result;
			});
		} else {
			$aRestaurant = [];
		}
		$response['aRestaurant'] = $aRestaurant;
		$response['aUser'] = $user_id;
		return \Response::json($response,200);
	}

	function manageSavedAddress(Request $request)
	{
		$rules['action'] = 'required|in:edit,delete,add';
		if($request->input('action') === null || $request->action != 'add'){
			$rules['address_id'] = 'required';
		}

		$this->validateDatas($request->all(),$rules);
		$aUser = \Auth::user();
		if($request->action != 'add'){
			$aUserAddress = Useraddress::find($request->address_id);
		}
		$user_id = $aUser->id;
		if($request->action != 'add' && (empty($aUserAddress) || $aUserAddress->user_id != $user_id)){
			return \Response::json(['message' => 'You do not have access'],422);
		}
		if($request->action == 'delete'){
			$aUserAddress->del_status = '1';
			$response['message'] = 'Deleted Successfully';
		} else {
			if($request->action != 'add' && $aUserAddress->del_status == '1'){
				return \Response::json(['message' => 'You do not have access'],422);
			}
			$addressAveFields = ['address_type','building','landmark','address','lat','lang','city','state'];
			$response['message'] = 'Updated Successfully';
			if($request->action == 'add') {
				$adrsExist	= Useraddress::where('user_id',$user_id)->where('address',$request->address)->where('del_status','0')->first();
				$aUserAddress	= (empty($adrsExist)) ? new Useraddress : Useraddress::find($adrsExist->id);
				$aUserAddress->created_at	= date('Y-m-d H:i:s');
				$response['message']		= 'Added Successfully';
			}
			foreach ($addressAveFields as $key => $value) {
				$aUserAddress->{$value}	= $request->input($value) !== null ? $request->{$value} : '';
			}
			
		}
		$aUserAddress->user_id = $user_id;
		$aUserAddress->updated_at = date('Y-m-d H:i:s');
		$aUserAddress->other_label = isset($request->other_label) && !empty($request->other_label)? $request->other_label:null;
		$aUserAddress->save();
		if($request->action != 'delete'){
			$select = ['id','other_label','address_type','building','landmark','address','lat','lang','city','state'];
			$uaddress = Useraddress::find($aUserAddress->id,$select);
			$uaddress->append('address_type_text');
			$aAddress[] = $uaddress;
			$response['aAddress'] = $aAddress;
		}
		return \Response::json($response,200);
	}

	function userAvailablePromos(Request $request)
	{
		$aUser = \Auth::user();

		$restaurant_id = $request->input('restaurant_id') !== null && $request->restaurant_id > 0 ? $request->restaurant_id : '';
		$response['aPromocode'] = \AbserveHelpers::getAvailablePromos($aUser->id,'','',$restaurant_id,'','');

		return \Response::json($response,200);
	}

	function userWalletDetail(Request $request)
	{
		$aUser = \Auth::user();
		// echo $aUser->id; exit();
		$response['walletdetails'] = Wallet::where('user_id',$aUser->id)->get();
		$response['user_wallet_balance'] = $aUser->customer_wallet;

		return \Response::json($response,200);
	}

	function userOfferDetail(Request $request)
	{
		$aUser = \Auth::user();
		$response['offers'] = OfferUsers::where('cust_id',$aUser->id)->get();
		$response['offer_total'] = $aUser->offer_wallet;

		return \Response::json($response,200);
	}

	function logout(Request $request)
	{
		$aUser = \Auth::user();
		JWTAuth::invalidate(JWTAuth::getToken());
		if($request->user_type == 'delivery'){
			Deliveryboy::where('id',$aUser->id)->update(['online_sts'=>'0','mobile_token'=>'']);
		}
		\Session::flush();
		$response['msg'] = 'success';
		return \Response::json($response,200);
	}

	function addFavouriteFood(Request $request)
	{
		$user_id = \Auth::user()->id;
		$food_id = $request->food_id;
		$res_id  = $request->res_id;
		if($food_id){
		$isFavourite = Favorites::where('food_id', $food_id)->where('user_id', $user_id)->first();
		// $isFavourite->makeHidden('created_at', 'updated_at');
		if($isFavourite){
			$isFavourite->user_id = $user_id;
			$isFavourite->food_id = $food_id;
			$isFavourite->status  = ($isFavourite->status == 1) ? 0 : 1;
			$isFavourite->save();
			if($isFavourite->status == 1){
				$response['message'] = 'Food Added to Your Favourites';
			}else{
				$response['message'] = 'Food Removed from Favourites';
			}
			$response['userFavourites'] = $isFavourite;
		}else{
			$addFavour = new Favorites();
			$addFavour->user_id = $user_id;
			$addFavour->food_id = $food_id;
			$addFavour->status  = 1;
			$addFavour->save();
			$response['message'] = 'Food Added to Your Favourites';
			$response['userFavourites'] = $addFavour;
		}
	}elseif($res_id){
		$isFavourite = Favorites::where('resid', $res_id)->where('user_id', $user_id)->first();
		// $isFavourite->makeHidden('created_at', 'updated_at');
		if($isFavourite){
			$isFavourite->user_id = $user_id;
			$isFavourite->resid = $res_id;
			$isFavourite->status  = ($isFavourite->status == 1) ? 0 : 1;
			$isFavourite->save();
			if($isFavourite->status == 1){
				$response['message'] = 'Restaurant Added to Your Favourites';
			}else{
				$response['message'] = 'Restaurant Removed from Favourites';
			}
			$response['userFavourites'] = $isFavourite;
		}else{
			$addFavour = new Favorites();
			$addFavour->user_id = $user_id;
			$addFavour->resid = $res_id;
			$addFavour->status  = 1;
			$addFavour->save();
			$response['message'] = 'Restaurant Added to Your Favourites';
			$response['userFavourites'] = $addFavour;
		}
	}
		return \Response::json($response,200);
	}

	function orderSummary(Request $request)
	{
		$user_id = \Auth::user()->id;
		$user_wallet = \Auth::user()->customer_wallet;
		$summary = Usercart::where('user_id', $user_id)->get()->append(['food_price', 'food_items']);
		$user_address = Useraddress::where('user_id', $user_id)->where('apply_status', 1)->where('del_status', 0)->first();
		if(empty($user_address)){
			$user_address = Useraddress::where('user_id', $user_id)->where('del_status', 0)->first();
			if(empty($user_address)){
				$response['user_address'] = (object)['address' => "No Address Found"];
				return \Response::json($response,200);
			}
		}
		if($summary->isNotEmpty()){
			$res = Restaurant::where('id', $summary[0]->res_id)->first();
			$delCharge = 0;
			$s_tax = 0;
			$aDelCharges['delivery'] = 0;
			$sub_total_price = $summary->sum(function ($item) {
	    		return $item->price * $item->quantity;
			});
			$s_gst = $summary->sum(function ($gst) {
	    		return $gst->gst;
			});
			if($res->service_tax1 > 0){
				$s_tax = $sub_total_price * ($res->service_tax1 / 100);
			}
			$gst = $s_gst + $s_tax;
			if(!empty($user_address)){
				$user_address->append('address_type_text');
				$userLat = $user_address->lat;
				$userLng = $user_address->lang;
				$restaurantLat = $res->latitude;
			    $restaurantLng = $res->longitude;
				$distance =  \AbserveHelpers::calculateDistance($userLat, $userLng, $restaurantLat, $restaurantLng);
				$aDelCharges = \AbserveHelpers::getDeliveryChargeValues($distance,$res,$sub_total_price);
			}
			// $promo = '';
			$discountAmount = 0;
			// $wallet_amount = 0;
			$averageSpeedKmph = 40;
			$travelTime = $distance / $averageSpeedKmph;
			$travelTimeInMinutes = $travelTime * 60;
			$travelTime = $travelTimeInMinutes ?? 0;
			// $grand_total_price = $gst + $sub_total_price + round($aDelCharges['delivery']);
			$total_price = $gst + $sub_total_price + $aDelCharges['delivery'];
			$currentDay = date('Y-m-d');

			$coupons = \DB::table('abserve_promocode')->select('id', 'promo_name', 'promo_desc', 'promo_amount', 'promo_code', 'promo_type', 'end_date')->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->whereRaw('FIND_IN_SET('.$summary[0]->res_id.',`res_id`)')->orWhere('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->where('res_id', 0)->get()->map(function($coupon){
				$co_codes = ['#FFE9EA', '#EEEEEE', '#FFF5C5', '#E7FFEF'];
				shuffle($co_codes);
				$coupon->colour_code = $co_codes[0];
				return $coupon;
			});

			$coupons = $coupons->filter(function($coupon) use($user_id) {
				$claim = \DB::table('abserve_promo_user_status')->where('user_id', $user_id)->where('coupon_id', $coupon->id)->first();
				if($claim == null){
					return $coupon;
				}
			})->values()->toArray();
			$promo_offer = \DB::table('abserve_promocode')->select('id', 'promo_name', 'promo_desc', 'promo_amount', 'promo_code', 'promo_type', 'end_date', 'min_order_value')/*->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')*/->where('min_order_value', '<=', $total_price)/*->where('res_id', $summary[0]->res_id)*/->where('promo_code', $request->promo_code)->first(); 

			$promo_chk = \DB::table('abserve_promocode')->select('id', 'promo_name', 'promo_desc', 'promo_amount', 'promo_code', 'promo_type', 'end_date', 'min_order_value')/*->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->where('res_id', $summary[0]->res_id)*/->where('promo_code', $request->promo_code)->first();

			if((isset($promo_offer) && $promo_offer != '') && $request->apply == 'true'){
				$coupon_msg = 'Coupon Applied Successfully';
				$insert = \DB::table('abserve_promo_user_status')->insert(['coupon_id' => $promo_offer->id, 'user_id' => $user_id/*, 'offer_claim' => 1*/]);
				if($promo_offer->promo_type == 'amount'){
					$total_price = $total_price - $promo_offer->promo_amount;
					$discountAmount = $promo_offer->promo_amount;
				}elseif($promo_offer->promo_type == 'percentage'){
					$discountPercentage = $promo_offer->promo_amount / 100;
					$discountAmount = $total_price * $discountPercentage;
					$total_price = $total_price - $discountAmount;
				}
			}elseif($request->apply == 'false'){
				$coupon_msg = 'Coupon Removed Successfully';
				$del = \DB::table('abserve_promo_user_status')->where('user_id', $user_id)->where('coupon_id', $promo_offer->id)->delete();
			}elseif($request->apply == 'true' && (isset($promo_chk) && $promo_chk != '')){
				$coupon_msg = "You have must be purhcase above .'$promo_chk->min_order_value'.";
			}

			if($discountAmount > 0){
				$strike_price = $sub_total_price;
				$sub_total_price = $sub_total_price - $discountAmount;
			}

			$types = [
						['name' => 'Cash On Delivery', 'image' => URL('uploads/COD.png'), 'amount' => ''],
			    		['name' => 'Razorpay', 'image' => URL('uploads/Razor.png'), 'amount' => ''],
			    		/*['name' => 'Wallet', 'image' => URL('uploads/wallet.png'), 'amount' => \Auth::user()->customer_wallet]*/
					];

			// user using wallet
			$wallet_msg = '';
			$w_user = User::find(\Auth::user()->id);
			if(isset($request->wallet_amount) && $request->wallet_amount != null){
			    $wallet_amount = $request->wallet_amount;
			}
			if(isset($request->wallet_apply) && isset($wallet_amount) && isset($request->wallet_apply_amount) && $wallet_amount <= $total_price){
			    if($request->wallet_apply == 'true' && ($w_user->customer_wallet > 0 && $w_user->customer_wallet >= $request->wallet_amount)){
			        $w_user->customer_wallet += $request->wallet_apply_amount;
			        $total_price -= $wallet_amount;
			        $w_user->customer_wallet -= $request->wallet_amount;
			        $wallet_msg = 'Applied';
			    } elseif($request->wallet_apply == 'false' && $w_user->customer_wallet > 0){
			        $w_user->customer_wallet += $request->wallet_apply_amount;
			        $wallet_msg = 'Cancelled';
			    }
			    foreach ($summary as $item) {
			        $item->update(['wallet' => $request->wallet_amount]);
			    }
			} elseif((!isset($request->wallet_apply)) && ($summary[0]->wallet) > 0 &&  ($summary[0]->wallet <= $total_price)){
			    $total_price -= $summary[0]->wallet;
			} elseif((isset($request->wallet_apply) && isset($wallet_amount)) && ($wallet_amount > $total_price)){
			    $wallet_amount = 0;
			    foreach ($summary as $item) {
			        $item->update(['wallet' => $wallet_amount]);
			    }
			    $w_user->customer_wallet += $request->wallet_apply_amount;
			    $wallet_msg = 'Not Applicable';
			}
			$w_user->save();
			// wallet end

			// $response['order_summary'] = $summary;
			$response['prices']['delivery_fee'] = round($aDelCharges['delivery'], 2);
			$response['prices']['gst'] = round($gst, 2);
			$response['prices']['sub_total'] = round($sub_total_price, 2);
			$response['prices']['discountAmount'] = round($discountAmount, 2);
			$response['prices']['strike_price'] = (isset($strike_price)) ? round($strike_price, 2) : 0;
			// $response['prices']['grand_total_price'] = round($grand_total_price);
			$response['prices']['wallet_apply_amount'] = isset($wallet_amount) ? round($wallet_amount, 2) : (isset($summary[0]) ? round(doubleval($summary[0]->wallet), 2) : 0);
			$response['prices']['total'] = round($total_price, 2);
			$response['user_address'] = $user_address;
			$response['restaurant_detail'] = $res;
			$response['travel_time'] = round($travelTime,2);
			$response['avail_coupons'] = $coupons;
			$response['payemnt_types'] = $types;
			$response['user_wallet'] = (string)$w_user->customer_wallet;
			if(isset($promo_offer) && $promo_offer != null){
				$response['applied_promo'] = $promo_offer;
			}else{
				$response['applied_promo'] = (object)["id" => 0, "promo_name" => '', "promo_desc" => '', "promo_amount" => 0, "promo_code" => '', "promo_type" => '', "end_date" => ''];
			}
			$response['coupon_msg'] = (isset($coupon_msg) && $coupon_msg != '') ? $coupon_msg : '';
			$response['wallet_msg'] = $wallet_msg;
		}else {
			$response['message'] = 'Your cart is empty';
		}
		return \Response::json($response,200);

	}

	function cartList(Request $request)
	{
		$user_id = \Auth::user()->id;
		$cartList = Usercart::where('user_id', $user_id)->get()->append(['food_price', 'food_items']);
		$response['cart_list'] = $cartList;
		return \Response::json($response,200);
	}

	function applyAddress(Request $request)
	{
		$user_id = \Auth::user()->id;
		$address = Useraddress::where('user_id', $user_id)->where('del_status', 0)->update(['apply_status' => 0]);
		$address = Useraddress::where('user_id', $user_id)->where('del_status', 0)->where('id', $request->address_id)->update(['apply_status' => 1]);
		$response['message'] = 'Address Applied Successfully';
		return \Response::json($response,200);
	}

	function showCart(Request $request)
	{
		$user_id = 0;
		if($request->user_id > 0){
			$user_id = $request->user_id;
		}
		$uCart = Usercart::where('user_id', $user_id)->get()->append(['restaurant_name', 'food_items']);
		if($uCart->isNotEmpty()){
			$response['uCart'] = $uCart;
		}else{
			$response['uCart'] = [];
		}
		return \Response::json($response,200);
	}

	public function userNotifications(Request $request)
	{
		$user_id = \Auth::user()->id;
		$notification = \DB::table('user_notification')->where('user_id', $user_id)->orderBy('id', 'desc')->get()->map(function($notification){
			if($notification->notification == 'Account Setup Successful!'){
				$notification->src = URL('uploads/Account setup sucessful.png');
			}elseif($notification->notification == 'Top up Successfull!'){
				$notification->src = URL('uploads/Wallet.png');
			}elseif($notification->notification == 'Orders Cancelled!'){
				$notification->src = URL('uploads/order cancel.png');
			}elseif($notification->notification == 'Orders Successful!'){
				$notification->src = URL('uploads/order successful.png');
			}
			return $notification;
		});
		// if(isset($request->status)){
			$update = \DB::table('user_notification')->where('user_id', $user_id)->update(['status' => 1]);
		// }
		$response['user_notifications'] = $notification;
		return \Response::json($response,200);
	}

	function userWalletTopup(Request $request)
	{
		$rules['razorpay_payment_id'] = 'required';
		$this->validateDatas($request->all(),$rules);
		$user = \Auth::user();
		// $amount = $request->amount;
		$razorpay_payment_id = $request->razorpay_payment_id;
		$api_key	= RAZORPAY_API_KEYID;
		$api_secret	= RAZORPAY_API_KEY_SECRET;
		$api	= new Api($api_key, $api_secret);
		// $paise_amount = round($amount * 100);
		$transaction_status = '';
		$paid_amount = 0;
		$order_id = '';
		if($razorpay_payment_id != ''){
			$razor	= $api->payment->fetch($razorpay_payment_id);
			$transaction_status	= $razor->status;
			$paid_amount		= $razor->amount;
			$order_id           = $razor->order_id;
			$transaction_id	    = $razorpay_payment_id;
			$razor_capture = $api->payment->fetch($razorpay_payment_id)->capture(array('amount'=>$paid_amount,'currency' => 'INR'));

		}
		$paid_amount = $paid_amount/100;
		$balance = Wallet::where('user_id', $user->id)->sum('amount');
		$currentDateTime = now();
		$timeFormatted = $currentDateTime->format('h:i:s');
		$wallet = new Wallet;
		$wallet->user_id = $user->id;
		$wallet->amount  = $paid_amount;
		$wallet->title  = 'Top Up E-Wallet';
		$wallet->type    = 'credit';
		$wallet->balance = $balance + $paid_amount;
		$wallet->date    = date('Y-m-d');
		$wallet->time    = $timeFormatted;
		$wallet->r_order_id = $order_id;
		$wallet->order_status = $transaction_status;
		$wallet->transaction_id = $razorpay_payment_id;
		$wallet->save();

		$notification = \DB::table('user_notification')->insert([
			'user_id' => $user->id,
			'notification' => 'Top up Successfull!',
			'status' => 0,
			'content' => "You have successfully top up e-wallet for ".$paid_amount."",
			'date' => date('Y-m-d'),
			'time' => $timeFormatted
		]);

		$title = 'Top up';
		$message = 'Top up successful';
		// \AbserveHelpers::sendPushNotification($user->id, $title, $message);
		$this->sendpushnotification($user->id,'user',$message);
		
		$user_wal = User::find($user->id);
		$user_wal->customer_wallet = $user->customer_wallet + $paid_amount;
		$user_wal->card_number = $request->card_number;
		$user_wal->expiry_year = $request->expiry_year;
		$user_wal->cvv = $request->cvv;
		$user_wal->card_name = $request->card_name;
		$user_wal->save();
		$response['message'] = 'Wallet amount added successfull';
		$response['wallet_details'] = $wallet;
		return \Response::json($response,200);
	}

	public function accountDelete(Request $request)
	{
		$user   			= \Auth::user();
		$rules['device']    = 'required|in:ios,android';
		$this->validateDatas($request->all(),$rules);
		if($user->group_id == '3' || $user->group_id == '4'){
			$data       		= User::find($user->id);
		} else {
			$data = Deliveryboy::find($user->id);
		}
		$data->phone_number    = 0;
		$data->active          = '0';
		$data->save();
		$response['message']    = "Your account Deleted successfully";
		return \Response::json($response,200);
	}

	public function deleteCart(Request $request)
	{
		$user_id = 0;
		$food_id = $request->food_id;
		$message = false;
		if($request->user_id > 0){
			$user_id = $request->user_id;
		}
		if(($request->food_delete == true) && $request->food_id){
			$uCart = Usercart::where('user_id', $user_id)->where('food_id', $food_id)->delete();
			$message = 'Food Deleted Successfully';
		}elseif($request->cart_delete == true){
			$uCart = Usercart::where('user_id', $user_id)->get();
			if ($uCart->isNotEmpty()) {
			    $user = User::find($user_id);
			    $user->customer_wallet += $uCart->first()->wallet;
			    $user->save();
			    foreach ($uCart as $item) {
			        $item->delete();
			    }
			}
			$message = 'Cart Deleted Successfully';
		}
		$response['message'] = $message;
		return \Response::json($response,200);
	}

	public function userRating(Request $request)
	{
		$user_id = \Auth::user()->id;

		$res_id = 0;
		if(isset($request->order_id) && $request->order_id > 0){
			$order = OrderDetail::find($request->order_id);
			$res_id = $order->res_id;
		}
		$postRating = new Restaurantrating;
		$postRating->cust_id   = $user_id;
		$postRating->orderid   = $request->order_id;
		$postRating->res_id    = $res_id;
		$postRating->rating    = 0;
		if(isset($request->rating) && $request->rating != 0){
			$postRating->rating    = $request->rating;
		}
		$postRating->comments  = $request->comments;
		$postRating->save();

		$rating = Restaurantrating::where('res_id', $res_id)->average('rating');
		$res = Restaurant::where('id', $res_id)->update(['rating' => $rating]);

		$response['message'] = 'Thank You For Your Rating';
		return \Response::json($response,200);
	}

	/*public function trainroute(Request $request)
	{
		$csvFilePath = public_path('3MGSJ-DSPT.csv');
        if (!file_exists($csvFilePath)) {
           return response()->json(['error' => 'CSV file not found'], 404);
        }
        $csv = Reader::createFromPath($csvFilePath, 'r');
        $stmt = (new Statement())->offset(1);
        $data = $stmt->process($csv);
        // $desiredNames2 = ["MRPM","DC","VRPD"];
        $desiredNames2 = ["ED","CV","ANU","SGE","MVPM","MVPM","DC","VRPD"];
        $jsonData = [];
        $currentRoute2 = null;
        $station1 = null;
        $i = 1;

        foreach ($data as $row) {
		    $trainrouteName = $row[1];

		    if (in_array($trainrouteName, $desiredNames2)) {
		        $firstValue = reset($desiredNames2);
		        $lastValue = end($desiredNames2);

		        if ($station1 !== null && $i % 2 == 0) {
		            $currentRoute2 = [
		                'name' => $firstValue . ' ' . $lastValue,
		                'desc' => implode(' ', $desiredNames2),
		                'station' => [],
		            ];
		            $jsonData['trainroute'][] = $currentRoute2;
		            $station2[] = [
		                'name' => $trainrouteName,
		                'start_lat' => $station1['lat'],
		                'start_lng' => $station1['lng'],
		                'end_lat' => $row[5], 
		                'end_lng' => $row[6], 
		                'caution' => ($row[8] === 'S' ? true : false), 
		                'camsg' => 'Speed 60km/hr',
		            ];
		            $currentRoute2['station'] = $station2;
		        }
		        $station1 = [
		            'lat' => $row[5], 
		            'lng' => $row[6], 
		        ];
		        $i++;
		    }
		}
        return response()->json($currentRoute2, 200);
	}*/

	public function walletHistory(Request $request)
	{
		$user_id = \Auth::user()->id;
		$wallets = Wallet::where('user_id', $user_id)->orderByDesc('id')->get();
		$wal_img = URL('uploads/wallet.svg');
		foreach ($wallets as $wallet) {
			if($wallet->type == 'credit'){
		    	$wallet->src = $wal_img;
		    }else{
		    	$order = OrderDetail::where('id', $wallet->order_id)->select('res_id')->first();
		    	$res = Restaurant::find($order->res_id);
		    	$wallet->src = URL('uploads/restaurants/'.$res->logo);
		    }
		}
		$u_card = User::where('id', $user_id)->select('id', 'username', 'customer_wallet', 'card_number', 'expiry_year', 'cvv', 'card_name')->first();
		$response['wallet_history'] = $wallets;
		$response['card_details'] = $u_card;
		return \Response::json($response,200);
	}

	public function availableCoupons(Request $request)
	{
		$user = \Auth::user();
		$currentDay = date('Y-m-d');
		$offers = Promocode::where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->get();

		$distance = 20;
		$userLatitude = (isset($user->lat) && $user->lat != '') ? $user->lat : $user->latitude;
		$userLongitude = (isset($user->lang) && $user->lang != '') ? $user->lang : $user->longitude;

		$offers = $offers->filter(function ($offer) use ($userLatitude, $userLongitude, $distance) {
			$offer->res_detail = $offer->getResDetailAttribute();
            $restaurantLatitude = $offer->res_detail->latitude;
            $restaurantLongitude = $offer->res_detail->longitude;
            $distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
            return $distanceKm <= $distance;
        })->values()->toArray();

		$response['Available_Offers'] = $offers;
		return \Response::json($response,200);
	}

	public function DeliveryBoyWalletHistory(Request $request)
	{
		$user_id   = \Auth::user()->id;
		$u_details = User::where('id', $user_id)->select('id','customer_wallet','boy_cashIn_hand')->first();
		$response['user_details'] = $u_details;
		return \Response::json($response,200);
	}

	public function BoyWalletHistoryDetails(Request $request)
	{
		$user_id   = \Auth::user()->id;
		
		$wallet_history = Deliveryboywallet::with(['orderdetails' => function($query) {
		    $query->with('restaurant');
		    $query->selectRaw("*, FROM_UNIXTIME(completed_time, '%d-%m-%Y') as completed_date, FROM_UNIXTIME(completed_time, '%h:%i:%s %p') as completed_time");
		}])->where('del_boy_id', $user_id)->orderBy('id','desc')->paginate(10);
		
		$response['wallet_history'] = $wallet_history;
		return \Response::json($response,200);
	}

	public function deliveryBoyEarning(Request $request)
	{
		$user_id = \Auth::user()->id;
		$earning = Deliveryboywallet::where('del_boy_id', $user_id)->where('transaction_type','credit')
			    ->sum('transaction_amount');
        $earning = number_format($earning, 2);	    
		$response['earning'] = $earning;
		return \Response::json($response,200);
	}

	public function BoyEarningDetails(Request $request)
	{
		$user_id = \Auth::user()->id;
		$earning_details = Deliveryboywallet::with(['orderdetails' => function($query) {
			    $query->with('restaurant');
			    $query->selectRaw("*, FROM_UNIXTIME(completed_time, '%d-%m-%Y') as completed_date, FROM_UNIXTIME(completed_time, '%h:%i:%s %p') as completed_time");
			}])->where('del_boy_id', $user_id)->where('transaction_type','credit')->orderBy('id', 'desc')->paginate(10);
		$response['earning_details'] = $earning_details;
		return \Response::json($response, 200);
	}

	public function payAdmin(Request $request)
	{
		$rules['pay_type'] = 'required|in:card,wallet,both';
		if($request->pay_type == 'card' || $request->pay_type == 'both'){
		$rules['payment_id'] = 'required';		
		}
		if($request->pay_type == 'both'){
			$rules['wallet_amount'] = 'required';
		}
		$this->validateDatas($request->all(),$rules);
		$user_id   = \Auth::user()->id;
		$u_details = User::where('id', $user_id)->select('id','customer_wallet','boy_cashIn_hand')->first();
		if ($request->pay_type == 'wallet') {
			if($u_details->customer_wallet >= $u_details->boy_cashIn_hand){
				$delBoyWallet = new Deliveryboywallet();			
				$delBoyWallet->del_boy_id = $user_id;
				$delBoyWallet->transaction_id = '';
				$delBoyWallet->transac_through = 'wallet';
				$delBoyWallet->transaction_amount = $u_details->boy_cashIn_hand;
				$delBoyWallet->trans_date = now();
				$delBoyWallet->title	 =  '# Debited the wallet Amount ';
				$delBoyWallet->transaction_type = 'debit';
				$delBoyWallet->transaction_status = '1';
				$delBoyWallet->save();
			    $wallet = $u_details->customer_wallet - $u_details->boy_cashIn_hand;
			    $u_details->boy_cashIn_hand = 0.00;
				$u_details->customer_wallet = $wallet;
				$u_details->save();
			$response['message'] = 'Amount Send Successfully';
			} else {
				$response['message'] = 'Your wallet amount is less than your hand-in cash';
				return \Response::json($response,403);
			}  
		} elseif ($request->pay_type == 'card') {
			$payment_id = $request->payment_id;
			$api_key	= RAZORPAY_API_KEYID;
			$api_secret	= RAZORPAY_API_KEY_SECRET;
			$api	= new Api($api_key, $api_secret);
			if($payment_id != ''){
				$razor	= $api->payment->fetch($payment_id);
				$transaction_status	= $razor->status;
				$paid_amount		= $razor->amount;
				$razor_capture = $api->payment->fetch($payment_id)->capture(array('amount'=>$paid_amount,'currency' => 'INR'));
				if($razor_capture->status == 'success' || $razor_capture->status == 'captured'){
					$paid_amount  = $paid_amount/100;
				    $delBoyWallet = new Deliveryboywallet();			
					$delBoyWallet->del_boy_id = $user_id;
					$delBoyWallet->transaction_id = $payment_id;
					$delBoyWallet->transac_through = 'card';
					$delBoyWallet->transaction_amount = $paid_amount;
					$delBoyWallet->trans_date = now();
					$delBoyWallet->transaction_type = 'debit';
					$delBoyWallet->title  =  '# Debited the card Amount';
					$delBoyWallet->transaction_status = '1';
					$delBoyWallet->save();

				    $amount = $u_details->boy_cashIn_hand - $paid_amount;
				    $u_details->boy_cashIn_hand = $amount;
					$u_details->save();
					$response['message'] = 'Amount Send Successfully';
				}else {
					$response['message'] = 'Your Payment Faild';
					return \Response::json($response,422);
				}
			}
		} elseif ($request->pay_type == 'both'){
			$payment_id = $request->payment_id;
			$api_key	= RAZORPAY_API_KEYID;
			$api_secret	= RAZORPAY_API_KEY_SECRET;
			$api	= new Api($api_key, $api_secret);
			if($payment_id != ''){
				$razor	= $api->payment->fetch($payment_id);
				$transaction_status	= $razor->status;
				$razor_amount		= $razor->amount;
				$razor_capture = $api->payment->fetch($payment_id)->capture(array('amount'=>$razor_amount,'currency' => 'INR'));
				if($razor_capture->status == 'success' || $razor_capture->status == 'captured'){
					$razor_amount = $razor_amount/100;
					$paid_amount  = $razor_amount + $request->wallet_amount;
				    $delBoyWallet = new Deliveryboywallet();			
					$delBoyWallet->del_boy_id = $user_id;
					$delBoyWallet->transaction_id = $payment_id;
					$delBoyWallet->transac_through = 'both';
					$delBoyWallet->transaction_amount = $paid_amount;
					$delBoyWallet->trans_date = now();
					$delBoyWallet->transaction_type = 'debit';
					$delBoyWallet->title  =  '# Debited the card Amount';
					$delBoyWallet->transaction_status = '1';
					$delBoyWallet->wallet_amount = $request->wallet_amount;
					$delBoyWallet->card_amount = $razor_amount;
					$delBoyWallet->save();

				    $amount = $u_details->boy_cashIn_hand - $paid_amount;
				    $u_details->customer_wallet = $u_details->customer_wallet - $request->wallet_amount;
				    $u_details->boy_cashIn_hand = $amount;
					$u_details->save();
					$response['message'] = 'Amount Send Successfully';
				}else {
					$response['message'] = 'Your Payment Faild';
					return \Response::json($response,422);
				}
			}
		}
		$response['u_details'] = $u_details;
		return \Response::json($response,200);
	}	
}