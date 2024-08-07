<?php namespace App\Http\Controllers\Front;

use App\Http\Controllers\controller;
use Illuminate\Http\Request;

use App\User;
use App\Models\Front\Offers;
use App\Models\Front\Usercart;
use App\Models\Front\Restaurant;

class FrontEndController extends Controller {

	public function ShowSearchcCart($res_id,$user_id,$cookie_id)
	{
		$offer    = $foods_items = [];
		$resInfo  = Restaurant::find($res_id);
		if (!empty($resInfo)) {
			$resTime	= \AbserveHelpers::gettimeval($res_id);
			if ($resTime == 1) {
				if ($user_id > 0) {
					$user_food_equal	= Usercart::where("user_id",$user_id)->exists();
					if($user_food_equal) {
						$foods_items	= Usercart::where('res_id',$res_id)->where('user_id',$user_id)->get();
					}
				} else if($cookie_id) {
					$foods_items	= Usercart::select('*')->where("cookie_id",'=',$cookie_id)->where("res_id",'=',$res_id)->get();
				}
				$offer		= Offers::whereRaw('? between usage_from and usage_to', [date('Y-m-d')])->where('status','active')->first();

				$data['foods_items']= $foods_items;
			}
			$data['resTime']	= $resTime;
		}
		$data['currsymbol']	= \AbserveHelpers::getCurrencySymbol();
		$data['offer']		= $offer;
		$data['resInfo']	= $resInfo;
		$html	= (string) view('front.cart.headercart',$data);
		return $html;
	}
}
?>