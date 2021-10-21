<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Books;
use App\ProductImage;
use App\Repositories\ProductsRepository;

class ProductPageController extends Controller
{
    /**
     * @param int $product_id 產品ID
     * @return json $message 
     */
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

    /**
     * @param int $product_id 產品ID
     * @return json $product 
     */
    public function show(Request $request, $product_id)
    {
        //search product table return product_id data.
        //這裡應該寫service，但是只有一個我懶得寫了
        $class = 'App\Repositories\ProductsRepository';
        $product = new $class();

        $productData = $product->SearchProduct($product_id);
        // dd($product);
        // echo $product['name'];
        return response()->json([
            'data'   => $productData,
        ]);
    }

    private function response(int $code, $message, array $data = [])
    { }
}
