<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use App\Models\Front\Restaurant;


class SearchDishController extends Controller
{
    public function getSearchdish()
    {
        return view('front.search.searchdish');
    }

    public function searchDishResult(Request $request)
    {
        $search   = $request->search;
        $res_data = Restaurant::where(function($qry) use($search){
            $qry->where('name','like','%'.$search.'%')->where('status','1')->where('admin_status','approved')
            ->orWhereHas('getRestuarantItems',function ($query) use($search){
                $query->where('food_item','like','%'.$search.'%')->where('approveStatus','Approved')->where('del_status','0')->groupBy('restaurant_id');
            });   
        })->with(['getRestuarantItems' => function ($qury) use($search){
            $qury->where('food_item','like','%'.$search.'%')->where('approveStatus','Approved')->where('del_status','0')->groupBy('restaurant_id');
        }])->get();
        $res['res_data']  = $res_data->append(['availability','cuisine_text','time_text','overall_rating']);
        $html             = (string) view('front.search.searchdishview',$res);
        $response['html'] = $html;
        return Response::json($response);
    }
}
