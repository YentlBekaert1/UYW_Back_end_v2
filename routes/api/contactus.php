<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('contactus.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/contactus', [\App\Http\Controllers\ContactUsController::class, 'index'])->name('index');

            Route::get('/contactus/{contact}', [\App\Http\Controllers\ContactUsController::class, 'show'])->name('show');

            Route::post('/contactus', [\App\Http\Controllers\ContactUsController::class, 'store'])->name('store');

            Route::patch('/contactus/{contact}', [\App\Http\Controllers\ContactUsController::class, 'update'])->name('update');

            Route::delete('/contactus/{contact}', [\App\Http\Controllers\ContactUsController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});

