<?php

use App\Http\Controllers\Backend\LanguagesBackendController;

Route::name('languages.')->prefix('languages')->group(function () {
    Route::get('/', [LanguagesBackendController::class, 'index'])->name('index');
    Route::get('/add', [LanguagesBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [LanguagesBackendController::class, 'show'])->name('edit');
    Route::post('/add', [LanguagesBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [LanguagesBackendController::class, 'update'])->name('edit.post');
    Route::get('/delete/{id}', [LanguagesBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [LanguagesBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
