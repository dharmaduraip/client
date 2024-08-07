<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Accountdetails extends Sximo  {
	
	protected $table = 'tb_partner_accounts';
	protected $primaryKey = 'id';
 	 public $timestamps=false;
 	// protected $fillable=['Bank_Name','Bank_AccName','ifsc_code', 'azor_account_id', 'fssai_no', 'aadhar_no', 'gst_no', 'pan_no'];
	public function __construct() {
		parent::__construct();
		
	}
public static function querySelect(  ){
		
		return "  SELECT tb_partner_accounts.* FROM tb_partner_accounts  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE tb_partner_accounts.partner_id = '".\Auth::user()->id."' AND tb_partner_accounts.id IS NOT NULL ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
