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
use App\Http\Controllers\GroupController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ChangeLogController;
use App\Http\Controllers\PriceController;

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

            Route::get('users/code/activate', [UserController::class, 'activate']);
            Route::get('users/activate/verify', [UserController::class, 'activateVerify']);
            Route::delete('users/permanent/{id}', [UserController::class, 'permanent']);
            Route::post('users/reset/{id}', [UserController::class, 'reset']);
            Route::post('users/restore/{id}', [UserController::class, 'restore']);
            Route::resource('users', UserController::class);

            Route::resource('groups', GroupController::class);

            Route::resource('histories', HistoryController::class);

            Route::resource('changelogs', ChangeLogController::class);

            Route::get('price/listrik', [PriceController::class, 'listrik']);
            Route::post('price/listrik', [PriceController::class, 'listrikStore']);
            Route::get('price/listrik/{id}/edit', [PriceController::class, 'listrikEdit']);
            Route::put('price/listrik/{id}', [PriceController::class, 'listrikUpdate']);
            Route::get('price/listrik/{id}', [PriceController::class, 'listrikShow']);
            Route::delete('price/listrik/{id}', [PriceController::class, 'listrikDestroy']);

            Route::get('price/airbersih', [PriceController::class, 'airbersih']);
            Route::post('price/airbersih', [PriceController::class, 'airbersihStore']);
            Route::get('price/airbersih/{id}/edit', [PriceController::class, 'airbersihEdit']);
            Route::put('price/airbersih/{id}', [PriceController::class, 'airbersihUpdate']);
            Route::get('price/airbersih/{id}', [PriceController::class, 'airbersihShow']);
            Route::delete('price/airbersih/{id}', [PriceController::class, 'airbersihDestroy']);

            Route::get('price/keamananipk', [PriceController::class, 'keamananipk']);
            Route::post('price/keamananipk', [PriceController::class, 'keamananipkStore']);
            Route::get('price/keamananipk/{id}/edit', [PriceController::class, 'keamananipkEdit']);
            Route::put('price/keamananipk/{id}', [PriceController::class, 'keamananipkUpdate']);
            Route::get('price/keamananipk/{id}', [PriceController::class, 'keamananipkShow']);
            Route::delete('price/keamananipk/{id}', [PriceController::class, 'keamananipkDestroy']);

            Route::get('price/kebersihan', [PriceController::class, 'kebersihan']);
            Route::post('price/kebersihan', [PriceController::class, 'kebersihanStore']);
            Route::get('price/kebersihan/{id}/edit', [PriceController::class, 'kebersihanEdit']);
            Route::put('price/kebersihan/{id}', [PriceController::class, 'kebersihanUpdate']);
            Route::get('price/kebersihan/{id}', [PriceController::class, 'kebersihanShow']);
            Route::delete('price/kebersihan/{id}', [PriceController::class, 'kebersihanDestroy']);

            Route::get('price/airkotor', [PriceController::class, 'airkotor']);
            Route::post('price/airkotor', [PriceController::class, 'airkotorStore']);
            Route::get('price/airkotor/{id}/edit', [PriceController::class, 'airkotorEdit']);
            Route::put('price/airkotor/{id}', [PriceController::class, 'airkotorUpdate']);
            Route::get('price/airkotor/{id}', [PriceController::class, 'airkotorShow']);
            Route::delete('price/airkotor/{id}', [PriceController::class, 'airkotorDestroy']);

            Route::get('price/lain', [PriceController::class, 'lain']);
            Route::post('price/lain', [PriceController::class, 'lainStore']);
            Route::get('price/lain/{id}/edit', [PriceController::class, 'lainEdit']);
            Route::put('price/lain/{id}', [PriceController::class, 'lainUpdate']);
            Route::get('price/lain/{id}', [PriceController::class, 'lainShow']);
            Route::delete('price/lain/{id}', [PriceController::class, 'lainDestroy']);
        });
    });

    Route::get('email/verify/resend', [EmailController::class, 'resend']);

    Route::post('profile/picture', [ProfileController::class, 'picture']);
    Route::resource('profile', ProfileController::class);

    Route::get('search/countries',[SearchController::class, 'country']);

    // Route::get('notification/bill/reviews',[NotificationController::class, 'billReviews']);
});

Route::get('expired', function(){
    abort(404);
});

Route::get('email/forgot', [EmailController::class, 'forgot']);
Route::post('email/forgot/{data}', [EmailController::class, 'forgotStore']);
Route::get('email/forgot/{level}/{member}', [EmailController::class, 'forgotVerify']);
Route::get('email/forgot/reset', function(){
    return view('email.forgot-recover',[
        'member' => session('member')
    ]);
});

Route::get('email/verify/{level}/{member}', [EmailController::class, 'verify']);
Route::get('email/verify/resend/{level}/{active}/{member}', [EmailController::class, 'verifyResend']);
Route::get('email/verified', function(){
    return view('email.verified');
});

Route::get('search/groups',[SearchController::class, 'group']);

Route::get('scan/qr/{type}/{data}',[ScanController::class, 'scanQr']);
Route::post('scan/qr/register',[ScanController::class, 'scanQrRegister']);
