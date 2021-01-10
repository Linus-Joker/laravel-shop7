<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

use App\Books;
use App\Cart;

class BooksController extends Controller
{
    public function index()
    {
        // $products = Books::all();
        // dd($products);

        return view('books');
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
    }

    public function decreaseByOne($id)
    {
        //要有會員才能進購物車頁面增減商品
        $cart = new Cart(Session::get('cart'));
        $cart->decreaseByOne($id);
        session()->put('cart', $cart);
    }

    public function removeItem()
    {
        return redirect('/');
    }

    public function clearCart()
    {
        return redirect('/');
    }

    public function order()
    {
        return view('order');
    }
}
