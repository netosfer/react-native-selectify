<?php

use App\Http\Controllers\Backend\EmployeesBackendController;

Route::name('employees.')->prefix('employees')->group(function () {
    Route::get('/', [EmployeesBackendController::class, 'index'])->name('index');
    Route::get('/add', [EmployeesBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [EmployeesBackendController::class, 'show'])->name('edit');
    Route::post('/add', [EmployeesBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [EmployeesBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{id}', [EmployeesBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [EmployeesBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
