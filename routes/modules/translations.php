<?php

use App\Http\Controllers\Backend\TranslationsBackendController;

Route::name('translations.')->prefix('translations')->group(function () {
    Route::get('/', [TranslationsBackendController::class, 'index'])->name('index');
    Route::get('/{translate}', [TranslationsBackendController::class, 'index'])->name('index_translate');
    Route::post('/save/{translate}', [TranslationsBackendController::class, 'store'])->name('index_save');
});
