<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('locations.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/locations', [\App\Http\Controllers\LocationsController::class, 'index'])->name('index');

            Route::get('/locationsmap', [\App\Http\Controllers\LocationsController::class, 'map'])->name('map');

            Route::get('/locations/{location}', [\App\Http\Controllers\LocationsController::class, 'show'])->name('show');

            Route::post('/locations', [\App\Http\Controllers\LocationsController::class, 'store'])->name('store');

            Route::patch('/locations/{location}', [\App\Http\Controllers\LocationsController::class, 'update'])->name('update');

            Route::delete('/locations/{location}', [\App\Http\Controllers\LocationsController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});

