<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator, Input, Redirect, Response;
use Illuminate\Http\Request;
use App\User;
// use LucaDegasperi\OAuth2Server\Authorizer;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\EmailController as emailcon;

use App\Models\Front\Fooditems;
use App\Models\Front\Restaurant;
use App\Models\Foodcategories;
use App\Models\Cuisines;
use App\Models\Masterdata;
use App\Models\Hotelitems;
use App\Models\MasterShopItems;
use App\Models\Foodunit;
use App\Models\Variationunit;
use App\Models\Variationcolor;
use App\Models\MasterFoodUnitData;
use App\Models\MasterFoodVariationsData;
use App\Models\FooditemsUnit;
use App\Models\FooditemsVariation;
use App\Models\Partnerwallet;


class PartnerController extends Controller {

	function getProfile(Authorizer $authorizer,$user_type )
	{

		$user_id	= $authorizer->getResourceOwnerId(); // the token user_id
		$user		= User::where('id',$user_id)->where('group_id','3')->first();
		if(empty($user) || $user->group_id != '3'){
			$response['message'] =  'Invalid User';
			response()->json($response, 422)->send();exit();
		}
     	return $user;
	}

	function masterDatas(Request $request)
	{
		$aUser =\Auth::user();

		$response['aFoodCategories'] = Foodcategories::select('id','cat_name')->where('root_id','0')->where('del_status','0')->get();

		$response['aCuisines'] = Cuisines::select('id','name','image')->get();

		$response['aTime'] = \DB::table('abserve_time')->select('name')->get();

		$select = ['id','name','location','logo','delivery_time','budget','rating','mode','cuisine'];

		$aRestaurant = Restaurant::where('partner_id',$aUser->id)->with('getRestuarantItems')->get()->map(function ($result) {
	       	$result->append('src','availability','cuisine_text');
	       	return $result;
	    });

	    $response['aRestaurant'] = $aRestaurant;

		return \Response::json($response);
	}

	function addEditFoodItems(Request $request)
	{
		// print_r($request->all());exit();
		$aUser	= \Auth::user();
		$rules['restaurant_id']	= 'required|numeric';
		if (isset($request->action)) {
			$rules['action']	= 'required|in:statusChange,delete';
			$rules['food_id']	= 'required';
			if ($request->action == 'statusChange') {
				$rules['item_status'] 	= 'required|in:0,1'; //1 - instock, 0 ->out of stock;
			}
		} else {
			$rules['id']			= 'required|numeric';
			$rules['price']			= 'required';
			$rules['adon_type']		= 'required|in:-,unit,variation';
			$rules['gst']			= 'required';
			$rules['item_status'] 	= 'required|in:0,1'; //1 - instock, 0 ->out of stock;
			if (isset($request->adon_type) && $request->adon_type == 'unit' ) {
				$rules['unit']			= 'required';
				$rules['unit_quantity']	= 'required';
				$rules['unit_price']	= 'required';
			}
			if (isset($request->adon_type) && $request->adon_type == 'variation' ) {
				$rules['Fcolor']		= 'required';
				$rules['vari_unit']		= 'required';
				$rules['vari_price']	= 'required';
			}
		}
		$this->validateDatas($request->all(),$rules);
		$restaurant_id = $request->restaurant_id;
		if (isset($request->action)) {
			$food_id	= (isset($request->food_id) && $request->food_id != '') ? $request->food_id : '';
		} else {
			$food_id	= (isset($request->id) && $request->id != '') ? $request->id : '';
		}
		$access		= \AbserveHelpers::foodItemsEditCheck($restaurant_id,$aUser->id,$food_id);
		if (!$access) {
			return \Response::json(['message' => 'You do not have access'],422);
		}

		if ($food_id == '') {
			$food				= new Fooditems;
			$food->created_at	= date('Y-m-d H:i:s');
			$food->approveStatus= 'Waiting';
			$food->price	= $request->price;
			$message		= 'Product added successfully';
		} else {
			$food	= Fooditems::find($food_id);
			$message= 'Product updated successfully';
		}
		if ($request->action == 'delete') {
			$food->del_status	= '1';
			$food->save();
			$message	= 'Product deleted successfully';
		} elseif($request->action == 'statusChange') {
			$food->item_status	= $request->item_status;
			$food->save();
			$message	= 'Updated successfully';
		} else {
			$request->merge(['partner_edit'	=> '1']);
			return app()->call('App\Http\Controllers\FooditemsController@store',[$request->all()]);	
		}
		return response()->json(['message'=> $message, 'status'=>200 ]);
	} 

	function viewFoodItem(Request $request)
	{
		$aUser = \Auth::user();
		$rules['id'] 						= 'required|numeric';
		$rules['restaurant_id'] 			= 'required|numeric';
		$this->validateDatas($request->all(),$rules);
		$restaurant_id = $request->restaurant_id;
		$access = \AbserveHelpers::foodItemsEditCheck($restaurant_id,$aUser->id,$request->id);
		if(!$access){
			return \Response::json(['message' => 'You do not have access'],422);
		}
		$select = ['id','restaurant_id','food_item','description','main_cat','status','item_status','adon_type','image','price','selling_price','original_price','is_veg','start_time1','end_time1','gst','strike_price'];
		$response['aFoodItems'] = Fooditems::select($select)/*->with('unit','variation')*/->where('id',$request->id)->where('restaurant_id',$restaurant_id)->where('del_status','0')->first()->append('src','main_cat_name');
		return \Response::json($response,200);
	}

	function foodCategoryItems(Request $request)
	{
		if($request->view == 'categoryMaster'){
			$aCategories = \DB::table('abserve_food_categories')->select('id','cat_name')->where('root_id','=',0)->where('del_status',0)->get();
			$response['category'] = $aCategories;
			return \Response::json($response,200);
		}
		$aUser = \Auth::user();

		$rules['restaurant_id'] 		= 'required';
		$rules['view'] = 'required|in:category,category_items,categoryMaster';

		if($request->input('view') !== null && $request->view == 'category_items'){
			$rules['main_cat'] 		= 'required';
			$niceNames = [];
		}

		$this->validateDatas($request->all(),$rules);

		$restaurant_id = $request->restaurant_id;
		$access = \AbserveHelpers::restaurantOwnerCheck($restaurant_id,$aUser->id);

		if(!$access){
			return \Response::json(['message' => 'You do not have access'],422);
		} else {
			$query = Fooditems::where('restaurant_id',$restaurant_id)->where('del_status','0');
			if($request->view == 'category_items'){
				$select = ['id','restaurant_id','food_item','description','specification','main_cat','status','item_status','recommended','adon_type','start_time1','end_time1','start_time2','end_time2','image','price','selling_price','original_price'];
				$response['aFoodItems'] = $query->where('main_cat',$request->main_cat)->select($select)->get()->map(function($result){
					$result->append('src','main_cat_name');
					return $result;
				});
			} else {
				$response['aCategoryItems'] = $query->select('main_cat',\DB::raw('COUNT(id) as food_count'))->groupBy('main_cat')->get()->map(function ($result) use($restaurant_id) {
					$result->food_items = $result->getFoodItemDetailAttribute($restaurant_id);
					return $result->append('main_cat_name');
				});
			}
			$response['Foodunits'] = Foodunit::get();
			$response['Vunits'] = Variationunit::get();
			$response['Vcolour'] = Variationcolor::get();
			
			return \Response::json($response,200);
		}
	}

	function restaurant(Request $request)
	{
		$aUser =\Auth::user();


		$select = ['id','name','location','logo','delivery_time','budget','rating','mode','cuisine'];
		$aRestaurant = Restaurant::where('partner_id',$aUser->id)->get()->map(function ($result) {
	       	$result->append('src','availability','cuisine_text','category');
	       	return $result;
	    });
	    // $this->foodCategoryItems($request,$authorizer)->getdata();

	    $response['aRestaurant'] = $aRestaurant;

	    return \Response::json($response,200);
	}

	function addEditRestaurant(Request $request)
	{
		$aUser = \Auth::user();
		$niceNames	= [];
		$restaurant_id = $request->input('restaurant_id') !== null ? $request->restaurant_id : '';

		$rules['action'] = 'required|in:modeChange';
		// $rules['action'] = 'required|in:save,delete,modeChange';

		if($request->input('action') !== null && $request->action != 'save'){
			$rules['restaurant_id'] = 'required';
			if($request->action == 'modeChange'){
				$rules['mode'] = 'required|in:open,close';
			}
		}

		$this->validateDatas($request->all(),$rules,$niceNames);


		$access = \AbserveHelpers::restaurantOwnerCheck($restaurant_id,$aUser->id);
		if(!$access){
			return \Response::json(['message' => 'You do not have access'],422);
		}

		if($restaurant_id == ''){
			$restaurant = new Restaurant;
			$restaurant->created_at = date('Y-m-d H:i:s');
			$message = 'Shop created successfully';
		} else {
			$restaurant = Restaurant::find($restaurant_id);
			$message = 'Shop updated successfully';
		}

		if($request->action == 'save') {

		} elseif($request->action == 'modeChange') {
			$restaurant->mode = $request->mode;
			$message = 'Shop mode updated';
		} elseif($request->action == 'delete') {
			$message = 'Shop deleted successfully';
		}
		/*$restaurant->updated_at = date('Y-m-d H:i:s');*/
		$restaurant->save();
		$response['message'] = $message;
		return \Response::json($response,200);
	}

	function viewCategoryItem(Request $request)
	{
		$rules['category_id']	= 'required';
		$this->validateDatas($request->all(),$rules);

		$menuItems	= Masterdata::select('id','name')->where('category',$request->category_id)->get();
		if (!empty($menuItems)) {
			$res['menuitems'] = $menuItems;
			$message    = '';
			$status		= 200;
		} else {
			$message    = "Sorry no items in that category.";
			$status		= 503;
		}
		$res['message'] = $message;
		return \Response::json($res,$status);
	}

	function addItems(Request $request)
	{
		$status		= 422; $message = 'Something went wrong';
		$niceNames	= $cmessage	= [];
		$rules['category_id']	= 'required';
		$rules['product_id']	= 'required';
		foreach($request->product_id as $key => $val) {
			$rules['product_id.'.$key]	= 'required|numeric';
			$cmessage['product_id.'.$key.'.required'] = 'The Product field is required.';
		}
		$niceNames['product_id']	= 'Product';
		$this->validateDatas($request->all(),$rules,$cmessage,$niceNames);

		$aUser		= \Auth::user();
		$productId	= $request->product_id;
		$productData= MasterShopItems::where('partner_id',$aUser->id)->where('shop_id',$aUser->shops[0]->id)->whereIn('parent_id',$productId)->get();
		if (count($productData) > 0) {
			$res['message']	= 'Some of the items are already added in your shop';
			return \Response::json($res,422);
		}

		$categoryId	= $request->category_id;
		$menuItems	= Masterdata::where('category',$categoryId)->whereIn('id',$productId)->get();
		if (!empty($menuItems)) {
			$plucked	= $menuItems->pluck('id');
			$productId	= $plucked->all();
			$return		= $this->insertItems($productId,$aUser->shops[0]->id,$aUser->id);
			if ($return) {
				$status	= 200;
				$message= "Product added successfully";
			}
		} else {
			$message	= "Check your items";
			$status		= 503;
		}
		
		$res['message'] = $message;
		return \Response::json($res,$status);
	}

	public function insertItems($productId = [], $resId, $partnerId)
	{
		if (!empty($productId)) {
			foreach ($productId as $key => $value) {
				$product	= Masterdata::find($value);
				if (!empty($product)) {
					$items	= new Hotelitems;
					$items->restaurant_id	= $resId;
					$items->food_item		= $product->name;
					$items->price			= $product->price;
					$items->original_price	= ($product->price / (100 + $product->gst)) * 100;
					$items->gst				= $product->gst;
					$items->adon_type		= $product->adon_type;
					$items->image			= $product->image;
					$items->main_cat		= $product->category;
					$items->sub_cat			= $product->brand;
					$items->save();

					if ($product->adon_type == 'unit') {
						$MasterUnit	= MasterFoodUnitData::where('food_id',$product->id)->get();
						if (count($MasterUnit) > 0) {
							foreach ($MasterUnit as $keyFU => $valueFU) {
								if ($valueFU != '') {	
									$foodUnit	= new FooditemsUnit;
									$foodUnit->created_at 	= date('Y-m-d H:i:s');
									$foodUnit->food_id  	= $items->id;
									$foodUnit->unit 		= $valueFU->unit;
									$foodUnit->unit_type 	= $valueFU->unit_type;
									$foodUnit->date 		= date('Y-m-d');
									$foodUnit->updated_at 	= date('Y-m-d H:i:s');
									$foodUnit->save();	
								}
							}
						}
					} elseif ($product->adon_type == 'variation') {
						$MasterVar	= MasterFoodVariationsData::where('food_id',$product->id)->get();
						if (count($MasterVar) > 0) {
							foreach ($MasterVar as $keyFc => $valueFc) {
								if($valueFc != ''){
									$variation	= new FooditemsVariation;
									$variation->created_at	= date('Y-m-d H:i:s');
									$variation->food_id		= $items->id;
									$variation->color		= $valueFc->color;
									$variation->unit		= $valueFc->unit;
									$variation->date		= date('Y-m-d');
									$variation->updated_at	= date('Y-m-d H:i:s');
									$variation->save();
								}
							}
						}
					}
					$shopItems	= new MasterShopItems;
					$shopItems->parent_id	= $value;
					$shopItems->child_id	= $items->id;
					$shopItems->partner_id	= $partnerId;
					$shopItems->shop_id		= $resId;
					$shopItems->save();
				}
			}
			$exists_cat	= Hotelitems::where('main_cat',$items->main_cat)->where('restaurant_id',$resId)->get();
			if ($exists_cat) {
				$product_item = \AbserveHelpers::categoryList($items->main_cat,$resId,$status='save_product');
				$shop = Restaurant::find($resId,['shop_categories']);
				if(!empty($shop->shop_categories))
					Restaurant::where('id','=', $resId)->update(['shop_categories'=>\DB::raw("CONCAT(shop_categories,', ".$items->main_cat."')")]);
			}
			$return = true;
		} else {
			$return = false;
		}
		return $return;
	}

	public function addFooditem(Request $request)
	{
		$rules['action'] = 'required|in:add,edit,delete';
		if($request->action == 'edit' || $request->action == 'delete'){
			$rules['food_id'] = 'required';
		}
		if($request->action != 'delete'){
			$rules['food_name'] = 'required';
			$rules['food_cat'] = 'required';
			$rules['price'] = 'required';
			$rules['selling_price'] = 'required';
			$rules['strike_price'] = 'required';
			$rules['start_time'] = 'required';
			$rules['end_time'] = 'required';
			$rules['item_status'] = 'required';
			if($request->action != 'edit'){
				$rules['image'] = 'required';
			}
			$rules['res_id'] = 'required';
			$rules['gst'] = 'required';
			$rules['is_veg'] = 'required';
		}
		$this->validateDatas($request->all(),$rules);

		$item = Fooditems::find($request->food_id);
		if($request->action != 'delete'){
			if(!$item){
				$item = new Hotelitems;
			}
			$item->restaurant_id = $request->res_id;
			$item->food_item = $request->food_name;
			$item->price = $request->price;
			$item->selling_price = $request->selling_price;
			$item->strike_price = $request->strike_price;
			$item->original_price = $request->price;
			$item->start_time1 = $request->start_time;
			$item->end_time1 = $request->end_time;
			$item->item_status = $request->item_status;
			$item->main_cat = $request->food_cat;
			$item->is_veg = $request->is_veg;
			$item->gst = $request->gst;
			$item->save();
			if($request->hasFile('image')){
				$image = $request->file('image');
				$extension = $image->getClientOriginalExtension();
				$filename = 'dish_'.$request->res_id.$item->id.'.'.$extension;
				$image->move('storage/app/public/restaurant/'.$request->res_id, $filename);
			    $item->image = $filename;
			}
			$item->save();
		}elseif($request->action == 'delete'){
			$item->del_status = 1;
			$item->save();
		}
		// $response['message'] = 'Food item added successfully';
		$response['message'] = $request->action == 'add' ? 'Food item edited successfully' : ($request->action == 'edit' ? 'Food item added successfully' : 'Food item deleted successfully');

		return \Response::json($response,200);
	} 

	public function shopEarning(Request $request)
	{
		$user_id = \Auth::user()->id;
		$earning = Partnerwallet::where('partner_id', $user_id)->where('transaction_type','credit')->sum('transaction_amount');
        $earning = number_format($earning, 2);	    
		$response['earning'] = $earning;
		return \Response::json($response,200);
	}

	public function shopEarningDetails(Request $request)
	{
		$user_id = \Auth::user()->id;
		$earning_details = Partnerwallet::with(['orderdetails' => function($query) {
			    $query->with('restaurant');
			    $query->selectRaw("*, FROM_UNIXTIME(completed_time, '%d-%m-%Y') as completed_date, FROM_UNIXTIME(completed_time, '%h:%i:%s %p') as completed_time");
			}])->where('partner_id', $user_id)->where('transaction_type','credit')->orderBy('id', 'desc')->paginate(10);
		$response['earning_details'] = $earning_details;
		return \Response::json($response, 200);
	}


}	