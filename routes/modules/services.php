<?php

use App\Http\Controllers\Backend\ServicesBackendController;

Route::name('services.')->prefix('services')->group(function () {
    Route::get('/', [ServicesBackendController::class, 'index'])->name('index');
    Route::get('/add', [ServicesBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [ServicesBackendController::class, 'show'])->name('edit');
    Route::post('/add', [ServicesBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [ServicesBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [ServicesBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [ServicesBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
