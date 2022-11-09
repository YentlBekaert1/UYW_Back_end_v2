<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.categories.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

        Route::get('/categories', [\App\Http\Controllers\web\CategoriesController::class, 'web'])->name('index');

        Route::get('/categoriescreate', [\App\Http\Controllers\web\CategoriesController::class, 'create'])->name('create');
        Route::post('/categoriesstore', [\App\Http\Controllers\web\CategoriesController::class, 'store'])->name('store');

        Route::get('/categoriesedit/{categorie}', [\App\Http\Controllers\web\CategoriesController::class, 'edit'])->name('edit');
        Route::patch('/categoriesedit/{categorie}', [\App\Http\Controllers\web\CategoriesController::class, 'update'])->name('update');

        Route::get('/categoriesdelete/{categorie}', [\App\Http\Controllers\web\CategoriesController::class, 'delete'])->name('delete');
        Route::delete('/categoriesdestroy/{categorie}', [\App\Http\Controllers\web\CategoriesController::class, 'destroy'])->name('destroy');

});

