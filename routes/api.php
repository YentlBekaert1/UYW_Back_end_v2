<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Route::apiResource('/offers', OffersController::class);

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/api/offers.php';
require __DIR__ . '/api/users.php';
require __DIR__ . '/api/categories.php';
require __DIR__ . '/api/materials.php';
require __DIR__ . '/api/submaterials.php';
require __DIR__ . '/api/tags.php';
require __DIR__ . '/api/approaches.php';
require __DIR__ . '/api/offerimages.php';
require __DIR__ . '/api/locations.php';
require __DIR__ . '/api/contactus.php';
require __DIR__ . '/api/faq.php';

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
       return "error";
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

