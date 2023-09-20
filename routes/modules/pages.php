<?php

use App\Http\Controllers\Backend\PagesBackendController;

Route::name('pages.')->prefix('pages')->group(function () {
    Route::get('/', [PagesBackendController::class, 'index'])->name('index');
    Route::get('/add', [PagesBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [PagesBackendController::class, 'show'])->name('edit');
    Route::post('/add', [PagesBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [PagesBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [PagesBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [PagesBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
