<?php

namespace App\Http\Controllers;
use App\Course;
use App\Order;
use Auth;
use Redirect;
use PDF;
use Illuminate\Http\Request;
use App\CourseProgress;
use Crypt;
use DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class CertificateController extends Controller
{
    public function __construct()
    {
    
        $this->middleware('permission:certificate.manage', ['only' => ['verification']]);
    
    }
    public function show($slug)
    {
        
        $serial_no = $slug;

        $whatIWant = strtok($slug, 'CR-');

        $progress = CourseProgress::where('id', $whatIWant)->firstOrfail();
        if($progress->certificate_no == NULL)
        {
            $progress->certificate_no = $slug;
            $progress->save();
        }
        $course = Course::where('id', $progress->course_id)->firstOrfail();

    
        return view('front.certificate.certificate', compact('course', 'progress', 'serial_no'));
        
    }

    public function pdfdownload($slug)
    {
        $serial_no = $slug;

        $whatIWant = strtok($slug, 'CR-');

        $progress = CourseProgress::where('id', $whatIWant)->first();

        $course = Course::where('id', $progress->course_id)->first();
        
        $pdf = PDF::loadView('front.certificate.download', compact('course', 'progress', 'serial_no'), [], 
        [ 
          'title' => 'Certificate', 
          'orientation' => 'L'
        ]);

        return $pdf->download('certificate.pdf');
        // return $pdf->stream('certificate.pdf');
    }


    public function apipdfdownload($id)
    {
        $user = Auth::guard('api')->user();

        $random = $id.'CR-'.uniqid();

        $serial_no = $random;

        $whatIWant = strtok($random, 'CR-'); 
    
        $progress = CourseProgress::where('id', $whatIWant)->where('user_id', $user->id)->first();

        $course = Course::where('id', $progress->course_id)->first();

        if($progress == NULL)
        {
            return response()->json(['Please Complete your course to get certificate !'], 400); 
        }
        
        
        $pdf = PDF::loadView('front.certificate.download', compact('course', 'progress', 'serial_no'), [], 
        [ 
          'title' => 'Certificate', 
          'orientation' => 'L'
        ]);
        
        // $pdf->save(storage_path().'/app/pdf/certificate.pdf');
        
        return $pdf->download('certificate.pdf');
        
    }

    public function verification(Request $request)
    {
        if(isset($request->title))
        {
            $verify = CourseProgress::where('certificate_no',$request->title)->first();
            if(!isset($verify))
            {
                return redirect()->route('  ')->with('fail','This is invalid serial no.'.$request->title);
                // session()->flash('fail',__('Invalid serial no.'));
            }
            $contains = Str::contains($request->title, 'CR-');
            if($contains)
            {
                if(isset($request->title))
                {
                    $posts = $request->title;
                }
                else
                {
                $posts = NULL; 
                }
                
                return view('admin.certificate.view', compact('posts'));
            }
        }
        else
        {
            $posts = NULL;
            return view('admin.certificate.view', compact('posts'));
        }
        
    }
    public function report(){

        $progress = DB::table('course_progress as a')->select('a.*','users.fname','users.email','courses.title')->join('course_progress as b', 'a.mark_chapter_id', '=', 'b.all_chapter_id')->join('users','a.user_id' , '=' , 'users.id')->join('courses','a.course_id', '=' , 'courses.id')->groupBy('a.id')->get();
        return view('admin.certificate.report',compact('progress'));
    }

}
