<?php namespace App\Http\Controllers;

use App\Models\Accountdetails;
use App\Models\Accountdetailsboy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class AccountdetailsController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'accountdetails';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Accountdetails();
		$this->model1 = new Accountdetailsboy();	
		$this->info = $this->model->makeInfo( $this->module);	
		$this->access = $this->model->validAccess($this->info['id']);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'accountdetails',
			'pageModule_1'=> 'deliveryboy',
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
	function edit( Request $request , $id = null) 
	{
		$this->hook( $request , $id );
		if($id =='')
		{
			if($this->access['is_add'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}	
		if($id !='')
		{
			if($this->access['is_edit'] ==0 )
			return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}				
		if($_GET['type']=='part') {

			$row=\DB::table('tb_partner_accounts')->where('partner_id',$id)->first();
			if(!$row){
				$this->data['partner_id']=$id;
			}
		} else {
			$row=\DB::table('tb_partner_accounts')->where('del_boy_id',$id)->first();
			if(!$row){
				$this->data['del_boy_id']=$id;
			}
		}
		if($row)
		{
			$this->data['row'] =  (array) $row;
		} else {
			$this->data['row'] = $this->model->getColumnTable('tb_partner_accounts');		}
		$this->data['fields'] 		=  \SiteHelpers::fieldLang($this->info['config']['forms']);
		$this->data['abs_bank']		= \DB::table('abs_bank')->get();
		$this->data['id'] = $id;
		$this->data['type']=$_GET['type'];
		return view('accountdetails.form',$this->data);
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
					
		$rules = [];
		$validator	= Validator::make($request->all(), $rules);
		if ($validator->passes()) {
			$data = $this->validatePost($request);
			
			if($request->type=='part'){

				if(isset($data['partner_id']) && $data['partner_id']==''){
					$data['partner_id']=\Auth::user()->id;
				}
				$data['id_type']=$request->id_type;
				$data['nric_number']=$request->nric_number;
				$data['ifsc_code']=$request->ifsc_code;
				$data['razor_account_id']=$request->razor_account_id;
				$postField = ['name' => $request->Bank_AccName, 'email' => '', 'type' => 'customer'];
				$url = 'https://api.razorpay.com/v1/contacts';
				$curlResponse = \AbserveHelpers::processCURL($url, $postField);
				if($curlResponse['status']){
					$Contact = json_decode($curlResponse['response']);
					$postField_fund = ['contact_id' => $Contact->id, 'account_type' => 'bank_account', 'bank_account' => array('name'=> $request->Bank_AccName,'ifsc'=> $request->ifsc_code,'account_number'=>$request->Bank_AccNumber)];
					$url_found = 'https://api.razorpay.com/v1/fund_accounts';
					$curlResponse_found = \AbserveHelpers::processCURL($url_found, $postField_fund);
					if($curlResponse_found['status']){
						$Found = json_decode($curlResponse_found['response']);
						$razorpay_contact_id = $Found->contact_id;
						$razorpay_fund_account_id = $Found->id;
						// $data['razorpay_contact_id']=$razorpay_contact_id;
						$data['razor_account_id']=$razorpay_fund_account_id;
					} else {
                    	throw new \Exception($curlResponse_found['response']);
                    
                	}
                } else {
                    throw new \Exception($curlResponse['response']);
                }
					$id = $this->model->insertRow($data , $request->input('id'));
					$idd=isset($request->partner_id) ? $request->partner_id : \Auth::user()->id;
                

				} else {
					if(isset($data['delboy_id']) && $data['delboy_id']==''){
						$data['del_boy_id']=\Auth::user()->id;
					}else{

						$data['del_boy_id']=$request->delboy_id;
					}
					
					// $data['id_type']=$request->id_type;
					$data['ifsc_code']=$request->ifsc_code;
					// $data['nric_number']=$request->nric_number;
				    $data['razor_account_id']=$request->razor_account_id;
					
					$tb_delboy_accounts=$this->model1->where('id',$request->input('id'))->first();
						if($this->model1->Bank_AccName != $request->Bank_AccName && $this->model1->ifsc_code != $request->ifsc_code && $this->model1->Bank_AccNumber != $request->Bank_AccNumber){
							$postField = ['name' => $request->Bank_AccName, 'email' => ''];
			                $url = 'https://api.razorpay.com/v1/contacts';
			                $curlResponse = \AbserveHelpers::processCURL($url, $postField);
			                if($curlResponse['status']){
			                	$Contact = json_decode($curlResponse['response']);
			                	$postField_fund = ['contact_id' => $Contact->id, 'account_type' => 'bank_account', 'bank_account' => array('name'=> $request->Bank_AccName,'ifsc'=> $request->ifsc_code,'account_number'=>$request->Bank_AccNumber)];
			                	$url_found = 'https://api.razorpay.com/v1/fund_accounts';
			                	$curlResponse_found = \AbserveHelpers::processCURL($url_found, $postField_fund);
			                	if($curlResponse_found['status']){
			                		$Found = json_decode($curlResponse_found['response']);
			                		$razorpay_contact_id = $Found->contact_id;
			                		$razorpay_fund_account_id = $Found->id;
			                		// $data['razorpay_contact_id']=$razorpay_contact_id;
			                		$data['razor_account_id']=$razorpay_fund_account_id;
			                	} else {
			                		throw new \Exception($curlResponse_found['response']);
			                	}
			                } else {
			                	throw new \Exception($curlResponse['response']);
			                }
			            }
			        /*$id = $this->model1->insertRow($data , $request->input('id'));*/
			        // dd($data);
			        $id = \DB::table('tb_partner_accounts')->insertGetId($data);
					$idd=isset($request->delboy_id) ? $request->delboy_id : \Auth::user()->id;
				}
           if(!is_null($request->input('apply')))
			{
				$return = 'accountdetails/update/'.$idd.'?type='.$request->type.'&return='.self::returnUrl();
			} else {
				  if($request->type=='part'){
					$return = 'partners';
				} else{
				    $return = 'deliveryboy';
				}
			//$return = 'accountdetails?return='.self::returnUrl();
			}
            // Insert logs into database
			if($request->input('id') =='')
			{
			\AbserveHelpers::auditTrail( $request , 'New Data with ID '.$id.' Has been Inserted !');
			} else {
			\AbserveHelpers::auditTrail($request ,'Data with ID '.$id.' Has been Updated !');
			}
			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
					
		} else {
			return Redirect::to('accountdetails/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($validator)->withInput();
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
		$model  = new Accountdetails();
		$info = $model::makeInfo('accountdetails');
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
				return view('accountdetails.public.view',$data);			
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
			return view('accountdetails.public.index',$data);	
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
	public function getdetails(Request $request)
	{
		$data = [];
		if($_GET['type'] == 'part'){
			$row = Accountdetails::where('partner_id',$request->id)->first();
		}
			$data['row']   = !empty($row) ? $row : '';
			$data['type']  = $_GET['type'];    
		return view('accountdetails.form',$data);
	}
}
