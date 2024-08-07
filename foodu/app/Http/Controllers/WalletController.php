<?php namespace App\Http\Controllers;

use App\Models\Wallet;
use App\User;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 


class WalletController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'wallet';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Wallet();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'wallet',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function index( Request $request )
	{
		$this->hook( $request  );
		if($this->access['is_view'] == 0)
			return Redirect::to('dashboard')->with('messagetext', \Lang::get('core.note_restric'))->with('msgstatus','error');

		$sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id'); 
		$order = (!is_null($request->input('order')) ? $request->input('order') : 'desc');
		// End Filter sort and order for query 
		// Filter Search for query	

		$filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');
		$this->data['u_id'] = $this->data['daterang']='';
		if(!is_null($request->input('search'))){
			$searchVal1=explode("|", $request->input('search'));
			$l_id='';
			if(count($searchVal1)){
				foreach ($searchVal1 as $key => $value) {
					if($value!=''){
						$searchVal2=explode(":", $value);
						$this->data[$searchVal2[0]]=$searchVal2[2];

						if($searchVal2[0]=='u_id'){
							$this->data['u_id']=$searchVal2[2];
							
							$filter .= " AND wallet.user_id = '".$searchVal2[2]."'";
						}						

						if($searchVal2[0]=='daterag'){
							$this->data['daterang']=$searchVal2[2];
							$dtofexp=explode(" - ", $searchVal2[2]);
							$filter .= " AND (wallet.date BETWEEN '".$dtofexp[0]."' AND '".$dtofexp[1]."' ) ";
						}
					}
				}
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
		// Get Query 
		$results = $this->model->getRows( $params );		
		
		// Build pagination setting
		$page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		$pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		$pagination->setPath('wallet');
		
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
		$this->data['user_name']=\DB::table('wallet')->select('tb_users.id','tb_users.email')->leftJoin('tb_users','tb_users.id','=','wallet.user_id')->groupBy('wallet.user_id')->get();
		//Order Details
		$this->data['order_id'] = OrderDetail::select('id','cust_id')->get();
		//Total wallet
		if (isset($this->data['u_id']) && $this->data['u_id'] > 0) {
			$total	= User::find($this->data['u_id'],['customer_wallet']);
		}
		$this->data['total_wallet'] = (!empty($total)) ? $total->customer_wallet : '0.00';
		// Master detail link if any 
		$this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		return view('wallet.index',$this->data);
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

	function edit( Request $request, $id = null) 
	{
		
		$this->hook( $request  );
		if(!isset($id) || $id == '')
			return Redirect::to('wallet');

		if($id =='') {
			echo "hii1";exit();
			if($this->access['is_add'] ==0 )
				return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		if($id !='') {
			if($this->access['is_edit'] ==0 )
				return Redirect::to('dashboard')->with('messagetext',\Lang::get('core.note_restric'))->with('msgstatus','error');
		}
		$row = Wallet::find($id);
		if($row) {
			$this->data['row']	= $row;
		} else {
			$this->data['row']	= $this->model->getColumnTable('wallet'); 
		}
		$this->data['fields']	= \SiteHelpers::fieldLang($this->info['config']['forms']);
		$this->data['id']		= $id;
		return view('wallet.form',$this->data);
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
		$rules			= $this->validateForm();
		$validator		= Validator::make($request->all(), $rules);	
		if ($validator->passes()) {
			$eWallet	 = Wallet::where('order_id',$request->order_id)->first();
			$userId		 = $request->user_id;
			$user_data   = User::find($userId);
			$user_wallet = $user_data->customer_wallet;
			$request_amount = $request->amount;
			$cBalance	= ($request->type == 'credit') ? ($user_wallet + (abs($request_amount))) : ($user_wallet - (abs($request_amount)));
			$wallet	           = new Wallet;
			$wallet->user_id   = $userId;
			$wallet->amount	   = $request_amount;
			$wallet->title	   = $request->type == 'credit' ? '# Admin Credited to your wallet' : '# Admin Debited to your wallet';
			$wallet->reason	   = $request->reason;
			$wallet->type	   = $request->type;
			$wallet->balance   = ($cBalance > 0) ? $cBalance : 0.00;
			$wallet->added_by  = \Auth::user()->id;
			$wallet->date	   = date("Y-m-d");
			$wallet->save();
			User::where('id',$userId)->update(['customer_wallet'=>($cBalance > 0) ? $cBalance : 0]);
			$return = 'wallet?search=u_id:equal:'.$userId;
			return Redirect::to($return)->with('messagetext',\Lang::get('core.note_success'))->with('msgstatus','success');
		} else {
			return Redirect::to('wallet/update/'.$id)->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')->withErrors($validator)->withInput();
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
		$model  = new Wallet();
		$info = $model::makeInfo('wallet');
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
				return view('wallet.public.view',$data);			
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
			return view('wallet.public.index',$data);	
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

	public function wallet($token, $amount = 0)
	{
		// $api        = $this->Api;
		$status     = true;
		$refund     = '';
		$paymentId  = $token->payment_token;

		if(!empty($paymentId) && $token->delivery=='paid' && $token->delivery_type=='razorpay'){

			$fetch_users= User::find($token->cust_id,['customer_wallet']);
			$wallet		= $fetch_users->customer_wallet + $amount;
			User::where('id',$token->cust_id)->update(['customer_wallet'=>$wallet]);
			$addwallet = new Wallet;
			$addwallet->user_id		= $token->cust_id;
			$addwallet->order_id	= $token->id;
			$addwallet->amount		= $amount;
			$addwallet->reason		= "Refund for items";
			$addwallet->type		= "credit";
			$addwallet->balance		= $wallet;
			$addwallet->added_by	= $token->cust_id;
			$addwallet->order_status= '0';
			$addwallet->date		= date('Y-m-d');
			$addwallet->save();

		}
        // $data['status'] = $status;
        // $data['refund'] = $refund;
        // $data['amount'] = $amount;
        // $data['message']= $message;
        // return $data;
	}

}
