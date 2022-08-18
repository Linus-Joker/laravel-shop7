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

    /**
     * 顯示搜尋產品頁面(不用前端資料驅動畫面只想到這樣寫)
     * 
     * @param Request $request
     * @return view
     */
    public function search(Request $request)
    {
        //似乎不用查詢防呆，NULL也可以返回視窗
        $query = $request->input('query');

        //搜尋關鍵字
        $products = Books::where('name', 'like', '%' . $query . '%')->get();

        return view('admin.product.index', [
            'products' => $products,
        ]);
    }
}
