<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
    Route::post('/delete',[UserController::class,'deleteUser']);
    Route::get('/all',[UserController::class,'allUserList']);
});  