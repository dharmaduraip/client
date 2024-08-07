<?php namespace App\Http\Controllers;

use App\Models\Misreport;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Misreportexport;


class MisreportController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'misreport';
	static $per_page	= '5';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Misreport();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'misreport',
			'return'	=> self::returnUrl()
		);
	}

	public function index( Request $request )
	{
		// Make Sure users Logged 
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');
		$request['order'] = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
		$this->grab( $request) ;
		if($this->access['is_view'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');				
		// Render into template
		return view( $this->module.'.index',$this->data);
	}	

	function create( Request $request , $id =0 ) 
	{
		$this->hook( $request  );
		if($this->access['is_add'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');

		$this->data['row'] = $this->model->getColumnTable( $this->info['table']); 
		
		$this->data['id'] = '';
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
		
		$this->data['id'] = $id;
		return view($this->module.'.form',$this->data);
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
				$id = $this->model->insertRow($data , $request->input( $this->info['key']));
				
				/* Insert logs */
				$this->model->logs($request , $id);
				if($request->has('apply'))
					return redirect( $this->module .'/'.$id.'/edit?'. $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');

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
		$model  = new Misreport();
		$info = $model::makeInfo('misreport');
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
				return view('misreport.public.view',$data);			
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
			return view('misreport.public.index',$data);	
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

	public function misreportexport(Request $request,$slug) 
	{ 	
		$request->all();
		$exporter = app()->makeWith(misreportexport::class, compact('request'));  
		return $exporter->download('misreportexport_'.date('Y-m-d').'.'.$slug);
	}

	public function postPhpexcel(Request $request){
		// $data['order_details'] = \DB::table('abserve_order_details')->select('abserve_order_details.*','abserve_restaurants.name as res_name','abserve_restaurants.location as res_address','tb_users.first_name as getuname','tb_users.email as getuemail','tb_users.phone_number as getumobile','abserve_deliveryboys.username as getboyname','abserve_restaurants.partner_code')
		// ->leftjoin('abserve_restaurants','abserve_restaurants.id','=','abserve_order_details.res_id')
		// ->leftjoin('tb_users','tb_users.id','=','abserve_order_details.cust_id')
		// ->leftjoin('abserve_orders_partner','abserve_orders_partner.orderid','=','abserve_order_details.id')
		// ->leftjoin('abserve_deliveryboys','abserve_deliveryboys.id','=','abserve_orders_partner.boy_id')
		// ->where('abserve_order_details.status','4')
		// ->orderBy('abserve_order_details.id','DESC');
		$data['order_details'] = OrderDetail::where('status','4')->orderBy('id','DESC');
		$sdate=$request->sdate;
	    $edate=$request->edate;
		
	    if($request->sdate!='' || $request->edate!='') 
	    {
	    	$from=date('Y-m-d H:i:s',strtotime($sdate.' 12:00 AM'));
	    	$to=date('Y-m-d H:i:s',strtotime($edate. '11:59 PM'));
							// DB::enableQueryLog();
	    	$data['order_details'] = $data['order_details']->wherebetween('abserve_order_details.date',[$from,$to]);
	    	//echo "<pre>";print_r($data['order_details']->get());exit();
	    }
						
						
								
		$data['order_detail'] = $data['order_details']->get();
		return view('phpexcel.index_mis', $data);   
	}

	public function getMisorder($orderid)
	{
		$data=array();
		$data['orderData']	= OrderDetail::with('accepted_order_items')->find($orderid);
		return view('misreport.mis_order', $data);  
	}

	public function postDownload(Request $request)
	{
		$data=array();
		$data['orderData']	= OrderDetail::with('accepted_order_items')->find($request->id);
		return view('phpexcel.mis_order_excel', $data);  
	}
}
