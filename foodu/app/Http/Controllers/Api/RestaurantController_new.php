<?php
namespace App\Http\Controllers\Api;

ini_set( 'serialize_precision', -1 );
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Front\Banner;
use App\Models\Front\Offers;
use App\Models\Front\Usercart;
use App\Models\Front\Cuisines;
use App\Models\Front\Fooditems;
use App\Models\Foodcategories;

class RestaurantController_new extends Controller {

	function homePage( Request $request)
	{
		$offer		= (object) []; $response['offer_banne']	= $response['offer_terms']	= '';
		request()->merge(['from'=>'api']);
		$response	= \App::call('App\Http\Controllers\Front\SearchController@Search')->getData();
		
		return \Response::json($response,200);

		$fieldData	= \AbserveHelpers::getCurrentUserFieldVal($request);
		$aCart		= Usercart::select(\DB::raw('CONVERT(COUNT(`quantity`),CHAR(50)) as total_quantity'),\DB::raw('SUM(price * quantity) as total_price'),'res_id')->where($fieldData['field'],$fieldData['fieldVal'])->first();
		$aCart->append('restaurant_name');
		$offer		= Offers::whereRaw('? between usage_from and usage_to', [date('Y-m-d')])->orWhereRaw('? between offer_from and offer_to', [date('Y-m-d')])->where('status','active')->first();

		$response['aCart']			= $aCart;
		$response['banner']			= Banner::get();
		if(!empty($offer)) {
			$response['offer_banne']= \URL::to('public/'.CNF_THEME.'/images/encash.jpg');
			$response['offer_terms']= \URL::to('/mega-offer?appview=1');
		}

		$response['aFilter'] = $this->getFilterArrays();
		return \Response::json($response,200);
	}

	function getFilterArrays($restaurant = [])
	{
		if (!empty($restaurant)) {
			$cuisineList	= array_column($restaurant, 'cuisine');
			$aUniqueCuisine	= array_unique(explode(',', implode(',', $cuisineList)));
			$res_id			= array_column($restaurant, 'id');
		}
		$aCuisines		= Cuisines::select('id','name','image');
		$foodItem		= Fooditems::select(\DB::raw('GROUP_CONCAT(`main_cat`) as cat'))->where('del_status','0')->orderBy('id')->where('approveStatus','Approved');
		if (!empty($restaurant)) {
			$foodItem	= $foodItem->whereIn('restaurant_id',$res_id);
		}
		$foodItem		= $foodItem->first();
		$fCategory		= Foodcategories::select('id','cat_name')->where('type','category')->where('root_id',0)->where('del_status','0');

		if (!empty($restaurant)) {
			if (!empty($foodItem))
				$fCategory	= $fCategory->whereIn('id',array_unique(explode(',', $foodItem->cat)));
			$aCuisines	= $aCuisines->whereIn('id',$aUniqueCuisine);
		}
		$aCuisines		= $aCuisines->get()->makeHidden('image ')->append('src');
		$fCategory		= $fCategory->get();

		$filter[0]['filter_name']	= 'Sort-by';
		$filter[1]['filter_name']	= 'Rating';
		$filter[2]['filter_name']	= 'Cusines';
		$filter[3]['filter_name']	= 'Categories';

		for ($i=0; $i < 2; $i++) { 
			$filter[0]['filter_values'][$i]['id']	= $i+1;
			$filter[0]['filter_values'][$i]['name']	= ($i == 0) ? 'Distance' : 'Rating';
		}
		for ($i=0; $i < 5; $i++) {
			$val	= $i+1;
			$filter[1]['filter_values'][$i]['id']	= $val;
			$filter[1]['filter_values'][$i]['name']	= "$val";
		}
		$filter[2]['filter_values'] = $aCuisines;
		foreach ($fCategory as $key => $value) {
			$filter[3]['filter_values'][$key]['id']		= $value->id;
			$filter[3]['filter_values'][$key]['name']	= $value->cat_name;
		}

		$aFilter = json_decode(json_encode($filter));
		return $aFilter;
	}
}
?>
