<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
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


/* User API's */
Route::group(['prefix' => 'User', 'namespace' => 'User'], function () {
    Route::post('/create',[UserController::class,'createUser']);
    Route::post('/detail',[UserController::class,'getUserDetail']);
    Route::post('/update',[UserController::class,'editUserDetail']);
    Route::post('/delete/{id}',[UserController::class,'deleteUser']);
    Route::get('/all',[UserController::class,'allUserList']);
});  

/* Report API's */
Route::group(['prefix' => 'Report', 'namespace' => 'Report'], function () {
    Route::post('/create',[ReportController::class,'create']);
    Route::post('/update',[ReportController::class,'editReportDetail']);
    Route::post('/delete/{id}',[ReportController::class,'deleteReport']);
    Route::get('/all',[ReportController::class,'allReportList']);
    Route::post('/detail',[ReportController::class,'getReportDetail']);
});