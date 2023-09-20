<?php

use App\Http\Controllers\Backend\ReferencesBackendController;

Route::name('references.')->prefix('references')->group(function () {
    Route::get('/', [ReferencesBackendController::class, 'index'])->name('index');
    Route::get('/add', [ReferencesBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [ReferencesBackendController::class, 'show'])->name('edit');
    Route::post('/add', [ReferencesBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [ReferencesBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [ReferencesBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [ReferencesBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
