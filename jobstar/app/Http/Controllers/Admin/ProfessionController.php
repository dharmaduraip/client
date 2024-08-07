<?php

namespace App\Http\Controllers\Admin;

use App\Models\Profession;
use App\Models\IndustryType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Language\Entities\Language;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!userCan('professions.view'), 403);

        $professions = Profession::all();
        $app_language = Language::latest()->get(['code']);

        return view('admin.profession.index', compact('professions','app_language'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!userCan('professions.create'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array );

        /***** current language ******/
        $defaultLanguage = Language::where('code', config('zakirsoft.default_language'))->first();
		$current_language = currentLanguage() ? currentLanguage() : $defaultLanguage;

        foreach($request->except('_token') as $key => $value){
            if($current_language->code == str_replace("name_","",$key)){
                $profession = new Profession();
                $profession->name = $value;
                $profession->save();
            }
        }

        foreach($request->except('_token') as $key => $value){
            $profession->translateOrNew(str_replace("name_","",$key))->name = $value;
            $profession->save();
        }

        flashSuccess(__('profession_created_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Profession $profession)
    {
        abort_if(!userCan('professions.update'), 403);

        $prof = $profession;
        $professions = Profession::all();
        $app_language = Language::latest()->get(['code']);

        /**** translation key by latest ****/
        $collection = $prof->translations;
		$keyed = $collection->keyBy('locale');
		$prof->translations = $keyed;

        return view('admin.profession.index', compact('prof', 'professions','app_language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profession $profession)
    {
        abort_if(!userCan('professions.update'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array );

        foreach($request->except(['_token','_method']) as $key => $value){
            $profession->translateOrNew(str_replace("name_","",$key))->name = $value;
            $profession->save();
        }

        flashSuccess(__('profession_updated_successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profession $profession)
    {
        abort_if(!userCan('professions.delete'), 403);

        $profession->delete();

        flashSuccess(__('profession_deleted_successfully'));
        return redirect()->route('profession.index');
    }
}
