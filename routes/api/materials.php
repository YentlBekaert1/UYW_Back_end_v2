<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('materials.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/{language}/materials', [\App\Http\Controllers\MaterialController::class, 'index'])->name('index');

            Route::get('/materials/{material}', [\App\Http\Controllers\MaterialController::class, 'show'])->name('show');

            Route::post('/materials', [\App\Http\Controllers\MaterialController::class, 'store'])->name('store');

            Route::patch('/materials/{material}', [\App\Http\Controllers\MaterialController::class, 'update'])->name('update');

            Route::delete('/materials/{material}', [\App\Http\Controllers\MaterialController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});

