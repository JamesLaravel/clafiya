<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register',  [RegisterController::class, 'register'])->name('signup');
Route::post('login', [LoginController::class, 'login'])->name('signin');

// admin users routes
Route::middleware('auth:api', 'scope:admin-users')->group(function() {

    Route::get('users', [UserController::class, 'allUser']);
});
