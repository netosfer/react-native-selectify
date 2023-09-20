<?php

use App\Http\Controllers\Backend\VehiclesBackendController;

Route::name('vehicles.')->prefix('vehicles')->group(function () {
    Route::get('/', [VehiclesBackendController::class, 'index'])->name('index');
    Route::get('/add', [VehiclesBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [VehiclesBackendController::class, 'show'])->name('edit');
    Route::post('/add', [VehiclesBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [VehiclesBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{id}', [VehiclesBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [VehiclesBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
