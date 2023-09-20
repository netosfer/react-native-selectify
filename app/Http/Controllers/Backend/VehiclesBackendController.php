<?php

namespace App\Http\Controllers\Backend;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;



class VehiclesBackendController extends BackendController
{
    public function index(Request $request)
    {
        $columns = ["plate_no" => __("vehicles.plate_no"), "brand_name" => __("vehicles.brand_name"), "model_name" => __("vehicles.model_name"), "maintenance_date" => __("vehicles.maintenance_date"), "insurance_date" => __("vehicles.insurance_date"), "vehicle_type" => __("vehicles.vehicle_type")];
        if ($request->ajax()) {
            $data = Vehicle::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="'.route('vehicles.edit', ["id" => $row->id]).'" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i> Edit</a>
                              <a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="'.route('vehicles.delete', ["id" => $row->id]).'" data-table=".vehicle_datatable"><i class="fa-duotone fa-trash-xmark"></i> Delete</a>
                            </div>';
                    return $btn;
                })
                ->addColumn('select_item', static function ($row) {
                return '<div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input bulk-item" id="bulk_item'.$row->id.'" name="bulk_item[]" value="'.$row->id.'">
                          <label class="custom-control-label" for="bulk_item'.$row->id.'"></label>
                        </div>';
                })
                ->editColumn('vehicle_type', static function($row){
                    $types = json_decode(\App\Models\Define::where('type', 'vehicle-types')->first()->values, true);
                    return isset($types[$row->vehicle_type]) ? $types[$row->vehicle_type] : 'Seçilmedi';
                })
                ->rawColumns(['action', 'select_item'])
                ->make(true);
        }
        return $this->render('backend.vehicles.index', ['table_columns' => $columns]);
    }

    public function store(Request $request, $id = null): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate(["plate_no" => "required", "brand_name" => "required", "model_name" => "nullable", "maintenance_date" => "nullable", "insurance_date" => "nullable", "vehicle_type" => "nullable"]);
        Vehicle::updateOrCreate(['id' => $id], $request->only("plate_no", "brand_name", "model_name", "maintenance_date", "insurance_date", "vehicle_type"));
        session()->flash("flash_notification", [
            "level"     => "success",
            "message"   => __('vehicles.added_message')
        ]);
        return redirect()->route('vehicles.index');
    }

    public function show($id=false)
    {
        $vehicle = false;
         if($id){
            $vehicle = Vehicle::find($id);
         }
        return $this->render('backend.vehicles.form', ['vehicle' => $vehicle]);
    }

    public function destroy($id): int
    {
        return Vehicle::destroy($id);
    }

    public function bulk_delete(Request $request)
    {
        return Vehicle::whereIn('id', $request->get('ids'));
    }

}
