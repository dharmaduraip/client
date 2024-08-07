<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IndustryType;
use App\Models\IndustryTypeTranslation;
use Illuminate\Http\Request;
use Modules\Language\Entities\Language;

class IndustryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!userCan('industry_types.view'), 403);

        $industrytypes = IndustryType::all();
        $app_language = Language::latest()->get(['code']);

        return view('admin.industryType.index', compact('industrytypes','app_language',));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!userCan('industry_types.create'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array);

        $industry_type = new IndustryType();
        $industry_type->save();

        foreach($request->except('_token') as $key => $value){
            $industry_type->translateOrNew(str_replace("name_","",$key))->name = $value;
            $industry_type->save();
        }

        flashSuccess(__("industry_type_created_successfully"));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(IndustryType $industryType)
    {
        abort_if(!userCan('industry_types.update'), 403);

        $industrytypes = IndustryType::all();
        $app_language = Language::latest()->get(['code']);

        /**** translation key by latest ****/
        $collection = $industryType->translations;
        $keyed = $collection->keyBy('locale');
        $industryType->translations = $keyed;

        return view('admin.industryType.index', compact('industryType', 'industrytypes','app_language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IndustryType $industryType)
    {
        abort_if(!userCan('industry_types.update'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array );

        foreach($request->except(['_token','_method']) as $key => $value){
            $industryType->translateOrNew(str_replace("name_","",$key))->name = $value;
            $industryType->save();
        }

        flashSuccess(__('industry_type_updated_successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(IndustryType $industryType)
    {
        abort_if(!userCan('industry_types.delete'), 403);

        $industryType->delete();

        flashSuccess(__('industry_type_deleted_successfully'));
        return redirect()->route('industryType.index');
    }
}
