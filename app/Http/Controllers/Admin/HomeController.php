<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Books;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function adminProducts()
    {
        $products = Books::all();

        return view('admin.product.index', [
            'products' => $products,
        ]);
    }
}
