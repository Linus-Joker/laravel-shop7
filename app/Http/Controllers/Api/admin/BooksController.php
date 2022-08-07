<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Books;
use App\Services\Admin\ProductServices;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->productService = new ProductServices();
    }

    public function index()
    {
        $products = Books::all();
        return $this->response(200, 'data read success.', $products);
    }

    public function show($id)
    {
        try {
            $bookData = $this->productService->show($id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }

        return $this->response(200, 'data find success.', $bookData);
    }

    public function store(Request $request)
    {
        try {
            $this->productService->create($request->input());
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }
        return $this->response(201, 'data create success.');
    }

    public function update(Request $request, $id)
    {
        try {
            $this->productService->update($request->input(), $id);
        } catch (\Throwable $e) {
            return $this->response(500, $e->getMessage());
        }
        return $this->response(200, 'data update success.');
    }

    public function destroy($id)
    {
        try {
            $this->productService->delete($id);
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

    public function test()
    {
        // $post = Books::find(2)->sort;
        $post = Books::all();
        return $post;
    }
}
