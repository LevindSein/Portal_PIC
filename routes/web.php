<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ActivityController;

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

//Login Authenticated
Route::middleware('auth')->group(function(){
    Route::post('settings', [AuthController::class, 'post_settings']);
    Route::get('settings', [AuthController::class, 'get_settings']);

    Route::resource('dashboard', DashboardController::class);

    Route::prefix('users')->group(function () {
        Route::get('excel', [UserController::class, 'excel']);
        Route::get('print', [UserController::class, 'print']);
        Route::post('reset/{id}', [UserController::class, 'reset']);
    });
    Route::resource('users', UserController::class);

    Route::prefix('services')->group(function () {
        Route::resource('place', PlaceController::class);

        Route::prefix('group')->group(function () {
            Route::get('excel', [GroupController::class, 'excel']);
            Route::get('print', [GroupController::class, 'print']);
        });
        Route::resource('group', GroupController::class);
    });

    Route::get('activities', [ActivityController::class, 'index']);
});

Route::get('check', [AuthController::class, 'check']);
Route::post('logout', [AuthController::class, 'logout']);
Route::resource('login', AuthController::class);

Route::get('optimize', function(){
    \Artisan::call('cache:clear');
    echo "Cache cleared<br>";

    \Artisan::call('view:clear');
    echo "View cleared<br>";

    \Artisan::call('config:cache');
    echo "Config cleared<br>";
});
