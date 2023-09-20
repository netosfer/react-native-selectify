<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UsersBackendController extends BackendController
{
    public function index(Request $request)
    {
        $columns = ["profile_photo_path" => __("users.profile_photo_path"), "name" => __("users.name"), "email" => __("users.email")];
        if ($request->ajax()) {
            $data = User::get();
            return DataTables::of($data)->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <a href="'.route('users.edit', ["id" => $row->id]).'" class="btn btn-warning"><i class="fa-duotone fa-pen-to-square"></i> '.__('global.edit').'</a>';
                    if($row->id != 1){
                        $btn .= '<a href="javascript:;" class="btn btn-danger delete-button" onClick="swalert(this)" data-url="'.route('users.delete', ["id" => $row->id]).'" data-table=".user_datatable"><i class="fa-duotone fa-trash-xmark"></i> '.__('global.delete').'</a>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })->editColumn('profile_photo_path', function($row){
                    if(!$row->profile_photo_path){
                        $row->profile_photo_path = "media/no-thumb.jpeg";
                    }
                    $btn = '<img src="'.$this->helper->image_url($row->profile_photo_path, 80, 80).'" class="img-thumbnail" />';
                    return $btn;
                })
                ->addColumn('select_item', static function ($row) {
                    if($row->id != 1){
                        return '<div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input bulk-item" id="bulk_item'.$row->id.'" name="bulk_item[]" value="'.$row->id.'">
                          <label class="custom-control-label" for="bulk_item'.$row->id.'"></label>
                        </div>';
                    }
                })
                ->rawColumns(['action', 'select_item', 'profile_photo_path'])
                ->make(true);
        }
        return $this->render('backend.users.index', ['table_columns' => $columns]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate(["profile_photo_path" => "nullable", "name" => "required", "email" => "required", "email_verified_at" => "nullable",  "remember_token" => "nullable", "is_admin" => "nullable"]);
        $user = new user($request->only("profile_photo_path", "name", "email", "email_verified_at", "password", "remember_token", "is_admin"));
        $user->save();
        session()->flash("flash_notification", [
            "level"     => "success",
            "message"   => __('users.added_message')
        ]);
        return redirect()->route('users.index');
    }

    public function show($id=false)
    {
        $user = false;
         if($id){
            $user = User::find($id);
         }
        return $this->render('backend.users.form', ['user' => $user]);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $validate = $request->validate(["profile_photo_path" => "nullable", "name" => "required", "email" => "required", "phone_number" => "required", "email_verified_at" => "nullable", "password" => "nullable", "remember_token" => "nullable", "is_admin" => "nullable"]);
        $user = User::findOrFail($id);
        $user = $user->update($request->only("profile_photo_path", "name", "email", "phone_number",  "is_admin"));
        session()->flash("flash_notification", [
            "level"     => "success",
            "message"   => __('users.updated_message')
        ]);
        return redirect()->route('users.index');
    }

    public function destroy($id): int
    {
        if($id == 1){
            return false;
        }
        return User::destroy($id);
    }

    public function bulk_delete(Request $request)
    {
        if(in_array(1, $request->get('ids'))){
            return false;
        }
        return User::whereIn('id', $request->get('ids'));
    }

}
