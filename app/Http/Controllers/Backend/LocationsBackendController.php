<?php

namespace App\Http\Controllers\Backend;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;



class LocationsBackendController extends BackendController
{
    public function index(Request $request)
    {
        $columns = ["company_name" => __("locations.company_name"), "city" => __("locations.city"), "related_person" => __("locations.related_person"), "phone_number" => __("locations.phone_number")];
        if ($request->ajax()) {
            $data = Location::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="'.route('locations.edit', ["id" => $row->id]).'" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i> Edit</a>
                              <a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="'.route('locations.delete', ["id" => $row->id]).'" data-table=".location_datatable"><i class="fa-duotone fa-trash-xmark"></i> Delete</a>
                            </div>';
                    return $btn;
                })
                ->editColumn('city', function($row){
                    $city = DB::table('cities')->where('city_no', $row->city)->first();
                    if(!$city){
                        return 'Seçilmedi';
                    }
                    return DB::table('cities')->where('city_no', $row->city)->first()->city_name;
                })
                ->addColumn('select_item', static function ($row) {
                return '<div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input bulk-item" id="bulk_item'.$row->id.'" name="bulk_item[]" value="'.$row->id.'">
                          <label class="custom-control-label" for="bulk_item'.$row->id.'"></label>
                        </div>';
                })
                ->rawColumns(['action', 'select_item'])
                ->make(true);
        }
        return $this->render('backend.locations.index', ['table_columns' => $columns]);
    }

    public function store(Request $request, $id = null): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate(["company_name" => "required", "city" => "required", "address" => "required", "related_person" => "required", "phone_number" => "required"]);
        Location::updateOrCreate(['id' => $id], $request->only("company_name", "city", "address", "related_person", "phone_number"));
        session()->flash("flash_notification", [
            "level"     => "success",
            "message"   => __('locations.added_message')
        ]);
        return redirect()->route('locations.index');
    }

    public function show($id=false)
    {
        $location = false;
         if($id){
            $location = Location::find($id);
         }
        return $this->render('backend.locations.form', ['location' => $location]);
    }

    public function destroy($id): int
    {
        return Location::destroy($id);
    }

    public function bulk_delete(Request $request)
    {
        return Location::whereIn('id', $request->get('ids'));
    }

}
