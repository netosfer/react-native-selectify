<?php

use App\Http\Controllers\Backend\ModuleBackendController;

Route::name('module.')->prefix('module')->group(function () {
    Route::get('/', [ModuleBackendController::class, 'index'])->name('index');
    Route::get('/{file}', [ModuleBackendController::class, 'index'])->name('index_file');
    Route::post('/make', [ModuleBackendController::class, 'make'])->name('add');
    Route::get('/edit/{id}', [ModuleBackendController::class, 'show'])->name('edit');
    Route::post('/add', [ModuleBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [ModuleBackendController::class, 'update'])->name('edit.post');
    Route::get('/delete/{id}', [ModuleBackendController::class, 'destroy'])->name('delete');
});
