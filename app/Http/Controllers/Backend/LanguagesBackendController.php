<?php

namespace App\Http\Controllers\Backend;

use App\Models\Blog;
use App\Models\Category;
use App\Models\language;
use App\Models\Page;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LanguagesBackendController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ["flag" => __("languages.flag"), "name" => __("languages.name"), "shortname" => __("languages.shortname"), "default" => __("languages.default"), "sort_order" => __("languages.sort_order")];
        if ($request->ajax()) {
            $data = Language::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('languages.edit', ["id" => $row->id]) . '" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i> ' . __('global.edit') . '</a>';
                    if ($row->id != 1) {
                        $btn .= '<a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="' . route('languages.delete', ["id" => $row->id]) . '" data-table=".language_datatable"><i class="fa-duotone fa-trash-xmark"></i> ' . __('global.delete') . '</a>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })->
            editColumn('flag', function ($row) {
                if (!$row->flag) {
                    $row->flag = "media/no-thumb.jpeg";
                }
                $btn = '<img src="' . $this->helper->image_url($row->flag, 80, 80) . '" class="img-thumbnail" />';
                return $btn;
            })
            ->addColumn('select_item', static function ($row) {
                if ($row->id != 1) {
                    return '<div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input bulk-item" id="bulk_item' . $row->id . '" name="bulk_item[]" value="' . $row->id . '">
                          <label class="custom-control-label" for="bulk_item' . $row->id . '"></label>
                        </div>';
                }
            })
            ->rawColumns(['action', 'select_item', 'flag'])
            ->make(true);
    }
return $this->render('backend.languages.index', ['table_columns' => $columns]);
}

/**
 * Store a newly created resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\Response
 */
public
function store(Request $request)
{
    $validate = $request->validate(["name" => "required", "shortname" => "required", "default" => "nullable", "sort_order" => "required", "flag" => "nullable"]);
    $language = new Language($request->only("name", "shortname", "default", "sort_order", "flag"));
    $language->save();
    $new_lang_dir = resource_path('lang/' . $request->get('shortname'));
    if (!is_dir($new_lang_dir)) {
        mkdir($new_lang_dir);
    }
    foreach (glob(resource_path('lang/en') . '/*.php') as $trans) {
        copy($trans, $new_lang_dir . "/" . basename($trans));
    }
    session()->flash("flash_notification", [
        "level" => "success",
        "message" => __('language.added_message')
    ]);
    return redirect()->route('languages.index');
}

/**
 * Display the specified resource.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
public
function show($id = false)
{
    $language = false;
    if ($id) {
        $language = Language::find($id);
    }
    return $this->render('backend.languages.form', ['language' => $language]);
}

/**
 * Update the specified resource in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @param int $id
 * @return \Illuminate\Http\Response
 */
public
function update(Request $request, $id)
{
    $validate = $request->validate(["name" => "required", "shortname" => "required", "default" => "nullable", "sort_order" => "required", "flag" => "nullable"]);
    $language = Language::findOrFail($id);
    $language = $language->update($request->only("name", "shortname", "default", "sort_order", "flag"));
    session()->flash("flash_notification", [
        "level" => "success",
        "message" => __('language.updated_message')
    ]);
    return redirect()->route('languages.index');
}

/**
 * Remove the specified resource from storage.
 *
 * @param int $id
 * @return \Illuminate\Http\Response
 */
public
function destroy($id)
{
    if ($id == 1) {
        return false;
    }
    $language = Language::find($id);
    // Blog
    Blog::where('lang', $language->shortname)->delete();
    Service::where('lang', $language->shortname)->delete();
    Category::where('lang', $language->shortname)->delete();
    Page::where('lang', $language->shortname)->delete();
    Slider::where('lang', $language->shortname)->delete();
    Setting::where('lang', $language->shortname)->delete();
    if ($language) {
        foreach (glob(resource_path('lang/' . $language->shortname) . '/*.php') as $trans) {
            //unlink($trans);
        }
        //rmdir(resource_path('lang/' . $language->shortname));
    }
    return Language::destroy($id);
}

public
function bulk_delete(Request $request)
{
    if (in_array(1, $request->get('ids'))) {
        return false;
    }
    $languages = Language::whereIn('id', $request->get('ids'))->get();
    foreach ($languages as $language) {
        foreach (glob(resource_path('lang/' . $language->shortname) . '/*.php') as $trans) {
            unlink($trans);
        }
        rmdir(resource_path('lang/' . $language->shortname));
    }
    return Language::whereIn('id', $request->get('ids'))->delete();
}

}
