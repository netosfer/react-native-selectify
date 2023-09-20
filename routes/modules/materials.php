<?php

use App\Http\Controllers\Backend\MaterialsBackendController;

Route::name('materials.')->prefix('materials')->group(function () {
    Route::get('/', [MaterialsBackendController::class, 'index'])->name('index');
    Route::get('/add', [MaterialsBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [MaterialsBackendController::class, 'show'])->name('edit');
    Route::post('/add', [MaterialsBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [MaterialsBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{id}', [MaterialsBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [MaterialsBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
