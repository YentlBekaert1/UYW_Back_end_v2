<?php

use Illuminate\Support\Facades\Route;

Route::middleware([
    //    'auth:api',
    ])
        ->name('submaterials.')
        ->namespace("\App\Http\Controllers")
        ->group(function () {

            Route::get('/{language}/submaterials', [\App\Http\Controllers\SubMaterialController::class, 'index'])->name('index');

            Route::get('/submaterials/{submaterial}', [\App\Http\Controllers\SubMaterialController::class, 'show'])->name('show');

            Route::get('/{language}/materialsubmaterials/{id}', [\App\Http\Controllers\SubMaterialController::class, 'material_submaterials'])->name('material_submaterials');

            Route::post('/submaterials', [\App\Http\Controllers\SubMaterialController::class, 'store'])->name('store');

            Route::patch('/submaterials/{submaterial}', [\App\Http\Controllers\SubMaterialController::class, 'update'])->name('update');

            Route::delete('/submaterials/{submaterial}', [\App\Http\Controllers\SubMaterialController::class, 'destroy'])->name('destroy');


});

Route::middleware('auth:sanctum')->group(function (){

});
