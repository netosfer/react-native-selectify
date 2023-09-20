<?php

use App\Http\Controllers\Backend\SettingsBackendController;

Route::name('settings.')->prefix('settings')->group(function () {
    Route::get('/', [SettingsBackendController::class, 'show'])->name('index');
    Route::get('/add', [SettingsBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [SettingsBackendController::class, 'show'])->name('edit');
    Route::post('/add', [SettingsBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [SettingsBackendController::class, 'update'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [SettingsBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [SettingsBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
