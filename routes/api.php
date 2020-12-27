<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/**
    namespace: controller 命名空間,
    prefix: 路由前缀
 **/
Route::namespace('Api')->group(function () {
    Route::prefix('v1')->group(function () {
        //會員系統
        Route::post('member/registed/{type}', 'MemberController@register');
        Route::post('member/login', 'MemberController@login');
        Route::post('member/hash-test', 'MemberController@hashTest');
        Route::post('member/hash-check', 'MemberController@hashCheckTest');

        //產品系統
        Route::apiResource('products', 'admin\BooksController');
    });
});
