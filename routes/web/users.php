<?php

use Illuminate\Support\Facades\Route;


Route::middleware([])
    ->name('web.users.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

        Route::get('/users', [\App\Http\Controllers\UserController::class, 'web'])->name('index');
        Route::get('/userscreate', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::get('/usersedit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::delete('/usersdestroy/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
});



