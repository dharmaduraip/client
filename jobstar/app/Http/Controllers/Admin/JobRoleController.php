<?php

namespace App\Http\Controllers\Admin;

use App\Models\JobRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Language\Entities\Language;

class JobRoleController extends Controller
{
    public function index()
    {
        abort_if(!userCan('job_role.view'), 403);

        $jobRoles = JobRole::withCount('jobs')->get();
        $app_language = Language::latest()->get(['code']);

        return view('admin.JobRole.index', compact('jobRoles','app_language'));
    }


    public function store(Request $request)
    {
        abort_if(!userCan('job_role.create'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array);

        /* $job_role = new JobRole();
        $job_role->save(); */
        /****** default Language insert data process *****/
        $defaultLanguage = Language::where('code', config('zakirsoft.default_language'))->first();
		$current_language = currentLanguage() ? currentLanguage() : $defaultLanguage;


        foreach($request->except('_token') as $key => $value){
            if($current_language->code == str_replace("name_","",$key)){
                $job_role = new JobRole();
                $job_role->name = $value;
                $job_role->save();
            }
        }


        foreach($request->except('_token') as $key => $value){
            $job_role->translateOrNew(str_replace("name_","",$key))->name = $value;
            $job_role->save();
        }

        flashSuccess(__('job_role_created_successfully'));
        return back();
    }

    public function edit(JobRole $jobRole)
    {
        abort_if(!userCan('job_role.update'), 403);

        $jobRoles = JobRole::withCount('jobs')->get();
        $app_language = Language::latest()->get(['code']);

        /**** translation key by latest ****/
        $collection = $jobRole->translations;
		$keyed = $collection->keyBy('locale');
		$jobRole->translations = $keyed;

        return view('admin.JobRole.index', compact('jobRole', 'jobRoles','app_language'));
    }

    public function update(Request $request, JobRole $jobRole)
    {
        abort_if(!userCan('job_role.update'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array );

        foreach($request->except(['_token','_method']) as $key => $value){
            $jobRole->translateOrNew(str_replace("name_","",$key))->name = $value;
            $jobRole->save();
        }

        flashSuccess(__('job_role_updated_successfully'));

        return back();
    }

    public function destroy(JobRole $jobRole)
    {
        abort_if(!userCan('job_role.delete'), 403);

        $jobRole->delete();

        flashSuccess(__('job_role_deleted_successfully'));
        return redirect()->route('jobRole.index');
    }
}
