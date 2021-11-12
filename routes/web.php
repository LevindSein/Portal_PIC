<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;

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

Route::get('register/download/{token}', [AuthController::class, 'registrasiDownload']);
Route::get('register/{token}', [AuthController::class, 'registrasiQR']);
Route::get('logout', [AuthController::class, 'logout']);
Route::post('register', [AuthController::class, 'register']);
Route::resource('login', AuthController::class);

Route::middleware('checkauth')->group(function(){
    Route::middleware('oneauth')->group(function(){
        Route::get('dashboard', [DashboardController::class, 'index']);

        Route::post('user/reset/{id}', [UserController::class, 'reset']);
        Route::post('user/restore/{id}', [UserController::class, 'restore']);
        Route::get('user/penghapusan/{params}', [UserController::class, 'penghapusan']);
        Route::get('user/level/{params}', [UserController::class, 'level']);
        Route::resource('user', UserController::class);
    });

    Route::get('email/verify/resend', [EmailController::class, 'resend']);

    Route::post('profil/foto', [ProfilController::class, 'fotoProfil']);
    Route::resource('profil', ProfilController::class);
});

Route::get('email/verify/resend/{level}/{aktif}/{anggota}', [EmailController::class, 'verifyResend']);
