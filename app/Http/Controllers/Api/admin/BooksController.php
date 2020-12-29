<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Books;

class BooksController extends Controller
{
    public function index()
    {
        $products = Books::all();
        return $this->response(200, 'data read success.', $products);
    }

    public function store(Request $request)
    {
        $class = 'App\Repositories\ProductRepository';
        $book = new $class();
        // try {
        //     $book->create($request->input());
        // } catch (\Throwable $e) {
        //     return $this->response(500, $e->getMessage());
        // }
        return $this->response(201, 'data create success.');
    }

    public function update(Request $request, $id)
    {
        $class = 'App\Repositories\ProductRepository';
        $book = new $class();
        try {
            $book->update($request->input(), $id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }
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

        return $this->response(204, 'data delete success.');
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
