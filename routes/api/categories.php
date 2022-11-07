<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('categories.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/categories', [\App\Http\Controllers\CategoriesController::class, 'index'])->name('index');

            Route::get('/categories/{categorie}', [\App\Http\Controllers\CategoriesController::class, 'show'])->name('show');

            Route::post('/categories', [\App\Http\Controllers\CategoriesController::class, 'store'])->name('store');

            Route::patch('/categories/{categorie}', [\App\Http\Controllers\CategoriesController::class, 'update'])->name('update');

            Route::delete('/categories/{categorie}', [\App\Http\Controllers\CategoriesController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});

