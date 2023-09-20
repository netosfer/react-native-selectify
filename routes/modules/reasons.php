<?php

use App\Http\Controllers\Backend\ReasonsBackendController;

Route::name('reasons.')->prefix('reasons')->group(function () {
    Route::get('/', [ReasonsBackendController::class, 'index'])->name('index');
    Route::get('/add', [ReasonsBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [ReasonsBackendController::class, 'show'])->name('edit');
    Route::post('/add', [ReasonsBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [ReasonsBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [ReasonsBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [ReasonsBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
