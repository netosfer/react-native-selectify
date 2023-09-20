<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Define;
use App\Models\Language;

class BackendController extends Controller
{
    public $data;
    public $languages;
    public $helper;
    public $default_lang;
    public function __construct()
    {
        $languages = Language::orderBy('default', 'desc')->get();
        $this->languages = $languages;
        $this->data['languages'] = $this->languages;
        $this->default_lang = false;
        foreach($this->languages as $lang){
            if($lang->default){
                $this->default_lang = $lang->toArray();
            }
        }
        $this->helper = new \MainHelper();
    }

    public function render($view, $data=[]){
        $data = array_merge($data, $this->data);
        $data["helper"] = $this->helper;
        $data['defines'] = Define::get();
        return view($view, $data);
    }
}
