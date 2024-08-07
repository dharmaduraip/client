<?php

namespace App\Http\Controllers\V1\Common\Admin\Resource;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Traits\Actions;
use App\Models\Common\Notifications;
use App\Helpers\Helper;
use Auth;
use App\Models\Common\City;
use App\Models\Common\State;
use App\Models\Common\User;
use App\Models\Common\Provider;
use DB;

class NotificationController extends Controller
{
  

    use Actions;

    private $model;
    private $request;

    public function __construct(Notifications $model)
    {
        $this->model = $model;
    }

  

     public function index(Request $request)
    {
        $datum = Notifications::whereHas('service' ,function($query){  
            $query->where('status',1);  
        })->where('company_id', Auth::user()->company_id);

        if($request->has('search_text') && $request->search_text != null) {
            $datum->Search($request->search_text);
        }

        if($request->has('order_by')) {
            $datum->orderby($request->order_by, $request->order_direction);
        }

        
        if($request->has('page') && $request->page == 'all') {
            $data = $datum->get();
        } else {
            $data = $datum->paginate(10);
        }
        if($request->has('userId')) {
            if ($request->userType = "provider") {
                $provider = Provider::where('id',$request->userId)->update(['seen' => '0']);
            }
            if ($request->userType = "user") {
                $provider = User::where('id',$request->userId)->update(['seen' => '0']);
            }
        }
        
        return Helper::getResponse(['data' => $data]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'notify_type' => 'required', 
            'service' => 'required',          
            'image' => 'required|mimes:jpeg,jpg,png|max:5242880',           
        ]);
        try{
            $Notifications = new Notifications;
            $Notifications->notify_type = $request->notify_type;
            if($request->hasFile('image')) {
                $Notifications->image = Helper::upload_file($request->file('image'), 'Notification/image');
            }
            if ($request->service == "user") {
                $user = User::where('company_id',1)->update(['seen' => DB::raw('seen+1')]);
            }elseif ($request->service == "provider") {
                $provider = Provider::where('company_id',1)->update(['seen' => DB::raw('seen+1')]);
            }
            else {
                $user = User::where('company_id',1)->update(['seen' => DB::raw('seen+1')]);
                $provider = Provider::where('company_id',1)->update(['seen' => DB::raw('seen+1')]);
            }
            $Notifications->company_id = Auth::user()->company_id;  
            $Notifications->service = $request->service;  
            $Notifications->descriptions = $request->descriptions;                                      
            $Notifications->title = $request->title;                                      
            $Notifications->expiry_date = date('Y-m-d H:i:s', strtotime($request->expiry_date));
            $Notifications->status = $request->status;                    
            $Notifications->save();
            return Helper::getResponse(['status' => 200, 'message' => trans('admin.create')]);
        } 
        catch (\Throwable $e) {
            \Log::info($e);
            return Helper::getResponse(['status' => 404, 'message' => trans('admin.something_wrong'), 'error' => $e->getMessage()]);
        }
    }
    public function show($id)
    {
        try {
            $notification = Notifications::findOrFail($id);
            $expiry_date=date('d/m/Y',strtotime($notification->expiry_date));
            return Helper::getResponse(['data' => $notification]);
        } catch (\Throwable $e) {
            return Helper::getResponse(['status' => 404,'message' => trans('admin.something_wrong'), 'error' => $e->getMessage()]);
        }
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'notify_type' => 'required',
            'service' => 'required',   
        ]);
        try {
            $Notifications = Notifications::findOrFail($id);
            $Notifications->notify_type = $request->notify_type;            
            if($request->hasFile('image')) {
                $Notifications->image = Helper::upload_file($request->file('image'), 'Notification/image');
            }
            $Notifications->service = $request->service;  
            $Notifications->descriptions = $request->descriptions; 
            $Notifications->title = $request->title;
            $Notifications->expiry_date = date('Y-m-d H:i:s',strtotime($request->expiry_date));
            $Notifications->status = $request->status;                    
            $Notifications->save();
            return Helper::getResponse(['status' => 200, 'message' => trans('admin.update')]);
           
            } catch (\Throwable $e) {
                return Helper::getResponse(['status' => 404,'message' => trans('admin.something_wrong'), 'error' => $e->getMessage()]);
            }
    }
    public function destroy($id)
    {
        return $this->removeModel($id);
    }

    public function shopNotification(Request $request)
    {
        try{
             $timezone=(Auth::guard('shop')->user()->city_id) ? City::find(Auth::guard('shop')->user()->city_id)->state->timezone : '';

            $jsonResponse = [];
            if($request->has('limit')) {
                $query = Notifications::where('company_id', Auth::guard('shop')->user()->company_id)->whereIn('notify_type',['shop','all']);
                $query->where(function ($q) {
                    return $q->where('user_id', Auth::guard('shop')->user()->id)->orwhereNull('user_id');
                });
                $notifications = $query->where('status','active')->take($request->limit)->offset($request->offset)->orderby('id','desc')->get(); 
               
            }else{
                $query = Notifications::where('company_id', Auth::guard('shop')->user()->company_id)->whereIn('notify_type',['shop','all']);
                $query->where(function ($q) {
                    return $q->where('user_id', Auth::guard('shop')->user()->id)->orwhereNull('user_id');
                });
                $query->update(['is_viewed' => 1]);
                $notifications = $query->where('status','active')->orderby('id','desc')->paginate(10); 



            }
            
            if(count($notifications) > 0){
                foreach($notifications as $k=>$val){
                $notifications[$k]['created_at']=(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$val['created_at'], 'UTC'))->setTimezone($timezone)->format('Y-m-d H:i:s');  
                // $notifications[$k]['time_at']=$notifications[$k]['created_at']->diffForHumans();  
                $notifications[$k]['time_at']=\Carbon\Carbon::createFromTimeStamp(strtotime($notifications[$k]['created_at']))->diffForHumans();
                $notifications[$k]['time_at']=\Carbon\Carbon::parse($notifications[$k]['created_at'])->diffForHumans();
                } 
           } 

       

            $jsonResponse['total_records'] = count($notifications);
            $jsonResponse['notification'] = $notifications;
        }catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
        return Helper::getResponse(['data' => $jsonResponse]);
    }

     public function shopNotificationCount(Request $request)
    {
        try{
            $timezone=(Auth::guard('shop')->user()->city_id) ? City::find(Auth::guard('shop')->user()->city_id)->state->timezone : '';

            $jsonResponse = [];
  
            $query = Notifications::where('company_id', Auth::guard('shop')->user()->company_id)->whereIn('notify_type',['shop','all']);
            $query->where(function ($q) {
                return $q->where('user_id', Auth::guard('shop')->user()->id)->orwhereNull('user_id');
            });
            $notifications = $query->where('status','active')->where('is_viewed',0)->orderby('id','desc')->get(); 

            $jsonResponse['total_count'] = count($notifications);

        }catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')]);
        }
        return Helper::getResponse(['data' => $jsonResponse]);
    }


}
