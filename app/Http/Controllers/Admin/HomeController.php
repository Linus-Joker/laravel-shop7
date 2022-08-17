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

    /**
     * 顯示後台產品頁面(不用前端資料驅動畫面只想到這樣寫)
     * 
     * @param $param 
     * 
     * @return view
     */
    public function adminProducts($param = null)
    {
        //如果沒有參數就返回全部資料
        if (is_null($param)) {
            $products = Books::all();

            return view('admin.product.index', [
                'products' => $products,
            ]);
        }

        //搜尋關鍵字
        $products = Books::where('name', 'like', '%' . $param . '%')->get();

        //如果沒有找到也返回全部資料
        //這個好像有問題，
        if (is_null($param)) {
            $products = Books::all();

            return view('admin.product.index', [
                'products' => $products,
            ]);
        } else {
            //有找到資料就只返回關鍵字內容
            return view('admin.product.index', [
                'products' => $products,
            ]);
        }
    }
}
