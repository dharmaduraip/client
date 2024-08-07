<?php namespace App\Http\Controllers;

use App\Models\Weeklypaymentfordeliveryboy;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Validator, Input, Redirect ; 
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\weeklypaymentfordeliveryboyexport;
use App\Models\Deliveryboywallet;
use App\User;
use App\Models\Accountdetails;


class WeeklypaymentfordeliveryboyController extends Controller {

	protected $layout = "layouts.main";
	protected $data = array();	
	public $module = 'weeklypaymentfordeliveryboy';
	static $per_page	= '10';

	public function __construct()
	{		
		parent::__construct();
		$this->model = new Weeklypaymentfordeliveryboy();	
		
		$this->info = $this->model->makeInfo( $this->module);	
		$this->data = array(
			'pageTitle'	=> 	$this->info['title'],
			'pageNote'	=>  $this->info['note'],
			'pageModule'=> 'weeklypaymentfordeliveryboy',
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
		// //Pagination Start

		// $sort = (!is_null($request->input('sort')) ? $request->input('sort') : 'id'); 
		// $order = (!is_null($request->input('order')) ? $request->input('order') : 'asc');
		// // End Filter sort and order for query 
		// // Filter Search for query		
		// $filter = (!is_null($request->input('search')) ? $this->buildSearch() : '');

		// $page = $request->input('page', 1);
		// $params = array(
		// 	'page'		=> $page ,
		// 	'limit'		=> (!is_null($request->input('rows')) ? filter_var($request->input('rows'),FILTER_VALIDATE_INT) : static::$per_page ) ,
		// 	'sort'		=> $sort ,
		// 	'order'		=> $order,
		// 	'params'	=> $filter,
		// 	'global'	=> (isset($this->access['is_global']) ? $this->access['is_global'] : 0 )
		// );
		// // Get Query 
		// $results = $this->model->getRows( $params );		
		
		// // Build pagination setting
		// $page = $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false ? $page : 1;	
		// $pagination = new Paginator($results['rows'], $results['total'], $params['limit']);	
		// $pagination->setPath('weeklypaymentfordeliveryboy');
		
		// $this->data['rowData']		= $results['rows'];
		// // Build Pagination 
		// $this->data['pagination']	= $pagination;
		// // Build pager number and append current param GET
		// $this->data['pager'] 		= $this->injectPaginate();	
		// // Row grid Number 
		// $this->data['i']			= ($page * $params['limit'])- $params['limit']; 
		// // Grid Configuration 
		// $this->data['tableGrid'] 	= $this->info['config']['grid'];
		// $this->data['tableForm'] 	= $this->info['config']['forms'];
		// $this->data['colspan'] 		= \SiteHelpers::viewColSpan($this->info['config']['grid']);		
		// // Group users permission
		// $this->data['access']		= $this->access;
		// // Detail from master if any
		
		// // Master detail link if any 
		// $this->data['subgrid']	= (isset($this->info['config']['subgrid']) ? $this->info['config']['subgrid'] : array()); 
		// Render into template
		//	return view('weeklypaymentfordeliveryboy.index',$this->data);

		//Pagination End
		$this->data['r'] = $this->data['i'];		
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

		/*$from=base64_decode(explode("||",$_GET['date'])[0]);
		$to=base64_decode(explode("||",$_GET['date'])[1]);
		 //echo $id.'||'.$from.'||'.$to;die();
		$amount=\AbserveHelpers::getDel_boy_payable_weekly_amt($id,date('Y-m-d',strtotime($from)),date('Y-m-d',strtotime($to)));*/
		$amount = \AbserveHelpers::Delboypayableamount($id);
		$this->data['amount']=$amount;		

		// echo "<pre>";
		// echo ($this->data['amount']); exit;

		// echo $amount; exit;

		//print_r($this->data);exit;

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
				$this->data['pagination'] = DeliveryBoyWallet::where('del_boy_id', $id)->paginate($this->data['pager']);

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
		$model  = new Weeklypaymentfordeliveryboy();
		$info = $model::makeInfo('weeklypaymentfordeliveryboy');
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
				return view('weeklypaymentfordeliveryboy.public.view',$data);			
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
			return view('weeklypaymentfordeliveryboy.public.index',$data);	
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
	public function weeklypaymentboyexport(Request $request,$slug) 
           {
        $request->all();
        $exporter = app()->makeWith(weeklypaymentfordeliveryboyexport::class, compact('request'));  
        return $exporter->download('weeklypaymentfordeliveryboyexport_'.date('Y-m-d').'.'.$slug);
    }

    function transferamountboyold(Request $request){
	


		$from=$request->fromdate;
		$to=$request->todate;
		$id=$request->boy_id;
		$amount=\AbserveHelpers::getDel_boy_payable_weekly_amt($id,$from,$to);
		// $amount='1.01';
		$mol_details=\DB::table('tb_mol_setting')->where('id','1')->first();
		/*$tb_delboy_accounts=\DB::table('tb_delboy_accounts')->where('delboy_id',$id)->first();*/
		$tb_delboy_accounts = \DB::table('tb_partner_accounts')->where('del_boy_id',$id)->first();
		
		$validate_details=\DB::table('abserve_weeklypayment')->where('from_date',$from)->where('to_date',$to)->where('del_boy_id',$id)->first();
		if($validate_details){
			$reference_id=$validate_details->reference_id;
			\DB::table('abserve_weeklypayment')->where('id',$validate_details->id)->update(array('amount'=>$amount));
		}else{
			$reference_id="MASS".time().rand();
			\DB::table('abserve_weeklypayment')->insertGetId(['reference_id'=>$reference_id,'from_date'=>$from,'to_date'=>$to,'del_boy_id'=>$id,'amount'=>$amount,'status'=>'progress']);
		}

       // print_r($tb_delboy_accounts); exit;
		

		$dataa=array(
			"account"=>$tb_delboy_accounts->razor_account_id,
			"amount"=>round($amount*100),
			"currency"=>"INR"
			);
		
		/*$api_key = env('RAZORPAY_API_KEYID');
		$api_secret = env('RAZORPAY_API_KEY_SECRET');
		$dataJson=json_encode($dataa);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/transfers');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
		curl_setopt($ch, CURLOPT_USERPWD, $api_key . ':' . $api_secret);
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$response = curl_exec($ch);
		$err = curl_error($ch);
		curl_close($ch);*/

		 // $amount=10.00;
		//print_r($tb_delboy_accounts->razor_account_id); exit;

		


		   $postField = ["account_number"=> /*$tb_delboy_accounts->Bank_AccNumber*/RAZORPAY_ACCOUNT_ID,"fund_account_id"=> $tb_delboy_accounts->razor_account_id,"amount"=> round($amount*100),"currency"=> "INR","mode"=> "IMPS","purpose"=> "payout"];

																						
		   	$api_key = RAZORPAY_API_KEYID;
			$api_secret = RAZORPAY_API_KEY_SECRET;
			$dataJson=json_encode($postField);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/payouts');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
			curl_setopt($ch, CURLOPT_USERPWD, $api_key . ':' . $api_secret);
			$headers = array();
			$headers[] = 'Content-Type: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$response = curl_exec($ch);
			$err = curl_error($ch);
			curl_close($ch);

		$response1=json_decode($response,true);

		if ($err) {
			
			\DB::table('abserve_weeklypayment')->where('reference_id',$response1['reference_id'])->update(['status'=>'failure','json_content'=>$response ]);
			return Redirect::to('weeklypaymentfordeliveryboy')->with('messagetext',\Lang::get('core.note_error'))->with('msgstatus','error')
			->withErrors($err)->withInput();
		} else {
			if(!isset($response1['id'])){

				$response1['id']='';

			}
			

			if($response1['id']!=''){
				\DB::table('abserve_weeklypayment')->where('reference_id',$reference_id)->update(['mass_id'=>$response1['id'],'status'=>'paid'/*,'json_content'=>$response*/ ]);
				$details	=  \DB::table(/*'abserve_deliveryboys'*/'tb_users')->select('username','email')->where('id',$request->boy_id)->first();
				$to1 		= $details->email;
				$username 	= $details->username; 
				// Payslip mail
				$vals=array(
					'header'=>CNF_APPNAME.' Payslip',
					'username'=>$username,
					'from'=>date('d-m-Y',strtotime($from)),
					'to'  =>date('d-m-Y',strtotime($to)),
					'amount'=>$amount,
					'status'=>'paid',
					'mass_id'=>$response1['id'],
					'reference_id'=>$reference_id
					);

				$subject	= CNF_APPNAME.' Payslip';
				\Mail::send('emails.payslip_mail', $vals,function($message)use ($to1,$subject) {
					$message->to($to1)->subject($subject);
					$message->from(CNF_EMAIL,CNF_APPNAME);
				});

				$ids = \Session::get('ids');
				$update = \DB::table('abserve_rider_location_log')->whereIn('id', $ids)->update(['status' => 1]);
				$wallet = \DB::table('tb_users')->where('id', $request->boy_id)->first();
				if ($wallet) {
				    $exist_wallet = $wallet->customer_wallet;
				    $updated_wallet = $exist_wallet - $amount;

				    \DB::table('tb_users')
				        ->where('id', $request->boy_id)
				        ->update(['customer_wallet' => $updated_wallet]);
				}

				return Redirect::to('weeklypaymentfordeliveryboy')->with('messagetext','Successfully amount transfered')->with('msgstatus','success')->withErrors('Successfully amount transfered')->withInput();
			}else{
				\DB::table('abserve_weeklypayment')->where('reference_id',$reference_id)->update(['status'=>'failure'/*,'json_content'=>$response*/]);
				return Redirect::to('weeklypaymentfordeliveryboy')->with('messagetext',$response1 ['error']['description'])->with('msgstatus','error')->withErrors($response1 ['error']['description'])->withInput();
			}
			
		}
	}

	function transferamountboy(Request $request)
	{
		$boy_id = $request->boy_id;
		$amount = $request->pay_amount;
        $orderIds = explode(',', $request->pay_order_id[0]);
		$tb_boy_accounts = Accountdetails::where('del_boy_id',$boy_id)->first();
		if($tb_boy_accounts){
				$postField = [
				    "account_number" => RAZORPAY_ACCOUNT_ID,
				    "fund_account_id" => $tb_boy_accounts->razor_account_id,
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
				    return Redirect::to('weeklypaymentfordeliveryboy/' . $boy_id . '/edit')->with('messagetext', 'Unable to create payout or status not processing')->with('msgstatus', 'error');
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
					$boyWallet = DeliveryBoyWallet::where('order_id', $orderId)->first();
					$boyWallet->transaction_status = '1';
					$boyWallet->transaction_id = $payoutId;
					$boyWallet->payout_trans_date = now();
					$boyWallet->save();
			    }
			  	$mass_id = now()->format('Y-m-d H:i:s') . '# Weekly Amount transfer';
			    \DB::table('abserve_weeklypayment')->insert([
				    'user_id' => $boy_id,
				    'order_id' => implode(',', $orderIds),
				    'reference_id' => $payoutId,
				    'amount' => $amount,
				    'mass_id' => $mass_id,
				    'status' => 'paid',
				]);
				$delboy_paid_amount = \AbserveHelpers::Delboypayableamount($boy_id);
			    $user_details = User::find($boy_id);
				$to 		= $user_details->email;
				$username 	= $user_details->first_name." ".$user_details->last_name; 
				$user_details->customer_wallet = $user_details->customer_wallet - $delboy_paid_amount;
				$user_details->save();
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

				return Redirect::to('weeklypaymentfordeliveryboy')->with('messagetext','	Successfully amount transfered')->with('msgstatus','success');
		} else{
			return Redirect::to('weeklypaymentfordeliveryboy/'.$boy_id.'/edit')->with('messagetext','Can not add account details in partner')->with('msgstatus','error');
		}
	}




}
