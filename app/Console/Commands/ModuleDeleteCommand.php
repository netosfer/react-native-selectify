<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ModuleDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:module {module_name} {confirm=true}';

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
        $module_lower = $module;
        if($module_lower == 'module'){
            return false;
        }
        if($this->argument('confirm') == 'true' && file_exists(app_path('Http/Controllers/'. $module.'Controller.php'))){
            if(!$this->confirm('The '.$module.' module files and database will be completely deleted. Are you sure? (yes|no)[no]',true))
            {
                $this->info("Process terminated by user");
                return;
            }
        }
        $module_plural = Str::plural($module);
        Schema::dropIfExists(Str::plural(Str::plural((new \MainHelper)->slugify((new \MainHelper)->camelToSnake($module), ['delimiter' => '_']))));
        if(file_exists(app_path('Http/Controllers/'. $module_plural.'Controller.php'))){
            unlink(app_path('Http/Controllers/'. $module_plural.'Controller.php'));
        }
        if(file_exists(app_path('Http/Controllers/Backend/'. $module_plural.'BackendController.php'))){
            unlink(app_path('Http/Controllers/Backend/'. $module_plural.'BackendController.php'));
        }
        if(file_exists(app_path('Http/Controllers/Frontend/'. $module_plural.'Controller.php'))){
            unlink(app_path('Http/Controllers/Frontend/'. $module_plural.'Controller.php'));
        }
        if(file_exists(app_path('Models/'. $module.'.php'))){
            unlink(app_path('Models/'. $module.'.php'));
        }
        if(file_exists(base_path('resources/views/backend/'.$module_lower.'/index.blade.php'))){
            unlink(base_path('resources/views/backend/'.$module_lower.'/index.blade.php'));
        }
        if(file_exists(base_path('resources/views/backend/'.$module_lower.'/form.blade.php'))){
            unlink(base_path('resources/views/backend/'.$module_lower.'/form.blade.php'));
        }
        if(file_exists(base_path('resources/views/'.$module_lower.'/index.blade.php'))){
            unlink(base_path('resources/views/'.$module_lower.'/index.blade.php'));
        }
        if(file_exists(base_path('resources/views/'.$module_lower.'/form.blade.php'))){
            unlink(base_path('resources/views/'.$module_lower.'/form.blade.php'));
        }
        if(is_dir(base_path('resources/views/'.$module_lower))){
            rmdir(base_path('resources/views/'.$module_lower));
        }
        if(is_dir(base_path('resources/views/backend/'.$module_lower))){
            rmdir(base_path('resources/views/backend/'.$module_lower));
        }

        $lang_ml = Str::plural($module_lower);
        $lang_ml = (new \MainHelper())->camelToSnake($lang_ml);
        $lang_ml = (new \MainHelper())->slugify($lang_ml);
        if(file_exists(base_path('resources/lang/en/'.$lang_ml.'.php'))){
            unlink(base_path('resources/lang/en/'.$lang_ml.'.php'));
        }
        if(file_exists(base_path('routes/modules/'.$module_lower.'.php'))){
            unlink(base_path('routes/modules/'.$module_lower.'.php'));
        }
        foreach(glob(base_path('database/migrations').'/*.php') as $mig){
            $migration_ = 'create_'.(new \MainHelper())->camelToSnake(Str::plural($module_lower)).'_table';
            if(Str::contains($mig, $migration_)){
                DB::table('migrations')->where('migration', basename($mig, '.php'))->delete();
                unlink($mig);
            }
        }
        return true;
    }
}
