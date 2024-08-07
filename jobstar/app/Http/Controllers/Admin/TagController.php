<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Benefit;
use Illuminate\Http\Request;
use App\Models\TagTranslation;
use App\Http\Controllers\Controller;
use Modules\Language\Entities\Language;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!userCan('tags.view'), 403);

        $tags = Tag::latest('id')->paginate(15);
        $app_language = Language::latest()->get(['code']);

        return view('admin.tag.index', compact('tags', 'app_language'));
    }

    /**
     * Change status a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statusChange(Request $request, Tag $tag)
    {
        $tag->update([
            'show_popular_list' => $request->status ?? false,
        ]);
        return ['message' => 'Tag status updated !'];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!userCan('tags.create'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach ($app_language as $language) {
            $validate_array['name_' . $language->code] = 'required|string|max:255|unique:tag_translations,name';
        }
        $this->validate($request, $validate_array);

        $tag = new Tag();
        $tag->save();

        foreach ($request->except('_token') as $key => $value) {
            $tag->translateOrNew(str_replace("name_", "", $key))->name = $value;
            $tag->save();
        }

        flashSuccess(__('tag') . ' ' . __('created') . ' ' . __('successfully'));
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        abort_if(!userCan('tags.update'), 403);

        $tags = Tag::latest('id')->paginate(15);
        $app_language = Language::latest()->get(['code']);

         /**** translation key by latest ****/
        $collection = $tag->translations;
		$keyed = $collection->keyBy('locale');
		$tag->translations = $keyed;

        return view('admin.tag.index', compact('tags', 'tag', 'app_language'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        abort_if(!userCan('tags.update'), 403);

        $app_language = Language::latest()->get(['code']);
        $validate_array = [];
        foreach ($app_language as $language) {
            $validate_array['name_' . $language->code] = 'required|string|max:255';
        }

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $tag->translateOrNew(str_replace("name_", "", $key))->name = $value;
            $tag->save();
        }

        $this->validate($request, $validate_array);

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            $tag->translateOrNew(str_replace("name_", "", $key))->name = $value;
            $tag->save();
        }

        flashSuccess(__('tag') . ' ' . __('updated') . ' ' . __('successfully'));
        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        abort_if(!userCan('tags.delete'), 403);

        $success = $tag->delete();
        $success ? flashSuccess(__('tag') . ' ' . __('deleted') . ' ' . __('successfully') . '!') : flashSuccess(__('something_went_wrong'));
        return redirect()->route('tags.index');
    }
}
