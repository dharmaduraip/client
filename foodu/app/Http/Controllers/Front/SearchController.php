<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Front\Restaurant;
use App\Models\Front\Cuisines;
use App\Models\Foodcategories;
use App\Models\Urlsettings;
use App\User;
use App\Models\Front\Fooditems;

/**
 * @version 1.0
 * @author Suganya <suganya.r@abserve.tech>
 * @return view blade
 */
class SearchController extends Controller
{

	public function Search( Request $request)
	{
		if($request->device != 'android'){
		if (!isset($request->from)) {
			$request->latitude	= $request->lat;
			$request->longitude	= $request->lang;
			$request->merge(['latitude'=>$request->lat,'longitude'=>$request->lang]);
		}
		$perpage= 5; $pNum	= $fNum = 1; $filter = '';
		$locRes = Location::where('name','like','%'.$request->city.'%')->first();
		$c_id	= (!empty($locRes) && $locRes->id != '') ? $locRes->id : '';
		if (isset($request->page) && $request->page != '' && is_numeric($request->page))
			$pNum	= $request->page;
		if (isset($request->fpage) && $request->fpage != '' && is_numeric($request->fpage))
			$fNum	= $request->fpage;
		$list	= Restaurant::where('status','1')->where('admin_status','approved');
		if(\Auth::check() && \Auth::user()->p_active == '1') 
		{
			$restrict = \Auth::user()->id;
			$list	= Restaurant::where('status','1')->where('admin_status','approved')->where('partner_id','!=',$restrict);
		}
		$list	= $list->with(['categories' => function ($qry) use($request) {
			if (isset($request->categories) && $request->categories != '' )
				$qry	= $qry->whereIn('abserve_food_categories.id', explode(',',$request->categories));
		}]);
		$cookie_id	= (\AbserveHelpers::getCartCookie() != '') ? \AbserveHelpers::getCartCookie() : \AbserveHelpers::setCartCookie();
		$user_id	= (\Auth::check()) ? \Auth::user()->id : 0;
		$authid		= (\Auth::check()) ? \Auth::user()->id : $cookie_id;
		$cond		= (\Auth::check()) ? 'user_id' : 'cookie_id';
		$baseurlexi	= Urlsettings::where($cond,$authid)->first();

		if (isset($request->city) && $request->city != '')
			\Session::put('city',$request->city);
		if (isset($request->latitude) && $request->latitude != 0 && isset($request->longitude) && $request->longitude != 0) {
			$distKm	= (isset($request->distance) && $request->distance > 0) ? $request->distance : 0;
			$list	= $list->nearby($request->latitude, $request->longitude, $distKm);
			\Session::put('latitude',$request->latitude);
			\Session::put('longitude',$request->longitude);
			/* Set users search location Begin */
			$lat	= (isset($request->latitude) && $request->latitude != '') ? $request->latitude : 0.00;
			$lang	= (isset($request->longitude) && $request->longitude != '') ? $request->longitude : 0.00;
			$city	= (isset($request->city)) ? $request->city : '';
			$keyword= (isset($request->keyword)) ? $request->keyword : '';
			if(empty($baseurlexi)){
				$urlsettings = new Urlsettings();
				$urlsettings->user_id	= ($user_id > 0) ? $user_id : 0; 
				$urlsettings->cookie_id	= ($user_id == 0) ? $authid : 0;
				$urlsettings->url		= 'search?lat='.$lat.'&lang='.$lang.'&keyword='.$keyword.'&city='.$city;
				$urlsettings->lat		= $lat;
				$urlsettings->lang		= $lang;
				$urlsettings->city		= $city;
				$urlsettings->keyword	= $keyword;
				$urlsettings->save();
			}
			/* Set users search location End */
		} else {
			Urlsettings::where($cond,$authid)->delete();
		}
		$all	= clone ($list); $fcount = clone ($list); $feature = clone ($list); $resCusn = clone ($list);
		if (isset($request->cuisines) && $request->cuisines != '' )
			$all	= $all->whereRaw('cuisine IN ('.$request->cuisines.')');
		if(isset($request->preorder) && $request->preorder != '')
			$all	= $all->where('preoder',$request->preorder);
		$all = $all->WhereHas('categories',function ($qry) use($request) {
		if (isset($request->categories) && $request->categories != '' )
				$qry	= $qry->whereRaw('abserve_food_categories.id IN ('.$request->categories.')');
		});
		if(isset($request->sort_by) && $request->sort_by == 'rating') {
			$all	= $all->WhereHas('ratings',function ($qy) {
				$qy->addSelect(\DB::raw('COUNT(id) as rating_count , sum(rating) as rating_total'))->groupBy('res_id');
			});
		}
		$count		= clone ($all);
		$all		= self::paginateMap($all->orderBy('id','DESC')->paginate($perpage, ['*'], 'page', $pNum));
		$feature	= self::paginateMap($feature->where('ordering','1')->orderBy('id','DESC')->paginate($perpage, ['*'], 'fpage', $fNum));
		$resCusn	= $resCusn->addSelect(\DB::raw('GROUP_CONCAT(DISTINCT(`cuisine`)) as Cats'))->first();
			$cuisines	= Cuisines::select('id','name','image');
			if (!empty($resCusn)) {
				$cuisine	= array_unique(explode(',', $resCusn->Cats));
				$cuisines	= $cuisines->whereIn('id',$cuisine);
			}
			$cuisines	= $cuisines->get()->makeHidden('image');
			if(isset($request->cuisines) && $request->cuisines != '') {
				$filter          = 'yes';
				$filter_cuisine	 = array_unique(explode(',', $request->cuisines));
				$filter_cuisines = Cuisines::select('id','name','image')->whereIn('id',$filter_cuisine)->get();
			}
			$categories	= Foodcategories::where('root_id',0)->where('type','category')->get();
		}elseif($request->device == 'android'){

			$user_ids = $request->user_id;
			$user = User::find($user_ids);
			if($request->home_lat && $request->home_long){
				$user->lat = $request->home_lat;
				$user->lang = $request->home_long;
				$user->save();
			}
			$notify = \DB::table('user_notification')->where('user_id', $user->id)->where('status', 0)->get();
			$cart = \DB::table('abserve_user_cart')->where('user_id', $user->id)->get();
			$notify = $notify->isNotEmpty() ? true : false;
			$cart = $cart->isNotEmpty() ? true : false;

			$userLatitude = (isset($user) && $user->lat != '') ? $user->lat : $user->latitude;
			$userLongitude = (isset($user) && $user->lang != '') ? $user->lang : $user->longitude;
			$distance = 20;
			$shop_cat_id = $request->shop_cat_id;
			$cuisines = new \App\Models\Front\Restaurant();
			$cuisines->setUser($request->user_id);
			$cuisines = $cuisines->select('id', 'name', 'logo', 'tagline', 'location', 'mode', 'l_id', 'latitude', 'longitude', 'rating')->where('mode', 'open')->where('admin_status', 'approved')->where('status', 1)->when(isset($shop_cat_id) && $shop_cat_id !== 'All', function ($query) use ($shop_cat_id) {
        		return $query->whereRaw('FIND_IN_SET(?, `cuisine`)', [$shop_cat_id]);
    			})->get();
			$cuisines = $cuisines->filter(function ($restaurant) use ($user_ids, $userLatitude, $userLongitude, $distance) {
			    $restaurant->status = $restaurant->getFavouriteAttribute($user_ids);
			    $restaurant->src = $restaurant->getSrcAttribute();
			    $restaurant->availability = $restaurant->getAvailabilityAttribute();
			    $restaurant->review = $restaurant->getReviewAttribute();
			    $restaurant->offer = $restaurant->getResOfferAttribute();
			    $restaurant->makeHidden(['logo', 'mode', 'l_id']);
			    $foods = Fooditems::where('restaurant_id', $restaurant->id)
			        ->where('approveStatus', 'Approved')
			        ->where('item_status', 1)
			        ->where('del_status', 0)
			        ->get();
			    if ($foods->isNotEmpty()) {
			        $restaurantLatitude = $restaurant->latitude;
			        $restaurantLongitude = $restaurant->longitude;
			        $distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);
			        return $distanceKm <= $distance;
			    }
			    return false;
			});
			$once = 5;
			$cpage = request()->input('page', 1);
			$currentPageResults = array_slice($cuisines->toArray(), ($cpage - 1) * $once, $once);
			$cuisines = new \Illuminate\Pagination\LengthAwarePaginator(
			    $currentPageResults,
			    count($cuisines),
			    $once,
			    $cpage,
			    ['path' => $request->url(), 'query' => $request->query()]
			);
			$currentDay = date('Y-m-d');
			$off = \DB::table('abserve_promocode')->select('res_id')->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('promo_mode', 'on')->where('res_id', '!=', 0)->get()->pluck('res_id')->toArray();
			$id = implode(',', $off);
			$id = explode(',', $id);
			$off_res = Restaurant::select('id', 'name', 'logo', 'tagline', 'location', 'mode', 'l_id', 'latitude', 'longitude', 'rating')->where('mode', 'open')->where('admin_status', 'approved')->where('status', 1)->whereIn('id', $id)->get();
		    $off_res = $off_res->filter(function ($restaurant) use ($user_ids, $userLatitude, $userLongitude, $distance) {
			    $restaurant->status = $restaurant->getFavouriteAttribute($user_ids);
			    $restaurant->src = $restaurant->getSrcAttribute();
			    $restaurant->availability = $restaurant->getAvailabilityAttribute();
			    $restaurant->review = $restaurant->getReviewAttribute();
			    $restaurant->offer = $restaurant->getResOfferAttribute();
			    $restaurant->makeHidden(['logo', 'mode', 'l_id']);
			    $foods = Fooditems::where('restaurant_id', $restaurant->id)
			        ->where('approveStatus', 'Approved')
			        ->where('item_status', 1)
			        ->where('del_status', 0)
			        ->count();
			    if ($foods > 0) {
			        $restaurantLatitude = $restaurant->latitude;
			        $restaurantLongitude = $restaurant->longitude;
			        $distanceKm = \AbserveHelpers::calculateDistance($userLatitude, $userLongitude, $restaurantLatitude, $restaurantLongitude);

			        return $distanceKm <= $distance;
			    }
			    return false;
			})->values()->toArray();
			$categories	= Foodcategories::select('id','cat_name','image_url')->where('root_id',0)->where('type','category')->limit(7)->get()->makeHidden('image_url')->append('src');
			$more['cat_name'] = 'more';
			$more['img_url'] = null;
			$more['src'] = \URL::to('/uploads/more.png');
			$categories[7] = $more;
			if(isset($request->all)){
				$categories	= Foodcategories::select('id','cat_name','image_url')->where('root_id',0)->where('type','category')->get()->makeHidden('image_url')->append('src');
			}
		}
		if(!isset($request->device) && $request->device != 'android'){
			$data['listCount']		= $count->count();
			$data['featureCount']	= $fcount->where('ordering','1')->count();
			$data['featureList']	= $feature;
			$data['allList']		= $all;
			$data['emergency_text'] = (!empty($locRes) && $locRes->emergency_mode == 'on') ? $locRes->reason : '';
			$data['cuisines']		= $cuisines;
			$data['filter_cuisines']= isset($filter_cuisines) ? $filter_cuisines : '';
			$data['filter']			= $filter;
		}
		if(isset($request->device) && $request->device == 'android'){
			$data['cuisines']		= $cuisines->items();
			$data['cuisines_pagination'] = [
				'total' => $cuisines->total(),
				'per_page' => $cuisines->perPage(),
				'current_page' => $cuisines->currentPage(),
				'last_page' => $cuisines->lastPage(),
				'links' => [
			        'prev' => $cuisines->previousPageUrl() ?? '',
			        'first' => $cuisines->url(1),
			        'next' => $cuisines->nextPageUrl() ?? '',
			        'last' => $cuisines->url($cuisines->lastPage())
			    ]
			];
			$data['offer_cuisines'] = $off_res;
			$data['user_notification'] = $notify;
			$data['cart'] = $cart;
		}
		$data['categories']		= $categories;
		return view('front.list.search',$data);
	}

	public function paginateMap($query,$sortBy = false)
	{
		$paginator = $query->tap(function($paginatedInstance){
			return $paginatedInstance->getCollection()->sortByDesc(function($product){
				return $product->overall_rating;
			})->transform(function ($value) {
				$value->append(/*'next_available_timetext','availability','cuisine_text','time_text',*/'overall_rating');
				return $value;
			});
		});
		return $paginator;
	}
}
?>