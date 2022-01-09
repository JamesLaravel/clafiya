<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

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
//     return view('welcome');
// });


Route::middleware(['auth.guest'])->group(function () {
   
    Route::get('/', [LoginController::class, 'loginpage'])->name('login');
    Route::get('/user/register', [RegisterController::class, 'register'])->name('register');

});

Route::middleware(['auth.user'])->group(function () {
    
    Route::get('/user', [HomeController::class, 'index']);
    Route::get('/user/admin', [HomeController::class, 'admin']);
});
