<?php

namespace App\Http\Controllers\Backend;

use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;



class EmployeesBackendController extends BackendController
{
    public function index(Request $request)
    {
        $columns = ["employee_type" => __("employees.employee_type"), "employee_id" => __("employees.employee_id"), "full_name" => __("employees.full_name"), "employee_duty" => __("employees.employee_duty"), "start_date_of_work" => __("employees.start_date_of_work")];
        if ($request->ajax()) {
            $data = Employee::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="'.route('employees.edit', ["id" => $row->id]).'" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i> Edit</a>
                              <a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="'.route('employees.delete', ["id" => $row->id]).'" data-table=".employee_datatable"><i class="fa-duotone fa-trash-xmark"></i> Delete</a>
                            </div>';
                    return $btn;
                })
                ->addColumn('select_item', static function ($row) {
                return '<div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input bulk-item" id="bulk_item'.$row->id.'" name="bulk_item[]" value="'.$row->id.'">
                          <label class="custom-control-label" for="bulk_item'.$row->id.'"></label>
                        </div>';
                })
                ->editColumn('employee_type', static function($row){
                    $types = json_decode(\App\Models\Define::where('type', 'employee-types')->first()->values, true);
                    return isset($types[$row->employee_type]) ? $types[$row->employee_type] : 'Seçilmedi';
                })
                ->editColumn('employee_duty', static function($row){
                    $types = json_decode(\App\Models\Define::where('type', 'employee-classes')->first()->values, true);
                    return isset($types[$row->employee_duty]) ? $types[$row->employee_duty] : 'Seçilmedi';
                })
                ->rawColumns(['action', 'select_item'])
                ->make(true);
        }
        return $this->render('backend.employees.index', ['table_columns' => $columns]);
    }

    public function store(Request $request, $id = null): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate(["employee_type" => "required", "employee_id" => "nullable", "full_name" => "required", "employee_duty" => "required", "start_date_of_work" => "nullable", "end_date_of_work" => "nullable", "files" => "nullable"]);
        Employee::updateOrCreate(['id' => $id], $request->only("employee_type", "employee_id", "full_name", "employee_duty", "start_date_of_work", "end_date_of_work", "files"));
        session()->flash("flash_notification", [
            "level"     => "success",
            "message"   => __('employees.added_message')
        ]);
        return redirect()->route('employees.index');
    }

    public function show($id=false)
    {
        $employee = false;
         if($id){
            $employee = Employee::find($id);
         }
        return $this->render('backend.employees.form', ['employee' => $employee]);
    }

    public function destroy($id): int
    {
        return Employee::destroy($id);
    }

    public function bulk_delete(Request $request)
    {
        return Employee::whereIn('id', $request->get('ids'));
    }

}
