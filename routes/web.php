<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

/**
    namespace: controller 命名空間,
    prefix: 路由前缀
 **/

//前台顯示
Route::get('/', 'BooksController@index');
Route::get('/cart', 'BooksController@cart');
Route::get('/increase/{id}', 'BooksController@increaseByOne');
Route::get('/decrease/{id}', 'BooksController@decreaseByOne');
Route::get('/remove-item/{id}', 'BooksController@removeItem');
Route::get('/addcart/{id}', 'BooksController@addToCart');
Route::get('/clear-cart', 'BooksController@clearCart');

Route::get('books', function () {
    return view('books');
});


//後台顯示
/**
    想要前後端分離但是懶的用框架
    僅用blade模板切視圖
    又懶得make一堆Controller
    所以先這樣吧~~
 **/

Route::get('webadmin', 'Admin\HomeController@index');
Route::get('adminProducts', function () {
    return view('admin.product.index');
});

//測試
Route::get('/{path}', 'BooksController@index')->where('path', '*');
