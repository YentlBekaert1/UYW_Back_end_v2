<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])
    ->name('web.contact_us.')
    ->namespace("\App\Http\Controllers")
    ->group(function () {

            Route::get('/contact_us', [\App\Http\Controllers\web\ContactUsController::class, 'web'])->name('index');

            Route::get('/contact_usresponse/{contact_us}', [\App\Http\Controllers\web\ContactUsController::class, 'response'])->name('response');
            Route::patch('/contact_ussendresponse/{contact_us}', [\App\Http\Controllers\web\ContactUsController::class, 'sendresponse'])->name('sendresponse');

            Route::get('/contact_usdelete/{contact_us}', [\App\Http\Controllers\web\ContactUsController::class, 'delete'])->name('delete');
            Route::delete('/contact_usdestroy/{contact_us}', [\App\Http\Controllers\web\ContactUsController::class, 'destroy'])->name('destroy');
});

