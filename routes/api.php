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

//會員系統
Route::post('member/registed/{type}', 'Api\MemberController@register');
Route::post('member/login', 'Api\MemberController@login');
Route::post('member/hash-test', 'Api\MemberController@hashTest');
Route::post('member/hash-check', 'Api\MemberController@hashCheckTest');

//產品系統
Route::apiResource('products', 'Api\BooksController');
