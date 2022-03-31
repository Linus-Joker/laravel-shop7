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
//購物車
Route::get('/', 'BooksController@index');
Route::get('/addcart/{id}', 'BooksController@addToCart');
Route::get('/cart', 'BooksController@cart');
Route::get('/getcart', 'BooksController@getCart');
Route::get('/increase/{id}', 'BooksController@increaseByOne');
Route::get('/decrease/{id}', 'BooksController@decreaseByOne');
Route::get('/remove-item/{id}', 'BooksController@removeItem');
Route::get('/clear-cart', 'BooksController@clearCart');

//訂單
// Route::get('/order', 'OrdersController@order');
Route::post('/orders', 'OrdersController@store');
Route::get('/order', 'OrdersController@getOrder');
Route::post('/callback', 'OrdersController@callback');
Route::get('/success', 'OrdersController@redirectFromECpay');

//產品內頁
Route::get('item/{id}', 'BooksController@ProductPage');

//會員系統
Route::get('/login', 'MemberController@login');
Route::get('register', 'MemberController@register');



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
// Route::get('/{path}', 'BooksController@index')->where('path', '*');
