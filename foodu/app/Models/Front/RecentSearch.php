<?php namespace App\Models\Front;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use App\Models\Abserve;
class RecentSearch extends Abserve  {
	
	protected $table = 'abserve_recent_search';
	protected $primaryKey = 'id';

	public function __construct() {
		parent::__construct();
		
	}

	public static function querySelect(  ){
		
		return "  SELECT abserve_recent_search.* FROM abserve_recent_search  ";
	}	

	public static function queryWhere(  ){
		
		return "  WHERE abserve_recent_search.res_id !=0 ";
	}
	
	public static function queryGroup(){
		return "  ";
	}
	

}
