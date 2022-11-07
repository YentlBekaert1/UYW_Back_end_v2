<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('tags.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/tags', [\App\Http\Controllers\TagController::class, 'index'])->name('index');

            Route::get('/tags/{tag}', [\App\Http\Controllers\TagController::class, 'show'])->name('show');

            Route::post('/tags', [\App\Http\Controllers\TagController::class, 'store'])->name('store');

            Route::post('/tagsautocomplete', [\App\Http\Controllers\TagController::class, 'autocomplete'])->name('autocomplete');

            Route::patch('/tags/{tag}', [\App\Http\Controllers\TagController::class, 'update'])->name('update');

            Route::delete('/tags/{tag}', [\App\Http\Controllers\TagController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});

