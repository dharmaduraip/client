<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotelitems;
use App\Models\Front\Restaurant;
use App\Models\Foodcategories;
use App\Models\Front\Usercart;
use App\Models\Front\RecentSearch;
use Session,Response,Redirect,URL;
use App\Http\Controllers\Api\OrderController as ordercon;
use App\Http\Controllers\mobile\UserController as userCon;
use App\Models\Useraddress;
use App\Models\Front\Fooditems;
use App\Models\Front\Favorites;

class DetailsControllerold extends Controller
{
    public  function getDetails(Request $request)
    {
        $keyinfo = \Session::get('keyinfo');
        \Session::forget('keyinfo');
        $restaurant = $this->data['cuisine_name'] = array();
        $restaurant_id  = $request->segment(2);
        $catString = [];
        $main_cat = Hotelitems::select(\DB::raw('GROUP_CONCAT(DISTINCT(main_cat)) as categories'))->where('restaurant_id',$restaurant_id)->where('del_status','0')->where('approveStatus','Approved')->first();
        if (!empty($main_cat)) {
            $catString = $main_cat->categories;
        }
        $shop_cate  = Restaurant::find($restaurant_id,['shop_categories']);
        if(!preg_match('/[0-9]/', $shop_cate->shop_categories)){ $shop_cate->shop_categories = ''; }/////TEMP FIX
        if (!empty($shop_cate->shop_categories) && trim($shop_cate->shop_categories) != '') {
            $catString = $shop_cate->shop_categories;
        }
        if ($catString != '') {
            $cate_list_shop = Foodcategories::select('*')->whereIn('id',explode(",",$catString))->orderByRaw('FIELD(id,'.$catString.')')->get();
        }
        $resexists      = Restaurant::where('id',$restaurant_id)->where('status','1')->exists();
        if($resexists){
            // Tam
            if (\Auth::id()) {
                $recentExists = RecentSearch::select('id')->where('user_id','=',\Auth::id())->where('res_id','=',
                    $restaurant_id)->first();
                if (!isset($recentExists->id)) {
                    $insertSearch = new RecentSearch();
                    $insertSearch->user_id = \Auth::id();
                    $insertSearch->res_id = $restaurant_id;
                    $insertSearch->save();
                }
            }
            $foods = \DB::table('abserve_hotel_items')->select('*')->where('restaurant_id',$restaurant_id)->where('del_status','0')->where('approveStatus','Approved')/*->where('selling_price','>',0)*/->get();
            if (count($foods) > 0) {
                $restaurant =  Restaurant::select('id', 'name', 'location','logo','rating','cuisine','delivery_time','opening_time','closing_time','res_desc','offer','free_delivery','adrs_line_1','sub_loc_level_1','city','state','phone','banner_image')->where('id', '=', $restaurant_id)->where('status','=',1)->first();
                $cuisine    = explode(",",$restaurant->cuisine); 
                $array  = array_values($cuisine);
                $cuisine_q =  \DB::table('abserve_food_cuisines')->select('name')->whereIn('id',  $array)->get();
                foreach ($cuisine_q as $cus) {
                    $cusine_name[] = $cus->name;
                }
                if (!isset($restaurant) && empty($restaurant)) {
                    return Redirect::to('/');
                }
                /*Minimum order value*/
                $min_order_val  = 0;
                $minInfo    = \DB::table('tb_settings')->where('name','min_order_value')->first();
                if (!empty($minInfo)) {
                    $min_order_val  = $minInfo->value;
                }
                \Session::put('min_order_val',$min_order_val);
                $this->data['cuisine_name']     = ($cusine_name!='') ? implode(",",$cusine_name) : '';
                $this->data['restaurant']       = $restaurant;
                $this->data['favorite'] = 0;
                $user_id    = $this->data['userid'] = (\Auth::check()) ? \Auth::user()->id : 0;
                if(\Auth::check()){
                    $Favorites = Favorites::where('user_id',$user_id)->where('resid',$restaurant_id)->count();
                    $this->data['favorite'] = $Favorites;

                }
                $this->data['authcheck']= (\Auth::check()) ? 1 : 0;
                $this->data['restid']   = $restaurant_id;
                $this->data['cate_list_shop']   = $cate_list_shop;
                $cart_cookie_id         = $this->getCartCookie();
                if (\Auth::check()) {
                    $yourcart1      = Usercart::where('user_id', $user_id)->first();
                } else {
                    $yourcart1      = Usercart::where('cookie_id', $cart_cookie_id)->first();
                }
                $resId = !empty($yourcart1) ? $yourcart1->res_id : 0;
                $this->data['keyinfo']      = $keyinfo;
                $this->data['cart_items_html']  = $this->Showcart($restaurant_id,$resId,$user_id,$cart_cookie_id,$keyinfo);
                $this->data['cart_res_id']      = $this->getCartResID();
                $this->data['cart_data']        = json_encode($this->getCartData(true));
                $all_hotel_items    = $this->getAllItemdetails($restaurant_id);
                // dd($all_hotel_items);
                $currsymbol         = \AbserveHelpers::getCurrencySymbol();
                foreach ($all_hotel_items as $key => $value) {
                    $value->item_name   = preg_replace('/[^A-Za-z0-9\-]/', '', $value->item_name);
                    $value->description = preg_replace('/[^A-Za-z0-9\-]/', '', $value->description);
                    $value->Sub_cat     = preg_replace('/[^A-Za-z0-9\-]/', '', $value->Sub_cat);
                    $value->Main_cat    = preg_replace('/[^A-Za-z0-9\-]/', '', $value->Main_cat);
                    $value->status      = preg_replace('/[^A-Za-z0-9\-]/', '', $value->status);
                    $price              = \AbserveHelpers::getItemPriceWithComsn($value->id);
                    $value->currencysymbol  = $currsymbol;
                    $itemPriceWithOffer     = round(\AbserveHelpers::CurrencyValue($price['itemPriceWithOffer']),2);
                    $itemPriceWithOutOffer  = round(\AbserveHelpers::CurrencyValue($price['itemPriceWithOutOffer']),2);
                    $value->price   = $itemPriceWithOffer;
                    $offerText      = '';
                    if($price['itemPriceWithOffer'] != $price['itemPriceWithOutOffer'] && $price['itemPriceWithOffer'] > 0) {
                        $offerText .= '<strike>'.$currsymbol.$itemPriceWithOutOffer.'</strike>';
                    }
                    $value->offerText   = $offerText;
                    $iteminvalidtext    = \AbserveHelpers::getNextItemTime($value->id);
                    $value->iteminvalidtext = $iteminvalidtext;
                    $this->data['offerText']    = $value->offerText;
                }
                $this->data['all_items']    = json_encode($all_hotel_items);
                
                //$head_cart_items_html           = (new FrontEndController)->ShowSearchcCart($resId,$user_id,$cart_cookie_id);
                // $this->data['head_cart_items_html'] = $head_cart_items_html;
                $this->data['head_cart_items_html'] = '';
                return view('front.details',$this->data);
            } else {
                return Redirect::to('/')->with('message',\AbserveHelpers::alert('error','No food items found in the shop'));
            }  
        } else {
            return Redirect::to('/')->with('message',\SiteHelpers::alert('error','No such shop found'));
        }
    }

    public function rescategories($restaurant_id)
    {
        $response = array();
        $categories = \DB::select("SELECT DISTINCT(`hi`.`main_cat`) as id,`fc`.`cat_name` as name FROM `abserve_hotel_items` AS `hi` JOIN `abserve_food_categories` AS `fc` ON `hi`.`main_cat` = `fc`.`id` WHERE `restaurant_id` = ".$restaurant_id." AND hi.del_status = 0 AND `approveStatus` = 'Approved' AND `recommended`= '0' order by `hi`.`main_cat`");
        $recomend = \DB::select("SELECT DISTINCT(`recommended`) AS recomnd FROM `abserve_hotel_items` WHERE `del_status` = 0 AND `approveStatus` = 'Approved' AND `restaurant_id` = ".$restaurant_id);
        if(!empty($recomend)){
            foreach ($recomend as $key => $val) {
                $rend[] = get_object_vars($val);
            }
            $result = call_user_func_array('array_merge_recursive', $rend);
            $rec_val = array("id"=>0,"name"=>"Recommended");

            if(is_array($result['recomnd'])){
                if(in_array('1',$result['recomnd'])){
                    array_unshift($categories, $rec_val);
                }
            }else{
                if($result['recomnd'] == 1){
                    array_unshift($categories, $rec_val);
                }
            }
        }
        return json_encode($categories);
    }

    public function getCartResID($ajax=false)
    {
        $res_id=0;
        if(\Auth::check()){
            $user_id = \Auth::user()->id;
            $result = \DB::table('abserve_user_cart')
            ->where('user_id', '=', $user_id)
            ->first();

        }else{
            $cart_cookie_id = $this->getCartCookie();
            $result = \DB::table('abserve_user_cart')
            ->where('cookie_id', '=', $cart_cookie_id)
            ->first();

        }
        if(!empty($result))
            $res_id=$result->res_id;
        if($ajax){
            echo $res_id;exit;
        }else {
            return $res_id;
        }
    }

    public static function getCartCookie()
    {
        $cookie_name = "mycart";
        if(\Cookie::has($cookie_name) && \Cookie::get($cookie_name) != null)
        {
            return  \Cookie::get($cookie_name);
        }
        return '';
    }

    public function getCartData($json_format=false)
    {
        if(\Auth::check()){
            $user_id = \Auth::user()->id;
            $results = \DB::table('abserve_user_cart')
            ->select('*')
            ->where("user_id",'=',$user_id)
            ->get();
        }else{
            $cart_cookie_id = $this->getCartCookie();
            $results = \DB::table('abserve_user_cart')
            ->select('*')
            ->where("cookie_id",'=',$cart_cookie_id)
            ->get();
        }
        if($json_format==true) {
            foreach ($results as $key => $value) {
                $value->food_item=str_replace('"', '``', $value->food_item);
            }
        }
        return $results;
    }

    public function getAllItemdetails( $restaurant_id)
    {
        $hotel_item = array();
        $qwert = "SELECT DISTINCT(`hi`.`id`),`hi`.`main_cat`,`hi`.`recommended`,`food_item` as item_name,`description`,`price`,`status`,`item_status`,`hc`.`cat_name` as Sub_cat,`hm`.`cat_name` as Main_cat,`hi`.`image` FROM `abserve_hotel_items` AS `hi` JOIN `abserve_food_categories` AS `hc` ON `hc`.`id` = `hi`.`main_cat` JOIN `abserve_food_categories` AS `hm` ON `hm`.`id` = `hi`.`main_cat` JOIN `abserve_food_categories` AS `c` ON `c`.`id` = `hi`.`main_cat` WHERE `hi`.`restaurant_id` = ".$restaurant_id." AND hi.del_status = 0 AND hi.`approveStatus` = 'Approved'";
        $hotel_item = \DB::select($qwert);
        return $hotel_item;
    }

    public function Showcart($cur_resid,$res_id,$user_id,$cookie_id,$keyinfo='') 
    {
        Session()->put('error','Item created successfully.');
        $min_val        = (\Session::has('min_order_val')) ? \Session::get('min_order_val') : '0';
        $min_order_val  = number_format((float)\AbserveHelpers::CurrencyValue($min_val),2,'.','');
        $resInfo        = Restaurant::find($cur_resid);
        $cartResInfo    = Restaurant::find($res_id);
        if(!empty($cartResInfo)){    
            $cartResInfo    = $cartResInfo->append('availability');
        }
        $res_timeValid          = \AbserveHelpers::gettimeval($cur_resid);
        $cart_res_time_valid    = \AbserveHelpers::gettimeval($res_id);
        \Session::put('restimevalid',$res_timeValid);
        $CartResTimeText    = '';
        if ($user_id != '0') {
            $user_food_equal    = \DB::table('abserve_user_cart')->where("user_id",'=',$user_id)->exists();
            if ($user_food_equal) {
                $foods_items    = \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$user_id)->where("res_id",'=',$res_id)->get();
            } else {
                $cookie_food_equal  = \DB::table('abserve_user_cart')->where("cookie_id",'=',$cookie_id)->where("res_id",'=',$res_id)->exists();
                if ($cookie_food_equal) {
                    $array['user_id']   = $user_id;
                    \DB::table('abserve_user_cart')->where("cookie_id",'=',$cookie_id)->update($array);
                    $foods_items        = \DB::table('abserve_user_cart')->select('*')->where("cookie_id",'=',$cookie_id)->where("res_id",'=',$res_id)->get();
                }
            }
        } else if($cookie_id != '0') {
            $foods_items = \DB::table('abserve_user_cart')->select('*')->where("cookie_id",'=',$cookie_id)->where("res_id",'=',$res_id)->get();
        }
        $innerhtml = '';$item_total = 0;$delivery_charge = '0.00'; $cnt_items ='';$html ='';
        if (!empty($foods_items)) {
            $cartCount  = (count($foods_items) > 1) ? (count($foods_items).' Items') : (count($foods_items).' Item');
            $cnt_items  = count($foods_items);
            $itemcount  = \DB::table('tb_settings')->select('item_count')->where('id',1)->first();
            $itemcnt    = $itemcount->item_count;
            $quan       = 0;
            foreach ($foods_items as $key => $value) {
                $quan   += $value->quantity;
            }
            $innerhtml  .= '<input type="hidden" value="'.$quan.'" id="quan">';
            $innerhtml  .= '<input type="hidden" value="'. $itemcnt.'" id="countitem">';
            $innerhtml  .= '<input type="hidden" value="'. $res_id.'" id="res_id_cart">';
            //if($quan <=  $itemcnt){
            $currsymbol = \AbserveHelpers::getCurrencySymbol();
            $timeCheck  = 'true';
            // $innerhtml.=' <div class="cartsectionitems"><div class="cart-loader" style="display:none;"></div>';
            foreach ($foods_items as $ky => $val) {
                $aFoodItem      = \App\Models\Fooditems::find($val->food_id);
                $deleteclass    = '';
                $item_time_valid= \AbserveHelpers::getItemTimeValid($val->food_id);
                $foodInfo       = \DB::table('abserve_hotel_items')->select('status')->where('id',$val->food_id)->first();
                if($item_time_valid != 1){
                    $timeCheck  = 'false';
                }
                // $iPrice      = \SiteHelpers::getItemPriceWithComsn($val->food_id,$val->adon_id,$val->adon_type);
                // $price_val   = round(\SiteHelpers::CurrencyValue($iPrice['itemPriceWithOffer']),2);

                $hikedPrice     = (isset($aFoodItem->original_price) * (isset($aFoodItem->hiking) /100));
                $gstHikedPrice  = ($hikedPrice * ($val->gst /100));
                $price_val      = $val->price + $hikedPrice + $gstHikedPrice;
                $total          = ($val->quantity * $price_val);
                $strike_price   = ($val->quantity * $val->strike_price);
                $innerhtml      .= ' <div class="menu-cart-items" id="item_'.$val->food_id.'_'.$val->adon_id.'">
                ';
                $addon_details = ($val->adon_details != 0) ? $val->adon_details : '';
                $innerhtml      .= '<div class="item_naem" style="margin-right:20px">
                <p class="veg-item">'.$val->food_item.'<br><small>'.$addon_details.'</small></p>
                </div>';
                if ($item_time_valid == 1) {
                    $afid   = $val->food_id;
                    if ($val->adon_id > 0) {
                        $afid   .='_'.$val->adon_id;
                    }
                    $innerhtml  .= '<div class="block-item text-center no-pad items_count" id="fnitem_'.$val->food_id.'_'.$val->adon_id.'" style="margin-right:20px">
                    <span class="remove_cart_item count_in_dec" data-isad="'.$aFoodItem->show_addon.'" data-faid="'.$val->food_id.'" data-type="'.$val->adon_type.'" >
                        <i data-faid="'.$val->food_id.'" data-aid="'.$val->adon_id.'" data-type="'.$val->adon_type.'" class="fa fa-minus "  aria-hidden="true" style="cursor:pointer;"></i></span>
                        <span id="afid_'.$afid.'_'.$val->adon_id.'" class="item-count afid_'.$afid.'">'.$val->quantity.'</span>
                        <span class="add_cart_item count_in_dec" data-faid="'.$val->food_id.'" data-aid="'.$val->adon_id.'" data-type="'.$val->adon_type.'"  data-isad="'.$aFoodItem->show_addon.'">
                            <i data-faid="'.$val->food_id.'"  id="fitem_'.$val->food_id.'" class="fa fa-plus " aria-hidden="true" style="cursor:pointer;"></i></span></div>';
                            if($strike_price > 0) {
                                $innerhtml .= '<span class="text-right"><s style="color:red;">'.$currsymbol.number_format($strike_price,2,'.','') .'</s></span>';
                            }
                            $innerhtml  .=   '<span class="block-item text-right '.$deleteclass.'">
                            <div>'.$currsymbol.' <span class="item-price">'.number_format($total,2,'.','').'</span></span>';

                        } else {
                            $deleteclass    = 'item_delete';
                            $innerhtml      .= '<div class="block-item text-center no-pad unavail_item"><span>Unavailable</span></div>';
                            $innerhtml      .=   '<div class="block-item text-right '.$deleteclass.'">
                            <div>'.$currsymbol.' <span class="item-price">'.number_format($total,2,'.','').'</span></div>';
                            $innerhtml      .= '<span class="delete_item" data-cart-id="'.$val->id.'"><i class="fa fa-trash"></i></span>';
                        }
                        $innerhtml  .=  '</div>
                    </div>';
                    $item_total += $total;
                }
                // $innerhtml.=' </div>';
                $html = '';
                if ($innerhtml != '' && !empty($cartResInfo)) {
                    if ($keyinfo == 'checkout') {
                        $closetime  = date("H:i a", strtotime($resInfo->opening_time));
                        //$bookingnote = '<h5><font color="red">Restaurent will be closed sooner.Next available at '.$closetime.'</font></h5>';
                        $bookingnote    = '';
                    } else {
                        $bookingnote    = '';
                    }
                    $astart = '';
                    if ($cur_resid != $res_id) {
                        $astart .= "<div class='restaurent_name'>from <a href='".\URL::to('details/'.$res_id)."'><b>".$cartResInfo->name."</b></a></div>";
                    }
                    $html = ' <section><div class="cartsection">
                    <div class="menu-cart-title">
                        <div class="rphidetitle">Cart</div>'.$bookingnote.$astart.'
                        <div class="rphitem">'.$cartCount.'</div>'.$CartResTimeText.'
                    </div>
                    <div class="menu-cart-body " >'.$innerhtml.'</div>
                    <div class="menu-cart-footer">';
                        if ($cartResInfo->offer >0 &&  $cartResInfo->offer <= 100) {
                            $offer_amount   = $item_total * ($cartResInfo->offer / 100);
                        } else {
                            $offer_amount   = 0;
                        }
                        $actual_total   = $item_total;
                        $grand_total    = $item_total - $offer_amount;
                        $offerText      = '';
                        if($offer_amount > 0 && $offer_amount <= $item_total ) {
                            $offerText  = '<strike>'.$currsymbol.number_format($actual_total,2,'.','').'</strike>';
                        }
                        $html   .= '<div class="final-total">
                        <h5><span class="sub_total">Subtotal</span>
                            <span class="pull-right">'.$offerText.''.$currsymbol.' <span class="grand_total">'.number_format($grand_total,2,'.','').'</span></span>
                        </h5>
                        <div class="extra_charge">Extra charges may apply</div>';
                        if ($resInfo->minimum_order > 0 && $resInfo->minimum_order > $item_total) {
                            if ($resInfo->minimum_order <= $grand_total) {
                                $Bcolor = "green";
                            }else{
                                $Bcolor = "#b55a5a";
                            }
                            $html       .= '<div style="text-align: center;font-weight: bold;color: #FFF;font-size: 17px;background-color:'.$Bcolor.';padding:10px" class="extra_charge">Minimum order value is '.$currsymbol.' '.$resInfo->minimum_order.'</div>';
                        }
                        $html   .= '</div>';
                    if ($res_id != '') { // If cart is not empty
                        if ($cartResInfo->availability['status'] == 1) {
                            if (\Auth::check()) {
                                if ($timeCheck != 'true') {
                                    $checkout   = '<button class="btn btn-checkout" id="btn-checkout" disabled>Checkout</button>';
                                } else {
                                    if($resInfo->minimum_order >= 0 && $resInfo->minimum_order<=$item_total){
                                        $checkout   = "<a href='".\URL::to('checkout')."'><button class='btn btn-checkout' id='btn-checkout' >Checkout</button></a>";
                                    }else{
                                        $checkout   = '<button class="btn btn-checkout" id="btn-checkout" disabled>Checkout</button>';
                                    }
                                }
                            } else {
                                $checkout   = '<button class="btn btn-checkout login_checkout" id="btn-checkout" >Checkout</button>';
                            }
                        } else {
                            if ($cartResInfo->availability['status'] != 1) {
                                if ( $res_id != $cur_resid) {
                                    $CartResTimeText    = '<div class="CartResTimeText"><font color="red">'.$cartResInfo->name.' not available now</font></div>';
                                } else {
                                    $getText    = \AbserveHelpers::getNextAvailableTimeRes($cur_resid);
                                    $CartResTimeText = '<div class="CartResTimeText"><font color="red">'.$getText.'</font></div>';
                                }
                            }

                            $checkout   = '<button class="btn btn-checkout" id="btn-checkout" disabled>Checkout</button>';
                        }

                    }
                    $html   .= $checkout.'</div></section>';
                }else{
                    $html   .= '<section>
                    <div class="menu-cart-title"><h1>Your Cart</h1></div>
                    <div class="menu-cart-body empty" ><div class="cart-quotes"></div></div>
                    <div class="menu-cart-footer">
                    <button class="btn btn-checkout" disabled id="btn-checkout">Checkout</button>
                    </div>
                    </section>';
                }
            } else {
                $empty_url  = URL::to('').'/'.CNF_THEME.'/themes/maintheme/images/cartempty.png';
                $html       .= '<div class="righttittle">Cart Empty</div>
                <img src="'.$empty_url.'" class="rghtimg img-responsive"><div class="goodfood">
                </div>';
            }
            return $html;
    }

    public function postFooddetails(Request $request)
    {
        $data['foodDetails']    = \App\Models\Fooditems::find($request->id);
        $data['unitDetails']    = \DB::table('tb_food_unit')->where('food_id',$request->id)->get();
        $data['variationDetails']   = \DB::table('tb_food_variation')->where('food_id',$request->id)->get();
        return view('frontend.details-modal',$data);
    }

    public function getCheckcart(Request $request)
    {
        $ajax=false;
        if(isset($request->ajax) && $request->ajax=='true')
            $ajax=true;
        if(\Auth::check()){
            $user_id = \Auth::user()->id;
            $result = \DB::select("SELECT * FROM `abserve_user_cart` WHERE `user_id` = '".$user_id."' AND res_id!='".$request->res_id."'");
        }else{
            $cart_cookie_id = $this->getCartCookie();
            $result = \DB::select("SELECT * FROM `abserve_user_cart` WHERE `cookie_id` = '".$cart_cookie_id."' AND res_id!='".$request->res_id."'");

        }
        if($ajax){
            echo count($result);exit;
        }else {
            return count($result);
        }
    }

    public function postAddtotcart(Request $request)
    {
        // if(isset($request->clear) && $request->clear=='true')
        //  $this->clearCart();
        $hotel_item = $product = array();
        $item_id    = $request->item;
        $res_id     = $request->res_id;
        $ad_id      = $request->ad_id;
        $adon_type    = $request->ad_type;
        $product['adon_details'] = 0;
        // $res_id      = $this->getResIdFromItemId($item_id);
        $html       = ''; $user_id = 0; $cart_cookie_id = 0;
        $hotel_item = \DB::table('abserve_hotel_items')->select('id','gst','food_item','price','selling_price','original_price','strike_price','hiking')->where('id', $item_id)->first();
        if ($adon_type == 'unit') {
            $hotel_item_unit    = \DB::table('tb_food_unit')->select('price','selling_price','original_price','unit','unit_type')->where('id', $adon_id)->where('food_id', $item_id)->first();
            $product['price']       = round($hotel_item_unit->selling_price) > 0 ? $hotel_item_unit->selling_price : $hotel_item_unit->price;
            $product['vendor_price']=$hotel_item_unit->original_price;
            $product['adon_details']=$hotel_item_unit->unit.' '.ucfirst($hotel_item_unit->unit_type);
        } else if($adon_type == 'variation') {
            $hotel_item_variation   = \DB::table('tb_food_variation')->select('price','selling_price','original_price','color','unit')->where('id', $adon_id)->where('food_id', $item_id)->first();
            $product['price']       = round($hotel_item_variation->selling_price) >0 ? $hotel_item_variation->selling_price : $hotel_item_variation->price;

            $product['vendor_price']=$hotel_item_variation->original_price;
            $product['adon_details']=ucfirst($hotel_item_variation->color).':'.$hotel_item_variation->unit;
        } else {
            $product['price']       = round($hotel_item->selling_price) >0 ? $hotel_item->selling_price : $hotel_item->price;
            $product['vendor_price']= $hotel_item->original_price;
        }
        $stax       = \DB::table('abserve_restaurants')->select('service_tax1')->where('id',$res_id)->first();
        $product['food_id']     = $item_id;
        $product['food_item']   = $hotel_item->food_item;
        $product['gst']         = 0;
        $product['price']       = $hotel_item->selling_price;
        $product['strike_price']= $hotel_item->strike_price;
        $product['quantity']    = $request->qty;
        $product['res_id']      = $res_id;
        $product['tax']         = $stax->service_tax1;

        $product['adon_type']   = $adon_type;
        $product['adon_id']     = $ad_id;
        $cart_cookie_id         = $this->getCartCookie();
        if ( !$cart_cookie_id ) {
            $cart_cookie_id     = $this->setCartCookie();
        }
        $product['cookie_id']   = $cart_cookie_id;
        $product['user_id']     = $user_id;
        if (\Auth::check()) {
            $user_id = \Auth::user()->id;
            $product['user_id']     = $user_id;
            $product['cookie_id']   = 0;
        }
        $cart_data  = $this->Addcart($product);
        if (isset($request->key) && $request->key == 'checkout') {
            $aCartPInfo = \AbserveHelpers::getCheckoutcartprice($user_id,$res_id);
            $html       = (string) view('front.cart.checkoutcart',$aCartPInfo);
        } else {
            $cur_resid  = $res_id;
            //return $cart_data=json_encode($cart_data);
            $html       = $this->Showcart($cur_resid,$res_id,$user_id,$cart_cookie_id);
        }
        // $searchhtml     = (new FrontEndController)->ShowSearchcCart($res_id,$user_id,$cart_cookie_id);
        $headCartCount  = \AbserveHelpers::getCartItemCount();
        $response['html']           = $html;
        // $response['searchhtml']     = $searchhtml;
        $response['headCartCount']  = $headCartCount;
        return Response::json($response);
    }

    public function Addcart( $input)
    {
        $values = array("user_id" => $input['user_id'],"res_id" => $input['res_id'],"food_id" => $input['food_id'],"food_item" => $input['food_item'],"price" => $input['price'],"quantity" => $input['quantity'],"cookie_id" => $input['cookie_id'],"tax" => $input['tax'],'vendor_price' => $input['vendor_price'],'adon_id' => $input['adon_id'],'adon_type' => $input['adon_type'],'adon_details' => $input['adon_details'],'gst' => $input['gst'],'strike_price' => $input['strike_price']);
        if($input['user_id'] != '0'){
            $user_res_equal = \DB::table('abserve_user_cart')->where("user_id",$input['user_id'])->where("res_id",$input['res_id'])->exists();
        } else { 
            $user_res_equal = \DB::table('abserve_user_cart')->where("cookie_id",'=',$input['cookie_id'])->where("res_id",'=',$input['res_id'])->exists();  
        }

        if ($user_res_equal) {
            if ($input['user_id'] != '0') {
                if ($input['adon_id'] > 0) {
                    $user_food_equal = \DB::table('abserve_user_cart')->where("user_id",'=',$input['user_id'])->where("food_id",'=',$input['food_id'])->where("adon_id",'=',$input['adon_id'])->where("adon_type",'=',$input['adon_type'])->exists();
                } else {
                    $user_food_equal = \DB::table('abserve_user_cart')->where("user_id",'=',$input['user_id'])->where("food_id",'=',$input['food_id'])->exists();
                }
            } else {
                if ($input['adon_id'] > 0) {
                    $user_food_equal = \DB::table('abserve_user_cart')->where("cookie_id",'=',$input['cookie_id'])->where("food_id",'=',$input['food_id'])->where("adon_id",'=',$input['adon_id'])->where("adon_type",'=',$input['adon_type'])->exists();
                } else {
                    $user_food_equal = \DB::table('abserve_user_cart')->where("cookie_id",'=',$input['cookie_id'])->where("food_id",'=',$input['food_id'])->exists();
                }
            }
            if ($user_food_equal) {
                if ($input['user_id'] != '0') {
                    if ($input['adon_id'] > 0) {
                        $quantity = \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$input['user_id'])->where("food_id",'=',$input['food_id'])->where("adon_id",'=',$input['adon_id'])->where("adon_type",'=',$input['adon_type'])->get();
                    } else {
                        $quantity = \DB::table('abserve_user_cart')->select('*')->where("user_id",'=',$input['user_id'])->where("food_id",'=',$input['food_id'])->get();
                    }
                } else {
                    if ($input['adon_id'] > 0) {
                        $quantity = \DB::table('abserve_user_cart')->select('*')->where("cookie_id",'=',$input['cookie_id'])->where("food_id",'=',$input['food_id'])->where("adon_id",'=',$input['adon_id'])->where("adon_type",'=',$input['adon_type'])->get();
                    } else {
                        $quantity = \DB::table('abserve_user_cart')->select('*')->where("cookie_id",'=',$input['cookie_id'])->where("food_id",'=',$input['food_id'])->get();
                    }
                }
                $fid = $quantity[0]->id;
                if($input['quantity'] == 0){
                    \DB::table('abserve_user_cart')->where("id",'=',$fid)->delete();
                } else {
                    $vals   = array("user_id"=>$input['user_id'],"res_id"=>$input['res_id'],"food_id"=>$input['food_id'],"food_item"=>$input['food_item'],"price"=>$input['price'],"quantity"=>$input['quantity'],"cookie_id"=>$input['cookie_id'],"tax"=>$input['tax'],'vendor_price'=>$input['vendor_price'],'adon_details'=>$input['adon_details'],'gst'=>$input['gst'],'strike_price' => $input['strike_price']);
                    \DB::table('abserve_user_cart')->where("id",'=',$fid)->update($vals);
                }
            } else {
                $cartCheck = \DB::table('abserve_user_cart')->where('user_id',$input['user_id'])->where('cookie_id',$input['cookie_id'])->where('res_id',$input['res_id'])->first();
                if(!empty($cartCheck)){
                    $values['distance_km']  = $cartCheck->distance_km;
                    $values['duration']     = $cartCheck->duration;
                    $values['address_id']   = $cartCheck->address_id;
                    $values['coupon_id']    = $cartCheck->coupon_id;
                    $values['ordertype']    = $cartCheck->ordertype;
                    $values['delivertype']  = $cartCheck->delivertype;
                    $values['deliverdate']  = $cartCheck->deliverdate;
                    $values['delivertime']  = $cartCheck->delivertime;
                }
                \DB::table('abserve_user_cart')->insert($values);
            }
        }else{
            if($input['user_id'] != '0'){
                \DB::table('abserve_user_cart')->where('user_id', '=', $input['user_id'])->delete();
            } else {
                \DB::table('abserve_user_cart')->where('cookie_id', '=', $input['cookie_id'])->delete();
            }
            \DB::table('abserve_user_cart')->insert($values);
        }
        //return $this->getCartData(true);
    }

    public function getRemovefromcart(Request $request)
    {
        $hotel_item = array();
        $item_id    = $request->item;
        $res_id     = $request->res_id;
        $adon_id    = $request->adon_id;
        $adon_type  = $request->adon_type;
        $html       = '';$user_id = 0;$cart_cookie_id = 0;
        // $hotel_item  = \DB::table('abserve_hotel_items')->select('food_item','price')->where('id', $item_id)->first();
        $hotel_item = \DB::table('abserve_hotel_items')->select('gst','food_item','price','selling_price','original_price','strike_price')->where('id', $item_id)->first();
        if ($adon_type == 'unit') {
            $hotel_item_unit    = \DB::table('tb_food_unit')->select('price','selling_price','original_price','unit','unit_type')->where('id', $adon_id)->where('food_id', $item_id)->first();
            $product['price']       = round($hotel_item_unit->selling_price) >0 ? $hotel_item_unit->selling_price : $hotel_item_unit->price;
            $product['vendor_price']= $hotel_item_unit->original_price;
            $product['adon_details']= $hotel_item_unit->unit.' '.ucfirst($hotel_item_unit->unit_type);
        } else if($adon_type == 'variation') {
            $hotel_item_variation   = \DB::table('tb_food_variation')->select('price','selling_price','original_price','color','unit')->where('id', $adon_id)->where('food_id', $item_id)->first();
            $product['price']       = round($hotel_item_variation->selling_price) >0 ? $hotel_item_variation->selling_price : $hotel_item_variation->price;
            
            $product['vendor_price']= $hotel_item_variation->original_price;
            $product['adon_details']= ucfirst($hotel_item_variation->color).':'.$hotel_item_variation->unit;
        } else {
            $product['price']       = round($hotel_item->selling_price) >0 ? $hotel_item->selling_price : $hotel_item->price;
            $product['vendor_price']= $hotel_item->original_price;
        }
        $stax   = \DB::table('abserve_restaurants')->select('service_tax1')->where('id',$res_id)->first();
        $product['food_id']     = $item_id;
        $product['food_item']   = $hotel_item->food_item;
        $product['gst']         = 0;
        $product['price']       = $hotel_item->selling_price;
        $product['strike_price']= $hotel_item->strike_price;
        $product['quantity']    = $request->qty;
        $product['res_id']      = $res_id;
        $product['tax']         = $stax->service_tax1;
        $product['adon_id']     = $adon_id;
        $product['adon_type']   = $adon_type;
        $cart_cookie_id = $this->getCartCookie();
        if (!$cart_cookie_id) {
            $cart_cookie_id     = $this->setCartCookie();
        }
        $product['cookie_id']   = $cart_cookie_id;
        $product['user_id']     = $user_id;
        $product['adon_details']= 0;
        if (\Auth::check()) {
            $user_id    = \Auth::user()->id;
            $product['user_id'] = $user_id;
            $cart_cookie_id     = 0;
        }
        $this->Addcart($product);
        if (isset($request->key) && $request->key == 'checkout') {
            $aCartPriceInfo = \AbserveHelpers::getCheckoutcartprice($user_id,$res_id);
            $html           = (string) view('front.cart.checkoutcart',$aCartPriceInfo);
        } else {
            $cur_resid      = $res_id;
            $html           = $this->Showcart($cur_resid,$res_id,$user_id,$cart_cookie_id);
        }
        //$searchhtml         = (new FrontEndController)->ShowSearchcCart($res_id,$user_id,$cart_cookie_id);
        $headCartCount      = \AbserveHelpers::getCartItemCount();
        $response['html']   = (string) $html;
        //$response['searchhtml']     = $searchhtml;
        $response['headCartCount']  = $headCartCount;
        $emptyhtml  = ''; $cart = 'notempty';
        if($html == '') {
            $cart   = 'empty';
            $emptyhtml = view('frontend.empty_checkout');
        }
        $response['emptyhtml'] = (string) $emptyhtml;
        $response['cart'] = $cart;
        return Response::json($response);
    }

    public static function setCartCookie()
    {
        $cookie_name = "mycart";
        $cart_cookie_val = uniqid();
        \Cookie::queue(\Cookie::make($cookie_name, $cart_cookie_val, 45000));
        return $cart_cookie_val;
    }

    public function postCheckneareraddress(Request $request,$auth = false)
    {
        if(\Auth::check() || $auth != false) {
            $cookie_id  = (\AbserveHelpers::getCartCookie() != '') ?  \AbserveHelpers::getCartCookie() : \AbserveHelpers::setCartCookie();
            $user_id    = $auth!=false ? $auth : \Auth::user()->id;
            $request->deliverDate = strtr($request->deliverDate, '/', '-');
            $delivertype= ($request->deliverType != '') ? $request->deliverType : 'asap';
            $deliverdate= ($request->deliverDate != '') ? date('Y/m/d',strtotime($request->deliverDate)) : NULL;
            $delivertime= ($request->deliverTime != '') ? $request->deliverTime : '';
            $ucart      = \AbserveHelpers::uCartQuery($user_id, $cookie_id);
            $ucartupdate    = clone $ucart;
            // $cartItems   = clone ($ucart);
            $selhtml        = $html = $distance = $status = '';
            $aRestaurant    = \DB::table('abserve_restaurants')->where('id',$request->res_id)->first();

            $authid     = $user_id;
            $updateVal['distance_km'] = 0;
            $updateVal['duration'] = 0;
            $updateVal['address_id'] = 0;
            $updateVal['ordertype'] = $request->ordertype;
            $updateVal['delivertype'] = $delivertype;
            $updateVal['deliverdate'] = $deliverdate;
            $updateVal['delivertime'] = $delivertime;
            $ucartupdate->update($updateVal);
            $addressCheck = false;
            $addressInsert = false;
            if ($request->ordertype != 'pickup') {
                $msg = 'success';
                $addressCheck = true;
                $dist['from_address']   = $aRestaurant->location;
                $dist['type']           = 'address';
                $ordercon = new ordercon;
                if($request->address_id > 0){
                    $aUserAddress   = Useraddress::find($request->address_id);
                    $addressID      = $request->address_id;
                    $dist['to_address']     = $aUserAddress->address;
                } else {
                    $adrsExist = Useraddress::where('user_id',$user_id)->where('address',$request->a_addr)/*->where('lat',$request->a_lat)->where('lang',$request->a_lang)*/->where('del_status','0')->first();
                    $dist['to_address']     = $request->a_addr;
                    if(empty($adrsExist)){
                        $addressID = $request->address_id;
                        $addressInsert = true;
                    } else {
                        $addressID = $adrsExist->id;
                        Usercart::where('user_id',$user_id)->update(array("address_id"=>$addressID));
                        $aUserAddress = Useraddress::find($addressID);
                        if(!empty($aUserAddress)) {
                            Useraddress::where('id',$addressID)->where('user_id',$user_id)->update(["lat"=>$request->a_lat,"lang"=>$request->a_lang,"building"=>$request->building,"landmark"=>$request->landmark,"address_type"=>$request->address_type]);
                        }
                    }
                }
            } else if($request->ordertype == 'pickup') {
                $msg = 'success';
                $selhtml    = '<b class="selected_address_type" data-id="'.$request->address_id.'" id="sel_add" >blank</b>';
            }
            if($addressCheck){
                $aDistanceDatas = $ordercon->calculate_distance($dist);
                if($aDistanceDatas['status']){
                    $validKm = \AbserveHelpers::site_setting1('delivery_distance');
                    $distance = $aDistanceDatas['total_km'];
                    if($distance <= $validKm){
                        if($addressInsert){
                            $aUserAddress = new Useraddress;
                            $aUserAddress->user_id = $authid;
                            $aUserAddress->lat = $request->a_lat;
                            $aUserAddress->lang = $request->a_lang;
                            $aUserAddress->address_type = $request->address_type;
                            $aUserAddress->landmark = $request->landmark;
                            $aUserAddress->building = $request->building;
                            $aUserAddress->address = $request->a_addr;
                            if($auth != false) {
                                $aUserAddress->hide = 1;
                            }
                            $aUserAddress->created_at = date('Y-m-d H:i:s');
                            $aUserAddress->updated_at = date('Y-m-d H:i:s');
                            $aUserAddress->save();
                        } else {
                            $aUserAddress = Useraddress::find($addressID);
                        }
                        $duration_text ='';
                        $html .= '<div class="col-md-6 col-sm-6 col-xs-12"><label class="delivery_new_box plain_border" id="plain_border_'.$aUserAddress->id.'" data-id="'.$aUserAddress->id.'" for="'.$aUserAddress->id.'"><b>'.$aUserAddress->address_type_text.'</b><address>'.$aUserAddress->building.$aUserAddress->landmark.$aUserAddress->address.'</address><strong>'.$duration_text.' </strong><div class="green_box">Deliver Here</div><input id="'.$aUserAddress->id.'" class="hid_adrs_id" type="radio" name="address" value="'.$aUserAddress->id.'" style="display:none;"></label></div>';
                        $response['html'] = $html;
                        $seconds        = $aDistanceDatas['duration'] + ($aRestaurant->delivery_time * 60);
                        $duration_text  = $ordercon->getReadabletimeFromSeconds($seconds);
                        $updateVal['distance_km']   = $distance;
                        $updateVal['duration']      = $aDistanceDatas['duration'];
                        $updateVal['address_id']    = $aUserAddress->id;
                        $adrstype   = ($aUserAddress->address_type == '1') ? 'Home' : (($aUserAddress->address_type == '2') ? 'Work' : 'Others');
                        $building = ($aUserAddress->building != '') ? $aUserAddress->building.', ' : '';
                        $landmark = ($aUserAddress->landmark != '') ? $aUserAddress->landmark.', ' : '';
                        $address    = ($building.$landmark.$aUserAddress->address);
                        $selhtml    .= '
                        <b class="selected_address_type">'.$aUserAddress->address_type_text.'</b>
                        <address class="selected_address_adrs"  data-id="'.$aUserAddress->id.'" id="sel_add" >'.$address.'</address>
                        <b class="selected_address_time">'.$duration_text.'</b>';
                        $carts      = \DB::table('abserve_user_cart')->select('*')->where('user_id',$authid)->where('res_id',$request->res_id)->get();
                        $msg        = 'success';
                        $response['address_id'] = $aUserAddress->id;

                    } else {
                        $msg = 'Sorry, we are unable to provide service at your location at this time!';
                    }
                } else {
                    $msg = 'Provide a Valid Address';
                }
            }
            $ucartupdate->update($updateVal);
            if($msg == 'success'){
                $response['ordertype']  = $request->ordertype;
                $response['selhtml']    = $selhtml;
                $aCartPriceInfo         = \AbserveHelpers::getCheckoutcartprice($authid,$request->res_id);
                $cartInfo = $ucart->first();
                $aCartPriceInfo['wallet_used']  = $cartInfo->wallet;
                $response['cart']       = (string) view('front.cart.checkoutcart',$aCartPriceInfo);
                $response['mol_amount'] = $aCartPriceInfo['grandTotal'];
                $amount                 = $response['mol_amount'];
                $orderid                = $request->mol_orderid;
                $response['mol_vcode']  = \AbserveHelpers::get_MolVcode($amount,$orderid);
                $response['distance']   = $distance;
                $response['status']     = $status;
            }
        } else {
            $msg = 'unauthorized';
        }
        $response['msg'] = $msg;
        return Response::json($response);
    }

    public function postShowavailabletime(Request $request)
    {

        if($request->week_id==''){
                $date=$request->date;
                $currentDay = date('D',strtotime($date));
                $aDayInfo = \DB::table('abserve_days')->select('*')->where('value',$currentDay)->first();
                $request['week_id']=$aDayInfo->id;
                $request['current_time']=date('H')*60+date('i')*30;
            }
        $resStatus  = \AbserveHelpers::getOpenClosingStatus($request->res_id,$request->week_id,$request->date);
        $option_html= '';
        if($resStatus['timevalid'] == 1) {

            $field = \Auth::check() && \Auth::user()->id > 0 ? 'user_id' : 'cookie_id';
            $fieldvalue = \Auth::check() && \Auth::user()->id > 0 ? \Auth::user()->id : $cookie_id;

            $abserve_user_cart=\DB::table('abserve_user_cart')->where('res_id',$request->res_id)->where($field,$fieldvalue)->first();

            $time           = \DB::table('abserve_time')->select('*')->get();
            $avail          = \DB::table('abserve_restaurant_timings')->where('res_id',$request->res_id)->where('day_id',$request->week_id)->select('*')->first();
            $start_time     = \DB::table('abserve_time')->select('*')->where('name',$avail->start_time1)->first();
            $endtime        = \DB::table('abserve_time')->select('*')->where('name',$avail->end_time1)->first();
            $datetime = $request->date;
            $datetime =  preg_replace('/( \(.*)$/','',$datetime);
            $timestamp = strtotime($datetime);
            $date_cur = date('Y-m-d', $timestamp);
            // echo "<pre>";echo strtotime($date_cur);exit();
            for($i=0;$i<2;$i++){
                if( ($avail->start_time1=='12:00am' && $avail->end_time1=='12:00am') || time()< strtotime($date_cur)){
                    foreach($time as $ky => $times){
                        if($abserve_user_cart && $abserve_user_cart->delivertime!=''){
                            $check =  ($abserve_user_cart->delivertime == $times->name) ? 'selected' : '';
                        }else{
                            $check =  ($ky == 0) ? 'selected' : '';
                        }
                            
                            $option_html.='<option '.$check.' value="'.$times->name.'">'.$times->name.'</option>';
                    }
                }else{
                    foreach($time as $ky => $times){
                            $current_time = empty($request->current_time) ? 0:$request->current_time;
                        if($start_time->time <= $times->time && $endtime->time >= $times->time && $times->time>=$current_time && $times->time-$current_time >= 720){
                            if($abserve_user_cart && $abserve_user_cart->delivertime!=''){
                                $check =  ($abserve_user_cart->delivertime == $times->name) ? 'selected' : '';
                            }else{
                                $check =  ($ky == 0) ? 'selected' : '';
                            }
                            $option_html.='<option '.$check.' value="'.$times->name.'">'.$times->name.'</option>';
                        }
                    }
                }
                if(!empty($avail->start_time2) && !empty($avail->end_time2)){
                    $start_time = \DB::table('abserve_time')->select('*')->where('name',$avail->start_time2)->first();
                    $endtime = \DB::table('abserve_time')->select('*')->where('name',$avail->end_time2)->first();
                }
            }
            $response['msg'] = 'opened';
        } else {
            $response['msg'] = 'closed';
        }
        $unavailDates = array();
        if(!empty($resStatus['datesunavail'])) {
            foreach ($resStatus['datesunavail'] as $value) {
                $unavailDates[] = date('m/d/Y',strtotime($value->date));
            }
        }
        $response['datesunavail']   = $unavailDates;
        $response['option_html']    = $option_html;
        return \Response::json($response);
    }

    public function postAddtofavorites(Request $request)
    {
        if(!empty($request->userid)) {         
            $values = array("user_id"=>$request->userid,"resid"=>$request->resid);
            $wishexist = collect(Favorites::select('id')->where('user_id',$request->userid)->where('resid',$request->resid)->first());
            $wish = $request->wishval;
            if($wish == 1){
                if(count($wishexist) == 0){
                    Favorites::insert($values);
                }
                echo 1;exit;
            } else {
                if(count($wishexist) > 0){
                    Favorites::where('user_id',$request->userid)->where('resid',$request->resid)->delete();
                }
                echo 2;exit;
            }
        }else{
            echo 0;exit;
        }
    }
}
