<?php

namespace App\Http\Controllers\Api\admin;

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
        //I don't sure sort class. so... wait!!
        //verification data.
        //create new data ,
        //else catch error.
        // dd($request->input());
        $class = 'App\Repositories\ProductRepository';
        $book = new $class();
        try {
            $book->create($request->input());
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }
        return $this->response(201, 'data create success.');
    }

    public function update(Request $request, $id)
    {
        // dd($request->input());
        $class = 'App\Repositories\ProductRepository';
        $book = new $class();
        $book->update($request->input(), $id);
        // try {
        //     $book->update($request->input(), $id);
        // } catch (\Throwable $e) {
        //     return $this->response(500, $e->getMessage());
        // }

        return $this->response(200, 'data update success.');
    }

    public function destroy($id)
    {
        $class = 'App\Repositories\ProductRepository';
        $book = new $class();

        try {
            $book->delete($id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        return $this->response(200, 'data delete success.');
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
