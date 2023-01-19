<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.faq.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

            Route::get('/faq', [\App\Http\Controllers\web\FaqController::class, 'web'])->name('index');

            Route::get('/faqcreate', [\App\Http\Controllers\web\FaqController::class, 'create'])->name('create');
            Route::post('/faqstore', [\App\Http\Controllers\web\FaqController::class, 'store'])->name('store');

            Route::get('/faqedit/{faq}', [\App\Http\Controllers\web\FaqController::class, 'edit'])->name('edit');
            Route::patch('/faqeupdate/{faq}', [\App\Http\Controllers\web\FaqController::class, 'update'])->name('update');

            Route::get('/faqdelete/{faq}', [\App\Http\Controllers\web\FaqController::class, 'delete'])->name('delete');
            Route::delete('/faqdestroy/{faq}', [\App\Http\Controllers\web\FaqController::class, 'destroy'])->name('destroy');
});

