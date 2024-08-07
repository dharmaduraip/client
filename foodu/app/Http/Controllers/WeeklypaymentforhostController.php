<?php namespace App\Http\Controllers;

use App\Models\Weeklypaymentforhost;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\WeeklypaymentExport;
use App\Models\Partnerwallet;
use App\User;
use App\Models\Accountdetails;
use Razorpay\Api\Api;


class WeeklypaymentforhostController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'weeklypaymentforhost';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Weeklypaymentforhost();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'weeklypaymentforhost',
			'return'	=> self::returnUrl()
			
		);
		
	}

	public function index( Request $request )
	{
		// Make Sure users Logged 
		
		if(!\Auth::check()) 
			return redirect('user/login')->with('status', 'error')->with('message','You are not login');
		$_REQUEST['search'] = $request->search;
		$this->grab( $request) ;
		if($this->access['is_view'] ==0) 
			return redirect('dashboard')->with('message', __('core.note_restric'))->with('status','error');				
		// Render into template
		$this->data['partner_wallet'] = Partnerwallet::get();
		$this->data['tb_users'] =\DB::table('tb_users')->where('group_id','=',3)->get();
		$this->data['restaurants']=\SiteHelpers::approvedrestaurant();	

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
		$this->data['amount']= \AbserveHelpers::Partnerpayableamount($id);	
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
				$this->data['user']  = User::find($id);
				$this->data['pager'] = 10;
				$this->data['pagination'] = Partnerwallet::where('partner_id', $id)->paginate($this->data['pager']);

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
		$model  = new Weeklypaymentforhost();
		$info = $model::makeInfo('weeklypaymentforhost');
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
				return view('weeklypaymentforhost.public.view',$data);			
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
			return view('weeklypaymentforhost.public.index',$data);	
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

	
	public function weeklypaymentexport(Request $request,$slug) 
	{    
        $request->all();
        $exporter = app()->makeWith(WeeklypaymentExport::class, compact('request'));  
        return $exporter->download('WeeklypaymentExport_'.date('Y-m-d').'.'.$slug);
    }

    public function transferamount(Request $request)
	{
		$partner_id = $request->partner_id;
		$amount = $request->pay_amount;
        $orderIds = explode(',', $request->pay_order_id[0]);
		$tb_partner_accounts = Accountdetails::where('partner_id',$partner_id)->first();
		if($tb_partner_accounts){
				$postField = [
				    "account_number" => RAZORPAY_ACCOUNT_ID,
				    "fund_account_id" => $tb_partner_accounts->razor_account_id,
				    "amount" => $amount * 100,
				    "currency" => "INR",
				    "mode" => "IMPS",
				    "purpose" => "payout",
				    "queue_if_low_balance" => true
				];

				$api_key = RAZORPAY_API_KEYID;
				$api_secret = RAZORPAY_API_KEY_SECRET;
				$dataJson = json_encode($postField);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payouts');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
				curl_setopt($ch, CURLOPT_USERPWD, $api_key . ':' . $api_secret);
				$headers[] = 'Content-Type: application/json';
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$response = curl_exec($ch);
				curl_close($ch);
				$payouts_data = json_decode($response, true);
				if (!isset($payouts_data['id']) || !isset($payouts_data['status']) || $payouts_data['status'] != 'processing') {
				    return Redirect::to('weeklypaymentforhost/' . $partner_id . '/edit')->with('messagetext', 'Unable to create payout or status not processing')->with('msgstatus', 'error');
				}
				$payoutId = $payouts_data['id'];
				if($payouts_data['status'] == 'pending'){
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/payouts/$payoutId/approve");
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array()));
					curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$api_secret");
					$headers = array('Content-Type: application/json');
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$statusResponse = curl_exec($ch);
					$statusData = json_decode($statusResponse, true);
					curl_close($ch);
				}

				foreach ($orderIds as $orderId) {
					$partnerWallet = Partnerwallet::where('order_id', $orderId)->first();
					$partnerWallet->transaction_status = '1';
					$partnerWallet->transaction_id = $payoutId;
					$partnerWallet->payout_trans_date = now();
					$partnerWallet->save();
			    }
			  	$mass_id = now()->format('Y-m-d H:i:s') . '# Weekly Amount transfer';
			    \DB::table('abserve_weeklypayment')->insert([
				    'user_id' => $partner_id,
				    'order_id' => implode(',', $orderIds),
				    'reference_id' => $payoutId,
				    'amount' => $amount,
				    'mass_id' => $mass_id,
				    'status' => 'paid',
				]);
			    $user_details = User::find($partner_id);
				$to 		= $user_details->email;
				$username 	= $user_details->first_name." ".$user_details->last_name; 
				$vals=array(
					'header'=>CNF_APPNAME.' Payslip',
					'username'=>$username,
					'amount'=>$amount,
					'status'=>'paid',
					'mass_id'=> $mass_id,
					'reference_id'=> $payoutId
				);
				$subject	= CNF_APPNAME.' Payslip';
				\Mail::send('emails.payslip_mail', $vals,function($message)use ($subject,$to) {
					$message->to($to)->subject($subject);
					$message->from(CNF_EMAIL,CNF_APPNAME);
				});

				return Redirect::to('weeklypaymentforhost')->with('messagetext','	Successfully amount transfered')->with('msgstatus','success');
		} else{
			return Redirect::to('weeklypaymentforhost/'.$partner_id.'/edit')->with('messagetext','Can not add account details in partner')->with('msgstatus','error');
		}

	}

	public function postPhpexcel(Request $request)
	{
	    
	    $data=array();
	    $from=strtotime($request->from.' 12:00 AM');
	    $to=strtotime($request->to.' 11:59 PM');
	   
	    $data['order_details']=\DB::table('tb_users')->select('tb_users.*')
	    ->where('tb_users.group_id','3')
	    ->orderBy('tb_users.id','DESC')
	    ->get();

	   // echo "<pre>"; print_r($data); exit;
	    $data['users'] = $data['order_details'];
	 	return view('phpexcel.index_weekpayhost', $data);   
	}






}
