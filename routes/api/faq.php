<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('faq.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name('index');

            Route::get('/faq/{faq}', [\App\Http\Controllers\FaqController::class, 'show'])->name('show');

            Route::post('/faq', [\App\Http\Controllers\FaqController::class, 'store'])->name('store');

            Route::patch('/faq/{faq}', [\App\Http\Controllers\FaqController::class, 'update'])->name('update');

            Route::delete('/faq/{faq}', [\App\Http\Controllers\FaqController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});

