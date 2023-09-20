<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {module_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $original_name = $this->argument('module_name');
        $module = Str::singular($original_name);
        $module = (new \MainHelper)->slugify($module, ['delimiter' => '_']);
        $module = (new \MainHelper)->snakeToCamel($module);
        $module_plural = Str::plural($module);
        Artisan::call('delete:module '. $module . ' false');
        $module_lower = $module; // todo : module_lower kaldır
        $request = file_get_contents(storage_path('modules/' . $module_lower . '.json'));
        $request = json_decode($request, true);
        $this->add_to_menu($module, $module_lower, $request);
        Artisan::call('make:model ' . ucfirst($module) . ' -m');
        Artisan::call('make:controller Frontend/' . ucfirst($module_plural) . 'Controller');
        Artisan::call('make:controller Backend/' . ucfirst($module_plural) . 'BackendController');
        $this->make_backend_controller($module, $module_lower, $request);
        $this->make_frontend_view($module, $module_lower);
        $this->make_backend_view($module, $module_lower, $request);
        $this->make_web_route($module, $module_lower, $request);
        $this->make_backend_form_view($module, $module_lower, $request);
        $this->make_lang($module, $module_lower, $request);
        $this->make_migration($module, $module_lower, $request);
        $this->update_model($module, $module_lower, $request);
        Artisan::call('migrate');
        return 0;
    }

    public function make_backend_controller($module, $module_lower, $request)
    {
        $cols = [];
        $validate = [];
        $only = [];
        $withs = [];
        $addcolumn = '';
        $datatable_raw = '';
        foreach ($request['fields'] as $field) {
            if (isset($field['type']) && $field['type'] != 'array') {
                $withs[] = '"' . strtolower($field['values']['model']) . '"';
                if ($field['column']) {
                    $cols[] = '"' . strtolower($field['values']['model']) . '.' . $field['values']['value'] . '" => __("' . Str::plural($module_lower) . '.' . $field['name'] . '")';
                }
            } else {
                if ($field['column']) {
                    $cols[] = '"' . $field['name'] . '" => __("' . Str::plural($module_lower) . '.' . $field['name'] . '")';
                }
            }
            $val = $field['required'] ? 'required' : 'nullable';
            if ($request['language'] && !$field['only_main_lang']) {
                $validate[] = '"' . $field['name'] . '.".$lang->shortname => "' . $val . '"';
            } else {
                $validate[] = '"' . $field['name'] . '" => "' . $val . '"';
            }
            if ($request['language'] && !$field['only_main_lang']) {
                $only[] = '"' . $field['name'] . '.".$lang->shortname';
            } else {
                $only[] = '"' . $field['name'] . '"';
            }

            if ($field['form'] == 'image' && $field['column']) {
                $datatable_raw .= ', "' . $field['name'] . '"';
                $addcolumn .= '->editColumn(\'' . $field['name'] . '\', function($row){
                    if(!$row->' . $field['name'] . '){
                        $row->' . $field['name'] . ' = "media/no-thumb.jpeg";
                    }
                    $btn = \'<img src="\'.$this->helper->image_url($row->' . $field['name'] . ', 80, 80).\'" class="img-thumbnail" />\';
                    return $btn;
                })';
            }
        }
        if ($withs) {
            $withs = "with(" . implode(', ', $withs) . ")->";
        } else {
            $withs = '';
        }
        if ($request['language']) {
            $view = storage_path('stubs/controllers/backend_lang.stub');
        } else {
            $view = storage_path('stubs/controllers/backend.stub');
        }
        $route_plural_u = Str::plural($module_lower);
        $route_plural_u = (new \MainHelper())->camelToSnake($route_plural_u);
        $route_plural_u = (new \MainHelper())->slugify($route_plural_u);
        $view = file_get_contents($view);
        $from = ['$MODULE_NAME', '$MODULE_LOWER', '$MODULE_PLURAL_U', '$ROUTE_PLURAL_U', '$MODULE_PLURAL_L', '$MODULE_SINGULAR_L', '$MODULE_SINGULAR_U', '$MODULE_COLUMNS', '$MODULE_VALIDATE', '$MODULE_ONLY', '$MODULE_WITHS', '$MODULE_ID', '$MODULE_ADDCOLUMN', '$MODULE_DATATABLE_RAW'];
        $id = $request["language"] ? 'uniq_key' : 'id';
        $to = [ucfirst($module), $module_lower, Str::plural($module_lower), $route_plural_u, ucfirst(Str::plural($module)), ucfirst(Str::singular($module_lower)), ucfirst(Str::singular($module)), implode(', ', $cols), implode(', ', $validate), implode(', ', $only), $withs, $id, $addcolumn, $datatable_raw];
        $view = str_replace($from, $to, $view);
        return file_put_contents(app_path('Http/Controllers/Backend') ."/". ucfirst(Str::plural($module)) . 'BackendController.php', $view);
    }

    public function make_frontend_view($module, $module_lower)
    {
        $view = storage_path('stubs/frontend.stub');
        $view = file_get_contents($view);
        $from = ['$MODULE_NAME', '$MODULE_LOWER', '$MODULE_PLURAL', '$MODULE_SINGULAR_L', '$MODULE_SINGULAR_U'];
        $to = [$module, $module_lower, Str::plural($module_lower), Str::singular($module_lower), Str::singular($module)];
        $view = str_replace($from, $to, $view);
        $new_dir = base_path('resources/views/' . Str::plural($module_lower));
        if (!is_dir($new_dir)) {
            mkdir($new_dir);
        }
        return file_put_contents(base_path('resources/views/' . Str::plural($module_lower) . '/index.blade.php'), $view);
    }

    public function make_backend_view($module, $module_lower, $request)
    {
        //{data: '{{ $key }}', name: '{{ str_replace('.', '', $col) }}'},
        $columns = [];
        $columns_th = [];
        $view = storage_path('stubs/backend.stub');
        $view = file_get_contents($view);
        $module_plural = Str::plural($module_lower);
        $module_plural = (new \MainHelper())->camelToSnake($module_plural);
        $module_plural = (new \MainHelper())->slugify($module_plural);
        foreach ($request['fields'] as $field) {
            if ($field['column']) {
                if ($field['form'] == 'image') {
                    $columns[] = "{data: '" . $field['name'] . "', name: '" . $field['name'] . "', orderable: false, searchable: false}";
                    $columns_th[] = "<th width=\"80\" style=\"max-width: 80px\" class=\"more-dots\">{{ __('" . $module_plural . "." . $field['name'] . "') }}</th>";
                } else if ($field['form'] == 'date' || $field['form'] == 'datetime') {
                    $columns[] = "{data: '" . $field['name'] . "', name: '" . $field['name'] . "'}";
                    $columns_th[] = "<th width=\"140\" style=\"max-width: 140px\" class=\"more-dots\">{{ __('" . $module_plural . "." . $field['name'] . "') }}</th>";
                } else {
                    $columns[] = "{data: '" . $field['name'] . "', name: '" . $field['name'] . "'}";
                    $columns_th[] = "<th>{{ __('" . $module_plural . "." . $field['name'] . "') }}</th>";
                }
            }
        }
        $module_plural = Str::plural($module_lower);
        $module_plural = (new \MainHelper())->camelToSnake($module_plural);
        $module_plural = (new \MainHelper())->slugify($module_plural);
        $from = ['$MODULE_NAME', '$MODULE_LOWER', '$MODULE_PLURAL', '$MODULE_SINGULAR_L', '$MODULE_SINGULAR_U', '$MODULE_DATATABLE_COLUMNS', '$MODULE_DATATABLE_TH'];
        $to = [$module, $module_lower, $module_plural, Str::singular($module_lower), Str::singular($module), implode(", \n\t\t\t\t\t", $columns), implode("\n\t\t\t\t\t\t\t\t\t", $columns_th)];
        $view = str_replace($from, $to, $view);
        $new_dir = base_path('resources/views/backend/' . Str::plural($module_lower));
        if (!is_dir($new_dir)) {
            mkdir($new_dir);
        }
        return file_put_contents(base_path('resources/views/backend/' . Str::plural($module_lower) . '/index.blade.php'), $view);
    }

    public function make_web_route($module, $module_lower, $request)
    {
        $view = storage_path('stubs/routes/web.stub');
        $view = file_get_contents($view);
        $id = $request["language"] ? 'uniq_key' : 'id';
        $module_plural_l = (new \MainHelper())->camelToSnake(Str::plural($module_lower));
        $module_plural_l = (new \MainHelper())->slugify($module_plural_l);
        $from = ['$MODULE_NAME', '$MODULE_LOWER', '$MODULE_PLURAL_L', '$MODULE_PLURAL_U', '$MODULE_SINGULAR_L', '$MODULE_SINGULAR_U', '$MODULE_ID'];
        $to = [$module, $module_lower, $module_plural_l, ucfirst(Str::plural($module)), Str::singular($module_lower), ucfirst(Str::singular($module)), $id];
        $view = str_replace($from, $to, $view);
        return file_put_contents(base_path('routes/modules/' . Str::plural($module_lower) . '.php'), $view);
    }

    public function make_backend_form_view($module, $module_lower, $request)
    {
        $output = [];
        $module_plural = Str::plural($module_lower);
        $module_plural = (new \MainHelper())->camelToSnake($module_plural);
        $module_plural = (new \MainHelper())->slugify($module_plural);
        foreach ($request['fields'] as $field) {
            $field_name = $field['name'];
            if ($request['language'] && $field['only_main_lang']) {
                $out = '<div class="pl-3 pr-3 pt-1 pb-1">';
                $out .= '@if($lang->default)';
                $out .= '{!! ';
            } else {
                $out = '<div class="pl-3 pr-3 pt-1 pb-1">{!! ';
            }
            if ($request['language']) {
                $field_name = $field['name'] . "['.\$lang->shortname.']";
                if ($field['only_main_lang']) {
                    $field_name = $field['name'];
                }
            }
            if ($field['form'] == "image") {
                if ($request['language']) {
                    if ($field['only_main_lang']) {
                        $out .= "MainHelper::FileManager('" . $field_name . "', isset($" . $module_lower . ") && $" . $module_lower . " && isset($" . $module_lower . "[\$lang->shortname]) ? $" . $module_lower . "[\$lang->shortname]->" . $field["name"] . " : null, '" . $field['label'] . "')";
                    } else {
                        $out .= "MainHelper::FileManager('" . $field_name . "['.\$lang->shortname.']', isset($" . $module_lower . ") && $" . $module_lower . " && isset($" . $module_lower . "[\$lang->shortname]) ? $" . $module_lower . "[\$lang->shortname]->" . $field["name"] . " : null, '" . $field['label'] . "')";
                    }
                } else {
                    $out .= "MainHelper::FileManager('" . $field_name . "', isset($" . $module_lower . ") && $" . $module_lower . " ? $" . $module_lower . "->" . $field["name"] . " : null, '" . $field['label'] . "')";
                }
            } elseif ($field['form'] == "images") {
                if ($request['language']) {
                    if ($field['only_main_lang']) {
                        $out .= "MainHelper::FileManager('" . $field_name . "', isset($" . $module_lower . ") && $" . $module_lower . " && isset($" . $module_lower . "[\$lang->shortname]) ? $" . $module_lower . "[\$lang->shortname]->" . $field["name"] . " : null, '" . $field['label'] . "', true)";
                    } else {
                        $out .= "MainHelper::FileManager('" . $field_name . "['.\$lang->shortname.']', isset($" . $module_lower . ") && $" . $module_lower . " && isset($" . $module_lower . "[\$lang->shortname]) ? $" . $module_lower . "[\$lang->shortname]->" . $field["name"] . " : null, '" . $field['label'] . "', true)";
                    }
                } else {
                    $out .= "MainHelper::FileManager('" . $field_name . "', isset($" . $module_lower . ") && $" . $module_lower . " ? $" . $module_lower . "->" . $field["name"] . " : null, '" . $field['label'] . "', true)";
                }
            } else {
                $out .= "Form::" . $field['form'] . "('" . $field_name . "', __('" . $module_plural . "." . strtolower($field['name']) . "'))";
                if ($field['form'] == 'select') {
                    if ($field["type"] != "array") {
                        $out .= "->options(\\App\\Models\\" . $field['values']['model'] . "::get()->prepend('', ''))";
                    } else {
                        $field['values'] = str_replace("[", "['' => __('" . $module_plural . ".choose" . "'), ", $field["values"]);
                        $out .= "->options(" . $field['values'] . ")";
                    }
                    $out .= "->attrs(['class' => 'select2', 'data-placeholder' => __('" . $module_plural . ".choose" . "')])";
                }
                $values = '';
                if(isset($field['values']) && $field['form'] != 'select'){
                    $values = $field['values'];
                }
                if ($request['language']) {
                    $out .= '->value(isset($' . $module_lower . ') && $' . $module_lower . ' && isset($' . $module_lower . '[$lang->shortname]) ? $' . $module_lower . '[$lang->shortname]->' . $field['name'] . ' : "'.$values.'")';
                } else {
                    $out .= '->value(isset($' . $module_lower . ') && $' . $module_lower . ' ? $' . $module_lower . '->' . $field['name'] . ' : "'.$values.'")';
                }
                if ($field['required']) {
                    $out .= "->required()";
                }
            }
            if ($request['language'] && $field['only_main_lang']) {
                $out .= ' !!}';
                $out .= '@endif';
            } else {
                $out .= ' !!}';
            }

            $out = str_replace('/', '\\', $out) . "</div>";
            $output[] = $out;
        }
        $view = storage_path('stubs/views/form.stub');
        if ($request['language']) {
            $view = storage_path('stubs/views/form_lang.stub');
        }
        $module_plural = Str::plural($module_lower);
        $module_plural = (new \MainHelper())->camelToSnake($module_plural);
        $module_plural = (new \MainHelper())->slugify($module_plural);
        $view = file_get_contents($view);
        $id = $request["language"] ? 'uniq_key' : 'id';
        $from = ['$MODULE_NAME', '$MODULE_LOWER', '$MODULE_PLURAL', '$MODULE_SINGULAR_L', '$MODULE_SINGULAR_U', '$MODULE_FORMS', '$MODULE_ID'];
        $to = [$module, $module_lower, $module_plural, Str::singular($module_lower), Str::singular($module), implode("\n", $output), $id];
        $view = str_replace($from, $to, $view);
        return file_put_contents(base_path('resources/views/backend/' . Str::plural($module_lower) . '/form.blade.php'), $view);
    }

    public function make_lang($module, $module_lower, $request)
    {
        $output = [];
        foreach ($request['fields'] as $i => $field) {
            $prefix = "\t";
            if (!$i) {
                $prefix = "";
            }
            $out = $prefix . '"' . strtolower($field['name']) . '" => "' . $field['label'] . '"';
            $output[] = $out;
        }
        $view = storage_path('stubs/lang.stub');
        $view = file_get_contents($view);
        $module_name = Str::singular($module);
        $module_name = (new \MainHelper())->camelCaseToWords($module_name);
        $lang_plural = Str::plural($module);
        $lang_plural = (new \MainHelper())->camelCaseToWords($lang_plural);
        $from = ['$MODULE_NAME', '$MODULE_LOWER', '$MODULE_PLURAL_L', '$MODULE_PLURAL_U', '$MODULE_SINGULAR_L', '$MODULE_SINGULAR_U', '$MODULE_LANGS'];
        $to = [$module_name, $module_lower, Str::plural($module_lower), $lang_plural, Str::singular($module_lower), Str::singular($module), implode(",\n", $output)];
        $view = str_replace($from, $to, $view);
        return file_put_contents(base_path('resources/lang/en/' . (new \MainHelper())->slugify((new \MainHelper())->camelToSnake(Str::plural($module_lower))) . '.php'), $view);
    }

    public function make_migration($module, $module_lower, $request)
    {
        $migration_path = '';
        foreach (glob(base_path('database/migrations/*.php')) as $mig) {
            Log::alert('create_' . Str::plural((new \MainHelper())->camelToSnake($module_lower)) . '_table');
            if (strpos($mig, 'create_' . Str::plural((new \MainHelper())->camelToSnake($module_lower)) . '_table')) {
                $migration_path = $mig;
            }
        }
        if (!$migration_path) {
            return false;
        }
        $table_rows = [];
        $table_rows[] = '$table->id();';
        if ($request['language']) {
            $table_rows[] = "\t\t\t" . '$table->string("lang")->default("en");';
            $table_rows[] = "\t\t\t" . '$table->string("uniq_key");';
        }
        foreach ($request['fields'] as $field) {
            $row = "\t\t\t";
            $row .= '$table->' . $field['table_type'] . '("' . $field['name'] . '")';
            if (!$field['required']) {
                $row .= '->nullable();';
            } else {
                $row .= ';';
            }
            $table_rows[] = $row;
        }
        $view = $migration_path;
        $view = file_get_contents($view);
        $from = ['$MODULE_NAME', '$MODULE_LOWER', '$MODULE_PLURAL', '$table->id();'];
        $to = [$module, $module_lower, Str::plural($module_lower), implode("\n", $table_rows)];
        $view = str_replace($from, $to, $view);
        return file_put_contents($migration_path, $view);
    }

    public function update_model($module, $module_lower, $request)
    {
        $migration_path = app_path('Models/' . $module . '.php');
        $func = [];
        $fillable = [];
        if ($request['language']) {
            $fillable[] = '"uniq_key"';
            $fillable[] = '"lang"';
        }
        foreach ($request['fields'] as $field) {
            if (isset($field['form']) && $field['form']) {
                $fillable[] = '"' . $field['name'] . '"';
            }
            if (isset($field['type']) && $field['type'] != "array") {
                $name = isset($field['values']['multiple']) && $field['values']['multiple'] ? Str::plural(strtolower($field['values']['model'])) : strtolower($field['values']['model']);
                $func[] = "\tpublic function " . $name . "(){ return \$this->" . $field['type'] . "(" . $field['values']['model'] . "::class, '" . $field['name'] . "'); }";
            }
        }
        $view = file_get_contents($migration_path);
        $exp = explode("\n", $view);
        $line_number = count($exp);
        $extra_code = implode("\n", $func);
        if (strpos($view, '$fillable') === false) {
            array_splice($exp, ($line_number - 2), 0, "\tprotected \$fillable = " . '[' . implode(', ', $fillable) . '];');
            $view = implode("\n", $exp);
            file_put_contents($migration_path, $view);
        }

        $view = file_get_contents($migration_path);
        $exp = explode("\n", $view);
        $line_number = count($exp);
        array_splice($exp, ($line_number - 2), 0, $extra_code);
        $view = implode("\n", $exp);
        file_put_contents($migration_path, $view);
    }

    public function add_to_menu($module, $module_lower, $request){
        $sidebar_path = resource_path('views/backend/partials/left-sidebar.blade.php');
        $sidebar = file_get_contents($sidebar_path);

        $menu_item = storage_path('stubs/menu-item.stub');
        $menu_item = file_get_contents($menu_item);
        $module_plural = Str::plural($module_lower);
        $module_plural = (new \MainHelper())->camelToSnake($module_plural);
        $module_plural = (new \MainHelper())->slugify($module_plural);
        $from = ['$MODULE_NAME', '$MODULE_LOWER', '$MODULE_PLURAL'];
        $to = [Str::plural($module), $module_lower, $module_plural];
        $view = str_replace($from, $to, $menu_item);

        $sidebar = str_replace($view, '', $sidebar);
        $sidebar = str_replace('<!-- MODULES AREA -->', $view.'<!-- MODULES AREA -->', $sidebar);
        file_put_contents($sidebar_path, $sidebar);
    }
}
