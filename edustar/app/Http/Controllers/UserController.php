<?php

namespace App\Http\Controllers;

use App\Allcity;
use App\Allstate;
use App\Allcountry;
use App\Answer;
use App\BBL;
use App\BundleCourse;
use App\Cart;
use App\City;
use App\Country;
use App\Course;
use App\CourseProgress;
use App\Instructor;
use App\Meeting;
use App\Order;
use App\Question;
use App\ReviewRating;
use App\State;
use App\User;
use App\Wishlist;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use Session;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Response;
use Illuminate\Support\Str;


class UserController extends Controller
{

    public function __construct()
    {
        return $this->middleware('auth');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function viewAllUser(Request $request)
    {
        abort_if(!auth()->user()->can('users.view'), 403, 'User does not have the right permissions.');
         $data = User::with(['roles'])->select('*');
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {

                    $chk = "<div class='inline'>
                              <input type='checkbox' form='bulk_delete_form' class='filled-in material-checkbox-input' name='checked[]'' value='$row->id' id='checkbox$row->id'>
                              <label for='checkbox$row->id' class='material-checkbox'></label>
                            </div>";

                    return $chk;
                })
                ->editColumn('image', 'admin.user.image')
                ->editColumn('name', 'admin.user.detail')
                ->addColumn('role', function ($row) {
                
                    return $row->roles[0]->name ?? 'No role set';

                })
                ->editColumn('loginasuser', 'admin.user.login')
                ->editColumn('status', 'admin.user.status')
                ->editColumn('action', 'admin.user.action')
                ->rawColumns(['checkbox', 'image', 'name', 'role', 'loginasuser', 'status', 'action'])
                ->make(true);
        }
        return view('admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        abort_if(!auth()->user()->can('users.create'), 403, 'User does not have the right permissions.');
        $cities = Allcity::all();
        $states = Allstate::all();
        $countries = Allcountry::all();
        $roles = Role::all();
        return view('admin.user.adduser')->with(['cities' => $cities, 'states' => $states, 'countries' => $countries, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        abort_if(!auth()->user()->can('users.create'), 403, 'User does not have the right permissions.');
        $data = $this->validate($request, [
            'fname' => 'required|regex:/^[\pL\s\-]+$/u',
            'lname' => 'required|regex:/^[\pL\s\-]+$/u',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:15|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20',
            'role' => 'required',
            'user_img' => 'mimes:jpg,jpeg,png,bmp,tiff',
        ]);
        
        $input = $request->all();
        if ($file = $request->file('user_img')) {
            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/user_img/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image, 72);
            $input['user_img'] = $image;

        }
        $input['status'] = isset($request->status) ? 1 : 0;
        $input['password'] = Hash::make($request->password);
        $input['detail'] = $request->detail;
        $input['email_verified_at'] = \Carbon\Carbon::now()->toDateTimeString();

        if ($request->role == 'user') {

            $input['role'] = 'user';

        } elseif ($request->role == 'instructor') {
            $input['role'] = 'instructor';
        } else {
            $input['role'] = 'admin';
        }

        $data = User::create($input);

        $data->assignRole($request->role);

        $data->save();

        Session::flash('success', trans('flash.AddedSuccessfully'));
        return redirect('user');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */

    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        abort_if(!auth()->user()->can('users.edit'), 403, 'User does not have the right permissions.');
        $user = User::findorfail($id);
        $countries = Allcountry::all();
        $states = Allstate::where('country_id',$user->country_id)->get();
        $cities = Allcity::where('state_id',$user->state_id)->get();
        $roles = Role::all();
        
        if (Auth::User()->role == 'admin') {
            $user = User::findorfail($id);
        } else {
            $user = User::where('id', Auth::User()->id)->first();
        }

        return view('admin.user.edit', compact('cities', 'states', 'countries', 'user', 'roles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        abort_if(!auth()->user()->can('users.edit'), 403, 'User does not have the right permissions.');

        $this->validate($request, [
            'user_img' => 'mimes:jpg,jpeg,png,bmp,tiff',
        ]);

        if (Auth::User()->role == 'admin') {
            $user = User::findorfail($id);
        } else {
            $user = User::where('id', Auth::User()->id)->first();
        }
        $request->validate([
            'fname' => 'required|regex:/^[\pL\s\-]+$/u',
            'lname' => 'required|regex:/^[\pL\s\-]+$/u',
            'mobile' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:6|max:15|unique:users,mobile,'.$user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required',
            
        ]);
        if (isset($request->update_pass)) {
            $request->validate([
                'password' => 'required|min:6|max:20|same:confirmpassword',
            ]);
        }
      
        if (config('app.demolock') == 0) {

            $input = $request->all();

            if ($file = $request->file('user_img')) {

                if ($user->user_img != null) {
                    $content = @file_get_contents(public_path() . '/images/user_img/' . $user->user_img);
                    if ($content) {
                        unlink(public_path() . '/images/user_img/' . $user->user_img);
                    }
                }

                $optimizeImage = Image::make($file);
                $optimizePath = public_path() . '/images/user_img/';
                $image = time() . $file->getClientOriginalName();
                $optimizeImage->save($optimizePath . $image, 72);
                $input['user_img'] = $image;

            }

            $verified = \Carbon\Carbon::now()->toDateTimeString();

            if (isset($request->verified)) {

                $input['email_verified_at'] = $verified;
            } else {

                $input['email_verified_at'] = null;
            }

            if (isset($request->update_pass)) {

                $input['password'] = Hash::make($request->password);
            } else {
                $input['password'] = $user->password;
            }

            if (isset($request->status)) {
                $input['status'] = '1';
            } else {
                $input['status'] = '0';
            }

            if ($request->role == 'user') {

                $input['role'] = 'user';

            } elseif ($request->role == 'instructor') {
                $input['role'] = 'instructor';
            } else {
                $input['role'] = 'admin';
            }

            $user->update($input);
            if ($request->role) {
            
                $user->syncRoles($request->role);
            }

            Session::flash('success', trans('flash.UpdatedSuccessfully'));

        } else {
            return back()->with('delete', trans('flash.DemoCannotupdate'));
        }

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(config('app.demolock') == 1){
            return back()->with('delete','Disabled in demo');
        }
        abort_if(!auth()->user()->can('users.delete'), 403, 'User does not have the right permissions.');
        $user = User::find($id);

        if (config('app.demolock') == 0) {

            if ($user->user_img != null) {

                $image_file = @file_get_contents(public_path() . '/images/user_img/' . $user->user_img);

                if ($image_file) {
                    unlink(public_path() . '/images/user_img/' . $user->user_img);
                }
            }

            $value = $user->delete();
            Course::where('user_id', $id)->delete();
            Wishlist::where('user_id', $id)->delete();
            Cart::where('user_id', $id)->delete();
            Order::where('user_id', $id)->delete();
            ReviewRating::where('user_id', $id)->delete();
            Question::where('user_id', $id)->delete();
            Answer::where('ans_user_id', $id)->delete();
            Meeting::where('user_id', $id)->delete();
            BundleCourse::where('user_id', $id)->delete();
            BBL::where('instructor_id', $id)->delete();
            Instructor::where('user_id', $id)->delete();
            CourseProgress::where('user_id', $id)->delete();

            if ($value) {
                session()->flash('delete', trans('flash.DeletedSuccessfully'));
                return redirect()->back();
            }
        } else {
            return back()->with('delete', trans('flash.DemoCannotupdate'));
        }
    }

    public function bulk_delete(Request $request)
    {
        abort_if(!auth()->user()->can('users.delete'), 403, 'User does not have the right permissions.');
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with('warning', 'Atleast one item is required to be checked');

        } else {
            $course = Course::whereIn('user_id',$request->checked)->get();
            if(count($course) > 0)
            {
                return back()->with('warning', 'you cannot delete these users. because, because, some user is already linked with course!');
            }

            User::whereIn('id', $request->checked)->delete();
            Session::flash('success', trans('Deleted Successfully'));
            return redirect()->back();

        }
    }

    public function status(Request $request)
    {
        // abort_if(!auth()->user()->can('users.update'), 403, 'User does not have the right permissions.');
        $user = User::find($request->id);
        
        if($request->status == "0")
        {
            if($user->role == "admin" || $user->role == "instructor")
            {
                $course = Course::where('user_id',$user->id)->first();
                if(!empty($course))
                {
                    return response()->json([
                        'msg' => 'active'
                    ]);
                }
            }
        }
        $user->status = $request->status;
        $user->save();
        return response()->json($request->all());
    }
    public function login($id)
    {
        $user = User::findOrFail($id);
        Auth::login($user);
        Session::flash('success', trans('LoginSuccessfully'));
        return redirect('/');
    }
    public function import()
    {
        return view('admin.user.import');
    }

    public function csvfileupload(Request $req){

    $user = User::all();
    $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
    fgetcsv($csvFile); 
         $file_data= array();
        $data = array();
            while(($line = fgetcsv($csvFile)) !== FALSE){
            $data= array(
           'fname' => $line[0],
            'lname' => $line[1],
            'phone_code' => "+".$line[2],
            'mobile' => $line[3],
            'email' => $line[4],
            'address' => $line[5],
            'status' => (int)$line[6],
            'role' => strtolower($line[7]),
            'password' => Hash::make($line[8])

           );
            
           $user = User::create($data);
           $user->assignRole('User');
           }
            fclose($csvFile);
            Session::flash('success', trans('Import Successfully'));
            return redirect('user');
        }

    public function verify_user()
    {
        $data['users'] = User::get();
        // echo"<pre>";print_r($data['users']->toArray());exit();
        return view('admin.user.verication',$data);
    }

    public function change_user_verify(Request $request)
    {

        $user = User::whereId($request->id)->first();
        if($user->is_verify=="0"){
            $data['is_verify'] = "1";
        } else {
            $data['is_verify'] = "0";
        }  
        User::whereId($request->id)->update($data);        
        Session::flash('success', trans('Verfiy Successfully'));

        if ($user->document_file != null) {

            $image_file = @file_get_contents(public_path().'/images/user_img/'.$user->document_file);

            if ($image_file) {
                unlink(public_path().'/images/user_img/'.$user->document_file);
            }
        }

        return true;
    }

    public function is_verifyuser(Request $request)
    {
        $user = User::whereId($request->user_id)->first();
        $user->is_verify = $request->is_verify;
        $user->save();
        return $user;
    }

    public function is_blockeduser(Request $request)
    {
        $user = User::whereId($request->user_id)->first();
        if($request->is_blocked  == "0")
        {
            $user->block_note = NULL;
        }
        $user->is_blocked = $request->is_blocked;
        $user->save();
        return $user;
    }

    public function user_blocked(Request $req)
    {
        $user = User::whereId($req->id)->first();
        if($user->is_blocked=='0' || $user->is_blocked == NULL){
            $data['is_blocked'] = "1";
        } else {
            $data['is_blocked'] = "0";
        }
        $data['block_note'] = $req->block_note; 
        User::whereId($req->id)->update($data);
        Session::flash('success', trans('Blocked Successfully'));
        return back();
    }
 }

