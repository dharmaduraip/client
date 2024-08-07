<?php namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Hotelitems;
use App\Models\Foodcategories;
use App\Models\Fooditems;
use App\Models\Ondeliveryorder;
use App\Models\Customerorder;
use App\Models\Paymentorder;
use App\Models\Front\Days;
use App\Models\Front\RestaurantTiming;
use App\Models\Usercart;
use App\User;
use App\Http\Controllers\Api\OrderController as apiordercontroller;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Http\Request;
use Validator, Input, Redirect , DB, DateTime, Auth ; 


class RestaurantController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'restaurant';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Restaurant();
		$this->info = $this->model->makeInfo( $this->module);
		$title	= (\Auth::id() == 1) ? 'Shops' : 'Shop' ;
		$note	= (\Auth::id() == 1) ? 'Shops details' : 'Shop detail';
		$this->data = array(
			'pageTitle'	=> 	$title,
			'pageNote'	=>  $note,
			'pageModule'=> 'restaurant',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function index( Request $request )
	{
		$this->hook( $request  );
		if($this->access['is_view'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
			return Redirect::to('dashboard')
				->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

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
		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results	= $this->model->getRows( $params , \Session::get('uid'));
		$avail		= false;
		if (\Auth::user()->group_id != 1) {
			$user = User::with('shops')->where('id',\Auth::id())->first();
			if (!empty($user->shops)) {
				$avail = true;
			}
		}

		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('restaurant');
		
		$this->data['avail']		= $avail;
		// print_r($avail);exit;
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any

		$this->data['tax']=\DB::table('tb_settings')->where('id','=',1)->first();

		$this->data['tb_users']=\DB::table('tb_users')->where('group_id','=',3)->get();
		$this->data['restaurants']=\DB::table('abserve_restaurants')->get();
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('restaurant.index',$this->data)->with('model',new Restaurant);
	}	

	function create( Request $request , $id =0 ) 
	{
		$this->hook( $request  );
		if($this->access['is_add'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

		$this->data['row'] = $this->model->getColumnTable( $this->info['table']); 
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$resTimings = \DB::table('abserve_restaurant_timings')->where('res_id',$id)->get();
			$this->data['resTimings'] = $resTimings;

		} else {

			$partners = \DB::select("SELECT `id`,`username` FROM `tb_users` WHERE `group_id` = 3 AND `active`=1");
			$this->data['partners'] = $partners; 

			$this->data['row'] = $this->model->getColumnTable('abserve_restaurants'); 
		}
		$this->data['id'] = '';
		$days = Days::all();
		$time = \DB::table('abserve_time')->select('*')->get();
		$this->data['time'] = $time;
		$this->data['days'] = $days;
		
		// $this->data['id'] = $id;
		$today=date('Y-m-d');
		$closedate=\DB::table('abserve_restaurant_unavailable_date')->select('*')->where('res_id','=',$id)->where('date','>=',$today)->get();
		if(count($closedate)>0){
			foreach($closedate as $data){
				$arr[] = date('Y-m-d',strtotime($data->date));
			}
			$this->data['closedate']= implode(",",$arr);
			$this->data['closedate1']=$arr;
			$this->data['closedate_json']=json_encode($arr);
		} else {
			$this->data['closedate']= '';
			$this->data['closedate1']=array();
			 
		}
		return view($this->module.'.form',$this->data);
	}

	function edit( Request $request , $id )
	{	

		 $this->hook( $request , $id );

	   
		if($id =='')
		{
			if($this->access['is_add'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2)
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}

        if($id !='')
		{

			if(\Auth::user()->group_id != "1" && \Auth::user()->group_id != "2"){
				if (\Auth::user()->group_id == 5) {
					$results = \DB::select("SELECT * FROM `abserve_restaurants` WHERE `id` = '".$id."'");
					
				}else{
					$results = \DB::select("SELECT * FROM `abserve_restaurants` WHERE `id` = '".$id."' AND `partner_id` = '".\Auth::user()->id."'");
				}
				if (empty($results)){
					return Redirect::to('restaurant');
				} else {
					if($this->access['is_edit'] ==0 )
						return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
				}
			} else {
				if($this->access['is_edit'] ==0 )
					return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
			}
		}				
				
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$resTimings = \DB::table('abserve_restaurant_timings')->where('res_id',$id)->get();
		//  
		// echo "<pre>";print_r($resTimings);exit();	

			$this->data['resTimings'] = $resTimings;

		} else {

			$partners = \DB::select("SELECT `id`,`username` FROM `tb_users` WHERE `group_id` = 3 AND `active`=1");
			$this->data['partners'] = $partners; 

			$this->data['row'] = $this->model->getColumnTable('abserve_restaurants'); 
		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);

		$days = Days::all();
		$time = \DB::table('abserve_time')->select('*')->get();
		$this->data['time'] = $time;
		$this->data['days'] = $days;
		
		$this->data['id'] = $id;
		$today=date('Y-m-d');
		$closedate=\DB::table('abserve_restaurant_unavailable_date')->select('*')->where('res_id','=',$id)->where('date','>=',$today)->get();
      
		if(count($closedate)>0){
			foreach($closedate as $data){
				$arr[] = date('Y-m-d',strtotime($data->date));
			}
			$this->data['closedate']= implode(",",$arr);
			$this->data['closedate1']=$arr;
			$this->data['closedate_json']=json_encode($arr);
		} else {
			$this->data['closedate']= '';
			$this->data['closedate1']=array();
			 
		}
		$this->data['cur_symbol'] = \AbserveHelpers::getBaseCurrencySymbol();
			
			
		return view('restaurant.form',$this->data);
	}
	public function Endtime(Request $request)
	{ 
		
		$time 	= \DB::table('abserve_time')->select('*')->get();
		$type = $request->type;
		if($request->timeVal != ''){
			$timeVal = explode('-', $request->timeVal);
			$checkTime = $timeVal[0];
		} else {
			$checkTime = '';
		}
		$response['checkTime'] = $checkTime;
		if($type == 'secondstart') {
			$value = $request->value;
			$seTime = explode('-',$value);
			$aTimeInfo = \DB::table('abserve_time')->select('*')->where('name',$seTime[1])->first();
			if($aTimeInfo->time == 0){
				$start_time =  $aTimeInfo->time;
			} else {
				$start_time =  $aTimeInfo->time + 30;
			}
			
			$loop = 'if';
		} else if($type == 'start') {
			$start_time = 0;
			$time = \DB::table('abserve_time')->select('*')->get();
			$loop = 'else if';
		} else {
			// $start_time 		= $request->value + 30;	
			if($request->value == '0'){
				$start_time =  $request->value;
			}else{
				$start_time =  $request->value + 30;
			}
			$loop = 'else';
		}
		$response['loop'] = $loop;
		$response['start_time'] = $start_time;
		$html 				= '';
		//$html.='<select id="endtime" name="res_time[]" class="form-field endTimeChange">';
		if($type == 'secondstart' || $type == 'start')
			$html.='<option value="" selected>Start Time</option>';
		foreach($time as $times){
			if($start_time <= $times->time){
				if($times->name == $checkTime)
					$html.='<option value="'.$times->time.'" selected>'.$times->name.'</option>';
				else 
					$html.='<option value="'.$times->time.'">'.$times->name.'</option>';
				if($start_time == $times->time)
					$endText = $times->name;
			}
		}
		// if($request->value > '0'){
		// 	$html.='<option value="0">12:00am</option>';
		// }
		//$html .= '</select>';
		$response['html'] = $html;
		$response['endText'] = $endText;
		echo json_encode($response);
	}

	public function Filltime(Request $request)
	{	

		
		$startTime = \DB::table('abserve_time')->select('*')->where('time',$request->starttime)->first();
		$endtime = \DB::table('abserve_time')->select('*')->where('time',$request->endtime)->first();
		$response['start'] = $startTime->name;
		$response['end'] = $endtime->name;
		$response['text'] = $startTime->name."-".$endtime->name;
		return json_encode($response);
	}

	public function Loadtime(Request $request)
    {
        
        $timeVal = $request->timeVal;
        if($timeVal != '') { 
            $check = explode('-', $timeVal);
            $time   = \DB::table('abserve_time')->select('*')->get();
            //For start time
            $startTime  = '';
            $checkTime = $check[0];
            $timeString = $check[0];
            if (strpos($timeString, ' ') !== false) {
                $timeString = str_replace(' ', '', $check[0]);
                $timeString = strtolower($timeString);
                $timeString = $this->roundTime($timeString);
                $timeString = ltrim($timeString, '0');
            }

            foreach($time as $times){
                if($startTime <= $times->time){
                    if($times->name == $timeString)
                        $startTime.='<option value="'.$times->time.'" selected>'.$times->name.'</option>';
                    else 
                        $startTime.='<option value="'.$times->time.'">'.$times->name.'</option>';
                }
            }
            //For End time
            $endTime    = '';
            $checkTime = $check[1];
            if (strpos($checkTime, ' ') !== false) {
                $checkTime = str_replace(' ', '', $check[1]);
                $checkTime = strtolower($checkTime);
                $checkTime = $this->roundTime($checkTime);
            }
            $aTimeInfo = \DB::table('abserve_time')->select('*')->where('name',$timeString)->first();
            if($timeString == '12:00am'){
                $start_time =  $aTimeInfo->time;
            }else{
                $start_time =  $aTimeInfo->time + 30;
            }
            
            foreach($time as $times){
                if($start_time <= $times->time){
                    if($times->name == $checkTime)
                        $endTime.='<option value="'.$times->time.'" selected>'.$times->name.'</option>';
                    else 
                        $endTime.='<option value="'.$times->time.'">'.$times->name.'</option>';
                }
            }
            /*if($timeString != '12:00am'){
                $endTime.='<option value="0" selected>12:00am</option>';
            }*/
            $msg = "success";
            $response['startTime']  = $startTime;
            $response['endTime']    = $endTime;
        } else {
            $msg = "fail";
        }
        $response['msg'] = $msg;

        return json_encode($response);
    }

    function roundTime($time) {
    	$period = substr($time, -2);
	    list($hour, $minute) = explode(':', $time);
	    $hour = intval($hour);
	    $minute = intval($minute);
	    if ($minute <= 30) {
	        $minute = 30;
	    } else {
	        $hour++;
	        $minute = 0;
	    }
	    $roundedTime = sprintf("%02d:%02d", $hour, $minute);
	    return $roundedTime.$period;
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
	{ 
	 $group_id =\Auth::user()->group_id;
	 $user_name=\Auth::user()->username;
		if (isset($_REQUEST['call_handling']) && $_REQUEST['call_handling'] != '') {
			$_REQUEST['call_handling'] = '1';
		} else {
			$_REQUEST['call_handling'] = '0';
		}
         
        //$rules = $this->validateForm();
        // $rules['restaurant_image']	='required';
        // $rules['free_delivery'] = 'required';
        // if($request->free_delivery != 1){
        // 	$rules['delivery_charge'] = 'required';
        // }
        // $rules['service_tax1'] = 'required|numeric|min:0|max:100';
        // $rules['service_tax2'] = 'required|numeric|min:0|max:100';
		if($_REQUEST['location'] != ''){
			// $data = $this->getLatlan($_REQUEST['location']);
		}
		if($request->gst_applicable == 'yes'){
			$rules['service_tax1'] = 'required|numeric';
			// $rules['gst'] = 'required|numeric';
		}
		$rules['service_tax'] = '';
		$rules['budget']='';
		$rules['delivery_time']='';
		$validator = Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$_REQUEST['cuisine']	= implode(',', $_REQUEST['cuisine']);
			if($_REQUEST['latitude'] == '' || $_REQUEST['longitude'] == '' || $_REQUEST['latitude'] == 0 || $_REQUEST['longitude'] == 0){
				$validator->getMessageBag()->add('location', 'Enter valid Address!');
				return Redirect::to('restaurant/update/'.$_REQUEST['id'])->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
				->withErrors($validator)->withInput();
			} else {

				// $delCharge = ($_REQUEST['free_delivery'] == 1) ? 0 : $_REQUEST['delivery_charge'];
				
				
				// $partner_id = (\Auth::user()->p_active != '') ?  (\Auth::user()->id) :  $_REQUEST['partner_id'] ;
				$partner_id = (\Auth::user()->group_id == 3) ?  (\Auth::user()->id) :  $_REQUEST['partner_id'] ;
				if($_REQUEST['mode']=='open'){
					$mode_filter='1';
				}else{
					$mode_filter='2';
				}
				$deliver_status = (isset($request->deliver_status)) ? implode(',', str_replace("delivery","deliver",$request->deliver_status)) : 'deliver';
				$values = array(
					"name"			=> $_REQUEST['name'],
					"location"		=> $_REQUEST['location'],
					"partner_id"	=> $partner_id,
					"res_desc"		=> (isset($request->res_desc)) ? $request->res_desc : '',
					"deliver_status"=> $deliver_status,
					"preoder"=> $_REQUEST['preoder'],
					"entry_by"		=> $partner_id,
					// "l_id"			=> $_REQUEST['l_id'],
					//"opening_time"	=> $_REQUEST['opening_time'],
					//"closing_time"	=> $_REQUEST['closing_time'],
					"phone"			=> $_REQUEST['phone'],
					//"service_tax1"	=> isset($_REQUEST['service_tax1']) ? $_REQUEST['service_tax1']: 0,
					"gst_applicable"	=> $_REQUEST['gst_applicable'],
					// "gst"	=> $_REQUEST['gst_applicable'] == 'no' ? 0  : $_REQUEST['gst'] ,
					"service_tax1"	=> $_REQUEST['gst_applicable'] == 'no' ? 0 : $_REQUEST['service_tax1'],
					// "service_tax2"	=> $_REQUEST['service_tax2'],
					// "free_delivery" => $_REQUEST['free_delivery'],
					// "delivery_charge"	=> $delCharge,
					//"vat"			=> $_REQUEST['vat'],
					"delivery_time"	=> isset($_REQUEST['delivery_time']) ? $_REQUEST['delivery_time']: 0,
					"offer"			=> $_REQUEST['offer'],
					"budget"		=> isset($_REQUEST['budget']) ? $_REQUEST['budget']: 0,
					// "logo"			=> $image,
					"cuisine"		=> $_REQUEST['cuisine'],
					"latitude"		=> $_REQUEST/*data*/['latitude'],
					"longitude"		=> $_REQUEST/*data*/['longitude'],
					"call_handling"	=> 0,//$_REQUEST['call_handling'],
					// "status"        => /*$_REQUEST['status'],*/0
					"flatno" 			=> $_REQUEST['flatno'],
					"adrs_line_1" 		=> $_REQUEST['adrs_line1'],
					"adrs_line_2" 		=> $_REQUEST['adrs_line2'],
					"sub_loc_level_1" 	=> $_REQUEST['sub_loc_level'],
					"city" 				=> $_REQUEST['city'],
					"state" 			=> $_REQUEST['state'],
					"country" 			=> $_REQUEST['country'],
					"zipcode" 			=> $_REQUEST['zipcode'],
					// "ordering" 			=> $_REQUEST['ordering'],
					// "tagline" 			=> $_REQUEST['tagline'],
					"partner_code"		=> $_REQUEST['partner_code'],
					"mode"				=> $_REQUEST['mode'],
					"mode_filter"		=> $mode_filter,
					"restaurant_cat"    => $request->restaurant_cat,
					
				);
				if($group_id == 1 || $group_id == 2)
					{
						$values["commission"]=isset($_REQUEST['commission']) ? $_REQUEST['commission'] : 0;
						$values["delivery_charge"]=isset($_REQUEST['delivery_charge']) ? $_REQUEST['delivery_charge'] : '';
						$values["delivery_limit"]=isset($_REQUEST['delivery_limit']) ? $_REQUEST['delivery_limit'] : '';
						$values["minimum_order"]=isset($_REQUEST['minimum_order']) ? $_REQUEST['minimum_order'] : '';
						$values["free_delivery"]=isset($_REQUEST['free_delivery']) ? $_REQUEST['free_delivery'] : '';
						
					}
				//echo "<pre>";
				//print_r($values);exit;
				if(!is_null($_REQUEST['restaurant_image']) && $_REQUEST['restaurant_image']!=''){
					$data = $_REQUEST['restaurant_image'];                                        
                    list($type, $data) = explode(';', $data);
                    list(, $data)      = explode(',', $data);
                    list(, $img_type)      = explode('/', $type);
                    $name = time().'-'.rand(1000,100).'.'.$img_type;                    
                    $data = base64_decode($data);                    
                    file_put_contents(base_path()."/uploads/restaurants/".$name, $data);                                        
                    $values['logo']=$name;

                    $compress = \AbserveHelpers::urlimg_compress(base_path()."/uploads/restaurants/".$name);

                    $check = \DB::table('abserve_restaurants')->select('logo')->where('id',$_REQUEST['id'])->first();
                //    if(count($check) > 0 && $check->logo != ""){
                    	 if(!empty($check) > 0 && $check->logo != ""){
                        $dir1    = 'uploads/restaurants/'.$check->logo;
                        if(file_exists($dir1))
                            unlink($dir1); 
                    }
					$values['logo']=$name;
				}

				$values['status']=$request->input('res_status');
				$partnerInfo =  \DB::table('tb_users')->select('email')->where('id',$partner_id)->first();
				if($request->input('id') == ''){
					if($group_id == 1 || $group_id == 2 )
					{
						$values['admin_status'] = 'approved';	
                     	$id = \DB::table('abserve_restaurants')->insertGetId($values);
                     	$emailMsg = "Your restaurant got approved, please go to site and start listing the menu for your restaurant";
					}
					
					else
					{
						$values['admin_status'] = 'waiting';
						$id = \DB::table('abserve_restaurants')->insertGetId($values);
						$emailMsg = "Your restaurant is under reviewing and once admin approved will inform you";

						$emailMsg1 = "Restaurant has been waiting for your approval";


						$from = CNF_EMAIL;
						$admininfo =  \DB::table('tb_users')->select('email')->where('id','1')->first();
						$dataVal['emailMsg'] = $emailMsg1;
						$dataVal['partnerInfo'] = $admininfo;
						$dataVal['name'] = $_REQUEST['name'];
						$subject = 'One new restaurant created';
						// \Mail::send('restaurant.emails.res_status',$dataVal,function($message) use ($to,$dataVal,$subject,$from) {
						// 	$message->to(CNF_EMAIL)->subject($subject);
						// 	$message->from($from);
						// });

					}
					
					$from = CNF_EMAIL;
					$to = $partnerInfo->email;
					$dataVal['emailMsg'] = $emailMsg;
					$dataVal['partnerInfo'] = $partnerInfo;
					$dataVal['name'] = $_REQUEST['name'];
					$subject = 'Restaurant status';
					// \Mail::send('restaurant.emails.res_status',$dataVal,function($message) use ($to,$dataVal,$subject,$from) {
					// 	$message->to($to)->subject($subject);
					// 	$message->from($from);
					// });				
				} 
				else {
					
					$image = \DB::select("SELECT `logo`,`admin_status` FROM `abserve_restaurants` WHERE `id` = ".$_REQUEST['id']);					
                    $values['admin_status'] = $image[0]->admin_status;
					if($group_id == 1 || $group_id == 2)
					{
						$values['admin_status'] = $request->input('adminstatus');
						$values['ordering'] = $request->input('ordering'); 
					}
                    if($values['admin_status'] == 'rejected' && \Auth::user()->p_active != 0 ) {
						$values['admin_status'] = 'waiting';
                    	$values['rejectreason'] = '';
                    	$updated = \DB::table('abserve_restaurants')->where('id','=',$request->input('id'))->update($values);

                    } else {
	                    // $values['commission']=$request->input('commission');
						$updated = \DB::table('abserve_restaurants')->where('id','=',$request->input('id'))->update($values);
					}
					$id = $request->input('id');
					$status=\DB::table('abserve_restaurants')->where('id','=',$request->input('id'))->where('status','<>',1)->first();
					if(isset($status) && !empty($status)){
						\DB::table('abserve_user_cart')->select('*')->where('res_id','=',$request->input('id'))->delete();	
					}
					
					//Meena Code start
					if($image[0]->admin_status != $values['admin_status']){
						if($values['admin_status'] == 'approved' ) {
	                     	$emailMsg = "Your restaurant got approved, please go to site and start listing the menu for your restaurant";
						} else {
							$emailMsg = "Your restaurant is under reviewing and once admin approved will inform you";
						}
						$from = CNF_EMAIL;
						$to = $partnerInfo->email;
						$subject = 'Restaurant status';
						$dataVal['emailMsg'] = $emailMsg;
						$dataVal['partnerInfo'] = $partnerInfo;
						$dataVal['name'] = $_REQUEST['name'];
						// \Mail::send('restaurant.emails.res_status',$dataVal,function($message) use ($to,$dataVal,$subject,$from) {
						// 	$message->to($to)->subject($subject);
						// 	$message->from($from);
						// });
					}
					//Meena Code end
				}

				$today=date('Y-m-d');
				$checkeddate = \DB::table('abserve_restaurant_unavailable_date')->select('*')->where('res_id',$request->input('id'))->where('date','>=',$today)->get();
				if(count($checkeddate) > 0 && $request->input('id') != ''){
					\DB::table('abserve_restaurant_unavailable_date')->where('res_id',$request->input('id'))->delete();
				}
				if($request->choosedate!=''){
					$var_date =explode(',', $request->choosedate);
					foreach ($var_date as $key => $value) {
						$val['res_id']= $id;
						$val['date'] =$value;
						$update =   \DB::table('abserve_restaurant_unavailable_date')->insert($val);
					}
				}

				// resaurant timing services start
				$days = Days::all();
				$time = \DB::table('abserve_time')->select('*')->get();

				foreach ($days as $value) {
					$day_status = ($request->input('day_'.$value->id) != '') ? 1 : 0 ;
					$entryBy = (\Auth::user()->group_id == 1 || $group_id == 2) ? 'admin' : 'partner';
					$firsttime = ($request->input('resTime_'.$value->id.'_1') != '') ? explode('-', $request->input('resTime_'.$value->id.'_1')) : '';
					$secondtime = ($request->input('resTime_'.$value->id.'_2') != '') ? explode('-', $request->input('resTime_'.$value->id.'_2')) : '';
					$aExistTime = \DB::table('abserve_restaurant_timings')->where('res_id',$id)->where('day_id',$value->id)->first();
					if(isset($aExistTime) && !empty($aExistTime)){
						$timeId = $aExistTime->id;
						$resTime = RestaurantTiming::find($timeId);
						$resTime->updated_at 	= date('Y-m-d H:i:s');
					}else{
						$resTime = new RestaurantTiming;
						$resTime->res_id 		= $id;
						$resTime->day_id 		= $value->id;
						$resTime->created_at 	= date('Y-m-d H:i:s');
						$resTime->updated_at 	= date('Y-m-d H:i:s');
					}
					$resTime->start_time1 	= ($firsttime != '') ? $firsttime[0] : '';
					$resTime->end_time1 	= ($firsttime != '') ? $firsttime[1] : '';
					$resTime->start_time2 	= ($secondtime != '') ? $secondtime[0] : '';
					$resTime->end_time2 	= ($secondtime != '') ? $secondtime[1] : '';
					$resTime->day_status 	= $day_status;
					$resTime->entry_by 		= $entryBy;
					$resTime->save();
				}
				$files='';
				// $id = $this->model->insertRow($data , $request->input('id'));
				if(isset($_REQUEST['image']))
				{
					// $destinationPath = '.'. $f['option']['path_to_upload'];
					$dir	= 'uploads/restaurants/';
					$directory	= base_path().'/uploads/restaurants/';
					// dd($directory);
					if (!(\File::exists($directory))) {
						$destinationPath = \File::makeDirectory($directory, 0777, true);
					}
					$destinationPath = $directory;
					foreach($_FILES['image']['tmp_name'] as $key => $tmp_name ){
					 	$org_name	= $_FILES['image']['name'][$key];
						// $exp		= explode(".",$org_name);
						$ext		= pathinfo($org_name, PATHINFO_EXTENSION);
					 	$file_name	= time()."-".rand(10,100).$key.'.'.$ext;
						$file_tmp	= $_FILES['image']['tmp_name'][$key];
						if($file_name !=''){
							$upload = move_uploaded_file($file_tmp,$destinationPath.$file_name);
							$files .= /*$dir.*/$file_name.',';

							$compress = \SiteHelpers::urlimg_compress($destinationPath.$file_name);

						}
					}
					// if($files !='')	$files = substr($files,0,strlen($files)-1);
				}
				if($request->image_old !== null && count($request->image_old)>0){
					$oldImgF=implode(",", $request->image_old);
				}else{
					$oldImgF='';
				}

				if($oldImgF!='' ){
					if(rtrim($files,',')!=''){
						$imgF=$oldImgF.",".rtrim($files,',');
					}else{
						$imgF=$oldImgF;
					}

				}else{
					if(rtrim($files,',')!=''){
						$imgF=rtrim($files,',');
					}else{
						$imgF='';
					}
				}

				$values['banner_image']= $imgF;
				\DB::table('abserve_restaurants')->where('id',$id)->update($values);
				apiordercontroller::RestaurantStatusUpdate($id);
				// resaurant timing services end
				if(!is_null($request->input('apply')))
				{
					$return = 'restaurant/update/'.$id.'?return='.self::returnUrl();
				} else {
					$return = 'restaurant?return='.self::returnUrl();
				}

				// Insert logs into database
				if($request->input('id') =='')
				{
					\SiteHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
					$url='restaurant/'.$id.'/edit';
					if(\Auth::user()->p_active != '0'){
						\AbserveHelpers::addnotification($request,$url,$user_name.' added a new restaurant');
					}
				} else {
					\SiteHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
				}
				/*if($request->gst_applicable=="yes")
				{
			 		\DB::table('abserve_hotel_items')->where('restaurant_id',$id)->update(['gst'=>0]); 
                }*/
				return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
			}
			
		} else {
			$id = $request->input('id');
			$return = 'restaurant/'.$id.'/edit?return='.self::returnUrl();		
			// if($request->restaurant_image != ''){
			// 	$request['restaurant_image'] = '';
			// }		

			return Redirect::to($return)->with('messagetext','error')->with('msgstatus','error')->withErrors($validator)->withInput();

		}	
	}	

	public function destroy( $request)
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');

		$this->access = $this->model->validAccess($this->info['id'] , session('gid'));
		if($this->access['is_remove'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
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
		$model  = new Restaurant();
		$info = $model::makeInfo('restaurant');
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
				return view('restaurant.public.view',$data);			
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
			return view('restaurant.public.index',$data);	
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
	public function getCategory($id)
	{
		$cate_list_shop = '';
		$shop_cate 		=\DB::table('abserve_restaurants')->select('shop_categories')->where('id',$id)->first();
		$cate_list	= [];
		$catString	= [];
		$main_cat	= Hotelitems::select(\DB::raw('GROUP_CONCAT(DISTINCT(main_cat)) as categories'))->where('restaurant_id',$id)->get();
		if(count($main_cat) > 0) {
			if($main_cat[0]->categories != '') {
				$cate_list_shop	= Foodcategories::select('id','cat_name')->whereIn('id',explode(',',$main_cat[0]->categories))->get();
			}
		}
		if (!empty($shop_cate->shop_categories)) {
			$catString = $shop_cate->shop_categories;
		}
		if (!empty($catString) && trim($catString) != '') {
			$cate_list_shop	= Foodcategories::select('*')->whereIn('id',explode(",",$catString))->orderByRaw('FIELD(id,'.$catString.')')->get();
		}	
		if ($cate_list_shop != '') {
			return view('restaurant.category',compact('cate_list_shop'));
		}

		return  Redirect::to('fooditems')->with('messagetext','Please upload the products')->with('msgstatus','error');
	}

	public function getResdelete(Request $request)
	{
		$this->hook( $request  );
		if($this->access['is_remove'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');
		
		if($request->segment(3) != '')
		{
			$id = $request->segment(3);
			\DB::table('abserve_restaurants')->where('id',$id)->update(['status' => '3']);
			\DB::table('abserve_hotel_items')->where('restaurant_id',$id)->update(['del_status' => '1']);
			\DB::table('abserve_user_cart')->where('res_id',$id)->delete();
			return Redirect::to('restaurant')
			->with('messagetext', \Lang::get('core.note_success_delete'))->with('msgstatus','success'); 
		} else {
			return Redirect::to('restaurant')
			->with('messagetext','No Item Deleted')->with('msgstatus','error');				
		}
	}

	public function restaurant_feature(Request $request )
	{
		/*$this->hook( $request  );
		if($this->access['is_view'] ==0 || \Auth::user()->p_active != '1' && \Auth::user()->group_id != 1 && \Auth::user()->group_id != 2) 
			return Redirect::to('dashboard')
		->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
		// End Filter sort and order for query 
		// Filter Search for query		
		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

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

		$filter .= " AND abserve_restaurants.status != '3' AND abserve_restaurants.ordering = '1'";		
		// echo $filter;die();
		$page = $request->input('page', 1);
		$params = array(
			'page'		=> $page ,
			'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
			'sort'		=> $sort ,
			'order'		=> $order,
			'params'	=> $filter,
			'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		);
		// Get Query 
		$results = $this->model->getRows( $params );

		$results['rows'] = \DB::select("select r.id,r.name,r.logo,r.admin_status,r.ordering,u.username as partner_name,u.phone_number from abserve_restaurants r left join tb_users u on u.id=r.partner_id");
 

		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('restaurant');
		
		$this->data['rowData']		= $results['rows'];
		// Build Pagination 
		$this->data['pagination']	= $pagination;
		// Build pager number and append current param GET
		$this->data['pager'] 		= $this->injectPaginate();	
		// Row grid Number 
		$this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// Grid Configuration 
		$this->data['tableGrid'] 	= $this->info['config']['grid'];
		$this->data['tableForm'] 	= $this->info['config']['forms'];
		$this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// Group users permission
		$this->data['access']		= $this->access;
		// Detail from master if any

		$this->data['tax']=\DB::table('tb_settings')->where('id','=',1)->first();

		$this->data['tb_users']=\DB::table('tb_users')->where('group_id','=',3)->get();
		$this->data['restaurants']=\DB::table('abserve_restaurants')->get();
		
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		$this->data['pageTitle'] = "Feature Restaurant";*///echo "<pre>";print_r($this->data);echo "</pre>"; die;
		$this->data['pagination'] = \DB::table('abserve_restaurants as r')
		    ->leftJoin('tb_users as u', 'u.id', '=', 'r.partner_id')
		    ->where('r.ordering', '1')
		    ->select('r.id', 'r.name', 'r.logo', 'r.admin_status', 'r.ordering', 'u.username as partner_name', 'u.phone_number')
		    ->paginate(10);
	    $this->data['restaurants']=\DB::table('abserve_restaurants')->where('ordering', '!=', '1')->get();
	    $this->data['pager'] = 10;
		return view('restaurant.feature',$this->data)->with('model',new Restaurant);
	}
		public function change_feature($id,$mode){
		$change = \DB::update("Update abserve_restaurants set ordering=".$mode." where id in (".$id.")" );
		if($change){
			if($mode == 1)
				$msg = "Featured Restaurant ID(".$id.") Enabled";
			else
				$msg = "Featured Restaurant ID(".$id.")  Disabled";
			return Redirect::to('restaurant/feature')->with('msg',$msg);
		}
		else{
			$error = "Error";
			return Redirect::to('restaurant/feature')->with('msg',$msg)->with('error',$error);
		}
		
	}
	public function bulk_change_feature(Request $request)
	{

		if( $request->input('feature_ckbox') != ''){
			$ids = implode(', ', $request->input('feature_ckbox') );  
			$mode = $request->input('upd_hid');
			return $this->change_feature($ids,$mode);
		}else{
			return Redirect::to('restaurant/feature')->with('error',"Please select any restaurant");
		}
	}

	public function onlinepaycommision(Request $request)
	{

		// $tax= $request->tax;
		// $festival_charge= $request->festival_charge;
		// $bad_weather_charge= $request->bad_weather_charge;
		// $delivery_tax= $request->delivery_tax;
		// $delivery_boy_charge_per_km= $request->delivery_boy_charge_per_km;

		//echo "<pre>";print_r($request);exit();
		
		\DB::table('tb_settings')->where('id',1)->update([
			'tax'				=> 0,
			'km'				=> $request->km,
			'upto_four_km'		=> $request->upto_four_km,
			'per_km'			=> $request->per_km,
			'delivery_tax'		=> $request->delivery_tax ,
			'bad_weather_charge'=> $request->bad_weather_charge ,
			'festival_charge'	=> $request->festival_charge,
			'p_delivery_boy'	=> 0,
			'p_admin'			=> 0,
			'u_delivery_boy'	=> 0,
			'u_admin'			=> 0,
			'min_night'			=> 0,
			'delivery_boy_charge_per_km'=>$request->delivery_boy_charge_per_km
		]);

		return Redirect::to('deliverychargesettings');	

	}

	function postSavecategory($id, Request $request)
	{
		$rules = array(
			'reorder'	=> 'required'
			);
		$validator 		= Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$menus 		= json_decode($request->input('reorder'),true);
			$a=0;
			foreach($menus as $m) {
				$cat_ids[] = $m['id'];
			}
			$imp=implode(', ', $cat_ids);
			\DB::table('abserve_restaurants')->where('id','=', $id)
			->update(array('shop_categories'=> $imp,'ordering'=>$a));
			return Redirect::to('restaurant/category/'.$id)
			->with('messagetext', 'Data Has Been Save Successfull')->with('msgstatus','success');
			$a++;	
		} else {
			
			return Redirect::to('restaurant/category/'.$id)
			->with('messagetext', 'The following errors occurred')->with('msgstatus','error');
		}
	}

	function getresOffer($id)
	{
		$currentDay = date('Y-m-d');
		// show the restaurant offer details from promocode table
		// promo name consider to offer name
		$res_id = $id;
		$res_off = \DB::table('abserve_promocode')->where('res_id', $id)->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->where('created_by', 'restaurant')->get();
		return view('restaurant.offer', compact('res_off', 'res_id'));
	}

	function createresOffer(Request $request, $id)
	{
		$res_id = $id;
		return view('restaurant.offercreate', compact('res_id'));
	}

	function poststoreresOffer(Request $request)
	{
		if(\Auth::user()->group_id == 1 || \Auth::user()->group_id == '1'){
			$create = 'admin';
		}elseif(\Auth::user()->group_id == 3 || \Auth::user()->group_id == '3'){
			$create = 'restaurant';
		}
		$id = $request->id;
		if($id == ''){
			$offer = \DB::table('abserve_promocode')->insert([
				'promo_name'      => $request->offer_name,
				'promo_desc'      => $request->offer_desc,
				'start_date'      => $request->s_date,
				'end_date'        => $request->e_date,
				'promo_type'      => $request->promo_type,
				'created_by'      => 'restaurant',
				'promo_mode'      => $request->offer_mode,
				'res_id'          => $request->res_id,
				'promo_amount'    => $request->offer_amt,
				'min_order_value' => $request->min_order_value,
				'promo_code'      => $request->promo_code
			]);
		}elseif($id != ''){
			$offer = \DB::table('abserve_promocode')->where('id', $id)->update([
				'promo_name'      => $request->offer_name,
				'promo_desc'      => $request->offer_desc,
				'start_date'      => $request->s_date,
				'end_date'        => $request->e_date,
				'promo_type'      => $request->promo_type,
				'created_by'      => 'restaurant',
				'promo_mode'      => $request->offer_mode,
				'res_id'          => $request->res_id,
				'promo_amount'    => $request->offer_amt,
				'min_order_value' => $request->min_order_value,
				'promo_code'      => $request->promo_code
			]);
		}
		$currentDay = date('Y-m-d');
		$res_id = $request->res_id;
		$res_off = \DB::table('abserve_promocode')/*->whereRaw('FIND_IN_SET('.$id.',`res_id`)')*/->where('res_id', $res_id)->where('start_date', '<=', $currentDay)->where('end_date', '>=', $currentDay)->get();
		return Redirect::to('restaurant/resOffer/'.$res_id)
			->with('messagetext', 'Data Has Been Save Successfull')->with('msgstatus','success');
	}

	public function editresOffer(Request $request)
	{
		$id = $request->id;
		$offer = \DB::table('abserve_promocode')->where('id', $id)->first();
		return view('restaurant.offeredit', compact('offer'));
	}
	public function editnon_feat(Request $request)
	{
		return Redirect::to('restaurant/'.$request->id.'/edit/')
			->with('messagetext', 'Data Has Been Save Successfull')->with('msgstatus','success');
	}
}
