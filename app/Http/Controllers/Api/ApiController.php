<?php

namespace App\Http\Controllers\Api;

use App\Models\Language;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class ApiController extends BaseController
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

    private $allowed_dirs = ['defines', 'vehicles', 'materials', 'locations'];

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

    public function list($model, $filter = false)
    {
        if (!in_array($model, $this->allowed_dirs)) {
            return ['error' => 'permission_denied', 'status' => 403];
        }
        if ($filter) {
            $filter = explode(':', $filter);
        }
        $model = Str::singular($model);
        $model = ucfirst($model);
        $className = "\App\Models\\" . $model;
        try {
            $init = (new $className);
            if ($filter) {
                $init = $init->where($filter[0], $filter[1]);
            }
            return $init->get()->toArray();
        } catch (\Exception $e) {
            return ['error' => 'query_error', 'status' => 403];
        }
    }

}
