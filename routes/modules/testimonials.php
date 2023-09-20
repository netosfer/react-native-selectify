<?php

use App\Http\Controllers\Backend\TestimonialsBackendController;

Route::name('testimonials.')->prefix('testimonials')->group(function () {
    Route::get('/', [TestimonialsBackendController::class, 'index'])->name('index');
    Route::get('/add', [TestimonialsBackendController::class, 'show'])->name('add');
    Route::get('/edit/{uniq_key}', [TestimonialsBackendController::class, 'show'])->name('edit');
    Route::post('/add', [TestimonialsBackendController::class, 'store'])->name('add.post');
    Route::post('/edit/{uniq_key}', [TestimonialsBackendController::class, 'store'])->name('edit.post');
    Route::get('/delete/{uniq_key}', [TestimonialsBackendController::class, 'destroy'])->name('delete');
    Route::post('/bulk-delete', [TestimonialsBackendController::class, 'bulk_delete'])->name('bulk_delete');
});
