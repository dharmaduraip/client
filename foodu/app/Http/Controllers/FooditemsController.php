<?php namespace App\Http\Controllers;

use App\Models\Fooditems;
use App\Models\Restaurant;
use App\Models\Front\Restaurant as Restaurants;
use App\Models\Masterdata;
use Illuminate\Http\Request;
use App\Http\Requests\CsvImportRequest;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect , Session,Response,DB; 
use App\Models\FooditemsUnit;
use App\Models\Hotelitems;
use App\Models\FooditemsVariation;
use App\Models\MasterFoodUnitData;
use App\Models\MasterShopItems;
use App\Models\MasterFoodVariationsData;
use Image;
use App\Models\Variations;
use App\Models\Front\Usercart;


class FooditemsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'fooditems';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Fooditems();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'fooditems',
			'return'	=> self::returnUrl()
			
		);	
	}

	public function index( Request $request )
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');
		$this->grab( $request) ;
		$item_count=\DB::table('tb_settings')->select('item_count')->where('id',1)->first();
		
		$this->data['item_count']   =$item_count->item_count;
		if($this->access['is_view'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');		
		$filter = '';
		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
		if(!is_null($request->input('search'))){
			$searchVal1=explode("|", $request->input('search'));
			if(count($searchVal1)){
				foreach ($searchVal1 as $key => $value) {
					if($value!=''){
						$searchVal2=explode(":", $value);
						$filter .= " AND abserve_restaurants.".$searchVal2[0]." = '".$searchVal2[2]."'";
					}
				}
			}
		}
		$filter .= " AND abserve_restaurants.status != '3'";
		if(\Auth::user()->group_id == "5"){
			$id = \Auth::user()->id;
			$partner_list	=  \DB::table('tb_users')->select(\DB::raw('GROUP_CONCAT(id) as partners'))->where('manager_id' , $id)->first();
			if(!empty($partner_list->partners)) {
				$filter .= "AND abserve_restaurants.partner_id IN ($partner_list->partners) ";
			}
		}
		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);		
		// Render into template
		if(\Auth::user()->group_id == 1 || \Auth::user()->group_id==5 || \Auth::user()->group_id == 2) {
			//$results = $this->model->getRows( $params );
			$model = new Restaurant();
			$results = $model->getRows( $params );
		} else {
			$results['rows'] = \DB::select("SELECT `id` FROM `abserve_restaurants` WHERE `abserve_restaurants`.`partner_id` = ".\Auth::user()->id." AND abserve_restaurants.status != '3' ORDER BY `abserve_restaurants`.`id` DESC");
			$results['total'] = count($results['rows']);
		}
		$this->data['rowData']		= $results['rows'];
		$this->data['tb_users']=\DB::table('tb_users')->where('group_id','=',3)->get();
		$this->data['restaurants']=\AbserveHelpers::approvedrestaurant();
		return view( $this->module.'.index',$this->data)->with('model',new Fooditems)->with('rmodel',new Restaurant);
	}

	public function single_exists($table='',$fields='',$value='',$exwhere = '')
	{
		$data = \DB::table($table)->where($fields,'=',$value);
		if($exwhere == 'restaurant'){
			$data->where('status','!=','3');
		}elseif($exwhere == 'fooditems'){
			$data->where('del_status','0');
		}	
		$res = $data->exists();
		return $res;
	}

	public function getResdatas(Request $request, $res_id = null)
	{
		if($res_id != ''){
			$res_exists  = $this->single_exists('abserve_restaurants','id',$res_id,'restaurant');
			if($res_exists){

				if(\Auth::user()->group_id != 1 && \Auth::user()->group_id != 5 && \Auth::user()->group_id != 2){

					$owner_check = $this->double_exists('abserve_restaurants','id,partner_id',$res_id.",".\Auth::id());
				} else {

					$owner_check = 1;
				}
				if($owner_check){

					$this->data['res_id']	= $res_id;
					Session::put('resID',$res_id);
					$this->data['currencySymbol'] 	= \AbserveHelpers::getCurrencySymbol();
					$this->data['perPage']	= 10;
					$this->data['page']		= (isset($request->page) && $request->page) ? $request->page : 1;
					$restaurant				=  \DB::table('abserve_restaurants')->select('*')->where('id', '=', $res_id)->where('status','!=','3')->first();
					$this->data['restaurant'] 	= $restaurant;
					$allItems		= \DB::table('abserve_hotel_items')->select(\DB::raw('abserve_hotel_items.*,abserve_hotel_items.gst as foodGST,abserve_restaurants.*,abserve_hotel_items.id as id_item '))->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_hotel_items.restaurant_id');
					if (isset($request->name) && $request->name != '') {
						$allItems = $allItems->where('food_item','LIKE','%'  .$request->name . '%');
					}
					if (\Auth::user()->group_id == '3') {
						$allItems = $allItems->where('abserve_restaurants.id',$res_id)->where('abserve_hotel_items.del_status','0')->where('abserve_hotel_items.entry_by',\Auth::id())->orderBy('abserve_hotel_items.id','DESC')->paginate('10');
					} else {
						$allItems = $allItems->where('abserve_restaurants.id',$res_id)->where('abserve_hotel_items.del_status','0')->orderBy('abserve_hotel_items.id','DESC')->paginate('10');
					}
					$this->data['allItems'] = $allItems;

					\AbserveHelpers::menuNotificationUpdate($res_id);
					return view('fooditems.food_items',$this->data);	
				} else {
					return Redirect::to('fooditems')->with('messagetext',"Sorry!.. You're not allow to access this Restaurant")->with('msgstatus','error');
				}
			} else {
				return Redirect::to('fooditems')->with('messagetext','No Such Restaurant Found')->with('msgstatus','error');
			}
		} else {
			return Redirect::to('fooditems')->with('messagetext','No Such Restaurant')->with('msgstatus','error');	
		}
	}

	public function postImportimage(Request $request)
	{
		$dataFiles = [];
		if($request->hasFile('image')){
			foreach ($request->file('image') as $fKey => $file) {
				$document	= $file;
				$filename	= $document->getClientOriginalName();
				$destinationPath= base_path('/uploads/images');
				$success	= $document->move($destinationPath, $filename);
				if ($success) {
					$dataFile[]		= $filename;
					$path= base_path('uploads/images/');
						 \AbserveHelpers::compressor($path.$filename);
					\DB::table('csv_image')->insert(array('images' => $filename));
				} else {
					$dataFiles[]	= $filename;
				}
			}
		}
		$return = redirect()->back();
		if (!empty($dataFiles)) {
			$return = $return->with('messagetext','No Item Deleted')->with('msgstatus','error');
		}
		return $return;
	}

	public function postImportimages(Request $request)
	{
		if($request->hasFile('image')){
			foreach ($request->file('image') as $fKey => $file) {
				$document	= $file;
				$filename	= $document->getClientOriginalName();
				$destinationPath= base_path('uploads/images');
				$document->move($destinationPath, $filename);
				$dataFile[]		= $filename;
				$path			= base_path('uploads/images/');
				\AbserveHelpers::compressor($path.$filename);
				\DB::table('csv_images')->insert(array('images' => $filename));
			}
		}
		return redirect()->back()->with('messagetext', 'Images uploaded successfully')->with('msgstatus','success');
	}

	function create( Request $request , $id =0 ) 
	{
		$this->hook( $request );
		if($this->access['is_add'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

		$this->data['row'] = $this->model->getColumnTable( $this->info['table']); 
		
		$this->data['id'] = '';
		$unit       = Variations::where('type','Variation')->get();
		return view($this->module.'.form',$this->data,compact('unit'));
	}

	function edit( Request $request , $id ) 
	{
		$menuitem   = Fooditems::where('id',$id)->first();
		if(empty($menuitem)) {
			return redirect()->back();
		}
		$menuitem->unit_det = $menuitem->unit_detail;
		$this->hook( $request , $id );
		if(!isset($this->data['row']))
			return redirect($this->module)->with('message','Record Not Found !')->with('status','error');
		if($this->access['is_edit'] ==0 )
			return redirect('dashboard')->with('message',__('core.note_restric'))->with('status','error');
		$this->data['row'] = (array) $this->data['row'];
		$this->data['user_address'] = \DB::table('abserve_user_address')->where(['user_id' => $id,'hide' => 0])->get();
			// echo "<pre>"; print_r($this->data);exit();	
		$this->data['id'] = $id;
		$unit       = Variations::where('type','Variation')->get();
		return view($this->module.'.form',$this->data,compact('unit','menuitem'));
	}

	function show( Request $request , $id ) 
	{
		/* Handle import , export and view */
		$task =$id ;
		switch( $task)
		{
			case 'search':
			return $this->getSearch();
			break;
			case 'lookup':
			return $this->getLookup($request );
			break;
			case 'comboselect':
			return $this->getComboselect( $request );
			break;
			case 'import':
			return $this->getImport( $request );
			break;
			case 'export':
			return $this->getExport( $request );
			break;
			default:
			$this->hook( $request , $id );
			if(!isset($this->data['row']))
				return redirect($this->module)->with('message','Record Not Found !')->with('status','error');

			if($this->access['is_detail'] ==0) 
				return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

			return view($this->module.'.view',$this->data);	
			break;		
		}
	}

	function store( Request $request  )
	{ //echo "<pre>";print_r($request->all());die;

		$user_name	= \Auth::user()->username;
		$partner_id	= Restaurant::find($request->restaurant_id);
		$user_id	= (\Auth::user()->group_id == '3')? \Auth::id() : $partner_id->partner_id ;
		$taxPercent = getenv('TAX_PERCENT') > 0 && getenv('TAX_PERCENT') != '' ?  getenv('TAX_PERCENT') : 5;
		$custom_message			= [];
		$rules['restaurant_id']	= 'required';
		if(!$request->id){
			$rules['image']	= 'required';
		}
		$rules['food_item']		= 'required';
		// $rules['adon_type']		= 'required|in:-,unit,variation'; // As of now '-' (None) only		
		
		//$rules['gst']			= 'required';
		if (isset($request->strike_price))
			$rules['strike_price']  = 'required|min:0';
		if (isset($request->addons)){
			$rules['addons']		= ['required','array'];
			foreach ($request->addons as $key => $val) {
				// $rules['name.'.$key] = 'required|distinct|min:3';
				// |exists:edu_common_data,id
				$rules['addons.'.$key]= 'required|exist_check:abserve_addons,where:id:=:'.$val.'-where:user_id:=:'.$user_id;
			}
		}


		// if (!isset($request->partner_edit) ) {
		// 	$rules['main_cat']		= 'required';
		// 	$rules['sub_cat']		= 'required';
		// 	if ($request->hasFile('image')) {
		// 		foreach($request->image as $index => $value) {
		// 			if($index == 0){
		// 				$rules['image.'.$index] = 'required|mimes:png,jpeg,jpg|max:1024';
		// 			} else {
		// 				$rules['image.'.$index] = 'mimes:png,jpeg,jpg|max:1024';
		// 			}
		// 			$custom_message['image.'.$index.'.required'] = 'Please upload proof';
		// 			$custom_message['image.'.$index.'.mimes'] = 'Only jpeg,jpg,png files are allowed';
		// 			$custom_message['image.'.$index.'.max'] = 'Sorry! Maximum allowed size for proof is 1MB';
		// 		}
		// 	}
		// }
		$niceNames	= array('startTime1' => 'Available from', 'end_time1' => 'Available to','price' => 'Price');
		$validator	= Validator::make($request->all(), $rules,$custom_message);
		// $validator->setAttributeNames($niceNames);
		$id			= $request->input('id');

		if ($validator->passes()) {

			\Request::merge(['recommended'	=> 1]);
			$restaurant_id	= $request->restaurant_id;
			$restaurant		= Restaurant::find($restaurant_id);
			$food_id		= $request->input('id') != '' ? $request->id : '';
			if(\Auth::user()->group_id == '5') {
				$partner_id = implode(',', \AbserveHelpers::managersPartner(\Auth::user()->id));
			} else {
				$partner_id = (\Auth::user()->group_id == '1' || \Auth::user()->group_id == '2') ? $restaurant->partner_id : \Auth::user()->id;
			}
			if(isset($request->partner_edit) && $request->partner_edit == 1){
				$access = true;
			}else{
				$access = \AbserveHelpers::foodItemsEditCheck($restaurant_id,$partner_id,$food_id);
			}
			if (!$access) {
				if (!isset($request->partner_edit) && $request->partner_edit == 1){
					return \Redirect::to('fooditems/resdatas/'.$restaurant_id)
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
			   } else { 
					return response()->json(['message'=> \Lang::get('core.note_restric'), 'status'=>422 ])->send();
				}
			}

			if($request->input('id') == '') {
				$food	= new Fooditems;
				$food->created_at	= date('Y-m-d H:i:s');
				$message			= 'Fooditem added successfully';
			} else {
				$food	= (object) Fooditems::find($request->id); 
				$message= 'Fooditem updated successfully';
			}
			
			$aMandatoryFields = ['restaurant_id','food_item','main_cat','sub_cat','adon_type','item_status','recommended'];

			if (isset($request->partner_edit) && $request->partner_edit == 1) {
				$aMandatoryFields = ['restaurant_id','food_item','item_status','recommended'];
			}

			foreach($aMandatoryFields as $key => $value) {
				$food->{$value} = $request->{$value};
			}

			$food->price  = $request->price;
			$food->original_price 	= ($request->price / (100 + $request->gst)) * 100;
			$startTime1 = ($request->start_time1 == '') ? '' : date("H:i:s", strtotime($request->start_time1));
			$endTime1 = ($request->end_time1 == '') ? '' : date("H:i:s", strtotime($request->end_time1));
			$startTime2 = ($request->start_time2 == '') ? '' : date("H:i:s", strtotime($request->start_time2));
			$endTime2 = ($request->end_time2 == '') ? '' : date("H:i:s", strtotime($request->end_time2));
			$food->start_time1 = $startTime1;
			$food->end_time1 = $endTime1;
			$food->start_time2 = $startTime2;
			$food->end_time2 = $endTime2;

// echo "<pre>";print_r($request->all());die;

			if(isset($request->strike_price))
				$food->strike_price = $request->strike_price;
			$food->unit         =$request->only(['unit','price_unit']);



			if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2) {
				$food->approveStatus = $request->approveStatus;
				if($request->hiking == 0){
					// $food->selling_price  = $request->price;
					$food->selling_price  = $request->selling_price;
				} else {
					// $food->selling_price = ($request->price * ( $request->hiking / 100 )) + $request->price;
					$food->selling_price = $request->selling_price;
				}
			} else {
				$tax				  =	$request->price * ( $request->hiking / 100 );
				// $food->selling_price  = $tax + $request->price; 
				$food->selling_price  = $request->selling_price; 
			}
			// $imageVal			= array_filter($imageVal);

			if (isset($request->partner_edit) && $request->partner_edit == 1 )
				$food->adon_type = $request->adon_type;
			else if ($request->adon_type == '-')
				$food->adon_type = '';

			// $food->image		= implode(',', $imageVal);
			//$food->main_cat='1';
			$food->adon_type = '';
			$food->sub_cat='1';
			$food->updated_at	= date('Y-m-d H:i:s');
			$food->gst = $request->gst;
			if(isset($request->main_cat)){

				$food->main_cat=$request->main_cat;
			}
			if(isset($request->addons)){
				$addonsid=implode(',',$request->addons);
				$food->addon	= $addonsid;
			}
			$food->save();

			$path		= 'storage/app/public/restaurant/'.$restaurant_id.'/';
			$imageVal	= explode(',', $food->image);
			if ($request->id) {
				$deletedImg	= explode(',', $request->deletedImg);
				if($request->deletedImg != '' && count($deletedImg) > 0 && count($imageVal) > 0){
					foreach ($imageVal as $key => $value) {
						if(in_array($value, $deletedImg)){
							\AbserveHelpers::unlinkimage($path,$value);
							unset($imageVal[$key]);
						}
					}
				}
			}
			if($request->hasFile('image')){
				foreach ($request->image as $key => $value) {
					$file = $request->image[$key];
					$filename	= 'dish_'.$restaurant_id.$food->id;
					$oldImageName = '';
					$upload = \AbserveHelpers::uploadImage($file,$path,$oldImageName,'',$filename);
					if($upload['success']){
						$imageVal[] = $upload['image'];
					}
				}
			}

			$imageVal			= array_filter($imageVal);
			$food->image		= implode(',', $imageVal);
			$food->entry_by	  	= $user_id;
			// $food->is_veg       = (isset($request->is_veg)) ? '1' : '0';
			$food->is_veg       = $request->is_veg;
			$food->save();
			$aSavedFoodUnitIds = [];
			// if ($request->adon_type == 'unit') { 
			// 	if (count($request->unit) > 0) { 
			// 		foreach ($request->unit as $keyFU => $valueFU) {
			// 			if ($valueFU != '') {	
			// 				$uniID = isset($request->unit_id[$keyFU]) && $request->unit_id[$keyFU] > 0 ? $request->unit_id[$keyFU] :''; 
			// 				if($uniID != '' && \DB::table('tb_food_unit')->where('id',$uniID)->where('food_id',$food->id)->exists()){
			// 					$foodUnit = FooditemsUnit::find($uniID);
			// 				} else {
			// 					$foodUnit = new FooditemsUnit;
			// 					$foodUnit->created_at = date('Y-m-d H:i:s');
			// 				}
			// 				$foodUnit->food_id	= $food->id;
			// 				$foodUnit->unit		= $request->unit_quantity[$keyFU];
			// 				$foodUnit->price	= $request->unit_price[$keyFU];
			// 				$foodUnit->hiking	= $request->unit_hiking[$keyFU];
			// 				$foodUnit->unit_type= $valueFU;
			// 				$foodUnit->date		= date('Y-m-d');
			// 				$foodUnit->updated_at		= date('Y-m-d H:i:s');
			// 				$foodUnit->original_price	= ($request->unit_price[$keyFU] / (100 + $request->gst)) * 100;
			// 				if((\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2) && !empty($request->unit_sprice[$keyFU])) {
			// 					$foodUnit->selling_price = $request->unit_sprice[$keyFU];
			// 				}else{
			// 					$tax	=	$request->unit_price[$keyFU] * ( $request->unit_hiking[$keyFU] / 100 );
			// 					$foodUnit->selling_price  = $tax + $request->unit_price[$keyFU];
			// 				}
			// 				$foodUnit->save();	
			// 				$aSavedFoodUnitIds[] = $foodUnit->id;	
			// 			}
			// 		}
			// 	}
			// } elseif($request->adon_type == 'variation') {
			// 	if(count($request->Fcolor)>0) {
			// 		foreach ($request->Fcolor as $keyFc => $valueFc) {
			// 			if($valueFc!=''){
			// 				$variationID = isset($request->variation_id[$keyFc]) && $request->variation_id[$keyFc] > 0 ? $request->variation_id[$keyFc] :'';
			// 				if($variationID != '' && FooditemsVariation::where('id',$variationID)->where('food_id',$id)->exists()){
			// 					$variation = FooditemsVariation::find($variationID);
			// 				} else {
			// 					$variation = new FooditemsVariation;
			// 					$variation->created_at = date('Y-m-d H:i:s');
			// 				}
			// 				$variation->food_id	= $id;
			// 				$variation->color	= $valueFc;
			// 				$variation->unit	= $request->vari_unit[$keyFc];
			// 				$variation->price	= $request->vari_price[$keyFc];
			// 				$variation->hiking	= $request->vari_hiking[$keyFc];
			// 				$variation->original_price	= ($request->vari_price[$keyFc] / (100 + $request->gst)) * 100;
			// 				if((\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2) && !empty($request->vari_sprice[$keyFc])) {
			// 					$variation->selling_price = $request->vari_sprice[$keyFc];
			// 				}else{
			// 					$tax	=	$request->vari_price[$keyFc] * ( $request->vari_hiking[$keyFc] / 100 );
			// 					$variation->selling_price  = $tax + $request->vari_price[$keyFc];
			// 				}
			// 				$variation->date 	= date('Y-m-d');
			// 				$variation->updated_at = date('Y-m-d H:i:s');
			// 				$variation->save();	
			// 				$variation->save();				
			// 			}
			// 		}
			// 	}
			// }

			if (isset($request->partner_edit) && $request->partner_edit == 1)		
				$food->id = $request->id;

			// FooditemsUnit::where('food_id',$food->id)->whereNotIn('id',$aSavedFoodUnitIds)->delete();

			if(!is_null($request->input('apply'))) {
				$return = 'fooditems/'.$food->id.'/edit?page=';
				
			} else {
				$return = 'fooditems/resdatas/'.$restaurant_id.'?'.time().'return='.self::returnUrl();
			}
			if($request->input('id') == '') {
				if(\Auth::user()->group_id == '3'){
					$url='fooditems/'.$food->id.'/edit';
					\AbserveHelpers::addnotification($request,$url,$user_name.' added a new Menu item');
				}
			}
			if($request->main_cat != ''){
				$product_item = \AbserveHelpers::categoryList($request->main_cat,$restaurant_id,$status='save_product');

				$shop_categories = Restaurant::find($restaurant_id,['shop_categories']);
				if(count($product_item) == 0) {
					if($shop_categories == ' ')
						Restaurant::where('id','=', $restaurant_id)->update(['shop_categories'=>\DB::raw("CONCAT(shop_categories,', ".$request->main_cat."')")]);
				}
			}
			if (isset($request->partner_edit)  && $request->partner_edit == 1)
				return Redirect::to($return)->with('messagetext', \Lang::get('core.note_success'))->with('msgstatus','success');
			else 
				return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');

		} else {

				$id = $request->input('id');
				if (isset($request->partner_edit)  && $request->partner_edit == 1)	
					return Redirect::to('fooditems/'.$id.'edit?'.time(). $this->returnUrl())->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success')
				->withErrors($validator)->withInput();
				else 
					return Redirect::to('fooditems/'.$id.'/edit?'.time(). $this->returnUrl())->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')->withErrors($validator)->withInput();
			}	
	}

	public function destroy( $request)
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');

		$this->access = $this->model->validAccess($this->info['id'] , session('gid'));
		if($this->access['is_remove'] ==0) 
			return redirect('dashboard')
		->with('message', __('core.note_restric'))->with('status','error');
		// delete multipe rows 
		if(is_array($request->input('ids')))
		{
			$this->model->destroy($request->input('ids'));
			
			\SiteHelpers::auditTrail( $request , "ID : ".implode(",",$request->input('ids'))."  , Has Been Removed Successfull");
			// redirect
			return ['message'=>__('core.note_success_delete'),'status'=>'success'];	

		} else {
			return ['message'=>__('No Item Deleted'),'status'=>'error'];				
		}
	}

	public static function display(  )
	{
		$mode  = isset($_GET['view']) ? 'view' : 'default' ;
		$model  = new Fooditems();
		$info = $model::makeInfo('fooditems');
		$data = array(
			'pageTitle'	=> 	$info['title'],
			'pageNote'	=>  $info['note']			
		);	
		if($mode == 'view')
		{
			$id = $_GET['view'];
			$row = $model::getRow($id);
			if($row)
			{
				$data['row'] =  $row;
				$data['fields'] 		=  \SiteHelpers::fieldLang($info['config']['grid']);
				$data['id'] = $id;
				return view('fooditems.public.view',$data);			
			}			
		} 
		else {

			$page = isset($_GET['page']) ? $_GET['page'] : 1;
			$params = array(
				'page'		=> $page ,
				'limit'		=>  (isset($_GET['rows']) ? filter_var($_GET['rows'],FILTER_VALIDATE_INT) : 10 ) ,
				'sort'		=> $info['key'] ,
				'order'		=> 'asc',
				'params'	=> '',
				'global'	=> 1 
			);

			$result = $model::getRows( $params );
			$data['tableGrid'] 	= $info['config']['grid'];
			$data['rowData'] 	= $result['rows'];	

			$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
			$pagination = new Paginator($result['rows'], $result['total'], $params['limit']);	
			$pagination->setPath('');
			$data['i']			= ($page * $params['limit'])- $params['limit']; 
			$data['pagination'] = $pagination;
			return view('fooditems.public.index',$data);	
		}

	}
	function store_public( $request)
	{
		
		$rules = $this->validateForm();
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$data = $this->validatePost(  $request );		
			$this->model->insertRow($data , $request->input('id'));
			return  Redirect::back()->with('message',__('core.note_success'))->with('status','success');
		} else {

			return  Redirect::back()->with('message',__('core.note_error'))->with('status','error')
			->withErrors($validator)->withInput();

		}	
	}

	public function deleteall(Request $request)
	{
		$this->hook( $request  );
		if($this->access['is_remove'] ==0) 
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		if($request->input('res_id')!= '')
		{
			$id 	= $request->input('res_id');
			Fooditems::where('restaurant_id',$id)->delete();
				//MasterShopItems::where('shop_id',$id)->delete();
			Restaurant::where('id',$id)->update(['shop_categories'=>' ']);
			return Redirect::to('fooditems')
			->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 	
		}
	}

	public function postImportfile(Request $request)
	{
		$res_id	= $request->res_name;
		$partener_id = Restaurant::find($res_id);
		$path	= $request->file('csv_file')->getRealPath();
		$dbdata	= array_map('str_getcsv', file($path));

		if (count($dbdata) > 0) {
			if ($request->has('header')) {
				$csv_header_fields = [];
				foreach ($data[0] as $key => $value) {
					$csv_header_fields[] = $key;
				}
			}
			$food_id	= '';
			foreach ($dbdata as $key => $value) {
					// $value = preg_replace('/[\x00-\x1F\x7F-\xFF]/', ' ', $value);
				if ($key>=1) {
					if($value[1] != '' && $value[2] != '' ) {
						$cat_val	= ($value[3]=='') ? 'OTHERS' : $value[3];
						$barnd_val	= ($value[4]=='') ? 'OTHERS' : $value[4];
						$category	= \AbserveHelpers::getMainCatID($cat_val);
						$brand		= \AbserveHelpers::getMainCatID($barnd_val);
				//		$master		= Masterdata::where('name',$value[1])->where('category',$category)->where('brand',$brand)->first();
						//if (!empty($master) && !empty($category) && !empty($brand)) {
							if ( !empty($category)) {
							$food	= Fooditems::where('food_item',$value[1])->where('restaurant_id',$res_id)->first();
							if (empty($food)) {
								$food = new Fooditems;
							}
							$food->restaurant_id	=	$res_id;
						//	$food->food_item		=	$master->name;
							$food->food_item		=	$value[1];
							$food->original_price	=	$value[2];
							$food->hiking			=	(isset($value[7]) && (\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)) ? $value[7] : '0'; 
							$food->price			=	$value[2];
							$food->selling_price    =	(isset($value[7]) && (\Auth::user()->group_id == 1 || \Auth::user()->group_id == 2)) ? (($value[7] > 0) ? (($value[2] * ($value[7]/100)) + $value[2]) : $value[2]) : $value[2] ; 
							$food->main_cat			=	$category;
							$food->sub_cat			=	$brand;
							$food->item_status		=	($value[5]=='1') ? 1 : 0;
							if(isset($value[9])){
							$food->adon_type		=	$value[9];
						}
							$food->approveStatus	=	'Approved';
							$food->entry_by 		= $partener_id->partner_id;
						//	$food->gst	=	(is_numeric($master->gst)==1) ? $master->gst : 0;
							if ($value[6] != '') {
								$food->image	= $value[6];
							}
							$food->strike_price		= ($food->selling_price < $value[8] && $food->selling_price > 0) ? $value[8] : 0;
							$food->save();
							$food_id	= $food->id;
							if (isset($value[9]) && $value[9] == 'variation') {
								$k=1; $ke = $key+1;
								for ($k=1; $k<=$value[10]; $k++) {
									$val		= $dbdata[$ke];
									$variation	= FooditemsVariation::where('food_id',$food_id)->where('color',$val[10])->where('unit',$val[11])->first();
									if (empty($variation)) {
										$variation	= new FooditemsVariation;
									}
									$variation->food_id			= $food_id;
									$variation->color			= $val[10];
									$variation->unit			= $val[11];
									$variation->price			= $val[12];
									$variation->selling_price	= $val[12];
									$variation->original_price	= $val[12];
									$variation->save();
									$ke++;
								}
							}
							if(isset($value[9]) && $value[9] == 'unit'){
								$k=1; $ke = $key+1;
								for($k=1; $k<=$value[10]; $k++) {
									$val	= $dbdata[$ke];
									$unit	= FooditemsUnit::where('food_id',$food_id)->where('unit',$val[10])->where('unit_type',$val[11])->first();
									if (empty($unit)) {
										$unit = new FooditemsUnit;
									}
									$unit->food_id		=	$food_id;
									$unit->unit			=	$val[10];
									$unit->unit_type	=	$val[11];
									$unit->price		=	$val[12];
									$unit->selling_price=	$val[12];
									$unit->original_price=	$val[12];
									$unit->save();
									$ke++;
								}
							}
						}
					}
				}
			}
		} else {
			return Redirect::back()->with('messagetext', 'No Appropriate Data')->with('msgstatus','error');
		}
		return redirect()->back()->with('messagetext', 'Data imported')->with('msgstatus','success');
	}

	public function getFooddelete( Request $request)
	{
		$this->hook( $request  );	
		if($this->access['is_remove'] == 0) 
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		if($request->segment(3) != '')
		{
			$id 	= $request->segment(3);
			$res_id = $request->segment(4);
			$res_exists  = $this->single_exists('abserve_restaurants','id',$res_id,'restaurant');
			if($res_exists){
				if(\Auth::user()->group_id != 1 && \Auth::user()->group_id != 5 && \Auth::user()->group_id != 2){
					$owner_check = $this->double_exists('abserve_restaurants','id,partner_id',$res_id.",".\Auth::id());
				} else {
					$owner_check = 1;
				}
				if($owner_check){
					$main_cat	= Hotelitems::select('main_cat')->where('id','=',$id)->first();
					$exists_cat	= Hotelitems::where('main_cat',$main_cat->main_cat)->where('restaurant_id',$res_id)->count();
					if ($exists_cat == 1) {
						$shop = Restaurant::find($res_id,['shop_categories']);
						if($shop->shop_categories != '') {
							$shop_cat = explode(',', $shop->shop_categories);
							if (in_array($main_cat->main_cat, $shop_cat)) {
								unset($shop_cat[array_search($main_cat->main_cat,$shop_cat)]);
								$shop_cat_imp = implode(',', $shop_cat);
								$shop = Restaurant::where('id',$res_id)->update(['shop_categories'=>$shop_cat_imp]);
							}
						}
					}
					\DB::table('abserve_hotel_items')->where('id',$id)->delete();
					\DB::table('abserve_user_cart')->where('food_id',$id)->delete();
					\SiteHelpers::auditTrail( $request , "ID : ".($id)."  , Has Been Removed Successfull");
					// redirect
					return Redirect::to('fooditems/resdatas/'.$res_id)->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success');
				} else {
					return Redirect::to('fooditems/resdatas/'.$res_id)->with('messagetext',"Sorry!.. You're not allow to access this Restaurant")->with('msgstatus','error');
				}
			} else {
				return Redirect::to('fooditems/resdatas/'.$res_id)->with('messagetext','No Such Restaurant Found')->with('msgstatus','error');
			}
		} else {
			return Redirect::to('fooditems/resdatas/'.$res_id)
			->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}
	}

	public function getPickproduct( Request $request, $res_id = null)
	{
		if ($res_id != null) {
			$data['res_id']	= $res_id;
			return view('fooditems.pickitem',$data);
		} else {
			return \Redirect::to('fooditems');
		}
	}

	public function postListproducst( Request $request)
	{
		$products	= Masterdata::where('category',$request->cat_id)->get();
		$html		= '';
		foreach($products as $key => $pro){
			if($key == 0)
				$html.='<option value="" disabled> choose products </option>';
			$html.='<option value="'.$pro->id.'">'.$pro->name.'</option>';
		}
		$response['html']	= $html;
		echo json_encode($response);
	}

	public function postInsertproducts( Request $request)
	{
		$products	= $request->products;
		$response	= app()->call('App\Http\Controllers\Api\PartnerController@insertItems',['productId' => $products,'resId' => $request->res_id,'partnerId' => \Auth::user()->id]);
		return \Redirect::to('fooditems/resdatas/'.$request->res_id);
	}

	public function postRemove( Request $request)
	{
		if($request->input('res_id')!= '')
		{
			$id 	= $request->input('res_id');
			$cartfood = Usercart::select('id','res_id','user_id','food_id','food_item')->where('res_id',$id)->get();
			if(!empty($cartfood)){
				foreach($cartfood as $k => $v ){
					$valid_food = Fooditems::where('restaurant_id',$v->res_id)->where('id',$v->food_id)->first();
					if($valid_food == null){
						Usercart::find($v->id)->delete();
					}
				}
			}
			Fooditems::where('restaurant_id',$id)->delete();
			MasterShopItems::where('shop_id',$id)->delete();
			Restaurant::where('id',$id)->update(['shop_categories'=>' ']);
			return Redirect::to('fooditems')
			->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 	
		}
	}

	public function postPhpexcelproduct(Request $request)
	{
		$data=array();
		$res_name=$request->id;
		$this->data['restaurants']=\DB::table('abserve_restaurants')->get();
		$data['item_details'] =  \DB::table('abserve_hotel_items')->select('abserve_hotel_items.*','abserve_restaurants.name as store_name','abserve_food_categories.cat_name')
		->leftjoin('abserve_food_categories','abserve_food_categories.id','=','abserve_hotel_items.main_cat')
		->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_hotel_items.restaurant_id')
		->where('abserve_hotel_items.restaurant_id',$res_name)
		->orderBy('abserve_hotel_items.id','DESC')
		->get();
			// echo "<pre>"; print_r($data);exit();
		return view('phpexcel.products_det', $data);   
	}

	public function postImportmaster(Request $request)
	{
		ini_set('memory_limit',-1);
		ini_set('max_execution_time',-1); 
		if(\Auth::user()->group_id != 1 && \Auth::user()->group_id != 2){
			return Redirect::back()->with('messagetext', 'Access Denied')->with('msgstatus','error');
		}
		$path = $request->file('csv_file')->getRealPath();
		$dbdata = array_map('str_getcsv', file($path));
		if (count($dbdata) > 0) {
			if ($request->has('header')) {
				$csv_header_fields = [];
				foreach ($data[0] as $key => $value) {
					$csv_header_fields[] = $key;
				}
			}
			$food_id='';
			foreach ($dbdata as $key => $value) {
				if($key >= 1){
					if($value[1]!='' && $value[2]!='')
					{
						$cat_val  =($value[3]=='') ? 'OTHERS' : $value[3];
						$barnd_val=($value[4]=='') ? 'OTHERS' : $value[4];
						$category = \AbserveHelpers::getMainCatID($cat_val);
						$brand    = \AbserveHelpers::getMainCatID($barnd_val);
						$master   = Masterdata::where('name',$value[1])->where('category',$category)->where('brand',$brand)->first();
						if(!empty($category) && !empty($brand))
						{
							$food = new Masterdata;
							$food->name 				=	$value[1];
							$food->price				=	$value[2];
							$food->category				=	$category;
							$food->brand				=	$brand;
							$food->gst 					=	(is_numeric($value[5])==1) ? $value[5] : 0;
							$food->status 				=	'approved';
							// $food->adon_type			=	(isset($value[9])) ? $value[9] : '';
							if($value[6]!=''){
								$images=explode(',', $value[6]);
								$target_dir = "/uploads/images/";
								$image_name=array();
								foreach ($images as $ke => $va) {
									$target_file = base_path().$target_dir . $va;
									// if (file_exists($target_file)) {
											// Store the path of source file
									$source			= base_path().'/uploads/images/'.$va; 
									$image_name[]	= $va;
									$directory		= base_path().'/uploads/images/';
									if (!(\File::exists($directory))) {
										$destinationPath= \File::makeDirectory($directory, 0777, true);
									}
									// }
								}
								$food->image	=	implode(',', $image_name);
							}
							$food->save();
							$food_id = $food->id;
							if(isset($value[9]) && $value[9]=='variation') {
								$k=1; $ke = $key+1;
								for($k=1;$k<=$value[10];$k++)
								{
									$val		= $dbdata[$ke];
									$variation	= MasterFoodVariationsData::where('food_id',$food_id)->where('unit',$val[10])->where('unit_type',$val[11])->first();
									if(empty($variation)){
										$variation = new MasterFoodVariationsData;
									}
									$variation->food_id			= $food_id;
									$variation->color			= $val[10];
									$variation->unit			= $val[11];
									$variation->price			= $val[12];
									$variation->date 			= date('Y-m-d');
									$variation->created_at 		= date('Y-m-d H:i:s');
									$variation->updated_at 		= date('Y-m-d H:i:s');
									$variation->save();
									$ke++;
								}
							}

							if(isset($value[9]) && $value[9]=='unit'){
								$k=1; $ke = $key+1;
								for($k=1;$k<=$value[10];$k++)
								{
									$val = $dbdata[$ke];
									$unit = MasterFoodUnitData::where('food_id',$food_id)->where('unit',$val[10])->where('unit_type',$val[11])->first();
									if(empty($unit)){
										$unit = new MasterFoodUnitData;
									}
									$unit->food_id 				= $food_id;
									$unit->unit 				= $val[10];
									$unit->unit_type 			= $val[11];
									$unit->price 				= $val[12];
									$unit->date 				= date('Y-m-d');
									$unit->created_at 			= date('Y-m-d H:i:s');
									$unit->updated_at 			= date('Y-m-d H:i:s');
									$unit->save();
									$ke++;
								}
							}
						} 
					}
				}
			}
		} else {
			return Redirect::back()->with('messagetext', 'No Appropriate Data')->with('msgstatus','error');
		}
		return redirect()->back();
	}

	public function double_exists($table='',$fields='',$value='')
	{
		$columns 	= explode(',', $fields);
		$data 		= explode(',', $value);
		return \DB::table($table)->where($columns[0],'=',$data[0])->where($columns[1],'=',$data[1])->exists();
	}

	public function getRemoveselected(Request $request)
	{
		$explodeid = explode(',', rtrim($request->getid,','));
		foreach ($explodeid as $key => $value) {
			$changestate = \DB::table('abserve_hotel_items')->where('id',$value)->delete();
		}exit();
		echo '1';
	}

	public function partnerdata(Request $request)
	{
		$restaurant = Restaurants::with('addons')->find($request->res_id);
		//$res['id']	= $restaurant->partner_id;
		$result	= $restaurant->addons;
		//echo "<pre>";print_r($restaurant->addons[0]->name);exit;
			
		return json_encode($result);
	}
}
