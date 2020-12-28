<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Books;

class BooksController extends Controller
{
    public function index()
    {
        $products = Books::all();
        return $this->response(200, 'data read success.', $products);
        // return view(
        //     'admin.product.index',
        //     ['products' => $products]
        // );
    }

    public function store(Request $request)
    {
        return $this->response(200, 'data create success.');
    }

    public function update(Request $request)
    { }

    public function destroy(Request $request)
    { }

    private function response(int $code, $message, $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}
