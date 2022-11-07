<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.submaterials.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

            Route::get('/submaterials', [\App\Http\Controllers\web\SubMaterialController::class, 'web'])->name('index');

            Route::get('/submaterialscreate', [\App\Http\Controllers\web\SubMaterialController::class, 'create'])->name('create');
            Route::post('/submaterialsstore', [\App\Http\Controllers\web\SubMaterialController::class, 'store'])->name('store');

            Route::get('/submaterialsedit/{submaterial}', [\App\Http\Controllers\web\SubMaterialController::class, 'edit'])->name('edit');
            Route::patch('/submaterialsedit/{submaterial}', [\App\Http\Controllers\web\SubMaterialController::class, 'update'])->name('update');

            Route::delete('/submaterialsdestroy/{submaterial}', [\App\Http\Controllers\web\SubMaterialController::class, 'destroy'])->name('destroy');
});


