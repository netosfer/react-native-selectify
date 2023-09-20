<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Imager;
use App\Http\Controllers\Frontend\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("img/{size}/{path}", [\App\Http\Controllers\Controller::class, 'resize'])->where('path', '.+');
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
$prefix = '/';
if (strlen(request()->segment(1)) == 2) {
    $segment = request()->segment(1);
    $languages = \App\Models\Language::get()->pluck('shortname')->toArray();
    if (in_array($segment, $languages)) {
        $prefix = $segment;
        config(['app.locale' => $prefix]);
        config(['app.prefix' => '/'.$prefix]);
    }
}
Route::group(['prefix' => $prefix], function () {
// Frontend Routes
    Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
    Route::get('/'.__('routes.page').'/{page}', [\App\Http\Controllers\Frontend\PagesController::class, 'detail'])->name('pages.detail');
    Route::get('/blog', [\App\Http\Controllers\Frontend\BlogsController::class, 'index'])->name('blog.index');
    Route::get('/blog/{detail}', [\App\Http\Controllers\Frontend\BlogsController::class, 'detail'])->name('blog.detail');
    Route::get('/'.__('routes.services').'/{category}', [\App\Http\Controllers\Frontend\CategoriesController::class, 'detail'])->name('categories.detail');
    Route::get('/'.__('routes.services').'/{category}/{service}', [\App\Http\Controllers\Frontend\CategoriesController::class, 'service'])->name('services.detail');
    Route::get('/'.__('routes.contact_me'), [\App\Http\Controllers\Frontend\HomeController::class, 'contact'])->name('home.contact');
    Route::get('/'.__('routes.login'), [\App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
    Route::post('/'.__('routes.login'), [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('auth.login-post');
    Route::post('/'.__('routes.register'), [\App\Http\Controllers\LoginController::class, 'register'])->name('auth.register-post');
    Route::get('/'.__('routes.actions'), [\App\Http\Controllers\AuthController::class, 'index'])->middleware('auth:sanctum')->name('auth.dashboard');
    Route::get('/'.__('routes.personal_informations'), [\App\Http\Controllers\AuthController::class, 'informations'])->middleware('auth:sanctum')->name('auth.informations');
    Route::post('/'.__('routes.update_informations'), [\App\Http\Controllers\AuthController::class, 'update'])->middleware('auth:sanctum')->name('auth.update-informations');
    Route::get('/'.__('routes.online_appointment'), [\App\Http\Controllers\Frontend\AppointmentsController::class, 'index'])->middleware('auth:sanctum')->name('auth.online-appointment');
    Route::post('/'.__('routes.online_appointment'), [\App\Http\Controllers\Frontend\AppointmentsController::class, 'makeAppointment'])->middleware('auth:sanctum')->name('auth.make-appointment');
    Route::post('/hours', [\App\Http\Controllers\Frontend\AppointmentsController::class, 'hours'])->middleware('auth:sanctum')->name('appointment.hours');
    Route::get('/'.__('routes.logout'), [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});
Route::get('/locale/{locale}', [\App\Http\Controllers\Frontend\HomeController::class, 'setLocale'])->name('pages.locale');
// Auth Routes


// Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
Route::group(['prefix' => 'admin', 'middleware' => ['auth:sanctum', 'can:viewAdmin']], function () {

    // Imager Route
    Route::get('/imager', [Imager::class, 'show'])->name('admin.imager');
    Route::post('/imager/files', [Imager::class, 'files'])->name('admin.imager.files');
    Route::post('/imager/upload', [Imager::class, 'upload'])->name('admin.imager.upload');

    // Appointments Iframe
    Route::get('/appointments-iframe', [\App\Http\Controllers\Backend\AppointmentIframeController::class, 'index'])->name('admin.appointments_iframe');

    // Options
    Route::get('/options/homepage', [\App\Http\Controllers\Backend\OptionsBackendController::class, 'homepageOptions'])->name('admin.options.homepage');
    Route::get('/options/contact', [\App\Http\Controllers\Backend\OptionsBackendController::class, 'contactOptions'])->name('admin.options.contact');
    Route::get('/options/appointment', [\App\Http\Controllers\Backend\OptionsBackendController::class, 'appointmentOptions'])->name('admin.options.appointment');
    Route::post('/options/{key}/{format}', [\App\Http\Controllers\Backend\OptionsBackendController::class, 'saveOptions'])->name('admin.options.save');
    Route::post('/options/closed-hours', [\App\Http\Controllers\Backend\OptionsBackendController::class, 'saveClosedHours'])->name('admin.options.save-closed-hours');

    Route::get('/', [\App\Http\Controllers\Backend\HomeController::class, 'index'])->name('admin.dashboard');
    $modules = glob(base_path("routes/modules/*.php"));
    foreach ($modules as $module) {
        require $module;
    }


});
