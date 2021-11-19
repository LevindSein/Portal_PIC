<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ScanController;

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

//Login Authenticated
Route::middleware('checkauth')->group(function(){
    //Access for Level 1 & 2
    Route::middleware('oneauth')->group(function(){
        Route::prefix('production')->group(function(){
            Route::get('dashboard', [DashboardController::class, 'index']);

            Route::get('layanan/registrasi', [LayananController::class, 'index']);

            Route::get('user/kode/aktivasi', [UserController::class, 'aktivasi']);
            Route::get('user/aktivasi/verify', [UserController::class, 'aktivasiVerify']);
            Route::delete('user/permanen/{id}', [UserController::class, 'permanen']);
            Route::post('user/reset/{id}', [UserController::class, 'reset']);
            Route::post('user/restore/{id}', [UserController::class, 'restore']);
            Route::get('user/penghapusan/{params}', [UserController::class, 'penghapusan']);
            Route::get('user/registrasi/{params}', [UserController::class, 'registrasi']);
            Route::get('user/level/{params}', [UserController::class, 'level']);
            Route::resource('user', UserController::class);

            Route::resource('riwayat-login', RiwayatController::class);
        });
    });

    Route::get('email/verify/resend', [EmailController::class, 'resend']);

    Route::post('profil/foto', [ProfilController::class, 'fotoProfil']);
    Route::resource('profil', ProfilController::class);
});

Route::get('email/forgot-password', [EmailController::class, 'forgot']);
Route::post('email/forgot-password/{data}', [EmailController::class, 'forgotStore']);
Route::get('email/forgot-password/{level}/{anggota}', [EmailController::class, 'forgotVerify']);

Route::get('email/verify/{level}/{anggota}', [EmailController::class, 'verify']);
Route::get('email/verify/resend/{level}/{aktif}/{anggota}', [EmailController::class, 'verifyResend']);

Route::get('cari/blok',[SearchController::class, 'blok']);

Route::get('scan/qr/{type}/{data}',[ScanController::class, 'scanQR']);
Route::post('scanning/qr/pendaftaran',[ScanController::class, 'scanningQRPendaftaran']);
