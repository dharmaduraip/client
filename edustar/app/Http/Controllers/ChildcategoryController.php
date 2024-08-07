<?php

namespace App\Http\Controllers;

use App\ChildCategory;
use Illuminate\Http\Request;
use DB;
use App\SubCategory;
use App\Categories;
use Auth;
use Session;
use App\Course;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class ChildcategoryController extends Controller
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
    public function index()
    {
        abort_if(!auth()->user()->can('childcategories.view'),403,'User does not have the right permissions.');
        $category = Categories::where('status','1')->get();
        $subcategory = SubCategory::where('status','1')->get();
        $childcategory = ChildCategory::all();
        return view('admin.category.childcategory.index',compact('childcategory', 'category', 'subcategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('childcategories.create'),403,'User does not have the right permissions.');

        $category = Categories::all();
        $childcategory = SubCategory::all();
        return view('admin.category.childcategory.insert',compact('category','childcategory')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!auth()->user()->can('childcategories.create'),403,'User does not have the right permissions.');

        $request->validate([
            "title"=>"required|unique:child_categories",
            "slug"=>"required",
            "icon"=>"required",
            "category_id"=>"required",
            "subcategories"=>"required"
        ]);
        
        $input = $request->all();
        // echo"<pre>";print_r($input);exit();
        $input['category_id'] = $request->category_id;
        $input['subcategory_id'] = $request->subcategories;
        $input['title'] = $request->title;
        $input['icon'] = $request->icon;
        $input['slug'] = $request->slug; 
       
        $data = ChildCategory::create($input);


        if(isset($request->status))
        {
            $data->status = '1';
        }
        else
        {
            $data->status = '0';
        }

        $data->save();

        return redirect ('childcategory');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\childcategory  $childcategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(!auth()->user()->can('childcategories.view'),403,'User does not have the right permissions.');

        $cate = ChildCategory::find($id);
        return view('admin.category.childcategory.edit',compact('cate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\childcategory  $childcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(childcategory $childcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\childcategory  $childcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        abort_if(!auth()->user()->can('childcategories.edit'),403,'User does not have the right permissions.');

        $data = ChildCategory::findorfail($id);
        $input = $request->all();
        $input['category_id'] = $request->category_id;
        $input['subcategory_id'] = $request->subcategories;
        $input['title'] = $request->title;
        $input['icon'] = $request->icon;
        $input['slug'] = $request->slug; 
    

        if(isset($request->status))
        {
            $input['status'] = '1';
        }
        else
        {
            $input['status'] = '0';
        }

        
        $data->update($input);
        Session::flash('success',trans('flash.Updated Successfully'));


        return redirect ('childcategory');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\childcategory  $childcategory
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        abort_if(!auth()->user()->can('childcategories.delete'),403,'User does not have the right permissions.');

        if(Auth::User()->role == "admin"){

            $course = Course::where('childcategory_id', $id)->get();

            if(!$course->isEmpty())
            {
                return back()->with('delete',trans('flash.CannotDeleteCategory'));
            }
            else
            {
                DB::table('child_categories')->where('id',$id)->delete();
                return back()->with('delete',trans('flash.DeletedSuccessfully'));
            }
        }
     
        return back()->with('delete', trans('Admin only have delete permission.'));
    }
    public function status(Request $request)
    {
        abort_if(!auth()->user()->can('childcategories.update'),403,'User does not have the right permissions.');


        $data = ChildCategory::find($request->id);
        $data->status = $request->status;
        $data->save();
        return back()->with('success',trans('flash.Updated Successfully'));
        
        
    }
    public function bulk_delete(Request $request)
    {
        abort_if(!auth()->user()->can('childcategories.delete'),403,'User does not have the right permissions.');

        $validator = Validator::make($request->all(), ['checked' => 'required']);
        if ($validator->fails()) {
            return back()->with('error',trans('Please select field to be deleted.'));
        }
        $course = Course::whereIn('childcategory_id', $request->checked)->get();
        if (count($course) > 0) 
        {
            return back()->with('delete', trans('flash.CannotDeleteCategory'));
        }

        ChildCategory::whereIn('id',$request->checked)->delete();

        return back()->with('delete',trans('Selected ChildCategory has been deleted.'));          
   }

   public function catAlertstatus(Request $request)
   {
        $course = Course::where('childcategory_id', $request->ccat_id)->first();
        if(!empty($course))
        {
            return response()->json(['msg' => 'active']);
        }
        else
        {
            return response()->json(['msg' => 'deactive']);
        }
   }


}
