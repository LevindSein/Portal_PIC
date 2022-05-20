<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaceController;

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

    Route::prefix('users')->group(function () {
        Route::get('excel', [UserController::class, 'excel']);
        Route::get('print', [UserController::class, 'print']);
        Route::post('reset/{id}', [UserController::class, 'reset']);
    });
    Route::resource('users', UserController::class);

    Route::prefix('services')->group(function () {
        Route::resource('place', PlaceController::class);
    });
});

Route::get('optimize', function(){
    \Artisan::call('cache:clear');
    echo "Cache cleared<br>";

    \Artisan::call('view:clear');
    echo "View cleared<br>";

    \Artisan::call('config:cache');
    echo "Config cleared<br>";
});
