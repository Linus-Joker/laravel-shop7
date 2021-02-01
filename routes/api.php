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
//前台使用
Route::namespace('Api')->group(function () {
    Route::prefix('v1')->group(function () {
        //會員系統
        Route::post('member/registed/{type}', 'MemberController@register');
        Route::post('member/login', 'MemberController@login');
        Route::post('member/hash-test', 'MemberController@hashTest');
        Route::post('member/hash-check', 'MemberController@hashCheckTest');

        //產品系統
        Route::apiResource('products', 'BooksController');
        Route::post('test/', function (Request $request) {
            $value = $request->all();
            return response()->json([
                'data'  => $value
            ]);
        });
    });
});

//後台使用
Route::namespace('Api\admin')->group(function () {
    Route::prefix('v1/admin')->group(function () {
        //管理員系統
        Route::post('/login', 'AdminController@login');
        Route::post('/change-password', 'AdminController@changePassword');
        //產品系統
        Route::apiResource('products', 'BooksController');

        //測試新加入資訊
        Route::get('p', 'BooksController@test');
    });
});
