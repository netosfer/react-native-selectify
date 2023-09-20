<?php

use App\Http\Controllers\Backend\usersBackendController;

Route::name('users.')->prefix('users')->group(function () {
    Route::get('/', [usersBackendController::class, 'index'])->name('index');
    Route::get('/add', [usersBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [usersBackendController::class, 'show'])->name('edit');
    Route::post('/add', [usersBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [usersBackendController::class, 'update'])->name('edit.post');
    Route::get('/delete/{id}', [usersBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [usersBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
