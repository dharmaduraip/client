<?php namespace App\Http\Controllers;

use App\Models\Promocode;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class PromocodeController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'promocode';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Promocode();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'promocode',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function index( Request $request )
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');
		$this->grab( $request) ;
		if($this->access['is_view'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');				
		// Render into template
		$innaugral = \DB::table('tb_settings')->select('neworder_from','neworder_to')->where('id',1)->first();		
		$this->data['innaugral']	= $innaugral;
		return view( $this->module.'.index',$this->data);
	}	

	function create( Request $request , $id =0 ) 
	{
		$this->hook( $request  );
		if($this->access['is_add'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

		$this->data['row'] = $this->model->getColumnTable( $this->info['table']); 
		
		$this->data['id'] = '';
		$curDate = date('m/d/Y');
		$row = $this->model->find($id);
		if($row)
		{
			$this->data['row'] =  $row;
			$mindate = date('m/d/Y',strtotime($row->start_date));
			$maxdate = date('m/d/Y',strtotime($row->end_date));
			$curDate = date('m/d/Y');
		} else {
			$this->data['row'] = $this->model->getColumnTable('abserve_promocode');
			$mindate = $maxdate = date('m/d/Y');
		}
		if($mindate >=$curDate || $maxdate >=$curDate || \Auth::id() ==1 )
		{
			$userlist = \DB::table('tb_users')->select('id','username','email')->where('active','1')->where('group_id',4)->get();

			$this->data['reslist']=\DB::table('abserve_restaurants')->where('admin_status','approved')->get();
			$this->data['userlist'] = $userlist;
			$this->data['mindate'] = $mindate;
			$this->data['maxdate'] = $maxdate;
			$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
			$this->data['id'] = $id;
		//This is for create coupon when refund orders.
			if(request()->segment(3) == 'refund'){
				$o_id = request()->segment(4);
				$get_order_details = \DB::table('abserve_order_details')->select('id','cust_id','grand_total')->where('id',$o_id)->get();
				$userlist = \DB::table('tb_users')->select('id','username','email')->where('id',$get_order_details[0]->cust_id)->get();
				$this->data['userlist'] = $userlist;
				$this->data['row']['user_id'] = $get_order_details[0]->cust_id;
				$this->data['row']['promo_amount'] = $get_order_details[0]->grand_total;
				$this->data['is_refund'] = 1;
				$this->data['order_id']  = $o_id;
			}
			return view('promocode.form',$this->data);
		}
		else
		{
			return Redirect::to('promocode')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}

		return view($this->module.'.form',$this->data);
	}
	function edit( Request $request , $id ) 
	{
		$this->hook( $request , $id );
		if(!isset($this->data['row']))
			return redirect($this->module)->with('message','Record Not Found !')->with('status','error');
		if($this->access['is_edit'] ==0 )
			return redirect('dashboard')->with('message',__('core.note_restric'))->with('status','error');
		$this->data['row'] = (array) $this->data['row'];

		$mindate = date('m/d/Y',strtotime($this->data['row']['start_date']));
		$maxdate = date('m/d/Y',strtotime($this->data['row']['end_date']));
		$curDate = date('m/d/Y');
		
		$this->data['id'] = $id;

		if($mindate >=$curDate || $maxdate >=$curDate || \Auth::user()->group_id ==1 ) {
			$userlist = \DB::table('tb_users')->select('id','username','email')->where('group_id',4)->get();

			$this->data['reslist']	= \DB::table('abserve_restaurants')->where('admin_status','approved')->get();
			$this->data['userlist']	= $userlist;
			$this->data['mindate']	= $mindate;
			$this->data['maxdate']	= $maxdate;
			$this->data['fields']	=  \SiteHelpers::fieldLang($this->info['config']['forms']);
			$this->data['id'] = $id;
			//This is for create coupon when refund orders.
			if(request()->segment(3) == 'refund'){
				$o_id = request()->segment(4);
				$get_order_details = \DB::table('abserve_order_details')->select('id','cust_id','grand_total')->where('id',$o_id)->get();

				$userlist = \DB::table('tb_users')->select('id','username','email')->where('id',$get_order_details[0]->cust_id)->get();
				$this->data['userlist'] = $userlist;

				$this->data['row']['user_id'] = $get_order_details[0]->cust_id;
				$this->data['row']['promo_amount'] = $get_order_details[0]->grand_total;
				$this->data['is_refund'] = 1;
				$this->data['order_id']  = $o_id;
			}
			return view($this->module.'.form',$this->data);
			// return view('promocode.form',$this->data);
		} else {
			return Redirect::to('promocode')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}

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
		$task = $request->input('action_task');
		switch ($task)
		{
			default:
			$rules = $this->validateForm();
			$validator = Validator::make($request->all(), $rules);
			if ($validator->passes()) 
			{ 
				$data = $this->validatePost( $request );
				/*if($request->hasFile('avatar')){
				$path="uploads/slider/";
				$oldImageName = $request->avatar;
				$upload = \SiteHelpers::uploadImage($request->file('avatar'),$path,$oldImageName,'');
				if($upload['success']){
					$data['avatar'] = $upload['image'];
				}
			}*/
			if($request->input('id')!=''){
				$checkPromo = \DB::table('abserve_promocode')->where('id','!=',$request->input('id'))->where('end_date','>=',date('Y-m-d'))->where('promo_code',$request->input('promo_code'))->first();
			}else{
				$checkPromo = \DB::table('abserve_promocode')->where('end_date','>=',date('Y-m-d'))->where('promo_code',$request->input('promo_code'))->first();
			}
			if($checkPromo){
				if($request->input('id')!=''){
				$id="/".$request->input('id');
				}else{
				$id='';
				}
				return Redirect::to('promocode/update'.$id)
				->with('messagetext', 'This promo code already exists')->with('msgstatus','error');
			}
			$sdate = date('Y-m-d',strtotime($request->start_date));
			$edate = date('Y-m-d',strtotime($request->end_date));
			$data['start_date'] = $sdate;
			$data['end_date'] = $edate;
			$data['promo_desc'] = $request->promo_desc;
			$data['promo_name'] = $request->promo_name;
			$data['limit_values'] = $request->limit_values;
			$data['promo_mode'] = $request->promo_mode;
			$data['ext_url'] = $request->ext_url;

				if($request->input('id') == ''){
				$data['limit_count'] = $request->limit_values;
			    }else{
				$cop = \DB::table('abserve_promocode')->where('id',$request->input('id'))->first();
				if($cop->limit_values > $data['limit_values']){
					$ll = $cop->limit_values - $data['limit_values'];
					if($cop->limit_count > $ll){
						$data['limit_count'] = $cop->limit_count - $ll;
					}else{
						$data['limit_count'] = $ll - $cop->limit_count;
					}					
				}elseif($cop->limit_values < $data['limit_values']){
					$ll = $data['limit_values'] - $cop->limit_values;
					$data['limit_count'] = $cop->limit_count + $ll;
				}
			    }		
				if($request->input('id') == ''){
				$data['created_at'] = date('Y-m-d H:i:s');
				$data['updated_at'] = date('Y-m-d H:i:s');
				// $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
				// $code = "";
				// for ($i = 0; $i < 7; $i++) {
				//     $code .= $chars[mt_rand(0, strlen($chars)-1)];
				// }
				// $data['promo_code'] = $code;
			    } else {
				$data['updated_at'] = date('Y-m-d H:i:s');
			    } 
			    if(isset($request->loc_res)){
					if($request->loc_res == 'res'){
					$data['res_id'] = implode(",",$request->resid); $data['l_id'] = 0;
				    }else{
					$data['l_id'] = implode(",",$request->locid); $data['res_id'] = 0;
				    }
				}
				$data['loc_res'] = $request->loc_res;
			    $data['usage_count']=$request->usage_count;
			    $data['max_discount']=$request->max_discount;
			    $data['promo_code']=$request->promo_code;
			    //print_r($data);exit;
				$id = $this->model->insertRow($data , $request->input( $this->info['key']));
				/* Insert logs */
				$this->model->logs($request , $id);
				if($request->has('apply'))
					// return redirect( $this->module .'/'.$id.'/edit?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');
					//return redirect( $this->module .'/create?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');

				return redirect( $this->module .'?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');
			} 
			else {

				if( $request->input(  $this->info['key'] ) =='') {
					$url = $this->module.'/create?'. $this->returnUrl();
				} else {
					$url = $this->module .'/'.$id.'/edit?'. $this->returnUrl();
				}
				return redirect( $url )
				->with('message',__('core.note_error'))->with('status','error')
				->withErrors($validator)->withInput();
			}
			break;
			case 'public':
			return $this->store_public( $request );
			break;

			case 'delete':
			$result = $this->destroy( $request );
			return redirect($this->module.'?'.$this->returnUrl())->with($result);
			break;

			case 'import':
			return $this->PostImport( $request );
			break;

			case 'copy':
			$result = $this->copy( $request );
			return redirect($this->module.'?'.$this->returnUrl())->with($result);
			break;		
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
		$model  = new Promocode();
		$info = $model::makeInfo('promocode');
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
				return view('promocode.public.view',$data);			
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
			return view('promocode.public.index',$data);	
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

	public function innaugral(Request $request){
		$req = $this->validate($request, [
			'sdate' => 'required|date',
			'edate' => 'required|date',
		]);
		$arr['neworder_from'] = $request->sdate;
		$arr['neworder_to'] = $request->edate;
		\DB::table('tb_settings')->where('id',1)->update($arr);
		return Redirect::to('promocode')->with('messagetext', \Lang::get('core.coupon_success'))->with('msgstatus','success'); 
	}
	
}
