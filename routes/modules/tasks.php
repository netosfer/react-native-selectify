<?php

use App\Http\Controllers\Backend\TasksBackendController;

Route::name('tasks.')->prefix('tasks')->group(function () {
    Route::get('/', [TasksBackendController::class, 'index'])->name('index');
    Route::get('/add', [TasksBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [TasksBackendController::class, 'show'])->name('edit');
    Route::post('/add', [TasksBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [TasksBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{id}', [TasksBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [TasksBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
