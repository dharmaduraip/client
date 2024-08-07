<?php namespace App\Http\Controllers;

use App\Models\Partners;
use App\Models\Partnerrequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 

class PartnersController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'partners';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Partners();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'partners',
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
		$this->data['r'] = $this->data['i'];		
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
		$id = $request->id;
		$task = $request->input('action_task');
		switch ($task)
		{
			default:
				$rules = $this->validateForm();
				$rules['phone_number'] = 'required|numeric|digits:10|not_in:0|unique:tb_users,phone_number';
				$rules['email'] 	   = 'required|email';
				$validator = Validator::make($request->all(), $rules);
				if ($validator->passes()) 
				{
					$data = $this->validatePost( $request );
					if($id == ''){
						$data['group_id'] = '3';
					}
					$id = $this->model->insertRow($data , $request->input( $this->info['key']));
					/* Insert logs */
					$this->model->logs($request , $id);
					if($request->has('apply'))
						return redirect( $this->module .'/'.$id.'/edit?'.time(). $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');

					return redirect( $this->module .'?'.time(). $this->returnUrl() )->with('message',__('core.note_success'))->with('status','success');
				} 
				else {
					if( $request->input(  $this->info['key'] ) =='') {
						$url = $this->module.'/create?'. $this->returnUrl();
					} else {
						$url = $this->module .'/'.$id.'/edit?'. $this->returnUrl();
					}
					/*return redirect( $url )
							->with('message',__('core.note_error'))->with('status','error')
							->withErrors($validator)->withInput();*/
					return back()->with('message',__('core.note_error'))->with('status','error')->withErrors($validator)->withInput();			

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
		$model  = new Partners();
		$info = $model::makeInfo('partners');
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
				return view('partners.public.view',$data);			
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
			return view('partners.public.index',$data);	
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

	public function getBlockpartner(Request $request)
	{
		
		$explodeid = explode(',', rtrim($request->getid,','));
		$update['active'] = '3';
		foreach ($explodeid as $key => $value) {
			$changestate = \DB::table('tb_users')->where('id',$value)->update($update);
		}
		echo '1';
	}
	public function getDeletepartner(Request $request)
	{
		
		$explodeid = explode(',', rtrim($request->getid,','));
		foreach ($explodeid as $key => $value) {
			\DB::table('tb_users')->where('id',$value)->delete();
			\DB::table('tb_partner_accounts')->where('partner_id',$value)->delete();

			if(SOCKET_ACTION == 'true'){
				require_once SOCKET_PATH;
				$aData = array(
					'partner_id' => $value
				);
				$client->emit('partner delete', $aData);
			}	
		}
		echo '1';
	}
	public function sendPartnerRequest( Request $request)
	 {
		$rules['name']          	= 'required';
		$rules['address']         	= 'required';
		$rules['email']     		= 'required|email';
		$rules['shop_name']         = 'required';
		$rules['contact_number']    = 'required|numeric';
		$rules['category']          = 'required';
		$rules['message']    		= 'required';
		$validator = Validator::make($request->all(), $rules);	
		if ($validator->fails()){
		 return Redirect::to('partner-with-us')->withErrors($validator);
		}
		else
		{
			$category 	= implode(',', $request->category);
			$partner_req = new PartnerRequest;
			$partner_req->name 				= $request->name;
			$partner_req->address			= $request->address;
			$partner_req->email				= $request->email;
			$partner_req->shop_name 		= $request->shop_name;
			$partner_req->contact_number 	= $request->contact_number;
			$partner_req->category 			= $category;
			$partner_req->message 			= $request->message;
			$partner_req->save();
			
			$to 					= $request->email;
			$from 					= env('MAIL_FROM_ADDRESS');
			$subject 				= "Website Partner Registration";
			$data['name'] 			= $request->name;
			$data['subject']		= $subject;
			$data['shop_name']		= $request->shop_name;
			$data['address'] 		= $request->address;
			$data['contact_number'] = $request->contact_number;
			$data['category']		= $category;
			$data['message'] 		= $request->message;
			$html = (String) view('emails.partnerwith',$data);
			//$mailsent= ecmail("suriyanarayanan.s@abserve.tech",$subject,$html);
			return Redirect::to('partner-with-us')->with('message', \AbserveHelpers::alert('success','Thank You , Your message has been sent !'));	
		}
	}


	public function partnercreation(Request $request){

		$rules['business_name']     = 'required';
		$rules['business_addr'] 	= 'required';
		$rules['ifsc_code'] 		= 'required';
		$rules['aadhar_no'] 		= 'required|min:12|max:12';
		$rules['fssai_no'] 			= 'required|min:14|max:14';
		$rules['pan_no'] 			= 'required|min:10|max:10';
		$rules['gst_no'] 			= 'required|min:15|max:15';
		$rules['Bank_Name'] 		= 'required';
		$rules['Bank_AccName'] 		= 'required';
		$rules['Bank_AccNumber'] 	= 'required';
		$this->validateDatas($request->all(),$rules);
		$bankFields = ['Bank_Name','Bank_AccName','Bank_AccNumber','ifsc_code','aadhar_no','gst_no','fssai_no','pan_no'];
		foreach ($bankFields as $key => $value) {
			$bank[$value] = $request->{$value};
		}
		$user = \Auth::user();
		$user->p_active = '1';
		$user->business_name = $request->business_name;
		$user->business_addr = $request->business_addr;
		$user->save();
		$bank['partner_id']	= $user->id;
		\DB::table('tb_partner_accounts')->insert($bank);
		return Redirect::to('restaurant/create')->with('message', 'success');
	}
}
