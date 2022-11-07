<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.locations.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

            Route::get('/locations', [\App\Http\Controllers\web\LocationsController::class, 'web'])->name('index');

            Route::get('/locationscreate', [\App\Http\Controllers\web\LocationsController::class, 'create'])->name('create');
            Route::post('/locationsstore', [\App\Http\Controllers\web\LocationsController::class, 'store'])->name('store');

            Route::get('/locationsedit/{location}', [\App\Http\Controllers\web\LocationsController::class, 'edit'])->name('edit');
            Route::patch('/locationsedit/{location}', [\App\Http\Controllers\web\LocationsController::class, 'update'])->name('update');

            Route::delete('/locationsdestroy/{location}', [\App\Http\Controllers\web\LocationsController::class, 'destroy'])->name('destroy');
});


