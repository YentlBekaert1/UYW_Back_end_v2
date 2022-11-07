<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.materials.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

            Route::get('/materials', [\App\Http\Controllers\web\MaterialController::class, 'web'])->name('index');

            Route::get('/materialscreate', [\App\Http\Controllers\web\MaterialController::class, 'create'])->name('create');
            Route::post('/materialsstore', [\App\Http\Controllers\web\MaterialController::class, 'store'])->name('store');

            Route::get('/materialsedit/{material}', [\App\Http\Controllers\web\MaterialController::class, 'edit'])->name('edit');
            Route::patch('/materialsedit/{material}', [\App\Http\Controllers\web\MaterialController::class, 'update'])->name('update');

            Route::delete('/materialsdestroy/{material}', [\App\Http\Controllers\web\MaterialController::class, 'destroy'])->name('destroy');
});


