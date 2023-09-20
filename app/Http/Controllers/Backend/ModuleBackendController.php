<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ModuleBackendController extends BackendController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($file=null)
    {
        if($file){
            $file = file_get_contents(storage_path('modules/'.$file));
            $file = json_decode($file, true);
        }
        $modules = glob(storage_path('modules/*.json'));
        return $this->render('backend.module.index', ['module' => $file, 'modules' => $modules]);
    }

    public function make(Request $request){
        $out['module'] = $request->get('module')['module'];
        $out['language'] = $request->has('language') && $request->get('language') == 1 ? true : false;
        $out['addable'] = $request->has('addable') && $request->get('addable') == 1 ? true : false;
        $fields_count = count($request->get('fields')['label']);
        $out['fields'] = [];
        for($i = 0; $i < $fields_count; $i++){
            $row = [];
            $row['label'] = $request->get('fields')['label'][$i];
            $row['name'] = $this->helper->slugify($row['label'], ['delimiter' => '_']);
            $row['form'] = $request->get('fields')['form'][$i];
            if(isset($request->get('fields')['values'][$i])){
                $row['values'] = json_decode($request->get('fields')['values'][$i], true);
            }
            $row['type'] = $request->get('fields')['type'][$i];
            $row['table_type'] = $request->get('fields')['table_type'][$i];
            $row['required'] = isset($request->get('fields')['required'][$i]) && $request->get('fields')['required'][$i] == '1' ? true : false;
            $row['column'] = isset($request->get('fields')['column'][$i]) && $request->get('fields')['column'][$i] == '1' ? true : false;
            $row['only_main_lang'] = isset($request->get('fields')['only_main_lang'][$i]) && $request->get('fields')['only_main_lang'][$i] == '1' ? true : false;
            $out['fields'][] = $row;
        }
        $module_name = $this->helper->slugify($out['module'], ['delimiter' => '_']);
        $module_name = $this->helper->snakeToCamel($module_name);
        $new_path = storage_path('modules/'.$module_name.'.json');
        if(file_exists($new_path)){
            unlink($new_path);
        }
        file_put_contents($new_path, json_encode($out, JSON_PRETTY_PRINT));
        Artisan::call('make:module "'. $out['module'].'"');
        return redirect()->route('admin.dashboard');
    }

}
