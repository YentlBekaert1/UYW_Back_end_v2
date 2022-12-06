<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('offers.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/offers', [\App\Http\Controllers\OffersController::class, 'searchitems'])
            ->name('searchitems');

            Route::get('/offersall', [\App\Http\Controllers\OffersController::class, 'index'])
            ->name('index');

            Route::get('/offers/{offer}', [\App\Http\Controllers\OffersController::class, 'show'])
                ->name('show')
                ->whereNumber('offer');

            Route::post('/offers/{offer}/share', [\App\Http\Controllers\OffersController::class, 'share'])->name('share');

            Route::get('/offersincrementviews/{id}', [\App\Http\Controllers\OffersController::class, 'increment_offer_views'])->name('increment_offer_views');

            Route::get('/offers_add_to_favorites/{id}', [\App\Http\Controllers\OffersController::class, 'add_offer_to_favorites_user'])->name('add_offer_to_favorites_user');
            Route::get('/offers_remove_from_favorites/{id}', [\App\Http\Controllers\OffersController::class, 'remove_offer_from_favorites_user'])->name('remove_offer_from_favorites_user');

            Route::post('/offers/add_tag_to_offer/{offer}', [\App\Http\Controllers\OffersController::class, 'add_tag_to_offer'])->name('add_tag_to_offer');
            Route::post('/offers/remove_tag_from_offer/{offer}', [\App\Http\Controllers\OffersController::class, 'remove_tag_from_offer'])->name('remove_tag_from_offer');

            Route::get('/{language}/offersearchterms', [\App\Http\Controllers\OffersController::class, 'searchterms'])
            ->name('searchterms');

});

Route::middleware('auth:sanctum',config('jetstream.auth_session'),'verified')->group(function (){

    Route::get('/geteditoffer/{offer}', [\App\Http\Controllers\OffersController::class, 'geteditoffer'])->name('offers.geteditoffer');

    Route::post('/offers', [\App\Http\Controllers\OffersController::class, 'store'])->name('offers.store');

    Route::post('/statusoffer/{offer}', [\App\Http\Controllers\OffersController::class, 'updateStatus'])->name('offers.updateStatus');

    Route::patch('/offers/{offer}', [\App\Http\Controllers\OffersController::class, 'update'])->name('offers.update');

    Route::delete('/offers/{offer}', [\App\Http\Controllers\OffersController::class, 'destroy'])->name('offers.destroy');

});

