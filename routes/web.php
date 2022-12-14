<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('dashboard');
// });
Route::view('/powergrid', 'powergrid-demo');

Route::get('/reset-password/{token}', function ($token){
    return view('auth.password-reset', [
        'token' => $token
    ]);
})->middleware(['guest:'.config('fortify.guard')])->name('password.reset');

Route::get('/register', function() {
    return redirect('/login');
});

Route::middleware(['auth:sanctum,web','verified', 'role:admin'])->group(function () {

    Route::get('/', [\App\Http\Controllers\web\Dashboard::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\web\Dashboard::class, 'index'])->name('dashboard');
    
    require __DIR__ . '/web/offers.php';
    require __DIR__ . '/web/users.php';
    require __DIR__ . '/web/categories.php';
    require __DIR__ . '/web/materials.php';
    require __DIR__ . '/web/tags.php';
    require __DIR__ . '/web/approaches.php';
    require __DIR__ . '/web/submaterials.php';
    require __DIR__ . '/web/locations.php';
    require __DIR__ . '/web/style.php';
});



//test routes
if(\Illuminate\Support\Facades\App::environment('local')){
    Route::get('/app', function (){
        return view('app');
    });

    Route::get('/verifymail', function (){
        return view('mail.verify')->with('url','hallo')->with('mailData', 'hello');
    });

    Route::get('/apppost', function (){
        return view('apppost');
    });

    Route::get('/apppost', function (){
        return view('apppost');
    });
    Route::get('/playground', function (){
        // $user = \App\Models\User::factory()->make();
        // \Illuminate\Support\Facades\Mail::to($user)
        //     ->send(new \App\Mail\WelcomeMail($user));
       return (new \App\Mail\WelcomeMail(\App\Models\User::factory()->make()))->render();
    });

    Route::get('/playgroundmail', function (){
        $user = \App\Models\User::factory()->make();
        \Illuminate\Support\Facades\Mail::to($user)
            ->send(new \App\Mail\WelcomeMail($user));
       return null;
    });
}

