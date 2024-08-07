<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use Spatie\Permission\Models\Role;
use DotenvEditor;

class AfricasTalkingController extends Controller
{
    public function __construct()
    { 
      $this->middleware('permission:twilio-setting.manage', ['only' => ['index','update','status']]);    
    }

    public function index()
    {
        $settings = Setting::first();
        return view('admin.africas_talking.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'africas_talking_username' => 'required',
            'africas_talking_apikey' => 'required',
        ]);


        $setting = Setting::first();

        $addenv_keys = DotenvEditor::setKeys([
            'AFRICAS_TALKING_USERNAME' => $request->africas_talking_username,
            'AFRICAS_TALKING_APIKEY' => $request->africas_talking_apikey,
        ]);

        if(isset($request->africas_talking_enable))
        {
          $setting->africas_talking_enable = '1';
        }
        else
        {
          $setting->africas_talking_enable = '0';
        }

        $setting->save();

        $addenv_keys->save();

        return back()->with('success', trans('flash.Settingssaved'));
    }

    public function status(Request $request)
    {
        $setting = Setting::first();
        $setting->africas_talking_enable = $request->status;
        $setting->save();
        
    }
}
