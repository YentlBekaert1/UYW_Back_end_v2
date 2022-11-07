<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.tags.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

        Route::get('/tags', [\App\Http\Controllers\web\TagController::class, 'web'])->name('index');

        Route::get('/tagscreate', [\App\Http\Controllers\web\TagController::class, 'create'])->name('create');
        Route::post('/tagsstore', [\App\Http\Controllers\web\TagController::class, 'store'])->name('store');

        Route::get('/tagsedit/{tag}', [\App\Http\Controllers\web\TagController::class, 'edit'])->name('edit');
        Route::patch('/tagsupdate/{tag}', [\App\Http\Controllers\web\TagController::class, 'update'])->name('update');

        Route::delete('/tagsdestroy/{tag}', [\App\Http\Controllers\web\TagController::class, 'destroy'])->name('destroy');
});


