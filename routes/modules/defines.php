<?php

use App\Http\Controllers\Backend\DefinesBackendController;

Route::name('defines.')->prefix('defines')->group(function () {
    Route::get('/', [DefinesBackendController::class, 'index'])->name('index');
    Route::get('/add', [DefinesBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [DefinesBackendController::class, 'show'])->name('edit');
    Route::get('/{type}', [DefinesBackendController::class, 'showByType'])->name('show.edit');
    Route::post('/add', [DefinesBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [DefinesBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{id}', [DefinesBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [DefinesBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
