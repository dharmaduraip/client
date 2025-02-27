<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\SubCategory;
use App\ChildCategory;
use Session;
use App\Course;
use File;
use Image;
use App\CourseLanguage;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class CategoriesController extends Controller
{
  public function __construct()
  {
    $this->middleware('permission:categories.view', ['only' => ['index', 'show']]);
    $this->middleware('permission:categories.create', ['only' => ['store']]);
    $this->middleware('permission:categories.edit', ['only' => ['update', 'catstatus']]);
    $this->middleware('permission:categories.delete', ['only' => ['destroy', 'bulk_delete']]);
  }
  public function index()
  {
    $userid = auth()->user()->id;
    $cate = Categories::orderBy('position', 'ASC')->get();
    return view('admin.category.view', compact('cate'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // $data = $this->validate($request, [
    //   "title" => "required|unique:categories,title",
    //   "title.required" => "Please enter category title !",
    //   "title.unique" => "This Category name is already exist !",
    //   "slug" => "required",
    //   "icon" => "required",
    //   'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000'

    // ]);

    $rules = array(
      "title" => "required|unique:categories,title",
      "title.required" => "Please enter category title !",
      "title.unique" => "This Category name is already exist !",
      "slug" => "required",
      "icon" => "required",
      'image' => 'image|mimes:jpg,png,jpeg|max:2048');
    $attributes = array(
      'image' => 'Invalid Image Format');
    $validator = Validator::make($request->all(),$rules);
    $validator->setAttributeNames($attributes);
    if($validator->fails()){
      return back()->withErrors($validator)->withInput()->with('error_code',4);
    }
    $input = $request->all();
    // $slug = str_slug($input['title'],'-');
    // $input['slug'] = $slug;
    $input['position'] = (Categories::count() + 1);

    if ($file = $request->file('image')) {

      $path = 'images/category/';

      if (!file_exists(public_path() . '/' . $path)) {

        $path = 'images/category/';
        File::makeDirectory(public_path() . '/' . $path, 0777, true);
      }
      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/category/';
      $image = time() . $file->getClientOriginalName();
      $optimizeImage->save($optimizePath . $image, 72);

      $input['cat_image'] = $image;
    }

    $input['status'] = isset($request->status)  ? 1 : "0";
    $input['featured'] = isset($request->featured)  ? 1 : "0";
    $data = Categories::create($input);

    $data->save();
    Session::flash('success', trans('flash.Added Successfully'));
    return redirect('category');
  }


  /**
   * Display the specified resource.
   *
   * @param  \App\categories  $categories
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {

    $cate = Categories::find($id);
    return view('admin.category.update', compact('cate'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\categories  $categories
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\categories  $categories
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // $data = $this->validate($request, [
    //   "title" => "required|unique:categories,title",
    //   "title.required" => "Please enter category title !",
    //   "title.unique" => "This Category name is already exist !",
    //   "slug" => "required",
    //   "icon" => "required",
    //   'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
    // ]);

    $rules = array(
      "title" => "required|unique:categories,title",
      "title.required" => "Please enter category title !",
      "title.unique" => "This Category name is already exist !",
      "slug" => "required",
      "icon" => "required",
      'image' => 'image|mimes:jpg,png,jpeg|max:2048');
    $attributes = array(
      'image' => 'Invalid Image Format');
    $validator = Validator::make($request->all(),$rules);
    $validator->setAttributeNames($attributes);
    if($validator->fails()){
      return back()->withErrors($validator)->withInput()->with(['error_code'=>3,'cat_id'=>$id]);
    }

    $data = Categories::findorfail($id);
    $input = $request->all();

    // $slug = str_slug($input['title'],'-');
    // $input['slug'] = $slug;

    if ($file = $request->file('image')) {

      $path = 'images/category/';

      if (!file_exists(public_path() . '/' . $path)) {

        $path = 'images/category/';
        File::makeDirectory(public_path() . '/' . $path, 0777, true);
      }

      if ($data->cat_image != null) {
        $content = @file_get_contents(public_path() . '/images/category/' . $data->cat_image);
        if ($content) {
          unlink(public_path() . '/images/category/' . $data->cat_image);
        }
      }

      $optimizeImage = Image::make($file);
      $optimizePath = public_path() . '/images/category/';
      $image = time() . $file->getClientOriginalName();
      $optimizeImage->save($optimizePath . $image, 72);

      $input['cat_image'] = $image;
    }
    if (isset($request->status)) {
      $input['status'] = '1';
    } else {
      $input['status'] = '0';
    }

    if (isset($request->featured)) {
      $input['featured'] = '1';
    } else {
      $input['featured'] = '0';
    }

    $data->update($input);
    Session::flash('success', trans('flash.Updated Successfully'));
    return redirect('category');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\categories  $categories
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    if (Auth::User()->role == "admin") {

      $course = Course::where('category_id', $id)->get();

      if (!$course->isEmpty()) {
        return back()->with('delete', trans('flash.CannotDeleteCategory'));
      } else {

        DB::table('categories')->where('id', $id)->delete();
        SubCategory::where('category_id', $id)->delete();
        ChildCategory::where('category_id', $id)->delete();

        return back()->with('delete', trans('flash.DeletedSuccessfully'));
      }
    }

    return back()->with('delete', trans('Admin only have delete permission.'));
  }

  public function categoryStore(Request $request)
  {
    $cat = new Categories;
    $cat->title = $request->category;
    $cat->icon = $request->icon;

    $cat->slug = $request->slug;

    $cat->position = (Categories::count() + 1);
    // $cat->slug = str_slug($request->category);
    $cat->featured = $request->featured;
    $cat->status = $request->status;

    $cat->save();
    return back()->with('success', trans('flash.AddedSuccessfully'));
  }

  public function categoryPage(Request $request)
  {

    $ipaddress = $request->getClientIp();

    $geoip = geoip()->getLocation($ipaddress);
    $usercountry = strtoupper($geoip->country);


    if (!$request->id && !$request->category) {

      return redirect('/')->with('delete', 'Invalid URL');
    }


    $ipaddress = $request->getClientIp();

    $geoip = geoip()->getLocation($ipaddress);
    $usercountry = strtoupper($geoip->country);



    $cats = Categories::with('courses')->where('id', $request->id)->first();

    if (!$cats) {

      return redirect('/')->with('delete', '404 | category not found !');
    }
    if ($request->sortby) 
    {
        if ($request->sortby == 'l-h') 
        {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        if ($request->sortby == 'h-l') 
        {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        if ($request->sortby == 'a-z')
        {

            if ($request->type) 
            {
              $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
            }
            else 
            {

              $courses = $cats->courses()->where('status', '1')->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
            }
        }

        if ($request->sortby == 'z-a') 
        {
            if ($request->type) {
              $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
            } else {

              $courses = $cats->courses()->where('status', '1')->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
            }
        }

        if ($request->sortby == 'newest') 
        {
            if ($request->type) {

              $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
            } else {

              $courses = $cats->courses()->where('status', '1')->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
            }
        }
        if ($request->sortby == 'featured')
        {
            if ($request->type) {
              $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->where('featured', '=', '1')->paginate($request->limit ?? 10);
            } else {

              $courses = $cats->courses()->where('status', '1')->where('featured', '=', '1')->paginate($request->limit ?? 10);
            }
        }
    } 
    else if ($request->limit) 
    {
        if ($request->limit == '10') {
          $courses = $cats->courses()->where('status', '1')->paginate(2);
        } elseif ($request->limit == '30') {

          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } elseif ($request->limit == '50') {

          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } elseif ($request->limit == '100') {

          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } else {

          $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
        }
    } 
    else if ($request->type) 
    {   
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);
    }
    else if ($request->lang)
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    } 
    else 
    {
        $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
    }

    if(!empty($request->type)  && !empty($request->lang))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }
    if(!empty($request->sortby) && !empty($request->type)  && !empty($request->lang))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();

        if ($request->sortby == 'l-h') 
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'h-l')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'a-z')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'z-a')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'newest')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'featured')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->where('featured', '=', '1')->paginate($request->limit ?? 10);
        }
    }
    if(!empty($request->sortby) && !empty($request->lang) && empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();

        if ($request->sortby == 'l-h') 
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'h-l')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'a-z')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'z-a')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'newest')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'featured')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->where('featured', '=', '1')->paginate($request->limit ?? 10);
        }
    }
    if(!empty($request->limit)  && !empty($request->type) && empty($request->lang))
    {
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);
    }
    if(!empty($request->limit)  && !empty($request->lang) && empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }
    if(!empty($request->limit)  && !empty($request->lang) && !empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }

    $filter_count = $courses->count();


    $subcat = SubCategory::where('category_id', $cats->id)->get();

    return view('front.category', compact('cats', 'courses', 'subcat', 'filter_count', 'usercountry'));
  }

  public function subcategoryPage(Request $request)
  {

    $ipaddress = $request->getClientIp();

    $geoip = geoip()->getLocation($ipaddress);
    $usercountry = strtoupper($geoip->country);

    $cats = SubCategory::where('id', $request->id)->first();

    if (!$cats) {

      return redirect('/')->with('delete', '404 | category not found !');
    }

    if ($request->type) 
    {
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);
    } 
    else if ($request->sortby)
    {

        if ($request->sortby == 'l-h') 
        {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        if ($request->sortby == 'h-l') 
        {
          $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        if ($request->sortby == 'a-z') 
        {
            if ($request->type) 
            {
              $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
            } 
            else
            {
              $courses = $cats->courses()->where('status', '1')->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
            }
        }
        if ($request->sortby == 'z-a') 
        {
            if ($request->type) 
            {
                $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
            }
            else
            {
              $courses = $cats->courses()->where('status', '1')->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
            }
        }
        if ($request->sortby == 'newest') 
        {
            if ($request->type)
            {
                $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
            }
            else 
            {
                $courses = $cats->courses()->where('status', '1')->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
            }
        }
        if ($request->sortby == 'featured')
        {
            if ($request->type) {
              $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->where('featured', '=', '1')->paginate($request->limit ?? 10);
            } else {

              $courses = $cats->courses()->where('status', '1')->where('featured', '=', '1')->paginate($request->limit ?? 10);
            }
        }
    } 
    else if ($request->limit)
    {
        // return 'ghjj';
        if ($request->limit == '10') {
          $courses = $cats->courses()->where('status', '1')->paginate(2);
        } elseif ($request->limit == '30') {

          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } elseif ($request->limit == '50') {

          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } elseif ($request->limit == '100') {

          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } else {

          $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
        }
    }
    else if ($request->lang)
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    } 
    else 
    {
      $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
    }

    if(!empty($request->type)  && !empty($request->lang))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }
    if(!empty($request->sortby) && !empty($request->type)  && !empty($request->lang))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();

        if ($request->sortby == 'l-h') 
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'h-l')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'a-z')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'z-a')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'newest')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'featured')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->where('featured', '=', '1')->paginate($request->limit ?? 10);
        }
    }
    if(!empty($request->sortby) && !empty($request->lang) && empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();

        if ($request->sortby == 'l-h') 
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'h-l')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'a-z')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'z-a')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'newest')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'featured')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->where('featured', '=', '1')->paginate($request->limit ?? 10);
        }
    }
    if(!empty($request->limit)  && !empty($request->type) && empty($request->lang))
    {
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);
    }
    if(!empty($request->limit)  && !empty($request->lang) && empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }
    if(!empty($request->limit)  && !empty($request->lang) && !empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }

    $filter_count = $courses->count();

    $childcat = ChildCategory::where('subcategory_id', $cats->id)->get();

    return view('front.category', compact('cats', 'courses', 'childcat', 'filter_count', 'usercountry'));
  }

  public function childcategoryPage(Request $request)
  {

    $ipaddress = $request->getClientIp();

    $geoip = geoip()->getLocation($ipaddress);
    $usercountry = strtoupper($geoip->country);

    $cats = ChildCategory::where('id', $request->id)->first();


    if (!$cats) {

      return redirect('/')->with('delete', '404 | category not found !');
    }

    if ($request->type) 
    {
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);
    } 
    else if ($request->sortby) 
    {
        if ($request->sortby == 'l-h') 
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        if ($request->sortby == 'h-l') 
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', '1')->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        if ($request->sortby == 'a-z') 
        {
            if ($request->type) 
            {
                $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
            } 
            else
            {
                $courses = $cats->courses()->where('status', '1')->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
            }
        }
        if ($request->sortby == 'z-a') 
        {
            if ($request->type) 
            {
              $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
            } 
            else
            {
              $courses = $cats->courses()->where('status', '1')->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
            }
        }
        if ($request->sortby == 'newest') 
        {
            if ($request->type) 
            {
              $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
            }
            else
            {
              $courses = $cats->courses()->where('status', '1')->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
            }
        }
        if ($request->sortby == 'featured') 
        {
            if ($request->type)
            {
                $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? 1 : 0)->where('featured', '=', '1')->paginate($request->limit ?? 10);
            } 
            else 
            {
                $courses = $cats->courses()->where('status', '1')->where('featured', '=', '1')->paginate($request->limit ?? 10);
            }
        }
    } 
    else if ($request->limit) 
    {
        // return 'ghjj';
        if ($request->limit == '10') 
        {
          $courses = $cats->courses()->where('status', '1')->paginate(2);
        } 
        elseif ($request->limit == '30') 
        {
          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } 
        elseif ($request->limit == '50') 
        {
          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } 
        elseif ($request->limit == '100')
        {
          $courses = $cats->courses()->where('status', '1')->paginate($request->limit);
        } 
        else 
        {
          $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
        }
    } 
    else if ($request->lang) 
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    } 
    else 
    {
        $courses = $cats->courses()->where('status', '1')->paginate($request->limit ?? 10);
    }

    if(!empty($request->type)  && !empty($request->lang))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }
    if(!empty($request->sortby) && !empty($request->type)  && !empty($request->lang))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();

        if ($request->sortby == 'l-h') 
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'h-l')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'a-z')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'z-a')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'newest')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'featured')
        {
            $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->where('featured', '=', '1')->paginate($request->limit ?? 10);
        }
    }
    if(!empty($request->sortby) && !empty($request->lang) && empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();

        if ($request->sortby == 'l-h') 
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('price', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'h-l')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('price', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'a-z')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('title', 'ASC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'z-a')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('title', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'newest')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->orderBy('created_at', 'DESC')->paginate($request->limit ?? 10);
        }
        else if ($request->sortby == 'featured')
        {
            $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->where('featured', '=', '1')->paginate($request->limit ?? 10);
        }
    }
    if(!empty($request->limit)  && !empty($request->type) && empty($request->lang))
    {
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate($request->limit ?? 10);
    }
    if(!empty($request->limit)  && !empty($request->lang) && empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }
    if(!empty($request->limit)  && !empty($request->lang) && !empty($request->type))
    {
        $lang = CourseLanguage::where('id', $request->lang)->first();
        $courses = $cats->courses()->where('status', '1')->where('type', '=', $request->type == 'paid' ? '1' : '0')->where('language_id', '=', $lang->id)->paginate($request->limit ?? 10);
    }

    $filter_count = $courses->count();
    return view('front.category', compact('cats', 'courses', 'filter_count', 'usercountry'));
  }

  public function reposition(Request $request)
  {

    $data = $request->all();

    $posts = Categories::all();
    $pos = $data['id'];

    $position = json_encode($data);

    foreach ($posts as $key => $item) {

      Categories::where('id', $item->id)->update(array('position' => $pos[$key]));
    }

    return response()->json(['msg' => 'Updated Successfully', 'success' => true]);
  }

  public function bulk_delete(Request $request)
  {

    $validator = Validator::make($request->all(), ['checked' => 'required']);
    if ($validator->fails()) {
      return back()->with('error', trans('Please select field to be deleted.'));
    }
    $course = Course::whereIn('category_id', $request->checked)->get();
    if (count($course) > 0) {
      return back()->with('delete', trans('flash.CannotDeleteCategory'));
    }
    Categories::whereIn('id', $request->checked)->delete();

    return back()->with('delete', trans('Selected Categories has been deleted.'));
  }

  public function catstatus(Request $request)
  {
    $catstatus = Categories::find($request->id);
    $catstatus->status = $request->status;
    $catstatus->save();
    return back()->with('success', 'Status change successfully.');
  }

  public function catfeatured(Request $request)
  {
    $catfeature = Categories::find($request->id);
    $catfeature->featured = $request->featured;
    $catfeature->save();
    return back()->with('success', 'Status change successfully.');
  }

  public function catAlertstatus(Request $request)
  {
      $course = Course::where('category_id', $request->cat_id)->first();

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
