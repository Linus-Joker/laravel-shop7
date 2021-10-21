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
 *namespace: controller 命名空間,
 *prefix: 路由前缀
 **/
//前台使用
Route::namespace('Api')->group(function () {
    Route::prefix('v1')->group(function () {
        //會員系統
        Route::post('member/registed/{type}', 'MemberController@register');
        Route::post('member/login', 'MemberController@login');
        Route::get('member/logout', 'MemberController@logout');
        Route::get('member/session-check', 'MemberController@sessionCheck');
        Route::post('member/hash-test', 'MemberController@hashTest');
        Route::post('member/hash-check', 'MemberController@hashCheckTest');

        //產品系統
        Route::apiResource('products', 'BooksController');

        //產品內頁
        Route::get('item/message/{id}', 'ProductPageController@index');
        Route::get('item/{id}', 'ProductPageController@show');

        //留言
        Route::post('/message', 'MessageController@insert');

        //管理員回復訊息留言
        Route::post('/admin-message', 'AdminResMessageController@insert');
        Route::delete('/adm-del-message', 'AdminResMessageController@delete');

        Route::post('test/', function (Request $request) {
            $value = $request->all();
            return response()->json([
                'data'  => $value
            ]);
        });

        //csrf測試
        Route::get('csrf', 'MessageController@csrf');
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
