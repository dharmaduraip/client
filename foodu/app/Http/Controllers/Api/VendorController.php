<?php namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Front\Partner;
use App\Models\Front\Restaurant;
use App\Models\fooditems;
use JWTAuth;

class VendorController extends Controller {

	private $status		= 403;
	private $message	= "Only vendors are allowed";

	public function testRole()
	{
		$guard	= (\Request::segment(1) == 'api') ? 'api' : 'web';
		$user	= auth($guard)->user();
		$group_id= $user->group_id;

		if(isset($group_id) && ($group_id == 1 || $group_id == 2)){
			return true;
		} else {
			return false;
		}
		
	}

	public function shop(Request $request)
	{
		$guard	= (\Request::segment(1) == 'api') ? 'api' : 'web';
		$user	= auth($guard)->user();
		$group_id= $user->group_id;
		$rules	= [];
		if ($this->method	== 'PUT') {
			$rules['shop_id']	= 'required';
			$rules['mode']	= 'required';
		}
		$this->validateDatas($request->all(),$rules);

		if ($this->method	== 'GET') {

			if ($this->testRole() || ($user->p_active == '1' && $request->group_id == '3') ) {
				$restaurant = Restaurant::select('id','name','mode')->where('partner_id',$user->id);
				if (!empty($request->search)) {
					$restaurant	= $restaurant->where('name' ,'Like', '%'.$request->search.'%');
				}
				$response['restaurant']	= $restaurant->get();
				$response['message']	= 'Success';
				$status	= 200;			
			}
		}
		if ($this->method	== 'PUT') {
			$restaurant	= Restaurant::find($request->shop_id);
			$restaurant->mode	= $request->mode;
			$restaurant->save();
			$response['message']	= 'Mode updated sucessfully';
			$status	= 200;
		}
		return \Response::json($response,$status);
	}

	public function menu(Request $request)
	{
		$guard	= (\Request::segment(1) == 'api') ? 'api' : 'web';
		$user	= auth($guard)->user();
		$group_id= $user->group_id;
		// $rules	= [];
		$rules['shop_id']	= 'required';
		$userdata	= Restaurant::where('partner_id',$user->id)->where('id',$request->shop_id)->first();
		if (empty($userdata)) {
			$response['message']	= 'Access Denied';
			return \Response::json($response,$this->status);
		}

		if(isset($request->food_id) && $request->food_id!='') {
			$fooddata	= fooditems::where('id',$request->food_id)->where('restaurant_id',$request->shop_id)->first();
			if (empty($fooddata)) {
				$response['message']	= 'Access Denied';
				return \Response::json($response,$this->status);
			}
		}
		if ($this->method	== 'PUT') {
			$rules['food_id']	= 'required';
			$rules['item_status']	= 'required';
		} elseif ($this->method	== 'POST') {
			$rules['shop_id']	= 'required';
			$rules['food_name']	= 'required';
			$rules['price']		= 'required';	
			// $rules['selling_price']	= 'required';
			// $rules['strike_price']	= 'required';
			$rules['status']		= 'required|in:active,inactive';
			$rules['category']		= 'required|exists:abserve_food_categories,id';
			$rules['start_time1']	= 'required|date_format:H:i:s';
			$rules['end_time1']		= 'required|date_format:H:i:s|after:start_time1';
			if(isset($request->start_time2) || isset($request->end_time2)) {
				$rules['start_time2']	  = 'required|date_format:H:i:s|after:start_time1|after:end_time1';
				$rules['end_time2']	  	  = 'required|date_format:H:i:s||after:start_time1|after:end_time1|after:start_time2';
			}
			if( $request->hasFile('image') ){
				$rules['image']	= 'required|mimes:png,jpeg,jpg|max:5000';
			}
			if(isset($request->unit)) {
				$rules['unit']	  = 'required|array';
			}
		} elseif ($this->method	== 'DELETE') {
			$rules['food_id']	= 'required';
		}
		$this->validateDatas($request->all(),$rules);

		if ($this->method	== 'GET') {
			if ($this->testRole()  || ($user->p_active == '1' && $request->group_id == '3') ) {
				$fooditem = Restaurant::with(['categories' => function($query) use ($request) {
					$query->select('abserve_food_categories.id','cat_name');
					$query->with(['menuitems' => function($q) use ($request) {
						$q->commonselect();
						if (!empty($request->search)) {
							$q->where('food_item' ,'Like', '%'.$request->search.'%');
						}
						$q->where('restaurant_id',$request->shop_id);	
					}]);		
				}])->find($request->shop_id,['id']);

				if (!empty($fooditem)) {
					$fooditem->makeHidden(['id']);
					$fooditem->categories->makeHidden(['pivot']);
					$fooditem->categories[0]->menuitems->makeHidden(['restaurant_id','main_cat',/*'start_time1','end_time1',*/'start_time2','end_time2']);
				}
				$response['Menus']	= $fooditem;
				$response['message']	= 'Menu items fetched successfully';
				$status	= 200;			
			}
		}
		elseif ($this->method  == 'PUT') {
			$fooditem	= fooditems::find($request->food_id);
			$fooditem->item_status	= $request->item_status;
			$fooditem->save();
			$response['message']	= 'Status updated successfully';
			$status	= 200;
		} elseif ($this->method	== 'DELETE') {
			$fooddelete	= fooditems::find($request->food_id);
			if(!empty($fooddelete)){
				$fooddelete->delete();
				$response['message']	= 'Item Deleted sucessfully';
				$status	= 200;
			} else {
				$response['message']	= 'Foodid does not exists';
				$status	= 422;
			}
		} elseif ($this->method	== 'POST') {
			$model	= $request->food_id ? fooditems::find($request->food_id) : new fooditems;
			$model->restaurant_id	= $request->shop_id;
			$model->food_item		= $request->food_name;
			$model->price			= $request->price;
			$model->selling_price	= '';
			$model->strike_price	= '';
			$model->main_cat	= $request->category;
			$model->status		= $request->status;
			$model->start_time1	= $request->start_time1;
			$model->end_time1	= $request->end_time1;
			if(isset($request->start_time2) || isset($request->end_time2)) {
				$model->start_time2	= $request->start_time2;
				$model->end_time2	= $request->end_time2;
			}
			if(isset($request->unit)) {
				foreach($request->unit as $k => $value) {
					$Unit['unit'][$k] 	 	= $value['id'];
					$Unit['price_unit'][$k] = $value['price'];
				}
				$model->unit 				= $Unit;
			}
			$model->save();

			if( $request->hasFile('image')) {
				$filenameWithExt	= $request->file('image')->getClientOriginalName();
				$filename			= pathinfo($filenameWithExt, PATHINFO_FILENAME);
				$extension			= $request->file('image')->getClientOriginalExtension();
				$fileNameToStore	= 'dish_'.$request->shop_id.$model->id.'.'.$extension;
				$avatar_path		= $request->file('image')->storeAs('public/restaurant/'.$request->shop_id.'/'.'', $fileNameToStore);
				$model->image		= $fileNameToStore;
				$model->save();
			}
			$response['message']	= 'Success';
			$status	= 200;
		}
		return \Response::json($response,$status);
	}

}