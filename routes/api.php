<?php

use App\Http\Controllers\FeedbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use \App\Http\Controllers\WishesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group(['prefix' => 'wish'], function () {
    Route::get('username', [WishesController::class, 'getUsername']);
    Route::get('user_wishes/{user_id}', [WishesController::class, 'getUserWishes']);
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('create', [WishesController::class, 'create']);
        Route::post('update', [WishesController::class, 'update']);
        Route::post('destroy', [WishesController::class, 'destroy']);
        Route::get('by_id/{id}', [WishesController::class, 'getWishById']);
        Route::post('book', [WishesController::class, 'book']);
        Route::post('unbook', [WishesController::class, 'unbook']);
    });
});

Route::group(['prefix' => 'feedback'], function () {
    Route::post('create', [FeedbackController::class, 'create']);
});
