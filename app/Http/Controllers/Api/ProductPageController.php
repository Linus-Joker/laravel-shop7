<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Books;
use App\ProductImage;

class ProductPageController extends Controller
{
    public function index($product_id)
    {
        $message = DB::table('message')
            ->join('admin_res', 'admin_res.message_id', '=', 'message.message_id')
            ->where('product_id', '=', $product_id)
            ->get();

        return response()->json([
            'data'  => $message,
        ]);
    }

    public function show(Request $request, $product_id)
    {
        //search product table return product_id data.
        $product = Books::find($product_id);
        // dd($product);
        // echo $product['name'];
        return response()->json([
            'data'   => $product,
        ]);
    }
}
