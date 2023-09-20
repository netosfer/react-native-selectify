<?php

use App\Http\Controllers\Backend\CategoriesBackendController;

Route::name('categories.')->prefix('categories')->group(function () {
    Route::get('/', [CategoriesBackendController::class, 'index'])->name('index');
    Route::get('/add', [CategoriesBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [CategoriesBackendController::class, 'show'])->name('edit');
    Route::post('/add', [CategoriesBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [CategoriesBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [CategoriesBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [CategoriesBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
