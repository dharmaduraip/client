<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Instructor;
use DB;
use App\User;
use Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Auth;

class InstructorRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:instructorrequest.view', ['only' => ['index']]);
        $this->middleware('permission:instructorrequest.create', ['only' => ['create','store']]);
        $this->middleware('permission:instructorrequest.edit', ['only' => ['edit','update']]);

    }
    public function index()
    {
        $items = Instructor::where('status', '0')->get();
        return view('admin.instructor.instructor_request.index',compact('items'));
    }

    public function create()
    {
        $data = Instructor::all();
        return view('admin.instructor.instructor_request.create',compact('data'));
    }

    public function edit($id)
    {
        $show = Instructor::where('id', $id)->first();
        return view('admin.instructor.instructor_request.view',compact('show'));
    }

    public function update(Request $request, $id)
    {
        $data = Instructor::findorfail($id);
        $input['status'] = $request->status;
 
        if(isset($request->search_enable))
        { 
            $show = User::where('id', $request->user_id)->first();
            User::where('id', $request->user_id)
                    ->update(['role' => $request->role]);
            Instructor::where('user_id', $request->user_id)
                    ->update(['status' => 1]);
            $show->removeRole('User');
            $show->assignRole('Instructor');
            
        }
        else
        {
            $show = User::where('id', $request->user_id)->first();
            $input['role'] = 'user';
            
            User::where('id', $request->user_id)
                    ->update(['role' => 'user']);
            Instructor::where('user_id', $request->user_id)
                    ->update(['status' => 0]);
            $show->removeRole('Instructor');
            $show->assignRole('User');
        }
  

        // $show = User::where('id', $request->user_id)->first();
        // $input['detail'] = $request->detail;
        // $input['mobile'] = $request->mobile;
        
        // User::where('id', $request->user_id)
        //             ->update(['detail' => $request->detail, 'mobile' => $request->mobile ]);

        // return redirect()->route('requestinstructor.index');
        return redirect()->back()->with('success',trans('Staus Changed Successfully'));
    }

    public function destroy($id)
    {
        DB::table('instructors')->where('id',$id)->delete();
        return back();
    }

    public function allinstructor()
    {
        $items = Instructor::all();
        return view('admin.instructor.all_instructor.index',compact('items'));
    }

    public function instructorpage()
    {
       
        return view('front.instructor');
    }


    public function instructor(Request $request)
    {
        $users = Instructor::where('user_id', $request->user_id)->get();

        if(!$users->isEmpty()){
            return back()->with('delete',trans('flash.AlreadyRequested'));  
        }
        else{

            $user = User::where('id', Auth::User()->id)->first();

            $request->validate([
              'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:15|unique:users,mobile,'.$user->id,
              'file' => 'required',
              'image' => 'required|mimes:jpg,jpeg,png,webp'
            ]);

            $input = $request->all();


            if($file = $request->file('image'))
            {
                if ($file = $request->file('image'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move(public_path().'/images/instructor', $name);
                    $input['image'] = $name;
                }
            }


            if($file = $request->file('file'))
            {
                if($file = $request->file('file'))
                {
                    $name = time().$file->getClientOriginalName();
                    $file->move(public_path().'/files/instructor/',$name);
                    $input['file'] = $name;
                }
            }

            $data = Instructor::create($input);
            $data->save(); 
        }

        return back()->with('success',trans('flash.RequestSuccessfully'));

    }
}
