<?php

use App\Http\Controllers\Backend\SlidersBackendController;

Route::name('sliders.')->prefix('sliders')->group(function () {
    Route::get('/', [SlidersBackendController::class, 'index'])->name('index');
    Route::get('/add', [SlidersBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [SlidersBackendController::class, 'show'])->name('edit');
    Route::post('/add', [SlidersBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [SlidersBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [SlidersBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [SlidersBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
