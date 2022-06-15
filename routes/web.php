<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PedagangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ChangeController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\SearchController;

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
})->name('login');

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
        Route::prefix('pedagang')->group(function () {
            Route::get('excel', [PedagangController::class, 'excel']);
            Route::post('reset/{id}', [PedagangController::class, 'reset']);
        });
        Route::resource('pedagang', PedagangController::class);

        Route::prefix('place')->group(function () {
            Route::get('print', [TempatController::class, 'print']);
            Route::get('generate/kontrol', [TempatController::class, 'generate']);
        });
        Route::resource('place', TempatController::class);

        Route::prefix('group')->group(function () {
            Route::get('excel', [GroupController::class, 'excel']);
            Route::get('print', [GroupController::class, 'print']);
        });
        Route::resource('group', GroupController::class);
    });

    Route::prefix('tagihan')->group(function () {
        Route::get('tempat/{id}', [TagihanController::class, 'tempat']);
        Route::post('publish/{id}', [TagihanController::class, 'publish']);
    });
    Route::resource('tagihan', TagihanController::class);

    Route::prefix('utilities')->group(function () {
        Route::prefix('tarif')->group(function () {
            Route::get('print', [TarifController::class, 'print']);
        });
        Route::resource('tarif', TarifController::class);

        Route::prefix('alat')->group(function () {
            Route::get('print', [AlatController::class, 'print']);
        });
        Route::resource('alat', AlatController::class);

        Route::resource('periode', PeriodeController::class);
    });

    Route::get('activities/{id}', [ActivityController::class, 'show']);
    Route::get('activities/print/dari/ke', [ActivityController::class, 'print']);
    Route::get('activities/print1/{id}', [ActivityController::class, 'print1']);
    Route::get('activities', [ActivityController::class, 'index']);

    Route::prefix('changelogs')->group(function () {
        Route::get('excel/{id}', [ChangeController::class, 'excel']);
    });
    Route::resource('changelogs', ChangeController::class);
});

Route::get('check', [AuthController::class, 'check']);
Route::post('logout', [AuthController::class, 'logout']);
Route::resource('login', AuthController::class);

Route::prefix('search')->group(function () {
    Route::get('users',[SearchController::class, 'users']);
    Route::get('groups',[SearchController::class, 'groups']);
    Route::get('{nameGroup}/los',[SearchController::class, 'los']);
    Route::get('alat',[SearchController::class, 'alat']);
    Route::get('tarif',[SearchController::class, 'tarif']);
    Route::get('tempat',[SearchController::class, 'tempat']);
    Route::get('stand/{id}',[SearchController::class, 'stand']);
});

Route::get('optimize', function(){
    \Artisan::call('cache:clear');
    echo "Cache cleared<br>";

    \Artisan::call('view:clear');
    echo "View cleared<br>";

    \Artisan::call('config:cache');
    echo "Config cleared<br>";
});
