<?php

namespace App\Http\Controllers\Backend;

use App\Models\language;
use Illuminate\Http\Request;

class TranslationsBackendController extends BackendController
{
    public function index($translate = 'global')
    {
        $languages = Language::get();
        $translations = [];
        foreach ($languages as $language) {
            $translation = is_file(resource_path('lang/' . $language->shortname . '/' . $translate . '.php')) ? include(resource_path('lang/' . $language->shortname . '/' . $translate . '.php')) : include(resource_path('lang/' . config('app.locale') . '/' . $translate . '.php'));
            foreach ($translation as $key => $val) {
                $translations[$key][$language->shortname] = $val;
            }
        }
        $files = glob(resource_path('lang/' . config('app.locale') . '/*.php'));
        return $this->render('backend.translations.index', ['languages' => $languages, 'translations' => $translations, 'files' => $files, 'current' => $translate]);
    }

    public function store(Request $request, $translate = 'global')
    {
        $languages = Language::get();
        $translations = $request->all();
        unset($translations['_token']);
        foreach ($translations as $key => $translation) {
            foreach ($languages as $lang) {
                $return[$lang->shortname][$key] = $translation[$lang->shortname];
            }
        }
        foreach ($languages as $lang) {
            $file = resource_path('lang/'.$lang->shortname.'/'.$translate.'.php');
            $out = [];
            $out[] = "<?php";
            $out[] = "";
            $out[] = "return [";
            foreach($return[$lang->shortname] as $key => $val){
                $out[] = "\t".'"'.$key.'" => "'.$val.'",';
            }
            $out[] = "];";
            $result = implode("\n", $out);
            file_put_contents($file, $result);
        }
        session()->flash("flash_notification", [
            "level" => "success",
            "message" => __('language.added_message')
        ]);
        return redirect()->route('translations.index_translate', ['translate' => $translate]);
    }
}
