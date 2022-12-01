<?php

use Illuminate\Support\Facades\Route;


Route::middleware([
//    'auth:api',
])
    ->name('users.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

});

Route::middleware(['auth:sanctum','verified'])
    ->name('users.')
    ->namespace("\App\Http\Controllers")
    ->group(function (){
        Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('index');

        Route::get('/users/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('show')->whereNumber('user');

        Route::post('/users', [\App\Http\Controllers\UserController::class, 'store'])->name('store');

        Route::patch('/users/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');

        Route::delete('/users/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');

        Route::get('/userprofile', [\App\Http\Controllers\UserController::class, 'profile'])->name('profile');

        Route::get('/useroffers', [\App\Http\Controllers\UserController::class, 'useroffers'])->name('useroffers');

        Route::get('/userfavorites', [\App\Http\Controllers\UserController::class, 'userfavorites'])->name('userfavorites');

        Route::get('/userdashboarddata', [\App\Http\Controllers\UserController::class, 'dashboarddata'])->name('dashboarddata');
});

