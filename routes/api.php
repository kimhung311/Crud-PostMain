<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::get('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});


Route::group(['middleware' => 'auth:api', 'prefix' => 'category'], function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/show/{id}', [UserController::class, 'show']);
});


Route::group(['prefix' => 'v1',  'as' => 'v1.'], function () {
    // Route::resource('user', UserController::class)->only(['index', 'show', 'store', 'update', 'delete']);
    Route::resource('user', UserController::class)->except(['create', 'edit']);  // Route::resource là tất cả các phương thức Controller Api
    // dùng only để chạy các phương thức khai báo trong hàm hoặc dung except trừ ra những phương thức không chạy
});
Route::get('user/login/facebook', [AuthController::class, 'facebook']);