<?php

use App\Http\Controllers\Web\OffersController;
use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.offers.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('/offers', [\App\Http\Controllers\OffersController::class, 'web'])->name('index');
        Route::get('/offerscreate', [\App\Http\Controllers\OffersController::class, 'create'])->name('create');
        Route::get('/offersedit/{offer}', [\App\Http\Controllers\OffersController::class, 'edit'])->name('edit');
        Route::delete('/offersdestroy/{offer}', [\App\Http\Controllers\OffersController::class, 'destroy'])->name('destroy');
});

