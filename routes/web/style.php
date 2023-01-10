<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.style.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('/sitesettings/changestyle', [\App\Http\Controllers\web\StyleController::class, 'web'])->name('index');
        Route::post('/sitesettings/changestyle', [\App\Http\Controllers\web\StyleController::class, 'store'])->name('store');
        Route::post('/sitesettings/changestylereset', [\App\Http\Controllers\web\StyleController::class, 'reset'])->name('reset');
});


