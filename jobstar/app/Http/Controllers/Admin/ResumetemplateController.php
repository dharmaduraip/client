<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resumetemplate;

class ResumetemplateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function view()
    {
        $templates = Resumetemplate::where('status','1')->get();
        return view('admin.resume.templates',compact('templates'));
    }

}
