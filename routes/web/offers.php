<?php

use App\Http\Controllers\Web\OffersController;
use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.offers.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {
        Route::get('/offers', [\App\Http\Controllers\web\OffersController::class, 'web'])->name('index');

        Route::get('/offerscreate', [\App\Http\Controllers\web\OffersController::class, 'create'])->name('create');
        Route::post('/offersstore', [\App\Http\Controllers\web\OffersController::class, 'store'])->name('store');

        Route::get('/offersedit/{offer}', [\App\Http\Controllers\web\OffersController::class, 'edit'])->name('edit');
        Route::patch('/offersupdate/{offer}', [\App\Http\Controllers\web\OffersController::class, 'update'])->name('update');

        Route::get('/offersdelete/{offer}', [\App\Http\Controllers\web\OffersController::class, 'delete'])->name('delete');
        Route::delete('/offersdestroy/{offer}', [\App\Http\Controllers\web\OffersController::class, 'destroy'])->name('destroy');
});

