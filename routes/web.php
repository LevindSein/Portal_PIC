<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return redirect('login');
});

Route::get('check', [AuthController::class, 'check']);
Route::post('logout', [AuthController::class, 'logout']);
Route::resource('login', AuthController::class);


//Login Authenticated
Route::middleware('auth')->group(function(){
    Route::resource('dashboard', DashboardController::class);

    Route::resource('users', UserController::class);
});

Route::get('optimize', function(){
    \Artisan::call('cache:clear');
    echo "Cache cleared<br>";

    \Artisan::call('view:clear');
    echo "View cleared<br>";

    \Artisan::call('config:cache');
    echo "Config cleared<br>";
});
