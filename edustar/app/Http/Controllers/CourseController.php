<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Image;
use App\CourseInclude;
use App\WhatLearn;
use App\CourseChapter;
use App\RelatedCourse;
use App\CourseClass;
use App\Categories;
use App\User;
use App\Wishlist;
use App\ReviewRating;
use App\Question;
use App\Announcement;
use App\Order;
use App\Answer;
use App\Cart;
use App\ReportReview;
use App\SubCategory;
use Session;
use App\QuizTopic;
use App\Quiz;
use Auth;
use Redirect;
use App\BundleCourse;
use App\CourseProgress;
use App\Adsense;
use App\Assignment;
use App\Appointment;
use App\BBL;
use App\Meeting;
use App\Currency;
use Cookie;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use App\PlanSubscribe;
use App\Setting;
use App\Googlemeet;
use App\JitsiMeeting;
use App\PreviousPaper;
use App\PrivateCourse;
use Illuminate\Support\Facades\Validator;
use File;
use App\Allcountry;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Mail;
use App\Mail\InstructorMailOnNotify;

class CourseController extends Controller
{
  public function __construct()
  {

    $this->middleware('permission:courses.view', ['only' => ['index', 'show']]);
    $this->middleware('permission:courses.create', ['only' => ['create', 'store']]);
    $this->middleware('permission:courses.edit', ['only' => ['update', 'status', 'courcestatus']]);
    $this->middleware('permission:courses.delete', ['only' => ['destroy', 'bulk_delete']]);
  }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function index(Request $request)
  {

    $searchTerm = $request->input('searchTerm');
    if (Auth::user()->role == 'instructor') {
      $cor = Course::query()->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc');
    } else {
      $cor = Course::query()->orderBy('created_at', 'desc');
    }


    $course = $cor->paginate(9);


    if ($request->searchTerm) {
      $course = $cor->where('title', 'LIKE', "%$searchTerm%")->where('status', '=', 1)->paginate(9)->appends(request()->query());
    }
    if ($request->type) {
      $course = $cor->where('type', '=', $request->type == 'paid' ? '1' : '0')->paginate(9)->appends(request()->query());
    }
    if ($request->featured == "1") {
      $course = $cor->where('featured', '=', $request->featured)->paginate(9)->appends(request()->query());
    }
    if ($request->featured == "0") {
      $course = $cor->where('featured', '=', $request->featured)->paginate(9)->appends(request()->query());
    }
    if ($request->status == "0") {

      $course = $cor->where('status', '=', $request->status)->paginate(9)->appends(request()->query());
    }
    if ($request->status == "1") {

      $course = $cor->where('status', '=', $request->status)->paginate(9)->appends(request()->query());
    }

    if ($request->ascending == "asc") {
        if (Auth::user()->role == 'instructor') {
            $course = $cor->orderBy('slug','ASC')->paginate(9)->appends(request()->query());
        }
        else
        {
            $course = Course::orderBy('slug','ASC')->paginate(9)->appends(request()->query());
        }
    }
    if ($request->ascending == "desc") {
      if (Auth::user()->role == 'instructor') {
          $course = $cor->orderBy('slug','DESC')->paginate(9)->appends(request()->query());
      }
      else
      {
          $course = Course::orderBy('slug','DESC')->paginate(9)->appends(request()->query());
      }
    }
    if ($request->category_id) {
      $course = $cor->where('category_id', '=', $request->category_id)->paginate(9)->appends(request()->query());
    }

    $categorys = Categories::all();
    $coursechapter = CourseChapter::all();
    $gsettings = Setting::first();
    if (Auth::user()->role == 'instructor') {
      $paid = Course::where('type', '1')->where('user_id', Auth::user()->id)->count();
      $active = Course::where('status', '1')->where('user_id', Auth::user()->id)->count();
      $free = Course::where('type', '0')->where('user_id', Auth::user()->id)->count();
      $deactive = Course::where('status', '0')->where('user_id', Auth::user()->id)->count();
      $cor = Course::query();
    } else {
      $paid = Course::where('type', '1')->count();
      $active = Course::where('status', '1')->count();
      $free = Course::where('type', '0')->count();
      $deactive = Course::where('status', '0')->count();
    }
    


    return view('admin.course.index', compact("course", 'coursechapter', 'gsettings', 'categorys', 'paid', 'active', 'free', 'deactive'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  public function create()
  {
    $userid = auth()->user()->id;
    $category = Categories::where('status','1')->get();

    $course = Course::all();
    $coursechapter = CourseChapter::all();

    if (Auth::user()->role == 'admin') {
      $users =  User::where('id', '!=', Auth::user()->id)->where('role', '!=', 'user')->where('status','1')->get();
    } else {
      $users =  User::where('id', Auth::user()->id)->first();
    }

    $countries = Allcountry::get();

    return view('admin.course.insert', compact("course", 'coursechapter', 'category', 'users', 'countries'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request)
  {
     
    if (config('app.demolock') == 1) {
      return back()->with('delete', 'Disabled in demo');
    }

    $this->validate($request, [
      'category_id' => 'required',
      'subcategory_id' => 'required',
      'user_id' => 'required',
      'language_id' => 'required|not_in:0',
      'institude_id' => 'required|not_in:0',
      'title' => 'required',
      'slug' => 'required|unique:courses,slug',
      'short_detail' => 'required',
      'requirement' => 'required',
      'detail' => 'required',
      'course_tags' => 'required',
      'preview_image' => 'required',
      // 'other_cats' => 'required',
      'duration' => 'required'
    ]);

    if(isset($request->preview_type))
    {
        $request->validate([
           'video' => 'mimes:mp4,avi,wmv',  
        ]);
    }
    if(isset($request->type))
    {
        $request->validate([
           'price' => 'required',  
        ]);
    }

    if(Auth::user()->role == 'instructor'){
      $request->validate([
          'preview_image' => 'required',
      ]);
    }

    $input = $request->all();
    $input['slug'] = Str::slug($request->slug, '-');
    
    if (isset($request->preview_type)) {
      $input['preview_type'] = "video";
      if ($file = $request->file('video')) {

        $filename = time() . $file->getClientOriginalName();
        $file->move(public_path().'/video/preview', $filename);
        $input['video'] = $filename;
        $input['url'] = NULL;
      }
    } else {
      $input['preview_type'] = "url";
      $input['url'] = $request->url;
      $input['video'] = NULL;
    }
    if (Auth::user()->role == 'admin') {
      if ($request->preview_image != null) {
        $input['preview_image'] = $request->preview_image;
      }
    }


    if (Auth::user()->role == 'instructor') {
      if ($file = $request->file('preview_image')) {
        $optimizeImage = Image::make($file);
        $optimizePath = public_path() . '/images/course/';
        $image = time() . $file->getClientOriginalName();
        $optimizeImage->save($optimizePath . $image, 72);

        $input['preview_image'] = $image;
      }
    }


    if (isset($request->duration_type)) {
      $input['duration_type'] = "m";
    } else {
      $input['duration_type'] = "d";
    }

    if (isset($request->involvement_request)) {
      $input['involvement_request'] = "1";
    } else {
      $input['involvement_request'] = "0";
    }

    if (isset($request->assignment_enable)) {
      $input['assignment_enable'] = "1";
    } else {
      $input['assignment_enable'] = "0";
    }

    if (isset($request->appointment_enable)) {
      $input['appointment_enable'] = "1";
    } else {
      $input['appointment_enable'] = "0";
    }

    if (isset($request->certificate_enable)) {
      $input['certificate_enable'] = "1";
    } else {
      $input['certificate_enable'] = "0";
    }

    if (isset($request->type)) {
      $input['type'] = 1;
    } else {
      $input['type'] = '0';
    }

    if (isset($request->status)) {
      $input['status'] = 1;
    } else {
      $input['status'] = '0';
    }

    if (isset($request->featured)) {
      $input['featured'] = 1;
    } else {
      $input['featured'] = '0';
    }
    if (isset($request->drip_enable)) {
      $input['drip_enable'] = 1;
    } else {
      $input['drip_enable'] = '0';
    }

    $data = Course::create($input);

    Session::flash('success', trans('flash.AddedSuccessfully'));
    return redirect('course')->withInput();
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {


    $instructor_course = Course::where('id', $id)->where('user_id', Auth::user()->id)->first();

    if (Auth::user()->role != "instructor" && Auth::user()->role != "user") {

      if (!isset($instructor_course)) {
        abort(404, 'Page Not Found.');
      }
    }

    $cor = Course::find($id);

    $countries = Allcountry::get();

    return view('admin.course.editcor', compact('cor', 'countries'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */

  public function edit(course $course)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */

  public function update(Request $request, $id)
  {

    $course = Course::find($id);
    if (config('app.demolock') == 1) {
      return back()->with('delete', 'Disabled in demo');
    }

    $request->validate([
      'category_id' => 'required',
      'subcategory_id' => 'required',
      'user_id' => 'required',
      'language_id' => 'required|not_in:0',
      'institude_id' => 'required|not_in:0',
      'title' => 'required',
      'slug' => 'required|unique:courses,slug,' . $course->id,
      'short_detail' => 'required',
      'requirement' => 'required',
      'detail' => 'required',
      // 'preview_image' => 'required',
      'course_tags' => 'required',
      // 'other_cats' => 'required',
      'duration' => 'required'

    ]);

    if(isset($request->preview_type))
    {
        $request->validate([
           'video' => 'mimes:mp4,avi,wmv',  
        ]);
    }
    if(isset($request->type))
    {
        $request->validate([
           'price' => 'required',  
        ]);
    }
  
    $input = $request->all();
    $input['slug'] = Str::slug($request->slug, '-');

    if (isset($request->status)) {
      $input['status'] = "1";
    } else {
      $input['status'] = "0";
    }


    if (isset($request->featured)) {
      $input['featured'] = "1";
    } else {
      $input['featured'] = "0";
    }


    if (isset($request->type)) {
      $input['type'] = "1";
    } else {
      $input['type'] = "0";
    }


    if (Auth::user()->role == 'admin') {
      $request->validate([
        'course_tags' => 'required'
      ]);
      if ($request->preview_image != null) {

        $input['preview_image'] = $request->preview_image;
      } else {

        $input['preview_image'] = $course->preview_image;
      }
    }


    if (Auth::user()->role == 'instructor') {

      if ($file = $request->file('preview_image')) {

        if ($course->preview_image != null) {
          $content = @file_get_contents(public_path() . '/images/course/' . $course->preview_image);
          if ($content) {
            unlink(public_path() . '/images/course/' . $course->preview_image);
          }
        }

        $optimizeImage = Image::make($file);
        $optimizePath = public_path() . '/images/course/';
        $image = time() . $file->getClientOriginalName();
        $optimizeImage->save($optimizePath . $image, 72);

        $input['preview_image'] = $image;
      }
    }


    if (isset($request->drip_enable)) {
      $input['drip_enable'] = 1;
    } else {
      $input['drip_enable'] = '0';
    }


    if (isset($request->preview_type)) {
      $input['preview_type'] = "video";
      if ($file = $request->file('video')) {
        if ($course->video != "") {
          $content = @file_get_contents(public_path() . '/video/preview/' . $course->video);
          if ($content) {
            unlink(public_path() . '/video/preview/' . $course->video);
          }
        }

        $filename = time() . $file->getClientOriginalName();
        $file->move(public_path().'/video/preview', $filename);
        $input['video'] = $filename;
        $input['url'] = NULL;
      }
    } else {
      $input['preview_type'] = "url";
      $input['url'] = $request->url;
      $input['video'] = NULL;
    }

    if (isset($request->duration_type)) {
      $input['duration_type'] = "m";
    } else {
      $input['duration_type'] = "d";
    }

    if (isset($request->involvement_request)) {
      $input['involvement_request'] = "1";
    } else {
      $input['involvement_request'] = "0";
    }

    if (isset($request->assignment_enable)) {
      $input['assignment_enable'] = "1";
    } else {
      $input['assignment_enable'] = "0";
    }

    if (isset($request->appointment_enable)) {
      $input['appointment_enable'] = "1";
    } else {
      $input['appointment_enable'] = "0";
    }

    if (isset($request->certificate_enable)) {
      $input['certificate_enable'] = "1";
    } else {
      $input['certificate_enable'] = "0";
    }


    // if(!isset($request->preview_type))
    // {
    //     $course->url = $request->video_url;
    //     $course->video = null;

    // }
    // else if($request->preview_type )
    // {
    //     if($file = $request->file('video'))
    //     {
    //       if($course->video != "")
    //       {
    //         $content = @file_get_contents(public_path().'/video/preview/'.$course->video);
    //         if ($content) {
    //           unlink(public_path().'/video/preview/'.$course->video);
    //         }
    //       }

    //       $filename = time().$file->getClientOriginalName();
    //       $file->move('video/preview',$filename);
    //       $input['video'] = $filename;
    //       $course->url = null;

    //     }
    // }



    Cart::where('course_id', $id)
      ->update([
        'price' => $request->price,
        'offer_price' => $request->discount_price,
      ]);


    $course->update($input);

    Session::flash('success', trans('flash.Updated Successfully'));
    return redirect('course');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\course  $course
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {

    if (Auth::user()->role == "admin") {

      $order = Order::where('course_id', $id)->get();

      if (config('app.demolock') == 0) {
        $course = Course::find($id);
        if (!$order->isEmpty()) {
          return back()->with('delete', trans('Cannot delete for this '.$course->title.' Course. Because, This course is already purchased some users !'));
        } else {
          if($course->user->role == "instructor")
          {
              if (env('MAIL_USERNAME')!=null) {
                  try{
                      /*Informed to Instructor using email*/
                      $x = 'your '.$course->title.' course was deleted by admin for more details contact Admin.';
                      $course_title = $course->title;
                      $user_name = $course->user->fname.' '.$course->user->lname;
                      Mail::to($course->user->email)->send(new InstructorMailOnNotify($x, $user_name,$course_title));
                  }catch(\Swift_TransportException $e){             
                  }
              }
          }

          if ($course->preview_image != null) {

            $image_file = @file_get_contents(public_path() . '/images/course/' . $course->preview_image);

            if ($image_file) {
              unlink(public_path() . '/images/course/' . $course->preview_image);
            }
          }
          if ($course->video != null) {

            $video_file = @file_get_contents(public_path() . '/video/preview/' . $course->video);

            if ($video_file != null) {
              unlink(public_path() . '/video/preview/' . $course->video);
            }
          }

          $value = $course->delete();
          Wishlist::where('course_id', $id)->delete();
          Cart::where('course_id', $id)->delete();
          ReviewRating::where('course_id', $id)->delete();
          Question::where('course_id', $id)->delete();
          Answer::where('course_id', $id)->delete();
          Announcement::where('course_id', $id)->delete();
          CourseInclude::where('course_id', $id)->delete();
          WhatLearn::where('course_id', $id)->delete();
          CourseChapter::where('course_id', $id)->delete();
          RelatedCourse::where('course_id', $id)->delete();
          CourseClass::where('course_id', $id)->delete();
         
          return back()->with('delete', trans('Deleted Successfully'));
        }
      } else {
        return back()->with('delete', trans('Demo Cannot delete'));
      }
    }

    return back()->with('delete', 'You cannot delete course');
  }

  public function upload_info(Request $request)
  {

    $id = $request['catId'];
    $category = Categories::findOrFail($id);
    $upload = $category->subcategory->where('category_id', $id)->where('status','1')->pluck('title', 'id')->all();

    return response()->json($upload);
  }


  public function gcato(Request $request)
  {

    $id = $request['catId'];

    $subcategory = SubCategory::findOrFail($id);
    $upload = $subcategory->childcategory->where('subcategory_id', $id)->where('status','1')->pluck('title', 'id')->all();

    return response()->json($upload);
  }

  public function showCourse($id)
  {

    $userid = auth()->user()->id;
    $course = Course::all();

    $cor = Course::findOrFail($id);
    if (Auth::user()->role == 'admin') {
      $users =  User::where('role', '!=', 'user')->where('status','1')->get();
    } else {
      $users =  User::where('id', Auth::user()->id)->first();
    }


    $courseinclude = CourseInclude::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $coursechapter = CourseChapter::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $whatlearns = WhatLearn::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $coursechapters = CourseChapter::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $relatedcourse = RelatedCourse::where('main_course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $courseclass = CourseClass::where('course_id', '=', $id)->orderBy('position', 'ASC')->get();
    $announsments = Announcement::where('course_id', '=', $id)->get();
    $reports = ReportReview::where('course_id', '=', $id)->get();
    $questions = Question::where('course_id', '=', $id)->get();
    $quizes = Quiz::where('course_id', '=', $id)->get();
    $topics = QuizTopic::where('course_id', '=', $id)->get();
    $appointment = Appointment::where('course_id', '=', $id)->get();

    $papers = PreviousPaper::where('course_id', '=', $id)->get();

    $countries = Allcountry::get();

    return view('admin.course.show', compact('cor', 'course', 'courseinclude', 'whatlearns', 'coursechapters', 'coursechapter', 'relatedcourse', 'courseclass', 'announsments', 'reports', 'questions', 'quizes', 'topics', 'appointment', 'papers', 'users', 'countries'));
  }



  public function CourseDetailPage($id, $slug)
  {

    $course = Course::findOrFail($id);

    session()->push('courses.recently_viewed', $id);


    $courseinclude = CourseInclude::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $whatlearns = WhatLearn::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $coursechapters = CourseChapter::where('course_id', '=', $id)->orderBy('id', 'ASC')->get();
    $relatedcourse = RelatedCourse::where('status', 1)->where('main_course_id', '=', $id)->get();
    $coursereviews = ReviewRating::where('course_id', '=', $id)->get();
    $courseclass = CourseClass::orderBy('position', 'ASC')->get();
    $reviews = ReviewRating::where('course_id', '=', $id)->get();
    $bundle_check = BundleCourse::first();

    $currency = Currency::first();

    $bigblue = BBL::where('course_id', '=', $id)->get();

    $meetings = Meeting::where('course_id', '=', $id)->get();
    $googlemeetmeetings = Googlemeet::where('course_id', '=', $id)->get();
    $jitsimeetings = JitsiMeeting::where('course_id', '=', $id)->get();

    $ad = Adsense::first();


    if (Auth::check()) {

      $private_courses = PrivateCourse::where('course_id', '=', $id)->where('status','1')->first();

      if (isset($private_courses)) {
        $user_id = array();
        array_push($user_id, $private_courses->user_id);
        $user_id = array_values(array_filter($user_id));
        $user_id = array_flatten($user_id);

        if (in_array(Auth::user()->id, $user_id)) {

          return back()->with('delete', trans('flash.UnauthorizedAction'));
        }
      }

      $order = Order::where('refunded', '0')->where('status', '1')->where('user_id', Auth::User()->id)->where('course_id', $id)->first();
      
      if(!empty($order))
      {   
          if(Auth::User()->id == $order->user_id)
          {
              $show_coursecontent = "1";
          }
      }
      else
      {   
          if(Auth::User()->role == "admin" || $course->user_id == Auth::User()->id)
          {
              $show_coursecontent = "1";
          }
          else
          {
              $show_coursecontent = "0";
          }
      }
      
      $wish = Wishlist::where('user_id', Auth::User()->id)->where('course_id', $id)->first();
      $cart = Cart::where('user_id', Auth::User()->id)->where('course_id', $id)->first();
      $instruct_course = Course::where('id', '=', $id)->where('user_id', '=', Auth::user()->id)->first();

      if (!empty($bundle_check)) {

        if (Auth::user()->role == 'user') {
          $bundle = Order::where('user_id', Auth::User()->id)->where('bundle_id', '!=', NULL)->get();

          $course_id = array();


          foreach ($bundle as $b) {
            $bundle = BundleCourse::where('id', $b->bundle_id)->first();
            array_push($course_id, $bundle->course_id);
          }

          $course_id = array_values(array_filter($course_id));

          $course_id = array_flatten($course_id);

          return view('front.course_detail', compact('course', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews', 'relatedcourse', 'course_id', 'ad', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'order', 'wish', 'currency', 'cart', 'instruct_course','show_coursecontent'));
        } else {
          return view('front.course_detail', compact('course', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews', 'relatedcourse', 'ad', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'order', 'wish', 'currency', 'cart', 'instruct_course','show_coursecontent'));
        }
      } else {

        return view('front.course_detail', compact('course', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews', 'relatedcourse', 'ad', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'order', 'wish', 'currency', 'cart', 'instruct_course','show_coursecontent'));
      }
    } else {
      $show_coursecontent = "0";
      return view('front.course_detail', compact('course', 'courseinclude', 'whatlearns', 'coursechapters', 'courseclass', 'coursereviews', 'reviews', 'relatedcourse', 'ad', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'currency','show_coursecontent'));
    }
  }

  public function CourseContentPage($id, $slug)
  {
    $course = Course::where('id', $id)->with(['user', 'chapter', 'chapter.courseclass'])->first();
    if(count($course->chapter) > 0)
    {
      $first_chapter = $course->chapter;
      $first_class = $first_chapter[0]->courseclass;
    }
    else
    {
      $first_chapter = [];
      $first_class = []; 
    }
    //echo"<pre>";print_r($first_class[0]->id);exit();
    $coursequestions = Question::where('course_id', '=', $id)->with('user')->get();

    $announsments = Announcement::where('course_id', '=', $id)->with('user')->get();

    $bigblue = BBL::where('course_id', '=', $id)->get();

    $meetings = Meeting::where('course_id', '=', $id)->with('user')->get();
    $googlemeetmeetings = Googlemeet::where('course_id', '=', $id)->get();
    $jitsimeetings = JitsiMeeting::where('course_id', '=', $id)->get();

    $papers = PreviousPaper::where('course_id', '=', $id)->get();


    if (Auth::check()) {

      $progress = CourseProgress::where('course_id', '=', $id)->where('user_id', Auth::User()->id)->first();

      $assignment = Assignment::where('course_id', '=', $id)->where('user_id', Auth::User()->id)->get();

      $appointment = Appointment::where('course_id', '=', $id)->where('user_id', Auth::User()->id)->get();

      // echo"<pre>";print_r($progress);exit();
      return view('front.course_content', compact('course', 'coursequestions', 'announsments', 'progress', 'assignment', 'appointment', 'bigblue', 'meetings', 'googlemeetmeetings', 'jitsimeetings', 'papers','first_chapter','first_class'));
    }

    return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
  }

  public function courseClassPage(Request $request)
  {
      $class = CourseClass::with('coursechapters')->where('id',$request->class_id)->first();
     
      return response([
          'class' => $class
      ]);
  }

  public function courseClassposPage(Request $request)
  {
      if($request->position == "previous")
      {
          $pre = CourseClass::with('coursechapters')->where('id',$request->class_id)->first();
          $allclass = CourseClass::with('coursechapters')->where('course_id',$pre['course_id'])->where('coursechapter_id','<=',$pre['coursechapter_id'])->where('status','1')->orderBy('coursechapter_id','asc')->get();
          if(count($allclass) > 0)
          {
              foreach($allclass as $key => $sclass)
              {
                  if($sclass['id'] == $pre['id'])
                  {
                      if(!empty($allclass[$key - 1]))
                      {
                        $class = $allclass[$key - 1];
                        break;
                      }
                      else
                      {
                        $class = CourseClass::with('coursechapters')->where('id',$request->class_id)->first();
                      }
                  }
              }
          }
          else
          {
              $class = CourseClass::with('coursechapters')->where('id',$request->class_id)->first();
          }      
      }
      else
      {
          $nex = CourseClass::with('coursechapters')->where('id',$request->class_id)->first();
          $allclass = CourseClass::with('coursechapters')->where('course_id',$nex['course_id'])->where('coursechapter_id','>=',$nex['coursechapter_id'])->where('status','1')->orderBy('coursechapter_id','asc')->get();
          if(count($allclass) > 0)
          {
              foreach($allclass as $key => $sclass)
              {
                  if($sclass['id'] == $nex['id'])
                  {
                      if(!empty($allclass[$key + 1]))
                      {
                        $class = $allclass[$key + 1];
                        break;
                      }
                      else
                      {
                        $class = CourseClass::with('coursechapters')->where('id',$request->class_id)->first();
                      }
                  }
              }
          }
          else
          {
              $class = CourseClass::with('coursechapters')->where('id',$request->class_id)->first();
          }  
      }
      return response([
          'class' => $class
      ]);
  }

  public function mycoursepage()
  {
    if (Auth::check()) {
      $course = Course::all();
      $enroll = Order::where('refunded', '0')->where('status', '1')->where('user_id', Auth::user()->id)->get();

      $user_enrolled = Order::where('refunded', '0')->where('user_id', Auth::user()->id)->get()->pluck('course_id');

      $bigbluemeeting = BBL::whereIn('course_id',$user_enrolled)->where('is_ended','!=',1)->where('link_by','!=',NULL)->get();
      $zoommeeting = Meeting::whereIn('course_id',$user_enrolled)->where('link_by','!=', NULL)->get();
    
      
      return view('front.my_course', compact('course', 'enroll','bigbluemeeting','zoommeeting'));
    }

    return Redirect::route('login')->withInput()->with('delete', trans('flash.PleaseLogin'));
  }
  public function status(Request $request)
  {

    $course = Course::find($request->id);
    $course->status = $request->status;
    $course->save();
    return back()->with('success', trans('flash.Updated Successfully'));
  }
  public function duplicate($id)
  {

    $existingOpening = Course::find($id);

    // $newOpenening = $existingOpening->replicate();

    if ($existingOpening->preview_image == !NULL && @file_get_contents(public_path() . 'images/course/' . $existingOpening->preview_image)) {
      $oldPath = public_path('images/course/' . $existingOpening->preview_image); // publc/images/1.jpg

      $fileExtension = \File::extension($oldPath);

      $newName = 'duplicate' . time() . '.' . $fileExtension;

      $newPathWithName = public_path('images/course/' . $newName);

      \File::copy($oldPath, $newPathWithName);
    } else {

      $newName = NULL;
    }

    if ($existingOpening->video == !NULL && @file_get_contents(public_path() . '/video/preview/' . $existingOpening->video)) {
      $oldPath = public_path('video/preview/' . $existingOpening->video); // publc/images/1.jpg

      $fileExtension = \File::extension($oldPath);

      $newVideo = 'duplicate' . time() . '.' . $fileExtension;

      $newPathWithName = public_path('video/preview/' . $newVideo);

      \File::copy($oldPath, $newPathWithName);
    } else {

      $newVideo = NULL;
    }



    $newOpenening = $existingOpening->replicate()->fill(
      [
        'preview_image' => $newName,
      ]
    );

    $newOpenening = $existingOpening->replicate()->fill(
      [
        'slug' => str_slug($existingOpening->slug . '-copy-' . time() . $existingOpening->id, '-'),
      ]
    );




    $newOpenening->save();


    $old_courseinclude = CourseInclude::where('course_id', $existingOpening->id)->get();

    foreach ($old_courseinclude as $include) {
      $new_courseinclude = $include->replicate()->fill(
        [
          'course_id' => $newOpenening->id,
        ]
      );

      $new_courseinclude->save();
    }

    $old_whatlearn = WhatLearn::where('course_id', $existingOpening->id)->get();

    foreach ($old_whatlearn as $whatlearn) {

      $new_whatlearn = $whatlearn->replicate()->fill(
        [
          'course_id' => $newOpenening->id,
        ]
      );

      $new_whatlearn->save();
    }


    $old_chapter = CourseChapter::where('course_id', $existingOpening->id)->get();

    foreach ($old_chapter as $chapter) {

      $new_chapter = $chapter->replicate()->fill(
        [
          'course_id' => $newOpenening->id,
          'file' => NULL,
        ]
      );

      $new_chapter->save();

      $old_class = CourseClass::where('coursechapter_id', $chapter->id)->get();




      foreach ($old_class as $class) {



        if ($class->video == !NULL && @file_get_contents(public_path() . 'video/class/' . $class->video)) {

          $oldPathVideo = public_path('video/class/' . $class->video); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathVideo);

          $newclassVideo = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithVideo = public_path('video/class/' . $newclassVideo);

          \File::copy($oldPathVideo, $newPathWithVideo);
        } else {

          $newclassVideo = NULL;
        }


        if ($class->pdf == !NULL && @file_get_contents(public_path() . 'files/pdf/' . $class->pdf)) {

          $oldPathPDF = public_path('files/pdf/' . $class->pdf); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathPDF);

          $newclassPDF = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithPDF = public_path('files/pdf/' . $newclassPDF);

          \File::copy($oldPathPDF, $newPathWithPDF);
        } else {

          $newclassPDF = NULL;
        }


        if ($class->zip == !NULL && @file_get_contents(public_path() . 'video/class/' . $class->zip)) {

          $oldPathZIP = public_path('video/class/' . $class->zip); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathZIP);

          $newclassZIP = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithZIP = public_path('video/class/' . $newclassZIP);

          \File::copy($oldPathZIP, $newPathWithZIP);
        } else {

          $newclassZIP = NULL;
        }


        if ($class->preview_video == !NULL && @file_get_contents(public_path() . 'video/class/' . $class->preview_video)) {

          $oldPathPreview = public_path('video/class/preview/' . $class->preview_video); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathPreview);

          $newclassPreview = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithPreview = public_path('video/class/preview/' . $newclassPreview);

          \File::copy($oldPathPreview, $newPathWithPreview);
        } else {

          $newclassPreview = NULL;
        }


        if ($class->audio == !NULL && @file_get_contents(public_path() . 'video/class/' . $class->audio)) {

          $oldPathAUDIO = public_path('video/class/' . $class->video); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathAUDIO);

          $newclassVideo = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithAUDIO = public_path('video/class/' . $newclassAUDIO);

          \File::copy($oldPathAUDIO, $newPathWithAUDIO);
        } else {

          $newclassAUDIO = NULL;
        }


        if ($class->file == !NULL && @file_get_contents(public_path() . 'files/class/material/' . $class->file)) {

          $oldPathfile = public_path('files/class/material/' . $class->file); // publc/images/1.jpg

          $fileExtension = \File::extension($oldPathfile);

          $newclassfile = 'duplicate' . time() . '.' . $fileExtension;

          $newPathWithVideo = public_path('files/class/material/' . $newclassfile);

          \File::copy($oldPathfile, $newPathWithfile);
        } else {

          $newclassfile = NULL;
        }





        $new_class = $class->replicate()->fill(
          [
            'course_id' => $newOpenening->id,
            'coursechapter_id' => $new_chapter->id,
            'video' => $newclassVideo,
            'pdf' => $newclassPDF,
            'zip' => $newclassZIP,
            'preview_video' => $newclassPreview,
            'audio' => $newclassAUDIO,
            'position' => (CourseClass::count() + 1),
            'file' => $newclassfile,
          ]
        );

        $new_class->save();
      }
    }




    return back()->with('CreatedSuccessfully');
  }


  public function courcestatus(Request $request)
  {

    $catstatus = Course::find($request->id);
    $catstatus->status = $request->status;
    $catstatus->save();
    return back()->with('success', 'Status change successfully.');
  }

  public function courcefeatured(Request $request)
  {
    $catfeature = Course::find($request->id);
    $catfeature->featured = $request->featured;
    $catfeature->save();
    return back()->with('success', 'Status change successfully.');
  }

  // This function performs bulk delete action
  public function bulk_delete(Request $request)
  {
    $validator = Validator::make($request->all(), ['checked' => 'required']);
    if ($validator->fails()) {
      return back()->with('warning', 'Atleast one item is required to be checked');
    } else {
      // echo"<pre>";print_r($request->checked);exit();
      if(count($request->checked) > 0)
      { 
          foreach($request->checked as $id)
          {
              $order = Order::where('course_id', $id)->get();
              if ($order->isEmpty()) {
                $course = Course::where('id',$id)->first();
                if($course->user->role == "instructor")
                {
                    if (env('MAIL_USERNAME')!=null) {
                        try{
                            /*Informed to Instructor using email*/
                            $x = 'your '.$course->title.' course was deleted by admin for more details contact Admin.';
                            $course_title = $course->title;
                            $user_name = $course->user->fname.' '.$course->user->lname;
                            Mail::to($course->user->email)->send(new InstructorMailOnNotify($x, $user_name,$course_title));
                        }catch(\Swift_TransportException $e){             
                        }
                    }
                }
                Course::where('id',$id)->delete();
                Wishlist::where('course_id', $id)->delete();
                Cart::where('course_id', $id)->delete();
                ReviewRating::where('course_id', $id)->delete();
                Question::where('course_id', $id)->delete();
                Answer::where('course_id', $id)->delete();
                Announcement::where('course_id', $id)->delete();
                CourseInclude::where('course_id', $id)->delete();
                WhatLearn::where('course_id', $id)->delete();
                CourseChapter::where('course_id', $id)->delete();
                RelatedCourse::where('course_id', $id)->delete();
                CourseClass::where('course_id', $id)->delete();
                // Course::whereIn('id', $request->checked)->delete();
              }
              else
              {
                  $course = Course::where('id',$id)->first();
                  $usedcourses[] = $course->title;
              }
          }
          
      }
      if(!isset($usedcourses))
      {
          Session::flash('delete', trans('Selected item has been deleted successfully !'));
      }
      else
      {
          $used_course = implode(' and ',$usedcourses);
          Session::flash('delete', trans('Cannot delete for this '.$used_course.' Courses. Because, These courses are already purchased some users !'));
      }
      
      return back();
      
    }
  }
}