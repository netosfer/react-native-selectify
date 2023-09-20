<?php

use App\Http\Controllers\Backend\LocationsBackendController;

Route::name('locations.')->prefix('locations')->group(function () {
    Route::get('/', [LocationsBackendController::class, 'index'])->name('index');
    Route::get('/add', [LocationsBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [LocationsBackendController::class, 'show'])->name('edit');
    Route::post('/add', [LocationsBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [LocationsBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{id}', [LocationsBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [LocationsBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
