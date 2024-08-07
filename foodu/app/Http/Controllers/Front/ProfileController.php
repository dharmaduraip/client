<?php 
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\Front\Restaurant;
use App\User;
use App\Models\Orders;
use App\Models\Fooditems;
use App\Models\Customerorder;
use App\Models\OrderDetail;
use App\Models\Dishes;
use App\Models\Wallet;
use App\Models\Promocode;
use App\Models\Urlsettings;
use App\Models\OfferUsers;
use App\Models\Usercart;
use App\Models\Useraddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ,DB, DateTime, Session , Response; 
use Auth,paginate;

class ProfileController extends Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public  function getProfile(Request $request)
	{
		if(\Auth::check()){
			$segment = $request->segment(1);
			$user_id		= Auth::user()->id;
			$userData 		= \DB::table('tb_users')->select('*')->where('id',$user_id)->first();
	        $this->data['userImg'] = $userData->avatar;
			$this->data['segment']	= $segment;
			if($segment == 'orders') {
				$explore_url	= \URL::to('/');
				$search_exist	= Urlsettings::where('user_id',$user_id)->exists();
				if($search_exist){
					$old_search	= Urlsettings::where('user_id',$user_id)->first();
					if($old_search->lat != '' && $old_search->lang != ''){
						$explore_url = \URL::to('search?lat='.$old_search->lat.'&lang='.$old_search->lang.'&keyword='.$old_search->keyword.'&city='.$old_search->city);
					}
				}
				$order_details = OrderDetail::
				where('abserve_order_details.cust_id',$user_id)
				->where('order_type','Initial')
				->orderBy('abserve_order_details.id','DESC')
				->paginate('10');
				$this->data['orders']	   = $order_details;
				$this->data['explore_url'] = $explore_url;
				$this->data['allowed_status']	= $this->allowed_status();
			}
			if($segment == 'offers'){
				$current_date = date('Y-m-d');
				$allcoupons = Promocode::where('start_date','<=', $current_date)->where('end_date','>=',$current_date)->where('user_id',0)->where('limit_count','!=',0)->get();
				$userCoupon = Promocode::where('start_date','<=', $current_date)->where('end_date','>=',$current_date)->where('user_id',$user_id)->where('limit_count','!=',0)->get();
				$availCouplons = $userAvailCouplons = array();
				if(!empty($allcoupons)){
					foreach ($allcoupons as $key => $value) {
						$exist = \DB::table('abserve_promo_user_status')->select('id')->where('coupon_id',$value->id)->where('user_id',$user_id)->get();
						if(!empty($exist)){
							$availCouplons[] = $value;
						}
					}
				}
				if(!empty($userCoupon)){
					foreach ($userCoupon as $key => $value) {
						$exist = \DB::table('abserve_promo_user_status')->select('id')->where('coupon_id',$value->id)->where('user_id',$user_id)->get();
						if(!empty($exist)){
							$userAvailCouplons[] = $value;
						}
					}
				}
				$this->data['allcoupons'] = $availCouplons;
				$this->data['userCoupon'] = $userAvailCouplons;
			}
			if($segment == 'favourites'){
				$favouriteshotesls = \DB::select("SELECT GROUP_CONCAT(Distinct(resid)) as res_id FROM abserve_favourites Where `user_id`=".$user_id." ORDER BY  id desc");
				if($favouriteshotesls != '') {
					$Favorites = array_unique(explode(',',$favouriteshotesls[0]->res_id));
					$restaurants= Restaurant::with(['getRestuarantItems' => function ($query) {
						$query->where('approveStatus','Approved')->where('del_status','0')->groupBy('restaurant_id');
					}])->where('status','1')->where('admin_status','approved')->whereIn('id',$Favorites)->has('getRestuarantItems')->paginate(5);
				} else {
					$restaurants = array();
				}
				$this->data['res_restaurnts'] = $restaurants;
			}
			if($segment == 'payments') {
				$this->data['wallet'] =  Wallet::select('order_id','type','title','reason','date','amount')->where('user_id',\Auth::user()->id)->orderBy('id','DESC')->paginate('10');	
			}
			if($segment == 'offer-wallet') {
				$this->data['offerwallet'] = OfferUsers::select('order_id','offer_name','offer_price','type','grand_total','created_at')->where('cust_id',\Auth::user()->id)->paginate('10');	
			}
			if($segment == 'manage_addresses') {
				$user_address	= Useraddress::where("user_id",'=',$user_id)->get();
				$this->data['address'] = $user_address;
			}
			$access_token = \Session::get('access_token');
			$this->data['access_token']= $access_token;
			return view('front.profile.myaccount',$this->data); 
		} else {
			return Redirect::to('user/login');
		}
	}

	public function Imageupload( Request $request) 
	{
		$user_id = \Auth::id();
		if(!is_null($request->file('userImg'))) {
			$file = $request->file('userImg'); 
			$types = array('image/jpeg', 'image/jpg', 'image/png');
			if (!in_array($_FILES['userImg']['type'], $types)) {
				$response['message'] = 'failure';
				$response['imgType'] = 'notValid';
			} else {
				$response['imgType'] 	= 'Valid';
				$destinationPath 	= './uploads/users/';
				$extension 			= $file->getClientOriginalExtension();
				$newfilename 		= $user_id.time().'.'.$extension;
				$uploadSuccess 		= $request->file('userImg')->move($destinationPath, $newfilename); 
				if( $uploadSuccess ) {
					$response['message']	= "success";
					$response['file_name']	= $newfilename;
					$data['avatar']			= $newfilename;

					$userOldImage = \Auth::user()->avatar;
					$imgPath = '/uploads/users/'.$userOldImage;
					if(\File::exists(public_path($imgPath))){
						\File::delete(public_path($imgPath));
					}
					$user	= User::find($user_id);
					$user->avatar  = $newfilename;
					$user->save();

				} else {
					$response['message']	= "failure";
					$response['file_name']	= '';
				}
			}
		}
		echo json_encode($response);exit();
	}

	public  function postEmail(Request $request)
	{
		$rules=[];
		$user = User::find(Auth::user()->id);
		if (!empty($user)) {
			$rules['mobile']    = 'required|numeric|unique:tb_users,phone_number,'.$user->id;
			$rules['email']     = 'required|unique:tb_users,email,'.$user->id;
			$validator	= Validator::make($request->all(), $rules);
			if ($validator->passes()) {
				$user->username = $request->username;
				$user->phone_number = $request->mobile;
				$user->email = $request->email;
				$user->address = $request->address;
				$user->save();
				echo "2";
			
			} else {
				echo "6";
			}
		} else {
			echo "4";
		}

	}

	public function allowed_status()
	{
		return array('pending','0','1','2','3','6');
	}

	public function postUpdateaddress(Request $request)
	{
		$user_id = Auth::user()->id;
		$array = array("user_id"=>$user_id,
			"address_type"=>$request->address_type,
			"landmark"=>$request->landmark,
			"building"=>$request->building,
			"address"=>$request->a_addr,
			"lat"=>$request->a_lat,
			"lang"=>$request->a_lang);
		$id =  $request->id;
		$addr_exists = \DB::table('abserve_user_address')
		->where("user_id",'=',$user_id)
		->whereNotIn("id",array($id))
		->where("address_type",'=',$request->address_type)
		->exists();
		if($addr_exists){
			$array['address_type'] = 3;
		}
		if(!empty($id))
		{
			\DB::table('abserve_user_address')
			->where("id",'=',$id)
			->update($array);
		}else
		{
			\DB::table('abserve_user_address')
			->insert($array);
			$id = \DB::getPdo()->lastInsertId();
		}

		$user_address = \DB::table('abserve_user_address')
		->where("id",'=',$id)->first();
		$html = '';
		if($user_address->address_type == '1'){
			$add_type= "Home";$icon = '<i class="fa fa-home"></i>';
		}else if($user_address->address_type == '2'){
			$add_type= "Work";$icon = '<i class="fa fa-briefcase"></i>';
		}
		else{
			$add_type= "Others";$icon = '<i class="fa fa-map-pin"></i>';
		} 

		$html.='
	  <div class="col-md-6 col-sm-6 col-xs-12 fn_'.$id.'">
		<div class="desktop">
			<div class="left">
				<span class="annotation">'.$icon.'</span>
			</div>
			<div>
				<h6 class="text-ellipsis">'.$add_type.'</h6>
				<div class="addr-line addressBlock">'.$user_address->building.', '.$user_address->landmark.', '.$user_address->address.'</div>
				<div class="actions">
					<a href="javascript:edit('.$id.');" class="bootstrap-link edit_address">Edit</a>
					<a  class="bootstrap-link del_address " href="javascript:remove('.$id.');">Delete</a>
				</div>
			</div>
		</div>
		</div>
		';
		return $html;
	}

	public  function getAddress(Request $request)
	{
		$id = $request->id;
		if($request->key == 'delete')	{
			\DB::table('abserve_user_address')
						->where("id",'=',$id)
						->delete();
		}else{
			$details = array();
			$query = \DB::table('abserve_user_address')
						->where("id",'=',$id)
						->first();
			if(!empty($query)){
				$details['id'] = $query->id;
				$details['address'] = $query->address;
				$details['lat'] = $query->lat;
				$details['lang'] = $query->lang;
				$details['address_type'] = $query->address_type;
				$details['landmark'] = $query->landmark;
				$details['building'] = $query->building;
			}
			return json_encode($query);
		}
	}
}