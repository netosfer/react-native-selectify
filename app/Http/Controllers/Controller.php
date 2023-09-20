<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Language;
use App\Models\Option;
use App\Models\Page;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $languages;
    /**
     * @var mixed
     */
    private $default_lang = 'en';
    /**
     * @var \MainHelper
     */
    private $helper;

    public function __construct()
    {
        $this->languages = Language::get();
        $this->helper = new \MainHelper();
        foreach ($this->languages as $lang) {
            if ($lang->default) {
                $this->default_lang = $lang;
            }
        }
    }

    public function resize($size)
    {
        $url = url()->current();
        $path = str_replace(url('/img/' . $size . '/'), '', $url);
        $path = ltrim($path, '/');
        $path = storage_path("app/public/" . $path);
        $sizes = explode('x', $size);
        define('RESIZER_SRC', $path);
        define('RESIZER_W', $sizes[0]);
        define('RESIZER_H', $sizes[1]);
        define('RESIZER_ZC', $sizes[2]);
        require storage_path('app/private/resizer.php');
    }

    public function view($view, $data = [])
    {
        $data['popular_categories'] = [];
        $data['languages'] = $this->languages;
        $data['default_lang'] = $this->default_lang;
        $data['helper'] = $this->helper;
        $data['settings'] = Setting::where('lang', config('app.locale'))->first();
        $data['meta'] = $data['meta'] ?? [];
        $options = Option::get();
        foreach ($options as $opt) {
            $data['options'][$opt->opt_key] = json_decode($opt->opt_val, true);
        }
        return view($view, $data);
    }
}
