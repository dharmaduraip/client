<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Language\Entities\Language;

class SkillController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!userCan('skills.view'), 403);

        $skills = Skill::all();
        $app_language = Language::latest()->get(['code']);

        return view('admin.skill.index', compact('skills','app_language'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!userCan('skills.create'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array);

        /********** default Language process ********/
        $defaultLanguage = Language::where('code', config('zakirsoft.default_language'))->first();
		$current_language = currentLanguage() ? currentLanguage() : $defaultLanguage;

        foreach($request->except('_token') as $key => $value){
            if($current_language->code == str_replace("name_","",$key)){
                $skill = new Skill();
                $skill->name = $value;
                $skill->save();
            }
        }


        foreach($request->except('_token') as $key => $value){
            $skill->translateOrNew(str_replace("name_","",$key))->name = $value;
            $skill->save();
        }

        flashSuccess(__('skill_created_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Skill $skill)
    {
        abort_if(!userCan('skills.update'), 403);

        $skilll = $skill;
        $skills = Skill::all();
        $app_language = Language::latest()->get(['code']);

         /**** translation key by latest ****/
        $collection = $skilll->translations;
		$keyed = $collection->keyBy('locale');
		$skilll->translations = $keyed;

        return view('admin.skill.index', compact('skilll', 'skills','app_language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Skill $skill)
    {
        abort_if(!userCan('skills.update'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array );

        foreach($request->except(['_token','_method']) as $key => $value){
            $skill->translateOrNew(str_replace("name_","",$key))->name = $value;
            $skill->save();
        }

       flashSuccess(__('skill_updated_successfully')) ;
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Skill $skill)
    {
        abort_if(!userCan('skills.delete'), 403);

        $skill->delete();

        flashSuccess(__('skill_deleted_successfully'));
        return redirect()->route('skill.index');
    }
}
