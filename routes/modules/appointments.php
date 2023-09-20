<?php

use App\Http\Controllers\Backend\AppointmentsBackendController;

Route::name('appointments.')->prefix('appointments')->group(function () {
    Route::get('/', [AppointmentsBackendController::class, 'index'])->name('index');
    Route::get('/add', [AppointmentsBackendController::class, 'show'])->name('add');
    Route::get('/edit/{id}', [AppointmentsBackendController::class, 'show'])->name('edit');
    Route::post('/add', [AppointmentsBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{id}', [AppointmentsBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{id}', [AppointmentsBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [AppointmentsBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
