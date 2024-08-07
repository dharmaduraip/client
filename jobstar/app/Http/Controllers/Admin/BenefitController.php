<?php

namespace App\Http\Controllers\Admin;

use App\Models\Benefit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Language\Entities\Language;

class BenefitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!userCan('benefits.view'), 403);

        $benefits = Benefit::all();
        $app_language = Language::latest()->get(['code']);

        return view('admin.benefit.index', compact('benefits','app_language'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!userCan('benefits.create'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array);

        $benefit = new Benefit();
        $benefit->save();

        foreach($request->except('_token') as $key => $value){
            $benefit->translateOrNew(str_replace("name_","",$key))->name = $value;
            $benefit->save();
        }

       flashSuccess(__('benefit_created_successfully'));
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Benefit $benefit)
    {
        abort_if(!userCan('benefits.update'), 403);

        $benefits = Benefit::all();
        $app_language = Language::latest()->get(['code']);

         /**** translation key by latest ****/
        $collection = $benefit->translations;
        $keyed = $collection->keyBy('locale');
        $benefit->translations = $keyed;


        return view('admin.benefit.index', compact('benefit', 'benefits','app_language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Benefit $benefit)
    {
        abort_if(!userCan('benefits.update'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach($app_language as $language){
            $validate_array['name_'. $language->code] = 'required|string|max:255';
        }
        $this->validate($request, $validate_array );

        foreach($request->except(['_token','_method']) as $key => $value){
            $benefit->translateOrNew(str_replace("name_","",$key))->name = $value;
            $benefit->save();
        }

        flashSuccess(__('benefit_updated_successfully'));
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Benefit $benefit)
    {
        abort_if(!userCan('benefits.delete'), 403);

        $benefit->delete();

        flashSuccess(__('benefit_deleted_successfully'));
        return redirect()->route('benefit.index');
    }
}
