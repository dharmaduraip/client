<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ads;
use Image;
use DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;


class AdsController extends Controller
{
  public function __construct()
    {
        $this->middleware('permission:player-settings.advertise.view', ['only' => ['getAds','getAdsSettings']]);
        $this->middleware('permission:player-settings.advertise.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:player-settings.advertise.edit', ['only' => ['showEdit', 'updateAd','updateADSOLO','updatePopAd','updateVideoAD']]);
        $this->middleware('permission:player-settings.advertise.delete', ['only' => ['destroy', 'bulk_delete']]);
    
    }
    public function getAds()
    {
    	return view('advertise.index');
    }

    public function create()
    {
      return view('advertise.create');
    }

    public function showEdit($id)
    {
      $ad = Ads::findorfail($id);
      return view('advertise.edit',compact('ad'));
    }

    public function store(Request $request)
    {
    	$newad = new Ads;
        
        if($request->ad_location == "skip")
        {
            $newad->ad_type = "video";
        }else
        {
            $newad->ad_type = "image";
        }
    	
    	  $newad->ad_location = $request->ad_location;
        $newad->ad_target = $request->ad_target;
        
       
       
    	
    	if($request->ad_location == "popup" || $request->ad_location == "onpause")
    	{

    	if ($file = $request->file('ad_image'))
         {

          $request->validate([
          'ad_image' => 'image:png,jpg,jpeg | max:3500'
        ]);

		  $name = time().preg_replace('/\s+/', '', $file->getClientOriginalName());
          $file->move(public_path().'/adv_upload/image', $name);
          $newad->ad_image = $name;
          $newad->ad_video = "no";

          if($request->ad_location == "popup")
          {
             $newad->time = $request->time;
             $newad->endtime = $request->endtime;
          }else
          {
             $newad->time = "00:00:00";
             $newad->endtime = "00:00:00";
          }
         
         
         }

    	}

    	if($request->ad_location == "skip")
    	{

        if($request->checkType == "upload")
        {


    		
    	if ($file = $request->file('ad_video'))
         {

    		$request->validate([
        'ad_video' => 'mimes:mp4,mov,ogg | max:10000',
        'ad_hold' => 'int'
        ],[
          'ad.hold' => 'Ad Hold time must be in valid format'
        ]);
		  $name = time().preg_replace('/\s+/', '', $file->getClientOriginalName());
          $file->move(public_path().'/adv_upload/video', $name);
          $newad->ad_video = $name;
          $newad->ad_image = "no";
          $newad->ad_hold = $request->ad_hold;
          $newad->time = $request->time;
          $newad->endtime = null;
         }

        }
        elseif($request->checkType == "url")
        {
          $newad->ad_video = "no";
          $newad->ad_image = "no";
          $newad->ad_url = $request->ad_url;
          $newad->ad_hold = $request->ad_hold;
          $newad->time = $request->time;
          $newad->endtime = null;
        }

    	}


    	$newad->save();
      return redirect('admin/ads')->with('success', trans('flash.CreatedSuccessfully'));


    }

    public function getAdsSettings()
    {
        return view('advertise.adsetting');
    }

    function updateAd(Request $request)
    {
        if($request->timer_check == "no")
        {
            $ad = DB::table('ads')->where('ad_type','video')->update(array('time' => '00:00:00'));
        }
        elseif($request->timer_check == "yes")
        {
            if($request->ad_timer !="")
            {
              $ad = DB::table('ads')->where('ad_type','video')->update(array('time' => $request->ad_timer));
            }
            
        }

         if($request->ad_hold !="")
         {
          $request->validate([
            'ad_hold' => 'int'
          ],
            ['ad.hold' => 'Invalid format']
          );

          $ad = DB::table('ads')->where('ad_type','video')->update(array('ad_hold' => $request->ad_hold));
         }
        

        return back()->with('success','Ad Settings Upated');
    }

    function updatePopAd(Request $request)
    {
      if($request->time !="")
      {
      $ad2 = DB::table('ads')->where('ad_location','popup')->update(array('time' => $request->time));
      }

      if($request->endtime !="")
      {
        $ad = DB::table('ads')->where('ad_location','popup')->update(array('endtime' => $request->endtime));
      }
      

      return back()->with('success',trans('flash.UpdatedSuccessfully'));
    }

    function delete($id)
    {
      $ad = Ads::findorfail($id);
      
      if($ad->ad_type == "image")
      {
        unlink(public_path().'/adv_upload/image/'.$ad->ad_image);
        $ad->delete();
      }
      elseif($ad->ad_type == "video")
      {
         if($ad->ad_video !="no")
        {
          unlink(public_path().'/adv_upload/video/'.$ad->ad_video);
          $ad->delete();
        }
        else
        {
          $ad->delete();
        }
      }
     
      
        return back()->with('delete', trans('flash.DeletedSuccessfully'));
    }

    function updateADSOLO(Request $request, $id)
    {

      $request->validate([
        'ad_image' => 'image:png,jpg,jpeg | max:3500'
      ]);

      $ad = Ads::findorfail($id);

      $ad->ad_target = $request->ad_target;

      if ($file = $request->file('ad_image'))
         {

          unlink(public_path().'/adv_upload/image/'.$ad->ad_image);

          $name = time().preg_replace('/\s+/', '', $file->getClientOriginalName());

          $file->move(public_path().'/adv_upload/image', $name);
          
          $ad->ad_image = $name;
      

          }

          $ad->save();

          return redirect()->route('ads')->with('success', trans('flash.UpdatedSuccessfully'));


    }

    function updateVideoAD(Request $request, $id)
    {

      $request->validate([
        'ad_video' => 'mimes:mp4,mov,ogg | max:10000'
      ]);

      $ad = Ads::findorfail($id);

      $ad->ad_target = $request->ad_target;

      if($ad->ad_video == "no")
      {
        $ad->ad_url = $request->ad_url;
      }

       if ($file = $request->file('ad_video'))
         {

          unlink(public_path().'/adv_upload/video/'.$ad->ad_video);

          $name = time().preg_replace('/\s+/', '', $file->getClientOriginalName());

          $file->move(public_path().'/adv_upload/video', $name);
          
          $ad->ad_video = $name;
      

          }

          $ad->save();

          return redirect()->route('ads')->with('success', trans('flash.UpdatedSuccessfully'));

    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('delete', 'Pleaseselectdelete');
        }

        foreach ($request->checked as $checked) {

            $ads = Ads::findOrFail($checked);

            $ads::destroy($checked);

            if($ads->ad_type == "image" && $ads->ad_video =="no")
            {
              unlink(public_path().'/adv_upload/image/'.$ads->ad_image);
            }

            if($ads->ad_type == "video" && $ads->ad_image =="no" && $ads->ad_url == "")
            {
              unlink(public_path().'/adv_upload/video/'.$ads->ad_video);
            }


        }

        return back()->with('delete', trans('flash.DeletedSuccessfully'));
    }
}
