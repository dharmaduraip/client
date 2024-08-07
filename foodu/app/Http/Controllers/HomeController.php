<?php  namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Urlsettings;
use App\Models\Front\Usercart;
use App\Models\Front\Restaurant;
use App\Models\Front\Fooditems;
use App\Models\Front\Banner;
use App\Models\Front\Cuisines;
use App\Models\Core\Pages;
use App\Models\OrderDetail;
use App\Library\Markdown;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Front\FrontEndController;
use App\Http\Controllers\Api\RestaurantController as resaurant;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Anam\PhantomMagick\Converter;

class HomeController extends Controller {

	public function __construct()
	{
		parent::__construct();

		$this->data['pageLang'] = 'en';
		if(\Session::get('lang') != '')
		{
			$this->data['pageLang'] = \Session::get('lang');
		}
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index( Request $request) 
	{
		if(\Auth::check() && \Auth::user()->active != '1' && \Auth::user()->p_active == '1'){
			return Redirect::to('/dashboard');
		}
		\App::setLocale(\Session::get('lang'));
		if(config('sximo.cnf_front') =='false' && $request->segment(1) =='' ) :
			return redirect('dashboard');
		endif; 	
		$food_categories = \DB::select("SELECT id, name FROM `abserve_food_cuisines` ");
		$this->data['food_categories'] = $food_categories;
		$page = $request->segment(1);
		//\DB::table('tb_pages')->where('alias',$page)->update(array('views'=> \DB::raw('views+1')));

		if($page !='') {
			$sql = \DB::table('tb_pages')->where('alias','=',$page)->where('status','=','enable')->get();
			$row = $sql[0];
			if(file_exists(base_path().'/resources/views/layouts/'.config('sximo.cnf_theme').'/template/'.$row->filename.'.blade.php') && $row->filename !='') {
				$page_template = 'layouts.'.config('sximo.cnf_theme').'.template.'.$row->filename;
			} else {
				$page_template = 'layouts.'.config('sximo.cnf_theme').'.template.page';
			}

			if($row->access !='') {
				$access = json_decode($row->access,true);
			} else {
				$access = array();
			}

			// If guest not allowed 
			if($row->allow_guest !=1) {	
				$group_id = \Session::get('gid');
				$isValid =  (isset($access[$group_id]) && $access[$group_id] == 1 ? 1 : 0 );
				if($isValid ==0) {
					return redirect('')
						->with(['message' => __('core.note_restric') ,'status'=>'error']);
				}
			}

			$this->data['pages']	= $page_template;
			$this->data['title']	= $row->title ;
			$this->data['subtitle'] = $row->sinopsis ;
			$this->data['pageID']	= $row->pageID ;
			$this->data['content']	= \PostHelpers::formatContent($row->note);
			//$this->data['note']		= $row->note;
			$filename = base_path() .'/resources/views/layouts/'.config('sximo.cnf_theme').'/template/'.$row->filename.".blade.php";
			if($row->filename=='faq') {
				$this->data['faq_categories'] = \DB::table('abserve_faq_categories')->select('*')->get();

				$this->data['faq_contents'] = \DB::table('abserve_faq_contents')->select('*')->get();
			}
			if ($row->template =='backend') {
           		$page ='layouts/'.config('sximo.cnf_theme').'/template/'.$row->filename;
				return view($page, $this->data);
			} else {
				 $page = 'layouts.'.config('sximo.cnf_theme').'.index';
				 if(file_exists($filename)) {
				 $this->data['pages'] ='layouts.'.config('sximo.cnf_theme').'.template.'.$row->filename;
				 return view($page,$this->data);
				}
				
			}
		} else {
			$cookie_id	= (\AbserveHelpers::getCartCookie() != '') ? \AbserveHelpers::getCartCookie() : \AbserveHelpers::setCartCookie();
			$user_id	= (\Auth::check()) ? \Auth::user()->id : 0;
			$authid		= (\Auth::check()) ? \Auth::user()->id : $cookie_id;
			$cond		= (\Auth::check()) ? 'user_id' : 'cookie_id';
			$baseurl	= Urlsettings::where($cond,$authid)->first();

			/*if(!empty($baseurl) && $baseurl->lat != 0) {
				return \Redirect::to('search?keyword='.$baseurl->keyword.'city='.$baseurl->city.'&lat='.$baseurl->lat.'&lang='.$baseurl->lang);
			} else {*/
				$frontCon		= new FrontEndController;
				$usercart		= Usercart::where($cond,$authid)->first();
				$restaurant_id	= !empty($usercart) ? $usercart->res_id : 0;
				$restwithhotels = Fooditems::select(\DB::raw('GROUP_CONCAT(DISTINCT restaurant_id) as resids'))->where('del_status','!=',1)->groupBy('restaurant_id')->first();
				$resid_array = $maxrest_city = $rest_city = array();
				$maxrest_city_url = \URL::to('search');
				if(!empty($restwithhotels)) {
					$resids = explode(',', $restwithhotels->resids);
					$maxrest_city = Restaurant::select('*',\DB::raw('COUNT(id) as count'))->whereIN('id',$resids)->where('status',1)->groupBy('city')->orderBy('count','DESC')->first();
					$rest_city = Restaurant::whereIN('id',$resids)->where('latitude','!=',0)->where('longitude','!=',0)->where('city','!=','')->where('status',1)->where('show',1)->groupBy('city')->get();
					if(!empty($maxrest_city)){
						$maxrest_city_url = \URL::to('search?city='.$maxrest_city->city.'&lat='.$maxrest_city->latitude.'&lang='.$maxrest_city->longitude);
					}
				}

				$this->data['previous_order'] = [];
				\DB::enableQueryLog();
				$this->data['recent_search'] = [];
				if (\Auth::check()) { 

					$this->data['previous_order'] = \DB::table('abserve_order_details')
					->select('abserve_order_details.res_id','abserve_restaurants.logo','abserve_restaurants.rating','abserve_restaurants.name as shop_name')
					->join('abserve_restaurants','abserve_restaurants.id','=','abserve_order_details.res_id')
					->where('abserve_order_details.cust_id','=',\Auth::id())
					->where('abserve_order_details.status','=','4')
					->where('abserve_restaurants.status','!=','3')
					->distinct()->limit(10)->get();

					$this->data['recent_search'] = \DB::table('abserve_recent_search')
					->select('abserve_recent_search.res_id','abserve_restaurants.logo','abserve_restaurants.rating','abserve_restaurants.name as shop_name')
					->join('abserve_restaurants','abserve_restaurants.id','=','abserve_recent_search.res_id')
					->where('abserve_recent_search.user_id','=',\Auth::id())
					->where('abserve_restaurants.status','!=','3')
					->distinct()->get();	
				}
				// print_r($this->data['previous_order']);exit;
				// print_r(\DB::getQueryLog($this->data['previous_order']));exit();
				$this->data['nearby_restaurants']	= [];
				$this->data['feature_restaurants']	= [];
				if (\Session::has('latitude')) {
					$resaurant			= new resaurant;
					$request_response	= new request;
					$request_response['latitude']	= \Session::get('latitude');
					$request_response['longitude']	= \Session::get('longitude');
					$request_response['show']		= 1;
					$request_response['distance']	= CNF_NEARBY_RADIUS;
					$nearby		= $resaurant->restaurantlist($request_response);
					$nearby		= $nearby->getData();
					$request_response['ordering']	= 1;
					$feature	= $resaurant->restaurantlist($request_response);
					$feature	= $feature->getData();
					$this->data['nearby_restaurants']	= $nearby->restaurant;
					$this->data['feature_restaurants']	= $feature->restaurant;
				}
				$this->data['abserve_food_cuisines']	= Cuisines::get();
				$this->data['banner']			= Banner::get();
				$this->data['rest_cities']		= $rest_city;
				$this->data['maxrest_city']		= $maxrest_city;
				$this->data['maxrest_city_url']	= $maxrest_city_url;
				$this->data['cart_items_html']	= $frontCon->ShowSearchcCart($restaurant_id,$user_id,$cookie_id);
				$this->data['search_cart_res_id']	= $restaurant_id;

				$this->data['pageID']	= 1 ;
				$this->data['content']	= \PostHelpers::formatContent('fdsg');
				$this->data['note']		= 'sfsdf';
				return view('front.home', $this->data);
			// }
			/*$sql	= Pages::where('default','1')->get();
			if (count($sql) >= 1) {
				$row	= $sql[0];
				$this->data['title'] = $row->title ;
				$this->data['subtitle'] = $row->sinopsis ;
				if(file_exists(base_path().'/resources/views/layouts/'.config('sximo.cnf_theme').'/template/'.$row->filename.'.blade.php') && $row->filename !='') {
					$page_template = 'layouts.'.config('sximo.cnf_theme').'.template.'.$row->filename;
				} else {
					$page_template = 'layouts.'.config('sximo.cnf_theme').'.template.page';
				}
				$this->data['pages']	= $page_template;
				$this->data['pageID']	= $row->pageID ;
				$this->data['content']	= \PostHelpers::formatContent($row->note);
				$this->data['note']		= $row->note;
				$page	= 'layouts.'.config('sximo.cnf_theme').'.index';
				return view( $page, $this->data);
			} else {
				return 'Please Set Default Page';
			}*/
		}
	}

	public function Nearrestplace( Request $request)
	{
		if(isset($request->lat) && isset($request->lng) && $request->lng != '' && $request->lat != '') {
			$radius     = \AbserveHelpers::getkm()* 1.60934;
			$whr		= "WHERE 1 ";
			$lat_lng	= ", ( 6371 * acos( cos( radians(".$request->lat.") ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians(".$request->lng.") ) + sin( radians(".$request->lat.") ) * sin( radians( latitude ) ) ) ) AS distance";
			$hav	= "HAVING distance <= ".$radius." ";
			$select = '*'.$lat_lng;
			$offer = \DB::select("SELECT `abserve_restaurants`.`id` as restId ".$lat_lng." FROM `abserve_restaurants` JOIN `abserve_hotel_items` ON `abserve_hotel_items`.`restaurant_id` = `abserve_restaurants`.`id` ".$whr." AND `abserve_hotel_items`.`del_status` = 0  GROUP BY `abserve_restaurants`.`id` ".$hav);
			if(count($offer)>0){
				$resaurant = new resaurant;
				$request_response = new request;
				$request_response['latitude'] = $request->lat;
				$request_response['longitude'] = $request->lng;
				$request_response['show'] 		= 1;
				$request_response['distance'] = CNF_NEARBY_RADIUS;
				$nearby = $resaurant->restaurantlist($request_response);
				$nearby = $nearby->getData();
				$nearby_restaurants = $nearby->restaurant;
				$request_response['ordering'] = 1;
				$feature = $resaurant->restaurantlist($request_response);
				$feature = $feature->getData();
				$feature_restaurants = $feature->restaurant;
				$html = (string) view('restaurant.nearby',compact('nearby_restaurants','feature_restaurants'));
				\Session::put('latitude', $request->lat);
				\Session::put('longitude', $request->lng);
				return json_encode(array('html'=>$html, 'result'=>1));
			} else {
				echo json_encode(array('result'=>0));
				exit;
			}
			exit;
		} else {
			exit;
		}
	}

	public function  getLang( Request $request , $lang='en')
	{
		$request->session()->put('lang', $lang);
		return  Redirect::back();
	}

	public function  getSkin($skin='sximo')
	{
		\Session::put('themes', $skin);
		return  Redirect::back();
	}

	public function submit( Request $request )
	{
		$formID = $request->input('form_builder_id');

		$rows = \DB::table('tb_forms')->where('formID',$formID)->get();
		if(count($rows))
		{
			$row = $rows[0];
			$forms = json_decode($row->configuration,true);
			$content = array();
			$validation = array();
			foreach($forms as $key=>$val)
			{
				$content[$key] = (isset($_POST[$key]) ? $_POST[$key] : ''); 
				if($val['validation'] !='')
				{
					$validation[$key] = $val['validation'];
				}
			}
			
			$validator = Validator::make($request->all(), $validation);	
			if (!$validator->passes()) 
					return redirect()->back()->with(['status'=>'error','message'=>'Please fill required input !'])
							->withErrors($validator)->withInput();

			
			if($row->method =='email')
			{
				// Send To Email
				$data = array(
					'email'		=> $row->email ,
					'content'	=> $content ,
					'subject'	=> "[ " .config('sximo.cnf_appname')." ] New Submited Form ",
					'title'		=> $row->name 			
				);
			
				if( config('sximo.cnf_mail') =='swift' )
				{ 				
					\Mail::send('sximo.form.email', $data, function ( $message ) use ( $data ) {
			    		$message->to($data['email'])->subject($data['subject']);
			    	});		

				}  else {

					$message 	 = view('sximo.form.email', $data);
					$headers  	 = 'MIME-Version: 1.0' . "\r\n";
					$headers 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$headers 	.= 'From: '. config('sximo.cnf_appname'). ' <'.config('sximo.cnf_email').'>' . "\r\n";
						mail($data['email'], $data['subject'], $message, $headers);	
				}
				
				return redirect()->back()->with(['status'=>'success','message'=> $row->success ]);

			} else {
				// Insert into database 
				\DB::table($row->tablename)->insert($content);
				return redirect()->back()->with(['status'=>'success','message'=>  $row->success  ]);
			
			}
		} else {

			return redirect()->back()->with(['status'=>'error','message'=>'Cant process the form !']);
		}
	}

	public function getLoad()
	{
		$result = \DB::table('tb_notification')->where('userid',\Session::get('uid'))->where('is_read','0')->orderBy('created','desc')->limit(5)->get();

		$data = array();
		$i = 0;
		foreach($result as $row)
		{
			if(++$i <=10 )
			{
				if($row->postedBy =='' or $row->postedBy == 0)
				{
					$image = '<img src="'.asset('uploads/images/system.png').'" border="0" width="30" class="img-circle" />';
				} 
				else {
					$image = \SiteHelpers::avatar('30', $row->postedBy);
				}
				$data[] = array(
						'url'	=> $row->url,
						'title'	=> $row->title ,
						'icon'	=> $row->icon,
						'image'	=> $image,
						'text'	=> substr($row->note,0,100),
						'date'	=> date("d/m/y",strtotime($row->created))
					);
			}	
		}
	
		$data = array(
			'total'	=> count($result) ,
			'note'	=> $data
			);	
		 return response()->json($data);	
	}

	public function posts( Request $request ,  $category = '')
	{

		$posts = \DB::table('tb_pages')
				->select('tb_pages.*','tb_users.username',\DB::raw('COUNT(commentID) AS comments'))
				->leftJoin('tb_users','tb_users.id','tb_pages.userid')
				->leftJoin('tb_comments','tb_comments.pageID','tb_pages.pageID')		
				->leftJoin('tb_categories','tb_categories.cid','tb_pages.cid')					
				->where('pagetype','post');
					/*
					if(!is_null($request->input('label'))){
						$keyword = trim($request->input('label'));
						$posts = $posts->where('labels', 'LIKE' , "%{$keyword}%%" ); 	
					}
					*/
	
				if( $category !=''  ) {
					$mode = 'category';
					$this->data['categoryDetail'] = Post::categoryDetail( $category );
					$posts = $posts->where('tb_categories.alias',$category )->paginate(10);					
				}
				else {
					$mode = 'all';

					$posts = $posts->groupBy('tb_pages.pageID')->paginate(10);
				}					

		$this->data['title']		= 'Post Articles';
		$this->data['posts']		= $posts;
		$this->data['pages']		= 'secure.posts.posts';
		$this->data['popular']		= Post::lists('popular');
		$this->data['headline']		= Post::lists('headline');
		$this->data['categories']		= Post::categories();
		$this->data['mode']			= $mode;


		$this->data['pages'] = 'layouts.'.config('sximo.cnf_theme').'.blog.index';	
		$page = 'layouts.'.config('sximo.cnf_theme').'.index';
		return view( $page , $this->data);	
	}

	public function read( Request $request , $read = '')
	{

		$row = Post::read( $read );
	
		$comments = Post::comments( $row->pageID );
		$data = [
			'title'	=> $row->title ,
			'posts'	=> $row ,
			'comments'	=>  $comments ,
			'pages' => 'layouts.'.config('sximo.cnf_theme').'.blog.view',
			'popular'	=> Post::lists('popular') , 
			'categories'	=> Post::categories()
		];
		$page = 'layouts.'.config('sximo.cnf_theme').'.index';
		return view( $page , $data);	
	}

	public function comment( Request $request)
	{
		$rules = array(
			'comments'	=> 'required'
		);
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {

			$data = array(
					'userID'		=> \Session::get('uid'),
					'posted'		=> date('Y-m-d H:i:s') ,
					'comments'		=> $request->input('comments'),
					'pageID'		=> $request->input('pageID')
				);

			\DB::table('tb_comments')->insert($data);
			return redirect('posts/read/'.$request->input('alias'))
        		->with(['message'=>'Thank You , Your comment has been sent !','status'=>'success']);
		} else {
			return redirect('posts/'.$request->input('alias'))
				->with(['message'=>'The following errors occurred','status'=>'error']);	
		}
	}

	public function remove( Request $request, $pageID , $alias , $commentID )
	{
		if($commentID !='')
		{
			\DB::table('tb_comments')->where('commentID',$commentID)->delete();
			return redirect('posts/read/'.$alias)
				->with(['message'=>'Comment has been deleted !','status'=>'success']);
       
		} else {
			return redirect('posts/post/'.$alias)
				->with(['message'=>'Failed to remove comment !','status'=>'error']);
		}
	}

	public function set_theme( $id )
	{
		session(['set_theme'=> $id ]);
		return response()->json(['status'=>'success']);
	}

	public function invoiceimage($id)
	{
		$orderDetail = OrderDetail::with('user_info','accepted_order_items')->find($id);
		return view('front.invoiceimage',['orderDetail' => $orderDetail]);
	}

	public function imageconvert($id)
	{
		$conv = new Converter();
		$name = 'bill'.$id.'.jpg';
		$conv->make(\URL::to('invoiceimage').'/'.$id)->toJpg()->portrait()->width('440')->quality(100)->save(base_path().'/uploads/bills/'.$name);
		return true;
	}

	public function getClearlog()
	{
		\DB::table('tbl_http_logger')->truncate();
	}
}
