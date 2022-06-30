<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PedagangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\ChangelogController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\KasirController;

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

    Route::prefix('users')->group(function () {
        Route::get('excel', [UserController::class, 'excel']);
        Route::get('print', [UserController::class, 'print']);
        Route::post('reset/{id}', [UserController::class, 'reset']);
    });

    Route::prefix('services')->group(function () {
        Route::resources([
            'kasir'    => KasirController::class
        ]);
    });

    Route::prefix('tagihan')->group(function () {
        Route::get('tempat/{id}', [TagihanController::class, 'tempat']);
        Route::post('publish/{id}', [TagihanController::class, 'publish']);
        Route::post('aktif/{id}', [TagihanController::class, 'aktif']);
    });

    Route::prefix('data')->group(function () {
        Route::prefix('tarif')->group(function () {
            Route::get('print', [TarifController::class, 'print']);
        });

        Route::prefix('alat')->group(function () {
            Route::get('print', [AlatController::class, 'print']);
        });

        Route::prefix('pedagang')->group(function () {
            Route::get('excel', [PedagangController::class, 'excel']);
            Route::post('reset/{id}', [PedagangController::class, 'reset']);
        });

        Route::prefix('groups')->group(function () {
            Route::get('excel', [GroupController::class, 'excel']);
            Route::get('print', [GroupController::class, 'print']);
        });

        Route::prefix('tempat')->group(function () {
            Route::get('print', [TempatController::class, 'print']);
            Route::get('generate/kontrol', [TempatController::class, 'generate']);
        });

        Route::resources([
            'periode'  => PeriodeController::class,
            'tarif'    => TarifController::class,
            'alat'     => AlatController::class,
            'pedagang' => PedagangController::class,
            'groups'   => GroupController::class,
            'tempat'   => TempatController::class,
        ]);
    });

    Route::prefix('aktivitas')->group(function () {
        Route::get('{id}', [AktivitasController::class, 'show']);
        Route::get('print/dari/ke', [AktivitasController::class, 'print']);
        Route::get('print1/{id}', [AktivitasController::class, 'print1']);
    });
    Route::get('aktivitas', [AktivitasController::class, 'index']);

    Route::prefix('changelogs')->group(function () {
        Route::get('excel/{id}', [ChangelogController::class, 'excel']);
    });

    Route::resources([
        'dashboard'  => DashboardController::class,
        'users'      => UserController::class,
        'tagihan'    => TagihanController::class,
        'changelogs' => ChangelogController::class
    ]);
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
