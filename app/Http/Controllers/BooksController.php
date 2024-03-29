<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use App\Books;
use App\Cart;

class BooksController extends Controller
{
    /**
     * getCart是API，懶的分了，所以先做在這裡。
     */

    public function index(Request $request)
    {
        // Session::put('userNumber', 22);
        $userNumber = Session::has('userNumber') ? Session::get('userNumber') : null;
        // $userNumber = Session::has('userNumber');
        // dd($userNumber);

        return view('books', [
            'userNumber'    => $userNumber
        ]);
    }

    public function addToCart(Request $request, $id)
    {
        $qty = 1;
        $book = Books::find($id);
        // dd($book->id);
        // dd($book);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        // dd($oldCart);
        $cart = new Cart($oldCart);
        $cart->add($book, $book->id, $qty);
        Session::put('cart', $cart);
        // dd($cart);
        return $cart->items;
    }

    public function cart()
    {
        //要有會員才可以進購物車
        return view('cart');
    }

    public function getCart()
    {
        //要有會員才可以進購物車
        //進頁面後才發起API向後端要資料
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);

        return response()->json([
            'product' => $cart->items,
            'totalPrice' => $cart->totalPrice,
            'totalQty' => $cart->totalQty
        ]);
    }

    public function increaseByOne($id)
    {
        //要有會員才能進購物車頁面增減商品
        $cart = new Cart(Session::get('cart'));
        $cart->increaseByOne($id);
        session()->put('cart', $cart);
        // return $cart->items;
        return response()->json(1);
    }

    public function decreaseByOne($id)
    {
        //要有會員才能進購物車頁面增減商品
        $cart = new Cart(Session::get('cart'));
        $cart->decreaseByOne($id);
        session()->put('cart', $cart);
        // return $cart->items;
        return response()->json(1);
    }

    public function removeItem($id)
    {
        $cart = new Cart(Session::get('cart'));
        $cart->removeItem($id);
        session()->put('cart', $cart);
        // return $cart->items;
        return response()->json(1);
    }

    public function clearCart()
    {
        if (session()->has('cart')) {
            session()->forget('cart');
        }
    }

    //這是進入view page
    public function ProductPage($product_id)
    {
        $userNumber = Session::has('userNumber') ? Session::get('userNumber') : null;
        // $userNumber = Session::has('userNumber');
        // dd($userNumber);
        // $message = DB::table('message')
        //     ->join('admin_res', 'admin_res.message_id', '=', 'message.message_id')
        //     ->where('product_id', '=', 1)
        //     ->get();

        return view('ProductPage', [
            'userNumber'    => $userNumber,
            // 'message'       => $message
            'product_id'    => $product_id
        ]);
    }
}
