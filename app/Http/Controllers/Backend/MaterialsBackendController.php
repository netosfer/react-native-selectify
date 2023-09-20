<?php

namespace App\Http\Controllers\Backend;

use App\Models\Material;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;



class MaterialsBackendController extends BackendController
{
    public function index(Request $request)
    {
        $columns = ["image" => __("materials.image"), "name" => __("materials.name"), "material_type" => __("materials.material_type"), "rfid_code" => __("materials.rfid_code"), "received_date" => __("materials.received_date")];
        if ($request->ajax()) {
            $data = Material::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="'.route('materials.edit', ["id" => $row->id]).'" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i> Edit</a>
                              <a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="'.route('materials.delete', ["id" => $row->id]).'" data-table=".material_datatable"><i class="fa-duotone fa-trash-xmark"></i> Delete</a>
                            </div>';
                    return $btn;
                })->editColumn('image', function($row){
                    if(!$row->image){
                        $row->image = "media/no-thumb.jpeg";
                    }
                    $btn = '<img src="'.$this->helper->image_url($row->image, 80, 80).'" class="img-thumbnail" />';
                    return $btn;
                })
                ->addColumn('select_item', static function ($row) {
                return '<div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input bulk-item" id="bulk_item'.$row->id.'" name="bulk_item[]" value="'.$row->id.'">
                          <label class="custom-control-label" for="bulk_item'.$row->id.'"></label>
                        </div>';
                })
                ->editColumn('material_type', static function($row){
                    $types = json_decode(\App\Models\Define::where('type', 'material-types')->first()->values, true);
                    return isset($types[$row->material_type]) ? $types[$row->material_type] : 'Seçilmedi';
                })
                ->rawColumns(['action', 'select_item', 'image'])
                ->make(true);
        }
        return $this->render('backend.materials.index', ['table_columns' => $columns]);
    }

    public function store(Request $request, $id = null): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate(["image" => "nullable", "name" => "required", "material_type" => "required", "material_code" => "required", "rfid_code" => "required", "received_date" => "nullable"]);
        Material::updateOrCreate(['id' => $id], $request->only("image", "name", "material_type", "material_code", "rfid_code", "received_date"));
        session()->flash("flash_notification", [
            "level"     => "success",
            "message"   => __('materials.added_message')
        ]);
        return redirect()->route('materials.index');
    }

    public function show($id=false)
    {
        $material = false;
         if($id){
            $material = Material::find($id);
         }
        return $this->render('backend.materials.form', ['material' => $material]);
    }

    public function destroy($id): int
    {
        return Material::destroy($id);
    }

    public function bulk_delete(Request $request)
    {
        return Material::whereIn('id', $request->get('ids'));
    }

}
