<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('approaches.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/approaches', [\App\Http\Controllers\ApproachController::class, 'index'])->name('index');

            Route::get('/approaches/{approach}', [\App\Http\Controllers\ApproachController::class, 'show'])->name('show');

            Route::post('/approaches', [\App\Http\Controllers\ApproachController::class, 'store'])->name('store');

            Route::patch('/approaches/{approach}', [\App\Http\Controllers\ApproachController::class, 'update'])->name('update');

            Route::delete('/approaches/{approach}', [\App\Http\Controllers\ApproachController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});

