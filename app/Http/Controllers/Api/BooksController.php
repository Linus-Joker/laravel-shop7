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
        // return $products;


    }

    private function response(int $code, $message, $data = [])
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ]);
    }
}
