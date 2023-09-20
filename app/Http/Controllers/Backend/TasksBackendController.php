<?php

namespace App\Http\Controllers\Backend;

use App\Models\Task;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;



class TasksBackendController extends BackendController
{
    public function index(Request $request)
    {
        $columns = ["employee.full_name" => __("tasks.employess"), "location.company_name" => __("tasks.location"), "material.name" => __("tasks.materials"), "vehicle.plate_no" => __("tasks.vehicle"), "start_date" => __("tasks.start_date"), "task_type" => __("tasks.task_type")];
        if ($request->ajax()) {
            $data = Task::with("employee", "location", "material", "vehicle")->get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="'.route('tasks.edit', ["id" => $row->id]).'" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i> Edit</a>
                              <a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="'.route('tasks.delete', ["id" => $row->id]).'" data-table=".task_datatable"><i class="fa-duotone fa-trash-xmark"></i> Delete</a>
                            </div>';
                    return $btn;
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
        return $this->render('backend.tasks.index', ['table_columns' => $columns]);
    }

    public function store(Request $request, $id = null): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate(["employess" => "required", "location" => "required", "materials" => "required", "vehicle" => "required", "start_date" => "required", "end_date" => "nullable", "task_type" => "required", "notes" => "nullable"]);
        Task::updateOrCreate(['id' => $id], $request->only("employess", "location", "materials", "vehicle", "start_date", "end_date", "task_type", "notes"));
        session()->flash("flash_notification", [
            "level"     => "success",
            "message"   => __('tasks.added_message')
        ]);
        return redirect()->route('tasks.index');
    }

    public function show($id=false)
    {
        $task = false;
         if($id){
            $task = Task::find($id);
         }
        return $this->render('backend.tasks.form', ['task' => $task]);
    }

    public function destroy($id): int
    {
        return Task::destroy($id);
    }

    public function bulk_delete(Request $request)
    {
        return Task::whereIn('id', $request->get('ids'));
    }

}
