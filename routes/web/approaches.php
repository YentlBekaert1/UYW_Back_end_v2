<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.approaches.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

        Route::get('/approaches', [\App\Http\Controllers\web\ApproachController::class, 'web'])->name('index');

        Route::get('/approachescreate', [\App\Http\Controllers\web\ApproachController::class, 'create'])->name('create');
        Route::post('/approachestore', [\App\Http\Controllers\web\ApproachController::class, 'store'])->name('store');

        Route::get('/approachesedit/{approach}', [\App\Http\Controllers\web\ApproachController::class, 'edit'])->name('edit');
        Route::patch('/approachesupdate/{approach}', [\App\Http\Controllers\web\ApproachController::class, 'update'])->name('update');

        Route::get('/approachesdelete/{approach}', [\App\Http\Controllers\web\ApproachController::class, 'delete'])->name('delete');
        Route::delete('/approachesdestroy/{approach}', [\App\Http\Controllers\web\ApproachController::class, 'destroy'])->name('destroy');
});

