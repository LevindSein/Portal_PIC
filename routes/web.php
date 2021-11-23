<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\ChangeLogController;

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

Route::get('register/{token}', [AuthController::class, 'registerQr']);
Route::get('register/download/{token}', [AuthController::class, 'registerQrDownload']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('register', [AuthController::class, 'register']);
Route::post('register', [AuthController::class, 'registerStore']);
Route::resource('login', AuthController::class);

//Login Authenticated
Route::middleware('checkauth')->group(function(){
    //Access for Level 1 & 2
    Route::middleware('oneauth')->group(function(){
        Route::prefix('production')->group(function(){
            Route::get('dashboard', [DashboardController::class, 'index']);

            Route::get('service/register', [ServiceController::class, 'index']);

            Route::get('user/code/activate', [UserController::class, 'activate']);
            Route::get('user/activate/verify', [UserController::class, 'activateVerify']);
            Route::delete('user/permanent/{id}', [UserController::class, 'permanent']);
            Route::post('user/reset/{id}', [UserController::class, 'reset']);
            Route::post('user/restore/{id}', [UserController::class, 'restore']);
            Route::get('user/deleted/{params}', [UserController::class, 'deleted']);
            Route::get('user/registered/{params}', [UserController::class, 'registered']);
            Route::get('user/level/{params}', [UserController::class, 'level']);
            Route::resource('user', UserController::class);

            Route::resource('histories', HistoryController::class);
        });
    });

    Route::get('email/verify/resend', [EmailController::class, 'resend']);

    Route::post('profile/picture', [ProfileController::class, 'picture']);
    Route::resource('profile', ProfileController::class);

    Route::resource('changelogs', ChangeLogController::class);
});

Route::get('expired', function(){
    abort(404);
});

Route::get('email/forgot', [EmailController::class, 'forgot']);
Route::post('email/forgot/{data}', [EmailController::class, 'forgotStore']);
Route::get('email/forgot/{level}/{anggota}', [EmailController::class, 'forgotVerify']);
Route::get('email/forgot/reset', function(){
    return view('email.forgot-recover',[
        'member' => session('member')
    ]);
});

Route::get('email/verify/{level}/{anggota}', [EmailController::class, 'verify']);
Route::get('email/verify/resend/{level}/{aktif}/{anggota}', [EmailController::class, 'verifyResend']);
Route::get('email/verified', function(){
    return view('email.verified');
});

Route::get('cari/groups',[SearchController::class, 'group']);

Route::get('scan/qr/{type}/{data}',[ScanController::class, 'scanQr']);
Route::post('scan/qr/register',[ScanController::class, 'scanQrRegister']);
