<?php

namespace App\Http\Controllers\Backend;

use App\Models\Define;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class DefinesBackendController extends BackendController
{
    public function index(Request $request)
    {
        $columns = ["type" => __("defines.type"), "name" => __("defines.name")];
        if ($request->ajax()) {
            $data = Define::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="' . route('defines.edit', ["id" => $row->id]) . '" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i> Edit</a>
                              <a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="' . route('defines.delete', ["id" => $row->id]) . '" data-table=".define_datatable"><i class="fa-duotone fa-trash-xmark"></i> Delete</a>
                            </div>';
                    return $btn;
                })
                ->addColumn('select_item', static function ($row) {
                    return '<div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input bulk-item" id="bulk_item' . $row->id . '" name="bulk_item[]" value="' . $row->id . '">
                          <label class="custom-control-label" for="bulk_item' . $row->id . '"></label>
                        </div>';
                })
                ->rawColumns(['action', 'select_item'])
                ->make(true);
        }
        return $this->render('backend.defines.index', ['table_columns' => $columns]);
    }

    public function store(Request $request, $id = null): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate(["type" => "required", "name" => "required", "values" => "required", "kind" => "nullable"]);
        $arr = $request->only("type", "name", "values", "kind");
        if (is_array($arr['values'])) {
            $arr['values'] = json_encode($arr['values']);
        }
        Define::updateOrCreate(['id' => $id], $arr);
        session()->flash("flash_notification", [
            "level" => "success",
            "message" => __('defines.added_message')
        ]);
        return redirect()->back();
    }

    public function show($id = false)
    {
        $define = false;
        if ($id) {
            $define = Define::find($id);
        }
        return $this->render('backend.defines.form', ['define' => $define]);
    }

    public function showByType($type)
    {
        $define = false;
        if ($type) {
            $define = Define::where('type', $type)->first();
        }
        if ($define && (new \MainHelper())->is_json($define->values)) {
            $define->values = json_decode($define->values, true);
            if (empty($define->values)) {
                $define->values = [''];
            }
        } else {
            $define->values = [''];
        }
        return $this->render('backend.defines.form', ['define' => $define]);
    }

    public function destroy($id): int
    {
        return Define::destroy($id);
    }

    public function bulk_delete(Request $request)
    {
        return Define::whereIn('id', $request->get('ids'));
    }

}
