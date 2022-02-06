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
use App\Http\Controllers\DayOffController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\PaymentController;

use Carbon\Carbon;

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

Route::get('payment/noauth', function(){
    return 'Payment';
});

//Login Authenticated
Route::middleware('checkauth')->group(function(){
    //Access for Level 1 & 2
    Route::prefix('production')->group(function(){
        Route::middleware('oneauth')->group(function(){
            Route::get('dashboard', [DashboardController::class, 'index']);

            Route::get('service/register/generate/{type}', [ServiceController::class, 'gKontrol']);
            Route::resource('service/register', ServiceController::class);

            Route::get('users/change/{level}', [UserController::class, 'userChange']);
            Route::get('users/level', [UserController::class, 'userLevel']);
            Route::get('users/code/activate', [UserController::class, 'activate']);
            Route::get('users/activate/verify', [UserController::class, 'activateVerify']);
            Route::delete('users/permanent/{id}', [UserController::class, 'permanent']);
            Route::post('users/reset/{id}', [UserController::class, 'reset']);
            Route::post('users/restore/{id}', [UserController::class, 'restore']);
            Route::get('users/choose/group/all', [UserController::class, 'chooseGroupAll']);
            Route::resource('users', UserController::class);

            Route::get('point/stores/generate/kontrol', [StoreController::class, 'gKontrol']);
            Route::resource('point/stores', StoreController::class);

            Route::resource('point/commodities', CommodityController::class);

            Route::resource('point/groups', GroupController::class);

            Route::resource('histories', HistoryController::class);

            Route::resource('changelogs', ChangeLogController::class);

            Route::get('manage/deleted/{id}', [BillController::class, 'deletedShow']);
            Route::get('manage/deleted', [BillController::class, 'deleted']);
            Route::get('manage/deleted/{id}/check', [BillController::class, 'check']);
            Route::post('manage/deleted/{id}', [BillController::class, 'restore']);
            Route::post('manage/bills/publish/{id}', [BillController::class, 'publish']);
            Route::get('manage/bills/period/{id}', [BillController::class, 'periodChange']);
            Route::get('manage/bills/period', [BillController::class, 'period']);
            Route::resource('manage/bills', BillController::class);

            Route::resource('manage/dayoff', DayOffController::class);

            Route::get('prices/listrik', [PriceController::class, 'listrik']);
            Route::post('prices/listrik', [PriceController::class, 'listrikStore']);
            Route::get('prices/listrik/{id}/edit', [PriceController::class, 'listrikEdit']);
            Route::put('prices/listrik/{id}', [PriceController::class, 'listrikUpdate']);
            Route::get('prices/listrik/{id}', [PriceController::class, 'listrikShow']);
            Route::delete('prices/listrik/{id}', [PriceController::class, 'listrikDestroy']);

            Route::get('prices/airbersih', [PriceController::class, 'airbersih']);
            Route::post('prices/airbersih', [PriceController::class, 'airbersihStore']);
            Route::get('prices/airbersih/{id}/edit', [PriceController::class, 'airbersihEdit']);
            Route::put('prices/airbersih/{id}', [PriceController::class, 'airbersihUpdate']);
            Route::get('prices/airbersih/{id}', [PriceController::class, 'airbersihShow']);
            Route::delete('prices/airbersih/{id}', [PriceController::class, 'airbersihDestroy']);

            Route::get('prices/keamananipk', [PriceController::class, 'keamananipk']);
            Route::post('prices/keamananipk', [PriceController::class, 'keamananipkStore']);
            Route::get('prices/keamananipk/{id}/edit', [PriceController::class, 'keamananipkEdit']);
            Route::put('prices/keamananipk/{id}', [PriceController::class, 'keamananipkUpdate']);
            Route::get('prices/keamananipk/{id}', [PriceController::class, 'keamananipkShow']);
            Route::delete('prices/keamananipk/{id}', [PriceController::class, 'keamananipkDestroy']);

            Route::get('prices/kebersihan', [PriceController::class, 'kebersihan']);
            Route::post('prices/kebersihan', [PriceController::class, 'kebersihanStore']);
            Route::get('prices/kebersihan/{id}/edit', [PriceController::class, 'kebersihanEdit']);
            Route::put('prices/kebersihan/{id}', [PriceController::class, 'kebersihanUpdate']);
            Route::get('prices/kebersihan/{id}', [PriceController::class, 'kebersihanShow']);
            Route::delete('prices/kebersihan/{id}', [PriceController::class, 'kebersihanDestroy']);

            Route::get('prices/airkotor', [PriceController::class, 'airkotor']);
            Route::post('prices/airkotor', [PriceController::class, 'airkotorStore']);
            Route::get('prices/airkotor/{id}/edit', [PriceController::class, 'airkotorEdit']);
            Route::put('prices/airkotor/{id}', [PriceController::class, 'airkotorUpdate']);
            Route::get('prices/airkotor/{id}', [PriceController::class, 'airkotorShow']);
            Route::delete('prices/airkotor/{id}', [PriceController::class, 'airkotorDestroy']);

            Route::get('prices/lain', [PriceController::class, 'lain']);
            Route::post('prices/lain', [PriceController::class, 'lainStore']);
            Route::get('prices/lain/{id}/edit', [PriceController::class, 'lainEdit']);
            Route::put('prices/lain/{id}', [PriceController::class, 'lainUpdate']);
            Route::get('prices/lain/{id}', [PriceController::class, 'lainShow']);
            Route::delete('prices/lain/{id}', [PriceController::class, 'lainDestroy']);

            Route::get('point/tools/listrik', [ToolsController::class, 'listrik']);
            Route::post('point/tools/listrik', [ToolsController::class, 'listrikStore']);
            Route::get('point/tools/listrik/{id}/edit', [ToolsController::class, 'listrikEdit']);
            Route::put('point/tools/listrik/{id}', [ToolsController::class, 'listrikUpdate']);
            Route::get('point/tools/listrik/{id}', [ToolsController::class, 'listrikShow']);
            Route::delete('point/tools/listrik/{id}', [ToolsController::class, 'listrikDestroy']);

            Route::get('point/tools/airbersih', [ToolsController::class, 'airbersih']);
            Route::post('point/tools/airbersih', [ToolsController::class, 'airbersihStore']);
            Route::get('point/tools/airbersih/{id}/edit', [ToolsController::class, 'airbersihEdit']);
            Route::put('point/tools/airbersih/{id}', [ToolsController::class, 'airbersihUpdate']);
            Route::get('point/tools/airbersih/{id}', [ToolsController::class, 'airbersihShow']);
            Route::delete('point/tools/airbersih/{id}', [ToolsController::class, 'airbersihDestroy']);

            Route::get('payment/receipt/reprint/{id}', [PaymentController::class, 'reprintReceipt']);
            Route::get('payment/receipt/{data}', [PaymentController::class, 'receipt']);
            Route::post('payment/restore/{id}', [PaymentController::class, 'restore']);
            Route::get('payment/level', [PaymentController::class, 'paymentLevel']);
            Route::get('payment/change/{level}', [PaymentController::class, 'paymentChange']);
            Route::get('payment/summary/{id}', [PaymentController::class, 'summary']);
            Route::resource('payment', PaymentController::class);
        });

        Route::post('profile/picture', [ProfileController::class, 'picture']);
        Route::resource('profile', ProfileController::class);
    });

    Route::get('email/verify/resend', [EmailController::class, 'resend']);

    Route::get('search/countries',[SearchController::class, 'country']);

    // Route::get('notification/bill/reviews',[NotificationController::class, 'billReviews']);
});

Route::get('expired', function(){
    abort(404);
});

Route::get('shift/{type}', function($type){
    if($type == 'get'){
        $time = Carbon::now();
        if($time->format('Y-m-d H:i:s') < $time->format('Y-m-d 17:00:00')){
            Session::put('shift', 1);
            $shift = 1;
        } else{
            Session::put('shift', 2);
            $shift = 2;
        }
    } else{
        if(Session::get('shift') == 1){
            Session::put('shift', 2);
            $shift = 2;
        } else{
            Session::put('shift', 1);
            $shift = 1;
        }
    }
    return response()->json(['success' => $shift]);
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

Route::get('search/period',[SearchController::class, 'period']);
Route::get('search/users',[SearchController::class, 'users']);
Route::get('search/kontrol',[SearchController::class, 'kontrol']);
Route::get('search/bill',[SearchController::class, 'bill']);
Route::get('search/groups',[SearchController::class, 'group']);
Route::get('search/{group}/los',[SearchController::class, 'los']);
Route::get('search/commodities',[SearchController::class, 'commodity']);
Route::get('search/tools/listrik',[SearchController::class, 'tlistrik']);
Route::get('search/price/listrik',[SearchController::class, 'plistrik']);
Route::get('search/tools/airbersih',[SearchController::class, 'tairbersih']);
Route::get('search/price/airbersih',[SearchController::class, 'pairbersih']);
Route::get('search/price/keamananipk',[SearchController::class, 'pkeamananipk']);
Route::get('search/price/kebersihan',[SearchController::class, 'pkebersihan']);
Route::get('search/price/airkotor',[SearchController::class, 'pairkotor']);
Route::get('search/price/lain',[SearchController::class, 'plain']);

Route::get('scan/qr/{type}/{data}',[ScanController::class, 'scanQr']);
Route::post('scan/qr/register',[ScanController::class, 'scanQrRegister']);

Route::get('tester', function(){
    return 200;
});
