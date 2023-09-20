<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum', 'can:viewAdmin']], function () {
Route::group(['prefix' => 'v1'], function () {
    Route::get('/{model}', [\App\Http\Controllers\Api\ApiController::class, 'list']);
    Route::get('/{model}/filter/{filter}', [\App\Http\Controllers\Api\ApiController::class, 'list']);
    Route::post('/auth/register', [AuthController::class, 'createUser']);
    Route::post('/auth/login', [AuthController::class, 'loginUser']);
});
$modules = glob(base_path("routes/modules/api/*.php"));
foreach ($modules as $module) {
    require $module;
}
