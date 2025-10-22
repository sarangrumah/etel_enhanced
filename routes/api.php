<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ScheduleController;

use App\Http\Controllers\Api\Ossapi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ISRController;
use App\Http\Controllers\InstansiPemerintah;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\HakLabuhController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'v1'], static function(){
    Route::post('/connecthub',[App\Http\Controllers\Api\Ossapi::class, 'connecthub']);
    Route::post('/receivenib',[App\Http\Controllers\Api\Ossapi::class, 'receiveNIB'])->name('receive-nib');
    Route::post('/receivefileds',[App\Http\Controllers\Api\Ossapi::class, 'receiveFileDS'])->name('receive-fileds');

    Route::get('/izin',[App\Http\Controllers\Api\HakLabuhController::class, 'index'])->name('get-izin');
    Route::get('/get-token',[App\Http\Controllers\Api\HakLabuhController::class, 'getToken'])->name('get-token');
    Route::get('/izin-terbit',[App\Http\Controllers\Api\HakLabuhController::class, 'izinTerbit'])->name('izin-terbit');
    Route::get('/isr',[App\Http\Controllers\Api\ISRController::class, 'getISR'])->name('get-isr');
    Route::get('/view-isr/{id}',[App\Http\Controllers\Api\ISRController::class, 'viewISR'])->name('view-isr');
});

Route::get('/getjenislayanan/{izin}/{id}',[App\Http\Controllers\Api\CommonController::class, 'getjenislayanan']);
Route::get('/getjenislayanan_nomor/{izin}',[App\Http\Controllers\Api\CommonController::class, 'getkbli_nomor']);
Route::get('/getjeniskbli_nomor/{kbli}',[App\Http\Controllers\Api\CommonController::class, 'getjenislayanan_nomor']);
Route::get('/getjeniskodeakses_nomor/{izinlayanan}',[App\Http\Controllers\Api\CommonController::class,
'getjeniskodeakses_nomor']);
Route::get('/getjeniskodeakses_nomor_excPLM/{izinlayanan}',[App\Http\Controllers\Api\CommonController::class,
'getjeniskodeakses_nomor_excPLM']);
Route::get('/update-bloknomor',[App\Http\Controllers\Api\CommonController::class,
'updatebloknomor']);
Route::get('/getkodeakses_nomor/{jenis_kodeakses}',[App\Http\Controllers\Api\CommonController::class,
'getkodeakses_nomor']);
Route::get('/getkodeakses_nomor_npt/{jenis_kodeakses}',[App\Http\Controllers\Api\CommonController::class,
'getkodeakses_nomor_npt']);
Route::get('/getkodeakses_nomor_re/{jenis_kodeakses}',[App\Http\Controllers\Api\CommonController::class,
'getkodeakses_nomor_re']);
Route::get('/getkodeakses_nomor_re_npt/{jenis_kodeakses}',[App\Http\Controllers\Api\CommonController::class,
'getkodeakses_nomor_re_npt']);
Route::get('/getskinfo_nomor_re/{kodeakses}',[App\Http\Controllers\Api\CommonController::class,
'getskinfo_nomor_re']);
Route::get('/getulo/{id}',[App\Http\Controllers\Api\CommonController::class, 'getulo']);
Route::post('/checkuser',[App\Http\Controllers\Api\CommonController::class, 'checkusersactive']);
Route::get('/checkuser/{username}',[App\Http\Controllers\Api\CommonController::class, 'checkusersactive_email']);
Route::get('/offday',[App\Http\Controllers\Api\CommonController::class, 'get_offday']);
Route::get('/hariliburnasional',[App\Http\Controllers\Api\CommonController::class, 'get_hariliburnasional']);
Route::get('/getKabupaten', [App\Http\Controllers\Api\CommonController::class, 'getKabupaten'])->name('getKabupaten');

Route::get('/ulo-calendar-all', [ScheduleController::class, 'getschedule'])->name('getschedule');