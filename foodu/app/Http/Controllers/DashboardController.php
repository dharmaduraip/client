<?php namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Models\OrderDetail;
use Auth, DB, Crypt, DateTime, Session; 
use Validator, Input, Redirect ;
use Illuminate\Support\Facades\URL;

class DashboardController extends Controller {

	public function __construct()
	{
		parent::__construct();
		
        $this->data = array(
            'pageTitle' =>  $this->config['cnf_appname'],
            'pageNote'  =>  'Welcome to Dashboard',
            
        );			
	}

	public function index( Request $request )
	{
				// print_r(Auth::user());exit;
		$this->data = [];
		if(Auth::user()->group_id == 4 ){
			return Redirect::to('/frontend/profile');	
		}
		elseif(Auth::user()->group_id == 3)
		{
			return Redirect::to('/user/profile');
		}
		elseif(Auth::user()->group_id == 7)
		{	
			return Redirect::to('/user/profile');
		}
		elseif(Auth::user()->group_id == 1 || Auth::user()->group_id == 2)
		{

			//$this->data['online_users'] = \DB::table('tb_users')->orderBy('last_activity','desc')->limit(10)->get();
			 $result = OrderDetail::where('status','!=','4')->where('status','!=','5')->where('status','!=','pending')->whereIn('delivery', ['unpaid','paid'])->orderBy('id','DESC')->limit(20)->get();			
			$this->data['results'] = $result;
			//subscribers
			$today_subscriber = \DB::select("SELECT (`id`) from `abserve_subscription`");
			$today_subscriber_count = count($today_subscriber);
			$week_subscriber = \DB::select("SELECT id FROM `abserve_subscription` WHERE `created_at` > DATE_SUB(now(), INTERVAL 1 WEEK)");
			$week_subscriber_count = count($week_subscriber);
			$month_subscriber = \DB::select("SELECT id FROM `abserve_subscription` WHERE `created_at` > DATE_SUB(now(), INTERVAL 1 MONTH)");
			$month_subscriber_count = count($month_subscriber);

			//orders
			$today_order = \DB::select("SELECT (`id`) from `abserve_order_details` WHERE `date`= CURDATE()  and `status` = '4'");
			$today_order_count = count($today_order);
			$week_order = \DB::select("SELECT id FROM `abserve_order_details` WHERE `date` > DATE_SUB(now(), INTERVAL 1 WEEK)");
			$week_order_count = count($week_order);
			$month_order = \DB::select("SELECT id FROM `abserve_order_details` WHERE `date` > DATE_SUB(now(), INTERVAL 1 MONTH)");
			$month_order_count = count($month_order);

			//registered users
			$today_register = \DB::select("SELECT (`id`) from `tb_users` WHERE `group_id` = 4");
			$today_register_count = count($today_register);
			$week_register = \DB::select("SELECT id FROM `tb_users` WHERE `created_at` > DATE_SUB(now(), INTERVAL 1 WEEK) AND `group_id` = 4");
			$week_register_count = count($week_register);
			$month_register = \DB::select("SELECT id FROM `tb_users` WHERE `created_at` > DATE_SUB(now(), INTERVAL 1 MONTH) AND `group_id` = 4");
			$month_register_count = count($month_register);

			//registered partners
			$today_register_partner = \DB::select("SELECT (`id`) from `tb_users` WHERE `group_id` = 3");
			$today_register_count_partner = count($today_register_partner);
			$week_register_partner = \DB::select("SELECT id FROM `tb_users` WHERE `created_at` > DATE_SUB(now(), INTERVAL 1 WEEK) AND `group_id` = 3");
			$week_register_count_partner = count($week_register_partner);
			$month_register_partner = \DB::select("SELECT id FROM `tb_users` WHERE `created_at` > DATE_SUB(now(), INTERVAL 1 MONTH) AND `group_id` = 3");
			$month_register_count_partner = count($month_register_partner);

			$today_register_pending_partner = \DB::select("SELECT (`id`) from `tb_users` WHERE `group_id` = 3 AND `active` = 0");
			$today_register_count_pending_partner = count($today_register_pending_partner);
			$week_register_pending_partner = \DB::select("SELECT id FROM `tb_users` WHERE `created_at` > DATE_SUB(now(), INTERVAL 1 WEEK) AND `group_id` = 3 AND `active` = 0");
			$week_register_count_pending_partner = count($week_register_pending_partner);
			$month_register_pending_partner = \DB::select("SELECT id FROM `tb_users` WHERE `created_at` > DATE_SUB(now(), INTERVAL 1 MONTH) AND `group_id` = 3 AND `active` = 0");
			$month_register_count_pending_partner = count($month_register_pending_partner);

			$admin_today_earnings = \DB::table('abserve_order_details')->where('status', '4')->where('customer_status', 'Delivered')->whereDate('date', '=', date('Y-m-d'))->sum('fixedCommission');

			$admin_weekly_earnings = \DB::table('abserve_order_details')->where('status', '4')->where('customer_status', 'Delivered')->whereRaw('YEARWEEK(created_at, 1) = YEARWEEK(NOW(), 1)')->sum('fixedCommission');


			$admin_monthly_earnings = \DB::table('abserve_order_details')->where('status', '4')->where('customer_status', 'Delivered')->whereYear('created_at', '=', date('Y'))->whereMonth('created_at', '=', date('m'))->sum('fixedCommission');

			$this->data['today_sub'] = $today_subscriber_count;
			$this->data['today_order'] = $today_order_count;
			$this->data['today_register'] = $today_register_count;
			$this->data['today_register_partner'] = $today_register_count_partner;
			$this->data['today_register_pending_partner'] = $today_register_count_pending_partner;
			$this->data['week_sub'] = $week_subscriber_count;
			$this->data['week_order'] = $week_order_count;
			$this->data['week_register'] = $week_register_count;
			$this->data['week_register_partner'] = $week_register_count_partner;
			$this->data['week_register_pending_partner'] = $week_register_count_pending_partner;
			$this->data['month_sub'] = $month_subscriber_count;
			$this->data['month_order'] = $month_order_count;
			$this->data['month_register'] = $month_register_count;
			$this->data['month_register_partner'] = $month_register_count_partner;
			$this->data['month_register_pending_partner'] = $month_register_count_pending_partner;
			$this->data['admin_today_earnings'] = $admin_today_earnings;
			$this->data['admin_weekly_earnings'] = $admin_weekly_earnings;
			$this->data['admin_monthly_earnings'] = $admin_monthly_earnings;

		return view('dashboard.index',$this->data);
		}elseif (Auth::user()->group_id == 5) {
			// orders
				$today_order = \DB::table('abserve_order_details')
									->whereRaw("`date`= CURDATE()")
									->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_order_details.res_id')
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$today_order_count = $today_order;							

				$week_order = \DB::table('abserve_order_details')
								  ->whereRaw("`date` > DATE_SUB(now(), INTERVAL 1 WEEK)")
								  ->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_order_details.res_id')
								  ->where('abserve_restaurants.manager_id',\Auth::user()->id)
								  ->count();
				$week_order_count = $week_order;

				$month_order = \DB::table('abserve_order_details')
									->whereRaw("`date` > DATE_SUB(now(), INTERVAL 1 MONTH)")
									->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_order_details.res_id')
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$month_order_count = $month_restaurent;	

				$this->data['today_order'] = $today_order_count;
				$this->data['month_sub'] = $month_subscriber_count;
				$this->data['month_order'] = $month_order_count;

			// Restaurants
				$today_restaurant = \DB::table('abserve_restaurants')
									->whereRaw("`created_at`= CURDATE()")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$today_restaurant_count = $today_restaurant;							

				$week_restaurant = \DB::table('abserve_restaurants')
								  ->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 WEEK)")
								  ->where('abserve_restaurants.manager_id',\Auth::user()->id)
								  ->count();
				$week_restaurant_count = $week_restaurant;

				$month_restaurant = \DB::table('abserve_restaurants')
									->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 MONTH)")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$month_restaurant_count = $month_restaurant;
				
				$this->data['today_restaurant'] = $today_restaurant_count;
				$this->data['week_restaurant'] = $week_restaurant_count;
				$this->data['month_restaurant'] = $month_restaurant_count;
				
			// Commision
				$today_commision = \DB::table('abserve_restaurants')
									->whereRaw("`created_at`= CURDATE()")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$today_commision_count = $today_commision;							

				$week_commision = \DB::table('abserve_restaurants')
								  ->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 WEEK)")
								  ->where('abserve_restaurants.manager_id',\Auth::user()->id)
								  ->count();
				$week_commision_count = $week_commision;

				$month_commision = \DB::table('abserve_restaurants')
									->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 MONTH)")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$month_commision_count = $month_commision;

				$this->data['today_commision'] = $today_commision_count;
				$this->data['week_commision'] = $week_commision_count;
				$this->data['month_commision'] = $month_commision_count;

			// Partners
				$today_partner = \DB::table('abserve_restaurants')
									->whereRaw("`created_at`= CURDATE()")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$today_partner_count = $today_partner;							

				$week_partner = \DB::table('abserve_restaurants')
								  ->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 WEEK)")
								  ->where('abserve_restaurants.manager_id',\Auth::user()->id)
								  ->count();
				$week_partner_count = $week_partner;

				$month_partner = \DB::table('abserve_restaurants')
									->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 MONTH)")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$month_partner_count = $month_partner;
				
				$this->data['today_partner'] = $today_partner_count;
				$this->data['week_partner'] = $week_partner_count;
				$this->data['month_partner'] = $month_partner_count;

			return view('dashboard.manager',$this->data);
		}elseif (Auth::user()->group_id == 6) {
			// orders
				$today_order = \DB::table('abserve_order_details')
									->whereRaw("`date`= CURDATE()")
									->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_order_details.res_id')
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$today_order_count = $today_order;							

				$week_order = \DB::table('abserve_order_details')
								  ->whereRaw("`date` > DATE_SUB(now(), INTERVAL 1 WEEK)")
								  ->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_order_details.res_id')
								  ->where('abserve_restaurants.manager_id',\Auth::user()->id)
								  ->count();
				$week_order_count = $week_order;

				$month_order = \DB::table('abserve_order_details')
									->whereRaw("`date` > DATE_SUB(now(), INTERVAL 1 MONTH)")
									->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_order_details.res_id')
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$month_order_count = $month_restaurent;	

				$this->data['today_order'] = $today_order_count;
				$this->data['month_sub'] = $month_subscriber_count;
				$this->data['month_order'] = $month_order_count;

			// Restaurants
				$today_restaurant = \DB::table('abserve_restaurants')
									->whereRaw("`created_at`= CURDATE()")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$today_restaurant_count = $today_restaurant;							

				$week_restaurant = \DB::table('abserve_restaurants')
								  ->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 WEEK)")
								  ->where('abserve_restaurants.manager_id',\Auth::user()->id)
								  ->count();
				$week_restaurant_count = $week_restaurant;

				$month_restaurant = \DB::table('abserve_restaurants')
									->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 MONTH)")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$month_restaurant_count = $month_restaurant;
				
				$this->data['today_restaurant'] = $today_restaurant_count;
				$this->data['week_restaurant'] = $week_restaurant_count;
				$this->data['month_restaurant'] = $month_restaurant_count;
				
			// Commision
				$today_commision = \DB::table('abserve_restaurants')
									->whereRaw("`created_at`= CURDATE()")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$today_commision_count = $today_commision;							

				$week_commision = \DB::table('abserve_restaurants')
								  ->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 WEEK)")
								  ->where('abserve_restaurants.manager_id',\Auth::user()->id)
								  ->count();
				$week_commision_count = $week_commision;

				$month_commision = \DB::table('abserve_restaurants')
									->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 MONTH)")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$month_commision_count = $month_commision;

				$this->data['today_commision'] = $today_commision_count;
				$this->data['week_commision'] = $week_commision_count;
				$this->data['month_commision'] = $month_commision_count;

			// Partners
				$today_partner = \DB::table('abserve_restaurants')
									->whereRaw("`created_at`= CURDATE()")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$today_partner_count = $today_partner;							

				$week_partner = \DB::table('abserve_restaurants')
								  ->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 WEEK)")
								  ->where('abserve_restaurants.manager_id',\Auth::user()->id)
								  ->count();
				$week_partner_count = $week_partner;

				$month_partner = \DB::table('abserve_restaurants')
									->whereRaw("`created_at` > DATE_SUB(now(), INTERVAL 1 MONTH)")
									->where('abserve_restaurants.manager_id',\Auth::user()->id)
									->count();
				$month_partner_count = $month_partner;
				
				$this->data['today_partner'] = $today_partner_count;
				$this->data['week_partner'] = $week_partner_count;
				$this->data['month_partner'] = $month_partner_count;

			return view('dashboard.supportmanager',$this->data);
		}
		//return Redirect::to('/frontend/profile');
		/*$this->data['online_users'] = \DB::table('tb_users')->orderBy('last_activity','desc')->limit(10)->get(); 
		return view('dashboard.index',$this->data);
		SELECT (`id`) from `tb_users` WHERE DATE(`created_at`) BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
		*/
	}	


	


}