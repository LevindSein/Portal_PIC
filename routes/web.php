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
use App\Http\Controllers\ToolsController;

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

            Route::resource('point/groups', GroupController::class);

            Route::resource('histories', HistoryController::class);

            Route::resource('changelogs', ChangeLogController::class);

            Route::get('manage/prices/listrik', [PriceController::class, 'listrik']);
            Route::post('manage/prices/listrik', [PriceController::class, 'listrikStore']);
            Route::get('manage/prices/listrik/{id}/edit', [PriceController::class, 'listrikEdit']);
            Route::put('manage/prices/listrik/{id}', [PriceController::class, 'listrikUpdate']);
            Route::get('manage/prices/listrik/{id}', [PriceController::class, 'listrikShow']);
            Route::delete('manage/prices/listrik/{id}', [PriceController::class, 'listrikDestroy']);

            Route::get('manage/prices/airbersih', [PriceController::class, 'airbersih']);
            Route::post('manage/prices/airbersih', [PriceController::class, 'airbersihStore']);
            Route::get('manage/prices/airbersih/{id}/edit', [PriceController::class, 'airbersihEdit']);
            Route::put('manage/prices/airbersih/{id}', [PriceController::class, 'airbersihUpdate']);
            Route::get('manage/prices/airbersih/{id}', [PriceController::class, 'airbersihShow']);
            Route::delete('manage/prices/airbersih/{id}', [PriceController::class, 'airbersihDestroy']);

            Route::get('manage/prices/keamananipk', [PriceController::class, 'keamananipk']);
            Route::post('manage/prices/keamananipk', [PriceController::class, 'keamananipkStore']);
            Route::get('manage/prices/keamananipk/{id}/edit', [PriceController::class, 'keamananipkEdit']);
            Route::put('manage/prices/keamananipk/{id}', [PriceController::class, 'keamananipkUpdate']);
            Route::get('manage/prices/keamananipk/{id}', [PriceController::class, 'keamananipkShow']);
            Route::delete('manage/prices/keamananipk/{id}', [PriceController::class, 'keamananipkDestroy']);

            Route::get('manage/prices/kebersihan', [PriceController::class, 'kebersihan']);
            Route::post('manage/prices/kebersihan', [PriceController::class, 'kebersihanStore']);
            Route::get('manage/prices/kebersihan/{id}/edit', [PriceController::class, 'kebersihanEdit']);
            Route::put('manage/prices/kebersihan/{id}', [PriceController::class, 'kebersihanUpdate']);
            Route::get('manage/prices/kebersihan/{id}', [PriceController::class, 'kebersihanShow']);
            Route::delete('manage/prices/kebersihan/{id}', [PriceController::class, 'kebersihanDestroy']);

            Route::get('manage/prices/airkotor', [PriceController::class, 'airkotor']);
            Route::post('manage/prices/airkotor', [PriceController::class, 'airkotorStore']);
            Route::get('manage/prices/airkotor/{id}/edit', [PriceController::class, 'airkotorEdit']);
            Route::put('manage/prices/airkotor/{id}', [PriceController::class, 'airkotorUpdate']);
            Route::get('manage/prices/airkotor/{id}', [PriceController::class, 'airkotorShow']);
            Route::delete('manage/prices/airkotor/{id}', [PriceController::class, 'airkotorDestroy']);

            Route::get('manage/prices/lain', [PriceController::class, 'lain']);
            Route::post('manage/prices/lain', [PriceController::class, 'lainStore']);
            Route::get('manage/prices/lain/{id}/edit', [PriceController::class, 'lainEdit']);
            Route::put('manage/prices/lain/{id}', [PriceController::class, 'lainUpdate']);
            Route::get('manage/prices/lain/{id}', [PriceController::class, 'lainShow']);
            Route::delete('manage/prices/lain/{id}', [PriceController::class, 'lainDestroy']);

            Route::get('point/tools/listrik', [ToolsController::class, 'listrik']);
            Route::post('point/tools/listrik', [ToolsController::class, 'listrikStore']);
            Route::get('point/tools/listrik/{id}/edit', [ToolsController::class, 'listrikEdit']);
            Route::put('point/tools/listrik/{id}', [ToolsController::class, 'listrikUpdate']);
            Route::get('point/tools/listrik/{id}', [ToolsController::class, 'listrikShow']);
            Route::delete('point/tools/listrik/{id}', [ToolsController::class, 'listrikDestroy']);
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
