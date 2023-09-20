<?php

use App\Http\Controllers\Backend\BlogsBackendController;

Route::name('blogs.')->prefix('blogs')->group(function () {
    Route::get('/', [BlogsBackendController::class, 'index'])->name('index');
    Route::get('/add', [BlogsBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [BlogsBackendController::class, 'show'])->name('edit');
    Route::post('/add', [BlogsBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [BlogsBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [BlogsBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [BlogsBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
