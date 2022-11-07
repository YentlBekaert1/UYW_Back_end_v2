<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('offerimages.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/offerimages', [\App\Http\Controllers\OfferImageController::class, 'index'])->name('index');

            Route::get('/offerimages/{offerimage}', [\App\Http\Controllers\OfferImageController::class, 'show'])->name('show');

            Route::post('/offerimages', [\App\Http\Controllers\OfferImageController::class, 'store'])->name('store');

            Route::patch('/offerimages/{offerimage}', [\App\Http\Controllers\OfferImageController::class, 'update'])->name('update');

            Route::delete('/offerimages/{offerimage}', [\App\Http\Controllers\OfferImageController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});

